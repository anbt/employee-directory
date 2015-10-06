<?php

App::uses('AppModel', 'Model');

class User extends AppModel
{
    public $validate = array(
        'username' => array(
            'required' => 'create',
            'between' => array(
                'rule' => array('lengthBetween', 3, 100),
                'message' => 'Username length must be between 3 and 100.'
            ),
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Letters and numbers only in username.'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This username is in use.',
            ),
        ),
        'email' => array(
            'rule' => array('email', true),
            'required' => true,
            'message' => 'Please enter a valid email address.'
        ),
    );
}
