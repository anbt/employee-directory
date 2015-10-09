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
    
    public $validate = array(
        'name' => array(
            'between' => array(
                'rule' => array('lengthBetween', 3, 100),
                'required' => true,
                'message' => 'Name length must be between 3 and 100.'
            )
        ),
        'cellphone' => array(
            'isPhoneNum' => array(
                'rule' => array('phone', '/^\d{10,11}$/', 'all'),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'Please enter a valid phone number (10-11 digits).'
            )
        ),
        'job_title' => array(
            'between' => array(
                'rule' => array('lengthBetween', 2, 100),
                'required' => true,
                'message' => 'Job title length must be between 2 and 100.'
            )
        ),
        'email' => array(
            'isEmail' => array(
                'rule' => array('email'),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'Please enter a valid email address.'
            )
        ),
        'photo' => array(
            'extension' => array(
                'rule' => array(
                    'extension',
                    array('gif', 'jpeg', 'png', 'jpg')
                ),
                'required' => false,
                'message' => 'Only upload .jpeg, .png, .jpg files.'
            ),
            'maxFileSize' => array(
                'rule' => array('fileSize', '<=', '100KB'),
                'required' => false,
                'message' => 'Image must be less than 100KB.'
            ),
            'type' => array(
                'rule' => array(
                    'mimeType',
                    array('image/gif', 'image/png', 'image/jpg', 'image/jpeg')
                ),
                'required' => false,
                'message' => 'Invalid mime type.'
            ),
            'uploadError' => array(
                'rule' => 'uploadError',
                'required' => false,
                'message' => 'Something went wrong with the upload.'
            ),
            'isUploadedFile' => array(
                'rule' => 'isUploadedFile',
                'required' => false,
                'message' => 'It is not an upload file.'
            ),
        )
    );
        
    /**
     * Check file is uploaded file
     * @param array $data
     * @return boolean
     * @see http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#validating-uploads
     */
    public function isUploadedFile($data)
    {
        $photo = $data['photo'];
        if ((isset($photo['error']) && $photo['error'] == 0) 
            || (!empty( $photo['tmp_name']) && $photo['tmp_name'] != 'none')) {
            return is_uploaded_file($photo['tmp_name']);
        }
        return false;
    }

    /**
     * Get employees list id => name
     * @return type
     */
    public function getAllEmployeeNames()
    {
        $this->recursive = -1;
        return $this->find("list", array('fields' => array('id', 'name'), 'order' => array('name' => 'asc')));
    }
    
    /**
     * Create, update employee with provided data, handle uploaded image
     * 
     * @param array $data Employee data
     * @return mixed Employee data on success, false otherwise
     */
    public function saveEmployee($data)
    {
        // unset photo if there is no photo name (user don't upload image)
        if (!$data['Employee']['photo']['name']) {
            unset($data['Employee']['photo']);
        }
        
        $this->set($data);
        if ($this->validates()) {
            // if user don't upload image
            if (!isset($data['Employee']['photo'])) {
                return $this->save($data, array('validate' => false));
            }
            
            // if user uploads image
            // generate new image name
            $imagename = uniqid() . '_' . $data['Employee']['photo']['name'];

            /* move uploaded file to webroot/files folder
             * make sure that this folder is writable
             */
            if (move_uploaded_file(
                $data['Employee']['photo']['tmp_name'], WWW_ROOT . 'files' . DS . $imagename
            )) {
                // save file name to DB
                $data['Employee']['photo'] = $imagename;
                if (!$this->id) {
                    // this is add, not update
                    $this->create();
                }
                // data has been validated above, don't need to be again, 'validate' => false
                return $this->save($data, array('validate' => false));
            }
        }
        return false;
    }

    /**
     * Get profile of employee specified by id
     * 
     * @param int $id Employee Id
     * @return array
     */
    public function getEmployeeProfile($id)
    {
        $this->recursive = 0;
        return $this->findById($id);
    }
    
    /**
     * Search employees
     * 
     * @param string|null $name Employee name
     * @param int|null $departmentId Department Id
     * @return array Employees list
     */ 
    public function search($name = null, $departmentId = null)
    {
        $cons = array();
        if (!empty($name)) {
            // prepare for search LIKE
            $name = trim($name);
            $name = str_replace('  ', ' ', $name);
            $likeClause = '%' . str_replace(' ', '%', $name) . '%';
            $cons['Employee.name LIKE'] = $likeClause;
        }
        if (!empty($departmentId)) {
            $cons['Employee.department_id'] = $departmentId;
        }
        
        return $this->find('all', array('conditions' => $cons));
    }
}
