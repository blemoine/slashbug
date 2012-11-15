<?php
/**
 * @property TimeHelper Time
 */
class FormatHelper extends AppHelper {

    public $helpers = array('Time');

    public function boolean($boolean, $trueValue = null, $falseValue = null) {
        if (!isset($trueValue)) {
            $trueValue = __('true');
        }

        if (!isset($falseValue)) {
            $falseValue = __('false');
        }
        return (isset($boolean) && $boolean) ? $trueValue : $falseValue;
    }

    public function today() {
        $l10n = Configure::read('Config.l10nInfo');
        return date($l10n->dateFormat);
    }

    public function date($date, $format = null) {
        if (!isset($format)) {
            $l10n = Configure::read('Config.l10nInfo');
            $format = $l10n->dateFormat;
        }

        return $this->Time->format($format, $date);
    }

}