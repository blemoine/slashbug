<?php

class DatatableHelper extends AppHelper {

    private static $SCRIPT_ALREADY_ADDED = false;

    public $helpers = array(
        'Html');

    public function create($id, $url) {
        if (!self::$SCRIPT_ALREADY_ADDED) {
            $this->Html->script('Datatable.jquery.dataTables.js', array('inline' => false));
        }

        $urlFinal = $this->Html->url($url);

        $script = <<<SCRIPT
$(function () {
    $('#$id').dataTable({
        "bProcessing":true,
        "bJQueryUI":true,
        "bServerSide":true,
        "sAjaxSource":'$urlFinal',
        "aoColumnDefs":[]
    });
});
SCRIPT;

        $this->Html->scriptBlock($script, array('inline' => false));
        self::$SCRIPT_ALREADY_ADDED;
    }

    public function jsonForDatatable($sEcho, $iTotal, $iFilteredTotal, $aaData) {
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => $aaData);

        return json_encode($output);
    }
}
