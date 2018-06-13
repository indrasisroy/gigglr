<?php

namespace App\Http\Controllers\admin;

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

class AdmincontactusController extends Controller
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
            
                $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
                $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
            
                if(!empty($successmsgdata)){
                        $data['successmsgdata']=$successmsgdata;
                }
                
                if(!empty($errormsgdata)){
                        $data['errormsgdata']=$errormsgdata;               
                }
                
                //**** fetch data starts
            
                $contactus_db = DB::table('contact_us as cu');
                $contactus_db=$contactus_db->join('contactus_category as cc', 'cu.contact_category_id', '=', 'cc.id');
                $contactus_db=$contactus_db->select(DB::raw('cu.id,cu.contact_category_id,cu.contact_name,cu.contact_email,cu.contact_phone,cu.contact_message,cu.create_date,cc.category_name'));
                
                if(!empty($srch1))
                {
                        $contactus_db=$contactus_db->where('cu.contact_email', 'like', "%".$srch1."%");
                        $contactus_db=$contactus_db->orWhere('cu.contact_name', 'like', "%".$srch1."%");
                }
            
                if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
                {
                        $contactus_db=$contactus_db->orderBy('cu.'.$sort1, $sorttype1);
                }
                
                $pagi_contactus=$contactus_db;
                
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
            
                $pagi_contactus = $pagi_contactus->paginate($pagelimit);

                $pagi_contactus->setPath(url(ADMINSEPARATOR.'/contactus'));
           
                /*  echo $pagi_country->count();
                echo  $pagi_country->perPage();
                echo  $pagi_country->total();           
                echo "pagi=><pre>";
                print_r($pagi_country);
                echo "</pre>"; exit(); */
          
                $data['pagi_contactus']=$pagi_contactus;
                $data['useinPagiAr']=$useinPagiAr;
                
                //***** pagination code ends
            
                return view('admin.contactus.contactuslist', $data);
        }
       
        public function delcontact(Request $request,$id=0)
        {
                if(empty($id))
                {
                        return redirect(ADMINSEPARATOR.'/contactus');
                }
                $ar=DB::table('contact_us')->where('id', '=', $id)->delete();
                if($ar>0)
                {
                        $request->session()->flash('admin_successmsgdata_sess', 'Data has been deleted successfully.');  
                }
                return redirect(ADMINSEPARATOR.'/contactus');
        }
        
}

?>