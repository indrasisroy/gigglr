<?php

namespace App\Http\Controllers\admin;

//use App\User
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;


//use Image;

use App\Customlibrary\Imageuploadlib;

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
		  $imgarray =array();
    
           $site_name = addslashes($request->input('site_name'));
           $site_url = addslashes($request->input('site_url'));
           $address = addslashes($request->input('address'));
           $contact_email = addslashes($request->input('contact_email'));
           $meta_keywords = addslashes($request->input('meta_keywords'));
           $meta_description = addslashes($request->input('meta_description'));
           $record_per_page = addslashes($request->input('record_per_page'));
           $record_per_page_admin = addslashes($request->input('record_per_page_admin'));
           $contact_phone = addslashes($request->input('contact_phone'));
           $site_fax_no = trim(addslashes($request->input('site_fax_no')));
           $email_from = addslashes($request->input('email_from'));
           $emailfromname = addslashes($request->input('emailfromname'));


		       $wc_text = addslashes($request->input('wctext'));

		   
		   $facebook_url = addslashes($request->input('facebook_url'));
		   $twitter_url = addslashes($request->input('twitter_url'));
		   $google_url = addslashes($request->input('google_url'));
		   $instagram_url = addslashes($request->input('instagram_url'));
		   $youtube_url = addslashes($request->input('youtube_url'));
		   
		   $default_radius = addslashes($request->input('default_radius'));
		   $max_radius_limit = addslashes($request->input('max_radius_limit'));
		   $google_api_key = addslashes($request->input('google_api_key'));
		   $client_id = addslashes($request->input('client_id'));
		   $client_secret_key = addslashes($request->input('client_secret_key'));
		   $pin_secret_key = addslashes($request->input('pin_secret_key'));
		   $pin_publishable_key = addslashes($request->input('pin_publishable_key'));
		   $pin_liveortest = addslashes($request->input('pin_live_test'));
		   
          $firstprev_banner_image = addslashes(trim($request->input('firstprev_banner_image','')));
		  $secondprev_banner_image = addslashes(trim($request->input('secondprev_banner_image','')));
		  $thirdprev_banner_image = addslashes(trim($request->input('thirdprev_banner_image','')));
		  $fourthprev_banner_image = addslashes(trim($request->input('fourthprev_banner_image','')));
         
            $validate_settings_data=$this->validatesettingsform($request,$id=0);
           /* if($validate_settings_data == false)
            {

            }*/

           // var_dump( $validate_settings_data);

         //   echo "here mew"; exit();
        if($validate_settings_data === true)
        {
          
          //**********Image Code Starts here
          
                $allowedFileExtAr=array();
                //$allowedFileExtAr[]="jpg";
                //$allowedFileExtAr[]="jpeg";
                $allowedFileExtAr[]="png";
                
                //$filecontrolname="settings-image";
               
				$allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['jpg']=(50*1024*1024);
				$allowedFileExtSizeAr['jpeg']=(50*1024*1024);
                
                $allowedFileResolAr=array();
				
				if($request->hasFile('site_logo_image'))
				{
				//$allowedFileResolAr['jpeg']=array('min_width'=>445,'min_height'=>82);
				//$allowedFileResolAr['jpg']=array('min_width'=>445,'min_height'=>82);
                $allowedFileResolAr['png']=array('min_width'=>445,'min_height'=>82);
				}
				if($request->hasFile('afterlogin_logo_image'))
				{
				//$allowedFileResolAr['jpeg']=array('min_width'=>66,'min_height'=>49);
				//$allowedFileResolAr['jpg']=array('min_width'=>66,'min_height'=>49);
                $allowedFileResolAr['png']=array('min_width'=>66,'min_height'=>49);
				}
				if($request->hasFile('footer_logo_image'))
				{
				//$allowedFileResolAr['jpeg']=array('min_width'=>254,'min_height'=>45);
				//$allowedFileResolAr['jpg']=array('min_width'=>254,'min_height'=>45);
                $allowedFileResolAr['png']=array('min_width'=>254,'min_height'=>45);
				
				}
				if($request->hasFile('email_template_logo_image'))
				{
				//$allowedFileResolAr['jpeg']=array('min_width'=>254,'min_height'=>45);
				//$allowedFileResolAr['jpg']=array('min_width'=>254,'min_height'=>45);
                $allowedFileResolAr['png']=array('min_width'=>254,'min_height'=>45);
				
				}
				
				
//				$allowedFileResolAr['jpeg']=array('min_width'=>445,'min_height'=>82);
//				$allowedFileResolAr['jpg']=array('min_width'=>445,'min_height'=>82);
//                $allowedFileResolAr['png']=array('min_width'=>445,'min_height'=>82);
                $func="uploadfile";//validatefile/uploadfile
                
               //*********for image 1
				//$Imcommonpath=public_path()."/upload/settings-image/";
				$destinationsourcePath1=public_path()."/upload/settings-image/source-file/"; 
				
                //$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="site_logo_image",$Imcommonpath,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0);
				$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="site_logo_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath1) ;
				
				//echo "<pre>"; print_r($chkimgresp);	echo "</pre>"; exit();
                
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
                        
                        
                        $firstimagename='';$thumbfileName='';
                        
                        if(!empty($fileuploadednames))
                        {
                                //$destinationcommonPath=public_path()."/upload/settings-image/";
                                
                                foreach($fileuploadednames as $fileuploadednameAr)
                                {
                                       
                                       $fileName=$fileuploadednameAr['filenamedata'];
                                       
                                }
                                
                               $firstimagename=$fileName;
                                
                        }
                        
                }
				//*******image 2
				//$Imcommonpath=public_path()."/upload/settings-image/";
				$destinationsourcePath2=public_path()."/upload/settings-image/source-file/"; 
				 //$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="afterlogin_logo_image",$Imcommonpath,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0) ;
