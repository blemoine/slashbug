<?php

class Request extends AppModel {

    public $belongsTo = array(
        'Creator' => array(
            'className' => 'User',
            'foreignKey' => 'created_by'
        ),
        'Assigned' => array(
            'className' => 'User',
            'foreignKey' => 'assigned_to'
        )
    );

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'A name is required')
        ),
        'created_by' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A creator is required'),
            'naturalNumber' => array(
                'rule' => array('naturalNumber',
                                false),
                'required' => true,
                'message' => 'numbers only'),
        ),
        'project_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A project is required'),
            'naturalNumber' => array(
                'rule' => array('naturalNumber',
                                false),
                'required' => true,
                'message' => 'numbers only'),
        ),
        'type' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A type is required'),
            'inEnum' => array(
                'rule' => array('inEnum',
                                'Type'),
                'message' => 'The type must be in the enum'),),
        'priority' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A priority is required'),
            'inEnum' => array(
                'rule' => array('inEnum',
                                'Priority'),
                'message' => 'The priority must be in the enum'),),
        'status' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A status is required'),
            'inEnum' => array(
                'rule' => array('inEnum',
                                'Status'),
                'message' => 'The status must be in the enum'),),
        'minute_spent' => array(
            'naturalNumber' => array(
                'rule' => array('numeric',
                                false),
                'required' => true,
                'message' => 'numbers only')),
        'assigned_to' => array(
            'naturalNumber' => array(
                'rule' => array('numeric',
                                false),
                'required' => false,
                'allowEmpty' => true,
                'message' => 'numbers only'),
        )
    );


    public function findFilteredByProject($type, $options = array()) {
        if ($type == 'count' || $type == 'all') {
            $options = $this->filterParameters($options);

            if ($type == 'count') {
                $result = $this->find('count', $options);
            } else if ($type == 'all') {

                $options['fields'] = array(
                    'Request.id',
                    'Request.name',
                    'Request.type',
                    "CONCAT(Creator.firstname,' ', Creator.lastname) as creatorFullname",
                    'Request.created',
                    "CONCAT(Assigned.firstname,' ', Assigned.lastname) as assignedFullname",
                    'Request.status'
                );


                $result = $this->find('all', $options);
            }

            return $result;
        } else {
            throw new InvalidArgumentException();
        }

    }


    protected function filterParameters($options) {
        return $this->filterParametersForDatatableFind($options,
            array('assignedFullname' => array('Assigned.firstname',
                                              'Assigned.lastname'),
                  'creatorFullName' => array('Creator.firstname',
                                             'Creator.lastname')));


    }

}
