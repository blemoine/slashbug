<?php
require_once __DIR__.'/MethodCall2.php';
require_once __DIR__.'/OngoingStubbing2.php';
require_once __DIR__.'/StaticOngoingStubbing2.php';

class Mock2 {

    private $mockClassName;
    private $constructorParameters = array();
    private $expectedCall = array();

    public function __construct($mockClassName, array $constructorParameters = array()) {
        $this->mockClassName = $mockClassName;
        $this->constructorParameters = $constructorParameters;
    }

    public static function when(MethodCall2 $call, $nbTime = 1) {
        $matcher = self::nbTimeToMatcher($nbTime);
        return new OngoingStubbing2($call, $matcher);
    }

    public static function expect(MethodCall2 $call, $nbTime = 1) {
        $matcher = self::nbTimeToMatcher($nbTime);
        $ongoing = new OngoingStubbing2($call, $matcher);
        $ongoing->thenReturn(null);
    }

    public static function nbTimeToMatcher($nbTime) {
        if (is_numeric($nbTime)) {
            $matcher = new PHPUnit_Framework_MockObject_Matcher_InvokedCount($nbTime);
        } else if ($nbTime instanceof PHPUnit_Framework_MockObject_Matcher_Invocation) {
            $matcher = $nbTime;
        }
        return $matcher;
    }

    public static function staticWhen(MethodCall2 $call, $nbTime = 1) {
        $matcher = self::nbTimeToMatcher($nbTime);

        return new StaticOngoingStubbing2($call, $matcher);
    }

    public function __call($methodName, $arguments) {
        $arguments = array_map(array($this,
                                     'getMatcherForArgument'), $arguments);
        return new MethodCall2($this, $methodName, $arguments);
    }


    protected function getMatcherForArgument($arg) {
        if ($arg instanceof PHPUnit_Framework_Constraint) {
            return $arg;
        } else {
            return PHPUnit_Framework_Assert::equalTo($arg);
        }
    }

    public function __addExpectedCall(MethodCall2 $call) {
        $this->expectedCall[] = $call;
    }

    public function __instrument() {
        $methods = array_map(function($call) {
            return $call->methodName;
        }, $this->expectedCall);
        $mock = PHPUnit_Framework_MockObject_Generator::getMock($this->mockClassName, $methods, $this->constructorParameters);

        foreach ($this->expectedCall as $call) {
            $call->__instrument($mock);
        }

        return $mock;
    }

}
