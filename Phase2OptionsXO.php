<?php

//require_once ('db.php');

function sendCurl($apiData, $URL) {
    
    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch); // run the whole process

    curl_close($ch);
    
    return $result;
}

$URL = "https://api.optionsxo.com/api/marketeer/customer/findAccounts";

$apiData = array(
    'affiliateUserName' => 'expertaffnetwor',
    'affiliatePassword' => 'DwqH1l5x'
);

$result = sendCurl($apiData, $URL);
$array = json_decode($result, true);

$count = count($array["result"]);

$accounts = $array["result"];

for ($i = 0; $i < $count; $i++) {
    
    $account = $accounts[$i];
    $id = $account['apiaccountview_id'];
    
//-------------------- DEPOSITS ----------------------// 
    $URL = "https://api.optionsxo.com/api/marketeer/banking/findTransactions";
    
    $apiData = array(
        'affiliateUserName' => 'expertaffnetwor',
        'affiliatePassword' => 'DwqH1l5x',
        'type' => '102',
        'Filter[accountID]' => '$id'
    );
    
    $result = sendCurl($apiData, $URL);
    $array = json_decode($result, true);

    $count_d = count($array["result"]);
    
    if ($count_d == 0) {
        
        $hasDeposits = 0;
        
    } else {
        
        $hasDeposits = 1;
        for ($y = 0; $y < $count_d; $y++) {
            
            $deposits = $array["result"];
            $depAmount = $deposits["banking_amount"];
            $depDate = $deposits["banking_requestTime"];
            $depStatus = $deposits["banking_status"];
            
            $query = "INSERT INTO deposits (id, deposit_date, deposit_amount, deposit_status) VALUES ('$id', '$depDate', '$depAmount', '$depStatus')";
            
            if ( $mysqli->query($query) === TRUE ) {

                echo 'New record created: $id, date - $widthDate, amount - $widthAmount, status - $depStatus';
            
            } else {

                echo "Error: " . $query . "<br />" . $mysqli->error . "<br />";
            }
        }
    }
//-------------------- WITHDRAWALS ----------------------//
    $URL = "https://api.optionsxo.com/api/marketeer/banking/findTransactions";
    
    $apiData = array(
        'affiliateUserName' => 'expertaffnetwor',
        'affiliatePassword' => 'DwqH1l5x',
        'type' => '103',
        'Filter[accountID]' => '$id'
    );
    
    $result = sendCurl($apiData, $URL);
    $array = json_decode($result, true);

    $count_w = count($array["result"]);
    
    if ($count_w == 0) {
        
        $hasWithdrawals = 0;
        
    } else {
        
        $hasWithdrawals = 1;
        for ($x = 0; $x < $count_w; $x++) {

            $withdrawals = $array["result"];
            $widthAmount = $withdrawals["banking_amount"];
            $widthDate = $withdrawals["banking_requestTime"];
            $widthStatus = $withdrawals["banking_status"];
            
            $query = "INSERT INTO withdrawals (id, withdrawal_date, withdrawal_amount, withdrawal_status) VALUES ('$id', '$widthDate', '$widthAmount', '$widthStatus')";
            
            if ( $mysqli->query($query) === TRUE ) {

                echo 'New record created: $id, date - $widthDate, amount - $widthAmount, status - $widthStatus';
                    
            } else {

                echo "Error: " . $query . "<br />" . $mysqli->error . "<br />";
            }
        }
    }
    
    $firstName = $account['apiaccountview_firstName'];
    $lastName = $account['apiaccountview_lastName'];
    $email = $account['apiaccountview_email'];
    $phoneNumber = $account['apiaccountview_phoneNumber'];
    $country = $account['apiaccountview_countryId'];
    $currency = $account['apiaccountview_currencyISO'];
    $regTime = $account['apiaccountview_registrationDate'];
    $subCampaign = $account['apiaccountview_param1'];
    $salesStatus = $account['apiaccountview_saleStatus'];
    
    $query = "INSERT INTO customers (id, FirstName, LastName, email, phone, Country, currency, regTime, subCampaign, hasDeposits, hasWithdrawals, saleStatus) VALUES ('$id', '$firstName', '$lastName', '$email', '$phoneNumber', '$country', '$currency', '$regTime', '$subCampaign', '$hasDeposits', '$hasWithdrawals', '$salesStatus')";
      
    if ( $mysqli->query($query) === TRUE ) {

        echo "New record created: " . $id . " - " . $firstName . " - " . $lastName . " - " . $email . " - " . $phoneNumber . " - " . $country . " - " . $currency . " - " . $regTime . " - " . $subCampaign . " - " . ($hasDeposits == 0 ? "No depposits" : "Has Deposits") . " - " . ($hasWithdrawals == 0 ? "No Withdrawals" : "Has Withdrawals") . " - " . $salesStatus . "<br />";
        
    } else {

        echo "Error: " . $query . "<br />" . $mysqli->error . "<br />";
    }
}
