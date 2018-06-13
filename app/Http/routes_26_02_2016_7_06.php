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
    
    //****************** For Admin Pannel********************
    Route::post('/'.ADMINSEPARATOR.'/logincheck', ['as' => 'adminlogincheckroute', 'uses' => 'AdminloginController@logincheck']);
    
});




