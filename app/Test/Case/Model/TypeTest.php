<?php
App::uses('Type', 'Model');

class TypeTest extends CakeTestCase {


    public function testValuesReturn_values() {
        $values = Type::values();

        $this->assertEqual($values, array('maintenance',
                                          'bug',
                                          'evolution'));
    }
}
