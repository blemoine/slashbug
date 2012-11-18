<?php
class DatatableBehavior extends ModelBehavior {


    public function filterParametersForDatatableFind(Model $model, array $options, array $forbiddenConditionFields = array(), array $forbiddenOrderFields = array()) {
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