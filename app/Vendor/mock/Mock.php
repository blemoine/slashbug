<?php

require_once __DIR__.'/MethodCall.php';
require_once __DIR__.'/OngoingStubbing.php';
/**
 * Classe destinée à la simplification de création de mock avec PHPUnit.
 * La syntaxe utilisée s'approche de celle de <a href="http://code.google.com/p/mockito/" >Mockito </a>
 *
 * Il est indispensable d'avoir préchargé les classes de PHPUnit.
 *
 * Pour l'utiliser il faut ensuite "wrapper" le mock PHPUnit
 * et utiliser la méthode when pour décrire un stub
 *
 *
 * <code><pre>
 * $mock = new Mock($phpunitMock);
 * Mock::when($mock->maMethode($monParametre))->thenReturn($maValeurDeRetour);
 * // Equivalent à $mock->expects($this->once())->method('maMethode')->with($this->equalTo($monParametre)->will($this->returnValue($maValeurDeRetour));
 * </pre></code>
 *
 */
class Mock {

    private $mock;
    private $constructorParameters;
    private $_lateMock;

    /**
     * Construit un nouveau wrapper d'objet de mock PHPUnit
     * @param $mock doit être un mock PHPUnit
     */
    public function __construct($mock, array $constructorParameters = array()) {
        $this->mock = $mock;
        $this->constructorParameters = $constructorParameters;
    }

    /**
     * La méthode statique permettant de stubber l'appel.
     * @param MethodCall $call l'appel de méthode généré par un appel sur le Mock
     * @param $nbTime = 1. Si on passe un chiffre, attend exactement ce nombre d'appel à la méthode. Il est possible de passer un matcher PHPUnit
     */
    public static function when(MethodCall $call, $nbTime = 1) {
        return new OngoingStubbing($call, $nbTime);
    }

    public static function expects(MethodCall $call, $nbTime = 1) {
        $stub = new OngoingStubbing($call, $nbTime);
        return $stub->thenReturn(null);
    }


    public function __call($methodName, $arguments) {
        return new MethodCall($this, $methodName, $arguments);
    }

    public function _instrument(PHPUnit_Framework_MockObject_Matcher_Invocation $matcher, $methodName, array $arguments, PHPUnit_Framework_MockObject_Stub $stub) {
        $mockArguments = array('matcher' => $matcher,
                               'methodName' => $methodName,
                               'arguments' => $arguments,
                               'stub' => $stub);

        if (is_string($this->mock)) {
            $this->_lateMock[] = $mockArguments;
        } else {

            $this->__instrument($this->mock, $mockArguments);
        }
    }

    private function __instrument($mock, array $mockArgument) {
        $ongoingMock = $mock
            ->expects($mockArgument['matcher'])
            ->method($mockArgument['methodName']);


        call_user_func_array(array($ongoingMock,
                                   'with'), $mockArgument['arguments']);

        $ongoingMock->will($mockArgument['stub']);
    }

    public function flushLateMock() {
        if (is_string($this->mock)) {
            $methods = array_map(function($value) {
                return $value['methodName'];
            }, $this->_lateMock);
            $mock = PHPUnit_Framework_MockObject_Generator::getMock($this->mock, $methods, $this->constructorParameters);

            foreach ($this->_lateMock as $lateMock) {
                $this->__instrument($mock, $lateMock);
            }
            return $mock;
        }
        return null;
    }

}

