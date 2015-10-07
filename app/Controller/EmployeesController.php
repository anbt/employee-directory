<?php

App::uses('AppController', 'Controller');

class EmployeesController extends AppController
{
    public function index()
    {
        // set recursive = 0 to retrive department's relationship
        $this->Employee->recursive = 0;
        $emps = $this->Employee->find("all");
        $this->set("employees", $emps);
    }
}
