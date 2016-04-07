<?php
header('Content-Type: application/xml');
$apiData = array(
    'api_username' => 'ExpertAffNetwork',
    'api_password' => 'm9IvX94tYk',
    'MODULE' => 'CustomerDeposits',
    'COMMAND' => 'view',
    'FILTER[id]' => '127909'
);

$URL = 'http://api-spotplatform.plustocks.com/api';

$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch); // run the whole process

echo $result;
curl_close($ch);
