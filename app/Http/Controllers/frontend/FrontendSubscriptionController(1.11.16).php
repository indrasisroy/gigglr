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

class FrontendSubscriptionController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    
    public function index(Request $request)
    {
        $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
        
        $date_data=date("Y-m-d H:i:s"); 
        $email = addslashes(trim($request->input('email','')));
        
        $dataInsert=array();
        $dataUpdt=array();
        
        $dataInsert['email']=$email;
        $dataInsert['create_date']=$date_data;
        $dataInsert['deactivate_date']="0000-00-00 00:00:00";

        $chkvalid=$this->checksubscriberform($request);
        
        if($chkvalid===true)
        {
            $user_master_db1 = DB::table('subscription as ss');
            $user_master_db1=$user_master_db1->select(DB::raw('ss.id,ss.status'));
            $user_master_db1=$user_master_db1->where('ss.email', $email);
            $user_master_db1=$user_master_db1->first();
            
            if(!empty($user_master_db1))
            {
                $ssstatus=$user_master_db1->status;
                
                if($ssstatus!=1){
                    $ssid=$user_master_db1->id;
                    $dataUpdt['create_date']=$date_data;
                    $dataUpdt['status']='1';
                    $isInserted= DB::table('subscription')->where('id',$ssid) ->update($dataUpdt);
                }
            }
            else
            {
                $isInserted = DB::table('subscription')->insert($dataInsert);
            }
            $flag_id=$isInserted;
            
            if($isInserted > 0 )
            {
                //*******email code starts here
                
                $userssel = DB::table('settings')
                      ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                      ->where('id', 1)
                      ->get();
                $sitename=$userssel[0]->site_name;
                $emailfrom=$userssel[0]->email_from;
                $copyright_year=$userssel[0]->copyright_year;
                $Imgologo=$userssel[0]->email_template_logo_image;
                $bsurl = url('/');
                $logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
                
                //*********Helper Function Starts here
                $replacefrom =array('{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                $replaceto =array($sitename,$copyright_year,$bsurl,$logoIMG);
              
                mailsnd($Temid=9,$replacefrom,$replaceto,$email);
                //*********Helper Function Ends here 
                
                //****** mail code ends here
            }
        }
        else
        {                 
                $error_message = $chkvalid->messages();
        }
        
        if(!empty($error_message))
        {
            $error_message=json_decode(json_encode($error_message));
          
            foreach($error_message as $kk => $error_message_ar)
            {
             $error_msgAr[$kk]=implode("<br>",$error_message_ar);    
            }
          
        }

        $responseAr['flag_id']=$flag_id;
        $responseAr['error_message']=$error_msgAr;

        echo json_encode($responseAr);
    }
    
    public function checksubscriberform($request)
    {
       
        $validator = Validator::make($request->all(), [
                        'email' => "required|email"                    
                    ],[
                       'email.required'=>'* Email is required',
                       'email.email'=>'* Enter valid email',   
                    ]);
        
        $userData=array();
        $userData['request']=$request;
               
        $validator->after(function($validator)  use ($userData)  {
                        
            $request=$userData['request'];

            //***** here
            $validatefilechk=$this->subscriberinvalid($request);
    
            if (!empty($validatefilechk))
            {
                $validator->errors()->add('subscriberemail', $validatefilechk);
            }
            //***** here
        });
        
        if ($validator->fails())
        {
            return $validator;
        }
        return true;
    }
   
    
    public function subscriberinvalid($request)
    {
        $mail=$request->input('email');
        
        $errorMsg=array();
        
        $user_master_db = DB::table('subscription as ss');
        $user_master_db=$user_master_db->select(DB::raw('ss.id,ss.status'));
        $user_master_db=$user_master_db->where('ss.email', $mail);
        $user_master_db=$user_master_db->first();
        
        if(!empty($user_master_db))
        {             
            $status=$user_master_db->status;
            if($status==1)
            {
                $errorMsg[]=" You have already subscribed earlier! ";
            }
        }
        
        $errorMsgStr='';
        if(!empty($errorMsg))
        {
           
           foreach($errorMsg as $errorMsgData)
           {
             $errorMsgStr.=" <br>".$errorMsgData;
           }
        }
        
        $responseAr=array();
        $responseAr['errormsgs']=$errorMsgStr;
         
        return $errorMsgStr;
    }
}