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

class FrontendVenueLocationController extends Controller
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
                 
                 
                 
                 
                   //**** fetch skill_master data  starts
                
                $fetchtype='multiple'; $tablename="skill_master";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['catag_type']=3;
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
                
                 
                 
                 
                 
                 
                 
                 
                     
                 $fetchtype='single'; $tablename="venue_master";
                 $fieldnames=" * ";
                 $wherear=array();
                 $wherear['id']='1';
                 $orderbyfield="id"; $orderbytype="asc";
                 $limitstart=0;$limitend=0;                
                
                $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
                //******
                 $data['fetchskillmasterAr']=$fetchskillmasterAr;
                 $data['fetchuserdata']=$fetchuserdata;
                     
                     
                     return view('front.venue.profile_venue'); 
    } public function edit_venue(Request $request)
    {
           $sess_idchk = $request->session()->get('front_id_sess');
       if($sess_idchk!='')
       {    // } 
                 
                 
                 
                     $data=array(); 
                            $data['data1']="hello";
                     
                     
                     
                $fetchtype='multiple'; $tablename="skill_master";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['catag_type']=3;
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
                
                $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.venue_id) as user_id ";
                
                $skill_user_db=DB::table('venue_skill_rel as usr');
                
                $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
                
                $skill_user_db=$skill_user_db->where('usr.venue_id', 1);
                $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
                
                $skill_user_db=$skill_user_db->get();
                
                //echo "==skill_db==><pre>";
                //print_r($skill_db);
                //echo "</pre>";
               
                //**** fetch user_skill_rel data  ends
                
                //******
                $fetchtype='single'; $tablename="venue_master";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['id']='1';
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
                //******
                $data['skill_user_db']=$skill_user_db;
                 $data['fetchuserdata']=$fetchuserdata;
                 $data['fetchskillmasterAr']=$fetchskillmasterAr;
                 return view('front.venue.venue_edit',$data);
    }else
    {
                 return redirect('/');
    }
    
    }
    
    function venuesubskill(Request $request)
         {
                //**** fetch skill starts
                
                 $parent_id = $request->input('parent_id');
              //echo "<br>";
                 $catag_type =$request->input('catag_type');
                
                $user_id=0;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session                       
                        
                        }
                
                $fetchtype='multiple'; $tablename="skill_master";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['catag_type']=$catag_type;
                $wherear['parent_id']=$parent_id;
                $wherear['status']=1;
                $orderbyfield="name"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                               
                $respar=array();
                //$wherenortinstr=" id NOT IN ( select skill_sub_id from user_skill_rel where user_id='".$user_id."' ) ";
    
                $tab_db = DB::table($tablename);
                $tab_db=$tab_db->select(DB::raw($fieldnames));
                $tab_db=$tab_db->where($wherear);
                //$tab_db=$tab_db->whereRaw($wherenortinstr);
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
                        
                        $chkupd= DB::table('venue_master')->where('id','1') ->update(
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
           
         
         
         
         
         
         
         
         
         
         
         
         
          //*************************** save saveusername starts
         
          public function saveusernamevenue(Request $request)
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
                        
                        $chkupd= DB::table('venue_master')->where('id','1') ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),'venue_name' => $nickname]
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
         
         
          //*************************** save user_description starts
         
          public function saveuserdescvenue(Request $request)
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
                        
                        $chkupd= DB::table('venue_master')->where('id','1') ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),'venue_description' => $user_description]
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
         
         
          //*************************** save skill data starts
         
          public function saveskilldatavenue(Request $request)
        {
          
            
         /*echo "Category ID=>".*/ $catag_type_id= addslashes(trim($request->input('catag_type_id','')));
       /* echo "Skill ID==>".*/    $skill_id= addslashes(trim($request->input('skill_id','')));
          /*echo "Skill Sub ID=>".*/  $skill_sub_id= addslashes(trim($request->input('skill_sub_id','')));
            //die;
            
            $id=0;
            $chkvalid=$this->checksaveskilldata($request);
            $chkvalid=true;
            $flag_id=0;
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
           if($chkvalid==true)
           {
                
                 
                 //*** save  data of user starts
                 
                        $user_id=1;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session                       
                        
                        }
                        
                        //*** update venue_skill table starts
                        
                        $insert_skill_array=array();
                        $insert_skill_array['catag_type_id']=$catag_type_id;
                        $insert_skill_array['skill_id']=$skill_id;
                        $insert_skill_array['skill_sub_id']=$skill_sub_id;
                        $insert_skill_array['venue_id']=$user_id;
                        $insert_skill_array['create_date']=date('Y-m-d H:i:s');
                         
                        $chkupd= DB::table('venue_skill_rel')->insert($insert_skill_array );
                         $last_insert_id=DB::getPdo()->lastInsertId();

                        
                        //*** update venue_skill table ends
                        
                        if(!empty($last_insert_id))
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
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                return true;
                    
        
           }
            //*************************** delete skill data starts
         
          public function deletemyskillvenue(Request $request)
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
                 
                        $user_id=1;
                        if ($request->session()->has('front_id_sess'))
                        {
                                $user_id=$request->session()->get('front_id_sess'); // get session                       
                        
                        }
                        
                        //*** update user_master table starts
                        
                        $where_del_array=array();
                        
                        $where_del_array['skill_sub_id']=$skill_sub_id;
                        $where_del_array['venue_id']=$user_id;
                        
                         //echo "<pre>";
                        // print_r($where_del_array);die;
                        $chkupd= DB::table('venue_skill_rel')->where($where_del_array )->delete();
                         

                        
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
           
    
         
         //************************** delete skill data ends     
         
         
    // public function index(Request $request)
    //{
    //        
    //                    $uu = $request->segment(2);
    //                    $query = DB::table('user_master')->select('user_uniqueid')->get();
    //                    $user_id = 0;
    //                    $user_single = DB::table('user_master')->where('user_uniqueid',$uu)->first();
    //                    if($user_single)
    //                    {
    //                                $user_id = $user_single->id;
    //                    }
    //                    else
    //                    {
    //                                 $user_id = 0;
    //                    }
    //
    //        
    //                    if($user_id <2 || empty($user_single) || $user_id ==0)
    //                    {
    //                                echo "wrong user";exit();
    //                    }
    //                    
    //                        $data=array(); 
    //                        $data['data1']="hello";
    //                   
    //                       //*************** fetch data of banner starts=======================*************
    //                        $banner_image='';$display_flag=0;            
    //                        //*** fetch data of banner ends                
    //                        
    //                        //**** fetch basic info of user  starts
    //                        
    //                        $fetchtype='single'; $tablename="user_master";
    //                        $fieldnames=" * ";
    //                        $wherear=array();
    //                        $wherear['id']=$user_id;
    //                        $orderbyfield="id"; $orderbytype="asc";
    //                        $limitstart=0;$limitend=0;                
    //                        
    //                        $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
    //           
    //           //**** fetch skill_master data  starts
    //            
    //            $fetchtype='multiple'; $tablename="skill_master";
    //            $fieldnames=" * ";
    //            $wherear=array();
    //            $wherear['catag_type']=1;
    //            $wherear['parent_id']=0;
    //            $wherear['status']=1;
    //            $orderbyfield="name"; $orderbytype="asc";
    //            $limitstart=0;$limitend=0;                
    //            
    //            $fetchskillmasterdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
    //           
    //            $fetchskillmasterAr=array();
    //            $fetchskillmasterAr['']="Category for Request";
    //            if(!empty($fetchskillmasterdata))
    //            {
    //                foreach( $fetchskillmasterdata as $fetchskillobj )
    //                {
    //                        $fetchskillmasterAr[$fetchskillobj->id]=$fetchskillobj->name;
    //                }
    //            } 
    //            //**** fetch skill_master data  ends
    //            
    //            
    //            //**** fetch user_skill_rel data  starts
    //            
    //            $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.user_id) as user_id ";
    //           
    //            $skill_user_db=DB::table('user_skill_rel as usr');
    //
    //            $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
    //            $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
    //            $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
    //            
    //            $skill_user_db=$skill_user_db->where('usr.user_id', $user_id);
    //            $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
    //            
    //            $skill_user_db=$skill_user_db->get();
    //            
    //            //echo "==skill_db==><pre>";
    //           // print_r($skill_user_db);
    //            $sklid = $skill_user_db[0]->skill_sub_id;
    //            $sklid = explode(',',$sklid);
    //          //  echo "<pre>";
    //           // print_r($sklid);
    //            //echo $skill_user_skill_sub_id'];
    //          //  echo "</pre>";
    //           
    //            //**** fetch user_skill_rel data  ends
    //            
    //            //*******************************FETCH COUNTRY DATA STARTS HERE 28-05-2016
    //            $country_db = DB::table('location_country')->where('published','1')->get();
    //           // $country_result = $country_qry;
    //                    $countryidAr=array();
    //                    $countryidAr['']="Select a country";
    //                    if(!empty($country_db))
    //                    {
    //                            foreach($country_db as $country_obj)
    //                            {
    //                                    $countryidAr[$country_obj->id]=stripslashes($country_obj->country_name);
    //                            }
    //                            
    //                    }
    //           
    //            //****************FETCH ALL CATEGORY ENDS HERE 30-05-2016
    //            
    //            
    //            //****************
    //            //***************FETCH USER IMAGE STARTS HERE
    //            $usr_img = DB::table('user_master_img')->where('default_status','1')->where('user_id',$user_id)->get();
    //             
    //           //***************FETCH USER IMAGE ENDS HERE
    //           
    //           //********Fetch user review starts here
    //           
    //           $userstesti = DB::table('event_review as erv')
    //                ->join('user_master as um', 'erv.booker_id', '=', 'um.id')
    //                 ->join('bookers_review as brv', 'erv.id', '=', 'brv.event_review_id')
    //                                    ->leftJoin('user_master_img as umi', function ($join)
    //                                    {
    //                                    $join->on('erv.booker_id', '=', 'umi.user_id')
    //                                    ->where('umi.default_status','=','1');
    //                                    })
    //                                   
    //                ->select('erv.*', 'um.first_name', 'um.username','um.nickname','um.city','umi.user_id','umi.image_name','umi.default_status','brv.puntuality','brv.performence','brv.presentation')
    //                ->where('erv.artist_id',$user_id)
    //                ->get();
    //               
    //                //echo "<pre>";
    //                //print_r($userstesti);
    //                //echo "</pre>";die;
    //           //********Fetch user review ends here
    //          //*************presskit data starts here
    //          $presskit = DB::table('user_presskit')->where('user_id',$user_id)->first();
    //          //*************presskit data ends here
    //          
    //          ////***************sum of ratings starts here
    //          //$total = DB::table('users')->where()->sum('puntuality');
    //          ////**************sum of ratings ends here
    //            
    //            
    //            $data['banner_image']=$banner_image;
    //            $data['display_flag']=$display_flag;
    //            $data['fetchuserdata']=$fetchuserdata;
    //            $data['fetchskillmasterAr']=$fetchskillmasterAr;
    //            $data['skill_user_db']=$skill_user_db;
    //            $data['country_result']=$countryidAr;
    //            $data['usr_img']=$usr_img;//usrIMG
    //            
    //            $data['user_testi']=$userstesti;//usrIMG
    //            $data['presskit']=$presskit;//usrIMG
    //           return view('front.user.profile', $data);
    //}
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
   
   //**********booking complete starts here
   public function completebooking(Request $request)
   {
     $getresponseAr=array();
                    
     $address1val = addslashes(trim($request->input('address1val')));
     $address2val = addslashes(trim($request->input('address2val')));
     $countrydata = $request->input('countrydata');
     $statelistdata = $request->input('statelistdata');
     $towndata = addslashes(trim($request->input('towndata')));
     $zipdata = addslashes(trim($request->input('zipdata')));
     $bookingcat_subdata = $request->input('bookingcat_subdata');
     $bookinggenre_subdata = $request->input('bookinggenre_subdata');
     $security_paymentdata = $request->input('security_paymentdata');
     $total_paymentdata = $request->input('total_paymentdata');
     $cancellation_paymentdata = $request->input('cancellation_paymentdata');
     $booking_datedata = $request->input('booking_datedata');
     $start_timedata = $request->input('start_timedata');
     $end_timedata = $request->input('end_timedata');
     $requestexpireddatedata = $request->input('requestexpireddatedata');
     $requestexpiredtimedata = $request->input('requestexpiredtimedata');
     
     
     
     //********* validation starts here
     //$chkvalid=$this->checkbookingform($request,$id);
     //********* validation ends here
     
     
     
     //*********** get country name and state name starts here
     $countrynm = 'country_name';
     $statenm = 'state_name';
     $tblnm = 'location_country';
     $sttbl = 'location_state';
     $countryname = $this->getcommondetails($countrydata,$countrynm,$tblnm);
     $statename = $this->getcommondetails($statelistdata,$statenm,$sttbl);
     //*********** get country name and state name ends here
     //*********** Get latlong starts here
      $fullBookingAddress = $address1val.' '.$address2val.' '.$towndata.' '.$statename->state_name.' '.$countryname->country_name;
      
      $fullBookingAddress = urlencode($fullBookingAddress);
      
      $latlog = getLatLong($fullBookingAddress);
      
                    $latitude = $latlog['latlong'][0]['latitude'];
                    $longitude = $latlog['latlong'][0]['longitude'];
                    $TimeZoneCheck = getTimezone($latitude,$longitude);
                    $timezoneId = $TimeZoneCheck['timeZoneId'];
                    $timezoneName = $TimeZoneCheck['timeZoneName'];
                    
     //*********** Get latlong ends here
    
    //*********current date time
    $crdt = date('Y-m-d H:i:s');
    
     //*****convert time into mysql format starts here
     
     //*********booking request date time
     $ttt= explode("/",$booking_datedata);
     $bkngdate = $ttt[2].'-'.$ttt[1].'-'.$ttt[0];
     
     $r =  date("G:i", strtotime($start_timedata));
     $strttim = date('H:i:s',strtotime($r));
     
     $r1 =  date("G:i", strtotime($end_timedata));
     $endtim = date('H:i:s',strtotime($r1));
    //*********booking request date time
    //*****convert time into mysql format ends here
   
    
    //*******request expire date time
     $reqt= explode("/",$requestexpireddatedata);
     $bkngexpirdate = $reqt[2].'-'.$reqt[1].'-'.$reqt[0];
     
     $r2 =  date("G:i", strtotime($requestexpiredtimedata));
     $expirtim = date('H:i:s',strtotime($r2));
    
    $bokingexpired = $bkngexpirdate.' '.$expirtim;
    //*******request expire date time
    
     $inbookingarray = array(
                             'artist_id' => '123456',
                             'booker_id' => '1234',
                             'event_address1' =>$address1val,
                             'event_address2' => $address2val,
                             'event_country' => $countrydata,
                             'event_state' => $statelistdata,
                             'event_city' => $towndata,
                             'event_zip' => $zipdata,
                             'booking_category' => $bookingcat_subdata,
                             'booking_genere' =>$bookinggenre_subdata,
                             'artist_security_deposit' => $security_paymentdata,
                             'total_payment' => $total_paymentdata,
                             'booking_cancellation_fee' => $cancellation_paymentdata,
                             'event_date' => $bkngdate,
                             'event_start_time' => $strttim,
                             'event_end_time' => $endtim,
                             'event_address1_lat' => $latitude,
                             'event_address1_long' => $longitude,
                             'event_timezone' => $timezoneName,
                             'booking_req_date' => $crdt,
                             'request_expired'=> $bokingexpired
                             );
     
                //    $datainsrt = DB::table('event_booking_request')->insert($inbookingarray); //insert data into event booking table
               
                    if($datainsrt)
                    {
                           //***************** calling an email function
                           //booking_email();
                           
                    }
     
                    $getresponseAr['flagdata'] = $inbookingarray;
                    
                    
                    //$getresponseAr['endtim'] = $endtim;
                    
                    echo json_encode($getresponseAr);
                    //die;
   }
   
   //**********booking complete ends here
   
   //************* Common function to get single data starts here
   public function getcommondetails($id,$selecttype,$tblnm)
   {
                    
                    //return 2;
                    $qry = DB::table($tblnm)->select($selecttype)->where('id',$id)->first();
                   // return  $qry$selecttype;
                   //echo "<pre>";
                   //print_r($qry);
                   //die;
                   return $qry;
   }
   //************* Common function to get single data ends here
      
      
      public function booking_email()
      {
            
                  
                    $userssel = DB::table('settings')
                    ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                    ->where('id', 1)
                    ->get();
                    $sitename=$userssel[0]->site_name;
                    $emailfrom=$userssel[0]->email_from;
                    $copyright_year=$userssel[0]->copyright_year;
                    $Imgologo=$userssel[0]->email_template_logo_image;
                    $bsurl = url('/');
                    
                    //**********get user details strats here
                    
                    $userdetail = DB::table('user_master')
                    ->select(DB::raw('first_name'))
                    ->where('email', $email)
                    ->get();
                    $first_name=$userdetail[0]->first_name;
                    
                    //*********get user details ends here
                    
                    //$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
                    $logoIMG = asset('upload/settings-image/source-file/'.$Imgologo);
                    //*********Helper Function Starts here
                    $replacefrom =array('{NAME}','{USERNAME}','{PASSWORD}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                    $replaceto =array(ucfirst($first_name),$email,$nw_pass,$sitename,$copyright_year,$bsurl,$logoIMG);
                    
                    mailsnd($Temid=8,$replacefrom,$replaceto,$email);
                  //*********Helper Function Ends here 
                
                     
      }
      
      
      
      //************************** save ABN data starts
            public function saveabncustfuncvenue(Request $request)
            {
                        $abndata = addslashes(trim($request->input('abndata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checkvalidabntosave($request,$id); //*** checksaveabn
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=1;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('venue_master')->where('id',$userid) ->update(
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
            public function savegstcustfuncvenue(Request $request)
            {
                        $gstdata = addslashes(trim($request->input('gstdata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checkvalidgsttosave($request,$id); 
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=1;
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
                                    $chkupd= DB::table('venue_master')->where('id',$userid) ->update(
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
            public function savepagemetatagcustfuncvenue(Request $request)
            {
                        $pagemetatagdata = addslashes(trim($request->input('pagemetatagdata','')));
                        $id=0; $flag_id=0; $error_message=''; $responseAr=array(); $error_msgAr=array();
                        $chkvalid=$this->checksavepagemetatag($request,$id);
                        if($chkvalid===true)
                        {
                                    //*** save data of user starts
                                    $userid=1;
                                    if ($request->session()->has('front_id_sess'))
                                    {
                                                $userid=$request->session()->get('front_id_sess'); // get session
                                    }
                                    //*** update user_master table starts
                                    $chkupd= DB::table('venue_master')->where('id',$userid) ->update(
                                    ['modified_date' => date('Y-m-d H:i:s'),'venue_meta_data' => $pagemetatagdata]
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
      
}