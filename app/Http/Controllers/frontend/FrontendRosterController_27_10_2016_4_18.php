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
        
        $eventredclockflag=false; $eventstarflag=false; $eventpurpleflag=false; $eventbluebookflag=false;
        
        
        if(!empty($evnttypeshowflag))
        {
            $evnttypeshowflagAr=explode("||",$evnttypeshowflag);
            
             if(!empty($evnttypeshowflagAr))
            {
                //"REDCLOCK","STARICON","PURPLE","BLUEBOOK"
                
                
                
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
        
        //YELLOWCLOCK
        $redclock_query="         
        select rcl.*  from 
        (
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (2) and  gm.type_flag IN (1,2,3) and  gm.booker_id=".$user_id."  and gm.booking_status=2
        
        UNION
        
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
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
        gbr.gig_bid_status=1   AND  (
        
        gbr.artist_id=".$user_id."
        or
        gbr.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 )
       
        
        )
        )
        
        
        
        
        UNION
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (2)
       
        and   gm.booker_id<>".$user_id."
        and  gm.booking_status=2
        and (
        
        ( gm.artist_id=".$user_id." and gm.type_flag IN (1)  )
        or
        (gm.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 ) and gm.type_flag IN (2) )
        or
        ( gm.artist_id IN ( select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1 ) and gm.type_flag IN (3) )
        
        )
        
       
        
        
        
        ) as rcl
        
        where DATE_FORMAT(rcl.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
        ";
        
         $star_clock_query="        
        select scq.* from (
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'STARICON','STARICON') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1,2)  and  gm.booking_status=1 and    gm.booker_id<>".$user_id."
        
        and (
                ( gm.artist_id=".$user_id." and  gm.type_flag=1 )
        
                or
                (gm.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 ) and gm.type_flag IN (2) )
                or
                ( gm.artist_id IN ( select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1 ) and gm.type_flag IN (3) )
                
                )
       
       ) as scq
       
       where   DATE_FORMAT(scq.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
       
        ";       

        
        $purple_suitcase_query="
        select psq.* from (
       
       
       
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
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
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'PURPLE','PURPLE') as rcsipsbb FROM `gig_master` as gm       
       
        where  gm.gigpostrequestflag IN (1) and gm.type_flag IN (1,2)
       
        and   gm.booker_id=".$user_id."
        and gm.artist_id=0  and   gm.booking_status=2
        
        
       
       
                     
                     
     
       
        ) as psq
       
        where   DATE_FORMAT(psq.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
       
        ";
        
        $bluebook_query="
        select bbq.* from (
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF(ISNULL(gm.id),'BLUEBOOK','BLUEBOOK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1,2) and  gm.type_flag IN (1,2,3) and  gm.booker_id=".$user_id." and gm.artist_id<>".$user_id."  and gm.booking_status=1
        
        ) as bbq
        
        where DATE_FORMAT(bbq.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
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
            $main_qry=" select qprf.* from ( ".$unionmerge." )  as qprf ";
        }
        
          if(!empty($unionmerge)==true)
        {
            $maingig_qry_data=DB::select($main_qry);
        }
        
        //**** now
     
        
        $respAr=array();
        
        if( !empty($maingig_qry_data) )
        {
               foreach($maingig_qry_data as $gigobj)
               {
                
                    $type_flag=$gigobj->type_flag;
                    $type_flag_data='';
                    
                    
                    $event_start_date_time=$gigobj->event_start_date_time;
                    $event_strtdttm_data=date("Y-m-d H:i:s",strtotime($event_start_date_time));
                    
                    $event_end_date_time=$gigobj->event_end_date_time;
                    $event_enddttm_data=date("Y-m-d H:i:s",strtotime($event_end_date_time));
                    
                    if( $type_flag==1 )
                    {
                        $type_flag_data=" Artist Event  Event Start Date Time-".strtotime($event_start_date_time)." Event End Date Time-".strtotime($event_enddttm_data)." ";
                    }
                    elseif( $type_flag==2 )
                    {
                        $type_flag_data=" Group Event Event Start Date-".strtotime($event_start_date_time)." Event End Date Time-".strtotime($event_enddttm_data)." ";
                    }
                    elseif( $type_flag==3 )
                    {
                        $type_flag_data=" Venue Event Event Start Date-".strtotime($event_start_date_time)." Event End Date Time-".strtotime($event_enddttm_data)." ";
                    }
                    
                    $gigeventrow=array();
                    $gigeventrow['title']=$type_flag_data;
                    $gigeventrow['start']=$event_strtdttm_data;
                    $gigeventrow['end']=$event_enddttm_data;
                    $gigeventrow['start']=$event_strtdttm_data;
                    //$gigeventrow['end']=$event_enddttm_data;
                    $gigeventrow['evcustomstart']=$event_strtdttm_data;
                    $gigeventrow['evcustomend']=$event_enddttm_data; 
                    
                    $gigeventrow['rcsipsbb']=$gigobj->rcsipsbb;
                    $gigeventrow['giguniqueid']=$gigobj->giguniqueid;
                    $gigeventrow['gigmaster_id']=base64_encode($gigobj->gigmaster_id);
                   
                    $respAr[]=$gigeventrow;
                
               }
        }
        
         //*** send mail starts
           
            //$body = $redclock_query; //email body
            //
            //$passarr['adminfrom']="soumik@esolzmail.com";
            //$passarr['emailsub']="prosessional query ".rand();
            //$passarr['emailto']="soumik@esolzmail.com";
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
        
        
        
        //$respAr=array();
        //
        //$respAr[]=array("title"=>"Meeting","start"=>"2016-06-10 10:30:00","end"=>"2016-06-12 12:30:00","hellotest"=>"me soumik");
        //$respAr[]=array("title"=>"Meeting111","start"=>"2016-06-12 10:31:00","end"=>"2016-06-12 12:30:00");
        //$respAr[]=array("title"=>"Meeting2","start"=>"2016-07-09 11:50:00","end"=>"2016-07-09 12:30:00");
        
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
        
        
         $eventredclockflag=false; $eventstarflag=false; $eventpurpleflag=false; $eventbluebookflag=false;
        
        
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
                    
                }
                
            }
            
        }
        
        
        
         //**** get artist state data from user_master table starts
        
        
        //echo $mwd;die;
        
        //YELLOWCLOCK
        $redclock_query="         
        select rcl.*,gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name ,
        gmsrt.categgenrerel, usm.nickname as bk_nickname,
        IF(rcl.type_flag=1, (select nickname from user_master where id=rcl.artist_id),'------') as art_nickname ,
        IF(rcl.type_flag=2, (select nickname from group_master where id=rcl.artist_id),'------') as grp_nickname ,
        IF(rcl.type_flag=3, (select nickname from venue_master where id=rcl.artist_id),'------') as ven_nickname
        from 
        (
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (2) and  gm.type_flag IN (1,2,3) and  gm.booker_id=".$user_id."  and gm.booking_status=2
        
        UNION
        
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
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
        gbr.gig_bid_status=1   AND  (
        
        gbr.artist_id=".$user_id."
        or
        gbr.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 )
       
        
        )
        )
        
        
        
        
        UNION
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (2)
       
        and   gm.booker_id<>".$user_id."
        and  gm.booking_status=2
        and (
        
        ( gm.artist_id=".$user_id." and gm.type_flag IN (1)  )
        or
        (gm.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 ) and gm.type_flag IN (2) )
        or
        ( gm.artist_id IN ( select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1 ) and gm.type_flag IN (3) )
        
        )
        
       
        
        
        
        ) as rcl
        
        
        
        
        JOIN
        (
        
        SELECT gpsk.gigmaster_id, gpsk.category as category_id, gpsk.name as category_name ,
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
       
       ) as gmsrt
       
       on rcl.gigmaster_id=gmsrt.gigmaster_id
        
        
        LEFT JOIN user_master as usm 

        on usm.id=rcl.booker_id
        
        
        
        where DATE_FORMAT(rcl.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
        ";
        
 $star_clock_query="        
        select scq.*,gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel,
        usm.nickname as bk_nickname,
        IF(scq.type_flag=1, (select nickname from user_master where id=scq.artist_id),'------') as art_nickname ,
        IF(scq.type_flag=2, (select nickname from group_master where id=scq.artist_id),'------') as grp_nickname ,
        IF(scq.type_flag=3, (select nickname from venue_master where id=scq.artist_id),'------') as ven_nickname
        from (
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'STARICON','STARICON') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1,2)  and  gm.booking_status=1 and    gm.booker_id<>".$user_id."
        
        and (
                ( gm.artist_id=".$user_id." and  gm.type_flag=1 )
        
                or
                (gm.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 ) and gm.type_flag IN (2) )
                or
                ( gm.artist_id IN ( select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1 ) and gm.type_flag IN (3) )
                
                )
       
       ) as scq
       
       
       JOIN
        (
        
        SELECT gpsk.gigmaster_id, gpsk.category as category_id, gpsk.name as category_name ,
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
       
       ) as gmsrt
       
       on scq.gigmaster_id=gmsrt.gigmaster_id
       
       
       LEFT JOIN user_master as usm 

       on usm.id=scq.booker_id
       
       where   DATE_FORMAT(scq.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
       
        ";       

        
        $purple_suitcase_query="
        select psq.* ,gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel ,
        usm.nickname as bk_nickname,
        IF(psq.type_flag=1, (select nickname from user_master where id=psq.artist_id),'------') as art_nickname ,
        IF(psq.type_flag=2, (select nickname from group_master where id=psq.artist_id),'------') as grp_nickname ,
        IF(psq.type_flag=3, (select nickname from venue_master where id=psq.artist_id),'------') as ven_nickname
        from (
       
       
       
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
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
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'PURPLE','PURPLE') as rcsipsbb FROM `gig_master` as gm       
       
        where  gm.gigpostrequestflag IN (1) and gm.type_flag IN (1,2)
       
        and   gm.booker_id=".$user_id."
        and gm.artist_id=0  and   gm.booking_status=2
        
        
       
       
                     
                     
     
       
        ) as psq
        
        
        JOIN
        (
        
        SELECT gpsk.gigmaster_id, gpsk.category as category_id, gpsk.name as category_name ,
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
       
       ) as gmsrt
       
       on psq.gigmaster_id=gmsrt.gigmaster_id
       
       LEFT JOIN user_master as usm 

        on usm.id=psq.booker_id
       
        where   DATE_FORMAT(psq.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
       
        ";
        
        $bluebook_query="
        select bbq.* ,gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel,
        usm.nickname as bk_nickname,
        IF(bbq.type_flag=1, (select nickname from user_master where id=bbq.artist_id),'------') as art_nickname ,
        IF(bbq.type_flag=2, (select nickname from group_master where id=bbq.artist_id),'------') as grp_nickname ,
        IF(bbq.type_flag=3, (select nickname from venue_master where id=bbq.artist_id),'------') as ven_nickname
        from (
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF(ISNULL(gm.id),'BLUEBOOK','BLUEBOOK') as rcsipsbb FROM `gig_master` as gm
        
        where gm.gigpostrequestflag IN (1,2) and  gm.type_flag IN (1,2,3) and  gm.booker_id=".$user_id." and gm.artist_id<>".$user_id."  and gm.booking_status=1
        
        ) as bbq
        
        JOIN
        (
        
        SELECT gpsk.gigmaster_id, gpsk.category as category_id, gpsk.name as category_name ,
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
       
       ) as gmsrt
       
       on bbq.gigmaster_id=gmsrt.gigmaster_id
       
       LEFT JOIN user_master as usm 

        on usm.id=bbq.booker_id
       
       where DATE_FORMAT(bbq.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
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
            $main_qry=" select qprf.* from ( ".$unionmerge." )  as qprf ";
        }
        
        //echo $main_qry;die;
        $maingig_qry_data = array();
          if(!empty($unionmerge)==true)
        {
            $maingig_qry_data = DB::select($main_qry);
        }
        $data_roster = array();
        $i = 0;  $prevgigid=array(); $prevgigimg=''; $gigardata=array();
        //print_r($maingig_qry_data);
        //die;
        if(count($maingig_qry_data)>0){
            foreach($maingig_qry_data as $qry_data){
                $booker_id = $qry_data->booker_id;
                $wherearum['id']=$qry_data->booker_id;
                
                //echo "<be>====prevgigid=>";print_r($prevgigid);
                
                if(!(in_array($qry_data->gigmaster_id , $prevgigid )) )
                {
                    //*******booker name get start******//
                    $data_roster[$i]['bk_nickname'] = $qry_data->bk_nickname;
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
                    
                    
                    if($qry_data->rcsipsbb == 'STARICON'){
                        
                        $revi_Gid_id = $qry_data->gigmaster_id;
                        $maingig_qry_data = DB::select("SELECT * FROM `gig_review` WHERE `gigmaster_id` = '".$revi_Gid_id."'");
                        
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
            }
        }

//echo "<pre>";
//print_r($data_roster);
//die;
        $data['maingig_qry_data_result']=$data_roster;

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
$fetGen = "SELECT skmt.`name` FROM  `gig_skill_rel` as gskrl,  `skill_master` as skmt WHERE gskrl.`gigmaster_id` =".$gig_master_id." AND gskrl.`genre` = skmt.`id";

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
        
        $wherearum['giguniqueid']=$gigid;
        
        $tab_db_um = DB::table("gig_master");
        $tab_db_um=$tab_db_um->where($wherearum);
        $tab_db_um=$tab_db_um->first();
        
        $data['gig_uniqueid'] = $gigid;
        $data['gigpostrequestflag'] = $tab_db_um->gigpostrequestflag;
        $data['type_flag'] = $tab_db_um->type_flag;
        $data['artist_id'] = $tab_db_um->artist_id;
        $data['booker_id'] = $tab_db_um->booker_id;
        $booker_data ='';
        $artist_data ='';
        if($tab_db_um->booker_id == $logid){
            $wherebooker['id']=$gigid;
            $data['usr_typ'] = 'booker';
            $booker_data = DB::table("user_master");
            $booker_data=$booker_data->where($wherebooker);
            $booker_data=$booker_data->first();

        }else{
            $data['usr_typ'] = 'artist';
            if($tab_db_um->type_flag == '1'){

                //$artist_data = DB::select("select usr.*,u_img.`image_name` from `user_master` as usr,`user_master_img` as u_img where usr.`id`='".$tab_db_um->artist_id."' and u_img.`default_status`='1' and u_img.`user_id`='".$tab_db_um->artist_id."'");
                $artist_data = DB::select("SELECT usr.* , u_img.`image_name` FROM  `user_master` AS usr LEFT JOIN  `user_master_img` AS u_img ON usr.`id` = u_img.`user_id` and u_img.`default_status`='1' and u_img.`user_id`='".$tab_db_um->artist_id."' where usr.`id`='".$tab_db_um->artist_id."'");
                
                //$data['artist_query'] = "SELECT usr.* , u_img.`image_name` FROM  `user_master` AS usr LEFT JOIN  `user_master_img` AS u_img ON usr.`id` = u_img.`user_id` and u_img.`default_status`='1' and u_img.`user_id`='".$tab_db_um->artist_id."' where usr.`id`='".$tab_db_um->artist_id."'";
            }else if($tab_db_um->type_flag == '2'){
                
                //$artist_data = DB::select("Select usr.*,g_img.`image_name` from `user_master` as usr,`group_master` as grp, group_master_img as g_img where grp.`creater_id` = usr.`id` and g_img.`group_id`= '".$tab_db_um->artist_id."' and g_img.`default_status`='1' and grp.`id` = '".$tab_db_um->artist_id."'");
                $artist_data = DB::select("SELECT grp.* , g_img.`image_name` FROM  `group_master` AS grp join `user_master` as usr LEFT JOIN  `group_master_img` AS g_img ON grp.id = g_img.`group_id` and g_img.`default_status`='1' and g_img.`group_id`= '".$tab_db_um->artist_id."' where grp.`creater_id` = usr.`id` and grp.`id`= '".$tab_db_um->artist_id."'");
                
                //$data['artist_query'] = "SELECT grp.* , g_img.`image_name` FROM  `group_master` AS grp join `user_master` as usr LEFT JOIN  `group_master_img` AS g_img ON grp.id = g_img.`group_id` and g_img.`default_status`='1' and g_img.`group_id`= '".$tab_db_um->artist_id."' where grp.`creater_id` = usr.`id` and grp.`id`= '".$tab_db_um->artist_id."'";
            }else if($tab_db_um->type_flag == '3'){
                
                //$artist_data = DB::select("Select usr.*.,v_img.`image_name` from `user_master` as usr,`venue_master` as vnu , venue_master_img as v_img where vnu.`creater_id` = usr.`id` and v_img.`venue_id` = '".$tab_db_um->artist_id."' and v_img.`default_status`='1' and vnu.`id` = '".$tab_db_um->artist_id."'");
                $artist_data = DB::select("SELECT vnu.* , v_img.`image_name` FROM  `venue_master` AS vnu join `user_master` as usr LEFT JOIN  `venue_master_img` AS v_img ON vnu.id = v_img.`venue_id` and v_img.`default_status`='1' and v_img.`venue_id`= '".$tab_db_um->artist_id."' where vnu.`creater_id` = usr.`id` and vnu.`id`= '".$tab_db_um->artist_id."'");
                
                //$data['artist_query'] = "SELECT vnu.* , v_img.`image_name` FROM  `venue_master` AS vnu join `user_master` as usr LEFT JOIN  `venue_master_img` AS v_img ON vnu.id = v_img.`venue_id` and v_img.`default_status`='1' and v_img.`venue_id`= '".$tab_db_um->artist_id."' where vnu.`creater_id` = usr.`id` and vnu.`id`= '".$tab_db_um->artist_id."'";
            }
        }

        $data['logid'] = $logid;
        $data['booker_data'] = $booker_data;
        $data['artist_data'] = $artist_data;
        //echo json_encode($data);die;
        //return view('front.roster.ajax.reviewmodal',$data);
        $view_obj = View::make('front.roster.ajax.reviewmodal',$data);
        $ep_view_contents = $view_obj->render();
        
        $respAr=array();
        $respAr['respdata']=$ep_view_contents;
        echo json_encode($respAr);
    }
    
}