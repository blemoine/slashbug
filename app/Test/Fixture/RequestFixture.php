<?php

App::uses('Type', 'Model');
App::uses('Priority', 'Model');
App::uses('Status', 'Model');

class RequestFixture extends CakeTestFixture {

    public $import = array('model' => 'Request',
                           'records' => false);

    public $records = array(
        array('id' => 1000,
              'name' => 'test request 1',
              'description' => '<p>Description de ma demande</p>',
              'created_by' => 1,
              'project_id' => 1000,
              'type' => Type::BUG,
              'priority' => Priority::NORMAL,
              'status' => Status::IN_PROGRESS,
              'created' => '2012-02-12',
              'modified' => '2012-02-12'),
        array('id' => 1001,
              'name' => 'test request 2',
              'description' => '<p>Description de ma 2eme demande</p>',
              'created_by' => 1,
              'project_id' => 1000,
              'type' => Type::BUG,
              'priority' => Priority::NORMAL,
              'status' => Status::RESOLVED,
              'created' => '2012-02-12',
              'modified' => '2012-02-12'),
        array('id' => 1002,
              'name' => 'test request 3',
              'description' => '<p>Description de ma troisieme demande</p>',
              'created_by' => 1,
              'project_id' => 1000,
              'type' => Type::BUG,
              'priority' => Priority::NORMAL,
              'status' => Status::SENT,
              'created' => '2012-02-12',
              'modified' => '2012-02-12'),
    );

    public function create($db) {

    }

    public function drop($db) {
        $db->execute('DELETE FROM requests WHERE id >= 1000', array('log' => false));
    }
}
