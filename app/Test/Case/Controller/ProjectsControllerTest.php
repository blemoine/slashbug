<?php
App::uses('AppControllerTest', 'Test/Case/Controller');

class ProjectsControllerTest extends AppControllerTest {

    public function testAdd_post() {

        $postData = array('Project' => array('name' => 'project name'));

        Mock2::when($this->Project->save($postData))->thenReturn(true);

        $this->expectFlashSuccess();
        $this->testAction('/projects/add', array('method' => 'post',
                                                 'data' => $postData));

        $this->assertTrue(isset($this->headers['Location']));
    }

    public function testAdd_postError() {

        $postData = array('Project' => array('name' => 'project name'));

        Mock2::when($this->Project->save($postData))->thenReturn(false);

        $this->expectFlashError();
        $this->testAction('/projects/add', array('method' => 'post',
                                                 'data' => $postData));

        $this->assertFalse(isset($this->headers['Location']));
    }

    public function testListProject() {
        $query = array('test' => 'pp');

        Mock2::when($this->Datatable->initDatatableProperties($query,
            array(
                 'Project.name',
                 'Project.created',
                 'inProgress',
                 'done',
                 'total'), $this->isInstanceOf('Project'),
            array('findMethod' => 'findWithRequestsCount')))
            ->thenReturn(array(
                              'sEcho' => "value",
                              'iTotal' => 'value2',
                              'iFilteredTotal' => 'value3',
                              'rows' => array()));

        $this->testAction('/projects/listProjects?test=pp', array('method' => 'get',
                                                                  'return' => 'vars'));

        $this->assertEqual($this->vars['sEcho'], 'value');
        $this->assertEqual($this->vars['iTotal'], 'value2');
        $this->assertEqual($this->vars['iFilteredTotal'], 'value3');
        $this->assertEqual($this->vars['rows'], array());
    }


    protected function getControllerName() {
        return 'Projects';
    }

    protected function getModelsDescription() {
        return array('Project');
    }

    protected function getComponentsDescription() {
        $components = parent::getComponentsDescription();
        $components[] = array('Datatable',
                              'Datatable');
        return $components;
    }
}
