<?php

App::uses('AppModel', 'Model');

class Employee extends AppModel
{
    // An employee works for a department
    public $belongsTo = array(
        'WorkingIn' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id'
        )
    );
    
    // An employee may manages departments
    public $hasMany = array(
        'Manage' => array(
            'className' => 'Department',
            'foreignKey' => 'manager_id'
        )
    );
}
