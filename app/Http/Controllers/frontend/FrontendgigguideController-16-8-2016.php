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

class FrontendgigguideController extends Controller
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
      return view('front.gigguide.gigguideview',$data);
    }
    
    public function getgigguidecallendardata(Request $request)
    {
        
        $user_id=0;       
        if ($request->session()->has('front_id_sess'))
        {
            $user_id= $request->session()->get('front_id_sess');
        }
        
        
        $selecteddate = trim($request->input('selecteddate'));
        $selectedfirstdate = trim($request->input('selectedfirstdate'));
        $selectedlastdate = trim($request->input('selectedlastdate'));
        
        $seo_name = trim($request->input('seo_name'));
        
        $category = trim($request->input('category'));
        $genre = trim($request->input('genre'));
        
        
        
        
        
        
        
        $filterevtype = trim($request->input('filterevtype'));
        $filterevtypeAr=array();
        
        $eventfanflag=false; $eventgenreflag=false; $eventtownflag=false;
        
        if(!empty($filterevtype))
        {
            $filterevtypeAr=explode("||",$filterevtype);
            
            if(!empty($filterevtypeAr))
            {
                foreach($filterevtypeAr as $filterevtypedata)
                {
                    if($filterevtypedata=="EVENTFAN") 
                    {
                        $eventfanflag=true;
                    }
                    elseif($filterevtypedata=="EVENTGENRE")
                    {
                        $eventgenreflag=true;
                    }
                    elseif($filterevtypedata=="EVENTTOWN")
                    {
                        $eventtownflag=true;
                    }
                    
                }
                
            }
            
        }
        
        
        //**** get artist state data from user_master table starts
        $user_city=''; $user_city_clause='';
        
        $wherearum=array();
        $wherearum['id']=$user_id;
        
        if(!empty($user_id) )
        {
        
            $tab_db_um = DB::table("user_master as um");
            $tab_db_um=$tab_db_um->select(DB::raw(" um.city "));   
            $tab_db_um=$tab_db_um->where($wherearum);
            $tab_db_um=$tab_db_um->first();
           
            if(!empty($tab_db_um))
            {
                $user_city=strtolower($tab_db_um->city);
            }
       
        }
        else
        {
            $citynmar=getCityNameAr("-33.8701926","151.2069446");
            //echo "<pre>"; print_r($citynmar); echo "</pre>";
            
            if(!empty($citynmar))
            {
              $user_city=implode(",",$citynmar);
            }
        }
        
        
        
        
        
       
       
        //**** get artist state data from user_master table ends
        
       
        
        if( !empty($user_city))
        {
            $user_city_clause=" and  FIND_IN_SET(LOWER(event_city),'".$user_city."') "; 
        }
        
        if( empty($user_city))
        {
            $user_city_clause=" limit 0,100 ";  // in case no city is found then apply limit 
        }
        
        
        
        $eventfan_query="         
        select rcl.*  from 
        (
        
            select rclo.*,gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel from
            (
                SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
                gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
                gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
                gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
                gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
                gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
                gm.gig_description,gm.total_amount ,
                IF( gm.id >0,'EVENTFAN','EVENTFAN') as rcsipsbb
                
                
                FROM `gig_master` as gm
                
                
                 where gm.gigpostrequestflag IN (1)  and
                 gm.event_type IN(1,3)  and gm.booking_status=1 and   gm.artist_id > 0
                 
                 and gm.id IN (
                    
                    SELECT distinct gm.id as gigmaster_id                    
                    FROM `gig_master` as gm                    
                    
                    JOIN favoriterecord as fr  on gm.artist_id=fr.favorite_id and gm.type_flag=fr.favorite_type_flag
                    
                    WHERE fr.user_id=".$user_id."  and fr.status=1 and gm.booking_status=1 and   gm.gigpostrequestflag IN (1) and gm.event_type IN (1,3) and gm.type_flag IN (1,2)
                   
                    )
               
                
                
            ) as rclo
                
        
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
       
       on rclo.gigmaster_id=gmsrt.gigmaster_id
       
        
      
        
       
        
        ) as rcl
        
        where        DATE_FORMAT(rcl.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
        ".$user_city_clause;
        
       
       $eventtown_query="
               select rcl.*  from 
        (
        
            select rclo.*,gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel from
            (
                SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
                gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
                gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
                gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
                gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
                gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
                gm.gig_description,gm.total_amount ,
                IF( gm.id >0,'EVENTTOWN','EVENTTOWN') as rcsipsbb
                
                
                FROM `gig_master` as gm
                
                
                 where gm.gigpostrequestflag IN (1)  and
                 gm.event_type IN(1,3)  and gm.booking_status=1 and   gm.artist_id > 0
                 
                               
                
                
            ) as rclo
                
        
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
       
       on rclo.gigmaster_id=gmsrt.gigmaster_id
       
        
      
        
       
        
        ) as rcl
        
        where        DATE_FORMAT(rcl.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
        ".$user_city_clause;
       
        $eventgenre_query="
       
        select rcl.*  from 
        (
        
            select rclo.*,gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel from
            (
                SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
                gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
                gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
                gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
                gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
                gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
                gm.gig_description,gm.total_amount ,
                IF( gm.id >0,'EVENTGENRE','EVENTGENRE') as rcsipsbb
                
                
                FROM `gig_master` as gm
                
                
                 where gm.gigpostrequestflag IN (1)  and
                 gm.event_type IN(1,3)  and gm.booking_status=1 and   gm.artist_id > 0
                 
                 and gm.id IN (
                    
                    select artmgg.gigmaster_id from  (
                       SELECT uskr.`user_id`,uskr.`skill_sub_id`,ggsr.`gigmaster_id`,ggsr.`genre`,ggsr.type_flag 
                      
                       FROM `user_skill_rel`  as uskr
                       
                        JOIN `gig_skill_rel` as ggsr
                       
                        on uskr.`skill_sub_id` =ggsr.genre and uskr.`user_id`=".$user_id."  and  ggsr.type_flag IN (1,2)
                       
                        ) as artmgg
                    
                    )
               
                
                
            ) as rclo
                
        
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
       
       on rclo.gigmaster_id=gmsrt.gigmaster_id
       
        
      
        
       
        
        ) as rcl
        
        where        DATE_FORMAT(rcl.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
        
        ".$user_city_clause;
       
        
        
        $unionmerge=''; $unionmergeAr=array();
        
         
         
        if($eventfanflag==true)
        {
            $unionmergeAr[]=$eventfan_query;
        }
        
        if($eventgenreflag==true)
        {
            $unionmergeAr[]=$eventgenre_query;
        }
        
        if($eventtownflag==true)
        {
            $unionmergeAr[]=$eventtown_query;
        }
        
        $unionmerge=implode(" UNION ",$unionmergeAr); //*** merge query accordingly
        
       // $main_qry=" select qprf.* from ( ".$redclock_query." UNION ".$star_clock_query ." )  as qprf ";
        
        if(!empty($unionmerge))
        {
            $main_qry=" select qprf.* from ( ".$unionmerge." )  as qprf ";
        }
       
        
        
        
        //**** filtration starts
         if( !empty($unionmerge) )
        {
            if(!empty($category) && empty($genre) )
                            {
                                        
                             $main_qry.=" where  ( FIND_IN_SET('".$category."',category_id)  ) ";
                            }
                            
            if(!empty($genre) && !empty($genre) )
                            {
                                        
                             $main_qry.=" where  ( FIND_IN_SET('".$category."',category_id)  ) and ( FIND_IN_SET('".$genre."',genre_id)  ) ";
                            }
        }
                        
        //**** filtration ends                
       
      
        
        if(!empty($unionmerge)==true)
        {
            $maingig_qry_data=DB::select($main_qry);
        }
        
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
                        $type_flag_data=" Artist Event  Event Start Date Time-".$event_start_date_time." Event End Date Time-".$event_enddttm_data." ";
                    }
                    elseif( $type_flag==2 )
                    {
                        $type_flag_data=" Group Event Event Start Date-".$event_start_date_time." Event End Date Time-".$event_enddttm_data." ";
                    }
                    elseif( $type_flag==3 )
                    {
                        $type_flag_data=" Venue Event Event Start Date-".$event_start_date_time." Event End Date Time-".$event_enddttm_data." ";
                    }
                    
                    $gigeventrow=array();
                    $gigeventrow['title']=$type_flag_data;
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
            
            //$body = $eventfan_query; //email body
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
    
    public function gigleftpannel(Request $request){
       
    }
    
    
   
}