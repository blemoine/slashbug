<?php
App::uses('Usertype', 'Model');

class UsertypeTest extends CakeTestCase {


    public function testValuesReturn_values() {
        $values = Usertype::values();

        $this->assertEqual($values, array('admin',
                                          'user'));
    }

    public function testI18nList() {
        $usertype = new Usertype();
        $result = $usertype->i18nList();
        $this->assertEqual($result, array('admin' => 'admin',
                                          'user' => 'user'));
    }
}
