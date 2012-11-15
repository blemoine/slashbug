<?php
$output = array(
    "sEcho" => $sEcho,
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array());

foreach ($rows as $rawRow) {
    $row = array();

    $row[] = $rawRow['Project']['name'];
    $row[] = $this->Format->date($rawRow['Project']['created']);

    $row[] = $rawRow[0]['inProgress'];
    $row[] = $rawRow[0]['done'];
    $row[] = $rawRow[0]['total'];



    $output['aaData'][] = $row;
}


echo json_encode($output);