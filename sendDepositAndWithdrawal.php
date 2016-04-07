<?php
header('Content-Type: application/xml');
$apiData = array(
'api_username' => 'ExpertAffNetwork',
'api_password' => 'm9IvX94tYk',
'MODULE' => 'CustomerDeposits',
'COMMAND' => 'add',
'method' => 'creditCard',
'customerId' => '127909',
'amount' => '300',
'fundId' => '2',
'cardType' => '3',
'cardNum' => '4580100010011002',
'ExpMonth' => '06',
'ExpYear' => '2017',
'CCV2/PIN' => '1234',
'FirstName' => 'Tony',
'LastName' => 'TestTony',
'currency' => 'USD'
);

$URL = 'http://api-spotplatform.plustocks.com/api';

$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch); // run the whole process

echo $result;
curl_close($ch);
