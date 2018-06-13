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
          
          return view('admin.user.useradd', $data);
    }  
    
    public function saveuser(Request $request)
    {
            $first_name = trim(addslashes($request->input('first_name')));
            $last_name = trim(addslashes($request->input('last_name')));
            $username = $request->input('username');
            $email = $request->input('email');
            $gender = $request->input('gender');
            
            $uid = $request->input('uid');
            
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
            $dataInsert['last_name']= ucfirst($last_name);
            $dataInsert['username']=$username;
            $dataInsert['email']=$email;
            $dataInsert['gender']=$gender;
            
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
                            
                            $user_uniqueid="USR".time().'N'.$lastInserted;
                            
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
                  
                  
                  
                   $logoIMG = asset('upload/settings-image/source-file/'.$Imgologo);
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
                'last_name' => "required|max:100",
                'username' => "required|max:100|unique:user_master,username,".$userid,
                'email' => "required|email|unique:user_master,email,".$userid,
                'gender'=>"required",
            ],
            [   'first_name.required'=>' * First name is required ',
                'first_name.max'=>' * Maximum 100 characters ',
                'last_name.required'=>' * Last name is required ',
                'last_name.max'=>' * Maximum 100 characters ',
                'username.required'=>' * Username is required ',
                'username.max'=>' * Maximum 100 characters ',
                'username.unique'=>' * Username should be unique ',
                'email.required'=>' * Email is required ',
                'email.unique'=>' * Email should be unique ',
                'gender.required'=>' * Gender is required ',
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
    
    //public function sendEmailReminder(Request $request, $uid)
    //{
    //    $user = User::findOrFail($uid);
    //
    //    Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
    //        $m->from('indrasis.roy@esolzmail.com', 'Your Application');
    //
    //        $m->to($user->email, $user->name)->subject('Your Reminder!');
    //    });
    //}
    
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
            }
                  
            //*** update status ends
        }
          
        $respAr['flag']=$flagdata;
        $respAr['iddata']=$userid;
        
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
           
}