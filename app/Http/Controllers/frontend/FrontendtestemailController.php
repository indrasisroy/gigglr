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
use Cookie;
use Response;
use View;
use Mail;

class FrontendtestemailController extends Controller
{
      function checkchronmail(Request $request)
        {
            
            //*** send mail starts
            
            $body = "Hello mail is getting fired from from cron-".time(); //email body
            
            $passarr['adminfrom']="soumik@esolzmail.com";
            $passarr['emailsub']="prosessional cron mail test ".rand();
            $passarr['emailto']="indrasis.roy@esolzmail.com";
            $passarr['sitename']="prosessional"; $replacefrom=array(); $replaceto=array();
            $data = array(
            'replacefrom'=>$replacefrom,'replaceto'=>$replaceto,'email_body'=>$body
            );
            $chkmail= Mail::send('emails.emailviewfolder.commonemailtenplate', $data, function ($message) use ($passarr)
            {
            
                $message->from($passarr['adminfrom'], $passarr['sitename']);            
                $message->to($passarr['emailto'])->subject($passarr['emailsub']);
            
            }
                                
            );
                 
            //*** send mail ends
            
        }


        function checklatlongvaluefrtst(Request $request)
        {
            // echo "asdasd";die;
            // $getLatlong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=sydney&key=AIzaSyDWE3PmXCnLTLvI8526Lo1U_GiYcVLuzBA');
            // //echo $getLatlong;
            // $getOutput= json_decode($getLatlong);
            // print_r($getOutput);
              return view('front.testlatlng.testview');




            


        }

        function phpinfocheckfunc(Request $request)
        {
            echo date("Y-m-d H:i:s");
            // Show all information, defaults to INFO_ALL
            phpinfo();
        }
    
    
        function checktimezonedata(Request $request){
            
            $curr_date_time=date("Y-m-d H:i:s");  
            $cur_php_serv_tz=date_default_timezone_get();
            
            echo " <br> Current PHP server (Australia/Sydney) respective date time : ".$curr_date_time;
            echo "<br> PHP server tz=>".$cur_php_serv_tz;
            
            $dttm=$curr_date_time;
            $ftmzn="Australia/Sydney";
            $ttmzn="UTC";
            
            
            $curdttmtzAr= convertdatetothistz($dttm,$ftmzn,$ttmzn,$cnvrtdtdrmt='Y-m-d H:i:s');
            $evnt_tz_curdttime='';
            if(array_key_exists('converteddatetime',$curdttmtzAr))
            {
                $evnt_tz_curdttime=$curdttmtzAr['converteddatetime'];
            }
            
            $date = new \DateTime(''.$curr_date_time.' Australia/Sydney');
            echo "<br> Australia/Sydney daylight active status=>". $date->format('I');
            
            echo " <br> Date time ".$curr_date_time." => converted from  (Australia/Sydney) to UTC : ".$evnt_tz_curdttime;
            
            
            echo "<br> ************************************************************************ <br>";
            
            date_default_timezone_set("UTC");
            $cur_php_serv_tz=date_default_timezone_get();
            $curr_date_time=date("Y-m-d H:i:s");  
            echo " <br> Current PHP server (UTC) respective date time : ".$curr_date_time;
            echo "<br> PHP server tz=>".$cur_php_serv_tz;
            
            $cust_date_tm="2017-03-14 16:50:20";
            
            
             $dttm=$cust_date_tm;
            $ftmzn="Australia/Sydney";
            $ttmzn="UTC";
            
            
            $curdttmtzAr= convertdatetothistz($dttm,$ftmzn,$ttmzn,$cnvrtdtdrmt='Y-m-d H:i:s');
            $evnt_tz_curdttime='';
            if(array_key_exists('converteddatetime',$curdttmtzAr))
            {
                $evnt_tz_curdttime=$curdttmtzAr['converteddatetime'];
            }
            
              echo " <br> Date time ".$cust_date_tm." => converted from  (Australia/Sydney) to UTC : ".$evnt_tz_curdttime;
            
            
            echo "<br> ************************************************************************ <br>";
            
            
            $winter = date_create('2017-10-21', timezone_open('Australia/Sydney'));
            $summer = date_create('2017-06-21', timezone_open('Australia/Sydney'));

            $offset_wntr=date_offset_get($winter)/3600;
            $offset_sumr=date_offset_get($summer)/3600;
            
            echo "<br> Australia/Sydney 2017-10-21 winter offset in terms of UTC/GMT=>".$offset_wntr;
            echo "<br> Australia/Sydney 2017-06-21 summer offset in terms of UTC/GMT=>".$offset_sumr;
       
            
            echo "<br>=winter=>".date_offset_get($winter) . "\n";
            echo "<br>=summer=>".date_offset_get($summer) . "\n";
            
            
             echo "<br> ************************************************************************ <br>";
            
            
            $winter = date_create('2017-12-21', timezone_open('America/New_York'));
            $summer = date_create('2017-06-21', timezone_open('America/New_York'));

            $offset_wntr=date_offset_get($winter)/3600;
            $offset_sumr=date_offset_get($summer)/3600;
            
            echo "<br> America/New_York 2017-12-21 winter offset in terms of UTC/GMT=>".$offset_wntr;
            echo "<br> America/New_York summer 2017-06-21 offset in terms of UTC/GMT=>".$offset_sumr;
       
            
            echo "<br>=winter=>".date_offset_get($winter) . "\n";
            echo "<br>=summer=>".date_offset_get($summer) . "\n";
            
            $hellodata=-10000;
            echo "==<br>hellodata=>".intval($hellodata);
            
            
            
        }
    
}