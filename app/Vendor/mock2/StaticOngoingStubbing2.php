<?php

class StaticOngoingStubbing2 extends OngoingStubbing2 {

    protected function _mustReturn(PHPUnit_Framework_MockObject_Stub $stub, PHPUnit_Framework_MockObject_Matcher_Invocation $matcher) {
        $this->call->mustReturn($stub, $matcher, true);
    }
}
