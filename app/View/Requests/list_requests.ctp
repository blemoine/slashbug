<?php

$aaData = array();
foreach ($rows as $rawRow) {
    $row = array();

    $row[] = $this->Html->link($rawRow['Request']['name'], array('controller' => 'requests',
                                                                 'action' => 'edit',
                                                                 $rawRow['Request']['id']));
    $row[] = __($rawRow['Request']['type']);
    $row[] = $rawRow[0]['creatorFullname'];
    $row[] = $this->Format->date($rawRow['Request']['created']);

    $row[] = $rawRow[0]['assignedFullname'];

    $row[] = __($rawRow['Request']['status']);

    $aaData[] = $row;
}

echo $this->Datatable->jsonForDatatable($sEcho, $iTotal, $iFilteredTotal, $aaData);