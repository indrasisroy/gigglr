<?php

//********************* function to call charge api of pin payment gateway starts**********************


function chargecreditcard($liveortestmode='test',$postparamar=array(),$secretkeydata='')
{
    
        $url = 'https://test-api.pin.net.au/1/charges'; // default is TEST  
    
        if($liveortestmode=="live")
        {
            $url = 'https://api.pin.net.au/1/charges';
        }
    

        //url-ify the data for the POST
    $fields_string='';
        foreach($postparamar as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        //curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_USERPWD, $secretkeydata.":");


        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        //close connection
        curl_close($ch);


        $respfromgateway=json_decode($server_output,true);
        //echo "result=><pre>"; print_r($respfromgateway); echo "<pre>";

        $flagresp=0;
        $message=''; $ermessagear=array();

        $succrespdataar=array(); $respdataar=array();

        if(!empty($respfromgateway))
        {
            if(array_key_exists('response',$respfromgateway) && !empty($respfromgateway['response']) )
            {
                $responsear=$respfromgateway['response'];

                $token=$responsear['token'];
                $success=$responsear['success'];
                $status_message=$responsear['status_message'];
                $amount=$responsear['amount']; // e.g amount charged
                $currency=$responsear['currency']; // e.g USD/AUD etc
                $description=$responsear['description']; // e.g purpose of payment  mentioned        
                $email=$responsear['email']; // e.g provided
                $card_token=$responsear['card']['token']; // e.g card_
                $scheme=$responsear['card']['scheme']; // e.g visa

                $succrespdataar['token']=$token;
                $succrespdataar['success']=$success;
                $succrespdataar['status_message']=$status_message;
                $succrespdataar['amount']=$amount;
                $succrespdataar['currency']=$currency;
                $succrespdataar['description']=$description;
                $succrespdataar['email']=$email;
                $succrespdataar['scheme']=$scheme;

                if($success=="true")
                {
                    $flagresp=1;
                }


            }
            elseif(array_key_exists('error',$respfromgateway))
            {
               
               
               // echo "<pre>"; print_r($respfromgateway);

                if( array_key_exists('messages',$respfromgateway) && !empty($respfromgateway['messages']))
                {
                    $responseerrmessgar=$respfromgateway['messages'];

                    if(!empty($responseerrmessgar))
                    {
                        foreach($responseerrmessgar as $ermsgar)
                        {
                            $ermessagear[]=$ermsgar['message'];

                        }

                    }
                    

                }
                elseif( array_key_exists('error_description',$respfromgateway) &&  !empty($respfromgateway['error_description']))
                    {
                        
                       
                        $ermessagear[]=$respfromgateway['error_description'];
                    }


                if(!empty($ermessagear))
                {

                    $message=implode("<br>",$ermessagear);
                }



            }


        }

        $respdataar['flagresp']=$flagresp;
        $respdataar['succrespdataar']=$succrespdataar;
        $respdataar['message']=$message;
        $respdataar['errormessagear']=$ermessagear;

        return $respdataar;

}

//********************* function to call charge api of pin payment gateway starts**********************


/*

//**************  calling  way to  chargecreditcard function starts ******************
$card_token=$_REQUEST['card_token'];

$postparamar=array();
$postparamar['email'] =urlencode("soumik@esolzmail.com"); 
$postparamar['description'] =urlencode("Wallet respective payment ".rand()); 
$postparamar['amount'] =urlencode("500"); 
$postparamar['ip_address '] =urlencode("203.192.1.172"); 
$postparamar['currency'] =urlencode("USD"); 
$postparamar['capture'] =urlencode("true"); 
$postparamar['card_token'] =$card_token;  //secret//lkCmlBsCkO92zz5yaYbALg//publishable//pk_tS2DpGcQfzS0vZe-j7gAWg

$secretkeydata="lkCmlBsCkO92zz5yaYbALg";
$liveortestmode='TEST'; // 'LIVE'

$callcgargecredit=chargecreditcard($liveortestmode='TEST',$postparamar,$secretkeydata);

echo "callcgargecredit==><pre>"; print_r($callcgargecredit); echo "</pre>";


//************** calling way to  chargecreditcard function ends ******************

*/




/**
########################### Charges Status Start Here ###########################
**/
function check_charges_status($charge_token, $payment_type, $secret_key)
{
	//Charges details using GET Method
	if($payment_type == 'test')
	{
		$charges_url = 'https://test-api.pin.net.au/1/charges/'.$charge_token;   // Test Payment Url
	}elseif($payment_type == 'live')
	{
		$charges_url = 'https://api.pin.net.au/1/charges/'.$charge_token;   // Live Payment Url
	}
	
	$charges_url = 'https://test-api.pin.net.au/1/charges/'.$charge_token;
	//$url = 'https://test-api.pin.net.au/1/charges/ch_xFHQeSe9-Oji5Im_K4i4yA/refunds';   Sample of test url

	//open connection
	$charges_ch = curl_init();

	curl_setopt($charges_ch,CURLOPT_URL, $charges_url);
	curl_setopt($charges_ch, CURLOPT_HTTPGET, 1);
	curl_setopt($charges_ch, CURLOPT_USERPWD, $secret_key.':');

	// receive server response ...
	curl_setopt($charges_ch, CURLOPT_RETURNTRANSFER, true);

	//execute get for charges listing

	$charges_output = curl_exec($charges_ch);
	curl_close($charges_ch);

	//print_r($charges_output); exit;
	return json_decode($charges_output);
}


/**
########################### Charges Status Ends Here ###########################
**/



/**
########################### Refunds Create Start Here ###########################
**/
function create_refund($refund_token, $payment_type, $secret_key)
{
	//Create Refund POST For Charges Token
	if($payment_type == 'test')
	{
		$refunds_url = 'https://test-api.pin.net.au/1/charges/'.$refund_token.'/refunds';  // Test payment url
	}elseif($payment_type == 'live')
	{
		$refunds_url = 'https://api.pin.net.au/1/charges/'.$refund_token.'/refunds';	   // Live payment url
	}
	
	//$url = 'https://test-api.pin.net.au/1/charges/ch_xFHQeSe9-Oji5Im_K4i4yA/refunds';		// Sample url to create refund

	//$fields_string = '';

	//open connection
	$refunds_ch = curl_init();

	curl_setopt($refunds_ch,CURLOPT_URL, $refunds_url);
	//curl_setopt($refunds_ch, CURLOPT_HTTPGET, 1);
	curl_setopt($refunds_ch,CURLOPT_CUSTOMREQUEST, 'POST');
	// /curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($refunds_ch, CURLOPT_USERPWD, $secret_key.':');

	// receive server response ...
	curl_setopt($refunds_ch, CURLOPT_RETURNTRANSFER, true);

	//execute get for refund listing
	$refunds_output = curl_exec($refunds_ch);
	curl_close($refunds_ch);

	// print_r($refunds_output); exit;
	return json_decode($refunds_output);
}


/*
//****** calling way  to cal check_charges_status and  create_refund starts


/**
########################### Refunds Create Ends Here ###########################
**/


////****** calling way  to cal check_charges_status and  create_refund starts
//
///**#################   CONFIG FOR REFUND PROCESS START HERE   #################**/
//$token_to_refund = 'ch_GM2xbFqtNF4UxqK-4Tam6Q';					//   Changes token for the refund  //
//$payment_type = 'TEST';   										//   'TEST' For test mode payment, 'LIVE' For live mode payment //
//$secret_key = 'lkCmlBsCkO92zz5yaYbALg';							//   Change this secret key with the LIVE secret key //
///**#################   CONFIG FOR REFUND PROCESS ENDS HERE   #################**/
//
//
//$refund_array = array();
//$refund_array['res_flag'] = 0;
//$refund_array['error_type'] = '';
//$refund_array['error_message'] = '';
//$refund_array['res_arr'] = array();
//
//$status = check_charges_status($token_to_refund, $payment_type, $secret_key);  //** check  charge token is valid or not 
////print_r($status); exit;
//if($status->error)
//{
//	$refund_array['error_type'] = $status->error;
//	$refund_array['error_message'] = $status->error_description;
//	//echo 'Error Type: '.$status->error.'<br>';
//	//echo 'Error Message: '.$status->error_description.'<br>';
//}else{
//    
//   
//
//	if($status->response->success == 1 && $status->response->amount_refunded == 0)
//	{
//		$refund_status = create_refund($token_to_refund, $payment_type, $secret_key); //** call create_refund function to make refund
//		$refund_array['res_flag'] = 1;
//		$refund_array['res_arr'] = $refund_status;
//		//print_r($refund_status); exit;
//	}elseif($status->response->success == 1 && $status->response->amount_refunded > 0)
//	{
//		$refund_array['error_message'] = 'Previously Refunded With '.$token_to_refund.' charges token number !!!';
//		//echo 'Previously Refunded With '.$token_to_refund.' charges token number !!!';  exit;
//	}
//
//}
//
////****** calling way  to cal check_charges_status and  create_refund ends


function convertamountbasedoncurrbaselimit($amount,$currency_code)
{
    
    //********** manipulate amount based on currency base unit according to pin payment gateway starts *****************
         
                if($currency_code=="AUD")
                {
                    $amount=($amount*100);
                }
                elseif($currency_code=="USD")
                {
                    $amount=($amount*100);
                }
                elseif($currency_code=="NZD")
                {
                    $amount=($amount*100);
                }
                elseif($currency_code=="SGD")
                {
                    $amount=($amount*100);
                }
                elseif($currency_code=="EUR")
                {
                    $amount=($amount*100);
                }
                elseif($currency_code=="GBP")
                {
                    $amount=($amount*50);
                }
                elseif($currency_code=="CAD")
                {
                    $amount=($amount*100);
                }
                elseif($currency_code=="HKD")
                {
                    $amount=($amount*1000);
                }
                elseif($currency_code=="JPY")
                {
                    $amount=($amount*100);
                }
                elseif($currency_code=="MYR")
                {
                    $amount=($amount*300);
                }
                elseif($currency_code=="THB")
                {
                    $amount=($amount*2000);
                }
                elseif($currency_code=="PHP")
                {
                    $amount=($amount*3000);
                }
                elseif($currency_code=="ZAR")
                {
                    $amount=($amount*1000);
                }
                elseif($currency_code=="IDR")
                {
                    $amount=($amount*1000000);
                }
                
                
         
                //AUD USD NZD SGD EUR GBP CAD HKD JPY MYR THB PHP ZAR IDR
                    
                //********** manipulate amount based on currency base unit according to pin payment gateway ends *****************
    
    return $amount;
}


function reconvertamountbasedoncurrbaselimit($amount,$currency_code)
{
    
    //********** manipulate amount based on currency base unit according to pin payment gateway starts *****************
         
                if($currency_code=="AUD")
                {
                    $amount=($amount/100);
                }
                elseif($currency_code=="USD")
                {
                    $amount=($amount/100);
                }
                elseif($currency_code=="NZD")
                {
                    $amount=($amount/100);
                }
                elseif($currency_code=="SGD")
                {
                    $amount=($amount/100);
                }
                elseif($currency_code=="EUR")
                {
                    $amount=($amount/100);
                }
                elseif($currency_code=="GBP")
                {
                    $amount=($amount/50);
                }
                elseif($currency_code=="CAD")
                {
                    $amount=($amount/100);
                }
                elseif($currency_code=="HKD")
                {
                    $amount=($amount/1000);
                }
                elseif($currency_code=="JPY")
                {
                    $amount=($amount/100);
                }
                elseif($currency_code=="MYR")
                {
                    $amount=($amount/300);
                }
                elseif($currency_code=="THB")
                {
                    $amount=($amount/2000);
                }
                elseif($currency_code=="PHP")
                {
                    $amount=($amount/3000);
                }
                elseif($currency_code=="ZAR")
                {
                    $amount=($amount/1000);
                }
                elseif($currency_code=="IDR")
                {
                    $amount=($amount/1000000);
                }
                
                
         
                //AUD USD NZD SGD EUR GBP CAD HKD JPY MYR THB PHP ZAR IDR
                    
                //********** manipulate amount based on currency base unit according to pin payment gateway ends *****************
    
    return $amount;
}


//******** for making  bank   payment  starts *****************

//*** function to create bank account token starts

function createbankaccounttoken($liveortestmode='test',$postparamar=array())
{
    
        $url = 'https://test-api.pin.net.au/1/bank_accounts'; // default is TEST  
    
        if($liveortestmode=="live")
        {           
             $url = 'https://api.pin.net.au/1/bank_accounts'; 
        }
    

        //url-ify the data for the POST
    $fields_string='';
        foreach($postparamar as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        //curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        //curl_setopt($ch, CURLOPT_USERPWD, $secretkeydata.":");


        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        //close connection
        curl_close($ch);


        $respfromgateway=json_decode($server_output,true);
        //echo "result=><pre>"; print_r($respfromgateway); echo "<pre>";

        $flagresp=0;
        $message=''; $ermessagear=array();

        $succrespdataar=array(); $respdataar=array();

        if(!empty($respfromgateway))
        {
            if(array_key_exists('response',$respfromgateway) && !empty($respfromgateway['response']) )
            {
                $responsear=$respfromgateway['response'];

                $token=$responsear['token']; // bank account token
                $name=$responsear['name']; // account holder name
                $bsb=$responsear['bsb']; //The BSB (Bank State Branch) code of the bank account
                $number=$responsear['number']; // Bank account number 
                $bank_name=$responsear['bank_name']; // Bank Name
                $branch=$responsear['branch']; // Bank Branch       
               
                $succrespdataar['token']=$token;
                $succrespdataar['name']=$name;
                $succrespdataar['bsb']=$bsb;
                $succrespdataar['number']=$number;
                $succrespdataar['bank_name']=$bank_name;
                $succrespdataar['branch']=$branch;
                
                
                
                if(!empty($token))
                {
                    $flagresp=1;
                }


            }
            elseif(array_key_exists('error',$respfromgateway))
            {
               
               
               // echo "<pre>"; print_r($respfromgateway);

                if( array_key_exists('messages',$respfromgateway) && !empty($respfromgateway['messages']))
                {
                    $responseerrmessgar=$respfromgateway['messages'];

                    if(!empty($responseerrmessgar))
                    {
                        foreach($responseerrmessgar as $ermsgar)
                        {
                            $ermessagear[]=$ermsgar['message'];

                        }

                    }
                    

                }
                elseif( array_key_exists('error_description',$respfromgateway) &&  !empty($respfromgateway['error_description']))
                    {
                        
                       
                        $ermessagear[]=$respfromgateway['error_description'];
                    }


                if(!empty($ermessagear))
                {

                    $message=implode("<br>",$ermessagear);
                }



            }


        }

        $respdataar['flagresp']=$flagresp;
        $respdataar['succrespdataar']=$succrespdataar;
        $respdataar['message']=$message;
        $respdataar['errormessagear']=$ermessagear;

        return $respdataar;

}
//*** function to create bank account token ends

//*** function to create recipient token starts

function createbankaccountrecipienttoken($liveortestmode='test',$postparamar=array(),$secretkeydata)
{
    
        $url = 'https://test-api.pin.net.au/1/recipients'; // default is test  
    
        if($liveortestmode=="live")
        {           
             $url = 'https://api.pin.net.au/1/recipients'; 
        }
    

        //url-ify the data for the POST
    $fields_string='';
        foreach($postparamar as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        //curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_USERPWD, $secretkeydata.":");


        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        //close connection
        curl_close($ch);


        $respfromgateway=json_decode($server_output,true);
        //echo "recei result=><pre>"; print_r($respfromgateway); echo "<pre>";

        $flagresp=0;
        $message=''; $ermessagear=array();

        $succrespdataar=array(); $respdataar=array();

        if(!empty($respfromgateway))
        {
            if(array_key_exists('response',$respfromgateway) && !empty($respfromgateway['response']) )
            {
                $responsear=$respfromgateway['response'];

                $token=$responsear['token']; // recipients_token
                $name=$responsear['name']; // recipient name
                $email=$responsear['email']; // email
                     
               
                $succrespdataar['token']=$token;
                $succrespdataar['name']=$name;
                $succrespdataar['email']=$email;
                
               
                
                if(!empty($token))
                {
                    $flagresp=1;
                }


            }
            elseif(array_key_exists('error',$respfromgateway))
            {
               
               
               // echo "<pre>"; print_r($respfromgateway);

                if( array_key_exists('messages',$respfromgateway) && !empty($respfromgateway['messages']))
                {
                    $responseerrmessgar=$respfromgateway['messages'];

                    if(!empty($responseerrmessgar))
                    {
                        foreach($responseerrmessgar as $ermsgar)
                        {
                            $ermessagear[]=$ermsgar['message'];

                        }

                    }
                    

                }
                elseif( array_key_exists('error_description',$respfromgateway) &&  !empty($respfromgateway['error_description']))
                    {
                        
                       
                        $ermessagear[]=$respfromgateway['error_description'];
                    }


                if(!empty($ermessagear))
                {

                    $message=implode("<br>",$ermessagear);
                }



            }


        }

        $respdataar['flagresp']=$flagresp;
        $respdataar['succrespdataar']=$succrespdataar;
        $respdataar['message']=$message;
        $respdataar['errormessagear']=$ermessagear;

        return $respdataar;

}
//*** function to create recipient account token ends

//*** function to tannsfer money to recipient account after getting recipient token starts

function transferamounttorecipient($liveortestmode='test',$postparamar=array(),$secretkeydata)
{
    
        $url = 'https://test-api.pin.net.au/1/transfers'; // default is test  
    
        if($liveortestmode=="live")
        {           
             $url = 'https://api.pin.net.au/1/recipients'; 
        }
    

        //url-ify the data for the POST
    $fields_string='';
        foreach($postparamar as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        //curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_USERPWD, $secretkeydata.":");


        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        //close connection
        curl_close($ch);


        $respfromgateway=json_decode($server_output,true);
        //echo "recei result=><pre>"; print_r($respfromgateway); echo "<pre>";

        $flagresp=0;
        $message=''; $ermessagear=array();

        $succrespdataar=array(); $respdataar=array();

        if(!empty($respfromgateway))
        {
            if(array_key_exists('response',$respfromgateway) && !empty($respfromgateway['response']) )
            {
                $responsear=$respfromgateway['response'];

                $token=$responsear['token']; // transfer token
                $status=$responsear['status']; // status
                $currency=$responsear['currency']; // currency
                $description=$responsear['description']; // description
                $amount=$responsear['amount']; // amount
                     
               
                $succrespdataar['token']=$token;
                $succrespdataar['status']=$status;
                $succrespdataar['currency']=$currency;
                $succrespdataar['description']=$description;
                $succrespdataar['amount']=$amount;
                
               
                
                if(!empty($token))
                {
                    $flagresp=1;
                }


            }
            elseif(array_key_exists('error',$respfromgateway))
            {
               
               
               // echo "<pre>"; print_r($respfromgateway);

                if( array_key_exists('messages',$respfromgateway) && !empty($respfromgateway['messages']))
                {
                    $responseerrmessgar=$respfromgateway['messages'];

                    if(!empty($responseerrmessgar))
                    {
                        foreach($responseerrmessgar as $ermsgar)
                        {
                            $ermessagear[]=$ermsgar['message'];

                        }

                    }
                    

                }
                elseif( array_key_exists('error_description',$respfromgateway) &&  !empty($respfromgateway['error_description']))
                    {
                        
                       
                        $ermessagear[]=$respfromgateway['error_description'];
                    }


                if(!empty($ermessagear))
                {

                    $message=implode("<br>",$ermessagear);
                }



            }


        }

        $respdataar['flagresp']=$flagresp;
        $respdataar['succrespdataar']=$succrespdataar;
        $respdataar['message']=$message;
        $respdataar['errormessagear']=$ermessagear;

        return $respdataar;

}
//*** function to tannsfer money to recipient account after getting recipient token ends




//******** for making  bank payment  ends *****************

?>