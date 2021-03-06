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
        $users_db=$users_db->select(DB::raw('um.id,CONCAT_WS(" ",um.first_name,um.last_name) AS name,um.nickname,um.email,um.status,um.verify_status,gm.id AS grp,vm.id AS ven'));
        $users_db=$users_db->where('um.user_type', 3);
        $users_db=$users_db->where('um.status','<>', 9);
        if(!empty($srch1))
        {
            $users_db=$users_db->where('um.nickname', 'like', "%".$srch1."%");
            $users_db=$users_db->orWhere('um.email','=',$srch1);
            $users_db=$users_db->where('um.user_type', 3);
            $users_db=$users_db->where('um.status','<>', 9);
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
        
        // $skill_db = DB::table('skill_master as sm');
        // $skill_db=$skill_db->select(DB::raw('sm.id,sm.name,sm.seo_name'));
        // $skill_db=$skill_db->where('sm.status', '=', 1);
        // $skill_db=$skill_db->where('sm.parent_id', '=', 0);
        // $skill_db=$skill_db->where('sm.catag_type', '=', 1);
        // $skill_db=$skill_db->orderBy('sm.name', 'asc');
        // $skill_db=$skill_db->get();
        
        // //echo "<pre>"; print_r($country_db); exit();
        // $skillidAr=array();
        // $skillidAr['']="Select a skill";
        // if(!empty($skill_db))
        // {
        //         foreach($skill_db as $skill_obj)
        //         {
        //                 $skillidAr[$skill_obj->id]=stripslashes($skill_obj->name);
        //         }
                
        // }

                    $parentskill_db = DB::table('skill_master');
                        $parentskill_db=$parentskill_db->where('status',1);
                        $parentskill_db=$parentskill_db->where('parent_id',0);
                        $parentskill_db=$parentskill_db->whereRaw(" FIND_IN_SET('1',`catag_type`) ");
                        $parentskill_db=$parentskill_db->orderBy('id', 'asc');
                        $parentskill_db=$parentskill_db->get();

                    $fetchskillmasterdata=$parentskill_db;
                    $fetchskillmasterAr=array();

                    if(!empty($fetchskillmasterdata))
                    {
                        foreach( $fetchskillmasterdata as $fetchskillobj )
                        {
                        $fetchskillmasterAr[$fetchskillobj->id]=$fetchskillobj->name;
                        }
                    } 
        
        $data['skillidAr']=$fetchskillmasterAr;
        
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

        //******fetch user image starts here
       
        if($id){
                $userimage_admin = DB::table("user_master_img")
                                    ->where('user_id',$id)
                                    ->get();
                
                $data['userimage_admin']=$userimage_admin;
                $data['user_image_admin_count']=count($userimage_admin);
        }else{
           $data['userimage_admin']=''; 
           $data['user_image_admin_count']=0;
        }

        //******fetch user imsage ends here


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



             //********for booking options strts
                        $availforuser = trim($request->input('availforuser')); 
                        $bookingsfrom = trim($request->input('bookingsfrom')); 
                        $hourlyrate = trim($request->input('hourlyrate')); 
                        $securityamount = trim($request->input('securityamount')); 
                        $setuptime = trim($request->input('setuptime')); 
                        $packuptime = trim($request->input('packuptime')); 
                        $techspecs = addslashes(trim($request->input('techspecs'))); 
             //********for booking options ends
            
            $uid = $request->input('uid');
            
            if($middle_name!='')
            {
                $midname=ucfirst($middle_name);
            }
            else{
                $midname='';
            }



            //*****password starts
            $mailpass='';
            $pwd='';
            if($newpass!='')
            {
                $mailpass=$newpass;
                $en_pwd=md5($newpass);   
            }
            else
            {
                $en_pwd=$oldpass;
            }
            
            //******* for sign up user checking starts

           if($formtype == 0 && $newpass=='')
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 8; $i++)
                {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                $mailpass = $randomString;
                $pwd=$randomString;
                $en_pwd=md5($pwd);
            }
            //***** for sign up checking ends

            //******password ends

            
            $today=date('Y-m-d H:i:s');
            
            $dataInsert=array();

            if($formtype == 0)
            {
         //   $dataInsert['username']=$username;
            $dataInsert['nickname']=$nickname;
            $dataInsert['email']=$email;
            $dataInsert['password']=$en_pwd;
            $dataInsert['gender']=$gender;
            $dataInsert['dob']=$dateofbirth;
            }else if($formtype == 1){

            $dataInsert['first_name']= ucfirst($first_name);
            $dataInsert['middle_name']=$midname;
            $dataInsert['last_name']= ucfirst($last_name);
            //$dataInsert['username']=$username;
            $dataInsert['nickname']=$nickname;
            $dataInsert['email']=$email;
            $dataInsert['password']=$en_pwd;
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

            $dataInsert['available_for']=$availforuser;
            $dataInsert['booking_from']=$bookingsfrom;
            $dataInsert['rate_amount']=$hourlyrate;
            $dataInsert['security_figure']=$securityamount;
            $dataInsert['setup_time']=$setuptime;
            $dataInsert['packup_time']=$packuptime;
            $dataInsert['tech_spec']=$techspecs;



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
                   // $dataInsert['password']=$en_pwd;
                    $dataInsert['user_type']='3';
                    $dataInsert['registration_date']=$today;
                    $dataInsert['status']='1';
                    $dataInsert['verify_status']='1';
                    $dataInsert['account_activation_date']=$today;
                    $dataInsert['verify_date']=$today;
                    
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
                        
                        //**********update seo name starts here
                            $nickname = strtolower($nickname);
                            $seotitle = str_slug($nickname, '-').'-'.$lastInserted;



                        //**********update seo name ends here
                        //**** create user_uniqueid and update  starts
                            
                            $user_uniqueid="usr".time().'n'.$lastInserted;
                            
                            $updatear=array();
                            $updatear['user_uniqueid']=$user_uniqueid;
                            $updatear['seo_name']=$seotitle;
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
                  $replaceto =array(ucfirst($nickname),$email,$mailpass,$sitenm,$copyrightyr,$bsurl,$logoIMG);
                //   echo "<pre>";
                // print_r($replaceto);
                //    echo "<pre>";
                // print_r($replacefrom);

                // echo $email;

                mailsnd($Temid=22,$replacefrom,$replaceto,$email);

                // if($r)
                // {
                //     echo "mail send";
                // }else
                // {
                //     echo "mail not send";
                // }die;
                  //*********Helper Function Ends here 
                    
                    
                    
                    
                    
                    
                    //*********Email send code ends here
                    
                    
                    
                    }
                }
                else
                {
                        $nickname = strtolower($nickname);
                        $seotitle = str_slug($nickname, '-').'-'.$uid;
                        $dataInsert['modified_date']=$today;
                       $dataInsert['seo_name']=$seotitle;
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
                'nickname' => "required|max:20|unique:user_master,nickname,".$userid,
                //'email' => "required|email|unique:user_master,email,".$userid,
                'email' =>array('required:required','regex:(^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$)','unique:user_master,email,'.$userid),
                'gender'=>"required",
                'dateofbirth'=> "required|date_format:m/d/Y",
                  ],
                [   
                'nickname.required'=>' * Nickname is required ',
                'nickname.max'=>' * Maximum 20 characters ',
                //'email.required'=>' * Email is required ',
                //'email.unique'=>' * Email should be unique ',
                'email.required'=>'* Email is required',
                'email.regex'=>'* Invalid Email address',
                'email.unique'=>'* This Email is already registered',
                'gender.required'=>' * Gender is required ',
                'dateofbirth.required'=>'* Date is required',
               
                'dateofbirth.date_format'=>'* Enter valid date format',
                 ]);

            $userData=array();
            $userData['request']=$request;
            $userData['addeditid']=$userid;

              //***********for password section validation starts here
                     if($request->input('newpass'))
                     {
                        //echo 'sadd';die;
                     $validator->after(function($validator)  use ($userData)  {
                                    
                                        $request=$userData['request'];
                                        $addeditid=$userData['addeditid'];

                                        $validatepasswordchk=$this->passwordisinvalid($request,$addeditid);

                                        if (!empty($validatepasswordchk))
                                        {
                                   
                                         $validator->errors()->add('newpass', $validatepasswordchk);
                                   
                                        }
                            });
                     }
            //***********for password section validation ends here

        }

        else if($formtype == 1)
        {

        $validator = Validator::make($request->all(), [
                'first_name' => "required|max:100",
                'middle_name' => "max:100",
                'last_name' => "required|max:100",
              //  'username' => "required|max:100|unique:user_master,username,".$userid,
                'nickname' => "required|max:20|unique:user_master,nickname,".$userid,
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
                // 'skill_id'=>"required",
                // 'subskill_id'=>"required",
                'currency'=>"required",
                'fburl' => "required|url",
                'soundcloudurl' => "required|url",
                'residentadvisorurl' => "required|url",
                'twitterurl' => "required|url",
                'youtubeurl' => "required|url",
                'instagramurl' => "required|url",
                'hourlyrate' => "numeric",
                'securityamount' => "numeric",
                'techspecs' => "max:250",

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
                'nickname.unique'=>' * Nickname should be unique ',
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
                // 'skill_id.required'=>' * Category is required ',
                // 'subskill_id.required'=>' * Sub-category is required ',
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
                'hourlyrate.numeric' => 'Enter a valid rate amount',
                'securityamount.numeric' => 'Enter a valid security amount',
                'techspecs.max' => 'Maximum 250 charecters are allowed',
            ]);
       
            //print_r($validator->fails());die;
            //echo $validator;die;
            $userData=array();
            $userData['request']=$request;
            $userData['addeditid']=$userid;

            if(trim($request->input('address1')))
            {

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
            }


             //***********for password section validation starts here
                     if($request->input('newpass'))
                     {
                      //  echo 'sadd';die;
                     $validator->after(function($validator)  use ($userData)  {
                                    
                                        $request=$userData['request'];
                                        $addeditid=$userData['addeditid'];

                                        $validatepasswordchk=$this->passwordisinvalid($request,$addeditid);

                                        if (!empty($validatepasswordchk))
                                        {
                                   
                                         $validator->errors()->add('newpass', $validatepasswordchk);
                                   
                                        }
                            });
                     }
            //***********for password section validation ends here

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
        $groupinfo_data = $request->input('groupinfo_data',0);
        $venueinfo_data = $request->input('venueinfo_data',0);


        $flagval = $request->input('flagval');

       // echo $venueinfo_data;die;

        $deactiveurl_group ='';
        $deactiveurl_venue ='';

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

                        if($groupinfo_data == 0)
                        {
                           $deactiveurl_group = " <a href = ".url(ADMINSEPARATOR.'/useradd/groupadd/'.$userid).">Add Group </a>" ;
                        }
                        else if($groupinfo_data > 0)
                        {
                             $deactiveurl_group = " <a href = ".url(ADMINSEPARATOR.'/useradd/groupadd/'.$userid.'/'.$groupinfo_data).">Edit Group </a>" ;
                            
                        }
                         if($venueinfo_data == 0)
                        {
                           $deactiveurl_venue = " <a href = ".url(ADMINSEPARATOR.'/useradd/venueadd/'.$userid).">Add Venue </a>" ;
                        }
                        else if($venueinfo_data > 0)
                        {
                             $deactiveurl_venue = " <a href = ".url(ADMINSEPARATOR.'/useradd/venueadd/'.$userid.'/'.$venueinfo_data).">Edit Venue </a>" ;
                            
                        }




                        
                   }
                   else{
                        $deactvfor='Deactivated by admin   ';
                          if($groupinfo_data == 0)
                        {
                           $deactiveurl_group = " <a href = 'javascript:void(0);' onclick='openmodalfunc(1);'>Group </a>" ;
                        }
                        else if($groupinfo_data > 0)
                        {
                             $deactiveurl_group = " <a href = ".url(ADMINSEPARATOR.'/useradd/groupadd/'.$userid.'/'.$groupinfo_data).">View Group </a>" ;
                            
                        }

                           if($venueinfo_data == 0)
                        {
                           $deactiveurl_venue = " <a href = 'javascript:void(0);' onclick='openmodalfunc(0);'>Venue </a>" ;
                        }
                        else if($venueinfo_data > 0)
                        {
                             $deactiveurl_venue = " <a href = ".url(ADMINSEPARATOR.'/useradd/venueadd/'.$userid.'/'.$venueinfo_data).">View Venue </a>" ;
                            
                        }




                   }

                   
            }

            //********************* Email send after change of status starts here
                       // echo "flagval==".$flagval;
                            if($flagval==1)
                            {
                                    $statictext = '';
                                    $useremailsend = $this->sendemailafteractivedeactive($userid,$flagactivedeactive=1,$statictext);
                            }
            //********************* Emil send after change of status ends here
                  
            //*** update status ends
        }
          
        $respAr['flag']=$flagdata;
        $respAr['iddata']=$userid;
        $respAr['deactvcz']=$deactvfor;
        $respAr['deactiveurl_group']=$deactiveurl_group;
        $respAr['deactiveurl_venue']=$deactiveurl_venue;
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
        $deactiuserid=0; 
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
            //echo 'ere'.$userid;die;
            $userdeacti = DB::table('user_deatcivate_reason')
                     // ->select(DB::raw('id'))
                      ->where('user_id', $userid)
                      ->get();
                     // ->first();
                      //print_r($userdeacti);die;
                      if($userdeacti)
                      {
                        $deactiuserid=$userdeacti[0]->id; 
                      }

                 //die;
            if(!empty($deactiuserid))
            {
                $isInserted= DB::table('user_deatcivate_reason')->where('id',$deactiuserid) ->update($dataInsert);
            }
            else{
                $isInserted = DB::table('user_deatcivate_reason')->insert($dataInsert);
            }
            if(!empty($isInserted))
            { 

                $flag_id=1; 

                //*************Email send function after deactive user starts here
                $deactivereason = $cause;
               $useremailsend = $this->sendemailafteractivedeactive($userid,$flagactivedeactive=0,$cause);

                //*************Email send function after deactive user ends here

            }
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
        $skill_id=$request->input('skill_id');//die;
		$respAr=array();
        $subskill_data=array();
        $resp=array();
		if(!empty($skill_id))
		{
            $subskilldetail = DB::table('skill_master')
                      ->select(DB::raw('id,name,seo_name'))
                      ->where('parent_id', $skill_id)
                      ->where('status', 1)
                      ->whereRaw(" FIND_IN_SET('3',`catag_type`) ")
                      ->orderBy('name', 'asc')
                      //->where('catag_type', 3)
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
     //   echo "<pre>";
      //  print_r($respAr);die;
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

        public function addusergroup(Request $request,$id=0,$venueid=0)
        {
                                          //  echo "I am creating a group";


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
                                           $uservenuerowcount = DB::table('group_master as gm')->where('gm.creater_id', $id)->where('gm.id', $venueid)->count();
                                           if($uservenuerowcount == 0)
                                           {
                                             return redirect(ADMINSEPARATOR.'/user');
                                           }
                                        }

                                            // echo $uservenuerowcount;die;

                                            $uservenuerow = DB::table('group_master as gm')->where('gm.creater_id', $id)->first();
                                            if($uservenuerow)
                                            {
                                                $data['uservenuerow']=$uservenuerow;
                                                $usrvenue_stateID = $uservenuerow->country;
                                            }
                                            //**** fetch data ends 

                                            //******** fetch user press kit
                                            $uservenuerow_press = DB::table('group_presskit as upkv')->where('upkv.group_id', $id)->first();
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
                                        
                                        

                                        $parentskill_db = DB::table('skill_master');
                                        $parentskill_db=$parentskill_db->where('status',1);
                                        $parentskill_db=$parentskill_db->where('parent_id',0);
                                        $parentskill_db=$parentskill_db->whereRaw(" FIND_IN_SET('2',`catag_type`) ");
                                        $parentskill_db=$parentskill_db->orderBy('id', 'asc');
                                        $parentskill_db=$parentskill_db->get();

                                        $fetchskillmasterdata=$parentskill_db;
                                        $fetchskillmasterAr=array();

                                        if(!empty($fetchskillmasterdata))
                                        {
                                            foreach( $fetchskillmasterdata as $fetchskillobj )
                                            {
                                             $fetchskillmasterAr[$fetchskillobj->id]=$fetchskillobj->name;
                                            }
                                        } 
                                        
                                        $data['skillidAr']=$fetchskillmasterAr;
                                        
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
                                                // $qry_select_amenity = DB::table('venue_amenity_rel')->select('amenity_id')->where('v_creator_id',$id)->get();
                                               

                                                //    if(!empty($qry_select_amenity))
                                                //         {
                                                //                 foreach($qry_select_amenity as $amenitiesqry_venue_obj)
                                                //                 {
                                                //                         $amenityIDAr[]=$amenitiesqry_venue_obj->amenity_id;
                                                                     
                                                //                 }
                                                                
                                                //         }
                                          }

                                        $data['qry_select_amenity'] = $amenityIDAr;

                                        $qry_select_user_status = DB::table('user_master')->select('status')->where('id',$id)->first();
                                        $data['user_status_chk'] = $qry_select_user_status->status;
                                         // echo '<pre>';
                                         // print_r($data['user_status_chk']);die;


                                        //******** get all amenities ends here
                                        
                                        //******** fetch currency data for drop down ends
                                     
                                         //******** fetch user press kit
                                            $venuerow_press = DB::table('group_presskit as gpk')->where('gpk.g_creator_id', $id)->first();
                                            if($venuerow_press)
                                            {
                                                $data['venuerow_press']=$venuerow_press;
                                            }

                                            $venuerow_menu = DB::table('venue_menu as vmnu')->where('vmnu.v_creator_id', $id)->first();
                                            if($venuerow_menu)
                                            {
                                                $data['venuerow_menu']=$venuerow_menu;
                                            }

                                             if(!empty($venueid)){
                                                $groupimage_admin = DB::table("group_master_img")
                                                ->where('g_creator_id',$id)
                                                ->where('group_id',$venueid)
                                                ->get();

                                                $data['groupimage_admin']=$groupimage_admin;
                                                $data['groupimage_admin_count']=count($groupimage_admin);
                                    }else{
                                        $data['groupimage_admin']='';
                                        $data['groupimage_admin_count']=0;
                                    }


                                     
                                        return view('admin.user.usergroupadd', $data);

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
                                
                                

                                        $parentskill_db = DB::table('skill_master');
                                        $parentskill_db=$parentskill_db->where('status',1);
                                        $parentskill_db=$parentskill_db->where('parent_id',0);
                                        $parentskill_db=$parentskill_db->whereRaw(" FIND_IN_SET('3',`catag_type`) ");
                                        $parentskill_db=$parentskill_db->orderBy('id', 'asc');
                                        $parentskill_db=$parentskill_db->get();

                                        $fetchskillmasterdata=$parentskill_db;
                                        $fetchskillmasterAr=array();

                                        if(!empty($fetchskillmasterdata))
                                        {
                                            foreach( $fetchskillmasterdata as $fetchskillobj )
                                            {
                                             $fetchskillmasterAr[$fetchskillobj->id]=$fetchskillobj->name;
                                            }
                                        } 

                                        $data['skillidAr']=$fetchskillmasterAr;
                                
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



                                    // fetching of venue image starts here
                                    if(!empty($venueid)){
                                                $venueimage_admin = DB::table("venue_master_img")
                                                ->where('v_creator_id',$id)
                                                ->where('venue_id',$venueid)
                                                ->get();

                                                $data['venueimage_admin']=$venueimage_admin;
                                                $data['venueimage_admin_count']=count($venueimage_admin);
                                    }else{
                                        $data['venueimage_admin']='';
                                        $data['venueimage_admin_count']=0;
                                    }
                                    // fetching of venue image ends here




                             
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


            //********for booking options strts
                $availforuser = trim($request->input('availforuser')); 
              
                $hourlyrate = trim($request->input('hourlyrate')); 
                $securityamount = trim($request->input('securityamount')); 
                $opening_time = trim($request->input('opening_time')); 

                $opening_time =  date('H:i:s',strtotime($opening_time));

                $closing_time = trim($request->input('closing_time')); 

                $closing_time =  date('H:i:s',strtotime($closing_time));

                $techspecs = addslashes(trim($request->input('techspecs'))); 
            //********for booking options ends

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

                                $dataInsertvenue['available_for']=$availforuser;
                                $dataInsertvenue['rate_amount']=$hourlyrate;
                                $dataInsertvenue['security_figure']=$securityamount;
                                $dataInsertvenue['opening_time']=$opening_time;
                                $dataInsertvenue['closing_time']=$closing_time;
                                $dataInsertvenue['tech_spec']=$techspecs;

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


                                                //************ email send after creating a venue starts here

                                                  //*******fetch user details starts here
                                                            $emailusr = DB::table('user_master')->select('email','nickname')->where('id',$ucreaterid)->first();
                                                            $emailtosendusr = $emailusr->email;
                                                            $emailtosendusrname = $emailusr->nickname;
                                                            //*******fetch user details ends here

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
                                                            $replacefrom =array('{User}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                                            $replaceto =array(addslashes(ucfirst($emailtosendusrname)),$sitenm,$copyrightyr,$bsurl,$logoIMG);

                                                            mailsnd($Temid=14,$replacefrom,$replaceto,$emailtosendusr);
                                                            //*********Helper Function Ends here 

                                                //************ email send after creating a venue ends here




                                }else
                                {
                                    // echo "<pre>";
                                    // print_r($dataInsertvenue);die;
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
                                            // 'skill_id'=>"required",
                                            // 'subskill_id'=>"required",
                                            'fburl' => "required|url",
                                            'soundcloudurl' => "required|url",
                                            'residentadvisorurl' => "required|url",
                                            'twitterurl' => "required|url",
                                            'youtubeurl' => "required|url",
                                            'instagramurl' => "required|url",

                                            'hourlyrate' => "numeric",
                                            'securityamount' => "numeric",
                                            'techspecs' => "max:250",


                                            ],
                                            [   
                                            'nickname.required'=>' * Venue name is required ',
                                             'nickname.unique'=>' * venue name already exists try some another name',
                                            'nickname.max'=>' * Maximum 20 characters ',
                                            'address1.required'=>' * Address is required ',
                                            'country_id.required'=>' * Country is required ',
                                           'state_id.required'=>' * State is required ',
                                            'city.required'=>' * City is required ',
                                            'zip.required'=>' * Zip is required ',
                                            // 'skill_id.required'=>' * Category is required ',
                                            // 'subskill_id.required'=>' * Sub-category is required ',
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

                                            'hourlyrate.numeric' => 'Enter a valid rate amount',
                                            'securityamount.numeric' => 'Enter a valid security amount',
                                            'techspecs.max' => 'Maximum 250 charecters are allowed',

                                            ]);

                                              // print_r($validator->fails());die;
                                                // print_r($validator);die;
                                                $userData=array();
                                                $userData['request']=$request;
                                                $userData['addeditid']=$userid;

                                                if(trim($request->input('address1')))
                                                {

                                                $validator->after(function($validator)  use ($userData)  {

                                                $request=$userData['request'];
                                                $addeditid=$userData['addeditid'];
                                                $validateaddresschk=$this->addressisinvalid($request,$addeditid);
                                                if (!empty($validateaddresschk))
                                                {
                                                $validator->errors()->add('address1', $validateaddresschk);

                                                }
                                                });
                                            }


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
            //********group add edit starts here
            public function saveusergroup(Request $request)
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

                                    //********for booking options strts
                                    $availforuser = trim($request->input('availforuser')); 
                                    $bookingsfrom = trim($request->input('bookingsfrom')); 
                                    $hourlyrate = trim($request->input('hourlyrate')); 
                                    $securityamount = trim($request->input('securityamount')); 
                                    $setuptime = trim($request->input('setuptime')); 
                                    $packuptime = trim($request->input('packuptime')); 
                                    $techspecs = addslashes(trim($request->input('techspecs'))); 
                                    //********for booking options ends


                                    $chkvalidgroup=$this->validateusergroupall($request,$uid);

        if($chkvalidgroup===true)
        {


                            //******
                            $dataInsertgroup=array();
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


                                                    $dataInsertgroup['group_lat']=$latitude;
                                                    $dataInsertgroup['group_long']=$longitude;
                                                    $dataInsertgroup['group_timezone']=$timezoneId;

                                }
                               
                                                    $dataInsertgroup['nickname']=$nickname;
                                                    $dataInsertgroup['creater_id']=$ucreaterid;
                                                    $dataInsertgroup['address_1']=$address1;
                                                    $dataInsertgroup['address_2']=$address2;
                                                    $dataInsertgroup['country']=$country;
                                                    $dataInsertgroup['state']=$state;
                                                    $dataInsertgroup['city']=$city;
                                                    $dataInsertgroup['zip']=$zip;
                                                    $dataInsertgroup['abn_data']=$abn;
                                                    $dataInsertgroup['tfn_data']=$tfn;
                                                   // $dataInsert['currency']=$currency;
                                                    $dataInsertgroup['rider_data']=$rider;
                                                    $dataInsertgroup['group_description']=$description;
                                                    $dataInsertgroup['facebook_url']=$fb_url;
                                                    $dataInsertgroup['soundcloud_url']=$soundcloud_url;
                                                    $dataInsertgroup['residentadvisor_url']=$residentadvisor_url;
                                                    $dataInsertgroup['twitter_url']=$twitter_url;
                                                    $dataInsertgroup['youtube_url']=$youtube_url;
                                                    $dataInsertgroup['instagram_url']=$instagram_url;
                                                    $dataInsertgroup['group_meta_data']=$pagemetatag;


                                                    $dataInsertgroup['available_for']=$availforuser;
                                                    $dataInsertgroup['booking_from']=$bookingsfrom;
                                                    $dataInsertgroup['rate_amount']=$hourlyrate;
                                                    $dataInsertgroup['security_figure']=$securityamount;
                                                    $dataInsertgroup['setup_time']=$setuptime;
                                                    $dataInsertgroup['packup_time']=$packuptime;
                                                    $dataInsertgroup['tech_spec']=$techspecs;




                                            if(empty($uid))
                                            {
                                                                $dataInsertgroup['type_flag']=2;
                                                                $dataInsertgroup['create_date']=date('Y-m-d H:i:s');

                                                                $isInserted = DB::table('group_master')->insert($dataInsertgroup);

                                                                $request->session()->flash('admin_successmsgdata_sess', 'Group created successfully');
                                                                /*Last Insert id*/
                                                                //$isInserted=DB::getPdo()->lastInsertId();
                                                                // echo "====>".$last_insert_id;
                                                                $lastInserted=DB::getPdo()->lastInsertId();
                                                                $uid = $lastInserted;


                                                                $nickname = strtolower($nickname);
                                                                $seotitle = str_slug($nickname, '-').'-'.$lastInserted;

                                                                $dataInsertvenueseo =array();
                                                                $dataInsertvenueseo['seo_name']=$seotitle;

                                                            $chkupdgroupseo= DB::table('group_master')->where('id',$uid) ->update($dataInsertvenueseo);


                                                            //************ email for sending user after create a group starts


                                                            //**********Email Send Code Starts here


                                                            //*******fetch user details starts here
                                                            $emailusr = DB::table('user_master')->select('email','nickname')->where('id',$ucreaterid)->first();
                                                            $emailtosendusr = $emailusr->email;
                                                            $emailtosendusrname = $emailusr->nickname;
                                                            //*******fetch user details ends here

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
                                                            $replacefrom =array('{User}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                                            $replaceto =array(addslashes(ucfirst($emailtosendusrname)),$sitenm,$copyrightyr,$bsurl,$logoIMG);

                                                            mailsnd($Temid=15,$replacefrom,$replaceto,$emailtosendusr);
                                                            //*********Helper Function Ends here 






                                                            //*********Email send code ends here


                                                            //***********  email for sending user after create a group ends











                                            }else
                                            {
                                                             $request->session()->flash('admin_successmsgdata_sess', 'Group updated successfully');
                                                            $dataInsertgroup['modified_date']=date('Y-m-d H:i:s');
                                                            //$dataInsertvenueseo =array();
                                                            $nickname = strtolower($nickname);
                                                            $seotitle = str_slug($nickname, '-').'-'.$uid;
                                                            $dataInsertgroup['seo_name']=$seotitle;

                                                            $chkupdgroup= DB::table('group_master')->where('id',$uid) ->update($dataInsertgroup);
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


                                            $destinationsourcePath=public_path()."/upload/group-press-kit/source-file/";                         

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
                                                                  
                                                                  $user_presskit_db=DB::table('group_presskit as upk');              
                                                                  $user_presskit_db=$user_presskit_db->select(DB::raw($selectstr));                                                          
                                                                  $user_presskit_db=$user_presskit_db->where('upk.g_creator_id', $ucreaterid);
                                                                  $user_presskit_db=$user_presskit_db->where('upk.group_id', $user_id);                                          
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
                                                                        
                                                                        $updtusrmstr= DB::table('group_presskit');
                                                                        $updtusrmstr= $updtusrmstr->where('group_id',$user_id) ;
                                                                         $updtusrmstr= $updtusrmstr->where('g_creator_id',$ucreaterid) ;
                                                                        $updtusrmstr=$updtusrmstr->update(
                                                                        ['presskit_name' =>addslashes($user_presskit_name),
                                                                         'create_date'=>date('Y-m-d H:i:s')    
                                                                         ]
                                                                        );
                                                                        
                                                                        //*** unlink previous presslit  file
                                                                        
                                                                        $srcpresskit=public_path()."/upload/group-press-kit/source-file/".$presskit_name;
                                                
                                                                         @unlink($srcpresskit);
                                                                        
                                                                       
                                                            }else
                                                            {
                                                                       //**** insert qry
                                                                       
                                                                        $presskit_array=array();                                                
                                                                        
                                                                        $presskit_array['presskit_name']=addslashes($user_presskit_name);
                                                                        $presskit_array['group_id']=$user_id;
                                                                        $presskit_array['g_creator_id']=$ucreaterid;
                                                                        $presskit_array['create_date']=date('Y-m-d H:i:s');                                    
                                                                        $chkupd= DB::table('group_presskit')->insert($presskit_array );
                                                                        $last_insert_id=DB::getPdo()->lastInsertId(); 
                                                                       
                                                            }
                                                           
                                                       
                                                            
                                                      }
                                            } //if(!empty($uploadedsuccnames)) ends
                                               
                                    } //if($request->hasFile('presskit_name')) ends

                                    //*********presskit upload ends here

               
                        return redirect(ADMINSEPARATOR.'/user');


        }
        else //if validation fails
        {
            if(!empty($uid))
            {
                 $request->session()->flash('admin_errormsgdata_sess', 'Please fill the fields with proper informations');
             return redirect(ADMINSEPARATOR.'/useradd/groupadd/'.$ucreaterid.'/'.$uid)
                     ->withErrors($chkvalidgroup)
                     ->withInput();
                    //echo 'error occurs';
            }else
            {
                 $request->session()->flash('admin_errormsgdata_sess', 'Please fill the fields with proper informations');
                return redirect(ADMINSEPARATOR.'/useradd/groupadd/'.$ucreaterid)
                     ->withErrors($chkvalidgroup)
                     ->withInput();
            }
        }



            }
            //********group as edit ends here



            public function validateusergroupall(Request $request,$userid)
                            {
                             
                                            $formtype = $request->input('formtype');
                                            $validator = Validator::make($request->all(), [

                                            'nickname' => "required|max:20|unique:group_master,nickname,".$userid,
                                            'address1'=>"required",
                                            'country_id'=>"required",
                                            'state_id'=>"required",
                                            'city'=>"required",
                                            'zip'=>"required",
                                            // 'skill_id'=>"required",
                                            // 'subskill_id'=>"required",
                                            'fburl' => "required|url",
                                            'soundcloudurl' => "required|url",
                                            'residentadvisorurl' => "required|url",
                                            'twitterurl' => "required|url",
                                            'youtubeurl' => "required|url",
                                            'instagramurl' => "required|url",
                                            'hourlyrate' => "numeric",
                                            'securityamount' => "numeric",
                                            'techspecs' => "max:250",

                                            ],
                                            [   
                                            'nickname.required'=>' * Group name is required ',
                                             'nickname.unique'=>' * Group name already exists try some another name',
                                            'nickname.max'=>' * Maximum 20 characters ',
                                            'address1.required'=>' * Address is required ',
                                            'country_id.required'=>' * Country is required ',
                                           'state_id.required'=>' * State is required ',
                                            'city.required'=>' * City is required ',
                                            'zip.required'=>' * Zip is required ',
                                            // 'skill_id.required'=>' * Category is required ',
                                            // 'subskill_id.required'=>' * Sub-category is required ',
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
                                            'hourlyrate.numeric' => 'Enter a valid rate amount',
                                            'securityamount.numeric' => 'Enter a valid security amount',
                                            'techspecs.max' => 'Maximum 250 charecters are allowed',
                                            ]);

                                              // print_r($validator->fails());die;
                                                // print_r($validator);die;
                                                $userData=array();
                                                $userData['request']=$request;
                                                $userData['addeditid']=$userid;

                                                if(trim($request->input('address1')))
                                                {

                                                    $validator->after(function($validator)  use ($userData)  {

                                                    $request=$userData['request'];
                                                    $addeditid=$userData['addeditid'];
                                                    $validateaddresschk=$this->addressisinvalid($request,$addeditid);
                                                    if (!empty($validateaddresschk))
                                                    {
                                                    $validator->errors()->add('address1', $validateaddresschk);

                                                    }
                                                    });
                                                 }


                                                //********for upload press kit validation starts here
                                                if($request->hasFile('presskit_name'))
                                                {

                                                    $validator->after(function($validator)  use ($userData)  {

                                                    $request=$userData['request'];
                                                    $addeditid=$userData['addeditid'];
                                                    $destinationsourcePath=public_path()."/upload/group-press-kit/source-file/";  
                                                    $validatepresschk=$this->presskitisinvalid($request,$destinationsourcePath,$addeditid);
                                                    if (!empty($validatepresschk))
                                                    {
                                                    $validator->errors()->add('presskit_name', $validatepresschk);
                                                    //echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                                                    }
                                                    });
                                                }



                                                //******** for press kit upload validation ends here

                                                        if ($validator->fails())
                                                        {
                                                           // echo "ewrwer";
                                                            // print_r($validator);die;
                                                            return $validator;
                                                        }
                                                        return true;
        
       
                            }

                            //******* group presskit download

                            public function usergrouppresskitadmindownload($file_name)
                            {
                                        $filennmdownload = base64_decode($file_name);
                                        //echo $filennmdownload;die;
                                        //********its working for single file
                                        $download_path = ( public_path() . '/upload/group-press-kit/source-file/' . $filennmdownload );
                                        return( Response::download( $download_path ) );
                            }






//********for venue section

                             public function skillwisesubskillsavefunc(Request $request)
                            {
                                        $skillid = $request->input('skillid');
                                        $subskillid = $request->input('subskillid');

                                        $venue_ID = $request->input('vnuID');
                                        $vnucreatrID = $request->input('vnucreatrID');


                                        $responsearray = array();

                                        $insertarr = array();
                                        $insertarr['venue_id'] = $venue_ID;
                                        $insertarr['v_creator_id'] = $vnucreatrID;
                                        $insertarr['catag_type_id'] = 3;
                                        $insertarr['skill_id'] = $skillid;
                                        $insertarr['skill_sub_id'] = $subskillid;

                                        $chkdata = DB::table('venue_skill_rel')->where($insertarr)->first();

                                        if($chkdata)
                                        {
                                        $flag = 0;
                                        }
                                        else
                                        {
                                        $insertarr['create_date'] = date('Y-m-d H:i:s');
                                        $insqry = DB::table('venue_skill_rel')->insert($insertarr);

                                        $flag = 1;
                                        }

                                        $languageidAr = $this->commonvenuecategory_subcategory($venue_ID,$vnucreatrID);

                                        $responsearray['response_data'] = $languageidAr;

                                        echo json_encode($responsearray);



                            }


                             public function skillwisesubskilldeletevenue(Request $request)
                        {
                              $responsearray =array();
                                    $skillid = $request->input('skillmaster_id');
                                    $skill_parentid = $request->input('skillmaster_parentid');

                                    $vnuID = $request->input('vnuID');
                                    $vnucreatrID = $request->input('vnucreatrID');




                                            $countdplicktchk =0;
                                            $dplicktchk = DB::table('gig_master')
                                            ->join('gig_skill_rel', 'gig_skill_rel.gigmaster_id', '=', 'gig_master.id')
                                            ->select('gig_skill_rel.*')
                                            ->where('gig_master.artist_id',$vnuID)
                                            ->where('gig_master.type_flag',3)
                                            ->where('gig_skill_rel.genre',$skillid)
                                            ->where('gig_skill_rel.type_flag',3)
                                            ->get();

                                            // echo "<pre>";
                                            // print_r($dplicktchk);
                                            // die;
                                            $dplicktcount = count($dplicktchk);


                                              if($dplicktcount == 0)
                                                          {

                                                                $select_venueskillsubskill = DB::table('venue_skill_rel')
                                                                ->select('id')
                                                                ->where('venue_id',$vnuID)
                                                                ->where('v_creator_id','=',$vnucreatrID)
                                                                ->where('catag_type_id','=','3')
                                                                ->where('skill_id','=',$skill_parentid)
                                                                ->where('skill_sub_id','=',$skillid)
                                                                ->first();

                                                                $venueskillid = $select_venueskillsubskill->id;//die;
                                                                $dltvnuskill = DB::table('venue_skill_rel')->where('id', $venueskillid)->delete();
                                                                 $responsearray['typeflag'] ='done';
                                                            }
                                                            else if($dplicktcount > 0)
                                                            {
                                                               // $request->session()->flash('admin_errormsgdata_sess', 'can not be deleted');
                                                                 $responsearray['typeflag'] ='exists';
                                                            }









                                    // die;
                                    $languageidAr = $this->commonvenuecategory_subcategory($vnuID,$vnucreatrID);

                                  

                                    $responsearray['response_data'] = $languageidAr;

                                    echo json_encode($responsearray);




                        }

                        public function skillwisesubskilldisplayvenue(Request $request)
                        {
                                $vnucreatrID = $request->input('vnucreatrID');
                                $vnuID = $request->input('vnuID');

                                // $ststus_chk = $request->input('ststus_chk');



                                $responsearray =array();
                                $languageidAr = $this->commonvenuecategory_subcategory($vnuID,$vnucreatrID);

                                $responsearray['response_data'] = $languageidAr;

                                echo json_encode($responsearray);

                        }


                        public function commonvenuecategory_subcategory($vnuID,$vnucreatrID)
                        {
                             

                             $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.venue_id) as user_id ";
               
                $skill_user_db=DB::table('venue_skill_rel as usr');

                $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
                
                $skill_user_db=$skill_user_db->where('usr.venue_id', $vnuID);
                $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
                
                $skill_user_db=$skill_user_db->get();


                                    $languageidAr = array();
                                    foreach($skill_user_db as $skill_user_obj)
                                    {
                                        $userid_ofskill = $skill_user_obj->user_id;
                                        $skill_parent_data=$skill_user_obj->skill_id;
                                        $skill_parent_txtdata=stripslashes($skill_user_obj->skill_name);
                                        $skill_sub_data_str=$skill_user_obj->skill_sub_id;
                                        $skill_sub_txtdata_str=$skill_user_obj->skill_sub_name;
                                        $skill_sub_data_Ar=explode(",",$skill_sub_data_str);
                                        $skill_sub_txtdata_Ar=explode(",",$skill_sub_txtdata_str);

                                        $languageidAr[]= "<strong>".$skill_parent_txtdata."<strong>";
                                        $languageidAr[]=" :  ";

                                    if(!empty($skill_sub_data_Ar))
                                    {
                                        $skill_lim =  count($skill_sub_data_Ar);
                                        $i = 0;
                                        $j = ",";
                                        foreach($skill_sub_data_Ar as $kk => $kvlue)
                                        {
                                            $i++;
                                            if($i == $skill_lim)
                                            {
                                                $j=".";
                                            }
                                            $skill_sub_data=$skill_sub_data_Ar[$kk];
                                            $skill_sub_txtdata=$skill_sub_txtdata_Ar[$kk];
                                          
 $languageidAr[]= $skill_sub_txtdata."<a onclick='showmemenue(".$skill_sub_data.",".$skill_parent_data.");'> <i class='fa fa-times' aria-hidden='true'></i></a> ".$j;
                                            ?>
                                           
                                            <?php
                                        }
                                        $languageidAr[]="<br>";
                                    }

                                    }



                                    return $languageidAr;

                        }
    //********for venue section ends


