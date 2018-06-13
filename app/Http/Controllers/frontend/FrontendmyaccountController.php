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
//use Request;


class FrontendmyaccountController extends Controller
{
   
    public function index(Request $request)
    {

        $datamyaccount=array();
        
        //***** for user details my account starts ************
        $sess_id = $request->session()->get('front_id_sess');
        
        if($sess_id!=''){
        $getUser = DB::table('user_master as user');
        //$getUser = $getUser->where('user.status', 1);
        $getUser = $getUser->where('user.id', $sess_id);        
        $datamyaccount['userdetails'] = $getUser->first();

        //***** for user details my account ends ************
        
        if($datamyaccount['userdetails']->status=="2"){
             return redirect('/editprofile');
        }
        
        //***** for get user_master_img starts ************
        $getuser_master_img = DB::table('user_master_img as img');
        $getuser_master_img = $getuser_master_img->where('img.default_status', 1);
        $getuser_master_img = $getuser_master_img->where('img.user_id', $sess_id);        
        $datamyaccount['img'] = $getuser_master_img->first();
        //***** for get user_master_img ends ************
        
        //***** for location country starts ************
        $getcountry = DB::table('location_country as country');
        $getcountry = $getcountry->where('country.published', 1);
        $datamyaccount['country'] = $getcountry->get();
        //***** for location country ends ************

        //***** for location state starts ************
        $getstate = DB::table('location_state as state');
        $getstate = $getstate->where('country_id',$datamyaccount['userdetails']->country);
        $datamyaccount['state'] = $getstate->get();
        //***** for location country ends ************
 
        //***** for get referral_email starts ************
        $getreferral_email = DB::table('referral_email as email');
        $getreferral_email = $getreferral_email->where('email.user_id', $sess_id);        
        $datamyaccount['getemail'] = $getreferral_email->first();
        //***** for get referral_email ends ************
        
        //***** for get language starts ************
        $getlanguage = DB::table('language as lang');
        $getlanguage = $getlanguage->where('lang.status', 1);        
        $datamyaccount['language'] = $getlanguage->get();
        //***** for get language ends ************
        
        //***** for get currency ************
        $datamyaccount['my_code'] = "";
        $datamyaccount['my_icon'] = "";
        if($datamyaccount['userdetails']->currency!='' && $datamyaccount['userdetails']->currency != "0"){
            $getcurrency = DB::table('location_country as currency');
            $getcurrency = $getcurrency->where('currency.id', $datamyaccount['userdetails']->currency)->first();       
            $datcurrency_code = $getcurrency->currency_code;
            $datcurrency_icon = $getcurrency->currency_icon;
            $datamyaccount['my_code'] = $datcurrency_code;
            $datamyaccount['my_icon'] = $datcurrency_icon; 
        }
        //***** for get currency ************
        
        //echo "<pre>";
        //print_r($datamyaccount);
        //echo "</pre>";
        //die;
        
        return view('front.user.myaccount',$datamyaccount);
        }else{
           return redirect('/'); ///editprofile
        }

    }
    
    //function checkcity(Request $request){
    //    $country = $request->input('country');
    //    $getstate = DB::table('location_state as state');
    //    $getstate = $getstate->where('state.country_id', $country);
    //    $dataLenth = $getstate->count();
    //    
    //    $getcountry = DB::table('location_country as country');
    //    $getcountry = $getcountry->where('country.id', $country)->first();
    //    
    //
    //    $dataState = $getstate->get();
    //    $arryListState = array();
    //    $arryListState['state']='';
    //    if($dataLenth > 0){
    //        for($i = 0;$i < $dataLenth;$i++){
    //            $arryListState['state'][$i]['state_id'] = $dataState[$i]->id;
    //            $arryListState['state'][$i]['state_name'] = $dataState[$i]->state_name;
    //        }  
    //    }
    //    $arryListState['country'] = $country;
    //    $arryListState['currency_code'] = $getcountry->currency_code;
    //    $arryListState['currency_icon'] = $getcountry->currency_icon;
    //    echo json_encode($arryListState); 
    //    
    //}
    
