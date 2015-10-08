<?php

App::uses('AppController', 'Controller');

class EmployeesController extends AppController
{
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("profile");
    }
    
    public function index()
    {
        if ($this->request->query) {
            // this is a search request, params in query array
            $this->Employee->recursive = 0;
            
            // prepare for search conditions
            $cons = array();
            if ($this->request->query['name']) {
                // prepare for search LIKE
                $texts = explode(' ', $this->request->query['name']);
                $likeClause = '%' . implode('%', $texts) . '%';
                $cons['Employee.name LIKE'] = $likeClause;
            }
            if ($this->request->query['department_id']) {
                $cons['Employee.department_id'] = $this->request->query['department_id'];
            }
            
            $emps = $this->Employee->find("all", array('conditions' => $cons));
            $this->set("employees", $emps);
        } else {
            // no search request, just show all employees
            // set recursive = 0 to retrive department's relationship
            $this->Employee->recursive = 0;
            $emps = $this->Employee->find("all");
            $this->set("employees", $emps);
        }
        // get departments to search in "index view"
        $deps = $this->Employee->WorkingIn->getAllDepartments();
        $departments = array();
        foreach ($deps as $dep) {
            $departments[$dep['WorkingIn']['id']] = $dep['WorkingIn']['name'];
        }
        $this->set("departments", $departments);
    }
    
    public function add()
    {
        if ($this->request->is(array("post", "put"))) {
            if ($this->Employee->saveEmployee($this->request->data)) {
                $this->Flash->success('An employee has been added.');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->fail('Cannot add this employee.');
        }
        
        // get departments to choose working place for employee
        $deps = $this->Employee->WorkingIn->getAllDepartments();
        $departments = array();
        foreach ($deps as $dep) {
            $departments[$dep['WorkingIn']['id']] = $dep['WorkingIn']['name'];
        }
        $this->set("departments", $departments);
    }
    
    public function profile($id)
    {
        // no employee id provided is invalid
        if (!$id) {
            throw new NotFoundException(__('Invalid employee'));
        }
        
        $emp = $this->Employee->getEmployeeProfile($id);
        // accessing an non-exist employee is invalid
        if (!$emp) {
            throw new NotFoundException(__('Invalid employee'));
        } else {
            $this->set('emp', $emp);
        }
    }
    
    public function edit($id)
    {
        // no employee id provided is invalid
        if (!$id) {
            throw new NotFoundException(__('Invalid employee'));
        }
        $emp = $this->Employee->findById($id);
        // accessing an non-exist employee is invalid
        if (!$emp) {
            throw new NotFoundException(__('Invalid employee'));
        }

        if ($this->request->is(array("post", "put"))) {
            $this->Employee->id = $id;
            if ($this->Employee->saveEmployee($this->request->data)) {
                $this->Flash->success('An employee has been edited.');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->fail('Cannot edit this employee.');
        }
        
        // get departments to choose working place for employees
        $deps = $this->Employee->WorkingIn->getAllDepartments();
        $departments = array();
        foreach ($deps as $dep) {
            $departments[$dep['WorkingIn']['id']] = $dep['WorkingIn']['name'];
        }
        $this->set("departments", $departments);
        
        if (!$this->request->data) {
            // populate form with data in DB
            $this->request->data = $emp;
        }
        // send image name to view
        $this->set('imageName', $emp['Employee']['photo']);
    }
    
    public function delete($id)
    {
        // delete link must be post method
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        
        if ($this->Employee->delete($id)) {
            $this->Flash->success('A employee has been deleted.');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->fail('Cannot delete this employee.');
    }
}
