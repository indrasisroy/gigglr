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
use DateTime;
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
     $session_group_id = '';$session_venue_id='';$gigpostorrequest_flag_checking='';$type_flag_gig_master='';

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
     
     //********** Gig master time zone strts here
     $gigmaster_timezone='Australia/Sydney';
     $gigmaster_timezone = $gig_master_details->event_timezone;
     //********** Gig master timezone ends here


     $booker_id = $gig_master_details->booker_id;
     $booking_status = $gig_master_details->booking_status;
     $booking_expire_datetime = $gig_master_details->request_expire_datetime;
     $type_flag_gig_master = $gig_master_details->type_flag;
     $artist_ID_val = $gig_master_details->artist_id; //*********** getting artist
        
        
     $gigpostorrequest_flag_checking = $gig_master_details->gigpostrequestflag; //*********** gig post or request flag

    // $negotiation_id = ''; 
     $w_am_i ='';
     $w_am_i_id =''; 
     $gig_bid_lastupdateby='';
     $gig_bid_lastupdateby_type='';

      $gig_bid_cancellationfeelock = ''; 
      $gig_bid_securitymoneylock = ''; 
      $gig_bid_totalmoneylock = ''; 

      $created_on='';
      $current_date='';
      $validupto_date='';


      $totlockflag='';
      $seclockflag='';
      $cancllockflag='';



        
        if($booker_id!=$session_id) // logged user is not a booker of this  gig/event
        {
                
                
            if($gigpostorrequest_flag_checking == 1 )     // if gig post           
            {
            
                $negotiation_id_type_flag=$type_flag_gig_master;
            
                if($type_flag_gig_master == "2"){

                    $get_group_master_id = DB::table('group_master')->where('creater_id',$session_id);  
                    $negotiation_data = $get_group_master_id->first();
                    $w_am_i_id = $negotiation_data->id;

                    }else if($type_flag_gig_master =="3"){

                    $get_venue_master_id = DB::table('venue_master')->where('creater_id',$session_id);  
                    $negotiation_data = $get_venue_master_id->first();
                    $w_am_i_id = $negotiation_data->id;

                    }else{

                    $w_am_i_id = $session_id;

                    }
            
            
                     $w_am_i = 'AGV';
                    // $w_am_i_id = $negotiation_id;
            }
            elseif($gigpostorrequest_flag_checking == 2 )// if individual booking request
            {
                
                     $w_am_i = 'AGV';
                     $w_am_i_id = $artist_ID_val;
                     $negotiation_id_type_flag=$type_flag_gig_master;
                
            }
            
        }
        else
        {
             $negotiation_id_type_flag=1; // according to current logic booker is always an artist   
            // $negotiation_id = $session_id;
             $w_am_i = 'BKR';
             $w_am_i_id = $booker_id;
        }
        
        
    
        
        
        
     
     //$data['negotiation_id']=0;
     $data['negotiation_id_type_flag']=$negotiation_id_type_flag;
     $data['w_am_i']=$w_am_i;
     $data['w_am_i_id']=$w_am_i_id;
     $data['w_am_id_agv']=$type_flag_gig_master;
        
