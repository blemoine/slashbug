<?php
App::uses('FormHelper', 'View/Helper');
/**
 * @property FormHelper Form
 */
class AFormHelper extends FormHelper {

    public static $IS_MCE_ALREADY_ADDED = false;
    public $defaultFormatDate = 'yy/mm/dd';

    public $helpers = array(
        'Html');

    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
        $this->defaultFormatDate = Configure::read('Config.l10nInfo')->jqueryFormatDate();
    }

    public function create($model = null, $options = array()) {
        $form = parent::create($model, $options);

        if (!isset($options['jQueryNoValidate'])) {
            if (isset($options['id'])) {
                $id = $options['id'];
            } else {
                $domId = isset($options['action']) ? $options['action'] : $this->request['action'];
                $id = $this->domId($domId.'Form');
            }

            $script = <<<SCRIPT
    jQuery(function() {

            jQuery('#$id').submit(function() {
                if(tinyMCE) {
                    tinyMCE.triggerSave();
                }
            });

            var validator = jQuery('#$id').validate();
            if(validator) {
                validator.focusInvalid = function() {
                // put focus on tinymce on submit validation
                    if( this.settings.focusInvalid ) {
                        try {
                            var toFocus = $(this.findLastActive() || this.errorList.length && this.errorList[0].element || []);
                            if (toFocus.is("textarea")) {
                                tinyMCE.get(toFocus.attr("id")).focus();
                            } else {
                                toFocus.filter(":visible").focus();
                            }
                        } catch(e) {
                            // ignore IE throwing errors when focusing hidden elements
                        }
                    }
                }
		    }
    });
SCRIPT;

            $this->Html->scriptBlock($script, array('inline' => false));
        }

        return $form;
    }

    public function endFormGrey($label) {
        $options = array('label' => $label,
                         'div' => array('class' => 'end-form-grey'));
        return parent::end($options);
    }

    public function ajaxSelect($fieldName, $source, $options = array()) {
        $url = $this->Html->url($source);

        $mockName = $fieldName.'Mock';
        $markup = $this->hidden($fieldName);
        $idHidden = $this->domId($fieldName);
        if ($this->isFieldError($fieldName)) {
            $entity = $this->entity();
            $model = array_shift($entity);
            if (!empty($entity) && isset($this->validationErrors[$model])) {
                $errors = $this->validationErrors[$model];
            }
            if (!empty($entity) && empty($errors)) {
                $errors = $this->_introspectModel($model, 'errors');
            }

            $errors = Set::classicExtract($errors, join('.', $entity));

            $this->validationErrors[$model][$mockName] = $errors;
        }

        $options['type'] = 'text';


        $markup .= $this->input($mockName, $options);
        $id = $this->domId($mockName);


        $script = <<<SCRIPT
jQuery(function() {
    if(jQuery('#$id').attr('readonly') != 'readonly') {
        jQuery('#$id').autocomplete({
            source: '$url',
            select:function(event, ui) {
                $('#$idHidden').val(ui.item.id);
            },
            change: function(event, ui) {
                if(ui.item) {
                    $('#$idHidden').val(ui.item.id);
                } else {
                    $('#$idHidden').val('');
                }
            }
        });
    }
});
SCRIPT;

        $this->Html->scriptBlock($script, array('inline' => false));

        return $markup;
    }

    public function datepicker($fieldName, $options = array()) {
        $input = $this->input($fieldName, $options);

        $id = $this->domId($fieldName);
        $currentYear = date('Y');

        $formatDate = isset($options['dateFormat']) ? $options['dateFormat'] : $this->defaultFormatDate;

        $script = <<<SCRIPT
jQuery(function() {
     $('#$id').datepicker({ dateFormat: "$formatDate", changeMonth: true, changeYear: true, yearRange: "1900:$currentYear" });
});
SCRIPT;

        $this->Html->scriptBlock($script, array('inline' => false));
        return $input;
    }

    public function textareaMce($fieldName, $options) {

        $lateBinding = false;
        if (isset($options['lateBinding'])) {
            $lateBinding = $options['lateBinding'];
            unset($options['lateBinding']);
        }

        $textarea = $this->input($fieldName, $options);
        $id = $this->domId($fieldName);

        $output = $textarea;

        $script = <<<SCRIPT
            jQuery(function() {
                $("#$id").addClass("mceEditor");
            });
SCRIPT;

        if ($lateBinding) {
            $output = '<script>'.$script.'</script>'.$output;
        } else {
            $this->Html->scriptBlock($script, array('inline' => false));
        }
        if ($lateBinding || !self::$IS_MCE_ALREADY_ADDED) {
            self::$IS_MCE_ALREADY_ADDED = true;

            $script = <<<SCRIPT
jQuery(function() {
            tinyMCE.init({
	          content_css : "../css/tinymce.css",
	          theme : "advanced",
			  plugins : "table,paste",
			  paste_remove_styles : true,
              onchange_callback: function(editor) {
			      tinyMCE.triggerSave();
			        },
                  mode:"specific_textareas",
                  editor_selector: "mceEditor",
                  theme_advanced_toolbar_location : "top",
                  theme_advanced_statusbar_location : "bottom",
                  theme_advanced_toolbar_align : "left",
                  theme_advanced_buttons1 : "bold,italic,underline,separator,forecolor,backcolor,separator,bullist,numlist,separator,outdent,indent,separator,undo,redo,separator,hr,removeformat",
                  theme_advanced_buttons2 : "sub,sup,separator,fontselect,fontsizeselect,separator,selectcharmap,separator,link,unlink,separator,pastetext,pasteword,selectall",
                  theme_advanced_buttons3 : "tablecontrols",
                  theme_advanced_fonts :
			        "Andale Mono=andale mono,times;"+
                	"Arial=arial,helvetica,sans-serif;"+
                	"Arial Black=arial black,avant garde;"+
                	"Book Antiqua=book antiqua,palatino;"+
                	"Comic Sans MS=comic sans ms,sans-serif;"+
                	"Courier New=courier new,courier;"+
                	"Georgia=georgia,palatino;"+
                	"Helvetica=helvetica;"+
                	"Impact=impact,chicago;"+
                	"Symbol=symbol;"+
                	"Tahoma=tahoma,arial,helvetica,sans-serif;"+
                	"Terminal=terminal,monaco;"+
                	"Times New Roman=times new roman,times;"+
                	"Trebuchet MS=trebuchet ms,geneva;"+
                	"Verdana=verdana,geneva;"+
                	"Webdings=webdings;"+
                	"Wingdings=wingdings,zapf dingbats",
                  theme_advanced_font_sizes : "10px,12px,14px,16px,18px,20px,22px,24px",
                  theme_advanced_text_colors : "ffd929,ff8e2a,ed3530,ffd7c6,fff18f,ceed40,95e070,60bb8b,bfd8f3,8bb9e8,4c7dae,2bb9ca,e3cae7,ca97d3,d397ac,b95377",
                  theme_advanced_background_colors : "ffd929,ff8e2a,ed3530,ffd7c6,fff18f,ceed40,95e070,60bb8b,bfd8f3,8bb9e8,4c7dae,2bb9ca,e3cae7,ca97d3,d397ac,b95377",
                  theme_advanced_more_colors : true,
                  width: 630,
                  height: 460,
				  invalid_elements : "img,embed,object,script"
        });
});
SCRIPT;
        }

        if ($lateBinding) {
            $output .= '<script>'.$script.'</script>';
        } else {
            $this->Html->scriptBlock($script, array('inline' => false));
        }
        return $output;
    }

    public function input($fieldName, $options = array()) {
        if (!isset($options['jQueryNoValidate'])) {
            $fieldNameForValidation = $fieldName;
            if (isset($options['fieldLinkedTo'])) {
                $fieldNameForValidation = $options['fieldLinkedTo'];
            }
            $this->setEntity($fieldNameForValidation);
            $modelKey = $this->model();
            $fieldKey = $this->field();
            if ($this->_introspectModel($modelKey, 'validates', $fieldKey)) {
                //Le champs obligatoire :
                if (!isset($options['type']) || ($options['type'] != 'checkbox' && $options['type'] != 'select')) {
                    $options['required'] = 'required';
                }
                if (isset($options['fieldLinkedTo'])) {
                    $options['div'] = array('class' => 'input text required');
                }
                if (!isset($options['type'])) {
                    $object = $this->_getModel($modelKey);

                    $validateProperties = $object->validate[$fieldKey];

                    if ($validateProperties && $this->_isEmailField($validateProperties)) {
                        $options['type'] = 'email';
                    }

                }
            }

        }
        if (isset($options['fieldLinkedTo'])) {
            unset($options['fieldLinkedTo']);
        }
        return parent::input($fieldName, $options);
    }

    protected function _isEmailField($validateProperties) {

        if ($validateProperties === 'email') {
            return true;
        }

        if (is_array($validateProperties)) {

            $dims = Set::countDim($validateProperties);
            if ($dims == 1 || ($dims == 2 && isset($validateProperties['rule']))) {
                $validateProperties = array($validateProperties);
            }
            foreach ($validateProperties as $rule => $validateProp) {
                $rule = isset($validateProp['rule']) ? $validateProp['rule'] : false;

                if ($rule === 'email') {
                    return true;
                }

            }
        }

        return false;
    }

    protected function _introspectModel($model, $key, $field = null) {
        if (substr($field, -4) == 'Mock') {
            $field = substr($field, 0, -4);
        }
        return parent::_introspectModel($model, $key, $field);
    }
}
