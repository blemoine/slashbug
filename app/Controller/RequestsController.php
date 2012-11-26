<?php
/**
 * @property Request Request
 * @property User User
 * @property Project Project
 */
class RequestsController extends AppController {

    public $uses = array('Request',
                         'Project',
                         'User',
                         'Type',
                         'Priority',
                         'Status');
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
            $request = $this->Request->findById($idRequest);
            $this->loadDataForSelect($request['Request']['project_id']);
            $this->request->data = $request;
        } else {
            $data = $this->request->data;

            $data['Request']['id'] = $idRequest;
            if ($this->Request->save($data)) {
                $this->setFlashSuccess(__('Your request has been saved.'));
                $request = $this->Request->findById($idRequest);
                $this->redirect(array('action' => 'index',
                                      $request['Request']['project_id']));
            } else {
                $request = $this->Request->findById($idRequest);
                $this->loadDataForSelect($request['Request']['project_id']);
                $this->setFlashErrorForModel($this->Request);
            }
        }
    }

    public function add($idProjectStr) {
        $idProject = (int) $idProjectStr;
        if ($this->request->isPost()) {
            $data = $this->request->data;

            $data['Request']['project_id'] = $idProject;
            $data['Request']['created_by'] = $this->Auth->user('id');

            if ($this->Request->save($data)) {
                $this->setFlashSuccess(__('Your request has been saved.'));
                $this->redirect(array('action' => 'index',
                                      $idProject));
            } else {
                $this->loadDataForSelect($idProject);
                $this->setFlashErrorForModel($this->Request);
            }
        } else {
            $this->loadDataForSelect($idProject);
        }
    }

    protected function loadDataForSelect($idProject) {
        $project = $this->Project->findById($idProject);
        $this->set('project', $project);
        $this->set('users', $this->User->find('list', array('fields' => array('id',
                                                                              'username'))));
        $this->set('types', $this->Type->i18nList());
        $this->set('status', $this->Status->i18nList());
        $this->set('priorities', $this->Priority->i18nList());
    }

}
