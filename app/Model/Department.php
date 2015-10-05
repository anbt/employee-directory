<?php

App::uses('AppModel', 'Model');

class Department extends AppModel
{
    // A deparment has many employees
    public $hasMany = array(
        'Employees' => array(
            'className' => 'Employee',
            'foreignKey' => 'department_id'
        )
    );
    
    // A deparment is managed by at most one employee
    public $belongsTo = array(
        'ManagedBy' => array(
            'className' => 'Employee',
            'foreignKey' => 'manager_id'
        )
    );
}
