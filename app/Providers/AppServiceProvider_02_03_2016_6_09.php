<?php

namespace App\Providers;

use DB;
use Validator;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //***** for admin custom rules for managements starts
        
        Validator::extend('countrynameunique', function($attribute, $value, $parameters, $validator)
         {            
            
            /*
            echo "<br>attribuute==>".$attribute;
            echo "<br>value==>".$value;           
            echo "<br>parameters==><pre>";print_r($parameters);echo "</pre>";
            */
            
             $id=0;  $country_name=$value;           
             if(!empty($parameters)&& array_key_exists(0,$parameters))
             {
                 $id=$parameters[0]; 
                
             }
              
            
            $user_single = DB::table('location_country');
            $user_single=$user_single->where('country_name', '=', $country_name);
            if(!empty($id))
             {
                    //***check for edit
                    $user_single=$user_single->where('id', '<>', $id);
             }
          
            $user_single=$user_single->get();
            
            
            $tot=count($user_single);
            
            if($tot>0)
            {
                return false;
            }
            else
            {
                return true;
            }
         
            
        });
        
         Validator::extend('country2codeunique', function($attribute, $value, $parameters, $validator)
         {            
            
            /*
            echo "<br>attribuute==>".$attribute;
            echo "<br>value==>".$value;           
            echo "<br>parameters==><pre>";print_r($parameters);echo "</pre>";
            */
            
             $id=0;  $country_2_code=addslashes(strtoupper(trim($value)));           
             if(!empty($parameters)&& array_key_exists(0,$parameters))
             {
                 $id=$parameters[0]; 
                
             }
              
            
            $user_single = DB::table('location_country');
            $user_single=$user_single->where('country_2_code', '=', $country_2_code);
            if(!empty($id))
             {
                    //***check for edit
                    $user_single=$user_single->where('id', '<>', $id);
             }
          
            $user_single=$user_single->get();
            
            
            $tot=count($user_single);
            
            if($tot>0)
            {
                return false;
            }
            else
            {
                return true;
            }
         
            
        });
        
        
        Validator::extend('country3codeunique', function($attribute, $value, $parameters, $validator)
         {            
            
            /*
            echo "<br>attribuute==>".$attribute;
            echo "<br>value==>".$value;           
            echo "<br>parameters==><pre>";print_r($parameters);echo "</pre>";
            */
            
             $id=0;  $country_3_code=addslashes(strtoupper(trim($value)));           
             if(!empty($parameters)&& array_key_exists(0,$parameters))
             {
                 $id=$parameters[0]; 
                
             }
              
            
            $user_single = DB::table('location_country');
            $user_single=$user_single->where('country_3_code', '=', $country_3_code);
            if(!empty($id))
             {
                    //***check for edit
                    $user_single=$user_single->where('id', '<>', $id);
             }
          
            $user_single=$user_single->get();
            
            
            $tot=count($user_single);
            
            if($tot>0)
            {
                return false;
            }
            else
            {
                return true;
            }
         
            
        });
        
        
        
        
        //***** for admin custom rules for managements ends
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
