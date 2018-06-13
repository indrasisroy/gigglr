<?php

namespace App\Http\Middleware;

use Closure;

class BeforeAdminMiddleware
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
                      
                      $notloggedinAr=array();
                $notallowedAr[]="admintest4gtpwd";
                $notallowedAr[]="admintestsend4gtpwd";
                $notallowedAr[]="adminloginroute";
                $notallowedAr[]="adminlogincheckroute";
                      
                if ($request->session()->has('admin_id_sess'))
                 {
                   
                 
                   if(in_array($routename,$notallowedAr))
                    {
                       return redirect(ADMINSEPARATOR.'/dashboard'); // 
                    }
                    else
                    {
                       return $next($request);
                    }
                 
               }
               else
               {
                    
                    if(in_array($routename,$notallowedAr))
                    {
                       return $next($request);
                    }
                    else
                    {
                       return redirect(ADMINSEPARATOR.'/login');  
                    }
                       
                      
               }
        
        
    }
}
?>