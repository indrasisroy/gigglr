<?php

namespace App\Http\Controllers\admin;

//use App\User
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;

use Mail;
//use Image;

use App\Customlibrary\Imageuploadlib;

class AdmintestmailController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {
      // redirect('settings');
    }
    public function admintestmail(Request $request)
    {

            $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
            $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
       
            $data=array();
            $data['data1']="hello";
       

           if(!empty($successmsgdata))
           {
             $data['successmsgdata']=$successmsgdata;
           }
          if(!empty($errormsgdata))
           {
              $data['errormsgdata']=$errormsgdata;
           }
        
          return view('admin.admintestmail.admintestmail_view', $data);
    }

    public function sendadmintestmail(Request $request)
    {
		  $imgarray =array();
    
            $receiver_email = addslashes(trim($request->input('receiver_email')));
            $mail_subject = addslashes(trim($request->input('mail_subject')));
            $mail_text = addslashes(trim($request->input('mail_text')));
           
         
            $validate_settings_data=$this->validatesendadmintestmail($request); // validate data
          
            if($validate_settings_data === true)
            {
                
                //****** fetch admin settings starts *********************
                
                $sitename=''; $emailfrom=''; $copyright_year=''; $Imgologo='';
                
                $adminsetsel = DB::table('settings')
                ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                ->where('id', 1)
                ->first();
                
                if(!empty($adminsetsel))
                {
                    $sitename=$adminsetsel->site_name;
                    $emailfrom=$adminsetsel->email_from;
                    $copyright_year=$adminsetsel->copyright_year;
                    $Imgologo=$adminsetsel->email_template_logo_image;
                }
                
                $bsurl = url('/');
                $logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
                
                
                $adminfrom=$emailfrom;
                $sitename=$sitename;
                
                //****** fetch admin settings ends *********************
                
                //******* send mail code  starts ***************************************
                
                $passarr = array();                
                $passarr['receiver_email']=$receiver_email;    
                $passarr['mail_subject']=$mail_subject;
                $passarr['mail_text']=$mail_text;
                $passarr['adminfrom']=$adminfrom; 
                $passarr['sitename']=$sitename; 

                $replacefrom=array(); $replaceto=array();
                
                $body=$mail_text;
                
                
                //*********Helper Function Starts here ************
                
                    $email=$receiver_email;
                 
                    $replacefrom =array('{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{MESSAGETEXT}");

                    $replaceto =array($sitename,$copyright_year,$bsurl,$logoIMG,$body);


                    $chksnd=mailsnd($Temid=60,$replacefrom,$replaceto,$email,$mail_subject);
               
                

                  //*********Helper Function Ends here *************
                
                /*
                $data = array(
            'replacefrom'=>$replacefrom,'replaceto'=>$replaceto,'email_body'=>$body
            );
                
                $chksnd= Mail::send('emails.emailviewfolder.commonemailtenplate', $data, function ($message) use ($passarr)
                    {

                         $receiver_email = stripslashes($passarr['receiver_email']);
                            $mail_subject = stripslashes($passarr['mail_subject']);
                            $mail_text =stripslashes($passarr['mail_text']);
                            $adminfrom=stripslashes($passarr['adminfrom']);
                            $sitename=stripslashes($passarr['sitename']);

                            $message->to($receiver_email)->subject($mail_subject);

                            $message->from($adminfrom, $sitename);            
                            $message->to($receiver_email)->subject($mail_subject);

                    

                }
                    
            );                
                */
            
                //******* send mail code  ends *****************************************
                
                
                if($chksnd)
                {
                    $request->session()->flash('admin_successmsgdata_sess', 'Mail send successfully.');
                }
                else                    
                {
                    $request->session()->flash('admin_errormsgdata_sess', 'Unable to send mail.');
                }    
          
            }
       
          return redirect(ADMINSEPARATOR.'/admintestmail');
          
         // $validate_setting_data=$this->validatesettingform($request);
    }


            public function validatesendadmintestmail($request,$id=0)
           {
               
                    $validator = Validator::make($request->all(), [
                   
                    'receiver_email'=>array('required:required','regex:(^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$)'),
                    'mail_subject'=>'required|max:100',
                    'mail_text'=>'required|max:600'
                    
                    ],['receiver_email.required'=>'Receiver  Email is required',
                       'receiver_email.regex'=>'Inavlid Email',
                       'mail_subject.required'=>'Mail Subject is required',                      
				       'mail_text.required'=>'Mail Text is  required'
					   
                       ]);
                    
                   // echo "validator==>"; var_dump($validator->fails()); echo "</pre>";  exit();
                   
                   
                   //*********** additional    validation starts here
                
                    //                $receiver_email = addslashes($request->input('receiver_email'));
                    //                
                    //                $userData=array();
                    //                $userData['request']=$request;
                    //                $userData['receiver_email']=$receiver_email;
                    //                $validator->after(function($validator)  use ($userData)  {
                    //                        
                    //                        $request=$userData['request'];
                    //                        $receiver_email=$userData['receiver_email'];
                    //
                    //                        $validator->errors()->add('receiver_email', 'test error');
                    //					
                    //                });

                   //*********** additional  validation ends here
                   
                    if ($validator->fails())
                    {
                          //echo "here failed"; exit();
                        return redirect(ADMINSEPARATOR.'/admintestmail')
                        ->withErrors($validator)
                        ->withInput();
                        
                   
                    }
                    
                  return true; 
        
           }
           
		
           
           
           
           
}