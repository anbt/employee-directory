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
    
    public function add()
    {
        // get employess to choose a manager in form
        $deps = $this->Employee->WorkingIn->getAllDepartments();
        $departments = array();
        foreach ($deps as $dep) {
            $departments[$dep['WorkingIn']['id']] = $dep['WorkingIn']['name'];
        }
        $this->set("departments", $departments);
        
        if ($this->request->is(array("post", "put"))) {
            if ($this->Employee->createEmployee($this->request->data)) {
                $this->Flash->success('An employee has been added.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->fail('Cannot add this employee.');
            }
        }
    }
}
