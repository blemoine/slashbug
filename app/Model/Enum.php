<?php
class Enum {

    public static function values() {
        $className = get_called_class();
        $refl = new ReflectionClass($className);
        return array_values($refl->getConstants());
    }

    public static function i18nList() {
        $className = get_called_class();
        $refl = new ReflectionClass($className);
        $constants = $refl->getConstants();
        $result = array();
        foreach ($constants as $constant) {
            $result[$constant] = __($constant);
        }
        return $result;
    }
}
