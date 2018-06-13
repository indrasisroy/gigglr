<?php
namespace App\Http\Controllers\admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;
class Admin_issue_with_booker_Controller extends Controller
{       
        public function index(Request $request )
    {
            $data=array();
            $useinPagiAr=array();           
            $srch1=addslashes(trim($request->input('srch1','')));
            $sort1=addslashes(trim($request->input('sort1','')));
            $sorttype1=addslashes(trim($request->input('sorttype1','')));
            $pages=addslashes(trim($request->input('page','')));
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
            
            //$countries_db = DB::table('resolve_dispute as rd');
            //$countries_db=$countries_db->select(DB::raw('rd.id,rd.gig_name,rd.dispute_opener_id,rd.gig_id,rd.gig_unique_id,rd.dispute_opening_date,rd.dispute_type,rd.issue_description,rd.arrival,rd.arrival_time,rd.required_specifications_availability,rd.able_to_complete,rd.technical_issue,rd.receive_rider,rd.leave_early,rd.leaving_time'));        
            //$countries_db=$countries_db->where('rd.dispute_type', "4");
            //    $first_sql= DB::table('resolve_dispute')
            //    ->join('gig_master', 'gig_master.id', '=', 'resolve_dispute.gig_id')
            //    ->select('gig_master.booker_id')
            //    ->where('resolve_dispute.dispute_type', "4")
            //    ->get();
            //
            
            $bookerQuery = "SELECT ugv.*,um1.`email` as 'booker_email',um1.`nickname` as 'booker_nickname' from(
    SELECT re_d. * , gig_m.`booker_id` , gig_m.`artist_id` , gig_m.`type_flag` , um.`nickname` as 'user_nickname' , um.`email` as 'grp_vn_art_email' , um.`nickname` as 'grp_vn_art_nickname' 
FROM `resolve_dispute` AS re_d, `gig_master` AS gig_m, `user_master` AS um
WHERE re_d.`dispute_type` = '4'
AND gig_m.`id` = re_d.`gig_id` 
AND gig_m.`type_flag` = '1'
AND um.`id` = gig_m.`artist_id` 

UNION 

	SELECT re_d. * , gig_m.`booker_id` , gig_m.`artist_id` , gig_m.`type_flag` , um.`nickname` as 'user_nickname', um.`email` as 'grp_vn_art_email' ,gr_m.`nickname` as 'grp_vn_art_nickname'
FROM `resolve_dispute` AS re_d, `gig_master` AS gig_m, `user_master` AS um, `group_master` AS gr_m
WHERE re_d.`dispute_type` = '4'
AND gig_m.`id` = re_d.`gig_id` 
AND gig_m.`type_flag` = '2'
AND um.`id` = gr_m.`creater_id` 
AND gr_m.`id` = gig_m.`artist_id` 

UNION 

	SELECT re_d. * , gig_m.`booker_id` , gig_m.`artist_id` , gig_m.`type_flag` , um.`nickname` as 'user_nickname' , um.`email` as 'grp_vn_art_email', vm.`nickname` as 'grp_vn_art_nickname'
FROM `resolve_dispute` AS re_d, `gig_master` AS gig_m, `user_master` AS um, `venue_master` AS vm
WHERE re_d.`dispute_type` = '4'
AND gig_m.`id` = re_d.`gig_id` 
AND gig_m.`type_flag` = '3'
AND um.`id` = vm.`creater_id` 
AND vm.`id` = gig_m.`artist_id`) as ugv, `user_master` AS um1 where ugv.`booker_id` = um1.`id`";
//and ugv.`grp_vn_art_nickname` LIKE '%Soumikcoder%' limit 0,2";
            
            
                //$user_master=DB::table('user_master')->select('user_master.email','user_master.nickname')->where('id','=',$first_sql[0]->booker_id)->get();
                //
            if(!empty($srch1))
            {
               //$countries_db=$countries_db->where('user_master.nickname', 'like', "%".$srch1."%");
               $bookerQuery=$bookerQuery."and ugv.`grp_vn_art_nickname` LIKE '%".$srch1."%'";
            }
            
            
            if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
            {
                  
                  //$countries_db=$countries_db->orderBy('user_master.'.$sort1, $sorttype1);
                  $bookerQuery=$bookerQuery."ORDER BY ugv.`grp_vn_art_nickname`".$sorttype1;
            }
                       
				
				
