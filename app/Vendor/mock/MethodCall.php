<?php
class MethodCall {

    private $mock;
    private $methodName;
    private $arguments;

    public function __construct(Mock $mock, $methodName, array $arguments) {
        $this->mock = $mock;
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    public function mustReturn(PHPUnit_Framework_MockObject_Stub $stub, PHPUnit_Framework_MockObject_Matcher_Invocation $matcher) {

        $arguments = array_map(array($this,
                                     'getMatcherForArgument'), $this->arguments);


        $this->mock->_instrument($matcher, $this->methodName, $arguments, $stub);

    }

    protected function getMatcherForArgument($arg) {
        if ($arg instanceof PHPUnit_Framework_Constraint) {
            return $arg;
        } else {
            return PHPUnit_Framework_Assert::equalTo($arg);
        }
    }
}
