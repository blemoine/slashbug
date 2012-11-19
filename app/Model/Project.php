<?php
App::uses('Status', 'Model');

class Project extends AppModel {

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'A name is required'),
            'unique' => array(
                'rule' => 'isUnique',
                'required' => 'create',
                'message' => "This name already exists; please choose another one")

        ),
    );

    public $actsAs = array('Datatable.Datatable');

    public function findWithRequestsCount($type, $options = array()) {

        $statusInProgress = Status::IN_PROGRESS;
        $statusResolved = Status::RESOLVED;
        $fields = array(
            'Project.id',
            'Project.name',
            'Project.created',
            "(SELECT COUNT(id) FROM requests where project_id = Project.id and status = '$statusInProgress') as inProgress",
            "(SELECT COUNT(id) FROM requests where project_id = Project.id and status = '$statusResolved') as done",
            "(SELECT COUNT(id) FROM requests where project_id = Project.id) as total"
        );

        $forbiddenSearchFields = array('inProgress',
                                       'done',
                                       'total');
        return $this->customFindMethod($type, $options, $fields, $forbiddenSearchFields);
    }

}
