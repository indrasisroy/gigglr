<?php
namespace App\Http\Controllers\admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;
use Mail;
use App\Customlibrary\Imageuploadlib;
use View;
class Admin_issue_with_booker_Controller extends Controller
{       
        public function index(Request $request ){
                
            $data=array();
            $useinPagiAr=array();           
            $srch1=addslashes(trim($request->input('srch1','')));
            $sort1=addslashes(trim($request->input('sort1','')));
            $sorttype1=addslashes(trim($request->input('sorttype1','')));
            
            if(!empty($srch1))
            {
                $useinPagiAr['srch1']=trim($srch1);  
            }            
            if(!empty($sort1))
            {
                $useinPagiAr['sort1']=trim($sort1);  
            }           
            if(!empty($sorttype1))
            {
                $useinPagiAr['sorttype1']=trim($sorttype1);  
            }
            
            $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
            $errormsgdata=$request->session()->get('admin_errormsgdata_sess');      
            if(!empty($successmsgdata)){
              $data['successmsgdata']=$successmsgdata;
            }
            if(!empty($errormsgdata)){
                $data['errormsgdata']=$errormsgdata;               
            }
            
            $countries_db = DB::table('resolve_dispute as rd')
                ->Join('user_master as um', function($join)
                {
                        $join->on('um.id','=','rd.dispute_opener_id');
                })
                ->Join('gig_master as gm', function($join)
                {
                        $join->on('gm.id','=','rd.gig_id');
                })
                ->select('rd.id','rd.gig_name','rd.dispute_opener_id','rd.gig_id','rd.gig_unique_id','rd.dispute_opening_date','rd.dispute_type','rd.issue_description','rd.arrival','rd.arrival_time','rd.required_specifications_availability','rd.able_to_complete','rd.technical_issue','rd.receive_rider','rd.leave_early','rd.leaving_time','rd.venue_presentation','rd.getting_gig','rd.commencing_gig','gm.artist_id','gm.booker_id','gm.type_flag','um.email','um.nickname','um1.email as booker_email','um1.nickname as booker_nickname','rd.dispute_resolved_status','rd.dispute_resolved_date')
                
                ->Join('user_master as um1', function($join)
                {
                        $join->on('gm.booker_id','=','um1.id');
                })
                
                ->where(function($query) use ($srch1){
                        if(!empty($srch1)){
                                
                            $query->where('rd.gig_name', 'like', "%".$srch1."%");
                        }
                        
                })->where('rd.dispute_type','4');
                
                $all_data = $countries_db->get();
           
                if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
                {
                      $countries_db=$countries_db->orderBy('rd.'.$sort1, $sorttype1);
                }
                       
                $pagi_country=$countries_db;    
                $pagelimit=1;
                $staterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();                      
                if(!empty($staterow))
                {
                    $pagelimit=$staterow->record_per_page_admin;
                }
                $pagi_country = $pagi_country->paginate($pagelimit);
                $pagi_country->setPath(url(ADMINSEPARATOR.'/admin_issue_with_booker'));
                
                $data['pagi_country']=$pagi_country;
                $data['useinPagiAr']=$useinPagiAr;
                $data['first_sql']=$all_data;
              
               return view('admin.admin_issue_with_booker.admin_issue_with_booker_list', $data);
        }
        
