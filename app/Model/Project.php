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
        if ($type == 'count' || $type == 'all') {
            $options = $this->filterParametersForDatatableFind($options, array('inProgress',
                                                                               'done',
                                                                               'total'));

            if ($type == 'count') {
                $result = $this->find('count', $options);
            } else if ($type == 'all') {
                $statusInProgress = Status::IN_PROGRESS;
                $statusResolved = Status::RESOLVED;
                $options['fields'] = array(
                    'Project.name',
                    'Project.created',
                    "(SELECT COUNT(id) FROM requests where project_id = Project.id and status = '$statusInProgress') as inProgress",
                    "(SELECT COUNT(id) FROM requests where project_id = Project.id and status = '$statusResolved') as done",
                    "(SELECT COUNT(id) FROM requests where project_id = Project.id) as total"
                );

                $result = $this->find('all', $options);
            }

            return $result;
        } else {
            throw new InvalidArgumentException();
        }
    }

}
