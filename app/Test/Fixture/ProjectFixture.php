<?php

class ProjectFixture extends CakeTestFixture {

    public $import = array('model' => 'Project',
                           'records' => false);

    public $records = array(
        array('id' => 1000,
              'name' => 'testProject1',
              'description' => '<p>Description de mon projet</p>',
              'created' => '2012-02-12'),
        array('id' => 1001,
              'name' => 'testProject2',
              'description' => '<p>Description de mon second projet</p>',
              'created' => '2012-04-22')
    );


    public function create($db) {

    }

    public function drop($db) {
        $db->execute('DELETE FROM projects WHERE id >= 1000', array('log' => false));
    }
}
