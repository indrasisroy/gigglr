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
class FrontendGroupController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    
     public function index(Request $request)
    {

            
                        $uu = $request->segment(2);
                        $flag = 1;
                        
                        //$query = DB::table('group_master')->select('seo_name')->get();
                        $user_id = 0;
                        $user_single = DB::table('group_master')->where('seo_name',$uu)->first();
                        
                        if($user_single)
                        {
                                    $user_id = $user_single->id;
                        }
                        else
                        {
                                     $user_id = 0;
                        }

            
                        if(empty($user_single) || $user_id ==0)
                        {
                                   
                                    $flag = 0;
                                    return redirect('/');
                        }else{
                        $flag = 1 ;
                            $data=array(); 
                            $data['data1']="hello";
                       
                           //*************** fetch data of banner starts=======================*************
                            $banner_image='';$display_flag=0;            
                            //*** fetch data of banner ends                
                            
                            //**** fetch basic info of user  starts
                            
                            $fetchtype='single'; $tablename="group_master";
                            $fieldnames=" * ";
                            $wherear=array();
                            $wherear['id']=$user_id;
                            $orderbyfield="id"; $orderbytype="asc";
                            $limitstart=0;$limitend=0;                
                            
                            $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);

                    $sqlGroupSkill="SELECT * FROM `skill_master` WHERE `id` in (SELECT `skill_id` FROM `group_skill_rel`where `group_id`='".$fetchuserdata->id."' group by `skill_id`)";
                    $GroupSkill = DB::select( DB::raw($sqlGroupSkill));
                    $fetchskillmasterAr=array();
                if(!empty($GroupSkill))
                {
                   for($i=0;$i<count($GroupSkill);$i++){
                    $fetchskillmasterAr[$GroupSkill[$i]->id]=$GroupSkill[$i]->name;
                   }
                }

         
                
                $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.group_id) as group_id ";
               
                $skill_user_db=DB::table('group_skill_rel as usr');

                $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
                
                $skill_user_db=$skill_user_db->where('usr.group_id', $user_id);
                $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
                
                $skill_user_db=$skill_user_db->get();
                
                
                //*******************************FETCH COUNTRY DATA STARTS HERE 28-05-2016
                $country_db = DB::table('location_country')->where('published','1')->get();
                        $countryidAr=array();
                        $countryidAr['']="Select a country";
                        if(!empty($country_db))
                        {
                                foreach($country_db as $country_obj)
                                {
                                        $countryidAr[$country_obj->id]=stripslashes($country_obj->country_name);
                                }
                                
                        }
               
                //****************FETCH ALL CATEGORY ENDS HERE 30-05-2016
                
                
                //****************
                //***************FETCH USER IMAGE STARTS HERE
                //$group_img = DB::table('group_master_img')->where('default_status','1')->where('group_id',$user_id)->get();
                
                 $group_img = DB::table('group_master_img')->where('group_id',$user_id)->orderBy('id','ASC')->get(); 
                 
               //***************FETCH USER IMAGE ENDS HERE
               
               //********Fetch user review starts here

               //********Fetch user review ends here
              //*************presskit data starts here
              $presskit = DB::table('group_presskit')->where('group_id',$user_id)->first();
              //*************presskit data ends here
              
              ////***************sum of ratings starts here
              //$total = DB::table('users')->where()->sum('puntuality');
              ////**************sum of ratings ends here
              
                      //***** for location country starts ************
                    $getcountry = DB::table('location_country as country');
                    $getcountry->where('published','1');
                    $data['country'] = $getcountry->get();
                    //***** for location country ends ************
                    
                    //***** for location state starts ************
                    
                    //echo  json_encode($fetchuserdata->state);
                    
                    $getstate = DB::table('location_state as state')->where('country_id',$fetchuserdata->country);  
                    $data['state'] = $getstate->get();
                    //***** for location country ends ************
                
                
                $data['banner_image']=$banner_image;
                $data['display_flag']=$display_flag;
                $data['fetchuserdata']=$fetchuserdata;
                $data['fetchskillmasterAr']=$fetchskillmasterAr;
                $data['skill_user_db']=$skill_user_db;
                $data['country_result']=$countryidAr;
                $data['usr_img']=$group_img;
                $data['presskit']=$presskit;
                

                $gig_review_data = DB::table('gig_review')
                ->where('artistgroupvenue_flag_type',2)
                ->where('artistgroupvenue_id',$user_id)
                ->get();

                $punctuality = 0;
                $performance = 0;
                $presentation = 0;
                
                $gig_review_count = count($gig_review_data);
                if($gig_review_count>0){
                    foreach($gig_review_data as $gig_review){
                        $punctuality = $punctuality + $gig_review->punctuality;
                        $performance = $performance + $gig_review->performance;
                        $presentation = $presentation + $gig_review->presentation;
                    }
                    $data['punctuality']=$punctuality/$gig_review_count;
                    $data['performance']=$performance/$gig_review_count;
                    $data['presentation']=$presentation/$gig_review_count; 
                }else{
                    $data['punctuality']=$punctuality;
                    $data['performance']=$performance;
                    $data['presentation']=$presentation; 
                }

               //$userstesti = DB::table('gig_review as grv')
               //     ->join('user_master as um', 'grv.booker_id', '=', 'um.id')
               //    //  ->join('bookers_review as brv', 'erv.id', '=', 'brv.event_review_id')
               //                         ->leftJoin('user_master_img as umi', function ($join)
               //                         {
               //                         $join->on('grv.booker_id', '=', 'umi.user_id')
               //                         ->where('umi.default_status','=','1');
               //                         })
               //                        
               //     ->select('grv.*', 'um.first_name','um.seo_name','um.username','um.nickname','um.city','umi.user_id','umi.image_name','umi.default_status','grv.punctuality','grv.performance','grv.presentation')
               //     ->where('grv.artistgroupvenue_id',$user_id)
               //     ->where('grv.artistgroupvenue_flag_type',2)
               //     ->get();
               
             $groupReviewquery = "SELECT rrvd1 . * ,gsr.category_name,gsr.genre_name ,um.nickname,um.first_name,um.username,um.seo_name, um.city,  IF( ISNULL( uimg.image_name )  , 'noimage', uimg.image_name ) AS image_name
              FROM (
              SELECT gigrev.`id` AS review_date_id,`gigmaster_id`,gmstr.`booker_id`, `punctuality`, `performance` ,`presentation`, `agv_review_data`, `agv_review_date`
     
              FROM `gig_review` as gigrev,`gig_master` AS gmstr
              WHERE
              (gmstr.`artist_id` =  '".$user_id."' AND gmstr.`type_flag` =  '2') AND gmstr.`id` = gigrev.`gigmaster_id`   
               )AS rrvd1
              INNER JOIN `user_master` AS um ON rrvd1.booker_id = um.id
              LEFT JOIN  `user_master_img` AS uimg ON rrvd1.booker_id = uimg.user_id
              AND uimg.default_status =1
               LEFT JOIN  (SELECT psk.gigmaster_id, psk.category as category_id, psk.name as category_name,
                        ssk.genre as genre_id, ssk.genre_name as genre_name, ssk.skillsubskillrel
                        FROM (                        
                                                
                        SELECT GROUP_CONCAT( DISTINCT gsk.gigmaster_id ) AS gigmaster_id, GROUP_CONCAT( DISTINCT gsk.category ) AS category, GROUP_CONCAT( DISTINCT skm.name ) AS name
                        FROM gig_skill_rel AS gsk
                        INNER JOIN skill_master AS skm ON gsk.category = skm.id
                        GROUP BY gsk.gigmaster_id
                        
                        ) AS psk
                        
                        LEFT JOIN 
                        (
                        SELECT GROUP_CONCAT( DISTINCT gsk.gigmaster_id ) AS gigmaster_id, GROUP_CONCAT( gsk.genre ) AS genre, GROUP_CONCAT( skm.name ) AS genre_name,
                        GROUP_CONCAT( concat(gsk.genre,'---',gsk.category) ) as skillsubskillrel
                        FROM gig_skill_rel AS gsk
                        INNER JOIN skill_master AS skm ON gsk.genre = skm.id
                        GROUP BY gsk.gigmaster_id
                        
                        ) AS ssk
                        
                         on psk.gigmaster_id=ssk.gigmaster_id ) AS gsr
                        
                         on rrvd1.gigmaster_id = gsr.gigmaster_id";
              
              
               $userstestiresult=DB::select($groupReviewquery);
               if(!empty($userstestiresult))
               {
                    $userstesti = $userstestiresult;
                    $data['user_testi']=$userstesti;
               }
             //usrIMG
    
                  // added for category and genre end //
                  
                    // added for favoriterecord start //
                    $sess_id = $request->session()->get('front_id_sess');
                    

                    $favorite_record = DB::table('favoriterecord')
                    ->where('user_id',$sess_id)
                    ->where('favorite_id',$fetchuserdata->id)
                    ->first();
                    $data['favorite'] = '';
                    
                    if($favorite_record){
                        $data['favorite'] = $favorite_record->status;             
                    }
                    // added for favoriterecord end //
                    
                    //****************currency code start ******************//
                    $sess_id = $request->session()->get('front_id_sess');
                    if($sess_id!=''){
                    $login_currency = DB::table('user_master')->select('currency','wallet_amount')
                    ->where('id',$sess_id)
                    ->first();
                    $data['login_currency'] = $login_currency->currency;
                    $data['wallet_amount'] = $login_currency->wallet_amount; //******fetching wallet amount of current logged in user
                    }else{
                    $data['login_currency'] = ''; 
                    $data['wallet_amount'] = '0.00';                   
                    }
                    
                    
                    $group_currency = DB::select( DB::raw("SELECT urm.currency,urm.wallet_amount FROM `group_master` as grp, `user_master`as urm WHERE grp.`id`='".$user_id."' and grp.`creater_id`= urm.`id`"));
                    
                    if(!empty($group_currency)){
                       $data['group_currency']=$group_currency[0]->currency;  
                       $data['group_wallet_amount']=$group_currency[0]->wallet_amount;                    
                    }else
                    {
                      $data['group_currency']="";  
                      $data['group_wallet_amount']='0.00';       
                    }
                    //****************currency code end ******************//
                    
                    $data['tech_spec_artist']='';
                    
                    $tech_spec_artist_data = DB::table('settings')->select('tech_spec_group')
                    ->where('id',1)
                    ->first();
                    if(!empty($tech_spec_artist_data)){
                             $data['tech_spec_group'] = $tech_spec_artist_data->tech_spec_group;
                    }
                    //echo  json_encode($data);die;
                    
                    return view('front.group_new.groupprofile', $data);
                    }

               
    }
    public function getstate(Request $request)
    {
          $country =  $request->input('countryid');
          $stateres = DB::table('location_state')->where('country_id',$country)->get();

          
           $statetypeidAr=array();
           
            if(!empty($stateres))
            {
                    foreach($stateres as $stateres)
                    {
                            $statetypeidAr[]=array('id'=>$stateres->id,'name'=>stripslashes($stateres->state_name));
                    }
                    
            }
        
          $respAr=$statetypeidAr;
          
          // $respAr['flag']=$flagdata;
          // $respAr['iddata']=$skillid;
          //$respAr['skillid']=$users;
          
          
          echo  json_encode($respAr);
          
    }
    
    public function getgenere(Request $request)
    {
            $categoryId = $request->input('categoryID');
            $groupId = $request->input('groupId');
            //echo $categoryId."-----".$groupId;die;
            if($categoryId > 0)
            {
                        //$getGenere = DB::table('skill_master')
                        //->where('parent_id',$categoryId)
                        //->where('status','1')
                        //->get();
                        $sqlGroupSubSkill="SELECT * FROM `skill_master` where `id` in(SELECT `skill_sub_id` FROM `group_skill_rel` WHERE `group_id`='".$groupId."')";
                        $GroupSubSkill = DB::select( DB::raw($sqlGroupSubSkill));
            }
            $generetypeidAr=array();
           
            if(!empty($GroupSubSkill))
            {
                    //foreach($getGenere as $getGenereobj)
                    //{
                    //        $generetypeidAr[]=array('id'=>$getGenereobj->id,'name'=>stripslashes($getGenereobj->name));
                    //}
                    //$generetypeidAr[]=array('flag'=>'1');
                     
                   for($i=0;$i<count($GroupSubSkill);$i++){
                    $generetypeidAr[]=array('id'=>$GroupSubSkill[$i]->id,'name'=>stripslashes($GroupSubSkill[$i]->name));
                   }
            }
        
          $respAr=$generetypeidAr;
          //echo "<pre>";
          //print_r($respAr);
          //echo "</pre>";die;
          echo  json_encode($respAr);
            
    }
    
    //*************download ptresskit starts here
    
    public function downloadpresskit($file_name)
    {
                   // echo $file_name;die;
                    $filennmdownload = base64_decode($file_name);
                   // echo $filennm;die;
            //********its working for single file
            $download_path = ( public_path() . '/upload/group-press-kit/source-file/' . $filennmdownload );
            return( Response::download( $download_path ) );
          
    }
   //*************download ptresskit starts here
   
   //**********booking complete starts here
   public function completebooking(Request $request)
   {
     $getresponseAr=array();
                    
     $address1val = addslashes(trim($request->input('address1val')));
     $address2val = addslashes(trim($request->input('address2val')));
     $countrydata = $request->input('countrydata');
     $statelistdata = $request->input('statelistdata');
     $towndata = addslashes(trim($request->input('towndata')));
     $zipdata = addslashes(trim($request->input('zipdata')));
     $bookingcat_subdata = $request->input('bookingcat_subdata');
     $bookinggenre_subdata = $request->input('bookinggenre_subdata');
     $security_paymentdata = $request->input('security_paymentdata');
     $total_paymentdata = $request->input('total_paymentdata');
     $cancellation_paymentdata = $request->input('cancellation_paymentdata');
     $booking_datedata = $request->input('booking_datedata');
     $start_timedata = $request->input('start_timedata');
     $end_timedata = $request->input('end_timedata');
     $requestexpireddatedata = $request->input('requestexpireddatedata');
     $requestexpiredtimedata = $request->input('requestexpiredtimedata');
     
     
     
     //********* validation starts here
     //$chkvalid=$this->checkbookingform($request,$id);
     //********* validation ends here
     
     
     
     //*********** get country name and state name starts here
     $countrynm = 'country_name';
     $statenm = 'state_name';
     $tblnm = 'location_country';
     $sttbl = 'location_state';
     $countryname = $this->getcommondetails($countrydata,$countrynm,$tblnm);
     $statename = $this->getcommondetails($statelistdata,$statenm,$sttbl);
     //*********** get country name and state name ends here
     //*********** Get latlong starts here
      $fullBookingAddress = $address1val.' '.$address2val.' '.$towndata.' '.$statename->state_name.' '.$countryname->country_name;
      
      $fullBookingAddress = urlencode($fullBookingAddress);
      
      $latlog = getLatLong($fullBookingAddress);
      
                    $latitude = $latlog['latlong'][0]['latitude'];
                    $longitude = $latlog['latlong'][0]['longitude'];
                    $TimeZoneCheck = getTimezone($latitude,$longitude);
                    $timezoneId = $TimeZoneCheck['timeZoneId'];
                    $timezoneName = $TimeZoneCheck['timeZoneName'];
                    
     //*********** Get latlong ends here
    
    //*********current date time
    $crdt = date('Y-m-d H:i:s');
    
     //*****convert time into mysql format starts here
     
     //*********booking request date time
     $ttt= explode("/",$booking_datedata);
     $bkngdate = $ttt[2].'-'.$ttt[1].'-'.$ttt[0];
     
     $r =  date("G:i", strtotime($start_timedata));
     $strttim = date('H:i:s',strtotime($r));
     
     $r1 =  date("G:i", strtotime($end_timedata));
     $endtim = date('H:i:s',strtotime($r1));
    //*********booking request date time
    //*****convert time into mysql format ends here
   
    
    //*******request expire date time
     $reqt= explode("/",$requestexpireddatedata);
     $bkngexpirdate = $reqt[2].'-'.$reqt[1].'-'.$reqt[0];
     
     $r2 =  date("G:i", strtotime($requestexpiredtimedata));
     $expirtim = date('H:i:s',strtotime($r2));
    
    $bokingexpired = $bkngexpirdate.' '.$expirtim;
    //*******request expire date time
    
     $inbookingarray = array(
                             'artist_id' => '123456',
                             'booker_id' => '1234',
                             'event_address1' =>$address1val,
                             'event_address2' => $address2val,
                             'event_country' => $countrydata,
                             'event_state' => $statelistdata,
                             'event_city' => $towndata,
                             'event_zip' => $zipdata,
                             'booking_category' => $bookingcat_subdata,
                             'booking_genere' =>$bookinggenre_subdata,
                             'artist_security_deposit' => $security_paymentdata,
                             'total_payment' => $total_paymentdata,
                             'booking_cancellation_fee' => $cancellation_paymentdata,
                             'event_date' => $bkngdate,
                             'event_start_time' => $strttim,
                             'event_end_time' => $endtim,
                             'event_address1_lat' => $latitude,
                             'event_address1_long' => $longitude,
                             'event_timezone' => $timezoneName,
                             'booking_req_date' => $crdt,
                             'request_expired'=> $bokingexpired
                             );
     
                //    $datainsrt = DB::table('event_booking_request')->insert($inbookingarray); //insert data into event booking table
               
                    if($datainsrt)
                    {
                           //***************** calling an email function
                           //booking_email();
                           
                    }
     
                    $getresponseAr['flagdata'] = $inbookingarray;
                    
                    
                    //$getresponseAr['endtim'] = $endtim;
                    
                    echo json_encode($getresponseAr);
                    //die;
   }
   
   //**********booking complete ends here
   
   //************* Common function to get single data starts here
   public function getcommondetails($id,$selecttype,$tblnm)
   {
                    
                    //return 2;
                    $qry = DB::table($tblnm)->select($selecttype)->where('id',$id)->first();
                   // return  $qry$selecttype;
                   //echo "<pre>";
                   //print_r($qry);
                   //die;
                   return $qry;
   }
   //************* Common function to get single data ends here
      
      
      public function booking_email()
      {
            
                  
                    $userssel = DB::table('settings')
                    ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                    ->where('id', 1)
                    ->get();
                    $sitename=$userssel[0]->site_name;
                    $emailfrom=$userssel[0]->email_from;
                    $copyright_year=$userssel[0]->copyright_year;
                    $Imgologo=$userssel[0]->email_template_logo_image;
                    $bsurl = url('/');
                    
                    //**********get user details strats here
                    
                    $userdetail = DB::table('group_master')
                    ->select(DB::raw('first_name'))
                    ->where('email', $email)
                    ->get();
                    $first_name=$userdetail[0]->first_name;
                    
                    //*********get user details ends here
                    
                    //$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
                    $logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
                    //*********Helper Function Starts here
                    $replacefrom =array('{NAME}','{USERNAME}','{PASSWORD}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                    $replaceto =array(ucfirst($first_name),$email,$nw_pass,$sitename,$copyright_year,$bsurl,$logoIMG);
                    
                    mailsnd($Temid=8,$replacefrom,$replaceto,$email);
                    
                    //*********Helper Function Ends here 
                
                     
      }
      
      //************15-06 for edit group***************

      function editgroup(Request $request){
                    
        $sess_id = $request->session()->get('front_id_sess');
        $data=array();
        if($sess_id!=''){
                //*************Checking group url ************
                //$sqlGroupName="SELECT `nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$sess_id."'";
                $sqlGroupName="SELECT * FROM `group_master` WHERE `creater_id`='".$sess_id."'";
                $GroupName= DB::select( DB::raw($sqlGroupName));

                $seo_seg=$request->segment(2);
                if(!empty($seo_seg)){
                    if(!empty($GroupName)){
                          if($GroupName[0]->seo_name==$seo_seg){
                         $data['data1']="hello";
                         $user_id=0;
                         
                         if ($request->session()->has('front_id_sess'))
                         {
                             $user_id= $request->session()->get('front_id_sess');
                             $sqlGroupName="SELECT * FROM `group_master` WHERE `creater_id`='".$user_id."'";
                             $GroupName = DB::select( DB::raw($sqlGroupName));
                             $group_id = $GroupName[0]->id;
                           
                         }
                        $user_id = $group_id;
         
                        $successmsgdata=$request->session()->get('front_successmsgdata_sess');
                        $errormsgdata=$request->session()->get('front_errormsgdata_sess');
                         
                        $data=array();
                        $data['data1']="hello";
                        
                        //**** for message show purpose starts
                        if(!empty($successmsgdata))
                        {
                                  $data['successmsgdata']=$successmsgdata;
                                  
                                 $data['tmodata']=2000;
                                 $data['etmodata']=500;
                                 $data['sddata']=1000; 
                                 $data['hddata']=1500;
                                 $data['posclsdata']='toast-top-full-width';
                        }
                         if(!empty($errormsgdata))
                        {
                                 $data['errormsgdata']=$errormsgdata;
                                 
                                 $data['tmodata']=2000;
                                 $data['etmodata']=500;
                                 $data['sddata']=1000; 
                                 $data['hddata']=1500;
                                 $data['posclsdata']='toast-top-full-width';
                        }
                        
                        //**** for message show purpose ends
                        
                        //*** fetch data of banner starts                 
                                        
                         $banner_image='';$display_flag=0;            
                         
                         
                         //*** fetch data of banner ends                
                         
                         //**** fetch basic info of user  starts
                         
                         $fetchtype='single'; $tablename="group_master";
                         $fieldnames=" * ";
                         $wherear=array();
                         $wherear['id']=$user_id;
                         $orderbyfield="id"; $orderbytype="asc";
                         $limitstart=0;$limitend=0;                
                         
                         $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                        
                                         
                         //**** fetch basic info of user  ends            

                        //**** fetch skill_master data  starts
                         
                         //$fetchtype='multiple'; $tablename="skill_master";
                         //$fieldnames=" * ";
                         //$wherear=array();
                         //$wherear['catag_type']=2;
                         //$wherear['parent_id']=0;
                         //$wherear['status']=1;
                         //$orderbyfield="name"; $orderbytype="asc";
                         //$limitstart=0;$limitend=0;                
                         //
                         //$fetchskillmasterdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                        
                        // echo "=fetchskillmasterdata==><pre>";  print_r($fetchskillmasterdata); echo "</pre>";
                         
                    $parentskill_db = DB::table('skill_master');
                    $parentskill_db=$parentskill_db->where('status',1);
                    $parentskill_db=$parentskill_db->where('parent_id',0);
                    $parentskill_db=$parentskill_db->whereRaw(" FIND_IN_SET('2',`catag_type`) ");
                    $parentskill_db=$parentskill_db->orderBy('id', 'asc');
                    $parentskill_db=$parentskill_db->get();
                    
                    $fetchskillmasterdata=$parentskill_db;
                         
                         $fetchskillmasterAr=array();
                       
                         if(!empty($fetchskillmasterdata))
                         {
                                 foreach( $fetchskillmasterdata as $fetchskillobj )
                                 {
                                         $fetchskillmasterAr[$fetchskillobj->id]=$fetchskillobj->name;
                                 }
                         } 
                         //**** fetch skill_master data  ends
                         
                         //**** fetch user_skill_rel data  starts
                         
                         $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.group_id) as group_id ";
                        
                         $skill_user_db=DB::table('group_skill_rel as usr');
         
                         $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
                         $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
                         $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
                         
                         $skill_user_db=$skill_user_db->where('usr.group_id', $user_id);
                         $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
                         
                         $skill_user_db=$skill_user_db->get();
                         //$skill_user_db=$skill_user_db->toSql();
                                 //dd($results);;
                           //echo $skill_user_db;
         
         
                        
                         //**** fetch user_skill_rel data  ends
                                         
                         //*** fetch this user related images starts                              
                         
                           $selectstr=" umtb.* ";
                           
                           $group_master_img_db=DB::table('group_master_img as umtb');              
                           $group_master_img_db=$group_master_img_db->where('umtb.group_id', $group_id);
                           $group_master_img_db=$group_master_img_db->orderBy("umtb.id", "asc");
                           $group_master_img_db = $group_master_img_db->skip(0)->take(3);
                           $group_master_img_db=$group_master_img_db->get();                                             
                                       
                           //*** fetch this user related images ends



                  //*********** Check pdf presskit is present or not starts here
                  $presskitflagcheck = 0;
                  $presskitcheck = DB::table('group_presskit')->where('g_creator_id',$sess_id)->first();
                  if($presskitcheck)
                  {
                    $presskitflagcheck = 1;
                  }else
                  {
                    $presskitflagcheck = 0;
                  }

                  //*********** Check pdf presskit is present or not ends here
                         
                           $data['banner_image']=$banner_image;
                           $data['display_flag']=$display_flag;
                           $data['fetchuserdata']=$fetchuserdata;
                           $data['fetchskillmasterAr']=$fetchskillmasterAr;
                           $data['skill_user_db']=$skill_user_db;
                           $data['group_master_img_db']=$group_master_img_db;

                            $data['presskitflagcheck']=$presskitflagcheck;
                            
                           return view('front.group_new.editgroupajax', $data);     
                          }else{
                                return redirect('/');             
                          }
                    }else{
                        return redirect('/');                
                    } 
                }else{
                    //$sqlGroupName
                $GroupName = DB::select( DB::raw("Select * from `user_master` where id ='".$sess_id."'"));

                    $sendingEMailAddress = $GroupName[0]->email;
                    $sendingMailUser = ucfirst($GroupName[0]->first_name." ".$GroupName[0]->middle_name." ".$GroupName[0]->last_name);
                $inserGroup_Array = array(
                 'create_date' => date('Y-m-d H:i:s'),
                 'modified_date' => date('Y-m-d H:i:s'),
                 'creater_id' =>$sess_id,
                 'address_1' =>$GroupName[0]->address1,
                 'address_2' =>$GroupName[0]->address2,
                 'group_lat' =>$GroupName[0]->addr_lat,
                 'group_long' =>$GroupName[0]->addr_long,
                 'group_timezone' =>$GroupName[0]->addr_timezone,
                 'country' =>$GroupName[0]->country,
                 'state' =>$GroupName[0]->state,
                 'city' =>$GroupName[0]->city,
                 'zip' =>$GroupName[0]->zip,
                 'address_1' =>$GroupName[0]->country,
                 );
                    $group_creted_id = DB::table('group_master')->insertGetId($inserGroup_Array);
                    $seo_name = 'group-profile-'.$group_creted_id;
                    
                    DB::table('group_master')
                                      ->where('id', $group_creted_id)
                                      ->update(['seo_name' => $seo_name]);
                    //******************Sending mail code 30-06-16********************//
                    
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
                                        $replaceto =array($sendingMailUser,$sitename,$copyright_year,$bsurl,$logoIMG);
                                        
                                        mailsnd($Temid=15,$replacefrom,$replaceto,$sendingEMailAddress);
                                        //*********Helper Function Ends here
                                        
                    
                    //******************Sending mail code 30-06-16********************//
                    $request->session()->flash('front_successmsgdata_sess', 'Your group has been created successfully .');
                    return redirect('group/'.$seo_name);
                }
        }else{
                    return redirect('/');
        }
                    
                    //$view_obj = View::make('front.group_new.editgroupajax',$data);
                    //$ep_view_contents = $view_obj->render();
                    //
                    //$resp_arr=array();
                    //$resp_arr['ep_contents']=$ep_view_contents;
                    //
                    //echo json_encode($resp_arr);
      }
      
      function editgroupajax(Request $request){
                
                $data=array();
                $data['data1']="hello";
                
                // return view('admin.logintemplate', $data);
                
                $user_id=0;
                
                if ($request->session()->has('front_id_sess'))
                {
                    $user_id= $request->session()->get('front_id_sess');
                  
                }
                
               
               $successmsgdata=$request->session()->get('front_successmsgdata_sess');
               $errormsgdata=$request->session()->get('front_errormsgdata_sess');
                
               $data=array();
               $data['data1']="hello";
               
               //**** for message show purpose starts
               if(!empty($successmsgdata))
               {
                         $data['successmsgdata']=$successmsgdata;
                         
                        $data['tmodata']=2000;
                        $data['etmodata']=500;
                        $data['sddata']=1000; 
                        $data['hddata']=1500;
                        $data['posclsdata']='toast-top-full-width';
               }
                if(!empty($errormsgdata))
               {
                        $data['errormsgdata']=$errormsgdata;
                        
                        $data['tmodata']=2000;
                        $data['etmodata']=500;
                        $data['sddata']=1000; 
                        $data['hddata']=1500;
                        $data['posclsdata']='toast-top-full-width';
               }
               
                //**** for message show purpose ends
               
                //*** fetch data of banner starts                 
                               
                $banner_image='';$display_flag=0;            
                
                
                //*** fetch data of banner ends                
                
                //**** fetch basic info of user  starts
                
                $fetchtype='single'; $tablename="group_master";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['id']=$user_id;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
                                
                //**** fetch basic info of user  ends
                
               // echo "<pre>";  print_r($fetchuserdata); echo "</pre>";
               
               
               //**** fetch skill_master data  starts
                
                //$fetchtype='multiple'; $tablename="skill_master";
                //$fieldnames=" * ";
                //$wherear=array();
                //$wherear['catag_type']=1;
                //$wherear['parent_id']=0;
                //$wherear['status']=1;
                //$orderbyfield="name"; $orderbytype="asc";
                //$limitstart=0;$limitend=0;                
                //
                //$fetchskillmasterdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
               // echo "=fetchskillmasterdata==><pre>";  print_r($fetchskillmasterdata); echo "</pre>";
               
               $parentskill_db = DB::table('skill_master');
                $parentskill_db=$parentskill_db->where('status',1);
                $parentskill_db=$parentskill_db->where('parent_id',0);
                $parentskill_db=$parentskill_db->whereRaw(" FIND_IN_SET('2',`catag_type`) ");
                $parentskill_db=$parentskill_db->orderBy('id', 'asc');
                $parentskill_db=$parentskill_db->get();
                $fetchskillmasterdata=$parentskill_db;
                $fetchskillmasterAr=array();
              
                if(!empty($fetchskillmasterdata))
                {
                        foreach( $fetchskillmasterdata as $fetchskillobj )
                        {
                                $fetchskillmasterAr[$fetchskillobj->id]=$fetchskillobj->name;
                        }
                } 
                //**** fetch skill_master data  ends
                
                
                //**** fetch user_skill_rel data  starts
                
                $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.user_id) as user_id ";
               
                $skill_user_db=DB::table('user_skill_rel as usr');

                $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
                
                $skill_user_db=$skill_user_db->where('usr.user_id', $user_id);
                $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
                
                $skill_user_db=$skill_user_db->get();
                
                //echo "==skill_db==><pre>";
                //print_r($skill_db);
                //echo "</pre>";
               
                //**** fetch user_skill_rel data  ends
                
                
                //*** fetch this user related images starts                              
                
                  $selectstr=" umtb.* ";
                 
                  $group_master_img_db=DB::table('group_master_img as umtb');              
                  $group_master_img_db=$group_master_img_db->select(DB::raw($selectstr));                                                          
                  $group_master_img_db=$group_master_img_db->where('umtb.user_idgroup_id', $user_id);
                  $group_master_img_db=$group_master_img_db->orderBy("umtb.id", "asc");
                  $group_master_img_db = $group_master_img_db->skip(0)->take(3);
                  $group_master_img_db=$group_master_img_db->get();                                             
                              
                  //*** fetch this user related images ends
                
                  $data['banner_image']=$banner_image;
                  $data['display_flag']=$display_flag;
                  $data['fetchuserdata']=$fetchuserdata;
                  $data['fetchskillmasterAr']=$fetchskillmasterAr;
                  $data['skill_user_db']=$skill_user_db;
                  $data['group_master_img_db']=$group_master_img_db;
                  
                  //return view('front.user.editprofile', $data);
            
                  $view_obj = View::make('front.group_new.editgroupajax',$data);
                  $ep_view_contents = $view_obj->render();
                  
                  $resp_arr=array();
                  $resp_arr['ep_contents']=$ep_view_contents;
                  
                  echo json_encode($resp_arr);
      }
      
      function savegroupskills(Request $request){
                    
      }
      function savegroupdesc(Request $request){
            $user_description = addslashes(trim($request->input('user_description','')));
            $id=0;
            $chkvalid=$this->checksaveuserdesc($request,$id);
            
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
           if($chkvalid===true)
           {
                 //*** save  data of user starts
                 
                        $userid=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $userid=$request->session()->get('front_id_sess'); // get session
                                $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$userid."'";
                                $GroupName = DB::select( DB::raw($sqlGroupName));
                                $group_id = $GroupName[0]->id;
                        
                        }
                        
                        //*** update user_master table starts
                        $chkupd= DB::table('group_master')->where('id',$group_id) ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),'group_description' => $user_description]
                        );
                        
                        //*** update user_master table ends
                        
                        if(!empty($chkupd))
                        {
                               $flag_id=1;          
                        }
                
                //*** save data of user ends
           }
           else
           {
                                   
                  $error_message = $chkvalid->messages();
                  
           }
           
          // return redirect(ADMINSEPARATOR.'/banner');
          
          
          
         $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
          
         // echo "<pre>"; print_r($error_msgAr);echo "</pre>";
         
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          echo json_encode($responseAr);       
      }
      function savegroupname(Request $request){
                    
            //$seo_name = addslashes(trim($request->input('nickname','')));
            $seo_name = addslashes(trim($request->input('seo_name','')));

            $id=0;
            $chkvalid=$this->checksaveusername($request,$id);
            $groucretaeOredit=0;
            $nicknmres = 0;
            $redirectNeed = 0;
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            $success_messagedata='';
           if($chkvalid===true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $userid=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $userid=$request->session()->get('front_id_sess'); // get session
                                $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$userid."'";
                                $GroupName = DB::select( DB::raw($sqlGroupName));
                                $group_id = $GroupName[0]->id;
                                $lst_seo_name = $GroupName[0]->seo_name;
                        
                        }
                        
                        //*** update user_master table starts
                        //********seo url
                        $seotitle = str_slug($seo_name, '-').'-'.$group_id;
                        //**********check modifying date starts here
                        $r = $this->check_modifying_date($group_id,$userid);
                        //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT
                        
                        //**********check modifying date starts here
                        if($r == 1)
                        {
                          $chkupd= DB::table('group_master')->where('id',$group_id) ->update(
                          ['modified_date' => date('Y-m-d H:i:s'),'nickname' => $seo_name,'seo_name' => $seotitle]
                          );
                        }else
                        {
                           $chkupd= DB::table('group_master')->where('id',$group_id) ->update(
                          ['modified_date' => date('Y-m-d H:i:s'),'nickname' => $seo_name]
                          );
                        }
                        
                        //*** update user_master table ends
                        if($r == 1)
                        {
                                       $request->session()->flash('front_successmsgdata_sess', 'YYour group name has been changed successfully.');
                                       //return redirect('/');
                                       $success_messagedata = "Your group name has been changed successfully ";
                                       $groucretaeOredit=1;
                                       //**get seo_name starts here
                                       $nicknmres =  $this->getnicknm($group_id,$userid);
                                       //**get seo_name ends here
                        }
                          
                        if(!empty($chkupd))
                        {
                                       $flag_id=1;       
                        }
                        // checking redirect condition
                        if($seotitle!=$lst_seo_name){
                             $request->session()->flash('front_successmsgdata_sess', 'Your group name has been changed successfully .');
                             $redirectNeed = 1;
                             $success_messagedata = "Your group name has been changed successfully ";
                             //$nicknmres =  $this->getnicknm($group_id,$userid);
                             $nicknmres =  $this->getnicknm($group_id,$userid);
                        }
                
                //*** save data of user ends
           }
           else
           {
                                   
                  $error_message = $chkvalid->messages();
                  
           }
           
          // return redirect(ADMINSEPARATOR.'/banner');
          
          
          
         $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
          
         // echo "<pre>"; print_r($error_msgAr);echo "</pre>";

          $responseAr['groucretaeOredit']=$groucretaeOredit;
          $responseAr['nicknmdata']= $nicknmres;
          $responseAr['redirectflag']= $redirectNeed;
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          $responseAr['successmsgdata']=$success_messagedata;
          // $responseAr['tt']=$error_message->first_name;
         
          echo json_encode($responseAr);
      }
      
          public function checksaveusername($request,$id=0)
           {
                $seo_name = addslashes(trim($request->input('seo_name','')));
                $controlmsg="";
                
                        
              
                $validator = Validator::make($request->all(), [
                "seo_name" => "required|min:5|max:50"
                ],[
                   'seo_name.required' => '* Group name is required',
                   'seo_name.required'=> '* Group name field required',
                   'seo_name.min'=> '* Group name length minimum 5',
                   'seo_name.max'=> '* Group name length maximum 50',
                   'seo_name.unique'=> '* Group name must be unique',
                ]);
                
                //*******validator after function starts here
                // $userData=array();
                // $userData['request']=$request;
                // $userData['addeditid']=$id;
                
                // $validator->after(function($validator)  use ($userData)  {
                        
                // $request=$userData['request'];
                // $addeditid=$userData['addeditid'];
                //     $chknm = $this->vaildtgroupnicknm($request,$addeditid);
                //     if($chknm > 0)
                //     {
                //      $validator->errors()->add('seo_name', 'Please enter a valid name');
                //     }
                // });
                //*******validator after function ends here
                
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                return true;
                    
        
           }
           
           public function checksaveuserdesc($request,$id=0)
           {
                $user_description = addslashes(trim($request->input('user_description','')));
                $controlmsg="";
                
                        
              
                    $validator = Validator::make($request->all(), [
                   
                    "user_description" => "required"
                    
                    
                    ],[
                       "user_description.required" => " Description is required"                  
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                
                  
                  
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                  return true;
                    
        
           }
         
         //************************** save user_description ends
      
      //************15-06 for edit group***************
      
      
      //*************16-06 *******************
      

   public function savegroupurls(Request $request)
    {
          
            
            $controlname = addslashes(trim($request->input('controlname','')));
            $controlnamedata = addslashes(trim($request->input('controlnamedata','')));
           
            $id=0;
            $chkvalid=$this->checksaveuserurls($request,$id);
            
            $groucretaeOredit=0;
            $nicknmres=0;
            
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
           if($chkvalid===true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $userid=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $userid=$request->session()->get('front_id_sess'); // get session
                                $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$userid."'";
                                $GroupName = DB::select( DB::raw($sqlGroupName));
                                $group_id = $GroupName[0]->id;
                         
                        
                        }
                        
                       
                        
                        //*** update user_master table starts
                        
                        $chkupd= DB::table('group_master')->where('id',$group_id) ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),$controlname => $controlnamedata]
                        );
                        
                        //*** update user_master table ends
                        
                        if(!empty($chkupd))
                        {
                                       $flag_id=1;                          
                                       
                               
                        }
                
                //*** save data of user ends
           }
           else
           {
                                   
                  $error_message = $chkvalid->messages();
                  
           }
           
          // return redirect(ADMINSEPARATOR.'/banner');
          
          
          
         $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
          
         // echo "<pre>"; print_r($error_msgAr);echo "</pre>";
          
         
          $responseAr['groucretaeOredit']=$groucretaeOredit;
          $responseAr['nicknmdata']= $nicknmres;
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          
          echo json_encode($responseAr);
          
          
    }
           
    public function checksaveuserurls($request,$id=0)
           {
                $controlname = addslashes(trim($request->input('controlname','')));
                $controlmsg="";
                
                         if ($controlname=="facebook_url")
						{
							                           
							 $controlmsg="The facebook url ";
						}
                        elseif ($controlname=="soundcloud_url")
						{
							                           
							  $controlmsg="The soundcloud url ";
						}
                        elseif ($controlname=="residentadvisor_url")
						{
							                           
                                $controlmsg="The residentadvisor url ";
						}
                         elseif ($controlname=="twitter_url")
						{
							     $controlmsg="The twitter url ";                      
							 
						}
                        elseif ($controlname=="youtube_url")
						{
							    $controlmsg="The youtube url ";                       
							 
						}
                        elseif ($controlname=="instagram_url")
						{
							     $controlmsg="The instagram url ";                     
							 
						}
                
              
                    $validator = Validator::make($request->all(), [
                   
                    "controlnamedata" => "required|url",
                    
                    
                    ],[
                       "controlnamedata.required" => $controlmsg." is required", 
                       "controlnamedata.url" => $controlmsg." This URL can not be accepted",
                     
                       
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                
                  
                  
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                  return true;
                    
        
           }
//********* populatesubskill starts
         
         
         function populategroupsubskill(Request $request)
         {
                //**** fetch skill starts
                
                $parent_id = $request->input('parent_id');

                $catag_type =$request->input('catag_type');
                
                
                $user_id=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session                       
                        
                        }
                
                $fetchtype='multiple'; $tablename="skill_master";
                $fieldnames=" * ";
                $wherear=array();
                //$wherear['catag_type']=$catag_type;
                $wherear['parent_id']=$parent_id;
                $wherear['status']=1;
                $orderbyfield="name"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                               
                $respar=array();
                //$wherenortinstr=" id NOT IN ( select skill_sub_id from user_skill_rel where user_id='".$user_id."' ) ";
	
                $tab_db = DB::table($tablename);
                $tab_db=$tab_db->select(DB::raw($fieldnames));
                $tab_db=$tab_db->where($wherear);
                $tab_db=$tab_db->whereRaw(" FIND_IN_SET('2',`catag_type`) ");
                $tab_db=$tab_db->orderBy($orderbyfield, $orderbytype);
                
                if(!empty($limitend))
                {
                    $tab_db = $tab_db->skip($limitstart)->take($limitend);
                }
                
                $tab_db=$tab_db->get();
             
                if(!empty($tab_db))
                {
                    $respar=$tab_db;
                    
                }
               
               $fetchskillmasterdata=$respar;
               
               // echo "=fetchskillmasterdata==><pre>";  print_r($fetchskillmasterdata); echo "</pre>";
                
                $fetchskillmasterAr=array();
               
                if(!empty($fetchskillmasterdata))
                {
                        foreach( $fetchskillmasterdata as $fetchskillobj )
                        {
                                $fetchskillmasterAr[]=array('id'=>$fetchskillobj->id,'name'=>$fetchskillobj->name);
                        }
                }
                
                echo json_encode($fetchskillmasterAr);
                
                //**** fetch skill  ends
         }
         
         
         //********* populatesubskill ends
         
//*************************** save skill data starts
         
          public function savegroupskilldata(Request $request)
        {

          
            
            $catag_type_id= addslashes(trim($request->input('catag_type_id','')));
            $skill_id= addslashes(trim($request->input('skill_id','')));
            $skill_sub_id= addslashes(trim($request->input('skill_sub_id','')));
            
            
            $id=0;
            $chkvalid=$this->checksaveskilldata($request);
            $chkvalid=true;
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
           if($chkvalid==true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $user_id=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session
                                $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$user_id."'";
                                $GroupName = DB::select( DB::raw($sqlGroupName));
                                $group_id = $GroupName[0]->id;
                        
                        }
                        
                        //*** update user_master table starts
                        
                        $insert_skill_array=array();
                        $insert_skill_array['catag_type_id']=$catag_type_id;
                        $insert_skill_array['skill_id']=$skill_id;
                        $insert_skill_array['skill_sub_id']=$skill_sub_id;
                        $insert_skill_array['group_id']=$group_id;
                        $insert_skill_array['create_date']=date('Y-m-d H:i:s');
                        $insert_skill_array['g_creator_id']=$user_id;
                        
                        $chkupd= DB::table('group_skill_rel')->insert($insert_skill_array );
                        $last_insert_id=DB::getPdo()->lastInsertId();

                        
                        //*** update user_master table ends
                        
                        if(!empty($last_insert_id))
                        {
                                       $flag_id=1;                          
                                       
                               
                        }
                
                //*** save data of user ends
           }
           else
           {
                                   
                  //$error_message = $chkvalid->messages();
                  
           }
           
          
          
          
          
         $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
          
         // echo "<pre>"; print_r($error_msgAr);echo "</pre>";
         
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          echo json_encode($responseAr);
          
          
    }
           
    
         
        //************************** save skill data ends
        
        public function checksaveskilldata($request)
           {
                $user_id=0;
                if ($request->session()->has('front_id_sess'))
                {
                        $user_id=$request->session()->get('front_id_sess'); // get session                       
                
                }
                $controlmsg="";
                
                        
              
                $validator = Validator::make($request->all(), [
               
                "skill_sub_id" => "required"         
                
                ],[
                   "skill_sub_id.required" => " Sub skill is required"                  
                   
                ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                return true;
                    
        
           }
     //*************************** delete skill data starts
         
          public function deletegroupskill(Request $request)
        {

            
           
            $skill_sub_id = addslashes(trim($request->input('skill_sub_id','')));
            
            
            $id=0;
            //$chkvalid=$this->checksaveskilldata($request,$id);
            $chkvalid=true;
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            $sk_delt_flaf = 0;
           if($chkvalid===true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $user_id=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session
                                $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$user_id."'";
                                $GroupName = DB::select( DB::raw($sqlGroupName));
                                $group_id = $GroupName[0]->id;
                        }
                        
                        //*** update user_master table starts
                        
                        $where_del_array=array();
                        
                        $where_del_array['skill_sub_id']=$skill_sub_id;
                        $where_del_array['group_id']=$group_id;
                    

                        //**********************Cheking skill delete start*********************//
                        //SELECT count(*) FROM `gig_skill_rel` WHERE `genre`='15' and`gigmaster_id` in(SELECT `id` FROM `gig_master` WHERE `type_flag`='2' and `artist_id` = '1')
                        $sqlGroupSkill="SELECT count(*) as 'number' FROM `gig_skill_rel` WHERE `genre`='".$skill_sub_id."' and`gigmaster_id` in(SELECT `id` FROM `gig_master` WHERE `type_flag`='2' and `artist_id` = '".$group_id."')";
                        $sqlGroupSkillCount = DB::select( DB::raw($sqlGroupSkill));
                        $numberCountSkill = $sqlGroupSkillCount[0]->number;
                        if($numberCountSkill > 0){
                              $sk_delt_flaf = 3;
                              $flag_id = 3;
                        }else{
                             //**********************Cheking skill delete start*********************//
                        
                             $chkupd= DB::table('group_skill_rel')->where($where_del_array )->delete();           
                        }

                         

                        
                        //*** update user_master table ends
                        
                        if(!empty($chkupd))
                        {
                                       $flag_id=1;                          
                                       
                               
                        }
                
                //*** save data of user ends
           }
           else
           {
                                   
                  //$error_message = $chkvalid->messages();
                  
           }
           
          
          
          
          
         $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
          
         // echo "<pre>"; print_r($error_msgAr);echo "</pre>";
                    
          if($flag_id == 3){
               $responseAr['flag_id']=3;
               $responseAr['error_message']="You can not delete this genre.";
               //$responseAr['error_message']="You con't delete this skill, this already used in ".$numberCountSkill." times.";     
          }else{
               $responseAr['flag_id']=$flag_id;
               $responseAr['error_message']=$error_msgAr;    
          }
          
          echo json_encode($responseAr);
          
          
          // $responseAr['tt']=$error_message->first_name;

          
          
    }

//************************** save rider data starts
            public function savegroupridercust(Request $request)
            {
                        $riderdata = addslashes(trim($request->input('riderdata','')));

                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checksaverider($request,$id);
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=0;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                                $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$userid."'";
                                                $GroupName = DB::select( DB::raw($sqlGroupName));
                                                $group_id = $GroupName[0]->id;
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('group_master')->where('id',$group_id) ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'),'rider_data' => $riderdata]
                                    );
                                    //*** update user_master table ends
                                    if(!empty($chkupd))
                                    {
                                                $flag_id=1;                            
                                    }
                                    //*** save data of user ends
                        }
                        else
                        {                 
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
                        }
                        $responseAr['flag_id']=$flag_id;
                        $responseAr['error_message']=$error_msgAr;
                        echo json_encode($responseAr);  
            }
            
            public function checksaverider($request,$id=0)
            {
                        $validator = Validator::make($request->all(), [
                                    "riderdata" => "required|max:100",
                        ],[
                                    "riderdata.required" => "Rider data is required", 
                                    "riderdata.max" => "Maximum 100 characters",
                        ]);
                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            //************************** save rider data ends
           
           
           //************************** save ABN data starts
            public function saveabncustgroup(Request $request)
            {
                        $abndata = addslashes(trim($request->input('abndata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checkvalidabntosave($request,$id); //*** checksaveabn
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=0;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                                $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$userid."'";
                                                $GroupName = DB::select( DB::raw($sqlGroupName));
                                                $group_id = $GroupName[0]->id;
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('group_master')->where('id',$group_id) ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'),'abn_data' => $abndata]
                                    );
                                    //*** update user_master table ends
                                    if(!empty($chkupd))
                                    {
                                                $flag_id=1;                            
                                    }
                                    //*** save data of user ends
                        }
                        else
                        {                 
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
                        }
                        $responseAr['flag_id']=$flag_id;
                        $responseAr['error_message']=$error_msgAr;
                        echo json_encode($responseAr);  
            }
            
            public function checkvalidabntosave($request,$id=0)
            {   
                        $validator = Validator::make($request->all(), [
                                    "abndata" => "required|numeric" ,
                        ],[
                                    "abndata.required" => "ABN is required",
                                    "abndata.numeric" => "An ABN is up to 11 numbers",//"Only numerics are allowed",
                        ]);
                        
                        $sendData=array();
                        $sendData['request']=$request;                      
                        $validator->after(function($validator)  use ($sendData)  {            
                                    $request=$sendData['request'];
                                    //***** here
                                    $validabnlengthcheck=$this->checkabnlengthvalid($request);
                                    if (!empty($validabnlengthcheck))
                                    {
                                                $validator->errors()->add('abndata', $validabnlengthcheck);
                                    }
                                    //***** here
                        });
                        
                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            
            public function checkabnlengthvalid($request)
            {
                        $abninput=$request->input('abndata');
                        $abnlength=strlen($abninput);
                        $errorMsg=array();
                        if($abnlength>11)
                        {
                                    $errorMsg[]="An ABN is up to 11 numbers";//" Maximum 11 digits ";
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
            //************************** save ABN data ends
            
            //************************** save GST data starts
            public function savegstcustgroup(Request $request)
            {
                        $gstdata = addslashes(trim($request->input('gstdata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checkvalidgsttosave($request,$id); 
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=0;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                                $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$userid."'";
                                                $GroupName = DB::select( DB::raw($sqlGroupName));
                                                $group_id = $GroupName[0]->id;
                                    }
                                    $gststat=0;
                                    if($gstdata!='')
                                    {
                                                $gststat=1;
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('group_master')->where('id',$group_id) ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'), 'tfn_data' => $gstdata, 'gst_status' => $gststat]
                                    );
                                    //*** update user_master table ends
                                    if(!empty($chkupd))
                                    {
                                                $flag_id=1;                            
                                    }
                                    //*** save data of user ends
                        }
                        else
                        {                 
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
                        }
                        $responseAr['flag_id']=$flag_id;
                        $responseAr['error_message']=$error_msgAr;
                        echo json_encode($responseAr);  
            }
            
            public function checkvalidgsttosave($request,$id=0)
            {   
                        $validator = Validator::make($request->all(), [
                                    "gstdata" => "required|numeric" ,
                        ],[
                                    "gstdata.required" => "GST is required",
                                    "gstdata.numeric" => "Only numerics are allowed",
                        ]);
                        
                        $sendData=array();
                        $sendData['request']=$request;                      
                        $validator->after(function($validator)  use ($sendData)  {            
                                    $request=$sendData['request'];
                                    //***** here
                                    $validgstlengthcheck=$this->checkgstlengthvalid($request);
                                    if (!empty($validgstlengthcheck))
                                    {
                                                $validator->errors()->add('gstdata', $validgstlengthcheck);
                                    }
                                    //***** here
                        });
                        
                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            
            public function checkgstlengthvalid($request)
            {
                        $gstinput=$request->input('gstdata');
                        $gstlength=strlen($gstinput);
                        $errorMsg=array();
                        if($gstlength>9)
                        {
                                    $errorMsg[]=" Maximum 9 digits ";
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
            //************************** save GST data ends
            
            //************************** save Page-meta-tag data starts
            public function savepagemetatagcustgroup(Request $request)
            {
                        $pagemetatagdata = addslashes(trim($request->input('pagemetatagdata','')));
                       
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checksavepagemetatag($request,$id);
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=0;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                                $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$userid."'";
                                                $GroupName = DB::select( DB::raw($sqlGroupName));
                                                $group_id = $GroupName[0]->id;
                                                
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('group_master')->where('id',$group_id) ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'),'group_meta_data' => $pagemetatagdata]
                                    );
                                    //*** update user_master table ends
                                    if(!empty($chkupd))
                                    {
                                                $flag_id=1;                            
                                    }
                                    //*** save data of user ends
                        }
                        else
                        {                 
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
                        }
                        $responseAr['flag_id']=$flag_id;
                        $responseAr['error_message']=$error_msgAr;
                        echo json_encode($responseAr);  
            }
            public function saveseourlcustgroup(Request $request)
            {
                        $pagemetatagdata = addslashes(trim($request->input('pagemetatagdata','')));
                       
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checksavepagemetatag($request,$id);
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=0;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                                $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$userid."'";
                                                $GroupName = DB::select( DB::raw($sqlGroupName));
                                                $group_id = $GroupName[0]->id;
                                                
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('group_master')->where('id',$group_id) ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'),'seo_name' => $pagemetatagdata]
                                    );
                                    //*** update user_master table ends
                                    if(!empty($chkupd))
                                    {
                                                $flag_id=1;                            
                                    }
                                    //*** save data of user ends
                        }
                        else
                        {                 
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
                        }
                        $responseAr['flag_id']=$flag_id;
                        $responseAr['error_message']=$error_msgAr;
                        echo json_encode($responseAr);  
            }
            
            public function checksavepagemetatag($request,$id=0)
            {
                        $validator = Validator::make($request->all(), [
                                    "pagemetatagdata" => array('required:required','max:100','regex:/^[a-zA-Z0-9-_]+$/'),
                        ],[
                                    "pagemetatagdata.required" => "Seo url is required", 
                                    "pagemetatagdata.max" => "Maximum 100 characters",
                                    "pagemetatagdata.regex" =>"Invalid seo url",
                        ]);


                        $userData=array();
                        $userData['request']=$request;
                       // $userData['request']=$request;

                         $validator->after(function($validator)  use ($userData)  { 
                                    $request=$userData['request'];
                                    
                                    $pagemetatagdata = trim(addslashes($request->input('pagemetatagdata')));
                                   
                                    $userid=$request->session()->get('front_id_sess'); 

                            if(trim($pagemetatagdata)!='')
                            {
                              $chkseoname = DB::table('group_master')->where('creater_id','<>',$userid)->where('seo_name',$pagemetatagdata)->get();
                              $countexists = count($chkseoname);
                                    if($chkseoname)
                                    {
                                      
                                     $validator->errors()->add('pagemetatagdata', 'This seo name already exists '); 
                                    }
                            }
       
                          });

                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            //************************** save Page-meta-tag data ends 
            
     //*************************** upload user image starts*************
     
     
     //************************** upload presskit starts
         
       public function presskituploadsavegroup(Request $request)
        {
            //press-kit
            
             //echo "<pre>"; print_r($_FILES);echo "</pre>";
           
           
            $id=0;
            $chkvalidimage=$this->presskitfileisinvalid($request,$id);
              
            $err_resp_msg=''; $respflg=0; $uploadedsuccnames=array(); $user_master_img_db=array();
            $slider_contents=''; $default_image_name='';
              
            $errormsgs=$chkvalidimage['errormsgs'];
            $errfileAr=$chkvalidimage['errfileAr'];
            $totalfileposted=$chkvalidimage['totalfileposted'];
              
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
           
                  //**** file upload code starts
                       
                       
                       $allowedFileExtAr=array();
                       $allowedFileExtAr[]="pdf";
                      
                       
                       $filecontrolname="presskit_name";
                       
                      
                       $allowedFileExtSizeAr=array();
                       $allowedFileExtSizeAr['pdf']=(5*1024*1024);                      
                       
                       
                       //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                       $allowedFileResolAr=array();
                       
                      // $allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
                      
                       $func="uploadfile";//validatefile/uploadfile
                       
                       
                       $destinationsourcePath=public_path()."/upload/group-press-kit/source-file/";      //group-press-kit                   
                      
                       $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath,$errfileAr) ;
                       
                       
                         //echo "==Imcommonpath=>".$Imcommonpath;
                         //echo "==chkimg1==><pre>";
                         //print_r($chkimgresp);
                         //echo "</pre>";  //exit();
                   
                       if(!empty($chkimgresp))
                       {
                               $errormsgs='';  $fileuploadednames=array();
                               
                               if(array_key_exists('errormsgs',$chkimgresp))
                               {
                                       $errormsgs=$chkimgresp['errormsgs'];
                               }
                               
                               if(array_key_exists('fileuploadednames',$chkimgresp))
                               {
                                       $fileuploadednames=$chkimgresp['fileuploadednames'];
                               }
                               
                               if(!empty($fileuploadednames))
                               {
                                       
                                       
                                       foreach($fileuploadednames as $fileuploadednameAr)
                                       {
                                             $presskitfileName=$fileuploadednameAr['filenamedata'];
                                                $uploadedsuccnames[]=$presskitfileName;
                                       }                           
                                
                               }
                       
                       }
                       
                       //**** file upload code ends
                       
                       
                       //*****  insert into user_presskit table starts
                       
                       //$uploadedsuccnames
                       
                       if(!empty($uploadedsuccnames))
                       {
                              $user_id=0;
                              if ($request->session()->has('front_id_sess'))
                              {
                                      $user_id=$request->session()->get('front_id_sess'); // get session
                                      $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$user_id."'";
                                      $GroupName = DB::select( DB::raw($sqlGroupName));
                                      $group_id = $GroupName[0]->id;
                              
                              }
                              
                              
                               //*** check whether any prev presskit present starts
                                          $selectstr=" gpk.* ";
                                          
                                          $user_presskit_db=DB::table('group_presskit as gpk');              
                                          $user_presskit_db=$user_presskit_db->select(DB::raw($selectstr));                                                          
                                          $user_presskit_db=$user_presskit_db->where('gpk.g_creator_id', $user_id);
                                          $user_presskit_db=$user_presskit_db->where('gpk.group_id', $group_id);
                                          $user_presskit_db = $user_presskit_db->skip(0)->take(1);
                                          $user_presskit_db=$user_presskit_db->first();
                                          $presskit_name='';
                                          if(!empty($user_presskit_db))
                                          {
                                                $presskit_name=stripslashes($user_presskit_db->presskit_name);
                                          }
                                        
                               //*** check whether any prev presskit present ends
                        
                              foreach($uploadedsuccnames as $user_presskit_name)
                              {
                                    
                                   
                                    
                                    if(!empty($user_presskit_db))
                                    {
                                                //**** update qry
                                                
                                                $updtusrmstr= DB::table('group_presskit');
                                                $updtusrmstr= $updtusrmstr->where('g_creator_id',$user_id) ;
                                                $updtusrmstr= $updtusrmstr->where('group_id',$group_id) ;
                                                $updtusrmstr=$updtusrmstr->update(
                                                ['presskit_name' =>addslashes($user_presskit_name),
                                                 'create_date'=>date('Y-m-d H:i:s')    
                                                 ]
                                                );
                                                
                                                //*** unlink previous presslit  file
                                                
                                                $srcpresskit=public_path()."/upload/group-press-kit/source-file/".$presskit_name; //group-press-kit
                        
                                                 @unlink($srcpresskit);
                                                
                                               
                                    }
                                    else
                                    {
                                               //**** insert qry
                                               
                                                $presskit_array=array();                                                
                                                
                                                $presskit_array['presskit_name']=addslashes($user_presskit_name);
                                                $presskit_array['g_creator_id']=$user_id;
                                                $presskit_array['group_id']=$group_id;
                                                $presskit_array['create_date']=date('Y-m-d H:i:s');                                    
                                                $chkupd= DB::table('group_presskit')->insert($presskit_array );
                                                $last_insert_id=DB::getPdo()->lastInsertId(); 
                                               
                                    }
                                   
                                    
                                    
                                    
                                    
                              }
                              
                             
                              
                              
                              
                              
                       }
                       
                       
                       //*****  insert into user_presskit table ends
                       
                       
            
            }
            else
            {
                   if(!empty($id))
                        {
                              
                              //return redirect(ADMINSEPARATOR.'/banneradd/'.$id)
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                             $err_resp_msg= $errormsgs;
                              
                        }
                        else
                        {
                              //return redirect(ADMINSEPARATOR.'/banneradd')
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                                $err_resp_msg= $errormsgs;
                        }
            }
            
            
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
                  $respflg=1;
              }
            
            
            
            
            $respAr=array();
            $respAr['flag']=$respflg;
            $respAr['errorespmsg']=$err_resp_msg;
            $respAr['errfileAr']=$errfileAr;
            $respAr['totalfileposted']=$totalfileposted;
            $respAr['uploadedsuccnames']=$uploadedsuccnames;
            
            //$respAr['user_master_img_db']=$user_master_img_db;
           //  $respAr['chkimgresp']=$chkimgresp;
            echo json_encode($respAr);
            
            
        }
        
        public function presskitfileisinvalid($request,$addeditid=0)
       {
               
                // echo "<pre>";    print_r($request); exit();
                
                
                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="pdf";
                
                
                $filecontrolname="presskit_name";
                
               
				$allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['pdf']=(5*1024*1024);
				
				
				
				
				//max_width & max_height ,min_width &  min_height,equal_width & equal_height  
				$allowedFileResolAr=array();
				
				//$allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
				
                $func="validatefile";//validatefile/uploadfile
                
                
                $destinationsourcePath=public_path()."/upload/press-kit/source-file/";                       
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$destinationsourcePath,$errfileAr=array()) ;
                       
                
                
                
               
               /* echo "==chkimg1==><pre>";
                print_r($chkimgresp);
                echo "</pre>"; */ //exit();
                
               
               $invalidresp=false;
               
               $errormsgs='';  $fileuploadednames=array(); $errfileAr=array();
               $totalfileposted=0;
               
                if(!empty($chkimgresp))
                {
                        
                        
                        if(array_key_exists('errormsgs',$chkimgresp))
                        {
                                $errormsgs=$chkimgresp['errormsgs'];
                        }
                        
                        if(array_key_exists('errfileAr',$chkimgresp))
                        {
                                $errfileAr=$chkimgresp['errfileAr'];
                        }
                        
                        if(array_key_exists('totalfileposted',$chkimgresp))
                        {
                                $totalfileposted=$chkimgresp['totalfileposted'];
                        }
                        
                }
                
                $resparray=array();
                $resparray['errormsgs']=$errormsgs;
                $resparray['errfileAr']=$errfileAr;
                $resparray['totalfileposted']=$totalfileposted;
                
                return $resparray;
       }
       
        
        
       //************************** upload presskit starts

      //*************16-06 *******************
      
      //*************17-06 *******************
      
      //*************************** upload user image starts*************
         
          public function groupimagesave(Request $request)
        {
          
            
           
           //echo "<pre>"; print_r($_FILES);echo "</pre>";
           //die;
           
           
            $id=0;
            $chkvalidimage=$this->fileisinvalid($request,$id);
              
            $err_resp_msg=''; $respflg=0; $uploadedsuccnames=array(); $user_master_img_db=array();
            $slider_contents=''; $default_image_name='';
              
            $errormsgs=$chkvalidimage['errormsgs'];
            $errfileAr=$chkvalidimage['errfileAr'];
            $totalfileposted=$chkvalidimage['totalfileposted'];
              
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
           
                  //**** image code starts
                       
                       
                       $allowedFileExtAr=array();
                       $allowedFileExtAr[]="jpg";
                       $allowedFileExtAr[]="jpeg";
                       $allowedFileExtAr[]="png";
                       
                       $filecontrolname="image_name";
                       
                      
                       $allowedFileExtSizeAr=array();
                       $allowedFileExtSizeAr['jpg']=(5*1024*1024);
                       $allowedFileExtSizeAr['jpeg']=(5*1024*1024);
                       $allowedFileExtSizeAr['png']=(5*1024*1024);
                       
                       
                       
                       //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                       $allowedFileResolAr=array();
                       
                       $allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
                       $allowedFileResolAr['jpg']=array('min_width'=>537,'min_height'=>507);
                       $allowedFileResolAr['png']=array('min_width'=>537,'min_height'=>507);
                       $func="uploadfile";//validatefile/uploadfile
                       
                       
                       $destinationsourcePath=public_path()."/upload/groupimage/source-file/";                         
                      
                       $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath,$errfileAr) ;
                       
                       
                         //echo "==Imcommonpath=>".$Imcommonpath;
                         //echo "==chkimg1==><pre>";
                         //print_r($chkimgresp);
                         //echo "</pre>";  //exit();
                   
                       if(!empty($chkimgresp))
                       {
                               $errormsgs='';  $fileuploadednames=array();
                               
                               if(array_key_exists('errormsgs',$chkimgresp))
                               {
                                       $errormsgs=$chkimgresp['errormsgs'];
                               }
                               
                               if(array_key_exists('fileuploadednames',$chkimgresp))
                               {
                                       $fileuploadednames=$chkimgresp['fileuploadednames'];
                               }
                               
                               
                               $singleimagename='';$thumbfileName='';
                               
                               if(!empty($fileuploadednames))
                               {
                                       $destinationcommonPath=public_path()."/upload/groupimage/";
                                       
                                       foreach($fileuploadednames as $fileuploadednameAr)
                                       {
                                             
                                              $thumbfileName=$fileuploadednameAr['filenamedata'];
                                               $sourcepathwithimage=$fileuploadednameAr['fileuploadedpath'].$thumbfileName;
                                               
                                                $uploadedsuccnames[]=$thumbfileName;
                                               
                                              
                                               $destinationfilewithPath1=$destinationcommonPath."thumb-big/".$thumbfileName;
                                              //  echo "==destinationfilewithPath1==>". $destinationfilewithPath1; exit();
                                               $width=537;$height=0;//$height=507;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath1,$width,$height);
                                               
                                               $destinationfilewithPath2=$destinationcommonPath."thumb-medium/".$thumbfileName;
                                               $width=208;$height=0;//$height=201;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath2,$width,$height);
                                               
                                               $destinationfilewithPath3=$destinationcommonPath."thumb-small/".$thumbfileName;
                                               $width=52;$height=52;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath3,$width,$height);
                              
                                      
                                      
                                       }
                                       
                                      $singleimagename=$thumbfileName;
                                       
                               }
                               
                      
                       
                       }
                       
                       //**** image code ends
                       
                       
                       //*****  insert into image table starts
                       
                       //$uploadedsuccnames
                       
                       if(!empty($uploadedsuccnames))
                       {
                              $user_id=0;
                              if ($request->session()->has('front_id_sess'))
                              {
                                      $user_id=$request->session()->get('front_id_sess'); // get session
                                      $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$user_id."'";
                                      $GroupName = DB::select( DB::raw($sqlGroupName));
                                      $group_id = $GroupName[0]->id;
                              
                              }
                              
                              
                        
                              foreach($uploadedsuccnames as $user_image_name)
                              {
                                    $default_status=0;
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 starts
                                          $selectstr=" umtb.* ";
                                          
                                          $user_master_img_db=DB::table('group_master_img as umtb');              
                                          $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                                          $user_master_img_db=$user_master_img_db->where('umtb.g_creator_id', $user_id); //	group_id
                                          $user_master_img_db=$user_master_img_db->where('umtb.group_id', $group_id);
                                          $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                                          $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                                          $user_master_img_db=$user_master_img_db->get();
                                          
                                          if(!empty($user_master_img_db))
                                          {
                                                $default_status=0;
                                          }
                                          else
                                          {
                                                $default_status=1;
                                          }
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 ends
                                    
                                               
                                    $user_img_array=array();
                                  
                                    $user_img_array['default_status']=$default_status;
                                    $user_img_array['image_name']=addslashes($user_image_name);
                                    $user_img_array['g_creator_id']=$user_id;
                                    $user_img_array['group_id']=$group_id;
                                    $user_img_array['create_date']=date('Y-m-d H:i:s');
                                    $user_img_array['modified_date']=date('Y-m-d H:i:s'); 
                                    $chkupd= DB::table('group_master_img')->insert($user_img_array );
                                    $last_insert_id=DB::getPdo()->lastInsertId();
                                    
                                    //***** update other image of this user to 0 starts
                                    
                                    //$updtusrmstr= DB::table('user_master_img');
                                    //$updtusrmstr= $updtusrmstr->where('id',"<>",$last_insert_id) ;
                                    //$updtusrmstr= $updtusrmstr->where('user_id',$user_id) ;
                                    //$updtusrmstr=$updtusrmstr->update(
                                    //['default_status' =>0]
                                    //);
                                    
                                    //***** update other image of this user to 0 ends
                                    
                                    
                              }
                              
                              //*** fetch this user related images starts
                              
                
                              $selectstr=" umtb.* ";
                             
                              $user_master_img_db=DB::table('group_master_img as umtb');              
                              $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                              $user_master_img_db=$user_master_img_db->where('umtb.g_creator_id', $user_id); //	group_id
                              $user_master_img_db=$user_master_img_db->where('umtb.group_id', $group_id);
                              $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                              $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                              $user_master_img_db=$user_master_img_db->get();
                              
                              if(!empty($user_master_img_db))
                              {
                                    
                                     $default_image_name= $user_master_img_db[0]->image_name;       
                              }
                              
                              //*** fetch this user related images ends
                              
                              $dataresp=array();
                              $view_obj = View::make('front.group_new.editgroupsilder', array("user_master_img_db"=>$user_master_img_db));
                              $slider_contents = $view_obj->render();  

                       }
                       
                       
                       //*****  insert into image table ends
                       
                       
            
            }
            else
            {
                   if(!empty($id))
                        {
                              
                              //return redirect(ADMINSEPARATOR.'/banneradd/'.$id)
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                             $err_resp_msg= $errormsgs;
                              
                        }
                        else
                        {
                              //return redirect(ADMINSEPARATOR.'/banneradd')
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                                $err_resp_msg= $errormsgs;
                        }
            }
            
            
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
                  $respflg=1;
              }
            
            
            
            
            $respAr=array();
            $respAr['flag']=$respflg;
            $respAr['errorespmsg']=$err_resp_msg;
            $respAr['errfileAr']=$errfileAr;
            $respAr['totalfileposted']=$totalfileposted;
            $respAr['uploadedsuccnames']=$uploadedsuccnames;
            $respAr['slider_contents']=$slider_contents;
            $respAr['default_image_name']=$default_image_name;
            //$respAr['user_master_img_db']=$user_master_img_db;
           //  $respAr['chkimgresp']=$chkimgresp;
            echo json_encode($respAr);
           
          
          
      }
      
      
      public function fileisinvalid($request,$addeditid=0)
       {
               
                // echo "<pre>";    print_r($request); exit();
                
                
                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="jpg";
                $allowedFileExtAr[]="jpeg";
                $allowedFileExtAr[]="png";
                
                $filecontrolname="image_name";
                
               
				$allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['jpg']=(5*1024*1024);
				$allowedFileExtSizeAr['jpeg']=(5*1024*1024);
                $allowedFileExtSizeAr['png']=(5*1024*1024);
				
				
				
				//max_width & max_height ,min_width &  min_height,equal_width & equal_height  
				$allowedFileResolAr=array();
				
				$allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
				$allowedFileResolAr['jpg']=array('min_width'=>537,'min_height'=>507);
                $allowedFileResolAr['png']=array('min_width'=>537,'min_height'=>507);
                $func="validatefile";//validatefile/uploadfile
                
                
                $destinationsourcePath=public_path()."/upload/groupimage/source-file/";                       
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$destinationsourcePath,$errfileAr=array()) ;
                       
                
                
                
               
               /* echo "==chkimg1==><pre>";
                print_r($chkimgresp);
                echo "</pre>"; */ //exit();
                
               
               $invalidresp=false;
               
               $errormsgs='';  $fileuploadednames=array(); $errfileAr=array();
               $totalfileposted=0;
               
                if(!empty($chkimgresp))
                {
                        
                        
                        if(array_key_exists('errormsgs',$chkimgresp))
                        {
                                $errormsgs=$chkimgresp['errormsgs'];
                        }
                        
                        if(array_key_exists('errfileAr',$chkimgresp))
                        {
                                $errfileAr=$chkimgresp['errfileAr'];
                        }
                        
                        if(array_key_exists('totalfileposted',$chkimgresp))
                        {
                                $totalfileposted=$chkimgresp['totalfileposted'];
                        }
                        
                }
                
                $resparray=array();
                $resparray['errormsgs']=$errormsgs;
                $resparray['errfileAr']=$errfileAr;
                $resparray['totalfileposted']=$totalfileposted;
                
                return $resparray;
       }
       
       
       
       
         
         //************************** upload group image  ends
         
         
         
         //************************** upload group image  start
         
       public function groupimagedelete(Request $request)
        {
            // imagename   firstimageflag imageid
            $imagename= addslashes(trim($request->input('imagename','')));
            $firstimageflag= addslashes(trim($request->input('firstimageflag','')));
            $imageid= addslashes(trim($request->input('imageid','')));
            
            $flag_dta=0;$slider_contents='';$error_message='';
            $user_id=0;$default_image_name='';
            if ($request->session()->has('front_id_sess'))
            {
                    $user_id=$request->session()->get('front_id_sess'); // get session
                    $sqlGroupName="SELECT `id`,`nickname`,`seo_name` FROM `group_master` WHERE `creater_id`='".$user_id."'";
                    $GroupName = DB::select( DB::raw($sqlGroupName));
                    $group_id = $GroupName[0]->id;
            
            }
            
            
            //*** fetch this user related image starts                              
                
            $selectstr=" umtb.* ";
           
            $user_master_img_db=DB::table('group_master_img as umtb');              
            $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));
            $user_master_img_db=$user_master_img_db->where('umtb.g_creator_id', $user_id); //	group_id
            $user_master_img_db=$user_master_img_db->where('umtb.group_id', $group_id);
            $user_master_img_db=$user_master_img_db->where('umtb.id', $imageid);
            $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
            
           // $user_master_img_db = $user_master_img_db->skip(0)->take(6);
            //$user_master_img_db=$user_master_img_db->get();
            $user_master_img_db=$user_master_img_db->first();
            
            $image_name='';
            
            if(!empty($user_master_img_db))
            {
                  $image_name=$user_master_img_db->image_name;
            }
            
            //*** fetch this user related image ends
           
           $ar=DB::table('group_master_img')->where('id', '=', $imageid)->delete();
         
           
           if($ar>0)
           {
            
                          //***** unlink image starts
                        $destinationcommonPath=public_path()."/upload/groupimage/source-file/".$image_name;
                        $destinationcommonPath2=public_path()."/upload/groupimage/thumb-small/".$image_name;
                        $destinationcommonPath3=public_path()."/upload/groupimage/thumb-medium/".$image_name;
                        $destinationcommonPath4=public_path()."/upload/groupimage/thumb-big/".$image_name;
                        
                        @unlink($destinationcommonPath);
                        @unlink($destinationcommonPath2);
                        @unlink($destinationcommonPath3);
                        @unlink($destinationcommonPath4);
                        
                        //***** unlink image ends
                        
                        
                   $flag_dta=1;  
                   
                  if($firstimageflag==1) // if default image has been deleted
                  {
                        
                      
                        //*** fetch new first id of image of this user to update its default_status to 1 starts                              
                        
                        $selectstr=" umtb.* ";
                        
                        $user_master_img_db=DB::table('group_master_img as umtb');              
                        $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                        $user_master_img_db=$user_master_img_db->where('umtb.g_creator_id', $user_id); //	group_id
                        $user_master_img_db=$user_master_img_db->where('umtb.group_id', $group_id);
                        $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                        $user_master_img_db = $user_master_img_db->skip(0)->take(1);
                        $user_master_img_db=$user_master_img_db->first();
                        
                        $new_frst_img_id=0;
                        
                        if(!empty($user_master_img_db))
                        {
                              $new_frst_img_id=$user_master_img_db->id;
                        }
                        
                        if(!empty($new_frst_img_id))
                        {
                              //*** update code default_status to 1 starts
                              
                              $chkupd= DB::table('group_master_img')->where('id',$new_frst_img_id) ->update(
                              ["default_status" =>1,"modified_date"=> date("Y-m-d H:i:s") ]
                              );
                              
                             
                              
                              //*** update code default_status to 1 ends
                        }
                  }
                              
                  //***** now get image slider data starts 
                  
                 
                              //*** fetch this user related images starts                              
    
                              $selectstr=" umtb.* ";
                             
                              $user_master_img_db=DB::table('group_master_img as umtb');              
                              $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                              $user_master_img_db=$user_master_img_db->where('umtb.g_creator_id', $user_id);
                              $user_master_img_db=$user_master_img_db->where('umtb.group_id', $group_id);
                              $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                              $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                              $user_master_img_db=$user_master_img_db->get();
                              
                              if(!empty($user_master_img_db))
                              {
                                    $default_image_name=$user_master_img_db[0]->image_name;
                                             
                              }
                              
                              //*** fetch this user related images ends
                              
                              $dataresp=array();
                              $view_obj = View::make('front.group_new.editgroupsilder', array("user_master_img_db"=>$user_master_img_db));
                              $slider_contents = $view_obj->render();  
                  
                  
                  //***** now get image slider data starts  
                        
                        
                        
                        
                        //*** fetch new first id of image of this user to update its default_status to 1 ends 
              
                     
           }
           
           if($flag_dta==0)
           {
                  $error_message=" Sorry image \"".$imagename."\" cannot be deleted ";
           }
           
           $respAr=array();
           $respAr['flag_status']=$flag_dta;
           $respAr['error_message']=$error_message;
           $respAr['slider_contents']=$slider_contents;
           $respAr['default_image_name']=$default_image_name;
           echo json_encode($respAr);
            
        }
      
      //************************** upload group image  start

      //*************17-06 *******************
      
     //*************22-06 start *******************
     
     
     
     //*************get seo_name strats here
    public function getseo_name($id){
                   $seoqry = DB::table('venue_master')
                             ->where('creater_id',$id)
                             ->select('*')
                             ->first();
                             return $seoqry->id;
    }
    //************get nick name ends here
        
      //**************common function to check the group is created first time or not starts here
      public function check_modifying_date($venueID,$usrID)
      {
                 $seoqry = DB::table('group_master')
                             ->where('creater_id',$usrID)
                             ->where('id',$venueID)
                             ->select('modified_date')
                             ->first();
                             $rtmodify = $seoqry->modified_date;
                             if($rtmodify == '0000-00-00 00:00:00')
                             {
                                      return 1; 
                             }else
                             {
                                      return 2; 
                             }
      }
     //**************common function to check the group is created first time or not starts here
     //*********get nick name starts here
     public function getnicknm($venueID,$usrID)
     {
                    $nicknmqry = DB::table('group_master')
                             ->where('creater_id',$usrID)
                             ->where('id',$venueID)
                             ->select('seo_name')
                             ->first();
                             $rtseo_name = $nicknmqry->seo_name;
                           //  echo $rtseo_name;die;
                             return $rtseo_name;
     }
     //*********get seo_name ends here
     
     
     
     //*********custom function starts here
     
     public function vaildtgroupnicknm($request,$id){
                   $usrnm = trim($request->input('seo_name'));
                   $output = preg_replace('!\s+!', ' ', $usrnm);
                   $chkID =0;
                   $qry = DB::table('group_master')
                   ->where('nickname',$output)
                   ->where('id', '<>', $id)
                   //->select('*')
                   ->first();
                   if($qry){
                   $chkID = $qry->id;
                   }
                   //echo  $id;//die;
                   return $chkID;
                   
     }
     //*********custom function ends here
     //*************22-06 end *********************
     
     //***************26-06-start*******************
     
     function groupprofilesubmit(Request $request){
                    
                    //***************upadate in 24th august 2016 for lock concept start ************//
                    $security_lock_id = $request->input('security_lock_id');
                    $booking_lock_id = $request->input('booking_lock_id');
                    $totalpay_lock_id = $request->input('totalpay_lock_id');
                    $gig_description = $request->input('gig_description');
         
                    $asd_lock_id = '0';
                    $ta_lock_id = '0';
                    $bcf_lock_id = '0';
                    if($security_lock_id!=''){
                      $asd_lock_id = $security_lock_id;
                    }
                    if($totalpay_lock_id!=''){
                      $ta_lock_id = $totalpay_lock_id;
                    }         
                    
                    if($booking_lock_id!=''){
                      $bcf_lock_id = $booking_lock_id;
                    }
                    
                    //***************upadate in 24th august 2016 for lock concept end ************//
                    //die("dD asd_lock_id".$asd_lock_id." ta_lock_id ".$ta_lock_id." bcf_lock_id ".$bcf_lock_id);

                    $artist_id = $request->input('artist_id');
                    $type_flag = $request->input('type_flag');
                    $creater_id = $request->input('creater_id');
                    $address1val =  $request->input('address1val');
                    $address2val =  $request->input('address2val');
                    $countrydata =  $request->input('countrydata');
                    $statelistdata =  $request->input('statelistdata');
                    $city =  $request->input('towndata');
                    $zipdata=  $request->input('zipdata');
                    $bookingcat_subdata =  $request->input('bookingcat_subdata');
                    $bookinggenre_subdata =  $request->input('bookinggenre_subdata');
                    $security_paymentdata =  $request->input('security_paymentdata');
                    $start_timedata =  $request->input('start_timedata');
                    $end_timedata =  $request->input('end_timedata');
                    $requestexpireddatedata =  $request->input('requestexpireddatedata');
                    $requestexpiredtimedata =  $request->input('requestexpiredtimedata');
                    
                    $total_paymentdata =  $request->input('total_paymentdata');
                    $cancellation_paymentdata =  $request->input('cancellation_paymentdata');
                    $booking_datedata =  $request->input('booking_datedata');
                    $type_entry = $request->input('type_entry');


                    $endtimedtval = $request->input('endtimedt');
                    $enddate= explode("/",$endtimedtval);
                    $endtimedt = $enddate[2].'-'.$enddate[1].'-'.$enddate[0];




                    $chkvalid=$this->checksavebookingrequest($request);
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

                    $unicId = "GIG-".uniqid();
                    
                    $crdt = date('Y-m-d H:i:s');
    
                    //*****convert time into mysql format starts here
                    
                    //*********booking request date time
                    $ttt= explode("/",$booking_datedata);
                    $bkngdate = $ttt[2].'-'.$ttt[1].'-'.$ttt[0];
                    
                    $r =  date("G:i", strtotime($start_timedata));
                    $strttim = date('H:i:s',strtotime($r));
                    
                    $r1 =  date("G:i", strtotime($end_timedata));
                    $endtim = date('H:i:s',strtotime($r1));
                    
                    //$reqt= explode("/",$requestexpireddatedata);
                    //$bkngexpirdate = $reqt[2].'-'.$reqt[1].'-'.$reqt[0];
                    //
                    //$r2 =  date("G:i", strtotime($requestexpiredtimedata));
                    //$expirtim = date('H:i:s',strtotime($r2));
                    //
                    //$bokingexpired = $bkngexpirdate.' '.$expirtim;
                    
                    $sess_id = $request->session()->get('front_id_sess');
                    $returnArray = array();
                    
                    if($sess_id!=''){

                    //$getgiguniqueidcount = DB::table('gig_master')->where('giguniqueid',$unicId)->count();
                    //if($getgiguniqueidcount=='0'){
                    //     $unicId = $unicId;               
                    //}else{
                    //     $unicId = $unicId."1";
                    //}
                    
                    
                    //********************checking group active or deactive********************//
                       $artist_id_checking = DB::table('group_master')->where('id',$artist_id)->first();
                       $profilealias = $artist_id_checking->nickname;
                       if($artist_id_checking->status=='1')
                       {
                                        //*************04-07-2016 start expdate*************//
                                        if($requestexpireddatedata!=''){
                                        $reqt= explode("/",$requestexpireddatedata);               
                                        $bkngexpirdate = $reqt[2].'-'.$reqt[1].'-'.$reqt[0];
                                        
                                        $r2 =  date("G:i", strtotime($requestexpiredtimedata));
                                        $expirtim = date('H:i:s',strtotime($r2));
                                        $bokingexpired = $bkngexpirdate.' '.$expirtim;    
                                        }else{
                                        $bkngstartdatetime = $bkngdate." ".$strttim;
                                        //$bokingexpired = date('Y-m-d h:i:s A',strtotime('-4 hours', strtotime($bkngstartdatetime)));
                                        $bkngexpirdate = date('Y-m-d',strtotime('-4 hours', strtotime($bkngstartdatetime)));
                                        $expirtim1 = date('h:i:s A',strtotime('-4 hours', strtotime($bkngstartdatetime)));
                                        $expirtim = date('H:i:s',strtotime(date("G:i", strtotime($expirtim1))));
                                        $bokingexpired = $bkngexpirdate." ".$expirtim;
                                        }
                                        //*************04-07-2016 end expdate*************//
                                        //****************insert into gig_master table***********//
                                        $Insertgig_master = array(
                                        //'giguniqueid' => $unicId,
                                        'gigpostrequestflag'=>'2',
                                        'event_type'=>$type_entry,
                                        'type_flag'=>$type_flag,
                                        'artist_id'=>$artist_id,
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
                                        'event_start_date_time'=>$bkngdate." ".$strttim,//2016-06-22 09:26:28
                                        'event_end_date_time'=>$endtimedt." ".$endtim,
                                        'event_end_date'=>$endtimedt,
                                        'event_end_time'=>$endtim,
                                        'request_expire_date'=>$bkngexpirdate,
                                        'request_expire_time'=>$expirtim,
                                        'request_expire_datetime'=>$bokingexpired,
                                        'booking_req_date'=>$crdt,
                                        'event_timezone'=>$final_timezone,
                                        'booking_status'=>'2',
                                        'booking_cancellation_fee'=>$cancellation_paymentdata,
                                        'artist_security_deposit'=>$security_paymentdata,
                                        'total_amount'=>$total_paymentdata,
                                        //***************upadate in 24th august 2016 for lock concept start ************//
                                        'ta_lock_id'=>$ta_lock_id,
                                        'asd_lock_id'=> $asd_lock_id,
                                        'bcf_lock_id'=> $bcf_lock_id,
                                        //***************upadate in 24th august 2016 for lock concept end ************//
                                        'gig_description' => $gig_description
                                        );
                                        //echo  json_encode($Insertgig_master); die;
                                        $LastInsertedId = DB::table('gig_master')->insertGetId($Insertgig_master);
                                        
                                        //************ creat new gig_unique id start**********//
                                        $appenduniqiddata=100000+$LastInsertedId;
                                        $update_gig_master['giguniqueid']="EVE-G".$appenduniqiddata;
                                        $is_gig_master = DB::table('gig_master')->where('id',$LastInsertedId)->update($update_gig_master); 
                                        //************ creat new gig_unique id end**********//
         
                                        //****************sending mail start**************//
                                        
                                        $senderdetail = DB::table('user_master')
                                        ->select('first_name','middle_name','last_name','email')
                                        ->where('id', $creater_id)
                                        ->get();
                                        $sender_name = $senderdetail[0]->first_name." ".$senderdetail[0]->middle_name." ".$senderdetail[0]->last_name;
                                        $sender_email = $senderdetail[0]->email;
                                        $sender_name = $senderdetail[0]->first_name." ".$senderdetail[0]->middle_name." ".$senderdetail[0]->last_name;
                                        $artistvenuegroupfirstname = $senderdetail[0]->first_name;
                                        $artistvenuegrouplastname = $senderdetail[0]->last_name;

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
                                        //*************fetching skill end************//
                                        //************fetching subskill**********//
                                        $subskilldetail = DB::table('skill_master')
                                        ->select('name')
                                        ->where('id', $bookinggenre_subdata)
                                        ->get();
                                        //************fetching subskill end**********//
                                        $data['Insertgig_master']=$Insertgig_master;
                                        
                                        $data['senderdetail']=$sender_name;
                                        $data['bookerdetail']=$booker_email;
                                        $Emailskill=$skilldetail[0]->name;
                                        $Emailsubskill=$subskilldetail[0]->name;
                                        $EmailWhen1 = $bkngdate." ".$strttim;
                                        //$Newdate = date("jS F,Y h:i a", strtotime($EmailWhen));
                                        $Newdate = date("jS F Y ", strtotime($EmailWhen1));
                                        $Newtime = date("h:i A", strtotime($EmailWhen1));
                                        $EmailWhen = $Newtime." on ".$Newdate;
                                        
                                        
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

                                        

                                       
                                        
                                        $replacefrom =array('{Accountfname}','{Accountlname}','{ARGRPVNU}','{PROFILEALIAS}','{add1}','{add2}','{City}','{Zip}','{State}','{Counrty}','{User}','{WHO}','{SKILL}','{SUBSKILL}','{WHEN}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{ExpiryDate}","{ExpiryTime}");
                                        $replaceto =array(ucfirst($artistvenuegroupfirstname),ucfirst($artistvenuegrouplastname),'Group',$profilealias,ucfirst($address1val),ucfirst($address2val),$city,$zipdata,$state_name,$country_name,ucfirst($sender_name),ucfirst($booker_name),$Emailskill,$Emailsubskill,$EmailWhen,$sitename,$copyright_year,$bsurl,$logoIMG,$bkngexpirdate,$expirtim);
                                        mailsnd($Temid=12,$replacefrom,$replaceto,$sender_email);
                                        
                                        $replacefrom =array('{Accountfname}','{User}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                        $replaceto =array(ucfirst($bookerdetail[0]->first_name),ucfirst($booker_name),$sitename,$copyright_year,$bsurl,$logoIMG);
                                        
                                        //mailsnd($Temid=12,$replacefrom,$replaceto,$booker_email);
                                        mailsnd($Temid=13,$replacefrom,$replaceto,$booker_email);
                                        
                                        $data['from']=$replacefrom;
                                        $data['sender_mail']=$sender_email;
                                        $data['to']=$replaceto;
                                        //*********Helper Function Ends here
                                        
                                        //****************sending mail end****************//
                                        
                                        //****************insert into gig_notify table***********//
                                        $Insertgig_notify = array(
                                        'gigmaster_id'=>$LastInsertedId,
                                        'member_id'=>$artist_id,
                                        'booker_id'=>$sess_id,
                                        'type_flag'=>2,
                                        'gigpostrequestflag'=>2,
                                        'create_date'=>date('Y-m-d H:i:s'),
                                        'modified_date'=>date('Y-m-d H:i:s'),
                                        'status'=>'1'
                                        );
                                        $isInsertedId = DB::table('gig_notify')->insert($Insertgig_notify);//insertGetId
                                        //***************insert into gig_skill_rel table***********//
                                        $Insertgig_skill_rel = array(
                                        'gigmaster_id'=>$LastInsertedId,
                                        'category'=>$bookingcat_subdata,
                                        'genre'=>$bookinggenre_subdata,
                                        'type_flag'=>2,
                                        'create_date'=>date('Y-m-d H:i:s')
                                        );
                                        $isInsertedId = DB::table('gig_skill_rel')->insert($Insertgig_skill_rel);//insertGetId
                                        $returnArray['flagdata'] = '1';
                                        $returnArray['message'] = 'Booking request posted successfully.';
                                        }else{
                       $returnArray['flagdata'] = '02';
                       $returnArray['message'] = 'This group is already inactive';
                                        }
                       }else{
                       $returnArray['flagdata'] = '02';
                       $returnArray['message'] = 'User needs to login first';
                       }
                    }else{
                       $returnArray['flagdata'] = '02';
                       $returnArray['message'] = 'Please enter proper address';
                    }
                    //print_r($latlog);die;
                    
                    }
                    else
                    {                 
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
                    
                    echo  json_encode($returnArray);
                    
     }
     //***************26-06-end*********************
     
     //***************29-06-start ******************
             function groupbookingoptionssaveajx(Request $request){
         
                    $typeEvent = addslashes(trim($request->input('typeEvent','')));
                    $typeEvent = ($typeEvent=="Available For")?"":$typeEvent;
                    
                    $bookingfrom = addslashes(trim($request->input('bookingfrom','')));
                    $bookingfrom = ($bookingfrom=="Bookings From")?"":$bookingfrom;
                    
                    $hourly_rate = addslashes(trim($request->input('hourly_rate','')));
                    $security_deposit = addslashes(trim($request->input('security_deposit','')));
                    
                    $setuptime = addslashes(trim($request->input('setuptime','')));
                    $setuptime = ($setuptime=="Set-up Time")?"":$setuptime;
                    
                    $packuptime = addslashes(trim($request->input('packuptime','')));
                    $packuptime = ($packuptime=="Pack-up Time")?"":$packuptime;
                    
                    $tech_spec = addslashes(trim($request->input('tech_spec','')));
                    
                    $chkvalid=$this->checksavebookingoptions($request);
                    $flag_id = 0;
                    if($chkvalid===true)
                    {
                                        
                                //*** save data of user starts
                                $userid=0;
                                if ($request->session()->has('front_id_sess'))
                                {
                                            $userid=$request->session()->get('front_id_sess'); // get session
                                            $sqlGroupName="SELECT * FROM `group_master` WHERE `creater_id`='".$userid."'";
                                            $GroupName = DB::select( DB::raw($sqlGroupName));
                                            $group_id = $GroupName[0]->id;
                                            
                                }
                    $updateArray = array(
                          'available_for' => $typeEvent ,
                          'booking_from' => $bookingfrom ,
                          'rate_amount' => $hourly_rate ,
                          'security_figure' => $security_deposit ,
                          'setup_time' => $setuptime ,
                          'packup_time' => $packuptime ,
                          'tech_spec' => $tech_spec ,
                          'modified_date' => date('Y-m-d H:i:s')
                    );
                     
                                //*** update user_master table starts
                                $chkupd= DB::table('group_master')->where('id',$group_id) ->update($updateArray);
                                //*** update user_master table ends
                                if(!empty($chkupd))
                                {
                                            $flag_id=1;                            
                                }
                                //*** save data of user ends
                    }
                    else
                    {                 
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
                    }
                    $responseAr['flag_id']=$flag_id;
                    $responseAr['error_message']=$error_msgAr;
                    echo json_encode($responseAr);

            }
            public function checksavebookingoptions($request,$id=0)
            {
                        $validator = Validator::make($request->all(), [
                                    "typeEvent" => "required",
                                    "bookingfrom" => "required",
                                    "hourly_rate" => "required",
                                    "security_deposit" => "required",
                                    "setuptime" => "required",
                                    "packuptime" => "required",
                                    //"tech_spec" => "required",
                        ],[
                                    "typeEvent.required" => "Event type data is required",
                                    "bookingfrom.required" => "Booking from data is required",
                                    "hourly_rate.required" => "Hourly rate data is required",
                                    "security_deposit.required" => "Security deposit data is required",
                                    "setuptime.required" => "Set-up time data is required",
                                    "packuptime.required" => "Pack-up time data is required",
                                    //"tech_spec.required" => "Tech spec data is required",
                        ]);
                        
                        $userData=array();
                        $userData['request']=$request;
                        
                        $validator->after(function($validator)  use ($userData)  { 
                                    $request=$userData['request'];
                                    
                                    $hourly_rate = addslashes($request->input('hourly_rate'));
                                    $security_deposit = addslashes($request->input('security_deposit'));
		   
                                    if($hourly_rate!='')
                                    {		 
                                                $validatehourlyratechk=$this->chkvalidhourlyrate($hourly_rate);
                                                if (!empty($validatehourlyratechk))
                                                {
                                                         $validator->errors()->add('hourly_rate', $validatehourlyratechk);   
                                                }
                                    }
				
                                    if($security_deposit!='')
                                    {		 
                                                $validatesecuritydepositchk=$this->chkvalidsecuritydeposit($security_deposit);
                        
                                                if (!empty($validatesecuritydepositchk))
                                                {
                                                         $validator->errors()->add('security_deposit', $validatesecuritydepositchk);  
                                                }
                                    }
                                     if($hourly_rate!='' && $security_deposit!='')
                                    {
                                        $validatechk=$this->chkvalidrules($hourly_rate,$security_deposit); 
                                        if (!empty($validatechk))
                                                {
                                                         $validator->errors()->add('security_deposit', $validatechk);  
                                                }
                                        
                                    }
                        });
                        
                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            
            public function chkvalidrules($hourly_rate,$security_deposit)
            {
                        $errorMsg=array();
                        if ($security_deposit > $hourly_rate)
                        //if($hourly_rate<=0)
                        {
                                    $errorMsg[]="Security deposit should not greater than total price";
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
            
            public function chkvalidhourlyrate($hourly_rate)
            {
                        $errorMsg=array();
                        if (!preg_match('/^([0-9]*){0,}(\.\d{1,2})?$/', $hourly_rate))
                        //if($hourly_rate<=0)
                        {
                                    $errorMsg[]=" Hourly rate field cannot have negative value and can take only numeric value upto two decimal points";
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
	   
            public function chkvalidsecuritydeposit($security_deposit)
            {
                        $errorMsg=array();
                        if (!preg_match('/^([0-9]*){0,}(\.\d{1,2})?$/', $security_deposit))
                        //if($security_deposit<=0)
                        {
                                    $errorMsg[]=" Security deposit field cannot have negative value and can take only numeric value upto two decimal points";
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
     //***************29-06-end ******************
     //*************** 30-06-start ****************
            public function checksavebookingrequest($request){
                    $validator = Validator::make($request->all(), [
                                "address1val" => "required",
                                "countrydata" => "required",
                                "statelistdata" => "required",
                                "towndata" => "required",
                                "zipdata" => "required|numeric",
                                "bookingcat_subdata" => "required",
                                "bookinggenre_subdata" => "required",
                                "security_paymentdata" => "required",
                                // "start_timedata" => "required",
                                // "end_timedata" => "required",
                                //"requestexpireddatedata" => "required",//requestexpireddatedata
                                "total_paymentdata" => "required",
                                "cancellation_paymentdata" => "required",
                                "booking_datedata" => "required",
                                "gig_description" => "required|max:250",
                    ],[
                                "address1val.required" => "First address is required",
                                "countrydata.required" => "Country field is required",
                                "statelistdata.required" => "State field is required",
                                "towndata.required" => "Town field is required",
                                "zipdata.required" => "Zip field is required",
                                "zipdata.numeric" => "Zip field is must be umeric",
                                "bookingcat_subdata.required" => "Booking category field is required",
                                "bookinggenre_subdata.required" => "Booking genre field is required",
                                "security_paymentdata.required" => "Security Paymentdata field is required",
                                // "start_timedata.required" => "Start timedata field is required",
                                // "end_timedata.required" => "End time field is required",
                                //"requestexpireddatedata.required" => "Request expire field is required",
                                "total_paymentdata.required" => "Total payment field is required",
                                "cancellation_paymentdata.required" => "Cancellation payment field is required",
                                "booking_datedata.required" => "Start date field is required",
                                "gig_description.required" => "Gig description in required",
                                "gig_description.max" => "Gig description not more than 250",
                    ]);
                    
                    //***********************Add more validation start 01-07-2016**********************
                    
                        $userData=array();
                        $userData['request']=$request;
                        
                        $validator->after(function($validator)  use ($userData)  { 
                                    $request=$userData['request'];
                                    
                                    $booking_datedata = addslashes($request->input('booking_datedata'));
                                    $start_timedata = addslashes($request->input('start_timedata'));
                                     $end_timedata = addslashes($request->input('end_timedata'));
                                    //$artist_ID = $request->input('artistID');
                                    $artist_ID = $request->input('artist_id');
                                    $sess_id = $request->session()->get('front_id_sess');

                                    $endtimedtval = $request->input('endtimedt');
                                    $enddate= explode("/",$endtimedtval);
                                    $endtimedt = $enddate[2].'-'.$enddate[1].'-'.$enddate[0];
       
                                    if($booking_datedata!='' && $start_timedata!='' && $artist_ID!='' && $sess_id!='')
                                    {    
                                                $validatehourlyavaiability=$this->chkvalidavailability($booking_datedata,$start_timedata,$artist_ID,$sess_id);
                                                if (!empty($validatehourlyavaiability))
                                                {
                                                         $validator->errors()->add('booking_datedata', $validatehourlyavaiability);   
                                                }
                                                 $validateduplicacy=$this->chkduplicacy($booking_datedata,$endtimedt,$start_timedata,$artist_ID,$sess_id,$end_timedata);
                                                if (!empty($validateduplicacy))
                                                {
                                                         $validator->errors()->add('booking_datedata', $validateduplicacy);   
                                                }
                                                //********this is for duplicate checking ends here
                                    }
        
                                    
                        });
                    
                    //***********************Add more validation end**********************
                    if ($validator->fails())
                    {
                        return $validator;
                    }
                    return true;
            }
     //*************** 30-06-end ******************
     //*************** 01-07-start ****************

            public function chkvalidavailability($booking_datedata,$start_timedata,$artist_ID,$sess_id)
            {
                      


            $ttt= explode("/",$booking_datedata);
            $bkngdate = $ttt[2].'-'.$ttt[1].'-'.$ttt[0];

            $r =  date("G:i", strtotime($start_timedata));
            $strttim = date('H:i:s',strtotime($r));
            $bookingdatetime = $bkngdate." ".$strttim; //date('Y-m-d H:i:s',strtotime($booking_datedata.' '.$start_timedata));
            $bookingdatetime_chk = date('Y-m-d H:i:s',strtotime($bookingdatetime)); 


            $match_date_qry = DB::table('gig_master')
                               ->where('event_start_date_time','<=',$bookingdatetime_chk)
                                ->where('event_end_date_time','>=',$bookingdatetime_chk)
                                 ->where('booking_status','1')
                                ->where('artist_id',$artist_ID)
                                ->first();

            $count_bookingavailable =  count($match_date_qry);
                        $errorMsg=array();
                     
                        if ($count_bookingavailable > 0)
                        {
                                    $errorMsg[]="Your booking request can not be processed please select another date time";
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
            
            public function chkduplicacy($booking_datedata,$endtimedt,$start_timedata,$artist_ID,$sess_id,$end_timedata)
            {

                                        $ttt= explode("/",$booking_datedata);
                                        $bkngdate = $ttt[2].'-'.$ttt[1].'-'.$ttt[0];

                                        $r =  date("G:i", strtotime($start_timedata));
                                          $strttim = date('H:i:s',strtotime($r));

                                        $bookingdatetime = $bkngdate." ".$strttim; //date('Y-m-d H:i:s',strtotime($booking_datedata.' '.$start_timedata));
                                        $et=date("G:i", strtotime($end_timedata));
                                        $enddatetime = date('H:i:s',strtotime($et));
                                        $endbookingdatetime = $endtimedt." ".$enddatetime;
                                        
                                        $bookingdatetime_chk = date('Y-m-d H:i:s',strtotime($bookingdatetime)); 
                                        $bookingendtime_chk = date('Y-m-d H:i:s',strtotime($endbookingdatetime)); 

                                         $match_date_qry = DB::table('gig_master')
                                                          // ->where('event_start_date_time',$bookingdatetime_chk)
                                                           ->where('booker_id',$sess_id)
                                                           ->where('artist_id',$artist_ID)
                                                            ->where('event_start_date_time','>=',$bookingdatetime_chk)
                                                             ->where('event_end_date_time','<=',$bookingendtime_chk)
                                                           ->where('type_flag','2')
                                                           ->first();

              // echo "<pre>";
             //  print_r($match_date_qry);
              // die();

                                              $count_bookingavailable =  count($match_date_qry);
                                              // die;

                                              $errorMsg=array();

                                              if ($count_bookingavailable > 0)
                                              {
                                              $errorMsg[]="Your booking request can not be processed at this moment<br> You have already booked this artist <br> Please select another date time to book this artist";
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
                                              /* echo "<pre>";
                                              print_r($responseAr);die;*/
                                              return $errorMsgStr;
            }
            
            
            
            
            
            
            
            
            
            
            
            
     //*************** 01-07-end ******************
}