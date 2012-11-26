<?php
App::uses('Priority', 'Model');

class PriorityTest extends CakeTestCase {


    public function testValuesReturn_values() {
        $values = Priority::values();

        $this->assertEqual($values, array('normal',
                                          'urgent'));
    }

    public function testI18nList() {
        $priority = new Priority();
        $result = $priority->i18nList();
        $this->assertEqual($result, array('normal' => 'normal',
                                          'urgent' => 'urgent'));
    }
}
