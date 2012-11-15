<?php

App::uses('Model', 'Model');

class AppModel extends Model {

    public function inEnum($check, $enumName) {
        // $check will have value: array('fieldName' => 'some-value')
        reset($check);
        $value = current($check);

        try {
            $enumValues = $enumName::values();
            return in_array($value, $enumValues);
        } catch (MissingTableException $e) {
            throw new InvalidArgumentException("$enumName must have a static function values, or extend Enum", null,$e);
        }
    }
}
