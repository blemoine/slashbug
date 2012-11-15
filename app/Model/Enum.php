<?php
class Enum {

    public static function values() {
        $className = get_called_class();
        $refl = new ReflectionClass($className);
        return array_values($refl->getConstants());
    }
}
