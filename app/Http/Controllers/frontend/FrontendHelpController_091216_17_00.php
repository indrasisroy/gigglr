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
use Mail;
use View;


class FrontendHelpController extends Controller
{
    
    public function index(Request $request)
    {
        //echo "FrontendSupportController";
        $datahelp=array();
        
        //***** for article help  description starts ************
        $articlePage = DB::table('article as ar');
        $articlePage=$articlePage->select(DB::raw('ar.description,ar.title'));
        $articlePage=$articlePage->where('ar.status', 1);
        $articlePage=$articlePage->where('ar.id', 13);        
        $articlePagedata=$articlePage->first();
        //***** for article help  description ends ************
        
        //***** for help_supportbypage starts ************
        $help_supportbypage = DB::table('help_supportbypage as supportbypage');
        $help_supportbypage=$help_supportbypage->select(DB::raw('supportbypage.id,supportbypage.title,supportbypage.description,supportbypage.seo_name,supportbypage.create_date,supportbypage.modified_date'));
        $help_supportbypage=$help_supportbypage->where('supportbypage.status', 1);
        $help_supportbypage=$help_supportbypage->orderby('supportbypage.modified_date','DESC')->skip(0)->take(6);
        $help_supportbypagedata=$help_supportbypage->get();
        //***** for help_supportbypage ends ************
       
        //***** for howitsdone starts ************
        $help_howitsdone = DB::table('help_howitsdone as howitsdone');
        $help_howitsdone=$help_howitsdone->select(DB::raw('howitsdone.id,howitsdone.title,howitsdone.youtube_embed,howitsdone.seo_name,howitsdone.create_date,howitsdone.modified_date'));
        $help_howitsdone=$help_howitsdone->where('howitsdone.status', 1)->skip(0)->take(6);
        $help_howitsdonedata=$help_howitsdone->get();
        //***** for howitsdone ends ************
        
        //***** for faq starts ************        
        $help_faqpagedata=array();
        $help_faqpage = DB::table('faq as fq');
        $help_faqpage=$help_faqpage->select(DB::raw('fq.id,fq.title,fq.description,fq.seo_name,fq.create_date,fq.modified_date'));
        $help_faqpage=$help_faqpage->where('fq.publish', 1);
        $help_faqpage=$help_faqpage->orderby('fq.modified_date','ASC')->skip(0)->take(6);
        $help_faqpagedata=$help_faqpage->get();        
        //***** for faq ends   ************
        
        
        $datahelp['supportbypage']=$help_supportbypagedata;
        $datahelp['howitsdone']=$help_howitsdonedata;
        $datahelp['artile']=$articlePagedata;
        $datahelp['faqpage']=$help_faqpagedata;        
        //
        //echo "<pre>";
        //print_r($datahelp);
        //echo "</pre>";
        //die;
        //
      return view('front.help.helpview',$datahelp);
    }
        
    public function support(Request $request)
    {
		$presentdt=date('Y-m-d H:i:s');
		$frontloginuserid='';
		$cancelbookingqry='';
		$cancelbooking_content=array();
		$cancel_bookinglist=array();
		$sess_id = $request->session()->get('front_id_sess');
		if(isset($sess_id) && $sess_id!=0)
		{
			$frontloginuserid=$sess_id;
			$cancelbookingqry = DB::select(
"(SELECT gm.id AS gigmasterid, gm.giguniqueid AS uniquegigid, gm.type_flag AS flagtype, gm.artist_id AS artistid, um.nickname AS artistname, um.email AS artistmail, IF('1'='1', 'artist', 'booker') AS bookerorartist
FROM gig_master AS gm
LEFT JOIN user_master AS um ON um.id=gm.artist_id
WHERE gm.booker_id='".$frontloginuserid."'
AND gm.artist_id!='0'
AND gm.type_flag='1'
AND gm.booking_status='1'
AND (gm.event_start_date_time > '".$presentdt."')
AND gm.id NOT IN (SELECT gig_id from resolve_dispute))
	UNION
(SELECT gm.id AS gigmasterid, gm.giguniqueid AS uniquegigid, gm.type_flag AS flagtype, gm.artist_id AS artistid, grp.nickname AS artistname, um.email as artistmail, IF('1'='1', 'group', 'booker') AS bookerorartist
FROM gig_master AS gm
LEFT JOIN group_master AS grp ON grp.id=gm.artist_id
LEFT JOIN user_master AS um ON um.id=grp.creater_id
WHERE gm.booker_id='".$frontloginuserid."'
AND gm.artist_id!='0'
AND gm.type_flag='2'
AND gm.booking_status='1'
AND (gm.event_start_date_time > '".$presentdt."')
AND gm.id NOT IN (SELECT gig_id from resolve_dispute))
	UNION
(SELECT gm.id AS gigmasterid, gm.giguniqueid AS uniquegigid, gm.type_flag AS flagtype, gm.artist_id AS artistid, ven.nickname AS artistname, um.email AS artistmail, IF('1'='1', 'venue', 'booker') AS bookerorartist
FROM gig_master AS gm
LEFT JOIN venue_master AS ven ON ven.id=gm.artist_id
LEFT JOIN user_master AS um ON um.id=ven.creater_id
WHERE gm.booker_id='".$frontloginuserid."'
AND gm.artist_id!='0'
AND gm.type_flag='3'
AND gm.booking_status='1'
AND (gm.event_start_date_time > '".$presentdt."')
AND gm.id NOT IN (SELECT gig_id from resolve_dispute))
    UNION
(SELECT gm.id AS gigmasterid, gm.giguniqueid AS uniquegigid, gm.type_flag AS flagtype, gm.booker_id AS artistid, um.nickname AS artistname, um.email AS artistmail, IF('1'='1', 'booker', 'artist') AS bookerorartist
FROM gig_master AS gm
LEFT JOIN user_master as um ON um.id=gm.booker_id
WHERE ( gm.artist_id='".$frontloginuserid."'
OR gm.artist_id IN (SELECT grm.id FROM group_master AS grm WHERE grm.creater_id='".$frontloginuserid."' AND grm.status='1')
OR gm.artist_id IN (SELECT venu.id FROM venue_master AS venu WHERE venu.creater_id='".$frontloginuserid."' AND venu.status='1') )
AND gm.booking_status='1'
AND (gm.event_end_date_time > '".$presentdt."')
AND gm.id NOT IN (SELECT gig_id from resolve_dispute))"
			);
			
			if(count($cancelbookingqry)>0)
			{
				foreach( $cancelbookingqry as $cancelbookingdata )
				{
					$cancelgigmastermainid=$cancelbookingdata->gigmasterid;
					$cancelgigartistmail=$cancelbookingdata->artistmail;
					$cancelgiguniqueid=$cancelbookingdata->uniquegigid;
					$cancelgigartistname=$cancelbookingdata->artistname;
					$cancelgigartisttype=$cancelbookingdata->bookerorartist;
					$cancelbooking_content['element']=$cancelgigmastermainid."-".$cancelgigartistmail;
					$cancelbooking_content['content']=$cancelgigartistname." (".$cancelgigartisttype.") - ".$cancelgiguniqueid." (unique gig ID)";
					
					array_push($cancel_bookinglist,$cancelbooking_content);
				}
			}
		}
		else
		{
			$frontloginuserid='';
		}
		
        $against_artist_query=''; $against_group_query=''; $against_venue_query=''; $against_booker_query=''; $reasonarrqry='';
        $datasupport=array(); $against_artist=array(); $against_group=array(); $against_venue=array(); $against_booker=array(); $against_artist_content=array(); $against_group_content=array(); $against_venue_content=array(); $against_booker_content=array(); $reasonarrcontent=array(); $reasonarr=array();
        
		$reasonarrqry = DB::select(
						"SELECT rsn.*
						FROM contactus_category AS rsn
						WHERE rsn.status='1'"
					);
		
		if(count($reasonarrqry)>0)
		{
			foreach( $reasonarrqry as $reasonarrqrydata )
			{
				$mainreasonid=$reasonarrqrydata->id;
				$mainreason=$reasonarrqrydata->category_name;
				$mainreasoncontent=stripslashes($mainreason);
				$reasonarrcontent['element']=$mainreasonid;
				$reasonarrcontent['content']=$mainreasoncontent;
				
				array_push($reasonarr,$reasonarrcontent);
			}
		}
		
		//$today=date("Y-m-d");
		//$prev_date = date('Y-m-d', strtotime($today .' -1 day'));
		
		$today = date('Y-m-d H:i:s');
		$prev_date = date('Y-m-d H:i:s', strtotime("-48 hours", strtotime($today)));
		//$gt = date('Y-m-d H:i:s', strtotime("+48 hours", strtotime($ft)));

//		$today="2016-11-08";
//		$prev_date = "2016-11-06";
        
        if ($request->session()->has('front_id_sess'))
        {
            $sess_user_id= $request->session()->get('front_id_sess');  
        }

        if(isset($sess_user_id) && $sess_user_id!=0)
        {
            $against_artist_query = DB::select(
"SELECT gm.id AS gigmasterid, gm.giguniqueid AS uniquegigid, gm.artist_id AS artistid, um.nickname AS artistname, um.email AS artistmail
FROM gig_master AS gm
LEFT JOIN user_master AS um ON um.id=gm.artist_id
WHERE gm.booker_id='".$sess_user_id."'
AND gm.artist_id!='0'
AND gm.type_flag='1'
AND gm.booking_status='1'
AND ((gm.event_end_date_time >= '".$prev_date."') AND (gm.event_end_date_time <= '".$today."'))
AND gm.id NOT IN (SELECT gig_id from resolve_dispute)"
			);
        
            $against_group_query = DB::select(
"SELECT gm.id AS gigmasterid, gm.giguniqueid AS uniquegigid, gm.artist_id AS groupid, grp.nickname AS groupname, grp.creater_id AS groupcraetorid, um.nickname AS groupcreatorname, um.email as groupcreatormail
FROM gig_master AS gm
LEFT JOIN group_master AS grp ON grp.id=gm.artist_id
LEFT JOIN user_master AS um ON um.id=grp.creater_id
WHERE gm.booker_id='".$sess_user_id."'
AND gm.artist_id!='0'
AND gm.type_flag='2'
AND gm.booking_status='1'
AND ((gm.event_end_date_time >= '".$prev_date."') AND (gm.event_end_date_time <= '".$today."'))
AND gm.id NOT IN (SELECT gig_id from resolve_dispute)"
			);
        
            $against_venue_query = DB::select(
"SELECT gm.id AS gigmasterid, gm.giguniqueid AS uniquegigid, gm.artist_id AS venueid, ven.nickname AS venuename, ven.creater_id AS venuecreatorid, um.nickname AS venuecreatorname, um.email AS venuecreatormail
FROM gig_master AS gm
LEFT JOIN venue_master AS ven ON ven.id=gm.artist_id
LEFT JOIN user_master AS um ON um.id=ven.creater_id
WHERE gm.booker_id='".$sess_user_id."'
AND gm.artist_id!='0'
AND gm.type_flag='3'
AND gm.booking_status='1'
AND ((gm.event_end_date_time >= '".$prev_date."') AND (gm.event_end_date_time <= '".$today."'))
AND gm.id NOT IN (SELECT gig_id from resolve_dispute)"
			);
            
            $against_booker_query = DB::select(
"SELECT gm.id AS gigmasterid, gm.giguniqueid AS uniquegigid, gm.booker_id AS bookerid, um.nickname AS bookername, um.email AS bookermail
FROM gig_master AS gm
LEFT JOIN user_master as um ON um.id=gm.booker_id
WHERE ( gm.artist_id='".$sess_user_id."'
OR gm.artist_id IN (SELECT grm.id FROM group_master AS grm WHERE grm.creater_id=".$sess_user_id." AND grm.status='1')
OR gm.artist_id IN (SELECT venu.id FROM venue_master AS venu WHERE venu.creater_id=".$sess_user_id." AND venu.status='1') )
AND gm.booking_status='1'
AND ((gm.event_end_date_time >= '".$prev_date."') AND (gm.event_end_date_time <= '".$today."'))
AND gm.id NOT IN (SELECT gig_id from resolve_dispute)"
			);
        
        //}
       
	   //echo count($against_artist_query);die;
       //print_r($against_artist_query);die;
	   
			if(count($against_artist_query)>0)
			{
				foreach( $against_artist_query as $against_artist_data )
				{
					$gigmastermainid=$against_artist_data->gigmasterid;
					$gigartistmail=$against_artist_data->artistmail;
					$giguniqueid=$against_artist_data->uniquegigid;
					$artistname=$against_artist_data->artistname;
					$against_artist_content['element']=$gigmastermainid."-".$gigartistmail;
					$against_artist_content['content']=$artistname." - ".$giguniqueid." (unique gig ID)";
					
					array_push($against_artist,$against_artist_content);
				}
			}
			
			if(count($against_group_query)>0)
			{
				foreach( $against_group_query as $against_group_data )
				{
					$gigmastermainid=$against_group_data->gigmasterid;
					$groupcreatormail=$against_group_data->groupcreatormail;
					$giguniqueid=$against_group_data->uniquegigid;
					$groupname=$against_group_data->groupname;
					$against_group_content['element']=$gigmastermainid."-".$groupcreatormail;
					$against_group_content['content']=$groupname." - ".$giguniqueid." (unique gig ID)";
					
					array_push($against_group,$against_group_content);
				}
			}
		   
			if(count($against_venue_query)>0)
			{
				foreach( $against_venue_query as $against_venue_data )
				{
					$gigmastermainid=$against_venue_data->gigmasterid;
					$venuecreatormail=$against_venue_data->venuecreatormail;
					$giguniqueid=$against_venue_data->uniquegigid;
					$venuename=$against_venue_data->venuename;
					$against_venue_content['element']=$gigmastermainid."-".$venuecreatormail;
					$against_venue_content['content']=$venuename." - ".$giguniqueid." (unique gig ID)";
					
					array_push($against_venue,$against_venue_content);
				}
			}
			
			if(count($against_booker_query)>0)
			{
				foreach( $against_booker_query as $against_booker_data )
				{
					$gigmastermainid=$against_booker_data->gigmasterid;
					$bookermail=$against_booker_data->bookermail;
					$giguniqueid=$against_booker_data->uniquegigid;
					$bookername=$against_booker_data->bookername;
					$against_booker_content['element']=$gigmastermainid."-".$bookermail;
					$against_booker_content['content']=$bookername." - ".$giguniqueid." (unique gig ID)";
					
					array_push($against_booker,$against_booker_content);
				}
			}
		}
		
