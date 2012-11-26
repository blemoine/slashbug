<?php
App::uses('AppControllerTest', 'Test/Case/Controller');

class RequestsControllerTest extends AppControllerTest {


    public function testIndex() {
        $project = array('Project' => array('name' => 'My Project',
                                            'id' => 3));
        Mock2::when($this->Project->findById(3))->thenReturn($project);
        $this->testAction('/requests/index/3', array('return' => 'view'));
        $this->assertTrue(strpos($this->view, 'datatable') !== false);

        $this->assertEqual($this->vars['project'], $project);
    }

    public function testListRequest() {
        $query = array('test' => 'pp');

        Mock2::when($this->Datatable->initDatatableProperties($query,
            array(
                 'Request.name',
                 'Request.type',
                 'creatorFullname',
                 'Request.created',
                 'assignedFullname',
                 'Request.status'
            ), $this->isInstanceOf('Request'),
            array('findMethod' => 'findFilteredByProject',
                  'preconditions' => array('Request.project_id' => 34))))
            ->thenReturn(array(
                              'sEcho' => "value",
                              'iTotal' => 'value2',
                              'iFilteredTotal' => 'value3',
                              'rows' => array()));

        $this->testAction('/requests/listRequests/34?test=pp', array('method' => 'get',
                                                                     'return' => 'vars'));

        $this->assertEqual($this->vars['sEcho'], 'value');
        $this->assertEqual($this->vars['iTotal'], 'value2');
        $this->assertEqual($this->vars['iFilteredTotal'], 'value3');
        $this->assertEqual($this->vars['rows'], array());
    }

    public function testAdd_get() {
        $users = array(3 => 'user');
        Mock2::when($this->User->find('list', array('fields' => array('id',
                                                                      'username'))))->thenReturn($users);

        $project = array('Project' => array('name' => 'test name',
                                            'id' => 2));
        Mock2::when($this->Project->findById(2))->thenReturn($project);

        $this->mockEnum();
        $this->testAction('/requests/add/2', array('method' => 'get'));


        $this->assertEqual($this->vars['users'], $users);
        $this->assertEqual($this->vars['project'], $project);
        $this->assertEnumInVars();
    }

    public function testEdit_get() {

        $users = array(3 => 'user');
        Mock2::when($this->User->find('list', array('fields' => array('id',
                                                                      'username'))))->thenReturn($users);
        $project = array('Project' => array('name' => 'test name',
                                            'id' => 2));
        Mock2::when($this->Project->findById(2))->thenReturn($project);

        $request = array('Request' => array('id' => 23,
                                            'project_id' => 2));
        Mock2::when($this->Request->findById(23))->thenReturn($request);
        $this->mockEnum();
        $this->testAction('/requests/edit/23', array('method' => 'get'));

        $this->assertEqual($this->controller->request->data, $request);

        $this->assertEqual($this->vars['users'], $users);
        $this->assertEqual($this->vars['project'], $project);
        $this->assertEnumInVars();
    }

    public function testEdit_postError() {
        $users = array(3 => 'user');
        Mock2::when($this->User->find('list', array('fields' => array('id',
                                                                      'username'))))->thenReturn($users);

        $request = array('Request' => array('id' => 23));
        Mock2::when($this->Request->save($request))->thenReturn(false);

        $project = array('Project' => array('name' => 'test name',
                                            'id' => 2));
        Mock2::when($this->Project->findById(2))->thenReturn($project);

        $request2 = array('Request' => array('id' => 23,
                                             'project_id' => 2));
        Mock2::when($this->Request->findById(23))->thenReturn($request2);
        $this->mockEnum();
        $this->expectFlashError();
        $this->testAction('/requests/edit/23', array('method' => 'put',
                                                     'data' => $request));

        $this->assertEqual($this->controller->request->data, $request);
        $this->assertEqual($this->vars['users'], $users);
        $this->assertEqual($this->vars['project'], $project);
        $this->assertEnumInVars();
    }

    public function testEdit_postOk() {

        $request = array('Request' => array('id' => 23,
                                            'project_id' => 32));
        Mock2::when($this->Request->save($request))->thenReturn(true);
        Mock2::when($this->Request->findById(23))->thenReturn($request);
        $this->expectFlashSuccess();
        $this->testAction('/requests/edit/23', array('method' => 'put',
                                                     'data' => $request));

        $this->assertEqual($this->controller->request->data, $request);

        $this->assertContains('/requests/index/32', $this->headers['Location']);
    }

    public function testAdd_postOk() {
        $data = array('Request' => array('name' => 'test',
                                         'project_id' => 23));
        Mock2::when($this->Request->save($data))->thenReturn(true);

        $this->expectFlashSuccess();
        $this->testAction('/requests/add/23', array('method' => 'post',
                                                    'data' => array('Request' => array('name' => 'test'))));

        $this->assertContains('/requests/index/23', $this->headers['Location']);
    }

    public function testAdd_postError() {
        $users = array(3 => 'user');
        Mock2::when($this->User->find('list', array('fields' => array('id',
                                                                      'username'))))->thenReturn($users);

        $data = array('Request' => array('name' => 'test',
                                         'project_id' => 2));
        $project = array('Project' => array('name' => 'test name',
                                            'id' => 2));
        Mock2::when($this->Project->findById(2))->thenReturn($project);
        Mock2::when($this->Request->save($data))->thenReturn(false);
        $this->mockEnum();
        $this->expectFlashError();
        $this->testAction('/requests/add/2', array('method' => 'post',
                                                   'data' => array('Request' => array('name' => 'test'))));

        $this->assertFalse(isset($this->headers['Location']));
        $this->assertEqual($this->vars['users'], $users);
        $this->assertEqual($this->vars['project'], $project);
        $this->assertEnumInVars();
    }

    protected function mockEnum($types = array('DataType'), $status = array('dataStatus'), $priorities = array('dataPriority')) {
        Mock2::when($this->Type->i18nList())->thenReturn($types);
        Mock2::when($this->Status->i18nList())->thenReturn($status);
        Mock2::when($this->Priority->i18nList())->thenReturn($priorities);
    }

    protected function assertEnumInVars($types = array('DataType'), $status = array('dataStatus'), $priorities = array('dataPriority')) {
        $this->assertEqual($this->vars['types'], $types);
        $this->assertEqual($this->vars['status'], $status);
        $this->assertEqual($this->vars['priorities'], $priorities);
    }

    protected function getControllerName() {
        return 'Requests';
    }

    protected function getModelsDescription() {
        return array('Request',
                     'User',
                     'Project',
                     'Type',
                     'Priority',
                     'Status');
    }

    protected function getComponentsDescription() {
        $components = parent::getComponentsDescription();
        $components[] = array('Datatable',
                              'Datatable');
        return $components;
    }
}
