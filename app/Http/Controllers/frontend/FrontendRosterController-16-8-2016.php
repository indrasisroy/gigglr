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
        
        where gm.gigpostrequestflag IN (1,2) and gm.type_flag=1 and   gm.booker_id<>".$user_id." and gm.artist_id=".$user_id."  and gm.booking_status=1
       
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
                    
                    LEFT JOIN gig_bidrequest as gbr on ggsr.`gigmaster_id`=gbr.`gigmaster_id`
                    
                    
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
        
        if($evnttypeshowflag=="ALL")
        {
            $main_qry.="".$redclock_query." UNION ".$star_clock_query." UNION ".$purple_suitcase_query." UNION ".$bluebook_query;
          //  $main_qry.="".$redclock_query." UNION ".$star_clock_query." UNION ".$purple_suitcase_query;
        }
        elseif($evnttypeshowflag=="REDCLOCK") 
        {
            $main_qry=$redclock_query;
        }
        elseif($evnttypeshowflag=="STARICON")
        {
            $main_qry=$star_clock_query;
        }
        elseif($evnttypeshowflag=="PURPLE")
        {
            $main_qry=$purple_suitcase_query;
        }
        elseif($evnttypeshowflag=="BLUEBOOK")
        {
            $main_qry=$bluebook_query;
        }
        
        $maingig_qry_data=DB::select($main_qry);
        
        //echo "==maingig_qry_data=><pre>";
        //print_r($maingig_qry_data);
        //echo "</pre>==";
        
        
     
        
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
        
        
        
        
        $currentDate = trim($request->input('currentDate'));
        $mwd = trim($request->input('mwd'));
        //echo $mwd;die;
        
        if($mwd=='daily'){
            
            $daily_cal_qry = "( SELECT IF( '1' = '1', '0', '1' ) AS ggbid, IF( '1' = '1', 'artist', 'booker' ) AS bookerorartist, gm.*, gm.event_start_date_time AS start, gsr.category, gsr.genre, IF( sm1.name IS NULL, 'N/A', sm1.name ) AS category_name, IF( sm2.name IS NULL, 'N/A', sm2.name ) AS genre_name, IF( um1.nickname IS NULL, 'N/A', um1.nickname ) AS booker_name,  IF( gm.type_flag = '1', ( SELECT umin.nickname FROM user_master AS umin WHERE umin.id = '".$user_id."' ), IF( gm.type_flag = '2', grp.nickname, IF( gm.type_flag = '3', ven.nickname, 'blank' ) ) )  AS assumed_artistname 
FROM gig_master AS gm JOIN gig_skill_rel AS gsr JOIN group_master AS grp JOIN venue_master AS ven 
INNER JOIN skill_master AS sm1 ON gsr.category = sm1.id 
LEFT JOIN skill_master AS sm2 ON gsr.genre = sm2.id 
INNER JOIN user_master AS um1 ON gm.booker_id = um1.id   
WHERE
( ( gm.artist_id = '".$user_id."' AND gm.type_flag = '1' ) OR ( gm.artist_id = grp.id AND gm.type_flag = '2' ) OR ( gm.artist_id = ven.id AND gm.type_flag = '3' ) ) 
AND gm.booking_status != '9'
AND gsr.gigmaster_id = gm.id
AND grp.creater_id = '".$user_id."'
AND ven.creater_id = '".$user_id."'
AND gm.event_start_date_time LIKE '".$currentDate."%' )

UNION

