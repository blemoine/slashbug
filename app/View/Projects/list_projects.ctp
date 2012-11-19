<?php

$aaData = array();
foreach ($rows as $rawRow) {
    $row = array();

    $row[] = $this->Html->link($rawRow['Project']['name'],array('controller'=>'requests','action'=>'index',$rawRow['Project']['id']));
    $row[] = $this->Format->date($rawRow['Project']['created']);

    $row[] = $rawRow[0]['inProgress'];
    $row[] = $rawRow[0]['done'];
    $row[] = $rawRow[0]['total'];

    $aaData[] = $row;
}

echo $this->Datatable->jsonForDatatable($sEcho, $iTotal, $iFilteredTotal, $aaData);