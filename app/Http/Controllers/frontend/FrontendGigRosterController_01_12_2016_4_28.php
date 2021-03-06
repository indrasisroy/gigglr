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
class FrontendGigRosterController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    
     public function index(Request $request)
    {

     $resp_arr=array();
     $gig_bidrequest_details = array();
     $gig_request_id = $request->input('gig_request_id');
     $session_id = $request->session()->get('front_id_sess');
     $bidreqstId = $request->input('bidreqstId');
     $session_group_id = '';$session_venue_id='';

     //*******************Get Session GroupID ******************//
     $get_group_master = DB::table('group_master')->where('creater_id',$session_id);
     if($get_group_master->count() > 0){
       $group_master_details = $get_group_master->first();
       $session_group_id = $group_master_details->id;
     }
     
     //*******************Get Session VenueID ******************//
     $get_venue_master = DB::table('venue_master')->where('creater_id',$session_id);
     if($get_venue_master->count() > 0){
       $get_venue_master_details = $get_venue_master->first();
       $session_venue_id = $get_venue_master_details->id;
     }
     
     $get_gig_master = DB::table('gig_master')->where('giguniqueid',$gig_request_id);  
     $gig_master_details = $get_gig_master->first();
     
     $booker_id = $gig_master_details->booker_id;
     $booking_status = $gig_master_details->booking_status;
     $booking_expire_datetime = $gig_master_details->request_expire_datetime;
     $type_flag_gig_master = $gig_master_details->type_flag;
     

     $negotiation_id = '';
     if($type_flag_gig_master == "2"){
      
       $get_group_master_id = DB::table('group_master')->where('creater_id',$session_id);  
       $negotiation_data = $get_group_master_id->first();
       $negotiation_id = $negotiation_data->id;
       
     }else if($type_flag_gig_master =="3"){
      
       $get_venue_master_id = DB::table('venue_master')->where('creater_id',$session_id);  
       $negotiation_data = $get_venue_master_id->first();
       $negotiation_id = $negotiation_data->id;
       
     }else{
      
       $negotiation_id = $session_id;
       
     }
     
     $data['negotiation_id']=$negotiation_id;
     //echo $type_flag_gig_master."==".$session_id."===".$negotiation_id;die;
     
     $current_date_time = date('Y-m-d H:i:s');
     
     //************checking that gig expire date is over or not start***************//

      if($current_date_time >= $booking_expire_datetime){
         if($session_id != $booker_id){
           $resp_arr['flag'] = 0;
           $resp_arr['type'] = 4; 
           $resp_arr['msg'] = "This request has expired."; 
           echo json_encode($resp_arr);
           exit;
         }
      }
     

     //************checking that gig expire date is over or not end***************//
     //*************checking that gig booking_status status start*****************//
     //************* 14-Oct-10 Start************//
     //if($booking_status == '1'){
     // $resp_arr['flag'] = 0;
     // $resp_arr['type'] = 2; 
     // $resp_arr['msg'] = "This gig's biding system is overed.";
     // echo json_encode($resp_arr);
     // exit;
     //}
     //************* 14-Oct-10 end************//
     if($booking_status == '9'){
      $resp_arr['flag'] = 0;
      $resp_arr['type'] = 3; 
      $resp_arr['msg'] = "This gig already canceled.";
      echo json_encode($resp_arr);
      exit;
     }
     //************checking that gig booking_status status end***************//
     //************checking gig status*******************//
     if($booker_id == $session_id){
      //$chcking_gig_sql = "SELECT gig_b.`gig_bid_status` FROM `gig_master` as gig_m,`gig_bidrequest` as gig_b WHERE gig_m.`giguniqueid` = '".$gig_request_id."' and gig_m.`booker_id` = '".$session_id."' and gig_m.`booking_status` != '3' and gig_b.`giguniqueid` = '".$gig_request_id."'";
      $chcking_gig_sql = "SELECT gig_b.`gig_bid_status` FROM `gig_master` as gig_m,`gig_bidrequest` as gig_b WHERE gig_m.`giguniqueid` = '".$gig_request_id."' and gig_m.`booker_id` = '".$session_id."' and gig_m.`booking_status` != '3' and gig_b.`id` = '".$bidreqstId."'";
      $chcking_gig_dtails = DB::select( DB::raw($chcking_gig_sql));
      if(empty($chcking_gig_dtails)){
      
      //$resp_arr['flag'] = 0;
      //$resp_arr['type'] = 1; 
      //$resp_arr['msg'] = "No one have bid on this gig";
      //echo json_encode($resp_arr);
      //exit;
      }else{
       $gig_bid_status = $chcking_gig_dtails[0]->gig_bid_status;
       if($gig_bid_status == 3){
       $resp_arr['flag'] = 0;
       $resp_arr['type'] = 6;
       $resp_arr['msg'] = "Artist has canceled your booking request";
       echo json_encode($resp_arr);
       exit;
       }
      }
     }
     


     if($booker_id == $session_id){
       if($bidreqstId!=''){
          $gig_bidrequest = DB::table('gig_bidrequest')->where('giguniqueid',$gig_request_id)
          ->where('booker_id',$session_id)->where('id',$bidreqstId);
          
       }else{
          $gig_bidrequest = DB::table('gig_bidrequest')->where('giguniqueid',$gig_request_id)
          ->where('booker_id',$session_id);
       }
     }else{
      if($type_flag_gig_master == '1'){
       $gig_bidrequest = DB::table('gig_bidrequest')->where('giguniqueid',$gig_request_id)
       ->where('artist_id',$session_id);
      }else if($type_flag_gig_master == '2'){
       $gig_bidrequest = DB::table('gig_bidrequest')->where('giguniqueid',$gig_request_id)
       ->where('artist_id',$session_group_id);
      }else if($type_flag_gig_master == '3'){
       $gig_bidrequest = DB::table('gig_bidrequest')->where('giguniqueid',$gig_request_id)
       ->where('artist_id',$session_venue_id);
      }
     }
     
     if($gig_bidrequest->count()>0){
      $gig_bidrequest_details = $gig_bidrequest->first();
      $gig_bid_status = $gig_bidrequest_details->gig_bid_status;
       if($gig_bid_status =='3'){
        $resp_arr['flag'] = 0;
        $resp_arr['type'] = 5; 
        $resp_arr['msg'] = "You have already canceled this gig";
        echo json_encode($resp_arr);
        exit;
       }
     }
     

     //*****************fetch country start*****************//
     $event_country = $gig_master_details->event_country;
     $get_gig_country = DB::table('location_country')->where('id',$event_country);
     $get_gig_country_details = $get_gig_country->first();
     //*****************fetch country end*****************//
     
     //*****************fetch state start*****************//
     $event_state = $gig_master_details->event_state;
     $get_gig_state = DB::table('location_state')->where('id',$event_state);
     $get_gig_state_details = $get_gig_state->first();
     //*****************fetch state start*****************//

     $gig_master_id = $gig_master_details->id;
     
     //*****************fetch category start************//
     $fetCat = "SELECT skmt.`name` FROM `gig_skill_rel` as gskrl, `skill_master` as skmt  WHERE gskrl.`gigmaster_id` =".$gig_master_id." and gskrl.`category` = skmt.`id`";

     $fetCat_details = DB::select( DB::raw($fetCat));
     //*****************fetch category end************//
     
     
     
     
     //*****************fetch category start************//
     $fetGen = "SELECT skmt.`name` FROM  `gig_skill_rel` as gskrl,  `skill_master` as skmt WHERE gskrl.`gigmaster_id` =".$gig_master_id." AND gskrl.`genre` = skmt.`id";

     $fetGen_details = DB::select( DB::raw($fetGen));
     //*****************fetch category end************//
     
     
     $data['gig_master_details']  = $gig_master_details;
     $data['gig_bidrequest_details']  = $gig_bidrequest_details;
     $data['get_gig_country_details']  = $get_gig_country_details->country_name;
     $data['get_gig_state_details']  = $get_gig_state_details->state_name;

     $data['get_gig_Cat_details']  = $fetCat_details[0]->name;
     $data['get_gig_Gen_details']  = $fetGen_details[0]->name;
     
     //echo "<pre>";
     //print_r($data);
     //echo "</pre>";
     //die;
     $data['divshow']  = "";
     
     $view_obj = View::make('front.includefolder.gigrostermodal',$data);
     $ep_view_contents = $view_obj->render();
     
     $resp_arr['flag'] = 1; 
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
      $parentcountrySql = "SELECT `id`,`state_name` FROM `location_state` WHERE `country_id`='".$country_data."'";
      $GigCountrykill = DB::select( DB::raw($parentcountrySql));
      echo json_encode($GigCountrykill);
    }
    
    public function savegigbidrequest(Request $request){
     
    $gig_description = $request->input('gig_description');
    $gigmaster_id = $request->input('gigmaster_id');
    $ta_lock_id = $request->input('ta_lock_id');
    $asd_lock_id = $request->input('asd_lock_id');
    $bcf_lock_id = $request->input('bcf_lock_id');
    //die($ta_lock_id." ".$asd_lock_id." ".$bcf_lock_id);
    $Last_updated_by = $request->input('Last_updated_by');
    $type_flag = $request->input('type_flag');
    $gigpostrequestflagjs = $request->input('gigpostrequestflagjs');
    
    $artist_id = $request->input('artist_id');
    if($artist_id == '0'){
     $artist_id = $request->input('negotiated');
    }

    $gigunique_id = $request->input('gigunique_id');
    $booker_id = $request->input('booker_id');
    $negotiated = $request->input('negotiated_by');
    
    $cancellation_fee = str_replace(',', '',ltrim($request->input('cancellation_fee'),"$"));
    $total_payment = str_replace(',', '',ltrim($request->input('total_payment'),"$"));
    $security_payment =str_replace(',', '',ltrim($request->input('security_payment'),"$"));
    $created_date = date('Y-m-d H:i:s');
    $gig_bidrequest_id = $request->input('gig_bidrequest_id');
    
    
    $rerurnArray = array();
    if(empty($gig_bidrequest_id)){
     
      $Insert_into_gig_bidrequest = array(
      'gigmaster_id'=>$gigmaster_id,
      'giguniqueid'=>$gigunique_id,
      'booker_id'=>$booker_id,
      //'artist_id'=>$artist_id,
      'type_flag'=>$type_flag,
      'last_updated_by'=>$Last_updated_by,
      'first_accepted_by'=>'',
      'artist_security_deposit'=>$security_payment,
      'asd_lock_id'=>$asd_lock_id,
      'total_amount'=>$total_payment,
      'ta_lock_id'=>$ta_lock_id,
      'create_date'=>$created_date,
      'modified_date'=>$created_date,
      'gig_bid_status'=>1
      );
      
      if($gigpostrequestflagjs == '2'){
       if($artist_id!=$booker_id){
        $Insert_into_gig_bidrequest['artist_id']=$artist_id;
       }
      }else{
       if($artist_id!=$booker_id){
        $Insert_into_gig_bidrequest['artist_id']=$artist_id;
       }
      }

      if($gig_description!=''){
      $Insert_into_gig_bidrequest['gig_description']=$gig_description;
      }
      
      if($cancellation_fee!=''){
      $Insert_into_gig_bidrequest['booking_cancellation_fee']=$cancellation_fee;
      $Insert_into_gig_bidrequest['bcf_lock_id']=$bcf_lock_id;
      }

      $isInserted = DB::table('gig_bidrequest')->insert($Insert_into_gig_bidrequest);
      $rerurnArray['flag'] = 1; 
      $rerurnArray['msg'] = "Bid negotiated successfully."; 
    }else{
     
    //*********************Cheking if that artist_id is allready have in that table or not********************//
    
    //$old_artist_id = DB::table('gig_bidrequest')
    //->where('gigmaster_id',$gigmaster_id)
    //->where('giguniqueid',$gigunique_id)
    //->where('artist_id',$request->session()->get('front_id_sess')); SELECT * FROM `gig_bidrequest` WHERE `gigmaster_id` = '34' and `giguniqueid` = 'GIG-5785c65c3f3fd' and (`artist_id` = '12' or `booker_id` = '29')
    $session_id = $request->session()->get('front_id_sess');
    
    //*******************Get Session GroupID ******************//
    $get_group_master = DB::table('group_master')->where('creater_id',$session_id);
    if($get_group_master->count() > 0){
      $group_master_details = $get_group_master->first();
      $session_group_id = $group_master_details->id;
    }
    
    //*******************Get Session VenueID ******************//
    $get_venue_master = DB::table('venue_master')->where('creater_id',$session_id);
    if($get_venue_master->count() > 0){
      $get_venue_master_details = $get_venue_master->first();
      $session_venue_id = $get_venue_master_details->id;
    }
    
    if($type_flag == 1){
     $ckeck_bid_old_sql = "SELECT * FROM `gig_bidrequest` WHERE `gigmaster_id` = '".$gigmaster_id."' and `giguniqueid` = '".$gigunique_id."' and (`artist_id` = '".$session_id."' or `booker_id` = '".$session_id."')";
    }else if($type_flag == 2){
     $ckeck_bid_old_sql = "SELECT * FROM `gig_bidrequest` WHERE `gigmaster_id` = '".$gigmaster_id."' and `giguniqueid` = '".$gigunique_id."' and (`artist_id` = '".$session_group_id."' or `booker_id` = '".$booker_id."')";
    }else if($type_flag == 3){
     $ckeck_bid_old_sql = "SELECT * FROM `gig_bidrequest` WHERE `gigmaster_id` = '".$gigmaster_id."' and `giguniqueid` = '".$gigunique_id."' and (`artist_id` = '".$session_venue_id."' or `booker_id` = '".$booker_id."')";
    }

    $old_artist_or_booker_id = DB::select( DB::raw($ckeck_bid_old_sql));
    if(count($old_artist_or_booker_id)>0){
     //************update section******************//
     
     //echo " //************update section******************//";
     $update_gig_bidrequest = array(
      'gigmaster_id'=>$gigmaster_id,
      'giguniqueid'=>$gigunique_id,
      'booker_id'=>$booker_id,
      'type_flag'=>$type_flag,
      'last_updated_by'=>$Last_updated_by,
      'first_accepted_by'=>'',
      'artist_security_deposit'=>$security_payment,
      'asd_lock_id'=>$asd_lock_id,
      'total_amount'=>$total_payment,
      'ta_lock_id'=>$ta_lock_id,
      'modified_date'=>$created_date,
      'gig_bid_status'=>1
      );
      
      if($gigpostrequestflagjs == '2'){
       if($artist_id!=$booker_id){
        $Insert_into_gig_bidrequest['artist_id']=$artist_id;
       }
      }else{
       if($artist_id!=$booker_id){
        $Insert_into_gig_bidrequest['artist_id']=$artist_id;
       }
      }
      if($gig_description!=''){
      $update_gig_bidrequest['gig_description']=$gig_description;
      }
      
      if($cancellation_fee!=''){
      $update_gig_bidrequest['booking_cancellation_fee']=$cancellation_fee;
      $update_gig_bidrequest['bcf_lock_id']=$bcf_lock_id;
      }
      //$update_gig_bidrequest['type']="its update bro"; echo json_encode($update_gig_bidrequest);die;
      $isInserted = DB::table('gig_bidrequest')->where('id',$gig_bidrequest_id)->update($update_gig_bidrequest);
      if($isInserted){
       $rerurnArray['flag'] = 1; 
       $rerurnArray['msg'] = "Bid negotiated successfully."; 
      }

    }else{
     //************insert section******************//
     //echo "//************insert section******************//";
       $Insert_into_gig_bidrequest = array(
      'gigmaster_id'=>$gigmaster_id,
      'giguniqueid'=>$gigunique_id,
      'booker_id'=>$booker_id,
      //'artist_id'=>$artist_id,
      'type_flag'=>$type_flag,
      'last_updated_by'=>$Last_updated_by,
      'first_accepted_by'=>'',
      'artist_security_deposit'=>$security_payment,
      'asd_lock_id'=>$asd_lock_id,
      'total_amount'=>$total_payment,
      'ta_lock_id'=>$ta_lock_id,
      'create_date'=>$created_date,
      'modified_date'=>$created_date,
      'gig_bid_status'=>1
      );
      if($artist_id!=$booker_id){
       $Insert_into_gig_bidrequest['artist_id']=$artist_id;
      }
      if($gig_description!=''){
      $Insert_into_gig_bidrequest['gig_description']=$gig_description;
      }
      
      if($cancellation_fee!=''){
      $Insert_into_gig_bidrequest['booking_cancellation_fee']=$cancellation_fee;
      $Insert_into_gig_bidrequest['bcf_lock_id']=$bcf_lock_id;
      }
      //$Insert_into_gig_bidrequest['type']="its insert bro"; echo json_encode($Insert_into_gig_bidrequest);die;
      $isInserted = DB::table('gig_bidrequest')->insert($Insert_into_gig_bidrequest);
      $rerurnArray['flag'] = 1; 
      $rerurnArray['msg'] = "Bid negotiated successfully.";
      

    }
     
    }
    echo json_encode($rerurnArray);
    }
    
    function accptbidrequestbyartist(Request $request){
      $is_gig_bidrequest_updated = '';
      $is_gig_bidrequest_insert = ''; 
      $gig_bidrequest_id = $request->input('gig_bidrequest_id');
      $gigunique_id = $request->input('gigunique_id');
      $gigmaster_id = $request->input('gigmaster_id');

      $gig_description = $request->input('gig_description');
      $type_flag = $request->input('type_flag');
      $booker_id = $request->input('booker_id');
      
      
    $cancellation_fee = str_replace(',', '',ltrim($request->input('cancellation_fee'),"$"));
    $total_payment = str_replace(',', '',ltrim($request->input('total_payment'),"$"));
    $security_payment =str_replace(',', '',ltrim($request->input('security_payment'),"$"));
      
      
      $accept_by = $request->input('accept_by');
      if($gig_bidrequest_id!=''){
           $accept_gig_bidrequest = array(
           'gigmaster_id'=>$gigmaster_id,
           'giguniqueid'=>$gigunique_id,
           'first_accepted_by'=>$accept_by,
           'artist_security_deposit'=>$security_payment,
           'asd_lock_id'=>$accept_by,
           'total_amount'=>$total_payment,
           'ta_lock_id'=>$accept_by,
           'modified_date'=>date('Y-m-d H:i:s'),
           'gig_bid_status'=>1
           );

           
           if($cancellation_fee!=''){
           $accept_gig_bidrequest['booking_cancellation_fee']=$cancellation_fee;
           $accept_gig_bidrequest['bcf_lock_id']=$accept_by;
           }
           if($gig_description!=''){
           $accept_gig_bidrequest['gig_description']=$gig_description;
           }
           
           $is_gig_bidrequest_updated = DB::table('gig_bidrequest')->where('id',$gig_bidrequest_id)->update($accept_gig_bidrequest);
           
      }else{
       
            $accept_gig_bidrequest = array(
           'gigmaster_id'=>$gigmaster_id,
           'giguniqueid'=>$gigunique_id,
           'booker_id'=>$booker_id,
           'artist_id'=>$accept_by,
           'type_flag'=>$type_flag,
           'last_updated_by'=>$accept_by,
           'create_date'=>date('Y-m-d H:i:s'),
           'first_accepted_by'=>$accept_by,
           'artist_security_deposit'=>$security_payment,
           'asd_lock_id'=>$accept_by,
           'total_amount'=>$total_payment,
           'ta_lock_id'=>$accept_by,
           'modified_date'=>date('Y-m-d H:i:s'),
           'gig_bid_status'=>1
           );

           
           if($cancellation_fee!=''){
           $accept_gig_bidrequest['booking_cancellation_fee']=$cancellation_fee;
           $accept_gig_bidrequest['bcf_lock_id']=$accept_by;
           }
           if($gig_description!=''){
           $accept_gig_bidrequest['gig_description']=$gig_description;
           }
           
           $is_gig_bidrequest_insert = DB::table('gig_bidrequest')->insert($accept_gig_bidrequest);
      }

           $rerurnArray = array();
           if($is_gig_bidrequest_updated == 1 || $is_gig_bidrequest_insert == 1 ){
              $rerurnArray['flag'] = 1; 
              $rerurnArray['msg'] = "You successfully accept gig request.";
           }else{
              $rerurnArray['flag'] = 0; 
              $rerurnArray['msg'] = "Oops!!! Something wrong in artist Gig cancelation  process";
           }
           echo json_encode($rerurnArray);
    }
    
    function accptbidrequestbybooker(Request $request){
     
      $bid_request_artist_id = $request->input('bid_request_artist_id');
      $gig_bidrequest_id = $request->input('gig_bidrequest_id');
      $gigunique_id = $request->input('gigunique_id');
      $gigmaster_id = $request->input('gigmaster_id');
      $security_payment = $request->input('security_payment');
      $total_payment = $request->input('total_payment');
      $cancellation_fee = $request->input('cancellation_fee');
      $gig_description = $request->input('gig_description');
      $accept_by = $request->input('accept_by');
      $type_flag = $request->input('type_flag');
      $gigpostrequestflag =  $request->input('gigpostrequestflagjs');
      $currentDateTime = date('m-d-Y H:i:s') ;

     //***************cheking artist location start**************//
     $sqlTimeZone = "SELECT * FROM `gig_master` WHERE `artist_id` = '".$bid_request_artist_id."' and `booking_status`='1' order by `event_end_date_time` desc LIMIT 1";

     $LstLat = '';
     $LstLong = '';
     $DesLstLat = '';
     $DesLstLong = '';
     $LstBookedTime = '';
     $LstBookedTimeZone = '';
     
     $sqlTimeZone_dtails = DB::select( DB::raw($sqlTimeZone));
     if(empty($sqlTimeZone_dtails)){
      
      if($type_flag == '1'){
       $user_master = DB::table('user_master')->where('id',$bid_request_artist_id);
       $user_details = $user_master->first();
       $LstBookedTimeZone = $user_details->addr_timezone;
       $LstLat = $user_details->addr_lat;
       $LstLong = $user_details->addr_long;
       
      }elseif($type_flag == '2'){
       $user_master = DB::table('group_master')->where('id',$bid_request_artist_id);
       $user_details = $user_master->first();
       $LstBookedTimeZone = $user_details->group_timezone;
       $LstLat = $user_details->group_lat;
       $LstLong = $user_details->group_long;
       
      }elseif($type_flag == '3'){
       $user_master = DB::table('venue_master')->where('id',$bid_request_artist_id);
       $user_details = $user_master->first();
       $LstBookedTimeZone = $user_details->venue_timezone;
       $LstLat = $user_details->venue_lat;
       $LstLong = $user_details->venue_long;
      }
      

      
     }else{
      $LstBookedTimeZone = $sqlTimeZone_dtails[0]->event_timezone;
      $LstBookedTime = $sqlTimeZone_dtails[0]->event_end_date_time;
      $user_details = $sqlTimeZone_dtails;
      $LstLat = $sqlTimeZone_dtails[0]->event_address_lat;
      $LstLong = $sqlTimeZone_dtails[0]->event_address_long;
      
     }
     if($LstBookedTime!=''){
      $Lastdate = $LstBookedTime;
     }else{
      date_default_timezone_set($LstBookedTimeZone);
      $Lastdate = date('m-d-Y H:i:s') ;
     }
     
     //************get destination lat long start **************//
     
     $gig_master_details = DB::table('gig_master')->select('id','event_timezone','event_start_date_time','event_address_lat','event_address_long','booking_status')->where('id',$gigmaster_id)->first();
     $gig_master_details_id = $gig_master_details->id;
     $Lst_checked_booking_status = $gig_master_details->booking_status;
     $event_start_date_time = $gig_master_details->event_start_date_time;
     $event_timezone = $gig_master_details->event_timezone;
     //*********even current time start*****//
     date_default_timezone_set($event_timezone);
     $eventCurrntTime = date('Y-m-d H:i:s');
     //*********even current time end*****//
     
     if($Lst_checked_booking_status == '2'){
       $DesLstLat = $gig_master_details->event_address_lat;
       $DesLstLong = $gig_master_details->event_address_long;
     }else{
       $rerurnArray['flag'] = 0; 
       $rerurnArray['msg'] = "SORRY. This Gig is already booked!";
       echo json_encode($rerurnArray);
       exit;
     }

     $responds = cheking_distance($LstLat,$DesLstLat,$LstLong,$DesLstLong);
     $total_duration = '00:00:00';
     $total_distance = '';
     if(!empty($responds)){
      $total_duration = $responds['duration'];
      $total_distance = $responds['distance'];
     }
     //************get destination lat long end **************//
     
     $data['duration']=$total_duration;
     $data['distance']=$total_distance;
     $data['Deslat']=$DesLstLat;
     $data['Deslong']=$DesLstLong;
     $data['lat']=$LstLat;
     $data['long']=$LstLong;
     $data['timeZone']=$LstBookedTimeZone;
     $data['Lasttime']=$Lastdate;
     $data['eventCurrntTime']=$eventCurrntTime;
     //echo json_encode($user_details);
     //**************** add event current time and duration **************//
     $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $total_duration);
     sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
     $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
     $currentDate = strtotime($eventCurrntTime);
     $futureDate = $currentDate+($time_seconds);
     $formatDate = date("Y-m-d H:i:s", $futureDate);

     
     $data['maxrichedtime']=$formatDate."--".strtotime($formatDate);
     $data['event_start_date_time']=$event_start_date_time."--".strtotime($event_start_date_time);
     $maxrichedtime_in_seconds = strtotime($formatDate);
     $event_start_date_time_in_seconds = strtotime($event_start_date_time);



      //***************** geting booker and artist full name start ******************//
      $get_user_master_booker = DB::table('user_master')->select('first_name','middle_name','last_name','email','wallet_amount')->where('id',$accept_by)->first();
      
      
      
      if($get_user_master_booker->wallet_amount < $total_payment){
       $rerurnArray['flag'] = 0; 
       $rerurnArray['msg'] = "SORRY. You don't have sufficient balance for booking";
       echo json_encode($rerurnArray);
       exit;
      }
     
      $tableName = "";$seletcolom = "";
      if($type_flag == "1"){
       $get_user_master_artist_query = "SELECT `first_name`,`middle_name`,`last_name`,`email`,`wallet_amount` FROM `user_master` WHERE `id`='".$bid_request_artist_id."'";
      }else if($type_flag == "2"){
       $get_user_master_artist_query = "select grp.`nickname`,mem.`email`,mem.`wallet_amount` from `group_master` as grp,`user_master` as mem where grp.`id` = '".$bid_request_artist_id."' and grp.`creater_id`= mem.`id`";
      }else if($type_flag == "3"){
       $get_user_master_artist_query = "select grp.`nickname`,mem.`email`,mem.`wallet_amount` from `venue_master` as grp,`user_master` as mem where grp.`id` = '".$bid_request_artist_id."' and grp.`creater_id`= mem.`id`";
      }
      $get_user_master_artist_dtails = DB::select( DB::raw($get_user_master_artist_query));

      
      if($type_flag == "1"){
       if($get_user_master_artist_dtails['0']->middle_name!=''){
       $full_artist_name = $get_user_master_artist_dtails['0']->first_name." ".$get_user_master_artist_dtails['0']->middle_name." ".$get_user_master_artist_dtails['0']->last_name;
       }else{
       $full_artist_name = $get_user_master_artist_dtails['0']->first_name." ".$get_user_master_artist_dtails['0']->last_name;
       }
      }else{
       $full_artist_name = $get_user_master_artist_dtails['0']->nickname;
      }
      $full_artist_email =$get_user_master_artist_dtails['0']->email;

      //echo $full_artist_email." ".$full_artist_name; die;
      //$get_user_master_artist = DB::table('user_master')->select('first_name','middle_name','last_name','email')->where('id',$bid_request_artist_id)->first();
      //$get_user_master_artist = DB::table($tableName)->select($seletcolom)->where('id',$bid_request_artist_id)->first();



      if($get_user_master_booker->middle_name!=''){
       $full_booker_name = $get_user_master_booker->first_name." ".$get_user_master_booker->middle_name." ".$get_user_master_booker->last_name;
      }else{
       $full_booker_name = $get_user_master_booker->first_name." ".$get_user_master_booker->last_name;
      }

      $full_booker_email = $get_user_master_booker->email;

      
      //***************** geting booker and artist full name end ******************//
      
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

     if($event_start_date_time_in_seconds > $maxrichedtime_in_seconds){
      
      //$data['booking_status']= "Possible";

            $accept_gig_bidrequest = array(
           'gigmaster_id'=>$gigmaster_id,
           'giguniqueid'=>$gigunique_id,
           'last_updated_by'=>$accept_by,
           'artist_security_deposit'=>$security_payment,
           'asd_lock_id'=>$accept_by,
           'total_amount'=>$total_payment,
           'ta_lock_id'=>$accept_by,
           'modified_date'=>date('Y-m-d H:i:s'),
           'gig_bid_status'=>2
           );
           
           if($cancellation_fee!=''){
           $accept_gig_bidrequest['booking_cancellation_fee']=$cancellation_fee;
           $accept_gig_bidrequest['bcf_lock_id']=$accept_by;
           }
           if($gig_description!=''){
           $accept_gig_bidrequest['gig_description']=$gig_description;
           }
           $isgig_bidrequestUpdated = DB::table('gig_bidrequest')->where('id',$gig_bidrequest_id)->update($accept_gig_bidrequest);
          
          
           $gig_master_updae = array(
            'booking_accept_date' => date('Y-m-d H:i:s'),
            'artist_security_deposit'=>$security_payment,
            'total_amount'=>$total_payment,
            'artist_id'=>$bid_request_artist_id,
            'booking_status'=>1,
                );
           if($cancellation_fee!=''){
           $gig_master_updae['booking_cancellation_fee']=$cancellation_fee;
           }
           if($gig_description!=''){
           $gig_master_updae['gig_description']=$gig_description;
           }


           
           
           
           //**********************escrowed process start*******************//
           $payment_for = '';
           $payment_description = '';
           if($type_flag == '1'){
            
             if($gigpostrequestflag =='2'){
              $payment_for = 'EBA';
              $payment_description = 'escrowed for artist for booking request';
             }else if($gigpostrequestflag =='1'){
               $payment_for = 'EGA';
               $payment_description = 'escrowed for artist for gig request';
             }
            
           }else if($type_flag == '2'){
            
             if($gigpostrequestflag =='2'){
               $payment_for = 'EBG';
               $payment_description = 'escrowed for group for booking request';
             }else if($gigpostrequestflag =='1'){
               $payment_for = 'EGG';
               $payment_description = 'escrowed for group for gig request';
             }
           }else if($type_flag == '3'){
             $payment_for = 'EBV';
             $payment_description = 'escrowed for venue for booking request';
           }
           
           //$gig_master_updae['payment_for'] = $payment_for;
           //$gig_master_updae['payment_description'] = $payment_description;
           //$gig_master_updae['bookerwallet_amount'] = $get_user_master_booker->wallet_amount;
           //$gig_master_updae['artistwallet_amount'] = $get_user_master_artist_dtails['0']->wallet_amount;
           
           //
           //$gig_master_updae['currentDateTime'] = date('Y-m-d H:i:s');
           //$gig_master_updae['event_start_date_time'] = $event_start_date_time;
           $time_diff = floor((strtotime($event_start_date_time) - strtotime(date('Y-m-d H:i:s')))/3600); //1101 in houres
           $amount_trans = '';
           if($time_diff >= 4 && $time_diff <= 48){
            //$gig_master_updae['time_diff'] = $time_diff." 1";
            $amount_trans = $total_payment;
            $gig_master_updae['payment_flag']= '2';
            
           }else if($time_diff >= 48){
            //$gig_master_updae['time_diff'] = $time_diff." 2";
            $amount_trans = $cancellation_fee + $security_payment;
            $gig_master_updae['payment_flag']= '1';
           }
           
           $isgig_masterUpdated = DB::table('gig_master')->where('id',$gigmaster_id)->update($gig_master_updae);
           
           $booker_curent_balance = $get_user_master_booker->wallet_amount - $amount_trans;
           //$artist_curent_balance = $get_user_master_artist_dtails['0']->wallet_amount + $amount_trans;
           //$gig_master_updae['amount_trans'] = $amount_trans;
           //$gig_master_updae['booker_curent_balance'] = $booker_curent_balance;
           //$gig_master_updae['artist_curent_balance'] = $artist_curent_balance;
           
           
           $logggedin_user_ip = get_client_ip_server();
           
           $dataorderInsert=array();
           $dataorderInsert['payment_for']=$payment_for; //required
           $dataorderInsert['card_token']='';
           $dataorderInsert['charge_token']='';
           $dataorderInsert['payment_description']=$payment_description;
           $dataorderInsert['payment_scheme']='';
           $dataorderInsert['email']=$full_booker_email;
           $dataorderInsert['total_price']= $amount_trans;//required
           $dataorderInsert['user_ip_address']= $logggedin_user_ip;//required
           $dataorderInsert['debitorcredit']="D"; // C=> Credit , D=> Debit //required
           $dataorderInsert['gigmaster_id'] = $gig_master_details_id;//required
           $dataorderInsert['currency']='';
           $dataorderInsert['payment_status']="SUCCESS";//required
           $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
           $dataorderInsert['user_id'] = $accept_by;
           $dataorderInsert['create_date'] = date('Y-m-d H:i:s');
           $dataorderInsert['modified_date']= date('Y-m-d H:i:s');
           //*** insert  query
           $isInserted = DB::table('user_order')->insert($dataorderInsert);
           
           
           //*** update user_master table starts ******************************
                    
                    $tot_wallet_amount=0;
                    if(!empty($isInserted))
                    {
                        $tot_wallet_amount=$get_user_master_booker->wallet_amount - $amount_trans;
                        $updateAr=array();
                        $updateAr['modified_date']=date('Y-m-d H:i:s');
                        $updateAr['wallet_amount']=$booker_curent_balance;


                        $chkupd= DB::table('user_master')->where('id',$accept_by) ->update($updateAr);
                    }
           if($isInserted == 1 && $chkupd == 1){
            
            
            //************** send mail to notify escrowed details start*******************//
            
            //*********send to admin**********//
              $replacefrom =array('{BOOKER}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
              //$replaceto =array(ucfirst($full_artist_name),ucfirst($full_booker_name),$sitename,$copyright_year,$bsurl,$logoIMG);
              $replaceto =array(ucfirst($full_booker_name),$sitename,$copyright_year,$bsurl,$logoIMG);
              mailsnd($Temid=23,$replacefrom,$replaceto,$emailfrom);
            
            //*********send to artist**********//
              $replacefrom =array('{ARTIST}','{BOOKER}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{AMOUNT}");
              $replaceto =array(ucfirst($full_artist_name),ucfirst($full_booker_name),$sitename,$copyright_year,$bsurl,$logoIMG,$amount_trans);
              mailsnd($Temid=24,$replacefrom,$replaceto,$full_artist_email);
                        
            //*********send to booker**********//
              $replacefrom =array('{BOOKER}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
              $replaceto =array(ucfirst($full_booker_name),$sitename,$copyright_year,$bsurl,$logoIMG);
              mailsnd($Temid=25,$replacefrom,$replaceto,$full_booker_email);
            //************** send mail to notify escrowed details start*******************//
            
                   
           }
           
           //*** update user_master table ends *********************************
           //echo json_encode($accept_gig_bidrequest);
           //echo json_encode($gig_master_updae);die;
           
           //**********************escrowed process start*******************//
           
           if($isgig_bidrequestUpdated == 1 && $isgig_masterUpdated == 1 ){
              $rerurnArray['flag'] = 1; 
              $rerurnArray['msg'] = "Bid Accepted successfully.";
              
              $replacefrom =array('{ACCEPT_BY}','{User}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
              $replaceto =array(ucfirst($full_artist_name),ucfirst($full_booker_name),$sitename,$copyright_year,$bsurl,$logoIMG);
              mailsnd($Temid=17,$replacefrom,$replaceto,$full_booker_email);

              $replacefrom1 =array('{ACCEPT_BY}','{User}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
              $replaceto1 =array(ucfirst($full_booker_name),ucfirst($full_artist_name),$sitename,$copyright_year,$bsurl,$logoIMG);
              mailsnd($Temid=21,$replacefrom1,$replaceto1,$full_artist_email);
              
           }else{
              $rerurnArray['flag'] = 0; 
              $rerurnArray['msg'] = "Oops!!! Something wrong in bid acceptance process";
           }
     }else{
      $isgig_masterUpdated = ''; $isgig_bidrequestUpdated = '';
      //$data['booking_status']= "Impossible";
         $accept_gig_bidrequest = array(
        'gigmaster_id'=>$gigmaster_id,
        'giguniqueid'=>$gigunique_id,
        'first_accepted_by'=>$accept_by,
        'artist_security_deposit'=>$security_payment,
        'asd_lock_id'=>$accept_by,
        'total_amount'=>$total_payment,
        'ta_lock_id'=>$accept_by,
        'modified_date'=>date('Y-m-d H:i:s'),
        'gig_bid_status'=>3
        );
        
        if($cancellation_fee!=''){
        $accept_gig_bidrequest['booking_cancellation_fee']=$cancellation_fee;
        $accept_gig_bidrequest['bcf_lock_id']=$accept_by;
        }
        if($gig_description!=''){
        $accept_gig_bidrequest['gig_description']=$gig_description;
        }
        $isgig_bidrequestUpdated = DB::table('gig_bidrequest')->where('id',$gig_bidrequest_id)->update($accept_gig_bidrequest);
        $reasone = "Artist can not reach to your destination.";
        if($gigpostrequestflag == '2'){
              
              $gig_master_updae = array(
              'booking_accept_date' => date('Y-m-d H:i:s'),
              'artist_security_deposit'=>$security_payment,
              'total_amount'=>$total_payment,
              'artist_id'=>$bid_request_artist_id,
              'booking_status'=>9,
              'gig_cancel_reason'=>$reasone
                  );
             if($cancellation_fee!=''){
             $gig_master_updae['booking_cancellation_fee']=$cancellation_fee;
             }
             if($gig_description!=''){
             $gig_master_updae['gig_description']=$gig_description;
             }
             $isgig_masterUpdated = DB::table('gig_master')->where('id',$gigmaster_id)->update($gig_master_updae);
        }
        
 
      
      if($isgig_bidrequestUpdated == 1 && $isgig_masterUpdated == 1 ){
         $replacefrom =array('{REASON}','{User}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
         $replaceto =array(ucfirst($reasone),ucfirst($full_booker_name),$sitename,$copyright_year,$bsurl,$logoIMG);
         mailsnd($Temid=18,$replacefrom,$replaceto,$full_booker_email);

         $replacefrom1 =array('{REASON}','{User}','{SITENAME}','{BOOKER}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
         $replaceto1 =array(ucfirst($reasone),ucfirst($full_artist_name),ucfirst($full_booker_name),$sitename,$copyright_year,$bsurl,$logoIMG);
         mailsnd($Temid=19,$replacefrom1,$replaceto1,$full_artist_email);
      }
      if($isgig_bidrequestUpdated == 1  && $isgig_masterUpdated == 0){
         $replacefrom1 =array('{REASON}','{User}','{SITENAME}','{BOOKER}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
         $replaceto1 =array(ucfirst($reasone),ucfirst($full_artist_name),ucfirst($full_booker_name),$sitename,$copyright_year,$bsurl,$logoIMG);
         mailsnd($Temid=19,$replacefrom1,$replaceto1,$full_artist_email);
      }
      
      $rerurnArray['flag'] = 0;
      if($gigpostrequestflag == '2'){
       $rerurnArray['msg'] = ucfirst($full_artist_name)." can not reach to your destination";
      }else{
       $rerurnArray['msg'] = ucfirst($full_artist_name)." can not reach to your destination, you can choose another artist.";
      }

      $data['booking_status']= "Impossible";
     }
     //echo json_encode($data);
     
     //***************cheking artist location end **************//


           echo json_encode($rerurnArray);
    }
    
    function gigcancelbybooker(Request $request){
     
      $gig_bidrequest_id = $request->input('gig_bidrequest_id');
      $gigunique_id = $request->input('gigunique_id');
      $gigmaster_id = $request->input('gigmaster_id');
      $security_payment = $request->input('security_payment');
      $total_payment = $request->input('total_payment');
      $cancellation_fee = $request->input('cancellation_fee');
      $gig_description = $request->input('gig_description');
      $canceled_by = $request->input('canceled_by');
      
      $rerurnArray = array();

      $isgig_bidrequest_count = DB::table('gig_bidrequest')->where('giguniqueid',$gigunique_id)->count();
      if($isgig_bidrequest_count>0){
       $update_gig_bidrequest = array(
       "gig_bid_status"=>3
       );
       $isgig_bidrequest_update = DB::table('gig_bidrequest')->where('giguniqueid',$gigunique_id)->where('id',$gig_bidrequest_id)->update($update_gig_bidrequest);
       
       $update_gig_master = array(
       //"booking_status"=>9
       "booking_status"=>8
       );
       $isgig_masterUpdated = DB::table('gig_master')->where('id',$gigmaster_id)->update($update_gig_master);
       
      }else{
       
       $update_gig_master = array(
       //"booking_status"=>9
       "booking_status"=>8
       );
       $isgig_bidrequest_update = DB::table('gig_master')->where('id',$gigmaster_id)->update($update_gig_master);
       
      }


       
       //if($isgig_bidrequest_count>0){
       //if($isgig_masterUpdated == '1' and $isgig_bidrequest_update=="1"){
       if($isgig_bidrequest_update=="1"){
            $rerurnArray['flag'] = 1; 
            $rerurnArray['msg'] = "Gig bid canceled successfully.";
         }else{
            $rerurnArray['flag'] = 0; 
            $rerurnArray['msg'] = "Oops!!! Something wrong in booker Gig cancelation process";
         }
       //}else{
       //  if($isgig_masterUpdated == '1'){
       //     $rerurnArray['flag'] = 1; 
       //     $rerurnArray['msg'] = "Gig canceled successfully.";
       //  }else{
       //     $rerurnArray['flag'] = 0; 
       //     $rerurnArray['msg'] = "Oops!!! Something wrong in booker Gig cancelation  process";
       //  }
       //}
       echo json_encode($rerurnArray);
      
    }
    function gigcancelbyartist(Request $request){
     
      $gig_bidrequest_id = $request->input('gig_bidrequest_id');
      $gigunique_id = $request->input('gigunique_id');
      $gigmaster_id = $request->input('gigmaster_id');
      $gig_description = $request->input('gig_description');
      $canceled_by = $request->input('canceled_by');
      $type_flag = $request->input('type_flag');
      $cancellation_fee = str_replace(',', '',ltrim($request->input('cancellation_fee'),"$"));
      $total_payment = str_replace(',', '',ltrim($request->input('total_payment'),"$"));
      $security_payment =str_replace(',', '',ltrim($request->input('security_payment'),"$"));
      $created_date = date('Y-m-d H:i:s');
      $isgig_bidrequest_update = '';
      $isgig_bidrequest_insert = '';
      
      $tab_db_um = DB::table("gig_master as gm");
      $tab_db_um=$tab_db_um->select(DB::raw(" gm.gigpostrequestflag "));   
      $tab_db_um=$tab_db_um->where('giguniqueid',$gigunique_id);
      $tab_db_um=$tab_db_um->first();
      
      if($gig_bidrequest_id!=''){
       if($tab_db_um->gigpostrequestflag=='1'){
             $upadate_array = array(
                 'gigmaster_id'=>$gigmaster_id,
                 'giguniqueid'=>$gigunique_id,
                 'artist_security_deposit'=>$security_payment,
                 'total_amount'=>$total_payment,
                 'modified_date'=>date('Y-m-d H:i:s'),
                 'gig_bid_status'=>3,
                 'type_flag'=>$type_flag,
                 'artist_id'=>$canceled_by,
             );
             $isgig_bidrequest_update = DB::table('gig_bidrequest')->where('id',$gig_bidrequest_id)->update($upadate_array);
             }
        else if($tab_db_um->gigpostrequestflag=='2'){
          $upadate_array = array(
              'gigmaster_id'=>$gigmaster_id,
              'giguniqueid'=>$gigunique_id,
              'artist_security_deposit'=>$security_payment,
              'total_amount'=>$total_payment,
              'modified_date'=>date('Y-m-d H:i:s'),
              'gig_bid_status'=>3,
              'type_flag'=>$type_flag,
              'artist_id'=>$canceled_by,
          );
          $isgig_bidrequest_update = DB::table('gig_bidrequest')->where('id',$gig_bidrequest_id)->update($upadate_array);
          
          $update_gig_master = array(
          //"booking_status"=>9
          "booking_status"=>8
          );
          $isgig_bidrequest_update = DB::table('gig_master')->where('id',$gigmaster_id)->update($update_gig_master);
       }

       
       
       
      }else{
       
       // $upadate_array = array(
       //    'gigmaster_id'=>$gigmaster_id,
       //    'giguniqueid'=>$gigunique_id,
       //    'artist_security_deposit'=>$security_payment,
       //    'total_amount'=>$total_payment,
       //    'artist_id'=>$request->session()->get('front_id_sess'),
       //    'modified_date'=>date('Y-m-d H:i:s'),
       //    'gig_bid_status'=>3,
       //    'type_flag'=>$type_flag,
       //    'artist_id'=>$canceled_by,
       //);
       //$isgig_bidrequest_insert = DB::table('gig_bidrequest')->insert($upadate_array);
       


       
       if($tab_db_um->gigpostrequestflag=='1'){
        
        $upadate_array = array(
            'gigmaster_id'=>$gigmaster_id,
            'giguniqueid'=>$gigunique_id,
            'artist_security_deposit'=>$security_payment,
            'total_amount'=>$total_payment,
            'modified_date'=>date('Y-m-d H:i:s'),
            'gig_bid_status'=>3,
            'type_flag'=>$type_flag,
            'artist_id'=>$canceled_by,
        );
        $isgig_bidrequest_update = DB::table('gig_bidrequest')->where('id',$gig_bidrequest_id)->update($upadate_array);
        
       }else if($tab_db_um->gigpostrequestflag=='2'){
        
         $update_gig_master = array(
         //"booking_status"=>9
         "booking_status"=>8
         );
         $isgig_bidrequest_update = DB::table('gig_master')->where('id',$gigmaster_id)->update($update_gig_master);
         
       }

       
       
      }
      //echo json_encode($upadate_array);
      $rerurnArray = array();
      if($isgig_bidrequest_insert == 1 || $isgig_bidrequest_update == 1){
         $rerurnArray['flag'] = 1; 
         $rerurnArray['msg'] = "Gig canceled successfully.";
      }else{
         $rerurnArray['flag'] = 0; 
         $rerurnArray['msg'] = "Oops!!! Something wrong in artist Gig cancelation  process";
      }
      echo json_encode($rerurnArray);
    }
    
    function getDistance(){
     $lat1 = 22.5726;
     $long1 = 88.3639;
     
     // 38°53′42″ N ,-77°02′10″ W
     $lat2 = 28.7041;
     $long2 = 77.1025;
     //$lat2 = 38.5342;
     //$long2 = -77.0210;
     //"Deslat":"-33.6050474","Deslong":"150.7449042","lat":"-36.1123019","long":"146.850954","timeZone":"Australia\/Hobart","Lasttime":"2016-07-19 21:20:00"
     $responds = $this->cheking_distance($lat1,$lat2,$long1,$long2);
     $responds = $this->cheking_distance(-33.6050474,-36.1123019,150.7449042,146.850954);
     if(empty($responds)){
      echo "nae";
     }else{
      
      //print_r($responds);
      $str_time = $responds['duration'];;

      $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
      
      sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
      
      echo $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
      

      echo "<br> 1 -> ".$date = '2011-04-08 08:29:49';
      $currentDate = strtotime($date);
      $futureDate = $currentDate+($time_seconds);
      echo "<br> 2 -> ".$formatDate = date("Y-m-d H:i:s", $futureDate);
     }
    }
    
    function cheking_distance($lat1,$lat2,$long1,$long2){
     $fAddress = $lat1.",".$long1;
     $sAddress = $lat2.",".$long2;
     
     $goople_distance_api = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$fAddress."&destinations=".$sAddress."&mode=driving&language=en-EN&key=AIzaSyDMtfReOBcDyXEUBByLlLgjOkwMKKJw86M";
     //$goople_distance_api = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=22.5726,88.3639&destinations=28.7041,77.1025&mode=driving&language=en-EN&key=AIzaSyDMtfReOBcDyXEUBByLlLgjOkwMKKJw86M";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $goople_distance_api);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     $response = curl_exec($ch);
     curl_close($ch);
     $response_a = json_decode($response);
    
    
     $status = $response_a->rows[0]->elements[0]->status;
    
     //echo json_encode($response_a);die;
    
     if ( $status == 'ZERO_RESULTS' )
     {
       
         return FALSE;
     }
     else
     {
         $duration = $response_a->rows[0]->elements[0]->duration->value;
         //$duration = $response_a->rows[0]->elements[0]->duration->text;
         $distance = $response_a->rows[0]->elements[0]->distance->text;
         //$return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
         $return = array(
          "duration"=>gmdate("H:i:s", $duration),
          //"duration"=>$duration,
          "distance"=> rtrim($distance," km")
         );
         return $return;
     }
    }
    function converToTz($time="",$toTz='',$fromTz='')
    {	
        // timezone by php friendly values
        $date = new DateTime($time, new DateTimeZone($fromTz));
        $date->setTimezone(new DateTimeZone($toTz));
        $time= $date->format('M j, Y g:i a');
        return $time;
    }
    
}