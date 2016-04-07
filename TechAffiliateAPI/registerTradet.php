<?php
include_once('TechApi.php');

$techApi = new TechApi();


/**/
// Get User Data from Register Form

$formData['firstName']='Volodymyr';    // you should get this data from your Register Form - Letters only No spaces
$formData['lastName']='Test';      // you should get this data from your Register Form - Letters only No spaces
$formData['currencyId']='USD';         // you should get this data from your Register Form
$formData['email']='testVova123@mail.com';  // you should get this data from your Register Form - MUST BE UNIQUE No spaces
$formData['countryId']='UA';           // you should get this data from your Register Form
$formData['phoneNumber']='33445566';   // you should get this data from your Register Form - Digits Only No spaces

$respond = $techApi->registerTrader($formData);

echo $respond;