        public function view(Request $request,$id=0){
				//$countries_db = ("SELECT rd.id, rd.gig_name, rd.dispute_opener_id, rd.gig_id, rd.gig_unique_id, rd.dispute_opening_date, rd.dispute_type, rd.issue_description, rd.arrival, rd.arrival_time, rd.required_specifications_availability, rd.able_to_complete, rd.technical_issue, rd.receive_rider, rd.leave_early, rd.leaving_time, rd.venue_presentation, rd.getting_gig, rd.commencing_gig, gm.artist_id, gm.booker_id, um.email, um.nickname, um1.email as booker_email, um1.nickname as booker_nickname, rd.dispute_resolved_status, rd.dispute_resolved_date");
           
            $countries_db = DB::table('resolve_dispute as rd')
            
                ->Join('user_master as um', function($join)
                {
                        $join->on('um.id','=','rd.dispute_opener_id');
                })
                ->Join('gig_master as gm', function($join)
                {
                        $join->on('gm.id','=','rd.gig_id');
                })
                ->select('rd.id','rd.gig_name','rd.dispute_opener_id','rd.gig_id','rd.gig_unique_id','rd.dispute_opening_date','rd.dispute_type','rd.issue_description','rd.arrival','rd.arrival_time','rd.required_specifications_availability','rd.able_to_complete','rd.technical_issue','rd.receive_rider','rd.leave_early','rd.leaving_time','rd.venue_presentation','rd.getting_gig','rd.commencing_gig','gm.artist_id','gm.booker_id','um.email','um.nickname','um1.email as booker_email','um1.nickname as booker_nickname','rd.dispute_resolved_status','rd.dispute_resolved_date')
                
                ->Join('user_master as um1', function($join)
                {
                        $join->on('gm.booker_id','=','um1.id');
                })
                
                ->where('rd.dispute_type','4')->where('rd.id',$id);
                
                $all_data = $countries_db->first();
                $pagi_country=$all_data;
				
                $data['pagi_country']=$pagi_country;
          
                return view('admin.admin_issue_with_booker.admin_issue_with_booker_list_view', $data);
        }
    