//**********added for venue skill add and delete ends 13-08-2016

//*******for group starts here

            public function skillwisesubskillfuncgroup(Request $request)
            {
                                $skill_id=$request->input('skill_id');//die;
                                $respAr=array();
                                $subskill_data=array();
                                $resp=array();
                                if(!empty($skill_id))
                                {
                                    $subskilldetail = DB::table('skill_master')
                                    ->select(DB::raw('id,name,seo_name'))
                                    ->where('parent_id', $skill_id)
                                    ->where('status', 1)
                                    //->where('catag_type', 2)
                                    ->whereRaw(" FIND_IN_SET('2',`catag_type`) ")
                                    ->orderBy('name', 'asc')
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

              public function skillwisesubskillsavefuncgroup(Request $request)
                            {
                                        $skillid = $request->input('skillid');
                                        $subskillid = $request->input('subskillid');

                                        $groupID = $request->input('groupID');
                                        $grupcreatrID = $request->input('grupcreatrID');


                                        $responsearray = array();

                                        $insertarr = array();
                                        $insertarr['group_id'] = $groupID;
                                        $insertarr['g_creator_id'] = $grupcreatrID;
                                        $insertarr['catag_type_id'] = 2;
                                        $insertarr['skill_id'] = $skillid;
                                        $insertarr['skill_sub_id'] = $subskillid;

                                        $chkdata = DB::table('group_skill_rel')->where($insertarr)->first();

                                        if($chkdata)
                                        {
                                        $flag = 0;
                                        }
                                        else
                                        {
                                        $insertarr['create_date'] = date('Y-m-d H:i:s');
                                        $insqry = DB::table('group_skill_rel')->insert($insertarr);

                                        $flag = 1;
                                        }

                                        $languageidAr = $this->commongroupcategory_subcategory($groupID,$grupcreatrID);

                                        $responsearray['response_data'] = $languageidAr;

                                        echo json_encode($responsearray);



                            }

                         



                             public function skillwisesubskilldeletegroup(Request $request)
                        {
                              $responsearray =array();
                                    $skillid = $request->input('skillmaster_id');
                                    $skill_parentid = $request->input('skillmaster_parentid');

                                    $groupID = $request->input('groupID');
                                    $grupcreatrID = $request->input('grupcreatrID');



                                    $sqlGroupSkill="SELECT count(*) as 'number' FROM `gig_skill_rel` WHERE `genre`='".$skillid."' and`gigmaster_id` in(SELECT `id` FROM `gig_master` WHERE `type_flag`='2' and `artist_id` = '".$groupID."')";
                        $sqlGroupSkillCount = DB::select( DB::raw($sqlGroupSkill));
                        $numberCountSkill = $sqlGroupSkillCount[0]->number;
                        if($numberCountSkill == 0)
                        {

                                    $select_groupkillsubskill = DB::table('group_skill_rel')
                                    ->select('id')
                                    ->where('group_id',$groupID)
                                    ->where('g_creator_id','=',$grupcreatrID)
                                    ->where('catag_type_id','=','2')
                                    ->where('skill_id','=',$skill_parentid)
                                    ->where('skill_sub_id','=',$skillid)
                                    ->first();

                                    $groupskillid = $select_groupkillsubskill->id;//die;
                                    $dltgrupskill = DB::table('group_skill_rel')->where('id', $groupskillid)->delete();
                                    $responsearray['typeflag'] ='done';
                        }else if($numberCountSkill > 0)
                        {
                            $responsearray['typeflag'] ='exists';
                        }








                                    // die;
                                    $languageidAr = $this->commongroupcategory_subcategory($groupID,$grupcreatrID);

                                  

                                    $responsearray['response_data'] = $languageidAr;

                                    echo json_encode($responsearray);




                        }
                          public function skillwisesubskilldisplaygroup(Request $request)
                        {
                                $grupcreatrID = $request->input('grupcreatrID');
                                $groupID = $request->input('groupID');



                                $responsearray =array();
                                $languageidAr = $this->commongroupcategory_subcategory($groupID,$grupcreatrID);

                                $responsearray['response_data'] = $languageidAr;

                                echo json_encode($responsearray);

                        }

                           public function commongroupcategory_subcategory($groupID,$grupcreatrID)
                            {
                               
                    $selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.group_id) as group_id ";
               
                $skill_user_db=DB::table('group_skill_rel as usr');

                $skill_user_db=$skill_user_db->select(DB::raw($selectstr));
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
                $skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');
                
                $skill_user_db=$skill_user_db->where('usr.group_id', $groupID);
                $skill_user_db=$skill_user_db->groupBy('usr.skill_id');
                
                $skill_user_db=$skill_user_db->get();



                                    $languageidAr = array();
                                    

                                    foreach($skill_user_db as $skill_user_obj)
                                    {
                                        //$userid_ofskill = $skill_user_obj->user_id;
                                        $skill_parent_data=$skill_user_obj->skill_id;
                                        $skill_parent_txtdata=stripslashes($skill_user_obj->skill_name);
                                        $skill_sub_data_str=$skill_user_obj->skill_sub_id;
                                        $skill_sub_txtdata_str=$skill_user_obj->skill_sub_name;
                                        $skill_sub_data_Ar=explode(",",$skill_sub_data_str);
                                        $skill_sub_txtdata_Ar=explode(",",$skill_sub_txtdata_str);

                                        $languageidAr[]= "<strong>".$skill_parent_txtdata."<strong>";
                                        $languageidAr[]=" :  ";

                                    if(!empty($skill_sub_data_Ar))
                                    {
                                        $skill_lim =  count($skill_sub_data_Ar);
                                        $i = 0;
                                        $j=",";

                                        foreach($skill_sub_data_Ar as $kk => $kvlue)
                                        {
                                            $i++;
                                            if($i == $skill_lim)
                                            {
                                                 $j=".";
                                            }
                                            $skill_sub_data=$skill_sub_data_Ar[$kk];
                                            $skill_sub_txtdata=$skill_sub_txtdata_Ar[$kk];
                                          
 $languageidAr[]= $skill_sub_txtdata."<a onclick='showmedelgroup(".$skill_sub_data.",".$skill_parent_data.");'> <i class='fa fa-times' aria-hidden='true'></i></a> ".$j;
                                            ?>
                                           
                                            <?php
                                        }
                                        $languageidAr[]="<br>";
                                    }

                                    }
                                    return $languageidAr;
                            }


                                        //*******for group ends here

                                            //******for user section starts

                                //*******for user skill wise subskill display

                public function userskillwisesubskillshowfunc(Request $request)
                {
                        $skill_id=$request->input('skill_id'); //die;
                                $respAr=array();
                                $subskill_data=array();
                                $resp=array();
                                if(!empty($skill_id))
                                {
                                    $subskilldetail = DB::table('skill_master')
                                    ->select(DB::raw('id,name,seo_name'))
                                    ->where('parent_id', $skill_id)
                                    ->where('status', 1)
                                   // ->where('catag_type', 1)
                                    ->whereRaw(" FIND_IN_SET('1',`catag_type`) ")
                                    ->orderBy('name', 'asc')
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

                 public function userskillwisesubskillsavefunc(Request $request)
                            {
                                        $skillid = $request->input('skillid');
                                        $subskillid = $request->input('subskillid');

                                        $userID = $request->input('userID');
                                       


                                        $responsearray = array();

                                        $insertarr = array();
                                        $insertarr['user_id'] = $userID;
                                        $insertarr['catag_type_id'] = 1;
                                        $insertarr['skill_id'] = $skillid;
                                        $insertarr['skill_sub_id'] = $subskillid;

                                        $chkdata = DB::table('user_skill_rel')->where($insertarr)->first();

                                        if($chkdata)
                                        {
                                        $flag = 0;
                                        }
                                        else
                                        {
                                        $insertarr['create_date'] = date('Y-m-d H:i:s');
                                        $insqry = DB::table('user_skill_rel')->insert($insertarr);

                                        $flag = 1;
                                        }

                                        $languageidAr = $this->commonusercategory_subcategory($userID);

                                        $responsearray['response_data'] = $languageidAr;

                                        echo json_encode($responsearray);



                            }

                               public function skillwisesubskilldeleteuser(Request $request)
                        {
                                    $userskillid ='';
                                    $responseflag = '';
                                    $languageidAr = '';
                                    $responsearray =array();
                                    $skillid = $request->input('skillmaster_id');
                                    $skill_parentid = $request->input('skillmaster_parentid');

                                    $userID = $request->input('userID');
                                    



                                                        $dplicktchk = DB::table('gig_master')
                                                          ->join('gig_skill_rel', 'gig_skill_rel.gigmaster_id', '=', 'gig_master.id')
                                                          ->select('gig_skill_rel.*')
                                                           ->where('gig_master.gigpostrequestflag','2')
                                                          ->where('gig_master.artist_id',$userID)
                                                          ->where('gig_master.type_flag',1)
                                                          ->where('gig_skill_rel.genre',$skillid)
                                                          ->where('gig_skill_rel.type_flag',1)
                                                          ->get();


                                                          //************* If gig posted chcekcking starts here

                                                          $dplicktchk_gig = DB::table('gig_master')
                                                          ->join('gig_skill_rel', 'gig_skill_rel.gigmaster_id', '=', 'gig_master.id')
                                                          ->select('gig_skill_rel.*')
                                                          ->where('gig_master.gigpostrequestflag','1')
                                                          ->where('gig_master.booker_id',$userID)
                                                          ->where('gig_skill_rel.genre',$skillid)
                                                          ->get();

                                                          //************* If gig posted checking ends here
                                                          // echo "This is for gig posing";
                                                          // echo "<pre>";
                                                          // print_r($dplicktchk_gig);
                                                          // die;
                                                          $dplicktchk_gigcount = count($dplicktchk_gig);
                                                          $dplicktcount = count($dplicktchk);


                                                           if($dplicktcount == 0 && $dplicktchk_gigcount == 0)
                                                          {
                                                                    // $responsearray =array();
                                                                    $select_userkillsubskill = DB::table('user_skill_rel')
                                                                    ->select('id')
                                                                    ->where('user_id',$userID)

                                                                    ->where('catag_type_id','=','1')
                                                                    ->where('skill_id','=',$skill_parentid)
                                                                    ->where('skill_sub_id','=',$skillid)
                                                                    ->first();

                                                                    if($select_userkillsubskill)
                                                                    {
                                                                        $userskillid = $select_userkillsubskill->id;//die;
                                                                        $dltgrupskill = DB::table('user_skill_rel')->where('id', $userskillid)->delete();
                                                                      
                                                                    }
                                                                    $responsearray['typeflag'] ='done';
                                                                  //  $responseflag = 1;
                                                                   
                                                          }
                                                          else if($dplicktcount > 0 || $dplicktchk_gigcount > 0)
                                                          {
                                                               //  $responsearray =array();
                                                             $responsearray['typeflag'] ='exists';
                                                                   // $responseflag = 0;
                                                          }else
                                                          {
                                                            // $responsearray =array();
                                                              // $responseflag = 0;
                                                             $responsearray['typeflag'] ='error';
                                                          }






                                    
                                    // die;
                                    $languageidAr = $this->commonusercategory_subcategory($userID);

                                   

                                   // $responsearray['flag_data'] = $responseflag;
                                    $responsearray['response_data'] = $languageidAr;

                                    // echo "<pre>";
                                    // print_r($responsearray);die;
                                   echo json_encode($responsearray);exit;




                        }

                        public function skillwisesubskilldisplayeuser(Request $request)
                        {
                               
                                $userID = $request->input('userID');



                                $responsearray =array();
                                $languageidAr = $this->commonusercategory_subcategory($userID);

                                $responsearray['response_data'] = $languageidAr;

                                echo json_encode($responsearray);
                        }



                             public function commonusercategory_subcategory($userID)
                            {
                               
$selectstr="usr.`skill_id` ,GROUP_CONCAT(distinct sm.name) as skill_name, GROUP_CONCAT(usr.skill_sub_id) as skill_sub_id, GROUP_CONCAT(ss.name) AS skill_sub_name ,GROUP_CONCAT(distinct usr.user_id) as user_id ";

$skill_user_db=DB::table('user_skill_rel as usr');

$skill_user_db=$skill_user_db->select(DB::raw($selectstr));
$skill_user_db=$skill_user_db->leftJoin('skill_master AS sm', 'usr.skill_id', '=', 'sm.id');
$skill_user_db=$skill_user_db->leftJoin('skill_master AS ss', 'usr.skill_sub_id', '=', 'ss.id');

$skill_user_db=$skill_user_db->where('usr.user_id', $userID);
$skill_user_db=$skill_user_db->groupBy('usr.skill_id');

$skill_user_db=$skill_user_db->get();

                                            // echo "<pre>";
                                            // print_r($skill_user_db);die;

                                    $languageidAr = array();


                                    //********* 
                                    foreach($skill_user_db as $skill_user_obj)
                                    {
                                        $userid_ofskill = $skill_user_obj->user_id;
                                        $skill_parent_data=$skill_user_obj->skill_id;
                                        $skill_parent_txtdata=stripslashes($skill_user_obj->skill_name);
                                        $skill_sub_data_str=$skill_user_obj->skill_sub_id;
                                        $skill_sub_txtdata_str=$skill_user_obj->skill_sub_name;
                                        $skill_sub_data_Ar=explode(",",$skill_sub_data_str);
                                        $skill_sub_txtdata_Ar=explode(",",$skill_sub_txtdata_str);

                                        $languageidAr[]= "<strong>".$skill_parent_txtdata."<strong>";
                                        $languageidAr[]=" :  ";

                                    if(!empty($skill_sub_data_Ar))
                                    {
                                        $skill_lim =  count($skill_sub_data_Ar);
                                        $i = 0;
                                        $j=",";

                                        foreach($skill_sub_data_Ar as $kk => $kvlue)
                                        {
                                            $i++;
                                            if($i == $skill_lim)
                                            {
                                                $j=".";
                                            }
                                            $skill_sub_data=$skill_sub_data_Ar[$kk];
                                            $skill_sub_txtdata=$skill_sub_txtdata_Ar[$kk];
                                          
 $languageidAr[]= $skill_sub_txtdata."<a onclick='showmedeluser(".$skill_sub_data.",".$skill_parent_data.");'> <i class='fa fa-times' aria-hidden='true'></i></a> ".$j;
                                            ?>
                                           
                                            <?php
                                        }
                                        $languageidAr[]="<br>";
                                    }

                                    }
                                    //*********

                                    
                                    return $languageidAr;
                           



                            }

                         
                            //*****for user section ends


                            //**********for password strength validation starts here
                                        public function passwordisinvalid($request,$addeditid=0)
                                        {   
                                            $invalidresp=false;
                                            $errormsgs=''; 

                                            $newpass = trim($request->input('newpass'));
                                            $pattern="/^(?=.{8,15})(?=[a-zA-Z0-9^\w\s]*)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";

                                            if(!preg_match($pattern,$newpass))
                                            {

                                            $errormsgs='Password should contain atleast one uppercase, one lowercase, one digit and between 8 - 15 characters';

                                            }

                                            return $errormsgs;
                                        }

                            //**********for password strength validation ends here

                                        //************ for user image save starts here

 public function adminuserimagesave(Request $request)
                                        {
      
           
          
           
            $usrid = $request->input('userid_fr_imageupload');
        //    echo $id;

          //   echo "<pre>"; print_r($_FILES);echo "</pre>";
         //  die;

            $chkvalidimage=$this->fileisinvalid($request,$usrid);
              
            $err_resp_msg=''; $respflg=0; $uploadedsuccnames=array(); $user_master_img_db=array();$getuserimgallAr=array();
            $slider_contents=''; $default_image_name='';$getuserimg=array();
            $venuecretaeOredit =0;
            $nicknmres =0;$totlalfilepresent=0;
              
            $errormsgs=$chkvalidimage['errormsgs'];
            $errfileAr=$chkvalidimage['errfileAr'];
            $totalfileposted=$chkvalidimage['totalfileposted'];
              
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
           
                  //**** image code starts
                       
                       
                       $allowedFileExtAr=array();
                       $allowedFileExtAr[]="jpg";
                       $allowedFileExtAr[]="jpeg";
                       $allowedFileExtAr[]="png";
                       
                       $filecontrolname="image_name";
                       
                      
                       $allowedFileExtSizeAr=array();
                       $allowedFileExtSizeAr['jpg']=(5*1024*1024);
                       $allowedFileExtSizeAr['jpeg']=(5*1024*1024);
                       $allowedFileExtSizeAr['png']=(5*1024*1024);
                       
                       
                       
                       //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                       $allowedFileResolAr=array();
                       
                       $allowedFileResolAr['jpeg']=array('min_width'=>458,'min_height'=>476);
                       $allowedFileResolAr['jpg']=array('min_width'=>458,'min_height'=>476);
                       $allowedFileResolAr['png']=array('min_width'=>458,'min_height'=>476);
                       $func="uploadfile";//validatefile/uploadfile
                       
                       
                       $destinationsourcePath=public_path()."/upload/userimage/source-file/";                         
                      
                       $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath,$errfileAr) ;
                       
                       
                         //echo "==Imcommonpath=>".$Imcommonpath;
                         //echo "==chkimg1==><pre>";
                         //print_r($chkimgresp);
                         //echo "</pre>";  //exit();
                   
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
                               
                               
                               $singleimagename='';$thumbfileName='';
                               
                               if(!empty($fileuploadednames))
                               {
                                       $destinationcommonPath=public_path()."/upload/userimage/";
                                       
                                       foreach($fileuploadednames as $fileuploadednameAr)
                                       {
                                             
                                              $thumbfileName=$fileuploadednameAr['filenamedata'];
                                               $sourcepathwithimage=$fileuploadednameAr['fileuploadedpath'].$thumbfileName;
                                               
                                                $uploadedsuccnames[]=$thumbfileName;
                                               
                                              
                                               $destinationfilewithPath1=$destinationcommonPath."thumb-big/".$thumbfileName;
                                              //  echo "==destinationfilewithPath1==>". $destinationfilewithPath1; exit();
                                               $width=537;$height=0;//$height=507;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath1,$width,$height);
                                               
                                               $destinationfilewithPath2=$destinationcommonPath."thumb-medium/".$thumbfileName;
                                               $width=208;$height=0;//$height=201;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath2,$width,$height);
                                               
                                               $destinationfilewithPath3=$destinationcommonPath."thumb-small/".$thumbfileName;
                                               $width=52;$height=52;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath3,$width,$height);
                              
                                      
                                      
                                       }
                                       
                                      $singleimagename=$thumbfileName;
                                       
                               }
                               
                      
                       
                       }
                       
                       //**** image code ends
                       
                       
                       //*****  insert into image table starts
                       
                       //$uploadedsuccnames
                       
                       if(!empty($uploadedsuccnames))
                       {
                              $user_id=1;
                              if ($request->session()->has('front_id_sess'))
                              {
                                      $user_id=$request->session()->get('front_id_sess'); // get session                       
                              //$Venueid = $this->getseo_name($user_id);
                              }
                              
                                      //**********check modifying date starts here
                                    //  $r = $this->check_modifying_date($Venueid,$user_id);
                                      //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                        
                              foreach($uploadedsuccnames as $user_image_name)
                              {
                                    $default_status=0;
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 starts
                                          $selectstr=" umtb.* ";
                                          
                                          $user_master_img_db=DB::table('user_master_img as umtb');              
                                          $user_master_img_db=$user_master_img_db->select(DB::raw($selectstr));                                                          
                                          // $user_master_img_db=$user_master_img_db->where('umtb.venue_id', $Venueid);
                                           $user_master_img_db=$user_master_img_db->where('umtb.user_id', $usrid);
                                          $user_master_img_db=$user_master_img_db->orderBy("umtb.id", "asc");
                                          $user_master_img_db = $user_master_img_db->skip(0)->take(3);
                                          $user_master_img_db=$user_master_img_db->get();
                                          $totlalfilepresent = count($user_master_img_db);
                                          if(!empty($user_master_img_db))
                                          {
                                                $default_status=0;
                                          }
                                          else
                                          {
                                                $default_status=1;
                                          }
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 ends
                                    
                                               
                                    $user_img_array=array();
                                  
                                    $user_img_array['default_status']=$default_status;
                                    $user_img_array['image_name']=addslashes($user_image_name);
                                    // $user_img_array['venue_id']=$Venueid;
                                     $user_img_array['user_id']=$usrid;
                                    $user_img_array['create_date']=date('Y-m-d H:i:s');
                                    $user_img_array['modified_date']=date('Y-m-d H:i:s'); 
                                    $chkupd= DB::table('user_master_img')->insert($user_img_array );
                                    $last_insert_id=DB::getPdo()->lastInsertId();
                                    $totlalfilepresent = $totlalfilepresent +1;

                                    //************* fetching user all image starts here

                                    $getuserimg = $this->fetchallimageuser($usrid);
                                   
                                   
                                    //************* fetching user all image ends here
                                   
                                    
                                    
                              }
                                      DB::table('user_master_img')
                                      ->where('id', $usrid)
                                      ->update(['modified_date'=>date('Y-m-d H:i:s') ]);
                              //*** fetch this user related images starts
                              
                
                              $selectstr=" umtb.* ";
                             
                              $venue_master_img_db=DB::table('user_master_img as umtb');              
                              $venue_master_img_db=$venue_master_img_db->select(DB::raw($selectstr));                                                          
                              // $venue_master_img_db=$venue_master_img_db->where('umtb.venue_id', $Venueid);
                              $venue_master_img_db=$venue_master_img_db->where('umtb.user_id', $usrid);
                              $venue_master_img_db=$venue_master_img_db->orderBy("umtb.id", "asc");
                              $venue_master_img_db = $venue_master_img_db->skip(0)->take(3);
                              $venue_master_img_db=$venue_master_img_db->get();
                              
                              if(!empty($venue_master_img_db))
                              {
                                    
                                     $default_image_name= $venue_master_img_db[0]->image_name;       
                              }
                              
                              //*** fetch this user related images ends
                              
                             
                              
                       }
                       
                       
                       //*****  insert into image table ends
                       
                       
            
            }
            else
            {
                   if(!empty($usrid))
                        {
                              
                             
                              
                             $err_resp_msg= $errormsgs;
                              
                        }
                        else
                        {
                              //return redirect(ADMINSEPARATOR.'/banneradd')
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                                $err_resp_msg= $errormsgs;
                        }
            }
            
            
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
                  $respflg=1;
              }
            
                  
            
            $respAr=array();
             $respAr['venuecretaeedit']=$venuecretaeOredit;
          $respAr['nicknmdata']= $nicknmres;
            $respAr['flag']=$respflg;
            $respAr['errorespmsg']=$err_resp_msg;
            $respAr['errfileAr']=$errfileAr;
            $respAr['totalfileposted']=$totalfileposted;
            $respAr['uploadedsuccnames']=$uploadedsuccnames;
          //  $respAr['slider_contents']=$slider_contents;
            $respAr['default_image_name']=$default_image_name;
            $respAr['totlalfilepresent'] = $totlalfilepresent;

            $respAr['getuserimgallAr'] = $getuserimg;
            //$respAr['user_master_img_db']=$user_master_img_db;
           //  $respAr['chkimgresp']=$chkimgresp;


        /*    echo "<pre>";
            print_r($respAr);die;*/


            echo json_encode($respAr);
           
          
          
      }
      public function fileisinvalid($request,$addeditid=0)
       {
               
                // echo "<pre>";    print_r($request); exit();
                
                
                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="jpg";
                $allowedFileExtAr[]="jpeg";
                $allowedFileExtAr[]="png";
                
                $filecontrolname="image_name";
                
               
                $allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['jpg']=(5*1024*1024);
                $allowedFileExtSizeAr['jpeg']=(5*1024*1024);
                $allowedFileExtSizeAr['png']=(5*1024*1024);
                
                
                
                //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                $allowedFileResolAr=array();
                
                $allowedFileResolAr['jpeg']=array('min_width'=>458,'min_height'=>476);
                $allowedFileResolAr['jpg']=array('min_width'=>458,'min_height'=>476);
                $allowedFileResolAr['png']=array('min_width'=>458,'min_height'=>476);
                $func="validatefile";//validatefile/uploadfile
                
                
                $destinationsourcePath=public_path()."/upload/userimage/source-file/";                       
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$destinationsourcePath,$errfileAr=array()) ;
                       
                
                
                
               
               /* echo "==chkimg1==><pre>";
                print_r($chkimgresp);
                echo "</pre>"; */ //exit();
                
               
               $invalidresp=false;
               
               $errormsgs='';  $fileuploadednames=array(); $errfileAr=array();
               $totalfileposted=0;
               
                if(!empty($chkimgresp))
                {
                        
                        
                        if(array_key_exists('errormsgs',$chkimgresp))
                        {
                                $errormsgs=$chkimgresp['errormsgs'];
                        }
                        
                        if(array_key_exists('errfileAr',$chkimgresp))
                        {
                                $errfileAr=$chkimgresp['errfileAr'];
                        }
                        
                        if(array_key_exists('totalfileposted',$chkimgresp))
                        {
                                $totalfileposted=$chkimgresp['totalfileposted'];
                        }
                        
                }
                
                $resparray=array();
                $resparray['errormsgs']=$errormsgs;
                $resparray['errfileAr']=$errfileAr;
                $resparray['totalfileposted']=$totalfileposted;
                
                return $resparray;
       }
       
      

                                        //************  for user image save ends here

       //**************delete user image admin starts here

       public function adminuserimagedelete(Request $request){
                $userID = $request->input('userID');
                $userimgID = $request->input('userimgID');
                $userimgsts = $request->input('userimgsts');
                 $respAr=array();

                $getuserimgallAr = array();
                $responseflag=0;$getuserimgallArcount=0;

                $dleteusrimg_qry = DB::table('user_master_img')
                                ->where('id',$userimgID)
                                ->where('user_id',$userID)
                                ->delete();


                                $usrimg_qry = DB::table('user_master_img')
                                ->select('id','default_status')
                               // ->where('id',$userimgID)
                                ->where('user_id',$userID)
                                ->orderBy('default_status','desc')
                                ->first();
                                if($usrimg_qry)
                                {
                                    $listedfirstdefaltststus =  $usrimg_qry->default_status;
                                    $listedfirst_id=$usrimg_qry->id;
                                    if($listedfirstdefaltststus == 0)
                                    {
                                        DB::table('user_master_img')
                                        ->where('id', $listedfirst_id)
                                        ->update(['default_status' => 1]);
                                    }
                                    $getuserimgallAr = $this->fetchallimageuser($userID);
                                    if($getuserimgallAr)
                                    {
                                    $getuserimgallArcount =count($getuserimgallAr);
                                       $respAr['getuserimgallAr'] =$getuserimgallAr;
                                    }

                                    $responseflag =1;
                                }
                                  if($getuserimgallArcount == 0)
                                    {
                                          $imgurldatablnk = BASEURLPUBLICCUSTOM.'admin/otherfiles/progimages/noimagefound52X52.jpg';
                                        // $getuserimgallAr = "<img src=".$imgurldatablnk.">";
                                           $respAr['getuserimgallAr'] ="<img src=".$imgurldatablnk.">";
                                    }

                               
                                $respAr['responseflag'] =$responseflag;
                                // $respAr['getuserimgallAr'] =$getuserimgallAr;
                                $respAr['getuserimgallArcount'] =$getuserimgallArcount;

                               // echo "<pre>";
                               // print_r($respAr);die;
                            echo   json_encode($respAr);
                                

       }

       //********fetching all images for user starts here