        function checkcity(Request $request){
        $country = $request->input('country');
        $getstate = DB::table('location_state as state');
        $getstate = $getstate->where('state.country_id', $country);
        $dataLenth = $getstate->count();
        
        if($country!='' && $country!='0'){
            $getcountry = DB::table('location_country as country');
            $getcountry = $getcountry->where('country.id', $country)->first(); 
        }else{
            $getcountry = array();
        }

        

        $dataState = $getstate->get();
        $arryListState = array();
        $arryListState['state']='';
        if($dataLenth > 0){
            for($i = 0;$i < $dataLenth;$i++){
                $arryListState['state'][$i]['state_id'] = $dataState[$i]->id;
                $arryListState['state'][$i]['state_name'] = $dataState[$i]->state_name;
                $arryListState['state'][$i]['state_3_code'] = $dataState[$i]->state_3_code;
            }  
        }
        $arryListState['country'] = $country;
            $arryListState['currency_code'] = '';
            $arryListState['currency_icon'] = ''; 
        if(!empty($getcountry)){
            $arryListState['currency_code'] = $getcountry->currency_code;
            $arryListState['currency_icon'] = $getcountry->currency_icon; 
        }

        echo json_encode($arryListState); 
        
    }
    
    
    function referemail(Request $request){
        $ref_email = $request->input('ref_email');
        $sess_id = $request->session()->get('front_id_sess');
        
        $getUser = DB::table('user_master as user');
        $getUser = $getUser->where('user.email', $ref_email);
        $getUser = $getUser->where('user.status', 1);
        $getUserData = $getUser->first();
        
        
        $checkArry = array();
        if(!empty($getUserData)){
           if($getUserData->id==$sess_id){
            $checkArry['msg']="you";
           }else{
           $checkArry['msg']="ok";
           }
        }else{
           $checkArry['msg']="not";
        }
        echo json_encode($checkArry);
    }
        public function checkemailform($ref_email,$sess_id=0)
        {
                $validator = Validator::make($request->all(),
                        [
                                'title' => "required|unique:user_master,email,".$sess_id,
                        ],
                        [
                                'title.required'=>'*Title field required',
                                'title.unique'=>'*Title already present',
                        ]
                );
                   
                if ($validator->fails())
                {
                    return $validator;
                }
                    
                return true;
        }
        
        function checkpass(Request $request){
            $re_password =md5($request->input('re_password'));
            $sess_id = $request->session()->get('front_id_sess');
            
            $getUser = DB::table('user_master as user');
            $getUser = $getUser->where('user.password', $re_password);
            $getUser = $getUser->where('user.id', $sess_id);
            $getUserData = $getUser->first();

            $rtun='true';
            if(!empty($getUserData)){
                $rtun = 'true';
            }else{
                $rtun = 'false';
            }
            echo $rtun;
        }
        
