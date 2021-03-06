<?php
namespace App\Http\Controllers\admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;
class Admin_issue_with_venue_Controller extends Controller
{       
        public function index(Request $request )
        {
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
                        ->select('rd.id','rd.gig_name','rd.dispute_opener_id','rd.gig_id','rd.gig_unique_id','rd.dispute_opening_date','rd.dispute_type','rd.issue_description','rd.arrival','rd.arrival_time','rd.required_specifications_availability','rd.able_to_complete','rd.technical_issue','rd.receive_rider','rd.leave_early','rd.leaving_time','gm.artist_id','gm.event_start_date_time','um.email as booker_email','um.nickname as booker_nickname','vm.id as venue_id','vm.creater_id as venue_creator_id','vm.nickname as venue_nickname','vm.country as venue_country','vm.state as venue_state','vm.city','vm.create_date as venue_create_date','vm.modified_date as venue_modified_date','um1.email as venue_creator_email','um1.nickname as venue_creator_nickname','rd.dispute_resolved_status')
                
                        ->Join('venue_master as vm', function($join)
                        {
                                $join->on('gm.artist_id','=','vm.id');
                        })
                         ->Join('user_master as um1', function($join)
                        {
                                $join->on('vm.creater_id','=','um1.id');
                        })
                
                        ->where(function($query) use ($srch1){
                                if(!empty($srch1)){
                                        
                                    $query->where('vm.nickname', 'like', "%".$srch1."%");
                                    $query->orwhere('um.nickname', 'like', "%".$srch1."%");
                                    $query->orwhere('rd.gig_name', 'like', "%".$srch1."%");
                                }
                                
                        })->where('rd.dispute_type','3');
                
                $all_data = $countries_db->get();                
                                
                if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
                {
                        if($sort1 == 'gig_name'){
                                $countries_db=$countries_db->orderBy('rd.'.$sort1, $sorttype1);
                        }
                        else if($sort1 == 'bookername'){
                                $countries_db=$countries_db->orderBy('um.nickname', $sorttype1);
                        }
                        else if($sort1 == 'venuename'){
                                $countries_db=$countries_db->orderBy('vm.nickname', $sorttype1);
                        }
                        else if($sort1 == 'resolved'){
                                $countries_db=$countries_db->orderBy('rd.dispute_resolved_status', $sorttype1);
                        }
                }
                           
                $pagi_country=$countries_db;

                $pagelimit=1;
                
                $staterow = DB::table('settings as st')
                                ->select(DB::raw('st.id,st.record_per_page_admin'))
                                ->where('st.id', 1)
                                ->first();                      
                
                if(!empty($staterow))
                {
                        $pagelimit=$staterow->record_per_page_admin;
                }
                
                $pagi_country = $pagi_country->paginate($pagelimit);
                $pagi_country->setPath(url(ADMINSEPARATOR.'/admin_issue_with_venue'));
                
                $data['pagi_country']=$pagi_country;
                $data['useinPagiAr']=$useinPagiAr;
             
                return view('admin.admin_issue_with_venue.admin_issue_with_venue_list', $data);
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
                        ->select('rd.id','rd.gig_name','rd.dispute_opener_id','rd.gig_id','rd.gig_unique_id','rd.dispute_opening_date','rd.dispute_type','rd.issue_description','rd.arrival','rd.arrival_time','rd.required_specifications_availability','rd.able_to_complete','rd.technical_issue','rd.receive_rider','rd.leave_early','rd.leaving_time','gm.artist_id','gm.event_start_date_time','um.email as booker_email','um.nickname as booker_nickname','vm.id as venue_id','vm.creater_id as venue_creator_id','vm.nickname as venue_nickname','vm.country as venue_country','vm.state as venue_state','vm.city','vm.create_date as venue_create_date','vm.modified_date as venue_modified_date','um1.email as venue_creator_email','um1.nickname as venue_creator_nickname','rd.dispute_resolved_status')
                
                        ->Join('venue_master as vm', function($join)
                        {
                                $join->on('gm.artist_id','=','vm.id');
                        })
                         ->Join('user_master as um1', function($join)
                        {
                                $join->on('vm.creater_id','=','um1.id');
                        })
                
                        ->where('rd.dispute_type','3')->where('rd.id',$id);
                
                $all_data = $countries_db->first();
                
                $data['pagi_country']=$all_data;
               
                return view('admin.admin_issue_with_venue.admin_issue_with_venue_list_view', $data);
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
                        ->select('rd.id','rd.gig_name','rd.dispute_opener_id','rd.gig_id','rd.gig_unique_id','rd.dispute_opening_date','rd.dispute_type','rd.issue_description','rd.arrival','rd.arrival_time','rd.required_specifications_availability','rd.able_to_complete','rd.technical_issue','rd.receive_rider','rd.leave_early','rd.leaving_time','gm.artist_id','gm.event_start_date_time','gm.event_city','gm.total_amount','um.email as booker_email','um.nickname as booker_nickname','vm.id as venue_id','vm.creater_id as venue_creator_id','vm.nickname as venue_nickname','vm.country as venue_country','vm.state as venue_state','vm.city','vm.create_date as venue_create_date','vm.modified_date as venue_modified_date','um1.email as venue_creator_email','um1.nickname as venue_creator_nickname','rd.dispute_resolved_status','gm.booker_id','gm.artist_security_deposit')
                
                        ->Join('venue_master as vm', function($join)
                        {
                                $join->on('gm.artist_id','=','vm.id');
                        })
                         ->Join('user_master as um1', function($join)
                        {
                                $join->on('vm.creater_id','=','um1.id');
                        })
                
                        ->where('rd.dispute_type','3')->where('rd.id',$id);
                        
                $all_data = $countries_db->first();
                
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
               
                //------------------END-----------------------//
                 $data['reply_messeges']=$all_data_get;
                $data['total_data']=$total_data;
                $data['pagi_country']=$all_data;
                if($all_data->dispute_resolved_status == '1'){

                        $booker_amount = DB::table('user_order as uo')
                                        ->select('uo.total_price','uo.modified_date')
                                        ->where('uo.gigmaster_id',$all_data->gig_id)
                                        ->where('uo.user_id',$all_data->booker_id)
                                        ->where('uo.payment_for','DPR')->first();
                        if(!empty($booker_amount)){
                                $data['dispute_resolved_amount']['booker_amount']=$booker_amount->total_price;
                                $data['dispute_resolved_amount']['modified_date']=$booker_amount->modified_date;
                        }else{
                                $data['dispute_resolved_amount']['booker_amount']='';
                        }
                        
                        
                        $artist_amount = DB::table('user_order as uo')
                                        ->select('uo.total_price','uo.modified_date')
                                        ->where('uo.gigmaster_id',$all_data->gig_id)
                                        ->where('uo.user_id',$all_data->venue_creator_id)
                                        ->where('uo.payment_for','DPR')->first();
                        if(!empty($artist_amount)){
                        
                                $data['dispute_resolved_amount']['artist_amount']=$artist_amount->total_price;
                                $data['dispute_resolved_amount']['modified_date']=$artist_amount->modified_date;
                        }else{
                                $data['dispute_resolved_amount']['artist_amount']='';                
                        }
                        
                        
                        
                        
                }else{
                        $data['dispute_resolved_amount']['booker_amount']=0;
                        $data['dispute_resolved_amount']['artist_amount']=0;
                        $data['dispute_resolved_amount']['modified_date']=0;
                }
                //echo '<pre>';print_r($data);exit;
                $srmdetails = array();
                if($all_data->artist_security_deposit != '0.00' && $all_data->artist_security_deposit > 0){
                $srm = DB::table('user_order as uo')
                ->select('uo.total_price')
                ->where('uo.gigmaster_id',$all_data->gig_id)
                ->where('uo.payment_for','SMR')->first();
                $srmdetails = $srm;
                }
                $data['sddetails']['total_amount']=$all_data->total_amount;
                if(!empty($srmdetails)){
                $data['sddetails']['total_amount']=$all_data->total_amount - $srmdetails->total_price;
                
                }
                
                //echo '<pre>';print_r($data);exit;
                return view('admin.admin_issue_with_venue.admin_issue_with_venue_reply_view', $data);
        }
}
        ?>