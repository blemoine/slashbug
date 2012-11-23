<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'Mock2', array('file' => 'mock2/Mock2.php'));
App::import('Vendor', 'PHPUnit_Framework_Constraint_Callback', array('file' => 'phpunit/PHPUnit_Framework_Constraint_Callback.php'));

abstract class AppControllerTest extends ControllerTestCase {

    public function setUp() {
        parent::setUp();
        CakePlugin::load('Datatable');
        CakePlugin::load('Less');

        $modelDescription = $this->getModelsDescription();
        $this->controller = $this->generate($this->getControllerName(), array('components' => array('Auth' => $this->getAuthMocKMethods())));
        foreach ($modelDescription as $modelName) {
            ClassRegistry::init($modelName);
            $this->$modelName = new Mock2($modelName, array(array('name' => $modelName)));
        }
        foreach ($this->getComponentsDescription() as $componentName) {
            if (is_array($componentName)) {
                $componentName = $componentName[0];
                $plugin = $componentName[1].'/';
            } else {
                $plugin = '';
            }

            App::uses($componentName.'Component', $plugin.'Controller/Component');
            $this->$componentName = new Mock2($componentName.'Component', array(new ComponentCollection()));
        }

        $lang = 'en';
        App::uses('L10nInfo', 'I18n');
        $l10nInfo = L10nInfo::create($lang);
        Configure::write('Config.language', $l10nInfo->isoLang);
        Configure::write('Config.l10nInfo', $l10nInfo);
    }

    protected function _testAction($url = '', $options = array()) {
        $modelsDescription = $this->getModelsDescription();
        if (!empty($modelsDescription)) {
            foreach ($modelsDescription as $modelName) {
                $this->controller->$modelName = $this->$modelName->__instrument();
            }
        }
        $componentDescription = $this->getComponentsDescription();
        if (!empty($componentDescription)) {
            foreach ($componentDescription as $componentName) {
                if (is_array($componentName)) {
                    $componentName = $componentName[0];
                }

                $this->controller->Components->set($componentName, $this->$componentName->__instrument());
                $this->controller->constructClasses();
            }
        }

        parent::_testAction($url, $options);
    }

    protected function expectFlashSuccess() {
        Mock2::when($this->Session->setFlash($this->anything(), 'default-alert-success'));
    }

    protected function expectFlashError() {
        Mock2::when($this->Session->setFlash($this->anything(), 'default-alert-error'));
    }

    protected function getComponentsDescription() {
        return array('Session');
    }

    //FIXME backport !!!
    public static function callback($callback) {
        return new PHPUnit_Framework_Constraint_Callback($callback);
    }

    protected abstract function getControllerName();

    protected abstract function getModelsDescription();

    protected function getAuthMocKMethods() {
        return array();
    }

}