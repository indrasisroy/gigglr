<?php

namespace App\Http\Controllers\admin;

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
use Response;
use Illuminate\Routing\Route;
use App\Customlibrary\Imageuploadlib;

class AdminuserController extends Controller
{
    
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    
    public function index(Request $request )
    {
        $data=array();
        $useinPagiAr=array();
           
        $srch1=addslashes(trim($request->input('srch1','')));
        $sort1=addslashes(trim($request->input('sort1','')));
        $sorttype1=addslashes(trim($request->input('sorttype1','')));
            
        if(!empty($srch1))
        {
            $useinPagiAr['srch1']=trim($srch1);  
        }
        if(!empty($sort1))
        {
            $useinPagiAr['sort1']=trim($sort1);  
        }
        if(!empty($sorttype1))
        {
            $useinPagiAr['sorttype1']=trim($sorttype1);  
        }
        
        $data['data1']="hello";
      
        $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
        $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
        
        if(!empty($successmsgdata))
        {
            $data['successmsgdata']=$successmsgdata;
        }
        if(!empty($errormsgdata))
        {
            $data['errormsgdata']=$errormsgdata;               
        }
        
        //**** fetch data starts
        
        $users_db = DB::table('user_master as um');
        $users_db=$users_db->join('group_master as gm', 'gm.creater_id', '=', 'um.id', 'left outer');
        $users_db=$users_db->join('venue_master as vm', 'vm.creater_id', '=', 'um.id', 'left outer');
        $users_db=$users_db->select(DB::raw('um.id,CONCAT_WS(" ",um.first_name,um.last_name) AS name,um.nickname,um.email,um.status,gm.id AS grp,vm.id AS ven'));
        $users_db=$users_db->where('um.user_type', 3);
        $users_db=$users_db->where('um.status','<>', 9);
        if(!empty($srch1))
        {
            $users_db=$users_db->where('um.nickname', 'like', "%".$srch1."%");
           //$users_db=$users_db->where('um.first_name', 'like', "%".$srch1."%");
           //$users_db=$users_db->orWhere('um.last_name', 'like', "%".$srch1."%");
           //$users_db=$users_db->orWhereRaw("CONCAT_WS(' ',um.first_name,um.last_name) LIKE '%".$srch1."%'");           
        }
        if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
        {
              
              $users_db=$users_db->orderBy('um.'.$sort1, $sorttype1);
        }
        //$users_db=$users_db->orderBy('um.id', 'asc');
        //$users_db=$users_db->get();
        
        $pagi_user=$users_db;
            
        //**** fetch data ends
        
        //***** fetch data from settings table starts
        
            $pagelimit=1;
            $staterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();            
            
            if(!empty($staterow))
            {
                $pagelimit=$staterow->record_per_page_admin;
            }
            
        //***** fetch data from settings table ends
            
        //***** pagination code starts
          
        //$pagelimit=2;
        $pagi_user = $pagi_user->paginate($pagelimit);

        $pagi_user->setPath(url(ADMINSEPARATOR.'/user'));
           
        $data['pagi_user']=$pagi_user;
        $data['useinPagiAr']=$useinPagiAr;
            
        //***** pagination code ends       
          
        return view('admin.user.userlist', $data);
    }
    
    public function adduser(Request $request,$id=0)
    {
          $usr_stateID = '';
        //  $flag = 0;
          $data=array();
          $data['data1']="hello";


          $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
        $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
        
        if(!empty($successmsgdata))
        {
            $data['successmsgdata']=$successmsgdata;
        }
        if(!empty($errormsgdata))
        {
            $data['errormsgdata']=$errormsgdata;               
        }
        
         
          if(!empty($id))
          {
            //**** fetch data starts
            $userrow = DB::table('user_master as um')->where('um.id', $id)->first();
            if($userrow)
            {
                $data['userrow']=$userrow;
                $usr_stateID = $userrow->country;
            }
            //**** fetch data ends 

            //******** fetch user press kit
            $userrow_press = DB::table('user_presskit as upk')->where('upk.user_id', $id)->first();
            if($userrow_press)
            {
                $data['userpresskit']=$userrow_press;
            }

          }
          
          //******** fetch country data for drop down starts
        
        $country_db = DB::table('location_country as lc');
        $country_db=$country_db->select(DB::raw('lc.id,lc.country_name,lc.published'));
        $country_db=$country_db->where('lc.published', '=', 1);
        $country_db=$country_db->orderBy('lc.country_name', 'asc');
        $country_db= $country_db->get();
        
        //echo "<pre>"; print_r($country_db); exit();
        $countryidAr=array();
        $countryidAr['']="Select a country";
        if(!empty($country_db))
        {
                foreach($country_db as $country_obj)
                {
                        $countryidAr[$country_obj->id]=stripslashes($country_obj->country_name);
                }
                
        }
        
        $data['countryidAr']=$countryidAr;
        
        //******** fetch country data for drop down ends

        //******** fetch state drop down starts
          $stateidAr=array();
          if(!empty($usr_stateID))
          {
            $stateres_db =  DB::table('location_state')->where('country_id',$usr_stateID)->where('published','1')->get();
                            if(!empty($stateres_db))
                            {
                                foreach($stateres_db as $stateres_obj)
                                {
                                $stateidAr[$stateres_obj->id]=stripslashes($stateres_obj->state_name);
                                }

                            }
          }
          $data['stateidAr']=$stateidAr;
        //******** fetch state drop down ends
        
        //******** fetch language data for drop down starts
        
        $language_db = DB::table('language as lng');
        $language_db=$language_db->select(DB::raw('lng.id,lng.language_name,lng.language_3_code'));
        $language_db=$language_db->where('lng.status', '=', 1);
        $language_db=$language_db->orderBy('lng.language_name', 'asc');
        $language_db=$language_db->get();
        
        //echo "<pre>"; print_r($country_db); exit();
        $languageidAr=array();
        $languageidAr['']="Select a language";
        if(!empty($language_db))
        {
                foreach($language_db as $language_obj)
                {
                        $languageidAr[$language_obj->id]=stripslashes($language_obj->language_name);
                }
                
        }
        
        $data['languageidAr']=$languageidAr;
        
        //******** fetch language data for drop down ends
        
        //******** fetch skill data for drop down starts
        
        $skill_db = DB::table('skill_master as sm');
        $skill_db=$skill_db->select(DB::raw('sm.id,sm.name,sm.seo_name'));
        $skill_db=$skill_db->where('sm.status', '=', 1);
        $skill_db=$skill_db->where('sm.parent_id', '=', 0);
        $skill_db=$skill_db->where('sm.catag_type', '=', 1);
        $skill_db=$skill_db->orderBy('sm.name', 'asc');
        $skill_db=$skill_db->get();
        
        //echo "<pre>"; print_r($country_db); exit();
        $skillidAr=array();
        $skillidAr['']="Select a skill";
        if(!empty($skill_db))
        {
                foreach($skill_db as $skill_obj)
                {
                        $skillidAr[$skill_obj->id]=stripslashes($skill_obj->name);
                }
                
        }
        
        $data['skillidAr']=$skillidAr;
        
        //******** fetch skill data for drop down ends
        
        //******** fetch currency data for drop down starts
        
        $currency_db = DB::table('currencylist as cl');
        $currency_db=$currency_db->select(DB::raw('cl.id,cl.currency_name,cl.published'));
        $currency_db=$currency_db->where('cl.published', '=', 1);
        $currency_db=$currency_db->orderBy('cl.currency_name', 'asc');
        $currency_db= $currency_db->get();
        
        //echo "<pre>"; print_r($country_db); exit();
        $currencyidAr=array();
        $currencyidAr['']="Select a currency";
        if(!empty($currency_db))
        {
                foreach($currency_db as $currency_obj)
                {
                        $currencyidAr[$currency_obj->id]=stripslashes($currency_obj->currency_name);
                }
                
        }
        
        $data['currencyidAr']=$currencyidAr;
        
        //******** fetch currency data for drop down ends
        if(!empty($id))
        {
            if(!$userrow || $id == 1)
            {
                $request->session()->flash('admin_errormsgdata_sess', 'This user does not exists');
                return redirect(ADMINSEPARATOR.'/user');
            }
        }
     
        return view('admin.user.useradd', $data);
    }  
    
