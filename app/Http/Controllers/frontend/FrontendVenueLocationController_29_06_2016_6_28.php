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
use App\Customlibrary\Imageuploadlib;
use View;
class FrontendVenueLocationController extends Controller
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
                        //$query = DB::table('venue_master')->select('user_uniqueid')->get();
                        //$user_id = 0;
                        $user_single = DB::table('venue_master')->where('seo_name',$uu)->first();
                        if($user_single)
                        {
                                    $user_id = $user_single->id;
                        }else
                        {
                                  return redirect('/');
                        }
                     
                     $data=array(); 
                     $data['data1']="hello";
                 
                 
                 
                 
                   //**** fetch skill_master data  starts
                
                $fetchtype='multiple'; $tablename="skill_master";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['catag_type']=3;
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
                
                
                //*** fetch this user related images starts                              
                
                  $selectstr=" umtb.* ";
                 
                  $venue_master_img_db=DB::table('venue_master_img as umtb');              
                  $venue_master_img_db=$venue_master_img_db->select(DB::raw($selectstr));                                                          
                  $venue_master_img_db=$venue_master_img_db->where('umtb.venue_id', $user_id);
                  $venue_master_img_db=$venue_master_img_db->orderBy("umtb.id", "asc");
                  $venue_master_img_db = $venue_master_img_db->skip(0)->take(3);
                  $venue_master_img_db=$venue_master_img_db->get();                                             
                              
                  //*** fetch this user related images ends
                 
               //***************FETCH USER IMAGE ENDS HERE
               
               //********Fetch user review starts here
                 
                 
                 
                     
                 $fetchtype='single'; $tablename="venue_master";
                 $fieldnames=" * ";
                 $wherear=array();
                 $wherear['id']=$user_id;
                 $orderbyfield="id"; $orderbytype="asc";
                 $limitstart=0;$limitend=0;                
                
                $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
               //echo "<pre>";
               //print_r($fetchuserdata);die;
               
               
               
               
                //**** fetch venue skill_rel data  starts
                
                $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.venue_id) as user_id ";
               
                $skill_user_db=DB::table('venue_skill_rel as usr');

                $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
                
                $skill_user_db=$skill_user_db->where('usr.venue_id', $user_id);
                $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
                
                $skill_user_db=$skill_user_db->get();
                //echo "<pre>";
                //print_r($skill_user_db);die;
                
                //echo "==skill_db==><pre>";
               
              
                   $venueamenitiqry = DB::table('venue_amenity_rel')
                   ->join('amenity_master', 'venue_amenity_rel.amenity_id', '=', 'amenity_master.id')
                   ->select('amenity_master.amenity_img')
                   ->where('venue_amenity_rel.venue_id',$user_id)
                   ->get();
                   //print_r($venueamenitiqry);
                   //echo $user_id;die;
               //***********Fetch Venue amemities ends here
               //echo $user_id;
               
               $presskit = DB::table('venue_presskit')->where('venue_id',$user_id)->first();
               if($presskit)
               {
                    $data['presskitvenue']=$presskit;//usrIMG
               }else
               {
                   $data['presskitvenue']='';//usrIMG
               }
              
               //echo "<pre>";
               //print_r($data);die;
               //***********

               //********venue menu starts
               $venuemenu = DB::table('venue_menu')->where('venue_id',$user_id)->first();
               if($venuemenu)
               {
                    $data['venuemenu']=$venuemenu;//usrIMG
               }else
               {
                   $data['venuemenu']='';//usrIMG
               }
               //********venue menu ends
               
               
               //**************fetch country data starts here
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
               //************** fetch country data ends here
               
               //************* fetch data for venue booking starts here category section
                   $venuebookingcategory = DB::table('venue_skill_rel')
                   ->join('skill_master', 'venue_skill_rel.skill_id', '=', 'skill_master.id')
                   ->where('venue_skill_rel.venue_id', '=', $user_id)
                   ->select('skill_master.*')
                   ->distinct('skill_master.id')
                   ->get();
                   
                   $fetchvenueskillAr=array();
                   
                   if(!empty($venuebookingcategory))
                   {
                   foreach( $venuebookingcategory as $fetchskillobj )
                   {
                           $fetchvenueskillAr[$fetchskillobj->id]=$fetchskillobj->name;
                   }
                   }
                   //echo "<pre>";
                   //print_r($fetchvenueskillAr);die;
                  //echo "<pre>";
                  //print_r($venuebookingcategory);die;
               //************ fetch data for venue booking ends here category section



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
              // echo $user_id;die;
                              //**************-------------------***************/////////


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






               
               //*********get hourly rate starts here
               $flaghourlyrate = 2;                                                        
               $hourlyrateqry = DB::table('venue_master')
                                      ->where('id',$user_id)
                                      ->select('rate_amount')
                                      ->first();
                                      //echo "Hourly rate is=======>".$hourlyrateqry->rate_amount;die;
                                      if($hourlyrateqry->rate_amount == '0.00')
                                      {
                                       $flaghourlyrate = 0;                                                        
                                      }else
                                      {
                                        $flaghourlyrate = 1;                                                        
                                      }

               //********get hourly rate ends here
               
                //******
                 $data['fetchskillmasterAr']=$fetchskillmasterAr;
                 $data['fetchuserdata']=$fetchuserdata;
                 $data['skill_user_db']=$skill_user_db;
                 $data['venue_master_img_db']=$venue_master_img_db;
                 $data['venue_amenityimg_data']=$venueamenitiqry;
                 $data['country_result']=$countryidAr;
                 
                 $data['venuebooking_skill']=$fetchvenueskillAr;
                  $data['venueprof_id'] = $user_id;
                  $data['hourlyrateflag'] = $flaghourlyrate;

                  $data['sessn_ID'] = $sessnID;
                     $data['user_testi']=$userstesti;//usrIMG
                 return view('front.venue.profile_venue',$data);

    }
    public function edit_venue(Request $request)
    {
                   
                   //************
               $successmsgdata=$request->session()->get('front_successmsgdata_sess');
               $errormsgdata=$request->session()->get('front_errormsgdata_sess');
                $createflag = 0;
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
                   //************
                   
                   
                    $sess_idchk = $request->session()->get('front_id_sess');
                    $venueURl = $request->segment(2);
                    if($venueURl!='')
                    {
                                      $chkvenueseonameqry = DB::table('venue_master')
                                      ->where('creater_id',$sess_idchk)
                                      ->where('seo_name',$venueURl)
                                      ->first();
                                      if(empty($chkvenueseonameqry))
                                      {
                                                  return redirect('/');       
                                      }
                    }
                   
       
         $VenueID ='';
       if($sess_idchk!='')
       {    // }
                   //**********check if a venue already exists or not starts here
                   $chkvenuexistsqry = DB::table('venue_master')
                                      ->where('creater_id',$sess_idchk)
                                      ->first();
                                                         
                  
                   if(empty($chkvenuexistsqry))
                   {
                                      // $createflag = 1;
                                      DB::table('venue_master')->insert([
                                      ['create_date' => date('Y-m-d H:i:s'), 'creater_id' =>$sess_idchk,'modified_date' => date('Y-m-d H:i:s')]
                                   
                                      ]);
                                  $VenueID = DB::getPdo()->lastInsertId();
                                  
                                      DB::table('venue_master')
                                      ->where('id', $VenueID)
                                      ->update(['nickname' => 'venue-profile-'.$VenueID]);
                                       // $createflag = 1;
                                      
                                       // $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                                       // echo "asdsdsd";die;
                   }else
                   {
                                       $VenueID = $chkvenuexistsqry->id;
                   }
                   //**********check if a venue already exists or not ends here
                 
                 
                 
                     //$data=array(); 
                     //       $data['data1']="hello";
                     //
                     
                     
                //$fetchtype='multiple'; $tablename="skill_master";
                //$fieldnames=" * ";
                //$wherear=array();
                //$wherear['catag_type']=3;
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
                $parentskill_db=$parentskill_db->whereRaw(" FIND_IN_SET('3',`catag_type`) ");
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
                
                $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.venue_id) as user_id ";
                
                $skill_user_db=DB::table('venue_skill_rel as usr');
                
                $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
                
                $skill_user_db=$skill_user_db->where('usr.venue_id', $VenueID);
                $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
                
                $skill_user_db=$skill_user_db->get();
                
                //echo "==skill_db==><pre>";
                //print_r($skill_db);
                //echo "</pre>";
               
                //**** fetch user_skill_rel data  ends
                
                
                  //*** fetch this user related images starts                              
                
                  $selectstr=" umtb.* ";
                 
                  $user_master_img_db=DB::table('venue_master_img as umtb');              
                  $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                  $user_master_img_db=$user_master_img_db->where('umtb.venue_id', $VenueID);
                  $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                  $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                  $user_master_img_db=$user_master_img_db->get();                                             
                              
                  //*** fetch this user related images ends
                
                //******
                $fetchtype='single'; $tablename="venue_master";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['id']=$VenueID;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
                //******
                
                
                //************Venue amenities starts here
                $amenities_qry = DB::table('amenity_master')->where('status',1)->get();
                //************Venue amenities ends here
                
                //************ get venue country data starts here
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
                //************ get venue country data ends here
                //************ get state starts here
               //  $co_db = DB::table('location_country')->where('published','1')->get();
               //// $country_result = $country_qry;
               //         $countryidAr=array();
               //         $countryidAr['']="Select a country";
               //         if(!empty($country_db))
               //         {
               //                 foreach($country_db as $country_obj)
               //                 {
               //                         $countryidAr[$country_obj->id]=stripslashes($country_obj->country_name);
               //                 }
               //                 
               //         }
                //************ get state enmds here
                
                
                //********get amenities value strts here
                $amenitiesqry_venue =  DB::table('venue_amenity_rel')
                   ->where('venue_id',$VenueID)
                   ->where('v_creator_id',$sess_idchk)
                   ->select('amenity_id')
                   ->get();
                    $amenityIDAr=array();
                   if(!empty($amenitiesqry_venue))
                        {
                                foreach($amenitiesqry_venue as $amenitiesqry_venue_obj)
                                {
                                        $amenityIDAr[]=$amenitiesqry_venue_obj->amenity_id;
                                     
                                }
                                
                        }
                //*******get amenities ends here
                //echo "<pre>";
                //print_r($fetchuserdata);die;
                $cuntryID = $fetchuserdata->country;
                if($cuntryID!=''){
                    $state_db = DB::table('location_state')->where('country_id',$cuntryID)->get();
               // $country_result = $country_qry;
                        $stateIDAr=array();
                        $stateIDAr['']="State";
                        if(!empty($state_db))
                        {
                                foreach($state_db as $state_db_obj)
                                {
                                        $stateIDAr[$state_db_obj->id]=stripslashes($state_db_obj->state_name);
                                }
                                
                        }
                }
                //echo "<pre>";
                //print_r($fetchuserdata);die;
                 $data['skill_user_db']=$skill_user_db;
                 $data['fetchuserdata']=$fetchuserdata;
                 $data['fetchskillmasterAr']=$fetchskillmasterAr;
                 $data['user_master_img_db']=$user_master_img_db;
                 $data['user_venue_amenities']=$amenities_qry;
                 $data['country_result']=$countryidAr;
                 $data['amenitiesqry_venue']=$amenityIDAr;
                 $data['stateIDAr']=$stateIDAr;
                 //echo "<pre>";
                 //print_r($stateIDAr);die;


                  // if($createflag == 1)
                  // $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');

                  
                 return view('front.venue.venue_edit',$data);
    }else
    {
                 return redirect('/');
    }
    
    }
    
    function venuesubskill(Request $request)
         {
                //**** fetch skill starts
                
                 $parent_id = $request->input('parent_id');
              //echo "<br>";
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
                $tab_db=$tab_db->whereRaw(" FIND_IN_SET('3',`catag_type`) ");
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
         
         
         
         
          public function saveuserurls(Request $request)
    {
          
            
            $controlname = addslashes(trim($request->input('controlname','')));
            $controlnamedata = addslashes(trim($request->input('controlnamedata','')));
           
            $id=0;
            $chkvalid=$this->checksaveuserurls($request,$id);
             $venuecretaeOredit=0; $nicknmres =0;
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
                                $VenueID = $this->getseo_name($userid); 
                        
                        }
                        //**********check modifying date starts here
                        $r = $this->check_modifying_date($VenueID,$userid);
                        //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                       
                        
                        //*** update user_master table starts
                        
                        $chkupd= DB::table('venue_master')->where('creater_id',$userid) ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),$controlname => $controlnamedata]
                        );
                        
                        //*** update user_master table ends
                         if($r == 1)
                        {
                                       $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                                       //return redirect('/');
                                       $venuecretaeOredit=1;
                                       //**get nickname starts here
                                      $nicknmres =  $this->getnicknm($VenueID,$userid);
                                       //**get nickname ends here
                                       
                        }
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
          
         
         $responseAr['venuecretaeedit']=$venuecretaeOredit;
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
                       "controlnamedata.url" => $controlmsg." invalid url",
                     
                       
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                
                  
                  
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                  return true;
                    
        
           }
           
         
         
         
         
         
         
         
         
         
         
         
         
          //*************************** save saveusername starts
         
          public function saveusernamevenue(Request $request)
        {
                   $usrVenueID =0;
                    if ($request->session()->has('front_id_sess'))
                        {
                                $loggeduserid=$request->session()->get('front_id_sess'); // get session                       
                                 $usrVenueID = $this->getseo_name($loggeduserid); 
                        }
            
            $nickname = addslashes(trim($request->input('nickname','')));
            
           $venuecretaeOredit =0;
            $id=0;
            $nicknmres=0;
            $chkvalid=$this->checksaveusername($request,$usrVenueID);
            
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
                                 $VenueID = $this->getseo_name($userid); 
                        }



                                //**********get previous venue name
                                //*****  starts
                                $previousvenueqry = DB::table('venue_master')
                                ->where('creater_id',$userid)
                                ->where('id',$VenueID)
                                ->select('nickname')
                                ->first();

                                $previously_venue_name = $previousvenueqry->nickname;

                                //*****  ends
                                //**********get previous venue name


                        
                        //*** update user_master table starts
                        //********seo url
                        $nickname = strtolower($nickname);
                        $seotitle = str_slug($nickname, '-').'-'.$VenueID;
                        //**********check modifying date starts here
                        $r = $this->check_modifying_date($VenueID,$userid);
                        //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT
                        //**********check modifying date ends here
                        $chkupd= DB::table('venue_master')
                        ->where('creater_id',$userid)
                        ->where('id',$VenueID)
                        
                        ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),'nickname' => $nickname,'seo_name' => $seotitle]
                        );
                        
                        //*** update user_master table ends
                        // if($r == 1)
                        // {
                        //                $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                        //                //return redirect('/');
                        //               $venuecretaeOredit=1;
                        //                //**get nickname starts here
                        //               $nicknmres =  $this->getnicknm($VenueID,$userid);
                        //                //**get nickname ends here
                                       
                        // }
                        
                        if(!empty($chkupd))
                        {

                            if($nickname != $previously_venue_name)
                            {
                                        $request->session()->flash('front_successmsgdata_sess', 'Venue name has been updated successfully .');
                                        $venuecretaeOredit=1;
                                       //**get nickname starts here
                                        $nicknmres =  $this->getnicknm($VenueID,$userid);
                            }
                                        $flag_id=1;                          
                                       //$venuecretaeOredit=0;
                                       //$nicknmres=0;
                               
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
         $responseAr['venuecretaeedit']=$venuecretaeOredit;
          $responseAr['nicknmdata']= $nicknmres;
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          echo json_encode($responseAr);
          
          
    }
           
    public function checksaveusername($request,$id=0)
           {
                $nickname = addslashes(trim($request->input('nickname','')));
                $controlmsg="";
                
                        
              
                $validator = Validator::make($request->all(), [
               
                "nickname" => "required|min:5|max:50|unique:venue_master,nickname,".$id         
                
                ],[
                   "nickname.required" => " Venue name is required",
                    'nickname.required'=>'*Venue name field required',
                    'nickname.min'=>'*Venue name length minimum 5',
                   'nickname.max'=>'*Venue name length maximum 50',
                   'nickname.unique'=>'*Venue name must be unique',
                   
                ]);
                    
                    
                    //*******validator after function starts here
                    $userData=array();
                $userData['request']=$request;
                $userData['addeditid']=$id;
                
                $validator->after(function($validator)  use ($userData)  {
                        
                   $request=$userData['request'];
                   $addeditid=$userData['addeditid'];
                                      $chknm = $this->vaildtvenuenicknm($request,$addeditid);
                                      if($chknm > 0)
                                      {
                                       $validator->errors()->add('nickname', 'Please enter a valid name');
                                      }
                   });
                    //*******validator after function ends here
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                return true;
                    
        
           }
         
         //************************** save saveusername ends
         
         
          //*************************** save user_description starts
         
          public function saveuserdescvenue(Request $request)
        {
          
            
            $user_description = addslashes(trim($request->input('user_description','')));
            
           
            $id=0;
            $chkvalid=$this->checksaveuserdesc($request,$id);
            $venuecretaeOredit=0;
            $nicknmres =0;
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
                                $VenueID = $this->getseo_name($userid);
                        }
                        
                        //*** update user_master table starts
                         //**********check modifying date starts here
                        $r = $this->check_modifying_date($VenueID,$userid);
                        //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                        $chkupd= DB::table('venue_master')->where('creater_id',$userid) ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),'venue_description' => $user_description]
                        );
                        
                        //*** update user_master table ends
                         if($r == 1)
                        {
                                       $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                                       //return redirect('/');
                                       $venuecretaeOredit=1;
                                       //**get nickname starts here
                                      $nicknmres =  $this->getnicknm($VenueID,$userid);
                                       //**get nickname ends here
                                       
                        }
                        
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
          $responseAr['venuecretaeedit']=$venuecretaeOredit;
          $responseAr['nicknmdata']= $nicknmres;
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          echo json_encode($responseAr);
          
          
    }
           
    public function checksaveuserdesc($request,$id=0)
           {
                $user_description = addslashes(trim($request->input('user_description','')));
                $controlmsg="";
                
                        
              
                    $validator = Validator::make($request->all(), [
                   
                    "user_description" => "required|max:1500"
                    
                    
                    ],[
                       "user_description.required" => " Description is required",                  
                       "user_description.max" => "Maximium 1500 characters are allowed"
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                
                  
                  
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                  return true;
                    
        
           }
         
         //************************** save user_description ends
         
         
          //*************************** save skill data starts
         
          public function saveskilldatavenue(Request $request)
        {
          
            
         /*echo "Category ID=>".*/ $catag_type_id= addslashes(trim($request->input('catag_type_id','')));
       /* echo "Skill ID==>".*/    $skill_id= addslashes(trim($request->input('skill_id','')));
          /*echo "Skill Sub ID=>".*/  $skill_sub_id= addslashes(trim($request->input('skill_sub_id','')));
            //die;
            
            $id=0;
            $chkvalid=$this->checksaveskilldata($request);
            $chkvalid=true;
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            $venuecretaeOredit=0;
            $nicknmres =0;
            
           if($chkvalid==true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $user_id=1;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session                       
                                      $venue_id = $this->getseo_name($user_id);
                        }
                        //**********check modifying date starts here
                        $r = $this->check_modifying_date($venue_id,$user_id);
                        //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                        //*** update venue_skill table starts
                        
                        $insert_skill_array=array();
                        $insert_skill_array['catag_type_id']=$catag_type_id;
                        $insert_skill_array['skill_id']=$skill_id;
                        $insert_skill_array['skill_sub_id']=$skill_sub_id;
                        $insert_skill_array['v_creator_id']=$user_id;
                        $insert_skill_array['venue_id']=$venue_id;
                        $insert_skill_array['create_date']=date('Y-m-d H:i:s');
                         
                        $chkupd= DB::table('venue_skill_rel')->insert($insert_skill_array );
                         $last_insert_id=DB::getPdo()->lastInsertId();

                        //******Update venue master table starts here
                                      DB::table('venue_master')
                                      ->where('id', $venue_id)
                                      ->update(['modified_date' => date('Y-m-d H:i:s')]);
                        //******Update venue master table ends here
                        
                        //*** update venue_skill table ends
                          if($r == 1)
                        {
                                       $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                                       //return redirect('/');
                                       $venuecretaeOredit=1;
                                       //**get nickname starts here
                                      $nicknmres =  $this->getnicknm($venue_id,$user_id);
                                       //**get nickname ends here
                                       
                        }
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
          $responseAr['venuecretaeedit']=$venuecretaeOredit;
          $responseAr['nicknmdata']= $nicknmres;
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
         
          public function deletemyskillvenue(Request $request)
        {
          
            
           
            $skill_sub_id= addslashes(trim($request->input('skill_sub_id','')));
            
            
            $id=0;
            //$chkvalid=$this->checksaveskilldata($request,$id);
            $chkvalid=true;
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
           if($chkvalid===true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $user_id=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session                       
                               $venue_id = $this->getseo_name($user_id);
                        }
                        
                        //*** update user_master table starts
                        
                        $where_del_array=array();
                        
                        $where_del_array['skill_sub_id']=$skill_sub_id;
                        $where_del_array['venue_id']=$venue_id;
                         $where_del_array['v_creator_id']=$user_id;
                        
                         //echo "<pre>";
                        // print_r($where_del_array);die;
                        $chkupd= DB::table('venue_skill_rel')->where($where_del_array )->delete();
                         

                        
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
         
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          echo json_encode($responseAr);
          
          
    }
           
    
         
         //************************** delete skill data ends     
         
         
    // public function index(Request $request)
    //{
    //        
    //                    $uu = $request->segment(2);
    //                    $query = DB::table('user_master')->select('user_uniqueid')->get();
    //                    $user_id = 0;
    //                    $user_single = DB::table('user_master')->where('user_uniqueid',$uu)->first();
    //                    if($user_single)
    //                    {
    //                                $user_id = $user_single->id;
    //                    }
    //                    else
    //                    {
    //                                 $user_id = 0;
    //                    }
    //
    //        
    //                    if($user_id <2 || empty($user_single) || $user_id ==0)
    //                    {
    //                                echo "wrong user";exit();
    //                    }
    //                    
    //                        $data=array(); 
    //                        $data['data1']="hello";
    //                   
    //                       //*************** fetch data of banner starts=======================*************
    //                        $banner_image='';$display_flag=0;            
    //                        //*** fetch data of banner ends                
    //                        
    //                        //**** fetch basic info of user  starts
    //                        
    //                        $fetchtype='single'; $tablename="user_master";
    //                        $fieldnames=" * ";
    //                        $wherear=array();
    //                        $wherear['id']=$user_id;
    //                        $orderbyfield="id"; $orderbytype="asc";
    //                        $limitstart=0;$limitend=0;                
    //                        
    //                        $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
    //           
    //           //**** fetch skill_master data  starts
    //            
    //            $fetchtype='multiple'; $tablename="skill_master";
    //            $fieldnames=" * ";
    //            $wherear=array();
    //            $wherear['catag_type']=1;
    //            $wherear['parent_id']=0;
    //            $wherear['status']=1;
    //            $orderbyfield="name"; $orderbytype="asc";
    //            $limitstart=0;$limitend=0;                
    //            
    //            $fetchskillmasterdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
    //           
    //            $fetchskillmasterAr=array();
    //            $fetchskillmasterAr['']="Category for Request";
    //            if(!empty($fetchskillmasterdata))
    //            {
    //                foreach( $fetchskillmasterdata as $fetchskillobj )
    //                {
    //                        $fetchskillmasterAr[$fetchskillobj->id]=$fetchskillobj->name;
    //                }
    //            } 
    //            //**** fetch skill_master data  ends
    //            
    //            
    //            //**** fetch user_skill_rel data  starts
    //            
    //            $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.user_id) as user_id ";
    //           
    //            $skill_user_db=DB::table('user_skill_rel as usr');
    //
    //            $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
    //            $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
    //            $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
    //            
    //            $skill_user_db=$skill_user_db->where('usr.user_id', $user_id);
    //            $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
    //            
    //            $skill_user_db=$skill_user_db->get();
    //            
    //            //echo "==skill_db==><pre>";
    //           // print_r($skill_user_db);
    //            $sklid = $skill_user_db[0]->skill_sub_id;
    //            $sklid = explode(',',$sklid);
    //          //  echo "<pre>";
    //           // print_r($sklid);
    //            //echo $skill_user_skill_sub_id'];
    //          //  echo "</pre>";
    //           
    //            //**** fetch user_skill_rel data  ends
    //            
    //            //*******************************FETCH COUNTRY DATA STARTS HERE 28-05-2016
    //            $country_db = DB::table('location_country')->where('published','1')->get();
    //           // $country_result = $country_qry;
    //                    $countryidAr=array();
    //                    $countryidAr['']="Select a country";
    //                    if(!empty($country_db))
    //                    {
    //                            foreach($country_db as $country_obj)
    //                            {
    //                                    $countryidAr[$country_obj->id]=stripslashes($country_obj->country_name);
    //                            }
    //                            
    //                    }
    //           
    //            //****************FETCH ALL CATEGORY ENDS HERE 30-05-2016
    //            
    //            
    //            //****************
    //            //***************FETCH USER IMAGE STARTS HERE
    //            $usr_img = DB::table('user_master_img')->where('default_status','1')->where('user_id',$user_id)->get();
    //             
    //           //***************FETCH USER IMAGE ENDS HERE
    //           
    //           //********Fetch user review starts here
    //           
    //           $userstesti = DB::table('event_review as erv')
    //                ->join('user_master as um', 'erv.booker_id', '=', 'um.id')
    //                 ->join('bookers_review as brv', 'erv.id', '=', 'brv.event_review_id')
    //                                    ->leftJoin('user_master_img as umi', function ($join)
    //                                    {
    //                                    $join->on('erv.booker_id', '=', 'umi.user_id')
    //                                    ->where('umi.default_status','=','1');
    //                                    })
    //                                   
    //                ->select('erv.*', 'um.first_name', 'um.username','um.nickname','um.city','umi.user_id','umi.image_name','umi.default_status','brv.puntuality','brv.performence','brv.presentation')
    //                ->where('erv.artist_id',$user_id)
    //                ->get();
    //               
    //                //echo "<pre>";
    //                //print_r($userstesti);
    //                //echo "</pre>";die;
    //           //********Fetch user review ends here
    //          //*************presskit data starts here
    //          $presskit = DB::table('user_presskit')->where('user_id',$user_id)->first();
    //          //*************presskit data ends here
    //          
    //          ////***************sum of ratings starts here
    //          //$total = DB::table('users')->where()->sum('puntuality');
    //          ////**************sum of ratings ends here
    //            
    //            
    //            $data['banner_image']=$banner_image;
    //            $data['display_flag']=$display_flag;
    //            $data['fetchuserdata']=$fetchuserdata;
    //            $data['fetchskillmasterAr']=$fetchskillmasterAr;
    //            $data['skill_user_db']=$skill_user_db;
    //            $data['country_result']=$countryidAr;
    //            $data['usr_img']=$usr_img;//usrIMG
    //            
    //            $data['user_testi']=$userstesti;//usrIMG
    //            $data['presskit']=$presskit;//usrIMG
    //           return view('front.user.profile', $data);
    //}
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
    
    public function downloadpresskitveue($file_name)
    {
                   // echo $file_name;die;
                    $filennmdownload = base64_decode($file_name);
                   // echo $filennm;die;
            //********its working for single file
            $download_path = ( public_path() . '/upload/venue-press-kit/source-file/' . $filennmdownload );
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
                             'event_timezone' => $timezoneId,
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
      
      
      
      //************************** save ABN data starts
            public function saveabncustfuncvenue(Request $request)
            {
                        $abndata = addslashes(trim($request->input('abndata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                         $venuecretaeOredit=0;
                         $nicknmres =0;
                        $chkvalid=$this->checkvalidabntosave($request,$id); //*** checksaveabn
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=1;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                                $venueID = $this->getseo_name($userid);
                                    }
                                    //*** update user_master table starts
                                    
                                      //**********check modifying date starts here
                                      $r = $this->check_modifying_date($venueID,$userid);
                                      //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                                    
                                    
                                    $chkupd= DB::table('venue_master')
                                    ->where('creater_id',$userid)
                                    ->where('id',$venueID)
                                    
                                    ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'),'abn_data' => $abndata]
                                    );
                                    //*** update user_master table ends
                                     if($r == 1)
                        {
                                       $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                                       //return redirect('/');
                                       $venuecretaeOredit=1;
                                       //**get nickname starts here
                                      $nicknmres =  $this->getnicknm($venueID,$userid);
                                       //**get nickname ends here
                                       
                        }
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
                   $responseAr['venuecretaeedit']=$venuecretaeOredit;
                   $responseAr['nicknmdata']= $nicknmres;
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
                                    "abndata.numeric" => "Only numerics are allowed",
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
                                    $errorMsg[]=" Maximum 11 digits ";
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
            public function savegstcustfuncvenue(Request $request)
            {
                        $gstdata = addslashes(trim($request->input('gstdata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $venuecretaeOredit=0;
                        $nicknmres = 0;
                        $chkvalid=$this->checkvalidgsttosave($request,$id); 
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=1;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                                $venueID = $this->getseo_name($userid);
                                    }
                                    $gststat=0;
                                    if($gstdata!='')
                                    {
                                                $gststat=1;
                                    }
                                      //**********check modifying date starts here
                                      $r = $this->check_modifying_date($venueID,$userid);
                                      //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                                    //*** update user_master table starts
                                    $chkupd= DB::table('venue_master')
                                    ->where('id',$venueID)
                                    ->where('creater_id',$userid)
                                    
                                    ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'), 'tfn_data' => $gstdata, 'gst_status' => $gststat]
                                    );
                                    //*** update user_master table ends
                                      if($r == 1)
                                      {
                                        $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                                        //return redirect('/');
                                        $venuecretaeOredit=1;
                                        //**get nickname starts here
                                       $nicknmres =  $this->getnicknm($venueID,$userid);
                                        //**get nickname ends here
                                        
                                      }
                                    
                                    
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
                   $responseAr['venuecretaeedit']=$venuecretaeOredit;
                   $responseAr['nicknmdata']= $nicknmres;
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
            public function savepagemetatagcustfuncvenue(Request $request)
            {
                        $pagemetatagdata = addslashes(trim($request->input('pagemetatagdata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $venuecretaeOredit=0;
                        $nicknmres = 0;
                        $chkvalid=$this->checksavepagemetatag($request,$id);
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=1;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                                $venueID = $this->getseo_name($userid);
                                    }
                                    //**********check modifying date starts here
                                      $r = $this->check_modifying_date($venueID,$userid);
                                    //*** update user_master table starts
                                    $chkupd= DB::table('venue_master')
                                    ->where('id',$venueID)
                                     ->where('creater_id',$userid)
                                    ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'),'venue_meta_data' => $pagemetatagdata]
                                    );
                                    //*** update user_master table ends
                                      if($r == 1)
                                      {
                                        $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                                        //return redirect('/');
                                        $venuecretaeOredit=1;
                                        //**get nickname starts here
                                       $nicknmres =  $this->getnicknm($venueID,$userid);
                                        //**get nickname ends here
                                        
                                      }
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
                   $responseAr['venuecretaeedit']=$venuecretaeOredit;
                   $responseAr['nicknmdata']= $nicknmres;
                        $responseAr['flag_id']=$flag_id;
                        $responseAr['error_message']=$error_msgAr;
                        echo json_encode($responseAr);  
            }
            
            public function checksavepagemetatag($request,$id=0)
            {
                        $validator = Validator::make($request->all(), [
                                    "pagemetatagdata" => "required|max:100",
                        ],[
                                    "pagemetatagdata.required" => "Page meta tag data is required", 
                                    "pagemetatagdata.max" => "Maximum 100 characters",
                        ]);
                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            //************************** save Page-meta-tag data ends 
       //*************************** upload user image starts*************
         
          public function userimagesavevenue(Request $request)
        {
          
            
           
           //echo "<pre>"; print_r($_FILES);echo "</pre>";
           
           
            $id=0;
            $chkvalidimage=$this->fileisinvalid($request,$id);
              
            $err_resp_msg=''; $respflg=0; $uploadedsuccnames=array(); $user_master_img_db=array();
            $slider_contents=''; $default_image_name='';
            $venuecretaeOredit =0;
            $nicknmres =0;
              
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
                       
                       
                       $destinationsourcePath=public_path()."/upload/venueimage/source-file/";                         
                      
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
                                       $destinationcommonPath=public_path()."/upload/venueimage/";
                                       
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
                              $user_id=1;
                              if ($request->session()->has('front_id_sess'))
                              {
                                      $user_id=$request->session()->get('front_id_sess'); // get session                       
                              $Venueid = $this->getseo_name($user_id);
                              }
                              
                                      //**********check modifying date starts here
                                      $r = $this->check_modifying_date($Venueid,$user_id);
                                      //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                        
                              foreach($uploadedsuccnames as $user_image_name)
                              {
                                    $default_status=0;
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 starts
                                          $selectstr=" umtb.* ";
                                          
                                          $user_master_img_db=DB::table('venue_master_img as umtb');              
                                          $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                                          $user_master_img_db=$user_master_img_db->where('umtb.venue_id', $Venueid);
                                           $user_master_img_db=$user_master_img_db->where('umtb.v_creator_id', $user_id);
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
                                    $user_img_array['venue_id']=$Venueid;
                                     $user_img_array['v_creator_id']=$user_id;
                                    $user_img_array['create_date']=date('Y-m-d H:i:s');
                                    $user_img_array['modified_date']=date('Y-m-d H:i:s'); 
                                    $chkupd= DB::table('venue_master_img')->insert($user_img_array );
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
                                      DB::table('venue_master')
                                      ->where('id', $Venueid)
                                      ->update(['modified_date'=>date('Y-m-d H:i:s') ]);
                              //*** fetch this user related images starts
                              
                
                              $selectstr=" umtb.* ";
                             
                              $venue_master_img_db=DB::table('venue_master_img as umtb');              
                              $venue_master_img_db=$venue_master_img_db->select(DB::raw($selectstr));                                                          
                              $venue_master_img_db=$venue_master_img_db->where('umtb.venue_id', $Venueid);
                              $venue_master_img_db=$venue_master_img_db->where('umtb.v_creator_id', $user_id);
                              $venue_master_img_db=$venue_master_img_db->orderBy("umtb.id", "asc");
                              $venue_master_img_db = $venue_master_img_db->skip(0)->take(3);
                              $venue_master_img_db=$venue_master_img_db->get();
                              
                              if(!empty($venue_master_img_db))
                              {
                                    
                                     $default_image_name= $venue_master_img_db[0]->image_name;       
                              }
                              
                              //*** fetch this user related images ends
                              
                              $dataresp=array();
                              $view_obj = View::make('front.venue.venueeditprofilesilder', array("venue_master_img_db"=>$venue_master_img_db));
                              $slider_contents = $view_obj->render();  
                              
                                      if($r == 1)
                                      {
                                         $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                                         //return redirect('/');
                                         $venuecretaeOredit=1;
                                         //**get nickname starts here
                                        $nicknmres =  $this->getnicknm($Venueid,$user_id);
                                         //**get nickname ends here
                                         
                                      }
                              
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
            
                   //if($r == 1)
                   //{
                   //               $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                   //               //return redirect('/');
                   //               $venuecretaeOredit=1;
                   //               //**get nickname starts here
                   //              $nicknmres =  $this->getnicknm($Venueid,$user_id);
                   //               //**get nickname ends here
                   //               
                   //}
            
            
            $respAr=array();
             $respAr['venuecretaeedit']=$venuecretaeOredit;
          $respAr['nicknmdata']= $nicknmres;
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
                
                
                $destinationsourcePath=public_path()."/upload/venueimage/source-file/";                       
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
       
       
       
       
         
         //************************** upload user  image  ends
         
         //************************** upload user  image  ends
         
       public function userimagedeletevenue(Request $request)
        {
            // imagename   firstimageflag imageid
           $imagename= addslashes(trim($request->input('imagename','')));
            $firstimageflag= addslashes(trim($request->input('firstimageflag','')));
            $imageid= addslashes(trim($request->input('imageid','')));
            //die;
            $flag_dta=0;$slider_contents='';$error_message='';
            $user_id=1;$default_image_name='';
            if ($request->session()->has('front_id_sess'))
            {
                    $user_id=$request->session()->get('front_id_sess'); // get session                       
                   $Venueid = $this->getseo_name($user_id);
            }
            
            
            //*** fetch this user related image starts                              
                
            $selectstr=" umtb.* ";
           
            $user_master_img_db=DB::table('venue_master_img as umtb');              
            $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
            $user_master_img_db=$user_master_img_db->where('umtb.venue_id', $Venueid);
            $user_master_img_db=$user_master_img_db->where('umtb.v_creator_id', $user_id);
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
           
           $ar=DB::table('venue_master_img')->where('id', '=', $imageid)->delete();
         
           
           if($ar>0)
           {
            
                          //***** unlink image starts
                        $destinationcommonPath=public_path()."/upload/venueimage/source-file/".$image_name;
                        $destinationcommonPath2=public_path()."/upload/venueimage/thumb-small/".$image_name;
                        $destinationcommonPath3=public_path()."/upload/venueimage/thumb-medium/".$image_name;
                        $destinationcommonPath4=public_path()."/upload/venueimage/thumb-big/".$image_name;
                        
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
                        
                        $user_master_img_db=DB::table('venue_master_img as umtb');              
                        $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                        $user_master_img_db=$user_master_img_db->where('umtb.venue_id', $Venueid);
                         $user_master_img_db=$user_master_img_db->where('umtb.v_creator_id', $user_id);
                         
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
                              
                              $chkupd= DB::table('venue_master_img')->where('id',$new_frst_img_id) ->update(
                              ["default_status" =>1,"modified_date"=> date("Y-m-d H:i:s") ]
                              );
                              
                             
                              
                              //*** update code default_status to 1 ends
                        }
                  }
                              
                  //***** now get image slider data starts 
                  
                 
                              //*** fetch this user related images starts                              
    
                              $selectstr=" umtb.* ";
                             
                              $user_master_img_db=DB::table('venue_master_img as umtb');              
                              $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                              $user_master_img_db=$user_master_img_db->where('umtb.venue_id', $Venueid);
                              $user_master_img_db=$user_master_img_db->where('umtb.v_creator_id', $user_id);
                              
                              $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                              $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                              $user_master_img_db=$user_master_img_db->get();
                              
                              if(!empty($user_master_img_db))
                              {
                                    $default_image_name=$user_master_img_db[0]->image_name;
                                             
                              }
                              
                              //*** fetch this user related images ends
                              
                              $dataresp=array();
                              $view_obj = View::make('front.venue.venueeditprofilesilder', array("venue_master_img_db"=>$user_master_img_db));
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
        
        
        
        
        
        //************************** upload presskit starts
         
       public function presskituploadsavevenue(Request $request)
        {
            //press-kit
            
             //echo "<pre>"; print_r($_FILES);echo "</pre>";
           
           
            $id=0;
            $chkvalidimage=$this->presskitfileisinvalid($request,$id);
              
            $err_resp_msg=''; $respflg=0; $uploadedsuccnames=array(); $user_master_img_db=array();
            $slider_contents=''; $default_image_name='';
             $venuecretaeOredit=0;
             $nicknmres = 0;
              
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
                       
                       
                       $destinationsourcePath=public_path()."/upload/venue-press-kit/source-file/";                         
                      
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
                              $user_id=1;
                              if ($request->session()->has('front_id_sess'))
                              {
                                      $user_id=$request->session()->get('front_id_sess'); // get session                       
                                      $venueID =  $this->getseo_name($user_id);
                              }
                   //**********check modifying date starts here
                   $r = $this->check_modifying_date($venueID,$user_id);
                   //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                              
                               //*** check whether any prev presskit present starts
                                          $selectstr=" upk.* ";
                                          
                                          $user_presskit_db=DB::table('venue_presskit as upk');              
                                          $user_presskit_db=$user_presskit_db->select(DB::raw($selectstr));                                                          
                                          $user_presskit_db=$user_presskit_db->where('upk.venue_id', $venueID);
                                           $user_presskit_db=$user_presskit_db->where('upk.v_creator_id', $user_id);
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
                                                
                                                $updtusrmstr= DB::table('venue_presskit');
                                                $updtusrmstr= $updtusrmstr->where('venue_id',$venueID) ;
                                                $updtusrmstr= $updtusrmstr->where('v_creator_id',$user_id) ;
                                                $updtusrmstr=$updtusrmstr->update(
                                                ['presskit_name' =>addslashes($user_presskit_name),
                                                 'create_date'=>date('Y-m-d H:i:s')    
                                                 ]
                                                );
                                                
                                                //*** unlink previous presslit  file
                                                
                                                $srcpresskit=public_path()."/upload/venue-press-kit/source-file/".$presskit_name;
                        
                                                 @unlink($srcpresskit);
                                                
                                               
                                    }
                                    else
                                    {
                                               //**** insert qry
                                               
                                                $presskit_array=array();                                                
                                                
                                                $presskit_array['presskit_name']=addslashes($user_presskit_name);
                                                $presskit_array['venue_id']=$venueID;
                                                 $presskit_array['v_creator_id']=$user_id;
                                                $presskit_array['create_date']=date('Y-m-d H:i:s');                                    
                                                $chkupd= DB::table('venue_presskit')->insert($presskit_array );
                                                $last_insert_id=DB::getPdo()->lastInsertId(); 
                                               
                                    }
                                   
                                    
                                    
                                    
                                    
                              }
                              
                             
DB::table('venue_master')
->where('id', $venueID)
->update(['modified_date'=>date('Y-m-d H:i:s') ]);
                              
                              
                              
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
            if($r == 1)
                        {
                                       $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                                       //return redirect('/');
                                       $venuecretaeOredit=1;
                                       //**get nickname starts here
                                      $nicknmres =  $this->getnicknm($venueID,$user_id);
                                       //**get nickname ends here
                                       
                        }
            
            
            
            $respAr=array();
             $respAr['venuecretaeedit']=$venuecretaeOredit;
             $respAr['nicknmdata']= $nicknmres;
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
                
                
                $destinationsourcePath=public_path()."/upload/venue-press-kit/source-file/";                       
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
       
        
        
       //************************** upload presskit ends
       
       
       
       
       
       
       
       
       
       //************************** upload Menu starts
         
       public function menuuploadsavevenue(Request $request)
        {
            //press-kit
            
             //echo "<pre>"; print_r($_FILES);echo "</pre>";
           
           
            $id=0;
            $chkvalidimage=$this->menufileisinvalid($request,$id);
              
            $err_resp_msg=''; $respflg=0; $uploadedsuccnames=array(); $user_master_img_db=array();
            $slider_contents=''; $default_image_name='';
                $venuecretaeOredit=0;
                $nicknmres =0;
            $errormsgs=$chkvalidimage['errormsgs'];
            $errfileAr=$chkvalidimage['errfileAr'];
            $totalfileposted=$chkvalidimage['totalfileposted'];
              
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
           
                  //**** file upload code starts
                       
                       
                       $allowedFileExtAr=array();
                       $allowedFileExtAr[]="pdf";
                      
                       
                       $filecontrolname="menu_name";
                       
                      
                       $allowedFileExtSizeAr=array();
                       $allowedFileExtSizeAr['pdf']=(5*1024*1024);                      
                       
                       
                       //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                       $allowedFileResolAr=array();
                       
                      // $allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
                      
                       $func="uploadfile";//validatefile/uploadfile
                       
                       
                       $destinationsourcePath=public_path()."/upload/venue-menu/source-file/";                         
                      
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
                              $user_id=1;
                              if ($request->session()->has('front_id_sess'))
                              {
                                      $user_id=$request->session()->get('front_id_sess'); // get session                       
                                       $venueID =  $this->getseo_name($user_id);
                              }
                                      //**********check modifying date starts here
                                      $r = $this->check_modifying_date($venueID,$user_id);
                                      //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                              
                               //*** check whether any prev presskit present starts
                                          $selectstr=" upk.* ";
                                          
                                          $user_presskit_db=DB::table('venue_menu as upk');              
                                          $user_presskit_db=$user_presskit_db->select(DB::raw($selectstr));                                                          
                                          $user_presskit_db=$user_presskit_db->where('upk.venue_id', $venueID);                                          $user_presskit_db=$user_presskit_db->where('upk.v_creator_id', $user_id);
                                          
                                          $user_presskit_db = $user_presskit_db->skip(0)->take(1);
                                          $user_presskit_db=$user_presskit_db->first();
                                          $presskit_name='';
                                          if(!empty($user_presskit_db))
                                          {
                                                $presskit_name=stripslashes($user_presskit_db->menu_name);
                                          }
                                        
                               //*** check whether any prev presskit present ends
                        
                              foreach($uploadedsuccnames as $user_presskit_name)
                              {
                                    
                                   
                                    
                                    if(!empty($user_presskit_db))
                                    {
                                                //**** update qry
                                                
                                                $updtusrmstr= DB::table('venue_menu');
                                                $updtusrmstr= $updtusrmstr->where('venue_id',$venueID);
                                                $updtusrmstr= $updtusrmstr->where('v_creator_id',$user_id);
                                                $updtusrmstr=$updtusrmstr->update(
                                                ['menu_name' =>addslashes($user_presskit_name),
                                                 'create_date'=>date('Y-m-d H:i:s')    
                                                 ]
                                                );
                                                
                                                //*** unlink previous presslit  file
                                                
                                                $srcpresskit=public_path()."/upload/venue-menu/source-file/".$presskit_name;
                        
                                                 @unlink($srcpresskit);
                                                
                                               
                                    }
                                    else
                                    {
                                               //**** insert qry
                                               
                                                $presskit_array=array();                                                
                                                
                                                $presskit_array['menu_name']=addslashes($user_presskit_name);
                                                $presskit_array['venue_id']=$venueID;
                                                $presskit_array['v_creator_id']=$user_id;
                                                $presskit_array['create_date']=date('Y-m-d H:i:s');                                    
                                                $chkupd= DB::table('venue_menu')->insert($presskit_array );
                                                $last_insert_id=DB::getPdo()->lastInsertId(); 
                                               
                                    }
                                   
                                    
                                    
                                    
                                    
                              }
                              
                             
                   //if($r == 1)
                   //{
                   //        $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                   //        //return redirect('/');
                   //        $venuecretaeOredit=1;
                   //        //**get nickname starts here
                   //       $nicknmres =  $this->getnicknm($venueID,$user_id);
                   //        //**get nickname ends here
                   //        
                   //}
                   DB::table('venue_master')
                   ->where('id', $venueID)
                   ->update(['modified_date'=>date('Y-m-d H:i:s') ]);       
                              
                              
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
            if($r == 1)
                   {
                           $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                           //return redirect('/');
                           $venuecretaeOredit=1;
                           //**get nickname starts here
                          $nicknmres =  $this->getnicknm($venueID,$user_id);
                           //**get nickname ends here
                           
                   }
            
            
            
            $respAr=array();
            $respAr['venuecretaeedit']=$venuecretaeOredit;
            $respAr['nicknmdata']= $nicknmres;
            $respAr['flag']=$respflg;
            $respAr['errorespmsg']=$err_resp_msg;
            $respAr['errfileAr']=$errfileAr;
            $respAr['totalfileposted']=$totalfileposted;
            $respAr['uploadedsuccnames']=$uploadedsuccnames;
            
            //$respAr['user_master_img_db']=$user_master_img_db;
           //  $respAr['chkimgresp']=$chkimgresp;
            echo json_encode($respAr);
            
            
        }
        
        public function menufileisinvalid($request,$addeditid=0)
       {
               
                // echo "<pre>";    print_r($request); exit();
                
                
                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="pdf";
                
                
                $filecontrolname="menu_name";
                
               
				$allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['pdf']=(5*1024*1024);
				
				
				
				
				//max_width & max_height ,min_width &  min_height,equal_width & equal_height  
				$allowedFileResolAr=array();
				
				//$allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
				
                $func="validatefile";//validatefile/uploadfile
                
                
                $destinationsourcePath=public_path()."/upload/venue-menu/source-file/";                       
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
       
        
        
       //************************** upload Menu ends
        
        //******save venue address starts here
        public function addresssavevenue(Request $request)
        {
                   $venuecretaeOredit=0;
                   $nicknmres = 0;
                   $user_id = 1;
                    if ($request->session()->has('front_id_sess'))
                              {
                                      $user_id=$request->session()->get('front_id_sess'); // get session                       
                                      $venueID =  $this->getseo_name($user_id);
                              }
                                      //**********check modifying date starts here
                                      $r = $this->check_modifying_date($venueID,$user_id);
                                      //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                   
                   $addressvenue1 = $request->input('address1val');
                   $addressvenue2 = $request->input('address2val');
                   
                   $countryId = $request->input('countrydata');
                   $statelistdata = $request->input('statelistdata');
                   $tablenamecountry ='location_country';
                   $tablenamestate ='location_state';
                   $countryfield = 'country_name';
                   $statefield = 'state_name';
                   //$countrycmpfield = 'id';
                   //$statecmpfield = '';
                   
                   $countryname =  $this->getcountrystatevenueedit($countryId,$tablenamecountry,$countryfield);
                   $statename =  $this->getcountrystatevenueedit($statelistdata,$tablenamestate,$statefield);
                   
                   $towndata = $request->input('towndata');
                   $zipdata = $request->input('zipdata');
                   //$addressvenue1 = $request->input('valchk');
                    $valchk = $request->input('valchk');
                    
                      //*************getltlong from address starts here
                   $hlprdta = urlencode($addressvenue1.' '.$addressvenue2.' '.$towndata.' '.$zipdata.' '.$statename.' '.$countryname);
                   $LatLongchk = getLatLong($hlprdta);
                   $latitude = $LatLongchk['latlong'][0]['latitude'];
                 // echo "<br>";
                   $longitude = $LatLongchk['latlong'][0]['longitude'];
                   $TimeZoneCheck = getTimezone($latitude,$longitude);
                    $timezoneId = $TimeZoneCheck['timeZoneId'];
                   $timezoneName = $TimeZoneCheck['timeZoneName'];
                   //*************get latlong from address ends here
                   
                   $updatedatavenue = array(
                                       'address_1' =>$addressvenue1,
                                       'address_2' =>$addressvenue2,
                                       'country' =>$countryId,
                                       'state'=>$statelistdata,
                                       'city'=>$towndata,
                                       'zip'=>$zipdata,
                                       'venue_lat'=>$latitude,
                                       'venue_long'=>$longitude,
                                       'venue_timezone'=>$timezoneId,
                                       'modified_date'=>date('Y-m-d H:i:s')
                                       );
                   //echo "<pre>";
                   //print_r($updatedatavenue);
                   
                   //$insertvaenueaminity = 
                    $amnty  = count($valchk);
                    if($amnty>0)
                   {
                                      DB::table('venue_amenity_rel')
                                          ->where('venue_id', $venueID)
                                          ->where('v_creator_id', $user_id)
                                          ->delete();
                                      for($i=0;$i<$amnty;$i++)
                                      {
                                                         DB::table('venue_amenity_rel')->insert([
                                                        
                                                         ['venue_id' => $venueID,'v_creator_id' => $user_id, 'amenity_id' => $valchk[$i],'create_date' =>date('Y-m-d H:i:s')]
                                                         ]);
                                      }
                   }
                  $respAr = array();
                            $updatevenueqry = DB::table('venue_master')
                                      ->where('id', $venueID)
                                      ->where('creater_id', $user_id)
                                      ->update($updatedatavenue);
                                      if($updatevenueqry)
                                      {
                                                       //  echo "Data updated successfully";
                                                           $respAr['flag']=1;
                                                       
                                      }else
                                      {
                                                        //echo  "Data not updated succesfully";
                                                            $respAr['flag']=0;
                                      }
                                      if($r == 1)
                                      {
                                       $request->session()->flash('front_successmsgdata_sess', 'Your venue has been created successfully .');
                                       //return redirect('/');
                                       $venuecretaeOredit=1;
                                       //**get nickname starts here
                                      $nicknmres =  $this->getnicknm($venueID,$user_id);
                                       //**get nickname ends here
                                       
                                      }
                   $respAr['venuecretaeedit']=$venuecretaeOredit;
                   $respAr['nicknmdata']= $nicknmres;
                                  //    echo $amnty;
                                     // die;
                     echo json_encode($respAr); 
                   
                //   print_r($addressvenue1);die;
                   //$j = count($addressvenue1);
                   
        }
        //******save venue address ends here
        
         public function getstatevenue(Request $request)
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
    
    public function getcountrystatevenueedit($id,$tablename,$fetchedrow)
    {
                  // echo $fetchedrow;
                   $getcunt_state = DB::table($tablename)->where('id',$id)->first();
                   
                   return $getcunt_state->$fetchedrow;//die;
                   
    }
    
    //*************get nickname strats here
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
                 $seoqry = DB::table('venue_master')
                             ->where('creater_id',$usrID)
                             ->where('id',$venueID)
                             ->select('modified_date')
                             ->first();
                             $rtmodify = $seoqry->modified_date;
                            // echo $rtmodify;
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
                    $nicknmqry = DB::table('venue_master')
                             ->where('creater_id',$usrID)
                             ->where('id',$venueID)
                             ->select('seo_name')
                             ->first();
                             $rtnickname = $nicknmqry->seo_name;
                           //  echo $rtnickname;die;
                             return $rtnickname;
     }
     //*********get nickname ends here
     
     //*********custom function starts here
     
     public function vaildtvenuenicknm($request,$id){
                   $usrnm = trim(addslashes($request->input('nickname')));
                   $output = preg_replace('!\s+!', ' ', $usrnm);
                   //echo $output;die;
                   $chkID =0;
                   $qry = DB::table('venue_master')
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
     
     //******for genere starts
     
      public function getvenueetgenere(Request $request)
    {
            $categoryId = $request->input('categoryID');
            $venueid = $request->input('venueid');
            if($categoryId > 0)
            {
                        //$getGenere = DB::table('skill_master')->where('parent_id',$categoryId)->where('status','1')->get();
                        
                   $getGenere = DB::table('venue_skill_rel')
                   ->join('skill_master', 'venue_skill_rel.skill_sub_id', '=', 'skill_master.id')
                   //->join('orders', 'users.id', '=', 'orders.user_id')
                   ->where('venue_skill_rel.venue_id', '=',$venueid)
                   ->where('venue_skill_rel.skill_id', '=',$categoryId)
                   ->select('skill_master.*','venue_skill_rel.*')
                   ->get();
                   // echo "<pre>";
                   // echo $venueid;
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
          //echo "<pre>";
          //print_r($respAr);
          //echo "</pre>";die;
          echo  json_encode($respAr);
            
    }
     //******forgenere ends
    //******for booking submission starts here
    public function venuebookingsubmission(Request $request)
    {
      $venueownID = $request->input('venueownID');
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

      $getgiguniqueidcount = DB::table('gig_master')->where('giguniqueid',$unicId)->count();
                   if($getgiguniqueidcount=='0'){
                        $unicId = $unicId;               
                   }else{
                        $unicId = $unicId."1";
                   }

       $unicId = "GIG-".uniqid();
      
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
       'type_flag'=>3,
       'artist_id' => $venueownID,
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
                    'member_id'=>$venueownID,
                    'booker_id'=>$sess_id,
                    'type_flag'=>3,
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
    //******for booking submission ends here


    //*********venue menu download starts here
    public function menudownloadvenue($file_name)
    {
          // echo $file_name;die;
          $filennmdownload = base64_decode($file_name);
         // echo $filennm;die;
          //********its working for single file
          $download_path = ( public_path() . '/upload/venue-menu/source-file/' . $filennmdownload );
          return( Response::download( $download_path ) );
    }
    //********veue menu download ends here
}
