<?php

namespace App\Http\Controllers\admin;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//use App\User
use Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;

class AdminsubscriptionController extends Controller
{
    
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    
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
        $data['data1']="hello";
        $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
        $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
        if(!empty($successmsgdata))
        {
            $data['successmsgdata']=$successmsgdata;
        }
        if(!empty($errormsgdata))
        {
            $data['errormsgdata']=$errormsgdata;               
        }
        //**** fetch data starts
        $users_db = DB::table('subscription as ss');
        $users_db=$users_db->select(DB::raw('ss.id,ss.email,ss.create_date,ss.deactivate_date,ss.status'));
        if(!empty($srch1))
        {
           $users_db=$users_db->where('ss.email', 'like', "%".$srch1."%");           
        }
        if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
        {    
              $users_db=$users_db->orderBy('ss.'.$sort1, $sorttype1);
        }
        $pagi_user=$users_db;    
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
        //$pagelimit=2;
        $pagi_user = $pagi_user->paginate($pagelimit);
        $pagi_user->setPath(url(ADMINSEPARATOR.'/subscription'));
        $data['pagi_user']=$pagi_user;
        $data['useinPagiAr']=$useinPagiAr;
        //***** pagination code ends       
        return view('admin.subscription.subscriberlist', $data);
    }

    public function delsubscription(Request $request,$uid=0)
    {
        if(!empty($uid))
        {
            DB::table('subscription')->where('id',$uid)->delete();
            $request->session()->flash('admin_successmsgdata_sess', 'User successfully deleted');
        }
        return redirect(ADMINSEPARATOR.'/subscription');
    }
    
    public function statuschangesubscription(Request $request)
    {   
        $statuschange = $request->input('statuschange',0);
        $userid = $request->input('userid',0);
        $respAr=array();
        $flagdata=0;
        
        if(!empty($userid) && ($userid>0) && in_array($statuschange,array(0,1)))
        {
            $dataUpdate=array();
            $today=date('Y-m-d H:i:s');
            
            //*** update status starts 
            if($statuschange==1){
                $deactvdt="------------------------------";
                $dataUpdate['create_date']=$today;
                $dataUpdate['deactivate_date']="0000-00-00 00:00:00";
                $dataUpdate['status']=$statuschange;
                $updstaus=DB::table('subscription')
                    ->where('id', $userid)
                    ->update($dataUpdate);
            }
            else{
                $deactvdt=date('d-m-Y H:i A',strtotime($today));
                $dataUpdate['deactivate_date']=$today;
                $dataUpdate['status']=$statuschange;
                $updstaus=DB::table('subscription')
                    ->where('id', $userid)
                    ->update($dataUpdate);
            }
            //*** update status ends
            
            if(!empty($updstaus))
            {
                $flagdata=1;
            }
        } 
        $respAr['flag']=$flagdata;
        $respAr['iddata']=$userid;
        $respAr['deactvdt']=$deactvdt;
        echo  json_encode($respAr);
    }

    public function statuschangesubscriptionmail(Request $request)
    {
        $statuschange = $request->input('statuschange',0);
        $userid = $request->input('iddata',0);
        
        $tomail = DB::table('subscription')
            ->select(DB::raw('email'))
            ->where('id', $userid)
            ->get();
        $emailid=$tomail[0]->email;
        
        $userssel = DB::table('settings')
            ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
            ->where('id', 1)
            ->get();
        $sitenm=$userssel[0]->site_name;
        $emailfrom=$userssel[0]->email_from;
        $copyrightyr=$userssel[0]->copyright_year;
        $Imgologo=$userssel[0]->email_template_logo_image;
        $bsurl = url('/');
        // $logoIMG = asset('upload/settings-image/source-file/'.$Imgologo);
        $logoIMG = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$Imgologo;
        
        $activation_link = route('frontendunsubscription', ['id'=>base64_encode($userid)]);
        $activation_link_text = 'Click this link to unsubscription : <a href="'.$activation_link.'">Unsubscription Link </a>';
        $deactivationlink = $activation_link_text;
        
        //**********Email Send Code Starts here    
        //*********Helper Function Starts here
        
        $replacefrom =array('{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{DEACTIVATION_LINK}");
        $replaceto =array($sitenm,$copyrightyr,$bsurl,$logoIMG,$deactivationlink);
        
        if($statuschange==1)
        {
            mailsnd($Temid=9,$replacefrom,$replaceto,$emailid);
        }
        else{
            mailsnd($Temid=10,$replacefrom,$replaceto,$emailid);
        }
        
        //*********Helper Function Ends here
        //**********Email Send Code Ends here
    }
}