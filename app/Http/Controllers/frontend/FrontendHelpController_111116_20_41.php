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
        $help_howitsdone=$help_howitsdone->where('howitsdone.status', 1);
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
        return view('front.help.supportview');
    }

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
				
				//*********Helper Function Starts here
				
				$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKER}','{STARTDATE}','{TOWN}','{SITENAME}','{YEAR}');
				$replaceto =array($logoIMG,$bsurl,$artistname,$frombooker,$gigstartdate,$gigtown,$sitename,$copyright_year);
				
				mailsnd($Temid=23,$replacefrom,$replaceto,$artistmail);
				
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
				'arrivaltime.required'=>'* Artist arrival time field is required',
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
	"SELECT gm.giguniqueid AS uniquegigid, gm.artist_id AS groupid, gm.event_city AS gigtown, gm.event_start_date_time AS gigstartdate, grp.nickname AS groupname
	FROM gig_master AS gm
	LEFT JOIN group_master AS grp ON grp.id=gm.artist_id
	WHERE gm.id='".$gigmasterid."'"
			);
			if(count($group_query)>0)
			{
				$gigmasteruniqueid=$group_query[0]->uniquegigid;
				$artistname=$group_query[0]->groupname;
				$gigtown=$group_query[0]->gigtown;
				$gigstart=$group_query[0]->gigstartdate;
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
				
				//*********Helper Function Starts here
				
				$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKER}','{STARTDATE}','{TOWN}','{SITENAME}','{YEAR}');
				$replaceto =array($logoIMG,$bsurl,$artistname,$frombooker,$gigstartdate,$gigtown,$sitename,$copyright_year);
				
				//mailsnd($Temid=23,$replacefrom,$replaceto,$artistmail);
				
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
				'grouparrivaltime.required'=>'* Group arrival time field is required',
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
    
}
?>