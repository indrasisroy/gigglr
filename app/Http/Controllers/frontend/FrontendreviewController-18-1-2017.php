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

class FrontendreviewController extends Controller
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
             
    }
   
    
    
     public function getreviewdata(Request $request)
    {
           $sessnID =  $request->session()->get('front_id_sess');
           $uu = $request->segment(2);
        
        
           $seo_name=$request->input('seo_name','');
           $type_flag=$request->input('type_flag',0);
           $reviewof=$request->input('reviewof','ASANARTIST');
        
           $query = DB::table('user_master')->select('seo_name')->get();
           $user_id = 0;
        
            if($type_flag==1)
            {
                $user_single = DB::table('user_master')->where('seo_name',$seo_name)->first();
            }
            elseif($type_flag==2)
            {
                $user_single = DB::table('group_master')->where('seo_name',$seo_name)->first();
            }
            elseif($type_flag==3)
            {
                $user_single = DB::table('venue_master')->where('seo_name',$seo_name)->first();
            }
        
           
           if($user_single)
           {
                       $user_id = $user_single->id;
                      
           }
           else
           {
                        $user_id = 0;
           }

         
         //**** fetch  settings - starts
                
                $fetchtype='single'; $tablename="settings";
                $fieldnames=" default_radius,max_radius_limit,record_per_page ";
                $wherear=array();
                $wherear['id']=1;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchfrontwelcomedata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                
                $default_radius=0; $max_radius_limit=100; $record_per_page_data=1;
                if(!empty($fetchfrontwelcomedata))
                {
                     
                     $default_radius=$fetchfrontwelcomedata->default_radius;
                     $max_radius_limit=$fetchfrontwelcomedata->max_radius_limit;
                     $record_per_page_data=$fetchfrontwelcomedata->record_per_page;
                }
               
                
           //**** fetch  from settings - ends
         
         
            
         $ep_view_contents=''; $pagination_link='';

       if(!empty($user_id))
       {
            
           //********************** raw query starts *****************************************
           
            $select_attr_from_ugv='';
               
            if($type_flag==1)
            {
                $listofbookerid=" SELECT `booker_id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 ";   
                
                $listofgigid=" SELECT `id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 "; 
                
                $select_attr_from_ugv=",um.nickname AS showname,um.seo_name,um.city, um.address1, um.address2";
            }
            elseif($type_flag==2)
            {
               $listofbookerid=" SELECT `booker_id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 ";   
                
                $listofgigid=" SELECT `id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 "; 
                
                $select_attr_from_ugv=",um.nickname AS showname,um.seo_name,um.city, um.address1, um.address2";
            }
            elseif($type_flag==3)
            {
               $listofbookerid=" SELECT `booker_id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 ";
                
                $listofgigid=" SELECT `id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 "; 
                
                $select_attr_from_ugv=",um.nickname AS showname,um.seo_name,um.city, um.address1, um.address2";
            }      
               
               
                
                   
           
          $FromBookerReviewquery = "SELECT rrvd . * ,rrvv.category_name,rrvv.genre_name".$select_attr_from_ugv.", 
          
          IF( ISNULL( uimg.image_name )  , 'noimage', uimg.image_name ) AS image_name
               FROM (
                   SELECT `id` AS review_date_id, `gigmaster_id`,`booker_id` AS from_id, `booker_flag_type` AS usertype, `punctuality` AS rev_param_one, `performance` AS rev_param_two,`presentation` AS rev_param_three, `agv_review_data` AS review_description, `agv_review_date` AS review_date, IF( (
               id >0
               ), 'FROMBOOKER', 'FROMBOOKER' ) AS bookertrackerflag
               FROM `gig_review` 
               WHERE `booker_id` IN ( ".$listofbookerid." ) AND `gigmaster_id` IN ( ".$listofgigid." )
               
               AND ( artistgroupvenue_id >0 AND booker_id >0  )
               
                )AS rrvd
              
               
               
               
               ";
               
           
           
            if($type_flag==1)
            {
               $FromBookerReviewquery .="    
               
               INNER JOIN `user_master` AS um ON rrvd.from_id = um.id 
               
               LEFT JOIN  `user_master_img` AS uimg ON rrvd.from_id = uimg.user_id AND uimg.default_status =1  ";
            }
            elseif($type_flag==2)
            {
               $FromBookerReviewquery .="    
               
               INNER JOIN `user_master` AS um ON rrvd.from_id = um.id 
               
               LEFT JOIN  `user_master_img` AS uimg ON rrvd.from_id = uimg.user_id AND uimg.default_status =1  ";
            }
            elseif($type_flag==3)
            {
               $FromBookerReviewquery .="    
               
               INNER JOIN `user_master` AS um ON rrvd.from_id = um.id 
               
               LEFT JOIN  `user_master_img` AS uimg ON rrvd.from_id = uimg.user_id AND uimg.default_status =1  ";
            }   
               
               
           
           $FromBookerReviewquery .="  
               INNER JOIN  (SELECT psk.gigmaster_id, psk.category as category_id, psk.name as category_name,
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
                        
                         on psk.gigmaster_id=ssk.gigmaster_id ) AS rrvv
                        
                         on rrvd.gigmaster_id = rrvv.gigmaster_id";
               
               $NotFromBookerReviewquery = " SELECT rrvd1 . * ,rrvv.category_name,rrvv.genre_name
              FROM (
              
              select revfrmagv.* from (
              
              SELECT gigrev.`id` AS review_date_id,`gigmaster_id`,gigrev.`artistgroupvenue_id` AS from_id, gigrev.artistgroupvenue_flag_type AS usertype,`bkr_hospitality` AS rev_param_one,`bkr_environment` AS rev_param_two, `bkr_readiness` AS rev_param_three, `bkr_review_data` AS review_description, `bkr_review_date` AS review_date,           
               IF( (
              gigrev.id >0
              ), 'NOTFROMBOOKER', 'NOTFROMBOOKER' ) AS bookertrackerflag ,
              
              um.nickname as showname,um.seo_name, um.city, um.address1, um.address2, IF( ISNULL( uimg.image_name )  , 'noimage', uimg.image_name ) AS image_name
              
              FROM `gig_review` as gigrev              
              INNER JOIN `user_master` AS um ON gigrev.artistgroupvenue_id = um.id
              LEFT JOIN  `user_master_img` AS uimg ON gigrev.artistgroupvenue_id = uimg.user_id AND uimg.default_status =1
              
              
              WHERE
              gigrev.`gigmaster_id` IN ( SELECT `id` FROM `gig_master` WHERE `booker_id` ='".$user_id."' AND `booking_status` =1 )
              AND
              gigrev.`booker_id`='".$user_id."' 
              
              AND gigrev.artistgroupvenue_id > 0  
              AND gigrev.artistgroupvenue_flag_type=1
              
              
              
              UNION
              
              
              
               SELECT gigrev.`id` AS review_date_id,`gigmaster_id`,gigrev.`artistgroupvenue_id` AS from_id, gigrev.artistgroupvenue_flag_type AS usertype, `bkr_hospitality` AS rev_param_one,`bkr_environment` AS rev_param_two, `bkr_readiness` AS rev_param_three, `bkr_review_data` AS review_description, `bkr_review_date` AS review_date, IF( (
              gigrev.id >0
              ), 'NOTFROMBOOKER', 'NOTFROMBOOKER' ) AS bookertrackerflag ,
              
              um.nickname as showname,um.seo_name, um.city, um.address_1 as address1, um.address_2 as address2, IF( ISNULL( uimg.image_name )  , 'noimage', uimg.image_name ) AS image_name
              
              FROM `gig_review` as gigrev              
              INNER JOIN `group_master` AS um ON gigrev.artistgroupvenue_id = um.id
              LEFT JOIN  `group_master_img` AS uimg ON gigrev.artistgroupvenue_id = uimg.group_id AND uimg.default_status =1
              
              
              WHERE
              gigrev.`gigmaster_id` IN ( SELECT `id` FROM `gig_master` WHERE `booker_id` ='".$user_id."' AND `booking_status` =1 )
              AND
              gigrev.`booker_id`='".$user_id."' 
              
              AND gigrev.artistgroupvenue_id > 0  
              AND gigrev.artistgroupvenue_flag_type=2
              
              
              UNION
              
              
              
               SELECT gigrev.`id` AS review_date_id,`gigmaster_id`,gigrev.`artistgroupvenue_id` AS from_id, gigrev.artistgroupvenue_flag_type AS usertype, `bkr_hospitality` AS rev_param_one,`bkr_environment` AS rev_param_two, `bkr_readiness` AS rev_param_three, `bkr_review_data` AS review_description, `bkr_review_date` AS review_date, IF( (
              gigrev.id >0
              ), 'NOTFROMBOOKER', 'NOTFROMBOOKER' ) AS bookertrackerflag ,
              
              um.nickname as showname,um.seo_name, um.city, um.address_1 as address1 , um.address_2  as address2, IF( ISNULL( uimg.image_name )  , 'noimage', uimg.image_name ) AS image_name
              
              FROM `gig_review` as gigrev              
              INNER JOIN `venue_master` AS um ON gigrev.artistgroupvenue_id = um.id
              LEFT JOIN  `venue_master_img` AS uimg ON gigrev.artistgroupvenue_id = uimg.venue_id AND uimg.default_status =1
              
              
              WHERE
              gigrev.`gigmaster_id` IN ( SELECT `id` FROM `gig_master` WHERE `booker_id` ='".$user_id."' AND `booking_status` =1 )
              AND
              gigrev.`booker_id`='".$user_id."' 
              
              AND gigrev.artistgroupvenue_id > 0  
              AND gigrev.artistgroupvenue_flag_type=3
              
              
              
              
              
              ) as revfrmagv
              
              
              
               )AS rrvd1
              
              
              
              
             
              
              INNER JOIN  (SELECT psk.gigmaster_id, psk.category as category_id, psk.name as category_name,
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
                        
                         on psk.gigmaster_id=ssk.gigmaster_id ) AS rrvv
                        
                         on rrvd1.gigmaster_id = rrvv.gigmaster_id ";
           
           //********************** raw query ends *****************************************
           
              
                $unionmerge='';
                
                $unionmergeAr=array();
                
               // $unionmergeAr[]=$FromBookerReviewquery;
               
               //echo "<br>==FromBookerReviewquery=>".$FromBookerReviewquery;
               //   echo "<br>==NotFromBookerReviewquery=>". $NotFromBookerReviewquery;
                 
               //echo $reviewof;
               
                if($type_flag==1 && ($reviewof=='ASABOOKER'))
                {                 
                    $unionmergeAr[]=$NotFromBookerReviewquery; // for artist extra query , when artist is getting review as a booker 
                    
                }
               else //ASANARTIST
                {                 
                    $unionmergeAr[]=$FromBookerReviewquery; // for artist extra query , when artist is getting review as a booker 
                    
                }
                
                 
                $unionmerge=implode(" UNION ",$unionmergeAr); //*** merge query accordingly
               
                $getreviewmain_qry='';
               
                if(!empty($unionmerge))
                {
                    $getreviewmain_qry=" SELECT revw.* FROM ( ".$unionmerge." )  as revw  order by revw.review_date desc ";

                }
               
               
               
               $review_data=array();
               
                  if(!empty($getreviewmain_qry)==true)
                {
                     $review_data=DB::select($getreviewmain_qry);
                }
                // echo "<pre>";
                // print_r($review_data);
                // die;
               
               
               //****** for pagination starts****************************************
            
       
                $totaldata=0; //*** total count data
                if(!empty($review_data))
                {
                    $totaldata=count($review_data);
                }



                //**** calculate total pages starts

                $record_per_page=$record_per_page_data;
                $record_per_page=(empty($record_per_page)==true)?1:$record_per_page;

               //$record_per_page=2;
                $totpages=ceil($totaldata/$record_per_page);

                //**** calculate total pages ends


                $pagenum=  $request->input('pagenum','1') ; $startlimit=0; 
                if(!empty($pagenum))
                {
                    if($pagenum>1)
                    {
                        $startlimit=($pagenum-1)*($record_per_page);
                    }
                }

                // $testme="==pagenum=>".$pagenum."===startlimit=>".$startlimit;

                $review_data_lim_qry=$getreviewmain_qry." limit ".$startlimit.",".$record_per_page;
                $review_data_lim=DB::select($review_data_lim_qry);

                 //echo "==<br>review_data_lim_qry==>".$review_data_lim_qry;

                //*** call pagination starts

                // echo "=main_srch_union_lim=>$$$$$ ".$main_srch_union_lim." $$$$$"; 

                $reload="";
                $page=$pagenum;$tpages=$totpages;$ajaxstatus=1;

                $pagination_link=paginatecustom($reload, $page, $tpages,$ajaxstatus);
           
                //*** call pagination ends
            
            
            
            //****** for pagination ends*************************************************
               
               
               
               
               
               
                  $data['user_testi']=$review_data_lim;
                  $data['artistusr_id'] = $user_id;
                  $data['atrist_sessionID'] = $sessnID;
               
                 $view_obj = View::make('front.user.ajax.profilereviewajax',$data);
                 $ep_view_contents = $view_obj->render(); //echo $ep_view_contents;
                 //$ep_view_contents = $view_obj;
               
               
           }
                
                $respAr=array();
            
                $respAr['respdata']=$ep_view_contents;
                $respAr['pagination_link']=$pagination_link;
                
                echo json_encode($respAr);
     
    }
    
    function checkreviewdatatopopulate(Request $request)
    {
           $sessnID =  $request->session()->get('front_id_sess');
           $uu = $request->segment(2);
        
        
           $seo_name=$request->input('seo_name','');
           $type_flag=$request->input('type_flag',0);
           $reviewof=$request->input('reviewof','ASANARTIST'); //ASANARTIST ASABOOKER
        
           $query = DB::table('user_master')->select('seo_name')->get();
           $user_id = 0;
        
            if($type_flag==1)
            {
                $user_single = DB::table('user_master')->where('seo_name',$seo_name)->first();
            }
            elseif($type_flag==2)
            {
                $user_single = DB::table('group_master')->where('seo_name',$seo_name)->first();
            }
            elseif($type_flag==3)
            {
                $user_single = DB::table('venue_master')->where('seo_name',$seo_name)->first();
            }
        
           
           if($user_single)
           {
                       $user_id = $user_single->id;
                      
           }
           else
           {
                        $user_id = 0;
           }

         
         //**** fetch  settings - starts
                
                $fetchtype='single'; $tablename="settings";
                $fieldnames=" default_radius,max_radius_limit,record_per_page ";
                $wherear=array();
                $wherear['id']=1;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchfrontwelcomedata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                
                $default_radius=0; $max_radius_limit=100; $record_per_page_data=1;
                if(!empty($fetchfrontwelcomedata))
                {
                     
                     $default_radius=$fetchfrontwelcomedata->default_radius;
                     $max_radius_limit=$fetchfrontwelcomedata->max_radius_limit;
                     $record_per_page_data=$fetchfrontwelcomedata->record_per_page;
                }
               
                
         //**** fetch  from settings - ends
         
         $tot_rev_recv_as_booker=0;
         $tot_rev_recv_as_artgrpven=0;
         

           if(!empty($user_id))
           {
               
           
               //********************** raw query starts *****************************************
           
            $select_attr_from_ugv='';
               
            if($type_flag==1)
            {
                $listofbookerid=" SELECT `booker_id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 ";   
                
                $listofgigid=" SELECT `id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 "; 
                
                $select_attr_from_ugv=",um.nickname AS showname,um.seo_name,um.city, um.address1, um.address2";
            }
            elseif($type_flag==2)
            {
               $listofbookerid=" SELECT `booker_id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 ";   
                
                $listofgigid=" SELECT `id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 "; 
                
                $select_attr_from_ugv=",um.nickname AS showname,um.seo_name,um.city, um.address1, um.address2";
            }
            elseif($type_flag==3)
            {
               $listofbookerid=" SELECT `booker_id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 ";
                
                $listofgigid=" SELECT `id` FROM `gig_master` WHERE `artist_id`='".$user_id."' and `type_flag`='".$type_flag."' and `booking_status`=1 "; 
                
                $select_attr_from_ugv=",um.nickname AS showname,um.seo_name,um.city, um.address1, um.address2";
            }      
               
               
                
                   
           
          $FromBookerReviewquery = "SELECT rrvd . * ,rrvv.category_name,rrvv.genre_name".$select_attr_from_ugv.", 
          
          IF( ISNULL( uimg.image_name )  , 'noimage', uimg.image_name ) AS image_name
               FROM (
                   SELECT `id` AS review_date_id, `gigmaster_id`,`booker_id` AS from_id, `booker_flag_type` AS usertype, `bkr_hospitality` AS rev_param_one,`bkr_environment` AS rev_param_two, `bkr_readiness` AS rev_param_three, `bkr_review_data` AS review_description, `bkr_review_date` AS review_date, IF( (
               id >0
               ), 'FROMBOOKER', 'FROMBOOKER' ) AS bookertrackerflag
               FROM `gig_review` 
               WHERE `booker_id` IN ( ".$listofbookerid." ) AND `gigmaster_id` IN ( ".$listofgigid." )
               
               AND ( artistgroupvenue_id >0 AND booker_id >0  )
               
                )AS rrvd
              
               
               
               
               ";
               
           
           
            if($type_flag==1)
            {
               $FromBookerReviewquery .="    
               
               INNER JOIN `user_master` AS um ON rrvd.from_id = um.id 
               
               LEFT JOIN  `user_master_img` AS uimg ON rrvd.from_id = uimg.user_id AND uimg.default_status =1 AND uimg.user_id='".$user_id."' ";
            }
            elseif($type_flag==2)
            {
               $FromBookerReviewquery .="    
               
               INNER JOIN `user_master` AS um ON rrvd.from_id = um.id 
               
               LEFT JOIN  `user_master_img` AS uimg ON rrvd.from_id = uimg.user_id AND uimg.default_status =1 AND uimg.user_id='".$user_id."' ";
            }
            elseif($type_flag==3)
            {
               $FromBookerReviewquery .="    
               
               INNER JOIN `user_master` AS um ON rrvd.from_id = um.id 
               
               LEFT JOIN  `user_master_img` AS uimg ON rrvd.from_id = uimg.user_id AND uimg.default_status =1 AND uimg.user_id='".$user_id."' ";
            }   
               
               
           
           $FromBookerReviewquery .="  
               INNER JOIN  (SELECT psk.gigmaster_id, psk.category as category_id, psk.name as category_name,
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
                        
                         on psk.gigmaster_id=ssk.gigmaster_id ) AS rrvv
                        
                         on rrvd.gigmaster_id = rrvv.gigmaster_id";
               
               $NotFromBookerReviewquery = " SELECT rrvd1 . * ,rrvv.category_name,rrvv.genre_name
              FROM (
              
              select revfrmagv.* from (
              
              SELECT gigrev.`id` AS review_date_id,`gigmaster_id`,gigrev.`artistgroupvenue_id` AS from_id, gigrev.artistgroupvenue_flag_type AS usertype, `punctuality` AS rev_param_one, `performance` AS rev_param_two,`presentation` AS rev_param_three, `agv_review_data` AS review_description, `agv_review_date` AS review_date, IF( (
              gigrev.id >0
              ), 'NOTFROMBOOKER', 'NOTFROMBOOKER' ) AS bookertrackerflag ,
              
              um.nickname as showname,um.seo_name, um.city, um.address1, um.address2, IF( ISNULL( uimg.image_name )  , 'noimage', uimg.image_name ) AS image_name
              
              FROM `gig_review` as gigrev              
              INNER JOIN `user_master` AS um ON gigrev.artistgroupvenue_id = um.id
              LEFT JOIN  `user_master_img` AS uimg ON gigrev.artistgroupvenue_id = uimg.user_id AND uimg.default_status =1
              
              
              WHERE
              gigrev.`gigmaster_id` IN ( SELECT `id` FROM `gig_master` WHERE `booker_id` ='".$user_id."' AND `booking_status` =1 )
              AND
              gigrev.`booker_id`='".$user_id."' 
              
              AND gigrev.artistgroupvenue_id > 0  
              AND gigrev.artistgroupvenue_flag_type=1
              
              
              
              UNION
              
              
              
               SELECT gigrev.`id` AS review_date_id,`gigmaster_id`,gigrev.`artistgroupvenue_id` AS from_id, gigrev.artistgroupvenue_flag_type AS usertype, `punctuality` AS rev_param_one, `performance` AS rev_param_two,`presentation` AS rev_param_three, `agv_review_data` AS review_description, `agv_review_date` AS review_date, IF( (
              gigrev.id >0
              ), 'NOTFROMBOOKER', 'NOTFROMBOOKER' ) AS bookertrackerflag ,
              
              um.nickname as showname,um.seo_name, um.city, um.address_1 as address1, um.address_2 as address2, IF( ISNULL( uimg.image_name )  , 'noimage', uimg.image_name ) AS image_name
              
              FROM `gig_review` as gigrev              
              INNER JOIN `group_master` AS um ON gigrev.artistgroupvenue_id = um.id
              LEFT JOIN  `group_master_img` AS uimg ON gigrev.artistgroupvenue_id = uimg.group_id AND uimg.default_status =1
              
              
              WHERE
              gigrev.`gigmaster_id` IN ( SELECT `id` FROM `gig_master` WHERE `booker_id` ='".$user_id."' AND `booking_status` =1 )
              AND
              gigrev.`booker_id`='".$user_id."' 
              
              AND gigrev.artistgroupvenue_id > 0  
              AND gigrev.artistgroupvenue_flag_type=2
              
              
              UNION
              
              
              
               SELECT gigrev.`id` AS review_date_id,`gigmaster_id`,gigrev.`artistgroupvenue_id` AS from_id, gigrev.artistgroupvenue_flag_type AS usertype, `punctuality` AS rev_param_one, `performance` AS rev_param_two,`presentation` AS rev_param_three, `agv_review_data` AS review_description, `agv_review_date` AS review_date, IF( (
              gigrev.id >0
              ), 'NOTFROMBOOKER', 'NOTFROMBOOKER' ) AS bookertrackerflag ,
              
              um.nickname as showname,um.seo_name, um.city, um.address_1 as address1 , um.address_2  as address2, IF( ISNULL( uimg.image_name )  , 'noimage', uimg.image_name ) AS image_name
              
              FROM `gig_review` as gigrev              
              INNER JOIN `venue_master` AS um ON gigrev.artistgroupvenue_id = um.id
              LEFT JOIN  `venue_master_img` AS uimg ON gigrev.artistgroupvenue_id = uimg.venue_id AND uimg.default_status =1
              
              
              WHERE
              gigrev.`gigmaster_id` IN ( SELECT `id` FROM `gig_master` WHERE `booker_id` ='".$user_id."' AND `booking_status` =1 )
              AND
              gigrev.`booker_id`='".$user_id."' 
              
              AND gigrev.artistgroupvenue_id > 0  
              AND gigrev.artistgroupvenue_flag_type=3
              
              
              
              
              
              ) as revfrmagv
              
              
              
               )AS rrvd1
              
              
              
              
             
              
              INNER JOIN  (SELECT psk.gigmaster_id, psk.category as category_id, psk.name as category_name,
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
                        
                         on psk.gigmaster_id=ssk.gigmaster_id ) AS rrvv
                        
                         on rrvd1.gigmaster_id = rrvv.gigmaster_id ";
           
           //********************** raw query ends *****************************************
              
                $unionmerge='';
                
                $unionmergeAr=array();
                
               // $unionmergeAr[]=$FromBookerReviewquery;
               
               //echo "<br>==FromBookerReviewquery=>".$FromBookerReviewquery;
               //   echo "<br>==NotFromBookerReviewquery=>". $NotFromBookerReviewquery;
                 
               //echo $reviewof;
               
                
                
                if($type_flag==1)
                {                 
                    $qry_revgotasbooker=$NotFromBookerReviewquery; // for artist extra query , when artist is getting review as a booker 
                    $qry_revgotasartgrpven=$FromBookerReviewquery;
                    
                     $review_data_received_asbooker=array();
                     $review_data_received_asbooker=DB::select($qry_revgotasbooker);
                     $tot_rev_recv_as_booker=count($review_data_received_asbooker);
                    /*if($reviewof=="ASABOOKER")
                    {
                       
                    }*/
                    
                    $review_data_received_asartgrpven=array();
                    $review_data_received_asartgrpven=DB::select($qry_revgotasartgrpven);
                    $tot_rev_recv_as_artgrpven=count($review_data_received_asartgrpven);
                    /*if($reviewof=="ASANARTIST")
                    {
                         
                    }*/
                   
                    
                    
                }
               
                
               
            
                // echo "<pre>";
                // print_r($review_data);
                // die;
               
               
               //****** for pagination starts****************************************
            
       
                


               
               
           }
                
                $respAr=array();            
                $respAr['tot_rev_recv_as_booker']=$tot_rev_recv_as_booker;
                $respAr['tot_rev_recv_as_artgrpven']=$tot_rev_recv_as_artgrpven;
                $respAr['reviewof']=$reviewof;
                
                
                echo json_encode($respAr);
     
    }




}