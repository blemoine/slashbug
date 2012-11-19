<?php

$aaData = array();
foreach ($rows as $rawRow) {
    $row = array();

    $row[] = $rawRow['Project']['name'];
    $row[] = $this->Format->date($rawRow['Project']['created']);

    $row[] = $rawRow[0]['inProgress'];
    $row[] = $rawRow[0]['done'];
    $row[] = $rawRow[0]['total'];

    $aaData[] = $row;
}

echo $this->Datatable->jsonForDatatable($sEcho, $iTotal, $iFilteredTotal, $aaData);