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
           
        
        Validator::extend('countrynameunique', 'CustvalidationadminClass@countrynameunique'); //for country management
        Validator::extend('country2codeunique', 'CustvalidationadminClass@country2codeunique');//for country management
        Validator::extend('country3codeunique', 'CustvalidationadminClass@country3codeunique');//for country management
        Validator::extend('articlenameunique', 'CustvalidationadminClass@articlenameunique');//for article management
        Validator::extend('alpha_spaces', 'CustvalidationadminClass@alpha_spaces');//for article management
        Validator::extend('skillunq_name', 'CustvalidationadminClass@skillunq_name');//for skill management
        
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
