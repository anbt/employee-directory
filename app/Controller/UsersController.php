<?php

App::uses('AppController', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class UsersController extends AppController
{
    public function beforeFilter()
    {
        // allow logout even having not changed pass
        if ($this->request->action != 'logout') {
            parent::beforeFilter();
        }
    }
    
    public function login()
    {
        if ($this->request->is(array("post"))) {
            if ($this->Auth->login()) {
                if ($this->Auth->user("changed_pass") != true) {
                    return $this->redirect(array('action' => 'changePass'));
                }
                // redirect to / (home page)
                return $this->redirect($this->Auth->redirectUrl('/'));
            }
            $this->Flash->fail("Username or password is wrong!");
        }
    }
    
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    
    /* add new users, require username and email,
     * password is auto generated and send to email
     */
    public function add()
    {
        if ($this->request->is(array("post", "put"))) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                // init pass for user and set change_pass = 0
                $pass = $this->genPass();
                $this->User->initPassAndState(
                    $this->request->data['User']['username'],
                    $pass
                );
                // send mail to user
                $this->User->sendEmail(
                    $this->request->data['User']['email'],
                    $this->request->data['User']['username'],
                    $pass
                );
                
                $this->Flash->success('An user has been added.');
                return $this->redirect(array('controller' => 'departments', 'action' => 'index'));
            } else {
                $this->Flash->fail('Cannot add this user.');
            }
        }
    }
    
    public function changePass()
    {
        if ($this->request->is(array("post", "put"))) {
            $this->User->id = $this->Auth->user('id');
            if ($this->User->save($this->request->data)) {
                $this->Flash->success('You changed pass successfully. You should login again to make sure');
                return $this->redirect(array('controller' => 'users', 'action' => 'logout'));
            } else {
                $this->Flash->fail('Your change is not successful.');
            }
        } 
    }
    
    // generate pass with length provided
    protected function genPass($length = 15)
    {
        $pass = '';
        // character allowed in pass
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $charsLength = strlen($chars);
        
        for ($i = 0; $i < $length; ++$i) {
            $pass .= $chars[rand(0, $charsLength - 1)];
        }
        return $pass;
    }
}
