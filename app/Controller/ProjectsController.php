<?php
CakePlugin::load('Datatable');

class ProjectsController extends AppController {

    public $components = array('Datatable.Datatable');

    public $helpers = array('Datatable.Datatable');

    public function index() {
    }

    public function listProjects() {
        $columns = array(
            'Project.name',
            'Project.created',
            'inProgress',
            'done',
            'total');
        $properties = $this->Datatable->initDatatableProperties($this->request->query, $columns, $this->Project, array('findMethod' => 'findWithRequestsCount'));
        foreach ($properties as $name => $val) {
            $this->set($name, $val);
        }

        $this->render(null, false);
    }

    public function add() {
        if ($this->request->isPost()) {
            if ($this->Project->save($this->request->data)) {
                $this->setFlashSuccess(__('Your project has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlashErrorForModel($this->Project);
            }
        }
    }
}
