<?php

$apiData = array(
    'affiliateUserName' => "$_POST[affiliateUserName]",
    'affiliatePassword' => "$_POST[affiliatePassword]",
    'trackingCode' => "$_POST[trackingCode]",
    'userName' => "$_POST[userName]",
    'firstName' => "$_POST[firstName]",
    'lastName' => "$_POST[lastName]",
    'email' => "$_POST[email]",
    'phoneNumber' => "$_POST[phoneNumber]",
    'countryId' => "$_POST[countryId]",
    'currencyId' => "$_POST[currencyId]",
    'Param1' => "$_POST[Param1]"
);

$URL = "https://api.optionsxo.com/api/marketeer/customer/registerTrader";

$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch); // run the whole process

var_dump($result);
curl_close($ch);
//header("Refresh: 5; url=http://www.plusoption.com/autologin_method_en.php?e=$_POST[email]&p=$_POST[password]");
