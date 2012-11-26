<?php
App::uses('User', 'Model');

class UserTest extends CakeTestCase {

    public function setUp() {
        parent::setUp();
        $this->User = ClassRegistry::init('User');
    }

    public function testSave_password() {

        $user = array('User' => array(
            'firstname' => 'Georges',
            'lastname' => 'Abitbol',
            'username' => 'classeman',
            'email' => 'georges.abitbol@caturday.dyndns.org',
            'password' => 'monde de merde'
        ));

        $result = $this->User->save($user);

        $this->assertTrue(is_numeric($result['User']['id']));
        $this->assertEqual($result['User']['password'], AuthComponent::password('monde de merde'));
    }
}
