<?php


namespace App\Http\Controllers\frontend;

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
use Cookie;
use View;


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
                                //$display_flag=1;
                               // $banner_image=$imgurldata = asset('upload/banner-image/thumb-big/'.$banner_image);
                                $banner_image=$imgurldata = BASEURLPUBLICCUSTOM.'upload/banner-image/thumb-big/'.$banner_image;
                         }
                }
                
                
                //*** fetch data of banner starts
                
                $data['banner_image']=$banner_image;
                $data['display_flag']=$display_flag;
                
                
                //**** fetch welcome info from settings - starts
                
                $fetchtype='single'; $tablename="settings";
                $fieldnames=" welcome_text,default_radius,max_radius_limit ";
                $wherear=array();
                $wherear['id']=1;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;  $default_radius=0;$max_radius_limit=100;             
                
                $fetchfrontwelcomedata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                
                $frontwelcomedata='';
                if(!empty($fetchfrontwelcomedata))
                {
                     $frontwelcomedata=$fetchfrontwelcomedata->welcome_text;
                     $default_radius=$fetchfrontwelcomedata->default_radius;
                     $max_radius_limit=$fetchfrontwelcomedata->max_radius_limit;
                }
                
               $data['frontwelcometext']=$frontwelcomedata;
               $data['default_radius']=$default_radius;
               $data['max_radius_limit']=$max_radius_limit;
                //**** fetch welcome info from settings - ends
                
                //*** fetch category (parent skill) related  data  starts         
             
              $selectstr=" skm.* ";
              
              $skl_master_db=DB::table('skill_master as skm');              
              $skl_master_db=$skl_master_db->select(DB::raw($selectstr));                                                          
              $skl_master_db=$skl_master_db->where('skm.parent_id', 0);
              $skl_master_db=$skl_master_db->where('skm.status',1);
              $skl_master_db=$skl_master_db->orderBy("skm.name", "asc");
              //$skl_master_db = $skl_master_db->skip(0)->take(3);
              $skl_master_db=$skl_master_db->get();            
             
              
              $categoryAr=array();
              if(!empty($skl_master_db))
              {
                foreach($skl_master_db as $skl_master)
                {
                  $categoryAr[$skl_master->id]=stripslashes($skl_master->name);
                }
               
              }
              
              //echo "=skl_master_db=><pre>";
              //print_r($skl_master_db);
              //echo "</pre>";
              //echo "=categoryAr=><pre>";
              //print_r($categoryAr);
              //echo "</pre>";
              
               //*** fetch category (parent skill) related  data  ends 
                
                 //$data['categoryAr']=$categoryAr;
                 
                 //**** for banner section in landing page starts
                 $other_dataAr=array();
                 if(!empty($categoryAr))
                 {
                 $other_dataAr['categoryAr']=$categoryAr;
                 }
                 $bannerdataAr=array();
                 $bannerdataAr['banner_image']=$banner_image;
                 $bannerdataAr['other_data']=$other_dataAr;
                 
                 $data['bannerdataAr']=$bannerdataAr;
                //**** for banner section in landing page starts
          
          
               
         
          
         
          
                 return view('front.home.landingview', $data);
    }
     
    public function landingajx(Request $request)
    {
     
                $banner_image='';
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
                                //$display_flag=1;
                                //$banner_image=$imgurldata = asset('upload/banner-image/thumb-big/'.$banner_image);
                                $banner_image=$imgurldata = BASEURLPUBLICCUSTOM.'upload/banner-image/thumb-big/'.$banner_image;
                         }
                }
                
                
                //*** fetch data of banner starts
             //*** fetch category (parent skill) related  data  starts         
             
              $selectstr=" skm.* ";
              
              $skl_master_db=DB::table('skill_master as skm');              
              $skl_master_db=$skl_master_db->select(DB::raw($selectstr));                                                          
              $skl_master_db=$skl_master_db->where('skm.parent_id', 0);
              $skl_master_db=$skl_master_db->where('skm.status',1);
              $skl_master_db=$skl_master_db->orderBy("skm.name", "asc");
              //$skl_master_db = $skl_master_db->skip(0)->take(3);
              $skl_master_db=$skl_master_db->get();            
             
              
              $categoryAr=array();
              if(!empty($skl_master_db))
              {
                foreach($skl_master_db as $skl_master)
                {
                  $categoryAr[$skl_master->id]=stripslashes($skl_master->name);
                }
               
              }
              
              
              
               //*** fetch category (parent skill) related  data  ends 
                 
                 //**** for banner section in landing page starts
                 $other_dataAr=array();
                 if(!empty($categoryAr))
                 {
                 $other_dataAr['categoryAr']=$categoryAr;
                 }
                 $bannerdataAr=array();
                 $bannerdataAr['banner_image']=$banner_image;
                 $bannerdataAr['other_data']=$other_dataAr;
                 // $data['bannerdataAr']=$bannerdataAr;
                //**** for banner section in landing page starts
                
                //echo "<pre>"; print_r($bannerdataAr); echo "</pre>";
                
                $view_obj = View::make('front.includefolder.banner',$bannerdataAr);
                $bnnr_contents = $view_obj->render();              
                            
                
                //****   random home search data fetch starts   ****//
                 
                      $home_search_db=DB::table('home_search as hs');
                      $home_search_db=$home_search_db->leftJoin('skill_master as sm', 'sm.id', '=', 'hs.skill_id');
                      $home_search_db=$home_search_db->select(DB::raw('hs.id,hs.title,hs.location,hs.description,hs.skill_id,hs.image_name,hs.image_title,sm.name'));
                      $home_search_db=$home_search_db->where('hs.status',1);
                      $home_search_db=$home_search_db->orderBy(DB::raw('RAND()'));
                      $home_search_db=$home_search_db->skip(0)->take(3);
                      $home_search_db=$home_search_db->get();
                      
                      $homesearchAr=array();
                      $homesearchAr=$home_search_db;
                 
                       $datahm=array();
                      $datahm['homesearchAr']=$homesearchAr;
                 
                //****   random home search data fetch ends   ****//
                
                
                $view_obj = View::make('front.home.ajax.landinghomesrchview',$datahm);
                $lndnghmsrch_contents = $view_obj->render();  
                
                
                
                $respdatastr=$bnnr_contents;
                $respdataAr=array();
                $respdataAr['respdatastr']=$respdatastr;
                $respdataAr['landinghmsrchcontent']=$lndnghmsrch_contents;
                echo json_encode($respdataAr);
                
                
     
    }
     
           
       public function registeruser(Request $request)
    {
          
          
            $status = 0;
            $date_data=date("Y-m-d H:i:s");            
           
            $email = addslashes(trim($request->input('email','')));
            $nickname = addslashes(trim($request->input('nickname','')));
            $password = addslashes(trim($request->input('password','')));
            $password_confirmation = addslashes(trim($request->input('password_confirmation','')));
            $gender = addslashes(trim($request->input('gender','')));
            $dob = addslashes(trim($request->input('dob','')));
            $termscond = addslashes(trim($request->input('dotermscondb','')));
            
            $verify_token=md5(time());
            $dataInsert=array();
            
            $dataInsert['nickname']=$nickname;
            $dataInsert['email']=$email;
            $dataInsert['password']=md5($password);           
            $dataInsert['dob']=date('Y-m-d',strtotime($dob));
            $dataInsert['status']=$status;
            $dataInsert['registration_date']=$date_data;
            $dataInsert['modified_date']=$date_data;
            $dataInsert['user_type']=3;
            $dataInsert['verify_token']=$verify_token;
            $dataInsert['verify_status']=0;
            
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
                        
                        $updatear=array();
                        
                        //**** create user_seoname and update  starts
                        
                        $nickname_lower=strtolower($nickname);
                        $slugged_arr=array($nickname_lower,$isInserted);
                        $slugged_str=implode(" ",$slugged_arr);
                        $slugged_id=str_slug($slugged_str,"-");
                        $updatear['seo_name']=$slugged_id;
                        
                            //**** create user_uniqueid and update  starts
                            
                            $user_uniqueid="usr".time().'n'.$isInserted;
                            
                            
                            $updatear['user_uniqueid']=$user_uniqueid;
                            
                            $chkupd= DB::table('user_master')->where('id',$isInserted) ->update($updatear);
                            
                            //**** create user_uniqueid and update ends
                        
                        $flag_id=$isInserted;
                  
                  }
                  
                  
                 
                  if($isInserted > 0 )
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
                  
                  $activation_link = route('frontendactivateuser', ['activationtime' => time(),'id'=>base64_encode($isInserted),'verify_token'=>$verify_token]);
                  
                 // $activation_link=$bsurl."activateuser/".time()."/".base64_encode($isInserted);
                  
                  
                  
                   //$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
                    $logoIMG = asset('upload/settings-image/source-file/'.$Imgologo);
                  //*********Helper Function Starts here
                  $replacefrom =array('{NAME}','{USERNAME}','{PASSWORD}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{ACTIVATION_LINK}");
                  $replaceto =array(ucfirst($nickname),$email,$password,$sitename,$copyright_year,$bsurl,$logoIMG,$activation_link);
                
                  mailsnd($Temid=3,$replacefrom,$replaceto,$email);
                  //*********Helper Function Ends here 
                  //****** mail code ends here
                        // $request->session()->flash('front_successmsgdata_sess', 'Registration successfully made.');
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
                   
                    'nickname' => "required|unique:user_master",
                    'email' => "required|unique:user_master",
                    'password' => "required|confirmed",
                    'password_confirmation'=>"required",
                    
                    ],[
                       
                       'nickname.required'=>'* Name is required',
                       'nickname.unique'=>'* This Name is already in use',
                       'email.required'=>'* Email is required',
                       'email.unique'=>'* This Email cannot be used',
                       'password.required'=>'* Password is required',
                       'password.confirmed'=>'* Password does not matches with confirm password',
                       'password_confirmation'=>'* Confirm Password is required',
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                      $userData=array();
                      $userData['request']=$request;
                      
                      $validator->after(function($validator)  use ($userData)  {
                        
                                 $request=$userData['request'];
                                 $validatepwdchk=$this->pwdformatisvalid($request);
                                 
                                 if (!empty($validatepwdchk))
                                 {
                                         $validator->errors()->add('password', $validatepwdchk);
                                         // echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                                 }
                      });
                   
                    if ($validator->fails())
                    {
                        return $validator;
                       
                    }
                    
                    
                  return true;
                    
        
           }
           
           public function pwdformatisvalid($request){
                      
                      $errorMsg=array();
                      
                      $passdata=addslashes(trim($request->input('password','')));;
                      
                      $pattern="/^(?=.{8,15})(?=[a-zA-Z0-9^\w\s]*)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^\w\s]).*$/";
		
                      if(!preg_match($pattern,$passdata))
                      {
                                 $errorMsg[]="Password should contain atleast one uppercase, one lowercase, one digit and one special character";  
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
    
     public function loginuser(Request $request)
    {
          
            
            $email = addslashes(trim($request->input('email','')));
            $password = trim($request->input('password',''));
            
            $keepmesigned = trim($request->input('keepmesigned',''));
           
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
                $user_master_db=$user_master_db->where('um.user_type',3);
                $user_master_db=$user_master_db->where('um.status',1);
                
                $user_master_db=$user_master_db->first();
                
                if(!empty($user_master_db))
                {
                               $flag_id=1;
                       
                                $setsess=$this->setfrontidsess($request,$email,1,'');  // set session                              
                                
                                $request->session()->flash('front_successmsgdata_sess', 'You have successfully logged in.');
                       
                }
                
                 //*** fetch data of user ends
                 
                 
                 //***** calling function and passing values into it to set cookie if keep me signed in is checked at the time of login - starts *****// 
                 if(!empty($keepmesigned))
                 {
                   $emailtocookie=base64_encode($email);
                   $passwordtocookie=md5($password);
                   $allcookies=$this->fetchallcookies($request,$emailtocookie,$passwordtocookie);
                 }
                 //***** calling function and passing values into it to set cookie if keep me signed in is checked at the time of login - ends *****//
                 
                 
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
                                $user_master_db=$user_master_db->select(DB::raw('um.id,um.first_name,um.password,um.email,um.status,um.user_type,um.verify_status,um.verify_token'));
                                
                                $user_master_db=$user_master_db->where('um.email', $email);
                                $user_master_db=$user_master_db->where('um.password', md5($password));
                                $user_master_db=$user_master_db->first();
                                
                                if(!empty($user_master_db))
                                {
                                        $user_status=$user_master_db->status;
                                        $user_type=$user_master_db->user_type;
                                        $verify_status=$user_master_db->verify_status;
                                        $verify_token=$user_master_db->verify_token;
                                        
                                        if($verify_status==1)
                                        {
                                          if($user_type==3)
                                          {
                                             if($user_status==0)
                                             {
                                                      $validator->errors()->add('email', "This account is has been deactivated by Admin.");
                                             }
                                             elseif($user_status==9)
                                             {
                                                      $validator->errors()->add('email', "This account has been deleted.");
                                             }
                                              elseif($user_status==2)
                                             {
                                                      $validator->errors()->add('email', "This account has been deactivated by the user.");
                                             }
                                          }
                                          else
                                          {
                                             $validator->errors()->add('email', "Sorry it is not authenticated.");
                                          }
                                        }
                                        else
                                        {
                                          $validator->errors()->add('email', "Sorry this account is not verified.");
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
                                   $this->delcook(); // delete all cookies when user logs out 
                                
                              }
                              
                              $request->session()->flash('front_successmsgdata_sess', 'You have successfully logged out.');    
                              return redirect('/');
                              
                    //*** set session ends
                }
                
                
         public function setfrontidsess($request,$emailid='',$login_type=1,$access_token='')
                {
                   //*** fetch data of user starts
                 
                        $user_master_db = DB::table('user_master as um');
                        $user_master_db=$user_master_db->select(DB::raw('um.id,um.first_name,um.password,um.email,um.status,um.user_type'));
                        
                        $user_master_db=$user_master_db->where('um.email', $emailid);
                        $user_master_db=$user_master_db->first();
                
                        if(!empty($user_master_db))
                        {
                                        $flag_id=1;
                                                           
                                        $status=$user_master_db->status;
                                        $user_type=$user_master_db->user_type;
                                        $userid=$user_master_db->id;
                                        //$last_login_ip=$this->get_client_ip_server();
                                         $last_login_ip=get_client_ip_server();
                                         
                                         $updatear=array();
                                         $updatear["last_login"]=date('Y-m-d H:i:s');
                                         $updatear["last_login_ip"]=$last_login_ip;
                                        
                                         $updatear['last_login_type']=$login_type;
                                          
                                         if($login_type==2)
                                         {
                                             
                                              $updatear["gp_access_token"]=$access_token;
                                         }
                                        
                                        //*** update user_master table starts
                                        
                                        $chkupd= DB::table('user_master')->where('id',$userid) ->update($updatear);
                                        
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
                
                
                
                          //**************forgot password code starts here
         public function forgotpassword(Request $request)
         {
                  $email = addslashes(trim($request->input('forgotemail','')));
                  $chkvalid=$this->checkforgotpassform($request);
                  
                  $flag_id=0;
                  $error_message=''; $responseAr=array();
                  
                  if($chkvalid===true)
                  {
                     $flag_id=1;
                     //************random password generate starts here
                     
                    $nw_pass = rand(111111,999999);
                    $update_password = md5($nw_pass);
                    DB::table('user_master')
                    ->where('email', $email)
                    ->update(['password' => $update_password]);
                    // echo $nw_pass;
                     //************ random password generate ends here
                     
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
                  
                  //**********get user details strats here
                  
                  $userdetail = DB::table('user_master')
                        ->select(DB::raw('first_name'))
                        ->where('email', $email)
                        ->get();
                  $first_name=$userdetail[0]->first_name;
                  
                  //*********get user details ends here
                  
                   //$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
                    $logoIMG = asset('upload/settings-image/source-file/'.$Imgologo);
                  //*********Helper Function Starts here
                  $replacefrom =array('{NAME}','{USERNAME}','{PASSWORD}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                  $replaceto =array(ucfirst($first_name),$email,$nw_pass,$sitename,$copyright_year,$bsurl,$logoIMG);
                
                  mailsnd($Temid=8,$replacefrom,$replaceto,$email);
                  //*********Helper Function Ends here 
                  //****** mail code ends here
                     
                     
                  }else
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
                
                
                public function checkforgotpassform($request)
                {
                  
                  
                  
                   $validator = Validator::make($request->all(), [
                   'forgotemail' => "required",
                    ],[
                       'forgotemail.required'=>'* Email is required',
                     ]);
                    
                   //echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                  
                  
                $userData=array();
                
                $email = addslashes(trim($request->input('forgotemail','')));
               
                $userData['email']=$email;
                
                //////echo "<pre>";
                //////print_r($userData);exit();
                
                $validator->after(function($validator)  use ($userData)  {
                        
                       $email=$userData['email'];
                        
                        //****fetch data to check starts
                        
                                $user_master_db = DB::table('user_master as um');
                                $user_master_db=$user_master_db->select(DB::raw('um.id,um.first_name,um.password,um.email,um.status,um.user_type'));
                                
                                $user_master_db=$user_master_db->where('um.email', $email);
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
                           //echo "Validator fails";exit();
                                 $validator->errors()->add('email', $validatefilechk);
                                 
                                 
                                 
                                 //echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                        }
                });
                  
                  
                if ($validator->fails())
                {
                  //echo "validation fails ";exit();
                    return $validator;
                   
                }
                    
                    
                  return true;
                  
                  
                }
                //************ forgot password code ends here
                
                
                //***** set cookie if keep me signed in is checked at the time of login - starts *****//      
          public function fetchallcookies($request,$emailtocook,$passwordtocook)
          {
                  $front_id_sess= $request->session()->get('front_id_sess');
                  $useridhere=base64_encode($front_id_sess);
                  $emailhere=$emailtocook;
                  $passhere=$passwordtocook;
                  Cookie::queue('cookuserid', $useridhere, 1440);
                  Cookie::queue('cookuseremail', $emailhere, 1440);
                  Cookie::queue('cookuserpassword', $passhere, 1440);
          }
                //***** set cookie if keep me signed in is checked at the time of login - ends *****//
                
                
            //****** delete cookies starts *****//
          public function delcook()
          {
                  Cookie::queue(Cookie::forget('cookuserid'));
                  Cookie::queue(Cookie::forget('cookuseremail'));
                  Cookie::queue(Cookie::forget('cookuserpassword'));
          }
            //****** delete cookies ends *****//
            
          
          public function checkgooglepluslogin(Request $request)
          {
              $email = addslashes(trim($request->input('email','')));
              $access_token = addslashes(trim($request->input('gplus_access_token','')));
              
              $respAr=array();
              
              $flag_id=0; $error_msg='';
              
              //*** fetch data of user starts
                 
                $user_master_db = DB::table('user_master as um');
                $user_master_db=$user_master_db->select(DB::raw('um.id,um.first_name,um.password,um.email,um.status,um.user_type,um.verify_status,um.verify_token'));
                
                $user_master_db=$user_master_db->where('um.email', $email);
                
               // $user_master_db=$user_master_db->where('um.user_type',3);
               // $user_master_db=$user_master_db->where('um.status',1);
                
                $user_master_db=$user_master_db->first();
                
                if(!empty($user_master_db))
                {
                 
                                       $user_status=$user_master_db->status;
                                        $user_type=$user_master_db->user_type;
                                        $verify_status=$user_master_db->verify_status;
                                        $verify_token=$user_master_db->verify_token;
                                        
                                        if($verify_status==1)
                                        {
                                          if($user_type==3)
                                          {
                                             if($user_status==0)
                                             {
                                                  $error_msg.="<p>This account is has been deactivated by Admin.</p>";
                                                    
                                             }
                                             elseif($user_status==9)
                                             {
                                               $error_msg.="<p>This account has been deleted.</p>";
                                                      
                                             }
                                              elseif($user_status==2)
                                             {
                                              $error_msg.="<p>This account has been deactivated by the user.</p>";
                                                    
                                             }
                                          }
                                          else
                                          {
                                            $error_msg.="<p>Sorry it is not authenticated.</p>";
                                             
                                          }
                                        }
                                        else
                                        {
                                          $error_msg.="<p>Sorry this account is not verified.</p>";
                                          
                                        }
                 
                   
                }
                else
                {
                           $error_msg.="<p>This email id is not registered.</p>";
                }
                
                //*** fetch data of user ends
                
                if(empty($error_msg))
                {
                
                   $chkresp=$this->setfrontidsess($request,$email,$login_type=2,$access_token);
                   if($chkresp==true)
                   {
                              $flag_id=1;
                              
                               $request->session()->flash('front_successmsgdata_sess', 'You have successfully logged in.');
                   }
                }
               
               $respAr['flag_id'] =$flag_id;
               $respAr['error_message'] =$error_msg;
               
               echo json_encode($respAr);
                
                
          }
            
              public function activateuser(Request $request)
          {
           
                 $activationtime = $request->segment(2);
                 $user_id_str = $request->segment(3);
                 $verify_token_data = $request->segment(4);
                 
                 $user_id=base64_decode($user_id_str);
                 
                 $respAr=array();
                 
                 $flag_id=0; $error_msg='';
              
                            
             
              //*** fetch data of user starts
                 
                $user_master_db = DB::table('user_master as um');
                $user_master_db=$user_master_db->select(DB::raw('um.id,um.first_name,um.password,um.email,um.status,um.user_type,um.verify_status,um.verify_token'));
                
                $user_master_db=$user_master_db->where('um.id', $user_id);
                
                
               // $user_master_db=$user_master_db->where('um.user_type',3);
               // $user_master_db=$user_master_db->where('um.status',1);
                
                $user_master_db=$user_master_db->first();
                $user_status='';$user_type='';$email='';
                $verify_token='';$verify_status='';
                if(!empty($user_master_db))
                {
                 
                         $user_status=$user_master_db->status;
                         $user_type=$user_master_db->user_type;
                         $email=$user_master_db->email;
                         $verify_status=$user_master_db->verify_status;
                         $verify_token=$user_master_db->verify_token;
                         //1=>active,0=>inactive by admin,9=>delete,2=>deactivated by user
                         if($verify_token==$verify_token_data)
                         {
                            if($verify_status==0)
                            {
                                if($user_type==3)
                                {
                                  $error_msg='';
                                   
                                }
                                else
                                {
                                    $error_msg.="<p>Sorry it is not authenticated.</p>";
                                }
                            }
                            
                         }
                         else
                         {
                             $error_msg.="<p>Verification token mismatch , contact with Admin .</p>";
                         }
                 
                   
                }
                else
                {
                           $error_msg.="<p>This email id is not registered.</p>";
                }
                
                //*** fetch data of user ends
                
                if(empty($error_msg) && ($user_status!=1) )
                {
                           //*** update user_master table ends
                           $updatear=array();
                           $updatear["status"]=1;
                           $updatear["verify_status"]=1;
                           $updatear["verify_date"]=date("Y-m-d H:i:s");
                          //*** update user_master table starts
                          
                          $chkupd= DB::table('user_master')->where('id',$user_id) ->update($updatear);
                          
                          //*** update user_master table ends
                
                        $chkresp=$this->setfrontidsess($request,$email,$login_type=1,$access_token='');
                        if($chkresp==true)
                        {
                                   $flag_id=1;
                                   
                                   
                                    $request->session()->flash('front_successmsgdata_sess','You have successfully logged in.' );
                                    return redirect('editprofile');
                        }
                }
                else
                {
                              $request->session()->flash('front_errormsgdata_sess',$error_msg );
                }
                
                 return redirect('/');
                
          }   
           
           
}