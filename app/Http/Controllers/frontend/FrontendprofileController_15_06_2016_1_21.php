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
use Response;

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
            
                        $uu = $request->segment(2);
                        $query = DB::table('user_master')->select('user_uniqueid')->get();
                        $user_id = 0;
                        $user_single = DB::table('user_master')->where('user_uniqueid',$uu)->first();
                        if($user_single)
                        {
                                    $user_id = $user_single->id;
                        }
                        else
                        {
                                     $user_id = 0;
                        }

            
                        if($user_id <2 || empty($user_single) || $user_id ==0)
                        {
                                    echo "wrong user";exit();
                        }
                            $data=array(); 
                            $data['data1']="hello";
                       
                           //*************** fetch data of banner starts=======================*************
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
               
                $fetchskillmasterAr=array();
                $fetchskillmasterAr['']="Category for Request";
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
                
                //*******************************FETCH COUNTRY DATA STARTS HERE 28-05-2016
                $country_db = DB::table('location_country')->where('published','1')->get();
               // $country_result = $country_qry;
                        $countryidAr=array();
                        $countryidAr['']="Select a country";
                        if(!empty($country_db))
                        {
                                foreach($country_db as $country_obj)
                                {
                                        $countryidAr[$country_obj->id]=stripslashes($country_obj->country_name);
                                }
                                
                        }
               
                //****************FETCH ALL CATEGORY ENDS HERE 30-05-2016
                
                
                //****************
                //***************FETCH USER IMAGE STARTS HERE
                $usr_img = DB::table('user_master_img')->where('default_status','1')->where('user_id',$user_id)->get();
                 
               //***************FETCH USER IMAGE ENDS HERE
               
               //********Fetch user review starts here
               
               $userstesti = DB::table('event_review as erv')
                    ->join('user_master as um', 'erv.booker_id', '=', 'um.id')
                     ->join('bookers_review as brv', 'erv.id', '=', 'brv.event_review_id')
                                        ->leftJoin('user_master_img as umi', function ($join)
                                        {
                                        $join->on('erv.booker_id', '=', 'umi.user_id')
                                        ->where('umi.default_status','=','1');
                                        })
                                       
                    ->select('erv.*', 'um.first_name', 'um.username','um.nickname','um.city','umi.user_id','umi.image_name','umi.default_status','brv.puntuality','brv.performence','brv.presentation')
                    ->where('erv.artist_id',$user_id)
                    ->get();
                   
                    //echo "<pre>";
                    //print_r($userstesti);
                    //echo "</pre>";die;
               //********Fetch user review ends here
              //*************presskit data starts here
              $presskit = DB::table('user_presskit')->where('user_id',$user_id)->first();
              //*************presskit data ends here
              
              ////***************sum of ratings starts here
              //$total = DB::table('users')->where()->sum('puntuality');
              ////**************sum of ratings ends here
                
                
                $data['banner_image']=$banner_image;
                $data['display_flag']=$display_flag;
                $data['fetchuserdata']=$fetchuserdata;
                $data['fetchskillmasterAr']=$fetchskillmasterAr;
                $data['skill_user_db']=$skill_user_db;
                $data['country_result']=$countryidAr;
                $data['usr_img']=$usr_img;//usrIMG
                
                $data['user_testi']=$userstesti;//usrIMG
                $data['presskit']=$presskit;//usrIMG
               return view('front.user.profile', $data);
    }
    public function getstate(Request $request)
    {
          $country =  $request->input('countryid');
          $stateres = DB::table('location_state')->where('country_id',$country)->get();
          //echo "<pre>";
          //print_r($stateres);
          //echo "</pre>";
          //echo $stateres;
          
           $statetypeidAr=array();
           
            if(!empty($stateres))
            {
                    foreach($stateres as $stateres)
                    {
                            $statetypeidAr[]=array('id'=>$stateres->id,'name'=>stripslashes($stateres->state_name));
                    }
                    
            }
        
          $respAr=$statetypeidAr;
          
          // $respAr['flag']=$flagdata;
          // $respAr['iddata']=$skillid;
          //$respAr['skillid']=$users;
          
          
          echo  json_encode($respAr);
          
    }
    
    public function getgenere(Request $request)
    {
            $categoryId = $request->input('categoryID');
            if($categoryId > 0)
            {
                        $getGenere = DB::table('skill_master')->where('parent_id',$categoryId)->where('status','1')->get();
            }
            $generetypeidAr=array();
           
            if(!empty($getGenere))
            {
                    foreach($getGenere as $getGenereobj)
                    {
                            $generetypeidAr[]=array('id'=>$getGenereobj->id,'name'=>stripslashes($getGenereobj->name));
                    }
                    //$generetypeidAr[]=array('flag'=>'1');
            }
        
          $respAr=$generetypeidAr;
          //echo "<pre>";
          //print_r($respAr);
          //echo "</pre>";die;
          echo  json_encode($respAr);
            
    }
    
    //*************download ptresskit starts here
    
    public function downloadpresskit($file_name)
    {
                   // echo $file_name;die;
                    $filennmdownload = base64_decode($file_name);
                   // echo $filennm;die;
            //********its working for single file
            $download_path = ( public_path() . '/upload/press-kit/source-file/' . $filennmdownload );
            return( Response::download( $download_path ) );
          
    }
   //*************download ptresskit starts here
           
           
}