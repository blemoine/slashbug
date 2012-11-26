<?php
App::uses('Usertype', 'Model');

class User extends AppModel {

    private $nonHashedPassword;

    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'A username is required'),
            'length' => array(
                'rule' => array(
                    'maxLength',
                    50),
                'message' => 'The username must have less than 50 characters'),
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Alphabets and numbers only'),
            'unique' => array(
                'rule' => 'isUnique',
                'required' => 'create',
                'message' => "This username already exists; please choose another one")

        ),
        'firstname' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A firstname is required')),
        'lastname' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A lastname is required')),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'),
            'length' => array(
                'rule' => array(
                    'maxLength',
                    50),
                'message' => 'The username must have less than 50 characters')),
        'email' => array(
            'valid' => array(
                'rule' => array(
                    'notEmpty',
                    'email'),
                'message' => 'Please enter a valid email address',
                'allowEmpty' => false)),
        'usertype' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A usertype is required'),
            'inEnum' => array(
                'rule' => array('inEnum',
                                'Usertype'),
                'message' => 'The usertype must be in the enum'),
        ));

    public function beforeSave() {
        if (isset($this->data[$this->alias]['password'])) {
            $this->nonHashedPassword = $this->data[$this->alias]['password'];
            $this->data[$this->alias]['password'] = AuthComponent::password($this->nonHashedPassword);
        }
        return true;
    }

}
