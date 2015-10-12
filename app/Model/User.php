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
                'message' => 'Letters and numbers only in username.'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
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
                'message' => 'Please enter a valid email address.'
            ),
        ),
        'password' => array(
            'longEnough' => array(
                'rule' => array('minLength', 8),
                'required' => 'update',
                'message' => 'Password need to be at least 8 chars long.'
            )
        )
    );
    
    /**
     * Check if current password field in pass-changing form is current password
     * 
     * @param array $data
     * @return boolean
     */
    public function isCurrentPass($data)
    {
        $this->id = AuthComponent::user('id');
        $curPass = $this->field('password');
        $hasher = new SimplePasswordHasher();
        $checkedPass = $hasher->hash($data['cur_password']);
        return (strcmp($checkedPass, $curPass) == 0);
    }

    /**
     * Check if new password not match current password
     * 
     * @param array $data
     * @return boolean
     */
    public function notMatchCurrentPassField($data)
    {
        return (strcmp($data['password'], $this->data['User']['cur_password']) != 0);
    }
    
    /**
     * Check if confirm matches new password
     * 
     * @param array $data
     * @return boolean
     */
    public function matchNewPass($data)
    {
        return (strcmp($data['confirm'], $this->data['User']['password']) == 0);
    }
    
    public function addCurrentPasswordValidator()
    {
        $this->validator()->add('cur_password', 'isCurPass', array(
            'rule'     => array('isCurrentPass'),
            'required' => 'update',
            'message'  => 'This is not your current password.'
        ));
    }

    public function addNewPassNotMatchCurPassValidator()
    {
        $this->validator()->add('password', 'notMatchCurPass', array(
            'rule'    => 'notMatchCurrentPassField',
            'message' => 'This field should not be similar to "Current Password" field.'
        ));
    }

    public function addPasswordConfirmValidator()
    {
        $this->validator()->add('confirm', 'matchNewPass', array(
            'rule'     => array('matchNewPass'),
            'required' => 'update',
            'message'  => 'Confirm must match password.'
        ));
    }

    public function beforeSave($options = array()) 
    {
        if (!empty($this->data['User']['password'])) {
            // there is an id, this is an updating save
            $hasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $hasher->hash($this->data['User']['password']);
        }
        return true;
    }
    
    /**
     * Create new user with provided username and email
     * return success or not (and non-ecrypted generated password)
     * 
     * @param array $data
     * @return array
     */
    public function createUser($data)
    {
        $this->create();
        // init pass for user with username provided and set change_pass = false
        $pass = $this->genPass();
        $data['User']['password'] = $pass;
        $data['User']['changed_pass'] = false;

        $success = $this->save($data);
        return array("success" => $success, "password" => $pass);
    }
    
    /**
     * Generate pass with provided length
     * 
     * @param int $length
     * @return string
     */
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