				$pagi_booker=$bookerQuery;
            
            
            //**** fetch data ends
            
            
            //***** fetch data from settings table starts            
            $pagelimit=1;
            $staterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();            
            
            if(!empty($staterow))
            {
                $pagelimit=$staterow->record_per_page_admin;
            }
            //***** fetch data from settings table ends
            
            
            
           //***** pagination code starts
            
           $pagi_booker = $pagi_booker->paginate($pagelimit);

           $pagi_booker->setPath(url(ADMINSEPARATOR.'/admin_issue_with_booker'));
           
            /*  echo $pagi_country->count();
            echo  $pagi_country->perPage();
            echo  $pagi_country->total();        
            echo "pagi=><pre>";
            print_r($pagi_booker);
            echo "</pre>";  */   
          
            //$data['pagi_skill']=$pagi_skill;
            //$data['useinPagiAr']=$useinPagiAr;
            //***** pagination code ends
					
            
         //   $staterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();                      
         //   if(!empty($staterow))
         //   {
         //$pagelimit=$staterow->record_per_page_admin;
         //
         //   }
         //   $pagelimit=2;
         //   //$pages
         //   if(!empty($pages)){
         //       $bookerQuery=$bookerQuery."limit ".($pages*2).",".$pagelimit;
         //   }else{
         //       $bookerQuery=$bookerQuery."limit 0,".$pagelimit;
         //   }
         //   $pagi_country=DB::select( DB::raw($bookerQuery));
         //   echo "<pre>";print_r($pagi_country);die;
         //   
         //  //$pagi_country = $pagi_country->paginate($pagelimit);
         //  //echo "<pre>";print_r($pagi_country);die;
         //  $pagi_country->setPath(url(ADMINSEPARATOR.'/admin_issue_with_booker'));
		 
		 
            $data['pagi_country']=$pagi_booker;
            $data['useinPagiAr']=$useinPagiAr;
            //$data['first_sql']=$first_sql;
            //$data['user_master']=$user_master;
            //echo "<pre>";print_r($data);die;
           return view('admin.admin_issue_with_booker.admin_issue_with_booker_list', $data);
    }
         public function view(Request $request,$id=0)
    {
            $countries_db = DB::table('resolve_dispute as rd');
            $countries_db=$countries_db->select(DB::raw('rd.id,rd.gig_name,rd.dispute_opener_id,rd.gig_id,rd.gig_unique_id,rd.dispute_opening_date,rd.dispute_type,rd.issue_description,rd.arrival,rd.arrival_time,rd.required_specifications_availability,rd.able_to_complete,rd.technical_issue,rd.receive_rider,rd.leave_early,rd.leaving_time'));        
            $countries_db=$countries_db->where('rd.dispute_type', "4")->get();
                $first_sql= DB::table('resolve_dispute')
                ->join('gig_master', 'gig_master.id', '=', 'resolve_dispute.gig_id')
                ->select('gig_master.booker_id')
                ->where('resolve_dispute.dispute_type', "4")
                ->get();
                $user_master=DB::table('user_master')->select('user_master.email','user_master.nickname')->where('id','=',$first_sql[0]->booker_id)->get();
        $pagi_country=$countries_db;
        $data['pagi_country']=$pagi_country;
        $data['first_sql']=$first_sql;
        $data['user_master']=$user_master;
        return view('admin.admin_issue_with_booker.admin_issue_with_booker_list_view', $data);
    }   
}
        ?>