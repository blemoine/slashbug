<?php

$aaData = array();
foreach ($rows as $rawRow) {
    $row = array();

    $row[] = $rawRow['User']['firstname'];
    $row[] = $rawRow['User']['lastname'];
    $row[] = $rawRow['User']['username'];
    $row[] = $rawRow['User']['email'];
    $row[] = __($rawRow['User']['usertype']);

    $aaData[] = $row;
}

echo $this->Datatable->jsonForDatatable($sEcho, $iTotal, $iFilteredTotal, $aaData);