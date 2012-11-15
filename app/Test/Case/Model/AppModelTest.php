<?php
App::uses('AppModel', 'Model');

class AppModelTest extends CakeTestCase {

    public function setUp() {
        parent::setUp();
        $this->Model = ClassRegistry::init('AppModel');
    }


    public function testInEnum_returnTrueIfInEnum() {
        $result = $this->Model->inEnum(array('da' => 'in'), 'MockEnum');
        $this->assertTrue($result);
    }

    public function testInEnum_returnFalseIfNotInEnum() {
        $result = $this->Model->inEnum(array('da' => 'not in'), 'MockEnum');
        $this->assertFalse($result);
    }

    public function testInEnum_paramMustBeAnEnum() {
        $this->expectException('InvalidArgumentException');
        $this->Model->inEnum(array('da' => 'not in'), 'AppModel');
    }
}

class MockEnum {
    public static function values() {
        return array('v in',
                     'in');
    }
}