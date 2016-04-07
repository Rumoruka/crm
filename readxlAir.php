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
        $data[] = $line;
    }
    fclose($handle);
}
//count the amount of rows in csv
$rows = count($data);
//print_r($data);
$URL = 'http://api.airsoftltd.com';

//send requests to $URL, one by one
for ($i = 0; $i < $rows; $i++) {
    
    $array = $data[$i]; //getting ich of the rows in csv
    $apiData = array(
        'key' => 'dfg4579jf84257',
        'method' => 'createLead',
        'first_name' => "$array[0]",
        'last_name' => "$array[1]",
        'email_address' => "$array[2]",
        'phone' => "$array[3]",
        'countryISO' => "$array[4]",
        'currency' => "$array[5]",
        'custom_refer' => "$array[6]",
        'campaign_id' => "$array[7]",
        'campaign_keyword' => "$array[8]",
        'is_lead_only' => "$array[9]",
        'comment' => "$array[10]"
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
    var_dump($result);
    //close connection
    curl_close($ch);
}

