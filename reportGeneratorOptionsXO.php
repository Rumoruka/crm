<?php
//header("Content-Type: text/xml");

require_once ('PHPExcel.php');
require_once ('PHPExcel/IOFactory.php');

function sendCurl($apiData) {
    
    $URL = "https://api.optionsxo.com/api/marketeer/customer/findAccounts";

    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch); // run the whole process

    curl_close($ch);
    
    return $result;
}

$apiData = array(
    'affiliateUserName' => 'expertaffnetwor',
    'affiliatePassword' => 'DwqH1l5x'
);

$result = sendCurl($apiData, $URL);

$array = json_decode($result, true);

$count = count($array["result"]);

$accounts = $array["result"];

$time = date("Y-m-d H-i-s");
$title = "Report - " . $time;
$objExel = new PHPExcel();
$objExel->getProperties()->setTitle($title);
$objExel->getActiveSheet()->setTitle($title);
$objExel->setActiveSheetIndex(0);

$objExel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Name");
$objExel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "Email");
$objExel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "Phone");
$objExel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "Last Call Date");

for ($i = 0; $i < $count; $i++) {
    
    $account = $accounts[$i];
    
    $row = $i+2;

    $objExel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $account['apiaccountview_firstName']);
    $objExel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $account['apiaccountview_email']);
    $objExel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $account['apiaccountview_phoneNumber']);
    //$objExel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $customer['lastUpdate']);
}

$objWriter = PHPExcel_IOFactory::createWriter($objExel, 'Excel2007');
$name = $title . ".xlsx";
$objWriter->save($name);
    echo "<a href='".$name."' download>Download report</a>";