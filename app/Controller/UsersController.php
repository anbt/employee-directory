<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
    public function login()
    {
        if ($this->request->is(array("post"))) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->fail("Username or password is wrong!");
        }
    }
    
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
