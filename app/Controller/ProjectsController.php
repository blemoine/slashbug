<?php
class ProjectsController extends AppController {

    public $components = array('Datatable');

    public function index() {
    }

    public function listProjects() {
        $columns = array(
            'name',
            'created');
        $properties = $this->Datatable->initDatatableProperties($this->request->query, $columns, $this->Project);
        foreach ($properties as $name => $val) {
            $this->set($name, $val);
        }

        $this->render(null, false);
    }

}
