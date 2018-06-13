<?php

namespace App\Http\Controllers;

//use App\User
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Mail;
use Illuminate\Routing\Route;



class AdminprofileController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(Request $request)
    {
        $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
        $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
       
        $data=array();
        $data['data1']="hello";
        //********** Fetching settings data starts here
        $table_name = 'user_master';
        $id = '1';
        $data['user_data'] = $this->getsingleData($table_name,$id); //***** Calling a method for fetching settings table data
     
        

               if(!empty($successmsgdata))
               {
                 $data['successmsgdata']=$successmsgdata;
               }
              if(!empty($errormsgdata))
               {
                  $data['errormsgdata']=$errormsgdata;
               }
        
          return view('admin.profile.profile_edit', $data);
    }


    public function updateprofile(Request $request)
    {
      $first_name = trim(addslashes($request->input('first_name')));
      $username = trim(addslashes($request->input('username')));
      $emailaddress = trim(addslashes($request->input('email')));
      $password = addslashes($request->input('password'));
      $cpassword = addslashes($request->input('cpassword'));


      // $value1 = $this->checkField($request->input('password'));

      $validate_admin_data=$this->validateadminform($request,$id=1);

      if($validate_admin_data === true)
      {

        // echo "Validate successfully";
        // exit();

        $nw_pass = md5($password);
          $table_name = 'user_master';
          $id = '1';
          $array_admindata = array(
          'first_name' => $first_name,
          'username' => $username,
          'email' => $emailaddress
         
          );

          $array_admindatapass = array(
          'password' => $nw_pass
          );

         $update_success = $this->update_admindata($table_name,$id,$array_admindata);
         if($password!='')
         {
          $update_success_pass = $this->update_admindata($table_name,$id,$array_admindatapass);
         }
         $updateemail = $this->sendEmailNewuser($first_name,$emailaddress,$password,$username); //email sending code sttarts here

          $request->session()->flash('admin_successmsgdata_sess', 'Content Successfully updated');
         // $request->session()->flash('admin_successmsgdata_sess', 'validation successful');
      }
       // echo "Validate failed";
       //  exit();
            
      return redirect(ADMINSEPARATOR.'/editprofileadmin');



    // $validate_setting_data=$this->validatesettingform($request);
    }
    public function update_admindata($table_name,$id,$ar) //******* update function 
    {
        $updated_settings_ddata = DB::table($table_name)->where('id',$id) ->update($ar);
        return true;
    }

    public function getsingleData($table_name,$id) //******** Common Function
    {
      $user_single = DB::table($table_name)->where('id',$id)->first();
      return $user_single;
    }

    

     public function validateadminform($request,$id=1)
     {
          $passworrd = $request->input('password');

              $validator = Validator::make($request->all(), [
              'first_name' => 'required|max:50',
              'username'=>'required|alpha|max:15|unique:user_master,username,'.$id,
              'email' => "required|email|unique:user_master,email,".$id,
              'password' => 'min:4|same:confirm_password'  
              ],['first_name.required'=>' Name field required',
                'username.required'=>'User name field required',
                'username.unique'=>'User name field already exists',
                'email.unique'=>'User email field already exists',
                 ]);
          
              if ($validator->fails())
              {
                    //echo "here failed"; exit();
                  return redirect(ADMINSEPARATOR.'/profile_edit')
                  ->withErrors($validator)
                  ->withInput();
                  
             
              }
              
            return true; 
  
     }


    public function sendEmailNewuser($to_name,$email,$pwd,$usernamelogin)
    {
        $passarr=array();
        $userssel = DB::table('settings')
                        ->select(DB::raw('site_name,email_from,copyright_year'))
                        ->where('id', 1)
                        ->get();
        $sitename=$userssel[0]->site_name;
        $emailfrom=$userssel[0]->email_from;
        $copyright_year=$userssel[0]->copyright_year;

        //fetching email template data starts here  07-03-2016

         $usersemail = DB::table('email_templates')
                        ->select(DB::raw('message,subject'))
                        ->where('id', 2)
                        ->get();
        $emailmsgname=$usersemail[0]->message;
        $emailsubname=$usersemail[0]->subject;



        //fetching email template data ends here  07-03-2016

        $subject = stripslashes($emailsubname);
        $passarr['adminfrom']=$emailfrom;
        $passarr['sitename']=$sitename;
        $passarr['emailsub']=$subject;
        $passarr['emailto']=$email;


        



        
        $data = array(
                    'to_name'=>$to_name,  'password'=>'Password : '.$pwd,'sitename'=>$sitename,'copyright_year'=>$copyright_year,'email_body'=>$emailmsgname,'usernamelogin'=>$usernamelogin
                      );
    
        $email_r = Mail::send('admin.emailviewfolder.customemailtenplate', $data, function ($message) use ($passarr) {
    
            $message->from($passarr['adminfrom'], $passarr['sitename']);
    
            $message->to($passarr['emailto'])->subject($passarr['emailsub']);
    
        });

        return $email_r;
    }
           
}