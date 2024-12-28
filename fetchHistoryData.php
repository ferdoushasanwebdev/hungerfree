<?php
include_once("./class/class.history.php");

$histObj = new History();
$data = $histObj->fetchHistoryByDate();

header('Content-Type: application/json');
echo json_encode($data);
