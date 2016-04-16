<?php
//header('Content-Type: application/xml');
require_once ('db.php');

// function to send curl requests
function sendCurl($apiData) {
    
    $URL = 'http://api-spotplatform.plusoption.com/api';

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
    'api_username' => 'expertaffnetwork',
    'api_password' => 'd9URo2q7Mb',
    'MODULE' => 'Customer',
    'COMMAND' => 'view'
);

// get the information about cutomers
$result = sendCurl($apiData);

// turn $result into SimpleXMLElement object and turn $xml into ordinary array
$xml = new SimpleXMLElement($result);
$array = json_decode(json_encode($xml), true);

$customers = $array['Customer'];
$amount = count($customers);

// get information on each customer
for ($i = 0; $i < $amount; $i++) {
    
    // each customer is stored in fields with names like data_0, data_1 ...
    // so this is how we get each customer
    $customer = $customers["data_$i"];
    
    $id = $customer['id'];
    
    // check if the customer is Lead or not, if not, continue, 
    // if yes - we output that 
    if ($customer['isLead'] == 0) {
//---------------------------  WITHDRAWALS ----------------------------//
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
        // if it is failed, we set $CustomerWithdrawals to 0
        if ($array['operation_status'] == 'failed') {
            
            $CustomerWithdrawals = 0;
        
        // if it is not failed, we set $CustomerWithdrawals to 1
        // and get the information on each withdrawal
        } else {
            
            $CustomerWithdrawals = 1;
            $widths = $array['Withdrawals'];
            $countw = count($widths);
            
            for ($y = 0; $y < $countw; $y++) {
                
                $width = $widths["data_$y"];
                $widthDate = $width['requestTime'];
                $widthAmount = $width['amount'];
                $widthStatus = $width['status'];
                
                // prepare query to insert into DB
                $query = "INSERT INTO withdrawals (id, withdrawal_date, withdrawal_amount, withdrawal_status) VALUES ('$id', '$widthDate', '$widthAmount', '$widthStatus')";
                
                // try to complete the query
                if ( $mysqli->query($query) === TRUE ) {

                    echo 'New record created: $id, date - $widthDate, amount - $widthAmount';
                    
                } else {

                    echo "Error: " . $query . "<br />" . $mysqli->error . "<br />";
                }
            }
        }
        
//----------------------------  DEPOSITS ----------------------------//    
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
        // if it is failed, we set $CustomerWithdrawals to 0, meaning no deposits
        if ($array['operation_status'] == 'failed') {
            
            $CustomerDeposits = 0;
        
        // if it is not failed, we set $CustomerWithdrawals to 1, meaning has deposits
        // and get the information on each deposit
        } else {
            
            $CustomerDeposits = 1;
            $deps = $array['CustomerDeposits'];
            $countd = count($deps);
            
            for ($x = 0; $x < $countd; $x++) {
                
                $dep = $deps["data_$x"];
                $depDate = $dep['requestTime'];
                $depAmount = $dep['amount'];
                $depStatus = $dep['Status'];
                
                // prepare query to insert into DB
                $query = "INSERT INTO deposits (id, deposit_date, deposit_amount, deposit_status) VALUES ('$id', '$depDate', '$depAmount', '$depStatus')";
                
                // try to complete the query
                if ( $mysqli->query($query) === TRUE ) {

                    echo 'New record created: $id, date - $depDate, amount - $depAmount';
                    
                } else {

                    echo "Error: " . $query . "<br />" . $mysqli->error . "<br />";
                }
            }
        }

        echo $customer['id'] . " - " . $customer['FirstName'] . " - " . $customer['LastName'] . " - " . $customer['email'] . " - " . $customer['phone'] . " - " . $customer['Country'] . " - " . $customer['currency'] . " - " . $customer['regTime'] . " - " . $customer['subCampaignParam'] . " - " . ($CustomerDeposits == 0 ? "No depposits" : "Has Deposits") . " - " . ($CustomerWithdrawals == 0 ? "No withdrawals" : "Has withdrawals") . " - " . $customer['lastTimeActive'] . "<br />";
        
        $id = $customer['id'];
        $FirstName = $customer['FirstName'];
        $LastName = $customer['LastName'];
        $email = $customer['email'];
        $phone = $customer['phone'];
        $Country = $customer['Country'];
        $currency = $customer['currency'];
        $regTime = $customer['regTime'];
        $subCampaignParam = $customer['subCampaignParam'];
        $lastTimeActive = $customer['lastTimeActive'];
        $saleStatus = $customer['saleStatus'];
        $leadStatus = $customer['leadStatus'];
        $balance = $customer['accountBalance'];
        
        $time = strtotime($lastTimeActive);
        $date = date("Y-m-d H:i:s", $time);
        /*
        $query = "INSERT INTO customers (id, FirstName, LastName, email, phone, Country, currency, regTime, subCampaign, hasDeposits, hasWithdrawals, lastTimeActive, saleSatus, leadStatus, balance)
        VALUES ('$id', '$FirstName', '$LastName', '$email', '$phone', '$Country', '$currency', '$regTime', '$subCampaignParam', '$CustomerDeposits', '$CustomerWithdrawals', '$date', '$saleSatus', '$leadStatus', '$balance')";
        
        if ( $mysqli->query($query) === TRUE ) {
            
            echo 'New record created: $id, $customer["FirstName"], $customer["LastName"]' . "<br />";
            
        } else {
            
            echo "Error: " . $query . "<br />" . $mysqli->error . "<br />";
        }*/
    } else {
        echo "Is Lead <br />";
    }
}
