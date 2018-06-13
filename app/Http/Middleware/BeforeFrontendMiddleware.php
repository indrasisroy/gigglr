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
        
                //***** to check artist / group / venue profile active starts ***********************
                $uri = $request->path();
                $uriAr=array();
                $uriAr=explode("/",$uri);
               // echo $uri."=uriAr=><pre>"; print_r($uriAr); echo "</pre>";
        
                $seonamedata=''; $active_status_flag=0;
        
                if(count($uriAr)>=2)
                {
                    $seonamedata=$uriAr[1];
                }
                
        
                $profileroutenameAr=array();
                $profileroutenameAr[]='frontendprofile';
                $profileroutenameAr[]='frontendgroup';
                $profileroutenameAr[]='frontendpublicVenue';
        
           
        
        
                if($routename=="frontendprofile")
                {
                    //***** check artist/creator status is active starts ***********
                    
                            $wherefar=array("seo_name"=>$seonamedata,'status'=>1);

                            $userdta_db = DB::table("user_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,status,seo_name"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                
                                $active_status_flag=1;                                                      

                            }
                    
                   
                        
                    //***** check artist/creator status is active ends ***********
                    
                }
                elseif($routename=="frontendgroup")
                {
                    
                    
                    //*** fetch creator_id data of group from group_master table starts*********
                            $creater_id=0;                      
                           
                           
                            
                            $wherefar=array("seo_name"=>$seonamedata,'status'=>1);

                            $userdta_db = DB::table("group_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,creater_id,seo_name"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                $creater_id= $userdta_db->creater_id;  
                                                      

                            }
                            
                    //*** fetch creator_id data of group from group_master table ends*********
                    
                    //***** check artist/creator status is active starts ***********
                    
                        if(!empty($creater_id))
                        {
                           $wherefar=array("id"=>$creater_id,'status'=>1);

                            $userdta_db = DB::table("user_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,status,seo_name"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                
                                $active_status_flag=1;                                                      

                            } 
                        }
                            
                        
                    //***** check artist/creator status is active ends ***********
                    
                    
                    

                }
                elseif($routename=="frontendpublicVenue")
                {
                    
                     //*** fetch creator_id data of venue from venue_master table starts*********
                            $creater_id=0;                      
                           
                            
                            
                            $wherefar=array("seo_name"=>$seonamedata,'status'=>1);

                            $userdta_db = DB::table("venue_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,creater_id,seo_name"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                $creater_id= $userdta_db->creater_id;  
                                                      

                            }
                            
                    //*** fetch creator_id data of venue from venue_master table ends*********
                    
                    //***** check artist/creator status is active starts ***********
                    
                        if(!empty($creater_id))
                        {
                            $wherefar=array("id"=>$creater_id,'status'=>1);

                            $userdta_db = DB::table("user_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,status,seo_name"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                
                                $active_status_flag=1;                                                      

                            }
                        }
                        
                    //***** check artist/creator status is active ends ***********
                    

                }        
                
        
                //***** to check artist / group / venue profile active ends ***************************
        
                
                
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
                            
                            $request->session()->flash('myaccount_data_all_saved', 'NO');
                            
                            
                            if(in_array($routename,$myaccountAr))
                            {
                                
                                return $next($request);
                            }
                            else
                            {   
                                
                                return redirect('/myaccount')->with('status', 'Please complete Account Information first, Then you can access other Sections !!!');
                                
                            }
                        }
                        
                        
                        if(in_array($routename,$profileroutenameAr) && ($active_status_flag==0) )
                            {
                                return redirect('/'); 
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
                            
                            if(in_array($routename,$profileroutenameAr) && ($active_status_flag==0) )
                            {
                                return redirect('/'); 
                            }
                            
                            
                            
                            return $next($request);
                        }
                     
                     
                      
               }
               
               
        
        
                return $next($request); // comment out this line when logic has been implemented
        
        
    }
}
?>