<?php
/**
 * @property Project Project
 */
class ProjectTest extends CakeTestCase {


    public $fixtures = array(
        'app.project',
        'app.request'
    );

    public function setUp() {
        parent::setUp();
        $this->Project = ClassRegistry::init('Project');
    }

    public function testFindWithRequests_Count() {
        $result = $this->Project->findWithRequestsCount('count');
        $this->assertEqual($result, 2);
    }

    public function testFindWithRequests_All() {
        $result = $this->Project->findWithRequestsCount('all');
        $this->assertEqual($result, array(
                                         array('Project' => array('id' => 1000,
                                                                  'name' => 'testProject1',
                                                                  'created' => '2012-02-12 00:00:00'),
                                               0 => array('inProgress' => 1,
                                                          'done' => 1,
                                                          'total' => 3)),
                                         array('Project' => array('id' => 1001,
                                                                  'name' => 'testProject2',
                                                                  'created' => '2012-04-22 00:00:00'),
                                               0 => array('inProgress' => 0,
                                                          'done' => 0,
                                                          'total' => 0)),
                                    ));
    }


}