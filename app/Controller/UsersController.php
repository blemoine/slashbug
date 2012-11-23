<?php
App::uses('UserType', 'Model');
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
            'User.email'
        );
        $properties = $this->Datatable->initDatatableProperties($this->request->query, $columns, $this->User);
        foreach ($properties as $name => $val) {
            $this->set($name, $val);
        }

        $this->render(null, false);
    }


}
