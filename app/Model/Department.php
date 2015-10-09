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
    
    public $validate = array(
        'name' => array(
            'between' => array(
                'rule' => array('lengthBetween', 3, 256),
                'required' => true,
                'message' => 'Name length must be between 3 and 256.'
            )
        ),
        'office_phone' => array(
            'isPhoneNum' => array(
                'rule' => array('phone', '/^\d{10,11}$/', 'all'),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'Please enter a valid phone number (10-11 digits).'
            )
        ),
    );
    
    /**
     * Get departments list id => name
     * @return type
     */
    public function getAllDepartmentNames()
    {
        $this->recursive = -1;
        return $this->find("list", array('fields' => array('id', 'name'), 'order' => array('name' => 'asc')));
    }
    
    /**
     * Get detail of department specified by id
     * 
     * @param int $id Department Id
     * @return array
     */
    public function getDepartmentDetail($id)
    {
        $this->recursive = 0;
        return $this->findById($id);
    }
}
