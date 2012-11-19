<?php
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('AFormHelper', 'View/Helper');
App::uses('HtmlHelper', 'View/Helper');
App::uses('Router', 'Routing');

App::import('Vendor', 'Mock', array('file' => 'mock/Mock.php'));
App::import('Vendor', 'PHPUnit_Framework_Constraint_Callback', array('file' => 'phpunit/PHPUnit_Framework_Constraint_Callback.php'));

class AFormHelperTest extends CakeTestCase {

    private $AForm;
    private $view;

    public function setUp() {
        parent::setUp();

        ClassRegistry::flush();
        Router::reload();

        $controller = new Controller();
        $this->view = new View($controller);

        $this->AForm = new AFormHelper($this->view);
        $this->AForm->request = new CakeRequest(null, false);
    }

    public function testCreate_addJqueryValidate() {
        $this->AForm->Html = $this->getMock('HtmlHelper', array('scriptBlock'), array($this->view));

        $mock = new Mock($this->AForm->Html);
        Mock::expects($mock->scriptBlock(new PHPUnit_Framework_Constraint_Callback(function($script) {

            return strpos($script, "('#MockFormModelForm').validate(") !== false;
        }), array('inline' => false)));

        $form = $this->AForm->create('MockFormModel');

        $this->assertTrue(strpos($form, '<form') !== false);
    }

    public function testAjaxSelect_nominal() {
        $this->AForm->Html = $this->getMock('HtmlHelper', array('scriptBlock'), array($this->view));
        $mock = new Mock($this->AForm->Html);
        Mock::expects($mock->scriptBlock(new PHPUnit_Framework_Constraint_Callback(function($script) {

            return strpos($script, "('#attributMock').autocomplete(") !== false;
        }), array('inline' => false)));

        $autocomplete = $this->AForm->ajaxSelect('attribut', array('controller' => 'mineController',
                                                                   'action' => 'monAction'));

        $this->assertEquals(substr_count($autocomplete, '<input'), 2);

        $this->assertTrue(strpos($autocomplete, 'id="attributMock"') !== false);
    }

    public function testDatepicker_nominal() {
        $this->AForm->Html = $this->getMock('HtmlHelper', array('scriptBlock'), array($this->view));
        $mock = new Mock($this->AForm->Html);
        Mock::expects($mock->scriptBlock(new PHPUnit_Framework_Constraint_Callback(function($script) {

            return strpos($script, "('#attribut').datepicker(") !== false;
        }), array('inline' => false)));

        $result = $this->AForm->datepicker('attribut');


        $this->assertTrue(strpos($result, '<input') !== false);
    }

}

class MockFormModel extends CakeTestModel {
    public $useTable = false;
}
