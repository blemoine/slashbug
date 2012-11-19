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

    protected function getControllerName() {
        return 'Requests';
    }

    protected function getModelsDescription() {
        return array('Request',
                     'Project');
    }

    protected function getComponentsDescription() {
        $components = parent::getComponentsDescription();
        $components[] = array('Datatable',
                              'Datatable');
        return $components;
    }
}
