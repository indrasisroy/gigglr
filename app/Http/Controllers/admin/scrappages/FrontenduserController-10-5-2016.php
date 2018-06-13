<?php


namespace App\Http\Controllers;

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
                
                
                $data['banner_image']=$banner_image;
                $data['display_flag']=$display_flag;
                $data['fetchuserdata']=$fetchuserdata;
                
                
               return view('front.user.editprofile', $data);
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
          
            
            $first_name = addslashes(trim($request->input('first_name','')));
            
           
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
                        
                        $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                        ['modified_date' => date('Y-m-d H:i:s'),'first_name' => $first_name]
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
                $first_name = addslashes(trim($request->input('first_name','')));
                $controlmsg="";
                
                        
              
                    $validator = Validator::make($request->all(), [
                   
                    "first_name" => "required"
                    
                    
                    ],[
                       "first_name.required" => " Name is required"                  
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                
                  
                  
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                  return true;
                    
        
           }
         
         //************************** save saveusername ends          
                
           
           
}