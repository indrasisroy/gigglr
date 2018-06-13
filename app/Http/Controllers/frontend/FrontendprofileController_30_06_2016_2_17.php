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

class FrontendprofileController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    
     public function index(Request $request)
    {
             $sessnID =  $request->session()->get('front_id_sess');
                        $uu = $request->segment(2);
                        $query = DB::table('user_master')->select('seo_name')->get();
                        $user_id = 0;
                        $user_single = DB::table('user_master')->where('seo_name',$uu)->first();
                        if($user_single)
                        {
                                    $user_id = $user_single->id;
                        }
                        else
                        {
                                     $user_id = 0;
                        }

            
                        if($user_id <2 || empty($user_single) || $user_id ==0)
                        {
                                    echo "wrong user";exit();
                        }
                        
                            $data=array(); 
                            $data['data1']="hello";
                       
                           //*************** fetch data of banner starts=======================*************
                            $banner_image='';$display_flag=0;            
                            //*** fetch data of banner ends                
                            
                            //**** fetch basic info of user  starts
                            
                            $fetchtype='single'; $tablename="user_master";
                            $fieldnames=" * ";
                            $wherear=array();
                            $wherear['id']=$user_id;
                            $orderbyfield="id"; $orderbytype="asc";
                            $limitstart=0;$limitend=0;                
                            
                            $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
               //**** fetch skill_master data  starts
                
                $fetchtype='multiple'; $tablename="skill_master";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['catag_type']=1;
                $wherear['parent_id']=0;
                $wherear['status']=1;
                $orderbyfield="name"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchskillmasterdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
                $fetchskillmasterAr=array();
                $fetchskillmasterAr['']="Category for Request";
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



                
                               //********fetch user ratings ***************

                                    $reviewratings  = DB::table('gig_review')
                                    ->where('artistgroupvenue_id',$user_id)
                                    ->get();

                                    $presentation = 0;
                                    $performence = 0;
                                    $puntuality =0;
                                    $presentationardata ='';
                                    $performenceardata='';
                                    $puntualityardata ='';

                                    $totalreviewdata  = count($reviewratings);

                                    foreach($reviewratings as $artistreview)
                                    {
                                       $presentation =  $presentation + $artistreview->presentation;
                                       $performence = $performence + $artistreview->performance;
                                       $puntuality =  $puntuality + $artistreview->punctuality;
                                     
                                    }
                                    if($presentation)
                                    $presentationardata = round($presentation/$totalreviewdata);
                                    if($performence)
                                    $performenceardata =round($performence/$totalreviewdata);
                                    if($puntuality)
                                    $puntualityardata = round($puntuality/$totalreviewdata);


                                      $data['puntualityardata']=$puntualityardata;
                                      $data['performenceardata']=$performenceardata;
                                      $data['presentationardata']=$presentationardata;
               
                              //**************-------------------***************/////////




               
                //**** fetch user_skill_rel data  ends
                
                //*******************************FETCH COUNTRY DATA STARTS HERE 28-05-2016
                $country_db = DB::table('location_country')->where('published','1')->get();
               // $country_result = $country_qry;
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
                $usr_img = DB::table('user_master_img')->where('default_status','1')->where('user_id',$user_id)->get();
                 
               //***************FETCH USER IMAGE ENDS HERE
               
               //********Fetch user review starts here
               
               $userstesti = DB::table('gig_review as grv')
                    ->join('user_master as um', 'grv.booker_id', '=', 'um.id')
                    // ->join('bookers_review as brv', 'erv.id', '=', 'brv.event_review_id')
                                        ->leftJoin('user_master_img as umi', function ($join)
                                        {
                                        $join->on('grv.booker_id', '=', 'umi.user_id')
                                        ->where('umi.default_status','=','1');
                                        })
                                       
                    ->select('grv.*', 'um.first_name', 'um.username','um.nickname','um.city','umi.user_id','umi.image_name','umi.default_status','grv.punctuality','grv.performance','grv.presentation')
                    ->where('grv.artistgroupvenue_id',$user_id)
                    ->get();
              //  $userstesti = array();
                   
                    // echo "<pre>";
                    // print_r($userstesti);
                    // echo "</pre>";die;
               //********Fetch user review ends here
              //*************presskit data starts here
              $presskit = DB::table('user_presskit')->where('user_id',$user_id)->first();
              //*************presskit data ends here
                //*************presskit data starts here
              $presskit = DB::table('user_presskit')->where('user_id',$user_id)->first();
              //*************presskit data ends here
              
              ////***************sum of ratings starts here
              //$total = DB::table('users')->where()->sum('puntuality');
              ////**************sum of ratings ends here


              //**********category and genere start here
              $artistbookingcategory = DB::table('user_skill_rel')
                   ->join('skill_master', 'user_skill_rel.skill_id', '=', 'skill_master.id')
                   ->where('user_skill_rel.user_id', '=', $user_id)
                   ->select('skill_master.*')
                   ->distinct('skill_master.id')
                   ->get();
                   
                   $fetchartistskillAr=array();
                   
                   if(!empty($artistbookingcategory))
                   {
                   foreach( $artistbookingcategory as $fetchskillobj )
                   {
                           $fetchartistskillAr[$fetchskillobj->id]=$fetchskillobj->name;
                   }
                   // echo "<pre>";
                   // print_r($fetchartistskillAr);die;
                   }
              //**********category and genere ends here
                
                
                $data['banner_image']=$banner_image;
                $data['display_flag']=$display_flag;
                $data['fetchuserdata']=$fetchuserdata;
                $data['fetchskillmasterAr']=$fetchskillmasterAr;
                $data['skill_user_db']=$skill_user_db;
                $data['country_result']=$countryidAr;
                $data['artistbooking_skill']=$fetchartistskillAr;
                $data['usr_img']=$usr_img;//usrIMG
                
                $data['user_testi']=$userstesti;//usrIMG
                $data['presskit']=$presskit;//usrIMG
                 $data['artistusr_id'] = $user_id;

                 $data['atrist_sessionID'] = $sessnID;
               return view('front.user.profile', $data);
    }
    public function getstate(Request $request)
    {
          $country =  $request->input('countryid');
          $stateres = DB::table('location_state')->where('country_id',$country)->get();
          //echo "<pre>";
          //print_r($stateres);
          //echo "</pre>";
          //echo $stateres;
          
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
            if($categoryId > 0)
            {
                        $getGenere = DB::table('skill_master')->where('parent_id',$categoryId)->where('status','1')->get();
            }
            $generetypeidAr=array();
           
            if(!empty($getGenere))
            {
                    foreach($getGenere as $getGenereobj)
                    {
                            $generetypeidAr[]=array('id'=>$getGenereobj->id,'name'=>stripslashes($getGenereobj->name));
                    }
                    //$generetypeidAr[]=array('flag'=>'1');
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
            $download_path = ( public_path() . '/upload/press-kit/source-file/' . $filennmdownload );
            return( Response::download( $download_path ) );
          
    }
   //*************download ptresskit starts here
   
   //**********booking complete starts here
   public function completebooking(Request $request)
   {
    //  $getresponseAr=array();
                    
    //  $address1val = addslashes(trim($request->input('address1val')));
    //  $address2val = addslashes(trim($request->input('address2val')));
    //  $countrydata = $request->input('countrydata');
    //  $statelistdata = $request->input('statelistdata');
    //  $towndata = addslashes(trim($request->input('towndata')));
    //  $zipdata = addslashes(trim($request->input('zipdata')));
    //  $bookingcat_subdata = $request->input('bookingcat_subdata');
    //  $bookinggenre_subdata = $request->input('bookinggenre_subdata');
    //  $security_paymentdata = $request->input('security_paymentdata');
    //  $total_paymentdata = $request->input('total_paymentdata');
    //  $cancellation_paymentdata = $request->input('cancellation_paymentdata');
    //  $booking_datedata = $request->input('booking_datedata');
    //  $start_timedata = $request->input('start_timedata');
    //  $end_timedata = $request->input('end_timedata');
    //  $requestexpireddatedata = $request->input('requestexpireddatedata');
    //  $requestexpiredtimedata = $request->input('requestexpiredtimedata');
     
     
     
    //  //********* validation starts here
    //  //$chkvalid=$this->checkbookingform($request,$id);
    //  //********* validation ends here
     
     
     
    //  //*********** get country name and state name starts here
    //  $countrynm = 'country_name';
    //  $statenm = 'state_name';
    //  $tblnm = 'location_country';
    //  $sttbl = 'location_state';
    //  $countryname = $this->getcommondetails($countrydata,$countrynm,$tblnm);
    //  $statename = $this->getcommondetails($statelistdata,$statenm,$sttbl);
    //  //*********** get country name and state name ends here
    //  //*********** Get latlong starts here
    //   $fullBookingAddress = $address1val.' '.$address2val.' '.$towndata.' '.$statename->state_name.' '.$countryname->country_name;
      
    //   $fullBookingAddress = urlencode($fullBookingAddress);
      
    //   $latlog = getLatLong($fullBookingAddress);
      
    //                 $latitude = $latlog['latlong'][0]['latitude'];
    //                 $longitude = $latlog['latlong'][0]['longitude'];
    //                 $TimeZoneCheck = getTimezone($latitude,$longitude);
    //                 $timezoneId = $TimeZoneCheck['timeZoneId'];
    //                 $timezoneName = $TimeZoneCheck['timeZoneName'];
                    
    //  //*********** Get latlong ends here
    
    // //*********current date time
    // $crdt = date('Y-m-d H:i:s');
    
    //  //*****convert time into mysql format starts here
     
    //  //*********booking request date time
    //  $ttt= explode("/",$booking_datedata);
    //  $bkngdate = $ttt[2].'-'.$ttt[1].'-'.$ttt[0];
     
    //  $r =  date("G:i", strtotime($start_timedata));
    //  $strttim = date('H:i:s',strtotime($r));
     
    //  $r1 =  date("G:i", strtotime($end_timedata));
    //  $endtim = date('H:i:s',strtotime($r1));
    // //*********booking request date time
    // //*****convert time into mysql format ends here
   
    
    // //*******request expire date time
    //  $reqt= explode("/",$requestexpireddatedata);
    //  $bkngexpirdate = $reqt[2].'-'.$reqt[1].'-'.$reqt[0];
     
    //  $r2 =  date("G:i", strtotime($requestexpiredtimedata));
    //  $expirtim = date('H:i:s',strtotime($r2));
    
    // $bokingexpired = $bkngexpirdate.' '.$expirtim;
    // //*******request expire date time
    
    //  $inbookingarray = array(
    //                          'artist_id' => '123456',
    //                          'booker_id' => '1234',
    //                          'event_address1' =>$address1val,
    //                          'event_address2' => $address2val,
    //                          'event_country' => $countrydata,
    //                          'event_state' => $statelistdata,
    //                          'event_city' => $towndata,
    //                          'event_zip' => $zipdata,
    //                          'booking_category' => $bookingcat_subdata,
    //                          'booking_genere' =>$bookinggenre_subdata,
    //                          'artist_security_deposit' => $security_paymentdata,
    //                          'total_payment' => $total_paymentdata,
    //                          'booking_cancellation_fee' => $cancellation_paymentdata,
    //                          'event_date' => $bkngdate,
    //                          'event_start_time' => $strttim,
    //                          'event_end_time' => $endtim,
    //                          'event_address1_lat' => $latitude,
    //                          'event_address1_long' => $longitude,
    //                          'event_timezone' => $timezoneName,
    //                          'booking_req_date' => $crdt,
    //                          'request_expired'=> $bokingexpired
    //                          );


    //  echo "<pre>";
    //  print_r($inbookingarray);die;
     
    //             //    $datainsrt = DB::table('event_booking_request')->insert($inbookingarray); //insert data into event booking table
               
    //                 if($datainsrt)
    //                 {
    //                        //***************** calling an email function
    //                        //booking_email();
                           
    //                 }
     
    //                 $getresponseAr['flagdata'] = $inbookingarray;
                    
                    
    //                 //$getresponseAr['endtim'] = $endtim;
                    
    //                 echo json_encode($getresponseAr);
                    //die;



      $artistID = $request->input('artistID');
      $address1val =  $request->input('address1val');
      $address2val =  $request->input('address2val');
      $countrydata =  $request->input('countrydata');
      $statelistdata =  $request->input('statelistdata');

      $towndata =  $request->input('towndata');
      $zipdata =  $request->input('zipdata');
      $bookingcat_subdata =  $request->input('bookingcat_subdata');
     $bookinggenre_subdata =  $request->input('bookinggenre_subdata');
// die;
      $security_paymentdata =  $request->input('security_paymentdata');
      $total_paymentdata =  $request->input('total_paymentdata');
      $cancellation_paymentdata =  $request->input('cancellation_paymentdata');
      $booking_datedata =  $request->input('booking_datedata');

      $start_timedata =  $request->input('start_timedata');
      $end_timedata =  $request->input('end_timedata');
      $requestexpireddatedata =  $request->input('requestexpireddatedata');
      $requestexpiredtimedata =  $request->input('requestexpiredtimedata');

      //******get countryname 
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

       $unicId = "GIG-".uniqid();
       $getgiguniqueidcount = DB::table('gig_master')->where('giguniqueid',$unicId)->count();
                   if($getgiguniqueidcount=='0'){
                        $unicId = $unicId;              
                   }else{
                        $unicId = $unicId."1";
                   }
      
      $latlog = getLatLong($fullBookingAddress);
      
                $latitude = $latlog['latlong'][0]['latitude'];
                $longitude = $latlog['latlong'][0]['longitude'];
                    $TimeZoneCheck = getTimezone($latitude,$longitude);
                $timezoneId = $TimeZoneCheck['timeZoneId'];
                $timezoneName = $TimeZoneCheck['timeZoneName'];
      //*****get state name


  $crdt = date('Y-m-d H:i:s');
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


      // $bookarray = array(
      //   'event_address1' => $address1val,
      //   'event_address2' => $address2val,

      //   'event_country' => $countrydata,
      //   'event_state' => $statelistdata,

      //   'event_city' => $towndata,
      //   'event_zip' => $zipdata,

      //   // 'bookingcat_subdata' => $bookingcat_subdata,
      //   // 'bookinggenre_subdata' => $bookinggenre_subdata,

      //   'security_paymentdata' => $security_paymentdata,
      //   'total_paymentdata' => $total_paymentdata,


      //   'cancellation_paymentdata' => $cancellation_paymentdata,
      //   'booking_datedata' => $booking_datedata,


      //   'start_timedata' => $start_timedata,
      //   'end_timedata' => $end_timedata,

      //   'requestexpireddatedata' => $requestexpireddatedata,
      //   'requestexpiredtimedata' => $requestexpiredtimedata,
      //   'event_address_lat' => $latitude,
      //   'event_address_long' => $longitude,
      //   'event_timezone' => $timezoneId



      //   );

      // echo "<pre>";
      // print_r($bookarray);

    $sess_id = $request->session()->get('front_id_sess');
      $insertdata = DB::table('gig_master')->insert([
       ['event_address1' => $address1val,
       'event_address2' => $address2val,
       'booker_id' => $sess_id,
       'type_flag'=>1,
       'artist_id' => $artistID,
      'gigpostrequestflag' => 2,
        'giguniqueid' => $unicId,
        'event_country' => $countrydata,
        'event_state' => $statelistdata,

        'event_city' => $towndata,
        'event_zip' => $zipdata,
        'artist_security_deposit' => $security_paymentdata,
        'total_amount' => $total_paymentdata,


        'booking_cancellation_fee' => $cancellation_paymentdata,
        // 'booking_datedata' => $booking_datedata,

        'event_date' => $bkngdate,
        'event_start_time' => $strttim,
        'event_start_date_time'=>$bkngdate." ".$strttim,
        'event_end_date_time'=>$bkngdate." ".$endtim,
        'event_end_date' =>$bkngdate,
        'event_end_time'=>$endtim,
        'request_expire_date'=>$bkngexpirdate,
        'request_expire_time'=>$expirtim,
        'request_expire_datetime'=>$bokingexpired,
        'booking_req_date'=>$crdt,
       
        'booking_status'=>'2',
      
        'event_address_lat' => $latitude,
        'event_address_long' => $longitude,
        'event_timezone' => $timezoneId

        ],

        ]);

         $LastInsertedId = DB::getPdo()->lastInsertId();//insertGetId

 //****************insert into gig_notify table***********//
                    $Insertgig_notify = array(
                    'gigmaster_id'=>$LastInsertedId,
                    'member_id'=>$artistID,
                    'booker_id'=>$sess_id,
                    'type_flag'=>1,
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
                    'type_flag'=>3,
                    'create_date'=>date('Y-m-d H:i:s')
                    );
                    $isInsertedId = DB::table('gig_skill_rel')->insert($Insertgig_skill_rel);//insertGetId



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
                    
                    $userdetail = DB::table('user_master')
                    ->select(DB::raw('first_name'))
                    ->where('email', $email)
                    ->get();
                    $first_name=$userdetail[0]->first_name;
                    
                    //*********get user details ends here
                    
                    //$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
                    $logoIMG = asset('upload/settings-image/source-file/'.$Imgologo);
                    //*********Helper Function Starts here
                    $replacefrom =array('{NAME}','{USERNAME}','{PASSWORD}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                    $replaceto =array(ucfirst($first_name),$email,$nw_pass,$sitename,$copyright_year,$bsurl,$logoIMG);
                    
                    mailsnd($Temid=8,$replacefrom,$replaceto,$email);
                  //*********Helper Function Ends here 
                
                     
      }

       public function getartistgenere(Request $request)
    {
            $categoryId = $request->input('categoryID');
            $userID = $request->input('artistusrid');
            if($categoryId > 0)
            {
                        //$getGenere = DB::table('skill_master')->where('parent_id',$categoryId)->where('status','1')->get();
                        
                   $getGenere = DB::table('user_skill_rel')
                   ->join('skill_master', 'user_skill_rel.skill_sub_id', '=', 'skill_master.id')
                   //->join('orders', 'users.id', '=', 'orders.user_id')
                   ->where('user_skill_rel.user_id', '=',$userID)
                   ->where('user_skill_rel.skill_id', '=',$categoryId)
                   ->select('skill_master.*','user_skill_rel.*')
                   ->get();
                   // echo "<pre>";
                   // echo $userID;
                   // print_r($getGenere);die;
                        
            }
            $generetypeidAr=array();
           
            if(!empty($getGenere))
            {
                    foreach($getGenere as $getGenereobj)
                    {
                            $generetypeidAr[]=array('id'=>$getGenereobj->skill_sub_id,'name'=>stripslashes($getGenereobj->name));
                    }
                    // foreach($getGenere as $getGenereobj2)
                    // {
                    //         $venuecretaoridAr[]=array('venuecreator_id'=>$getGenereobj->v_creator_id);
                    //         break;
                    // }
                    //$generetypeidAr[]=array('flag'=>'1');
            }
        
          $respAr=$generetypeidAr;
          // echo "<pre>";
          // print_r($respAr);
          // echo "</pre>";die;
          echo  json_encode($respAr);
            
    }
}