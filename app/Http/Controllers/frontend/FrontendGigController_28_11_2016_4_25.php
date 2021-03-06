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
use App\Customlibrary\Imageuploadlib;
class FrontendGigController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    
     public function index(Request $request)
    {
     //return view('front.includefolder.gigapostmodal');
     $view_obj = View::make('front.includefolder.gigapostmodal');
     $ep_view_contents = $view_obj->render();
     
     $resp_arr=array();
     $resp_arr['ep_contents']=$ep_view_contents;
     
     echo json_encode($resp_arr);
    }
    public function getAllSkillParent(Request $request){
      $Gigtype = $request->input('Gigtype');
      $parentskillSql = "SELECT * FROM `skill_master` where FIND_IN_SET('".$Gigtype."',`catag_type`) and `parent_id`=0";
      $GroupSkill = DB::select( DB::raw($parentskillSql));
      echo json_encode($GroupSkill);
      
    }
    public function gigsubskill(Request $request){
      $catag_type = $request->input('catag_type');
      $skill_parent_data = $request->input('parent_id');
      $parentsubskillSql = "SELECT * FROM `skill_master` where FIND_IN_SET('".$catag_type."',`catag_type`) and `parent_id`!=0 and `parent_id`='".$skill_parent_data."'";
      $GroupSubSkill = DB::select( DB::raw($parentsubskillSql));
      echo json_encode($GroupSubSkill);
    }
    public function getCountryDataGig(Request $request){
      $parentcountrySql = "SELECT `id`,`country_name` FROM `location_country` WHERE `published`='1'";
      $GigCountrykill = DB::select( DB::raw($parentcountrySql));
      echo json_encode($GigCountrykill);
    }
    public function getgigstate(Request $request){
      $country_data = $request->input('country_data');
      $parentcountrySql = "SELECT `id`,`state_name`,`state_3_code` FROM `location_state` WHERE `country_id`='".$country_data."'";
      $GigCountrykill = DB::select( DB::raw($parentcountrySql));
      echo json_encode($GigCountrykill);
    }
    function insert_gig_notify($eventType,$tble1,$tble1As,$tbleWhere,$tble2,$tble2As,$cat,$sub,$sess_id,$user_type,$LastInsertedId){
      
      $sqlQuery = "SELECT ".$tble1As.".`id`,".$tble2As.".`".$tbleWhere."` FROM `".$tble1."` as ".$tble1As.", `".$tble2."` as ".$tble2As." WHERE ".$tble1As.".`id`=".$tble2As.".`".$tbleWhere."` and ".$tble2As.".`skill_id` = '".$cat."' and  ".$tble2As.".`skill_sub_id` = '".$sub."' and (".$tble1As.".`available_for`='3' or ".$tble1As.".`available_for`='".$eventType."')";
      
      $GigNotifyResult = DB::select( DB::raw($sqlQuery));

      foreach($GigNotifyResult as $GigNotify){
          $Insertgig_notify = array(
          'gigmaster_id'=>$LastInsertedId,
          'member_id'=>$GigNotify->id,
          'booker_id'=>$sess_id,
          'type_flag'=>$user_type,
          'gigpostrequestflag'=>1,
          'create_date'=>date('Y-m-d H:i:s'),
          'modified_date'=>date('Y-m-d H:i:s'),
          'status'=>'1'
          );
          $isInsertedId = DB::table('gig_notify')->insert($Insertgig_notify);
      }

    }
    public function gig_master_post_submit(Request $request){
            
      $gig_description = addslashes(trim($request->input('gig_description')));
      $eventType = addslashes(trim($request->input('eventType')));
      $sess_id = addslashes(trim($request->input('loginID')));
      $user_type = addslashes(trim($request->input('user_type')));
      $address1val =  $request->input('address1val');
      $address2val =  $request->input('address2val');
      $countrydata =  $request->input('countrydata');
      $statelistdata =  $request->input('statelistdata');
      $city =  $request->input('towndata');
      $zipdata=  $request->input('zipdata');
      $bookingcat_subdata =  $request->input('bookingcat_subdata');
      $bookinggenre_subdata =  $request->input('bookinggenre_subdata');
      
      $booking_datedata =  $request->input('booking_datedata');
      $start_timedata =  $request->input('start_timedata');
      $end_timedata =  $request->input('end_timedata');
      $requestexpireddatedata =  $request->input('requestexpireddatedata');
      $requestexpiredtimedata =  $request->input('requestexpiredtimedata');
      
      $security_paymentdata =  $request->input('security_paymentdata');
      $total_paymentdata =  $request->input('total_paymentdata');
      //********************** Server site validation ******************************//
      $chkvalid=$this->checksavepostagig($request);
      $flag_id = 0;
      if($chkvalid===true)
      {
            //***** for location country starts ************
            $getcountry = DB::table('location_country')->where('id',$countrydata);  
            $datacountry = $getcountry->first();
            
            //***** for location country ends ************
            
            //***** for location state starts ************
            $getstate = DB::table('location_state')->where('id',$statelistdata);
            $datastate = $getstate->first();
            //***** for location country ends ************
            $country_name = $datacountry->country_name;
            $state_name = $datastate->state_name;
            $fullAddress = $address1val."+".$address2val."+".$city."+".$state_name."+".$zipdata."+".$country_name;
      
            $latlog = getLatLong($fullAddress);
            if($latlog['flag']=='1'){
                $final_latitude = $latlog['latlong'][0]['latitude'];
                $final_longitude = $latlog['latlong'][0]['longitude'];
                $timezone = getTimezone($final_latitude,$final_longitude);
                $final_timezone = $timezone['timeZoneId'];
          
                //$unicId = "GIG-".uniqid();
                
                $crdt = date('Y-m-d H:i:s');
          
                //*****convert time into mysql format starts here
                
                //*********booking request date time
                $ttt= explode("/",$booking_datedata);
                $bkngdate = $ttt[2].'-'.$ttt[1].'-'.$ttt[0];
                
                $r =  date("G:i", strtotime($start_timedata));
                $strttim = date('H:i:s',strtotime($r));
                
                $r1 =  date("G:i", strtotime($end_timedata));
                $endtim = date('H:i:s',strtotime($r1));
                
                $reqt= explode("/",$requestexpireddatedata);
                $bkngexpirdate = $reqt[2].'-'.$reqt[1].'-'.$reqt[0];
                
                $r2 =  date("G:i", strtotime($requestexpiredtimedata));
                $expirtim = date('H:i:s',strtotime($r2));
                
                $bokingexpired = $bkngexpirdate.' '.$expirtim;

                  $Insertgig_master = array(
                  //'giguniqueid' => $unicId,
                  'gigpostrequestflag'=>'1',
                  'event_type'=>$eventType,
                  'type_flag'=>$user_type,
                  'artist_id'=>0,
                  'booker_id'=>$sess_id,
                  'event_address1'=>$address1val,
                  'event_address2'=>$address2val,
                  'event_city'=>$city,
                  'event_state'=>$statelistdata,
                  'event_country'=>$countrydata,
                  'event_zip'=>$zipdata,
                  'event_address_lat'=>$final_latitude,
                  'event_address_long'=>$final_longitude,
                  'event_date'=>$bkngdate,
                  'event_start_time'=>$strttim,
                  'event_start_date_time'=>$bkngdate." ".$strttim,
                  'event_end_date_time'=>$bkngdate." ".$endtim,
                  'event_end_date'=>$bkngdate,
                  'event_end_time'=>$endtim,
                  'request_expire_date'=>$bkngexpirdate,
                  'request_expire_time'=>$expirtim,
                  'request_expire_datetime'=>$bokingexpired,
                  'booking_req_date'=>$crdt,
                  'event_timezone'=>$final_timezone,
                  'booking_status'=>'2',
                  'artist_security_deposit'=>$security_paymentdata,
                  'total_amount'=>$total_paymentdata,
                  'gig_description'=>$gig_description,
                  );
        
                  $LastInsertedId = DB::table('gig_master')->insertGetId($Insertgig_master);
                  
                  
                  //************ creat new gig_unique id start**********//
                  $appenduniqiddata=100000+$LastInsertedId;
                  if($user_type == '2'){
                    $update_gig_master['giguniqueid']="GIG-G".$appenduniqiddata;
                  }else if($user_type == '1'){
                    $update_gig_master['giguniqueid']="GIG-A".$appenduniqiddata;
                  }
                  $is_gig_master = DB::table('gig_master')->where('id',$LastInsertedId)->update($update_gig_master); 
                  //************ creat new gig_unique id end**********//
                  
                  
                  
                  $bookerdetail = DB::table('user_master')
                  ->select('first_name','middle_name','last_name','email')
                  ->where('id', $sess_id)
                  ->get();
                  $booker_name = $bookerdetail[0]->first_name." ".$bookerdetail[0]->middle_name." ".$bookerdetail[0]->last_name;
                  $booker_email = $bookerdetail[0]->email;
                  //*************fetching skill start************//
                  $skilldetail = DB::table('skill_master')
                  ->select('name')
                  ->where('id', $bookingcat_subdata)
                  ->get();
                  $userssel = DB::table('settings')
                  ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                  ->where('id', 1)
                  ->get();
                  
                  $sitename=$userssel[0]->site_name;
                  $emailfrom=$userssel[0]->email_from;
                  $copyright_year=$userssel[0]->copyright_year;
                  $Imgologo=$userssel[0]->email_template_logo_image;
                  $bsurl = url('/');
        
                  //$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
                  $logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
                  //*********Helper Function Starts here
                  $replacefrom =array('{User}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                  $replaceto =array(ucfirst($booker_name),$sitename,$copyright_year,$bsurl,$logoIMG);
        
                  mailsnd($Temid=16,$replacefrom,$replaceto,$booker_email);
                  
                  //****************insert into gig_notify table***********//
                  if($user_type == '1'){
                    $this->insert_gig_notify($eventType,"user_master","usr_mstr","user_id","user_skill_rel","usr_skl",$bookingcat_subdata,$bookinggenre_subdata,$sess_id,$user_type,$LastInsertedId);
                  }else{
                    $this->insert_gig_notify($eventType,"group_master","grp_mstr","group_id","group_skill_rel","grp_skl",$bookingcat_subdata,$bookinggenre_subdata,$sess_id,$user_type,$LastInsertedId);
                  }

                  //***************insert into gig_skill_rel table***********//
                  $Insertgig_skill_rel = array(
                  'gigmaster_id'=>$LastInsertedId,
                  'category'=>$bookingcat_subdata,
                  'genre'=>$bookinggenre_subdata,
                  'type_flag'=>$user_type,
                  'create_date'=>date('Y-m-d H:i:s')
                  );
                  $isInsertedId = DB::table('gig_skill_rel')->insert($Insertgig_skill_rel);
                  $returnArray['flagdata'] = '1';
                  // $returnArray['message'] = 'Booking request posted successfully.';
                   $returnArray['message'] = 'Gig posted successfully.';
                
                }else{
                    $returnArray['flagdata'] = '02';
                    $returnArray['message'] = 'Please enter proper address';
                }
      }else{
        $error_message = $chkvalid->messages();
      }
      $error_msgAr=array();
      if(!empty($error_message))
      {
                  $error_message=json_decode(json_encode($error_message));
                  foreach($error_message as $kk => $error_message_ar)
                  {
                              $error_msgAr[$kk]=implode("<br>",$error_message_ar); 
                  }
          $returnArray['flagdata'] = '01';
          $returnArray['message'] = $error_msgAr;
                  
      }
     echo json_encode($returnArray);
    }

    
    public function checksavepostagig($request,$id=0)
    {
$validator = Validator::make($request->all(), [
                            "eventType" => "required",
                            "user_type" => "required",
                            "address1val" => "required",
                            "countrydata" => "required",
                            "statelistdata" => "required",
                            "towndata" => "required",
                            "zipdata" => "required|numeric",
                            "bookingcat_subdata" => "required",
                            "bookinggenre_subdata" => "required",
                            "security_paymentdata" => "required",
                            "start_timedata" => "required",
                            "end_timedata" => "required",
                            "total_paymentdata" => "required",
                            "booking_datedata" => "required",
                            "gig_description"=> "required|max:255"
                ],[
                            "eventType.required" => "Please select your event type",
                            "user_type.required" => "Please select your type",
                            "address1val.required" => "First address is required",
                            "countrydata.required" => "Country field is required",
                            "statelistdata.required" => "State field is required",
                            "towndata.required" => "Town field is required",
                            "zipdata.required" => "Zip field is required",
                            "zipdata.numeric" => "Zip field is must be numeric",
                            "bookingcat_subdata.required" => "Gig category field is required",
                            "bookinggenre_subdata.required" => "Gig genre field is required",
                            "security_paymentdata.required" => "Security Paymentdata field is required",
                            "start_timedata.required" => "Start timedata field is required",
                            "end_timedata.required" => "End time field is required",
                            "total_paymentdata.required" => "Total payment field is required",
                            "booking_datedata.required" => "Start date field is required",
                            "gig_description.required" => "Gig description field in required",
                            "gig_description.max" => "Gig description field not more than 255",
                ]);
                
            //***********************Add more validation start 01-07-2016**********************
            
                $userData=array();
                $userData['request']=$request;
                
                $validator->after(function($validator)  use ($userData)  { 
                            $request=$userData['request'];
                            $security_paymentdata =  $request->input('security_paymentdata');
                            $total_paymentdata =  $request->input('total_paymentdata');
                            if($security_paymentdata!='' && $total_paymentdata!=''){
                              if($total_paymentdata <= $security_paymentdata ){
                                $validator->errors()->add('total_paymentdata', "Total amount must be greater then Security amount");
                              }
                            }
                            $booking_datedata =  $request->input('booking_datedata');
                            $start_timedata =  $request->input('start_timedata');
                            $end_timedata =  $request->input('end_timedata');
                            $requestexpireddatedata =  $request->input('requestexpireddatedata');
                            $requestexpiredtimedata =  $request->input('requestexpiredtimedata');
                            
                            $ttt= explode("/",$booking_datedata);
                            $bkngdate = $ttt[2].'-'.$ttt[1].'-'.$ttt[0];
                            
                            $r =  date("G:i", strtotime($start_timedata));
                            $strttim = date('H:i:s',strtotime($r));
                            $start_date_time_v = $bkngdate." ".$strttim;
                            
                            $r1 =  date("G:i", strtotime($end_timedata));
                            $endtim = date('H:i:s',strtotime($r1));
                            $end_date_time_v = $bkngdate." ".$endtim;
                            
                            $reqt= explode("/",$requestexpireddatedata);
                            $bkngexpirdate = $reqt[2].'-'.$reqt[1].'-'.$reqt[0];
                            
                            $r2 =  date("G:i", strtotime($requestexpiredtimedata));
                            $expirtim = date('H:i:s',strtotime($r2));
                            $expir_date_time_v = $bkngexpirdate." ".$expirtim;
                            
                            if($start_date_time_v!='' && $end_date_time_v!=''){
                              $validate_start_end=$this->chkvalidavail_start_end($start_date_time_v,$end_date_time_v);
                              if($validate_start_end!=''){
                                $validator->errors()->add('end_timedata', $validate_start_end); 
                              }
                            }
                            
                            if($start_date_time_v!='' && $expir_date_time_v!=''){
                              $validate_start_expir=$this->chkvalidavail_start_expir($start_date_time_v,$expir_date_time_v);
                              if($validate_start_expir!=''){
                                $validator->errors()->add('requestexpireddatedata', $validate_start_expir); 
                              }
                            }
                            //$booking_datedata = addslashes($request->input('booking_datedata'));
                            //$start_timedata = addslashes($request->input('start_timedata'));
                            //$artist_ID = $request->input('artist_id');
                            //$sess_id = $request->session()->get('front_id_sess');

                            //if($booking_datedata!='' && $start_timedata!='' && $artist_ID!='' && $sess_id!='')
                            //{    
                            //            $validatehourlyavaiability=$this->chkvalidavailability($booking_datedata,$start_timedata,$artist_ID,$sess_id);
                            //            if (!empty($validatehourlyavaiability))
                            //            {
                            //                     $validator->errors()->add('booking_datedata', $validatehourlyavaiability);   
                            //            }
                            //}

                            
                });
            
            //***********************Add more validation end**********************
                
                if ($validator->fails())
                {
                    return $validator;
                }
                return true;
    }
    function chkvalidavail_start_end($state_date,$end_date){

      $state_date_new = strtotime($state_date);
      $end_date_new = strtotime($end_date);
      $vali_error_msg = '';
      if($end_date_new <= $state_date_new){
        $vali_error_msg = "Start time should be less than ending time";
      }
      return $vali_error_msg;
      
    }
    function chkvalidavail_start_expir($state_date,$expire_date){
      
      $state_date_new = strtotime($state_date);
      $expire_date_new = strtotime($expire_date);
      $vali_error_msg = '';
      if($state_date_new <= $expire_date_new){
        $vali_error_msg = "Expired date time should be greater than starting time";
      }
      return $vali_error_msg;
    }
    
}