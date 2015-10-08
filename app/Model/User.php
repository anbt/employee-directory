<?php

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel
{
    public $validate = array(
        'username' => array(
            'between' => array(
                'rule' => array('lengthBetween', 3, 100),
                'required' => 'create',
                'message' => 'Username length must be between 3 and 100.'
            ),
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => 'create',
                'message' => 'Letters and numbers only in username.'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'required' => 'create',
                'message' => 'This username is in use.'
            ),
        ),
        'email' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'required' => 'create',
                'message' => 'This email is in use.'
            ),
            'isEmail' => array(
                'rule' => array('email'),
                'required' => 'create',
                'message' => 'Please enter a valid email address.'
            ),
        ),
        'cur_password' => array(
            'isCurPass' => array(
                'rule' => array('isCurrentPass'),
                'required' => 'update',
                'message' => 'This is not your current password.'
            )
        ),
        'password' => array(
            'longEnough' => array(
                'rule' => array('minLength', 8),
                'required' => 'update',
                'message' => 'Password need to be at least 8 chars long.'
            ),
            'notMatchCurPass' => array(
                'rule' => 'notMatchCurrentPassField',
                'required' => 'update',
                'message' => 'This field should not be similar to "Current password" field.'
            )
        ),
        'confirm' => array(
            'rule' => array('matchNewPass'),
            'required' => 'update',
            'message' => 'Confirm must match password.'
        ),
    );
    
    // check if current password field in pass-changing form is current password in DB
    public function isCurrentPass($data)
    {
        $this->id = AuthComponent::user('id');
        $curPass = $this->field('password');
        $hasher = new SimplePasswordHasher();
        $checkedPass = $hasher->hash($data['cur_password']);
        return (strcmp($checkedPass, $curPass) == 0);
    }

    // check if new password not match current password
    public function notMatchCurrentPassField($data)
    {
        return (strcmp($data['password'], $this->data['User']['cur_password']) != 0);
    }
    
    // confirm need to match new password
    public function matchNewPass($data)
    {
        return (strcmp($data['confirm'], $this->data['User']['password']) == 0);
    }
    
    public function beforeSave($options = array()) 
    {
        if ($this->id) {
            // there is an id, this is an updating save
            $hasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $hasher->hash($this->data['User']['password']);
            // user has changed pass
            $this->data['User']['changed_pass'] = 1;
        }        
        return true;
    }
    
    /* create new user with username and email provided
     * return success or not (and non-ecrypted generated password)
     */
    public function createUser($data)
    {
        // validate first
        $this->set($data);
        if ($this->validates()) {
            // init pass for user with username provided and set change_pass = false
            $pass = $this->genPass();
            $hasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $hasher->hash($pass);
            $this->data['User']['changed_pass'] = false;
            
            // data has been validated above, don't need to be again, 'validate' => false
            $success = $this->save($data, array('validate' => false));
            return array("success" => $success, "password" => $pass);
        }
        return array("success" => false);
    }
    
    // generate pass with length provided
    protected function genPass($length = 15)
    {
        $pass = '';
        // character allowed in pass
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $charsLength = strlen($chars);
        
        for ($i = 0; $i < $length; ++$i) {
            $pass .= $chars[rand(0, $charsLength - 1)];
        }
        return $pass;
    }
}
