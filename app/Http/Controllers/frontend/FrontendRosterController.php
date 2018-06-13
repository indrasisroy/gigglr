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
use View;
use Mail;

class FrontendRosterController extends Controller
{
    
    public function index(Request $request)
    {
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
      return view('front.roster.rosterview',$data);
    }
    
    public function giguserfeeds(Request $request)
    {
        $user_id=0;       
        if ($request->session()->has('front_id_sess'))
        {
            $user_id= $request->session()->get('front_id_sess');
        }
        
        $selecteddate = trim($request->input('selecteddate'));
        $selectedfirstdate = trim($request->input('selectedfirstdate'));
        $selectedlastdate = trim($request->input('selectedlastdate'));
        $evnttypeshowflag = trim($request->input('evnttypeshowflag'));
        $category = trim($request->input('category'));
        $genre = trim($request->input('genre'));
        
        $eventredclockflag=false; $eventstarflag=false; $eventpurpleflag=false; $eventbluebookflag=false;
        
        $profilevents_flag=false;
            
        if(!empty($evnttypeshowflag))
        {
            $evnttypeshowflagAr=explode("||",$evnttypeshowflag);
            
             if(!empty($evnttypeshowflagAr))
            {
                //"REDCLOCK","STARICON","PURPLE","BLUEBOOK"
                
                //"PROFILEEVENTS"
                
                foreach($evnttypeshowflagAr as $evnttypedata)
                {
                    if($evnttypedata=="REDCLOCK") 
                    {
                        $eventredclockflag=true;
                    }
                    elseif($evnttypedata=="STARICON")
                    {
                        $eventstarflag=true;
                    }
                    elseif($evnttypedata=="PURPLE")
                    {
                        $eventpurpleflag=true;
                    }
                    elseif($evnttypedata=="BLUEBOOK")
                    {
                        $eventbluebookflag=true;
                    }
                    elseif($evnttypedata=="PROFILEEVENTSHIDE")
                    {
                        $profilevents_flag=true;
                    }
                    
                }
                
            }
            
        }
        
        
        
         //**** get artist state data from user_master table starts
        $user_city='';
        $wherearum=array();
        $wherearum['id']=$user_id;
       
        $tab_db_um = DB::table("user_master as um");
        $tab_db_um=$tab_db_um->select(DB::raw(" um.city "));   
        $tab_db_um=$tab_db_um->where($wherearum);
        $tab_db_um=$tab_db_um->first();
       
        if(!empty($tab_db_um))
        {
            $user_city=strtolower($tab_db_um->city);
        }
       
        
       
        //**** get artist state data from user_master table ends
        
        
        //**** added for show profile events starts ****
        $redclock_newtb_query1=''; $redclock_newtb_query2='';
        $starclock_newtb_query1='';
        
        $php_srvr_datetime=date('Y-m-d H:i:s');
        
        
        //YELLOWCLOCK
     
        //$profilevents_flag
        
        if($profilevents_flag==true)
        {
            $redclock_newtb_query1=" AND ( gbr.artist_id <>'".$user_id."' AND  gm.type_flag IN (1) ) "; 
            $redclock_newtb_query2=" AND ( gm.artist_id<>".$user_id." and gm.type_flag IN (1) ) ";
            
            $starclock_newtb_query1=" AND ( gm.artist_id<>".$user_id." and  gm.type_flag=1 ) ";
        }
        
        //**** added for show profile events ends ****
        
        
        $redclock_query= " select rcl.*  from (
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,        
        gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (2) and  gm.type_flag IN (1,2,3) and  gm.booker_id=".$user_id."  and gm.booking_status=2
        
        UNION
        
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1) and  gm.type_flag IN (1,2) and  gm.booker_id=".$user_id."  and gm.booking_status=2
        
