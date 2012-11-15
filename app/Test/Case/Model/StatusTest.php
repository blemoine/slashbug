<?php
App::uses('Status', 'Model');

class StatusTest extends CakeTestCase {


    public function testValuesReturn_values() {
        $values = Status::values();

        $this->assertEqual($values, array('sent',
                                          'in_progress',
                                          'resolved',
                                          'ignored'));
    }
}
