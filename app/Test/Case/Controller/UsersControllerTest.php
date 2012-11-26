<?php
App::uses('AppControllerTest', 'Test/Case/Controller');

class UsersControllerTest extends AppControllerTest {

    public function testListUsers() {
        $query = array('test' => 'pp');

        Mock2::when($this->Datatable->initDatatableProperties($query,
            array(
                 'User.firstname',
                 'User.lastname',
                 'User.username',
                 'User.email',
                 'User.usertype'), $this->isInstanceOf('User')
        ))
            ->thenReturn(array(
                              'sEcho' => "value",
                              'iTotal' => 'value2',
                              'iFilteredTotal' => 'value3',
                              'rows' => array()));

        $this->testAction('/users/listUsers?test=pp', array('method' => 'get',
                                                            'return' => 'vars'));

        $this->assertEqual($this->vars['sEcho'], 'value');
        $this->assertEqual($this->vars['iTotal'], 'value2');
        $this->assertEqual($this->vars['iFilteredTotal'], 'value3');
        $this->assertEqual($this->vars['rows'], array());
    }


    public function testIndex() {
        $this->testAction('/users/index', array('return' => 'view'));
        $this->assertTrue(strpos($this->view, 'datatable') !== false);
    }

    public function testAdd_get() {
        $this->testAction('/users/add', array("method" => 'get'));
        $this->assertEqual($this->vars['usertypes'], Usertype::i18nList());
    }

    public function testAdd_postError() {
        $data = array('User' => array('firstname' => 'test'));
        Mock2::when($this->User->save($data))->thenReturn(false);
        $this->expectFlashError();
        $this->testAction('/users/add', array("method" => 'post',
                                              'data' => $data));
        $this->assertEqual($this->vars['usertypes'], Usertype::i18nList());
        $this->assertFalse(isset($this->headers['Location']));
    }

    public function testAdd_postOk() {
        $data = array('User' => array('firstname' => 'test'));
        Mock2::when($this->User->save($data))->thenReturn(true);
        $this->expectFlashSuccess();
        $this->testAction('/users/add', array("method" => 'post',
                                              'data' => $data));
        $this->assertContains('/users', $this->headers['Location']);
    }

    protected function getControllerName() {
        return 'Users';
    }

    protected function getModelsDescription() {
        return array('User');
    }

    protected function getComponentsDescription() {
        $components = parent::getComponentsDescription();
        $components[] = array('Datatable',
                              'Datatable');
        return $components;
    }
}
