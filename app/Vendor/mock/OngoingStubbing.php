<?php
class OngoingStubbing {

    private $call;
    private $nbTime;

    public function __construct(MethodCall $call, $nbTime = 1) {
        $this->call = $call;
        $this->nbTime = $nbTime;
    }

    public function thenReturn($value) {
        $this->_thenReturn(new PHPUnit_Framework_MockObject_Stub_Return($value), new PHPUnit_Framework_MockObject_Matcher_InvokedCount($this->nbTime));
    }

    public function thenAnswer($callable) {
        $this->_thenReturn(new PHPUnit_Framework_MockObject_Stub_ReturnCallback($callable), new PHPUnit_Framework_MockObject_Matcher_InvokedCount($this->nbTime));
    }

    protected function _thenReturn(PHPUnit_Framework_MockObject_Stub $stub, PHPUnit_Framework_MockObject_Matcher_Invocation $matcher) {
        $this->call->mustReturn($stub, $matcher);
    }
}

