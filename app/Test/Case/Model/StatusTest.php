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

    public function testI18nList() {
        $status = new Status();
        $result = $status->i18nList();
        $this->assertEqual($result, array('sent' => 'sent',
                                          'in_progress' => 'in_progress',
                                          'resolved' => 'resolved',
                                          'ignored' => 'ignored'));
    }
}
