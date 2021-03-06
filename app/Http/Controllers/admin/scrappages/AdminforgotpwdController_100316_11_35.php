<?php

namespace App\Http\Controllers;

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

class AdminforgotpwdController extends Controller
{
    
    public function index(Request $request)
    {
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
          
          return view('admin.forgotpwd.frgtpwd', $data);
    }
     
    public function sendnewfrgtpwd(Request $request)
    {
        $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
        $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
        
          $email1 = $request->input('frgt_email');
          $email=trim($email1);
          
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 8; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $pwd=$randomString;
            $en_pwd=md5($pwd);
           
            $chkvalid=$this->validateforgotuser($request);
            if($chkvalid===true)
            {
                $userssel = DB::table('user_master')
                        ->select(DB::raw('id,first_name,last_name,user_type'))
                        ->where('email',$email)
                        ->get();
                $userid=$userssel[0]->id;
                $firstname=$userssel[0]->first_name;
                $lastname=$userssel[0]->last_name;
                $usertype=$userssel[0]->user_type;
                if($userid!='' && $userid>0){
                    if($usertype=='1' || $usertype=='2'){
                        $mailvalid=$this->sendEmailNewuser($email,$pwd,$firstname,$lastname);
                        //echo $mailvalid;die;
                        if($mailvalid==1){
                            $dataUpdate=array();
                            $dataUpdate['password']=$en_pwd;
                            
                            $updstaus=DB::table('user_master')
                                  ->where('id', $userid)
                                  ->update($dataUpdate);
                                  
                            $request->session()->flash('admin_successmsgdata_sess', 'Password is successfully changed.');
                            return redirect(ADMINSEPARATOR.'/login');
                        }
                    }
                    else{
                        $request->session()->flash('admin_errormsgdata_sess', 'Error! Password can not be changed.');
                        return redirect(ADMINSEPARATOR.'/forgotPwd');
                    }
                }
                else{
                    $request->session()->flash('admin_errormsgdata_sess', 'Error! Password can not be changed.');
                    return redirect(ADMINSEPARATOR.'/forgotPwd');
                }                
            }
            else
            {
                return redirect(ADMINSEPARATOR.'/forgotPwd')
                 ->withErrors($chkvalid)
                 ->withInput();
            }
    }
    
    public function validateforgotuser($request)
    {
         
         $validator = Validator::make($request->all(), [
                'frgt_email' => "required|email",
            ],
            [   
                'frgt_email.required'=>' * Email is required. ',
            ]);
        
        if ($validator->fails())
        {
            return $validator ;
        }
        return true;
    }
    
    public function sendEmailNewuser($email,$pwd,$firstname,$lastname)
    {
        $passarr=array();
        
        $userssel = DB::table('settings')
                        ->select(DB::raw('site_name,email_from,copyright_year'))
                        ->where('id', 1)
                        ->get();
        $sitename=$userssel[0]->site_name;
        $emailfrom=$userssel[0]->email_from;
        $copyright_year=$userssel[0]->copyright_year;
        
        $usersemail = DB::table('email_templates')
                       ->select(DB::raw('message,subject'))
                       ->where('id', 5)
                       ->get();
       $emailmsgname=$usersemail[0]->message;
       $emailsubname=$usersemail[0]->subject;
        $subject = stripslashes($emailsubname);
        
        $passarr['adminfrom']=$emailfrom;
        $passarr['sitename']=$sitename;
        $passarr['emailsub']=$subject;
        $passarr['emailto']=$email;
        $fullname=$firstname.' '.$lastname;
        
        $data = array(
                      'password'=>$pwd,'sitename'=>$sitename,'copyright_year'=>$copyright_year,'fullname'=>$fullname,'email_body'=>$emailmsgname
                      );
    
       $chkmail= Mail::send('admin.emailviewfolder.adminforgotpwdmailtemp', $data, function ($message) use ($passarr) {
    
            $message->from($passarr['adminfrom'], $passarr['sitename']);
    
            $message->to($passarr['emailto'])->subject($passarr['emailsub']);
    
        });
       //var_dump($chkmail);die;
       return $chkmail;
        
        
    }
    
}