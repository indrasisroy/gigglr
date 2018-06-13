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
use Illuminate\Routing\Route;

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
        $users_db=$users_db->select(DB::raw('um.id,CONCAT_WS(" ",um.first_name,um.last_name) AS name,um.username,um.email,um.password,um.gender,um.status'));
        $users_db=$users_db->where('um.user_type', 3);
        $users_db=$users_db->where('um.status','<>', 9);
        if(!empty($srch1))
        {
           $users_db=$users_db->where('um.first_name', 'like', "%".$srch1."%");
           $users_db=$users_db->orWhere('um.last_name', 'like', "%".$srch1."%");
           $users_db=$users_db->orWhereRaw("CONCAT_WS(' ',um.first_name,um.last_name) LIKE '%".$srch1."%'");           
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
          $data=array();
          $data['data1']="hello";
         
          if(!empty($id))
          {
            //**** fetch data starts
            
            $userrow = DB::table('user_master as um')->where('um.id', $id)->first();
            
            /*echo "<pre>";           
            print_r($countryrow);
            echo "</pre>"; exit();*/
            $data['userrow']=$userrow;
            //**** fetch data ends 
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
          
        return view('admin.user.useradd', $data);
    }  
    
    public function saveuser(Request $request)
    {
            $first_name = trim(addslashes($request->input('first_name')));
            $middle_name = trim(addslashes($request->input('middle_name')));
            $last_name = trim(addslashes($request->input('last_name')));
            $username = $request->input('username');
            $nickname = $request->input('nickname');
            $email = $request->input('email');
            $oldpass = $request->input('oldpass');
            $newpass = $request->input('newpass');
            $gender = $request->input('gender');
            $address1 = $request->input('address1');
            $country = $request->input('country_id');
            $state = $request->input('state_id');
            $city = $request->input('city');
            $zip = $request->input('zip');
            $language=$request->input('language_id');
            $abn=$request->input('abn');
            $tfn=$request->input('tfn');
            $currency=$request->input('currency');
            $rider=$request->input('rider');
            $description=$request->input('description');
            $fb_url = $request->input('fburl');
            $soundcloud_url= $request->input('soundcloudurl');
            $residentadvisor_url = $request->input('residentadvisorurl');
            $twitter_url = $request->input('twitterurl');
            $youtube_url = $request->input('youtubeurl');
            $instagram_url = $request->input('instagramurl');      
            
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
            $dataInsert['first_name']= ucfirst($first_name);
            $dataInsert['middle_name']=$midname;
            $dataInsert['last_name']= ucfirst($last_name);
            $dataInsert['username']=$username;
            $dataInsert['nickname']=$nickname;
            $dataInsert['email']=$email;
            $dataInsert['password']=$pwd;
            $dataInsert['gender']=$gender;
            $dataInsert['address1']=$address1;
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
            
            $chkvalid=$this->validateuserall($request,$uid);
            //print_r($chkvalid);die;
            //echo $chkvalid;die;
            if($chkvalid===true)
            //if($chkvalid!=1)
            {
            
                if(empty($uid))
                {
                    $dataInsert['password']=$en_pwd;
                    $dataInsert['user_type']='3';
                    $dataInsert['registration_date']=$today;
                    $dataInsert['status']='1';
                    
                    //*** insert  query
                    
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
                
                  mailsnd($Temid=3,$replacefrom,$replaceto,$email);
                  //*********Helper Function Ends here 
                    
                    
                    
                    
                    
                    
                    //*********Email send code ends here
                    
                    
                    
                    }
                }
                else
                {
                     $dataInsert['modified_date']=$today;
                    
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
                    return redirect(ADMINSEPARATOR.'/useradd')
                     ->withErrors($chkvalid)
                     ->withInput();
                }
                else
                {
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
        $validator = Validator::make($request->all(), [
                'first_name' => "required|max:100",
                'middle_name' => "max:100",
                'last_name' => "required|max:100",
                'username' => "required|max:100|unique:user_master,username,".$userid,
                'nickname' => "required|max:20",
                'email' => "required|email|unique:user_master,email,".$userid,
                'gender'=>"required",
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
                'username.required'=>' * Username is required ',
                'username.max'=>' * Maximum 100 characters ',
                'username.unique'=>' * Username should be unique ',
                'nickname.required'=>' * Nickname is required ',
                'nickname.max'=>' * Maximum 20 characters ',
                'email.required'=>' * Email is required ',
                'email.unique'=>' * Email should be unique ',
                'gender.required'=>' * Gender is required ',
                'address1.required'=>' * Address is required ',
                'country_id.required'=>' * Country is required ',
                'state_id.required'=>' * State is required ',
                'city.required'=>' * City is required ',
                'zip.required'=>' * Zip is required ',
                'language_id.required'=>' * Language is required ',
                'skill_id.required'=>' * Skill is required ',
                'subskill_id.required'=>' * Sub-skill is required ',
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

}
?>