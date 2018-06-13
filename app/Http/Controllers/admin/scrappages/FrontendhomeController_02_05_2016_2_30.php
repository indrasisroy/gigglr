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



class FrontendhomeController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(Request $request)
    {
          //$data=array();
          //$data['data1']="hello";
          
          $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
               $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
                
               $data=array();
               $data['data1']="hello";
               
               if(!empty($successmsgdata)){
                $data['successmsg']=$successmsgdata;
                
                $data['tmodata']=2000;
                $data['etmodata']=500;
                $data['sddata']=1000; 
                $data['hddata']=1500;
                $data['posclsdata']='toast-bottom-center';
               
               
               }
                if(!empty($errormsgdata)){
                $data['errormsg']=$errormsgdata;
               
                $data['tmodata']=2000;
                $data['etmodata']=500;
                $data['sddata']=1000; 
                $data['hddata']=1500;
                $data['posclsdata']='toast-bottom-center';
               
               }
               
               
                //*** fetch data of banner starts
                 
                $user_master_db = DB::table('banner as bn');
                $user_master_db=$user_master_db->select(DB::raw('bn.id,bn.status,bn.banner_image'));
                
                $user_master_db=$user_master_db->where('bn.status', 1);
                $user_master_db=$user_master_db->first();
                
                $banner_image='';$display_flag=0;
                
                if(!empty($user_master_db))
                {
                         $banner_image=$user_master_db->banner_image;
                         
                         if(!empty($banner_image))
                         {
                                $display_flag=1;
                                $banner_image=$imgurldata = asset('upload/banner-image/thumb-big/'.$banner_image);
                         }
                }
                
                
                //*** fetch data of banner starts
                
                $data['banner_image']=$banner_image;
                $data['display_flag']=$display_flag;
          
                 return view('front.home.landingview', $data);
    }
     
           
       public function registeruser(Request $request)
    {
          
          
            $status = 1;
            $date_data=date("Y-m-d H:i:s");            
           
            $email = addslashes(trim($request->input('email','')));
            $first_name = addslashes(trim($request->input('first_name','')));
            $password = addslashes(trim($request->input('password','')));
            $password_confirmation = addslashes(trim($request->input('password_confirmation','')));
            $gender = addslashes(trim($request->input('gender','')));
            $dob = addslashes(trim($request->input('dob','')));
            $termscond = addslashes(trim($request->input('dotermscondb','')));
            
            
            $dataInsert=array();
            
            $dataInsert['first_name']=$first_name;
            $dataInsert['email']=$email;
            $dataInsert['password']=md5($password);           
            $dataInsert['dob']=date('Y-m-d',strtotime($dob));
            $dataInsert['status']=$status;
            $dataInsert['registration_date']=$date_data;
            $dataInsert['user_type']=3;
            //var_dump($chkvalid); exit();
           // echo "i=>>".$id; exit();
             $id=0;
            $chkvalid=$this->checkregisterform($request,$id);
            
            $flag_id=0;
            $error_message=''; $responseAr=array();
            
           if($chkvalid===true)
           {
                
                  if(empty($id))
                  {
                                                
                        //*** insert  query
                        $isInserted = DB::table('user_master')->insert($dataInsert);
                        
                        /*Last Insert id*/
                        $isInserted=DB::getPdo()->lastInsertId();
                        // echo "====>".$last_insert_id;
                        $flag_id=$isInserted;
                  
                  }
                  
                  
                 
                  if($isInserted >= 0 )
                  {
                  //*******email code starts here
                  
                   $userssel = DB::table('settings')
                        ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                        ->where('id', 1)
                        ->get();
                  $sitename=$userssel[0]->site_name;
                  $emailfrom=$userssel[0]->email_from;
                  $copyright_year=$userssel[0]->copyright_year;
                  $Imgologo=$userssel[0]->email_template_logo_image;
                  $bsurl = url('/');
                  
                  
                  
                   //$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
                    $logoIMG = asset('upload/settings-image/source-file/'.$Imgologo);
                  //*********Helper Function Starts here
                  $replacefrom =array('{NAME}','{USERNAME}','{PASSWORD}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                  $replaceto =array(ucfirst($first_name),$email,$password,$sitename,$copyright_year,$bsurl,$logoIMG);
                
                  mailsnd($Temid=3,$replacefrom,$replaceto,$email);
                  //*********Helper Function Ends here 
                  //****** mail code ends here
                         $request->session()->flash('admin_successmsgdata_sess', 'Registration successfully made.');
                         //return redirect(ADMINSEPARATOR.'/banner');
                  
                  }
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
    
    
    public function checkregisterform($request,$id=0)
           {

              
                    $validator = Validator::make($request->all(), [
                   
                    'first_name' => "required",
                    'email' => "required|unique:user_master",
                    'password' => "required|confirmed",
                    'password_confirmation'=>"required",
                    
                    ],[
                       
                       'first_name.required'=>'* Name is required',
                       'email.required'=>'* Email is required',
                       'email.unique'=>'* This Email cannot be used',
                       'password.required'=>'* Password is required',
                       'password.confirmed'=>'* Password does not matches with confirm password',
                       'password_confirmation'=>'* Confirm Password is required',
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                   
                   
                    if ($validator->fails())
                    {
                        return $validator;
                       
                    }
                    
                    
                  return true;
                    
        
           } 
    
     public function loginuser(Request $request)
    {
          
            
            $email = addslashes(trim($request->input('email','')));
            $password = trim($request->input('password',''));
           
            $id=0;
            $chkvalid=$this->checkloginform($request,$id);
            
            $flag_id=0;
            $error_message=''; $responseAr=array();
            
           if($chkvalid===true)
           {
                
                 
                 //*** fetch data of user starts
                 
                $user_master_db = DB::table('user_master as um');
                $user_master_db=$user_master_db->select(DB::raw('um.id,um.first_name,um.password,um.email,um.status,um.user_type'));
                
                $user_master_db=$user_master_db->where('um.email', $email);
                $user_master_db=$user_master_db->where('um.password', md5($password));
                $user_master_db=$user_master_db->first();
                
                if(!empty($user_master_db))
                {
                               $flag_id=1;
                       
                                $setsess=$this->setfrontidsess($request,$email);  // set session                              
                                
                                $request->session()->flash('front_successmsgdata_sess', 'You have successfully logged in.');
                       
                }
                
                 //*** fetch data of user ends
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
           
    public function checkloginform($request,$id=0)
           {

              
                    $validator = Validator::make($request->all(), [
                   
                    'email' => "required",
                    'password' => "required",
                    
                    ],[
                       
                       'email.required'=>'* Email is required',
                     
                       'password.required'=>'* Password is required',
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                  
                $userData=array();
                
                $email = addslashes(trim($request->input('email','')));
                $password = trim($request->input('password',''));
           
                $userData['email']=$email;
                $userData['password']=$password;
                
                $validator->after(function($validator)  use ($userData)  {
                        
                       $email=$userData['email'];
                       $password=$userData['password'];
                      
                        
                        //****fetch data to check starts
                        
                                $user_master_db = DB::table('user_master as um');
                                $user_master_db=$user_master_db->select(DB::raw('um.id,um.first_name,um.password,um.email,um.status,um.user_type'));
                                
                                $user_master_db=$user_master_db->where('um.email', $email);
                                $user_master_db=$user_master_db->where('um.password', md5($password));
                                $user_master_db=$user_master_db->first();
                                
                                if(!empty($user_master_db))
                                {
                                        $user_status=$user_master_db->status;
                                        
                                        if($user_status==0)
                                        {
                                                 $validator->errors()->add('email', "This account is not active.");
                                        }
                                        elseif($user_status==9)
                                        {
                                                 $validator->errors()->add('email', "This account has been deleted.");
                                        }
                                }
                                else
                                {
                                         $validator->errors()->add('email', "Either emailid / password is wrong.");
                                }
                        
                        
                        //****fetch data to check ends
                        
                        
                        
                        if (!empty($validatefilechk))
                        {
                                 $validator->errors()->add('email', $validatefilechk);
                                 
                                 
                                 
                                // echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                        }
                });
                  
                  
                if ($validator->fails())
                {
                    return $validator;
                   
                }
                    
                    
                  return true;
                    
        
           }
           
        public function get_client_ip_server() {
               $ipAddress = '';

               $chk1=getenv('HTTP_X_FORWARDED_FOR');
               $chk2=('' !== trim(getenv('HTTP_X_FORWARDED_FOR')));
               $chk3=getenv('REMOTE_ADDR');
               $chk4=('' !== trim(getenv('REMOTE_ADDR')));
              
               // Check for X-Forwarded-For headers and use those if found
               if ( ($chk1!=false) && ($chk2!=false)) {
                    
               $ipAddress = trim(getenv('HTTP_X_FORWARDED_FOR'));
               } else {
               if ( ($chk3!=false) && ($chk4!=false)) {
               $ipAddress = trim(getenv('REMOTE_ADDR'));
               }
               }
       
                return $ipAddress;
           }
           
           public function dashboard(Request $request)
          {
                $data=array();
                $data['data1']="hello";
                
                // return view('admin.logintemplate', $data);
                
                if ($request->session()->has('front_id_sess'))
                     {
                         $front_id_sess= $request->session()->get('front_id_sess');
                       
                     }
                
               
               $successmsgdata=$request->session()->get('front_successmsgdata_sess');
               $errormsgdata=$request->session()->get('front_errormsgdata_sess');
                
               $data=array();
               $data['data1']="hello";
               
               if(!empty($successmsgdata)){
               $data['successmsgdata']=$successmsgdata;
               }
                if(!empty($errormsgdata)){
               $data['errormsgdata']=$errormsgdata;
               }
                
               return view('front.home.landingview', $data);
                
          }
          
           public function logout(Request $request)
                {
                    //*** set session  starts
                              
                               if ($request->session()->has('front_id_sess'))
                              {
                                   $request->session()->forget('front_id_sess');    // this unsets the session variable
                                    
                                
                              }
                                  
                              return redirect('/');
                              
                    //*** set session ends
                }
                
                
         public function setfrontidsess($request,$emailid='')
                {
                   //*** fetch data of user starts
                 
                        $user_master_db = DB::table('user_master as um');
                        $user_master_db=$user_master_db->select(DB::raw('um.id,um.first_name,um.password,um.email,um.status,um.user_type'));
                        
                        $user_master_db=$user_master_db->where('um.email', $emailid);
                        $user_master_db=$user_master_db->first();
                
                        if(!empty($user_master_db))
                        {
                                          $flag_id=1;
                               
                            /*echo "==user_single==><pre>";
                            print_r($user_single);
                            echo "</pre>";*/
                            
                            
                                        $status=$user_master_db->status;
                                        $user_type=$user_master_db->user_type;
                                        $userid=$user_master_db->id;
                                        $last_login_ip=$this->get_client_ip_server();
                                        
                                        
                                        
                                        //*** update user_master table starts
                                        
                                        $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                                        ['last_login' => date('Y-m-d H:i:s'),'last_login_ip' => $last_login_ip]
                                        );
                                        
                                        //*** update user_master table ends
                                        
                                        
                                        //*** set session  starts
                                        
                                        if ($request->session()->has('front_id_sess'))
                                        {
                                                $request->session()->forget('front_id_sess');    // this unsets the session variable
                                         
                                        
                                        }
                                        
                                        $request->session()->put('front_id_sess', $userid); // set session
                                       
                                        
                                        //*** set session ends
                                        
                                        
                                  return true;      
                           
                        }
                
                 //*** fetch data of user ends
                 
                 
                 return false;
                }
                
                
           
           
}