<?php

class LessHelper extends AppHelper {

    public $helpers = array('Html');

    public function less($path, $rel = null, $options = array()) {
        if (Configure::read('debug') > 0) {
            App::import('Vendor', 'Less.lessphp', array('file' => 'lessphp'.DS.'lessc.inc.php'));

            $LESS_URL = WWW_ROOT.DS.'less';

            if (strpos($path, '//') !== false) {
                $url = $path;
            } else {
                $url = $LESS_URL.DS.$path.'.less';
            }

            $cssUrl = str_replace(DS.'less', DS.'css', $url);
            $cssUrl = str_replace('.less', '.css', $cssUrl);
            lessc::ccompile($url, $cssUrl);
        }
        return $this->Html->css($path);
    }
}
