<?php
App::uses('Type','Model');
App::uses('Priority','Model');
App::uses('Status','Model');

class RequestsController extends AppController {

    public $uses = array('Request',
                         'Project',
                         'User');
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
            array('findMethod' => 'findFilteredByProject',
                  'preconditions' => array('Request.project_id' => $idProject)));
        foreach ($properties as $name => $val) {
            $this->set($name, $val);
        }

        $this->render(null, false);
    }

    public function add() {

        $this->set('projects', $this->Project->find('list'));
        $this->set('users', $this->User->find('list', array('fields'=>array('id','username'))));
        $this->set('types',Type::i18nList());
        $this->set('status',Status::i18nList());
        $this->set('priorities',Priority::i18nList());

        if ($this->request->isPost()) {
            $data = $this->request->data;

            if ($this->Request->save($data)) {
                $this->setFlashSuccess(__('Your request has been saved.'));
                $this->redirect(array('action' => 'index',
                                      $data['Request']['project_id']));
            } else {
                $this->setFlashErrorForModel($this->Request);
            }
        }
    }

}
