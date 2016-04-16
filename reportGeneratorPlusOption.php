<?php
//header("Content-Type: text/xml");

require_once ('PHPExcel.php');
require_once ('PHPExcel/IOFactory.php');

function sendCurl($apiData) {
    
    $URL = 'http://api-spotplatform.plusoption.com/api';

    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch); // run the whole process

    curl_close($ch);
    
    return $result;
}

$apiData = array(
    'api_username' => 'expertaffnetwork',
    'api_password' => 'd9URo2q7Mb',
    'MODULE' => 'Customer',
    'COMMAND' => 'view'
);
// Get information about customers
$result = sendCurl($apiData);

//echo $result;
//echo $result . "<br />" . "CALLS" . "<br />";
//exit();
$xml = new SimpleXMLElement($result);
$array = json_decode(json_encode($xml), true);

$customers = $array['Customer'];
$amount = count($customers);

// This is date and title for exel file
$time = date("Y-m-d H-i-s");
$title = "Report - " . $time;

//Start new exel object
$objExel = new PHPExcel();
$objExel->getProperties()->setTitle($title);
$objExel->getActiveSheet()->setTitle($title);
$objExel->setActiveSheetIndex(0);

//First line in file with names of columns
$objExel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Name");
$objExel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "Email");
$objExel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "Phone");
$objExel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "Last Call Date");

for ($i = 0; $i < $amount; $i++) {
    
    $customer = $customers["data_$i"];
    
    $id = $customer['id'];
    
    // Rows start from 1, $i from 0.
    // In first row we have column names, so wwe start to write info from row #2
    $row = $i+2;  // first $row == 2, then $row == 3 ....

    $objExel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $customer['FirstName']);
    $objExel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $customer['email']);
    $objExel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $customer['phone']);
    $objExel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $customer['lastUpdate']);
}

$objWriter = PHPExcel_IOFactory::createWriter($objExel, 'Excel2007');

// Name of the file that contains data of file creation
$name = $title . ".xlsx";
//save file with $name
$objWriter->save($name);
    echo "<a href='".$name."' download>Download report</a>";