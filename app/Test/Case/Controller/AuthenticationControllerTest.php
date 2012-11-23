<?php
App::uses('AppControllerTest', 'Test/Case/Controller');

class AuthenticationControllerTest extends AppControllerTest {

    public function testLogout() {
        $mock = new Mock2('AuthComponent');
        Mock2::when($mock->logout())->thenReturn(array('controller'=>'test','action'=>'act'));
        $mock->__instrument($this->controller->Auth);

        $this->testAction('/authentication/logout',array('method'=>'get'));

        $this->assertContains('/test/act', $this->headers['Location']);
    }

    public function testLogin_postOk() {
        $mock = new Mock2('AuthComponent');
        Mock2::when($mock->redirect())->thenReturn(array('controller'=>'test','action'=>'act'));
        Mock2::when($mock->login())->thenReturn(true);
        $mock->__instrument($this->controller->Auth);

        $this->testAction('/authentication/login',array('method'=>'post'));

        $this->assertContains('/test/act', $this->headers['Location']);
    }

    public function testLogin_postNonOk() {
        $mock = new Mock2('AuthComponent');
        Mock2::when($mock->login())->thenReturn(false);
        $mock->__instrument($this->controller->Auth);

        $this->expectFlashError();
        $this->testAction('/authentication/login',array('method'=>'post'));

        $this->assertFalse(isset($this->headers['Location']));
    }


    protected function getControllerName() {
        return 'Authentication';
    }

    protected function getModelsDescription() {
        return array();
    }
}
