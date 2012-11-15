<?php
class DatatableComponent extends Component {

    public function initDatatableProperties(array $query, array $columns, Model $model, array $configuration = array()) {

        $options = array();
        if (isset($query['iDisplayStart']) && $query['iDisplayLength'] != '-1') {
            $options['offset'] = (int) $query['iDisplayStart'];
            $options['limit'] = (int) $query['iDisplayLength'];
        }

        $sort = $this->createQuerySort($query, $columns);
        if (!empty($sort)) {
            $options['order'] = $sort;
        }
        $where = $this->createQueryCondition($query, $columns, $configuration);


        $iTotal = $model->find('count');
        $options['conditions'] = $where;

        if (isset($configuration['findMethod'])) {
            $findMethod = $configuration['findMethod'];
        } else {
            $findMethod = 'find';
        }

        $iFilteredTotal = $model->$findMethod('count', array('conditions' => $where));
        $elementsFound = $model->$findMethod('all', $options);
        return array(
            'sEcho' => intval($query['sEcho']),
            'iTotal' => $iTotal,
            'iFilteredTotal' => $iFilteredTotal,
            'rows' => $elementsFound,
            'columns' => $columns,
            'modelName' => $model->name);
    }

    protected function createQuerySort(array $query, array $columns) {
        if (isset($query['iSortCol_0'])) {

            $order = array();

            $sortingColsNumber = intval($query['iSortingCols']);
            for ($i = 0; $i < $sortingColsNumber; ++$i) {
                $sortingColumnIndex = intval($query['iSortCol_'.$i]);
                if ($query['bSortable_'.$sortingColumnIndex] == "true") {

                    $sortingCol = $columns[$sortingColumnIndex];
                    $order[] = $sortingCol.' '.$query['sSortDir_'.$i];
                }
            }
            return $order;
        }
        return null;
    }

    protected function createQueryCondition(array $query, array $columns, array $configuration) {
        $ignore = array();
        if (isset($configuration['ignore'])) {
            $ignore = $configuration['ignore'];
        }

        $where = array();
        if (isset($query['sSearch']) && $query['sSearch'] != "") {
            $where['OR'] = array();
            $numberOfColumns = count($columns);
            for ($i = 0; $i < $numberOfColumns; $i++) {
                $filterCol = $columns[$i];
                if (!in_array($filterCol, $ignore)) {
                    $where['OR'][$filterCol." LIKE"] = '%'.$query['sSearch'].'%';
                }
            }
        }
        return $where;
    }

}