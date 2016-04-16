<?php
//error_reporting (0);
$file = $_FILES['uploadedfile']['name']; //get posted csv file
$tmp = $_FILES['uploadedfile']['tmp_name']; 
$path = 'uploads/';
$file = $path . $file;
move_uploaded_file($tmp, $file); //upload te file into the $path folder
$data = []; //empty array for csv data

//read the csv file and insert its data into $data array, row by row
if (($handle = fopen($file, "r")) !== FALSE) {
    while (($line = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $data[] =  $line;
    }
    fclose($handle);
}
//count the amount of rows in csv
$rows = count($data);
//print_r($data);
$URL = "https://api.optionsxo.com/api/marketeer/customer/registerTrader";

//send requests to $URL, one by one
for ($i = 0; $i < $rows; $i++) {
    
    $array = $data[$i]; //getting ich of the rows in csv
    
    //replace the whitespaces by underlines
    //because OPtionsXO preg match doesn't let the names 
    //with whitespaces to pass through
    $firstName = preg_replace('/ /', '_', $array[0]);
    $lastName = preg_replace('/ /', '_', $array[1]);
    /*
    echo $array[0] . " - " . $firstName . "<br />";
    echo $array[1] . " - " . $lastName . "<br />";
    */
    //prepare request
    $apiData = array(
        'affiliateUserName' => 'expertaffnetwor',
        'affiliatePassword' => 'DwqH1l5x',
        'trackingCode' => '2215',
        'firstName' => "$firstName",
        'lastName' => "$lastName",
        'email' => "$array[2]",
        'phoneNumber' => "$array[3]",
        'countryId' => "$array[4]",
        'currencyId' => "$array[5]",
        'param1' => "$array[6]"
        );
    //print_r($apiData);
    //prepare the request

    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    //execute the request
    $result = curl_exec($ch);
    $err = curl_error($ch);
    if ($err) {
        echo  $err;
    } else {
        var_dump($result);
    }

    //close connection
    curl_close($ch);
}
