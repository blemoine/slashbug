<?php
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('FormatHelper', 'View/Helper');
App::uses('Router', 'Routing');
App::uses('TimeHelper', 'View/Helper');
App::uses('L10nInfo', 'I18n');

App::import('Vendor', 'Mock2', array('file' => 'mock2/Mock2.php'));
App::import('Vendor', 'PHPUnit_Framework_Constraint_Callback', array('file' => 'phpunit/PHPUnit_Framework_Constraint_Callback.php'));


class FormatHelperTest extends CakeTestCase {

    /**
     * @var FormatHelper
     */
    private $Format;

    public function setUp() {
        parent::setUp();

        ClassRegistry::flush();
        Router::reload();

        $controller = new Controller();
        $this->view = new View($controller);

        $this->Format = new FormatHelper($this->view);
        $this->Format->request = new CakeRequest(null, false);
    }


    public function testBoolean_valueIsTrue() {
        $this->assertEqual($this->Format->boolean(true, "true2", "false2"), "true2");
        $this->assertEqual($this->Format->boolean(1, "true2", "false2"), "true2");
    }

    public function testBoolean_valueIsFalse() {
        $this->assertEqual($this->Format->boolean(false, "true2", "false2"), "false2");
        $this->assertEqual($this->Format->boolean(0, "true2", "false2"), "false2");
    }

    public function testBoolean_defaultValueTrue() {
        $this->assertEqual($this->Format->boolean(true), "true");
    }

    public function testBoolean_defaultValueFalse() {
        $this->assertEqual($this->Format->boolean(false), "false");
    }

    public function testDate_formatSpecified() {
        $mockTime = new Mock2('TimeHelper', array($this->view));
        Mock2::when($mockTime->format('Y--m--d', 12456))->thenReturn("correctTime");
        $this->Format->Time = $mockTime->__instrument();

        $this->assertEqual($this->Format->date(12456, 'Y--m--d'), 'correctTime');
    }

    public function  testToday() {
        $oldValue = Configure::read('Config.l10nInfo');
        L10nInfo::$DEFAULT_LANGUAGE_CONFIGURATION['dada'] = array('Y--m--d',
                                                                  'dad');
        $l10nInfo = L10nInfo::create('dada');
        Configure::write('Config.l10nInfo', $l10nInfo);

        $this->assertEqual($this->Format->today(), date('Y--m--d'));

        Configure::write('Config.l10nInfo', $oldValue);
    }

    public function testDate_defaultFormatSpecified() {

        $mockTime = new Mock2('TimeHelper', array($this->view));
        Mock2::when($mockTime->format('Y--m--d', 12456))->thenReturn("correctTime");
        $this->Format->Time = $mockTime->__instrument();

        $oldValue = Configure::read('Config.l10nInfo');
        L10nInfo::$DEFAULT_LANGUAGE_CONFIGURATION['dada'] = array('Y--m--d',
                                                                  'dad');
        $l10nInfo = L10nInfo::create('dada');
        Configure::write('Config.l10nInfo', $l10nInfo);

        $this->assertEqual($this->Format->date(12456), 'correctTime');
        Configure::write('Config.l10nInfo', $oldValue);
    }
}
