<?php

App::uses('AppController', 'Controller');

class DepartmentsController extends AppController
{
    public function index()
    {
        // set recursive = 0 to retrive employee's relationship
        $this->Department->recursive = 0;
        $deps = $this->Department->find("all");
        $this->set("departments", $deps);
    }
}
