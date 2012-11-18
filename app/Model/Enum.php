<?php
class Enum {

    public static function values() {
        return array_values(static::_hashmap());
    }

    public static function i18nList() {
        $constants = static::_hashmap();
        $result = array();
        foreach ($constants as $constant) {
            $result[$constant] = __($constant);
        }
        return $result;
    }

    private static function _hashmap() {
        $className = get_called_class();
        $refl = new ReflectionClass($className);
        return $refl->getConstants();
    }
}
