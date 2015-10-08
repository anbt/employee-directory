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
        
    // book.cakephp.org/2.0/en/core-libraries/helpers/form.html#validating-uploads
    public function isUploadedFile($data)
    {
        $photo = $data['photo'];
        if ((isset($photo['error']) && $photo['error'] == 0) 
            || (!empty( $photo['tmp_name']) && $photo['tmp_name'] != 'none')) {
            return is_uploaded_file($photo['tmp_name']);
        }
        return false;
    }
    
    // get all employees in DB
    public function getAllEmployees()
    {
        $this->recursive = -1;
        return $this->find("all", array('order' => array('name' => 'asc')));
    }
    
    /* create new employee with $data provided
     * handle uploaded imgage
     * return success or not
     */
    public function saveEmployee($data)
    {
        // unset photo if there is no photo name (user don't upload image)
        if (!$data['Employee']['photo']['name']) {
            unset($data['Employee']['photo']);
        }
        
        $this->set($data);
        if ($this->validates()) {
            // if user upload image
            if (isset($data['Employee']['photo'])) {
                // generate new image name
                $imagename = uniqid() . '_' . $data['Employee']['photo']['name'];

                /* move uploaded file to webroot/files folder
                 * make sure that this folder is writable
                 */
                if (move_uploaded_file(
                    $data['Employee']['photo']['tmp_name'],
                    WWW_ROOT . 'files' . DS . $imagename
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
            } else {
                // if user don't upload image
                return $this->save($data, array('validate' => false));
            }
        }
        return false;
    }
    
    /* get profile of employee specified by $id
     * (duplication of Department->getDepartmentDetail())
     */
    public function getEmployeeProfile($id)
    {
        $this->recursive = 0;
        return $this->findById($id);
    }
}
