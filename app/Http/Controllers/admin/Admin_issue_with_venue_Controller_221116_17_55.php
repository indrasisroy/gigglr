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
            $countries_db = DB::table('resolve_dispute as rd');
            $countries_db=$countries_db->select(DB::raw('rd.id,rd.gig_name,rd.dispute_opener_id,rd.gig_id,rd.gig_unique_id,rd.dispute_opening_date,rd.dispute_type,rd.issue_description,rd.arrival,rd.arrival_time,rd.required_specifications_availability,rd.able_to_complete,rd.technical_issue,rd.receive_rider,rd.leave_early,rd.leaving_time'));        
            $countries_db=$countries_db->where('rd.dispute_type', "3");
            //print_r($countries_db);die();
                $first_sql= DB::table('resolve_dispute')
                ->join('gig_master', 'gig_master.id', '=', 'resolve_dispute.gig_id')
                ->select('gig_master.artist_id')
                ->where('resolve_dispute.dispute_type', "3")
                ->get();
                echo'<pre>';
                print_r($first_sql);die();
                $artist_details=DB::table('venue_master')->select('venue_master.creater_id','venue_master.nickname')->where('id','=',$first_sql[0]->artist_id)->get();
                //print_r($artist_details);die();
                $user_master=DB::table('user_master')->select('user_master.email')->where('id','=',$artist_details[0]->creater_id)->get();
                //print_r($user_master);die();
                                
            if(!empty($srch1))
            {
               $countries_db=$countries_db->where('venue_master.nickname', 'like', "%".$srch1."%");   
            }
            
            
            if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
            {
                  
                  $countries_db=$countries_db->orderBy('venue_master.'.$sort1, $sorttype1);
            }
                       
            $pagi_country=$countries_db;
            //print_r($pagi_country);
            $pagelimit=1;
            $staterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();                      
            if(!empty($staterow))
            {
         $pagelimit=$staterow->record_per_page_admin;
               //die();
            }
           $pagi_country = $pagi_country->paginate($pagelimit);
           $pagi_country->setPath(url(ADMINSEPARATOR.'/admin_issue_with_venue'));          
            $data['pagi_country']=$pagi_country;
            $data['useinPagiAr']=$useinPagiAr;
            $data['user_master']=$user_master;
            $data['artist_details']=$artist_details;
           return view('admin.admin_issue_with_venue.admin_issue_with_venue_list', $data);
    }
         public function view(Request $request,$id=0)
    {
            $countries_db = DB::table('resolve_dispute as rd');
            $countries_db=$countries_db->select(DB::raw('rd.id,rd.gig_name,rd.dispute_opener_id,rd.gig_id,rd.gig_unique_id,rd.dispute_opening_date,rd.dispute_type,rd.issue_description,rd.arrival,rd.arrival_time,rd.required_specifications_availability,rd.able_to_complete,rd.technical_issue,rd.receive_rider,rd.leave_early,rd.leaving_time,rd.venue_presentation'));        
            $countries_db=$countries_db->where('rd.dispute_type', "3")->get();
            //print_r($countries_db);die();
                $first_sql= DB::table('resolve_dispute')
                ->join('gig_master', 'gig_master.id', '=', 'resolve_dispute.gig_id')
                ->select('gig_master.artist_id')
                ->where('resolve_dispute.dispute_type', "3")
                ->get();
                //print_r($first_sql);die();
                $artist_details=DB::table('venue_master')->select('venue_master.creater_id','venue_master.nickname')->where('id','=',$first_sql[0]->artist_id)->get();
                //print_r($artist_details);die();
                $user_master=DB::table('user_master')->select('user_master.email')->where('id','=',$artist_details[0]->creater_id)->get();
        $pagi_country=$countries_db;
        $data['pagi_country']=$pagi_country;
        $data['user_master']=$user_master;
        $data['artist_details']=$artist_details;
        return view('admin.admin_issue_with_venue.admin_issue_with_venue_list_view', $data);
    }   
}
        ?>