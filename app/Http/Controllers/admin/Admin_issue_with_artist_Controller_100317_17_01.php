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
class Admin_issue_with_artist_Controller extends Controller
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
                ->select('rd.id','rd.gig_name','rd.dispute_opener_id','rd.gig_id','rd.gig_unique_id','rd.dispute_opening_date','rd.dispute_type','rd.issue_description','rd.arrival','rd.arrival_time','rd.required_specifications_availability','rd.able_to_complete','rd.technical_issue','rd.receive_rider','rd.leave_early','rd.leaving_time','gm.artist_id','um.email','um.nickname','um1.email as artist_email','um1.nickname as artist_nickname','rd.dispute_resolved_status')
                
                ->Join('user_master as um1', function($join)
                {
                        $join->on('gm.artist_id','=','um1.id');
                })
                
                ->where(function($query) use ($srch1){
                        if(!empty($srch1)){
                                //$query->where('um.email', 'like', "%".$srch1."%");
                                $query->where('um.nickname', 'like', "%".$srch1."%");
                                $query->orwhere('um1.nickname', 'like', "%".$srch1."%");
                                //$query->orwhere('um1.email', 'like', "%".$srch1."%");
                                $query->orwhere('rd.gig_name', 'like', "%".$srch1."%");
                        }
                        
                })->where('rd.dispute_type','1');
                
                $all_data = $countries_db->get();
           
                if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
                {
                        
                        if($sort1 == 'gig_name'){
                                $countries_db=$countries_db->orderBy('rd.'.$sort1, $sorttype1);
                        }else if($sort1 == 'bookernickname'){
                                $countries_db=$countries_db->orderBy('um.nickname', $sorttype1);
                        }else if($sort1 == 'artistnickname'){
                                $countries_db=$countries_db->orderBy('um1.nickname', $sorttype1);
                        }else if($sort1 == 'resolved'){
                                $countries_db=$countries_db->orderBy('rd.dispute_resolved_status', $sorttype1);
                        }
                }
                       
                $pagi_country=$countries_db;    
                $pagelimit=1;
                $staterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();                      
                if(!empty($staterow))
                {
                    $pagelimit=$staterow->record_per_page_admin;
                }
                $pagi_country = $pagi_country->paginate($pagelimit);
                $pagi_country->setPath(url(ADMINSEPARATOR.'/admin_issue_with_artist'));
                
                $data['pagi_country']=$pagi_country;
                $data['useinPagiAr']=$useinPagiAr;
                $data['first_sql']=$all_data;
              
               return view('admin.admin_issue_with_artist.admin_issue_with_artist_list', $data);
        }
        
        public function view(Request $request,$id=0){
           
            $countries_db = DB::table('resolve_dispute as rd')
            
                ->Join('user_master as um', function($join)
                {
                        $join->on('um.id','=','rd.dispute_opener_id');
                })
                ->Join('gig_master as gm', function($join)
                {
                        $join->on('gm.id','=','rd.gig_id');
                })
                ->select('rd.id','rd.gig_name','rd.dispute_opener_id','rd.gig_id','rd.gig_unique_id','rd.dispute_opening_date','rd.dispute_type','rd.issue_description','rd.arrival','rd.arrival_time','rd.required_specifications_availability','rd.able_to_complete','rd.technical_issue','rd.receive_rider','rd.leave_early','rd.leaving_time','gm.artist_id','um.email','um.nickname','um1.email as artist_email','um1.nickname as artist_nickname','rd.dispute_resolved_status')
                
                ->Join('user_master as um1', function($join)
                {
                        $join->on('gm.artist_id','=','um1.id');
                })
                
                ->where('rd.dispute_type','1')->where('rd.id',$id);
                
                $all_data = $countries_db->first();
                $pagi_country=$all_data;
                $data['pagi_country']=$pagi_country;
          
                return view('admin.admin_issue_with_artist.admin_issue_with_artist_list_view', $data);
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
                ->select('rd.id','rd.gig_name','rd.dispute_opener_id','rd.gig_id','rd.gig_unique_id','rd.dispute_opening_date','rd.dispute_type','rd.issue_description','rd.arrival','rd.arrival_time','rd.required_specifications_availability','rd.able_to_complete','rd.technical_issue','rd.receive_rider','rd.leave_early','rd.leaving_time','gm.artist_id','gm.total_amount','um.email','um.nickname','um1.email as artist_email','um1.nickname as artist_nickname','rd.dispute_resolved_status','gm.booker_id','gm.artist_security_deposit')
                
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
                
                //fetching total amount of the gig from gig_bidrequest table
                $final_gig_amount = DB::table('gig_bidrequest as gbdr')
                                        ->select('gbdr.total_amount')
                                        ->where('gbdr.gigmaster_id',$pagi_country->gig_id)
                                        ->where('gbdr.gig_bid_status','2')->first();
                $gig_amount_final = $final_gig_amount->total_amount;
                
                $data['pagi_country']=$pagi_country;
                $data['reply_messeges']=$all_data_get;
                $data['total_data']=$total_data;
                //echo '<pre>'; print_r($data);exit;
                if($pagi_country->dispute_resolved_status == '1'){

                        $booker_amount = DB::table('user_order as uo')
                                        ->select('uo.total_price','uo.modified_date')
                                        ->where('uo.gigmaster_id',$pagi_country->gig_id)
                                        ->where('uo.user_id',$pagi_country->booker_id)
                                        ->where('uo.payment_for','DPR')->first();
                        if(!empty($booker_amount)){
                                $data['dispute_resolved_amount']['booker_amount']=$booker_amount->total_price;
                                $data['dispute_resolved_amount']['modified_date']=$booker_amount->modified_date;
                        }else{
                                $data['dispute_resolved_amount']['booker_amount']='';
                                $data['dispute_resolved_amount']['modified_date']='';
                        }
                        $artist_amount = DB::table('user_order as uo')
                                        ->select('uo.total_price','uo.modified_date')
                                        ->where('uo.gigmaster_id',$pagi_country->gig_id)
                                        ->where('uo.user_id',$pagi_country->artist_id)
                                        ->where('uo.payment_for','DPR')->first();
                        if(!empty($artist_amount)){
                              $data['dispute_resolved_amount']['artist_amount']=$artist_amount->total_price;
                              $data['dispute_resolved_amount']['modified_date']=$artist_amount->modified_date;
                        }else{
                              $data['dispute_resolved_amount']['artist_amount']='';
                              $data['dispute_resolved_amount']['modified_date']='';
                        }
                }else{
                        $data['dispute_resolved_amount']['booker_amount']=0;
                        $data['dispute_resolved_amount']['artist_amount']=0;
                        $data['dispute_resolved_amount']['modified_date']=0;
                }
                
                $srmdetails = array();
                if($pagi_country->artist_security_deposit != '0.00' && $pagi_country->artist_security_deposit > 0){
                $srm = DB::table('user_order as uo')
                ->select('uo.total_price')
                ->where('uo.gigmaster_id',$pagi_country->gig_id)
                ->where('uo.payment_for','SMR')->first();
                $srmdetails = $srm;
                }
                //$data['sddetails']['total_amount']=$pagi_country->total_amount;
                //if(!empty($srmdetails)){
                //$data['sddetails']['total_amount']=$pagi_country->total_amount - $srmdetails->total_price;
                //
                //}
                
                if(!empty($srmdetails)){
                        $data['sddetails']['total_amount']=$gig_amount_final - $srmdetails->total_price;
                }
                else{
                        $data['sddetails']['total_amount']=$gig_amount_final;  
                }
                
           return view('admin.admin_issue_with_artist.admin_issue_with_artist_reply_view', $data);
           //echo '<pre>';print_r($data);exit;
        }
     public function reply(Request $request)
        {
                $typeidun=$request->input('typeidun');
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
                $gigdetails = DB::table('gig_master')->select('event_start_date_time','event_city','type_flag','artist_id')->where('id', $gig_id)->first();
                if(count($gigdetails) > 0){
                      $event_start_date_time = $gigdetails->event_start_date_time;
                      $event_start_date = date('d/m/Y h:i A',strtotime($event_start_date_time));
                      $event_city = $gigdetails->event_city;
                      $event_typeflag = $gigdetails->type_flag;
                      $event_artistid = $gigdetails->artist_id;
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
                                        
                                        $self='';
                                        //***------fetching data for mail
                                        if($event_typeflag==1)
                                        {
                                                $self='by '.$artist_ori_nikname.' Artist';
                                        }
                                        elseif($event_typeflag==2)
                                        {
                                                $artdetails = DB::table('group_master')->select('nickname')->where('id', $event_artistid)->first();
                                                if(count($artdetails) > 0)
                                                {
                                                    $event_artist_nickname = $artdetails->nickname;    
                                                }
                                                $self='by '.$event_artist_nickname.' Group';     
                                        }
                                        elseif($event_typeflag==3)
                                        {
                                                $artdetails = DB::table('venue_master')->select('nickname')->where('id', $event_artistid)->first();
                                                if(count($artdetails) > 0)
                                                {
                                                    $event_artist_nickname = $artdetails->nickname;    
                                                }
                                                $self='in '.$event_artist_nickname.' Venue';
                                        }
                                        //****------end
                                        
                                if($typeidun!=4)
                                {
                                        $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{DISPUTEDATE}','{ARTIST}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                        $replaceto =array($logoIMG,$bsurl,$booker_ori_nikname,$DisputeDate,$self,$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                        $sendMail =  mailsnd($Temid=30,$replacefrom,$replaceto,$booker_ori_email);
                                }
                                else{
                                        $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{BOOKERNAME}','{USER}','{DISPUTEDATE}','{SELF}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                        $replaceto =array($logoIMG,$bsurl,$booker_ori_nikname,$artist_ori_nikname,$DisputeDate,$self,$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                             //echo "<pre>";print_r($replacefrom);echo"<br>=====NEXT=====<br><pre>";print_r($replaceto);die;
                                        $sendMail =  mailsnd($Temid=43,$replacefrom,$replaceto,$booker_ori_email);
                                }
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
                                 
                                $self1='';
                                //***-----fetching data for mail
                                if($event_typeflag==1)
                                {
                                        $self1='by you';
                                }
                                elseif($event_typeflag==2)
                                {
                                        $artdetails = DB::table('group_master')->select('nickname')->where('id', $event_artistid)->first();
                                        if(count($artdetails) > 0)
                                        {
                                            $event_artist_nickname = $artdetails->nickname;    
                                        }
                                        $self1='by your '.$event_artist_nickname.' Group';     
                                }
                                elseif($event_typeflag==3)
                                {
                                        $artdetails = DB::table('venue_master')->select('nickname')->where('id', $event_artistid)->first();
                                        if(count($artdetails) > 0)
                                        {
                                            $event_artist_nickname = $artdetails->nickname;    
                                        }
                                        $self1='in your '.$event_artist_nickname.' Venue';
                                }
                                //***-----end
                                 
                        if($typeidun!=4)
                        {       
                                $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKERNAME}','{DISPUTEDATE}','{SELF}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                $replaceto =array($logoIMG,$bsurl,$artist_ori_nikname,$booker_ori_nikname,$DisputeDate,$self1,$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                $sendMail =  mailsnd($Temid=31,$replacefrom,$replaceto,$artist_ori_email);
                        }
                        else{
                                $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKERNAME}','{DISPUTEDATE}','{SELF}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                $replaceto =array($logoIMG,$bsurl,$artist_ori_nikname,$booker_ori_nikname,$DisputeDate,$self1,$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                $sendMail =  mailsnd($Temid=44,$replacefrom,$replaceto,$artist_ori_email);
                        }
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
                                
                                //**-----fetching data for mail
                                $self=''; $self1='';
                                if($event_typeflag==1)
                                {
                                        $self='by '.$artist_ori_nikname.' Artist';
                                        $self1='by you';
                                }
                                elseif($event_typeflag==2)
                                {
                                        $artdetails = DB::table('group_master')->select('nickname')->where('id', $event_artistid)->first();
                                        if(count($artdetails) > 0)
                                        {
                                            $event_artist_nickname = $artdetails->nickname;    
                                        }
                                        
                                        $self='by '.$event_artist_nickname.' Group';
                                        $self1='by your '.$event_artist_nickname.' Group';     
                                }
                                elseif($event_typeflag==3)
                                {
                                        $artdetails = DB::table('venue_master')->select('nickname')->where('id', $event_artistid)->first();
                                        if(count($artdetails) > 0)
                                        {
                                            $event_artist_nickname = $artdetails->nickname;    
                                        }
                                        
                                        $self='in '.$event_artist_nickname.' Venue';
                                        $self1='in your '.$event_artist_nickname.' Venue';
                                }
                                //*****------end
                                
                        if($typeidun!=4)
                        {
                                //-----Mail send Function Starts here for booker--------//
                                $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{DISPUTEDATE}','{ARTIST}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                $replaceto =array($logoIMG,$bsurl,$booker_ori_nikname,$DisputeDate,$self,$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                $sendMail =  mailsnd($Temid=30,$replacefrom,$replaceto,$booker_ori_email);
                                //-----END------------------------------//
                                
                                //-----Mail send Function Starts here for artist--------//
                                $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKERNAME}','{DISPUTEDATE}','{SELF}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                     $replaceto =array($logoIMG,$bsurl,$artist_ori_nikname,$booker_ori_nikname,$DisputeDate,$self1,$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                $sendMail2 =  mailsnd($Temid=31,$replacefrom,$replaceto,$artist_ori_email);
                                //-----END------------------------------//
                        }       
                        else{
                                //-----Mail send Function Starts here for booker--------//
                                $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{BOOKERNAME}','{USER}','{DISPUTEDATE}','{SELF}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                             $replaceto =array($logoIMG,$bsurl,$booker_ori_nikname,$artist_ori_nikname,$DisputeDate,$self,$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                        $sendMail =  mailsnd($Temid=43,$replacefrom,$replaceto,$booker_ori_email);
                                //-----END------------------------------//
                                
                                //-----Mail send Function Starts here for artist--------//
                                $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{BOOKERNAME}','{DISPUTEDATE}','{SELF}','{STARTDATE}','{TOWN}','{REPLYCONTENT}','{SITENAME}','{YEAR}');
                                             $replaceto =array($logoIMG,$bsurl,$artist_ori_nikname,$booker_ori_nikname,$DisputeDate,$self1,$event_start_date,$event_city,$description,$sitename,$copyright_year);
                                        $sendMail =  mailsnd($Temid=44,$replacefrom,$replaceto,$artist_ori_email);
                                //-----END------------------------------//
                        }
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
                
                //**** get gig all data for mail sending ***//
                $todayis=date("d/m/Y");
                
                $booker_partamount="$".$pay_to_booker_id_value;
                $artist_partamount="$".$pay_to_artist_id_value;
                
                $self='';$self1='';
                
                $gigalldata = DB::table('gig_master')->select('event_start_date_time','event_city','type_flag','artist_id','booker_id')->where('id', $gig_id)->first();
                
                if(!empty($gigalldata))
                {
                    $event_start_date_time = $gigalldata->event_start_date_time;
                    $event_start=date("d/m/Y H:i A",strtotime($event_start_date_time));
                    $event_city = $gigalldata->event_city;
                    $event_typeflag = $gigalldata->type_flag;
                    $event_artistid = $gigalldata->artist_id;
                    $event_bookerid = $gigalldata->booker_id;
                    
                    $bkrdetails = DB::table('user_master')->select('nickname','email')->where('id', $event_bookerid)->first();
                        if(count($bkrdetails) > 0)
                        {
                                $event_booker_nickname = $bkrdetails->nickname;
                                $event_booker_emailid = $bkrdetails->email;
                        }
                        else{
                                $event_booker_nickname='';
                                $event_booker_emailid='';
                        }
                        
                    if($event_typeflag==1)
                    {
                        $artdetails = DB::table('user_master')->select('nickname','email')->where('id', $event_artistid)->first();
                        if(count($artdetails) > 0)
                        {
                                $event_artist_nickname = $artdetails->nickname;
                                $event_artist_emailid=$artdetails->email;
                                $self='by '.$event_artist_nickname.' Artist';
                                $self1='by you';
                        }
                        else{
                                $event_artist_nickname='';
                                $event_artist_emailid='';
                        }
                    }
                    elseif($event_typeflag==2)
                    {
                        $artdetails=DB::select("SELECT grp.nickname AS groupnickname, grp.creater_id, usms1.nickname AS grpcreatorname, usms1.email AS grpcreatoremail FROM group_master AS grp JOIN user_master AS usms1 ON usms1.id=grp.creater_id WHERE grp.id='".$event_artistid."'");
                        //$artdetails = DB::table('group_master')->select('nickname')->where('id', $event_artistid)->first();
                        if(count($artdetails) > 0)
                        {
                                $event_artist_nickname = $artdetails[0]->grpcreatorname;
                                $event_artist_emailid=$artdetails[0]->grpcreatoremail;
                                $event_mainartist_nickname=$artdetails[0]->groupnickname;
                                $self='by '.$event_mainartist_nickname.' group';
                                $self1='by your '.$event_mainartist_nickname.' group';
                        }
                        else{
                                $event_artist_nickname='';
                                $event_artist_emailid='';
                                $event_mainartist_nickname='';
                        }
                    }
                    elseif($event_typeflag==3)
                    {
                        $artdetails=DB::select("SELECT ven.nickname AS venuenickname, ven.creater_id, usms2.nickname AS vencreatorname, usms2.email AS vencreatoremail FROM venue_master AS ven JOIN user_master AS usms2 ON usms2.id=ven.creater_id WHERE ven.id='".$event_artistid."'");
                        //$artdetails = DB::table('venue_master')->select('nickname')->where('id', $event_artistid)->first();
                        if(count($artdetails) > 0)
                        {
                                $event_artist_nickname = $artdetails[0]->vencreatorname;
                                $event_artist_emailid=$artdetails[0]->vencreatoremail;
                                $event_mainartist_nickname=$artdetails[0]->venuenickname;
                                $self='in '.$event_mainartist_nickname.' venue';
                                $self1='in your '.$event_mainartist_nickname.' venue';
                        }
                        else{
                                $event_artist_nickname='';
                                $event_artist_emailid='';
                                $event_mainartist_nickname='';
                        }
                    }
                }
                //**** end ***//
                
                //------getting details from settings for mail--------//
                $userssel = DB::table('settings')
                ->select('site_name','email_from','copyright_year','email_template_logo_image','contact_email')
                ->where('id', 1)->get();
                $sitename=$userssel[0]->site_name;
                $emailfrom=$userssel[0]->email_from;
                $copyright_year=$userssel[0]->copyright_year;
                $Imgologo=$userssel[0]->email_template_logo_image;
                $contactemail=$userssel[0]->contact_email;
                $bsurl = url('/');
                $logoIMG = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$Imgologo;
                //------END---------------------------//
                
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
                
                        //**************** Checking SMR start *******************//
                $srmdetails = '';
                $srm = DB::table('user_order as uo')
                ->select('uo.total_price')
                ->where('uo.gigmaster_id',$gig_id)
                ->where('uo.payment_for','SMR')->first();
                if(!empty($srm)){
                        $srmdetails = $srm->total_price;
                }
                        //**************** Checking SMR end *******************//
                        $dataamount = '';
                if($srmdetails!=''){
                   //$site_commission_amout_from_artist = ($pay_to_artist_id_value + $srmdetails)*($site_commission)/100;
                   $dataamount = $pay_to_artist_id_value - ($pay_to_artist_id_value + $srmdetails)*($site_commission)/100;
                   $artist_wallet_new_wallet = $artist_wallet + $dataamount;
                }else{
                   //$site_commission_amout_from_artist = ($pay_to_artist_id_value)*($site_commission)/100;
                   $artist_wallet_new_wallet = $artist_wallet+(($pay_to_artist_id_value*(100-$site_commission))/100);
                }
                
                //echo "Dhiman ".$artist_wallet_new_wallet." ".$pay_to_artist_id_value." ".$dataamount;die;
                
                
                
                //$artist_wallet_new_wallet = $artist_wallet+(($pay_to_artist_id_value*(100-$site_commission))/100);
                
                
                
                
                
                $respdataAr['artist_wallet_new_wallet'] = $artist_wallet_new_wallet;
                $artist_wallet_new_amout = ($pay_to_artist_id_value*(100-$site_commission))/100;
                $respdataAr['artist_wallet_new_amout'] = $artist_wallet_new_amout;
                
                $artist_wallet_add_cr = 'true';
                if($pay_to_artist_id_value!='0'){
                $trnstype = 'C';
                $artist_wallet_add_cr = $this->insertintouserorder($pay_to_artist_id,$artist_email,$pay_to_artist_id_value,$gig_id,$trnstype,'DPR','Dispute payment release');     
                }

                //*************insert into user_order**************//
                
                //********mail sending to booker and artist of resolved details********//
                
                  //------mail to booker-----//
                        $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{EVENTBOOKERNAME}','{SELF}','{STARTDATE}','{TOWN}','{RESOLVEDDATE}','{PARTAMOUNT}','{SITENAME}','{YEAR}');
                        $replaceto =array($logoIMG,$bsurl,$event_booker_nickname,$self,$event_start,$event_city,$todayis,$booker_partamount,$sitename,$copyright_year);
                        $sendMail =  mailsnd($Temid=38,$replacefrom,$replaceto,$event_booker_emailid);
                  //---------end---------//
                  
                  //------mail to artist-----//
                        $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{USER}','{SELF}','{STARTDATE}','{TOWN}','{RESOLVEDDATE}','{PARTAMOUNT}','{SITENAME}','{YEAR}');
                        $replaceto =array($logoIMG,$bsurl,$event_artist_nickname,$self1,$event_start,$event_city,$todayis,$artist_partamount,$sitename,$copyright_year);
                        $sendMail =  mailsnd($Temid=37,$replacefrom,$replaceto,$event_artist_emailid);
                  //---------end---------//
                  
                //********end**********//
                
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
                        
                        //**** refer related insert into user_oder table start****//
                        
                        /*$trnstype = 'D';
                        $artist_refer_wallet_add_dr =  $this->insertintouserorder($pay_to_artist_id,$artist_email,$refer_amout_from_artist,$gig_id,$trnstype,'RD','Referal Debit');*/
                        
                        //**** refer related insert into user_oder table end****//
                        $insertarryrefer = array();
                        $insertarryrefer['wallet_amount']=$refer_wallet_amount + $refer_amout_from_artist;
                        $datainsrtrefer = DB::table('user_master')->where('id', $refer_id)->update($insertarryrefer);
                        
                        //$insertarryAgain = array();
                        //$insertarryAgain['wallet_amount']=$artist_wallet_new_wallet - $refer_amout_from_artist;
                        //$datainsrtartistagain = DB::table('user_master')->where('id', $pay_to_artist_id)->update($insertarryAgain);
                        
                        //if($datainsrtrefer && $datainsrtartistagain){
                        if($datainsrtrefer){
                                $trnstype = 'C';
                                $artist_refer_wallet_add_dr =  $this->insertintouserorder($refer_id,$refer_mail,$refer_amout_from_artist,$gig_id,$trnstype,'RC','Referal Credit');
                                
                                //**-----mail sending to the referral user
                                $referral_partamount="$".$refer_amout_from_artist;
                                
                                $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{REFRERAMOUNT}','{GIGUNIQUEID}','{SITENAME}','{YEAR}');
                                $replaceto =array($logoIMG,$bsurl,$referral_partamount,$gig_unique_id,$sitename,$copyright_year);
                                $sendMail =  mailsnd($Temid=42,$replacefrom,$replaceto,$refer_mail);
                                //**-----end
                        }
                        
                        //********** refer commission insert end****************//
                        
                        //********** admin site commission insert start************//
                        //$site_commission_amout_from_artist = ($pay_to_artist_id_value)*($site_commission - REFFERER_PERCENTAGE)/100;
                        $site_commission_amout_from_artist = ($pay_to_artist_id_value)*($site_commission)/100;
                        $respdataAr['site_commission_amout_from_artist'] = $site_commission_amout_from_artist;
                        
                        $trnstype = 'D';
                        $artist_wallet_add_dr =  $this->insertintouserorder($pay_to_artist_id,$artist_email,$site_commission_amout_from_artist,$gig_id,$trnstype,'SCP','Site Commission payment');
                        
                        //**-----mail sending to the site
                        $site_partamount="$".$site_commission_amout_from_artist;
                        
                        $replacefrom =array('{LOGO_IMG}','{BASE_URL}','{REFRERAMOUNT}','{GIGUNIQUEID}','{SITENAME}','{YEAR}');
                        $replaceto =array($logoIMG,$bsurl,$site_partamount,$gig_unique_id,$sitename,$copyright_year);
                        $sendMail =  mailsnd($Temid=45,$replacefrom,$replaceto,$refer_mail);
                        //**-----end
                        
                        //********** admin site commission insert end************//
                        
                }else{
                        //**************** Checking SMR start *******************//
                $srmdetails = '';
                $srm = DB::table('user_order as uo')
                ->select('uo.total_price')
                ->where('uo.gigmaster_id',$gig_id)
                ->where('uo.payment_for','SMR')->first();
                if(!empty($srm)){
                        $srmdetails = $srm->total_price;
                }
                        //**************** Checking SMR end *******************//
                        
                if($srmdetails!=''){
                   $site_commission_amout_from_artist = ($pay_to_artist_id_value + $srmdetails)*($site_commission)/100;     
                }else{
                   $site_commission_amout_from_artist = ($pay_to_artist_id_value)*($site_commission)/100;      
                }

                $respdataAr['site_commission_amout_from_artist'] = $site_commission_amout_from_artist;
                
                $trnstype = 'D';
                $artist_wallet_add_dr =  $this->insertintouserorder($pay_to_artist_id,$artist_email,$site_commission_amout_from_artist,$gig_id,$trnstype,'SCP','Site Commission payment');
                
                //**-----mail sending to the site
                //$site_partamount="$".$site_commission_amout_from_artist;
                //
                //$replacefrom =array('{LOGO_IMG}','{BASE_URL}','{REFRERAMOUNT}','{GIGUNIQUEID}','{SITENAME}','{YEAR}');
                //$replaceto =array($logoIMG,$bsurl,$site_partamount,$gig_unique_id,$sitename,$copyright_year);
                //$sendMail =  mailsnd($Temid=45,$replacefrom,$replaceto,$contactemail);
                //**-----end
                
                }
                
                

                //*************artist end*************//
                
                //*************booker start*************//
                //*************insert into user_order admin**************//

                $user_master1 = DB::table('user_master as um')->select(DB::raw('um.wallet_amount,um.email'))->where('um.id',$pay_to_booker_id)->first();                      
                if(!empty($user_master1))
                {
                    $booker_wallet = $user_master1->wallet_amount;
                    $booker_email = $user_master1->email;
                }
                
                $respdataAr['booker_wallet'] = $booker_wallet;
                $respdataAr['pay_to_booker_id_value'] = $pay_to_booker_id_value;
                //$booker_wallet_new_wallet = $booker_wallet+(($pay_to_booker_id_value*(100-$site_commission))/100);
                $booker_wallet_new_wallet = $booker_wallet+$pay_to_booker_id_value;
                $respdataAr['booker_wallet_new_wallet'] = $booker_wallet_new_wallet;
                $booker_wallet_new_amout = ($pay_to_booker_id_value*(100-$site_commission))/100;
                $respdataAr['booker_wallet_new_amout'] = $booker_wallet_new_amout;
                
                $trnstype = 'C';
                $booker_wallet_add_cr = 'true';
                if($pay_to_booker_id_value!='0'){
                        $booker_wallet_add_cr = $this->insertintouserorder($pay_to_booker_id,$booker_email,$pay_to_booker_id_value,$gig_id,$trnstype,'DPR','Dispute payment release');    
                }

                //*************insert into user_order**************//
                if($booker_wallet_add_cr){
                        $insertarry['wallet_amount']=$booker_wallet_new_wallet;
                        $datainsrt = DB::table('user_master')->where('id', $pay_to_booker_id)->update($insertarry);
                        
                }
                //*************update into user_master**************//
                //***************site_commission_amout_from_booker*****************//
                
                /*
                $site_commission_amout_from_booker = ($pay_to_booker_id_value)*$site_commission/100;
                $respdataAr['site_commission_amout_from_booker'] = $site_commission_amout_from_booker;
                $trnstype = 'D';
                
                $booker_wallet_add_dr =  $this->insertintouserorder($pay_to_booker_id,$booker_email,$site_commission_amout_from_booker,$gig_id,$trnstype,'SCP','Site Commission payment');
                */
                
                //***************site_commission_amout_from_booker*****************//
                //*************insert into user_order admin**************//
                
                //*************artist end*************//
                //if($artist_wallet_add_cr == 'true' && $artist_wallet_add_dr == 'true' && $booker_wallet_add_cr == 'true' && $booker_wallet_add_dr == 'true'){
                if($artist_wallet_add_cr == 'true' && $artist_wallet_add_dr == 'true' && $booker_wallet_add_cr == 'true'){
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