    public function saveuser(Request $request)
    {

        // if($request->hasFile('presskit_name'))
        // {
        //     echo "File present";die;
        // }
            $formtype = $request->input('formtype');

            $first_name = trim(addslashes($request->input('first_name')));
            $middle_name = trim(addslashes($request->input('middle_name')));
            $last_name = trim(addslashes($request->input('last_name')));
           // $username = $request->input('username');
            $nickname = $request->input('nickname');
            $email = $request->input('email');
            $oldpass = $request->input('oldpass');
            $newpass = $request->input('newpass');
            $gender = $request->input('gender');
            $address1 = trim($request->input('address1'));
            $address2 = trim($request->input('address2'));
            $country = $request->input('country_id');
            $state = $request->input('state_id');
            $city = trim($request->input('city'));
            $zip = trim($request->input('zip'));
            $language=$request->input('language_id');
            $abn=trim($request->input('abn'));
            $tfn=trim($request->input('tfn'));
            $currency=$request->input('currency');
            $rider=trim($request->input('rider'));
            $description=$request->input('description');
            $fb_url = $request->input('fburl');
            $soundcloud_url= $request->input('soundcloudurl');
            $residentadvisor_url = $request->input('residentadvisorurl');
            $twitter_url = $request->input('twitterurl');
            $youtube_url = $request->input('youtubeurl');
            $instagram_url = $request->input('instagramurl');  
            $pagemetatag=trim($request->input('pagemeta'));

            $presskitfile = trim($request->input('presskit_name'));
            //print_r($presskitfile);die;
             $dateofbirth = trim($request->input('dateofbirth')); 
             $dateofbirth = date('Y-m-d H:i:s',strtotime($dateofbirth)); 

             //echo $dateofbirth;die;
            
            $uid = $request->input('uid');
            
            if($middle_name!='')
            {
                $midname=ucfirst($middle_name);
            }
            else{
                $midname='';
            }
            
            $pwd='';
            if($newpass!='')
            {
                $pwd=md5($newpass);   
            }
            else
            {
                $pwd=$oldpass;
            }
            
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 8; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $pwd=$randomString;
            $en_pwd=md5($pwd);
            
            $today=date('Y-m-d H:i:s');
            
            $dataInsert=array();

            if($formtype == 0)
            {
         //   $dataInsert['username']=$username;
            $dataInsert['nickname']=$nickname;
            $dataInsert['email']=$email;
            $dataInsert['password']=$pwd;
            $dataInsert['gender']=$gender;
            }else if($formtype == 1){

            $dataInsert['first_name']= ucfirst($first_name);
            $dataInsert['middle_name']=$midname;
            $dataInsert['last_name']= ucfirst($last_name);
            //$dataInsert['username']=$username;
            $dataInsert['nickname']=$nickname;
            $dataInsert['email']=$email;
            $dataInsert['password']=$pwd;
            $dataInsert['gender']=$gender;
            $dataInsert['address1']=$address1;
            $dataInsert['address2']=$address2;
            $dataInsert['country']=$country;
            $dataInsert['state']=$state;
            $dataInsert['city']=$city;
            $dataInsert['zip']=$zip;
            $dataInsert['language']=$language;
            $dataInsert['abn_data']=$abn;
            $dataInsert['tfn_data']=$tfn;
            $dataInsert['currency']=$currency;
            $dataInsert['rider_data']=$rider;
            $dataInsert['user_description']=$description;
            $dataInsert['facebook_url']=$fb_url;
            $dataInsert['soundcloud_url']=$soundcloud_url;
            $dataInsert['residentadvisor_url']=$residentadvisor_url;
            $dataInsert['twitter_url']=$twitter_url;
            $dataInsert['youtube_url']=$youtube_url;
            $dataInsert['instagram_url']=$instagram_url;
            $dataInsert['user_meta_data']=$pagemetatag;

            $dataInsert['dob']=$dateofbirth;

          }
            $chkvalid=$this->validateuserall($request,$uid);
           
            if($chkvalid===true)
            {
                //********* presskit starts here

                 if($request->hasFile('presskit_name'))
       
                {
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
                      
                       $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath) ; //$errfileAr
                       
                       
                        // echo "==Imcommonpath=>".$destinationsourcePath;
                         // echo "==chkimg1==><pre>";
                         // print_r($chkimgresp);
                         // echo "</pre>";  exit();
                   
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


                       if(!empty($uploadedsuccnames))
                       {
                              $user_id=$uid;
                              if ($request->session()->has('front_id_sess'))
                              {
                                    //  $user_id=$uid; // get session                     
                              
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
                       
            }
                       //**** file upload code ends
                       
                //********* presskit ends here

                //********* Latlong starts
if($formtype == 1)
{
                $countrynm = 'country_name';
                $statenm = 'state_name';
                $tblnm = 'location_country';
                $sttbl = 'location_state';
                $countryname = $this->getcommondetails($country,$countrynm,$tblnm);
                $statename = $this->getcommondetails($state,$statenm,$sttbl);
                //*********** get country name and state name ends here
                //*********** Get latlong starts here
                //$fullBookingAddress = $address1val.' '.$address2val.' '.$towndata.' '.$statename->state_name.' '.$countryname->country_name;
                $fullBookingAddress =  $address1."+".$address2."+".$city."+".$statename->state_name."+".$zip."+".$countryname->country_name;
                $latlog = getLatLong($fullBookingAddress);
                if($latlog['flag'] == 1)
                {
                   //echo "werewrewr";
                // $errormsgs='Please enter a valid address';

                $latitude = $latlog['latlong'][0]['latitude'];
                $longitude = $latlog['latlong'][0]['longitude'];
                $TimeZoneCheck = getTimezone($latitude,$longitude);
                $timezoneId = $TimeZoneCheck['timeZoneId'];
                $timezoneName = $TimeZoneCheck['timeZoneName'];


                    $dataInsert['addr_lat']=$latitude;
                    $dataInsert['addr_long']=$longitude;
                    $dataInsert['addr_timezone']=$timezoneId;

                    // echo "<pre>";
                    // print_r($dataInsert);die;
                    // echo "</pre>";

                }
            }


                //********* Latlong ends


            
                if(empty($uid))
                {
                    $dataInsert['password']=$en_pwd;
                    $dataInsert['user_type']='3';
                    $dataInsert['registration_date']=$today;
                    $dataInsert['status']='1';
                    
                    //*** insert  query
                    // echo "<pre>";
                    // print_r($dataInsert);die;
                    // echo "</pre>";
                    /*Insert query*/
                   $isInserted = DB::table('user_master')->insert($dataInsert);
                    
                    /*Last Insert id*/
                    //$isInserted=DB::getPdo()->lastInsertId();
                    // echo "====>".$last_insert_id;
                   $lastInserted=DB::getPdo()->lastInsertId();
                  //  $isInserted=1;
                    if($isInserted){
                        
                        //**** create user_uniqueid and update  starts
                            
                            $user_uniqueid="usr".time().'n'.$lastInserted;
                            
                            $updatear=array();
                            $updatear['user_uniqueid']=$user_uniqueid;
                            $chkupd= DB::table('user_master')->where('id',$lastInserted) ->update($updatear);
                            
                        //**** create user_uniqueid and update ends
                        
                    //    $name_toemail = $first_name.' '.$last_name;
                    //    $mailvalid=$this->sendEmailNewuser($name_toemail,$email,$username,$pwd); //*** Sending mail after inserting an user ***//
                    
                    //**********Email Send Code Starts here

                    $userssel = DB::table('settings')
                        ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                        ->where('id', 1)
                        ->get();
                  $sitenm=$userssel[0]->site_name;
                  $emailfrom=$userssel[0]->email_from;
                  $copyrightyr=$userssel[0]->copyright_year;
                  $Imgologo=$userssel[0]->email_template_logo_image;
                  $bsurl = url('/');
                  
                  
                  
                   // $logoIMG = asset('upload/settings-image/source-file/'.$Imgologo);
                   $logoIMG = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$Imgologo;
                  //*********Helper Function Starts here
                  $replacefrom =array('{NAME}','{USERNAME}','{PASSWORD}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                  $replaceto =array(ucfirst($first_name),$email,$en_pwd,$sitenm,$copyrightyr,$bsurl,$logoIMG);
                
               //   mailsnd($Temid=3,$replacefrom,$replaceto,$email);
                  //*********Helper Function Ends here 
                    
                    
                    
                    
                    
                    
                    //*********Email send code ends here
                    
                    
                    
                    }
                }
                else
                {
                     $dataInsert['modified_date']=$today;
                    //  echo "<pre>";
                    // print_r($dataInsert);die;
                    // echo "</pre>";
                      //*** update query
                      
                      $isInserted=DB::table('user_master')
                      ->where('id', $uid)
                      ->update($dataInsert);
                }
                
                if($isInserted >= 0 )
                {
                       $request->session()->flash('admin_successmsgdata_sess', 'User successfully saved');
                       return redirect(ADMINSEPARATOR.'/user');
                }
            
            }
            //elseif($chkvalid==1)
            else
            {
                if(empty($uid))
                {
                    $request->session()->flash('admin_errormsgdata_sess', 'Please fill the fields with proper informations');

                    return redirect(ADMINSEPARATOR.'/useradd')
                     ->withErrors($chkvalid)
                     ->withInput();
                }
                else
                {
                        $request->session()->flash('admin_errormsgdata_sess', 'Please fill the fields with proper informations');
                        return redirect(ADMINSEPARATOR.'/useradd/'.$uid)
                      ->withErrors($chkvalid)
                      ->withInput();
                }
            }
            
            //return redirect(ADMINSEPARATOR.'/usersadd'); 
    }
     
    public function deluser(Request $request,$uid=0)
    {
        if(!empty($uid))
        {
            $dataUpdate=array('status'=>'9');
            $isUpdated=DB::table('user_master')
                      ->where('id', $uid)
                      ->update($dataUpdate);
            //DB::table('user_master')->where('id', $uid)->delete();
            $request->session()->flash('admin_successmsgdata_sess', 'User successfully deleted');
        }
        
        return redirect(ADMINSEPARATOR.'/user');
    }
    
    public function validateuserall(Request $request,$userid=0)
    {

        // echo $request->input('email');die;
        $formtype = $request->input('formtype');

        if($formtype == 0)
        {
             $validator = Validator::make($request->all(), [
                'nickname' => "required|max:20",
                'email' => "required|email|unique:user_master,email,".$userid,
                'gender'=>"required",
                'dateofbirth'=> "required|date_format:m/d/Y",
                  ],
                [   
                'nickname.required'=>' * Nickname is required ',
                'nickname.max'=>' * Maximum 20 characters ',
                'email.required'=>' * Email is required ',
                'email.unique'=>' * Email should be unique ',
                'gender.required'=>' * Gender is required ',
                'dateofbirth.required'=>'* Date is required',
               
                'dateofbirth.date_format'=>'* Enter valid date format',
                 ]);
        }

        else if($formtype == 1)
        {

        $validator = Validator::make($request->all(), [
                'first_name' => "required|max:100",
                'middle_name' => "max:100",
                'last_name' => "required|max:100",
              //  'username' => "required|max:100|unique:user_master,username,".$userid,
                'nickname' => "required|max:20",
                'email' => "required|email|unique:user_master,email,".$userid,
                'gender'=>"required",
                // 'dateofbirth'=> "required|date|date_format:d/m/Y",
                'dateofbirth'=> "required|date_format:m/d/Y",
                'address1'=>"required",
                'country_id'=>"required",
                'state_id'=>"required",
                'city'=>"required",
                'zip'=>"required",
                'language_id'=>"required",
                'skill_id'=>"required",
                'subskill_id'=>"required",
                'currency'=>"required",
                'fburl' => "required|url",
                'soundcloudurl' => "required|url",
                'residentadvisorurl' => "required|url",
                'twitterurl' => "required|url",
                'youtubeurl' => "required|url",
                'instagramurl' => "required|url",

            ],
            [   'first_name.required'=>' * First name is required ',
                'first_name.max'=>' * Maximum 100 characters ',
                'middle_name.max'=>' * Maximum 100 characters ',
                'last_name.required'=>' * Last name is required ',
                'last_name.max'=>' * Maximum 100 characters ',
               // 'username.required'=>' * Username is required ',
               // 'username.max'=>' * Maximum 100 characters ',
               // 'username.unique'=>' * Username should be unique ',
                'nickname.required'=>' * Nickname is required ',
                'nickname.max'=>' * Maximum 20 characters ',
                'email.required'=>' * Email is required ',
                'email.unique'=>' * Email should be unique ',
                'gender.required'=>' * Gender is required ',
                'dateofbirth.required'=>'* Date is required',
               // 'datepicker2.date'=>'* Enter valid date',
                'dateofbirth.date_format'=>'* Enter valid date format',
                'address1.required'=>' * Address is required ',
                'country_id.required'=>' * Country is required ',
                'state_id.required'=>' * State is required ',
                'city.required'=>' * City is required ',
                'zip.required'=>' * Zip is required ',
                'language_id.required'=>' * Language is required ',
                'skill_id.required'=>' * Category is required ',
                'subskill_id.required'=>' * Sub-category is required ',
                'currency.required'=>' * Currency is required ',
                'fburl.required' => ' * FB url is required ', 
                'fburl.url' => ' * FB url is invalid ',
                'soundcloudurl.required' => ' * Soundcloud url is required ', 
                'soundcloudurl.url' => ' * Soundcloud url is invalid ',
                'residentadvisorurl.required' => ' * Residentadvisor url is required ', 
                'residentadvisorurl.url' => ' * Residentadvisor url is invalid ',
                'twitterurl.required' => ' * Twitter url is required ', 
                'twitterurl.url' => ' * Twitter url is invalid ',
                'youtubeurl.required' => ' * Youtube url is required ', 
                'youtubeurl.url' => ' * Youtube url is invalid ',
                'instagramurl.required' => ' * Instagram url is required ', 
                'instagramurl.url' => ' * Instagram url is invalid ',
            ]);
       
            //print_r($validator->fails());die;
            //echo $validator;die;
            $userData=array();
            $userData['request']=$request;
            $userData['addeditid']=$userid;

             $validator->after(function($validator)  use ($userData)  {
                        
                        $request=$userData['request'];
                        $addeditid=$userData['addeditid'];
                      
                        $validateaddresschk=$this->addressisinvalid($request,$addeditid);
                        
                        // echo "==validatefilechk==><pre>";
                        // print_r($validateaddresschk);
                        // echo "</pre>===="; exit();
                        
                        if (!empty($validateaddresschk))
                        {
                                $validator->errors()->add('address1', $validateaddresschk);
                                // echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                        }
                });


            //********for upload press kit validation starts here
                     if($request->hasFile('presskit_name'))
                     {

                     $validator->after(function($validator)  use ($userData)  {
                                    
                                    $request=$userData['request'];
                                    $addeditid=$userData['addeditid'];
                                  

                                    $destinationsourcePath=public_path()."/upload/press-kit/source-file/";  
                                    $validatepresschk=$this->presskitisinvalid($request,$destinationsourcePath,$addeditid);
                                    
                                    // echo "==validatefilechk==><pre>";
                                    // print_r($validateaddresschk);
                                    // echo "</pre>===="; exit();
                                    
                                    if (!empty($validatepresschk))
                                    {
                                         $validator->errors()->add('presskit_name', $validatepresschk);
                                             //echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                                    }
                            });
                 }
        }

         //******** for press kit upload validation ends here


        
        if ($validator->fails())
        {
            return $validator ;
        }
        return true;
        
        //$ret=$validator->fails();
        //return $ret;
    }
    
    public function statuschangeuser(Request $request)
    {
        //$country_name = $request->input('country_name','');
           
        $statuschange = $request->input('statuschange',0);
        $userid =    $request->input('userid',0);
        
        $respAr=array();
        $flagdata=0;
          
        if(!empty($userid) && ($userid>0) && in_array($statuschange,array(0,1)))
        {
            //*** update status starts
            
            $dataUpdate=array();
            $dataUpdate['status']=$statuschange;
            
            $updstaus=DB::table('user_master')
                  ->where('id', $userid)
                  ->update($dataUpdate);
                        
            if(!empty($updstaus))
            {
                   $flagdata=1;
                   if($statuschange==1)
                   {
                        $deactvfor='-----------------------------';
                   }
                   else{
                        $deactvfor='Deactivated by admin  ';
                   }
            }
                  
            //*** update status ends
        }
          
        $respAr['flag']=$flagdata;
        $respAr['iddata']=$userid;
        $respAr['deactvcz']=$deactvfor;
        echo  json_encode($respAr);
    }
    
    
    //****** Mail sending function while inserting user from admin panel starts ******//
    public function sendEmailNewuser($useremailname,$email,$username,$pwd)
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
                        ->where('id', 3)
                        ->get();
        $emailmsgname=$usersemail[0]->message;
        $emailsubname=$usersemail[0]->subject;



        //fetching email template data ends here  07-03-2016

        $subject = $emailsubname;
        $passarr['adminfrom']=$emailfrom;
        $passarr['sitename']=$sitename;
        $passarr['emailsub']=$subject;
        $passarr['emailto']=$email;
        
        $data = array(
                      'useremailtoname'=>$useremailname,'username'=>$username,'password'=>$pwd,'sitename'=>$sitename,'copyright_year'=>$copyright_year,'email_body'=>$emailmsgname
                      );
    
       $email_register = Mail::send('admin.emailviewfolder.registrationemailtenplate', $data, function ($message) use ($passarr) {
    
            $message->from($passarr['adminfrom'], $passarr['sitename']);
    
            $message->to($passarr['emailto'])->subject($passarr['emailsub']);
    
        });
       return $email_register;
    }
    //****** Mail sending function while inserting user from admin panel ends ******//
    
    
    public function deactivationreasonfunc(Request $request)
    {
        $respAr=array();
        $recentuserid = $request->input('recentuserid');
        $userssel = DB::table('user_deatcivate_reason')
                    ->select(DB::raw('deactivate_reason,create_date'))
                    ->where('user_id',$recentuserid)
                    ->get();
        $deactivate_reason=$userssel[0]->deactivate_reason;
        $deactivate_date=$userssel[0]->create_date;
        $respAr['deactivate_reason']=$deactivate_reason;
        $respAr['deactivate_date']=$deactivate_date;
        echo json_encode($respAr);
    }
    
    public function statusdeactivatefunc(Request $request)
    {
        $error_msgAr='';
        $responseAr=array();
        $flag_id=0;
        $cause= $request->input('cause');
        $userid = $request->input('userid');
        $dataInsert=array();
        $today=date('Y-m-d H:i:s');
        $dataInsert['deactivate_reason']= stripslashes($cause);
        $dataInsert['user_id']=$userid;
        $dataInsert['create_date']=$today;
        $chkvalid=$this->checkdeactivatingreasonform($request);
        if($chkvalid===true)
        {
            $userdeacti = DB::table('user_deatcivate_reason')
                      ->select(DB::raw('id'))
                      ->where('user_id', $userid)
                      ->get();
            $deactiuserid=$userdeacti[0]->id;
            if(!empty($deactiuserid))
            {
                $isInserted= DB::table('user_deatcivate_reason')->where('id',$deactiuserid) ->update($dataInsert);
            }
            else{
                $isInserted = DB::table('user_deatcivate_reason')->insert($dataInsert);
            }
            if(!empty($isInserted))
            { $flag_id=1; }
        }       
        else
        {                 
            $error_message = $chkvalid->messages();
        }
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
    
    public function checkdeactivatingreasonform(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'cause' => "required",
            ],
            [
                'cause.required'=>' * Please give valid reason ',
            ]);
        if ($validator->fails())
        {
            return $validator ;
        }
        return true;
    }

    public function countrywisestatefunc(Request $request)
    {
        $country_id=$request->input('country_id');
		$respAr=array();
        $state_data=array();
        $resp=array();
		if(!empty($country_id))
		{
            $statedetail = DB::table('location_state')
                      ->select(DB::raw('id,state_name'))
                      ->where('country_id', $country_id)
                      ->where('published', 1)
                      ->orderBy('state_name')
                      ->get();
			if(!empty($statedetail))
			{
				foreach ($statedetail as $row)
                {
                        //$respAr[$row->$key_val_name]=$row->$key_txt_name;
                        $respAr[]=array('state_id'=>$row->id,'state_name'=>$row->state_name);
                }
			}
		}
		echo json_encode($respAr);
    }
    
    public function skillwisesubskillfunc(Request $request)
    {
        $skill_id=$request->input('skill_id');
		$respAr=array();
        $subskill_data=array();
        $resp=array();
		if(!empty($skill_id))
		{
            $subskilldetail = DB::table('skill_master')
                      ->select(DB::raw('id,name,seo_name'))
                      ->where('parent_id', $skill_id)
                      ->where('status', 1)
                      ->where('catag_type', 1)
                      ->get();
			if(!empty($subskilldetail))
			{
				foreach ($subskilldetail as $row)
                {
                        //$respAr[$row->$key_val_name]=$row->$key_txt_name;
                        $respAr[]=array('subskill_id'=>$row->id,'subskill_name'=>$row->name);
                }
			}
		}
		echo json_encode($respAr);
    }




     public function addressisinvalid($request,$addeditid=0)
        {   
             $invalidresp=false;
             $errormsgs=''; 
                
                $address1 = trim($request->input('address1'));
                $address2 = trim($request->input('address2'));
                $country = $request->input('country_id');
                $state = $request->input('state_id');
                $city = trim($request->input('city'));
                $zip = trim($request->input('zip'));

                $countrynm = 'country_name';
                $statenm = 'state_name';
                $tblnm = 'location_country';
                $sttbl = 'location_state';
                $countryname = $this->getcommondetails($country,$countrynm,$tblnm);
                $statename = $this->getcommondetails($state,$statenm,$sttbl);

                $snm ='';
                if($statename)
                {
                   $snm =  $statename->state_name;
                }

               $cnm ='';
               if($countryname)
               {
              $cnm = $countryname->country_name;
          }


                $fullBookingAddress =  $address1."+".$address2."+".$city."+".$snm."+".$zip."+".$cnm;
                $latlog = getLatLong($fullBookingAddress);
      
              if($latlog['flag'] != 1)
              {
        
                    $errormsgs='Please enter a valid address';
      
               }
               
               
                return $errormsgs;
        }

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



   //******* Presskit validation 

   public function presskitisinvalid($request,$destinationsourcePath,$addeditid=0)
        {   

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
                
                
              //  $destinationsourcePath=public_path()."/upload/press-kit/source-file/";                       
                $chkprsresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$destinationsourcePath,$errfileAr=array()) ;
                       
                
                
                
               
                // echo "==chkimg1==><pre>";
                // print_r($chkprsresp);
                // echo "</pre>";  //exit();
                
               
               $invalidresp=false;
               
               $errormsgs='';  $fileuploadednames=array(); $errfileAr=array();
               $totalfileposted=0;
               
                if(!empty($chkprsresp))
                {
                        
                        
                        if(array_key_exists('errormsgs',$chkprsresp))
                        {
                                $errormsgs=$chkprsresp['errormsgs'];
                        }
                        
                        // if(array_key_exists('errfileAr',$chkprsresp))
                        // {
                        //         $errfileAr=$chkprsresp['errfileAr'];
                        // }
                        
                        // if(array_key_exists('totalfileposted',$chkprsresp))
                        // {
                        //         $totalfileposted=$chkprsresp['totalfileposted'];
                        // }
                        
                }
                
                // $resparray=array();
                // $resparray['errormsgs']=$errormsgs;
                // $resparray['errfileAr']=$errfileAr;
                // $resparray['totalfileposted']=$totalfileposted;
                // echo $errormsgs; die;

               return $errormsgs;
//                 echo "<pre>";
//                 print_r($resparray);

// die;









        }

   //******* presskit validation

        //******** download presskit
        public function userpresskitadmindownload($file_name)
        {
            $filennmdownload = base64_decode($file_name);
         //echo $filennmdownload;die;
          //********its working for single file
          $download_path = ( public_path() . '/upload/press-kit/source-file/' . $filennmdownload );
          return( Response::download( $download_path ) );
        }



        //******* create group starts here

        public function addusergroup()
        {
            echo "I am creating a group";
        }

        



        public function adduservenue(Request $request,$id=0,$venueid=0)

{

          $usrvenue_stateID = '';
          $data=array();
          $data['data1']="hello";




            $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
            $errormsgdata=$request->session()->get('admin_errormsgdata_sess');

            if(!empty($successmsgdata))
            {
            $data['successmsgdata']=$successmsgdata;
            }
            if(!empty($errormsgdata))
            {
            $data['errormsgdata']=$errormsgdata;               
            }
        
         
          if(!empty($id))
          {
            if($id == 1)
            {
                return redirect(ADMINSEPARATOR.'/user');
            }
            //**** fetch data starts
            $usrowcount = DB::table('user_master as um')->where('um.id', $id)->count();
            if($usrowcount  == 0)
            {
                return redirect(ADMINSEPARATOR.'/user');
            }
            if(!empty($venueid))
            {
               $uservenuerowcount = DB::table('venue_master as vm')->where('vm.creater_id', $id)->where('vm.id', $venueid)->count();
               if($uservenuerowcount == 0)
               {
                 return redirect(ADMINSEPARATOR.'/user');
               }
            }

            // echo $uservenuerowcount;die;

            $uservenuerow = DB::table('venue_master as vm')->where('vm.creater_id', $id)->first();
            if($uservenuerow)
            {
                $data['uservenuerow']=$uservenuerow;
                $usrvenue_stateID = $uservenuerow->country;
            }
            //**** fetch data ends 

            //******** fetch user press kit
            $uservenuerow_press = DB::table('venue_presskit as upkv')->where('upkv.venue_id', $id)->first();
            if($uservenuerow_press)
            {
                $data['uservenuerow_press']=$uservenuerow_press;
            }

          }
          
          //******** fetch country data for drop down starts
        
        $country_db = DB::table('location_country as lc');
        $country_db=$country_db->select(DB::raw('lc.id,lc.country_name,lc.published'));
        $country_db=$country_db->where('lc.published', '=', 1);
        $country_db=$country_db->orderBy('lc.country_name', 'asc');
        $country_db= $country_db->get();
        
        //echo "<pre>"; print_r($country_db); exit();
        $countryidAr=array();
        $countryidAr['']="Select a country";
        if(!empty($country_db))
        {
                foreach($country_db as $country_obj)
                {
                        $countryidAr[$country_obj->id]=stripslashes($country_obj->country_name);
                }
                
        }
        
        $data['countryidAr']=$countryidAr;
        
        //******** fetch country data for drop down ends

        //******** fetch state drop down starts
          $stateidAr=array();
          if(!empty($usrvenue_stateID))
          {
            $stateres_db =  DB::table('location_state')->where('country_id',$usrvenue_stateID)->where('published','1')->get();
                            if(!empty($stateres_db))
                            {
                                foreach($stateres_db as $stateres_obj)
                                {
                                $stateidAr[$stateres_obj->id]=stripslashes($stateres_obj->state_name);
                                }

                            }
          }
          $data['stateidAr']=$stateidAr;
        //******** fetch state drop down ends
        //******** fetch skill data for drop down starts
        
        $skill_db = DB::table('skill_master as sm');
        $skill_db=$skill_db->select(DB::raw('sm.id,sm.name,sm.seo_name'));
        $skill_db=$skill_db->where('sm.status', '=', 1);
        $skill_db=$skill_db->where('sm.parent_id', '=', 0);
        $skill_db=$skill_db->where('sm.catag_type', '=', 1);
        $skill_db=$skill_db->orderBy('sm.name', 'asc');
        $skill_db=$skill_db->get();
        
        //echo "<pre>"; print_r($country_db); exit();
        $skillidAr=array();
        $skillidAr['']="Select a skill";
        if(!empty($skill_db))
        {
                foreach($skill_db as $skill_obj)
                {
                        $skillidAr[$skill_obj->id]=stripslashes($skill_obj->name);
                }
                
        }
        
        $data['skillidAr']=$skillidAr;
        
        //******** fetch skill data for drop down ends
        
        //******** fetch currency data for drop down starts
        
        $currency_db = DB::table('currencylist as cl');
        $currency_db=$currency_db->select(DB::raw('cl.id,cl.currency_name,cl.published'));
        $currency_db=$currency_db->where('cl.published', '=', 1);
        $currency_db=$currency_db->orderBy('cl.currency_name', 'asc');
        $currency_db= $currency_db->get();
        
        //echo "<pre>"; print_r($country_db); exit();
        $currencyidAr=array();
        $currencyidAr['']="Select a currency";
        if(!empty($currency_db))
        {
                foreach($currency_db as $currency_obj)
                {
                        $currencyidAr[$currency_obj->id]=stripslashes($currency_obj->currency_name);
                }
                
        }
        
        $data['currencyidAr']=$currencyidAr;


        //******** get all amenities starts here
       $qryall_amenity = DB::table('amenity_master')->where('status','1')->get();
       $data['amenity_all'] = $qryall_amenity;

       //*******select ID based amenity
       $amenityIDAr=array();
       if(!empty($id))
          {
          //  echo $id;die;
                $qry_select_amenity = DB::table('venue_amenity_rel')->select('amenity_id')->where('v_creator_id',$id)->get();
               

                   if(!empty($qry_select_amenity))
                        {
                                foreach($qry_select_amenity as $amenitiesqry_venue_obj)
                                {
                                        $amenityIDAr[]=$amenitiesqry_venue_obj->amenity_id;
                                     
                                }
                                
                        }
          }

        $data['qry_select_amenity'] = $amenityIDAr;

        $qry_select_user_status = DB::table('user_master')->select('status')->where('id',$id)->first();
        $data['user_status_chk'] = $qry_select_user_status->status;
         // echo '<pre>';
         // print_r($data['user_status_chk']);die;


        //******** get all amenities ends here
        
        //******** fetch currency data for drop down ends
        // if(!empty($id))
        // {
        //     if(!$uservenuerow)
        //     {
        //         $request->session()->flash('admin_errormsgdata_sess', 'This venue does not exists');
        //         return redirect(ADMINSEPARATOR.'/user');
        //     }
        // }
         //******** fetch user press kit
            $venuerow_press = DB::table('venue_presskit as upk')->where('upk.v_creator_id', $id)->first();
            if($venuerow_press)
            {
                $data['venuerow_press']=$venuerow_press;
            }

            $venuerow_menu = DB::table('venue_menu as vmnu')->where('vmnu.v_creator_id', $id)->first();
            if($venuerow_menu)
            {
                $data['venuerow_menu']=$venuerow_menu;
            }
     
        return view('admin.user.uservenueadd', $data);
    }  


    public function saveuservenue(Request $request)
    {

            $formtype = $request->input('formtype');

            $nickname = trim(addslashes($request->input('nickname')));
            $address1 = trim(addslashes($request->input('address1')));
            $address2 = trim(addslashes($request->input('address2')));
            $country = $request->input('country_id');
            $state = $request->input('state_id');
            $city = trim(addslashes($request->input('city')));
            $zip = trim($request->input('zip'));
        
            $abn=trim($request->input('abn'));
            $tfn=trim($request->input('tfn'));
          
            $rider=trim(addslashes($request->input('rider')));
            $description=trim(addslashes($request->input('description')));
            $fb_url = $request->input('fburl');
            $soundcloud_url= $request->input('soundcloudurl');
            $residentadvisor_url = $request->input('residentadvisorurl');
            $twitter_url = $request->input('twitterurl');
            $youtube_url = $request->input('youtubeurl');
            $instagram_url = $request->input('instagramurl');  
            $pagemetatag=trim($request->input('pagemeta'));

            $valchk = $request->input('valchk');

            $uid = $request->input('uid'); //die;
            $ucreaterid = $request->input('ucreaterid'); 

            $chkvalidvenue=$this->validateuservenueall($request,$uid);

        if($chkvalidvenue===true)
        {


            //******
             $dataInsertvenue=array();
                                 $countrynm = 'country_name';
                                $statenm = 'state_name';
                                $tblnm = 'location_country';
                                $sttbl = 'location_state';
                                $countryname = $this->getcommondetails($country,$countrynm,$tblnm);
                                $statename = $this->getcommondetails($state,$statenm,$sttbl);
                                //*********** get country name and state name ends here
                                //*********** Get latlong starts here
                                //$fullBookingAddress = $address1val.' '.$address2val.' '.$towndata.' '.$statename->state_name.' '.$countryname->country_name;
                                $fullBookingAddress =  $address1."+".$address2."+".$city."+".$statename->state_name."+".$zip."+".$countryname->country_name;
                                $latlog = getLatLong($fullBookingAddress);
                                if($latlog['flag'] == 1)
                                {
                                   //echo "werewrewr";
                                // $errormsgs='Please enter a valid address';

                                                    $latitude = $latlog['latlong'][0]['latitude'];
                                                    $longitude = $latlog['latlong'][0]['longitude'];
                                                    $TimeZoneCheck = getTimezone($latitude,$longitude);
                                                    $timezoneId = $TimeZoneCheck['timeZoneId'];
                                                    $timezoneName = $TimeZoneCheck['timeZoneName'];


                                                    $dataInsertvenue['venue_lat']=$latitude;
                                                    $dataInsertvenue['venue_long']=$longitude;
                                                    $dataInsertvenue['venue_timezone']=$timezoneId;

                                }





                               
                                $dataInsertvenue['nickname']=$nickname;
                                $dataInsertvenue['creater_id']=$ucreaterid;
                                $dataInsertvenue['address_1']=$address1;
                                $dataInsertvenue['address_2']=$address2;
                                $dataInsertvenue['country']=$country;
                                $dataInsertvenue['state']=$state;
                                $dataInsertvenue['city']=$city;
                                $dataInsertvenue['zip']=$zip;
                                $dataInsertvenue['abn_data']=$abn;
                                $dataInsertvenue['tfn_data']=$tfn;
                               // $dataInsert['currency']=$currency;
                                $dataInsertvenue['rider_data']=$rider;
                                $dataInsertvenue['venue_description']=$description;
                                $dataInsertvenue['facebook_url']=$fb_url;
                                $dataInsertvenue['soundcloud_url']=$soundcloud_url;
                                $dataInsertvenue['residentadvisor_url']=$residentadvisor_url;
                                $dataInsertvenue['twitter_url']=$twitter_url;
                                $dataInsertvenue['youtube_url']=$youtube_url;
                                $dataInsertvenue['instagram_url']=$instagram_url;
                                $dataInsertvenue['venue_meta_data']=$pagemetatag;

                                if(empty($uid))
                                {
                                    $dataInsertvenue['type_flag']=3;
                                    $dataInsertvenue['create_date']=date('Y-m-d H:i:s');

                                                $isInserted = DB::table('venue_master')->insert($dataInsertvenue);

                                                 $request->session()->flash('admin_successmsgdata_sess', 'Venue created successfully');
                                                /*Last Insert id*/
                                                //$isInserted=DB::getPdo()->lastInsertId();
                                                // echo "====>".$last_insert_id;
                                                $lastInserted=DB::getPdo()->lastInsertId();
                                                $uid = $lastInserted;


                                                $nickname = strtolower($nickname);
                                                $seotitle = str_slug($nickname, '-').'-'.$lastInserted;

                                                $dataInsertvenueseo =array();
                                                $dataInsertvenueseo['seo_name']=$seotitle;

                                                $chkupdvenueseo= DB::table('venue_master')->where('id',$uid) ->update($dataInsertvenueseo);
                                }else
                                {
                                                 $request->session()->flash('admin_successmsgdata_sess', 'Venue updated successfully');
                                                $dataInsertvenue['modified_date']=date('Y-m-d H:i:s');
                                                //$dataInsertvenueseo =array();
                                                $nickname = strtolower($nickname);
                                                $seotitle = str_slug($nickname, '-').'-'.$uid;
                                                $dataInsertvenue['seo_name']=$seotitle;

                                                $chkupdvenue= DB::table('venue_master')->where('id',$uid) ->update($dataInsertvenue);
                                }

                                // echo "<pre>";
                                // print_r($dataInsertvenue);die;

            //******
            //echo 'success';
                                 //*********presskit upload starts here

                                        if($request->hasFile('presskit_name'))
                                        {
                                            $allowedFileExtAr=array();
                                            $allowedFileExtAr[]="pdf";


                                            $filecontrolname="presskit_name";


                                            $allowedFileExtSizeAr=array();
                                            $allowedFileExtSizeAr['pdf']=(5*1024*1024);                      


                                            //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                                            $allowedFileResolAr=array();

                                            // $allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);

                                            $func="uploadfile";//validatefile/uploadfile


                                            $destinationsourcePath=public_path()."/upload/venue-press-kit/source-file/";                         

                                            $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath) ; //$errfileAr

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
                                            if(!empty($uploadedsuccnames))
                                           {
                                                      $user_id=$uid;
                                                      if ($request->session()->has('front_id_sess'))
                                                      {
                                                            //  $user_id=$uid; // get session                     
                                                      
                                                      }
                                                      //*** check whether any prev presskit present starts
                                                                  $selectstr=" upk.* ";
                                                                  
                                                                  $user_presskit_db=DB::table('venue_presskit as upk');              
                                                                  $user_presskit_db=$user_presskit_db->select(DB::raw($selectstr));                                                          
                                                                  $user_presskit_db=$user_presskit_db->where('upk.v_creator_id', $ucreaterid);
                                                                  $user_presskit_db=$user_presskit_db->where('upk.venue_id', $user_id);                                          
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
                                                                        
                                                                        $updtusrmstr= DB::table('venue_presskit');
                                                                        $updtusrmstr= $updtusrmstr->where('venue_id',$user_id) ;
                                                                         $updtusrmstr= $updtusrmstr->where('v_creator_id',$ucreaterid) ;
                                                                        $updtusrmstr=$updtusrmstr->update(
                                                                        ['presskit_name' =>addslashes($user_presskit_name),
                                                                         'create_date'=>date('Y-m-d H:i:s')    
                                                                         ]
                                                                        );
                                                                        
                                                                        //*** unlink previous presslit  file
                                                                        
                                                                        $srcpresskit=public_path()."/upload/venue-press-kit/source-file/".$presskit_name;
                                                
                                                                         @unlink($srcpresskit);
                                                                        
                                                                       
                                                            }else
                                                            {
                                                                       //**** insert qry
                                                                       
                                                                        $presskit_array=array();                                                
                                                                        
                                                                        $presskit_array['presskit_name']=addslashes($user_presskit_name);
                                                                        $presskit_array['venue_id']=$user_id;
                                                                        $presskit_array['v_creator_id']=$ucreaterid;
                                                                        $presskit_array['create_date']=date('Y-m-d H:i:s');                                    
                                                                        $chkupd= DB::table('venue_presskit')->insert($presskit_array );
                                                                        $last_insert_id=DB::getPdo()->lastInsertId(); 
                                                                       
                                                            }
                                                           
                                                       
                                                            
                                                      }
                                            }
                                               
                                    }

