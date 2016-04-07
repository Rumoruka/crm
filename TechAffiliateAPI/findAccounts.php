<?php
include_once('TechApi.php');

$techApi = new TechApi();

$respond =  $techApi->findAccounts();

var_dump($respond);