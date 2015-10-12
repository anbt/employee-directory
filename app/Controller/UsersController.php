<?php

App::uses('AppController', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController
{
    public $uses = array('User');
    
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
            // $ret format is array("success" => true/false, "password" => $pass);
            $ret = $this->User->createUser($this->request->data);
            if ($ret['success']) {
                // send mail to user
                $this->sendEmail(
                    $this->request->data['User']['email'],
                    $this->request->data['User']['username'],
                    $ret['password']
                );

                $this->Flash->success('An user has been added.');
                return $this->redirect(array('controller' => 'departments', 'action' => 'index'));
            }
            $this->Flash->fail('Cannot add this user.');
        }
    }
    
    public function changePass()
    {
        if ($this->request->is(array("post", "put"))) {
            $this->User->id = $this->Auth->user('id');
            $this->User->addCurrentPasswordValidator();
            $this->User->addPasswordConfirmValidator();
            $this->User->addNewPassNotMatchCurPassValidator();
            $this->request->data['User']['changed_pass'] = true;
            if ($this->User->save($this->request->data)) {
                $this->Flash->success('You changed pass successfully. You should login again to make sure');
                return $this->redirect(array('controller' => 'users', 'action' => 'logout'));
            }
            $this->Flash->fail('Your change is not successful.');
        }
    }
    
    /* send username and pass to user via mail
     * ---------------------------------------
     * to send successfully (using gmail), config email in Config/email.php
     * and turn on "Access for less secure apps" in google account settings
     */
    protected function sendEmail($address, $username, $pass)
    {
        $subject = 'You now are an user of Employees Directory!';
        $body = 'Your username : ' . $username . '. Your password : ' . $pass . '. (not include the last period)';
        
        $email = new CakeEmail('smtp');
        $email->to($address)->subject($subject)->send($body);
    }
}
