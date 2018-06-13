<?php

namespace App\Http\Middleware;

use Closure;

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