$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="afterlogin_logo_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath2) ;
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
                        
                        
                        $secondimagename='';
                        
                        if(!empty($fileuploadednames))
                        {
                                //$destinationcommonPath=public_path()."/upload/settings-image/";
                                
                                foreach($fileuploadednames as $fileuploadednameAr)
                                {
                                       
                                       $fileName=$fileuploadednameAr['filenamedata'];
                                       
                                }
                                
                               $secondimagename=$fileName;
                                
                        }
                        
                }
				
				//******* image 3
				
				//$Imcommonpath=public_path()."/upload/settings-image/";
				$destinationsourcePath3=public_path()."/upload/settings-image/source-file/";
				
				//$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="footer_logo_image",$Imcommonpath,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0) ;
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="footer_logo_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath3) ;
				
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
                        
                        
                        $thirdimagename='';
                        
                        if(!empty($fileuploadednames))
                        {
                                //$destinationcommonPath=public_path()."/upload/settings-image/";
                                
                                foreach($fileuploadednames as $fileuploadednameAr)
                                {
                                       
                                       $fileName=$fileuploadednameAr['filenamedata'];
                                       
                                }
                                
                               $thirdimagename=$fileName;
                                
                        }
                        
                }
				
				//*********image 4
                //$Imcommonpath=public_path()."/upload/settings-image/";
				$destinationsourcePath4=public_path()."/upload/settings-image/source-file/";
				//$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="email_template_logo_image",$Imcommonpath,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0) ;
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="email_template_logo_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath4) ;
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
                        
                        
                        $fourthimagename='';
                        
                        if(!empty($fileuploadednames))
                        {
                                //$destinationcommonPath=public_path()."/upload/settings-image/";
                                
                                foreach($fileuploadednames as $fileuploadednameAr)
                                {
                                       
                                       $fileName=$fileuploadednameAr['filenamedata'];
                                       
                                }
                                
                               $fourthimagename=$fileName;
                                
                        }
                        
                }
				
				
				
				
                //$dataInsert['banner_image']=$singleimagename;
                //echo $singleimagename;
                //exit();
          
          //********* Image code Ends here
          
          
          
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
            'email_from' => $email_from,
            'emailfromname' => $emailfromname,
			'welcome_text' =>$wc_text,
			
			'facebook_url' =>$facebook_url,
			'twitter_url' =>$twitter_url,
			'google_url' =>$google_url,
			'instagram_url' =>$instagram_url,
			'youtube_url' =>$youtube_url,
			
			'default_radius' =>$default_radius,
			'max_radius_limit' =>$max_radius_limit,
			'google_api_key' =>$google_api_key,
			'client_id' =>$client_id,
			'client_secret_key' =>$client_secret_key,
			'pin_secret_key' => $pin_secret_key,
			'pin_publishable_key' => $pin_publishable_key,
			'pin_liveortest'      => $pin_liveortest,
             );

          $update_success = $this->update_settingdata($table_name,$id,$array_settingsdata);
          
          
          
          //**********checking if 1st image exists or not strats here
          
          if(!empty($firstimagename))
          {
            $imgarray['site_logo_image']=$firstimagename;
            //echo "<pre>";
            //print_r($imgarray);
            // exit();
             
           $update_success = $this->update_settingdata($table_name,$id,$imgarray);
          }
          
          if(!empty($firstimagename) && !empty($firstprev_banner_image))
                               {
                                 
                                         $firststdestinationcommonPath=public_path()."/upload/settings-image/source-file/".$firstprev_banner_image;
                                        
                                         @unlink($firststdestinationcommonPath);
                                         
                               }
          //*********checking if 1st image exists or not ends here
		  
		  
		  //**********checking if 2nd image exists or not strats here
          
          if(!empty($secondimagename))
          {
            $imgarray['afterlogin_logo_image']=$secondimagename;
            //echo "<pre>";
            //print_r($imgarray);
            // exit();
             
           $update_success = $this->update_settingdata($table_name,$id,$imgarray);
          }
          
          if(!empty($secondimagename) && !empty($secondprev_banner_image))
                               {
                                 
                                         $seconddestinationcommonPath=public_path()."/upload/settings-image/source-file/".$secondprev_banner_image;
                                        
                                         @unlink($seconddestinationcommonPath);
                                         
                               }
          //*********checking if 2nd image exists or not ends here
		  
		  
		  //*********checking if 3rd image exists starts here
		 
          
          if(!empty($thirdimagename))
          {
            $imgarray['footer_logo_image']=$thirdimagename;
            //echo "<pre>";
            //print_r($imgarray);
            // exit();
             
           $update_success = $this->update_settingdata($table_name,$id,$imgarray);
          }
          
          if(!empty($thirdimagename) && !empty($thirdprev_banner_image))
                               {
                                 
                                         $thirddestinationcommonPath=public_path()."/upload/settings-image/source-file/".$thirdprev_banner_image;
                                        
                                         @unlink($thirddestinationcommonPath);
                                         
                               }
       
		  //*********checking if 3 image exists ends here
		  
		  //***********checking if 4th image exists starts here
		  
		   if(!empty($fourthimagename))
          {
            $imgarray['email_template_logo_image']=$fourthimagename;
            //echo "<pre>";
            //print_r($imgarray);
            // exit();
             
           $update_success = $this->update_settingdata($table_name,$id,$imgarray);
          }
          
          if(!empty($fourthimagename) && !empty($fourthprev_banner_image))
		  {
			
					$fourthdestinationcommonPath=public_path()."/upload/settings-image/source-file/".$fourthprev_banner_image;
				   
					@unlink($fourthdestinationcommonPath);
					
		  }
       
	   
		  //***********checking if 4th image exists ends here
          
          

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


            public function validatesettingsform($request,$id=0)
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
                   // 'site_fax_no'=>'required',
                    'email_from'=>'required|email',

                    'emailfromname'=>'required',

					'wctext'=>'required',
					
					'facebook_url'=>'required|active_url',
					'twitter_url'=>'required|active_url',
					'google_url'=>'required|active_url',
					'instagram_url'=>'required|active_url',
					'youtube_url'=>'required|active_url',
					
					'default_radius'=>'required|numeric',
					'max_radius_limit'=>'required|numeric',
					'google_api_key'=>'required',
					'client_id'=>'required',
					'client_secret_key'=>'required',
					'pin_secret_key'=>'required',
					'pin_publishable_key'=>'required',
                    
                    ],['site_name.required'=>'Site Name field is required',
                       'site_url.required'=>'Site Url field is required',
                       'address.required'=>'Address field is required',
                       'contact_email.required'=>'Contact Email field is required',
                       'meta_keywords.required'=>'Meta Keywords field is required',
                       'meta Description.required'=>'Site Url field is required',
                       'record_per_page.required'=>'Record Per Page field is required',
                       'record_per_page_admin.required'=>'Record Per Page Admin field is required',
                       'contact_phone.required'=>'Contact Phone field is required',
                     //  'site_fax_no.required'=>'Site Fax field is required',
                       'email_from.required'=>'Email field is required',
                       'emailfromname.required'=>'Email from field is required',
					   'wctext.required'=>'Welcome text field is required',
					  // 'wctext.max'=>'Welcome text should not be greater than 350 characters',
					   'default_radius.required'=>'Default Radius field is required',
					   'default_radius.numeric'=>'Default Radius will take only numeric input',
					   'max_radius_limit.required'=>'Maximum Radius Limit field is required',
					   'max_radius_limit.numeric'=>'Maximum Radius Limit will take only numeric input',
					   'google_api_key.required'=>'Google API Key field is required',
					   'client_id.required'=>'Client ID field is required',
					   'client_secret_key.required'=>'Client Secret Key field is required',
					   'pin_secret_key.required'=>'Pin Secret Key field is required',
					   'pin_publishable_key.required'=>'Pin Publishable Key field is required',
					   
                       ]);
                    
                   // echo "validator==>"; var_dump($validator->fails()); echo "</pre>";  exit();
                   
                   
                   //***********image validation starts here
                   
                $userData=array();
                $userData['request']=$request;
                $userData['addeditid']=$id;
                $validator->after(function($validator)  use ($userData)  {
                        
                       $request=$userData['request'];
                       $addeditid=$userData['addeditid'];
                      
					  
					  //***********validation for image 1
					if($request->hasFile('site_logo_image'))
				{
						$site_logo_image = 'site_logo_image';
                        $validatefilechk=$this->fileisinvalid($request,$addeditid,$site_logo_image = 'site_logo_image');
                        
                        if (!empty($validatefilechk))
                        {
                                 $validator->errors()->add('site_logo_image', $validatefilechk);
                        }
				}
						//********** validation for image 2
						if($request->hasFile('afterlogin_logo_image'))
				{
				  
						$afterlogin_logo_image = 'afterlogin_logo_image';
						$validatefilechk2=$this->fileisinvalid($request,$addeditid,$afterlogin_logo_image);
						
						//var_dump($validatefilechk2); exit();
                        
                        if (!empty($validatefilechk2))
                        {
                                 $validator->errors()->add('afterlogin_logo_image', $validatefilechk2);
                                 
                        }
				}
						//********* validation for image 3
				if($request->hasFile('footer_logo_image'))
				{		
						$afterlogin_logo_image = 'footer_logo_image';
						$validatefilechk=$this->fileisinvalid($request,$addeditid,$afterlogin_logo_image='footer_logo_image');
                        
                        if (!empty($validatefilechk))
                        {
                                 $validator->errors()->add('footer_logo_image', $validatefilechk);
                                 
                        }
				}	
						 //********* validation for image 4
				if($request->hasFile('email_template_logo_image'))
				{		 
						$afterlogin_logo_image = 'email_template_logo_image';
						$validatefilechk=$this->fileisinvalid($request,$addeditid,$afterlogin_logo_image='email_template_logo_image');
                        
                        if (!empty($validatefilechk))
                        {
                                 $validator->errors()->add('email_template_logo_image', $validatefilechk);
                                 
                        }
						
				}
				
				$default_radius = addslashes($request->input('default_radius'));
		   $max_radius_limit = addslashes($request->input('max_radius_limit'));
		   
		   if($default_radius!='')
				{		 
						$validatedefaultradiuschk=$this->chkvaliddefaultradius($default_radius,$max_radius_limit);
                        
                        if (!empty($validatedefaultradiuschk))
                        {
                                 $validator->errors()->add('default_radius', $validatedefaultradiuschk);
                                 
                        }
						
				}
				
				
				if($max_radius_limit!='')
				{		 
						$validatemaxradiuschk=$this->chkvalidmaxradius($default_radius,$max_radius_limit);
                        
                        if (!empty($validatemaxradiuschk))
                        {
                                 $validator->errors()->add('max_radius_limit', $validatemaxradiuschk);
                                 
                        }
						
				}
						
						
                });

                   //***********image validation ends here
                   
                   
                   
                   
                   
                   
                   
                    
                    if ($validator->fails())
                    {
                          //echo "here failed"; exit();
                        return redirect(ADMINSEPARATOR.'/settings')
                        ->withErrors($validator)
                        ->withInput();
                        
                   
                    }
                    
                  return true; 
        
           }
           
		public function chkvaliddefaultradius($default_radius,$max_radius_limit)
		{
			$errorMsg=array();
			if($default_radius<=0)
			{
				$errorMsg[]=" Radius field cannot have 0 or negative value ";
			}
			else{
				if ((int) $default_radius != $default_radius) {
					$errorMsg[]=" Radius field cannot have decimal value ";
				}
				else{
					if($default_radius>=$max_radius_limit){
						$errorMsg[]=" Default Radius cannot be grater than Maximum Radius Limit ";
					}
				}
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
	   
		public function chkvalidmaxradius($default_radius,$max_radius_limit)
		{
			$errorMsg=array();
			if($max_radius_limit<=0)
			{
				$errorMsg[]=" Radius field cannot have 0 or negative value ";
			}
			else{
				if ((int) $max_radius_limit != $max_radius_limit) {
					$errorMsg[]=" Radius field cannot have decimal value ";
				}
				else{
					if($default_radius>=$max_radius_limit){
						$errorMsg[]=" Maximum Radius Limit should be grater than Default Radius ";
					}
				}
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
           
      public function fileisinvalid($request,$addeditid=1,$filecontrolname)
       {
               
                 //echo "<pre>";    print_r($request); exit();
                //echo $filecontrolname;exit;
                
                //**** image code starts
                
                
               $allowedFileExtAr=array();
                //$allowedFileExtAr[]="jpg";
                //$allowedFileExtAr[]="jpeg";
                $allowedFileExtAr[]="png";
                
                //$filecontrolname="site_logo_image";
                
               
				$allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['jpg']=(50*1024*1024);
				$allowedFileExtSizeAr['jpeg']=(50*1024*1024);
                
                
                $allowedFileResolAr=array();
				
				
				if($filecontrolname=="site_logo_image")
				{
				  
				//$allowedFileResolAr['jpeg']=array('min_width'=>445,'min_height'=>82);
				//$allowedFileResolAr['jpg']=array('min_width'=>445,'min_height'=>82);
                $allowedFileResolAr['png']=array('min_width'=>445,'min_height'=>82);
				
				$func="validatefile";//validatefile/uploadfile
				//$Imcommonpath=public_path()."/upload/settings-image/";
				$destinationsourcePath1=public_path()."/upload/settings-image/source-file/";
				
                //$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="site_logo_image",$Imcommonpath,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=1) ;
				$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="site_logo_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath1);
                  
				  
				}
				else if($filecontrolname=="afterlogin_logo_image")
				{
				//$allowedFileResolAr['jpeg']=array('min_width'=>66,'min_height'=>49);
				//$allowedFileResolAr['jpg']=array('min_width'=>66,'min_height'=>49);
                $allowedFileResolAr['png']=array('min_width'=>66,'min_height'=>49);
				
				$func="validatefile";//validatefile/uploadfile
				
				
				//$Imcommonpath=public_path()."/upload/settings-image/";
				$destinationsourcePath2=public_path()."/upload/settings-image/source-file/";
                //$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="afterlogin_logo_image",$Imcommonpath,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=1) ;
				$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="afterlogin_logo_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath2);
                
				}
				
				else if($filecontrolname=="footer_logo_image")
				{
				//$allowedFileResolAr['jpeg']=array('min_width'=>254,'min_height'=>45);
				//$allowedFileResolAr['jpg']=array('min_width'=>254,'min_height'=>45);
                $allowedFileResolAr['png']=array('min_width'=>254,'min_height'=>45);
				  
				$func="validatefile";//validatefile/uploadfile
				//$Imcommonpath=public_path()."/upload/settings-image/";
				$destinationsourcePath3=public_path()."/upload/settings-image/source-file/";
                //$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="footer_logo_image",$Imcommonpath,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=1) ;
				$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="footer_logo_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath3);
                 
				}
				
				
				else if($filecontrolname=="email_template_logo_image")
				{
				//$allowedFileResolAr['jpeg']=array('min_width'=>254,'min_height'=>45);
				//$allowedFileResolAr['jpg']=array('min_width'=>254,'min_height'=>45);
                $allowedFileResolAr['png']=array('min_width'=>254,'min_height'=>45);
				  
				$func="validatefile";//validatefile/uploadfile
				
				//$Imcommonpath=public_path()."/upload/settings-image/";
				$destinationsourcePath4=public_path()."/upload/settings-image/source-file/";
				
                //$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="email_template_logo_image",$Imcommonpath,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=1) ;
				
				$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="email_template_logo_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath4);
                   
				}
				
				
				
				
				
				
                //$func="validatefile";//validatefile/uploadfile
                //
                //
                //$chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="site_logo_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=1) ;
                //
                
               
                //echo "==chkimg1==><pre>";
                //print_r($chkimgresp);
                //echo "</pre>"; exit();
                
               
               $invalidresp=false;
               
               $errormsgs='';  $fileuploadednames=array();
               
                if(!empty($chkimgresp))
                {
                        
                        
                        if(array_key_exists('errormsgs',$chkimgresp))
                        {
                                $errormsgs=$chkimgresp['errormsgs'];
                        }
                        
                        
                }
                
                return $errormsgs;
       }
           
           
           
           
}