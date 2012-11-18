<?php
App::uses('ComponentCollection', 'Controller');
App::uses('DatatableComponent', 'Controller/Component');

class DatatableComponentTest extends CakeTestCase {

    private $datatableComponent = null;


    public function setUp() {
        parent::setUp();
        // Setup our component and fake test controller
        $Collection = new ComponentCollection();
        $this->datatableComponent = new DatatableComponent($Collection);
    }

    public function testInitDatatablePropertiesNominalEmptyQuery() {
        $query = array('sEcho' => 2);
        $columns = array();
        $model = $this->getMock('Model', array('find'));
        $model->name = 'model';

        $stub = $model->expects($this->exactly(3))->method('find');
        $stub->with($this->logicalOr($this->equalTo('all'), $this->equalTo('count')), $this->anything());
        $stub->will($this->returnCallback(function($type, $options) {

            if ($type == 'count') {
                return 5;
            } else if ($type == 'all') {
                return array(
                    'da',
                    'da2');
            } else {
                throw new Exception('Parameters invalid '.$type." ::".$options);
            }
        }));

        $result = $this->datatableComponent->initDatatableProperties($query, $columns, $model);

        $this->assertEqual(count($result), 6);
        $this->assertEqual($result['sEcho'], 2);
        $this->assertEqual($result['iTotal'], 5);
        $this->assertEqual($result['iFilteredTotal'], 5);
        $this->assertEqual($result['rows'], array(
                                                 'da',
                                                 'da2'));
        $this->assertEqual($result['columns'], $columns);
        $this->assertEqual($result['modelName'], 'model');
    }

    public function testInitDatatablePropertiesNominalQueryLimitAndSort() {
        $query = array(
            'sEcho' => 2,
            'iDisplayStart' => 25,
            'iDisplayLength' => 10,
            'iSortingCols' => '2',
            'iSortCol_0' => 0,
            'iSortCol_1' => 1,
            'bSortable_0' => 'true',
            'bSortable_1' => 'true',
            'sSortDir_0' => 'desc',
            'sSortDir_1' => 'asc');
        $columns = array(
            'name',
            'age');
        $model = $this->getMock('Model', array('find'));
        $model->name = 'model';

        $stub = $model->expects($this->exactly(3))->method('find');
        $stub->with($this->logicalOr($this->equalTo('all'), $this->equalTo('count')), $this->anything());
        $stub->will($this->returnCallback(function($type, $options) {

            if ($type == 'count') {
                return 5;
            } else if ($type == 'all' && $options['offset'] == 25 && $options['limit'] == 10 && $options['order'][0] == 'name desc' && $options['order'][1] == 'age asc') {
                return array(
                    'da',
                    'da2');
            } else {
                throw new Exception('Parameters invalid '.$type." ::".print_r($options, 1));
            }
        }));

        $result = $this->datatableComponent->initDatatableProperties($query, $columns, $model);

        $this->assertEqual(count($result), 6);
        $this->assertEqual($result['sEcho'], 2);
        $this->assertEqual($result['iTotal'], 5);
        $this->assertEqual($result['iFilteredTotal'], 5);
        $this->assertEqual($result['rows'], array(
                                                 'da',
                                                 'da2'));
        $this->assertEqual($result['columns'], $columns);
        $this->assertEqual($result['modelName'], 'model');
    }

