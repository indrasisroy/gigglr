<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use DB;

class BeforeFrontendMiddleware
{
    public function handle($request, Closure $next)
    {
                        // Perform action
                        
                //echo "from middleware=>".$request->route()->getActionName()."<br>";
                //echo "from middleware=>".$request->route()->getName()."<br>";
                //$ntest_sess = $request->session()->get('admin_id_sess');
                // echo "==ntest_sess==>".$ntest_sess;
                $routename=$request->route()->getName();
                
                //echo "==routename==>".$routename; exit();
               
                
                $beforeloginAr=array();
                $beforeloginAr[]="frontendregisteruser";
                $beforeloginAr[]="frontendloginuser";
                
                
                $afterlogindAr=array();
                $afterlogindAr[]="frontenddashboard";
                $afterlogindAr[]="frontendlogout";
                $afterlogindAr[]="frontendeditprofile";
                $afterlogindAr[]="frontendroster";                
                $afterlogindAr[]="frontendpublicVenueEdit";
                $afterlogindAr[]="frontendeditgroup";
                $afterlogindAr[]="frontendloadgigpostmodal";
                $afterlogindAr[]="frontendmyaccount";
                $afterlogindAr[]="frontendeditprofilebookingoptions";

                
                
                $myaccountAr=array();
                $myaccountAr[]="frontendmyaccount";
                $myaccountAr[]="frontendmyaccountcity";
                $myaccountAr[]="frontendmyaccountreferemail";
                $myaccountAr[]="frontendmyaccountfrmsubmit";
                $myaccountAr[]="frontendmyaccountchkpass";
                $myaccountAr[]="frontendmyaccountdeactive";
                $myaccountAr[]="frontendlogout";
                

                //*******************checking for keep me signed in starts here
                if(request()->cookie('cookuser_ID'))
                {
                    $r = request()->cookie('cookuser_ID'); 
                    $getcookieDetails = DB::table('user_master')->where('cookie_value', $r)->first();
                    if($getcookieDetails)
                    {
                       //echo "Cookie matched";
                       
                       $userid = $getcookieDetails->id;
                       $request->session()->put('front_id_sess', $userid); // set session
                        
                    }                    
                    

                }
              
                //*******************checking for keep me signed in ends here

                
                if ($request->session()->has('front_id_sess'))
                 {
                   
                 
                   if(in_array($routename,$beforeloginAr))
                    {
                       return redirect('/'); // 
                    }
                    else
                    {
                        $sess_id = $request->session()->get('front_id_sess');
                        $getUserDetails = DB::table('user_master')->where('id', $sess_id)->first();
                        //echo "<pre>";
                        //print_r($getUserDetails);
                        //echo "</pre>";die;
                        $email = $getUserDetails->email;
                        $first_name = $getUserDetails->first_name;
                        $last_name = $getUserDetails->last_name;
                        $address1 = $getUserDetails->address1;
                        $phone = $getUserDetails->phone;
                        $gender = $getUserDetails->gender;
                        $language = $getUserDetails->language;
                        $currency = $getUserDetails->currency;
                        //if($email!='' && $first_name !='' && $last_name!='' && $address1!='' && $phone!='' && $gender!='' && $language!='' && $currency!=''){
                        //    return $next($request);
                        //}else{
                        //    return redirect('/myaccount');
                        //}
                        
                        $myaccnt_mndtryar_flg=array();
                        if($email!='')
                        {
                            $myaccnt_mndtryar_flg[]=$email;
                        }
                        if($first_name!='')
                        {
                            $myaccnt_mndtryar_flg[]=$first_name;
                        }
                        if($last_name!='')
                        {
                            $myaccnt_mndtryar_flg[]=$last_name;
                        }
                        if($address1!='')
                        {
                            $myaccnt_mndtryar_flg[]=$address1;
                        }
                        if($phone!='')
                        {
                            $myaccnt_mndtryar_flg[]=$phone;
                        }
                        if($gender!='')
                        {
                            $myaccnt_mndtryar_flg[]=$gender;
                        }
                        if($language!='')
                        {
                            $myaccnt_mndtryar_flg[]=$language;
                        }
                        if($currency!='')
                        {
                            $myaccnt_mndtryar_flg[]=$currency;
                        }
                        
                        if(!empty($myaccnt_mndtryar_flg) && (count($myaccnt_mndtryar_flg)<8))
                        {
                            if(in_array($routename,$myaccountAr))
                            {
                                
                                return $next($request);
                            }
                            else
                            {   
                                
                                return redirect('/myaccount')->with('status', 'Please complete Account Information first, Then you can access other Sections !!!');
                                
                            }
                        }

                        return $next($request);
                        
                    }
                 
               }
               else
               {
                
                    
                             
                        if(in_array($routename,$afterlogindAr))
                        {
                            return redirect('/');  
                          
                        }
                        else
                        {
                            return $next($request);
                        }
                     
                     
                      
               }
               
               
        
        
                return $next($request); // comment out this line when logic has been implemented
        
        
    }
}
?>