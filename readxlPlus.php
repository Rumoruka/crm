<?php
error_reporting (0);
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
$URL = 'http://api-spotplatform.plusoption.com/api';

//send requests to $URL, one by one
for ($i = 0; $i < $rows; $i++) {
    
    $array = $data[$i]; //getting ich of the rows in csv
    $apiData = array(
        'api_username' => 'expertaffnetwork',
        'api_password' => 'd9URo2q7Mb',
        'MODULE' => 'Customer',
        'COMMAND' => 'add',
        'isLead' => '1',
        'FirstName' => "$array[0]",
        'LastName' => "$array[1]",
        'email' => "$array[4]",
        'password' => "$array[2]",
        'Country' => "$array[3]",
        'campaignId' => "$array[6]",
        'Phone' => "$array[5]",
        'subCampaign' => "$array[7]",
        'currency' => "$array[8]"
        );
    //print_r($apiData);
    //prepare the request
    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    //execute the request
    $result = curl_exec($ch);

    //display the answer from the $URL
    echo "<pre>".htmlspecialchars($result)."</pre><br />";
    //close connection
    curl_close($ch);
}