        function myaccountfrmsubmit(Request $request){
        
        $flag_id = 0; $error_message=''; $responseAr=array(); $error_msgAr=array(); $myerror_message=array();$my_message=array();

        $sess_id = $request->session()->get('front_id_sess');
        $referemail =$request->input('referemail');
        $first_name =$request->input('first_name');
        $middle_name =$request->input('middle_name');
        $last_name =$request->input('last_name');
        $phone =$request->input('phone');
        $email =$request->input('email');
        $address1 =$request->input('address1');
        $address2 =$request->input('address2');
        $select_country =$request->input('select_country');
        $select_state =$request->input('select_state');
        $city =$request->input('city');
        $zip =$request->input('zip');
        $phone =$request->input('phone');
        $dobDays =$request->input('dobDays');
        $dobMonths =$request->input('dobMonths');
        $dobYears =$request->input('dobYears');
        $genderradio =$request->input('genderradio');
        $select_Language =$request->input('select_Language');
        $currency =$request->input('currency');
        
        $old_password =$request->input('old_password');
        $new_password =$request->input('new_password');
        $con_password =$request->input('con_password');

        $seo_name =$request->input('seo_name');
        
        
        //***** for location country starts ************
        $getcountry = DB::table('location_country')->where('id',$select_country);  
        $datacountry = $getcountry->first();
        
        //***** for location country ends ************

        //***** for location state starts ************
        $getstate = DB::table('location_state')->where('id',$select_state);
        $datastate = $getstate->first();
        //***** for location country ends ************
        $country_name = $datacountry->country_name;
        $state_name = $datastate->state_name;
        if($address2!=''){
            $fullAddress = $address1."+".$address2."+".$city."+".$state_name."+".$zip."+".$country_name;
        }else{
            $fullAddress = $address1."+".$city."+".$state_name."+".$zip."+".$country_name;
        }
        

        $latlog = getLatLong($fullAddress);
//echo $fullAddress;
//echo "<pre>";
//print_r($latlog);
//echo "</pre>";die;
        if($latlog['flag']!='0'){
                $final_latitude = $latlog['latlong'][0]['latitude'];
                $final_longitude = $latlog['latlong'][0]['longitude'];
                $timezone = getTimezone($final_latitude,$final_longitude);
                $final_timezone = $timezone['timeZoneId'];
        
                //************fer referral_email table insert start******************
                if($referemail!=''){
                    $getUser = DB::table('user_master as user');
                    $getUser = $getUser->where('user.email', $referemail);
                    $getUser = $getUser->where('user.status', 1);
                    $getUserData = $getUser->first();
                    $referId = $getUserData->id;
                    
                    $StaringDate = date('Y-m-d H:i:s');
                    $insert_data_referral_email['user_id']=$sess_id;
                    $insert_data_referral_email['emailid']=$referemail;
                    $insert_data_referral_email['referrer_userid']=$referId;
                    $insert_data_referral_email['referred_date']=$StaringDate;
                    $referral_expiry_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($StaringDate)) . " + 365 day"));
                    $insert_data_referral_email['referral_expiry_date']=$referral_expiry_date;
                    $insert_data_referral_email['active_status']= 1;
                    
