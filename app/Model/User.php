<?php

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');

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
    );
    
    // init pass for user with username provided and set change_pass = 0
    public function initPassAndState($username, $genPass)
    {
        $hasher = new SimplePasswordHasher();
        $genPass = $hasher->hash($genPass);
        // add "'" to get correct sql syntax
        return $this->updateAll(
            array(
                'password' => "'" . $genPass . "'",
                'changed_pass' => false
            ),
            array('username' => $username)
        );
    }
    
    /* send username and pass to user via mail
     * ---------------------------------------
     * to send successfully (using gmail), config email in Config/email.php
     * and turn on "Access for less secure apps" in google account settings
     */
    public function sendEmail($address, $username, $pass) {
        $subject = 'You now are an user of Employees Directory!';
        $body = 'Your username : ' . $username . '. Your password : ' . $pass . '. (not include the last period)';
        
        $email = new CakeEmail('smtp');
        $email->to($address)->subject($subject)->send($body);
    }
}
