<?php

class OngoingStubbing2 {

    protected $call;
    protected $matcher;

    public function __construct(MethodCall2 $call, PHPUnit_Framework_MockObject_Matcher_Invocation $matcher) {
        $this->call = $call;
        $this->matcher = $matcher;
    }

    public function thenReturn($value) {
        $this->_mustReturn(new PHPUnit_Framework_MockObject_Stub_Return($value), $this->matcher);
    }

    public function thenAnswer($callable) {
        $this->_mustReturn(new PHPUnit_Framework_MockObject_Stub_ReturnCallback($callable), $this->matcher);
    }

    protected function _mustReturn(PHPUnit_Framework_MockObject_Stub $stub, PHPUnit_Framework_MockObject_Matcher_Invocation $matcher) {
        $this->call->mustReturn($stub, $matcher);
    }
}
