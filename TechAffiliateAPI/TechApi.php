<?php

class TechApi {

    private $ApiUrl = 'https://api.optionsxo.com/api/marketeer/';    // DO NOT Change this URL
    private $ApiUsername = 'expertaffnetwor';                         // Enter Your Api User Here
    private $ApiPassword = 'DwqH1l5x';                                 // Enter Your Api Password Here
    private $oftc = '2215';                                          // Enter Your Api Tracking Code (OFTC) Here
    private $email_admin = 'vovaba@i.ua';                        // Enter Your Email to get Errors to Email

    public function registerTrader($data=array()){

        $method="registerTrader";

        try
        {
            $response = $this->request($data,$method);
        }
        catch (Exception $e)
        {
            mail($this->email_admin,'Tech Api Error',$e);
            return $e;
        }
        return $response;
    }



    public function findAccounts($data=array()){

        $method="findAccounts";

        try
        {
            $response = $this->request($data,$method);
        }
        catch (Exception $e)
        {
            mail($this->email_admin,'Tech Api Error',$e);
            return $e;
        }
        return $response;
    }

    public function findTransactions($data=array()){

        $method="findTransactions";

        try
        {
            $response = $this->request($data,$method);
        }
        catch (Exception $e)
        {
            mail($this->email_admin,'Tech Api Error',$e);
            return $e;
        }
        return $response;
    }



    private function request($dataArray, $method) {


        $dataArray['affiliateUserName']=$this->ApiUsername;
        $dataArray['affiliatePassword']=$this->ApiPassword;
        $dataArray['trackingCode']=$this->oftc;

        $method_url=$this->getMethodURL($method);

        $URL = $this->ApiUrl.$method_url;

        $URL_data=http_build_query ($dataArray);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>"$URL?$URL_data",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",

        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        //var_dump("$URL?$URL_data");
        //var_dump($response);
        
        if ($err) {
            mail($this->email_admin,'Tech Api Error',$err);
            return  $err;
        } else {
            return $response;
        }
    }



    private function getMethodURL($method_name){
        $return='';
        switch($method_name){
            case'registerTrader':
                $return='customer/registerTrader';
                break;
            case'findAccounts':
                $return='customer/findAccounts';
                break;
            case'findTransactions':
                $return='banking/findTransactions';
                break;

            default:
                $return='customer/registerTrader';
                break;

        }
        return $return;
    }


}



