<?php
header('Content-Type: application/xml');
$apiData = array(
'api_username' => "$_POST[api_username]",
'api_password' => "$_POST[api_password]",
'MODULE' => "$_POST[MODULE]",
'COMMAND' => "$_POST[COMMAND]",
'FirstName' => "$_POST[FirstName]",
'LastName' => "$_POST[LastName]",
'email' => "$_POST[email]",
'password' => "$_POST[password]",
'Country' => "$_POST[Country]",
'campaignId' => "$_POST[campaignId]",
'Phone' => "$_POST[Phone]",
'subCampaign' => "$_POST[subCampaign]",
'currency' => "$_POST[currency]"
);

$URL = 'http://api-spotplatform.plusoption.com/api';

$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch); // run the whole process

echo $result;
curl_close($ch);
//header("Refresh: 5; url=http://www.plusoption.com/autologin_method_en.php?e=$_POST[email]&p=$_POST[password]");