( SELECT IF( ( SELECT COUNT(gb.id) AS gbid FROM gig_bidrequest AS gb WHERE gb.gigmaster_id=gm.id AND gb.artist_id=grp.id )>0, ( SELECT gbd.id FROM gig_bidrequest AS gbd WHERE gbd.gigmaster_id=gm.id AND gbd.artist_id=grp.id ), '0' ) AS ggbid, IF( '1' = '1', 'artist', 'booker' ) AS bookerorartist, gm.*, gm.event_start_date_time AS start, gsr.category, gsr.genre, IF( sm1.name IS NULL, 'N/A', sm1.name ) AS category_name, IF( sm2.name IS NULL, 'N/A', sm2.name ) AS genre_name, IF( um1.nickname IS NULL, 'N/A', um1.nickname ) AS booker_name, grp.nickname AS assumed_artistname
FROM gig_master AS gm 
JOIN gig_skill_rel AS gsr ON gsr.gigmaster_id = gm.id
INNER JOIN skill_master AS sm1 ON gsr.category = sm1.id 
LEFT JOIN skill_master AS sm2 ON gsr.genre = sm2.id 
INNER JOIN user_master AS um1 ON gm.booker_id = um1.id, 
group_skill_rel AS grpsr,
group_master AS grp 
WHERE grpsr.g_creator_id = '".$user_id."' 
AND grp.id = grpsr.group_id
AND ( gsr.genre = grpsr.skill_sub_id AND gsr.type_flag = '2' )
AND gm.booking_status = '2'
AND gm.gigpostrequestflag = '1'
AND gm.artist_id = '0'
AND gm.booker_id != '".$user_id."'
AND gm.event_start_date_time LIKE '".$currentDate."%'
AND LOWER(gm.event_city)='".$user_city."'
)

UNION

( SELECT IF( ( SELECT COUNT(gb.id) AS gbid FROM gig_bidrequest AS gb WHERE gb.gigmaster_id=gm.id AND gb.artist_id='".$user_id."' )>0, ( SELECT gbd.id FROM gig_bidrequest AS gbd WHERE gbd.gigmaster_id=gm.id AND gbd.artist_id='".$user_id."' ), '0' ) AS ggbid, IF( '1' = '1', 'artist', 'booker' ) AS bookerorartist, gm.*, gm.event_start_date_time AS start, gsr.category, gsr.genre, IF( sm1.name IS NULL, 'N/A', sm1.name ) AS category_name, IF( sm2.name IS NULL, 'N/A', sm2.name ) AS genre_name, IF( um1.nickname IS NULL, 'N/A', um1.nickname ) AS booker_name, usms.nickname AS assumed_artistname 
FROM gig_master AS gm 
JOIN gig_skill_rel AS gsr ON gsr.gigmaster_id = gm.id
INNER JOIN skill_master AS sm1 ON gsr.category = sm1.id 
LEFT JOIN skill_master AS sm2 ON gsr.genre = sm2.id 
INNER JOIN user_master AS um1 ON gm.booker_id = um1.id, 
user_skill_rel AS usr,
user_master AS usms
WHERE usr.user_id = '".$user_id."'
AND usms.id = '".$user_id."'
AND ( gsr.genre = usr.skill_sub_id AND gsr.type_flag = '1' )
AND gm.booking_status = '2'
AND gm.gigpostrequestflag = '1'
AND gm.artist_id = '0'
AND gm.booker_id != '".$user_id."'
AND gm.event_start_date_time LIKE '".$currentDate."%'
AND LOWER(gm.event_city)='".$user_city."'
)

UNION

( SELECT IF( '1' = '1', '0', '1' ) AS ggbid, IF( gm.booker_id = '".$user_id."', 'booker', 'artist' ) AS bookerorartist, gm.*, gm.event_start_date_time AS start, gsr.category, gsr.genre,IF( sm1.name IS NULL, 'N/A', sm1.name ) AS category_name, IF( sm2.name IS NULL, 'N/A', sm2.name ) AS genre_name, IF( um1.nickname IS NULL, 'N/A', um1.nickname ) AS booker_name, IF( gm.type_flag = '1', ( SELECT umstr.nickname FROM user_master AS umstr WHERE umstr.id = gm.artist_id ), IF( gm.type_flag = '2', ( SELECT grpms.nickname FROM group_master AS grpms WHERE grpms.id = gm.artist_id ), IF( gm.type_flag = '3', ( SELECT venms.nickname FROM venue_master AS venms WHERE venms.id = gm.artist_id ), 'blank' ) ) )  AS assumed_artistname
FROM gig_skill_rel AS gsr JOIN gig_master AS gm
INNER JOIN skill_master AS sm1 ON gsr.category = sm1.id
LEFT JOIN skill_master AS sm2 ON gsr.genre = sm2.id
INNER JOIN user_master AS um1 ON gm.booker_id = um1.id
WHERE gm.booker_id = '".$user_id."'
AND gm.id = gsr.gigmaster_id
AND gm.booking_status != '9'
AND gm.event_start_date_time LIKE '".$currentDate."%' )

