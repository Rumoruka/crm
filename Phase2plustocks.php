<?php
//header('Content-Type: application/xml');
require_once ('db.php');

// function to send curl requests
function sendCurl($apiData) {
    
    $URL = 'http://api-spotplatform.plustocks.com/api';

    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch); // run the whole process

    curl_close($ch);
    
    return $result;
}

// array for curl request
$apiData = array(
    'api_username' => 'ExpertAffNetwork',
    'api_password' => 'm9IvX94tYk',
    'MODULE' => 'Customer',
    'COMMAND' => 'view'
);

// get the information about cutomers
$result = sendCurl($apiData);

// turn $result into SimpleXMLElement object
$xml = new SimpleXMLElement($result);

// turn $xml into ordinary array
$array = json_decode(json_encode($xml), true);

$customers = $array['Customer'];

// get the amount of the customers, will need this number for cycle
$amount = count($customers);

// get information on each customer
for ($i = 0; $i < $amount; $i++) {
    
    // each customer is stored in fields with names like data_0, data_1 ...
    // so this is how we get each customer
    $customer = $customers["data_$i"];
    
    // now we get the customers id
    $id = $customer['id'];
    
    // check if the customer i Lead or not, if not, continue, 
    // if yes - we output that 
    if ($customer['isLead'] == 0) {
        
        // prepare new list to get information on customer withdrawals
        $apiData = array(
            'api_username' => 'ExpertAffNetwork',
            'api_password' => 'm9IvX94tYk',
            'MODULE' => 'Withdrawal',
            'COMMAND' => 'view',
            'FILTER[id]' => "$id"
        );
        
        // send request
        $Withdrawal = sendCurl($apiData);
        
        // connvert the data into simple array
        $xml = new SimpleXMLElement($Withdrawal);
        $array = json_decode(json_encode($xml), true);
        
        // check the operation status
        // if it is failed, we set $CustomerWithdrawals to "No withdrawals"
        if ($array['operation_status'] == 'failed') {
            
            $CustomerWithdrawals = "No withdrawals";
        
        // if it is not failed, we set $CustomerWithdrawals to "Has withdrawals"
        // and get the information on each withdrawal
        } else {
            
            $CustomerWithdrawals = "Has withdrawals";
            $widths = $array['CustomerDeposits'];
            $countw = count($widths);
            
            for ($y = 0; $y < $countw; $y++) {
                
                $dep = $deps["data_$i"];
                $depDate = $dep['confirmTime'];
                $depAmount = $dep['amount'];
                
                echo $customer['id'] . " - " . $depDate . " - " . $depAmount . "<br />";
            }
        }
        
        // Now we make te same with customer deposits as we did with withdrawals
        $apiData = array(
            'api_username' => 'ExpertAffNetwork',
            'api_password' => 'm9IvX94tYk',
            'MODULE' => 'CustomerDeposits',
            'COMMAND' => 'view',
            'FILTER[id]' => "$id"
        );
        
        // send request
        $Deposits = sendCurl($apiData);
        
        // convert response into simple array
        $xml = new SimpleXMLElement($Deposits);
        $array = json_decode(json_encode($xml), true);
        
        // check the operation status
        // if it is failed, we set $CustomerWithdrawals to "No deposits"
        if ($array['operation_status'] == 'failed') {
            
            $CustomerDeposits = "No deposits";
        
        // if it is not failed, we set $CustomerWithdrawals to "Has deposits"
        // and get the information on each deposit
        } else {
            
            $CustomerDeposits = "Has deposits";
            $deps = $array['CustomerDeposits'];
            $countd = count($deps);
            
            for ($x = 0; $x < $countd; $x++) {
                
                $dep = $deps["data_$i"];
                $depDate = $dep['confirmTime'];
                $depAmount = $dep['amount'];
                
                echo $id . " - " . $depDate . " - " . $depAmount . "<br />";
                
                // insert data into DB
                $sql_query = $mysqli->query('INSERT INTO deposits (id, deposit_date, deposit_amount) VALUES ($id, $depDate, $depAmount)');
            }
        }
        
        echo $customer['id'] . " - " . $customer['FirstName'] . " - " . $customer['LastName'] . " - " . $customer['email'] . " - " . $customer['phone'] . " - " . $customer['Country'] . " - " . $customer['currency'] . " - " . $customer['regTime'] . " - " . $customer['subCampaignParam'] . " - " . $CustomerDeposits . " - " . $CustomerWithdrawals . " - " . $customer['lastTimeActive'] . "<br />";
    } else {
        echo "Is Lead <br />";
    }
}
