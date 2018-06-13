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
use View;
use Illuminate\Routing\Route;

//use Image;

use App\Customlibrary\Imageuploadlib;

class FrontenduserController extends Controller
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
                
                $user_id=0;
                
                if ($request->session()->has('front_id_sess'))
                {
                    $user_id= $request->session()->get('front_id_sess');
                  
                }
                
               
               $successmsgdata=$request->session()->get('front_successmsgdata_sess');
               $errormsgdata=$request->session()->get('front_errormsgdata_sess');
                
               $data=array();
               $data['data1']="hello";
               
               //**** for message show purpose starts
               if(!empty($successmsgdata))
               {
                         $data['successmsgdata']=$successmsgdata;
                         
                        $data['tmodata']=2000;
                        $data['etmodata']=500;
                        $data['sddata']=1000; 
                        $data['hddata']=1500;
                        $data['posclsdata']='toast-top-full-width';
               }
                if(!empty($errormsgdata))
               {
                        $data['errormsgdata']=$errormsgdata;
                        
                        $data['tmodata']=2000;
                        $data['etmodata']=500;
                        $data['sddata']=1000; 
                        $data['hddata']=1500;
                        $data['posclsdata']='toast-top-full-width';
               }
               
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
                
                
                //*** fetch this user related images starts                              
                
                  $selectstr=" umtb.* ";
                 
                  $user_master_img_db=DB::table('user_master_img as umtb');              
                  $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                  $user_master_img_db=$user_master_img_db->where('umtb.user_id', $user_id);
                  $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                  $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                  $user_master_img_db=$user_master_img_db->get();                                             
                              
                  //*** fetch this user related images ends
                
                  $data['banner_image']=$banner_image;
                  $data['display_flag']=$display_flag;
                  $data['fetchuserdata']=$fetchuserdata;
                  $data['fetchskillmasterAr']=$fetchskillmasterAr;
                  $data['skill_user_db']=$skill_user_db;
                  $data['user_master_img_db']=$user_master_img_db;
                
                  return view('front.user.editprofile', $data);
    }
    
    public function editprofileajax(Request $request)
    {
             $data=array();
                $data['data1']="hello";
                
                // return view('admin.logintemplate', $data);
                
                $user_id=0;
                
                if ($request->session()->has('front_id_sess'))
                {
                    $user_id= $request->session()->get('front_id_sess');
                  
                }
                
               
               $successmsgdata=$request->session()->get('front_successmsgdata_sess');
               $errormsgdata=$request->session()->get('front_errormsgdata_sess');
                
               $data=array();
               $data['data1']="hello";
               
               //**** for message show purpose starts
               if(!empty($successmsgdata))
               {
                         $data['successmsgdata']=$successmsgdata;
                         
                        $data['tmodata']=2000;
                        $data['etmodata']=500;
                        $data['sddata']=1000; 
                        $data['hddata']=1500;
                        $data['posclsdata']='toast-top-full-width';
               }
                if(!empty($errormsgdata))
               {
                        $data['errormsgdata']=$errormsgdata;
                        
                        $data['tmodata']=2000;
                        $data['etmodata']=500;
                        $data['sddata']=1000; 
                        $data['hddata']=1500;
                        $data['posclsdata']='toast-top-full-width';
               }
               
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
                
                //$fetchtype='multiple'; $tablename="skill_master";
                //$fieldnames=" * ";
                //$wherear=array();
                //$wherear['catag_type']=1;
                //$wherear['parent_id']=0;
                //$wherear['status']=1;
                //$orderbyfield="name"; $orderbytype="asc";
                //$limitstart=0;$limitend=0;                
                //
                //$fetchskillmasterdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
               // echo "=fetchskillmasterdata==><pre>";  print_r($fetchskillmasterdata); echo "</pre>";
               
               $parentskill_db = DB::table('skill_master');
                $parentskill_db=$parentskill_db->where('status',1);
                $parentskill_db=$parentskill_db->where('parent_id',0);
                $parentskill_db=$parentskill_db->whereRaw(" FIND_IN_SET('1',`catag_type`) ");
                $parentskill_db=$parentskill_db->orderBy('id', 'asc');
                $parentskill_db=$parentskill_db->get();
                
                $fetchskillmasterdata=$parentskill_db;
                
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
                
                
                //*** fetch this user related images starts                              
                
                  $selectstr=" umtb.* ";
                 
                  $user_master_img_db=DB::table('user_master_img as umtb');              
                  $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                  $user_master_img_db=$user_master_img_db->where('umtb.user_id', $user_id);
                  $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                  $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                  $user_master_img_db=$user_master_img_db->get();                                             
                              
                  //*** fetch this user related images ends
                
                  $data['banner_image']=$banner_image;
                  $data['display_flag']=$display_flag;
                  $data['fetchuserdata']=$fetchuserdata;
                  $data['fetchskillmasterAr']=$fetchskillmasterAr;
                  $data['skill_user_db']=$skill_user_db;
                  $data['user_master_img_db']=$user_master_img_db;
                  
                  //return view('front.user.editprofile', $data);
            
                  $view_obj = View::make('front.user.editprofileajax',$data);
                  $ep_view_contents = $view_obj->render();
                  
                  $resp_arr=array();
                  $resp_arr['ep_contents']=$ep_view_contents;
                  
                  echo json_encode($resp_arr);
            
    }
     
           
       public function saveuserurls(Request $request)
    {
          
            
            $controlname = addslashes(trim($request->input('controlname','')));
            $controlnamedata = addslashes(trim($request->input('controlnamedata','')));
           
            $id=0;
            $chkvalid=$this->checksaveuserurls($request,$id);
            
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
           if($chkvalid===true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $userid=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $userid=$request->session()->get('front_id_sess'); // get session
                         
                        
                        }
                        
                       
                        
                        //*** update user_master table starts
                        
                        $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),$controlname => $controlnamedata]
                        );
                        
                        //*** update user_master table ends
                        
                        if(!empty($chkupd))
                        {
                                       $flag_id=1;                          
                                       
                               
                        }
                
                //*** save data of user ends
           }
           else
           {
                                   
                  $error_message = $chkvalid->messages();
                  
           }
           
          // return redirect(ADMINSEPARATOR.'/banner');
          
          
          
         $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
          
         // echo "<pre>"; print_r($error_msgAr);echo "</pre>";
          
         
         
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          
          echo json_encode($responseAr);
          
          
    }
           
    public function checksaveuserurls($request,$id=0)
           {
                $controlname = addslashes(trim($request->input('controlname','')));
                $controlmsg="";
                
                         if ($controlname=="facebook_url")
						{
							                           
							 $controlmsg="The facebook url ";
						}
                        elseif ($controlname=="soundcloud_url")
						{
							                           
							  $controlmsg="The soundcloud url ";
						}
                        elseif ($controlname=="residentadvisor_url")
						{
							                           
                                $controlmsg="The residentadvisor url ";
						}
                         elseif ($controlname=="twitter_url")
						{
							     $controlmsg="The twitter url ";                      
							 
						}
                        elseif ($controlname=="youtube_url")
						{
							    $controlmsg="The youtube url ";                       
							 
						}
                        elseif ($controlname=="instagram_url")
						{
							     $controlmsg="The instagram url ";                     
							 
						}
                
              
                    $validator = Validator::make($request->all(), [
                   
                    "controlnamedata" => "required|url",
                    
                    
                    ],[
                       "controlnamedata.required" => $controlmsg." is required", 
                       "controlnamedata.url" => $controlmsg." invalid url",
                     
                       
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                
                  
                  
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                  return true;
                    
        
           }
           
         //*************************** save user_description starts
         
          public function saveuserdesc(Request $request)
        {
          
            
            $user_description = addslashes(trim($request->input('user_description','')));
            
           
            $id=0;
            $chkvalid=$this->checksaveuserdesc($request,$id);
            
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
           if($chkvalid===true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $userid=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $userid=$request->session()->get('front_id_sess'); // get session                       
                        
                        }
                        
                        //*** update user_master table starts
                        
                        $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),'user_description' => $user_description]
                        );
                        
                        //*** update user_master table ends
                        
                        if(!empty($chkupd))
                        {
                                       $flag_id=1;                          
                                       
                               
                        }
                
                //*** save data of user ends
           }
           else
           {
                                   
                  $error_message = $chkvalid->messages();
                  
           }
           
          // return redirect(ADMINSEPARATOR.'/banner');
          
          
          
         $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
          
         // echo "<pre>"; print_r($error_msgAr);echo "</pre>";
         
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          echo json_encode($responseAr);
          
          
    }
           
    public function checksaveuserdesc($request,$id=0)
           {
                $user_description = addslashes(trim($request->input('user_description','')));
                $controlmsg="";
                
                        
              
                    $validator = Validator::make($request->all(), [
                   
                    "user_description" => "required"
                    
                    
                    ],[
                       "user_description.required" => " Description is required"                  
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                
                  
                  
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                  return true;
                    
        
           }
         
         //************************** save user_description ends
         
      //*************************** save saveusername starts
         
          public function saveusername(Request $request)
        {
          
            
            $nickname = addslashes(trim($request->input('nickname','')));
            
           
            $id=0;
            $chkvalid=$this->checksaveusername($request,$id);
            
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
           if($chkvalid===true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $userid=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $userid=$request->session()->get('front_id_sess'); // get session                       
                        
                        }
                        
                        //*** update user_master table starts
                        
                        $nickname_lower=strtolower($nickname);
                        $slugged_arr=array($nickname_lower,$userid);
                        $slugged_str=implode(" ",$slugged_arr);
                        $slugged_id=str_slug($slugged_str,"-");
                        
                        $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),'nickname' => $nickname, 'seo_name' => $slugged_id]
                        );
                        
                        //*** update user_master table ends
                        
                        if(!empty($chkupd))
                        {
                                       $flag_id=1;                          
                                       
                               
                        }
                
                //*** save data of user ends
           }
           else
           {
                                   
                  $error_message = $chkvalid->messages();
                  
           }
           
          // return redirect(ADMINSEPARATOR.'/banner');
          
          
          
         $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
          
         // echo "<pre>"; print_r($error_msgAr);echo "</pre>";
         
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          echo json_encode($responseAr);
          
          
    }
           
    public function checksaveusername($request,$id=0)
           {
                $nickname = addslashes(trim($request->input('nickname','')));
                $controlmsg="";
                
                        
              
                $validator = Validator::make($request->all(), [
               
                "nickname" => "required"         
                
                ],[
                   "nickname.required" => " Name is required"                  
                   
                ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                return true;
                    
        
           }
         
         //************************** save saveusername ends
         
         //********* populatesubskill starts
         
         
         function populatesubskill(Request $request)
         {
                //**** fetch skill starts
                
                $parent_id = $request->input('parent_id');
                $catag_type =$request->input('catag_type');
                
                $user_id=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session                       
                        
                        }
                
                $fetchtype='multiple'; $tablename="skill_master";
                $fieldnames=" * ";
                $wherear=array();
                //$wherear['catag_type']=$catag_type;
                $wherear['parent_id']=$parent_id;
                $wherear['status']=1;
                $orderbyfield="name"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                               
                $respar=array();
                //$wherenortinstr=" id NOT IN ( select skill_sub_id from user_skill_rel where user_id='".$user_id."' ) ";
	
                $tab_db = DB::table($tablename);
                $tab_db=$tab_db->select(DB::raw($fieldnames));
                $tab_db=$tab_db->where($wherear);
                $tab_db=$tab_db->whereRaw(" FIND_IN_SET('1',`catag_type`) ");
                $tab_db=$tab_db->orderBy($orderbyfield, $orderbytype);
                
                if(!empty($limitend))
                {
                    $tab_db = $tab_db->skip($limitstart)->take($limitend);
                }
                
                $tab_db=$tab_db->get();
             
                if(!empty($tab_db))
                {
                    $respar=$tab_db;
                    
                }
               
               $fetchskillmasterdata=$respar;
               
               // echo "=fetchskillmasterdata==><pre>";  print_r($fetchskillmasterdata); echo "</pre>";
                
                $fetchskillmasterAr=array();
               
                if(!empty($fetchskillmasterdata))
                {
                        foreach( $fetchskillmasterdata as $fetchskillobj )
                        {
                                $fetchskillmasterAr[]=array('id'=>$fetchskillobj->id,'name'=>$fetchskillobj->name);
                        }
                }
                
                echo json_encode($fetchskillmasterAr);
                
                //**** fetch skill  ends
         }
         
         
         //********* populatesubskill ends
         
          //*************************** save skill data starts
         
          public function saveskilldata(Request $request)
        {
          
            
            $catag_type_id= addslashes(trim($request->input('catag_type_id','')));
            $skill_id= addslashes(trim($request->input('skill_id','')));
            $skill_sub_id= addslashes(trim($request->input('skill_sub_id','')));
            
            
            $id=0;
            $chkvalid=$this->checksaveskilldata($request);
            //$chkvalid=true;
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
           if($chkvalid===true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $user_id=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session                       
                        
                        }
                        
                        //*** update user_master table starts
                        
                        $insert_skill_array=array();
                        $insert_skill_array['catag_type_id']=$catag_type_id;
                        $insert_skill_array['skill_id']=$skill_id;
                        $insert_skill_array['skill_sub_id']=$skill_sub_id;
                        $insert_skill_array['user_id']=$user_id;
                        $insert_skill_array['create_date']=date('Y-m-d H:i:s');
                         
                        $chkupd= DB::table('user_skill_rel')->insert($insert_skill_array );
                         $last_insert_id=DB::getPdo()->lastInsertId();

                        
                        //*** update user_master table ends
                        
                        if(!empty($last_insert_id))
                        {
                                       $flag_id=1;                          
                                       
                               
                        }
                
                //*** save data of user ends
           }
           else
           {
                                   
                  $error_message = $chkvalid->messages();
                  
           }
           
          
          
          
          
         $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
          
         // echo "<pre>"; print_r($error_msgAr);echo "</pre>";
         
         
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          echo json_encode($responseAr);
          
          
    }
           
    
         
        //************************** save skill data ends
        
        public function checksaveskilldata($request)
           {
                $user_id=0;
                if ($request->session()->has('front_id_sess'))
                {
                        $user_id=$request->session()->get('front_id_sess'); // get session                       
                
                }
                $controlmsg="";
                
                        
              
                $validator = Validator::make($request->all(), [
               
                "skill_sub_id" => "required"         
                
                ],[
                   "skill_sub_id.required" => " Sub skill is required"                  
                   
                ]);
                    
                        $userData=array();
                        $userData['request']=$request;
                        
                        $validator->after(function($validator)  use ($userData)  {
                                    $request=$userData['request'];
                                    //***** here
                                    $validaterepeatitionchk=$this->chkrepeatitionvalid($request);
                                    if (!empty($validaterepeatitionchk))
                                    {
                                                $validator->errors()->add('skill_sub_id', $validaterepeatitionchk);
                                    }
                                    //***** here
                        });
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                
                if ($validator->fails())
                {
                    return $validator;
                   
                   //return false;
                   
                }
                    
                    
                return true;
                    
        
           }
           
            public function chkrepeatitionvalid($request)
            {
                        $user_id=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session
                        }
                        
                        $skill_sub_id= addslashes(trim($request->input('skill_sub_id','')));
                        
                        $errorMsg=array();
        
                        $user_skill_rel_db = DB::table('user_skill_rel as sr');
                        $user_skill_rel_db=$user_skill_rel_db->select(DB::raw('sr.id'));
                        $user_skill_rel_db=$user_skill_rel_db->where('sr.user_id', $user_id);
                        $user_skill_rel_db=$user_skill_rel_db->where('sr.skill_sub_id', $skill_sub_id);
                        $user_skill_rel_db=$user_skill_rel_db->first();
                        
                        if(!empty($user_skill_rel_db))
                        {
                                    $errorMsg[]=" This skill is already used ";
                        }
                        
                        $errorMsgStr='';
                        if(!empty($errorMsg))
                        {
                                    foreach($errorMsg as $errorMsgData)
                                    {
                                                $errorMsgStr.=$errorMsgData;
                                    }
                        }
                        
                        $responseAr=array();
                        $responseAr['errormsgs']=$errorMsgStr;
                        
                       // echo "==errorMsgStr=>".$errorMsgStr;
                         
                        return $errorMsgStr;
            }
           
           
     //*************************** delete skill data starts
         
          public function deletemyskill(Request $request)
        {
          
            
           
            $skill_sub_id= addslashes(trim($request->input('skill_sub_id','')));
            
            
            $id=0;
            //$chkvalid=$this->checksaveskilldata($request,$id);
            $chkvalid=true;
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
           if($chkvalid===true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $user_id=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session                       
                        
                        }
                        
                        //*** update user_master table starts
                        
                        $where_del_array=array();
                        
                        $where_del_array['skill_sub_id']=$skill_sub_id;
                        $where_del_array['user_id']=$user_id;
                        
                         
                        $chkupd= DB::table('user_skill_rel')->where($where_del_array )->delete();
                         

                        
                        //*** update user_master table ends
                        
                        if(!empty($chkupd))
                        {
                                       $flag_id=1;                          
                                       
                               
                        }
                
                //*** save data of user ends
           }
           else
           {
                                   
                  //$error_message = $chkvalid->messages();
                  
           }
           
          
          
          
          
         $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
          
         // echo "<pre>"; print_r($error_msgAr);echo "</pre>";
         
          $responseAr['flag_id']=$flag_id;
          $responseAr['error_message']=$error_msgAr;
          // $responseAr['tt']=$error_message->first_name;
         
          echo json_encode($responseAr);
          
          
    }
           
     //*************************** upload user image starts*************
         
          public function userimagesave(Request $request)
        {
          
            
           
           //echo "<pre>"; print_r($_FILES);echo "</pre>";
           
           
            $id=0;
            $chkvalidimage=$this->fileisinvalid($request,$id);
              
            $err_resp_msg=''; $respflg=0; $uploadedsuccnames=array(); $user_master_img_db=array();
            $slider_contents=''; $default_image_name='';
              
            $errormsgs=$chkvalidimage['errormsgs'];
            $errfileAr=$chkvalidimage['errfileAr'];
            $totalfileposted=$chkvalidimage['totalfileposted'];
              
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
           
                  //**** image code starts
                       
                       
                       $allowedFileExtAr=array();
                       $allowedFileExtAr[]="jpg";
                       $allowedFileExtAr[]="jpeg";
                       $allowedFileExtAr[]="png";
                       
                       $filecontrolname="image_name";
                       
                      
                       $allowedFileExtSizeAr=array();
                       $allowedFileExtSizeAr['jpg']=(5*1024*1024);
                       $allowedFileExtSizeAr['jpeg']=(5*1024*1024);
                       $allowedFileExtSizeAr['png']=(5*1024*1024);
                       
                       
                       
                       //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                       $allowedFileResolAr=array();
                       
                       $allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
                       $allowedFileResolAr['jpg']=array('min_width'=>537,'min_height'=>507);
                       $allowedFileResolAr['png']=array('min_width'=>537,'min_height'=>507);
                       $func="uploadfile";//validatefile/uploadfile
                       
                       
                       $destinationsourcePath=public_path()."/upload/userimage/source-file/";                         
                      
                       $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath,$errfileAr) ;
                       
                       
                         //echo "==Imcommonpath=>".$Imcommonpath;
                         //echo "==chkimg1==><pre>";
                         //print_r($chkimgresp);
                         //echo "</pre>";  //exit();
                   
                       if(!empty($chkimgresp))
                       {
                               $errormsgs='';  $fileuploadednames=array();
                               
                               if(array_key_exists('errormsgs',$chkimgresp))
                               {
                                       $errormsgs=$chkimgresp['errormsgs'];
                               }
                               
                               if(array_key_exists('fileuploadednames',$chkimgresp))
                               {
                                       $fileuploadednames=$chkimgresp['fileuploadednames'];
                               }
                               
                               
                               $singleimagename='';$thumbfileName='';
                               
                               if(!empty($fileuploadednames))
                               {
                                       $destinationcommonPath=public_path()."/upload/userimage/";
                                       
                                       foreach($fileuploadednames as $fileuploadednameAr)
                                       {
                                             
                                              $thumbfileName=$fileuploadednameAr['filenamedata'];
                                               $sourcepathwithimage=$fileuploadednameAr['fileuploadedpath'].$thumbfileName;
                                               
                                                $uploadedsuccnames[]=$thumbfileName;
                                               
                                              
                                               $destinationfilewithPath1=$destinationcommonPath."thumb-big/".$thumbfileName;
                                              //  echo "==destinationfilewithPath1==>". $destinationfilewithPath1; exit();
                                               $width=537;$height=0;//$height=507;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath1,$width,$height);
                                               
                                               $destinationfilewithPath2=$destinationcommonPath."thumb-medium/".$thumbfileName;
                                               $width=208;$height=0;//$height=201;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath2,$width,$height);
                                               
                                               $destinationfilewithPath3=$destinationcommonPath."thumb-small/".$thumbfileName;
                                               $width=52;$height=52;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath3,$width,$height);
                              
                                      
                                      
                                       }
                                       
                                      $singleimagename=$thumbfileName;
                                       
                               }
                               
                      
                       
                       }
                       
                       //**** image code ends
                       
                       
                       //*****  insert into image table starts
                       
                       //$uploadedsuccnames
                       
                       if(!empty($uploadedsuccnames))
                       {
                              $user_id=0;
                              if ($request->session()->has('front_id_sess'))
                              {
                                      $user_id=$request->session()->get('front_id_sess'); // get session                       
                              
                              }
                              
                              
                        
                              foreach($uploadedsuccnames as $user_image_name)
                              {
                                    $default_status=0;
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 starts
                                          $selectstr=" umtb.* ";
                                          
                                          $user_master_img_db=DB::table('user_master_img as umtb');              
                                          $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                                          $user_master_img_db=$user_master_img_db->where('umtb.user_id', $user_id);
                                          $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                                          $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                                          $user_master_img_db=$user_master_img_db->get();
                                          
                                          if(!empty($user_master_img_db))
                                          {
                                                $default_status=0;
                                          }
                                          else
                                          {
                                                $default_status=1;
                                          }
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 ends
                                    
                                               
                                    $user_img_array=array();
                                  
                                    $user_img_array['default_status']=$default_status;
                                    $user_img_array['image_name']=addslashes($user_image_name);
                                    $user_img_array['user_id']=$user_id;
                                    $user_img_array['create_date']=date('Y-m-d H:i:s');
                                    $user_img_array['modified_date']=date('Y-m-d H:i:s'); 
                                    $chkupd= DB::table('user_master_img')->insert($user_img_array );
                                    $last_insert_id=DB::getPdo()->lastInsertId();
                                    
                                    //***** update other image of this user to 0 starts
                                    
                                    //$updtusrmstr= DB::table('user_master_img');
                                    //$updtusrmstr= $updtusrmstr->where('id',"<>",$last_insert_id) ;
                                    //$updtusrmstr= $updtusrmstr->where('user_id',$user_id) ;
                                    //$updtusrmstr=$updtusrmstr->update(
                                    //['default_status' =>0]
                                    //);
                                    
                                    //***** update other image of this user to 0 ends
                                    
                                    
                              }
                              
                              //*** fetch this user related images starts
                              
                
                              $selectstr=" umtb.* ";
                             
                              $user_master_img_db=DB::table('user_master_img as umtb');              
                              $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                              $user_master_img_db=$user_master_img_db->where('umtb.user_id', $user_id);
                              $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                              $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                              $user_master_img_db=$user_master_img_db->get();
                              
                              if(!empty($user_master_img_db))
                              {
                                    
                                     $default_image_name= $user_master_img_db[0]->image_name;       
                              }
                              
                              //*** fetch this user related images ends
                              
                              $dataresp=array();
                              $view_obj = View::make('front.user.editprofilesilder', array("user_master_img_db"=>$user_master_img_db));
                              $slider_contents = $view_obj->render();  
                              
                              
                       }
                       
                       
                       //*****  insert into image table ends
                       
                       
            
            }
            else
            {
                   if(!empty($id))
                        {
                              
                              //return redirect(ADMINSEPARATOR.'/banneradd/'.$id)
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                             $err_resp_msg= $errormsgs;
                              
                        }
                        else
                        {
                              //return redirect(ADMINSEPARATOR.'/banneradd')
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                                $err_resp_msg= $errormsgs;
                        }
            }
            
            
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
                  $respflg=1;
              }
            
            
            
            
            $respAr=array();
            $respAr['flag']=$respflg;
            $respAr['errorespmsg']=$err_resp_msg;
            $respAr['errfileAr']=$errfileAr;
            $respAr['totalfileposted']=$totalfileposted;
            $respAr['uploadedsuccnames']=$uploadedsuccnames;
            $respAr['slider_contents']=$slider_contents;
            $respAr['default_image_name']=$default_image_name;
            //$respAr['user_master_img_db']=$user_master_img_db;
           //  $respAr['chkimgresp']=$chkimgresp;
            echo json_encode($respAr);
           
          
          
      }
      
      
      public function fileisinvalid($request,$addeditid=0)
       {
               
                // echo "<pre>";    print_r($request); exit();
                
                
                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="jpg";
                $allowedFileExtAr[]="jpeg";
                $allowedFileExtAr[]="png";
                
                $filecontrolname="image_name";
                
               
				$allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['jpg']=(5*1024*1024);
				$allowedFileExtSizeAr['jpeg']=(5*1024*1024);
                $allowedFileExtSizeAr['png']=(5*1024*1024);
				
				
				
				//max_width & max_height ,min_width &  min_height,equal_width & equal_height  
				$allowedFileResolAr=array();
				
				$allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
				$allowedFileResolAr['jpg']=array('min_width'=>537,'min_height'=>507);
                $allowedFileResolAr['png']=array('min_width'=>537,'min_height'=>507);
                $func="validatefile";//validatefile/uploadfile
                
                
                $destinationsourcePath=public_path()."/upload/userimage/source-file/";                       
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$destinationsourcePath,$errfileAr=array()) ;
                       
                
                
                
               
               /* echo "==chkimg1==><pre>";
                print_r($chkimgresp);
                echo "</pre>"; */ //exit();
                
               
               $invalidresp=false;
               
               $errormsgs='';  $fileuploadednames=array(); $errfileAr=array();
               $totalfileposted=0;
               
                if(!empty($chkimgresp))
                {
                        
                        
                        if(array_key_exists('errormsgs',$chkimgresp))
                        {
                                $errormsgs=$chkimgresp['errormsgs'];
                        }
                        
                        if(array_key_exists('errfileAr',$chkimgresp))
                        {
                                $errfileAr=$chkimgresp['errfileAr'];
                        }
                        
                        if(array_key_exists('totalfileposted',$chkimgresp))
                        {
                                $totalfileposted=$chkimgresp['totalfileposted'];
                        }
                        
                }
                
                $resparray=array();
                $resparray['errormsgs']=$errormsgs;
                $resparray['errfileAr']=$errfileAr;
                $resparray['totalfileposted']=$totalfileposted;
                
                return $resparray;
       }
       
       
       
       
         
         //************************** upload user  image  ends
         
       public function userimagedelete(Request $request)
        {
            // imagename   firstimageflag imageid
            $imagename= addslashes(trim($request->input('imagename','')));
            $firstimageflag= addslashes(trim($request->input('firstimageflag','')));
            $imageid= addslashes(trim($request->input('imageid','')));
            
            $flag_dta=0;$slider_contents='';$error_message='';
            $user_id=0;$default_image_name='';
            if ($request->session()->has('front_id_sess'))
            {
                    $user_id=$request->session()->get('front_id_sess'); // get session                       
            
            }
            
            
            //*** fetch this user related image starts                              
                
            $selectstr=" umtb.* ";
           
            $user_master_img_db=DB::table('user_master_img as umtb');              
            $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
            $user_master_img_db=$user_master_img_db->where('umtb.user_id', $user_id);
            $user_master_img_db=$user_master_img_db->where('umtb.id', $imageid);
            $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
           // $user_master_img_db = $user_master_img_db->skip(0)->take(6);
            //$user_master_img_db=$user_master_img_db->get();
            $user_master_img_db=$user_master_img_db->first();
            
            $image_name='';
            
            if(!empty($user_master_img_db))
            {
                  $image_name=$user_master_img_db->image_name;
            }
            
            //*** fetch this user related image ends
           
           $ar=DB::table('user_master_img')->where('id', '=', $imageid)->delete();
         
           
           if($ar>0)
           {
            
                          //***** unlink image starts
                        $destinationcommonPath=public_path()."/upload/userimage/source-file/".$image_name;
                        $destinationcommonPath2=public_path()."/upload/userimage/thumb-small/".$image_name;
                        $destinationcommonPath3=public_path()."/upload/userimage/thumb-medium/".$image_name;
                        $destinationcommonPath4=public_path()."/upload/userimage/thumb-big/".$image_name;
                        
                        @unlink($destinationcommonPath);
                        @unlink($destinationcommonPath2);
                        @unlink($destinationcommonPath3);
                        @unlink($destinationcommonPath4);
                        
                        //***** unlink image ends
                        
                        
                   $flag_dta=1;  
                   
                  if($firstimageflag==1) // if default image has been deleted
                  {
                        
                      
                        //*** fetch new first id of image of this user to update its default_status to 1 starts                              
                        
                        $selectstr=" umtb.* ";
                        
                        $user_master_img_db=DB::table('user_master_img as umtb');              
                        $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                        $user_master_img_db=$user_master_img_db->where('umtb.user_id', $user_id);
                        $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                        $user_master_img_db = $user_master_img_db->skip(0)->take(1);
                        $user_master_img_db=$user_master_img_db->first();
                        
                        $new_frst_img_id=0;
                        
                        if(!empty($user_master_img_db))
                        {
                              $new_frst_img_id=$user_master_img_db->id;
                        }
                        
                        if(!empty($new_frst_img_id))
                        {
                              //*** update code default_status to 1 starts
                              
                              $chkupd= DB::table('user_master_img')->where('id',$new_frst_img_id) ->update(
                              ["default_status" =>1,"modified_date"=> date("Y-m-d H:i:s") ]
                              );
                              
                             
                              
                              //*** update code default_status to 1 ends
                        }
                  }
                              
                  //***** now get image slider data starts 
                  
                 
                              //*** fetch this user related images starts                              
    
                              $selectstr=" umtb.* ";
                             
                              $user_master_img_db=DB::table('user_master_img as umtb');              
                              $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                              $user_master_img_db=$user_master_img_db->where('umtb.user_id', $user_id);
                              $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                              $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                              $user_master_img_db=$user_master_img_db->get();
                              
                              if(!empty($user_master_img_db))
                              {
                                    $default_image_name=$user_master_img_db[0]->image_name;
                                             
                              }
                              
                              //*** fetch this user related images ends
                              
                              $dataresp=array();
                              $view_obj = View::make('front.user.editprofilesilder', array("user_master_img_db"=>$user_master_img_db));
                              $slider_contents = $view_obj->render();  
                  
                  
                  //***** now get image slider data starts  
                        
                        
                        
                        
                        //*** fetch new first id of image of this user to update its default_status to 1 ends 
              
                     
           }
           
           if($flag_dta==0)
           {
                  $error_message=" Sorry image \"".$imagename."\" cannot be deleted ";
           }
           
           $respAr=array();
           $respAr['flag_status']=$flag_dta;
           $respAr['error_message']=$error_message;
           $respAr['slider_contents']=$slider_contents;
           $respAr['default_image_name']=$default_image_name;
           echo json_encode($respAr);
            
        }
        
        
      //************************** upload presskit starts
         
       public function presskituploadsave(Request $request)
        {
            //press-kit
            
             //echo "<pre>"; print_r($_FILES);echo "</pre>";
           
           
            $id=0;
            $chkvalidimage=$this->presskitfileisinvalid($request,$id);
              
            $err_resp_msg=''; $respflg=0; $uploadedsuccnames=array(); $user_master_img_db=array();
            $slider_contents=''; $default_image_name='';
              
            $errormsgs=$chkvalidimage['errormsgs'];
            $errfileAr=$chkvalidimage['errfileAr'];
            $totalfileposted=$chkvalidimage['totalfileposted'];
              
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
           
                  //**** file upload code starts
                       
                       
                       $allowedFileExtAr=array();
                       $allowedFileExtAr[]="pdf";
                      
                       
                       $filecontrolname="presskit_name";
                       
                      
                       $allowedFileExtSizeAr=array();
                       $allowedFileExtSizeAr['pdf']=(5*1024*1024);                      
                       
                       
                       //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                       $allowedFileResolAr=array();
                       
                      // $allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
                      
                       $func="uploadfile";//validatefile/uploadfile
                       
                       
                       $destinationsourcePath=public_path()."/upload/press-kit/source-file/";                         
                      
                       $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath,$errfileAr) ;
                       
                       
                         //echo "==Imcommonpath=>".$Imcommonpath;
                         //echo "==chkimg1==><pre>";
                         //print_r($chkimgresp);
                         //echo "</pre>";  //exit();
                   
                       if(!empty($chkimgresp))
                       {
                               $errormsgs='';  $fileuploadednames=array();
                               
                               if(array_key_exists('errormsgs',$chkimgresp))
                               {
                                       $errormsgs=$chkimgresp['errormsgs'];
                               }
                               
                               if(array_key_exists('fileuploadednames',$chkimgresp))
                               {
                                       $fileuploadednames=$chkimgresp['fileuploadednames'];
                               }
                               
                               if(!empty($fileuploadednames))
                               {
                                       
                                       
                                       foreach($fileuploadednames as $fileuploadednameAr)
                                       {
                                             $presskitfileName=$fileuploadednameAr['filenamedata'];
                                                $uploadedsuccnames[]=$presskitfileName;
                                       }                           
                                
                               }
                       
                       }
                       
                       //**** file upload code ends
                       
                       
                       //*****  insert into user_presskit table starts
                       
                       //$uploadedsuccnames
                       
                       if(!empty($uploadedsuccnames))
                       {
                              $user_id=0;
                              if ($request->session()->has('front_id_sess'))
                              {
                                      $user_id=$request->session()->get('front_id_sess'); // get session                       
                              
                              }
                              
                              
                               //*** check whether any prev presskit present starts
                                          $selectstr=" upk.* ";
                                          
                                          $user_presskit_db=DB::table('user_presskit as upk');              
                                          $user_presskit_db=$user_presskit_db->select(DB::raw($selectstr));                                                          
                                          $user_presskit_db=$user_presskit_db->where('upk.user_id', $user_id);                                          
                                          $user_presskit_db = $user_presskit_db->skip(0)->take(1);
                                          $user_presskit_db=$user_presskit_db->first();
                                          $presskit_name='';
                                          if(!empty($user_presskit_db))
                                          {
                                                $presskit_name=stripslashes($user_presskit_db->presskit_name);
                                          }
                                        
                               //*** check whether any prev presskit present ends
                        
                              foreach($uploadedsuccnames as $user_presskit_name)
                              {
                                    
                                   
                                    
                                    if(!empty($user_presskit_db))
                                    {
                                                //**** update qry
                                                
                                                $updtusrmstr= DB::table('user_presskit');
                                                $updtusrmstr= $updtusrmstr->where('user_id',$user_id) ;
                                                $updtusrmstr=$updtusrmstr->update(
                                                ['presskit_name' =>addslashes($user_presskit_name),
                                                 'create_date'=>date('Y-m-d H:i:s')    
                                                 ]
                                                );
                                                
                                                //*** unlink previous presslit  file
                                                
                                                $srcpresskit=public_path()."/upload/press-kit/source-file/".$presskit_name;
                        
                                                 @unlink($srcpresskit);
                                                
                                               
                                    }
                                    else
                                    {
                                               //**** insert qry
                                               
                                                $presskit_array=array();                                                
                                                
                                                $presskit_array['presskit_name']=addslashes($user_presskit_name);
                                                $presskit_array['user_id']=$user_id;
                                                $presskit_array['create_date']=date('Y-m-d H:i:s');                                    
                                                $chkupd= DB::table('user_presskit')->insert($presskit_array );
                                                $last_insert_id=DB::getPdo()->lastInsertId(); 
                                               
                                    }
                                   
                                    
                                    
                                    
                                    
                              }
                              
                             
                              
                              
                              
                              
                       }
                       
                       
                       //*****  insert into user_presskit table ends
                       
                       
            
            }
            else
            {
                   if(!empty($id))
                        {
                              
                              //return redirect(ADMINSEPARATOR.'/banneradd/'.$id)
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                             $err_resp_msg= $errormsgs;
                              
                        }
                        else
                        {
                              //return redirect(ADMINSEPARATOR.'/banneradd')
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                                $err_resp_msg= $errormsgs;
                        }
            }
            
            
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
                  $respflg=1;
              }
            
            
            
            
            $respAr=array();
            $respAr['flag']=$respflg;
            $respAr['errorespmsg']=$err_resp_msg;
            $respAr['errfileAr']=$errfileAr;
            $respAr['totalfileposted']=$totalfileposted;
            $respAr['uploadedsuccnames']=$uploadedsuccnames;
            
            //$respAr['user_master_img_db']=$user_master_img_db;
           //  $respAr['chkimgresp']=$chkimgresp;
            echo json_encode($respAr);
            
            
        }
        
        public function presskitfileisinvalid($request,$addeditid=0)
       {
               
                // echo "<pre>";    print_r($request); exit();
                
                
                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="pdf";
                
                
                $filecontrolname="presskit_name";
                
               
				$allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['pdf']=(5*1024*1024);
				
				
				
				
				//max_width & max_height ,min_width &  min_height,equal_width & equal_height  
				$allowedFileResolAr=array();
				
				//$allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
				
                $func="validatefile";//validatefile/uploadfile
                
                
                $destinationsourcePath=public_path()."/upload/press-kit/source-file/";                       
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$destinationsourcePath,$errfileAr=array()) ;
                       
                
                
                
               
               /* echo "==chkimg1==><pre>";
                print_r($chkimgresp);
                echo "</pre>"; */ //exit();
                
               
               $invalidresp=false;
               
               $errormsgs='';  $fileuploadednames=array(); $errfileAr=array();
               $totalfileposted=0;
               
                if(!empty($chkimgresp))
                {
                        
                        
                        if(array_key_exists('errormsgs',$chkimgresp))
                        {
                                $errormsgs=$chkimgresp['errormsgs'];
                        }
                        
                        if(array_key_exists('errfileAr',$chkimgresp))
                        {
                                $errfileAr=$chkimgresp['errfileAr'];
                        }
                        
                        if(array_key_exists('totalfileposted',$chkimgresp))
                        {
                                $totalfileposted=$chkimgresp['totalfileposted'];
                        }
                        
                }
                
                $resparray=array();
                $resparray['errormsgs']=$errormsgs;
                $resparray['errfileAr']=$errfileAr;
                $resparray['totalfileposted']=$totalfileposted;
                
                return $resparray;
       }
       
        
        
       //************************** upload presskit starts
             
            //************************** save rider data starts
            public function saveridercustfunc(Request $request)
            {
                        $riderdata = addslashes(trim($request->input('riderdata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checksaverider($request,$id);
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=0;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'),'rider_data' => $riderdata]
                                    );
                                    //*** update user_master table ends
                                    if(!empty($chkupd))
                                    {
                                                $flag_id=1;                            
                                    }
                                    //*** save data of user ends
                        }
                        else
                        {                 
                                    $error_message = $chkvalid->messages();
                        }
                        $error_msgAr=array();
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
                        echo json_encode($responseAr);  
            }
            
            public function checksaverider($request,$id=0)
            {
                        $validator = Validator::make($request->all(), [
                                    "riderdata" => "required|max:100",
                        ],[
                                    "riderdata.required" => "Rider data is required", 
                                    "riderdata.max" => "Maximum 100 characters",
                        ]);
                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            //************************** save rider data ends
            
            //************************** save ABN data starts
            public function saveabncustfunc(Request $request)
            {
                        $abndata = addslashes(trim($request->input('abndata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checkvalidabntosave($request,$id); //*** checksaveabn
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=0;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'),'abn_data' => $abndata]
                                    );
                                    //*** update user_master table ends
                                    if(!empty($chkupd))
                                    {
                                                $flag_id=1;                            
                                    }
                                    //*** save data of user ends
                        }
                        else
                        {                 
                                    $error_message = $chkvalid->messages();
                        }
                        $error_msgAr=array();
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
                        echo json_encode($responseAr);  
            }
            
            public function checkvalidabntosave($request,$id=0)
            {   
                        $validator = Validator::make($request->all(), [
                                    "abndata" => "required|numeric" ,
                        ],[
                                    "abndata.required" => "ABN is required",
                                    "abndata.numeric" => "Only numerics are allowed",
                        ]);
                        
                        $sendData=array();
                        $sendData['request']=$request;                      
                        $validator->after(function($validator)  use ($sendData)  {            
                                    $request=$sendData['request'];
                                    //***** here
                                    $validabnlengthcheck=$this->checkabnlengthvalid($request);
                                    if (!empty($validabnlengthcheck))
                                    {
                                                $validator->errors()->add('abndata', $validabnlengthcheck);
                                    }
                                    //***** here
                        });
                        
                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            
            public function checkabnlengthvalid($request)
            {
                        $abninput=$request->input('abndata');
                        $abnlength=strlen($abninput);
                        $errorMsg=array();
                        if($abnlength>11)
                        {
                                    $errorMsg[]=" Maximum 11 digits ";
                        }
                        
                        $errorMsgStr='';
                        if(!empty($errorMsg))
                        {
                                    foreach($errorMsg as $errorMsgData)
                                    {
                                                $errorMsgStr.=" <br>".$errorMsgData;
                                    }
                        }
                        
                        $responseAr=array();
                        $responseAr['errormsgs']=$errorMsgStr;
                        return $errorMsgStr;
            }
            //************************** save ABN data ends
            
            //************************** save GST data starts
            public function savegstcustfunc(Request $request)
            {
                        $gstdata = addslashes(trim($request->input('gstdata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checkvalidgsttosave($request,$id); 
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=0;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                    }
                                    $gststat=0;
                                    if($gstdata!='')
                                    {
                                                $gststat=1;
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'), 'tfn_data' => $gstdata, 'gst_status' => $gststat]
                                    );
                                    //*** update user_master table ends
                                    if(!empty($chkupd))
                                    {
                                                $flag_id=1;                            
                                    }
                                    //*** save data of user ends
                        }
                        else
                        {                 
                                    $error_message = $chkvalid->messages();
                        }
                        $error_msgAr=array();
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
                        echo json_encode($responseAr);  
            }
            
            public function checkvalidgsttosave($request,$id=0)
            {   
                        $validator = Validator::make($request->all(), [
                                    "gstdata" => "required|numeric" ,
                        ],[
                                    "gstdata.required" => "GST is required",
                                    "gstdata.numeric" => "Only numerics are allowed",
                        ]);
                        
                        $sendData=array();
                        $sendData['request']=$request;                      
                        $validator->after(function($validator)  use ($sendData)  {            
                                    $request=$sendData['request'];
                                    //***** here
                                    $validgstlengthcheck=$this->checkgstlengthvalid($request);
                                    if (!empty($validgstlengthcheck))
                                    {
                                                $validator->errors()->add('gstdata', $validgstlengthcheck);
                                    }
                                    //***** here
                        });
                        
                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            
            public function checkgstlengthvalid($request)
            {
                        $gstinput=$request->input('gstdata');
                        $gstlength=strlen($gstinput);
                        $errorMsg=array();
                        if($gstlength>9)
                        {
                                    $errorMsg[]=" Maximum 9 digits ";
                        }
                        
                        $errorMsgStr='';
                        if(!empty($errorMsg))
                        {
                                    foreach($errorMsg as $errorMsgData)
                                    {
                                                $errorMsgStr.=" <br>".$errorMsgData;
                                    }
                        }
                        
                        $responseAr=array();
                        $responseAr['errormsgs']=$errorMsgStr;
                        return $errorMsgStr;
            }
            //************************** save GST data ends
            
            //************************** save Page-meta-tag data starts
            public function savepagemetatagcustfunc(Request $request)
            {
                        $pagemetatagdata = addslashes(trim($request->input('pagemetatagdata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checksavepagemetatag($request,$id);
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=0;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'),'user_meta_data' => $pagemetatagdata]
                                    );
                                    //*** update user_master table ends
                                    if(!empty($chkupd))
                                    {
                                                $flag_id=1;                            
                                    }
                                    //*** save data of user ends
                        }
                        else
                        {                 
                                    $error_message = $chkvalid->messages();
                        }
                        $error_msgAr=array();
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
                        echo json_encode($responseAr);  
            }
            
            public function checksavepagemetatag($request,$id=0)
            {
                        $validator = Validator::make($request->all(), [
                                    "pagemetatagdata" => "required|max:100",
                        ],[
                                    "pagemetatagdata.required" => "Page meta tag data is required", 
                                    "pagemetatagdata.max" => "Maximum 100 characters",
                        ]);
                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            //************************** save Page-meta-tag data ends
            
            
            //************************** save booking options data starts
            public function bookingoptionssaveconfunc(Request $request)
            {
                        $typeEvent = addslashes(trim($request->input('typeEvent','')));
                        $typeEvent = ($typeEvent=="Available For")?"":$typeEvent;
                        
                        $bookingfrom = addslashes(trim($request->input('bookingfrom','')));
                        $bookingfrom = ($bookingfrom=="Bookings From")?"":$bookingfrom;
                        
                        $hourly_rate = addslashes(trim($request->input('hourly_rate','')));
                        $security_deposit = addslashes(trim($request->input('security_deposit','')));
                        
                        $setuptime = addslashes(trim($request->input('setuptime','')));
                        $setuptime = ($setuptime=="Set-up Time")?"":$setuptime;
                        
                        $packuptime = addslashes(trim($request->input('packuptime','')));
                        $packuptime = ($packuptime=="Pack-up Time")?"":$packuptime;
                        
                        $tech_spec = addslashes(trim($request->input('tech_spec','')));
                        $flag_id=0;
                        $chkvalid=$this->checksavebookingoptions($request);
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=0;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                                    ['available_for' => $typeEvent , 'booking_from' => $bookingfrom , 'rate_amount' => $hourly_rate , 'security_figure' => $security_deposit , 'setup_time' => $setuptime , 'packup_time' => $packuptime , 'tech_spec' => $tech_spec ,'modified_date' => date('Y-m-d H:i:s')]
                                    );
                                    //*** update user_master table ends
                                    if(!empty($chkupd))
                                    {
                                                $flag_id=1;                            
                                    }
                                    //*** save data of user ends
                        }
                        else
                        {                 
                                    $error_message = $chkvalid->messages();
                        }
                        $error_msgAr=array();
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
                        echo json_encode($responseAr);
            }
            
            public function checksavebookingoptions($request,$id=0)
            {
                        $validator = Validator::make($request->all(), [
                                    "typeEvent" => "required",
                                    "bookingfrom" => "required",
                                    "hourly_rate" => "required|numeric",
                                    "security_deposit" => "required|numeric",
                                    "setuptime" => "required",
                                    "packuptime" => "required",
                                    "tech_spec" => "required",
                        ],[
                                    "typeEvent.required" => "Event type data is required",
                                    "bookingfrom.required" => "Booking from data is required",
                                    "hourly_rate.required" => "Hourly rate data is required",
                                    "hourly_rate.numeric" => "Hourly rate data should be only in numeric",
                                    "security_deposit.required" => "Security deposit data is required",
                                    "security_deposit.numeric" => "Security deposit data should be only in numeric",
                                    "setuptime.required" => "Set-up time data is required",
                                    "packuptime.required" => "Pack-up time data is required",
                                    "tech_spec.required" => "Tech spec data is required",
                        ]);
                        
                        $userData=array();
                        $userData['request']=$request;
                        
                        $validator->after(function($validator)  use ($userData)  { 
                                    $request=$userData['request'];
                                    
                                    $hourly_rate = addslashes($request->input('hourly_rate'));
                                    $security_deposit = addslashes($request->input('security_deposit'));
		   
                                    if($hourly_rate!='')
                                    {		 
                                                $validatehourlyratechk=$this->chkvalidhourlyrate($hourly_rate);
                                                if (!empty($validatehourlyratechk))
                                                {
                                                         $validator->errors()->add('hourly_rate', $validatehourlyratechk);   
                                                }
                                    }
				
                                    if($security_deposit!='')
                                    {		 
                                                $validatesecuritydepositchk=$this->chkvalidsecuritydeposit($security_deposit);
                        
                                                if (!empty($validatesecuritydepositchk))
                                                {
                                                         $validator->errors()->add('security_deposit', $validatesecuritydepositchk);  
                                                }
                                    }
                        });
                        
                        if ($validator->fails())
                        {
                            return $validator;
                        }
                        return true;
            }
            
            public function chkvalidhourlyrate($hourly_rate)
            {
                        $errorMsg=array();
                        if($hourly_rate<=0)
                        {
                                    $errorMsg[]=" Hourly rate field cannot have 0 or negative value ";
                        }
			
                        $errorMsgStr='';
                        if(!empty($errorMsg))
                        { 
                                    foreach($errorMsg as $errorMsgData)
                                    {
                                       $errorMsgStr.=$errorMsgData;
                                    }
                        }
		  
                        $responseAr=array();
                        $responseAr['errormsgs']=$errorMsgStr;
                       
                        return $errorMsgStr;
            }
	   
            public function chkvalidsecuritydeposit($security_deposit)
            {
                        $errorMsg=array();
                        if($security_deposit<=0)
                        {
                                    $errorMsg[]=" Security deposit field cannot have 0 or negative value ";
                        }
			
                        $errorMsgStr='';
                        if(!empty($errorMsg))
                        { 
                                    foreach($errorMsg as $errorMsgData)
                                    {
                                                $errorMsgStr.=$errorMsgData;
                                    }
                        }
                      
                        $responseAr=array();
                        $responseAr['errormsgs']=$errorMsgStr;
                       
                        return $errorMsgStr;
            }
            //************************** save booking options data ends
           
}