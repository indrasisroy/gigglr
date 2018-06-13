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
use Cookie;


class FrontendprofileController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    
     public function index(Request $request)
    {
      
                $data=array(); 
                $data['data1']="hello";
                
                // return view('admin.logintemplate', $data);
                
                $user_id=12;
                
                //if ($request->session()->has('front_id_sess'))
                //{
                //     $user_id= $request->session()->get('front_id_sess');
                //  
                //}
                
                
               
               //$successmsgdata=$request->session()->get('front_successmsgdata_sess');
               //$errormsgdata=$request->session()->get('front_errormsgdata_sess');
                
               $data=array();
               $data['data1']="hello";
               
               //**** for message show purpose starts
               //if(!empty($successmsgdata))
               //{
               //          $data['successmsgdata']=$successmsgdata;
               //          
               //         $data['tmodata']=2000;
               //         $data['etmodata']=500;
               //         $data['sddata']=1000; 
               //         $data['hddata']=1500;
               //         $data['posclsdata']='toast-top-full-width';
               //}
               // if(!empty($errormsgdata))
               //{
               //         $data['errormsgdata']=$errormsgdata;
               //         
               //         $data['tmodata']=2000;
               //         $data['etmodata']=500;
               //         $data['sddata']=1000; 
               //         $data['hddata']=1500;
               //         $data['posclsdata']='toast-top-full-width';
               //}
               
               //**** for message show purpose ends
               
               //*** fetch data of banner starts                 
                               
                $banner_image='';$display_flag=0;            
                
                
                //*** fetch data of banner ends                
                
                //**** fetch basic info of user  starts
                
                $fetchtype='single'; $tablename="user_master";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['id']=$user_id;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
                                
                //**** fetch basic info of user  ends
                
               // echo "<pre>";  print_r($fetchuserdata); echo "</pre>";
               
               
               //**** fetch skill_master data  starts
                
                $fetchtype='multiple'; $tablename="skill_master";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['catag_type']=1;
                $wherear['parent_id']=0;
                $wherear['status']=1;
                $orderbyfield="name"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchskillmasterdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
               // echo "=fetchskillmasterdata==><pre>";  print_r($fetchskillmasterdata); echo "</pre>";
                
                $fetchskillmasterAr=array();
              
                if(!empty($fetchskillmasterdata))
                {
                        foreach( $fetchskillmasterdata as $fetchskillobj )
                        {
                                $fetchskillmasterAr[$fetchskillobj->id]=$fetchskillobj->name;
                        }
                } 
                //**** fetch skill_master data  ends
                
                
                //**** fetch user_skill_rel data  starts
                
                $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.user_id) as user_id ";
               
                $skill_user_db=DB::table('user_skill_rel as usr');

                $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
                
                $skill_user_db=$skill_user_db->where('usr.user_id', $user_id);
                $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
                
                $skill_user_db=$skill_user_db->get();
                
                //echo "==skill_db==><pre>";
                //print_r($skill_db);
                //echo "</pre>";
               
                //**** fetch user_skill_rel data  ends
                
              
                
                
                $data['banner_image']=$banner_image;
                $data['display_flag']=$display_flag;
                $data['fetchuserdata']=$fetchuserdata;
                $data['fetchskillmasterAr']=$fetchskillmasterAr;
                $data['skill_user_db']=$skill_user_db;
                
               return view('front.user.profile', $data);
    }
     
   
           
           
}