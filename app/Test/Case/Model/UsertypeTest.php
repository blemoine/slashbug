<?php
App::uses('Usertype', 'Model');

class UsertypeTest extends CakeTestCase {


    public function testValuesReturn_values() {
        $values = Usertype::values();

        $this->assertEqual($values, array('admin','user'));
    }
}
