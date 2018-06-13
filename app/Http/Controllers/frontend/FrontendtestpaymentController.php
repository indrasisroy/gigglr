<?php


namespace App\Http\Controllers\frontend;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//use App\User
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;
use View;
use Mail;

class FrontendtestpaymentController extends Controller
{
    
    public function refundtest(Request $request)
        {
            $charge_token="ch_zyBOWtQ3WGszx0BlSbOcqg";
        
            $refund_token="rf_aBcGX8whDptVx-y9sNawbg";

        
            $payment_type='test';
            $secret_key="lkCmlBsCkO92zz5yaYbALg";

            // $chkrefund=create_refund($refund_token,$payment_type, $secret_key);

            //echo "<pre>"; print_r($chkrefund); echo "</pre>";

            //Create Refund POST For Charges Token
            

            $fields_string = '';
            $amount=1;
            $amount=convertamountbasedoncurrbaselimit($amount,'AUD');   
            //echo "<br>==amount=>".$amount;             
            $postparamar=array("amount"=>$amount);
        
           $postparamar=array();
           //$chk_ref= create_refund($charge_token, $payment_type, $secret_key,$postparamar);
        
           //echo "<pre>"; print_r($chk_ref); echo "</pre>";
        
                    /*

                    success response=>  Array
        (
            [flagresp] => 2
            [succrespdataar] => Array
                (
                    [token] => rf_8kf0A4qG1eJb29r8TxGx4g
                    [success] => 
                    [status_message] => Pending
                    [amount] => 100
                    [currency] => AUD
                    [charge_token] => ch_-X25DUYd4XWjpezMjU3CVA
                )

            [message] => 
            [errormessagear] => Array
                (
                )

        )


        errror response => 

        Array
        (
            [flagresp] => 0
            [succrespdataar] => Array
                (
                )

            [message] => Charge You have tried to refund more than the original charge
            [errormessagear] => Array
                (
                    [0] => Charge You have tried to refund more than the original charge
                )

        )



                    */
        
        
            $chk_ref_status=     check_charges_status($refund_token, $payment_type, $secret_key);
        
           echo "chk_ref_status=><pre>"; print_r($chk_ref_status); echo "</pre>";
        
        
        /*
        
        success response=>
        
        Array
(
    [flagresp] => 1
    [succrespdataar] => Array
        (
            [success] => 1
            [status_message] => Success
            [amount] => 500
            [currency] => AUD
            [charge_token] => ch_-X25DUYd4XWjpezMjU3CVA
            [amount_refunded] => 200
            [total_fees] => 39
            [merchant_entitlement] => 461
            [refund_pending] => 1
            [captured] => 1
            [settlement_currency] => AUD
        )

    [message] => 
    [errormessagear] => Array
        (
        )

)
        
        
        */
        
        
        }
    
    public function getservertimezone(Request $request)
        {
            $servertimezn=date_default_timezone_get();
            $time="2017-01-16 15:00:00";
            $fromTz=$servertimezn;
            $toTz="Australia/Sydney";
        echo "=servertimezn=>".$servertimezn;
        			// timezone by php friendly values
        
            
			$date = new \DateTime($time, new \DateTimeZone($fromTz));
			$date->setTimezone(new \DateTimeZone($toTz));
			$time= $date->format('Y-m-d H:i:s');
			echo $time;
        
        }
    
   
    
   
}