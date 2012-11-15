<?php
$output = array(
    "sEcho" => $sEcho,
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array());

foreach ($rows as $rawRow) {
    $row = array();

    $row[] = $rawRow['Request']['name'];
    $row[] = __($rawRow['Request']['type']);
    $row[] = $rawRow[0]['creatorFullname'];
    $row[] = $this->Format->date($rawRow['Request']['created']);

    $row[] = $rawRow[0]['assignedFullname'];

    $row[] = __($rawRow['Request']['status']);

    $output['aaData'][] = $row;
}


echo json_encode($output);