<?php
class DatatableBehavior extends ModelBehavior {

    public function customFindMethod(Model $model, $type, array $options, array $fields, array $forbiddenConditionFields = array(), array $forbiddenOrderFields = array()) {
        if ($type == 'count' || $type == 'all') {
            $options = $this->filterParametersForDatatableFind($options, $forbiddenConditionFields, $forbiddenOrderFields);

            if ($type == 'count') {
                $result = $model->find('count', $options);
            } else if ($type == 'all') {

                $options['fields'] = $fields;

                $result = $model->find('all', $options);
            }

            return $result;
        } else {
            throw new InvalidArgumentException();
        }
    }

    protected function filterParametersForDatatableFind(array $options, array $forbiddenConditionFields = array(), array $forbiddenOrderFields = array()) {
        if (isset($options['conditions']) && isset($options['conditions']['OR'])) {

            foreach ($forbiddenConditionFields as $field => $remplacement) {
                if (is_int($field)) {
                    $field = $remplacement;
                }
                foreach ($options['conditions']['OR'] as $key => $condition) {
                    if (strpos($key, $field) !== false) {
                        unset($options['conditions']['OR'][$key]);
                        if ($remplacement != null && $field != $remplacement) {
                            if (is_string($remplacement)) {
                                $remplacement = array($remplacement);
                            }
                            foreach ($remplacement as $repName) {
                                $options['conditions']['OR'][str_replace($field, $repName, $key)] = $condition;
                            }
                        }
                    }
                }
            }
            if (empty($options['conditions']['OR'])) {
                unset($options['conditions']['OR']);
            }
        }

        if (isset($options['order'])) {
            foreach ($forbiddenOrderFields as $field => $remplacement) {
                if (is_int($field)) {
                    $field = $remplacement;
                }
                foreach ($options['order'] as $index => $order) {
                    if (strpos($order, $field) !== false) {
                        unset($options['order'][$index]);
                        if ($remplacement != null && $field != $remplacement) {
                            if (is_string($remplacement)) {
                                $remplacement = array($remplacement);
                            }
                            foreach ($remplacement as $repName) {
                                $options['order'][] = str_replace($field, $repName, $order);
                            }
                        }
                    }
                }
            }
        }

        return $options;
    }
}