                    $getUseremail = DB::table('referral_email as email');
                    $getUseremail = $getUseremail->where('email.user_id', $sess_id);
                    $arryCount = $getUseremail->count();
                    if($arryCount== 0){
                        //***************isert into referral_email table*********
        
                        $insert_data_referral_email['create_date']=$StaringDate;
                        
                        $isInserted = DB::table('referral_email')->insert($insert_data_referral_email);
                    }else{
                        //***************update referral_email table*********
                        $isInserted=DB::table('referral_email')->where('user_id', $sess_id)->update($insert_data_referral_email);
                        
                    }
                }
                $chkvalid=$this->checkMyAccountform($request,$sess_id);
                if($chkvalid===true)
                {
                    $update_data_user_master['first_name']=$first_name;
                    $update_data_user_master['middle_name']=$middle_name;
                    $update_data_user_master['last_name']=$last_name;
                    $update_data_user_master['phone']=$phone;
                    $update_data_user_master['email']=$email;
        
                    $dobFormated = date('Y-m-d',strtotime($dobYears."-".$dobMonths."-".$dobDays));
                    $update_data_user_master['dob']=$dobFormated;
                    
                    $update_data_user_master['address1']=$address1;
                    $update_data_user_master['address2']=$address2;
                    
                    $update_data_user_master['country']=$select_country;
                    $update_data_user_master['state']=$select_state;
                    $update_data_user_master['city']=$city;
                    $update_data_user_master['zip']=$zip;
                    $update_data_user_master['addr_lat']=$final_latitude;
                    $update_data_user_master['addr_long']=$final_longitude;
                    $update_data_user_master['addr_timezone']=$final_timezone;
                    
                    $update_data_user_master['gender']=$genderradio;
                    $update_data_user_master['language']=$select_Language;
                    $update_data_user_master['currency']=$currency;
                    $update_data_user_master['modified_date']=date('Y-m-d H:i:s');
        
                    //$update_data_user_master['seo_name']=$seo_name;

                    $changepasswordflag = '';
                    if($old_password!=''){
                        $old_password_normal =md5($old_password);
                        $getUser = DB::table('user_master as user');
                        $getUser = $getUser->where('user.password', $old_password_normal);
                        $getUser = $getUser->where('user.id', $sess_id);
                        $getUserData = $getUser->first();
                            if(!empty($getUserData) && ($new_password== $con_password)){
                                $update_data_user_master['password']=md5($new_password);
                                $changepasswordflag = '1';
                            }
                    }
                    
                    $update=DB::table('user_master')->where('id', $sess_id)->update($update_data_user_master);
                    
                    if($update && $changepasswordflag == '1')
                    {
                        //*************** send mail after change password ****************// 
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
    
                     
                        $replacefrom =array('{NAME}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
    
                        $replaceto =array(ucfirst($first_name),$sitename,$copyright_year,$bsurl,$logoIMG);
    
    
                        mailsnd($Temid=54,$replacefrom,$replaceto,$email);
                    }
                    //************Checking that user have any group************//
                    
                    $update_data_group_master = array();
                    $Checking=DB::table('group_master')->select('id')->where('creater_id', $sess_id)->first();
                    if($Checking){
                        $group_master_id = $Checking->id;
                        $update_data_group_master['address_1']=$address1;
                        $update_data_group_master['address_2']=$address2;
                        $update_data_group_master['country']=$select_country;
                        $update_data_group_master['state']=$select_state;
                        $update_data_group_master['city']=$city;
                        $update_data_group_master['zip']=$zip;
                        $update_data_group_master['group_lat']=$final_latitude;
                        $update_data_group_master['group_long']=$final_longitude;
                        $update_data_group_master['group_timezone']=$final_timezone;
                    $update=DB::table('group_master')->where('id', $group_master_id)->update($update_data_group_master);
                        
                    }
                    //$request->session()->flash('front_successmsgdata_sess', 'Your account have been deactivated successfully and you are successfully logged out.');
                    $flag_id = 1;
                }else{
                    $flag_id = 0;
                    $error_message = $chkvalid->messages();
                }
           
                //************fer referral_email table insert end******************
                
        
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
        }else{
                $responseAr['flag_id']= 3;

                $responseAr['error_message']="Please check that your address";
        }

        echo json_encode($responseAr);
    }
  
    public function checkMyAccountform($request,$sess_id=0)
    {
            $validator = Validator::make($request->all(),
                    [
                            'email' => "required|unique:user_master,email,".$sess_id,
                            //'seo_name'=> "required|unique:user_master,seo_name,".$sess_id,
                            'first_name'=> "required|regex:(^[a-zA-Z]+$)|max:50",
                            'middle_name'=> "regex:(^[a-zA-Z]+$)|max:50",
                            'last_name'=> "required|regex:(^[a-zA-Z]+$)|max:50",
                            'city' => "alpha_spaces|max:50",
                            'address1'=> "required",
                            'select_state'=> "required",
                            'select_country'=> "required",
                            'zip'=>"regex:(^(?:[0-9]+$))",
                            'phone'=> "required|numeric|min:1",
                            'genderradio'=> "required",
                            'select_Language'=> "required",
                            'currency'=> "required",    
                    ],
                    [
                            'email.required'=>'*Email name field required',
                            'email.unique'=>'*Email already present',
                            'zip.regex'=>'*Zip code field allows only numbers',
                            //'seo_name.required'=>'*SEO URL field required',
                            //'seo_name.unique'=>'*SEO URL already present',
                            'first_name.required'=>'*First name field required',
                            'first_name.regex'=>'*First name field can only contain letters and no spaces',
                            'first_name.max'=>'*First name length maximum 50',
                            'middle_name.regex'=>'*Middle name field can only contain letters and no spaces',
                            'middle_name.max'=>'*Middle name length maximum 50',
                            'city.max'=>'*City name length maximum 50',
                            'city.alpha_spaces'=>'*City name can only contain letters and spaces',
                            'last_name.required'=>'*Last name field required',
                            'last_name.regex'=>'*Last name field can only contain letters and no spaces',
                            'last_name.max'=>'*Last name length maximum 50',
                            'address1.required'=>'*Address field required',
                            'phone.required'=>'*Phone number field required',
                            'phone.numeric'=>'*Phone number must be numeric',
                            'phone.min'=>'*Phone number at least 10',
                            'genderradio.required'=>'*Gender field required',
                            'select_Language.required'=>'*Language field required',
                            'currency.required'=>'*Currency field required',
                            'select_state.required'=>'*State name field is required',
                            'select_country.required'=>'*Country name field is required',
                    ]
            );
               
            $userData=array();
            $userData['request']=$request;
            
            $validator->after(function($validator)  use ($userData)  {
              
                       $request=$userData['request'];
                       $validatepwdchk=$this->pwdformatisvalid($request);
                       
                       if (!empty($validatepwdchk))
                       {
                               $validator->errors()->add('password', $validatepwdchk);
                               // echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                       }
            });
            if ($validator->fails())
            {
                return $validator;
            }
                
            return true;
    }
    public function myaccountdeactivefrmsubmitfunc(Request $request){
        $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array(); $myerror_message=array();$my_message=array();
        $deactive_reason =$request->input('deactive_reason');
        $subscriptions =$request->input('subscriptions');
        $gig_notification =$request->input('gig_notification');
        $sess_id = $request->session()->get('front_id_sess');
        $current_date=date("Y-m-d H:i:s");
        $chkvalid=$this->checkMyAccountdeactiveform($request);
        
            if($chkvalid===true)
        {
            $checkSubSQL="SELECT user.* FROM `user_master` as user,`subscription` as sub WHERE user.`id`='".$sess_id."' and user.`email`=sub.`email` and sub.`status`=1";

            $checkSub= DB::select( DB::raw($checkSubSQL));
            
            $user_master_db1 = DB::table('user_master as user');
            $user_master_db1=$user_master_db1->select(DB::raw('user.email'));
            $user_master_db1=$user_master_db1->where('user.id', $sess_id);
            $user_master_db1=$user_master_db1->first();
            $emailto = $user_master_db1->email;
            
            if(empty($checkSub)){

            //*******insert into subscription table start*********//

            $dataInsert['email']=$emailto;
            $dataInsert['create_date']=$current_date;
            $dataInsert['deactivate_date']="0000-00-00 00:00:00";
            $dataInsert['status']=$subscriptions;
            $isInserted = DB::table('subscription')->insert($dataInsert);
            //*******insert into subscription table end*********//

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
                  
                    mailsnd($Temid=9,$replacefrom,$replaceto,$emailto);
                    //*********Helper Function Ends here 
                    
                    //****** mail code ends here
                }
                $my_message['type']=1;
                $my_message['text']="Your have successfully subscribed";
            }else{
                $my_message['type']=0;
                $my_message['text']="Your account is already subscribed";
            }
            $checkGigSQL="SELECT * FROM `gig_subscription` WHERE `user_id`='".$sess_id."'";

            $checkGig= DB::select( DB::raw($checkGigSQL));
            if(empty($checkGig)){
                
                //*******insert into gig_subscription table start*********//
                $data_gig_Insert['user_email']=$emailto;
                $data_gig_Insert['create_date']=$current_date;
                $data_gig_Insert['status']=$gig_notification;
                $data_gig_Insert['user_id']=$sess_id;
                $isInsertedToGig_subscription = DB::table('gig_subscription')->insert($data_gig_Insert);
                //*******insert into gig_subscription table end*********//
                if($isInsertedToGig_subscription > 0){
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
                  
                    mailsnd($Temid=11,$replacefrom,$replaceto,$emailto);
                    //*********Helper Function Ends here 
                    
                    //****** mail code ends here
                }   
            }//else{echo "error";die;}
            
            $dataUpdt['status']=2;
            $isUpdated= DB::table('user_master')->where('id',$sess_id)->update($dataUpdt);
            
            //*********create deactiveted showing msg start*******//
                if($isUpdated){
                    $my_message['type_deact']=1;
                    $my_message['text_deact']="Your account is successfully deactiveted";
                        
                        //if ($request->session()->has('front_id_sess'))
                        //{
                        //    $request->session()->forget('front_id_sess');    // this unsets the session variable
                        //    $this->delcook(); // delete all cookies when user logs out 
                        //}
                }else{
                    $my_message['type_deact']=0;
                    $my_message['text_deact']="Your account is not deactiveted";
                }
            //*********create deactiveted showing msg end*******//
            
            $user_deatcivate_reason_insert['user_id']=$sess_id;
            $user_deatcivate_reason_insert['deactivate_reason']=$deactive_reason;
            $user_deatcivate_reason_insert['create_date']=$current_date;
            
            $isInserted = DB::table('user_deatcivate_reason')->insert($user_deatcivate_reason_insert);
            $flag_id=1;
            
        }else{
            $error_message = $chkvalid->messages();
        }
        
        //*********create validation error showing msg start*******//
        if(!empty($error_message))
        {
            $error_message=json_decode(json_encode($error_message));
          
            foreach($error_message as $kk => $error_message_ar)
            {
             $error_msgAr[$kk]=implode("<br>",$error_message_ar);    
            }
          
        }
        //*********create validation error showing msg end*******//

        //*************Ths code for log out and deactive account start*******//
        if ($request->session()->has('front_id_sess'))
                   {
                        $request->session()->forget('front_id_sess');    // this unsets the session variable
                        $responseAr['session']=$request->session()->has('front_id_sess');
                        
                   }
                   else{
                        $responseAr['session']="not found";
                   }
        $request->session()->flash('front_successmsgdata_sess', 'Your account have been deactivated successfully and you are successfully logged out.');
        
        //*************Ths code for log out and deactive account end *******//

        $responseAr['flag_id']=$flag_id;
        $responseAr['error_message']=$error_msgAr;
        $responseAr['my_msg']=$my_message;
        
        echo json_encode($responseAr);
    }

    public function checkMyAccountdeactiveform($request)
    {
            $validator = Validator::make($request->all(),
                    [
                            'deactive_reason' => "required|max:200",    
                    ],
                    [
                            'deactive_reason.required'=>'*Email name field required',
                            'deactive_reason.max'=>'*Deactive reason lenth maximum 200',
                    ]
            );
               
            if ($validator->fails())
            {
                return $validator;
            }
                
            return true;
    }
    
    public function pwdformatisvalid($request){
               
               $errorMsg=array();
                $old_password =$request->input('old_password');
                $passdata=addslashes(trim($request->input('new_password','')));
                
                if($old_password!=''){
                    $pattern="/^(?=.{8,16})(?=[a-zA-Z0-9^\w\s]*)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
      
                    if(!preg_match($pattern,$passdata))
                    {
                               $errorMsg[]="Password should contain atleast one uppercase, one lowercase, one digit and between 8 - 16 characters";  
                    }
                }
               
               

               
               $errorMsgStr='';
               
               if(!empty($errorMsg))
               { 
                          foreach($errorMsg as $errorMsgData)
                          {
                                     $errorMsgStr.=$errorMsgData;
                          }
               }
               
               $responseAr=array();
               $responseAr['errormsgs']=$errorMsgStr; 
               return $errorMsgStr;   
               
    }
    
}