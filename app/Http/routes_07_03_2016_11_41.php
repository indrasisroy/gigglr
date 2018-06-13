<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

define("ADMINSEPARATOR","adminpannel");

/*
Route::get('/', function () {
    return view('welcome');
});
*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    
    //****************** For Admin Pannel********************
    Route::get('/'.ADMINSEPARATOR.'/login', ['as' => 'adminloginroute', 'uses' => 'AdminloginController@index']);
   
    Route::get('/'.ADMINSEPARATOR.'/dashboard', ['as' => 'admindashboardroute', 'uses' => 'AdminloginController@dashboard']);
    Route::get('/'.ADMINSEPARATOR,function () {
    return redirect()->route('admindashboardroute');
    });
    Route::get('/'.ADMINSEPARATOR.'/logout', ['as' => 'adminlogoutroute', 'uses' => 'AdminloginController@logout']);
    

    Route::post('/'.ADMINSEPARATOR.'/logincheck', ['as' => 'adminlogincheckroute', 'uses' => 'AdminloginController@logincheck']);

    //****************** For Country Management********************
    
     Route::get('/'.ADMINSEPARATOR.'/country', ['as' => 'admincountryroute', 'uses' => 'AdmincountryController@index']);
     Route::get('/'.ADMINSEPARATOR.'/countryadd/{id?}', ['as' => 'admincountryaddroute', 'uses' => 'AdmincountryController@addcountry'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/countrysave', ['as' => 'admincountrysaveroute', 'uses' => 'AdmincountryController@savecountry']);
     Route::get('/'.ADMINSEPARATOR.'/countrydel/{id?}', ['as' => 'admincountrydelroute', 'uses' => 'AdmincountryController@delcountry'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/countrystatus', ['as' => 'admincountrystatusroute', 'uses' => 'AdmincountryController@statuschangecountry']);
     
     //****************** For State Management********************
    
     Route::get('/'.ADMINSEPARATOR.'/state', ['as' => 'adminstateroute', 'uses' => 'AdminstateController@index']);
     Route::get('/'.ADMINSEPARATOR.'/stateadd/{id?}', ['as' => 'adminstateaddroute', 'uses' => 'AdminstateController@addstate'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/statesave', ['as' => 'adminstatesaveroute', 'uses' => 'AdminstateController@savestate']);
     Route::get('/'.ADMINSEPARATOR.'/statedel/{id?}', ['as' => 'adminstatedelroute', 'uses' => 'AdminstateController@delstate'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/statestatus', ['as' => 'adminstatestatusroute', 'uses' => 'AdminstateController@statuschangestate']);
     
     
     

    //****************** For Settings Pannel********************
    Route::get('/'.ADMINSEPARATOR.'/settings', ['as' => 'adminsettingsroute', 'uses' => 'AdminsettingsController@settings']);
    Route::post('/'.ADMINSEPARATOR.'/upadte_settings', ['as' => 'adminsettingscheckroute', 'uses' => 'AdminsettingsController@updatesettings']);
    
    
    //****************** For User Management********************
    
     Route::get('/'.ADMINSEPARATOR.'/user', ['as' => 'adminuserroute', 'uses' => 'AdminuserController@index']);
     Route::get('/'.ADMINSEPARATOR.'/useradd/{id?}', ['as' => 'adminuseraddroute', 'uses' => 'AdminuserController@adduser'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/usersave', ['as' => 'adminusersaveroute', 'uses' => 'AdminuserController@saveuser']);
     Route::get('/'.ADMINSEPARATOR.'/userdel/{id?}', ['as' => 'adminuserdelroute', 'uses' => 'AdminuserController@deluser'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/userstatus', ['as' => 'adminuserstatusroute', 'uses' => 'AdminuserController@statuschangeuser']);
    




     //****************** For article Pannel********************
    Route::get('/'.ADMINSEPARATOR.'/article', ['as' => 'adminarticleroute', 'uses' => 'AdminarticleController@show_article']);
    Route::get('/'.ADMINSEPARATOR.'/createarticle/{id?}', ['as' => 'adminarticleaddroute', 'uses' => 'AdminarticleController@addarticle'])->where(['id' => '[0-9]+']);
    Route::post('/'.ADMINSEPARATOR.'/articlesave', ['as' => 'adminarticlesaveroute', 'uses' => 'AdminarticleController@articlesaeve']);
    Route::get('/'.ADMINSEPARATOR.'/delete_article/{id?}', ['as' => 'adminarticledeleteroute', 'uses' => 'AdminarticleController@articledelete']);
    // Route::get('/'.ADMINSEPARATOR.'/changestatus_article/{id?}', ['as' => 'adminarticlechangstsroute', 'uses' => 'AdminarticleController@articlestachange']);
    Route::post('/'.ADMINSEPARATOR.'/articlechangestatus', ['as' => 'adminarticlestatusroute', 'uses' => 'AdminarticleController@statuschangearticle']);
     //****************** For Email Template Pannel********************
    Route::get('/'.ADMINSEPARATOR.'/email-template', ['as' => 'adminemailroute', 'uses' => 'AdminemailtemplateController@show_emailtemaplate']);
    Route::get('/'.ADMINSEPARATOR.'/createemailtemplate/{id?}', ['as' => 'adminemailaddroute', 'uses' => 'AdminemailtemplateController@addtemplate'])->where(['id' => '[0-9]+']);
    Route::post('/'.ADMINSEPARATOR.'/emailtemplatesave', ['as' => 'adminemailsaveroute', 'uses' => 'AdminemailtemplateController@emailtemplatesaeve']);
    Route::get('/'.ADMINSEPARATOR.'/delete_template/{id?}', ['as' => 'adminemaildeleteroute', 'uses' => 'AdminemailtemplateController@emailtemplatedelete']);
    // Route::get('/'.ADMINSEPARATOR.'/changestatus_article/{id?}', ['as' => 'adminarticlechangstsroute', 'uses' => 'AdminarticleController@articlestachange']);
    Route::post('/'.ADMINSEPARATOR.'/emailchangestatus', ['as' => 'adminemailstatusroute', 'uses' => 'AdminemailtemplateController@statuschangeemail']);

    //****************** For testing Purpose********************
    Route::get('/'.ADMINSEPARATOR.'/testmymail', ['as' => 'admintestmymailroute', 'uses' => 'AdminmytestController@testmymail']);
    
    
    //****************** For testmail Management********************
    
     //Route::get('/'.ADMINSEPARATOR.'/mailtest', ['as' => 'mailtestroute', 'uses' => 'TestmailController@index']);
     
     Route::get('/'.ADMINSEPARATOR.'/sendemail', ['as' => 'mailtestroute', 'uses' => 'TestmailController@index']) ;
    

});