public function fetchallimageuser($usrid){

                                    $getuserimgallAr = array();
                                    $getuserimg = DB::table('user_master_img')
                                   // ->select('id','image_name')
                                    ->where('user_id',$usrid)
                                    ->orderBy('default_status', 'desc')
                                    ->get();

                                    
                                    foreach($getuserimg as $getuserimgall_obj)
                                    {
                                       $imgname = $getuserimgall_obj->image_name;
                                      $usID= $getuserimgall_obj->user_id;
                                       $userimgsts= $getuserimgall_obj->default_status;
                                      $userimgID= $getuserimgall_obj->id;
                                      $imgurldata = BASEURLPUBLICCUSTOM.'upload/userimage/thumb-small/'.$imgname;
    $getuserimgallAr[]= "<img src=".$imgurldata." onclick=showIMageFancy('".$imgname."'); ><a onclick='deleteuserimage(".$userimgID.",".$userimgsts.",".$usID.");'> Delete</a> ";
                                    }
                               
                                   

                                   return $getuserimgallAr;
                                  
                                   
                                    //************* fetching user all image ends here


       //********fetching all images for user ensds here
}

      //***********for user venue image save starts here

                                            //************ for user image save starts here

 public function adminuservenueimagesave(Request $request)
                                        {
      
           
          
           
            $usrid = $request->input('userid_fr_imageupload');
            $venueid = $request->input('venueid_fr_imageupload');
        //    echo $id;

          //   echo "<pre>"; print_r($_FILES);echo "</pre>";
         //  die;

            $chkvalidimage=$this->fileisinvalidvenue($request,$usrid);
              
            $err_resp_msg=''; $respflg=0; $uploadedsuccnames=array(); $venue_master_img_db=array();$getuservenueimgallAr=array();
            $slider_contents=''; $default_image_name='';$getuserimg=array();
            $venuecretaeOredit =0;
            $nicknmres =0;$totlalfilepresent=0;
              
            $errormsgs=$chkvalidimage['errormsgs'];
            $errfileAr=$chkvalidimage['errfileAr'];
            $totalfileposted=$chkvalidimage['totalfileposted'];
              
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
           
                  //**** image code starts
                       
                       
                       $allowedFileExtAr=array();
                       $allowedFileExtAr[]="jpg";
                       $allowedFileExtAr[]="jpeg";
                       $allowedFileExtAr[]="png";
                       
                       $filecontrolname="image_name";
                       
                      
                       $allowedFileExtSizeAr=array();
                       $allowedFileExtSizeAr['jpg']=(5*1024*1024);
                       $allowedFileExtSizeAr['jpeg']=(5*1024*1024);
                       $allowedFileExtSizeAr['png']=(5*1024*1024);
                       
                       
                       
                       //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                       $allowedFileResolAr=array();
                       
                       $allowedFileResolAr['jpeg']=array('min_width'=>458,'min_height'=>476);
                       $allowedFileResolAr['jpg']=array('min_width'=>458,'min_height'=>476);
                       $allowedFileResolAr['png']=array('min_width'=>458,'min_height'=>476);
                       $func="uploadfile";//validatefile/uploadfile
                       
                       
                       $destinationsourcePath=public_path()."/upload/venueimage/source-file/";                         
                      
                       $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath,$errfileAr) ;
                       
                       
                         //echo "==Imcommonpath=>".$Imcommonpath;
                         //echo "==chkimg1==><pre>";
                         //print_r($chkimgresp);
                         //echo "</pre>";  //exit();
                   
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
                               
                               
                               $singleimagename='';$thumbfileName='';
                               
                               if(!empty($fileuploadednames))
                               {
                                       $destinationcommonPath=public_path()."/upload/venueimage/";
                                       
                                       foreach($fileuploadednames as $fileuploadednameAr)
                                       {
                                             
                                              $thumbfileName=$fileuploadednameAr['filenamedata'];
                                               $sourcepathwithimage=$fileuploadednameAr['fileuploadedpath'].$thumbfileName;
                                               
                                                $uploadedsuccnames[]=$thumbfileName;
                                               
                                              
                                               $destinationfilewithPath1=$destinationcommonPath."thumb-big/".$thumbfileName;
                                              //  echo "==destinationfilewithPath1==>". $destinationfilewithPath1; exit();
                                               $width=537;$height=0;//$height=507;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath1,$width,$height);
                                               
                                               $destinationfilewithPath2=$destinationcommonPath."thumb-medium/".$thumbfileName;
                                               $width=208;$height=0;//$height=201;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath2,$width,$height);
                                               
                                               $destinationfilewithPath3=$destinationcommonPath."thumb-small/".$thumbfileName;
                                               $width=52;$height=52;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath3,$width,$height);
                              
                                      
                                      
                                       }
                                       
                                      $singleimagename=$thumbfileName;
                                       
                               }
                               
                      
                       
                       }
                       
                       //**** image code ends
                       
                       
                       //*****  insert into image table starts
                       
                       //$uploadedsuccnames
                       
                       if(!empty($uploadedsuccnames))
                       {
                             
                                      //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                        
                              foreach($uploadedsuccnames as $venue_image_name)
                              {
                                    $default_status=0;
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 starts
                                          $selectstr=" umtb.* ";
                                          
                                          $venue_master_img_db=DB::table('venue_master_img as umtb');              
                                          $venue_master_img_db=$venue_master_img_db->select(DB::raw($selectstr));                                                          
                                           $venue_master_img_db=$venue_master_img_db->where('umtb.venue_id', $venueid);
                                           $venue_master_img_db=$venue_master_img_db->where('umtb.v_creator_id', $usrid);
                                          $venue_master_img_db=$venue_master_img_db->orderBy("umtb.id", "asc");
                                          $venue_master_img_db = $venue_master_img_db->skip(0)->take(3);
                                          $venue_master_img_db=$venue_master_img_db->get();
                                          $totlalfilepresent = count($venue_master_img_db);
                                          if(!empty($venue_master_img_db))
                                          {
                                                $default_status=0;
                                          }
                                          else
                                          {
                                                $default_status=1;
                                          }
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 ends
                                    
                                               
                                    $user_img_array=array();
                                  
                                    $user_img_array['default_status']=$default_status;
                                    $user_img_array['image_name']=addslashes($venue_image_name);
                                    $user_img_array['venue_id']=$venueid;
                                     $user_img_array['v_creator_id']=$usrid;
                                    $user_img_array['create_date']=date('Y-m-d H:i:s');
                                    $user_img_array['modified_date']=date('Y-m-d H:i:s'); 
                                    $chkupd= DB::table('venue_master_img')->insert($user_img_array );
                                    $last_insert_id=DB::getPdo()->lastInsertId();
                                    $totlalfilepresent = $totlalfilepresent +1;

                                    //************* fetching user all image starts here

                                    $getuserimg = $this->fetchallimagevenue($venueid,$usrid);
                                   
                                   
                                    //************* fetching user all image ends here
                                   
                                    
                                    
                              }
                                      DB::table('venue_master_img')
                                      ->where('venue_id', $venueid)
                                       ->where('v_creator_id', $usrid)
                                      ->update(['modified_date'=>date('Y-m-d H:i:s') ]);
                              //*** fetch this user related images starts
                              
                
                              $selectstr=" umtb.* ";
                             
                              $venue_master_img_db=DB::table('venue_master_img as umtb');              
                              $venue_master_img_db=$venue_master_img_db->select(DB::raw($selectstr));                                                          
                              $venue_master_img_db=$venue_master_img_db->where('umtb.venue_id', $venueid);
                              $venue_master_img_db=$venue_master_img_db->where('umtb.v_creator_id', $usrid);
                              $venue_master_img_db=$venue_master_img_db->orderBy("umtb.id", "asc");
                              $venue_master_img_db = $venue_master_img_db->skip(0)->take(3);
                              $venue_master_img_db=$venue_master_img_db->get();
                              
                              if(!empty($venue_master_img_db))
                              {
                                    
                                     $default_image_name= $venue_master_img_db[0]->image_name;       
                              }
                              
                              //*** fetch this user related images ends
                              
                             
                              
                       }
                       
                       
                       //*****  insert into image table ends
                       
                       
            
            }
            else
            {
                   if(!empty($usrid))
                        {
                              
                             
                              
                             $err_resp_msg= $errormsgs;
                              
                        }
                        else
                        {
                              //return redirect(ADMINSEPARATOR.'/banneradd')
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                                $err_resp_msg= $errormsgs;
                        }
            }
            
            
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
                  $respflg=1;
              }
            
                  
            
            $respAr=array();
             $respAr['venuecretaeedit']=$venuecretaeOredit;
          $respAr['nicknmdata']= $nicknmres;
            $respAr['flag']=$respflg;
            $respAr['errorespmsg']=$err_resp_msg;
            $respAr['errfileAr']=$errfileAr;
            $respAr['totalfileposted']=$totalfileposted;
            $respAr['uploadedsuccnames']=$uploadedsuccnames;
          //  $respAr['slider_contents']=$slider_contents;
            $respAr['default_image_name']=$default_image_name;
            $respAr['totlalfilepresent'] = $totlalfilepresent;

            $respAr['getuservenueimgallAr'] = $getuserimg;
            //$respAr['user_master_img_db']=$user_master_img_db;
           //  $respAr['chkimgresp']=$chkimgresp;


            // echo "<pre>";
            // print_r($respAr);die;


           echo json_encode($respAr);
           
          
          
      }

     //******for user venue image save ensds here


       public function fileisinvalidvenue($request,$addeditid=0)
       {
               
                // echo "<pre>";    print_r($request); exit();
                
                
                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="jpg";
                $allowedFileExtAr[]="jpeg";
                $allowedFileExtAr[]="png";
                
                $filecontrolname="image_name";
                
               
                $allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['jpg']=(5*1024*1024);
                $allowedFileExtSizeAr['jpeg']=(5*1024*1024);
                $allowedFileExtSizeAr['png']=(5*1024*1024);
                
                
                
                //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                $allowedFileResolAr=array();
                
                $allowedFileResolAr['jpeg']=array('min_width'=>458,'min_height'=>476);
                $allowedFileResolAr['jpg']=array('min_width'=>458,'min_height'=>476);
                $allowedFileResolAr['png']=array('min_width'=>458,'min_height'=>476);
                $func="validatefile";//validatefile/uploadfile
                
                
                $destinationsourcePath=public_path()."/upload/venueimage/source-file/";                       
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$destinationsourcePath,$errfileAr=array()) ;
                       
                
                
                
               
               /* echo "==chkimg1==><pre>";
                print_r($chkimgresp);
                echo "</pre>"; */ //exit();
                
               
               $invalidresp=false;
               
               $errormsgs='';  $fileuploadednames=array(); $errfileAr=array();
               $totalfileposted=0;
               
                if(!empty($chkimgresp))
                {
                        
                        
                        if(array_key_exists('errormsgs',$chkimgresp))
                        {
                                $errormsgs=$chkimgresp['errormsgs'];
                        }
                        
                        if(array_key_exists('errfileAr',$chkimgresp))
                        {
                                $errfileAr=$chkimgresp['errfileAr'];
                        }
                        
                        if(array_key_exists('totalfileposted',$chkimgresp))
                        {
                                $totalfileposted=$chkimgresp['totalfileposted'];
                        }
                        
                }
                
                $resparray=array();
                $resparray['errormsgs']=$errormsgs;
                $resparray['errfileAr']=$errfileAr;
                $resparray['totalfileposted']=$totalfileposted;
                
                return $resparray;
       }



       public function fetchallimagevenue($venueid,$venuecreaterid){

                                    $getuserimgallAr = array();
                                    $getuserimg = DB::table('venue_master_img')
                                   // ->select('id','image_name')
                                    ->where('venue_id',$venueid)
                                    ->where('v_creator_id',$venuecreaterid)
                                    ->orderBy('default_status', 'desc')
                                    ->get();

                                    
                                    foreach($getuserimg as $getuserimgall_obj)
                                    {
                                       $imgname = $getuserimgall_obj->image_name;
                                        $venue_id= $getuserimgall_obj->venue_id;
                                      $usID= $getuserimgall_obj->v_creator_id;
                                       $userimgsts= $getuserimgall_obj->default_status;
                                      $userimgID= $getuserimgall_obj->id;
                                      $imgurldata = BASEURLPUBLICCUSTOM.'upload/venueimage/thumb-small/'.$imgname;
    $getuserimgallAr[]= "<img src=".$imgurldata." onclick=showIMageFancy('".$imgname."'); ><a onclick='deletevenueimage(".$userimgID.",".$userimgsts.",".$usID.",".$venue_id.");'> Delete</a> ";
                                    }
                               
                                   

                                   return $getuserimgallAr;
                                  
                                   
                                    //************* fetching user all image ends here


       //********fetching all images for user ensds here
}

 //**************delete user venue image admin starts here

       public function adminuservenueimagedelete(Request $request){
                $userID = $request->input('userID');
                $userimgID = $request->input('userimgID');
                $userimgsts = $request->input('userimgsts');
                 $hdnuservenueID = $request->input('hdnuservenueID');


                 $respAr=array();

                $getuserimgallAr = array();
                $responseflag=0;$getuserimgallArcount=0;

                $dleteusrimg_qry = DB::table('venue_master_img')
                                ->where('id',$userimgID)
                                ->where('venue_id',$hdnuservenueID)
                                ->where('v_creator_id',$userID)
                                ->delete();


                                $usrimg_qry = DB::table('venue_master_img')
                                ->select('id','default_status')
                               // ->where('id',$userimgID)
                                ->where('venue_id',$hdnuservenueID)
                                ->where('v_creator_id',$userID)
                                ->orderBy('default_status','desc')
                                ->first();
                                if($usrimg_qry)
                                {
                                    $listedfirstdefaltststus =  $usrimg_qry->default_status;
                                    $listedfirst_id=$usrimg_qry->id;
                                    if($listedfirstdefaltststus == 0)
                                    {
                                        DB::table('venue_master_img')
                                        ->where('id', $listedfirst_id)
                                        ->update(['default_status' => 1]);
                                    }
                                    $getuserimgallAr = $this->fetchallimagevenue($hdnuservenueID,$userID);
                                    if($getuserimgallAr)
                                    {
                                    $getuserimgallArcount =count($getuserimgallAr);
                                       $respAr['getuserimgallAr'] =$getuserimgallAr;
                                    }

                                    $responseflag =1;
                                }
                                  if($getuserimgallArcount == 0)
                                    {
                                          $imgurldatablnk = BASEURLPUBLICCUSTOM.'admin/otherfiles/progimages/noimagefound52X52.jpg';
                                        // $getuserimgallAr = "<img src=".$imgurldatablnk.">";
                                           $respAr['getuserimgallAr'] ="<img src=".$imgurldatablnk.">";
                                    }

                               
                                $respAr['responseflag'] =$responseflag;
                                // $respAr['getuserimgallAr'] =$getuserimgallAr;
                                $respAr['getuserimgallArcount'] =$getuserimgallArcount;

                               // echo "<pre>";
                               // print_r($respAr);die;
                            echo   json_encode($respAr);
                                

       }







       public function adminusergroupimagesave(Request $request)
                                        {
      
           
          
           
            $usrid = $request->input('userid_fr_imageupload');
            $groupid = $request->input('groupid_fr_imageupload');
        //    echo $id;

          //   echo "<pre>"; print_r($_FILES);echo "</pre>";
         //  die;

            $chkvalidimage=$this->fileisinvalidgroup($request,$usrid);
              
            $err_resp_msg=''; $respflg=0; $uploadedsuccnames=array(); $group_master_img_db=array();$getuservenueimgallAr=array();
            $slider_contents=''; $default_image_name='';$getuserimg=array();
            $venuecretaeOredit =0;
            $nicknmres =0;$totlalfilepresent=0;
              
            $errormsgs=$chkvalidimage['errormsgs'];
            $errfileAr=$chkvalidimage['errfileAr'];
            $totalfileposted=$chkvalidimage['totalfileposted'];
              
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
           
                  //**** image code starts
                       
                       
                       $allowedFileExtAr=array();
                       $allowedFileExtAr[]="jpg";
                       $allowedFileExtAr[]="jpeg";
                       $allowedFileExtAr[]="png";
                       
                       $filecontrolname="image_name";
                       
                      
                       $allowedFileExtSizeAr=array();
                       $allowedFileExtSizeAr['jpg']=(5*1024*1024);
                       $allowedFileExtSizeAr['jpeg']=(5*1024*1024);
                       $allowedFileExtSizeAr['png']=(5*1024*1024);
                       
                       
                       
                       //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                       $allowedFileResolAr=array();
                       
                       $allowedFileResolAr['jpeg']=array('min_width'=>458,'min_height'=>476);
                       $allowedFileResolAr['jpg']=array('min_width'=>458,'min_height'=>476);
                       $allowedFileResolAr['png']=array('min_width'=>458,'min_height'=>476);
                       $func="uploadfile";//validatefile/uploadfile
                       
                       
                       $destinationsourcePath=public_path()."/upload/groupimage/source-file/";                         
                      
                       $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$destinationsourcePath,$errfileAr) ;
                       
                       
                         //echo "==Imcommonpath=>".$Imcommonpath;
                         //echo "==chkimg1==><pre>";
                         //print_r($chkimgresp);
                         //echo "</pre>";  //exit();
                   
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
                               
                               
                               $singleimagename='';$thumbfileName='';
                               
                               if(!empty($fileuploadednames))
                               {
                                       $destinationcommonPath=public_path()."/upload/groupimage/";
                                       
                                       foreach($fileuploadednames as $fileuploadednameAr)
                                       {
                                             
                                              $thumbfileName=$fileuploadednameAr['filenamedata'];
                                               $sourcepathwithimage=$fileuploadednameAr['fileuploadedpath'].$thumbfileName;
                                               
                                                $uploadedsuccnames[]=$thumbfileName;
                                               
                                              
                                               $destinationfilewithPath1=$destinationcommonPath."thumb-big/".$thumbfileName;
                                              //  echo "==destinationfilewithPath1==>". $destinationfilewithPath1; exit();
                                               $width=537;$height=0;//$height=507;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath1,$width,$height);
                                               
                                               $destinationfilewithPath2=$destinationcommonPath."thumb-medium/".$thumbfileName;
                                               $width=208;$height=0;//$height=201;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath2,$width,$height);
                                               
                                               $destinationfilewithPath3=$destinationcommonPath."thumb-small/".$thumbfileName;
                                               $width=52;$height=52;
                                             
                                               Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath3,$width,$height);
                              
                                      
                                      
                                       }
                                       
                                      $singleimagename=$thumbfileName;
                                       
                               }
                               
                      
                       
                       }
                       
                       //**** image code ends
                       
                       
                       //*****  insert into image table starts
                       
                       //$uploadedsuccnames
                       
                       if(!empty($uploadedsuccnames))
                       {
                             
                                      //IF MODIFYING DATE IS 1 THEN THIS IS FIRST TIME EDIT //*** update user_master table ends
                        
                              foreach($uploadedsuccnames as $group_image_name)
                              {
                                    $default_status=0;
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 starts
                                          $selectstr=" umtb.* ";
                                          
                                          $group_master_img_db=DB::table('group_master_img as umtb');              
                                          $group_master_img_db=$group_master_img_db->select(DB::raw($selectstr));                                                          
                                           $group_master_img_db=$group_master_img_db->where('umtb.group_id', $groupid);
                                           $group_master_img_db=$group_master_img_db->where('umtb.g_creator_id', $usrid);
                                          $group_master_img_db=$group_master_img_db->orderBy("umtb.id", "asc");
                                          $group_master_img_db = $group_master_img_db->skip(0)->take(3);
                                          $group_master_img_db=$group_master_img_db->get();
                                          $totlalfilepresent = count($group_master_img_db);
                                          if(!empty($group_master_img_db))
                                          {
                                                $default_status=0;
                                          }
                                          else
                                          {
                                                $default_status=1;
                                          }
                                    //*** check whether any prev image present then on insert default status will be 0 , else 1 ends
                                    
                                               
                                    $user_img_array=array();
                                  
                                    $user_img_array['default_status']=$default_status;
                                    $user_img_array['image_name']=addslashes($group_image_name);
                                    $user_img_array['group_id']=$groupid;
                                     $user_img_array['g_creator_id']=$usrid;
                                    $user_img_array['create_date']=date('Y-m-d H:i:s');
                                    $user_img_array['modified_date']=date('Y-m-d H:i:s'); 
                                    $chkupd= DB::table('group_master_img')->insert($user_img_array );
                                    $last_insert_id=DB::getPdo()->lastInsertId();
                                    $totlalfilepresent = $totlalfilepresent +1;

                                    //************* fetching user all image starts here

                                    $getuserimg = $this->fetchallimagegroup($groupid,$usrid);
                                   
                                   
                                    //************* fetching user all image ends here
                                   
                                    
                                    
                              }
                                      DB::table('group_master_img')
                                      ->where('group_id', $groupid)
                                       ->where('g_creator_id', $usrid)
                                      ->update(['modified_date'=>date('Y-m-d H:i:s') ]);
                              //*** fetch this user related images starts
                              
                
                              $selectstr=" umtb.* ";
                             
                              $group_master_img_db=DB::table('group_master_img as umtb');              
                              $group_master_img_db=$group_master_img_db->select(DB::raw($selectstr));                                                          
                              $group_master_img_db=$group_master_img_db->where('umtb.group_id', $groupid);
                              $group_master_img_db=$group_master_img_db->where('umtb.g_creator_id', $usrid);
                              $group_master_img_db=$group_master_img_db->orderBy("umtb.id", "asc");
                              $group_master_img_db = $group_master_img_db->skip(0)->take(3);
                              $group_master_img_db=$group_master_img_db->get();
                              
                              if(!empty($group_master_img_db))
                              {
                                    
                                     $default_image_name= $group_master_img_db[0]->image_name;       
                              }
                              
                              //*** fetch this user related images ends
                              
                             
                              
                       }
                       
                       
                       //*****  insert into image table ends
                       
                       
            
            }
            else
            {
                   if(!empty($usrid))
                        {
                              
                             
                              
                             $err_resp_msg= $errormsgs;
                              
                        }
                        else
                        {
                              //return redirect(ADMINSEPARATOR.'/banneradd')
                              //->withErrors($chkvalid)
                              //->withInput();
                              
                                $err_resp_msg= $errormsgs;
                        }
            }
            
            
             if ( empty($errormsgs) ||  (!empty($errormsgs) && (count($errfileAr)<$totalfileposted)) )
              {
                  $respflg=1;
              }
            
                  
            
            $respAr=array();
             $respAr['venuecretaeedit']=$venuecretaeOredit;
          $respAr['nicknmdata']= $nicknmres;
            $respAr['flag']=$respflg;
            $respAr['errorespmsg']=$err_resp_msg;
            $respAr['errfileAr']=$errfileAr;
            $respAr['totalfileposted']=$totalfileposted;
            $respAr['uploadedsuccnames']=$uploadedsuccnames;
          //  $respAr['slider_contents']=$slider_contents;
            $respAr['default_image_name']=$default_image_name;
            $respAr['totlalfilepresent'] = $totlalfilepresent;

            $respAr['getuservenueimgallAr'] = $getuserimg;
            //$respAr['user_master_img_db']=$user_master_img_db;
           //  $respAr['chkimgresp']=$chkimgresp;


            // echo "<pre>";
            // print_r($respAr);die;


           echo json_encode($respAr);
           
          
          
      }

     //******for user venue image save ensds here

   public function fileisinvalidgroup($request,$addeditid=0)
       {
               
                // echo "<pre>";    print_r($request); exit();
                
                
                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="jpg";
                $allowedFileExtAr[]="jpeg";
                $allowedFileExtAr[]="png";
                
                $filecontrolname="image_name";
                
               
                $allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['jpg']=(5*1024*1024);
                $allowedFileExtSizeAr['jpeg']=(5*1024*1024);
                $allowedFileExtSizeAr['png']=(5*1024*1024);
                
                
                
                //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                $allowedFileResolAr=array();
                
                $allowedFileResolAr['jpeg']=array('min_width'=>458,'min_height'=>476);
                $allowedFileResolAr['jpg']=array('min_width'=>458,'min_height'=>476);
                $allowedFileResolAr['png']=array('min_width'=>458,'min_height'=>476);
                $func="validatefile";//validatefile/uploadfile
                
                
                $destinationsourcePath=public_path()."/upload/groupimage/source-file/";                       
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$destinationsourcePath,$errfileAr=array()) ;
                       
                
                
                
               
               /* echo "==chkimg1==><pre>";
                print_r($chkimgresp);
                echo "</pre>"; */ //exit();
                
               
               $invalidresp=false;
               
               $errormsgs='';  $fileuploadednames=array(); $errfileAr=array();
               $totalfileposted=0;
               
                if(!empty($chkimgresp))
                {
                        
                        
                        if(array_key_exists('errormsgs',$chkimgresp))
                        {
                                $errormsgs=$chkimgresp['errormsgs'];
                        }
                        
                        if(array_key_exists('errfileAr',$chkimgresp))
                        {
                                $errfileAr=$chkimgresp['errfileAr'];
                        }
                        
                        if(array_key_exists('totalfileposted',$chkimgresp))
                        {
                                $totalfileposted=$chkimgresp['totalfileposted'];
                        }
                        
                }
                
                $resparray=array();
                $resparray['errormsgs']=$errormsgs;
                $resparray['errfileAr']=$errfileAr;
                $resparray['totalfileposted']=$totalfileposted;
                
                return $resparray;
       }

         public function fetchallimagegroup($groupid,$groupcreaterid){

                                    $getuserimgallAr = array();
                                    $getuserimg = DB::table('group_master_img')
                                   // ->select('id','image_name')
                                    ->where('group_id',$groupid)
                                    ->where('g_creator_id',$groupcreaterid)
                                    ->orderBy('default_status', 'desc')
                                    ->get();

                                    
                                    foreach($getuserimg as $getuserimgall_obj)
                                    {
                                       $imgname = $getuserimgall_obj->image_name;
                                        $group_id= $getuserimgall_obj->group_id;
                                      $usID= $getuserimgall_obj->g_creator_id;
                                       $userimgsts= $getuserimgall_obj->default_status;
                                      $userimgID= $getuserimgall_obj->id;
                                      $imgurldata = BASEURLPUBLICCUSTOM.'upload/groupimage/thumb-small/'.$imgname;
    $getuserimgallAr[]= "<img src=".$imgurldata." onclick=showIMageFancy('".$imgname."'); ><a onclick='deletegroupimage(".$userimgID.",".$userimgsts.",".$usID.",".$group_id.");'> Delete</a> ";
                                    }
                               
                                   

                                   return $getuserimgallAr;
                                  
                                   
                                    //************* fetching user all image ends here


       //********fetching all images for user ensds here
}


