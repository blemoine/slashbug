<?php
App::uses('Usertype', 'Model');
/**
 * @property User User
 */
class UsersController extends AppController {

    public $components = array('Datatable.Datatable');

    public $helpers = array('Datatable.Datatable');

    public function index() {
    }

    public function listUsers() {
        $columns = array(
            'User.firstname',
            'User.lastname',
            'User.username',
            'User.email',
            'User.usertype'
        );
        $properties = $this->Datatable->initDatatableProperties($this->request->query, $columns, $this->User);
        foreach ($properties as $name => $val) {
            $this->set($name, $val);
        }

        $this->render(null, false);
    }

    public function add() {
        if ($this->request->isPost()) {
            $data = $this->request->data;

            if ($this->User->save($data)) {
                $this->setFlashSuccess(__('Your user has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->set('usertypes', Usertype::i18nList());
                $this->setFlashErrorForModel($this->User);
            }
        } else {
            $this->set('usertypes', Usertype::i18nList());
        }
    }

}
