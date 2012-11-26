<?php
App::uses('Type', 'Model');

class TypeTest extends CakeTestCase {


    public function testValuesReturn_values() {
        $values = Type::values();

        $this->assertEqual($values, array('maintenance',
                                          'bug',
                                          'evolution'));
    }

    public function testI18nList() {
        $type = new Type();
        $result = $type->i18nList();
        $this->assertEqual($result, array('maintenance' => 'maintenance',
                                          'bug' => 'bug',
                                          'evolution' => 'evolution'));
    }
}
