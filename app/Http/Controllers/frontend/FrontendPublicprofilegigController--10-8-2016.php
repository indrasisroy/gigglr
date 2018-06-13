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

class FrontendPublicprofilegigController extends Controller
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
    
    public function publicprofilegigs(Request $request)
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
        $seo_name = trim($request->input('seo_name'));
        $type_flag = trim($request->input('type_flag'));
        $category = trim($request->input('category'));
        $genre = trim($request->input('genre'));
        
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
        
        
        $filterevtype = trim($request->input('filterevtype'));
        $filterevtypeAr=array();
        
        $redclockflag=false; $yellowstarflag=false; $blackstarflag=false;
        
        if(!empty($filterevtype))
        {
            $filterevtypeAr=explode("||",$filterevtype);
            
            if(!empty($filterevtypeAr))
            {
                foreach($filterevtypeAr as $filterevtypedata)
                {
                    if($filterevtypedata=="REDCLOCK")
                    {
                        $redclockflag=true;
                    }
                    elseif($filterevtypedata=="YELLOWSTAR")
                    {
                        $yellowstarflag=true;
                    }
                    elseif($filterevtypedata=="BLACKSTAR")
                    {
                        $blackstarflag=true;
                    }
                    
                }
                
            }
            
        }
        
        
        
        $redclock_query="         
        select rcl.*  from 
        (
        
        SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount ,IF( (select count(*) from gig_bidrequest where     gigmaster_id= gm.id )>0,'REDCLOCK','REDCLOCK') as rcsipsbb,
        gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel
        
        FROM `gig_master` as gm
        
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
       
       on gm.id=gmsrt.gigmaster_id
       
        
       where gm.gigpostrequestflag IN (1,2) and gm.type_flag=".$type_flag." and
       gm.event_type IN(1,2,3)  and gm.booking_status=2 and   gm.booker_id<>".$user_id."
                       
       and (
        
        gm.artist_id=".$user_id."
        or
        gm.artist_id IN ( select grm.id from group_master as grm where grm.creater_id=".$user_id." and grm.status=1 )
        or
        gm.artist_id IN ( select vm.id from venue_master as vm where vm.creater_id=".$user_id." and vm.status=1 )
        
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
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'STARICON','STARICON') as rcsipsbb ,
        
        gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel
        
        FROM `gig_master` as gm
        
        
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
       
       on gm.id=gmsrt.gigmaster_id
       
       where gm.gigpostrequestflag IN (1,2) and gm.type_flag=".$type_flag." and  gm.event_type IN(1,3) and   gm.booker_id<>".$user_id." and gm.artist_id=".$user_id." and gm.booking_status=1
       
       ) as scq
       
       where   DATE_FORMAT(scq.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
       
        ";
        
        
         $blackstar_query="        
        select scq.* from (
        
         SELECT gm.id as gigmaster_id,gm.giguniqueid,gm.gigpostrequestflag,gm.type_flag,gm.event_type,
        gm.artist_id,gm.booker_id,gm.event_address1,gm.event_address2,gm.event_city,
        gm.event_state,gm.event_country,gm.event_zip,gm.event_address_lat,gm.event_address_long,
        gm.booking_req_date,gm.booking_accept_date,gm.event_date,gm.event_start_time,gm.event_start_date_time,
        gm.event_end_date_time,gm.event_end_date,gm.event_end_time,gm.request_expire_date,gm.request_expire_time,
        gm.request_expire_datetime,gm.event_timezone,gm.booking_status,gm.booking_cancellation_fee,gm.artist_security_deposit,
        gm.gig_description,gm.total_amount  ,IF(ISNULL(gm.id),'BLACKSTAR','BLACKSTAR') as rcsipsbb ,
        
        gmsrt.category_id, gmsrt.category_name ,gmsrt.genre_id, gmsrt.genre_name , gmsrt.categgenrerel
        
        FROM `gig_master` as gm
        
        
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
       
       on gm.id=gmsrt.gigmaster_id
       
       where gm.gigpostrequestflag IN (1,2) and gm.type_flag=".$type_flag." and  gm.event_type IN(2,3) and   gm.booker_id<>".$user_id." and gm.artist_id=".$user_id." and gm.booking_status=1
       
       ) as scq
       
       where   DATE_FORMAT(scq.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
       
        ";
        
        $unionmerge=''; $unionmergeAr=array();
        
         
        if($redclockflag==true)
        {
            $unionmergeAr[]=$redclock_query;
        }
        
        if($yellowstarflag==true)
        {
            $unionmergeAr[]=$star_clock_query;
        }
        
        if($blackstarflag==true)
        {
            $unionmergeAr[]=$blackstar_query;
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
       
        //$main_qry=$redclock_query." UNION ".$star_clock_query;
        
       // echo "==main_qry=>".$main_qry;
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
    
    public function calendarshowhidesave(Request $request)
    {
        
        $user_id=0;        
        if ($request->session()->has('front_id_sess'))
        {
            $user_id= $request->session()->get('front_id_sess');
        
        }
        
        
        
        $type_flag_data = trim($request->input('type_flag'));//1->artist,2->group,3->venue
        $cal_viewshowflag = trim($request->input('cal_viewshowflag'));//0,1
        $artistgrpvenueid = trim($request->input('artistgrpvenueid'));// artist id of user_master , group id of group_master , venue id of group_master
        
        $modified_date=date("Y-m-d H:i:s");            
       
        $updatear=array();
        $updatear['modified_date']=$modified_date;
        
        $update_flag=0;
        
        if($type_flag_data==1)
        {
            $updatear['cal_viewshowflag']=$cal_viewshowflag;
            
            $chkupd= DB::table('user_master')->where('id',$artistgrpvenueid) ->update($updatear);
            
        }
        elseif($type_flag_data==2)
        {
            $updatear['cal_viewshowflag']=$cal_viewshowflag;
            
            $chkupd= DB::table('group_master')->where('id',$artistgrpvenueid) ->update($updatear);
        }
        elseif($type_flag_data==3)
        {
            $updatear['cal_viewshowflag']=$cal_viewshowflag;
            
            $chkupd= DB::table('venue_master')->where('id',$artistgrpvenueid) ->update($updatear);
        }
        
        $update_flag=$chkupd;
        
        $returnResp=array();        
        $returnResp['update_flag']=$update_flag;
        
        echo json_encode($returnResp);
       
        
    }
    
    public function calpendbkpublicevesave(Request $request)
    {
        $user_id=0;        
        if ($request->session()->has('front_id_sess'))
        {
            $user_id= $request->session()->get('front_id_sess');
        
        }
        
        $type_flag = trim($request->input('type_flag'));
        $pendbkpblshowfl = trim($request->input('pendbkpblshowfl'));
        $cal_pendingbkshowflag = trim($request->input('cal_pendingbkshowflag'));
        $pendingbkshowflag = trim($request->input('pendingbkshowflag'));
        $artistgrpvenueid = trim($request->input('artistgrpvenueid'));


        $modified_date=date("Y-m-d H:i:s");            
       
        $updatear=array();
        $updatear['modified_date']=$modified_date;
        
        $update_flag=0;
        
        if($type_flag==1)
        {
            if($pendbkpblshowfl=="cal_pendingbkshowflag")
            {
                $updatear['cal_pendingbkshowflag']=$pendingbkshowflag;
            }
            elseif($pendbkpblshowfl=="cal_publiceventshowflag")
            {
                $updatear['cal_publiceventshowflag']=$pendingbkshowflag;
            }
            elseif($pendbkpblshowfl=="cal_privateeventshowflag")
            {
                $updatear['cal_privateeventshowflag']=$pendingbkshowflag;
            }
            
            $chkupd= DB::table('user_master')->where('id',$artistgrpvenueid) ->update($updatear);
            
        }
        elseif($type_flag==2)
        {
            if($pendbkpblshowfl=="cal_pendingbkshowflag")
            {
                $updatear['cal_pendingbkshowflag']=$pendingbkshowflag;
            }
            elseif($pendbkpblshowfl=="cal_publiceventshowflag")
            {
                $updatear['cal_publiceventshowflag']=$pendingbkshowflag;
            }
            elseif($pendbkpblshowfl=="cal_privateeventshowflag")
            {
                $updatear['cal_privateeventshowflag']=$pendingbkshowflag;
            }
            
            $chkupd= DB::table('group_master')->where('id',$artistgrpvenueid) ->update($updatear);
        }
        elseif($type_flag==3)
        {
            if($pendbkpblshowfl=="cal_pendingbkshowflag")
            {
                $updatear['cal_pendingbkshowflag']=$pendingbkshowflag;
            }
            elseif($pendbkpblshowfl=="cal_publiceventshowflag")
            {
                $updatear['cal_publiceventshowflag']=$pendingbkshowflag;
            }
            elseif($pendbkpblshowfl=="cal_privateeventshowflag")
            {
                $updatear['cal_privateeventshowflag']=$pendingbkshowflag;
            }
            $chkupd= DB::table('venue_master')->where('id',$artistgrpvenueid) ->update($updatear);
        }
        
        $update_flag=$chkupd;
        
        $returnResp=array();        
        $returnResp['update_flag']=$update_flag;
        
        echo json_encode($returnResp);


    }
    
   public function showreviewinprofilepg(Request $request)
   {
      $type_flag = trim($request->input('type_flag'));
      $reviewhow_ornot = trim($request->input('reviewyesorno')); 
      $venueID = trim($request->input('venueID'));

    //  die;
       // $update_flag=0;

        $modified_date=date("Y-m-d H:i:s");            

        $updatear=array();
        $updatear['modified_date']=$modified_date;

        if($type_flag == 1)
        {
            $updatear['review_show_flag']=$reviewhow_ornot;
            $chkupd= DB::table('user_master')->where('id',$venueID)->update($updatear);
        }
        else if($type_flag == 2)
        {
            $updatear['review_show_flag']=$reviewhow_ornot;
            $chkupd= DB::table('group_master')->where('id',$venueID)->update($updatear);
        }
        else if($type_flag == 3)
        {
            $updatear['review_show_flag']=$reviewhow_ornot;
            $chkupd= DB::table('venue_master')->where('id',$venueID)->update($updatear);
        }
           $update_flag=$chkupd;
        
        $returnResp=array();        
        $returnResp['update_flag']=$update_flag;
        $returnResp['flag_type']=$reviewhow_ornot;
        
        echo json_encode($returnResp);
   }

   
   
   //***************public profile leftpanel start**************//
   public function profileleftmanu (Request $request){
    
    $cal_select_date = trim($request->input('cal_select_date'));
    //$currentmonth = date("Y-m-d G:i:s",strtotime($cal_select_date));
    $currentmonth = date("Y-m-d",strtotime($cal_select_date));
    
    //$lastMonth = date("Y-m-d G:i:s",strtotime('+ 29 days'));
    //$lastMonth = date("Y-m-d",strtotime('+ 29 days'));
    $lastMonth = date("Y-m-d",strtotime('+ 29 days',strtotime($cal_select_date)));
    //$week = date("Y-m-d G:i:s",strtotime('+ 6 days'));
    $week = date("Y-m-d",strtotime('+ 6 days',strtotime($cal_select_date)));
    $currentday = date("Y-m-d",strtotime($cal_select_date));
    
    $data = array();

    $string_sql = '';
    


    
    
    $genre = trim($request->input('genre'));
    if($genre!=''){
        $string_sql = $string_sql."and gsk.`genre` = '".$genre."' ";
    }
    $category = trim($request->input('category'));
    if($category!=''){
        $string_sql = $string_sql."and gsk.`category` = '".$category."' ";
    }
    
    $filterevtype = trim($request->input('filterevtype'));

    
    $month = trim($request->input('month'));
    
    /*
     DATE_FORMAT(bbq.event_start_date_time,'%Y-%m-%d')  BETWEEN STR_TO_DATE('".$selectedfirstdate."','%Y-%m-%d') AND STR_TO_DATE('".$selectedlastdate."','%Y-%m-%d')
     */
    
    if($month!=''){
        if($month =='week'){
            $string_sql = $string_sql."and ( DATE_FORMAT(event_start_date_time,'%Y-%m-%d') BETWEEN STR_TO_DATE('".$currentmonth."','%Y-%m-%d') AND STR_TO_DATE('".$week."','%Y-%m-%d')  )";
        }
        else if($month =='day'){
            //$string_sql = $string_sql."and (`event_start_date_time` >= '".$currentday." 00:00:00"."' and `event_start_date_time` <= '".$currentday." 23:59:59"."')";
            $string_sql = $string_sql."and (DATE_FORMAT(event_start_date_time,'%Y-%m-%d')='".$currentday."' )";
            
        }else if($month =='month')
        {
             $string_sql = $string_sql."and ( DATE_FORMAT(event_start_date_time,'%Y-%m-%d') BETWEEN STR_TO_DATE('".$currentmonth."','%Y-%m-%d') AND STR_TO_DATE('".$lastMonth."','%Y-%m-%d'))";
        }
    }else{
        $string_sql = $string_sql."and (`event_start_date_time` >= '".$lastMonth."' and `event_start_date_time` <= '".$currentmonth."')"; 
    }
    
    $seo_name = trim($request->input('seo_name'));
    $user_type = trim($request->input('type_flag'));
    
    $tble_name = '';
    $tble_as = '';
    if($user_type == 1){
        $tble_name = `user_master`;
        $tble_as = 'user_master';
        
    }else if($user_type == 2){
        $tble_name = `group_master`;
        $tble_as = 'group_master';
    }else{
        $tble_name = `venue_master`;
        $tble_as = 'venue_master';
    }

    $tble_details = DB::table($tble_as)->where('seo_name',$seo_name)->first();
    
    $skill_master = DB::table('skill_master')->get();

    $user_id = $tble_details->id;
    $user_nickname = $tble_details->nickname;

    
    $filterevtypeArr = array();
    $filterevtypeArr = explode("||",$filterevtype);
    $unionArray = array();
    
    if (in_array("REDCLOCK", $filterevtypeArr))
    {
        //echo "<br>REDCLOCK";
        
        //$unionArray[] = "SELECT gm.*,'clock' as 'icone',um.`nickname` as Booker_name,gsk.`category`,gsk.`genre` FROM `gig_master` as gm,`user_master` as um , `gig_skill_rel` as gsk WHERE gm.`type_flag`='".$user_type."' and gm.`artist_id` = '".$user_id."' and gm.`booking_status` = 2 and gm.`booker_id` = um.`id` and gm.`id`= gsk.`gigmaster_id` ".$string_sql."";
        
                $unionArray[] = "SELECT gm.*,'clock' as 'icone',um.`nickname` as Booker_name,gsk.`category`,gsk.`genre` FROM `gig_master` as gm,`user_master` as um , `gig_skill_rel` as gsk WHERE gm.`type_flag`='".$user_type."' and gm.`artist_id` = '".$user_id."' and gm.`booking_status` = 2 and gm.`booker_id` = um.`id` and gm.`id`= gsk.`gigmaster_id` ".$string_sql." UNION SELECT gm.*,'clock' as 'icone',um.`nickname` as Booker_name,gsk.`category`,gsk.`genre` FROM `gig_bidrequest` as gbr,`gig_master` as gm,`user_master` as um , `gig_skill_rel` as gsk WHERE gbr.`artist_id`= '".$user_id."' and gm.`giguniqueid` = gbr.`giguniqueid` and gm.`artist_id`= '0'
and gm.`booking_status` = 2 
and gm.`booker_id` = um.`id` 
and gm.`id`= gsk.`gigmaster_id` ".$string_sql."";
        
        
        
        
        
        
        
        
        
        
        //$unionArray[] = "SELECT gm.*,'clock' as 'icone',um.`nickname` as Booker_name,gsk.`category`,gsk.`genre` FROM `gig_master` as gm,`user_master` as um ,`gig_skill_rel` as gsk WHERE gm.`type_flag`='".$user_type."' and (gm.`artist_id` =  '".$user_id."' or ( gm.`artist_id` =  '0' and gm.`booker_id` =  '".$user_id."')) and gm.`booking_status` = 2 and gm.`booker_id` = um.`id` and gm.`id`= gsk.`gigmaster_id` ".$string_sql."";
    }
    if(in_array("YELLOWSTAR", $filterevtypeArr)){
        
        //echo "<br>YELLOWSTAR";
        $unionArray[] = "SELECT gm.*,'star' as 'icone',um.`nickname` as Booker_name , gsk.`category`,gsk.`genre`FROM `gig_master` as gm,`user_master` as um,`gig_skill_rel` as gsk WHERE gm.`type_flag`='".$user_type."' and gm.`artist_id` = '".$user_id."' and gm.`booking_status` = 1 and (gm.`event_type` = '1' or gm.`event_type` = '3') and  gm.`booker_id` = um.`id` and gm.`id`= gsk.`gigmaster_id` ".$string_sql.""; 
    }
    if(in_array("BLACKSTAR", $filterevtypeArr)){
        
        //echo "<br>BLACKSTAR";
        $unionArray[] = "SELECT gm.*,'star' as 'icone',um.`nickname` as Booker_name , gsk.`category`,gsk.`genre`FROM `gig_master` as gm,`user_master` as um,`gig_skill_rel` as gsk WHERE gm.`type_flag`='".$user_type."' and gm.`artist_id` = '".$user_id."' and gm.`booking_status` = 1 and gm.`event_type` = '2' and gm.`booker_id` = um.`id` and gm.`id`= gsk.`gigmaster_id` ".$string_sql.""; 
    }
    
// added in 03-08 start
    
    /*

      $getGigListSql = "SELECT s . * FROM (SELECT gm.*,'star' as 'icone',um.`nickname` as Booker_name , gsk.`category`,gsk.`genre`FROM `gig_master` as gm,`user_master` as um,`gig_skill_rel` as gsk WHERE gm.`type_flag`='".$user_type."' and gm.`artist_id` = '".$user_id."' and gm.`booking_status` = 1 and gm.`booker_id` = um.`id` and gm.`id`= gsk.`gigmaster_id` ".$string_sql."
UNION 
SELECT gm.*,'clock' as 'icone',um.`nickname` as Booker_name,gsk.`category`,gsk.`genre` FROM `gig_master` as gm,`user_master` as um , `gig_skill_rel` as gsk WHERE gm.`type_flag`='".$user_type."' and gm.`artist_id` = '".$user_id."' and gm.`booking_status` = 2 and gm.`booker_id` = um.`id` and gm.`id`= gsk.`gigmaster_id` ".$string_sql.") s ORDER BY s.event_start_date_time DESC";  
    */
    $resp_arr=array();
    
    if(empty($unionArray)){
        $resp_arr['return_type']="0";
    }else{
        $afetUnionStr = implode(" UNION ",$unionArray);
    
        $getGigListSql = "SELECT s . * FROM (".$afetUnionStr.") s ORDER BY s.event_start_date_time DESC"; 
    
    // added in 03-08 end 
    
        //echo $getGigListSql;die;
        $getGigList_details = DB::select( DB::raw($getGigListSql));
        
        $data['skill'] = $skill_master;
        $data['nickname'] = $user_nickname;
        
       
        if(!empty($getGigList_details)){
            $data['all'] = $getGigList_details;
            
            //echo json_encode( $data['all'] );die;
            
            $view_obj = View::make('front.common_profile.profileleftmenu',$data);
            $ep_view_contents = $view_obj->render();
            $resp_arr['ep_contents']=$ep_view_contents;
            $resp_arr['return_type']="1";
        }else{
            $resp_arr['return_type']="0";
        }
    }

    
    echo json_encode($resp_arr);
    
   }
   
   
    public function getcatgen (Request $request){
        
    $data = array();
    $seo_name = trim($request->input('seo_name'));
    $user_type = trim($request->input('type_flag'));
    $tble_as = '';
    $tble_skl = '';
    $tble_col = '';
    if($user_type == 1){
        $tble_as = 'user_master';
        $tble_skl = 'user_skill_rel';
        $tble_col ='user_id';
        
    }else if($user_type == 2){
        $tble_as = 'group_master';
        $tble_skl = 'group_skill_rel';
        $tble_col ='group_id';
    }else{
        $tble_as = 'venue_master';
        $tble_skl = 'venue_skill_rel';
        $tble_col ='venue_id';
    }
    
    $tble_details = DB::table($tble_as)->where('seo_name',$seo_name)->first();
    
    $tble_id = $tble_details->id;
    $getCatListSql = "SELECT vskl.`skill_id` as 'id',skm.`name` FROM `".$tble_skl."` as vskl, `skill_master` as skm WHERE vskl.`skill_id` = skm.`id` and vskl.`".$tble_col."`='".$tble_id."'  Group by skm.`name`";

    $getCatListDetails = DB::select( DB::raw($getCatListSql));

 
    $data['category'] = $getCatListDetails;

    $view_obj = View::make('front.common_profile.profilepagecatgen',$data);
    $ep_view_contents = $view_obj->render();
    $resp_arr=array();
    
    $resp_arr['ep_contents']=$ep_view_contents;
    
    echo json_encode($resp_arr);
   }
   
   function profilegenajax(Request $request){
    $data = array();
    $seo_name = trim($request->input('seo_name'));
    $user_type = trim($request->input('type_flag'));
    $category = trim($request->input('pro_category'));
    $tble_as = '';
    $tble_skl = '';
    $tble_col = '';
    if($user_type == 1){
        $tble_as = 'user_master';
        $tble_skl = 'user_skill_rel';
        $tble_col ='user_id';
        
    }else if($user_type == 2){
        $tble_as = 'group_master';
        $tble_skl = 'group_skill_rel';
        $tble_col ='group_id';
    }else{
        $tble_as = 'venue_master';
        $tble_skl = 'venue_skill_rel';
        $tble_col ='venue_id';
    }
    
    $tble_details = DB::table($tble_as)->where('seo_name',$seo_name)->first();
    
    $tble_id = $tble_details->id;

    $getgenListSql = "SELECT vskl.`skill_sub_id` as 'id',skm.`name` FROM `".$tble_skl."` as vskl, `skill_master` as skm WHERE vskl.`skill_sub_id` = skm.`id` and vskl.`".$tble_col."`='".$tble_id."' and vskl.`skill_id` = '".$category."'";
    $getGenListDetails = DB::select( DB::raw($getgenListSql));

    echo json_encode($getGenListDetails);
   }
   
   //***************public profile leftpanel end**************//
   
   //***************public profile leftpanel modal start**************//
   function profilemodalajax(Request $request){
    $type_flag = trim($request->input('type_flag'));
    $event_type = trim($request->input('event_type'));
    $gigunicid = trim($request->input('gigunicid'));
    
    
    
    $gig_master_details = DB::table('gig_master')
    ->where('giguniqueid',$gigunicid)
    ->where('event_type',$event_type)
    ->where('type_flag',$type_flag)    
    ->first();
    
    $booker_id = $gig_master_details->booker_id;
    $booking_status = $gig_master_details->booking_status;
    $booking_expire_datetime = $gig_master_details->request_expire_datetime;
    $type_flag_gig_master = $gig_master_details->type_flag;
    
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
    $data['gig_master_details']=$gig_master_details;
    $data['get_gig_Cat_details']  = $fetCat_details[0]->name;
    $data['get_gig_Gen_details']  = $fetGen_details[0]->name;
    
    //return view('front.common_profile.profilemodal',$data);die;
    $view_obj = View::make('front.common_profile.profilemodal',$data);
    $ep_view_contents = $view_obj->render();
    $resp_arr=array();
    
    $resp_arr['ep_contents']=$ep_view_contents;
    
    echo json_encode($resp_arr);
    //echo json_encode($gig_master_details);
    
   }
   //***************public profile leftpanel modal end**************//
}