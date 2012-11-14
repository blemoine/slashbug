<?php

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
}