        $datasupport['against_artist']=$against_artist;
        $datasupport['against_group']=$against_group;
        $datasupport['against_venue']=$against_venue;
        $datasupport['against_booker']=$against_booker;
		$datasupport['reasonarr']=$reasonarr;
		$datasupport['frontloginuserid']=$frontloginuserid;
		$datasupport['gigeventarr']=$cancel_bookinglist;
        
        return view('front.help.supportview',$datasupport);
    }
        
        //return view('front.help.supportview');
    

    //************* For Static page content starts here

    public function termsandconditions()
    {
       $termsandconditionsqry =  DB::table('article')->where('id',9)->first();

       $titledata = $termsandconditionsqry->title;
       $descdata = $termsandconditionsqry->description;

       $data = array();
       $data['titledata'] = $titledata;
       $data['description'] = $descdata;


       return view('front.help.staticcontent', $data);

    }
    
    public function securityandsafety()
    {
       $termsandconditionsqry =  DB::table('article')->where('id',11)->first();

       $titledata = $termsandconditionsqry->title;
       $descdata = $termsandconditionsqry->description;

       $data = array();
       $data['titledata'] = $titledata;
       $data['description'] = $descdata;


       return view('front.help.staticcontent', $data);

    }
    
    public function privacypolicy()
    {
       $termsandconditionsqry =  DB::table('article')->where('id',12)->first();

       $titledata = $termsandconditionsqry->title;
       $descdata = $termsandconditionsqry->description;

       $data = array();
       $data['titledata'] = $titledata;
       $data['description'] = $descdata;


       return view('front.help.staticcontent', $data);

    }
	
	public function tips()
    {
       $tipsqry =  DB::table('article')->where('id',17)->first();

       $titledata = $tipsqry->title;
       $descdata = $tipsqry->description;

       $data = array();
       $data['titledata'] = $titledata;
       $data['description'] = $descdata;


       return view('front.help.staticcontent', $data);

    }
	
	
    //************* For Static page content ends here

    public function againstartistfrmsubfunc(Request $request)
	{
		$flag_id = 0; $error_message=''; $responseAr=array(); $error_msgAr=array(); $myerror_message=array();$my_message=array();
		
		$sess_id = $request->session()->get('front_id_sess');
		
		if(isset($sess_id) && $sess_id!=0)
		{
			$arriveradio =$request->input('arriveradio');
			$arrivetime =$request->input('arrivaltime');
			$specificationradio =$request->input('specificationradio');
			$performanceradio =$request->input('performanceradio');
			$technicalradio =$request->input('technicalradio');
			$riderradio =$request->input('riderradio');
			$leaveradio =$request->input('leaveradio');
			$lefttime =$request->input('leavetime');
			$againstartist =$request->input('againstartist');
			$description=$request->input('description');
			
			$arrivaltime=date("H:i:s",strtotime($arrivetime));
			$leavetime=date("H:i:s",strtotime($lefttime));
			
			$openingDate = date('Y-m-d H:i:s');
			
			$gigmasterid='';
			$artistmail='';
			if($againstartist!='' && $againstartist!=0)
			{
				$split_array=explode("-",$againstartist);
				$gigmasterid=$split_array[0];
				$artistmail=$split_array[1];
			}
			
			$artist_query = DB::select(
	"SELECT gm.giguniqueid AS uniquegigid, gm.artist_id AS artistid, gm.event_city AS gigtown, gm.event_start_date_time AS gigstartdate, um.nickname AS artistname
	FROM gig_master AS gm
	LEFT JOIN user_master AS um ON um.id=gm.artist_id
	WHERE gm.id='".$gigmasterid."'"
			);
			if(count($artist_query)>0)
			{
				$gigmasteruniqueid=$artist_query[0]->uniquegigid;
				$artistname=$artist_query[0]->artistname;
				$gigtown=$artist_query[0]->gigtown;
				$gigstart=$artist_query[0]->gigstartdate;
				$gigstartdate=date("d/m/Y h:i A",strtotime($gigstart));
			}
			else{
				$gigmasteruniqueid='';
				$artistname='';
				$gigtown='';
				$gigstartdate='';
			}
			$gigname=$artistname."-".$gigmasteruniqueid." (unique gig ID)";
			
			$insertdataarr=array();
			
			$chkvalid=$this->checkagainstartistform($request,$sess_id);
			if($chkvalid===true)
			{
				$insertdataarr['dispute_opener_id']=$sess_id;
				$insertdataarr['gig_id']=$gigmasterid;
				$insertdataarr['gig_unique_id']=$gigmasteruniqueid;
				$insertdataarr['gig_name']=$gigname;
				$insertdataarr['dispute_opening_date']=$openingDate;
				$insertdataarr['dispute_type']='1';
				$insertdataarr['issue_description']=$description;
				$insertdataarr['arrival']=$arriveradio;
				$insertdataarr['arrival_time']=$arrivaltime;
				$insertdataarr['required_specifications_availability']=$specificationradio;
				$insertdataarr['able_to_complete']=$performanceradio;
				$insertdataarr['technical_issue']=$technicalradio;
				$insertdataarr['receive_rider']=$riderradio;
				$insertdataarr['leave_early']=$leaveradio;
				$insertdataarr['leaving_time']=$leavetime;
				$insertdataarr['venue_presentation']='';
				$insertdataarr['getting_gig']='';
				$insertdataarr['commencing_gig']='';
				
				$isInserted = DB::table('resolve_dispute')->insert($insertdataarr);
				
				$isUpdated1 = DB::table('gig_master')
								->where('id', $gigmasterid)
								->update(['dispute_flag' => '1']);
			
				$flag_id = 1;
				
				//****** sending mail to the artist
				
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
				
				$booker_query = DB::select(
					"SELECT usm.nickname AS bookername
					FROM user_master AS usm
					WHERE usm.id='".$sess_id."'"
				);
				if(count($booker_query)>0)
				{
					$frombooker=$booker_query[0]->bookername;
				}
				else{
					$frombooker='';
				}
				
				//*********get user details ends here
				
				//$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
				$logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
				
				$self='you';
				
				//*********Helper Function Starts here
				
				$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKER}','{SELF}','{STARTDATE}','{TOWN}','{SITENAME}','{YEAR}');
				$replaceto =array($logoIMG,$bsurl,$artistname,$frombooker,$self,$gigstartdate,$gigtown,$sitename,$copyright_year);
				
				mailsnd($Temid=26,$replacefrom,$replaceto,$artistmail);
				
				//*********Helper Function Ends here
				
			}
			else{
				$flag_id = 0;
				$error_message = $chkvalid->messages();
			}
			
			if(!empty($error_message))
			{
				$error_message=json_decode(json_encode($error_message));
			  
				foreach($error_message as $kk => $error_message_ar)
				{
					$error_msgAr[$kk]=implode("<br>",$error_message_ar);    
				}
			  
			}
	
			$responseAr['flag_id']=$flag_id;
			$responseAr['error_message']=$error_msgAr;
		}
		else{
			$error_msgAr[0]="You must be logged in to resolve a dispute";
			$responseAr['flag_id']=3;
			$responseAr['error_message']=$error_msgAr;
		}
		
        echo json_encode($responseAr);
	}
	
	public function checkagainstartistform($request,$sess_id=0)
    {
        $validator = Validator::make($request->all(),
			[
				'arriveradio' => "required",
				'arrivaltime'=> "required",
				'specificationradio'=> "required",
				'performanceradio'=> "required",
				'technicalradio'=> "required",
				'riderradio'=> "required",
				'leaveradio'=> "required",
				'leavetime'=> "required",
				'againstartist'=> "required",
				'description'=> "required|max:500",
			],
			[
				'arriveradio.required'=>'* Confirmation of the artists arrival is required',
				'arrivaltime.required'=>'* Arrival time field is required',
				'specificationradio.required'=>'* Confirmation of the availability of the artists required specifications is required',
				'performanceradio.required'=>'* Confirmation of the artists ablity to complete the performance is required',
				'technicalradio.required'=>'* Confirmation of any technical issue during the performance is required',
				'riderradio.required'=>'* Confirmation of receiving the rider by the artists is required',
				'leaveradio.required'=>'* Confirmation of the artists leaving is required',
				'leavetime.required'=>'* Artist leaving time field is required',
				'againstartist.required'=>'* The name of the artist is required',
				'description.required'=>'* Description of the issue is required',
				'description.max'=>'* Description should be of maximum 500 characters',
			]
		);
                 
		if($validator->fails())
		{
			return $validator;
		}
			
		return true;
    }
	
	public function againstgroupfrmsubfunc(Request $request)
	{
		$flag_id = 0; $error_message=''; $responseAr=array(); $error_msgAr=array(); $myerror_message=array();$my_message=array();
		
		$sess_id = $request->session()->get('front_id_sess');
		
		if(isset($sess_id) && $sess_id!=0)
		{
			$arriveradio =$request->input('grouparriveradio');
			$arrivetime =$request->input('grouparrivaltime');
			$specificationradio =$request->input('groupspecificationradio');
			$performanceradio =$request->input('groupperformanceradio');
			$technicalradio =$request->input('grouptechnicalradio');
			$riderradio =$request->input('groupriderradio');
			$leaveradio =$request->input('groupleaveradio');
			$lefttime =$request->input('groupleavetime');
			$againstgroup =$request->input('againstgroup');
			$description=$request->input('groupdescription');
			
			$arrivaltime=date("H:i:s",strtotime($arrivetime));
			$leavetime=date("H:i:s",strtotime($lefttime));
			
			$openingDate = date('Y-m-d H:i:s');
			
			$gigmasterid='';
			$artistmail='';
			if($againstgroup!='' && $againstgroup!=0)
			{
				$split_array=explode("-",$againstgroup);
				$gigmasterid=$split_array[0];
				$artistmail=$split_array[1];
			}
			
			$group_query = DB::select(
	"SELECT gm.giguniqueid AS uniquegigid, gm.artist_id AS groupid, gm.event_city AS gigtown, gm.event_start_date_time AS gigstartdate, grp.nickname AS groupname, grp.creater_id AS groupcraetorid, um.nickname AS groupcreatorname
	FROM gig_master AS gm
	LEFT JOIN group_master AS grp ON grp.id=gm.artist_id
	LEFT JOIN user_master AS um ON um.id=grp.creater_id
	WHERE gm.id='".$gigmasterid."'"
			);
			if(count($group_query)>0)
			{
				$gigmasteruniqueid=$group_query[0]->uniquegigid;
				$artistname=$group_query[0]->groupname;
				$gigtown=$group_query[0]->gigtown;
				$gigstart=$group_query[0]->gigstartdate;
				$gigstartdate=date("d/m/Y h:i A",strtotime($gigstart));
				$grpcname=$group_query[0]->groupcreatorname;
			}
			else{
				$gigmasteruniqueid='';
				$artistname='';
				$gigtown='';
				$gigstartdate='';
				$grpcname='';
			}
			$gigname=$artistname."-".$gigmasteruniqueid." (unique gig ID)";
			
			$insertdataarr=array();
			
			$chkvalid=$this->checkagainstgroupform($request,$sess_id);
			if($chkvalid===true)
			{
				$insertdataarr['dispute_opener_id']=$sess_id;
				$insertdataarr['gig_id']=$gigmasterid;
				$insertdataarr['gig_unique_id']=$gigmasteruniqueid;
				$insertdataarr['gig_name']=$gigname;
				$insertdataarr['dispute_opening_date']=$openingDate;
				$insertdataarr['dispute_type']='2';
				$insertdataarr['issue_description']=$description;
				$insertdataarr['arrival']=$arriveradio;
				$insertdataarr['arrival_time']=$arrivaltime;
				$insertdataarr['required_specifications_availability']=$specificationradio;
				$insertdataarr['able_to_complete']=$performanceradio;
				$insertdataarr['technical_issue']=$technicalradio;
				$insertdataarr['receive_rider']=$riderradio;
				$insertdataarr['leave_early']=$leaveradio;
				$insertdataarr['leaving_time']=$leavetime;
				$insertdataarr['venue_presentation']='';
				$insertdataarr['getting_gig']='';
				$insertdataarr['commencing_gig']='';
				
				$isInserted = DB::table('resolve_dispute')->insert($insertdataarr);
				
				$isUpdated1 = DB::table('gig_master')
								->where('id', $gigmasterid)
								->update(['dispute_flag' => '1']);
			
				$flag_id = 1;
				
				//****** sending mail to the artist
				
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
				
				$booker_query = DB::select(
					"SELECT usm.nickname AS bookername
					FROM user_master AS usm
					WHERE usm.id='".$sess_id."'"
				);
				if(count($booker_query)>0)
				{
					$frombooker=$booker_query[0]->bookername;
				}
				else{
					$frombooker='';
				}
				
				//*********get user details ends here
				
				//$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
				$logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
				
				$self='your '.$artistname.' group';
				
				//*********Helper Function Starts here
				
				$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKER}','{SELF}','{STARTDATE}','{TOWN}','{SITENAME}','{YEAR}');
				$replaceto =array($logoIMG,$bsurl,$grpcname,$frombooker,$self,$gigstartdate,$gigtown,$sitename,$copyright_year);
				
				mailsnd($Temid=26,$replacefrom,$replaceto,$artistmail);
				
				//*********Helper Function Ends here
				
			}
			else{
				$flag_id = 0;
				$error_message = $chkvalid->messages();
			}
			
			if(!empty($error_message))
			{
				$error_message=json_decode(json_encode($error_message));
			  
				foreach($error_message as $kk => $error_message_ar)
				{
					$error_msgAr[$kk]=implode("<br>",$error_message_ar);    
				}
			  
			}
	
			$responseAr['flag_id']=$flag_id;
			$responseAr['error_message']=$error_msgAr;
		}
		else{
			$error_msgAr[0]="You must be logged in to resolve a dispute";
			$responseAr['flag_id']=3;
			$responseAr['error_message']=$error_msgAr;
		}
		
        echo json_encode($responseAr);
	}
	
	public function checkagainstgroupform($request,$sess_id=0)
    {
        $validator = Validator::make($request->all(),
			[
				'grouparriveradio' => "required",
				'grouparrivaltime'=> "required",
				'groupspecificationradio'=> "required",
				'groupperformanceradio'=> "required",
				'grouptechnicalradio'=> "required",
				'groupriderradio'=> "required",
				'groupleaveradio'=> "required",
				'groupleavetime'=> "required",
				'againstgroup'=> "required",
				'groupdescription'=> "required|max:500",
			],
			[
				'grouparriveradio.required'=>'* Confirmation of the groups arrival is required',
				'grouparrivaltime.required'=>'* Arrival time field is required',
				'groupspecificationradio.required'=>'* Confirmation of the availability of the groups required specifications is required',
				'groupperformanceradio.required'=>'* Confirmation of the groups ablity to complete the performance is required',
				'grouptechnicalradio.required'=>'* Confirmation of any technical issue during the performance is required',
				'groupriderradio.required'=>'* Confirmation of receiving the rider by the group is required',
				'groupleaveradio.required'=>'* Confirmation of the groups leaving is required',
				'groupleavetime.required'=>'* Group leaving time field is required',
				'againstgroup.required'=>'* The name of the group is required',
				'groupdescription.required'=>'* Description of the issue is required',
				'groupdescription.max'=>'* Description should be of maximum 500 characters',
			]
		);
                 
		if($validator->fails())
		{
			return $validator;
		}
			
		return true;
    }
	
	public function againstvenuefrmsubfunc(Request $request)
	{
		$flag_id = 0; $error_message=''; $responseAr=array(); $error_msgAr=array(); $myerror_message=array();$my_message=array();
		
		$sess_id = $request->session()->get('front_id_sess');
		
		if(isset($sess_id) && $sess_id!=0)
		{
			$arriveradio =$request->input('venuearriveradio');
			$arrivetime =$request->input('venuearrivaltime');
			$presentationradio =$request->input('venuepresentationradio');
			$specificationradio =$request->input('venuespecificationradio');
			$technicalradio =$request->input('venuetechnicalradio');
			$leaveradio =$request->input('venueleaveradio');
			$lefttime =$request->input('venueleavetime');
			$againstgroup =$request->input('againstvenue');
			$description=$request->input('venuedescription');
			
			$arrivaltime=date("H:i:s",strtotime($arrivetime));
			$leavetime=date("H:i:s",strtotime($lefttime));
			
			$openingDate = date('Y-m-d H:i:s');
			
			$gigmasterid='';
			$artistmail='';
			if($againstgroup!='' && $againstgroup!=0)
			{
				$split_array=explode("-",$againstgroup);
				$gigmasterid=$split_array[0];
				$artistmail=$split_array[1];
			}
			
			$venue_query = DB::select(
	"SELECT gm.giguniqueid AS uniquegigid, gm.artist_id AS venueid, gm.event_city AS gigtown, gm.event_start_date_time AS gigstartdate, ven.nickname AS venuename, ven.creater_id AS venuecraetorid, um.nickname AS venuecreatorname
	FROM gig_master AS gm
	LEFT JOIN venue_master AS ven ON ven.id=gm.artist_id
	LEFT JOIN user_master AS um ON um.id=ven.creater_id
	WHERE gm.id='".$gigmasterid."'"
			);
			if(count($venue_query)>0)
			{
				$gigmasteruniqueid=$venue_query[0]->uniquegigid;
				$artistname=$venue_query[0]->venuename;
				$gigtown=$venue_query[0]->gigtown;
				$gigstart=$venue_query[0]->gigstartdate;
				$gigstartdate=date("d/m/Y h:i A",strtotime($gigstart));
				$vencname=$venue_query[0]->venuecreatorname;
			}
			else{
				$gigmasteruniqueid='';
				$artistname='';
				$gigtown='';
				$gigstartdate='';
				$vencname='';
			}
			$gigname=$artistname."-".$gigmasteruniqueid." (unique gig ID)";
			
			$insertdataarr=array();
			
			$chkvalid=$this->checkagainstvenueform($request,$sess_id);
			if($chkvalid===true)
			{
				$insertdataarr['dispute_opener_id']=$sess_id;
				$insertdataarr['gig_id']=$gigmasterid;
				$insertdataarr['gig_unique_id']=$gigmasteruniqueid;
				$insertdataarr['gig_name']=$gigname;
				$insertdataarr['dispute_opening_date']=$openingDate;
				$insertdataarr['dispute_type']='3';
				$insertdataarr['issue_description']=$description;
				$insertdataarr['arrival']=$arriveradio;
				$insertdataarr['arrival_time']=$arrivaltime;
				$insertdataarr['required_specifications_availability']=$specificationradio;
				$insertdataarr['able_to_complete']='';
				$insertdataarr['technical_issue']=$technicalradio;
				$insertdataarr['receive_rider']='';
				$insertdataarr['leave_early']=$leaveradio;
				$insertdataarr['leaving_time']=$leavetime;
				$insertdataarr['venue_presentation']=$presentationradio;
				$insertdataarr['getting_gig']='';
				$insertdataarr['commencing_gig']='';
				
				$isInserted = DB::table('resolve_dispute')->insert($insertdataarr);
				
				$isUpdated1 = DB::table('gig_master')
								->where('id', $gigmasterid)
								->update(['dispute_flag' => '1']);
			
				$flag_id = 1;
				
				//****** sending mail to the artist
				
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
				
				$booker_query = DB::select(
					"SELECT usm.nickname AS bookername
					FROM user_master AS usm
					WHERE usm.id='".$sess_id."'"
				);
				if(count($booker_query)>0)
				{
					$frombooker=$booker_query[0]->bookername;
				}
				else{
					$frombooker='';
				}
				
				//*********get user details ends here
				
				//$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
				$logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
				
				$self='your '.$artistname.' venue';
				
				//*********Helper Function Starts here
				
				$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKER}','{SELF}','{STARTDATE}','{TOWN}','{SITENAME}','{YEAR}');
				$replaceto =array($logoIMG,$bsurl,$vencname,$frombooker,$self,$gigstartdate,$gigtown,$sitename,$copyright_year);
				
				mailsnd($Temid=26,$replacefrom,$replaceto,$artistmail);
				
				//*********Helper Function Ends here
				
			}
			else{
				$flag_id = 0;
				$error_message = $chkvalid->messages();
			}
			
			if(!empty($error_message))
			{
				$error_message=json_decode(json_encode($error_message));
			  
				foreach($error_message as $kk => $error_message_ar)
				{
					$error_msgAr[$kk]=implode("<br>",$error_message_ar);    
				}
			  
			}
	
			$responseAr['flag_id']=$flag_id;
			$responseAr['error_message']=$error_msgAr;
		}
		else{
			$error_msgAr[0]="You must be logged in to resolve a dispute";
			$responseAr['flag_id']=3;
			$responseAr['error_message']=$error_msgAr;
		}
		
        echo json_encode($responseAr);
	}
	
	public function checkagainstvenueform($request,$sess_id=0)
    {
        $validator = Validator::make($request->all(),
			[
				'venuearriveradio' => "required",
				'venuearrivaltime'=> "required",
				'venuepresentationradio'=> "required",
				'venuespecificationradio'=> "required",
				'venuetechnicalradio'=> "required",
				'venueleaveradio'=> "required",
				'venueleavetime'=> "required",
				'againstvenue'=> "required",
				'venuedescription'=> "required|max:500",
			],
			[
				'venuearriveradio.required'=>'* Confirmation of the venues availability is required',
				'venuearrivaltime.required'=>'* Available time field is required',
				'venuepresentationradio.required'=>'* Confirmation of the venues real presentation required specifications is required',
				'venuespecificationradio.required'=>'* Confirmation of the availability of the venues amenities is required',
				'venuetechnicalradio.required'=>'* Confirmation of any technical issue during the performance is required',
				'venueleaveradio.required'=>'* Confirmation of the venues leaving is required',
				'venueleavetime.required'=>'* Venue leaving time field is required',
				'againstvenue.required'=>'* The name of the venue is required',
				'venuedescription.required'=>'* Description of the issue is required',
				'venuedescription.max'=>'* Description should be of maximum 500 characters',
			]
		);
                 
		if($validator->fails())
		{
			return $validator;
		}
			
		return true;
    }
    
    public function againstbookerfrmsubfunc(Request $request)
	{
		$flag_id = 0; $error_message=''; $responseAr=array(); $error_msgAr=array(); $myerror_message=array();$my_message=array();
		
		$sess_id = $request->session()->get('front_id_sess');
		
		if(isset($sess_id) && $sess_id!=0)
		{
			$getgig =$request->input('getgig');
			$arrivetime =$request->input('bookerarrivaltime');
			$commencegig=$request->input('commencegig');
			$technicalradio =$request->input('bookertechnicalradio');
			$specificationradio =$request->input('bookerspecificationradio');
			$rideradio =$request->input('bookerriderradio');
			$leaveradio =$request->input('bookerleaveradio');
			$againstbooker =$request->input('againstbooker');
			$description=$request->input('bookerdescription');
			
			$arrivaltime=date("H:i:s",strtotime($arrivetime));
			
			$openingDate = date('Y-m-d H:i:s');
			
			$gigmasterid='';
			$bookermail='';
			if($againstbooker!='' && $againstbooker!=0)
			{
				$split_array=explode("-",$againstbooker);
				$gigmasterid=$split_array[0];
				$bookermail=$split_array[1];
			}
			
			$booker_query = DB::select(	
	"SELECT gm.giguniqueid AS uniquegigid, gm.type_flag AS typo, gm.artist_id AS bookedartist, gm.booker_id AS bookerid, gm.event_city AS gigtown, gm.event_start_date_time AS gigstartdate, um.nickname AS bookername
	FROM gig_master AS gm
	LEFT JOIN user_master as um ON um.id=gm.booker_id
	WHERE gm.id='".$gigmasterid."'"
			);
			if(count($booker_query)>0)
			{
				$gigmasteruniqueid=$booker_query[0]->uniquegigid;
				$bookername=$booker_query[0]->bookername;
				$gigtown=$booker_query[0]->gigtown;
				$gigstart=$booker_query[0]->gigstartdate;
				$gigstartdate=date("d/m/Y h:i A",strtotime($gigstart));
				$typo=$booker_query[0]->typo;
				$bookedartist=$booker_query[0]->bookedartist;
			}
			else{
				$gigmasteruniqueid='';
				$bookername='';
				$gigtown='';
				$gigstartdate='';
				$typo='';
				$bookedartist='';
			}
			$gigname=$bookername."-".$gigmasteruniqueid." (unique gig ID)";
			
			$insertdataarr=array();
			
			$chkvalid=$this->checkagainstbookerform($request,$sess_id);
			if($chkvalid===true)
			{
				$insertdataarr['dispute_opener_id']=$sess_id;
				$insertdataarr['gig_id']=$gigmasterid;
				$insertdataarr['gig_unique_id']=$gigmasteruniqueid;
				$insertdataarr['gig_name']=$gigname;
				$insertdataarr['dispute_opening_date']=$openingDate;
				$insertdataarr['dispute_type']='4';
				$insertdataarr['issue_description']=$description;
				$insertdataarr['arrival']='';
				$insertdataarr['arrival_time']=$arrivaltime;
				$insertdataarr['required_specifications_availability']=$specificationradio;
				$insertdataarr['able_to_complete']='';
				$insertdataarr['technical_issue']=$technicalradio;
				$insertdataarr['receive_rider']=$rideradio;
				$insertdataarr['leave_early']=$leaveradio;
				$insertdataarr['leaving_time']='';
				$insertdataarr['venue_presentation']='';
				$insertdataarr['getting_gig']=$getgig;
				$insertdataarr['commencing_gig']=$commencegig;
				
				$isInserted = DB::table('resolve_dispute')->insert($insertdataarr);
				
				$isUpdated1 = DB::table('gig_master')
								->where('id', $gigmasterid)
								->update(['dispute_flag' => '1']);
			
				$flag_id = 1;
				
				//****** sending mail to the artist
				
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
				
				$artist_query = DB::select(
					"SELECT usm.nickname AS artistname,usm.gender AS artistgender
					FROM user_master AS usm
					WHERE usm.id='".$sess_id."'"
				);
				if(count($artist_query)>0)
				{
					$fromartist=$artist_query[0]->artistname;
					$artistgender=$artist_query[0]->artistgender;
				}
				else{
					$fromartist='';
					$artistgender='';
				}
				
				//*********get user details ends here
				
				//$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
				$logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
				
				if($typo=='1'){
					if($artistgender=='1' || $artistgender='3')
					{
						$self='him';
					}
					elseif($artistgender=='2')
					{
						$self='her';
					}
				}
				elseif($typo=='2'){
					$artistgroup = DB::select(
						"SELECT grps.nickname AS artistgroupname
						FROM group_master AS grps
						WHERE grps.id='".$bookedartist."'"
					);
					$artistgroupname=$artistgroup[0]->artistgroupname;
					if($artistgender=='1' || $artistgender='3')
					{
						$self='his '.$artistgroupname.' group';
					}
					elseif($artistgender=='2')
					{
						$self='her '.$artistgroupname.' group';
					}
				}
				else{
					$artistvenue = DB::select(
						"SELECT vens.nickname AS artistvenuename
						FROM venue_master AS vens
						WHERE vens.id='".$bookedartist."'"
					);
					$artistvenuename=$artistvenue[0]->artistvenuename;
					if($artistgender=='1' || $artistgender='3')
					{
						$self='his '.$artistvenuename.' venue';
					}
					elseif($artistgender=='2')
					{
						$self='her '.$artistvenuename.' venue';
					}
				}
				
				//*********Helper Function Starts here
				
				$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{ARTIST}','{SELF}','{STARTDATE}','{TOWN}','{SITENAME}','{YEAR}');
				$replaceto =array($logoIMG,$bsurl,$bookername,$fromartist,$self,$gigstartdate,$gigtown,$sitename,$copyright_year);
				
				mailsnd($Temid=29,$replacefrom,$replaceto,$bookermail);
				
				//*********Helper Function Ends here
				
			}
			else{
				$flag_id = 0;
				$error_message = $chkvalid->messages();
			}
			
			if(!empty($error_message))
			{
				$error_message=json_decode(json_encode($error_message));
			  
				foreach($error_message as $kk => $error_message_ar)
				{
					$error_msgAr[$kk]=implode("<br>",$error_message_ar);    
				}
			  
			}
	
			$responseAr['flag_id']=$flag_id;
			$responseAr['error_message']=$error_msgAr;
		}
		else{
			$error_msgAr[0]="You must be logged in to resolve a dispute";
			$responseAr['flag_id']=3;
			$responseAr['error_message']=$error_msgAr;
		}
		
        echo json_encode($responseAr);
	}
	
	public function checkagainstbookerform($request,$sess_id=0)
    {
        $validator = Validator::make($request->all(),
			[
				'getgig' => "required",
				'bookerarrivaltime'=> "required",
				'commencegig'=> "required",
				'bookertechnicalradio'=> "required",
				'bookerspecificationradio'=> "required",
				'bookerriderradio'=> "required",
				'bookerleaveradio'=> "required",
				'againstbooker'=> "required",
				'bookerdescription'=> "required|max:500",
			],
			[
				'getgig.required'=>'* Confirmation of getting your gig is required',
				'bookerarrivaltime.required'=>'* Arrival time field is required',
				'commencegig.required'=>'* Confirmation of commencing your gig is required',
				'bookertechnicalradio.required'=>'* Confirmation of any technical issue during the performance is required',
				'bookerspecificationradio.required'=>'* Confirmation of the availability of your required specifications is required',
				'bookerriderradio.required'=>'* Confirmation of receiving the rider by you is required',
				'bookerleaveradio.required'=>'* Confirmation of your leaving is required',
				'againstbooker.required'=>'* The name of the booker is required',
				'bookerdescription.required'=>'* Description of the issue is required',
				'bookerdescription.max'=>'* Description should be of maximum 500 characters',
			]
		);
                 
		if($validator->fails())
		{
			return $validator;
		}
			
		return true;
    }
	
	
	public function contactsupportsubfunc(Request $request)
	{
		$flag_id = 0; $error_message=''; $responseAr=array(); $error_msgAr=array(); $myerror_message=array(); $my_message=array(); $insertdataarr=array();
		
		$sess_id = $request->session()->get('front_id_sess');
		
		//if(isset($sess_id) && $sess_id!=0)
		//{
			$reqresdata =$request->input('reqres');
			if(isset($reqresdata) && $reqresdata!=''){
				$reqres=$reqresdata;
			}
			else{
				$reqres='';
			}
			
			$mecopydata =$request->input('mecopy');
			if(isset($mecopydata) && $mecopydata!=''){
				$mecopy=$mecopydata;
			}
			else{
				$mecopy='';
			}
			
			$conDescdata =$request->input('condesc');
			if(isset($conDescdata) && $conDescdata!=''){
				$conDesc=$conDescdata;
				$condesc=addslashes($conDesc);
			}
			else{
				$condesc='';
			}
			
			$conemaildata =$request->input('conemail');
			if(isset($conemaildata) && $conemaildata!=''){
				$conemail=$conemaildata;
			}
			else{
				$conemail='';
			}
			
			$conlnamedata =$request->input('conlname');
			if(isset($conlnamedata) && $conlnamedata!=''){
				$conlname=$conlnamedata;
			}
			else{
				$conlname='';
			}
			
			$confnamedata =$request->input('confname');
			if(isset($confnamedata) && $confnamedata!=''){
				$confname=$confnamedata;
			}
			else{
				$confname='';
			}
			
			$contactreasondata =$request->input('contactreason');
			if(isset($contactreasondata) && $contactreasondata!=''){
				$contactreason=$contactreasondata;
			}
			else{
				$contactreason='';
			}
			
			$cancelgigmasterid='';
			$cancelartistemail='';
			$gigselectdata =$request->input('gigselect');
			if(isset($gigselectdata) && $gigselectdata!=''){
				
				$split_cancelgig_array=explode("-",$gigselectdata);
				$cancelgigmasterid=$split_cancelgig_array[0];
				$cancelartistemail=$split_cancelgig_array[1];
				
				$gigselect=$cancelgigmasterid;
			}
			else{
				$gigselect='';
			}
			
			$conDate = date('Y-m-d H:i:s');
			
			if($contactreason==6)
			{
				$chkvalid=$this->checkcontactsupportformforcancel($request,$sess_id);
			}
			else{
				$chkvalid=$this->checkcontactsupportform($request,$sess_id);
			}
			
			if($chkvalid===true)
			{
				$insertdataarr['contact_reason_id']=$contactreason;
				$insertdataarr['contact_first_name']=$confname;
				$insertdataarr['contact_last_name']=$conlname;
				$insertdataarr['contact_email']=$conemail;
				$insertdataarr['contact_message']=$condesc;
				$insertdataarr['request_response']=$reqres;
				$insertdataarr['send_me_copy']=$mecopy;
				$insertdataarr['contact_date']=$conDate;
				$insertdataarr['contact_back_flag']=0;
				$insertdataarr['contact_back_date']='';
				
				if($contactreason==6)
				{
					$insertdataarr['cancel_gig_id']=$gigselect;
				}
				else{
					$insertdataarr['cancel_gig_id']='';
				}
				
				$isInserted = DB::table('contact_us')->insert($insertdataarr);
			
				$flag_id = 1;
				
				//****** sending mail to the artist
				
				$userssel = DB::table('settings')
                    ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image,emailfromname,contact_email'))
                    ->where('id', 1)
                    ->get();
				$sitename=$userssel[0]->site_name;
				$emailfrom=$userssel[0]->email_from;
				$emailfromname = $userssel[0]->emailfromname;
				$copyright_year=$userssel[0]->copyright_year;
				$Imgologo=$userssel[0]->email_template_logo_image;
				$contactemail=$userssel[0]->contact_email;
				
				$confromname=ucfirst($confname)." ".ucfirst($conlname);
				
				if(isset($reqres) && $reqres!='')
				{
					if($reqres==1)
					{
						$requestresponse='Yes';
					}
					else{
						$requestresponse='No';
					}
				}
				else{
					$requestresponse='No';
				}
				
				if(isset($mecopy) && $mecopy!='')
				{
					if($mecopy==1)
					{
						$sendcopy='Yes';
					}
					else{
						$sendcopy='No';
					}
				}
				else{
					$sendcopy='No';
				}
				
				if(isset($condesc) && $condesc!='')
				{
					$contactmessage=stripslashes($condesc);
				}
				else{
					$contactmessage='No message is available';
				}
				
				if(isset($contactreason) && ($contactreason!='' || $contactreason!=0))
				{
					$contcat = DB::table('contactus_category')
								->select(DB::raw('category_name'))
								->where('id', $contactreason)
								->where('status', 1)
								->get();
					$contcatname=$contcat[0]->category_name;
					
					$contactreasonmain=$contcatname;
				}
				else{
					$contactreasonmain='No reason is available';
				}
				
				$bsurl = url('/');
				
				//$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
				$logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
				
				//*********Helper Function Starts 
				
				$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USERREALNAME}','{CONTACTREASON}','{CONTACTMESSAGE}','{CONTACTTOEMAIL}','{REQUESTRESPONSE}','{SENDCOPY}','{SITENAME}','{YEAR}');
				$replaceto =array($logoIMG,$bsurl,$confromname,$contactreasonmain,$contactmessage,$conemail,$requestresponse,$sendcopy,$sitename,$copyright_year);
				
				//*** fetch data of email template starts
				   
				$user_master_db_sub = DB::table('email_templates as et');
				$user_master_db_sub=$user_master_db_sub->select(DB::raw('et.subject,et.message'));
				$user_master_db_sub=$user_master_db_sub->where('et.id', '35');
				$user_master_db_sub=$user_master_db_sub->first();
				  
				if(!empty($user_master_db_sub))
				{
					$bodysub = $user_master_db_sub->message; //email body

					$passarrsub['adminfrom']=$conemail;
					$passarrsub['emailsub']=$user_master_db_sub->subject;
					$passarrsub['emailto']=$contactemail;
					$passarrsub['sitename']=$sitename;
					$passarrsub['emailfromname']=$confromname;
					
					$datasub = array('replacefrom'=>$replacefrom,'replaceto'=>$replaceto,'email_body'=>$bodysub);
					
					$chkmailsub= Mail::send('emails.emailviewfolder.commonemailtenplate', $datasub, function ($message) use ($passarrsub)
					{
						$message->from($passarrsub['adminfrom'], $passarrsub['emailfromname']);
						$message->to($passarrsub['emailto'])->subject($passarrsub['emailsub']);
					});
				}
				
				//*********Helper Function Ends here
				
				if($mecopy!=0 && $mecopy==1)
				{
					$replacefromme =array('{LOGO_IMG}','{BASE_URL}','{USERREALNAME}','{CONTACTREASON}','{CONTACTMESSAGE}','{REQUESTRESPONSE}','{SENDCOPY}','{SITENAME}','{YEAR}');
					$replacetome =array($logoIMG,$bsurl,$confromname,$contactreasonmain,$contactmessage,$requestresponse,$sendcopy,$sitename,$copyright_year);
					
					mailsnd($Temid=36,$replacefromme,$replacetome,$conemail);
				}
				
				if($contactreason==6)
				{
					$user_master_db_sub1 = DB::table('user_master');
					$user_master_db_sub1=$user_master_db_sub1->select(DB::raw('nickname'));
					$user_master_db_sub1=$user_master_db_sub1->where('id', $sess_id);
					$user_master_db_sub1=$user_master_db_sub1->first();
					$fromname=$user_master_db_sub1->nickname;
					
					$user_master_db_sub2 = DB::table('user_master');
					$user_master_db_sub2=$user_master_db_sub2->select(DB::raw('nickname'));
					$user_master_db_sub2=$user_master_db_sub2->where('email', $cancelartistemail);
					$user_master_db_sub2=$user_master_db_sub2->first();
					$toname=$user_master_db_sub2->nickname;
					
					$gig_master_db_sub11 = DB::table('gig_master');
					$gig_master_db_sub11=$gig_master_db_sub11->select(DB::raw('event_city,type_flag,event_start_date_time'));
					$gig_master_db_sub11=$gig_master_db_sub11->where('id', $cancelgigmasterid);
					$gig_master_db_sub11=$gig_master_db_sub11->first();
					$cancel_event_city=$gig_master_db_sub11->event_city;
					$cancel_event_start_date_time=$gig_master_db_sub11->event_start_date_time;
					$cancelstart=date("d/m/Y H:i A",strtotime($cancel_event_start_date_time));
					
					$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{TOUSER}','{FROMUSER}','{GIGDATE}','{GIGTOWN}','{SITENAME}','{YEAR}');
					$replaceto =array($logoIMG,$bsurl,$toname,$fromname,$cancelstart,$cancel_event_city,$sitename,$copyright_year);
					
					mailsnd($Temid=46,$replacefrom,$replaceto,$cancelartistemail);
					
					
					$replacefromme =array('{LOGO_IMG}','{BASE_URL}','{FROMUSER}','{GIGDATE}','{GIGTOWN}','{SITENAME}','{YEAR}');
					$replacetome =array($logoIMG,$bsurl,$fromname,$cancelstart,$cancel_event_city,$sitename,$copyright_year);
					
					mailsnd($Temid=47,$replacefromme,$replacetome,$cancelartistemail);
				}
			}
			else{
				$flag_id = 0;
				$error_message = $chkvalid->messages();
			}
			
			if(!empty($error_message))
			{
				$error_message=json_decode(json_encode($error_message));
			  
				foreach($error_message as $kk => $error_message_ar)
				{
					$error_msgAr[$kk]=implode("<br>",$error_message_ar);    
				}
			  
			}
	
			$responseAr['flag_id']=$flag_id;
			$responseAr['error_message']=$error_msgAr;
		//}
		//else{
		//	$error_msgAr[0]="You must be logged in to resolve a dispute";
		//	$responseAr['flag_id']=3;
		//	$responseAr['error_message']=$error_msgAr;
		//}
		
        echo json_encode($responseAr);
	}
	
	public function checkcontactsupportform($request,$sess_id=0)
    {
        $validator = Validator::make($request->all(),
			[
				'contactreason' => "required",
				'confname'=> "required",
				'conemail'=> "required|email",
				'condesc'=> "required",
			],
			[
				'contactreason.required'=>'* Reason of contact is required',
				'confname.required'=>'* First name is required',
				'conemail.required'=>'* Email is required',
				'conemail.email'=>'* Email should be of valid format',
				'condesc.required'=>'* Message is required',
			]
		);
                 
		if($validator->fails())
		{
			return $validator;
		}
			
		return true;
    }
	
	
	public function checkcontactsupportformforcancel($request,$sess_id=0)
    {
        $validator = Validator::make($request->all(),
			[
				'contactreason' => "required",
				'gigselect' => "required",
				'confname'=> "required",
				'conemail'=> "required|email",
				'condesc'=> "required",
			],
			[
				'contactreason.required'=>'* Reason of contact is required',
				'gigselect.required'=>'* Event is required',
				'confname.required'=>'* First name is required',
				'conemail.required'=>'* Email is required',
				'conemail.email'=>'* Email should be of valid format',
				'condesc.required'=>'* Message is required',
			]
		);
                 
		if($validator->fails())
		{
			return $validator;
		}
			
		return true;
    }
	
	
	public function showdisputerecordsfunc(Request $request)
	{	
		$sess_id = $request->session()->get('front_id_sess');
		
		if(isset($sess_id) && $sess_id!=0)
		{
			$gigidbookedbookedbymequery = DB::select(	
				"SELECT gm.id AS gigmasterid, gm.giguniqueid AS uniquegigid
				FROM gig_master AS gm
				WHERE gm.booker_id='".$sess_id."'
				OR gm.artist_id='".$sess_id."'
				OR gm.artist_id IN ( SELECT grm.id FROM group_master AS grm WHERE grm.creater_id='".$sess_id."' AND grm.status='1' )
				OR gm.artist_id IN ( SELECT ven.id FROM venue_master AS ven WHERE ven.creater_id='".$sess_id."' AND ven.status='1' )"
			);
			
			$gigidarr=array();
			$contentheadingarr1=array();
			$contentheadingarr2=array();
			$datadispute=array();
			
			if(count($gigidbookedbookedbymequery)>0)
			{
				foreach($gigidbookedbookedbymequery as $gigidqry)
				{
					$gigarr=$gigidqry->gigmasterid;
					array_push($gigidarr,$gigarr);
				}

				$disputequery = DB::table('resolve_dispute')
					->select('id','gig_id','dispute_type','dispute_opener_id','dispute_opening_date')
                    ->whereIn('gig_id', $gigidarr)
					->orderBy('id', 'desc')
					->get();
				
				if(count($disputequery)>0)
				{
					foreach($disputequery as $disputeqry)
					{
						$openingdate=$disputeqry->dispute_opening_date;
						$disputedate=date("d/m/Y h:i A",strtotime($openingdate));
						$disputeopener=$disputeqry->dispute_opener_id;
						$disputegigids=$disputeqry->gig_id;
						$disputeids=$disputeqry->id;
						$disputetypo=$disputeqry->dispute_type;
							
						$disputeopenernameqry = DB::select(	
							"SELECT um.nickname AS disputeopenername
							FROM user_master AS um
							WHERE um.id='".$disputeopener."'"
						);
						
						$disputeopenername=$disputeopenernameqry[0]->disputeopenername;
						
						$disputedgigqry = DB::select(	
							"SELECT gigsr.genre AS genreid, gigsr.category AS skillid, gigm.artist_id AS artistid, gigm.booker_id AS bookerid, gigm.type_flag AS flagtypo, gigm.event_city AS eventtown, gigm.event_start_date_time AS eventtime, mstrusr.nickname AS gigBookerName
							FROM gig_master AS gigm
							JOIN gig_skill_rel AS gigsr ON gigsr.gigmaster_id = gigm.id
							JOIN user_master AS mstrusr ON mstrusr.id = gigm.booker_id
							WHERE gigm.id='".$disputegigids."'"
						);
						
						$disputedgigskillid=$disputedgigqry[0]->skillid;
						$disputedgiggenreid=$disputedgigqry[0]->genreid;
						$disputedgigtown=$disputedgigqry[0]->eventtown;
						$gigdate=$disputedgigqry[0]->eventtime;
						$disputedgigdate=date("d/m/Y h:i A",strtotime($gigdate));
						$disputedgigflag=$disputedgigqry[0]->flagtypo;
						$disputedgigartistid=$disputedgigqry[0]->artistid;
						$disputedgigbookerid=$disputedgigqry[0]->bookerid;
						$gigBookerName=$disputedgigqry[0]->gigBookerName;
						
						$disputebookernameqry = DB::select(	
							"SELECT um.nickname AS disputebookername
							FROM user_master AS um
							WHERE um.id='".$disputeopener."'"
						);
						
						if($disputetypo!='4')
						{
							$disputebookername=$disputebookernameqry[0]->disputebookername;
						}
						else{
							$disputebookername=$gigBookerName;
						}
						
						if($disputedgigskillid!=0 && $disputedgigskillid!='')
						{
							$disputedgigskillqry = DB::select(	
								"SELECT skm1.name AS disputedgigskillname
								FROM skill_master AS skm1
								WHERE skm1.id='".$disputedgigskillid."'"
							);
							
							$disputedgigskillname=$disputedgigskillqry[0]->disputedgigskillname;
						}
						else{
							$disputedgigskillname='';
						}
						
						if($disputedgiggenreid!=0 && $disputedgiggenreid!='')
						{
							$disputedgiggenreqry = DB::select(	
								"SELECT skm2.name AS disputedgiggenrename
								FROM skill_master AS skm2
								WHERE skm2.id='".$disputedgiggenreid."'"
							);
							
							$disputedgiggenrename=$disputedgiggenreqry[0]->disputedgiggenrename;
						}
						else{
							$disputedgiggenrename='';
						}
						
						if($disputedgigflag=='1'){
							
							if($disputeopener!=$sess_id){
								if($disputetypo!='4'){
									$gigtypeflag="by you";
								}
								else{
									$gigtypeflag=$disputeopenername;
								}
							}
							else{
								if($disputetypo!='4'){
									
									$disputegigartistnameqry = DB::select(	
										"SELECT usrm.nickname AS disputegigartistname
										FROM user_master AS usrm
										WHERE usrm.id='".$disputedgigartistid."'"
									);
									
									$disputegigartistname=$disputegigartistnameqry[0]->disputegigartistname;
									
									$gigtypeflag=$disputegigartistname." who performed in ";
								}
								else{
									$gigtypeflag="I";
								}
							}
						}
						elseif($disputedgigflag=='2'){
							
							$disputedgroupnameqry = DB::select(	
								"SELECT gpm.nickname AS disputedgroupname
								FROM group_master AS gpm
								WHERE gpm.id='".$disputedgigartistid."'"
							);
							
							$disputedgroupname=$disputedgroupnameqry[0]->disputedgroupname;
							
							if($disputeopener!=$sess_id){	
								if($disputetypo!='4'){
									$gigtypeflag="by your ".$disputedgroupname." group";
								}
								else{
									$gigtypeflag=$disputedgroupname." group of ".$disputeopenername;
								}
							}
							else{
								if($disputetypo!='4'){
									$gigtypeflag=$disputedgroupname." group who performed in ";
								}
								else{
									$gigtypeflag="my ".$disputedgroupname." group";
								}
							}
						}
						else{
							$disputedvenuenameqry = DB::select(	
								"SELECT vnm.nickname AS disputedvenuename
								FROM venue_master AS vnm
								WHERE vnm.id='".$disputedgigartistid."'"
							);
							
							$disputedvenuename=$disputedvenuenameqry[0]->disputedvenuename;
							
							if($disputeopener!=$sess_id){
								if($disputetypo!='4'){
									$gigtypeflag="in your ".$disputedvenuename." venue";
								}
								else{
									$gigtypeflag=$disputedvenuename." venue of ".$disputeopenername;
								}
							}
							else{
								if($disputetypo!='4'){
									$gigtypeflag=$disputedvenuename." venue which I booked in ";
								}
								else{
									$gigtypeflag="my ".$disputedvenuename." venue";
								}
							}
						}
						
						if($disputedgigskillname!='' && $disputedgiggenrename!='')
						{
							$baseskill=" based on ".$disputedgigskillname." skill - ".$disputedgiggenrename." genre";
						}
						elseif($disputedgigskillname=='' && $disputedgiggenrename=='')
						{
							$baseskill='';
						}
						elseif($disputedgigskillname!='' && $disputedgiggenrename=='')
						{
							$baseskill=" based on ".$disputedgigskillname." skill";
						}
						elseif($disputedgigskillname=='' && $disputedgiggenrename!='')
						{
							$baseskill=" based on ".$disputedgiggenrename." genre";
						}
							
						if($disputeopener!=$sess_id){
							
							if($disputetypo!='4'){
								$disputedgigcontent=$disputeopenername." has opened a dispute on ".$disputedate." for gig perfomed ".$gigtypeflag." in ".$disputedgigtown." on ".$disputedgigdate.$baseskill;
							}
							else{
								$disputedgigcontent=$gigtypeflag." was booked by me and performed in ".$disputedgigtown." on ".$disputedgigdate.$baseskill." has opened a dispute against me on ".$disputedate;
							}
						}	
						else{
							if($disputetypo!='4'){
								$disputedgigcontent="I have opened a dispute on ".$disputedate." against ".$gigtypeflag.$disputedgigtown." on ".$disputedgigdate.$baseskill;
							}
							else{
								
								$disputedgigcontent="I have opened a dispute on ".$disputedate." against ".$disputebookername." in whose event ".$gigtypeflag." performed on ".$disputedgigdate." in ".$disputedgigtown.$baseskill;
							}
						}
						
						$contentmain=array("contenttext"=>$disputedgigcontent,"disputedid"=>$disputeids);
						array_push($contentheadingarr1,$contentmain);
					}
					
					$datadispute["contentheading"]=$contentheadingarr1;
					return view('front.help.disputerecordview',$datadispute);
				}
				else{
					$request->session()->flash('front_errormsgdata_sess', 'No dispute is present');    
					return redirect('/');
				}
			}
			else{
				$request->session()->flash('front_errormsgdata_sess', 'No dispute is present');    
				return redirect('/');
			}
		}
		else{
			$request->session()->flash('front_errormsgdata_sess', 'You must be logged in to view disputes');    
            return redirect('/');
		}
	}
	
	
	public function disputerepliesloadmorefunc(Request $request)
	{
		$disputesettingsqry = DB::table('settings')
						->select('record_per_page')
						->where('id', '1')
						->get();
			
		$frontperpage=$disputesettingsqry[0]->record_per_page;
		
		$sess_id = $request->session()->get('front_id_sess');
		
		if(isset($sess_id) && $sess_id!='')
		{
			$disputeid =$request->input('disputemainid');
			 $next_limit = $request->input('limit');
			
				$datadispute=array();
				
				$disputeqry = DB::table('resolve_dispute')
							->select('id','gig_id','dispute_type','dispute_opener_id','dispute_opening_date')
							->where('id', $disputeid)
							->orderBy('id', 'desc')
							->get();
				
				$openingdate=$disputeqry[0]->dispute_opening_date;
				$disputedate=date("d/m/Y h:i A",strtotime($openingdate));
				$disputeopener=$disputeqry[0]->dispute_opener_id;
				$disputegigids=$disputeqry[0]->gig_id;
				$disputeids=$disputeqry[0]->id;
				$disputetypo=$disputeqry[0]->dispute_type;
									
				$disputeopenernameqry = DB::select(	
					"SELECT um.nickname AS disputeopenername, um.email AS disputeopenermail
					FROM user_master AS um
					WHERE um.id='".$disputeopener."'"
				);
								
				$disputeopenername=$disputeopenernameqry[0]->disputeopenername;
				$disputeopenermail=$disputeopenernameqry[0]->disputeopenermail;
								
				$disputedgigqry = DB::select(	
					"SELECT gigsr.genre AS genreid, gigsr.category AS skillid, gigm.artist_id AS artistid, gigm.booker_id AS bookerid, gigm.type_flag AS flagtypo, gigm.event_city AS eventtown, gigm.event_start_date_time AS eventtime, gigm.giguniqueid AS gigUniqueId, mstrusr.nickname AS gigBookerName, mstrusr.email AS gigBookerMail
					FROM gig_master AS gigm
					JOIN gig_skill_rel AS gigsr ON gigsr.gigmaster_id = gigm.id
					JOIN user_master AS mstrusr ON mstrusr.id = gigm.booker_id
					WHERE gigm.id='".$disputegigids."'"
				);
								
				$disputedgigskillid=$disputedgigqry[0]->skillid;
				$disputedgiggenreid=$disputedgigqry[0]->genreid;
				$disputedgigtown=$disputedgigqry[0]->eventtown;
				$gigdate=$disputedgigqry[0]->eventtime;
				$disputedgigdate=date("d/m/Y h:i A",strtotime($gigdate));
				$disputedgigflag=$disputedgigqry[0]->flagtypo;
				$disputedgigartistid=$disputedgigqry[0]->artistid;
				$disputedgigbookerid=$disputedgigqry[0]->bookerid;
				$gigBookerName=$disputedgigqry[0]->gigBookerName;
				
				$disputebookernameqry = DB::select(	
					"SELECT um.nickname AS disputebookername
					FROM user_master AS um
					WHERE um.id='".$disputeopener."'"
				);
				
				$disputedoerartist4=array();
				
				if($disputetypo!=4)
				{
					$disputebookername=$disputebookernameqry[0]->disputebookername;
				}
				else{
					$disputebookername=$gigBookerName;
					
					if($disputedgigflag==2){
						$disputegroupmnameqry = DB::select(	
							"SELECT groupm.nickname AS disputegroupmname
							FROM group_master AS groupm
							WHERE groupm.id='".$disputedgigartistid."'"
						);
						$dispgroupmname=$disputegroupmnameqry[0]->disputegroupmname;
						$dispgroupmid=$disputedgigartistid;
						$disputedoerartist4=array("disdoername4"=>$dispgroupmname,"disdoerid4"=>$dispgroupmid);
					}
					elseif($disputedgigflag==3)
					{
						$disputevenuemnameqry = DB::select(	
							"SELECT venuem.nickname AS disputevenuemname
							FROM venue_master AS venuem
							WHERE venuem.id='".$disputedgigartistid."'"
						);
						$dispvenuemname=$disputevenuemnameqry[0]->disputevenuemname;
						$dispvenuemid=$disputedgigartistid;
						$disputedoerartist4=array("disdoername4"=>$dispvenuemname,"disdoerid4"=>$dispvenuemid);
					}
				}
				
				if($disputedgigskillid!=0 && $disputedgigskillid!='')
				{
					$disputedgigskillqry = DB::select(	
						"SELECT skm1.name AS disputedgigskillname
						FROM skill_master AS skm1
						WHERE skm1.id='".$disputedgigskillid."'"
					);
					
					$disputedgigskillname=$disputedgigskillqry[0]->disputedgigskillname;
				}
				else{
					$disputedgigskillname='';
				}
				
				if($disputedgiggenreid!=0 && $disputedgiggenreid!='')
				{
					$disputedgiggenreqry = DB::select(	
						"SELECT skm2.name AS disputedgiggenrename
						FROM skill_master AS skm2
						WHERE skm2.id='".$disputedgiggenreid."'"
					);
					
					$disputedgiggenrename=$disputedgiggenreqry[0]->disputedgiggenrename;
				}
				else{
					$disputedgiggenrename='';
				}
								
				if($disputedgigflag=='1'){
					if($disputeopener!=$sess_id){
						if($disputetypo!='4'){
							$gigtypeflag="by you";
						}
						else{
							$gigtypeflag=$disputeopenername;
						}
					}
					else{
						if($disputetypo!='4'){
							$disputegigartistnameqry = DB::select(	
								"SELECT usrm.nickname AS disputegigartistname
								FROM user_master AS usrm
								WHERE usrm.id='".$disputedgigartistid."'"
							);
							
							$disputegigartistname=$disputegigartistnameqry[0]->disputegigartistname;
							
							$gigtypeflag=$disputegigartistname." who performed in ";
						}
						else{
							$gigtypeflag="I";
						}
					}
				}
				elseif($disputedgigflag=='2'){
					$disputedgroupnameqry = DB::select(	
						"SELECT gpm.nickname AS disputedgroupname
						FROM group_master AS gpm
						WHERE gpm.id='".$disputedgigartistid."'"
					);
					
					$disputedgroupname=$disputedgroupnameqry[0]->disputedgroupname;
					
					if($disputeopener!=$sess_id){	
						if($disputetypo!='4'){
							$gigtypeflag="by your ".$disputedgroupname." group";
						}
						else{
							$gigtypeflag=$disputedgroupname." group of ".$disputeopenername;
						}
					}
					else{
						if($disputetypo!='4'){
							$gigtypeflag=$disputedgroupname." group who performed in ";
						}
						else{
							$gigtypeflag="my ".$disputedgroupname." group";
						}
					}
				}
				else{
					$disputedvenuenameqry = DB::select(	
						"SELECT vnm.nickname AS disputedvenuename
						FROM venue_master AS vnm
						WHERE vnm.id='".$disputedgigartistid."'"
					);
					
					$disputedvenuename=$disputedvenuenameqry[0]->disputedvenuename;
					
					if($disputeopener!=$sess_id){
						if($disputetypo!='4'){
							$gigtypeflag="in your ".$disputedvenuename." venue";
						}
						else{
							$gigtypeflag=$disputedvenuename." venue of ".$disputeopenername;
						}
					}
					else{
						if($disputetypo!='4'){
							$gigtypeflag=$disputedvenuename." venue which I booked in ";
						}
						else{
							$gigtypeflag="my ".$disputedvenuename." venue";
						}
					}
				}
								
				if($disputedgigskillname!='' && $disputedgiggenrename!='')
				{
					$baseskill=" based on ".$disputedgigskillname." skill - ".$disputedgiggenrename." genre";
				}
				elseif($disputedgigskillname=='' && $disputedgiggenrename=='')
				{
					$baseskill='';
				}
				elseif($disputedgigskillname!='' && $disputedgiggenrename=='')
				{
					$baseskill=" based on ".$disputedgigskillname." skill";
				}
				elseif($disputedgigskillname=='' && $disputedgiggenrename!='')
				{
					$baseskill=" based on ".$disputedgiggenrename." genre";
				}
									
				if($disputeopener!=$sess_id){
					if($disputetypo!='4'){
						$disputedgigcontent=$disputeopenername." has opened a dispute on ".$disputedate." for gig perfomed ".$gigtypeflag." in ".$disputedgigtown." on ".$disputedgigdate.$baseskill;
					}
					else{
						$disputedgigcontent=$gigtypeflag." was booked by me and performed in ".$disputedgigtown." on ".$disputedgigdate.$baseskill." has opened a dispute against me on ".$disputedate;
					}
				}	
				else{
					if($disputetypo!='4'){
						$disputedgigcontent="I have opened a dispute on ".$disputedate." against ".$gigtypeflag.$disputedgigtown." on ".$disputedgigdate.$baseskill;
					}
					else{
						$disputedgigcontent="I have opened a dispute on ".$disputedate." against ".$disputebookername." in whose event ".$gigtypeflag." performed on ".$disputedgigdate." in ".$disputedgigtown.$baseskill;
					}
				}
				
				$contentmain=$disputedgigcontent;
				
				$disputereplyqry = DB::select(	
											"SELECT dr.id AS replyid, dr.dispute_type AS replydistype, dr.replied_by AS replyby, dr.replied_to_1 AS replyto1, dr.replied_to_2 AS replyto2, dr.reply_content AS replycon, dr.reply_date AS replydt
											FROM resolve_dispute_replies AS dr
											WHERE dr.resolve_dispute_id='".$disputeid."'
											ORDER BY dr.id DESC
											LIMIT ".$next_limit.",".$frontperpage
										);
				
				$disputeagainstdetails=array();
				
				if($disputetypo!=4)
				{
					if($disputedgigflag==1)
					{
						$disputeagainstartistqry = DB::select(	
							"SELECT usrmst.nickname AS disputeartistnickname, usrmst.email AS disputeartistmail 
							FROM user_master AS usrmst
							WHERE usrmst.id='".$disputedgigartistid."'"
						);
						$disputeagainstname=$disputeagainstartistqry[0]->disputeartistnickname;
						$disputeagainstmail=$disputeagainstartistqry[0]->disputeartistmail;
						
						$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>'',"againstcreatorname"=>'',"againstcreatormail"=>$disputeagainstmail);
					}
					elseif($disputedgigflag==2){
						$disputeagainstgroupqry = DB::select(	
							"SELECT grms.nickname AS disputegroupnickname, grms.creater_id AS againstgrpcrtid, grus.nickname AS againstgrpcrtname, grus.email AS againstgrpcrtmail
							FROM group_master AS grms
							JOIN user_master AS grus ON grms.creater_id=grus.id
							WHERE grms.id='".$disputedgigartistid."'"
						);
						$disputeagainstname=$disputeagainstgroupqry[0]->disputegroupnickname;
						$disputeagainstcrtid=$disputeagainstgroupqry[0]->againstgrpcrtid;
						$disputeagainstcrtname=$disputeagainstgroupqry[0]->againstgrpcrtname;
						$disputeagainstcrtmail=$disputeagainstgroupqry[0]->againstgrpcrtmail;
						
						$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>$disputeagainstcrtid,"againstcreatorname"=>$disputeagainstcrtname,"againstcreatormail"=>$disputeagainstcrtmail);
					}
					elseif($disputedgigflag==3){
						$disputeagainstvenueqry = DB::select(	
							"SELECT vnms.nickname AS disputevenuenickname, vnms.creater_id AS againstvencrtid, vnus.nickname AS againstvencrtname, vnus.email AS againstvencrtmail
							FROM venue_master AS vnms
							JOIN user_master AS vnus ON vnms.creater_id=vnus.id
							WHERE vnms.id='".$disputedgigartistid."'"
						);
						$disputeagainstname=$disputeagainstvenueqry[0]->disputevenuenickname;
						$disputeagainstcrtid=$disputeagainstvenueqry[0]->againstvencrtid;
						$disputeagainstcrtname=$disputeagainstvenueqry[0]->againstvencrtname;
						$disputeagainstcrtmail=$disputeagainstvenueqry[0]->againstvencrtmail;
						
						$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>$disputeagainstcrtid,"againstcreatorname"=>$disputeagainstcrtname,"againstcreatormail"=>$disputeagainstcrtmail);
					}
				}
				else{
					$disputeagainstbookerqry = DB::select(	
						"SELECT usrmstr.nickname AS disputebookernickname, usrmstr.email AS disputebookermail
						FROM user_master AS usrmstr
						WHERE usrmstr.id='".$disputedgigbookerid."'"
					);
					$disputeagainstname=$disputeagainstbookerqry[0]->disputebookernickname;
					$disputeagainstmail=$disputeagainstbookerqry[0]->disputebookermail;
					
					$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>'',"againstcreatorname"=>'',"againstcreatormail"=>$disputeagainstmail);
				}
				
				$disputeopenerdetails=array("disputeopenerid"=>$disputeopener,"disputeopenername"=>$disputeopenername,"disputeopenermail"=>$disputeopenermail);
				
				$adminset = DB::table('settings')
						->select(DB::raw('contact_email,email_from'))
						->where('id', 1)
						->get();
				
				$datadispute["sessionloggedinid"]=$sess_id;
				$datadispute["contentmain"]=$contentmain;
				$datadispute["disputeid"]=$disputeid;
				$datadispute["disputetypo"]=$disputetypo;
				$datadispute["disputereplydata"]=$disputereplyqry;
				$datadispute["disputegigmainid"]=$disputegigids;
				$datadispute["disputegigdata"]=$disputedgigqry;
				$datadispute["disputeopenerdetails"]=$disputeopenerdetails;
				$datadispute["disputeagainstdetails"]=$disputeagainstdetails;
				$datadispute["disputedoerartist4"]=$disputedoerartist4;
				$datadispute["adminset"]=$adminset;
			
				//return view('front.help.disputereplyview',$datadispute);
			
			$view_obj = View::make('front.help.disputereplymoreview',$datadispute);
			$contents = $view_obj->render();  
			
			$respdataAr=array();
			
			$respdataAr['replyrec']=$contents;
			echo json_encode($respdataAr);
		}
		else{
			$request->session()->flash('front_errormsgdata_sess', 'You must be logged in to view dispute replies');    
            return redirect('/');
		}
	}
	
	
	public function showdisputerepliesfunc(Request $request)
	{
		$disputesettingsqry = DB::table('settings')
						->select('record_per_page')
						->where('id', '1')
						->get();
			
		$frontperpage=$disputesettingsqry[0]->record_per_page;
		
		$sess_id = $request->session()->get('front_id_sess');
		
		if(isset($sess_id) && $sess_id!='')
		{
			$disputeid = $request->segment(2);
			
			$datadispute=array();
			
			
			$disputeqry = DB::table('resolve_dispute')
						->select('id','gig_id','dispute_type','dispute_opener_id','dispute_opening_date')
						->where('id', $disputeid)
						->orderBy('id', 'desc')
						->get();
			
			$openingdate=$disputeqry[0]->dispute_opening_date;
			$disputedate=date("d/m/Y h:i A",strtotime($openingdate));
			$disputeopener=$disputeqry[0]->dispute_opener_id;
			$disputegigids=$disputeqry[0]->gig_id;
			$disputeids=$disputeqry[0]->id;
			$disputetypo=$disputeqry[0]->dispute_type;
								
			$disputeopenernameqry = DB::select(	
				"SELECT um.nickname AS disputeopenername, um.email AS disputeopenermail
				FROM user_master AS um
				WHERE um.id='".$disputeopener."'"
			);
							
			$disputeopenername=$disputeopenernameqry[0]->disputeopenername;
			$disputeopenermail=$disputeopenernameqry[0]->disputeopenermail;
							
			$disputedgigqry = DB::select(	
				"SELECT gigsr.genre AS genreid, gigsr.category AS skillid, gigm.artist_id AS artistid, gigm.booker_id AS bookerid, gigm.type_flag AS flagtypo, gigm.event_city AS eventtown, gigm.event_start_date_time AS eventtime, gigm.giguniqueid AS gigUniqueId, mstrusr.nickname AS gigBookerName, mstrusr.email AS gigBookerMail
				FROM gig_master AS gigm
				JOIN gig_skill_rel AS gigsr ON gigsr.gigmaster_id = gigm.id
				JOIN user_master AS mstrusr ON mstrusr.id = gigm.booker_id
				WHERE gigm.id='".$disputegigids."'"
			);
							
			$disputedgigskillid=$disputedgigqry[0]->skillid;
			$disputedgiggenreid=$disputedgigqry[0]->genreid;
			$disputedgigtown=$disputedgigqry[0]->eventtown;
			$gigdate=$disputedgigqry[0]->eventtime;
			$disputedgigdate=date("d/m/Y h:i A",strtotime($gigdate));
			$disputedgigflag=$disputedgigqry[0]->flagtypo;
			$disputedgigartistid=$disputedgigqry[0]->artistid;
			$disputedgigbookerid=$disputedgigqry[0]->bookerid;
			$gigBookerName=$disputedgigqry[0]->gigBookerName;
			
			$disputebookernameqry = DB::select(	
				"SELECT um.nickname AS disputebookername
				FROM user_master AS um
				WHERE um.id='".$disputeopener."'"
			);
			
			$disputedoerartist4=array();
			
			if($disputetypo!=4)
			{
				$disputebookername=$disputebookernameqry[0]->disputebookername;
			}
			else{
				$disputebookername=$gigBookerName;
				
				if($disputedgigflag==2){
					$disputegroupmnameqry = DB::select(	
						"SELECT groupm.nickname AS disputegroupmname
						FROM group_master AS groupm
						WHERE groupm.id='".$disputedgigartistid."'"
					);
					$dispgroupmname=$disputegroupmnameqry[0]->disputegroupmname;
					$dispgroupmid=$disputedgigartistid;
					$disputedoerartist4=array("disdoername4"=>$dispgroupmname,"disdoerid4"=>$dispgroupmid);
				}
				elseif($disputedgigflag==3)
				{
					$disputevenuemnameqry = DB::select(	
						"SELECT venuem.nickname AS disputevenuemname
						FROM venue_master AS venuem
						WHERE venuem.id='".$disputedgigartistid."'"
					);
					$dispvenuemname=$disputevenuemnameqry[0]->disputevenuemname;
					$dispvenuemid=$disputedgigartistid;
					$disputedoerartist4=array("disdoername4"=>$dispvenuemname,"disdoerid4"=>$dispvenuemid);
				}
			}
			
			if($disputedgigskillid!=0 && $disputedgigskillid!='')
			{
				$disputedgigskillqry = DB::select(	
					"SELECT skm1.name AS disputedgigskillname
					FROM skill_master AS skm1
					WHERE skm1.id='".$disputedgigskillid."'"
				);
				
				$disputedgigskillname=$disputedgigskillqry[0]->disputedgigskillname;
			}
			else{
				$disputedgigskillname='';
			}
			
			if($disputedgiggenreid!=0 && $disputedgiggenreid!='')
			{
				$disputedgiggenreqry = DB::select(	
					"SELECT skm2.name AS disputedgiggenrename
					FROM skill_master AS skm2
					WHERE skm2.id='".$disputedgiggenreid."'"
				);
				
				$disputedgiggenrename=$disputedgiggenreqry[0]->disputedgiggenrename;
			}
			else{
				$disputedgiggenrename='';
			}
							
			if($disputedgigflag=='1'){
				if($disputeopener!=$sess_id){
					if($disputetypo!='4'){
						$gigtypeflag="by you";
					}
					else{
						$gigtypeflag=$disputeopenername;
					}
				}
				else{
					if($disputetypo!='4'){
						$disputegigartistnameqry = DB::select(	
							"SELECT usrm.nickname AS disputegigartistname
							FROM user_master AS usrm
							WHERE usrm.id='".$disputedgigartistid."'"
						);
						
						$disputegigartistname=$disputegigartistnameqry[0]->disputegigartistname;
						
						$gigtypeflag=$disputegigartistname." who performed in ";
					}
					else{
						$gigtypeflag="I";
					}
				}
			}
			elseif($disputedgigflag=='2'){
				$disputedgroupnameqry = DB::select(	
					"SELECT gpm.nickname AS disputedgroupname
					FROM group_master AS gpm
					WHERE gpm.id='".$disputedgigartistid."'"
				);
				
				$disputedgroupname=$disputedgroupnameqry[0]->disputedgroupname;
				
				if($disputeopener!=$sess_id){	
					if($disputetypo!='4'){
						$gigtypeflag="by your ".$disputedgroupname." group";
					}
					else{
						$gigtypeflag=$disputedgroupname." group of ".$disputeopenername;
					}
				}
				else{
					if($disputetypo!='4'){
						$gigtypeflag=$disputedgroupname." group who performed in ";
					}
					else{
						$gigtypeflag="my ".$disputedgroupname." group";
					}
				}
			}
			else{
				$disputedvenuenameqry = DB::select(	
					"SELECT vnm.nickname AS disputedvenuename
					FROM venue_master AS vnm
					WHERE vnm.id='".$disputedgigartistid."'"
				);
				
				$disputedvenuename=$disputedvenuenameqry[0]->disputedvenuename;
				
				if($disputeopener!=$sess_id){
					if($disputetypo!='4'){
						$gigtypeflag="in your ".$disputedvenuename." venue";
					}
					else{
						$gigtypeflag=$disputedvenuename." venue of ".$disputeopenername;
					}
				}
				else{
					if($disputetypo!='4'){
						$gigtypeflag=$disputedvenuename." venue which I booked in ";
					}
					else{
						$gigtypeflag="my ".$disputedvenuename." venue";
					}
				}
			}
							
			if($disputedgigskillname!='' && $disputedgiggenrename!='')
			{
				$baseskill=" based on ".$disputedgigskillname." skill - ".$disputedgiggenrename." genre";
			}
			elseif($disputedgigskillname=='' && $disputedgiggenrename=='')
			{
				$baseskill='';
			}
			elseif($disputedgigskillname!='' && $disputedgiggenrename=='')
			{
				$baseskill=" based on ".$disputedgigskillname." skill";
			}
			elseif($disputedgigskillname=='' && $disputedgiggenrename!='')
			{
				$baseskill=" based on ".$disputedgiggenrename." genre";
			}
								
			if($disputeopener!=$sess_id){
				if($disputetypo!='4'){
					$disputedgigcontent=$disputeopenername." has opened a dispute on ".$disputedate." for gig perfomed ".$gigtypeflag." in ".$disputedgigtown." on ".$disputedgigdate.$baseskill;
				}
				else{
					$disputedgigcontent=$gigtypeflag." was booked by me and performed in ".$disputedgigtown." on ".$disputedgigdate.$baseskill." has opened a dispute against me on ".$disputedate;
				}
			}	
			else{
				if($disputetypo!='4'){
					$disputedgigcontent="I have opened a dispute on ".$disputedate." against ".$gigtypeflag.$disputedgigtown." on ".$disputedgigdate.$baseskill;
				}
				else{
					$disputedgigcontent="I have opened a dispute on ".$disputedate." against ".$disputebookername." in whose event ".$gigtypeflag." performed on ".$disputedgigdate." in ".$disputedgigtown.$baseskill;
				}
			}
			
			$contentmain=$disputedgigcontent;
			
			$disputereplyqry = DB::select(	
										"SELECT dr.id AS replyid, dr.dispute_type AS replydistype, dr.replied_by AS replyby, dr.replied_to_1 AS replyto1, dr.replied_to_2 AS replyto2, dr.reply_content AS replycon, dr.reply_date AS replydt
										FROM resolve_dispute_replies AS dr
										WHERE dr.resolve_dispute_id='".$disputeid."'
										ORDER BY dr.id DESC
										LIMIT 0,".$frontperpage
									);
			
			$alldisputereplyqry = DB::select(	
										"SELECT dr.id AS replyid, dr.dispute_type AS replydistype, dr.replied_by AS replyby, dr.replied_to_1 AS replyto1, dr.replied_to_2 AS replyto2, dr.reply_content AS replycon, dr.reply_date AS replydt
										FROM resolve_dispute_replies AS dr
										WHERE dr.resolve_dispute_id='".$disputeid."'
										ORDER BY dr.id DESC"
									);
			
			$disputereplyallcount=count($alldisputereplyqry);
			//echo $disputereplyallcount;die;
			
			$disputeagainstdetails=array();
			
			if($disputetypo!=4)
			{
				if($disputedgigflag==1)
				{
					$disputeagainstartistqry = DB::select(	
						"SELECT usrmst.nickname AS disputeartistnickname, usrmst.email AS disputeartistmail 
						FROM user_master AS usrmst
						WHERE usrmst.id='".$disputedgigartistid."'"
					);
					$disputeagainstname=$disputeagainstartistqry[0]->disputeartistnickname;
					$disputeagainstmail=$disputeagainstartistqry[0]->disputeartistmail;
					
					$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>'',"againstcreatorname"=>'',"againstcreatormail"=>$disputeagainstmail);
				}
				elseif($disputedgigflag==2){
					$disputeagainstgroupqry = DB::select(	
						"SELECT grms.nickname AS disputegroupnickname, grms.creater_id AS againstgrpcrtid, grus.nickname AS againstgrpcrtname, grus.email AS againstgrpcrtmail
						FROM group_master AS grms
						JOIN user_master AS grus ON grms.creater_id=grus.id
						WHERE grms.id='".$disputedgigartistid."'"
					);
					$disputeagainstname=$disputeagainstgroupqry[0]->disputegroupnickname;
					$disputeagainstcrtid=$disputeagainstgroupqry[0]->againstgrpcrtid;
					$disputeagainstcrtname=$disputeagainstgroupqry[0]->againstgrpcrtname;
					$disputeagainstcrtmail=$disputeagainstgroupqry[0]->againstgrpcrtmail;
					
					$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>$disputeagainstcrtid,"againstcreatorname"=>$disputeagainstcrtname,"againstcreatormail"=>$disputeagainstcrtmail);
				}
				elseif($disputedgigflag==3){
					$disputeagainstvenueqry = DB::select(	
						"SELECT vnms.nickname AS disputevenuenickname, vnms.creater_id AS againstvencrtid, vnus.nickname AS againstvencrtname, vnus.email AS againstvencrtmail
						FROM venue_master AS vnms
						JOIN user_master AS vnus ON vnms.creater_id=vnus.id
						WHERE vnms.id='".$disputedgigartistid."'"
					);
					$disputeagainstname=$disputeagainstvenueqry[0]->disputevenuenickname;
					$disputeagainstcrtid=$disputeagainstvenueqry[0]->againstvencrtid;
					$disputeagainstcrtname=$disputeagainstvenueqry[0]->againstvencrtname;
					$disputeagainstcrtmail=$disputeagainstvenueqry[0]->againstvencrtmail;
					
					$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>$disputeagainstcrtid,"againstcreatorname"=>$disputeagainstcrtname,"againstcreatormail"=>$disputeagainstcrtmail);
				}
			}
			else{
				$disputeagainstbookerqry = DB::select(	
					"SELECT usrmstr.nickname AS disputebookernickname, usrmstr.email AS disputebookermail
					FROM user_master AS usrmstr
					WHERE usrmstr.id='".$disputedgigbookerid."'"
				);
				$disputeagainstname=$disputeagainstbookerqry[0]->disputebookernickname;
				$disputeagainstmail=$disputeagainstbookerqry[0]->disputebookermail;
				
				$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>'',"againstcreatorname"=>'',"againstcreatormail"=>$disputeagainstmail);
			}
			
			$disputeopenerdetails=array("disputeopenerid"=>$disputeopener,"disputeopenername"=>$disputeopenername,"disputeopenermail"=>$disputeopenermail);
			
			$adminset = DB::table('settings')
                    ->select(DB::raw('contact_email,email_from'))
                    ->where('id', 1)
                    ->get();
			
			$datadispute["sessionloggedinid"]=$sess_id;
			$datadispute["contentmain"]=$contentmain;
			$datadispute["disputeid"]=$disputeid;
			$datadispute["disputetypo"]=$disputetypo;
			$datadispute["disputereplydata"]=$disputereplyqry;
			$datadispute["disputegigmainid"]=$disputegigids;
			$datadispute["disputegigdata"]=$disputedgigqry;
			$datadispute["disputeopenerdetails"]=$disputeopenerdetails;
			$datadispute["disputeagainstdetails"]=$disputeagainstdetails;
			$datadispute["disputedoerartist4"]=$disputedoerartist4;
			$datadispute["adminset"]=$adminset;
			$datadispute["disputereplyallcount"]=$disputereplyallcount;
			$datadispute["frontperpage"]=$frontperpage;
			
			
				return view('front.help.disputereplyview',$datadispute);
			
		}
		else{
			$request->session()->flash('front_errormsgdata_sess', 'You must be logged in to view dispute replies');    
            return redirect('/');
		}
	}
	
	
	public function frontdisputereplyfrmsubfunc(Request $request)
	{
		$flag_id = 0; $error_message=''; $responseAr=array(); $error_msgAr=array(); $myerror_message=array();$my_message=array();
		
		$disputesettingsqry = DB::table('settings')
						->select('record_per_page')
						->where('id', '1')
						->get();
			
		$frontperpage=$disputesettingsqry[0]->record_per_page;
		
		$sess_id = $request->session()->get('front_id_sess');
		
		if(isset($sess_id) && $sess_id!='')
		{
			$adminid = $request->input('adminid');
			$adminmail = $request->input('adminmail');
			$opponentid = $request->input('opponentid');
			$opponentmail = $request->input('opponentmail');
			$replydesc = $request->input('replydesc');
			$desc=addslashes(ucfirst($replydesc));
			$disputemainid = $request->input('disputemainid');
			$disputemaintype = $request->input('disputemaintype');
			$disputegigmstrid = $request->input('disputegigmstrid');
			$disputegigmstruniqueid = $request->input('disputegigmstruniqueid');
			$disputegigmstrtype = $request->input('disputegigmstrtype');
			$disputegigmstrbookerid = $request->input('disputegigmstrbookerid');
			$disputegigmstrartistid = $request->input('disputegigmstrartistid');
			$today=date('Y-m-d H:i:s');
			
			$insertdataarr=array();
			$chkvalid=$this->checkdisputereplyform($request,$sess_id);
			if($chkvalid===true)
			{
				$insertdataarr['resolve_dispute_id']=$disputemainid;
				$insertdataarr['gig_id']=$disputegigmstrid;
				$insertdataarr['gig_unique_id']=$disputegigmstruniqueid;
				$insertdataarr['dispute_type']=$disputemaintype;
				$insertdataarr['replied_by']=$sess_id;
				$insertdataarr['replied_to_1']=$adminid;
				$insertdataarr['replied_to_2']=$opponentid;
				$insertdataarr['reply_content']=$desc;
				$insertdataarr['reply_date']=$today;
				
				$isInserted = DB::table('resolve_dispute_replies')->insert($insertdataarr);
			
				$flag_id = 1;
				
				/* for rendering the view gathering data starts */
				
					$disputeid = $disputemainid;
			
					$datadispute=array();
					
					$disputeqry = DB::table('resolve_dispute')
								->select('id','gig_id','dispute_type','dispute_opener_id','dispute_opening_date')
								->where('id', $disputeid)
								->orderBy('id', 'desc')
								->get();
					
					$openingdate=$disputeqry[0]->dispute_opening_date;
					$disputedate=date("d/m/Y h:i A",strtotime($openingdate));
					$disputeopener=$disputeqry[0]->dispute_opener_id;
					$disputegigids=$disputeqry[0]->gig_id;
					$disputeids=$disputeqry[0]->id;
					$disputetypo=$disputeqry[0]->dispute_type;
										
					$disputeopenernameqry = DB::select(	
						"SELECT um.nickname AS disputeopenername, um.email AS disputeopenermail
						FROM user_master AS um
						WHERE um.id='".$disputeopener."'"
					);
									
					$disputeopenername=$disputeopenernameqry[0]->disputeopenername;
					$disputeopenermail=$disputeopenernameqry[0]->disputeopenermail;
									
					$disputedgigqry = DB::select(	
						"SELECT gigsr.genre AS genreid, gigsr.category AS skillid, gigm.artist_id AS artistid, gigm.booker_id AS bookerid, gigm.type_flag AS flagtypo, gigm.event_city AS eventtown, gigm.event_start_date_time AS eventtime, gigm.giguniqueid AS gigUniqueId, mstrusr.nickname AS gigBookerName, mstrusr.email AS gigBookerMail
						FROM gig_master AS gigm
						JOIN gig_skill_rel AS gigsr ON gigsr.gigmaster_id = gigm.id
						JOIN user_master AS mstrusr ON mstrusr.id = gigm.booker_id
						WHERE gigm.id='".$disputegigids."'"
					);
									
					$disputedgigskillid=$disputedgigqry[0]->skillid;
					$disputedgiggenreid=$disputedgigqry[0]->genreid;
					$disputedgigtown=$disputedgigqry[0]->eventtown;
					$gigdate=$disputedgigqry[0]->eventtime;
					$disputedgigdate=date("d/m/Y h:i A",strtotime($gigdate));
					$disputedgigflag=$disputedgigqry[0]->flagtypo;
					$disputedgigartistid=$disputedgigqry[0]->artistid;
					$disputedgigbookerid=$disputedgigqry[0]->bookerid;
					$gigBookerName=$disputedgigqry[0]->gigBookerName;
					
					$disputebookernameqry = DB::select(	
						"SELECT um.nickname AS disputebookername
						FROM user_master AS um
						WHERE um.id='".$disputeopener."'"
					);
					
					$disputedoerartist4=array();
					
					if($disputetypo!=4)
					{
						$disputebookername=$disputebookernameqry[0]->disputebookername;
					}
					else{
						$disputebookername=$gigBookerName;
						
						if($disputedgigflag==2){
							$disputegroupmnameqry = DB::select(	
								"SELECT groupm.nickname AS disputegroupmname
								FROM group_master AS groupm
								WHERE groupm.id='".$disputedgigartistid."'"
							);
							$dispgroupmname=$disputegroupmnameqry[0]->disputegroupmname;
							$dispgroupmid=$disputedgigartistid;
							$disputedoerartist4=array("disdoername4"=>$dispgroupmname,"disdoerid4"=>$dispgroupmid);
						}
						elseif($disputedgigflag==3)
						{
							$disputevenuemnameqry = DB::select(	
								"SELECT venuem.nickname AS disputevenuemname
								FROM venue_master AS venuem
								WHERE venuem.id='".$disputedgigartistid."'"
							);
							$dispvenuemname=$disputevenuemnameqry[0]->disputevenuemname;
							$dispvenuemid=$disputedgigartistid;
							$disputedoerartist4=array("disdoername4"=>$dispvenuemname,"disdoerid4"=>$dispvenuemid);
						}
					}
					
					if($disputedgigskillid!=0 && $disputedgigskillid!='')
					{
						$disputedgigskillqry = DB::select(	
							"SELECT skm1.name AS disputedgigskillname
							FROM skill_master AS skm1
							WHERE skm1.id='".$disputedgigskillid."'"
						);
						
						$disputedgigskillname=$disputedgigskillqry[0]->disputedgigskillname;
					}
					else{
						$disputedgigskillname='';
					}
					
					if($disputedgiggenreid!=0 && $disputedgiggenreid!='')
					{
						$disputedgiggenreqry = DB::select(	
							"SELECT skm2.name AS disputedgiggenrename
							FROM skill_master AS skm2
							WHERE skm2.id='".$disputedgiggenreid."'"
						);
						
						$disputedgiggenrename=$disputedgiggenreqry[0]->disputedgiggenrename;
					}
					else{
						$disputedgiggenrename='';
					}
									
					if($disputedgigflag=='1'){
						if($disputeopener!=$sess_id){
							if($disputetypo!='4'){
								$gigtypeflag="by you";
							}
							else{
								$gigtypeflag=$disputeopenername;
							}
						}
						else{
							if($disputetypo!='4'){
								$disputegigartistnameqry = DB::select(	
									"SELECT usrm.nickname AS disputegigartistname
									FROM user_master AS usrm
									WHERE usrm.id='".$disputedgigartistid."'"
								);
								
								$disputegigartistname=$disputegigartistnameqry[0]->disputegigartistname;
								
								$gigtypeflag=$disputegigartistname." who performed in ";
							}
							else{
								$gigtypeflag="I";
							}
						}
					}
					elseif($disputedgigflag=='2'){
						$disputedgroupnameqry = DB::select(	
							"SELECT gpm.nickname AS disputedgroupname
							FROM group_master AS gpm
							WHERE gpm.id='".$disputedgigartistid."'"
						);
						
						$disputedgroupname=$disputedgroupnameqry[0]->disputedgroupname;
						
						if($disputeopener!=$sess_id){	
							if($disputetypo!='4'){
								$gigtypeflag="by your ".$disputedgroupname." group";
							}
							else{
								$gigtypeflag=$disputedgroupname." group of ".$disputeopenername;
							}
						}
						else{
							if($disputetypo!='4'){
								$gigtypeflag=$disputedgroupname." group who performed in ";
							}
							else{
								$gigtypeflag="my ".$disputedgroupname." group";
							}
						}
					}
					else{
						$disputedvenuenameqry = DB::select(	
							"SELECT vnm.nickname AS disputedvenuename
							FROM venue_master AS vnm
							WHERE vnm.id='".$disputedgigartistid."'"
						);
						
						$disputedvenuename=$disputedvenuenameqry[0]->disputedvenuename;
						
						if($disputeopener!=$sess_id){
							if($disputetypo!='4'){
								$gigtypeflag="in your ".$disputedvenuename." venue";
							}
							else{
								$gigtypeflag=$disputedvenuename." venue of ".$disputeopenername;
							}
						}
						else{
							if($disputetypo!='4'){
								$gigtypeflag=$disputedvenuename." venue which I booked in ";
							}
							else{
								$gigtypeflag="my ".$disputedvenuename." venue";
							}
						}
					}
									
					if($disputedgigskillname!='' && $disputedgiggenrename!='')
					{
						$baseskill=" based on ".$disputedgigskillname." skill - ".$disputedgiggenrename." genre";
					}
					elseif($disputedgigskillname=='' && $disputedgiggenrename=='')
					{
						$baseskill='';
					}
					elseif($disputedgigskillname!='' && $disputedgiggenrename=='')
					{
						$baseskill=" based on ".$disputedgigskillname." skill";
					}
					elseif($disputedgigskillname=='' && $disputedgiggenrename!='')
					{
						$baseskill=" based on ".$disputedgiggenrename." genre";
					}
										
					if($disputeopener!=$sess_id){
						if($disputetypo!='4'){
							$disputedgigcontent=$disputeopenername." has opened a dispute on ".$disputedate." for gig perfomed ".$gigtypeflag." in ".$disputedgigtown." on ".$disputedgigdate.$baseskill;
						}
						else{
							$disputedgigcontent=$gigtypeflag." was booked by me and performed in ".$disputedgigtown." on ".$disputedgigdate.$baseskill." has opened a dispute against me on ".$disputedate;
						}
					}	
					else{
						if($disputetypo!='4'){
							$disputedgigcontent="I have opened a dispute on ".$disputedate." against ".$gigtypeflag.$disputedgigtown." on ".$disputedgigdate.$baseskill;
						}
						else{
							$disputedgigcontent="I have opened a dispute on ".$disputedate." against ".$disputebookername." in whose event ".$gigtypeflag." performed on ".$disputedgigdate." in ".$disputedgigtown.$baseskill;
						}
					}
					
					$contentmain=$disputedgigcontent;
					
					$disputereplyqry = DB::select(	
												"SELECT dr.id AS replyid, dr.dispute_type AS replydistype, dr.replied_by AS replyby, dr.replied_to_1 AS replyto1, dr.replied_to_2 AS replyto2, dr.reply_content AS replycon, dr.reply_date AS replydt
												FROM resolve_dispute_replies AS dr
												WHERE dr.resolve_dispute_id='".$disputeid."'
												ORDER BY dr.id DESC
												LIMIT 0,".$frontperpage
											);
					
					$alldisputereplyqry = DB::select(	
												"SELECT dr.id AS replyid, dr.dispute_type AS replydistype, dr.replied_by AS replyby, dr.replied_to_1 AS replyto1, dr.replied_to_2 AS replyto2, dr.reply_content AS replycon, dr.reply_date AS replydt
												FROM resolve_dispute_replies AS dr
												WHERE dr.resolve_dispute_id='".$disputeid."'
												ORDER BY dr.id DESC"
											);
					
					$disputereplyallcount=count($alldisputereplyqry);
					
					$disputeagainstdetails=array();
					
					if($disputetypo!=4)
					{
						if($disputedgigflag==1)
						{
							$disputeagainstartistqry = DB::select(	
								"SELECT usrmst.nickname AS disputeartistnickname, usrmst.email AS disputeartistmail 
								FROM user_master AS usrmst
								WHERE usrmst.id='".$disputedgigartistid."'"
							);
							$disputeagainstname=$disputeagainstartistqry[0]->disputeartistnickname;
							$disputeagainstmail=$disputeagainstartistqry[0]->disputeartistmail;
							
							$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>'',"againstcreatorname"=>'',"againstcreatormail"=>$disputeagainstmail);
						}
						elseif($disputedgigflag==2){
							$disputeagainstgroupqry = DB::select(	
								"SELECT grms.nickname AS disputegroupnickname, grms.creater_id AS againstgrpcrtid, grus.nickname AS againstgrpcrtname, grus.email AS againstgrpcrtmail
								FROM group_master AS grms
								JOIN user_master AS grus ON grms.creater_id=grus.id
								WHERE grms.id='".$disputedgigartistid."'"
							);
							$disputeagainstname=$disputeagainstgroupqry[0]->disputegroupnickname;
							$disputeagainstcrtid=$disputeagainstgroupqry[0]->againstgrpcrtid;
							$disputeagainstcrtname=$disputeagainstgroupqry[0]->againstgrpcrtname;
							$disputeagainstcrtmail=$disputeagainstgroupqry[0]->againstgrpcrtmail;
							
							$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>$disputeagainstcrtid,"againstcreatorname"=>$disputeagainstcrtname,"againstcreatormail"=>$disputeagainstcrtmail);
						}
						elseif($disputedgigflag==3){
							$disputeagainstvenueqry = DB::select(	
								"SELECT vnms.nickname AS disputevenuenickname, vnms.creater_id AS againstvencrtid, vnus.nickname AS againstvencrtname, vnus.email AS againstvencrtmail
								FROM venue_master AS vnms
								JOIN user_master AS vnus ON vnms.creater_id=vnus.id
								WHERE vnms.id='".$disputedgigartistid."'"
							);
							$disputeagainstname=$disputeagainstvenueqry[0]->disputevenuenickname;
							$disputeagainstcrtid=$disputeagainstvenueqry[0]->againstvencrtid;
							$disputeagainstcrtname=$disputeagainstvenueqry[0]->againstvencrtname;
							$disputeagainstcrtmail=$disputeagainstvenueqry[0]->againstvencrtmail;
							
							$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>$disputeagainstcrtid,"againstcreatorname"=>$disputeagainstcrtname,"againstcreatormail"=>$disputeagainstcrtmail);
						}
					}
					else{
						$disputeagainstbookerqry = DB::select(	
							"SELECT usrmstr.nickname AS disputebookernickname, usrmstr.email AS disputebookermail
							FROM user_master AS usrmstr
							WHERE usrmstr.id='".$disputedgigbookerid."'"
						);
						$disputeagainstname=$disputeagainstbookerqry[0]->disputebookernickname;
						$disputeagainstmail=$disputeagainstbookerqry[0]->disputebookermail;
						
						$disputeagainstdetails=array("againstmainid"=>$disputedgigartistid,"againstmainname"=>$disputeagainstname,"againstcreatorid"=>'',"againstcreatorname"=>'',"againstcreatormail"=>$disputeagainstmail);
					}
					
					$disputeopenerdetails=array("disputeopenerid"=>$disputeopener,"disputeopenername"=>$disputeopenername,"disputeopenermail"=>$disputeopenermail);
					
					$adminset = DB::table('settings')
							->select(DB::raw('contact_email,email_from'))
							->where('id', 1)
							->get();
					
					$datadispute["sessionloggedinid"]=$sess_id;
					$datadispute["contentmain"]=$contentmain;
					$datadispute["disputeid"]=$disputeid;
					$datadispute["disputetypo"]=$disputetypo;
					$datadispute["disputereplydata"]=$disputereplyqry;
					$datadispute["disputegigmainid"]=$disputegigids;
					$datadispute["disputegigdata"]=$disputedgigqry;
					$datadispute["disputeopenerdetails"]=$disputeopenerdetails;
					$datadispute["disputeagainstdetails"]=$disputeagainstdetails;
					$datadispute["disputedoerartist4"]=$disputedoerartist4;
					$datadispute["adminset"]=$adminset;
					$datadispute["disputereplyallcount"]=$disputereplyallcount;
				
				/* for rendering the view gathering data ends */
				
				$view_obj = View::make('front.help.disputereplynextview',$datadispute);
				$contents = $view_obj->render();
				
				
				$usersselmail = DB::table('settings')
                    ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image,emailfromname,contact_email'))
                    ->where('id', 1)
                    ->get();
				$sitename=$usersselmail[0]->site_name;
				$emailfrom=$usersselmail[0]->email_from;
				$emailfromname = $usersselmail[0]->emailfromname;
				$copyright_year=$usersselmail[0]->copyright_year;
				$Imgologo=$usersselmail[0]->email_template_logo_image;
				$contactemail=$usersselmail[0]->contact_email;
				
				$bsurl = url('/');
			
				//$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
				$logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
				
				if($sess_id==$disputegigmstrbookerid)
				{
					$behalf='Booker';
				}
				else{
					$behalf='Artist';
				}
				
				if($opponentid!='' && $opponentid!=0)
				{
					$usersselnickname = DB::table('user_master')
                    ->select(DB::raw('nickname'))
                    ->where('email', $opponentmail)
                    ->get();
					$nameuser=$usersselnickname[0]->nickname;
					
					$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BEHALF}','{UNIQUEIDGIG}','{REPLYCONTENTTEXT}','{SITENAME}','{YEAR}');
					$replaceto =array($logoIMG,$bsurl,$nameuser,$behalf,$disputegigmstruniqueid,$replydesc,$sitename,$copyright_year);
					
					mailsnd($Temid=39,$replacefrom,$replaceto,$opponentmail);
				}
				
				if($adminid!='' && $adminid!=0)
				{
					$nameuser='Admin';
					
					$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BEHALF}','{UNIQUEIDGIG}','{REPLYCONTENTTEXT}','{SITENAME}','{YEAR}');
					$replaceto =array($logoIMG,$bsurl,$nameuser,$behalf,$disputegigmstruniqueid,$replydesc,$sitename,$copyright_year);
					
					mailsnd($Temid=39,$replacefrom,$replaceto,$adminmail);
				}
			}
			else{
				$flag_id = 0;
				$error_message = $chkvalid->messages();
				$contents='';
			}
			
			if(!empty($error_message))
			{
				$error_message=json_decode(json_encode($error_message));
			  
				foreach($error_message as $kk => $error_message_ar)
				{
					$error_msgAr[$kk]=implode("<br>",$error_message_ar);    
				}
			  
			}
	
			$responseAr['flag_id']=$flag_id;
			$responseAr['error_message']=$error_msgAr;
			$responseAr['replyrec']=$contents;
		}
		else{
			$error_msgAr[0]="You must be logged in to resolve a dispute";
			$responseAr['flag_id']=2;
			$responseAr['error_message']=$error_msgAr;
			$responseAr['replyrec']='';
		}
		
		echo json_encode($responseAr);
	}
	
	public function checkdisputereplyform($request,$sess_id=0)
    {
        $validator = Validator::make($request->all(),
			[
				'replydesc'=> "required",
			],
			[
				'replydesc.required'=>'* Reply content is required',
			]
		);
                 
		if($validator->fails())
		{
			return $validator;
		}
			
		return true;
    }
    
}
?>