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



class AdminloginController extends Controller
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
               }
                if(!empty($errormsgdata)){
               $data['errormsg']=$errormsgdata;
               }
          
          return view('admin.login.logintemplate', $data);
    }
     public function logincheck(Request $request)
      {
          
          $username = $request->input('username');
          $password = $request->input('password');
          
          
          $validate_login=$this->validateloginform($request);
          
          if($validate_login==false)
          {
               // return redirect(ADMINSEPARATOR.'/login');
          }
          
          
          $user_single = DB::table('user_master')->where([
         
          ['username',$username],
          ['password',md5($password)]
          ])->first();

          /*echo "==user_single==><pre>";
          print_r($user_single);
          echo "</pre>";*/
          
          $status=0;$user_type=1;$userid=0;
          if(!empty($user_single))
          {
               $status=$user_single->status;
               $user_type=$user_single->user_type;
               $userid=$user_single->id;
               $last_login_ip=$this->get_client_ip_server();
               
               if( ($user_type==1) && ($status==1) )
               {
                    //*** update user_master table starts
                   
                   $chkupd= DB::table('user_master')->where('id',$userid) ->update(
                                                                           ['last_login' => date('Y-m-d H:i:s'),'last_login_ip' => $last_login_ip]
                                                                           );
                                  
                    //*** update user_master table ends
                    
                    
                    //*** set session  starts
                    
                     if ($request->session()->has('admin_id_sess'))
                    {
                         $request->session()->forget('admin_id_sess');    // this unsets the session variable
                         $request->session()->forget('admin_type_sess');    // this unsets the session variable   
                      
                    }
                        
                     $request->session()->put('admin_id_sess', $userid); // set session
                     $request->session()->put('admin_type_sess', $user_type); // set session
                    
                    //*** set session ends
                    
                    
                    $request->session()->flash('admin_successmsgdata_sess', 'You have successfully logged in.');
                    
                    return redirect(ADMINSEPARATOR.'/dashboard');
               }
               else
               {
                    return redirect(ADMINSEPARATOR.'/login');
               }
          }
          
          
          
          
          return redirect(ADMINSEPARATOR.'/login');         
           
      }
      
      public function logout(Request $request)
      {
          //*** set session  starts
                    
                     if ($request->session()->has('admin_id_sess'))
                    {
                         $request->session()->forget('admin_id_sess');    // this unsets the session variable
                         $request->session()->forget('admin_type_sess');    // this unsets the session variable   
                      
                    }
                        
                    return redirect(ADMINSEPARATOR.'/login');
                    
          //*** set session ends
      }
      
      
        
       public function dashboard(Request $request)
          {
                $data=array();
                $data['data1']="hello";
                
                // return view('admin.logintemplate', $data);
                
                if ($request->session()->has('admin_id_sess'))
                     {
                         $admin_id_sess= $request->session()->get('admin_id_sess');
                         
                         //echo $admin_id_sess;
                     }
                
               
               $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
               $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
                
               $data=array();
               $data['data1']="hello";
               
               if(!empty($successmsgdata)){
               $data['successmsgdata']=$successmsgdata;
               }
                if(!empty($errormsgdata)){
               $data['errormsgdata']=$errormsgdata;
               }
                
               return view('admin.home.admindashboard', $data);
                
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
           
           public function validateloginform($request)
           {
               
                    $validator = Validator::make($request->all(), [
                    'username' => 'required|max:255',
                    'password'=>'required'
                    
                    ],['username.required'=>'Username field required',
                       'password.required'=>'Password field required'
                       ]);
                    
                   // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; 
                    
                    if ($validator->fails())
                    {
                                      
                              /*$messages = $validator->errors();
                              
                             echo " messages=><pre>";
                             
                             print_r($messages);
                             
                             echo "</pre>";
                             
                             $name_error_msg=$messages->first('name');
                             */
                    
                  // return false;
                  
                  return redirect(ADMINSEPARATOR.'/login')
                        ->withErrors($validator)
                        ->withInput();
                  
                    
                    }
                    
                    return true;
        
           }
           
           
           
           
}