//     echo " negotiation_id_type_flag => ".$negotiation_id_type_flag."==".$session_id." w_am_i ".$w_am_i.' $w_am_i_id '.$w_am_i_id;die;
     
     $current_date_time = date('Y-m-d H:i:s');
     
     //************checking that gig expire date is over or not start***************//

     if($current_date_time >= $booking_expire_datetime){
         // if($session_id != $booker_id){
         //   $resp_arr['flag'] = 0;
         //   $resp_arr['type'] = 4; 
         //   $resp_arr['msg'] = "Unfortunately, this request has expired"; 
         //   echo json_encode($resp_arr);
         //   exit;
         // }
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
         
         //*************** fetching last update by and type starts
         $gig_bid_lastupdateby = $gig_bidrequest_details->last_updated_by; 
         $gig_bid_lastupdateby_type = $gig_bidrequest_details->lub_type_flag; 
         //*************** fetching last update by and type ends


         //*************  Fetching security money, cancellation lock, total payemnt lock starts 

          
         $gig_bid_cancellationfeelock = $gig_bidrequest_details->bcf_lock_id; 
         $gig_bid_securitymoneylock = $gig_bidrequest_details->asd_lock_id; 
         $gig_bid_totalmoneylock = $gig_bidrequest_details->ta_lock_id;

         $totlockflag= $gig_bidrequest_details->ta_lock_flag;
         $seclockflag=$gig_bidrequest_details->asd_lock_flag;
         $cancllockflag=$gig_bidrequest_details->bcf_lock_flag;

          //*************  Fetching security money, cancellation lock, total payemnt lock ends 
         
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
     $fetGen = "SELECT skmt.`name` FROM  `gig_skill_rel` as gskrl,  `skill_master` as skmt WHERE gskrl.`gigmaster_id` =".$gig_master_id." AND gskrl.`genre` = skmt.`id`";

     $fetGen_details = DB::select( DB::raw($fetGen));
     //*****************fetch category end************//
     
     
     $data['gig_master_details']  = $gig_master_details;
     $data['gig_bidrequest_details']  = $gig_bidrequest_details;
     $data['get_gig_country_details']  = $get_gig_country_details->country_name;
     $data['get_gig_state_details']  = $get_gig_state_details->state_3_code;

     $data['get_gig_Cat_details']  = $fetCat_details[0]->name;
     $data['get_gig_Gen_details']  = $fetGen_details[0]->name;
        
     $data['gig_bid_lastupdateby']  = $gig_bid_lastupdateby;
     $data['gig_bid_lastupdateby_type']  = $gig_bid_lastupdateby_type;

      $data['gig_bid_cancellationfeelock']  = $gig_bid_cancellationfeelock; 
      $data['gig_bid_securitymoneylock']  = $gig_bid_securitymoneylock; 
      $data['gig_bid_totalmoneylock']  = $gig_bid_totalmoneylock; 

      $data['gig_bidtotallockflag']  = $totlockflag; 
      $data['gig_bid_securitylockflag']  = $seclockflag; 
      $data['gig_bid_cancellationflag']  = $cancllockflag; 

     
     //echo "<pre>";
     //print_r($data);
     //echo "</pre>";
     //die;
      $data['bookingstatuschecktext']='';
      $offerexpo_on='';
      $offerexpo_on_second='';
      $offerexpflag = 0;
      //*************************  fetching data from gig master table ******************

      $getofferexpdata = DB::table('gig_master')->select('booking_req_date','request_expire')->where('giguniqueid',$gig_request_id)->first();


      //*************************  fetching data from gig master table ends here **********

       if($getofferexpdata)
      {
        $offerexpo_on = $getofferexpdata->booking_req_date;
        $offerexpo_on_second = $getofferexpdata->request_expire;


        if($offerexpo_on_second !='')
        {
          $offerexpflag = 1;

         $secondsval =  $this->secondsToTime($offerexpo_on_second);
          // echo "<br>";
         $seconds_time_val_day  = $secondsval['d'];
       
         $seconds_time_val_hour  = $secondsval['h'];
       
         $seconds_time_val_minutes  = $secondsval['m'];
        // echo "<br>";
       // echo "<br>";


          //*************

           $datevalidornot = date('Y-m-d H:i:s',strtotime('+'.$seconds_time_val_day.' days +'.$seconds_time_val_hour.' hour +'.$seconds_time_val_minutes.' minutes',strtotime($offerexpo_on)));

            $currentdateval = date('Y-m-d H:i:s');

            $datechecking = $this->datecheckingfunc($currentdateval,$datevalidornot,$gigmaster_timezone);
            // echo "Here 1 ===> ".$datechecking;
            if($datechecking == 2)
            {

              //************   remaining time calculation starts here

               $datechecking = $this->datecheckingfuncremaining($currentdateval,$datevalidornot,$gigmaster_timezone);
               $data['bookingstatusopenuntil']  = $datechecking;

              //************   remaining time checking ends here

              $data['bookingstatuschecktext']  = "prossibletoopen";
            }else
            {
              $data['bookingstatuschecktext']  = "notprossibletoopen";
              $data['bookingstatusopenuntil']  = "notdefifound";
            }
           


          //*************



        }else
        {
          $data['bookingstatusopenuntil']  = "notdefifound";
        }
      }

      //************   fetching request expire date time starts here from gig bid request ****************

      // echo $gig_request_id."== "; 


      $getofferexpdata1 = DB::table('gig_bidrequest')->select('offer_exp_datetime','offer_expire_totaltime')->where('giguniqueid',$gig_request_id)->first();

      

      if($getofferexpdata1)
      {

        //echo "Here 2";die;
         $offerexpo_on = $getofferexpdata1->offer_exp_datetime;
         $offerexpo_on_second = $getofferexpdata1->offer_expire_totaltime;


        if($offerexpo_on_second !='')
        {
          $offerexpflag = 1;

          $secondsval =  $this->secondsToTime($offerexpo_on_second);
         // echo "<br>";
          $seconds_time_val_day  = $secondsval['d'];
       
          $seconds_time_val_hour  = $secondsval['h'];
       
          $seconds_time_val_minutes  = $secondsval['m'];
      //  echo "<br>";
       // echo "<br>";


          //*************

          $datevalidornot = date('Y-m-d H:i:s',strtotime('+'.$seconds_time_val_day.' day +'.$seconds_time_val_hour.' hour +'.$seconds_time_val_minutes.' minutes',strtotime($offerexpo_on)));

            $currentdateval = date('Y-m-d H:i:s');

            $datechecking = $this->datecheckingfunc($currentdateval,$datevalidornot,$gigmaster_timezone);
            // echo "Here 2 ===>".$datechecking; die;
            if($datechecking == 2)
            {
               //************   remaining time calculation starts here

               $datechecking = $this->datecheckingfuncremaining($currentdateval,$datevalidornot,$gigmaster_timezone);

              //************   remaining time checking ends here
              $data['bookingstatuschecktext']  = "prossibletoopen";
              $data['bookingstatusopenuntil']  = $datechecking;
            }else
            {
              $data['bookingstatuschecktext']  = "notprossibletoopen";
              $data['bookingstatusopenuntil']  = "notdefifound";
            }



          //*************



        }else
        {
          $data['bookingstatusopenuntil']  = "notdefifound";
        }
      }


      //***********    fetch request expire date time ends here from gig bid request **************

      //************** check if the offer is already accecpted or not  starts here ***********

      $getofferexpdata2 = DB::table('gig_master')->select('booking_status')->where('giguniqueid',$gig_request_id)->first();

      if($getofferexpdata2)
      {
        $oferstatus = $getofferexpdata2->booking_status;

        if($oferstatus == 1)
        {
          $data['bookingstatuschecktext']  = "accecptedfrombothend";
        }
      }

      //**************  check if the offer is already accecpted or not ends here *************


      //********** condition check for request exp 14-01-2017
      if($data['bookingstatuschecktext'] === "notprossibletoopen")
      {
       // echo "Here = ".$data['bookingstatuschecktext'];

          $resp_arr['flag'] = 0;
          $resp_arr['type'] = 4; 
          $resp_arr['msg'] = "Unfortunately, this request has expired";
          echo json_encode($resp_arr);
          exit;
      }
      //**********  condition check for request exp 14-01-2017


     $data['divshow']  = "";

     // echo "<pre>";
     // print_r($data);die;

     
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
    


    //************************** starts of negotiation process
    public function savegigbidrequest(Request $request)
    {
     
                    $session_id = $request->session()->get('front_id_sess'); 
                    $gig_description = $request->input('gig_description');
                    $gigmaster_id = $request->input('gigmaster_id');
                    $ta_lock_id = $request->input('ta_lock_id');
                    $asd_lock_id = $request->input('asd_lock_id');
                    $bcf_lock_id = $request->input('bcf_lock_id');
                    //die($ta_lock_id." ".$asd_lock_id." ".$bcf_lock_id);
                    $Last_updated_by = $request->input('Last_updated_by');
                    $type_flag = $request->input('type_flag');
                    $gigpostrequestflagjs = $request->input('gigpostrequestflagjs');
                    $secconverval = $request->input('secconverval');
                    
                    $lastupdatetypeval =  $request->input('lastupdatettpe');


                    $totalamoutnlockflagval =  $request->input('totalamoutnlockflagval');
                    $securityamoutnlockflagval =  $request->input('securityamoutnlockflagval');
                    $cancellationamoutnlockflagval =  $request->input('cancellationamoutnlockflagval');

                    // echo "ta == ".$totalamoutnlockflagval;
                    // echo "sd == ".$securityamoutnlockflagval;
                    // echo "cf == ".$cancellationamoutnlockflagval;die;

                    // echo "==========";
                    // echo " ta_lock_id is ".$ta_lock_id;
                    // echo "==========";
                    // echo " asd_lock_id is ".$asd_lock_id;
                    // echo "==========";
                    // echo " bcf_lock_id is ".$bcf_lock_id;
                    // echo "==========";
                    // echo " Last_updated_by ".$Last_updated_by;
                    // echo "==========";
                    // die;

                    // if($ta_lock_id !='')
                    // {
                    //   // $ta_lock_id = $Last_updated_by;
                    //   // $ta_lock_flag = $lastupdatetypeval;

                    //   echo $ta_lock_id;
                    //    die;
                    // }
                    // if($asd_lock_id !='')
                    // {
                    //   // $asd_lock_id = $Last_updated_by;
                    //   // $asd_lock_flag = $lastupdatetypeval;
                    //   echo $asd_lock_id;
                    //    die;
                    // }
                    // if($bcf_lock_id!='')
                    // {
                    //   // $bcf_lock_id = $Last_updated_by;
                    //   // $bcf_lock_flag = $lastupdatetypeval;
                    //    echo $asd_lock_id;
                    //     die;
                    // }





        
                    //********** request expire time value strats here
                    $secconverval = $request->input('secconverval');
                    $seconds_time_val = $this->secondsToTime($secconverval);
                    $seconds_time_val_day  = $seconds_time_val['d'];
                    $seconds_time_val_hour  = $seconds_time_val['h'];
                    $seconds_time_val_minutes  = $seconds_time_val['m'];
                    
                     // echo "<br>";
                     // echo date('Y-m-d', strtotime(" + ".$seconds_time_val_day." days"));

                    //**********  request expire time value ends here
        
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
        
        
        
        //*************************************  Condition for if gig bid request is empty or not starts here
        
        //******** if empty 
        
                    if(empty($gig_bidrequest_id))
                    {

                      $Insert_into_gig_bidrequest = array(
                      'gigmaster_id'=>$gigmaster_id,
                      'giguniqueid'=>$gigunique_id,
                      'booker_id'=>$booker_id,
                      'lub_type_flag'=>$lastupdatetypeval,
                      'artist_id'=>$artist_id,
                      'type_flag'=>$type_flag,
                      'last_updated_by'=>$Last_updated_by,
                      'first_accepted_by'=>'',
                      'artist_security_deposit'=>$security_payment,
                      'asd_lock_id'=>$asd_lock_id,
                      'total_amount'=>$total_payment,
                      'ta_lock_id'=>$ta_lock_id,
                      'offer_exp_datetime'=>$created_date,
                      'offer_expire_totaltime'=>$secconverval,
                      'create_date'=>$created_date,
                      'modified_date'=>$created_date,
                      'gig_bid_status'=>1,

                      'ta_lock_flag'=>$totalamoutnlockflagval,
                      'asd_lock_flag'=>$securityamoutnlockflagval,
                      'bcf_lock_flag'=>$cancellationamoutnlockflagval

                      );

                      if($gigpostrequestflagjs == '2'){
                       if($artist_id!=$booker_id){
                        $Insert_into_gig_bidrequest['artist_id']=$artist_id;
                        $Insert_into_gig_bidrequest['lub_type_flag']='AGV';

                       }
                      }
                      else{
                       if($artist_id!=$booker_id){
                        $Insert_into_gig_bidrequest['artist_id']=$artist_id;
                        $Insert_into_gig_bidrequest['lub_type_flag']='AGV';
                       }
                      }

                      if($gig_description!=''){
                      $Insert_into_gig_bidrequest['gig_description']=e($gig_description);
                      }

                      if($cancellation_fee!=''){
                      $Insert_into_gig_bidrequest['booking_cancellation_fee']=$cancellation_fee;
                      $Insert_into_gig_bidrequest['bcf_lock_id']=$bcf_lock_id;
                      }

                      // echo "<pre>";
                      // print_r($Insert_into_gig_bidrequest);
                      // die;
                      $isInserted = DB::table('gig_bidrequest')->insert($Insert_into_gig_bidrequest);
                      $rerurnArray['flag'] = 1; 
                      $rerurnArray['msg'] = "Bid negotiated successfully."; 
                       // echo "Here ";


                      //**************************  email will be send after negotiation starts here


                      if($booker_id == $session_id)
                      {
                        $sndnegotiationemail1 = $this->sendnegotiationemail($gigunique_id,$artist_id,$type_flag,$booker_id,$typeval = 'BKR');
                      }else
                      {
                        $sndnegotiationemail1 = $this->sendnegotiationemail($gigunique_id,$artist_id,$type_flag,$booker_id,$typeval = 'AGV');
                      }

                      //************************** email will be send after negotiation ends here 
                    }
                    else
                    {
                        //******** if not empty 
                            
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
                        if(count($old_artist_or_booker_id)>0)
                        {
                         //************update section******************//

                         //echo " //************update section******************//";
                         $update_gig_bidrequest = array(
                          'gigmaster_id'=>$gigmaster_id,
                          'giguniqueid'=>$gigunique_id,
                          'booker_id'=>$booker_id,
                          'lub_type_flag'=>$lastupdatetypeval,
                          'type_flag'=>$type_flag,
                          'last_updated_by'=>$Last_updated_by,
                          'first_accepted_by'=>'',
                          'offer_exp_datetime'=>$created_date,
                          'offer_expire_totaltime'=>$secconverval,
                          'artist_security_deposit'=>$security_payment,
                          'asd_lock_id'=>$asd_lock_id,
                          'total_amount'=>$total_payment,
                          'ta_lock_id'=>$ta_lock_id,
                          'modified_date'=>$created_date,
                          'gig_bid_status'=>1,

                            'ta_lock_flag'=>$totalamoutnlockflagval,
                            'asd_lock_flag'=>$securityamoutnlockflagval,
                            'bcf_lock_flag'=>$cancellationamoutnlockflagval
                          );

    //                      if($gigpostrequestflagjs == '2'){
    //                       if($artist_id!=$booker_id){
    //                        $Insert_into_gig_bidrequest['artist_id']=$artist_id;
    //                        $Insert_into_gig_bidrequest['lub_type_flag']='AGV';
    //                       }
    //                      }else{
    //                       if($artist_id!=$booker_id){
    //                        $Insert_into_gig_bidrequest['artist_id']=$artist_id;
    //                        $Insert_into_gig_bidrequest['lub_type_flag']='AGV';
    //                       }
    //                      }


                             $Insert_into_gig_bidrequest['last_updated_by']=$Last_updated_by;
                             $Insert_into_gig_bidrequest['lub_type_flag']=$lastupdatetypeval;


                              if($gig_description!=''){
                              $update_gig_bidrequest['gig_description']=e($gig_description);
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
                                // echo "Here 1";

                               //**************************  email will be send after negotiation starts here


                                if($booker_id == $session_id)
                                {
                                  $sndnegotiationemail1 = $this->sendnegotiationemail($gigunique_id,$artist_id,$type_flag,$booker_id,$typeval = 'BKR');
                                }else
                                {
                                  $sndnegotiationemail1 = $this->sendnegotiationemail($gigunique_id,$artist_id,$type_flag,$booker_id,$typeval = 'AGV');
                                }

                                //************************** email will be send after negotiation ends here 
                              }

                        }
                            else
                         {
                         // echo "Here 2";
                                 //************insert section******************//
                                 //echo "//************insert section******************//";
                                   $Insert_into_gig_bidrequest = array(
                                  'gigmaster_id'=>$gigmaster_id,
                                  'giguniqueid'=>$gigunique_id,
                                  'booker_id'=>$booker_id,
                                  'lub_type_flag'=>$lastupdatetypeval,
                                  //'artist_id'=>$artist_id,
                                  'type_flag'=>$type_flag,
                                  'offer_exp_datetime'=>$created_date,
                                  'offer_expires_totaltime'=>$secconverval,
                                  'last_updated_by'=>$Last_updated_by,
                                  'first_accepted_by'=>'',
                                  'artist_security_deposit'=>$security_payment,
                                  'asd_lock_id'=>$asd_lock_id,
                                  'total_amount'=>$total_payment,
                                  'ta_lock_id'=>$ta_lock_id,
                                  'create_date'=>$created_date,
                                  'modified_date'=>$created_date,
                                  'gig_bid_status'=>1,

                                  'ta_lock_flag'=>$totalamoutnlockflagval,
                                  'asd_lock_flag'=>$securityamoutnlockflagval,
                                  'bcf_lock_flag'=>$cancellationamoutnlockflagval

                                  );
                                  if($artist_id!=$booker_id){
                                   $Insert_into_gig_bidrequest['artist_id']=$artist_id;
                                  $Insert_into_gig_bidrequest['lub_type_flag']='AGV';
                                  }
                                  if($gig_description!=''){
                                  $Insert_into_gig_bidrequest['gig_description']=e($gig_description);
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
        //*************************************  Condition for if gig bid request is empty or not ends
        
        
                    echo json_encode($rerurnArray);
    }


    //*****************************************************  end of negotiation process
    
    //********** accecpt of booking request by artist starts here
    
    function accptbidrequestbyartist(Request $request)
    {   
      $rerurnArray = array();
        
      $is_gig_bidrequest_updated = '';
      $is_gig_bidrequest_insert = ''; 
      $gig_bidrequest_id = $request->input('gig_bidrequest_id');
      $gigunique_id = $request->input('gigunique_id');
      $gigmaster_id = $request->input('gigmaster_id');

      $gig_description = $request->input('gig_description');
      $type_flag = $request->input('type_flag');
      $booker_id = $request->input('booker_id');
      
      
    //************** Who am I starts here
      $whoami = $request->input('whoami');
      $whoamitext = $request->input('whoamitext');
      $w_am_id_agv = $request->input('w_am_id_agv');
    //************** who am I ends here
        
        
    $cancellation_fee = str_replace(',', '',ltrim($request->input('cancellation_fee'),"$"));
    $total_payment = str_replace(',', '',ltrim($request->input('total_payment'),"$"));
    $security_payment =str_replace(',', '',ltrim($request->input('security_payment'),"$"));
      
      
      $accept_by = $request->input('accept_by');
        
      //*********** if already data exists in gig_bidrequest form starts here
       
      if($gig_bidrequest_id!='')
      {  
          
         
          
           $accept_gig_bidrequest = array(
           'gigmaster_id'=>$gigmaster_id,
           'giguniqueid'=>$gigunique_id,
          // 'first_accepted_by'=>$accept_by,
           'artist_security_deposit'=>$security_payment,
           'asd_lock_id'=>$whoami,
           'total_amount'=>$total_payment,
           'ta_lock_id'=>$whoami,
           'modified_date'=>date('Y-m-d H:i:s'),
           'gig_bid_status'=>1
           );

           
           if($cancellation_fee!=''){
           $accept_gig_bidrequest['booking_cancellation_fee']=$cancellation_fee;
           $accept_gig_bidrequest['bcf_lock_id']=$whoami;
           }
           if($gig_description!=''){
           $accept_gig_bidrequest['gig_description']=e($gig_description);
           }
          
          
           //********************  check if already accecpted by booker starts here
            
           $qryforcountfirstaccept =  DB::table('gig_bidrequest')->select('first_accepted_by','fab_type_flag')->where('id',$gig_bidrequest_id)->first();
//          echo "<pre>";
//          print_r($qryforcountfirstaccept);
          
          $accecptbyid = $qryforcountfirstaccept->first_accepted_by;
          $acptbytype = $qryforcountfirstaccept->fab_type_flag;

          if( ($accecptbyid > 0) && ($acptbytype == 'BKR') ) //************ If already accecpted by booker starts 
          {
              $accept_gig_bidrequest['last_updated_by']=$whoami;
              $accept_gig_bidrequest['lub_type_flag']=$whoamitext;
              $accept_gig_bidrequest['gig_bid_status']='2';
              
              
              //*************   Over lapping validation starts here 
              
                //********************************************
               //*********************************************
              
              //*************   Overlaping validation ends here
              
              //*********** insert data into gig master starts here code to be written   here
              
              
              /************************************************/
              /************************************************/
              /************************************************/
              /************************************************/
              /************************************************/
              
              //*********** insert data into gig master starts here code to be written   here
              
              
               //echo "Hello";die; 
              
          }else 
          {
              //************ If first time accecpted by artist starts 
              
               //*************   Over lapping validation starts here 
              
                //********************************************
            
              $overlappingtime_artistaccpt = $this->artistoverlaping($whoami,$type_flag,$gigunique_id);
              
              if($overlappingtime_artistaccpt == 1)
              {
                  $rerurnArray['flag'] = 0; 
                  $rerurnArray['msg'] = "You can not accept this request. You already have a confirmed booking for another event";
                  echo json_encode($rerurnArray);
                  exit();
              }
               //*********************************************
              
              //*************   Overlaping validation ends here
              
              
              
              $accept_gig_bidrequest['first_accepted_by']=$whoami;
              $accept_gig_bidrequest['fab_type_flag']=$whoamitext;
              $accept_gig_bidrequest['last_updated_by']=$whoami;
              $accept_gig_bidrequest['lub_type_flag']=$whoamitext;
              
              //************ If first time accecpted by artist starts 
              
          }
          //********************  check if already accecpted by booker ends here
           
           $is_gig_bidrequest_updated = DB::table('gig_bidrequest')->where('id',$gig_bidrequest_id)->update($accept_gig_bidrequest);
           
      } //*********** if already data exists in gig_bidrequest form ends here
        else
        { //*********** else already data exists in gig_bidrequest form starts here
       //echo "Hello Here";die;
         //  echo "Hello artist here".$gig_bidrequest_id.' ';//die;
            
            $accept_gig_bidrequest = array(
           'gigmaster_id'=>$gigmaster_id,
           'giguniqueid'=>$gigunique_id,
           'booker_id'=>$booker_id,
           'artist_id'=>$whoami,
           'type_flag'=>$type_flag,
           'last_updated_by'=>$accept_by,
           'create_date'=>date('Y-m-d H:i:s'),
           'first_accepted_by'=>$whoami,
           'last_updated_by'=>$whoami,
           'lub_type_flag'=>$whoamitext,
           'fab_type_flag'=>$whoamitext,   
           'artist_security_deposit'=>$security_payment,
           'asd_lock_id'=>$whoami,
           'total_amount'=>$total_payment,
           'ta_lock_id'=>$whoami,
           'modified_date'=>date('Y-m-d H:i:s'),
           'gig_bid_status'=>1
           );
            
            
              //********************************************
            
              $overlappingtime_artistaccpt = $this->artistoverlaping($whoami,$type_flag,$gigunique_id);
                  

              if($overlappingtime_artistaccpt == 1)
              {
                  $rerurnArray['flag'] = 0; 
                  $rerurnArray['msg'] = "You can not accept this request. You already have a confirmed booking for another event";
                  echo json_encode($rerurnArray);
                  exit();
              }
            
            
               //*********************************************
            
           
           if($cancellation_fee!=''){
           $accept_gig_bidrequest['booking_cancellation_fee']=$cancellation_fee;
           $accept_gig_bidrequest['bcf_lock_id']=$accept_by;
           }
           if($gig_description!=''){
           $accept_gig_bidrequest['gig_description']=e($gig_description);
           }
           
           $is_gig_bidrequest_insert = DB::table('gig_bidrequest')->insert($accept_gig_bidrequest);
      } //*********** else already data exists in gig_bidrequest form starts here

          
           if($is_gig_bidrequest_updated == 1 || $is_gig_bidrequest_insert == 1 ){
              $rerurnArray['flag'] = 1; 
              $rerurnArray['msg'] = "Congratulations, you have accepted a Booking Request";
           }else{
              $rerurnArray['flag'] = 0; 
              $rerurnArray['msg'] = "Hmm, something went wrong in the event cancellation process";
           }
           echo json_encode($rerurnArray);
    }
    
    
    //********** accecpt of booking request by booker starts here
    function accptbidrequestbybooker(Request $request) 
    {  
     //echo "Hello booking by booker and artist ";
      $sessionid = $request->session()->get('front_id_sess');
      $rerurnArray = array();
      $rerurnArray['escrow_flagresponse'] = 0; 


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
      $currentDateTime = date('m-d-Y H:i:s');
      $booker_curent_balance = '';
      $booker_id = $request->input('booker_id');
      $secconverval = $request->input('secconverval');
      $whoami = $request->input('whoami');
      $whoamitext = $request->input('whoamitext');
      $w_am_id_agv = $request->input('w_am_id_agv');

      $ta_lock_id = $request->input('ta_lock_id');
      $asd_lock_id = $request->input('asd_lock_id');
      $bcf_lock_id = $request->input('bcf_lock_id');
                    //die($ta_lock_id." ".$asd_lock_id." ".$bcf_lock


      $totalamoutnlockflagval =  $request->input('totalamoutnlockflagval');
      $securityamoutnlockflagval =  $request->input('securityamoutnlockflagval');
      $cancellationamoutnlockflagval =  $request->input('cancellationamoutnlockflagval');
     
      $updatedatatogigbidreqarray = array();
      $insertdatatogigbidreqarray = array();
      $bookingacceptgigmaster = array();

      //************ get complete details from gigmaster table starts here
      $getcompletedetailsdata = $this->customfuncgigdetsils($gigunique_id);

      $getingbookerid = $getcompletedetailsdata->booker_id;
      $getingartistid = $getcompletedetailsdata->artist_id;
      $getingtypeflag = $getcompletedetailsdata->type_flag;

      //************ get complete details from gigmaster table ends here

      //************* wallet balance condition starts here ***********

      if($getingbookerid == $sessionid)
        {
          $walletblnccheckqry = $this->checkwaletbalancndition($getingbookerid,$getingartistid,$getingtypeflag,$total_payment);

          if( $walletblnccheckqry == 0)
          {
             $rerurnArray['flag'] = 0; 
             $rerurnArray['msg'] = "You can not accept this request. You do not have sufficient amount to continue the booking request";
              echo json_encode($rerurnArray);
              exit();
          }
        }


      //************* wallet balance condition ends here ************


      //***************** overlapping condition starts here 
       $overlappingtime_artistaccpt = $this->artistoverlaping($getingartistid,$getingtypeflag,$gigunique_id);
         if($overlappingtime_artistaccpt == 1)
              {
                $rerurnArray['flag'] = 0; 

                if($getingbookerid == $sessionid)
                {
                  $rerurnArray['msg'] = "You can not accept this request. This artist already have a confirmed booking for another event";
                }else
                {
                  $rerurnArray['msg'] = "You can not accept this request. You already have a confirmed booking for another event";
                }

                  
                  
                  echo json_encode($rerurnArray);
                  exit();
              }
      //*****************  overlapping condition ends here 


             




      //*************  check this gig is already accepted or not starts here   ********


              $check_alreadyexceptedornot =  DB::table('gig_bidrequest')
              ->where('giguniqueid',$gigunique_id)
              ->first();
              $countvaldata = count($check_alreadyexceptedornot);


              // echo "<pre>";
              // print_r($check_alreadyexceptedornot);die;

              if($countvaldata > 0)
              {
                $check_alreadyexceptedval = $check_alreadyexceptedornot->first_accepted_by;  

                if($check_alreadyexceptedval!='' && $check_alreadyexceptedval>0)
                {
          

                 //*********  Here we are going to complete the accept process from both end by release escrow amount

                  $escrowpaymentdone = $this->escrowonacceptingbkrequest($booker_id,$bkridtype=1,$gigmaster_id);

                  //if(flagresp)
                  // echo "<pre>";
                  // print_r($escrowpaymentdone);
                  // echo " flag response data ====> ".$escrowpaymentdone['flagresp'];

                  //**************** email will send to use if escrowed true starts


                  if($escrowpaymentdone['flagresp'] == 1)
                  {
                     $rerurnArray['escrow_flagresponse'] = 1; 
                  }


                  //**************** email will send to use if escrowed true starts

                  
                  //***********  if escrow amount is released then update the table starts here


                    $updatedatatogigbidreqarray['gig_description'] = e($gig_description);
                    $updatedatatogigbidreqarray['modified_date'] = date('Y-m-d H:i:s');
                    $updatedatatogigbidreqarray['last_updated_by'] = $whoami;
                    $updatedatatogigbidreqarray['gig_bid_status'] = '2';
                    $updatedatatogigbidreqarray['lub_type_flag'] = $whoamitext;

                    $updatedatatogigbidreqarray['total_amount'] = $total_payment;
                    $updatedatatogigbidreqarray['artist_security_deposit'] = $security_payment;
                    $updatedatatogigbidreqarray['booking_cancellation_fee'] = $cancellation_fee;

                    $updatedatatogigbidreqarray['ta_lock_id']=$ta_lock_id;
                    $updatedatatogigbidreqarray['asd_lock_id']=$asd_lock_id;
                    $updatedatatogigbidreqarray['bcf_lock_id']=$bcf_lock_id;

                    $updatedatatogigbidreqarray['ta_lock_flag']=$totalamoutnlockflagval;
                    $updatedatatogigbidreqarray['asd_lock_flag']=$securityamoutnlockflagval;
                    $updatedatatogigbidreqarray['bcf_lock_flag']=$cancellationamoutnlockflagval;

                    $secondacptqry = DB::table('gig_bidrequest')
                    ->where('giguniqueid', $gigunique_id)
                    ->update($updatedatatogigbidreqarray);


                    //*********** if payment release then update gig master table table starts here

                      $bookingacceptgigmaster['booking_accept_date'] = date('Y-m-d H:i:s');
                      $bookingacceptgigmaster['booking_status'] ='1';




                    $updategigmasterqry = DB::table('gig_master')
                    ->where('giguniqueid', $gigunique_id)
                    ->update($bookingacceptgigmaster);

                    //*********** if payment release then update gig master table table ends here

                    if($secondacptqry)
                    {


                       $emailsendafteraccecpt_nego = $this->sendemailaccept($gigunique_id,$whoamitext,$whoami,$getingtypeflag,$booker_id,$getingartistid,$sessionid);

                       $rerurnArray['flag'] = 1; 
                       $rerurnArray['msg'] = "Bid Accepted successfully";
                        echo json_encode($rerurnArray);
                        exit();
                    }


                    

                  //***********  if escrow amount is released then update the table ends here


        }else
        {
          //**********  here we are going to accept the data for the first time by booker or artist 

            //*******  updating of data into gig bid request table starts here

            $updatedatatogigbidreqarray['gig_description'] = e($gig_description);
            $updatedatatogigbidreqarray['modified_date'] = date('Y-m-d H:i:s');
            $updatedatatogigbidreqarray['first_accepted_by'] = $whoami;
            $updatedatatogigbidreqarray['fab_type_flag'] = $whoamitext;
            $updatedatatogigbidreqarray['last_updated_by'] = $whoami;
            $updatedatatogigbidreqarray['lub_type_flag'] = $whoamitext;

            $updatedatatogigbidreqarray['total_amount'] = $total_payment;
            $updatedatatogigbidreqarray['artist_security_deposit'] = $security_payment;
            $updatedatatogigbidreqarray['booking_cancellation_fee'] = $cancellation_fee;

            $updatedatatogigbidreqarray['ta_lock_flag']=$totalamoutnlockflagval;
            $updatedatatogigbidreqarray['asd_lock_flag']=$securityamoutnlockflagval;
            $updatedatatogigbidreqarray['bcf_lock_flag']=$cancellationamoutnlockflagval;

            // $updatedatatogigbidreqarray['ta_lock_flag']=$totalamoutnlockflagval;
            // $updatedatatogigbidreqarray['asd_lock_flag']=$securityamoutnlockflagval;
            // $updatedatatogigbidreqarray['bcf_lock_flag']=$bcf_lock_id;
            $updatedatatogigbidreqarray['ta_lock_id']=$ta_lock_id;
            $updatedatatogigbidreqarray['asd_lock_id']=$asd_lock_id;
            $updatedatatogigbidreqarray['bcf_lock_id']=$bcf_lock_id;
                  

            $firstacptqry = DB::table('gig_bidrequest')
            ->where('giguniqueid', $gigunique_id)
            ->update($updatedatatogigbidreqarray);

            if($firstacptqry)
            {
              //echo "First accecpted section"; die;


              $emailsendafteraccecpt_nego = $this->sendemailaccept($gigunique_id,$whoamitext,$whoami,$getingtypeflag,$booker_id,$getingartistid,$sessionid);

                      $rerurnArray['flag'] = 1; 
                      $rerurnArray['msg'] = "Bid Accepted successfully";
                      echo json_encode($rerurnArray);
                      exit();
            }

            //*******  inserting data into gig bid request table ends here


          // echo "Here we are on negotiation stage";die;
        }


      }else
      {
          // echo "Here we are first time entering the data into gig bid request table";die;

            $insertdatatogigbidreqarray['gig_description'] = e($gig_description);
            $insertdatatogigbidreqarray['create_date'] = date('Y-m-d H:i:s');
            $insertdatatogigbidreqarray['modified_date'] = date('Y-m-d H:i:s');
            $insertdatatogigbidreqarray['first_accepted_by'] = $whoami;
            $insertdatatogigbidreqarray['fab_type_flag'] = $whoamitext;
            $insertdatatogigbidreqarray['last_updated_by'] = $whoami;
            $insertdatatogigbidreqarray['lub_type_flag'] = $whoamitext;
            $insertdatatogigbidreqarray['giguniqueid'] = $gigunique_id;
            $insertdatatogigbidreqarray['gigmaster_id'] = $gigmaster_id;

            $insertdatatogigbidreqarray['booker_id'] = $getingbookerid;
            $insertdatatogigbidreqarray['artist_id'] = $getingartistid;
            $insertdatatogigbidreqarray['type_flag'] = $getingtypeflag;

            $insertdatatogigbidreqarray['gig_bid_status'] = '1';

            $insertdatatogigbidreqarray['total_amount'] = $total_payment;
            $insertdatatogigbidreqarray['artist_security_deposit'] = $security_payment;
            $insertdatatogigbidreqarray['booking_cancellation_fee'] = $cancellation_fee;

            $insertdatatogigbidreqarray['ta_lock_flag']=$totalamoutnlockflagval;
            $insertdatatogigbidreqarray['asd_lock_flag']=$securityamoutnlockflagval;
            $insertdatatogigbidreqarray['bcf_lock_flag']=$cancellationamoutnlockflagval;

            // $insertdatatogigbidreqarray['ta_lock_flag']=$totalamoutnlockflagval;
            // $insertdatatogigbidreqarray['asd_lock_flag']=$securityamoutnlockflagval;
            // $insertdatatogigbidreqarray['bcf_lock_flag']=$bcf_lock_id;

            $insertdatatogigbidreqarray['ta_lock_id']=$ta_lock_id;
            $insertdatatogigbidreqarray['asd_lock_id']=$asd_lock_id;
            $insertdatatogigbidreqarray['bcf_lock_id']=$bcf_lock_id;

            
            
            $insertdatatogigbidreqarray['offer_exp_datetime'] = date('Y-m-d H:i:s');
            $insertdatatogigbidreqarray['offer_expire_totaltime'] = $secconverval;
             //$secconverval = $request->input('secconverval');
              

            $firstinsertqry = DB::table('gig_bidrequest')
            ->insert($insertdatatogigbidreqarray);

            if($firstinsertqry)
            {
              // echo "First inserted section"; die;



            //****************  Email send after accecpt by artist for the first time of negotiaation process starts here
             // echo "I am going to accept the data for the first time";

              $emailsendafteraccecpt_first = $this->sendemailaccept($gigunique_id,$whoamitext,$whoami,$getingtypeflag,$booker_id,$getingartistid,$sessionid);


            //****************  Email send after accecpt by artist for the first time of negotiaation process ends here




              $rerurnArray['flag'] = 1; 
              $rerurnArray['msg'] = "Bid Accepted successfully";
              echo json_encode($rerurnArray);
              exit();
            }

      }
       


      //*************  check this event is already accepted or not ends here   ********

    


     
    
     
     
           
           
         
          


          // echo json_encode($rerurnArray);
    }
    
    
     //*******************************************************************************************************************
    //**************************** Function for event cancelled by booker starts here ***********************************
    
    
    
    function gigcancelbybooker(Request $request){
     
      $gig_bidrequest_id = $request->input('gig_bidrequest_id');
      $gigunique_id = $request->input('gigunique_id');
      $gigmaster_id = $request->input('gigmaster_id');
      $security_payment = $request->input('security_payment');
      $total_payment = $request->input('total_payment');
      $cancellation_fee = $request->input('cancellation_fee');
      $gig_description = $request->input('gig_description');
      $canceled_by = $request->input('canceled_by');
        
      //************* Last updated by id and type starts here
      $last_updated_by = $request->input('Last_updated_by');
      $lastupdatettpe = $request->input('lastupdatettpe');
      //************* Last updated by id and type ends here
      
      $rerurnArray = array();

      $isgig_bidrequest_count = DB::table('gig_bidrequest')->where('giguniqueid',$gigunique_id)->count();
      if($isgig_bidrequest_count>0){
       $update_gig_bidrequest = array(
       "gig_bid_status"=>3,
       "last_updated_by"=>$last_updated_by,
       "lub_type_flag"=>$lastupdatettpe,
       "modified_date"=>date('Y-m-d H:i:s'),
       );
       $isgig_bidrequest_update = DB::table('gig_bidrequest')->where('giguniqueid',$gigunique_id)->where('id',$gig_bidrequest_id)->update($update_gig_bidrequest);
       
       $update_gig_master = array(
       //"booking_status"=>9
       "booking_status"=>8,
       "cancel_by_whom"=>2,
       "cancel_type_flag"=>1,
       "cancel_manual_id"=>$last_updated_by,
       );
       $isgig_masterUpdated = DB::table('gig_master')->where('id',$gigmaster_id)->update($update_gig_master);
       
      }else{
       
       $update_gig_master = array(
       //"booking_status"=>9
       "booking_status"=>8,
       "cancel_by_whom"=>2,
       "cancel_type_flag"=>1,
       "cancel_manual_id"=>$last_updated_by,
       );
       $isgig_bidrequest_update = DB::table('gig_master')->where('id',$gigmaster_id)->update($update_gig_master);
       
      }


       
       //if($isgig_bidrequest_count>0){
       //if($isgig_masterUpdated == '1' and $isgig_bidrequest_update=="1"){
       if($isgig_bidrequest_update=="1"){
            $rerurnArray['flag'] = 1; 
            $rerurnArray['msg'] = "Your Booking Request has been canceled";
         }else{
            $rerurnArray['flag'] = 0; 
            $rerurnArray['msg'] = "Hmm, something went wrong in the event cancellation process";
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
       
       
//**************add in 16-12-16 start ************//
      $gig_master_details = DB::table('gig_master as gm')
      ->select(DB::raw("gm.type_flag,gm.type_flag,gm.type_flag,gm.artist_id,gm.booker_id,gm.giguniqueid"))
      ->where('gm.id',$gigmaster_id)
      ->first();
      $artist_email = '';
      $artist_id = '';
      $artist_name = '';
      
      $booker_email = '';
      $booker_id = '';
      $booker_name= '';
      
      if(!empty($gig_master_details)){
       $type_flag = $gig_master_details->type_flag;
       
       if($type_flag == '1'){
        
          $artist_mail_details = DB::table('user_master as um')
          ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
          ->where('id',$gig_master_details->artist_id)
          ->first();
       }else if($type_flag == '2'){
        
          $artist_mail_details = DB::table('user_master as um')
          ->Join('group_master as gm', function($join)
          {
                  $join->on('gm.creater_id','=','um.id');
          })
          ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
          ->where('gm.id',$gig_master_details->artist_id)
          ->first();
       }else if($type_flag == '3'){
        
          $artist_mail_details = DB::table('user_master as um')
          ->Join('venue_master as vm', function($join)
          {
                  $join->on('vm.creater_id','=','um.id');
          })
          ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
          ->where('vm.id',$gig_master_details->artist_id)
          ->first();
       }
       if(!empty($artist_mail_details)){
        
        $artist_email = $artist_mail_details->email;
        $artist_id = $artist_mail_details->id;
        $artist_name = $artist_mail_details->nickname;
        
       }
       
        $booker_mail_details = DB::table('user_master as um')
        ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
        ->where('id',$gig_master_details->booker_id)
        ->first();
        
        if(!empty($booker_mail_details)){
         $booker_email = $booker_mail_details->email;
         $booker_id = $booker_mail_details->id;
         $booker_name= $booker_mail_details->nickname;
        }
        
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
        
        //************* Send mail to artist***********//
        $replacefrom =array('{USER}','{BY_WHOM}','{EVENT_NAME}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{CNCLDCL}");
        $replaceto =array(ucfirst($artist_name)," by ".$booker_name." as a Booker",$gig_master_details->giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG," cancelled ");
        mailsnd($Temid=50,$replacefrom,$replaceto,$artist_email);
        //************* Send mail to artist ***********//
        
        //************* Send mail to booker ***********//
        $replacefrom =array('{USER}','{BY_WHOM}','{EVENT_NAME}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{CNCLDCL}");
        $replaceto =array(ucfirst($booker_name)," by you ",$gig_master_details->giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG," cancelled ");
        mailsnd($Temid=50,$replacefrom,$replaceto,$booker_email);
        //************* Send mail to booker ***********//
       
      }
      //**************add in 16-12-16 end ************//
       
       
       echo json_encode($rerurnArray);
      
    }
    
    
     //*******************************************************************************************************************
    //**************************** Function for event cancelled by booker ends here ***********************************
    
    //*******************************************************************************************************************
    //**************************** Function for event cancelled by artist starts here ***********************************
    
    
    
    
    function gigcancelbyartist(Request $request)
    {
     
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
        
        
      //************* Last updated by id and type starts here
      $alldetails='';
      $last_updated_by = $request->input('Last_updated_by');
      $lastupdatettpe = $request->input('lastupdatettpe');
      $w_am_id_agv = $request->input('w_am_id_agv');
        
      //************* Last updated by id and type ends here  
      
        
        
        
        
      
      if($gig_bidrequest_id!=''){ //***********  if gig bid request id not equals to blank
       if($tab_db_um->gigpostrequestflag=='1'){ //*********** if gig posted
             $upadate_array = array(
//                 'gigmaster_id'=>$gigmaster_id,
//                 'giguniqueid'=>$gigunique_id,
//                 'artist_security_deposit'=>$security_payment,
//                 'total_amount'=>$total_payment,
                 'modified_date'=>date('Y-m-d H:i:s'),
                 'gig_bid_status'=>3,
                 //'type_flag'=>$type_flag,
                 //'artist_id'=>$canceled_by,
                 "last_updated_by"=>$last_updated_by,
                 "lub_type_flag"=>$lastupdatettpe,
             );
             $isgig_bidrequest_update = DB::table('gig_bidrequest')->where('id',$gig_bidrequest_id)->update($upadate_array);
             }
        else if($tab_db_um->gigpostrequestflag=='2'){  //*********** if individual booking request
          $upadate_array = array(
//              'gigmaster_id'=>$gigmaster_id,
//              'giguniqueid'=>$gigunique_id,
//              'artist_security_deposit'=>$security_payment,
//              'total_amount'=>$total_payment,
              'modified_date'=>date('Y-m-d H:i:s'),
              'gig_bid_status'=>3,
//              'type_flag'=>$type_flag,
//              'artist_id'=>$canceled_by,
              "last_updated_by"=>$last_updated_by,
              "lub_type_flag"=>$lastupdatettpe,
              
          );
          $isgig_bidrequest_update = DB::table('gig_bidrequest')->where('id',$gig_bidrequest_id)->update($upadate_array);
          
          $update_gig_master = array(
          //"booking_status"=>9
          "booking_status"=>8,
          "cancel_by_whom"=>1,
          "cancel_type_flag"=>$w_am_id_agv,
          "cancel_manual_id"=>$last_updated_by,
          "cancel_date"=>date('Y-m-d H:i:s')
          );
          $isgig_bidrequest_update = DB::table('gig_master')->where('id',$gigmaster_id)->update($update_gig_master);
       }

       
       
       
      }else{ //***********  if gig bid request id  equals to blank
     
      
       


       
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
            
           
           
           
           //************************* get gig detsils starts here
          $alldetails = $this->customfuncgigdetsils($gigunique_id);
//           echo "<pre>";
//           print_r($alldetails);
          $gigdetailsartist_id = $alldetails->artist_id;
          $gigdetailsbooker_id = $alldetails->booker_id;
          $gigdetailsbcf_lock_id = $alldetails->bcf_lock_id; 
          $gigdetailsasd_lock_id = $alldetails->asd_lock_id;
          $gigdetailsta_lock_id = $alldetails->ta_lock_id;
           
           
           
           $insertydata_array = array(
                'gigmaster_id'=>$gigmaster_id,
                'giguniqueid'=>$gigunique_id,
                'artist_security_deposit'=>$security_payment,
                'total_amount'=>$total_payment,
                'create_date'=>date('Y-m-d H:i:s'),
                'modified_date'=>date('Y-m-d H:i:s'),
                'gig_bid_status'=>3,
                'type_flag'=>$type_flag,
                'artist_id'=>$gigdetailsartist_id,
                'booker_id'=>$gigdetailsbooker_id,
                'last_updated_by'=>$gigdetailsartist_id,
                'lub_type_flag'=>'AGV',
                'booking_cancellation_fee'=>$cancellation_fee,
               
//                'bcf_lock_id'=>$gigdetailsbooker_id,
//                'bcf_lock_flag'=>'BKR',
//                'asd_lock_id'=>$cancellation_fee, 
//                'asd_lock_flag'=>
                
               
        );
           
            $isInserted = DB::table('gig_bidrequest')->insert($insertydata_array);
           
          // die;
           
           
           //*************************  get gig detsils ends here
        
         $update_gig_master = array(
         //"booking_status"=>9
             "booking_status"=>8,
             "cancel_manual_id"=>$gigdetailsartist_id,
             "cancel_by_whom"=>'1',
             "cancel_type_flag"=>$type_flag,
             "cancel_date"=>date('Y-m-d H:i:s'),
             
             
             
         );
         $isgig_bidrequest_update = DB::table('gig_master')->where('id',$gigmaster_id)->update($update_gig_master);
         
       }

       
       
      }
      //echo json_encode($upadate_array);
      $rerurnArray = array();
      if($isgig_bidrequest_insert == 1 || $isgig_bidrequest_update == 1){
         $rerurnArray['flag'] = 1; 
         $rerurnArray['msg'] = "Your Booking Request has been declined";
         
         
      //**************add in 16-12-16 start ************//
      $gig_master_details = DB::table('gig_master as gm')
      ->select(DB::raw("gm.type_flag,gm.type_flag,gm.type_flag,gm.artist_id,gm.booker_id,gm.giguniqueid"))
      ->where('gm.id',$gigmaster_id)
      ->first();
      
      $artist_email = '';
      $artist_id = '';
      $artist_name = '';
      
      $booker_email = '';
      $booker_id = '';
      $booker_name= '';
      
      if(!empty($gig_master_details)){
       $type_flag = $gig_master_details->type_flag;
       
       if($type_flag == '1'){
        
          $artist_mail_details = DB::table('user_master as um')
          ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
          ->where('id',$gig_master_details->artist_id)
          ->first();
       }else if($type_flag == '2'){
        
          $artist_mail_details = DB::table('user_master as um')
          ->Join('group_master as gm', function($join)
          {
                  $join->on('gm.creater_id','=','um.id');
          })
          ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
          ->where('gm.id',$gig_master_details->artist_id)
          ->first();
       }else if($type_flag == '3'){
        
          $artist_mail_details = DB::table('user_master as um')
          ->Join('venue_master as vm', function($join)
          {
                  $join->on('vm.creater_id','=','um.id');
          })
          ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
          ->where('vm.id',$gig_master_details->artist_id)
          ->first();
       }
       if(!empty($artist_mail_details)){
        
        $artist_email = $artist_mail_details->email;
        $artist_id = $artist_mail_details->id;
        $artist_name = $artist_mail_details->nickname;
        
       }
       
        $booker_mail_details = DB::table('user_master as um')
        ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
        ->where('id',$gig_master_details->booker_id)
        ->first();
        
        if(!empty($booker_mail_details)){
         $booker_email = $booker_mail_details->email;
         $booker_id = $booker_mail_details->id;
         $booker_name= $booker_mail_details->nickname;
        }
        
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
        
        //************* Send mail to booker***********//
        $replacefrom =array('{USER}','{BY_WHOM}','{EVENT_NAME}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{CNCLDCL}");
        $replaceto =array(ucfirst($booker_name)," by ".$artist_name." as a Artist",$gig_master_details->giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG," declined ");
        mailsnd($Temid=50,$replacefrom,$replaceto,$booker_email);
        //************* Send mail to booker ***********//
        
        //************* Send mail to artist ***********//
        $replacefrom =array('{USER}','{BY_WHOM}','{EVENT_NAME}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{CNCLDCL}");
        $replaceto =array(ucfirst($artist_name)," by you ",$gig_master_details->giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG," declined ");
        mailsnd($Temid=50,$replacefrom,$replaceto,$artist_email);
        //************* Send mail to artist ***********//
       
      }
      //**************add in 16-12-16 end ************//
         
         
         
      }else{
         $rerurnArray['flag'] = 0; 
         $rerurnArray['msg'] = "Hmm, something went wrong in the event cancellation process";
      }
      echo json_encode($rerurnArray);
    }
    
    //*******************************************************************************************************************
    //**************************** Function for event cancelled by artist ends here ***********************************
    
    
    
    
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
    
    
    //*********************** custom function to get event details  starts here  modified starts for booking form split
    public function customfuncgigdetsils($eventid)
    {
     $eventdetsilsqry = DB::table('gig_master')->where('giguniqueid',$eventid)->first();   
        return $eventdetsilsqry;
    }
    //***********************  custom function to get event details ends here
    
    
    //************ converting from secods to time starts here **************
    
    
    function secondsToTime($inputSeconds)
    { 
        $secondsInAMinute = 60; 
        $secondsInAnHour = 60 * $secondsInAMinute;
        $secondsInADay = 24 * $secondsInAnHour; 
        // extract days
        $days = floor($inputSeconds / $secondsInADay); 
        // extract hours
        $hourSeconds = $inputSeconds % $secondsInADay; 
        $hours = floor($hourSeconds / $secondsInAnHour); 
        // extract minutes
        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);
        // extract the remaining seconds 
        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);
        // return the final array
        $obj = array( 'd' => (int) $days, 'h' => (int) $hours, 'm' => (int) $minutes, 's' => (int) $seconds, ); 
        return $obj;
    }
    
    //************ converting from seconds to time ends here ***************
    
    function artistoverlaping($whoami,$type_flag,$gigunique_id)
    {
        $flag1=0;$flag2=0;$flag3=0;$flag=0; $venueqrycount=0; $artistqrycount=0;$groupqrycount=0;
        
        //********* getting event start date time and end date time starts here
        
        
        $geting_details = $this->customfuncgigdetsils($gigunique_id);
        
        
        $evntstrtdatetime = $geting_details->event_start_date_time;
        $evntenddatetime = $geting_details->event_end_date_time;
//        echo "<pre>";
//        print_r($geting_details);//die;
        
        //********* getting event start date time  end date time ends here
        
        if($type_flag == 1)
        {
            //echo "This is artist ";
            
            
            
                    //************* getting user booking details starts here
            
                    //***** for artist 
            
                    $rqry_a = DB::table('gig_master')
                                ->where('event_start_date_time','>=',$evntstrtdatetime)
                                ->where('event_end_date_time','<=',$evntenddatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$whoami)
                                ->where('type_flag',$type_flag)
                                ->get();
            
                    
                    $rqry_a1 = DB::table('gig_master')
                                ->where('event_start_date_time','<=',$evntstrtdatetime)
                                ->where('event_end_date_time','>=',$evntstrtdatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$whoami)
                                ->where('type_flag',$type_flag)
                                ->get();
           
                        
                    $rqry_a2 = DB::table('gig_master')
                                ->where('event_start_date_time','<=',$evntenddatetime)
                                ->where('event_end_date_time','>=',$evntenddatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$whoami)
                                ->where('type_flag',$type_flag)
                                ->get();
                     
                        
                    $rqry_a3 = DB::table('gig_master')
                                ->where('event_start_date_time','<=',$evntstrtdatetime)
                                ->where('event_end_date_time','>=',$evntstrtdatetime)
                                ->where('event_end_date_time','<=',$evntenddatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$whoami)
                                ->where('type_flag',$type_flag)
                                ->get();
                    
                    
             if((count($rqry_a) > 0) || (count($rqry_a1) > 0) || (count($rqry_a2) > 0) ||  (count($rqry_a3) > 0))
            {
                
                $artistqrycount = 1;
            }  
            
//                    echo "<pre>";
//                    print_r($rqry_a);
//                    
//                    echo "<pre>";
//                    print_r($rqry_a1);
//            
//                    echo "<pre>";
//                    print_r($rqry_a2);
//            
//                    echo "<pre>";
//                    print_r($rqry_a3);
            
            
                    //die;
            
                    //********  for group 
                
                    $rqry_g = DB::table('group_master')
                        ->select('id')
                        ->where('creater_id',$whoami)
                        ->first();
            
                    if($rqry_g)
                    {
                        $grpid = $rqry_g->id;
                        
                        
                        $rqry_g = DB::table('gig_master')
                                ->where('event_start_date_time','>=',$evntstrtdatetime)
                                ->where('event_end_date_time','<=',$evntenddatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$grpid)
                                ->where('type_flag','2')
                                ->get();
                    
                        $rqry_g1 = DB::table('gig_master')
                                ->where('event_start_date_time','<=',$evntstrtdatetime)
                                ->where('event_end_date_time','>=',$evntstrtdatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$grpid)
                                ->where('type_flag','2')
                                ->get();
                        
                        $rqry_g2 = DB::table('gig_master')
                                ->where('event_start_date_time','<=',$evntenddatetime)
                                ->where('event_end_date_time','>=',$evntenddatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$grpid)
                                ->where('type_flag','2')
                                ->get();
                        
                        $rqry_g3 = DB::table('gig_master')
                                ->where('event_start_date_time','<=',$evntstrtdatetime)
                                ->where('event_end_date_time','>=',$evntstrtdatetime)
                                ->where('event_end_date_time','<=',$evntenddatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$grpid)
                                ->where('type_flag','2')
                                ->get();
                        
                        if( (count($rqry_g) > 0) || (count($rqry_g1) > 0) || (count($rqry_g2) > 0) ||   (count($rqry_g3) > 0))
                        {
                            
                            $groupqrycount = 1;
                        }
                        
                        
//                    echo "<pre>";
//                    print_r($rqry_g);
//                    
//                    echo "<pre>";
//                    print_r($rqry_g1);
//            
//                    echo "<pre>";
//                    print_r($rqry_g2);
//            
//                    echo "<pre>";
//                    print_r($rqry_g3);
            
                        
                    }
            
            
                //******* For venue
                
                $rqry_v = DB::table('venue_master')
                        ->select('id')
                        ->where('creater_id',$whoami)
                        ->first();
            
                if($rqry_v)
                    {
                        $vid = $rqry_v->id;
                        
                        
                        $rqry_v = DB::table('gig_master')
                                ->where('event_start_date_time','>=',$evntstrtdatetime)
                                ->where('event_end_date_time','<=',$evntenddatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$vid)
                                ->where('type_flag','3')
                                ->get();
                    
                        $rqry_v1 = DB::table('gig_master')
                                ->where('event_start_date_time','<=',$evntstrtdatetime)
                                ->where('event_end_date_time','>=',$evntstrtdatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$vid)
                                ->where('type_flag','3')
                                ->get();
                        
                        $rqry_v2 = DB::table('gig_master')
                                ->where('event_start_date_time','<=',$evntenddatetime)
                                ->where('event_end_date_time','>=',$evntenddatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$vid)
                                ->where('type_flag','3')
                                ->get();
                        
                        $rqry_v3 = DB::table('gig_master')
                                ->where('event_start_date_time','<=',$evntstrtdatetime)
                                ->where('event_end_date_time','>=',$evntstrtdatetime)
                                ->where('event_end_date_time','<=',$evntenddatetime)
                                ->where('booking_status','=','1')
                                ->where('artist_id',$vid)
                                ->where('type_flag','3')
                                ->get();
                        
                        if( (count($rqry_v) > 0) || (count($rqry_v1) > 0) || (count($rqry_v2) > 0) ||   (count($rqry_v3) > 0))
                        {
                             //echo "Here 3";
                            $venueqrycount = 1;
                        }
                        
//                        echo "<pre>";
//                        print_r($rqry_v);
//
//                        echo "<pre>";
//                        print_r($rqry_v1);
//
//                        echo "<pre>";
//                        print_r($rqry_v2);
//
//                        echo "<pre>";
//                        print_r($rqry_v3);
                        
                        
                    }
            
                   
                    
            //echo "Here";
            
                    //************* getting user booking details ends here
            
            
            
        }
         if($type_flag == 2)
        {
             //echo "Here 2";
            //echo "This is group ";
            
            //********* get creater id starts here 
            $groupcreater = '';
            $rqry_usr = DB::table('group_master')
                ->select('creater_id')
                ->where('id',$whoami)
                ->first();
            
//            echo "Creater id is ".$rqry_usr->creater_id;
            if($rqry_usr)
            {
                $groupcreater = $rqry_usr->creater_id; // this is group creater or user own id 
            }
            
            
            //********* get creater id ends here
            
            
             //************* getting user booking details starts here
            
                //****** for group                 
                        $rqry_grp = DB::table('gig_master')
                                    ->where('event_start_date_time','>=',$evntstrtdatetime)
                                    ->where('event_end_date_time','<=',$evntenddatetime)
                                    ->where('booking_status','=','1')
                                    ->where('artist_id',$whoami)
                                    ->where('type_flag',$type_flag)
                                    ->get();
            
                        $rqry_grp1 = DB::table('gig_master')
                                    ->where('event_start_date_time','<=',$evntstrtdatetime)
                                    ->where('event_end_date_time','>=',$evntstrtdatetime)
                                    ->where('booking_status','=','1')
                                    ->where('artist_id',$whoami)
                                    ->where('type_flag',$type_flag)
                                    ->get();
                        
                        $rqry_gr2 = DB::table('gig_master')
                                    ->where('event_start_date_time','<=',$evntenddatetime)
                                    ->where('event_end_date_time','>=',$evntenddatetime)
                                    ->where('booking_status','=','1')
                                    ->where('artist_id',$whoami)
                                    ->where('type_flag',$type_flag)
                                    ->get();
                        
                        $rqry_grp3 = DB::table('gig_master')
                                    ->where('event_start_date_time','<=',$evntstrtdatetime)
                                    ->where('event_end_date_time','>=',$evntstrtdatetime)
                                    ->where('event_end_date_time','<=',$evntenddatetime)
                                    ->where('booking_status','=','1')
                                    ->where('artist_id',$whoami)
                                    ->where('type_flag',$type_flag)
                                    ->get();
            
            
//                        echo "<pre> g 1 ";
//                        print_r($rqry_grp);
//                        
//                        echo "<pre> g 2";
//                        print_r($rqry_grp1);
//                        
//                        echo "<pre> g 3";
//                        print_r($rqry_gr2);
//                       
//                        echo "<pre> g 4";
//                        print_r($rqry_grp3);
            
//            echo "<pre>";
//            print_r($rqry_grp);
//            echo "Counting of data from query group = ".count($rqry_grp);
            
            if( (count($rqry_grp) > 0) || (count($rqry_grp1) > 0) || (count($rqry_gr2) > 0) ||  (count($rqry_grp3) > 0))
            {
                $groupqrycount = 1;
            }
            
           
            
            
            
            if($groupcreater!='' && $groupcreater > 0)
            {
               
                //****** for user ************
                
                    
                $rqry_artist = DB::table('gig_master')
                            ->where('event_start_date_time','>=',$evntstrtdatetime)
                            ->where('event_end_date_time','<=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$groupcreater)
                            ->where('type_flag','1')
                            ->get();
                
                $rqry_artist1 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntstrtdatetime)
                            ->where('event_end_date_time','>=',$evntstrtdatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$groupcreater)
                            ->where('type_flag','1')
                            ->get();
                        
                $rqry_artist2 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntenddatetime)
                            ->where('event_end_date_time','>=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$groupcreater)
                            ->where('type_flag','1')
                            ->get();
                        
                $rqry_artist3 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntstrtdatetime)
                            ->where('event_end_date_time','>=',$evntstrtdatetime)
                            ->where('event_end_date_time','<=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$groupcreater)
                            ->where('type_flag','1')
                            ->get();
                
//                        echo "<pre> a 1 ";
//                        print_r($rqry_artist);
//                        
//                        echo "<pre> a 2";
//                        print_r($rqry_artist1);
//                        
//                        echo "<pre> a 3";
//                        print_r($rqry_artist2);
//                       
//                        echo "<pre> a 4";
//                        print_r($rqry_artist3);
            
//                echo "<pre>";
//                print_r($rqry_artist);
                
              //  echo "Counting of data from query artist = ".count($rqry_artist);
            
                if( (count($rqry_artist) > 0) || (count($rqry_artist1) > 0) || (count($rqry_artist2) > 0) ||   (count($rqry_artist3) > 0) )
                {
                    $artistqrycount = 1;
                }
                
                
                //****** for venue
                
                $qryselectvenue = DB::table('venue_master')
                    ->select('id')
                    ->where('creater_id',$groupcreater)
                    ->first();
                
                $venueid='';
                if($qryselectvenue)
                {
                    $venueid = $qryselectvenue->id;
                }
                
                    if($venueid!='' && $venueid > 0)
                    {


                         $rqry_venue = DB::table('gig_master')
                            ->where('event_start_date_time','>=',$evntstrtdatetime)
                            ->where('event_end_date_time','<=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$venueid)
                            ->where('type_flag','3')
                            ->get();
                        
                        $rqry_venue1 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntstrtdatetime)
                            ->where('event_end_date_time','>=',$evntstrtdatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$venueid)
                            ->where('type_flag','3')
                            ->get();
                        
                        $rqry_venue2 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntenddatetime)
                            ->where('event_end_date_time','>=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$venueid)
                            ->where('type_flag','3')
                            ->get();
                        
                        $rqry_venue3 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntstrtdatetime)
                            ->where('event_end_date_time','>=',$evntstrtdatetime)
                            ->where('event_end_date_time','<=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$venueid)
                            ->where('type_flag','3')
                            ->get();
                        
                        
//                        echo "<pre> v 1 ";
//                        print_r($rqry_venue);
//                        
//                        echo "<pre> v 2";
//                        print_r($rqry_venue1);
//                        
//                        echo "<pre> v 3";
//                        print_r($rqry_venue2);
//                       
//                        echo "<pre> v 4";
//                        print_r($rqry_venue3);
                        
                       /* echo "Counting of data from query venue = ".count($rqry_venue);
                        echo "Counting of data from query1 venue = ".count($rqry_venue1);
                        echo "Counting of data from query2 venue = ".count($rqry_venue2);
                         echo "Counting of data from query3 venue = ".count($rqry_venue3);*/

                        if( (count($rqry_venue) > 0) || (count($rqry_venue1) > 0) || (count($rqry_venue2) > 0) ||   (count($rqry_venue3) > 0) )
                        {
                            $venueqrycount = 1;
                        }

                        
                    }
                
                
                
            }
                
//            die;
            
            
            
            
            
                    //************* getting user booking details ends here
        }
         if($type_flag == 3)
        {
              //echo "Here 3";
            //echo "This is venue ";
          
            
            //********* get creater id starts here 
            $groupcreater = '';
            $rqry_usr = DB::table('venue_master')
                ->select('creater_id')
                ->where('id',$whoami)
                ->first();
            
//            echo "Creater id is ".$rqry_usr->creater_id;
            if($rqry_usr)
            {
                $venuecreater = $rqry_usr->creater_id; // this is venue creater or user own id 
            }
            
            
            //********* get creater id ends here
            
            
             //************* getting user booking details starts here
            
                //****** for venue                 
                        $rqry_v = DB::table('gig_master')
                                    ->where('event_start_date_time','>=',$evntstrtdatetime)
                                    ->where('event_end_date_time','<=',$evntenddatetime)
                                    ->where('booking_status','=','1')
                                    ->where('artist_id',$whoami)
                                    ->where('type_flag',$type_flag)
                                    ->get();
            
                        $rqry_v1 = DB::table('gig_master')
                                    ->where('event_start_date_time','<=',$evntstrtdatetime)
                                    ->where('event_end_date_time','>=',$evntstrtdatetime)
                                    ->where('booking_status','=','1')
                                    ->where('artist_id',$whoami)
                                    ->where('type_flag',$type_flag)
                                    ->get();
                        
                        $rqry_v2 = DB::table('gig_master')
                                    ->where('event_start_date_time','<=',$evntenddatetime)
                                    ->where('event_end_date_time','>=',$evntenddatetime)
                                    ->where('booking_status','=','1')
                                    ->where('artist_id',$whoami)
                                    ->where('type_flag',$type_flag)
                                    ->get();
                        
                        $rqry_v3 = DB::table('gig_master')
                                    ->where('event_start_date_time','<=',$evntstrtdatetime)
                                    ->where('event_end_date_time','>=',$evntstrtdatetime)
                                    ->where('event_end_date_time','<=',$evntenddatetime)
                                    ->where('booking_status','=','1')
                                    ->where('artist_id',$whoami)
                                    ->where('type_flag',$type_flag)
                                    ->get();
            
            
//                        echo "<pre> g 1 ";
//                        print_r($rqry_v);
//                        
//                        echo "<pre> g 2";
//                        print_r($rqry_v1);
//                        
//                        echo "<pre> g 3";
//                        print_r($rqry_v2);
//                       
//                        echo "<pre> g 4";
//                        print_r($rqry_v3);
            
//            echo "<pre>";
//            print_r($rqry_grp);
//            echo "Counting of data from query group = ".count($rqry_grp);
            
            if( (count($rqry_v) > 0) || (count($rqry_v1) > 0) || (count($rqry_v2) > 0) ||  (count($rqry_v3) > 0))
            {
                $venueqrycount = 1;
            }
            
           
            
            
            
            if($venuecreater!='' && $venuecreater > 0)
            {
               
                //****** for user ************
                
                    
                $rqry_artist = DB::table('gig_master')
                            ->where('event_start_date_time','>=',$evntstrtdatetime)
                            ->where('event_end_date_time','<=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$venuecreater)
                            ->where('type_flag','1')
                            ->get();
                
                $rqry_artist1 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntstrtdatetime)
                            ->where('event_end_date_time','>=',$evntstrtdatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$venuecreater)
                            ->where('type_flag','1')
                            ->get();
                        
                $rqry_artist2 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntenddatetime)
                            ->where('event_end_date_time','>=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$venuecreater)
                            ->where('type_flag','1')
                            ->get();
                        
                $rqry_artist3 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntstrtdatetime)
                            ->where('event_end_date_time','>=',$evntstrtdatetime)
                            ->where('event_end_date_time','<=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$venuecreater)
                            ->where('type_flag','1')
                            ->get();
                
//                        echo "<pre> a 1 ";
//                        print_r($rqry_artist);
//                        
//                        echo "<pre> a 2";
//                        print_r($rqry_artist1);
//                        
//                        echo "<pre> a 3";
//                        print_r($rqry_artist2);
//                       
//                        echo "<pre> a 4";
//                        print_r($rqry_artist3);
//            
//                        echo "<pre>";
//                        print_r($rqry_artist);
//                
//                        echo "Counting of data from query artist = ".count($rqry_artist);
            
                if( (count($rqry_artist) > 0) || (count($rqry_artist1) > 0) || (count($rqry_artist2) > 0) ||  (count($rqry_artist3) > 0) )
                {
                    $artistqrycount = 1;
                }
                
                
                //****** for venue
                
                $qryselectgrp = DB::table('group_master')
                    ->select('id')
                    ->where('creater_id',$venuecreater)
                    ->first();
                
                $venueid='';
                if($qryselectgrp)
                {
                    $grpid = $qryselectgrp->id;
                }
                
                    if($grpid!='' && $grpid > 0)
                    {


                         $rqry_grp = DB::table('gig_master')
                            ->where('event_start_date_time','>=',$evntstrtdatetime)
                            ->where('event_end_date_time','<=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$grpid)
                            ->where('type_flag','2')
                            ->get();
                        
                        $rqry_grp1 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntstrtdatetime)
                            ->where('event_end_date_time','>=',$evntstrtdatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$grpid)
                            ->where('type_flag','2')
                            ->get();
                        
                        $rqry_grp2 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntenddatetime)
                            ->where('event_end_date_time','>=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$grpid)
                            ->where('type_flag','2')
                            ->get();
                        
                        $rqry_grp3 = DB::table('gig_master')
                            ->where('event_start_date_time','<=',$evntstrtdatetime)
                            ->where('event_end_date_time','>=',$evntstrtdatetime)
                            ->where('event_end_date_time','<=',$evntenddatetime)
                            ->where('booking_status','=','1')
                            ->where('artist_id',$grpid)
                            ->where('type_flag','2')
                            ->get();
                        
                        
//                        echo "<pre> v 1 ";
//                        print_r($rqry_grp);
//                        
//                        echo "<pre> v 2";
//                        print_r($rqry_grp1);
//                        
//                        echo "<pre> v 3";
//                        print_r($rqry_grp2);
//                       
//                        echo "<pre> v 4";
//                        print_r($rqry_grp3);
                        
                       /* echo "Counting of data from query venue = ".count($rqry_venue);
                        echo "Counting of data from query1 venue = ".count($rqry_venue1);
                        echo "Counting of data from query2 venue = ".count($rqry_venue2);
                         echo "Counting of data from query3 venue = ".count($rqry_venue3);*/

                        if( (count($rqry_grp) > 0) || (count($rqry_grp1) > 0) || (count($rqry_grp2) > 0) ||   (count($rqry_grp3) > 0) )
                        {
                            $groupqrycount = 1;
                        }

                        
                    }
                
                
                
            }
                
//            die;
            
        }
        //die;
        
        
        if($venueqrycount > 0 || $artistqrycount > 0 || $groupqrycount > 0)
        {
            
//            echo " venue query count ".$venueqrycount;
//            echo "<br>";
//            echo " group query count ".$groupqrycount;
//            echo "<br>";
//            echo " artist query count ".$artistqrycount;
//            echo "<br>";
//            
            return 1;
        }else
        {
            return 0;
        }
        
        
    }


    function datecheckingfunc($currentdateval,$datevalidornot,$gigmaster_timezone)
    {

      // echo "Current date == ".$currentdateval;
      // echo "<br>";

      // echo "request exp date here == ".$datevalidornot;

      // echo "<br>";


//*******************

      // $chktest_datevalidornot= convertdatetothistz($dttm=date('Y-m-d H:i:s'),$ftmzn='UTC',$ttmzn=$gigmaster_timezone,$cnvrtdtdrmt='Y-m-d H:i:s');

      // echo "<pre>";
      // print_r($chktest_datevalidornot);die;

      // echo $gigmaster_timezone;
      // echo "<============>";
      // echo $chktest_currentdateval['converteddatetime'];
      //  echo "<============>";
      // echo $chktest_datevalidornot['converteddatetime'];
      //  echo "<============>";
      // die;

// response => Array ( [converteddatetime] => 2017-01-17 02:00:00 [reqdatetime] => 2017-01-16 15:00:00 [fromtimezone] => UTC [totimezone] => Australia/Sydney )

//*******************


      // $dteStart = new DateTime($currentdateval); 
      // $dteEnd   = new DateTime($datevalidornot);

     

      $chktest_currentdateval= convertdatetothistz($dttm=$currentdateval,$ftmzn='UTC',$ttmzn=$gigmaster_timezone,$cnvrtdtdrmt='Y-m-d H:i:s');

      $chktest_datevalidornot= convertdatetothistz($dttm=$datevalidornot,$ftmzn='UTC',$ttmzn=$gigmaster_timezone,$cnvrtdtdrmt='Y-m-d H:i:s');

      // echo $gigmaster_timezone;
      // echo "<============>";
      // echo $chktest_currentdateval['converteddatetime'];
      //  echo "<============>";
      // echo $chktest_datevalidornot['converteddatetime'];
      //  echo "<============>";
      // die;

// response => Array ( [converteddatetime] => 2017-01-17 02:00:00 [reqdatetime] => 2017-01-16 15:00:00 [fromtimezone] => UTC [totimezone] => Australia/Sydney )

      $dteStart = new DateTime($chktest_currentdateval['converteddatetime']); 
      $dteEnd   = new DateTime($chktest_datevalidornot['converteddatetime']);

        $dteDiff  = $dteEnd->diff($dteStart); 
        $r = $dteDiff->format("%H:%I:%S"); 



      if($dteStart > $dteEnd)
      {
        // echo "Current date time is greater than calculated date time";
        // echo "<br>";
        // echo " currentdateval ".$currentdateval;
        // echo "<br>";
        // echo " calculated datetime ".$datevalidornot;
        // echo "<br>";
        // echo "Current date is ".date('Y-m-d h:i:s');
        // echo "<br>";

        return 1;



      }else 
      {
        // echo "calculated date time is greater than Current date time";
        // echo "<br>";
        // echo " currentdateval ".$currentdateval;
        // echo "<br>";
        // echo " calculated datetime ".$datevalidornot;
        // echo "<br>";
        // echo "Current date is ".date('Y-m-d h:i:s');
        // echo "<br>";

        //*******  remaining time calculation starts here


        // $dteDiff  = $dteEnd->diff($dteStart); 
        // $r = $dteDiff->format("%H:%I:%S"); 
        //******* remaining time calculation ends here
        



        return 2;
      }

     // die;  
    }


    function datecheckingfuncremaining($currentdateval,$datevalidornot,$gigmaster_timezone)
    {
      // echo "currentdateval ".$currentdateval;
      // echo "==============";
      // echo "datevalidornot ".$datevalidornot;
      // echo "===";



       $chktest_currentdateval= convertdatetothistz($dttm=$currentdateval,$ftmzn='UTC',$ttmzn=$gigmaster_timezone,$cnvrtdtdrmt='Y-m-d H:i:s');

      $chktest_datevalidornot= convertdatetothistz($dttm=$datevalidornot,$ftmzn='UTC',$ttmzn=$gigmaster_timezone,$cnvrtdtdrmt='Y-m-d H:i:s');

        // $dteStart = new DateTime($currentdateval); 
        // $dteEnd   = new DateTime($datevalidornot);

        $dteStart = new DateTime($chktest_currentdateval['converteddatetime']); 
        $dteEnd   = new DateTime($chktest_datevalidornot['converteddatetime']);


        $dteDiff  = $dteEnd->diff($dteStart); 
        $r = $dteDiff->format("%d:%H:%I"); 
        return $r;

        // echo "date diff starts here  === >";die;
    }



    //***************************  check wallet balance condition starts here ***********

    function checkwaletbalancndition($getingbookerid,$getingartistid,$getingtypeflag,$total_payment)
    {
      $selecttable = "";
      $bookerwalletval=0;
    


      $bookerwalletbalanceqry = DB::table('user_master')
                               ->select('wallet_amount')
                               ->where('id',$getingbookerid)
                               ->first();
      $bookerwalletval = $bookerwalletbalanceqry->wallet_amount;
    
      if($getingtypeflag == 1)
      {
        $selecttable = "user_master";
      }else if($getingtypeflag == 2)
      {
         $selecttable = "group_master";

      }else if($getingtypeflag == 3)
      {
         $selecttable = "venue_master";

      }

    $agvwalletbalanceqry = DB::table($selecttable)
                   ->select('rate_amount')
                   ->where('id',$getingartistid)
                   ->first();

               if($bookerwalletval < $total_payment)
               {
                return 0;
               }else
               {
                return 1;
               }

    }

    //***************************  check wallet balance condition ends here  *************



    //********************  Email will be send after negotiation stage starts here *********
    function sendnegotiationemail($gigunique_id,$artist_id,$type_flag,$booker_id,$typeval)
    {

      $agvnickname = '';
      $agvemail = '';

      
      if($type_flag == '1')
      {
      $userdetails = DB::table('user_master')
            ->select('user_master.email','user_master.nickname')
            ->where('user_master.id','=',$artist_id)
            ->first();

            if($userdetails)
          {
            $agvnickname = $userdetails->nickname;
            $agvemail = $userdetails->email;
          }
            // echo "<pre>".$type_flag;
            // print_r($userdetails);
      } 
      else if($type_flag == '2')
      {
      $groupdetails = DB::table('user_master')
            ->join('group_master', 'group_master.creater_id', '=', 'user_master.id')
            ->select('user_master.email','group_master.nickname')
            ->where('group_master.id','=',$artist_id)
            ->first();

            if($groupdetails)
            {
              $agvnickname = $groupdetails->nickname;
              $agvemail = $groupdetails->email; 
            }
            
            // echo "<pre>".$type_flag;
            // print_r($groupdetails);
      } 
 else if($type_flag == '3')
      {
         $venuedetails = DB::table('user_master')
            ->join('venue_master', 'venue_master.creater_id', '=', 'user_master.id')
            ->select('user_master.email','venue_master.nickname')
            ->where('venue_master.id','=',$artist_id)
            ->first();

            if($venuedetails)
            {

              $agvnickname = $venuedetails->nickname;
              $agvemail = $venuedetails->email;
            }

            //  echo "<pre>".$type_flag;
            // print_r($venuedetails);die;
      }


      $bookerdatanickname='';
      $bookerdataemail='';

          $fetchingdataqrybkr = DB::table('user_master')
                               ->select('nickname','email')
                              ->where('id',$booker_id)
                              ->first();


          if($fetchingdataqrybkr)
          {
              $bookerdatanickname = $fetchingdataqrybkr->nickname;
              $bookerdataemail = $fetchingdataqrybkr->email;
          }

          








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
                  
                  if($typeval == 'BKR')
                  {
                    
                    $replacefrom =array("{RESPOND_TO}","{RESPOND_BY}",'{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{EVENTID}");
                $replaceto =array(ucfirst($agvnickname),$bookerdatanickname,$sitename,$copyright_year,$bsurl,$logoIMG,$gigunique_id);
                    mailsnd($Temid=56,$replacefrom,$replaceto,$agvemail);
                  }else
                  {
                    
                    $replacefrom =array("{RESPOND_TO}","{RESPOND_BY}",'{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{EVENTID}");
                $replaceto =array(ucfirst($bookerdatanickname),$agvnickname,$sitename,$copyright_year,$bsurl,$logoIMG,$gigunique_id);
                    mailsnd($Temid=56,$replacefrom,$replaceto,$bookerdataemail);
                  }

                
                  
                  //*********Helper Function Ends here 



    }
    //******************** email will be send after negotiation stage ends here ***********

    //********************  email after accept of bid starts here ****************


    function sendemailaccept($gigunique_id,$whoamitext,$whoami,$getingtypeflag,$booker_id,$artist_id,$sessionid)
    {
      // $gigunique_id,$whoamitext,$whoami,$getingtypeflag,$booker_id

      // echo "Gig unique id == >".$gigunique_id;
      // echo "whoamitext == >".$whoamitext;
      // echo " whoami == >".$whoami;
      // echo "getingtypeflag == >".$getingtypeflag;
      // echo "booker_id == >".$booker_id;






      $agvnickname = '';
      $agvemail = '';

      
      if($getingtypeflag == '1')
      {
      $userdetails = DB::table('user_master')
            ->select('user_master.email','user_master.nickname')
            ->where('user_master.id','=',$artist_id)
            ->first();

            if($userdetails)
          {
            $agvnickname = $userdetails->nickname;
            $agvemail = $userdetails->email;
          }
            // echo "<pre>";
            // print_r($userdetails);
      } 
      else if($getingtypeflag == '2')
      {
      $groupdetails = DB::table('user_master')
            ->join('group_master', 'group_master.creater_id', '=', 'user_master.id')
            ->select('user_master.email','group_master.nickname')
            ->where('group_master.id','=',$artist_id)
            ->first();

            if($groupdetails)
            {
              $agvnickname = $groupdetails->nickname;
              $agvemail = $groupdetails->email; 
            }
            
            // echo "<pre>";
            // print_r($groupdetails);
      } 
 else if($getingtypeflag == '3')
      {
         $venuedetails = DB::table('user_master')
            ->join('venue_master', 'venue_master.creater_id', '=', 'user_master.id')
            ->select('user_master.email','venue_master.nickname')
            ->where('venue_master.id','=',$artist_id)
            ->first();

            if($venuedetails)
            {

              $agvnickname = $venuedetails->nickname;
              $agvemail = $venuedetails->email;
            }

            // echo "<pre>";
            // print_r($venuedetails);die;
      }


      $bookerdatanickname='';
      $bookerdataemail='';

          $fetchingdataqrybkr = DB::table('user_master')
                               ->select('nickname','email')
                              ->where('id',$booker_id)
                              ->first();


          if($fetchingdataqrybkr)
          {
              $bookerdatanickname = $fetchingdataqrybkr->nickname;
              $bookerdataemail = $fetchingdataqrybkr->email;
          }







      // $sessionid = $request->session()->get('front_id_sess');

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

      if($sessionid == $booker_id)
      {
        //*******  accept by booker 

        $replacefrom =array("{User}","{ACCEPT_BY}",'{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{EVENTID}");
        
        $replaceto =array(ucfirst($agvnickname),$bookerdatanickname,$sitename,$copyright_year,$bsurl,$logoIMG,$gigunique_id);


        mailsnd($Temid=21,$replacefrom,$replaceto,$agvemail);



      }else
      {
        //******* accept by agv

       $replacefrom =array("{User}","{ACCEPT_BY}",'{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{EVENTID}");
                $replaceto =array(ucfirst($bookerdatanickname),$agvnickname,$sitename,$copyright_year,$bsurl,$logoIMG,$gigunique_id);
                mailsnd($Temid=21,$replacefrom,$replaceto,$bookerdataemail);



      }




      




    }

    //********************  email after accept of bid ends here ****************




    //**********************  separete escrow function starts here  ***********************


     function escrowonacceptingbkrequest($bkrid=0,$bkridtype=1,$bkgigid=0)
    {
            $escrowResp=array();
            $flagresp=0; $flagresp_msg=''; $total_amount=0; $wallet_update_amt=0;

            if(!empty($bkrid) && !empty($bkridtype) && !empty($bkgigid))
            {

                //***** fetch gig related from gig_master table starts *********

                $get_gig_master = DB::table('gig_master')->where('id',$bkgigid);  
                $gig_master_details = $get_gig_master->first();

                $booker_id=0;   $gig_master_details_id=0; $payment_flag='';
                $type_flag='';$gigpostrequestflag='';$payment_for = ''; $payment_description = '';

                //echo "==gig_master_details==><pre>"; print_r($gig_master_details); echo "</pre>";

                if(!empty($gig_master_details))
                {
                    $gig_master_details_id=$gig_master_details->id;            
                    $booker_id = $gig_master_details->booker_id;
                    $booking_status = $gig_master_details->booking_status; //1,2,8,9,7               
                    $type_flag = $gig_master_details->type_flag;
                    $artist_ID_val = $gig_master_details->artist_id; 
                    $gigpostrequestflag= $gig_master_details->gigpostrequestflag; // 1=>gigpost 2=>booking request
                    $total_amount=$gig_master_details->total_amount;
                    $payment_flag=$gig_master_details->payment_flag;



                }
                else
                {
                    $flagresp_msg="Invalid event information";
                }


                //***** fetch gig related from gig_master table ends *********

                 //***** fetch booker  related data from user_master table starts *********

                $user_master_data = DB::table('user_master');
                $user_master_data=$user_master_data->where('id',$booker_id); 
                $user_master_data=$user_master_data->where('status',1);  
                $user_master_data = $user_master_data->first();

                $first_name=''; $last_name=''; $email=''; $phone=''; $nickname='';
                $wallet_amount=0;

                if(!empty($user_master_data))
                {

                    $first_name=$user_master_data->first_name;
                    $last_name=$user_master_data->last_name;
                    $email=$user_master_data->email;
                    $phone=$user_master_data->phone;
                    $nickname=$user_master_data->nickname;
                    $wallet_amount=$user_master_data->wallet_amount;            


                }
                else
                {
                    $flagresp_msg="User data not found";
                }

               // echo $total_amount."---".$wallet_amount;
                if($payment_flag==0)
                {
                    if($total_amount>0 && ($total_amount < $wallet_amount) && !empty($booker_id))
                    {
                        $wallet_update_amt=$wallet_amount-$total_amount;
                        
                        //***** add to to user_order table starts ******


                        if($type_flag == '1')
                        {

                            if($gigpostrequestflag =='2')
                            {
                                $payment_for = 'EBA';
                                $payment_description = 'escrowed for artist for booking request';
                            }
                            elseif($gigpostrequestflag =='1')
                            {
                                $payment_for = 'EGA';
                                $payment_description = 'escrowed for artist for gig request';
                            }

                        }
                        elseif($type_flag == '2')
                        {

                            if($gigpostrequestflag =='2')
                            {
                                $payment_for = 'EBG';
                                $payment_description = 'escrowed for group for booking request';
                            }
                            elseif($gigpostrequestflag =='1')
                            {
                                $payment_for = 'EGG';
                                $payment_description = 'escrowed for group for gig request';
                            }
                        }
                        elseif($type_flag == '3')
                        {
                            $payment_for = 'EBV';
                            $payment_description = 'escrowed for venue for booking request';
                        }





                       $isInserted=0;
                       $logggedin_user_ip = get_client_ip_server();

                       $dataorderInsert=array();
                       $dataorderInsert['payment_for']=$payment_for; //required
                       $dataorderInsert['card_token']='';
                       $dataorderInsert['charge_token']='';
                       $dataorderInsert['payment_description']=$payment_description;
                       $dataorderInsert['payment_scheme']='';
                       $dataorderInsert['email']=$email;
                       $dataorderInsert['total_price']= $total_amount;//required
                       $dataorderInsert['user_ip_address']= $logggedin_user_ip;//required
                       $dataorderInsert['debitorcredit']="D"; // C=> Credit , D=> Debit //required
                       $dataorderInsert['gigmaster_id'] = $gig_master_details_id;//required
                       $dataorderInsert['currency']='';
                       $dataorderInsert['payment_status']="SUCCESS";//required
                       $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                       $dataorderInsert['user_id'] = $booker_id;
                       $dataorderInsert['create_date'] = date('Y-m-d H:i:s');
                       $dataorderInsert['modified_date']= date('Y-m-d H:i:s');
                       //*** insert  query
                       $isInserted = DB::table('user_order')->insert($dataorderInsert);

                        $isInserted = DB::getPdo()->lastInsertId();


                        //***** add to to user_order table ends ********


                        if($isInserted>0)
                        {
                            //***** update  gig_master table starts ******

                            $updateAr=array();
                            $updateAr['payment_flag']=2;//2=>full escrowed
                            $chkupd= DB::table('gig_master')->where('id',$bkgigid) ->update($updateAr);  


                            //***** update  gig_master  table ends ******

                             //***** update  user_master wallet balance table starts ******

                            $updateAr=array();
                            $updateAr['modified_date']=date('Y-m-d H:i:s');
                            $updateAr['wallet_amount']=$wallet_update_amt;                    
                            $chkupd= DB::table('user_master')->where('id',$booker_id) ->update($updateAr);

                            //***** update  user_master wallet balance table ends ******

                            $flagresp=1;
                        }



                }
                else
                {
                     $flagresp_msg="Insufficient wallet amount for escrow";
                }
            
            }
            else
            {
                $flagresp_msg="Escrow related improper data";
            }
            
            //***** fetch booker  related data  from user_master table ends *********
            
            
            
        }
        
        $escrowed_amt=($flagresp==1)?$total_amount:0;
        
        $escrowResp['flagresp']=$flagresp;
        $escrowResp['flagresp_msg']=$flagresp_msg;
        $escrowResp['wallet_update_amt']=$wallet_update_amt;
        $escrowResp['escrowed_amt']=$escrowed_amt;
        
        
        return $escrowResp;
        
    }



    //**********************  separete escrow function ends here  *************************
    
    
    function sendescrowmailtobkr(Request $request)
    {
        $gigmaster_id = $request->input('gigmaster_id','');

        $settingsdata = DB::table('settings')
                        ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                        ->where('id', 1)
                        ->first();
        
        //**** fetch event information
        $selectgigfldname="gm.type_flag,gm.type_flag,gm.type_flag,gm.artist_id,gm.booker_id,gm.giguniqueid";
        $gig_master_details = DB::table('gig_master as gm');
        $gig_master_details=$gig_master_details->select(DB::raw($selectgigfldname));
        $gig_master_details=$gig_master_details->where('gm.id',$gigmaster_id);
        $gig_master_details=$gig_master_details->first();
        
        
        $artist_email = ''; $artist_id = ''; $artist_name = '';      
        $booker_email = ''; $booker_id = ''; $booker_name= ''; $event_giguniqueid='';
      
        if(!empty($gig_master_details))
        {
            $booker_id = $gig_master_details->booker_id;
            $event_giguniqueid=$gig_master_details->giguniqueid;
        }
       
     
        $booker_nickname=''; $booker_email='';
        if(!empty($booker_id))
        {
          //***** fetch booker information    
          $booker_details = DB::table('user_master as um');
          $booker_details=$booker_details->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"));
          $booker_details=$booker_details->where('id',$booker_id);
          $booker_details=$booker_details->first();
        
          if(!empty($booker_details))
          {
             $booker_nickname= stripslashes($booker_details->nickname);
             $booker_email=stripslashes($booker_details->email);
          }
        }
        
        
        
          $sitename=$settingsdata->site_name;
          $emailfrom=$settingsdata->email_from;
          $copyright_year=$settingsdata->copyright_year;
          $Imgologo=$settingsdata->email_template_logo_image;

          $bsurl = url('/');                 
          $logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
         
        
        
        //*********send to booker**********//
        $replacefrom =array('{BOOKER}','{ENVID}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
        $replaceto =array(ucfirst($booker_nickname),$event_giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG);
        mailsnd($Temid=25,$replacefrom,$replaceto,$booker_email);
        //************** send mail to notify escrowed details start*******************//
        
        
        
        
    }
    
}