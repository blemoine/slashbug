<?php

class MethodCall2 {

    private $mock;
    public $methodName;
    private $arguments;
    private $stub;
    private $matcher;
    private $static;


    public function __construct(Mock2 $mock, $methodName, array $arguments) {
        $this->mock = $mock;
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }


    public function mustReturn(PHPUnit_Framework_MockObject_Stub $stub, PHPUnit_Framework_MockObject_Matcher_Invocation $matcher, $static = false) {
        $this->stub = $stub;
        $this->matcher = $matcher;
        $this->static = $static;
        $this->mock->__addExpectedCall($this);
    }

    public function __instrument($phpUnitMock) {

        if (!$this->static) {
            $ongoingMock = $phpUnitMock->expects($this->matcher);
        } else {
            $ongoingMock = $phpUnitMock->staticExpects($this->matcher);
        }

        $ongoingMock = $ongoingMock->method($this->methodName);


        call_user_func_array(array($ongoingMock,
                                   'with'), $this->arguments);

        $ongoingMock->will($this->stub);
    }


}
