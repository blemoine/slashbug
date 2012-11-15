<?php

class L10nInfo {

    public static $DEFAULT_LANGUAGE_CONFIGURATION = array('en' => array('d/m/Y',
                                                                        'eng'),
                                                          'fr' => array('d/m/Y',
                                                                        'fra'));

    public $lang;
    public $isoLang;

    public $dateFormat;

    private function __construct($lang, $isoLang, $dateFormat) {
        $this->lang = $lang;
        $this->dateFormat = $dateFormat;
        $this->isoLang = $isoLang;
    }

    public function dateStrToSql($dateStr) {
        if ($dateStr == null) {
            return null;
        }
        $date = DateTime::createFromFormat($this->dateFormat, $dateStr);
        if ($date == null) {
            return null;
        }
        return $date->format('Y-m-d');
    }

    public function jqueryFormatDate() {
        $replaceArray = array('Y' => 'yy',
                              'm' => 'mm',
                              'd' => 'dd');
        return str_replace(array_keys($replaceArray), array_values($replaceArray), $this->dateFormat);
    }

    public static function create($lang) {
        if (!isset(self::$DEFAULT_LANGUAGE_CONFIGURATION[$lang])) {
            throw new InvalidArgumentException("The language $lang isn't properly configured");
        }
        $config = self::$DEFAULT_LANGUAGE_CONFIGURATION[$lang];
        return new L10nInfo($lang, $config[1], $config[0]);
    }
}

