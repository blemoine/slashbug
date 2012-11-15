<?php
App::uses('Priority', 'Model');

class PriorityTest extends CakeTestCase {


    public function testValuesReturn_values() {
        $values = Priority::values();

        $this->assertEqual($values, array('normal',
                                          'urgent'));
    }
}
