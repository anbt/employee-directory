<?php

App::uses('AppController', 'Controller');

class DepartmentsController extends AppController
{
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("detail");
    }

    public function index()
    {
        // set recursive = 0 to retrive employee's relationship
        $this->Department->recursive = 0;
        $deps = $this->Department->find("all");
        $this->set("departments", $deps);
    }
    
    public function add()
    {
        if ($this->request->is(array("post", "put"))) {
            $this->Department->create();
            if ($this->Department->save($this->request->data)) {
                $this->Flash->success('A department has been added.');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->fail('Cannot add this department.');
        }
        
        // get employess to choose a manager in form
        $managers = $this->Department->Employees->getAllEmployeeNames();
        $this->set("managers", $managers);
    }
    
    public function detail($id)
    {
        // no department id provided is invalid
        if (!$id) {
            throw new NotFoundException(__('Invalid department'));
        }
        
        $dep = $this->Department->getDepartmentDetail($id);
        // accessing an non-exist department is invalid
        if (!$dep) {
            throw new NotFoundException(__('Invalid department'));
        } else {
            $this->set('dep', $dep);
        }
    }
    
    public function edit($id)
    {
        // no department id provided is invalid
        if (!$id) {
            throw new NotFoundException(__('Invalid department'));
        }
        $dep = $this->Department->findById($id);
        // accessing an non-exist department is invalid
        if (!$dep) {
            throw new NotFoundException(__('Invalid department'));
        }
        
        if ($this->request->is(array("post", "put"))) {
            $this->Department->id = $id;
            if ($this->Department->save($this->request->data)) {
                $this->Flash->success('A department has been edited.');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->fail('Cannot edit this department.');
        }
        
        // get employess to choose a manager in form
        $managers = $this->Department->Employees->getAllEmployeeNames();
        $this->set("managers", $managers);
        
        if (!$this->request->data) {
            // populate form with data in DB
            $this->request->data = $dep;
        }
    }
    
    public function delete($id)
    {
        // delete link must be post method
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        
        if ($this->Department->delete($id)) {
            $this->Flash->success('A department has been deleted.');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->fail('Cannot delete this department.');
    }
}
