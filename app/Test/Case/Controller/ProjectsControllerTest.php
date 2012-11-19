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