                                    //*********presskit upload ends here

                                    //*******amenity insert data starts here

                                                $amnty  = count($valchk);
                                                if($amnty>0 || $amnty==0)
                                                {
                                                DB::table('venue_amenity_rel')
                                                ->where('venue_id', $uid)
                                                ->where('v_creator_id', $ucreaterid)
                                                ->delete();

                                                    if($amnty>0)
                                                    {
                                                        
                                                        for($i=0;$i<$amnty;$i++)
                                                        {
                                                        DB::table('venue_amenity_rel')->insert([

                                                        ['venue_id' => $uid,'v_creator_id' => $ucreaterid, 'amenity_id' => $valchk[$i],'create_date' =>date('Y-m-d H:i:s')]
                                                        ]);
                                                        }
                                                    }

                                                }

                                    //*******amenity insert data ends here









                                    //*********menu upload starts here

                                        if($request->hasFile('venue_menu'))
                                        {
                                            $allowedFileExtAr=array();
                                            $allowedFileExtAr[]="pdf";


                                            $filecontrolname="venue_menu";


                                            $allowedFileExtSizeAr=array();
                                            $allowedFileExtSizeAr['pdf']=(5*1024*1024);                      


                                            //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                                            $allowedFileResolAr=array();

                                            // $allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);

                                            $func="uploadfile";//validatefile/uploadfile


                                            $destinationsourcePath=public_path()."/upload/venue-menu/source-file/";                         

                                            $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath) ; //$errfileAr

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
                                                                        $uploadedsuccnamesmenue[]=$presskitfileName;
                                                               }                           

                                                        }

                                                }
                                            if(!empty($uploadedsuccnamesmenue))
                                           {
                                                      $user_id=$uid;
                                                      if ($request->session()->has('front_id_sess'))
                                                      {
                                                            //  $user_id=$uid; // get session                     
                                                      
                                                      }
                                                      //*** check whether any prev presskit present starts
                                                                  $selectstr=" upk.* ";
                                                                  
                                                                  $user_presskit_db=DB::table('venue_menu as upk');              
                                                                  $user_presskit_db=$user_presskit_db->select(DB::raw($selectstr));                                                          
                                                                  $user_presskit_db=$user_presskit_db->where('upk.v_creator_id', $ucreaterid);
                                                                  $user_presskit_db=$user_presskit_db->where('upk.venue_id', $user_id);                                          
                                                                  $user_presskit_db = $user_presskit_db->skip(0)->take(1);
                                                                  $user_presskit_db=$user_presskit_db->first();
                                                                  $menu_name='';
                                                                  if(!empty($user_presskit_db))
                                                                  {
                                                                        $menu_name=stripslashes($user_presskit_db->menu_name);
                                                                  }
                                                                
                                                       //*** check whether any prev presskit present ends
                                                    foreach($uploadedsuccnamesmenue as $venue_menu_name)
                                                    {
                                                            
                                                           
                                                            
                                                            if(!empty($user_presskit_db))
                                                            {
                                                                        //**** update qry
                                                                        
                                                                        $updtusrmstr= DB::table('venue_menu');
                                                                        $updtusrmstr= $updtusrmstr->where('venue_id',$user_id) ;
                                                                         $updtusrmstr= $updtusrmstr->where('v_creator_id',$ucreaterid) ;
                                                                        $updtusrmstr=$updtusrmstr->update(
                                                                        ['menu_name' =>addslashes($venue_menu_name),
                                                                         'create_date'=>date('Y-m-d H:i:s')    
                                                                         ]
                                                                        );
                                                                        
                                                                        //*** unlink previous presslit  file
                                                                        
                                                                        $srcpresskit=public_path()."/upload/venue-menu/source-file/".$menu_name;
                                                
                                                                         @unlink($srcpresskit);
                                                                        
                                                                       
                                                            }else
                                                            {
                                                                       //**** insert qry
                                                                       
                                                                        $presskit_array=array();                                                
                                                                        
                                                                        $presskit_array['menu_name']=addslashes($venue_menu_name);
                                                                        $presskit_array['venue_id']=$user_id;
                                                                        $presskit_array['v_creator_id']=$ucreaterid;
                                                                        $presskit_array['create_date']=date('Y-m-d H:i:s');                                    
                                                                        $chkupd= DB::table('venue_menu')->insert($presskit_array );
                                                                        $last_insert_id=DB::getPdo()->lastInsertId(); 
                                                                       
                                                            }
                                                           
                                                       
                                                            
                                                      }
                                            }
                                               
                                    }

                                    //*********menu upload ends here
               
                return redirect(ADMINSEPARATOR.'/user');


        }
        else
        {
            if(!empty($uid))
            {
                 $request->session()->flash('admin_errormsgdata_sess', 'Please fill the fields with proper informations');
             return redirect(ADMINSEPARATOR.'/useradd/venueadd/'.$ucreaterid.'/'.$uid)
                     ->withErrors($chkvalidvenue)
                     ->withInput();
                    //echo 'error occurs';
            }else
            {
                 $request->session()->flash('admin_errormsgdata_sess', 'Please fill the fields with proper informations');
                return redirect(ADMINSEPARATOR.'/useradd/venueadd/'.$ucreaterid)
                     ->withErrors($chkvalidvenue)
                     ->withInput();
            }
        }
                         
          
    }




     



                             public function validateuservenueall(Request $request,$userid)
                            {
                             
                                            $formtype = $request->input('formtype');
                                            $validator = Validator::make($request->all(), [

                                            'nickname' => "required|max:20|unique:venue_master,nickname,".$userid,
                                            'address1'=>"required",
                                            'country_id'=>"required",
                                            'state_id'=>"required",
                                            'city'=>"required",
                                            'zip'=>"required",
                                            'skill_id'=>"required",
                                            'subskill_id'=>"required",
                                            'fburl' => "required|url",
                                            'soundcloudurl' => "required|url",
                                            'residentadvisorurl' => "required|url",
                                            'twitterurl' => "required|url",
                                            'youtubeurl' => "required|url",
                                            'instagramurl' => "required|url",

                                            ],
                                            [   
                                            'nickname.required'=>' * Nickname is required ',
                                             'nickname.unique'=>' * venue name already exists try some another name',
                                            'nickname.max'=>' * Maximum 20 characters ',
                                            'address1.required'=>' * Address is required ',
                                            'country_id.required'=>' * Country is required ',
                                           'state_id.required'=>' * State is required ',
                                            'city.required'=>' * City is required ',
                                            'zip.required'=>' * Zip is required ',
                                            'skill_id.required'=>' * Category is required ',
                                            'subskill_id.required'=>' * Sub-category is required ',
                                            'fburl.required' => ' * FB url is required ', 
                                            'fburl.url' => ' * FB url is invalid ',
                                            'soundcloudurl.required' => ' * Soundcloud url is required ', 
                                            'soundcloudurl.url' => ' * Soundcloud url is invalid ',
                                            'residentadvisorurl.required' => ' * Residentadvisor url is required ', 
                                            'residentadvisorurl.url' => ' * Residentadvisor url is invalid ',
                                            'twitterurl.required' => ' * Twitter url is required ', 
                                            'twitterurl.url' => ' * Twitter url is invalid ',
                                            'youtubeurl.required' => ' * Youtube url is required ', 
                                            'youtubeurl.url' => ' * Youtube url is invalid ',
                                            'instagramurl.required' => ' * Instagram url is required ', 
                                            'instagramurl.url' => ' * Instagram url is invalid ',
                                            ]);

                                              // print_r($validator->fails());die;
                                                // print_r($validator);die;
                                                $userData=array();
                                                $userData['request']=$request;
                                                $userData['addeditid']=$userid;

                                                $validator->after(function($validator)  use ($userData)  {

                                                $request=$userData['request'];
                                                $addeditid=$userData['addeditid'];
                                                $validateaddresschk=$this->addressisinvalid($request,$addeditid);
                                                if (!empty($validateaddresschk))
                                                {
                                                $validator->errors()->add('address1', $validateaddresschk);

                                                }
                                                });


                                                //********for upload press kit validation starts here
                                                if($request->hasFile('presskit_name'))
                                                {

                                                    $validator->after(function($validator)  use ($userData)  {

                                                    $request=$userData['request'];
                                                    $addeditid=$userData['addeditid'];
                                                    $destinationsourcePath=public_path()."/upload/venue-press-kit/source-file/";  
                                                    $validatepresschk=$this->presskitisinvalid($request,$destinationsourcePath,$addeditid);
                                                    if (!empty($validatepresschk))
                                                    {
                                                    $validator->errors()->add('presskit_name', $validatepresschk);
                                                    //echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                                                    }
                                                    });
                                                }




                                                if($request->hasFile('venue_menu'))
                                                {

                                                    $validator->after(function($validator)  use ($userData)  {

                                                    $request=$userData['request'];
                                                    $addeditid=$userData['addeditid'];
                                                    $destinationsourcePath=public_path()."/upload/venue-menu/source-file/";  
                                                    $validatepresschk=$this->menuisinvalid($request,$destinationsourcePath,$addeditid);
                                                    if (!empty($validatepresschk))
                                                    {
                                                    $validator->errors()->add('venue_menu', $validatepresschk);
                                                    //echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                                                    }
                                                    });
                                                }



                                                //}

                                                //******** for press kit upload validation ends here


        //echo "hello";die;
                                                        if ($validator->fails())
                                                        {
                                                           // echo "ewrwer";
                                                            // print_r($validator);die;
                                                            return $validator;
                                                        }


                                                        // echo "hello";
                                                        // die;

                                                        return true;
        
       
    

                            }









                             //******* Presskit validation 

   public function menuisinvalid($request,$destinationsourcePath,$addeditid=0)
        {   

                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="pdf";
                
                
                $filecontrolname="venue_menu";
                
               
                $allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['pdf']=(5*1024*1024);
                
                
                
                
                //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                $allowedFileResolAr=array();
                
                //$allowedFileResolAr['jpeg']=array('min_width'=>537,'min_height'=>507);
                
                $func="validatefile";//validatefile/uploadfile
                
                
              //  $destinationsourcePath=public_path()."/upload/press-kit/source-file/";                       
                $chkprsresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$destinationsourcePath,$errfileAr=array()) ;
                       
                
                
                
               
                // echo "==chkimg1==><pre>";
                // print_r($chkprsresp);
                // echo "</pre>";  //exit();
                
               
               $invalidresp=false;
               
               $errormsgs='';  $fileuploadednames=array(); $errfileAr=array();
               $totalfileposted=0;
               
                if(!empty($chkprsresp))
                {
                        
                        
                        if(array_key_exists('errormsgs',$chkprsresp))
                        {
                                $errormsgs=$chkprsresp['errormsgs'];
                        }
                        
                        // if(array_key_exists('errfileAr',$chkprsresp))
                        // {
                        //         $errfileAr=$chkprsresp['errfileAr'];
                        // }
                        
                        // if(array_key_exists('totalfileposted',$chkprsresp))
                        // {
                        //         $totalfileposted=$chkprsresp['totalfileposted'];
                        // }
                        
                }
                
                // $resparray=array();
                // $resparray['errormsgs']=$errormsgs;
                // $resparray['errfileAr']=$errfileAr;
                // $resparray['totalfileposted']=$totalfileposted;
                // echo $errormsgs; die;

               return $errormsgs;
//                 echo "<pre>";
//                 print_r($resparray);

// die;









        }

   //******* presskit validation





        //********download presskit venue starts

            
            public function uservenuepresskitadmindownload($file_name)
            {
            $filennmdownload = base64_decode($file_name);
            //echo $filennmdownload;die;
            //********its working for single file
            $download_path = ( public_path() . '/upload/venue-press-kit/source-file/' . $filennmdownload );
            return( Response::download( $download_path ) );
            }

        //********doenload preskit venue ends



        //********download presskit venue starts

            
            public function uservenuemenuadmindownload($file_name)
            {
            $filennmdownload = base64_decode($file_name);
            //echo $filennmdownload;die;
            //********its working for single file
            $download_path = ( public_path() . '/upload/venue-menu/source-file/' . $filennmdownload );
            return( Response::download( $download_path ) );
            }

        //********doenload preskit venue ends

}
?>