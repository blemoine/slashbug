<?php
class RequestsController extends AppController {

    public $uses = array('Request',
                         'Project');
    public $components = array('Datatable');

    public function index($idProject) {
        $project = $this->Project->findById($idProject);
        $this->set('project', $project);
    }

    public function listRequests($idProject) {
        $columns = array(
            'Request.name',
            'Request.type',
            'creatorFullname',
            'Request.created',
            'assignedFullname',
            'Request.status'
        );
        $properties = $this->Datatable->initDatatableProperties($this->request->query, $columns, $this->Request,
            array('findMethod' => 'findFilteredByProject'
            ,'preconditions'=>array('Request.project_id'=>$idProject)));
        foreach ($properties as $name => $val) {
            $this->set($name, $val);
        }

        $this->render(null, false);
    }

    public function add($idProject) {

    }

}
