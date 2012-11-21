<?php
App::uses('Type', 'Model');
App::uses('Priority', 'Model');
App::uses('Status', 'Model');
/**
 * @property Request Request
 * @property User User
 * @property Project Project
 */
class RequestsController extends AppController {

    public $uses = array('Request',
                         'Project',
                         'User');
    public $components = array('Datatable.Datatable');

    public $helpers = array('Datatable.Datatable');

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

    public function edit($idRequest) {

        if (!$this->request->isPut()) {
            $this->loadDataForSelect();
            $this->request->data = $this->Request->findById($idRequest);
        } else {
            $data = $this->request->data;

            $data['Request']['id'] = $idRequest;
            if ($this->Request->save($data)) {
                $this->setFlashSuccess(__('Your request has been saved.'));
                $request = $this->Request->findById($idRequest);
                $this->redirect(array('action' => 'index',
                                      $request['Request']['project_id']));
            } else {
                $this->loadDataForSelect();
                $this->setFlashErrorForModel($this->Request);
            }
        }
    }

    public function add() {
        if ($this->request->isPost()) {
            $data = $this->request->data;

            if ($this->Request->save($data)) {
                $this->setFlashSuccess(__('Your request has been saved.'));
                $this->redirect(array('action' => 'index',
                                      $data['Request']['project_id']));
            } else {
                $this->loadDataForSelect();
                $this->setFlashErrorForModel($this->Request);
            }
        } else {
            $this->loadDataForSelect();
        }
    }

    protected function loadDataForSelect() {
        $this->set('projects', $this->Project->find('list'));
        $this->set('users', $this->User->find('list', array('fields' => array('id',
                                                                              'username'))));
        $this->set('types', Type::i18nList());
        $this->set('status', Status::i18nList());
        $this->set('priorities', Priority::i18nList());
    }

}
