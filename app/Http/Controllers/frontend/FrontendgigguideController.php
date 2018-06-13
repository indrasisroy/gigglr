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
            $latidata=trim($request->input('latidata'));
            $longidata=trim($request->input('longidata'));
            $citynmar=getCityNameAr($latidata,$longidata);
            //echo "<pre>"; print_r($citynmar); echo "</pre>";
            
            if( !empty($latidata) && !empty($longidata) )
            {
                $citynmar=getCityNameAr($latidata,$longidata);
                
                if(!empty($citynmar))
                {
                  $user_city=implode(",",$citynmar);
                }
            }
        }
        
        
        $selectedfirstdate=date("Y-m-d");
        
        $selectedlastdate=date("Y-m")."-".date('t');
        
        
       
       
        //**** get artist state data from user_master table ends
        
       if( !empty($user_city))
            {
                $user_city_clause=" and  FIND_IN_SET(LOWER(event_city),'".$user_city."')  ORDER BY RAND() limit 0,20"; 
            }
            else
            {
                $user_city_clause=" ORDER BY RAND() limit 0,100 ";  // in case no city is found then apply limit 
            }
        
        
        
        
               
               
     
     $eventtown_query="
               select rcl.*  from 
        (
        
            select rclo.*,gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel from
            (
                (
                
                    SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
                    gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
                    gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
                    gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
                    gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
                    gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
                    gm.gig_description,gm.total_amount ,
                    IF( gm.id >0,'EVENTTOWN','EVENTTOWN') as rcsipsbb ,
                    
                    IF(ISNULL(uimg.image_name), 'noimage', uimg.image_name) as image_name ,
                    
                    IF(usrm.nickname='', '---', usrm.nickname) as profile_name,
                    usrm.seo_name
                    
                    
                    FROM `gig_master` as gm
                    
                    INNER JOIN user_master as usrm
                    on usrm.id=gm.artist_id
                     
                    LEFT JOIN   `user_master_img` AS uimg
                    on  gm.artist_id=  uimg.user_id and   uimg.default_status=1
                    
                    
                    where gm.gigpostrequestflag IN (1)  and
                    gm.event_type IN(1,3)  and gm.booking_status=1 and   gm.artist_id > 0                     
                    and gm.type_flag IN(1)
                                 
                 )
                 
                 UNION
                 
                 
                 (
                
                    SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
                    gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
                    gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
                    gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
                    gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
                    gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
                    gm.gig_description,gm.total_amount ,
                    IF( gm.id >0,'EVENTTOWN','EVENTTOWN') as rcsipsbb ,
                    
                    IF(ISNULL(gimg.image_name), 'noimage', gimg.image_name) as image_name ,
                    
                    IF(grpm.nickname='', '---', grpm.nickname) as profile_name,
                    grpm.seo_name
                    
                    FROM `gig_master` as gm
                    
                    INNER JOIN group_master as grpm
                    on grpm.id=gm.artist_id
                     
                   LEFT JOIN   `group_master_img` AS gimg
                   on  gm.artist_id=  gimg.group_id and   gimg.default_status=1
                    
                    
                    where gm.gigpostrequestflag IN (1)  and
                    gm.event_type IN(1,3)  and gm.booking_status=1 and   gm.artist_id > 0                     
                    and gm.type_flag IN(2)
                                 
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
               
       $main_qry=$eventtown_query;
       //echo "==main_qry==>". $main_qry;
      
       $maingig_qry_data=DB::select($main_qry);
       
      // echo "<pre>"; print_r($maingig_qry_data); echo "</pre>"; exit();
               
      $data ['gigtopsliderdata']   =$maingig_qry_data;     
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
        
        $latidata = trim($request->input('latidata'));
        $longidata = trim($request->input('longidata'));
        
        
        
        
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
            //$citynmar=getCityNameAr("-33.8701926","151.2069446");
            //echo "<pre>"; print_r($citynmar); echo "</pre>";
            if( !empty($latidata) && !empty($longidata) )
            {
                $citynmar=getCityNameAr($latidata,$longidata);
                
                if(!empty($citynmar))
                {
                  $user_city=implode(",",$citynmar);
                }
            }
        }
        
        
        
        
        
       
       
        //**** get artist state data from user_master table ends
        
       
        
        if( !empty($user_city))
        {
            $user_city_clause=" and  FIND_IN_SET(LOWER(event_city),'".$user_city."') "; 
        }
        else
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
                 
                 and gm.type_flag IN(1,2)
                 
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
                 
                 and gm.type_flag IN(1,2)             
                
                
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
                 
                 and gm.type_flag IN(1,2)
                 
                 and (
                 
                        gm.id IN (
                    
                        select artmgg.gigmaster_id from  (
                           SELECT uskr.`user_id`,uskr.`skill_sub_id`,ggsr.`gigmaster_id`,ggsr.`genre`,ggsr.type_flag 
                          
                           FROM `user_skill_rel`  as uskr
                           
                            JOIN `gig_skill_rel` as ggsr
                           
                            on uskr.`skill_sub_id` =ggsr.genre and uskr.`user_id`=".$user_id."  and  ggsr.type_flag IN (1)
                           
                            ) as artmgg
                    
                        )
                    
                        OR
                        
                        gm.id IN (
                    
                        select grpm.gigmaster_id from  (
                           SELECT gskr.`group_id` ,gskr.`skill_sub_id`,ggsr.`gigmaster_id`,ggsr.`genre`,ggsr.type_flag 
                          
                           FROM `group_skill_rel`  as gskr
                           
                            JOIN `gig_skill_rel` as ggsr
                           
                            on gskr.`skill_sub_id` =ggsr.genre   and  ggsr.type_flag IN (2)
                            
                            where gskr.`group_id` IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1  )
                            
                           
                            ) as grpm
                    
                        )
                    
                    
                    
                    
                    
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
       
              //echo $main_qry;die;
        //die($main_qry);
        
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
            
            //$body = $main_qry; //email body
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
       
       
        $logID = trim($request->input('logID'));
        $filterevtype = trim($request->input('filterevtype'));
        $cal_select_date = trim($request->input('cal_select_date'));
        
        $latidata = trim($request->input('curr_lat_data'));
        $longidata = trim($request->input('curr_long_data'));

        $selected_category = trim($request->input('category'));
        $selected_genre = trim($request->input('genre'));
        
        $gencat = 0; $genreQueryStr = '';
        
        if($selected_category !='' && $selected_genre !=''){
            $gencat = 1;
        }
        else if($selected_category !=''){
            $gencat = 2;
        }else if($selected_genre !=''){
            $gencat = 3;
        }

        $lastMonth = date("Y-m-d",strtotime('+ 29 days',strtotime($cal_select_date)));
        $week = date("Y-m-d",strtotime('+ 6 days',strtotime($cal_select_date)));
        $currentday = date("Y-m-d",strtotime($cal_select_date));
        $currentmonth = date("Y-m-d",strtotime($cal_select_date));
        $month = trim($request->input('month'));

        
        
        $string_sql = '';
        
        if($month!=''){
            if($month =='week'){
                $string_sql = $string_sql."and ( DATE_FORMAT(event_start_date_time,'%Y-%m-%d') BETWEEN STR_TO_DATE('".$currentmonth."','%Y-%m-%d') AND STR_TO_DATE('".$week."','%Y-%m-%d')  )";
            }
            else if($month =='day'){
                $string_sql = $string_sql."and (DATE_FORMAT(event_start_date_time,'%Y-%m-%d')=STR_TO_DATE('".$currentday."','%Y-%m-%d') )";
                
            }else if($month =='month')
            {
                $string_sql = $string_sql."and ( DATE_FORMAT(event_start_date_time,'%Y-%m-%d') BETWEEN STR_TO_DATE('".$currentmonth."','%Y-%m-%d') AND STR_TO_DATE('".$lastMonth."','%Y-%m-%d'))";
            }
        }else{
            $string_sql = $string_sql."and (`event_start_date_time` >= '".$lastMonth."' and `event_start_date_time` <= '".$currentmonth."')"; 
        }
        
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
        
        $user_details_sql = "SELECT uskl.skill_id,uskl.skill_sub_id,us.city FROM `user_skill_rel` as uskl,`user_master` as us WHERE us.`id` = '".$logID."' and uskl.`catag_type_id`='1' and us.`id` = uskl.`user_id`";
        $user_details_data = DB::select($user_details_sql);
        $user_city = '';
        if(!empty($user_details_data)){
            $user_city = " gigm.`event_city` = '".$user_details_data[0]->city."'";
        }else{

            if( !empty($latidata) && !empty($longidata) )
            {
                $citynmar=getCityNameAr($latidata,$longidata);
                
                if(!empty($citynmar))
                {
                  $user_city="FIND_IN_SET(LOWER(gigm.`event_city`),'".implode(",",$citynmar)."')";
                }
            }
        }


        $user_group_details_sql = "SELECT gskl.skill_id,gskl.skill_sub_id,us.city FROM `group_skill_rel` as gskl,`user_master` as us WHERE us.`id` = '".$logID."' and gskl.`catag_type_id`='2' and us.`id` = gskl.`g_creator_id`";
        
        $user_group_details_data = DB::select($user_group_details_sql);
        

        $fainal_quesy=array();
        
        //********************** genre only started *************//
        $genreQueryArtist = array();
        if(!empty($user_details_data)){
            
            foreach($user_details_data as $details_data){
                $genreQueryArtist[] = "(`category`='".$details_data->skill_id."' and `genre` ='".$details_data->skill_sub_id."' and `type_flag` ='1')";
            }
            
        }
        $genreQueryGroup = array();
        if(!empty($user_group_details_data)){
            
            foreach($user_group_details_data as $details_group_data){
                $genreQueryGroup[] = "(`category`='".$details_group_data->skill_id."' and `genre` ='".$details_group_data->skill_sub_id."' and `type_flag` ='2')";
            }
            
        }
        $genreQueryImplode = array();
        if(!empty($genreQueryArtist))
        {
            $genreQueryImplode[] = "(`type_flag` = '1' and (".implode(" or ",$genreQueryArtist)."))";
        }
        if(!empty($genreQueryGroup))
        {
            $genreQueryImplode[] = "(`type_flag` = '2' and (".implode(" or ",$genreQueryGroup)."))";
        }


        if(!empty($genreQueryImplode))
        {
            $genreQueryStrimpl = implode(" or ",$genreQueryImplode);
            $genreQueryStr=" and gigm.`id` 
            in( SELECT gigmaster_id FROM `gig_skill_rel` WHERE ".$genreQueryStrimpl." ) ";
        }
            

            $genrefullQuery = "SELECT gigm.*,gskl.`category`,gskl.`genre`,'genre_only' as return_type FROM `gig_master` as gigm,`gig_skill_rel` as gskl WHERE gigm.`id` = gskl.`gigmaster_id` and gigm.`gigpostrequestflag`='1' and gigm.`booking_status` = '1' ".$string_sql." and gigm.`event_type`!='2' and ".$user_city." ".$genreQueryStr." ";
    
           // echo "Here genre sql=>".$genrefullQuery;
        
            //die("Dhiman ***************".$genrefullQuery);
        //********************** genre only end *************//
        
        
        //********************** show my town started *************//
        $showmytown_event_sql = '';
        if($user_city!=''){
            $showmytown_event_sql = "SELECT gigm.*,gskl.`category`,gskl.`genre`,'city_only' as return_type FROM `gig_master` as gigm,`gig_skill_rel` as gskl WHERE gigm.`id` = gskl.`gigmaster_id` and gigm.`gigpostrequestflag`='1' and gigm.`booking_status` = '1' and gigm.`event_type`!='2' and ".$user_city." ".$string_sql."";
        }else{
            $showmytown_event_sql = "SELECT gigm.*,gskl.`category`,gskl.`genre`,'city_only' as return_type FROM `gig_master` as gigm,`gig_skill_rel` as gskl WHERE gigm.`id` = gskl.`gigmaster_id` and gigm.`gigpostrequestflag`='1' and gigm.`booking_status` = '1' and gigm.`event_type`!='2' ".$string_sql."";
        }
        
        //********************** show my town ended *************//
        
        
        //********************** favoriterecord started *************//
        $favoriterecord = "SELECT fev.* FROM `favoriterecord` as fev WHERE fev.`user_id`='".$logID."' and fev.`user_type_flag`='1'";
        $favoriterecord_data=DB::select($favoriterecord);
        
        $arraySql = array();
        if(!empty($favoriterecord_data)){
            foreach($favoriterecord_data as $favoriterecord){
                $arraySql[] = "(gigm.`artist_id`=".$favoriterecord->favorite_id." and gigm.`type_flag` = '".$favoriterecord->favorite_type_flag."')";
            }
        }
        
        $afetUnionStr='';
        if(!empty($arraySql))
        {
            $afetUnionStr = " and  ( ".implode(" or ",$arraySql)." ) ";
        }
        
        $favoriterecord_event_sql = "SELECT gigm.*,gskl.`category`,gskl.`genre`,'favorite_only' as return_type FROM `gig_master` as gigm ,`gig_skill_rel` as gskl WHERE gigm.`id` = gskl.`gigmaster_id` and gigm.`gigpostrequestflag`='1' and gigm.`booking_status` = '1' and gigm.`event_type`!='2' and ".$user_city."  ".$afetUnionStr." ".$string_sql."";
        //********************** favoriterecord ended *************//

        if($eventfanflag==true)
        {
            $fainal_quesy[]=$favoriterecord_event_sql;
        }
        
        if($eventgenreflag==true)
        {
            $fainal_quesy[]=$genrefullQuery;
        }
        
        if($eventtownflag==true)
        {
            $fainal_quesy[]=$showmytown_event_sql;
        }
        


        $fainal_quesyStr = implode(" UNION ",$fainal_quesy);



            $main_qry ='';
            if(!empty($fainal_quesyStr))
        {
            $main_qry =" select qprf.* from ( ".$fainal_quesyStr." )  as qprf ";
            
               
        }
            $catgenreQueryStr = '';
            if($main_qry!=''){
                        if($gencat == '1'){
                            $main_qry.="WHERE (`category`='".$selected_category."' and `genre` ='".$selected_genre."')";
                        }else if($gencat == '2'){
                            $main_qry.="WHERE (`category`='".$selected_category."')";
                        }else if($gencat == '3'){
                            $main_qry.="WHERE (`genre` ='".$selected_genre."')";
                        }    
            }

         if(!empty($main_qry))
         {

            $fainal_quesyStr_event_data=DB::select($main_qry);
            
         }
        
        $data  = array();
       
      // echo "--------fainal_quesyStr_event_data==><pre>"; print_r($fainal_quesyStr_event_data);  echo "</pre>"; 

        if(!empty($fainal_quesyStr_event_data)){
            $i = 0; $prevgigid=array(); $prevgigimg=''; $gigardata=array();

            foreach($fainal_quesyStr_event_data as $fainal_quesyStr_data){
                
                //************* start *******//
         
              
               
            if(!(in_array($fainal_quesyStr_data->giguniqueid , $prevgigid )) )
            {
                
                //************* end *******//
                $tableName = '';
                if($fainal_quesyStr_data->type_flag == '2'){
                    $tableName = 'group_master';
                }else{
                    $tableName = 'user_master';
                }
                
                $artist_single = DB::table($tableName)->where('id',$fainal_quesyStr_data->artist_id)->first();
                
                $nik = $artist_single->nickname;
                    $data['result'][$i]['event_city'] = $fainal_quesyStr_data->event_city;
                    $data['result'][$i]['type_flag'] = $fainal_quesyStr_data->type_flag;
                    $data['result'][$i]['event_start_date_time'] = $fainal_quesyStr_data->event_start_date_time;
                    $data['result'][$i]['giguniqueid'] = $fainal_quesyStr_data->giguniqueid;
                    $data['result'][$i]['id'] = $fainal_quesyStr_data->id;
                    $data['result'][$i]['event_address1'] = $fainal_quesyStr_data->event_address1;
                    $data['result'][$i]['return_type'] = $fainal_quesyStr_data->return_type;
                    
                if($nik!=''){
                    $data['result'][$i]['artist_name'] = $artist_single->nickname;
                }else{
                    $data['result'][$i]['artist_name'] = "";
                }
                $gigardata[$fainal_quesyStr_data->giguniqueid]=array("return_type"=>$fainal_quesyStr_data->return_type,"data_roster_key"=>$i);
                
           
                 $prevgigid[]=$fainal_quesyStr_data->giguniqueid;
                
                        
            
            }
            else
            {
                        
                        
                        $mtchar=$gigardata[$fainal_quesyStr_data->giguniqueid];
                        
                        $data_roster_key=$mtchar['data_roster_key'];
                        $nowprevimg= $data['result'][$data_roster_key]['return_type'];
                        
                        $prevgigimg=explode(",",$nowprevimg);
                        
                if(!in_array($fainal_quesyStr_data->return_type,$prevgigimg))
                {
                        
                    if(array_key_exists($fainal_quesyStr_data->giguniqueid,$gigardata)){
                        
                        //$mtchar=$gigardata[$fainal_quesyStr_data->giguniqueid];
                        //
                        //$data_roster_key=$mtchar['data_roster_key'];
                        //$nowprevimg= $data['result'][$data_roster_key]['return_type'];
                        
                        $expldnowprevimg=explode(",",$nowprevimg);
                        array_push($expldnowprevimg,$fainal_quesyStr_data->return_type);
                        
                       
                        
                        $nowupdtdimgs=implode(",",$expldnowprevimg);
                        
                        unset($data['result'][$data_roster_key]['return_type']);
                        $data['result'][$data_roster_key]['return_type']=$nowupdtdimgs;
                        
                        
                        
                        
                         
                    }
                }
            }
            
           
                $i++;
            }
        }
       
        //return view('front.gigguide.ajax.gigguideLeftpannel',$data);
        $view_obj = View::make('front.gigguide.ajax.gigguideLeftpannel',$data);
        $ep_view_contents = $view_obj->render();
        $resp_arr['ep_contents']=$ep_view_contents;
        $resp_arr['return_type']="1";
        
        echo json_encode($resp_arr);
        
       
    }    
    
    function getcategory(Request $request){
        
        $returnArry = array();
        $allCAtegory = DB::table('skill_master')
        ->where('parent_id','0')
        ->where('catag_type','!=','3')
        ->where('status','1');
        $returnArry['data'] = '';
        if($allCAtegory->count()>0){
            $allCAtegoryRow = $allCAtegory->get();
            $returnArry['data'] = $allCAtegoryRow;
            $returnArry['flag'] = '1';
            
        }else{
            $returnArry['flag'] = '0';
            $returnArry['msg'] = 'Some thing went wrong';
        }
        
        echo json_encode($returnArry);
    }
    
    function getrostergetcategory(Request $request){
        
        $user_id = trim($request->input('user_id'));  
        $returnArry = array();
        $allCAtegory = DB::table('skill_master')
        ->where('parent_id','0')
        ->where('catag_type','!=','3')
        ->where('status','1');
        $returnArry['data'] = '';
        if($allCAtegory->count()>0){
            $allCAtegoryRow = $allCAtegory->get();
            $returnArry['data'] = $allCAtegoryRow;
            $returnArry['flag'] = '1';
            
        }else{
            $returnArry['flag'] = '0';
            $returnArry['msg'] = 'Some thing went wrong';
        }
        
        echo json_encode($returnArry); 
    }
    
    function getgenre(Request $request){
        
        $guide_cat = trim($request->input('guide_cat'));
        $returnArry = array();
        $allCAtegory = DB::table('skill_master')
        ->where('parent_id',$guide_cat)
        ->where('catag_type','!=','3')
        ->where('status','1');
        $returnArry['data'] = '';
        if($allCAtegory->count()>0){
            $allCAtegoryRow = $allCAtegory->get();
            $returnArry['data'] = $allCAtegoryRow;
            $returnArry['flag'] = '1';
            
        }else{
            $returnArry['flag'] = '0';
            $returnArry['msg'] = 'Some thing went wrong';
        }
        
        echo json_encode($returnArry);
        
    }
    
    
   
}