        public function reply_view(Request $request,$id=0){
                
          $countries_db = DB::table('resolve_dispute as rd')
            
                ->Join('user_master as um', function($join)
                {
                        $join->on('um.id','=','rd.dispute_opener_id');
                })
                ->Join('gig_master as gm', function($join)
                {
                        $join->on('gm.id','=','rd.gig_id');
                })
                ->select('rd.id','rd.gig_name','rd.dispute_opener_id','rd.gig_id','rd.gig_unique_id','rd.dispute_opening_date','rd.dispute_type','rd.issue_description','rd.arrival','rd.arrival_time','rd.required_specifications_availability','rd.able_to_complete','rd.technical_issue','rd.receive_rider','rd.leave_early','rd.leaving_time','gm.artist_id','gm.total_amount','um.email','um.nickname','um1.email as artist_email','um1.nickname as artist_nickname','rd.dispute_resolved_status','gm.booker_id')
                
                ->Join('user_master as um1', function($join)
                {
                        $join->on('gm.artist_id','=','um1.id');
                })
                
                ->where('rd.dispute_type','1')->where('rd.id',$id);
                
                $all_data = $countries_db->first();
                $pagi_country=$all_data;
                //echo '<pre>'; print_r($all_data); exit;
                //------------for listing of repli messeges----------//
                
           $all_reply_data = DB::table('resolve_dispute_replies as rdr')
                        ->Join('user_master as um', function($join) 
                                {
                                     $join->on('um.id','=','rdr.replied_by');
                                        
                                })
                        ->select('rdr.*','um.nickname as reply_by_user')
                        ->where('rdr.resolve_dispute_id',$id);
                $all_data_get = $all_reply_data->orderby('rdr.id','DESC')->skip(0)->take(4)->get();
                $total_data = $all_reply_data->count();
                //echo '<pre>'; print_r($all_data_get);exit;
                //------------------END-----------------------//
                $data['pagi_country']=$pagi_country;
                $data['reply_messeges']=$all_data_get;
                $data['total_data']=$total_data;
                //echo '<pre>'; print_r($data);exit;
                if($pagi_country->dispute_resolved_status == '1'){

                        $booker_amount = DB::table('user_order as uo')
                                        ->select('uo.total_price')
                                        ->where('uo.gigmaster_id',$pagi_country->gig_id)
                                        ->where('uo.user_id',$pagi_country->booker_id)
                                        ->where('uo.payment_for','DPR')->first();
                                        
                        $artist_amount = DB::table('user_order as uo')
                                        ->select('uo.total_price','uo.modified_date')
                                        ->where('uo.gigmaster_id',$pagi_country->gig_id)
                                        ->where('uo.user_id',$pagi_country->artist_id)
                                        ->where('uo.payment_for','DPR')->first();
                        $data['dispute_resolved_amount']['booker_amount']=$booker_amount->total_price;
                        $data['dispute_resolved_amount']['artist_amount']=$artist_amount->total_price;
                        $data['dispute_resolved_amount']['modified_date']=$artist_amount->modified_date;
                }else{
                        $data['dispute_resolved_amount']['booker_amount']=0;
                        $data['dispute_resolved_amount']['artist_amount']=0;
                        $data['dispute_resolved_amount']['modified_date']=0;
                }
                
           return view('admin.admin_issue_with_artist.admin_issue_with_artist_reply_view', $data);
           //echo '<pre>';print_r($data);exit;
        }
     public function reply(Request $request)
        {
                
                $description = strip_tags($request->input('description'));
                $last_row = $request->input('last_row');
                $resolve_dispute_id = $request->input('resolve_dispute_id');
                $gig_id = $request->input('gig_id');
                $gig_unique_id = $request->input('gig_unique_id');
                $booker_id = $request->input('booker_id');
                $artist_id = $request->input('artist_id');
                $booker_ID = $request->input('booker_ID');
                $artist_ID = $request->input('artist_ID');
                $user_type = $request->input('user_type');
                $respdataAr=array();
                //------getting the booker emailID-------//
                $booker_useremail = DB::table('user_master')->select('email','nickname')->where('id', $booker_id)->first();
                if(count($booker_useremail) > 0){
                        
                      $booker_ori_email = $booker_useremail->email;
                     //$booker_ori_email = 'sutirtha.nazir@esolzmail.com';
                      $booker_ori_nikname = $booker_useremail->nickname;
                      //echo $gig_id.'     '.$booker_ori_nikname;exit;
                }else{
                        echo'Probably booker is deleted';exit;
                }
                //---------END-----------------//
                
                //------getting the artist emailID-------//
                if($user_type == '1'){
                        
                        $artist_useremail = DB::table('user_master')->select('email','nickname')->where('id', $artist_id)->first();
                        if(count($artist_useremail) > 0){
                              $artist_ori_email = $artist_useremail->email;
                              $artist_ori_nikname = $artist_useremail->nickname;
                        }else{
                                 echo'Probably artist is deleted';exit;
                        }
                }
                else if($user_type == '2'){
                        $artist_useremail = DB::table('user_master as um')
                        ->Join('group_master as grm', function($join)
                        {
                                $join->on('grm.creater_id','=','um.id');
                        })
                        ->select('um.email','um.nickname')
                        ->where('grm.id', $artist_id)->first();
                        
                        if(count($artist_useremail) > 0){
                              $artist_ori_email = $artist_useremail->email;
                              $artist_ori_nikname = $artist_useremail->nickname;
                        }else{
                                 echo'Probably artist is deleted';exit;
                        }
                }
                else if($user_type == '3'){
                        $artist_useremail = DB::table('user_master as um')
                        ->Join('venue_master as vm', function($join)
                        {
                                $join->on('vm.creater_id','=','um.id');
                        })
                        ->select('um.email','um.nickname')
                        ->where('vm.id', $artist_id)->first();
                        
                        if(count($artist_useremail) > 0){
                              $artist_ori_email = $artist_useremail->email;
                              $artist_ori_nikname = $artist_useremail->nickname;
                        }else{
                                 echo'Probably artist is deleted';exit;
                        }
                }

                //---------END-----------------//
                
                //------getting the gig detail-------//
                $gigdetails = DB::table('gig_master')->select('event_start_date_time','event_city')->where('id', $gig_id)->first();
                if(count($gigdetails) > 0){
                      $event_start_date_time = $gigdetails->event_start_date_time;
                      $event_start_date = date('d/m/Y h:i A',strtotime($event_start_date_time));
                      $event_city = $gigdetails->event_city;
                }
                //---------END-----------------//
                
                //------getting details from settings for mail--------//
                $userssel = DB::table('settings')
                ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                ->where('id', 1)->get();
                $sitename=$userssel[0]->site_name;
                $emailfrom=$userssel[0]->email_from;
                $copyright_year=$userssel[0]->copyright_year;
                $Imgologo=$userssel[0]->email_template_logo_image;
                $bsurl = url('/');
                $logoIMG = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$Imgologo;
                //------END---------------------------//
                
                //---------getting the dispute date--------//
                $dispuTE_Date = DB::table('resolve_dispute')->select('dispute_opening_date')->where('id', $resolve_dispute_id)->first();
                if(count($dispuTE_Date) > 0){
                      $DisputeDatenor = $dispuTE_Date->dispute_opening_date;
                      $DisputeDate = date('d/m/Y h:i A',strtotime($DisputeDatenor));
                    
                }
                //--------END-----------------//
                
               //-----------Createing datainsert arrey for insert into resolve_dispute_replies table--------//
                $dataInsert = array(
                             'resolve_dispute_id'=>$resolve_dispute_id,
                             'gig_id'=>$gig_id,
                             'gig_unique_id'=>$gig_unique_id,
                             'dispute_type'=>'1',
                             'replied_by'=>'1',
                             'reply_date'=>date('Y-m-d H:i:s'),
                             'reply_content'=>$description
                        );
                //------------------------END---------------------------------------------//
                
                //--------------------Condition for replied_to_1 and replied_to_2---------//
                if($booker_ID != '' && $artist_ID==''){
                        $dataInsert['replied_to_1']= $booker_ID;
                        
                        $dataInserted = DB::table('resolve_dispute_replies')->insert($dataInsert);
                                if($dataInserted){
                                        //-----Mail send Function Starts here for booker--------//
                                        $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{DISPUTEDATE}','{ARTIST}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                             $replaceto =array($logoIMG,$bsurl,$booker_ori_nikname,$DisputeDate,$artist_ori_nikname,$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                        $sendMail =  mailsnd($Temid=30,$replacefrom,$replaceto,$booker_ori_email);
                                        //-----END------------------------------//
                                        
                                        //----------Appending the data in the reply section---------//
                                         $all_reply_data = DB::table('resolve_dispute_replies as rdr')
                                                ->Join('user_master as um', function($join) 
                                                        {
                                                             $join->on('um.id','=','rdr.replied_by');
                                                                
                                                        })
                                                ->select('rdr.*','um.nickname as reply_by_user')
                                                ->where('rdr.resolve_dispute_id',$resolve_dispute_id);

                                        //$all_data_get = $all_reply_data->orderby('rdr.id','DESC')->skip(0)->take($last_row+1)->get();
                                        $all_data_get = $all_reply_data->orderby('rdr.id','DESC')->skip(0)->take(4)->get();
                                        $data['reply_messeges']=$all_data_get;
                                        $data['pannel']=0;
                                        $view_obj = View::make('admin.admin_issue_with_artist.admin_issue_artist_render_page',$data);
                                        $contents = $view_obj->render();  
                                        
                                         //--------for toster----------//
                                        $respdataAr['type']='success';
                                        $respdataAr['message']='Your messege send successfully';
                                        //----------END---------------//
                                        
                                        $respdataAr['reply_content']=$contents;
                                        
                                        
                                        //----------------------END---------------------------------//
                                }else{
                                         //--------for toster----------//
                                        $respdataAr['type']='error';
                                        $respdataAr['message']='Your messege not send successfully';
                                        //----------END---------------//
                                }
                        
                        echo json_encode($respdataAr);
                        
                }elseif($artist_ID != '' && $booker_ID==''){
                        
                        $dataInsert['replied_to_2']= $artist_ID;
                        $dataInserted = DB::table('resolve_dispute_replies')->insert($dataInsert);
                        if($dataInserted){
                                
                                 //-----Mail send Function Starts here for artist--------//
                                $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKERNAME}','{DISPUTEDATE}','{SELF}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                $replaceto =array($logoIMG,$bsurl,$artist_ori_nikname,$booker_ori_nikname,$DisputeDate,'performed by you',$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                $sendMail =  mailsnd($Temid=31,$replacefrom,$replaceto,$artist_ori_email);
                                //-----END------------------------------//
                                         
                                //----------Appending the data in the reply section---------//
                                 $all_reply_data = DB::table('resolve_dispute_replies as rdr')
                                        ->Join('user_master as um', function($join) 
                                                {
                                                     $join->on('um.id','=','rdr.replied_by');
                                                        
                                                })
                                        ->select('rdr.*','um.nickname as reply_by_user')
                                        ->where('rdr.resolve_dispute_id',$resolve_dispute_id);

                                //$all_data_get = $all_reply_data->orderby('rdr.id','DESC')->skip(0)->take($last_row+1)->get();
                                $all_data_get = $all_reply_data->orderby('rdr.id','DESC')->skip(0)->take(4)->get();
                                $data['reply_messeges']=$all_data_get;
                                $data['pannel']=0;
                                $view_obj = View::make('admin.admin_issue_with_artist.admin_issue_artist_render_page',$data);
                                $contents = $view_obj->render();  
                                
                                $respdataAr['reply_content']=$contents;
                                 //--------for toster----------//
                                $respdataAr['type']='success';
                                $respdataAr['message']='Your messege send successfully';
                                 //----------END---------------//
                                
                        }else{
                                //--------for toster----------//
                                $respdataAr['type']='error';
                                $respdataAr['message']='Your messege not send successfully';
                                 //----------END---------------//
                        }
                        
                        echo json_encode($respdataAr);
                        
                }elseif($booker_ID != '' && $artist_ID != ''){
                        $dataInsert['replied_to_1']= $booker_ID;
                        $dataInsert['replied_to_2']= $artist_ID;
                        
                        $dataInserted = DB::table('resolve_dispute_replies')->insert($dataInsert);
                        if($dataInserted){
                                //-----Mail send Function Starts here for booker--------//
                                $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{DISPUTEDATE}','{ARTIST}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                $replaceto =array($logoIMG,$bsurl,$booker_ori_nikname,$DisputeDate,$artist_ori_nikname,$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                $sendMail =  mailsnd($Temid=30,$replacefrom,$replaceto,$booker_ori_email);
                                //-----END------------------------------//
                                
                                //-----Mail send Function Starts here for artist--------//
                                $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKERNAME}','{DISPUTEDATE}','{SELF}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                     $replaceto =array($logoIMG,$bsurl,$artist_ori_nikname,$booker_ori_nikname,$DisputeDate,'performed by you',$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                $sendMail2 =  mailsnd($Temid=31,$replacefrom,$replaceto,$artist_ori_email);
                                //-----END------------------------------//
                                
                                          
                                //----------Appending the data in the reply section---------//
                                 $all_reply_data = DB::table('resolve_dispute_replies as rdr')
                                        ->Join('user_master as um', function($join) 
                                                {
                                                     $join->on('um.id','=','rdr.replied_by');
                                                        
                                                })
                                        ->select('rdr.*','um.nickname as reply_by_user')
                                        ->where('rdr.resolve_dispute_id',$resolve_dispute_id);

                                //$all_data_get = $all_reply_data->orderby('rdr.id','DESC')->skip(0)->take($last_row+1)->get();
                                $all_data_get = $all_reply_data->orderby('rdr.id','DESC')->skip(0)->take(4)->get();
                                $data['reply_messeges']=$all_data_get;
                                $data['pannel']=0;
                                $view_obj = View::make('admin.admin_issue_with_artist.admin_issue_artist_render_page',$data);
                                $contents = $view_obj->render();  
                                
                               
                                $respdataAr['reply_content']=$contents;
                                //--------for toster----------//
                                $respdataAr['type']='success';
                                $respdataAr['message']='Your messege send successfully';
                                 //----------END---------------//
                               // echo json_encode($respdataAr);
                        }else{
                                $respdataAr['type']='error';
                                $respdataAr['message']='Your messege not send successfully'; 
                        }
                        
                        echo json_encode($respdataAr);
                        
                }
                //------------------------------END-------------------------------------//
          
           
        }
        public function load_more(Request $request){
                
                $next_limit = $request->input('limit');
		$resolve_dispute_id = $request->input('resolve_dispute_id');
		
		//----------Appending the data in the reply section---------//
                        $all_reply_data = DB::table('resolve_dispute_replies as rdr')
                               ->Join('user_master as um', function($join) 
                                       {
                                            $join->on('um.id','=','rdr.replied_by');
                                               
                                       })
                               ->select('rdr.*','um.nickname as reply_by_user')
                               ->where('rdr.resolve_dispute_id',$resolve_dispute_id);
                       $all_data_get = $all_reply_data->orderby('rdr.id','DESC')->skip($next_limit)->take(4)->get();
                       $count = $all_reply_data->count();
                       
                       $data['reply_messeges']=$all_data_get;
                       $data['pannel']=0;
                       
                        $view_obj = View::make('admin.admin_issue_with_artist.admin_issue_artist_render_page',$data);
                        $contents = $view_obj->render();  
                        
                        $respdataAr=array();
                        
                        $respdataAr['reply_content']=$contents;
                        echo json_encode($respdataAr);
				

        }
        

        public function artistbookertransactionbyadmin(Request $request){
                //echo REFFERER_PERCENTAGE;die;
                $refer_com = '';
                $pay_to_booker_id = $request->input('pay_to_booker_id');
                $pay_to_booker_id_value = $request->input('pay_to_booker_id_value');
                $pay_to_artist_id = $request->input('pay_to_artist_id');
                $pay_to_artist_id_value = $request->input('pay_to_artist_id_value');
                $gig_id = $request->input('gig_id');
                $gig_unique_id = $request->input('gig_unique_id');
                $resolve_dispute_id = $request->input('resolve_dispute_id');
                $artist_type = $request->input('artist_type');
                $insertarry = array();
                $booker_wallet = '';
                $booker_email = '';
                $artist_wallet = '';
                $artist_email = '';
                $staterow = DB::table('settings as st')->select(DB::raw('st.site_commission,st.referral_commission'))->where('st.id', 1)->first();                      
                if(!empty($staterow))
                {
                    $site_commission = $staterow->site_commission;
                    $refer_com = $staterow->referral_commission;
                }
                
                
                $user_master1 = DB::table('user_master as um')->select(DB::raw('um.wallet_amount,um.email'))->where('um.id',$pay_to_booker_id)->first();                      
                if(!empty($user_master1))
                {
                    $booker_wallet = $user_master1->wallet_amount;
                    $booker_email = $user_master1->email;
                }
                
                if($artist_type == '1'){
                        $user_master2 = DB::table('user_master as um')->select(DB::raw('um.id,um.wallet_amount,um.email'))->where('um.id', $pay_to_artist_id)->first();      
                }else if($artist_type == '2'){
                        $user_master2 = DB::table('user_master as um')
                        ->Join('group_master as gm', function($join)
                        {
                        $join->on('um.id','=','gm.creater_id');
                        })
                        ->select(DB::raw('um.id,um.wallet_amount,um.email'))
                        ->where('gm.id', $pay_to_artist_id)
                        ->first();  
                }else if($artist_type == '3'){
                        $user_master2 = DB::table('user_master as um')
                        ->Join('venue_master as vm', function($join)
                        {
                        $join->on('um.id','=','vm.creater_id');
                        })
                        ->select(DB::raw('um.id,um.wallet_amount,um.email'))
                        ->where('vm.id', $pay_to_artist_id)
                        ->first();  
                }
                if(!empty($user_master2))
                {
                    $artist_wallet=$user_master2->wallet_amount;
                    $artist_email=$user_master2->email;
                    $pay_to_artist_id = $user_master2->id;
                }
                $respdataAr = array();
                $respdataAr['gig_id'] = $gig_id;
                $respdataAr['gig_unique_id'] = $gig_unique_id;              
                $respdataAr['resolve_dispute_id'] = $resolve_dispute_id;                
                
                
                $respdataAr['site_commission'] = $site_commission;

                $trnstype = '';
                //*************artist start*************//
                $respdataAr['artist_wallet'] = $artist_wallet;
                $respdataAr['pay_to_artist_id_value'] = $pay_to_artist_id_value;
                $artist_wallet_new_wallet = $artist_wallet+(($pay_to_artist_id_value*(100-$site_commission))/100);;
                $respdataAr['artist_wallet_new_wallet'] = $artist_wallet_new_wallet;
                $artist_wallet_new_amout = ($pay_to_artist_id_value*(100-$site_commission))/100;
                $respdataAr['artist_wallet_new_amout'] = $artist_wallet_new_amout;
                $trnstype = 'C';
                
                $artist_wallet_add_cr = $this->insertintouserorder($pay_to_artist_id,$artist_email,$pay_to_artist_id_value,$gig_id,$trnstype,'DPR','Dispute payment release');
                //*************insert into user_order**************//
                
                if($artist_wallet_add_cr){
                        $insertarry['wallet_amount']=$artist_wallet_new_wallet;
                        $datainsrt = DB::table('user_master')->where('id', $pay_to_artist_id)->update($insertarry);
                }
                
                //*************update into user_master**************//
                $cherefer_mail = "SELECT um . * FROM  `user_master` AS um,  `referral_email` AS ref_eml WHERE ref_eml.`referrer_userid` = um.`id` AND ref_eml.`user_id` =  '".$pay_to_artist_id."' AND um.`status` =  '1' AND DATE( ref_eml.`referral_expiry_date` ) >= CURDATE( ) ";
                $cherefer_mail_result = DB::select( DB::raw($cherefer_mail));
                
                if(!empty($cherefer_mail_result)){
                        
                        //********** refer commission insert start****************//
                        $refer_mail = $cherefer_mail_result[0]->email;
                        $refer_id = $cherefer_mail_result[0]->id;
                        $refer_wallet_amount = $cherefer_mail_result[0]->wallet_amount;
                                
                        $refer_amout_from_artist = ($pay_to_artist_id_value)*($refer_com/100);
                        $respdataAr['refer_amout_from_artist'] = $refer_amout_from_artist;
                        
                        $trnstype = 'D';
                        $artist_refer_wallet_add_dr =  $this->insertintouserorder($pay_to_artist_id,$artist_email,$refer_amout_from_artist,$gig_id,$trnstype,'RD','Referal Debit');
                        
                        $insertarryrefer = array();
                        $insertarryrefer['wallet_amount']=$refer_wallet_amount + $refer_amout_from_artist;
                        $datainsrtrefer = DB::table('user_master')->where('id', $refer_id)->update($insertarryrefer);
                        
                        $insertarryAgain = array();
                        $insertarryAgain['wallet_amount']=$artist_wallet_new_wallet - $refer_amout_from_artist;
                        $datainsrtartistagain = DB::table('user_master')->where('id', $pay_to_artist_id)->update($insertarryAgain);
                        
                        if($datainsrtrefer && $datainsrtartistagain){
                                $trnstype = 'C';
                                $artist_refer_wallet_add_dr =  $this->insertintouserorder($refer_id,$refer_mail,$refer_amout_from_artist,$gig_id,$trnstype,'RC','Referal Credit');
                        }
                        
                        //********** refer commission insert end****************//
                        
                        //********** admin site commission insert start************//
                        $site_commission_amout_from_artist = ($pay_to_artist_id_value)*($site_commission - REFFERER_PERCENTAGE)/100;
                        //$site_commission_amout_from_artist = ($pay_to_artist_id_value)*($site_commission)/100;
                        $respdataAr['site_commission_amout_from_artist'] = $site_commission_amout_from_artist;
                        
                        $trnstype = 'D';
                        $artist_wallet_add_dr =  $this->insertintouserorder($pay_to_artist_id,$artist_email,$site_commission_amout_from_artist,$gig_id,$trnstype,'SCP','Site Commission payment');
                        //********** admin site commission insert end************//
                        
                }else{
                        
                $site_commission_amout_from_artist = ($pay_to_artist_id_value)*($site_commission)/100;
                $respdataAr['site_commission_amout_from_artist'] = $site_commission_amout_from_artist;
                
                $trnstype = 'D';
                $artist_wallet_add_dr =  $this->insertintouserorder($pay_to_artist_id,$artist_email,$site_commission_amout_from_artist,$gig_id,$trnstype,'SCP','Site Commission payment');
                
                }
                
                

                //*************artist end*************//
                
                //*************booker start*************//
                //*************insert into user_order admin**************//
                
                
                $respdataAr['booker_wallet'] = $booker_wallet;
                $respdataAr['pay_to_booker_id_value'] = $pay_to_booker_id_value;
                $booker_wallet_new_wallet = $booker_wallet+(($pay_to_booker_id_value*(100-$site_commission))/100);
                $respdataAr['booker_wallet_new_wallet'] = $booker_wallet_new_wallet;
                $booker_wallet_new_amout = ($pay_to_booker_id_value*(100-$site_commission))/100;
                $respdataAr['booker_wallet_new_amout'] = $booker_wallet_new_amout;
                $trnstype = 'C';
                
                $booker_wallet_add_cr = $this->insertintouserorder($pay_to_booker_id,$booker_email,$pay_to_booker_id_value,$gig_id,$trnstype,'DPR','Dispute payment release');
                //*************insert into user_order**************//
                if($booker_wallet_add_cr){
                        $insertarry['wallet_amount']=$booker_wallet_new_wallet;
                        $datainsrt = DB::table('user_master')->where('id', $pay_to_booker_id)->update($insertarry);
                        
                }
                //*************update into user_master**************//
                
                $site_commission_amout_from_booker = ($pay_to_booker_id_value)*$site_commission/100;
                $respdataAr['site_commission_amout_from_booker'] = $site_commission_amout_from_booker;
                $trnstype = 'D';
                
                $booker_wallet_add_dr =  $this->insertintouserorder($pay_to_booker_id,$booker_email,$site_commission_amout_from_booker,$gig_id,$trnstype,'SCP','Site Commission payment');
                //*************insert into user_order admin**************//
                //*************artist end*************//
                if($artist_wallet_add_cr == 'true' && $artist_wallet_add_dr == 'true' && $booker_wallet_add_cr == 'true' && $booker_wallet_add_dr == 'true'){
                        $datainsrt = DB::table('resolve_dispute')->where('id', $resolve_dispute_id)->update(['dispute_resolved_status'=>'1','dispute_resolved_date'=>date('Y-m-d H:i:s')]);
                        $insertarrygig_master = array();
                        $insertarrygig_master['dispute_flag']='2';
                        $insertarrygig_master['payment_flag']='4';
                        $datainsrt = DB::table('gig_master')->where('id', $gig_id)->update($insertarrygig_master);
                        
                        $respdataAr['returnflag']='1';
                        $respdataAr['msg']='Resolve dispute successfully';
                }else{
                        $respdataAr['returnflag']='0';
                        $respdataAr['msg']='Error in system';
                }
                echo json_encode($respdataAr);
                
        }
        
        
        function insertintouserorder($user_id,$user_email,$amount_trans,$gig_master_details_id,$trnstype,$payment_for,$payment_description){
                $logggedin_user_ip = get_client_ip_server();
                
                $dataorderInsert=array();
                $dataorderInsert['payment_for']=$payment_for; //required
                $dataorderInsert['card_token']='';
                $dataorderInsert['charge_token']='';
                $dataorderInsert['payment_description']=$payment_description;
                $dataorderInsert['payment_scheme']='';
                $dataorderInsert['email']=$user_email;
                $dataorderInsert['total_price']= $amount_trans;//required
                $dataorderInsert['user_ip_address']= $logggedin_user_ip;//required
                $dataorderInsert['debitorcredit']=$trnstype; // C=> Credit , D=> Debit //required
                $dataorderInsert['gigmaster_id'] = $gig_master_details_id;//required
                $dataorderInsert['currency']='';
                $dataorderInsert['payment_status']="SUCCESS";//required
                $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                $dataorderInsert['user_id'] = $user_id;
                $dataorderInsert['create_date'] = date('Y-m-d H:i:s');
                $dataorderInsert['modified_date']= date('Y-m-d H:i:s');
                //*** insert  query
                $isInserted = DB::table('user_order')->insert($dataorderInsert);
                if($isInserted){
                        return true;
                }else{
                        return false;
                }
        }
    
}
        ?>