//*************delete group image starts here

 public function adminusergroupimagedelete(Request $request){
                $userID = $request->input('userID');
                $userimgID = $request->input('userimgID');
                $userimgsts = $request->input('userimgsts');
                 $hdnusergroupID = $request->input('hdnusergroupID');
// echo "hello";die;

                 $respAr=array();

                $getuserimgallAr = array();
                $responseflag=0;$getuserimgallArcount=0;

                $dleteusrimg_qry = DB::table('group_master_img')
                                ->where('id',$userimgID)
                                ->where('group_id',$hdnusergroupID)
                                ->where('g_creator_id',$userID)
                                ->delete();


                                $usrimg_qry = DB::table('group_master_img')
                                ->select('id','default_status')
                               // ->where('id',$userimgID)
                                ->where('group_id',$hdnusergroupID)
                                ->where('g_creator_id',$userID)
                                ->orderBy('default_status','desc')
                                ->first();
                                if($usrimg_qry)
                                {
                                    $listedfirstdefaltststus =  $usrimg_qry->default_status;
                                    $listedfirst_id=$usrimg_qry->id;
                                    if($listedfirstdefaltststus == 0)
                                    {
                                        DB::table('group_master_img')
                                        ->where('id', $listedfirst_id)
                                        ->update(['default_status' => 1]);
                                    }
                                    $getuserimgallAr = $this->fetchallimagegroup($hdnusergroupID,$userID);
                                    if($getuserimgallAr)
                                    {
                                    $getuserimgallArcount =count($getuserimgallAr);
                                       $respAr['getuserimgallAr'] =$getuserimgallAr;
                                    }

                                    $responseflag =1;
                                }
                                  if($getuserimgallArcount == 0)
                                    {
                                          $imgurldatablnk = BASEURLPUBLICCUSTOM.'admin/otherfiles/progimages/noimagefound52X52.jpg';
                                        // $getuserimgallAr = "<img src=".$imgurldatablnk.">";
                                           $respAr['getuserimgallAr'] ="<img src=".$imgurldatablnk.">";
                                    }

                               
                                $respAr['responseflag'] =$responseflag;
                                // $respAr['getuserimgallAr'] =$getuserimgallAr;
                                $respAr['getuserimgallArcount'] =$getuserimgallArcount;

                               // echo "<pre>";
                               // print_r($respAr);die;
                            echo   json_encode($respAr);
                                

       }

       public function userdeletemultiple(Request $request,$id=0)
       {
       // echo 'hello';die;

                $i = strlen($id);
          
                $countdeletditems = 0;
                $id_arry = explode(",",$id);
                $id_arry_count = count($id_arry);
           
                foreach ($id_arry as $id) {

                                     if($id!=1)
                                    {
                                        $dataUpdate=array('status'=>'9');
                                        $isUpdated=DB::table('user_master')
                                        ->where('id', $id)
                                        ->update($dataUpdate);
                                        //DB::table('user_master')->where('id', $uid)->delete();
                                        $request->session()->flash('admin_successmsgdata_sess', 'User successfully deleted');
                                    }
                }

        return redirect(ADMINSEPARATOR.'/user');
       }




       public function sendactivationlinkadmin(Request $request)
       {
        $userid = $request->input('userID');
        $emailid = $request->input('useremail');

        $verify_token=md5(time());
         $respAr=array();


       $verifyqry = DB::table('user_master')->where('id',$userid)->update(['verify_token' => $verify_token]);


       if($verifyqry)
       {
        //echo "Accounmt updated successfully";die;



            //*******fetch user details starts here
            $emailusr = DB::table('user_master')->select('first_name')->where('id',$userid)->first();
            $emailtosendusr = $emailid;
            $emailtosendusrname = $emailusr->first_name;
            //*******fetch user details ends here

            $userssel = DB::table('settings')
            ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
            ->where('id', 1)
            ->get();
            $sitenm=$userssel[0]->site_name;
            $emailfrom=$userssel[0]->email_from;
            $copyrightyr=$userssel[0]->copyright_year;
            $Imgologo=$userssel[0]->email_template_logo_image;
            $bsurl = url('/');

            $activation_link = route('frontendactivateuser', ['activationtime' => time(),'id'=>base64_encode($userid),'verify_token'=>$verify_token]);
            $activation_link_text = 'Click this link to activate : <a href="'.$activation_link.'">Activation Link </a>';


            // $logoIMG = asset('upload/settings-image/source-file/'.$Imgologo);
            $logoIMG = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$Imgologo;
            //*********Helper Function Starts here
            $replacefrom =array('{User}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{ACTIVATION_LINK}");
            $replaceto =array(addslashes(ucfirst($emailtosendusrname)),$sitenm,$copyrightyr,$bsurl,$logoIMG,$activation_link_text);

           $mailsendchk = mailsnd($Temid=48,$replacefrom,$replaceto,$emailtosendusr);
            
            if($mailsendchk)
            {
                $respAr['responseflag'] =1;
            }else{
                $respAr['responseflag'] =0;
            }

       }
       else{
         $respAr['responseflag'] =2;
       }
                                    // echo "<pre>";
                                    // print_r($respAr);die;
                                    echo   json_encode($respAr);

       }



       //***************** send email after active and deactive starts here



       public function sendemailafteractivedeactive($userid,$activedeactiveflag,$statictext)
       {    
        $getuseremailqry = DB::table('user_master')->where('id',$userid)->select('email','first_name')->first();
        $emailtosendusr = $getuseremailqry->email;
        $emailtosendusrname = $getuseremailqry->first_name;
       // $accountstatus ='';

        if($activedeactiveflag == 0)
        {
            $accountstatus = 'Deactivated';
        }
        if($activedeactiveflag == 1)
        {
            $accountstatus = 'Activated';
        }






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
                            $replacefrom =array('{Accountfname}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{ACTIVATION_STATUS}","{STATIC_INFORMATION}");
                            $replaceto =array(addslashes(ucfirst($emailtosendusrname)),$sitenm,$copyrightyr,$bsurl,$logoIMG,$accountstatus,$statictext);

                            mailsnd($Temid=52,$replacefrom,$replaceto,$emailtosendusr);
                            //*********Helper Function Ends here 






                            //*********Email send code ends here





       }


       //**************** mail send after active and deactive ends here



}
?>