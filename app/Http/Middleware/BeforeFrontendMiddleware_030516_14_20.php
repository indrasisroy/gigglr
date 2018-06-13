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
                      
                if ($request->session()->has('front_id_sess'))
                 {
                   
                 
                   if(in_array($routename,$beforeloginAr))
                    {
                       return redirect('/editprofile'); // 
                    }
                    else
                    {
                       return $next($request);
                    }
                 
               }
               else
               {
                
                    $cookuserid = Cookie::get('cookuserid');
                    if(!empty($cookuserid))
                    {
                        $cookuseremail = Cookie::get('cookuseremail');
                        $cookuserpassword = Cookie::get('cookuserpassword');
                        $decodeduserid=base64_decode($cookuserid);
                        $decodeduseremail=base64_decode($cookuseremail);
                        
                        //** fetching data row from db of cookie's user_id to check if it exists and for further checking of the status and password - starts **//
                        
                        $usersel = DB::table('user_master')
                        ->select(DB::raw('password,status'))
                        ->where('id', $decodeduserid)
                        ->where('email', $cookuseremail)
                        ->first();
                        
                        if(!empty($usersel))
                        {
                            $cookuserpass=$usersel->password;
                            $cookuserstat=$usersel->status;
                              
                            if($cookuserpass==$cookuserpassword && $cookuserstat==1)
                            {
                                
                                //***** generation of ip address - starts *****//
                                
                                $useripAddress = '';
                                $chk1=getenv('HTTP_X_FORWARDED_FOR');
                                $chk2=('' !== trim(getenv('HTTP_X_FORWARDED_FOR')));
                                $chk3=getenv('REMOTE_ADDR');
                                $chk4=('' !== trim(getenv('REMOTE_ADDR')));
                               
                                // Check for X-Forwarded-For headers and use those if found
                                
                                if ( ($chk1!=false) && ($chk2!=false))
                                {    
                                    $useripAddress = trim(getenv('HTTP_X_FORWARDED_FOR'));
                                }
                                else
                                {
                                    if ( ($chk3!=false) && ($chk4!=false))
                                    {
                                        $useripAddress = trim(getenv('REMOTE_ADDR'));
                                    }
                                }
                                
                                //***** generation of ip address - ends *****//
                                
                                //***** login respective updation of user_master table - starts *****//
                                
                                $chkupd= DB::table('user_master')->where('id',$decodeduserid) ->update(
                                        ['last_login' => date('Y-m-d H:i:s'),'last_login_ip' => $useripAddress]
                                        );
                                
                                //***** login respective updation of user_master table - ends *****//
                                
                                //***** set session - starts *****//
                                
                                $request->session()->put('front_id_sess', $userid);
                                
                                //***** set session - ends *****//
                                
                                return redirect('/editprofile');
                                
                            }
                        }
                        
                        //** checking of cookie's user_id's existance in db and further checking of the status and password - ends **//
                        
                    }

                    else{
                             
                        if(in_array($routename,$afterlogindAr))
                        {
                            return redirect('/');  
                          
                        }
                        else
                        {
                            return $next($request);
                        }
                     
                    }  
                      
               }
               
               
        
        
                return $next($request); // comment out this line when logic has been implemented
        
        
    }
}
?>