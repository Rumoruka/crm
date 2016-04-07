<?php
include_once('TechApi.php');

$techApi = new TechApi();

/*
 *  Transactions Types
 *   102	Deposit
 *   103	Withdrawal
 *   195	ChargeBack
 *
 */


$formData['type']='102';

$respond =  $techApi->findTransactions($formData);

var_dump($respond);