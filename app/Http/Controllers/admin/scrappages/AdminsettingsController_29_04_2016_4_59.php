<?php

namespace App\Http\Controllers;

//use App\User
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;



class AdminsettingsController extends Controller
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
    public function settings(Request $request)
    {
// echo "Hello";
// exit();
       $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
       $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
       
          $data=array();
        $data['data1']="hello";
        //********** Fetching settings data starts here
        $table_name = 'settings';
        $id = '1';
        $data['settings_data'] = $this->getsingleData($table_name,$id); //***** Calling a method for fetching settings table data
     
        

               if(!empty($successmsgdata))
               {
                 $data['successmsgdata']=$successmsgdata;
               }
              if(!empty($errormsgdata))
               {
                  $data['errormsgdata']=$errormsgdata;
               }
        
          return view('admin.settings.settings_view', $data);
    }

    public function updatesettings(Request $request)
    {

    
           $site_name = addslashes($request->input('site_name'));
           $site_url = addslashes($request->input('site_url'));
           $address = addslashes($request->input('address'));
           $contact_email = addslashes($request->input('contact_email'));
           $meta_keywords = addslashes($request->input('meta_keywords'));
           $meta_description = addslashes($request->input('meta_description'));
           $record_per_page = addslashes($request->input('record_per_page'));
           $record_per_page_admin = addslashes($request->input('record_per_page_admin'));
           $contact_phone = addslashes($request->input('contact_phone'));
           $site_fax_no = addslashes($request->input('site_fax_no'));
           $email_from = addslashes($request->input('email_from'));


            $validate_settings_data=$this->validatesettingsform($request);
           /* if($validate_settings_data == false)
            {

            }*/

           // var_dump( $validate_settings_data);

         //   echo "here mew"; exit();
if($validate_settings_data === true){
            $table_name = 'settings';
            $id = '1';
           $array_settingsdata = array(

            'site_name' => $site_name,
            'site_url' => $site_url,
            'address' => $address,
            'contact_email' => $contact_email,
            'meta_keywords' => $meta_keywords,
            'meta_description' =>$meta_description,
            'record_per_page' => $record_per_page,
            'record_per_page_admin' => $record_per_page_admin,
            'contact_phone' => $contact_phone,
            'site_fax_no' => $site_fax_no,
            'email_from' => $email_from
            );

          $update_success = $this->update_settingdata($table_name,$id,$array_settingsdata);

          $request->session()->flash('admin_successmsgdata_sess', 'Content Successfully updated');
}
                    
       return redirect(ADMINSEPARATOR.'/settings');
       
          
          
         // $validate_setting_data=$this->validatesettingform($request);
    }
    public function update_settingdata($table_name,$id,$ar) //******* update function 
    {
        $updated_settings_ddata = DB::table($table_name)->where('id',$id) ->update($ar);
        return true;
    }

    public function getsingleData($table_name,$id) //******** Common Function
    {
      $user_single = DB::table($table_name)->where('id',$id)->first();
      return $user_single;
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
                  
                  return redirect(ADMINSEPARATOR.'/settings')
                        ->withErrors($validator)
                        ->withInput();
                  
                    
                    }
                    
                    return true;
        
           }


            public function validatesettingsform($request)
           {
               
                    $validator = Validator::make($request->all(), [
                    'site_name' => 'required|max:255',
                    'site_url'=>'required',
                    'address' => 'required',
                    'contact_email'=>'required|email',
                    'meta_keywords' => 'required|max:255',
                    'meta_description'=>'required',
                    'record_per_page' => 'required|max:255',
                    'record_per_page_admin'=>'required',
                    'contact_phone' => 'required|max:255',
                    'site_fax_no'=>'required',
                    'email_from'=>'required|email'

                    
                    ],['site_name.required'=>'Site Name field required',
                       'site_url.required'=>'Site Url field required',
                       'address.required'=>'Address field required',
                       'contact_email.required'=>'Contact Email field required',
                       'meta_keywords.required'=>'Meta Keywords field required',
                       'meta Description.required'=>'Site Url field required',
                       'record_per_page.required'=>'Record Per Page field required',
                       'record_per_page_admin.required'=>'Record Per Page Admin field required',
                       'contact_phone.required'=>'Contact Phone field required',
                       'site_fax_no.required'=>'Site Fax field required',
                       'email_from.required'=>'Email field required',

                       ]);
                    
                   // echo "validator==>"; var_dump($validator->fails()); echo "</pre>";  exit();
                    
                    if ($validator->fails())
                    {
                          //echo "here failed"; exit();
                        return redirect(ADMINSEPARATOR.'/settings')
                        ->withErrors($validator)
                        ->withInput();
                        
                   
                    }
                    
                  return true; 
        
           }
           
           
           
           
}