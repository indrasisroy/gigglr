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
use View;
use Illuminate\Routing\Route;

use Mail;

//use Image;

use App\Customlibrary\Imageuploadlib;

class FrontendMainsearchController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function mainsearch(Request $request)
    {
      
             
      
            $data=array();
            $data['data1']="hello";
            
            // return view('admin.logintemplate', $data);
            
            $user_id=0;
            
            if ($request->session()->has('front_id_sess'))
            {
                         $user_id= $request->session()->get('front_id_sess');
            
            }
            
            $whowhat = addslashes(trim($request->input('whowhat','')));
            $mainsearch = addslashes(trim($request->input('mainsearch','')));
            
            $category = addslashes(trim($request->input('category','')));
            $category = ($category=="Category")?"":$category;
            
            $genre = addslashes(trim($request->input('genre','')));
            $genre=($genre=="Genre")?"":$genre;
            
            $curr_lat = addslashes(trim($request->input('curr_lat','')));
            $curr_long = addslashes(trim($request->input('curr_long','')));
            
            
            $locationtxt = addslashes(trim($request->input('locationtxt','')));            
            
            $distance_data = addslashes(trim($request->input('distance_data','')));
            
            $available_date = addslashes(trim($request->input('available_date','')));
            $available_time = addslashes(trim($request->input('available_time','')));
            
            $available_datetime = addslashes(trim($request->input('available_datetime','')));
            
            $orderbycust = addslashes(trim($request->input('orderbycust','')));
            
            
            if(!empty($available_datetime))
            {
                    $available_datetime=date("Y-m-d H:i:s",strtotime($available_datetime));    
            }
            
            if(!empty($available_date))
            {
                    $available_date=date("Y-m-d",strtotime($available_date));    
            }
            
            if(!empty($available_time))
            {
                    $available_time=date("H:i:s",strtotime($available_time));    
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
            
            if(empty($distance_data))
            {
                        
                         $distance_data=$default_radius; // if distance not provided then set the data from admin settings
            }
           
           //**** if user is logged in then get addr_lat and addr_long  for center point for radius search starts
           if(!empty($user_id))
           {
                $fetchtype='single'; $tablename="user_master";
                $fieldnames=" addr_lat,addr_long ";
                $wherear=array();
                $wherear['id']=$user_id;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                
               
                if(!empty($fetchuserdata))
                {
                     
                     $curr_lat=$fetchuserdata->addr_lat;
                     $curr_long=$fetchuserdata->addr_long;
                } 
           }
           //**** if user is logged in then get addr_lat and addr_long  for center point for radius search ends
           
            
            //*** if locationtxt data posted then find lat long based on it starts
             $latitude=''; $longitude='';
            if(!empty($locationtxt))
            {
                        $fullBookingAddress = urlencode($locationtxt);
                        
                        $latlog = getLatLong($fullBookingAddress);
                        
                        $latitude = $latlog['latlong'][0]['latitude'];
                        $longitude = $latlog['latlong'][0]['longitude'];
                        
                        if($latitude!='' && $longitude!='')
                        {
                                  $curr_lat=  $latitude;
                                  $curr_long= $longitude;
                        }
                        
            }
             //*** if locationtxt data posted then  find lat long  based on it   starts
             
            //***** query for fetching starts
                
                //**** for user_master starts
                $user_master_qry=" ( ";
                         $user_master_qry.=" select usm.id,usm.type_flag,IF(usm.nickname='', '---', usm.nickname) as profile_name,
                                    usm.address1,usm.address2,
                                    usm.addr_lat,usm.addr_long,usm.addr_timezone , uskt.category_id ,uskt.category_name,uskt.genre_id,
                                    uskt.genre_name,uskt.skillsubskillrel,usm.status,usm.seo_name,IF(ISNULL(uimg.image_name), 'noimage', uimg.image_name) as image_name,
                                    IF(ISNULL(upk.presskit_name), 'nopresskit', upk.presskit_name) as presskit_name , usm.rate_amount,
                                    if((usm.rate_amount=0.00),'NO','YES') as allowedtobook ,
                                    IF(ISNULL(ggrvw.point_perc), '0.00',ggrvw.point_perc) as point_perc ";
                         
                         // for radius search           
                          if($curr_lat!='' && $curr_long!='')
                          {
                                    $user_master_qry.=" ,round(( 6371 * acos( cos( radians(".$curr_lat." ) ) *
                                    cos( radians(  usm.addr_lat ) ) * cos( radians(  usm.addr_long ) - radians(".$curr_long.") )
                                    + sin( radians(".$curr_lat." ) ) * sin( radians(  usm.addr_lat ) ) ) ),2) AS distance   "; 
                                    
                          }
                         $user_master_qry.=" from user_master as usm   ";
                                    
                                    
                        $user_master_qry.=" JOIN  (
                        SELECT psk.user_id, psk.skill_id as category_id, psk.name as category_name ,
                        ssk.skill_sub_id as genre_id, ssk.skill_name as genre_name , ssk.skillsubskillrel
                        FROM (                        
                                                
                        SELECT GROUP_CONCAT( DISTINCT usk.user_id ) AS user_id, GROUP_CONCAT( DISTINCT usk.skill_id ) AS skill_id, GROUP_CONCAT( DISTINCT skm.name ) AS name
                        FROM user_skill_rel AS usk
                        INNER JOIN skill_master AS skm ON usk.skill_id = skm.id
                        GROUP BY usk.user_id 
                        
                        
                        ) AS psk
                        
                        LEFT JOIN 
                        
                        (
                        
                        SELECT GROUP_CONCAT( DISTINCT usk.user_id ) AS user_id, GROUP_CONCAT( usk.skill_sub_id ) AS skill_sub_id, GROUP_CONCAT( skm.name ) AS skill_name,
                        GROUP_CONCAT( concat(usk.skill_id,'---',usk.skill_sub_id) ) as skillsubskillrel
                        FROM user_skill_rel AS usk
                        INNER JOIN skill_master AS skm ON usk.skill_sub_id = skm.id
                        GROUP BY usk.user_id
                        
                        ) AS ssk
                        
                        on psk.user_id=ssk.user_id
                        
                        )  as uskt
                        
                        on usm.id=uskt.user_id
                        
                        LEFT JOIN   `user_master_img` AS uimg
                        on  usm.id=  uimg.user_id and   uimg.default_status=1
                        
                        LEFT JOIN   `user_presskit` AS upk
                        on  usm.id=  upk.user_id
                        
                        Left JOIN (
                        
                        SELECT `gigmaster_id`,`punctuality`,`performance`,
                        `punctuality`+`performance`+`presentation` as  total_points,
                        round((( punctuality + performance+presentation)/15)*100,2) as point_perc,
                        `booker_flag_type`   FROM `gig_review` WHERE `artistgroupvenue_flag_type`=1
                        ) as  ggrvw
                        
                        on usm.id= ggrvw.gigmaster_id
                                                
                        
                        ";
                        
                        
                       
                        
                        
                        
                         $user_master_qry.=" where usm.nickname!='' and usm.status=1  ";
                        
                        if(!empty($mainsearch) && ($whowhat==1))
                        {
                                 $user_master_qry.=" and   usm.nickname LIKE '%".$mainsearch."%' ";
                        }
                        
                        if(!empty($mainsearch) && ($whowhat==2))
                        {
                                    
                        $user_master_qry.=" and ( FIND_IN_SET('".$mainsearch."',category_name) or FIND_IN_SET('".$mainsearch."',genre_name)  ) ";
                        }
                        
                        if(!empty($category) )
                        {
                                    
                         $user_master_qry.=" and ( FIND_IN_SET('".$category."',category_name)  ) ";
                        }
                        
                        if(!empty($genre) )
                        {
                                    
                         $user_master_qry.=" and ( FIND_IN_SET('".$genre."',genre_name)  ) ";
                        }
                        
                         if(!empty($available_date) && (!empty($available_time)))
                        {
                                    $user_master_qry.=" and usm.id NOT IN ( select gigm.usergrpvenid from (
                                    SELECT artist_id as usergrpvenid,type_flag,group_concat( date_format(event_date,'%Y-%m-%d') separator '||') as eventstartdate,
                                    group_concat(event_start_time separator '||') as eventstarttime, group_concat(event_start_date_time  separator '||' )  as eventstartdatetime ,
                                    group_concat(booking_status separator'||') as booking_status , group_concat(id   separator '||' ) as gigmasterid FROM `gig_master`
                                    WHERE type_flag=1 and booking_status=1  and date_format(event_date,'%Y-%m-%d') = '".$available_date."' and event_start_time ='".$available_time."'
                                    group by artist_id
                                    
                                    ) as gigm
                                    
                                    )                                    
                                    ";
                        }
                        elseif(!empty($available_date) )
                        {
                                     $user_master_qry.=" and usm.id NOT IN ( select gigm.usergrpvenid from (
                                    SELECT artist_id as usergrpvenid,type_flag,group_concat( date_format(event_date,'%Y-%m-%d') separator '||') as eventstartdate,
                                    group_concat(event_start_time separator '||') as eventstarttime, group_concat(event_start_date_time  separator '||' )  as eventstartdatetime ,
                                    group_concat(booking_status separator'||') as booking_status , group_concat(id   separator '||' ) as gigmasterid FROM `gig_master`
                                    WHERE type_flag=1 and booking_status=1  and date_format(event_date,'%Y-%m-%d') = '".$available_date."' 
                                    group by artist_id
                                    
                                    ) as gigm
                                    
                                    )                                    
                                    ";
                        }
                        
                        
                        
                        
                        
                        // for radius search 
                        if($curr_lat!='' && $curr_long!='')
                        {
                                    $user_master_qry.=" having  distance <=".$distance_data;
                        }
                
                         $user_master_qry.=" ) ";
                
                 
                
                //**** for user_master ends                    
                                    
                //**** for group_master   starts
                 $user_group_qry=" ( ";
                 $user_group_qry.=" select gm.id,gm.type_flag,IF(gm.nickname='', '---', gm.nickname) as profile_name,
                                   gm.address_1,gm.address_2,
                                    gm.group_lat,gm.group_long,gm.group_timezone ,gskt.category_id ,gskt.category_name,gskt.genre_id,
                                    gskt.genre_name,gskt.skillsubskillrel,gm.status,gm.seo_name,IF(ISNULL(gimg.image_name), 'noimage', gimg.image_name) as image_name,
                                    IF(ISNULL(gpk.presskit_name), 'nopresskit', gpk.presskit_name) as presskit_name , gm.rate_amount,
                                    if((gm.rate_amount=0.00),'NO','YES') as allowedtobook ,
                                    IF(ISNULL(ggrvw.point_perc), '0.00',ggrvw.point_perc) as point_perc
                                   
                                    ";
                                    
                        // for radius search           
                          if($curr_lat!='' && $curr_long!='')
                          {
                                    $user_group_qry.=" , round(( 6371 * acos( cos( radians(".$curr_lat." ) ) *
                                    cos( radians(  gm.group_lat ) ) * cos( radians(  gm.group_long ) - radians(".$curr_long.") )
                                    + sin( radians(".$curr_lat." ) ) * sin( radians(  gm.group_lat ) ) ) ),2) AS distance   "; 
                                    
                          }
                         $user_group_qry.="  from group_master as gm  ";
                         
                   $user_group_qry.=" JOIN  (  SELECT gpsk.group_id, gpsk.skill_id as category_id, gpsk.name as category_name ,
                        ssk.skill_sub_id as genre_id, ssk.skill_name as genre_name , ssk.skillsubskillrel
                        FROM (
                        
                            SELECT GROUP_CONCAT( DISTINCT gsk.group_id ) AS group_id, GROUP_CONCAT( DISTINCT gsk.skill_id ) AS skill_id, GROUP_CONCAT( DISTINCT skm.name ) AS name
                            FROM group_skill_rel AS gsk
                            INNER JOIN skill_master AS skm ON gsk.skill_id = skm.id
                            GROUP BY gsk.group_id                        
                        
                        ) AS gpsk
                        
                        LEFT JOIN 
                        
                        (
                        
                        SELECT GROUP_CONCAT( DISTINCT gsk.group_id ) AS group_id, GROUP_CONCAT( gsk.skill_sub_id ) AS skill_sub_id, GROUP_CONCAT( skm.name ) AS skill_name,
                        GROUP_CONCAT( concat(gsk.skill_id,'---',gsk.skill_sub_id) ) as skillsubskillrel
                        FROM group_skill_rel AS gsk
                        INNER JOIN skill_master AS skm ON gsk.skill_sub_id = skm.id
                        GROUP BY gsk.group_id
                        
                        ) AS ssk
                        
                        on gpsk.group_id=ssk.group_id )  as gskt
                        
                        on gm.id=gskt.group_id
                        
                        LEFT JOIN   `group_master_img` AS gimg
                        on  gm.id=  gimg.group_id and   gimg.default_status=1
                        
                        LEFT JOIN   `group_presskit` AS gpk
                        on  gm.id=  gpk.group_id
                        
                        Left JOIN (
                        
                        SELECT `gigmaster_id`,`punctuality`,`performance`,
                        `punctuality`+`performance`+`presentation` as  total_points,
                        round((( punctuality + performance+presentation)/15)*100,2) as point_perc,
                        `booker_flag_type`   FROM `gig_review` WHERE `artistgroupvenue_flag_type`=2
                        ) as  ggrvw
                        
                        on gm.id= ggrvw.gigmaster_id
                        
                        
                        ";
                  
                 
                  
                        
                  $user_group_qry.=" where gm.nickname!='' and gm.status=1    ";                 
                                    
                 
                                    
            if(!empty($mainsearch) && ($whowhat==1) )
            {
                         $user_group_qry.=" and   gm.nickname LIKE '%".$mainsearch."%' ";
            }
            
            if(!empty($mainsearch) && ($whowhat==2))
            {
            
                         $user_group_qry.=" and ( FIND_IN_SET('".$mainsearch."',category_name) or FIND_IN_SET('".$mainsearch."',genre_name)  ) ";
            }
            if(!empty($category) )
            {
            
                          $user_group_qry.=" and ( FIND_IN_SET('".$category."',category_name)  ) ";
            }
            
            if(!empty($genre) )
            {
                        
                          $user_group_qry.=" and ( FIND_IN_SET('".$genre."',genre_name)  ) ";
            }
            
            
             if(!empty($available_date) && (!empty($available_time)))
                        {
                                    $user_group_qry.=" and gm.id NOT IN (
                                    SELECT artist_id as usergrpvenid,type_flag,group_concat( date_format(event_date,'%Y-%m-%d') separator '||') as eventstartdate,
                                    group_concat(event_start_time separator '||') as eventstarttime, group_concat(event_start_date_time  separator '||' )  as eventstartdatetime ,
                                    group_concat(booking_status separator'||') as booking_status , group_concat(id   separator '||' ) as gigmasterid FROM `gig_master`
                                    WHERE type_flag=2 and booking_status=1  and date_format(event_date,'%Y-%m-%d') = '".$available_date."' and event_start_time ='".$available_time."'
                                    group by artist_id
                                    ) as gigm
                                    
                                    on gm.id= gigm.usergrpvenid
                                    
                                    ";
                        }
                         elseif(!empty($available_date) )
                        {
                                     $user_group_qry.=" and gm.id NOT IN (
                                    SELECT artist_id as usergrpvenid,type_flag,group_concat( date_format(event_date,'%Y-%m-%d') separator '||') as eventstartdate,
                                    group_concat(event_start_time separator '||') as eventstarttime, group_concat(event_start_date_time  separator '||' )  as eventstartdatetime ,
                                    group_concat(booking_status separator'||') as booking_status , group_concat(id   separator '||' ) as gigmasterid FROM `gig_master`
                                    WHERE type_flag=2 and booking_status=1  and date_format(event_date,'%Y-%m-%d') = '".$available_date."' 
                                    group by artist_id
                                    ) as gigm
                                    
                                    on gm.id= gigm.usergrpvenid
                                    
                                    ";
                        }
            
                        
            // for radius search 
            if($curr_lat!='' && $curr_long!='')
            {
                        $user_group_qry.=" having  distance <=".$distance_data;
            }            
                
                  $user_group_qry.=" ) ";
                //**** for group_master   ends 
                
                //**** for venue_master  starts
                $user_venue_qry=" ( ";
                $user_venue_qry.=" select vm.id,vm.type_flag,IF(vm.nickname='', '---', vm.nickname) as profile_name,
                                   vm.address_1,vm.address_2,
                                    vm.venue_lat,vm.venue_long,vm.venue_timezone , vskt.category_id ,vskt.category_name,vskt.genre_id,
                                    vskt.genre_name,vskt.skillsubskillrel,vm.status,vm.seo_name,IF(ISNULL(vimg.image_name), 'noimage', vimg.image_name) as image_name,
                                     IF(ISNULL(vpk.presskit_name), 'nopresskit', vpk.presskit_name) as presskit_name , vm.rate_amount,
                                     if((vm.rate_amount=0.00),'NO','YES') as allowedtobook ,
                                    IF(ISNULL(ggrvw.point_perc), '0.00',ggrvw.point_perc) as point_perc
                                     
                                     
                                    ";
                // for radius search           
                          if($curr_lat!='' && $curr_long!='')
                          {
                                    $user_venue_qry.=" , round(( 6371 * acos( cos( radians(".$curr_lat." ) ) *
                                    cos( radians(  vm.venue_lat ) ) * cos( radians(  vm.venue_long ) - radians(".$curr_long.") )
                                    + sin( radians(".$curr_lat." ) ) * sin( radians(  vm.venue_lat ) ) ) ),2) AS distance   "; 
                                    
                          }
                $user_venue_qry.="   from venue_master as vm  ";                    
                                    
                $user_venue_qry.=" JOIN  (
                                    SELECT vpsk.venue_id, vpsk.skill_id as category_id, vpsk.name as category_name ,
                                    ssk.skill_sub_id as genre_id, ssk.skill_name as genre_name , ssk.skillsubskillrel
                                    FROM (
                                    
                                    SELECT GROUP_CONCAT( DISTINCT vsk.venue_id ) AS venue_id, GROUP_CONCAT( DISTINCT vsk.skill_id ) AS skill_id, GROUP_CONCAT( DISTINCT skm.name ) AS name
                                    FROM venue_skill_rel AS vsk
                                    INNER JOIN skill_master AS skm ON vsk.skill_id = skm.id
                                    GROUP BY vsk.venue_id                        
                                    
                                    ) AS vpsk
                                    
                                    LEFT JOIN 
                                    
                                    (
                                    
                                    SELECT GROUP_CONCAT( DISTINCT vsk.venue_id ) AS group_id, GROUP_CONCAT( vsk.skill_sub_id ) AS skill_sub_id, GROUP_CONCAT( skm.name ) AS skill_name,
                                    GROUP_CONCAT( concat(vsk.skill_id,'---',vsk.skill_sub_id) ) as skillsubskillrel
                                    FROM venue_skill_rel AS vsk
                                    INNER JOIN skill_master AS skm ON vsk.skill_sub_id = skm.id
                                    GROUP BY vsk.venue_id
                                    
                                    ) AS ssk
                                    
                                    on vpsk.venue_id=ssk.group_id
                         ) as vskt
                         
                         on vm.id=vskt.venue_id
                         
                         LEFT JOIN   `venue_master_img` AS vimg
                         on  vm.id=  vimg.venue_id and   vimg.default_status=1
                         
                        LEFT JOIN   `venue_presskit` AS vpk
                        on  vm.id=  vpk.venue_id
                        
                         Left JOIN (
                        
                        SELECT `gigmaster_id`,`punctuality`,`performance`,
                        `punctuality`+`performance`+`presentation` as  total_points,
                        round((( punctuality + performance+presentation)/15)*100,2) as point_perc,
                        `booker_flag_type`  FROM `gig_review` WHERE `artistgroupvenue_flag_type`=3
                        ) as  ggrvw
                        
                        on vm.id= ggrvw.gigmaster_id
                         
                         ";
                         
                 
                                    
               $user_venue_qry.="  where vm.nickname!='' and vm.status=1  ";
               
                if(!empty($mainsearch) && ($whowhat==1) )
                {
                         $user_venue_qry.=" and   vm.nickname LIKE '%".$mainsearch."%' ";
                }
                
               if(!empty($mainsearch) && ($whowhat==2))
               {
                           
                         $user_venue_qry.=" and ( FIND_IN_SET('".$mainsearch."',category_name) or FIND_IN_SET('".$mainsearch."',genre_name)  ) ";
               }
               
            if(!empty($category))
                     {
                                 
                      $user_venue_qry.=" and ( FIND_IN_SET('".$category."',category_name)  ) ";
                     }
            
            if(!empty($genre) )
            {
                        
             $user_venue_qry.=" and ( FIND_IN_SET('".$genre."',genre_name)  ) ";
            }
            
             if(!empty($available_date) && (!empty($available_time)))
                        {
                                    $user_venue_qry.=" and vm.id NOT IN (
                                    SELECT artist_id as usergrpvenid,type_flag,group_concat( date_format(event_date,'%Y-%m-%d') separator '||') as eventstartdate,
                                    group_concat(event_start_time separator '||') as eventstarttime, group_concat(event_start_date_time  separator '||' )  as eventstartdatetime ,
                                    group_concat(booking_status separator'||') as booking_status , group_concat(id   separator '||' ) as gigmasterid FROM `gig_master`
                                    WHERE type_flag=2 and booking_status=1  and date_format(event_date,'%Y-%m-%d') = '".$available_date."' and event_start_time ='".$available_time."'
                                    group by artist_id
                                    ) as gigm
                                    
                                    on vm.id= gigm.usergrpvenid
                                    
                                    ";
                        }
                   elseif(!empty($available_date))
                        {
                                    $user_venue_qry.=" and vm.id NOT IN (
                                    SELECT artist_id as usergrpvenid,type_flag,group_concat( date_format(event_date,'%Y-%m-%d') separator '||') as eventstartdate,
                                    group_concat(event_start_time separator '||') as eventstarttime, group_concat(event_start_date_time  separator '||' )  as eventstartdatetime ,
                                    group_concat(booking_status separator'||') as booking_status , group_concat(id   separator '||' ) as gigmasterid FROM `gig_master`
                                    WHERE type_flag=2 and booking_status=1  and date_format(event_date,'%Y-%m-%d') = '".$available_date."' 
                                    group by artist_id
                                    ) as gigm
                                    
                                    on vm.id= gigm.usergrpvenid
                                    
                                    ";
                        }   
            
                        
            // for radius search 
            if($curr_lat!='' && $curr_long!='')
            {
                        $user_venue_qry.=" having  distance <=".$distance_data;
            }
            
               $user_venue_qry.=" ) ";
               
               //**** for venue_master  ends
                           
               
               
           //  $main_srch_union= " select a.* from ( ".  $user_master_qry." UNION ".$user_group_qry." UNION ".$user_venue_qry." ) as a ";
             $main_srch_union= " select a.* from ( ".  $user_master_qry." ) as a ";
             
            
             //***** append order by  clause to  the query starts
             if(!empty($orderbycust))
             {
                        if($orderbycust=="Name")
                        {
                                  $main_srch_union.=" order by a.profile_name ASC ";  
                        }
                        else if($orderbycust=="Popularity")
                        {
                                    $main_srch_union.=" order by (a.point_perc * 1) DESC ";  
                        }
                        else if($orderbycust=="Distance")
                        {
                                if($curr_lat!='' && $curr_long!='')
                                    {
                                                $main_srch_union.=" order by (a.distance * 1) DESC ";  
                                    }
                        }
                       
                        
             }
             //***** append order by  clause to  the query ends
             
                                    
            $mainserch_qry_data=DB::select($main_srch_union);
            
            
           
            
            
                
            //echo "==mainserch_qry_data==><pre>";
            //print_r($mainserch_qry_data);
            //echo "</pre>";                
            
            //***** query for fetching ends
            
            
            //****** for pagination starts****************************************
            
       
            $totaldata=0; //*** total count data
            if(!empty($mainserch_qry_data))
            {
                  $totaldata=count($mainserch_qry_data);
            }
               
            
        
        //**** calculate total pages starts
        
        $record_per_page=$record_per_page_data;
        $record_per_page=(empty($record_per_page)==true)?1:$record_per_page;
        
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
            
            $main_srch_union_lim=$main_srch_union." limit ".$startlimit.",".$record_per_page;
            $mainserch_qry_lim_data=DB::select($main_srch_union_lim);
        
        
        //*** call pagination starts
         
       // echo "=main_srch_union_lim=>$$$$$ ".$main_srch_union_lim." $$$$$"; 
         
        $reload="";
        $page=$pagenum;$tpages=$totpages;$ajaxstatus=1;
        
        $pagination_link=paginatecustom($reload, $page, $tpages,$ajaxstatus);
           
        //*** call pagination ends
            
            
            
        //****** for pagination ends*************************************************
            
            
           
            
            
            //*** get view data content starts
            $data['mainserch_qry_data']=$mainserch_qry_lim_data;
            $view_obj = View::make('front.home.ajax.mainsearchlistajax',$data);
            $ep_view_contents = $view_obj->render(); //echo $ep_view_contents;
             //*** get view data content ends
             
            //**** get category and  genre from searched data starts 
            
            $searchgenrecategdataAr=array(); 
            
            if( ( ($whowhat==2) && !empty($mainsearch) ) && !empty($mainserch_qry_lim_data) )
            {
                        foreach($mainserch_qry_lim_data as $mainserch_data)
                        {
                                    
                                    $category_id='';$category_name='';$genre_id='';$genre_name='';$skillsubskillrel='';
                                    $category_idAr=array(); $category_nameAr=array(); $genre_idAr=array(); $genre_nameAr=array(); $skillsubskillrelAr=array();

                                    if(!empty($mainserch_data->category_id))
                                    {
                                             $category_id=$mainserch_data->category_id;
                                             $category_idAr=explode(",",$category_id);
                                    }
                                    if(!empty($mainserch_data->category_name))
                                    {
                                             $category_name=$mainserch_data->category_name;
                                             $category_nameAr=explode(",",$category_name);
                                             
                                    }
                                    if(!empty($mainserch_data->genre_id))
                                    {
                                             $genre_id=$mainserch_data->genre_id;
                                             $genre_idAr=explode(",",$genre_id);
                                    }
                                    if(!empty($mainserch_data->genre_name))
                                    {
                                             $genre_name=$mainserch_data->genre_name;
                                             $genre_nameAr=explode(",",$genre_name);
                                    }
                                    if(!empty($mainserch_data->skillsubskillrel))
                                    {
                                             $skillsubskillrel=$mainserch_data->skillsubskillrel;
                                             $skillsubskillrelAr=explode(",",$skillsubskillrel);
                                    }
                                    
                                    $categgenAr=array();
                                    if(!empty($skillsubskillrelAr))
                                    {
                                             foreach($skillsubskillrelAr as $ssardata )
                                             {
                                                                  $ssrAr=explode("---",$ssardata);
                                                                  $categdata=$ssrAr[0];
                                                                  $genredata=$ssrAr[1];
                                                                  $categgenAr[]=array("categid"=>$categdata,"genreid"=>$genredata);
                                                                  
                                                                  // find categ name
                                                                  $ctgname=''; $grnname='';
                                                                  if(in_array($categdata,$category_idAr))
                                                                  {
                                                                        $ctidkey=array_search($categdata,$category_idAr);
                                                                        $ctgname=$category_nameAr[$ctidkey];
                                                                        
                                                                  }
                                                                  
                                                                  // find genre name
                                                                  if(in_array($genredata,$genre_idAr))
                                                                  {
                                                                        $gnridkey=array_search($genredata,$genre_idAr);
                                                                        $gnrname=$genre_nameAr[$gnridkey];
                                                                        
                                                                  }
                                                                  
                                                                  $searchgenrecategdataAr[]=array("categid"=>$categdata,"categname"=>$ctgname,"genreid"=>$genredata,"genrename"=>$gnrname);
                                            
                                             }
                                    
                                    }
                                    
                                    //
                                    /*if(!empty($category_idAr))
                                    {
										  for($ii=0;$ii<count($category_idAr);$ii++)
										  {
										  
										  $categid=$category_idAr[$ii];
                                          $dispgenrAr=array();
										  for($ss=0; $ss < count($categgenAr); $ss++)
										  {
															  
										  
															   if($categgenAr[$ss]['categid']==$categid)
															   {
											
															   $genreiddata=$categgenAr[$ss]['genreid'];
															   $genreiddata_pos=array_search($genreiddata,$genre_idAr);
											
															   $genrenamedata=$genre_nameAr[$genreiddata_pos];
															   $dispgenrAr[]=$genrenamedata;
															   }
											}
                                          }
                                     }*/
                                    //
                                                
                         }
            }
            
            
            $filtercategnameAr=array();$filtergenreAr=array();
            $found_in_categ=0; $found_in_genre=0; $categnmid=''; $genrenmid=''; $categnm=''; $genrenm='';
            $genrenmkeypos='';
            if(!empty($searchgenrecategdataAr))
            {
                        foreach($searchgenrecategdataAr as $searchgenrecategdt)
                        {
                                   $filtercategnameAr[]=$searchgenrecategdt['categname'];
                                   $filtergenreAr[]=$searchgenrecategdt['genrename'];
                        }
                        
                        if(in_array(strtoupper($mainsearch),$filtercategnameAr))
                        {
                                    $categnmkeypos=array_search(strtoupper($mainsearch),$filtercategnameAr);
                                    $categnmid=$searchgenrecategdataAr[$categnmkeypos]['categid'];
                                    
                                    $categnm=$searchgenrecategdataAr[$categnmkeypos]['categname'];
                                    
                                    $found_in_categ=1;
                        }
                        
                        
                        if( in_array(strtoupper($mainsearch),$filtergenreAr) )
                        {
                                    $genrenmkeypos=array_search(strtoupper($mainsearch),$filtergenreAr);
                                    $genrenmid=$searchgenrecategdataAr[$genrenmkeypos]['genreid'];                                    
                                    $categnmid=$searchgenrecategdataAr[$genrenmkeypos]['categid'];
                                    
                                    $categnm=$searchgenrecategdataAr[$genrenmkeypos]['categname'];
                                    $genrenm=$searchgenrecategdataAr[$genrenmkeypos]['genrename'];
                                    $found_in_genre=1;
                        }
                        
            }
            
            
           
            //**** get category and  genre from searched data ends
            
            //**** if no data has been found and whowhat is 2 , then find category name  and  id from skill_master table starts
            
          
             if(empty($mainserch_qry_lim_data) && ($whowhat==2) && (!empty($mainsearch)))
             {
                        $selectstr=" skm.* ";
                        
                        $skl_master_db=DB::table('skill_master as skm');              
                        $skl_master_db=$skl_master_db->select(DB::raw($selectstr));                                                          
                        $skl_master_db=$skl_master_db->where('skm.parent_id', 0);
                        //$skl_master_db=$skl_master_db->where('skm.status',1);
                        $skl_master_db=$skl_master_db->where('skm.name',$mainsearch);
                        $skl_master_db=$skl_master_db->orderBy("skm.name", "asc");
                        $skl_master_db=$skl_master_db->first();
                        
                        if(!empty($skl_master_db))
                        {
                                 $categnm=$mainsearch;
                                 $categnmid=$skl_master_db->id;
                                 
                        }
             }
            
            //**** if no data has been found and whowhat is 2 , then find category name from skill_master table ends 
           
            $respAr=array();
            
            $respAr['respdata']=$ep_view_contents;
            $respAr['pagination_link']=$pagination_link;
             $respAr['main_srch_union_lim']=$main_srch_union_lim;
            $respAr['mainserch_qry_data']=$mainserch_qry_data;
            $respAr['mainserch_qry_lim_data']=$mainserch_qry_lim_data;
            // $respAr['testme']=$testme;
            $respAr['loc-lat-long']="=locationtxt=>".$locationtxt."=latitude=>".$latitude."=longitude=>".$longitude."default_radius=>".$default_radius;
            $respAr['searchgenrecategdata']=$searchgenrecategdataAr;
            $respAr['selectcategnmid']=$categnmid;
            $respAr['selectgenrenmid']=$genrenmid;
            $respAr['selectcategnm']=$categnm;
            $respAr['selectgenrenm']=$genrenm;
           // $respAr['found_in_categ']=$found_in_categ; // required for debug
           // $respAr['found_in_genre']=$found_in_genre; // required for debug
           // $respAr['genrenmkeypos']=$genrenmkeypos;   // required for debug
           // $respAr['filtergenreAr']=$filtergenreAr;   // required for debug
            
            
            echo json_encode($respAr);
            
            
                  
            
               
              
    }
    
    public function mainsearchgenre(Request $request)
    {
             //**** fetch skill starts
                
                $parent_id = $request->input('parent_id','');
                               
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
                //$tab_db=$tab_db->whereRaw(" FIND_IN_SET('1',`catag_type`) ");
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

       
    public function mainsearchcitytowndata(Request $request)
    {
        $latidata =trim($request->input('latidata'));   // "22.5830327";
        $longidata =  trim($request->input('longidata')); // "88.4936501";
        $user_city='';
        
         if( !empty($latidata) && !empty($longidata) )
            {
                $citynmar=getCityNameAr($latidata,$longidata);
                
                if(!empty($citynmar))
                {
                  $user_city=implode(",",$citynmar);
                }
            }
            
            
            
            
            $respAr=array();
            $respAr['user_city']=$user_city;
            
            echo json_encode($respAr);
            
            
            
       
    }   
           
}