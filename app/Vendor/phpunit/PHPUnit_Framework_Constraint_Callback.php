<?php
class PHPUnit_Framework_Constraint_Callback extends PHPUnit_Framework_Constraint {
    private $callback;

    /**
     * @param callable $value
     * @throws InvalidArgumentException
     */
    public function __construct($callback) {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Specified callback <%s> is not callable.',
                    $this->callbackToString($callback)
                )
            );
        }
        $this->callback = $callback;
    }

 /**
     * Evaluates the constraint for parameter $value. Returns TRUE if the
     * constraint is met, FALSE otherwise.
     *
     * @param mixed $value Value or object to evaluate.
     * @return bool
     */
    protected function matches($other) {
        return call_user_func($this->callback, $other);
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString() {
        return 'is accepted by specified callback';
    }

  private function callbackToString($callback) {
        if (!is_array($callback)) {
            return $callback;
        }
        if (empty($callback)) {
            return "empty array";
        }
        if (!isset($callback[0]) || !isset($callback[1])) {
            return "array without indexes 0 and 1 set";
        }
        if (is_object($callback[0])) {
            $callback[0] = get_class($callback[0]);
        }
        return $callback[0].'::'.$callback[1];
    }

}