ORDER BY start ASC";
            
            $daily_cal_qry_data=DB::select($daily_cal_qry);
        }
        else{
            $current=$currentDate.' 00:00:00';
            //echo $current;die;
             
            if($mwd=='week')
            {
                $date = $currentDate;
                $date = strtotime($date);
                $date = strtotime("+6 day", $date);
                $enddate=date('Y-m-d', $date);
                $endt=$enddate.' 23:59:59';
                //echo $endt;die;
            }
            elseif($mwd=='month')
            {
                $date = $currentDate;
                $date = strtotime($date);
                $date = strtotime("+29 day", $date);
                $enddate=date('Y-m-d', $date);
                $endt=$enddate.' 23:59:59';
                //echo $endt;die;
            }
            
            $daily_cal_qry = "
( SELECT IF( '1' = '1', '0', '1' ) AS ggbid, IF( '1' = '1', 'artist', 'booker' ) AS bookerorartist, gm.*, gm.event_start_date_time AS start, gsr.category, gsr.genre, IF( sm1.name IS NULL, 'N/A', sm1.name ) AS category_name, IF( sm2.name IS NULL, 'N/A', sm2.name ) AS genre_name, IF( um1.nickname IS NULL, 'N/A', um1.nickname ) AS booker_name,  IF( gm.type_flag = '1', ( SELECT umin.nickname FROM user_master AS umin WHERE umin.id = '".$user_id."' ), IF( gm.type_flag = '2', grp.nickname, IF( gm.type_flag = '3', ven.nickname, 'blank' ) ) )  AS assumed_artistname 
FROM gig_master AS gm JOIN gig_skill_rel AS gsr JOIN group_master AS grp JOIN venue_master AS ven 
INNER JOIN skill_master AS sm1 ON gsr.category = sm1.id 
LEFT JOIN skill_master AS sm2 ON gsr.genre = sm2.id 
INNER JOIN user_master AS um1 ON gm.booker_id = um1.id   
WHERE
( ( gm.artist_id = '".$user_id."' AND gm.type_flag = '1' ) OR ( gm.artist_id = grp.id AND gm.type_flag = '2' ) OR ( gm.artist_id = ven.id AND gm.type_flag = '3' ) ) 
AND gm.booking_status != '9'
AND gsr.gigmaster_id = gm.id
AND grp.creater_id = '".$user_id."'
AND ven.creater_id = '".$user_id."'
AND ( gm.event_start_date_time >= '".$current."%' AND gm.event_start_date_time <= '".$endt."%' ) )

UNION

( SELECT IF( ( SELECT COUNT(gb.id) AS gbid FROM gig_bidrequest AS gb WHERE gb.gigmaster_id=gm.id AND gb.artist_id=grp.id )>0, ( SELECT gbd.id FROM gig_bidrequest AS gbd WHERE gbd.gigmaster_id=gm.id AND gbd.artist_id=grp.id ), '0' ) AS ggbid, IF( '1' = '1', 'artist', 'booker' ) AS bookerorartist, gm.*, gm.event_start_date_time AS start, gsr.category, gsr.genre, IF( sm1.name IS NULL, 'N/A', sm1.name ) AS category_name, IF( sm2.name IS NULL, 'N/A', sm2.name ) AS genre_name, IF( um1.nickname IS NULL, 'N/A', um1.nickname ) AS booker_name, grp.nickname AS assumed_artistname
FROM gig_master AS gm 
JOIN gig_skill_rel AS gsr ON gsr.gigmaster_id = gm.id
INNER JOIN skill_master AS sm1 ON gsr.category = sm1.id 
LEFT JOIN skill_master AS sm2 ON gsr.genre = sm2.id 
INNER JOIN user_master AS um1 ON gm.booker_id = um1.id, 
group_skill_rel AS grpsr,
group_master AS grp 
WHERE grpsr.g_creator_id = '".$user_id."' 
AND grp.id = grpsr.group_id
AND ( gsr.genre = grpsr.skill_sub_id AND gsr.type_flag = '2' )
AND gm.booking_status = '2'
AND gm.gigpostrequestflag = '1'
AND gm.artist_id = '0'
AND gm.booker_id != '".$user_id."'
AND ( gm.event_start_date_time >= '".$current."%' AND gm.event_start_date_time <= '".$endt."%' )
AND LOWER(gm.event_city)='".$user_city."'
)

UNION

( SELECT IF( ( SELECT COUNT(gb.id) AS gbid FROM gig_bidrequest AS gb WHERE gb.gigmaster_id=gm.id AND gb.artist_id='".$user_id."' )>0, ( SELECT gbd.id FROM gig_bidrequest AS gbd WHERE gbd.gigmaster_id=gm.id AND gbd.artist_id='".$user_id."' ), '0' ) AS ggbid, IF( '1' = '1', 'artist', 'booker' ) AS bookerorartist, gm.*, gm.event_start_date_time AS start, gsr.category, gsr.genre, IF( sm1.name IS NULL, 'N/A', sm1.name ) AS category_name, IF( sm2.name IS NULL, 'N/A', sm2.name ) AS genre_name, IF( um1.nickname IS NULL, 'N/A', um1.nickname ) AS booker_name, usms.nickname AS assumed_artistname 
FROM gig_master AS gm 
JOIN gig_skill_rel AS gsr ON gsr.gigmaster_id = gm.id
INNER JOIN skill_master AS sm1 ON gsr.category = sm1.id 
LEFT JOIN skill_master AS sm2 ON gsr.genre = sm2.id 
INNER JOIN user_master AS um1 ON gm.booker_id = um1.id, 
user_skill_rel AS usr,
user_master AS usms
WHERE usr.user_id = '".$user_id."'
AND usms.id = '".$user_id."'
AND ( gsr.genre = usr.skill_sub_id AND gsr.type_flag = '1' )
AND gm.booking_status = '2'
AND gm.gigpostrequestflag = '1'
AND gm.artist_id = '0'
AND gm.booker_id != '".$user_id."'
AND ( gm.event_start_date_time >= '".$current."%' AND gm.event_start_date_time <= '".$endt."%' )
AND LOWER(gm.event_city)='".$user_city."'
)

UNION

( SELECT IF( '1' = '1', '0', '1' ) AS ggbid, IF( gm.booker_id = '".$user_id."', 'booker', 'artist' ) AS bookerorartist, gm.*, gm.event_start_date_time AS start, gsr.category, gsr.genre,IF( sm1.name IS NULL, 'N/A', sm1.name ) AS category_name, IF( sm2.name IS NULL, 'N/A', sm2.name ) AS genre_name, IF( um1.nickname IS NULL, 'N/A', um1.nickname ) AS booker_name, IF( gm.type_flag = '1', ( SELECT umstr.nickname FROM user_master AS umstr WHERE umstr.id = gm.artist_id ), IF( gm.type_flag = '2', ( SELECT grpms.nickname FROM group_master AS grpms WHERE grpms.id = gm.artist_id ), IF( gm.type_flag = '3', ( SELECT venms.nickname FROM venue_master AS venms WHERE venms.id = gm.artist_id ), 'blank' ) ) )  AS assumed_artistname
FROM gig_skill_rel AS gsr JOIN gig_master AS gm
INNER JOIN skill_master AS sm1 ON gsr.category = sm1.id
LEFT JOIN skill_master AS sm2 ON gsr.genre = sm2.id
INNER JOIN user_master AS um1 ON gm.booker_id = um1.id
WHERE gm.booker_id = '".$user_id."'
AND gm.id = gsr.gigmaster_id
AND gm.booking_status != '9'
AND ( gm.event_start_date_time >= '".$current."%' AND gm.event_start_date_time <= '".$endt."%' ) )

ORDER BY start ASC";

            $daily_cal_qry_data=DB::select($daily_cal_qry);
        }

        $data['daily_cal_qry_data']=$daily_cal_qry_data;
        $data['current_date_data']=$currentDate;
        $data['con_sess_id']=$user_id;
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
        $view_obj = View::make('front.roster.ajax.rosterleftnestedlistajax',$data);
        $ep_view_contents = $view_obj->render();
        
        $respAr=array();
        $respAr['respdata']=$ep_view_contents;
        echo json_encode($respAr);
    }
    
}