    public function testInitDatatablePropertiesNominalQueryWithFilter() {
        $query = array(
            'sEcho' => 2,
            'sSearch' => 'FR');
        $columns = array(
            'age',
            'name');
        $model = $this->getMock('Model', array('find'));
        $model->name = 'model';

        $stub = $model->expects($this->exactly(3))->method('find');
        $stub->with($this->logicalOr($this->equalTo('all'), $this->equalTo('count')), $this->anything());
        $stub->will($this->returnCallback(function($type, $options) {

            if ($type == 'count' && empty($options)) {
                return 5;
            } else if ($type == 'count' && $options['conditions']['OR']['name LIKE'] == '%FR%' && $options['conditions']['OR']['age LIKE'] == '%FR%') {
                return 4;
            } else if ($type == 'all' && $options['conditions']['OR']['name LIKE'] == '%FR%' && $options['conditions']['OR']['age LIKE'] == '%FR%') {
                return array(
                    'da',
                    'da2');
            } else {
                throw new Exception('Parameters invalid '.$type." ::".$options);
            }
        }));

        $result = $this->datatableComponent->initDatatableProperties($query, $columns, $model);

        $this->assertEqual(count($result), 6);
        $this->assertEqual($result['sEcho'], 2);
        $this->assertEqual($result['iTotal'], 5);
        $this->assertEqual($result['iFilteredTotal'], 4);
        $this->assertEqual($result['rows'], array(
                                                 'da',
                                                 'da2'));
        $this->assertEqual($result['columns'], $columns);
        $this->assertEqual($result['modelName'], 'model');
    }

    public function testInitDatatablePropertiesCustomFindMethod() {
        $query = array('sEcho' => 2);
        $columns = array();
        $model = $this->getMock('Model', array('find',
                                               'findCustom'));
        $model->name = 'model';

        $stub = $model->expects($this->exactly(2))->method('findCustom');
        $stub->with($this->logicalOr($this->equalTo('all'), $this->equalTo('count')), $this->anything());
        $stub->will($this->returnCallback(function($type, $options) {

            if ($type == 'count') {
                return 5;
            } else if ($type == 'all') {
                return array(
                    'da',
                    'da2');
            } else {
                throw new Exception('Parameters invalid '.$type." ::".$options);
            }
        }));


        $stub = $model->expects($this->once())->method('find');
        $stub->with($this->equalTo('count'), $this->anything());
        $stub->will($this->returnValue(8));

        $result = $this->datatableComponent->initDatatableProperties($query, $columns, $model, array('findMethod' => 'findCustom'));

        $this->assertEqual(count($result), 6);
        $this->assertEqual($result['sEcho'], 2);
        $this->assertEqual($result['iTotal'], 8);
        $this->assertEqual($result['iFilteredTotal'], 5);
        $this->assertEqual($result['rows'], array(
                                                 'da',
                                                 'da2'));
        $this->assertEqual($result['columns'], $columns);
        $this->assertEqual($result['modelName'], 'model');
    }

    public function testInitDatatableProperties_withIgnore() {
        $query = array('sEcho' => 2,
                       'sSearch' => 'da');
        $columns = array('myColonne',
                         'pasMyColonne');
        $model = $this->getMock('Model', array('find'));
        $model->name = 'model';

        $stub = $model->expects($this->exactly(3))->method('find');
        $stub->with($this->logicalOr($this->equalTo('all'), $this->equalTo('count')), $this->anything());
        $stub->will($this->returnCallback(function($type, $options) {

            if ($type == 'count') {
                return 5;
            } else if ($type == 'all' && isset($options['conditions']['OR']['pasMyColonne LIKE']) && !isset($options['conditions']['OR']['myColonne LIKE'])) {
                return array(
                    'da',
                    'da2');
            } else {
                throw new Exception('Parameters invalid '.$type." ::".print_r($options, true));
            }
        }));

        $result = $this->datatableComponent->initDatatableProperties($query, $columns, $model, array('ignore' => array('myColonne')));

        $this->assertEqual(count($result), 6);
        $this->assertEqual($result['sEcho'], 2);
        $this->assertEqual($result['iTotal'], 5);
        $this->assertEqual($result['iFilteredTotal'], 5);
        $this->assertEqual($result['rows'], array(
                                                 'da',
                                                 'da2'));
        $this->assertEqual($result['columns'], $columns);
        $this->assertEqual($result['modelName'], 'model');
    }

    public function tearDown() {
        parent::tearDown();
        // Clean up after we're done
        unset($this->datatableComponent);
    }
}
