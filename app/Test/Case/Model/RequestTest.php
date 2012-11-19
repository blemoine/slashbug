<?php
/**
 * @property Request Request
 */
class RequestTest extends CakeTestCase {


    public $fixtures = array(
        'app.project',
        'app.request'
    );

    public function setUp() {
        parent::setUp();
        $this->Request = ClassRegistry::init('Request');
    }

    public function testFindFilteredByProject_Count() {
        $result = $this->Request->findFilteredByProject('count');
        $this->assertEqual($result, 3);
    }

    public function testFindFilteredByProject_All() {
        $result = $this->Request->findFilteredByProject('all');

        $this->assertEqual($result, array(
                                         array('Request' => array(
                                             'id' => 1000,
                                             'name' => "test request 1",
                                             'type' => Type::BUG,
                                             'created' => "2012-02-12 00:00:00",
                                             'status' => Status::IN_PROGRESS
                                         ),
                                               0 => array('creatorFullname' => "Admin Admin",
                                                          'assignedFullname' => NULL
                                               )

                                         ),
                                         array('Request' => array(
                                             'id' => 1001,
                                             'name' => "test request 2",
                                             'type' => Type::BUG,
                                             'created' => "2012-02-12 00:00:00",
                                             'status' => Status::RESOLVED
                                         ),
                                               0 => array('creatorFullname' => "Admin Admin",
                                                          'assignedFullname' => NULL
                                               )

                                         ),
                                         array('Request' => array(
                                             'id' => 1002,
                                             'name' => "test request 3",
                                             'type' => Type::BUG,
                                             'created' => "2012-02-12 00:00:00",
                                             'status' => Status::SENT
                                         ),
                                               0 => array('creatorFullname' => "Admin Admin",
                                                          'assignedFullname' => NULL
                                               )

                                         )
                                    ));
    }


}