        and (
        
             gm.artist_id=0 and
        
            gm.id IN (
            
            SELECT distinct gm.`id` FROM `gig_master` as gm
            JOIN `gig_bidrequest` as gbr
            on gm.`id`=gbr.`gigmaster_id`  
            WHERE gm.`gigpostrequestflag` =1 AND  gm.type_flag IN (1,2) AND gm.`artist_id` =0 AND gm.`booking_status` =2 AND gbr.gig_bid_status=1  AND gm.`booker_id`=".$user_id."
            )
        
        )
        
        
        UNION
        
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1) and  gm.type_flag IN (1,2) and  gm.booker_id <>".$user_id."  and gm.booking_status=2
        
        and gm.id IN (
        
        SELECT distinct gm.`id` FROM `gig_master` as gm
        JOIN `gig_bidrequest` as gbr
        on gm.`id`=gbr.`gigmaster_id`
        WHERE gm.`gigpostrequestflag` =1 AND  gm.type_flag IN (1,2) AND
        gm.`artist_id` =0 AND gm.`booking_status` =2 AND
        gbr.gig_bid_status IN (1,2)   AND  (
        
        ( gbr.artist_id=".$user_id." ".$redclock_newtb_query1." )
        or
        gbr.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 )
        
        
        )
        
        
        
        
        )
        

        UNION
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (2)
        
        and  gm.booker_id<>".$user_id."
        and  gm.booking_status=2
        and (
        
        ( gm.artist_id=".$user_id." and gm.type_flag IN (1) ".$redclock_newtb_query2." )
        or
        (gm.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 ) and gm.type_flag IN (2) )
        or
        ( gm.artist_id IN ( select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1 ) and gm.type_flag IN (3) )
        
        )
        
        
        

        ) as rcl
        
        where
        ( DATEDIFF( '".$php_srvr_datetime."' , DATE_FORMAT( rcl.event_end_date_time_ptz , '%Y-%m-%d %H:%i:%s' ) ) <=30 ) AND
        
        DATE_FORMAT(rcl.event_start_date_time_ptz,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
        ";
        
      
        
         $star_clock_query="        
        select scq.* from (
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,        
        gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'STARICON','STARICON') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1,2)  and  gm.booking_status=1 and    gm.booker_id<>".$user_id."
        
        and (
                ( gm.artist_id=".$user_id." and  gm.type_flag=1  ".$starclock_newtb_query1." )
        
                or
                ( gm.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 ) and gm.type_flag IN (2) )
                or
                ( gm.artist_id IN ( select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1 ) and gm.type_flag IN (3) )
                
                )
       
       ) as scq
       
       where    scq.gigmaster_id NOT IN (
       
                        SELECT gigmaster_id FROM `gig_review` WHERE `gigmaster_id` IN (

                        SELECT `id` FROM `gig_master` WHERE `booking_status`=1 and `artist_id`=".$user_id." and `type_flag`=1 
                        UNION
                        SELECT `id` FROM `gig_master` WHERE `booking_status`=1 and `artist_id` IN (

                        select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1

                        ) and `type_flag`=2 

                        UNION
                        SELECT `id` FROM `gig_master` WHERE `booking_status`=1 and `artist_id` IN (

                        select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1

                        ) and `type_flag`=3 


                        )
                        and `artistgroupvenue_id` >0 
       
                        )
       
        AND
       
       ( DATEDIFF( '".$php_srvr_datetime."' , DATE_FORMAT( scq.event_end_date_time_ptz , '%Y-%m-%d %H:%i:%s' ) ) <=30 ) AND
       
       DATE_FORMAT(scq.event_start_date_time_ptz,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
       
        ";       

        $purple_suitcase_query="
        select psq.* from (
       
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'GREENGIG','GREENGIG') as rcsipsbb FROM `gig_master` as gm
       
       
       
        where  gm.gigpostrequestflag IN (1) and gm.type_flag IN (2)
        and   gm.booker_id<>".$user_id." and gm.booking_status IN (1,2) and
       
        gm.artist_id=0 and gm.id  IN (
       
       
             select grpmgg.gigmaster_id from  (
                    SELECT gskr.`group_id`,gskr.`skill_sub_id`,ggsr.`gigmaster_id`,ggsr.`genre` ,
                    ggsr.type_flag ,IF(ISNULL(gbr.`id`),0,gbr.`id`)  as gigbidrqst_id , IF(ISNULL(gbr.artist_id),0,gbr.artist_id)   as gbr_group_id
                    FROM `group_skill_rel`  as gskr
                    
                    JOIN `gig_skill_rel` as ggsr 
                    
                    on gskr.`skill_sub_id` =ggsr.genre and gskr.`group_id` IN (select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1
                    )  and  ggsr.type_flag=2
                    
                    LEFT JOIN gig_bidrequest as gbr on ggsr.`gigmaster_id`=gbr.`gigmaster_id` and gbr.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 )
                    
                    
                    having gigbidrqst_id=0
       
                        ) as grpmgg
       
                    )  and  LOWER(gm.event_city)='".$user_city."' 
       
       
        
        UNION
       
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'GREENGIG','GREENGIG') as rcsipsbb FROM `gig_master` as gm
       
       
        where  gm.gigpostrequestflag IN (1) and gm.type_flag IN (1)
       
        and   gm.booker_id<>".$user_id."
        and gm.artist_id=0       
        and gm.id IN (
       
                       select artmgg.gigmaster_id from  (
                       SELECT uskr.`user_id`,uskr.`skill_sub_id`,ggsr.`gigmaster_id`,ggsr.`genre`,ggsr.type_flag ,
                      
                    IF(ISNULL(gbr.`id`),0,gbr.`id`)  as gigbidrqst_id , IF(ISNULL(gbr.artist_id),0,gbr.artist_id)   as gbr_artist_id
                      
                       FROM `user_skill_rel`  as uskr
                       
                        JOIN `gig_skill_rel` as ggsr
                       
                        on uskr.`skill_sub_id` =ggsr.genre and uskr.`user_id`=".$user_id."  and  ggsr.type_flag=1
                        
                        LEFT JOIN gig_bidrequest as gbr on ggsr.`gigmaster_id`=gbr.`gigmaster_id`
                         
                         having gigbidrqst_id=0 
                        
                        ) as artmgg
                        
                         
       
                     ) and  LOWER(gm.event_city)='".$user_city."' 
                     
       UNION
       
       
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
         gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'PURPLE','PURPLE') as rcsipsbb FROM `gig_master` as gm       
       
        where  gm.gigpostrequestflag IN (1) and gm.type_flag IN (1,2)
       
        and   gm.booker_id=".$user_id."
        and gm.artist_id=0  and   gm.booking_status=2
        
       
        ) as psq
       
        where
        ( DATEDIFF( '".$php_srvr_datetime."' , DATE_FORMAT( psq.event_end_date_time_ptz , '%Y-%m-%d %H:%i:%s' ) ) <=30 ) AND
        DATE_FORMAT(psq.event_start_date_time_ptz,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
       
        ";
        

        $bluebook_query="
        select bbq.* from (
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF(ISNULL(gm.id),'BLUEBOOK','BLUEBOOK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1,2) and  gm.type_flag IN (1,2,3) and  gm.booker_id=".$user_id." and gm.artist_id<>".$user_id."  and gm.booking_status=1
        
        ) as bbq
        
        where bbq.gigmaster_id NOT IN (
       
                        SELECT gigmaster_id FROM `gig_review` WHERE `gigmaster_id` IN (                        
                       
                        SELECT `id` FROM `gig_master` WHERE `booking_status`=1 and `booker_id`=".$user_id."

                        )
                        and  ( `booker_id` >0 and   booker_flag_type=1 )
       
                        )
                        
                        AND
       
       ( DATEDIFF( '".$php_srvr_datetime."' , DATE_FORMAT( bbq.event_end_date_time , '%Y-%m-%d %H:%i:%s' ) ) <=30 ) AND
        
        
        DATE_FORMAT(bbq.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND
        
        STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
        ";
        
        
        $main_qry="";
        
        //if($evnttypeshowflag=="ALL")
        //{
        //    $main_qry.="".$redclock_query." UNION ".$star_clock_query." UNION ".$purple_suitcase_query." UNION ".$bluebook_query;
        //  //  $main_qry.="".$redclock_query." UNION ".$star_clock_query." UNION ".$purple_suitcase_query;
        //}
        //elseif($evnttypeshowflag=="REDCLOCK") 
        //{
        //    $main_qry=$redclock_query;
        //}
        //elseif($evnttypeshowflag=="STARICON")
        //{
        //    $main_qry=$star_clock_query;
        //}
        //elseif($evnttypeshowflag=="PURPLE")
        //{
        //    $main_qry=$purple_suitcase_query;
        //}
        //elseif($evnttypeshowflag=="BLUEBOOK")
        //{
        //    $main_qry=$bluebook_query;
        //}
        //
        //$maingig_qry_data=DB::select($main_qry);
        
        //echo "==maingig_qry_data=><pre>";
        //print_r($maingig_qry_data);
        //echo "</pre>==";
        
        
        //**** now
        
         $unionmerge=''; $unionmergeAr=array();
        
        // $eventredclockflag=false; $eventstarflag=false; $eventpurpleflag=false; $eventbluebookflag=false;
         
        if($eventredclockflag==true)
        {
            $unionmergeAr[]=$redclock_query;
        }
        
        if($eventstarflag==true)
        {
            $unionmergeAr[]=$star_clock_query;
        }
        
        if($eventpurpleflag==true)
        {
            $unionmergeAr[]=$purple_suitcase_query;
        }
        
        if($eventbluebookflag==true)
        {
            $unionmergeAr[]=$bluebook_query;
        }
        
        $unionmerge=implode(" UNION ",$unionmergeAr); //*** merge query accordingly
        
       // $main_qry=" select qprf.* from ( ".$redclock_query." UNION ".$star_clock_query ." )  as qprf ";
        
        if(!empty($unionmerge))
        {
            $getmain_qry=" select qprf.* from ( ".$unionmerge." )  as qprf ";
            
            $totalskillgig_main_qry = "  JOIN
        (SELECT gpsk.gigmaster_id, gpsk.category as category_id, gpsk.name as category_name ,
                        gssk.genre as genre_id, gssk.genre_name as genre_name , gssk.categgenrerel
                        FROM (                       
                                               
                        SELECT GROUP_CONCAT( DISTINCT gsk.gigmaster_id ) AS gigmaster_id, GROUP_CONCAT( DISTINCT gsk.category ) AS category, GROUP_CONCAT( DISTINCT skm.name ) AS name
                        FROM gig_skill_rel AS gsk
                        INNER JOIN skill_master AS skm ON gsk.category = skm.id
                        GROUP BY gsk.gigmaster_id
                       
                       
                        ) AS gpsk
                       
                        LEFT JOIN
                       
                        (
                       
                        SELECT GROUP_CONCAT( DISTINCT gsk.gigmaster_id ) AS gigmaster_id, GROUP_CONCAT( gsk.genre ) AS genre, GROUP_CONCAT( skm.name ) AS genre_name,
                        GROUP_CONCAT( concat(gsk.category,'---',gsk.genre) ) as categgenrerel
                        FROM gig_skill_rel AS gsk
                        INNER JOIN skill_master AS skm ON gsk.genre = skm.id
                        GROUP BY gsk.gigmaster_id
                       
                        ) AS gssk
                       
                        on gpsk.gigmaster_id=gssk.gigmaster_id
       
       ) as gmsrt on qprf.gigmaster_id=gmsrt.gigmaster_id
       
        LEFT JOIN user_master as usm 
       
        on usm.id=qprf.booker_id";
            
            
        $main_qry =  $getmain_qry.$totalskillgig_main_qry;  
            
        }
        
         //**** filtration starts
         
         if( !empty($unionmerge) )
        {
            
            if(!empty($category) && empty($genre))
                     {
                                 
                      $main_qry.=" where ( FIND_IN_SET('".$category."',category_id)  ) ";
                     }
            
            if(!empty($genre) && empty($category) )
            {
                        
             $main_qry.=" where ( FIND_IN_SET('".$genre."',genre_id)  ) ";
            }
        
            if(!empty($category) && !empty($genre) )
                            {
                                        
                             $main_qry.=" where ( FIND_IN_SET('".$category."',category_id)  ) and ( FIND_IN_SET('".$genre."',genre_id)  ) ";
                            }
        }
                        
        //**** filtration ends    
        
        
        //*** send mail starts
           
            //$body = $main_qry; //email body
            //
            //$passarr['adminfrom']="soumik@esolzmail.com";
            //$passarr['emailsub']="prosessional query ".rand();
            //$passarr['emailto']="surajit.sadhukan@esolzmail.com";
            //$passarr['sitename']="prosessional"; $replacefrom=array(); $replaceto=array();
            //$data = array(
            //'replacefrom'=>$replacefrom,'replaceto'=>$replaceto,'email_body'=>$body
            //);
            //$chkmail= Mail::send('emails.emailviewfolder.commonemailtenplate', $data, function ($message) use ($passarr)
            //{
            //
            //$message->from($passarr['adminfrom'], $passarr['sitename']);
            //
            //$message->to($passarr['emailto'])->subject($passarr['emailsub']);
            //
            //});
                 
            //*** send mail ends
        
        
        

          if(!empty($unionmerge)==true)
        {
            $maingig_qry_data=DB::select($main_qry);
        }
        
        //**** now
     
        $cur_php_serv_tz=date_default_timezone_get();
        
        $respAr=array();
        
        if( !empty($maingig_qry_data) )
        {
               foreach($maingig_qry_data as $gigobj)
               {
                
                    $databaselastmonthdate = strtotime(date('Y-m-d H:i:s') . ' -1 month');
                    $event_start_date_time=$gigobj->event_start_date_time;
                    $event_strtdttm_data=date("Y-m-d H:i:s",strtotime($event_start_date_time));
                    
                    //if($databaselastmonthdate < strtotime($event_start_date_time)){
                        
                    $type_flag=$gigobj->type_flag;
                    $type_flag_data='';
                    
                    
                    $event_end_date_time=$gigobj->event_end_date_time;
                    $event_enddttm_data=date("Y-m-d H:i:s",strtotime($event_end_date_time));
                    
                    
                    if( $type_flag==1 )
                    {
                        $type_flag_data=" Artist Event Event Start Date Time-".strtotime($event_start_date_time)." Event End Date Time-".strtotime($event_enddttm_data)." ";
                    }
                    elseif( $type_flag==2 )
                    {
                        $type_flag_data=" Group Event Event Start Date-".strtotime($event_start_date_time)." Event End Date Time-".strtotime($event_enddttm_data)." ";
                    }
                    elseif( $type_flag==3 )
                    {
                        $type_flag_data=" Venue Event Event Start Date-".strtotime($event_start_date_time)." Event End Date Time-".strtotime($event_enddttm_data)." ";
                    }
                   
                   
                    $rcsipsbb=$gigobj->rcsipsbb;
                    
                   //****  check event completed time passed for BLUEBOOK and STARICON starts ****
                    $ev_cmpltd_passed_tm=0;
                        
                    if(($rcsipsbb=='BLUEBOOK')||($rcsipsbb=='STARICON'))
                    {
                        $now_servr = time(); // or your date as well
                        $your_evend_date = strtotime($event_enddttm_data);
                        $datediff_ev_comp = $now_servr - $your_evend_date;
                        $ev_cmpltd_passed_tm= floor($datediff_ev_comp / (60 * 60 ));    //hours  
                        
                        if($now_servr > $your_evend_date)
                        {
                            $rcsipsbb="PROFILEREVIEW";
                        }
                        
                    }
                    //****  check event completed time passed for BLUEBOOK and STARICON ends ****
                   
                    
                   
                    $gigeventrow=array();
                    $gigeventrow['title']=$type_flag_data;
                    $gigeventrow['start']=$event_strtdttm_data;
                    $gigeventrow['end']=$event_strtdttm_data;//$event_enddttm_data;                   
                    //$gigeventrow['end']=$event_enddttm_data;
                    $gigeventrow['evcustomstart']=$event_strtdttm_data;
                    $gigeventrow['evcustomend']=$event_enddttm_data; 
                   
                    $gigeventrow['ev_cmpltd_passed_tm']=$ev_cmpltd_passed_tm; // for BLUEBOOK and  STARICON
                   
                    $gigeventrow['rcsipsbb']=$rcsipsbb;
                    $gigeventrow['giguniqueid']=$gigobj->giguniqueid;
                    $gigeventrow['gigmaster_id']=base64_encode($gigobj->gigmaster_id);    
                     $gigeventrow['ps_tz']=$cur_php_serv_tz;
                    $respAr[]=$gigeventrow;
                   
                    //}
                   
                    
                    



                   
                   
                   
               }
        }
        
        //$respAr=array();
        //
        //$respAr[]=array("title"=>"Meeting","start"=>"2016-06-10 10:30:00","end"=>"2016-06-12 12:30:00","hellotest"=>"me soumik");
        //$respAr[]=array("title"=>"Meeting111","start"=>"2016-06-12 10:31:00","end"=>"2016-06-12 12:30:00");
        //$respAr[]=array("title"=>"Meeting2","start"=>"2016-07-09 11:50:00","end"=>"2016-07-09 12:30:00");
        // print_r($respAr);die;
        echo json_encode($respAr);  
        
    }
    
    public function callrosterleftpanelfunc(Request $request)
    {
        $user_id=0;       
        if ($request->session()->has('front_id_sess'))
        {
            $user_id= $request->session()->get('front_id_sess');
        }
        
        
        //**** get artist state data from user_master table starts
        $user_city='';
        $wherearum=array();
        $wherearum['id']=$user_id;
        
        $tab_db_um = DB::table("user_master as um");
        $tab_db_um=$tab_db_um->select(DB::raw(" um.city "));   
        $tab_db_um=$tab_db_um->where($wherearum);
        $tab_db_um=$tab_db_um->first();
        
        if(!empty($tab_db_um))
        {
        $user_city=strtolower($tab_db_um->city);
        }
        //**** get artist state data from user_master table ends
        
        
        $selectedfirstdate = '';
        $selectedlastdate = '';
        
        $currentDate = trim($request->input('currentDate'));
        $mwd = trim($request->input('mwd'));
        if($mwd == 'month'){
            $date = $currentDate;
            $date = strtotime($date);
            $date = strtotime("+29 day", $date);
            $monthdate = date('Y-m-d', $date);

            $selectedfirstdate = $currentDate;
            $selectedlastdate = $monthdate;
            
        }else if($mwd == 'week'){
            $date = $currentDate;
            $date = strtotime($date);
            $date = strtotime("+6 day", $date);
            $weekdate = date('Y-m-d', $date);

            $selectedfirstdate = $currentDate;
            $selectedlastdate = $weekdate;
            
        }else if($mwd == 'daily'){

            $selectedfirstdate = $currentDate;
            $selectedlastdate = $currentDate;
            
        }

        
        $evnttypeshowflag = trim($request->input('evnttypeshowflag'));
        $category = trim($request->input('category'));
        $genre = trim($request->input('genre'));
        
         $eventredclockflag=false; $eventstarflag=false; $eventpurpleflag=false; $eventbluebookflag=false;
        
        $profilevents_flag=false;
        
        if(!empty($evnttypeshowflag))
        {
            $evnttypeshowflagAr=explode("||",$evnttypeshowflag);
            
             if(!empty($evnttypeshowflagAr))
            {
            
                foreach($evnttypeshowflagAr as $evnttypedata)
                {
                    if($evnttypedata=="REDCLOCK") 
                    {
                        $eventredclockflag=true;
                    }
                    elseif($evnttypedata=="STARICON")
                    {
                        $eventstarflag=true;
                    }
                    elseif($evnttypedata=="PURPLE")
                    {
                        $eventpurpleflag=true;
                    }
                    elseif($evnttypedata=="BLUEBOOK")
                    {
                        $eventbluebookflag=true;
                    }
                    elseif($evnttypedata=="PROFILEEVENTSHIDE")
                    {
                        $profilevents_flag=true;
                    }
                    
                }
                
            }
            
        }
        
        
        
         //**** get artist state data from user_master table starts
        
        
        //echo $mwd;die;
        
        //YELLOWCLOCK
        

        //**** added for show profile events starts ****
        $redclock_newtb_query1=''; $redclock_newtb_query2='';
        $starclock_newtb_query1='';
        
        $php_srvr_datetime=date('Y-m-d H:i:s');
        
        
        //YELLOWCLOCK
     
        //$profilevents_flag
        
        if($profilevents_flag==true)
        {
            $redclock_newtb_query1=" AND ( gbr.artist_id <>'".$user_id."' AND  gm.type_flag IN (1) ) "; 
            $redclock_newtb_query2=" AND ( gm.artist_id<>".$user_id." and gm.type_flag IN (1) ) ";
            
            $starclock_newtb_query1=" AND ( gm.artist_id<>".$user_id." and  gm.type_flag=1 ) ";
        }
        
        //**** added for show profile events ends ****
        
        
        $redclock_query="         
        select rcl.*  from 
        (

        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (2) and  gm.type_flag IN (1,2,3) and  gm.booker_id=".$user_id."  and gm.booking_status=2
        
        UNION
        
              
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1) and  gm.type_flag IN (1,2) and  gm.booker_id=".$user_id."  and gm.booking_status=2
        
        and (
        
             gm.artist_id=0 and
        
            gm.id IN (
            
            SELECT distinct gm.`id` FROM `gig_master` as gm
            JOIN `gig_bidrequest` as gbr
            on gm.`id`=gbr.`gigmaster_id`  
            WHERE gm.`gigpostrequestflag` =1 AND  gm.type_flag IN (1,2) AND gm.`artist_id` =0 AND gm.`booking_status` =2 AND gbr.gig_bid_status=1  AND gm.`booker_id`=".$user_id."
            )
        
        )
 
        
        UNION
        
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1) and  gm.type_flag IN (1,2) and  gm.booker_id <>".$user_id."  and gm.booking_status=2
        
        and gm.id IN (
        
        SELECT distinct gm.`id` FROM `gig_master` as gm
        JOIN `gig_bidrequest` as gbr
        on gm.`id`=gbr.`gigmaster_id`
        WHERE gm.`gigpostrequestflag` =1 AND  gm.type_flag IN (1,2) AND
        gm.`artist_id` =0 AND gm.`booking_status` =2 AND
        gbr.gig_bid_status IN (1,2)   AND  (
        
        
        ( gbr.artist_id=".$user_id." ".$redclock_newtb_query1." )
        
        or
        gbr.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 )
       
        
        )
     )
        
        
        
        
        UNION
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (2)
       
        and   gm.booker_id<>".$user_id."
        and  gm.booking_status=2
        and (
                
        ( gm.artist_id=".$user_id." and gm.type_flag IN (1) ".$redclock_newtb_query2." )
        or
        (gm.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 ) and gm.type_flag IN (2) )
        or
        ( gm.artist_id IN ( select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1 ) and gm.type_flag IN (3) )
        
        )
        
      )
        as rcl

        where
        ( DATEDIFF( '".$php_srvr_datetime."' , DATE_FORMAT( rcl.event_end_date_time_ptz , '%Y-%m-%d %H:%i:%s' ) ) <=30 ) AND
        DATE_FORMAT(rcl.event_start_date_time_ptz,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
        ";
        
 $star_clock_query="        
     
      select scq.* from  (
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'STARICON','STARICON') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1,2)  and  gm.booking_status=1 and    gm.booker_id<>".$user_id."
        
        and (
                
                ( gm.artist_id=".$user_id." and  gm.type_flag=1  ".$starclock_newtb_query1." )
        
                or
                (gm.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 ) and gm.type_flag IN (2) )
                or
                ( gm.artist_id IN ( select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1 ) and gm.type_flag IN (3) )
                
                )
       
       ) as scq

       where 
       
        scq.gigmaster_id NOT IN (
       
                        SELECT gigmaster_id FROM `gig_review` WHERE `gigmaster_id` IN (

                        SELECT `id` FROM `gig_master` WHERE `booking_status`=1 and `artist_id`=".$user_id." and `type_flag`=1 
                        UNION
                        SELECT `id` FROM `gig_master` WHERE `booking_status`=1 and `artist_id` IN (

                        select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1

                        ) and `type_flag`=2 

                        UNION
                        SELECT `id` FROM `gig_master` WHERE `booking_status`=1 and `artist_id` IN (

                        select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1

                        ) and `type_flag`=3 


                        )
                        and  `artistgroupvenue_id` >0 
       
                        )
       
        AND
       
       ( DATEDIFF( '".$php_srvr_datetime."' , DATE_FORMAT( scq.event_end_date_time_ptz , '%Y-%m-%d %H:%i:%s' ) ) <=30 ) AND
       
       DATE_FORMAT(scq.event_start_date_time_ptz,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
       
        ";       
 
        
        $purple_suitcase_query="
      
       select psq.* from (
       
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'GREENGIG','GREENGIG') as rcsipsbb FROM `gig_master` as gm
       
       
       
        where  gm.gigpostrequestflag IN (1) and gm.type_flag IN (2)
        and   gm.booker_id<>".$user_id." and gm.booking_status IN (1,2) and
       
        gm.artist_id=0 and gm.id  IN (
       
       
             select grpmgg.gigmaster_id from  (
                    SELECT gskr.`group_id`,gskr.`skill_sub_id`,ggsr.`gigmaster_id`,ggsr.`genre` ,
                    ggsr.type_flag ,IF(ISNULL(gbr.`id`),0,gbr.`id`)  as gigbidrqst_id , IF(ISNULL(gbr.artist_id),0,gbr.artist_id)   as gbr_group_id
                    FROM `group_skill_rel`  as gskr
                    
                    JOIN `gig_skill_rel` as ggsr 
                    
                    on gskr.`skill_sub_id` =ggsr.genre and gskr.`group_id` IN (select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1
                    )  and  ggsr.type_flag=2
                    
                    LEFT JOIN gig_bidrequest as gbr on ggsr.`gigmaster_id`=gbr.`gigmaster_id` and gbr.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 )
                    
                    
                    having gigbidrqst_id=0
       
                        ) as grpmgg
       
                    )  and  LOWER(gm.event_city)='".$user_city."' 
       
       
        
        UNION
       
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'GREENGIG','GREENGIG') as rcsipsbb FROM `gig_master` as gm
       
       
        where  gm.gigpostrequestflag IN (1) and gm.type_flag IN (1)
       
        and   gm.booker_id<>".$user_id."
        and gm.artist_id=0       
        and gm.id IN (
       
                       select artmgg.gigmaster_id from  (
                       SELECT uskr.`user_id`,uskr.`skill_sub_id`,ggsr.`gigmaster_id`,ggsr.`genre`,ggsr.type_flag ,
                      
                    IF(ISNULL(gbr.`id`),0,gbr.`id`)  as gigbidrqst_id , IF(ISNULL(gbr.artist_id),0,gbr.artist_id)   as gbr_artist_id
                      
                       FROM `user_skill_rel`  as uskr
                       
                        JOIN `gig_skill_rel` as ggsr
                       
                        on uskr.`skill_sub_id` =ggsr.genre and uskr.`user_id`=".$user_id."  and  ggsr.type_flag=1
                        
                        LEFT JOIN gig_bidrequest as gbr on ggsr.`gigmaster_id`=gbr.`gigmaster_id`
                         
                        having gigbidrqst_id=0  
                        
                        ) as artmgg
                        
                         
 
                     ) and  LOWER(gm.event_city)='".$user_city."' 
                     
       UNION
       
       
        
       
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'PURPLE','PURPLE') as rcsipsbb FROM `gig_master` as gm       
       
        where  gm.gigpostrequestflag IN (1) and gm.type_flag IN (1,2)
       
        and   gm.booker_id=".$user_id."
        and gm.artist_id=0  and   gm.booking_status=2
        
       
        ) as psq

        where
        ( DATEDIFF( '".$php_srvr_datetime."' , DATE_FORMAT( psq.event_end_date_time_ptz , '%Y-%m-%d %H:%i:%s' ) ) <=30 ) AND
        DATE_FORMAT(psq.event_start_date_time_ptz,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
       
        ";
        

        
        
        $bluebook_query="
        select bbq.*  from (
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.event_start_date_time_ptz,gm.event_end_date_time_ptz,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF(ISNULL(gm.id),'BLUEBOOK','BLUEBOOK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1,2) and  gm.type_flag IN (1,2,3) and  gm.booker_id=".$user_id." and gm.artist_id<>".$user_id."  and gm.booking_status=1
        
        ) as bbq
              
       
        where bbq.gigmaster_id NOT IN (
       
                        SELECT gigmaster_id FROM `gig_review` WHERE `gigmaster_id` IN (                        
                       
                        SELECT `id` FROM `gig_master` WHERE `booking_status`=1 and `booker_id`=".$user_id."

                        )
                        and  ( `booker_id` >0 and   booker_flag_type=1 )
       
                        )
                        
                        AND
       
       ( DATEDIFF( '".$php_srvr_datetime."' , DATE_FORMAT( bbq.event_end_date_time_ptz , '%Y-%m-%d %H:%i:%s' ) ) <=30 ) AND
       
       DATE_FORMAT(bbq.event_start_date_time_ptz,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
        ";
        
        
        $main_qry="";

        
        
        
         $unionmerge=''; $unionmergeAr=array();
        
        // $eventredclockflag=false; $eventstarflag=false; $eventpurpleflag=false; $eventbluebookflag=false;
         
        if($eventredclockflag==true)
        {
            $unionmergeAr[]=$redclock_query;
        }
        
        if($eventstarflag==true)
        {
            $unionmergeAr[]=$star_clock_query;
        }
        
        if($eventpurpleflag==true)
        {
            $unionmergeAr[]=$purple_suitcase_query;
        }
        
        if($eventbluebookflag==true)
        {
            $unionmergeAr[]=$bluebook_query;
        }
        
        $unionmerge=implode(" UNION ",$unionmergeAr); //*** merge query accordingly
        
       // $main_qry=" select qprf.* from ( ".$redclock_query." UNION ".$star_clock_query ." )  as qprf ";
        
        if(!empty($unionmerge))
        {
            $getmain_qry =" select qprf.* ";
            
            $getmain_qry.=" ,gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel,
            usm.nickname as bk_nickname,
            IF(qprf.type_flag=1, (select nickname from user_master where id=qprf.artist_id),'------') as art_nickname ,
            IF(qprf.type_flag=2, (select nickname from group_master where id=qprf.artist_id),'------') as grp_nickname ,
            IF(qprf.type_flag=3, (select nickname from venue_master where id=qprf.artist_id),'------') as ven_nickname ";
        
            $getmain_qry .= " from ( ".$unionmerge." )  as qprf ";
            
            $totalskillgig_main_qry = "  JOIN
        (SELECT gpsk.gigmaster_id, gpsk.category as category_id, gpsk.name as category_name ,
                        gssk.genre as genre_id, gssk.genre_name as genre_name , gssk.categgenrerel
                        FROM (                       
                                               
                        SELECT GROUP_CONCAT( DISTINCT gsk.gigmaster_id ) AS gigmaster_id, GROUP_CONCAT( DISTINCT gsk.category ) AS category, GROUP_CONCAT( DISTINCT skm.name ) AS name
                        FROM gig_skill_rel AS gsk
                        INNER JOIN skill_master AS skm ON gsk.category = skm.id
                        GROUP BY gsk.gigmaster_id
                       
                       
                        ) AS gpsk
                       
                        LEFT JOIN
                       
                        (
                       
                        SELECT GROUP_CONCAT( DISTINCT gsk.gigmaster_id ) AS gigmaster_id, GROUP_CONCAT( gsk.genre ) AS genre, GROUP_CONCAT( skm.name ) AS genre_name,
                        GROUP_CONCAT( concat(gsk.category,'---',gsk.genre) ) as categgenrerel
                        FROM gig_skill_rel AS gsk
                        INNER JOIN skill_master AS skm ON gsk.genre = skm.id
                        GROUP BY gsk.gigmaster_id
                       
                        ) AS gssk
                       
                        on gpsk.gigmaster_id=gssk.gigmaster_id
       
       ) as gmsrt on qprf.gigmaster_id=gmsrt.gigmaster_id
      
      
       LEFT JOIN user_master as usm 
       
        on usm.id=qprf.booker_id";
            
            
        $main_qry =  $getmain_qry.$totalskillgig_main_qry;  
            
        }
        
         //**** filtration starts
         
         if( !empty($unionmerge) )
        {
            
            if(!empty($category) && empty($genre))
                     {
                                 
                      $main_qry.=" where ( FIND_IN_SET('".$category."',category_id)  ) ";
                     }
            
            if(!empty($genre) && empty($category) )
            {
                        
             $main_qry.=" where ( FIND_IN_SET('".$genre."',genre_id)  ) ";
            }
        
            if(!empty($category) && !empty($genre) )
                            {
                                        
                             $main_qry.=" where ( FIND_IN_SET('".$category."',category_id)  ) and ( FIND_IN_SET('".$genre."',genre_id)  ) ";
                            }
        }
                        
        //**** filtration ends   
        
        //echo $main_qry;die;
        
          $maingig_qry_data = array();
        if(!empty($unionmerge)==true)
        {
            $maingig_qry_data = DB::select($main_qry);
        }
        $data_roster = array();
        $i = 0; $j = 0; $prevgigid=array(); $prevgigimg=''; $gigardata=array(); $gignested = array(); $gigChild = array();
        
        //echo "<pre>";
        //print_r($maingig_qry_data);
        ////echo json_encode($maingig_qry_data);
        //die;
        if(count($maingig_qry_data)>0){
            foreach($maingig_qry_data as $qry_data){
                $booker_id = $qry_data->booker_id;
                $wherearum['id']=$qry_data->booker_id;
                
                    //$gignested[$j]['gigmaster_id'] = $qry_data->gigmaster_id;
                    //$gignested[$j]['type_flag'] = $qry_data->type_flag;
                    
                    
                //echo "<be>====prevgigid=>";print_r($prevgigid);
                
                
                
                
                
                
                if(!(in_array($qry_data->gigmaster_id , $prevgigid )) )
                {
                    $gigChild[$j]['nestedgig'] = $this->loadnestedgig($qry_data->gigmaster_id,$qry_data->type_flag,$user_id);
                    //*******booker name get start******//
                    //$data_roster[$i]['bk_nickname'] = $qry_data->bk_nickname;
                    
                    
                    if($qry_data->booker_id == $user_id){
                       $data_roster[$i]['dhiman'] = '1';
                       if($qry_data->type_flag == '1'){
                           $data_roster[$i]['bk_nickname'] = $qry_data->art_nickname;
                       }else if($qry_data->type_flag == '2'){
                           $data_roster[$i]['bk_nickname'] = $qry_data->grp_nickname;
                       }else if($qry_data->type_flag == '3'){
                           $data_roster[$i]['bk_nickname'] = $qry_data->ven_nickname;
                       }
                   }else{
                       $data_roster[$i]['dhiman'] = '2';
                       $data_roster[$i]['bk_nickname'] = $qry_data->bk_nickname;
                     
                   }
                    
                    
                    
                    
                    
                    //*******booker name get end******//
                    
                    //*******category get start******//
                    $data_roster[$i]['category_name_join'] = $qry_data->category_name;
                    //*******category get end******//
                    
                    //*******genre get start******//
                    $data_roster[$i]['genre_name_join'] = $qry_data->genre_name;
                    //*******genre get end******//
                    $data_roster[$i]['rcsipsbb'] = $qry_data->rcsipsbb;
                    $data_roster[$i]['giguniqueid'] = $qry_data->giguniqueid;
                    $data_roster[$i]['gigmaster_id'] = $qry_data->gigmaster_id;
                    $data_roster[$i]['gigpostrequestflag'] = $qry_data->gigpostrequestflag;
                    $data_roster[$i]['type_flag'] = $qry_data->type_flag;
                    $data_roster[$i]['art_nickname'] = $qry_data->art_nickname;
                    $data_roster[$i]['grp_nickname'] = $qry_data->grp_nickname;
                    $data_roster[$i]['ven_nickname'] = $qry_data->ven_nickname;
                    $data_roster[$i]['booker_id'] = $qry_data->booker_id;
                    $data_roster[$i]['start_date'] = $qry_data->event_start_date_time;
                    $data_roster[$i]['end_date'] = $qry_data->event_end_date_time;
                    $data_roster[$i]['event_city'] = $qry_data->event_city;
                    
                    if($qry_data->rcsipsbb == 'STARICON'){
                        
                        $revi_Gid_id = $qry_data->gigmaster_id;
                        //$maingig_qry_data = DB::select("SELECT * FROM `gig_review` WHERE `gigmaster_id` = '".$revi_Gid_id."'"); $user_id
                        $maingig_qry_data = DB::select("SELECT * FROM `gig_review` WHERE `gigmaster_id` = '".$revi_Gid_id."' and artistgroupvenue_id = '".$user_id."'");
                        if(!empty($maingig_qry_data)){
                            $data_roster[$i]['review'] = '1';
                        }else{
                            $data_roster[$i]['review'] = '0';
                        }
                    }else{
                        $data_roster[$i]['review'] = '';
                    }
                    
                    $gigardata[$qry_data->gigmaster_id]=array("rcsipsbb"=>$qry_data->rcsipsbb,"data_roster_key"=>$i);
                    $prevgigid[]=$qry_data->gigmaster_id;
                    //$prevgigimg=$qry_data->rcsipsbb;
                   // echo "==gigardata==><pre>" ; print_r($gigardata); echo "</pre>";
                }
                else
                {
                    $mtchar=$gigardata[$qry_data->gigmaster_id];
                    $data_roster_key=$mtchar['data_roster_key'];
                    $nowprevimg=$data_roster[$data_roster_key]['rcsipsbb'];//$mtchar['rcsipsbb'];
                    $prevgigimg=explode(",",$nowprevimg);
                        
                    if(!in_array($qry_data->rcsipsbb,$prevgigimg))
                    {       
                        if(array_key_exists($qry_data->gigmaster_id,$gigardata))
                        {
                            $expldnowprevimg=explode(",",$nowprevimg);
                            array_push($expldnowprevimg,$qry_data->rcsipsbb);
                            
                            $nowupdtdimgs=implode(",",$expldnowprevimg);
                            
                            unset($data_roster[$data_roster_key]['rcsipsbb']);
                            $data_roster[$data_roster_key]['rcsipsbb']=$nowupdtdimgs;
                        } 
                     }
                }
                
                $i++;
                $j++;
            }
        }
        //echo "<pre>";
        //print_r($data_roster);
        
        //echo json_encode($gigChild);
        //die;

        $data['maingig_qry_data_result']=$data_roster;
        
        $data['gigChild']=$gigChild;

        //echo json_encode($data);
        //die;
        //return view('front.roster.ajax.rosterleftlistajax',$data);

        $view_obj = View::make('front.roster.ajax.rosterleftlistajax',$data);
        $ep_view_contents = $view_obj->render();
        
        $respAr=array();
        $respAr['respdata']=$ep_view_contents;
        echo json_encode($respAr);
    }
    
    
     public function callrosterleftnestedpanelfunc(Request $request)
    {
        $user_id=0;       
        if ($request->session()->has('front_id_sess'))
        {
            $user_id= $request->session()->get('front_id_sess');
        }
        
        $gigid = trim($request->input('gigid'));
        $gigprotypo = trim($request->input('gigprotypo'));
        
        if($gigprotypo==1)
        {
            $nested_qry="SELECT IF(um2.nickname IS NULL,'N/A',um2.nickname) AS book_req_artist_name,gbr.*,gbr.create_date AS reqdt FROM gig_bidrequest AS gbr INNER JOIN user_master AS um2 ON gbr.artist_id=um2.id WHERE gbr.gigmaster_id='".$gigid."' AND gbr.booker_id='".$user_id."' ORDER BY reqdt ASC";
        }
        elseif($gigprotypo==2)
        {
            $nested_qry="SELECT IF(um2.nickname IS NULL,'N/A',um2.nickname) AS book_req_artist_name,gbr.*,gbr.create_date AS reqdt FROM gig_bidrequest AS gbr INNER JOIN group_master AS um2 ON gbr.artist_id=um2.id WHERE gbr.gigmaster_id='".$gigid."' AND gbr.booker_id='".$user_id."' ORDER BY reqdt ASC";
        }
        elseif($gigprotypo==3)
        {
            $nested_qry="SELECT IF(um2.nickname IS NULL,'N/A',um2.nickname) AS book_req_artist_name,gbr.*,gbr.create_date AS reqdt FROM gig_bidrequest AS gbr INNER JOIN venue_master AS um2 ON gbr.artist_id=um2.id WHERE gbr.gigmaster_id='".$gigid."' AND gbr.booker_id='".$user_id."' ORDER BY reqdt ASC";
        }
            
        $nested_qry_data=DB::select($nested_qry);


        $data['nested_qry_data']=$nested_qry_data;
        
        //*******************17-10-16 added to see gig details start*****************//
        

$session_id = $request->session()->get('front_id_sess');
$get_gig_master = DB::table('gig_master')->where('id',$gigid);
$gig_master_details = $get_gig_master->first();
$booker_id = $gig_master_details->booker_id;
$booking_status = $gig_master_details->booking_status;
$booking_expire_datetime = $gig_master_details->request_expire_datetime;
$type_flag_gig_master = $gig_master_details->type_flag;
$data['gig_master_details']  = $gig_master_details;
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



$data['get_gig_country_details']  = $get_gig_country_details->country_name;
$data['get_gig_state_details']  = $get_gig_state_details->state_name;

$data['get_gig_Cat_details']  = $fetCat_details[0]->name;
$data['get_gig_Gen_details']  = $fetGen_details[0]->name;
$data['divshow']  = "gigmaster";
$view_obj = View::make('front.includefolder.gigrostermodal',$data);
$ep_view_contents = $view_obj->render();
        $respAr=array();
$respAr['flag'] = 1; 
$respAr['ep_contents']=$ep_view_contents;

        //*******************17-10-16 added to see gig details end*****************//

        $view_obj = View::make('front.roster.ajax.rosterleftnestedlistajax',$data);
        $ep_view_contents = $view_obj->render();
        
        
        $respAr['respdata']=$ep_view_contents;
        
        echo json_encode($respAr);
    }
function reviewmodal(Request $request){
    
        $gigid = trim($request->input('gig_uniqueid'));
        $logid = trim($request->input('loginid'));
        $typo = trim($request->input('typo'));
        $gig_master_uniq_id = trim($request->input('gigid'));
        
        $wherearumnew['gigmaster_id']=$gig_master_uniq_id;
        $tab_db_um_new = DB::table("gig_review");
        $tab_db_um_new = $tab_db_um_new->where($wherearumnew);
        $tab_db_um_new = $tab_db_um_new->first();
        //echo json_encode($tab_db_um_new);die;
        if(empty($tab_db_um_new)){
            
            $wherearum['giguniqueid']=$gigid;
            
            $tab_db_um = DB::table("gig_master");
            $tab_db_um = $tab_db_um->where($wherearum);
            $tab_db_um = $tab_db_um->first();
            
            $tab_skill_rel = DB::table("gig_skill_rel");
            $tab_skill_rel = $tab_skill_rel->where('gigmaster_id',$tab_db_um->id);
            $tab_skill_rel = $tab_skill_rel->first();
            
            $datagig_cat = DB::table("skill_master")->select("name")->where('id',$tab_skill_rel->category)->first();
            $datagig_gen = DB::table("skill_master")->select("name")->where('id',$tab_skill_rel->genre)->first();
            
            $data['gig_cat'] = $datagig_cat->name;
            $data['gig_gen'] = $datagig_gen->name;
            
            
            $data['gig_uniqueid'] = $gigid;
            $data['gigpostrequestflag'] = $tab_db_um->gigpostrequestflag;
            $data['type_flag'] = $tab_db_um->type_flag;
            $data['artist_id'] = $tab_db_um->artist_id;
            $data['booker_id'] = $tab_db_um->booker_id;
            $data['gig_city'] = $tab_db_um->event_city;
            $data['gig_date_time'] = $tab_db_um->event_start_date_time;
            $booker_data ='';
            $artist_data ='';
            if($tab_db_um->booker_id != $logid){
    
                $data['usr_typ'] = 'booker';
    
                
                $booker_data = DB::select("SELECT usr.* ,1 as 'tab_type', u_img.`image_name` FROM  `user_master` AS usr LEFT JOIN  `user_master_img` AS u_img ON usr.`id` = u_img.`user_id` and u_img.`default_status`='1' and u_img.`user_id`='".$tab_db_um->booker_id."' where usr.`id`='".$tab_db_um->booker_id."'");
                
            }else{
                $data['usr_typ'] = 'artist';
                if($tab_db_um->type_flag == '1'){
    
                    
                    $artist_data = DB::select("SELECT usr.* ,1 as 'tab_type', u_img.`image_name` FROM  `user_master` AS usr LEFT JOIN  `user_master_img` AS u_img ON usr.`id` = u_img.`user_id` and u_img.`default_status`='1' and u_img.`user_id`='".$tab_db_um->artist_id."' where usr.`id`='".$tab_db_um->artist_id."'");
                    
                }else if($tab_db_um->type_flag == '2'){
    
                    $artist_data = DB::select("SELECT grp.* ,2 as 'tab_type', g_img.`image_name` FROM  `group_master` AS grp join `user_master` as usr LEFT JOIN  `group_master_img` AS g_img ON grp.id = g_img.`group_id` and g_img.`default_status`='1' and g_img.`group_id`= '".$tab_db_um->artist_id."' where grp.`creater_id` = usr.`id` and grp.`id`= '".$tab_db_um->artist_id."'");
    
                }else if($tab_db_um->type_flag == '3'){
    
                    $artist_data = DB::select("SELECT vnu.* ,3 as 'tab_type', v_img.`image_name` FROM  `venue_master` AS vnu join `user_master` as usr LEFT JOIN  `venue_master_img` AS v_img ON vnu.id = v_img.`venue_id` and v_img.`default_status`='1' and v_img.`venue_id`= '".$tab_db_um->artist_id."' where vnu.`creater_id` = usr.`id` and vnu.`id`= '".$tab_db_um->artist_id."'");
                    
                }
            }
    
    
            $data['logid'] = $logid;
            $data['booker_data'] = $booker_data;
            $data['artist_data'] = $artist_data;

            $view_obj = View::make('front.roster.ajax.reviewmodal',$data);
            $ep_view_contents = $view_obj->render();
            
            $respAr=array();
            $respAr['returnflag']='1';
            $respAr['respdata']=$ep_view_contents;
            echo json_encode($respAr);
            exit;
            
        }else{

        $sqlQuery = "SELECT * FROM `gig_review` WHERE `gigmaster_id` = '".$gig_master_uniq_id."' and ((`booker_id` = '".$logid."' and `booker_flag_type` = '".$typo."') or (`artistgroupvenue_id`= '".$logid."' and `artistgroupvenue_flag_type`='".$typo."'))";
        //echo $sqlQuery;die;
        
        $review_check = DB::select(DB::raw($sqlQuery));
        
        //****************exiting review check *******************//
        if(empty($review_check)){
            
            
            $wherearum['giguniqueid']=$gigid;
            
            $tab_db_um = DB::table("gig_master");
            $tab_db_um = $tab_db_um->where($wherearum);
            $tab_db_um = $tab_db_um->first();
            
            $tab_skill_rel = DB::table("gig_skill_rel");
            $tab_skill_rel = $tab_skill_rel->where('gigmaster_id',$tab_db_um->id);
            $tab_skill_rel = $tab_skill_rel->first();
            
            $datagig_cat = DB::table("skill_master")->select("name")->where('id',$tab_skill_rel->category)->first();
            $datagig_gen = DB::table("skill_master")->select("name")->where('id',$tab_skill_rel->genre)->first();
            
            $data['gig_cat'] = $datagig_cat->name;
            $data['gig_gen'] = $datagig_gen->name;
            
            
            $data['gig_uniqueid'] = $gigid;
            $data['gigpostrequestflag'] = $tab_db_um->gigpostrequestflag;
            $data['type_flag'] = $tab_db_um->type_flag;
            $data['artist_id'] = $tab_db_um->artist_id;
            $data['booker_id'] = $tab_db_um->booker_id;
            $data['gig_city'] = $tab_db_um->event_city;
            $data['gig_date_time'] = $tab_db_um->event_start_date_time;
            $booker_data ='';
            $artist_data ='';
            if($tab_db_um->booker_id != $logid){
    
                $data['usr_typ'] = 'booker';
    
                
                $booker_data = DB::select("SELECT usr.* ,1 as 'tab_type', u_img.`image_name` FROM  `user_master` AS usr LEFT JOIN  `user_master_img` AS u_img ON usr.`id` = u_img.`user_id` and u_img.`default_status`='1' and u_img.`user_id`='".$tab_db_um->booker_id."' where usr.`id`='".$tab_db_um->booker_id."'");
                
            }else{
                $data['usr_typ'] = 'artist';
                if($tab_db_um->type_flag == '1'){
    
                    
                    $artist_data = DB::select("SELECT usr.* ,1 as 'tab_type', u_img.`image_name` FROM  `user_master` AS usr LEFT JOIN  `user_master_img` AS u_img ON usr.`id` = u_img.`user_id` and u_img.`default_status`='1' and u_img.`user_id`='".$tab_db_um->artist_id."' where usr.`id`='".$tab_db_um->artist_id."'");
                    
                }else if($tab_db_um->type_flag == '2'){
    
                    $artist_data = DB::select("SELECT grp.* ,2 as 'tab_type', g_img.`image_name` FROM  `group_master` AS grp join `user_master` as usr LEFT JOIN  `group_master_img` AS g_img ON grp.id = g_img.`group_id` and g_img.`default_status`='1' and g_img.`group_id`= '".$tab_db_um->artist_id."' where grp.`creater_id` = usr.`id` and grp.`id`= '".$tab_db_um->artist_id."'");
    
                }else if($tab_db_um->type_flag == '3'){
    
                    $artist_data = DB::select("SELECT vnu.* ,3 as 'tab_type', v_img.`image_name` FROM  `venue_master` AS vnu join `user_master` as usr LEFT JOIN  `venue_master_img` AS v_img ON vnu.id = v_img.`venue_id` and v_img.`default_status`='1' and v_img.`venue_id`= '".$tab_db_um->artist_id."' where vnu.`creater_id` = usr.`id` and vnu.`id`= '".$tab_db_um->artist_id."'");
                    
                }
            }
    
    
            $data['logid'] = $logid;
            $data['booker_data'] = $booker_data;
            $data['artist_data'] = $artist_data;

            $view_obj = View::make('front.roster.ajax.reviewmodal',$data);
            $ep_view_contents = $view_obj->render();
            
            $respAr=array();
            $respAr['returnflag']='1';
            $respAr['respdata']=$ep_view_contents;
            echo json_encode($respAr);
            
        }else{

            $respAr=array();
            $respAr['returnflag']='0';
            $respAr['msg']='You have already given feedback on this event';
            echo json_encode($respAr);
        }
        }
        
        //echo "<pre>";print_r($tab_db_um_new);die;
        


        
        
        
        
        
        
    }
    function reviesubmit(Request $request){
        
        $gigid = trim($request->input('gig_uniqueid'));
        $logid = trim($request->input('loginid'));
        $usr_typ = trim($request->input('usr_typ'));
        $review_description = trim($request->input('review_description'));
        
        //$performance = '';
        //$presentation = '';
        //$punctuality = '';
        //$bkr_hospitality = '';
        //$bkr_environment = '';
        //$bkr_readiness = '';
        $get_gig_master_id = DB::table('gig_master')->select('id')->where('giguniqueid',$gigid)->first();;
        $gigmaster_id = $get_gig_master_id->id;
        $insertarry = array();
        
        $server_tz=date_default_timezone_get();
        
        $insertarry['gigmaster_id'] = $gigmaster_id;
        $insertarry['agv_review_date_tz'] = $server_tz;
        $insertarry['bkr_review_date_tz'] = $server_tz;
        
        //if($usr_typ == 'booker'){
        if($usr_typ == 'artist'){
            
        $insertarry['booker_id'] = $logid;
        $insertarry['booker_flag_type'] = '1';
        
        $performance = trim($request->input('performance'));
        $presentation = trim($request->input('presentation'));
        $punctuality = trim($request->input('punctuality'));
        $insertarry['agv_review_data'] = $review_description;
        $insertarry['agv_review_date'] = date('Y-m-d H:i:s');

        $insertarry['performance'] = $performance;
        $insertarry['presentation'] = $presentation;
        $insertarry['punctuality'] = $punctuality;
        
        
        //}else if($usr_typ == 'artist'){
        }else if($usr_typ == 'booker'){
            
        $review_flag_type = trim($request->input('review_flag_type'));
        
        $insertarry['artistgroupvenue_id'] = $logid;
        $insertarry['artistgroupvenue_flag_type'] = $review_flag_type;
        
        $bkr_hospitality = trim($request->input('bkr_hospitality'));
        $bkr_environment = trim($request->input('bkr_environment'));
        $bkr_readiness = trim($request->input('bkr_readiness'));
        $insertarry['bkr_review_data'] = $review_description;
        $insertarry['bkr_review_date'] = date('Y-m-d H:i:s');
        
        $insertarry['bkr_hospitality'] = $bkr_hospitality;
        $insertarry['bkr_environment'] = $bkr_environment;
        $insertarry['bkr_readiness'] = $bkr_readiness;
        }


        $gig_review_data = DB::table("gig_review");
        $gig_review_data = $gig_review_data->where("gigmaster_id",$gigmaster_id);
        $gig_review_data = $gig_review_data->first();
        
        if(!empty($gig_review_data)){
            $gig_review_data_id = $gig_review_data->id;
            $datainsrt = DB::table('gig_review')
                ->where('id', $gig_review_data_id)
                ->update($insertarry);
        }else{
            $datainsrt = DB::table('gig_review')->insert($insertarry); 
        }
        $resp_arr = array();
        
        if($datainsrt){
            $resp_arr['return_flag'] = $datainsrt;
            $resp_arr['message'] = "Thanks, your review has been submitted";
        }else{
            $resp_arr['return_flag'] = '0';
            $resp_arr['message'] = "Something wrong";
        }
        
        echo json_encode($resp_arr);
        
    }
    
    function frontendrostercalexp(Request $request)
    {
       $seg4=$request->segment(2);
       $seg6=$request->segment(3);
       
       $seg8=date("Y/m/d",$seg4);
       $seg12=date("Y/m/d",$seg6);
       
       $seg2=date("Y-m-d",strtotime($seg8.'+1 days'));
       $seg3=date("Y-m-d",strtotime($seg12.'+1 days'));
       
        if ($request->session()->has('front_id_sess'))
        {
            $sess_user_id= $request->session()->get('front_id_sess');  
        }
        $sessid=$sess_user_id;
       
       $main_qry_exp = DB::select("SELECT gm.*, IF( sm1.name IS NULL, 'N/A', sm1.name ) AS category_name, IF( sm2.name IS NULL, 'N/A', sm2.name ) AS genre_name, IF( gm.booker_id='".$sessid."', 'booker', 'artist' ) AS bookerorartist, lc.country_name AS countryname, ls.state_name AS statename

        FROM gig_master AS gm
        JOIN location_country AS lc ON lc.id = gm.event_country
        JOIN location_state AS ls ON ls.id = gm.event_state
        JOIN gig_skill_rel AS gsr ON gsr.gigmaster_id = gm.id
        INNER JOIN skill_master AS sm1 ON gsr.category = sm1.id
        LEFT JOIN skill_master AS sm2 ON gsr.genre = sm2.id
        
        WHERE ((DATE_FORMAT(gm.event_start_date_time, '%Y-%m-%d') >= '".$seg2."') AND (DATE_FORMAT(gm.event_start_date_time, '%Y-%m-%d') <= '".$seg3."')) AND gm.booking_status != '9'");
               
       $event = array();
       
       if(count($main_qry_exp)>0){
        
            foreach($main_qry_exp as $qry_exp){
                $gigtyp=$qry_exp->gigpostrequestflag;
                $usertyp=$qry_exp->type_flag;
                $bookerorartist=$qry_exp->bookerorartist;
                $skillnm=$qry_exp->category_name;
                $genrenm=$qry_exp->genre_name;
                
                $evnmcontent='';
                if($gigtyp==1)
                {
                    if($bookerorartist=='booker')
                    {
                        if($usertyp==1)
                        {
                            $utyp='artist';
                        }
                        else{
                            $utyp='group';
                        }
                        $evnmcontent='I as a booker posted a gig for '.$utyp.' on '.$genrenm.' genre of '.$skillnm.' skill';
                    }
                    else{
                        if($usertyp==1)
                        {
                            $utyp='my';
                        }
                        else{
                            $utyp="my group's";
                        }
                        $evnmcontent='A gig is posted which matched with '.$utyp.' '.$genrenm.' genre of '.$skillnm.' skill';
                    }
                }
                else{
                    if($bookerorartist=='booker')
                    {
                        if($usertyp==1)
                        {
                            $utyp='an artist';
                        }
                        elseif($usertyp==2)
                        {
                            $utyp='a group';
                        }
                        else{
                            $utyp='a venue';
                        }
                        $evnmcontent='I as a booker have booked '.$utyp.' of '.$genrenm.' genre of '.$skillnm.' skill';
                    }
                    else{
                        if($usertyp==1)
                        {
                            $utyp='I have';
                        }
                        elseif($usertyp==2)
                        {
                            $utyp='my group has';
                        }
                        else{
                            $utyp='my venue has';
                        }
                        $evnmcontent=$utyp.' been booked for an event of '.$genrenm.' genre of '.$skillnm.' skill';
                    }
                }
                
                $evname=$evnmcontent;
                $evdesc=$qry_exp->gig_description;
                $evstdt=$qry_exp->event_start_date_time;
                $evtodt=$qry_exp->event_end_date_time;;
                $evadd1=$qry_exp->event_address1;
                $evadd2=$qry_exp->event_address2;
                $evcity=$qry_exp->event_city;
                $evstate=$qry_exp->statename;
                $evcoun=$qry_exp->countryname;
                $evzip=$qry_exp->event_zip;
                
                $qry_data=array(
                                'event_name'        => $evname,
                                'event_description' => $evdesc,
                                'event_start'       => strtotime($evstdt), 
                                'event_end'         => strtotime($evtodt),
                                'event_venue'       => array(
                                                                    'venue_address'     => $evadd1,
                                                                    'venue_address_two' => $evadd2,
                                                                    'venue_city'        => $evcity,
                                                                    'venue_state'       => $evstate,
                                                                    'venue_country'     => $evcoun,
                                                                    'venue_postal_code' => $evzip
                                                            )
                                );
                array_push($event,$qry_data);
            }
            
            $this->generateCalendarEvents($request,$event);
        }
        //else{
        //    $request->session()->flash('front_errormsgdata_sess', 'Data can not be exported as there is no data in these date range.');
        //    return redirect('/myroster');
        //}
        
        //$data=array();
        //$data['eventCollector']=$event;
        //$data['frm']=$seg2;
        //$data['to']=$seg3;
        //return view('front.roster.expview',$data);
    }
    
    
    function generateCalendarEvents($request,$events)
    {
        $domain         = "prosessional.com"; // DOMAIN NAME GOES HERE
        $eventCollector = '';

        $eventCollector .= "BEGIN:VCALENDAR\n";
        $eventCollector .= "VERSION:2.0\n";
        $eventCollector .= "PRODID:-//{$domain}//NONSGML events//EN\n";
        $eventCollector .= "METHOD:REQUEST\n"; // requied by Outlook
        foreach( $events as $eachEvent ){
            $name        = $eachEvent[ 'event_name' ];
            $venue       = $eachEvent[ 'event_venue' ];
            $location    = $venue[ 'venue_address' ] . ', ' . $venue[ 'venue_address_two' ] . ', ' . $venue[ 'venue_city' ] . ', ' . $venue[ 'venue_state' ] . ', ' . $venue[ 'venue_country' ] . ', ' . $venue[ 'venue_postal_code' ];
            $start       = date('Ymd', $eachEvent[ 'event_start' ] + 18000) . 'T' . date('His', $eachEvent[ 'event_start' ] + 18000) . 'Z';
            $end         = date('Ymd', $eachEvent[ 'event_end' ] + 18000) . 'T' . date('His', $eachEvent[ 'event_end' ] + 18000) . 'Z';
            $description = $eachEvent[ 'event_description' ];
            $expfilenm        = 'samplecal';


            $eventCollector .= "BEGIN:VEVENT\n";
            $eventCollector .= "UID:" . date('Ymd') . 'T' . date('His') . "-" . rand() . "-{$domain}\n"; // required by Outlok
            $eventCollector .= "DTSTAMP:" . date('Ymd') . 'T' . date('His') . "\n"; // required by Outlook
            $eventCollector .= "DTSTART:{$start}\n";
            $eventCollector .= "DTEND:{$end}\n";
            $eventCollector .= "LOCATION:{$location}\n";
            $eventCollector .= "SUMMARY:{$name}\n";
            $eventCollector .= "DESCRIPTION: {$description}\n";
            $eventCollector .= "END:VEVENT\n";
        }
            $eventCollector .= "END:VCALENDAR\n";
            header("Content-Type: text/Calendar; charset=utf-8");
            header("Content-Disposition: attachment;filename=".$expfilenm.".ics ");
            //header("Content-Disposition: inline; filename={$expfilenm}.ics");
            echo $eventCollector;
        
    }
    
    
    function totalexporteddata(Request $request)
   {
        $fromdt=$request->input('fromdt');
        $todt=$request->input('todt');
        
        $seg8=date("Y/m/d",$fromdt);
        $seg12=date("Y/m/d",$todt);
       
        $seg2=date("Y-m-d",strtotime($seg8.'+1 days'));
        $seg3=date("Y-m-d",strtotime($seg12.'+1 days'));
       
        if ($request->session()->has('front_id_sess'))
        {
            $sess_user_id= $request->session()->get('front_id_sess');  
        }
        $sessid=$sess_user_id;
       
       $main_qry_exp = DB::select("SELECT gm.*, IF( sm1.name IS NULL, 'N/A', sm1.name ) AS category_name, IF( sm2.name IS NULL, 'N/A', sm2.name ) AS genre_name, IF( gm.booker_id='".$sessid."', 'booker', 'artist' ) AS bookerorartist, lc.country_name AS countryname, ls.state_name AS statename

        FROM gig_master AS gm
        JOIN location_country AS lc ON lc.id = gm.event_country
        JOIN location_state AS ls ON ls.id = gm.event_state
        JOIN gig_skill_rel AS gsr ON gsr.gigmaster_id = gm.id
        INNER JOIN skill_master AS sm1 ON gsr.category = sm1.id
        LEFT JOIN skill_master AS sm2 ON gsr.genre = sm2.id
        
        WHERE ((DATE_FORMAT(gm.event_start_date_time, '%Y-%m-%d') >= '".$seg2."') AND (DATE_FORMAT(gm.event_start_date_time, '%Y-%m-%d') <= '".$seg3."')) AND gm.booking_status != '9'");
               
        $totaldata=count($main_qry_exp);
       
        $retarr=array();
        $retarr['totaldata']=$totaldata;
       
        echo json_encode($retarr);
   }
   
   
   
   
   
   public function loadnestedgig($gigid,$gigprotypo,$user_id){
    
        if($gigprotypo==1)
            {
                $nested_qry="SELECT IF(um2.nickname IS NULL,'N/A',um2.nickname) AS book_req_artist_name,gbr.*,gbr.create_date AS reqdt FROM gig_bidrequest AS gbr INNER JOIN user_master AS um2 ON gbr.artist_id=um2.id WHERE gbr.gig_bid_status='1' AND gbr.gigmaster_id='".$gigid."' AND gbr.booker_id='".$user_id."' ORDER BY reqdt ASC";
            }
            elseif($gigprotypo==2)
            {
                $nested_qry="SELECT IF(um2.nickname IS NULL,'N/A',um2.nickname) AS book_req_artist_name,gbr.*,gbr.create_date AS reqdt FROM gig_bidrequest AS gbr INNER JOIN group_master AS um2 ON gbr.artist_id=um2.id WHERE gbr.gig_bid_status='1' AND gbr.gigmaster_id='".$gigid."' AND gbr.booker_id='".$user_id."' ORDER BY reqdt ASC";
            }
            elseif($gigprotypo==3)
            {
                $nested_qry="SELECT IF(um2.nickname IS NULL,'N/A',um2.nickname) AS book_req_artist_name,gbr.*,gbr.create_date AS reqdt FROM gig_bidrequest AS gbr INNER JOIN venue_master AS um2 ON gbr.artist_id=um2.id WHERE gbr.gig_bid_status='1' AND gbr.gigmaster_id='".$gigid."' AND gbr.booker_id='".$user_id."' ORDER BY reqdt ASC";
            }
                
            $nested_qry_data=DB::select($nested_qry);
    
            if(!empty($nested_qry_data)){
            //$data['nested_qry_data']['get_gig_country_details']  = '';
            //$data['nested_qry_data']['get_gig_state_details']  = '';
            //$data['nested_qry_data']['get_gig_Cat_details']  = '';
            //$data['nested_qry_data']['get_gig_Gen_details']  = '';
            $data['nested_qry_data']=$nested_qry_data;    
            }else{
                $data['nested_qry_data']=[];
            }
            
            
            //*******************17-10-16 added to see gig details start*****************//
            
    
    $session_id = $user_id;
    $get_gig_master = DB::table('gig_master')->where('id',$gigid);
    $gig_master_details = $get_gig_master->first();
    $booker_id = $gig_master_details->booker_id;
    $booking_status = $gig_master_details->booking_status;
    $booking_expire_datetime = $gig_master_details->request_expire_datetime;
    $type_flag_gig_master = $gig_master_details->type_flag;
    //$data['gig_master_details']  = $gig_master_details;
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
    
    //$data['nested_qry_data']['get_gig_country_details']  = $get_gig_country_details->country_name;
    //$data['nested_qry_data']['get_gig_state_details']  = $get_gig_state_details->state_name;
    //$data['nested_qry_data']['get_gig_Cat_details']  = $fetCat_details[0]->name;
    //$data['nested_qry_data']['get_gig_Gen_details']  = $fetGen_details[0]->name;
    
    $data['gig_id']  = $gigid;
    $data['get_gig_country_details']  = $get_gig_country_details->country_name;
    $data['get_gig_state_details']  = $get_gig_state_details->state_name;
    $data['get_gig_Cat_details']  = $fetCat_details[0]->name;
    $data['get_gig_Gen_details']  = $fetGen_details[0]->name;

    return $data;
    //echo json_encode($data);
   }
   
}

?>