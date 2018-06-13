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
                      
                if ($request->session()->has('admin_id_sess'))
                 {
                   
                 
                    if($routename=="adminloginroute"||$routename=="adminlogincheckroute")
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
                    
                    if($routename=="adminloginroute"||$routename=="adminlogincheckroute")
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