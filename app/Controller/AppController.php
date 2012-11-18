<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $helpers = array(
        'Html',
        'Session',
        'Less.Less',
        'AForm',
        'Format');

    protected function errorMessageForModel(Model $model) {
        $errorString = '';
        foreach ($model->validationErrors as $field => $errors) {
            $formattedField = str_replace('_id', '', $field);
            $errorString .= __('Field ').'"'.$formattedField.'"'.__(' has error: ').implode(',', $errors).'<br />';
        }
        return __('Unable to add your ').get_class($model).'<br />'.$errorString;
    }

    protected function setFlashSuccess($message) {
        $this->Session->setFlash($message, 'default-alert-success');
    }

    protected function setFlashError($message) {
        $this->Session->setFlash($message, 'default-alert-error');
    }

    protected function setFlashErrorForModel(Model $model) {
        $this->setFlashError($this->errorMessageForModel($model));
    }


}
