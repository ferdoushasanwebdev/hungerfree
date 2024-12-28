<?php
include('./class/class.history.php');

$histObj = new History();
$data = $histObj->fetchDonationByDivisions();

echo json_encode($data);
