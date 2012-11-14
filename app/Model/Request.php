<?php

class Request extends AppModel {

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
                'message' => 'A type is required')),
        'priority' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A priority is required')),
        'status' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A status is required')),
        'minute_spent' => array(
            'naturalNumber' => array(
                'rule' => array('naturalNumber',
                                false),
                'required' => true,
                'message' => 'numbers only')),
        'assigned_to' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A creator is required'),
            'naturalNumber' => array(
                'rule' => array('naturalNumber',
                                false),
                'required' => true,
                'message' => 'numbers only'),
        )
    );
}
