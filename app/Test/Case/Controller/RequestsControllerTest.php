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
