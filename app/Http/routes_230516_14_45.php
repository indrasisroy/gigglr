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
    Route::get('/'.ADMINSEPARATOR.'/login', ['as' => 'adminloginroute', 'uses' => 'admin\AdminloginController@index']);
   
    Route::get('/'.ADMINSEPARATOR.'/dashboard', ['as' => 'admindashboardroute', 'uses' => 'admin\AdminloginController@dashboard']);
    Route::get('/'.ADMINSEPARATOR,function () {
    return redirect()->route('admindashboardroute');
    });
    Route::get('/'.ADMINSEPARATOR.'/logout', ['as' => 'adminlogoutroute', 'uses' => 'admin\AdminloginController@logout']);
    

    Route::post('/'.ADMINSEPARATOR.'/logincheck', ['as' => 'adminlogincheckroute', 'uses' => 'admin\AdminloginController@logincheck']);

    //****************** For Country Management********************
    
     Route::get('/'.ADMINSEPARATOR.'/country', ['as' => 'admincountryroute', 'uses' => 'admin\AdmincountryController@index']);
     Route::get('/'.ADMINSEPARATOR.'/countryadd/{id?}', ['as' => 'admincountryaddroute', 'uses' => 'admin\AdmincountryController@addcountry'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/countrysave', ['as' => 'admincountrysaveroute', 'uses' => 'admin\AdmincountryController@savecountry']);
     Route::get('/'.ADMINSEPARATOR.'/countrydel/{id?}', ['as' => 'admincountrydelroute', 'uses' => 'admin\AdmincountryController@delcountry'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/countrystatus', ['as' => 'admincountrystatusroute', 'uses' => 'admin\AdmincountryController@statuschangecountry']);
     
     //****************** For State Management********************
    
     Route::get('/'.ADMINSEPARATOR.'/state', ['as' => 'adminstateroute', 'uses' => 'admin\AdminstateController@index']);
     Route::get('/'.ADMINSEPARATOR.'/stateadd/{id?}', ['as' => 'adminstateaddroute', 'uses' => 'admin\AdminstateController@addstate'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/statesave', ['as' => 'adminstatesaveroute', 'uses' => 'admin\AdminstateController@savestate']);
     Route::get('/'.ADMINSEPARATOR.'/statedel/{id?}', ['as' => 'adminstatedelroute', 'uses' => 'admin\AdminstateController@delstate'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/statestatus', ['as' => 'adminstatestatusroute', 'uses' => 'admin\AdminstateController@statuschangestate']);
     
     
     

    //****************** For Settings Pannel********************
    Route::get('/'.ADMINSEPARATOR.'/settings', ['as' => 'adminsettingsroute', 'uses' => 'admin\AdminsettingsController@settings']);
    Route::post('/'.ADMINSEPARATOR.'/upadte_settings', ['as' => 'adminsettingscheckroute', 'uses' => 'admin\AdminsettingsController@updatesettings']);
    
    
    //****************** For User Management********************
    
     Route::get('/'.ADMINSEPARATOR.'/user', ['as' => 'adminuserroute', 'uses' => 'admin\AdminuserController@index']);
     Route::get('/'.ADMINSEPARATOR.'/useradd/{id?}', ['as' => 'adminuseraddroute', 'uses' => 'admin\AdminuserController@adduser'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/usersave', ['as' => 'adminusersaveroute', 'uses' => 'admin\AdminuserController@saveuser']);
     Route::get('/'.ADMINSEPARATOR.'/userdel/{id?}', ['as' => 'adminuserdelroute', 'uses' => 'admin\AdminuserController@deluser'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/userstatus', ['as' => 'adminuserstatusroute', 'uses' => 'admin\AdminuserController@statuschangeuser']);
    

    //****************** For Subscription Management********************
    
     Route::get('/'.ADMINSEPARATOR.'/subscription', ['as' => 'adminsubscriptionroute', 'uses' => 'admin\AdminsubscriptionController@index']);
     Route::get('/'.ADMINSEPARATOR.'/subscriptiondel/{id?}', ['as' => 'adminsubscriptiondelroute', 'uses' => 'admin\AdminsubscriptionController@delsubscription'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/subscriptionstatus', ['as' => 'adminsubscriptionstatusroute', 'uses' => 'admin\AdminsubscriptionController@statuschangesubscription']);


     //****************** For article Pannel********************
    Route::get('/'.ADMINSEPARATOR.'/article', ['as' => 'adminarticleroute', 'uses' => 'admin\AdminarticleController@show_article']);
    Route::get('/'.ADMINSEPARATOR.'/createarticle/{id?}', ['as' => 'adminarticleaddroute', 'uses' => 'admin\AdminarticleController@addarticle'])->where(['id' => '[0-9]+']);
    Route::post('/'.ADMINSEPARATOR.'/articlesave', ['as' => 'adminarticlesaveroute', 'uses' => 'admin\AdminarticleController@articlesaeve']);
    Route::get('/'.ADMINSEPARATOR.'/delete_article/{id?}', ['as' => 'adminarticledeleteroute', 'uses' => 'admin\AdminarticleController@articledelete']);
    // Route::get('/'.ADMINSEPARATOR.'/changestatus_article/{id?}', ['as' => 'adminarticlechangstsroute', 'uses' => 'AdminarticleController@articlestachange']);
    Route::post('/'.ADMINSEPARATOR.'/articlechangestatus', ['as' => 'adminarticlestatusroute', 'uses' => 'admin\AdminarticleController@statuschangearticle']);
     //****************** For Email Template Pannel********************
    Route::get('/'.ADMINSEPARATOR.'/email-template', ['as' => 'adminemailroute', 'uses' => 'admin\AdminemailtemplateController@show_emailtemaplate']);
    Route::get('/'.ADMINSEPARATOR.'/createemailtemplate/{id?}', ['as' => 'adminemailaddroute', 'uses' => 'admin\AdminemailtemplateController@addtemplate'])->where(['id' => '[0-9]+']);
    Route::post('/'.ADMINSEPARATOR.'/emailtemplatesave', ['as' => 'adminemailsaveroute', 'uses' => 'admin\AdminemailtemplateController@emailtemplatesaeve']);
    Route::get('/'.ADMINSEPARATOR.'/delete_template/{id?}', ['as' => 'adminemaildeleteroute', 'uses' => 'admin\AdminemailtemplateController@emailtemplatedelete']);
    // Route::get('/'.ADMINSEPARATOR.'/changestatus_article/{id?}', ['as' => 'adminarticlechangstsroute', 'uses' => 'AdminarticleController@articlestachange']);
    Route::post('/'.ADMINSEPARATOR.'/emailchangestatus', ['as' => 'adminemailstatusroute', 'uses' => 'admin\AdminemailtemplateController@statuschangeemail']);

    //****************** For testing Purpose********************
    Route::get('/'.ADMINSEPARATOR.'/testmymail', ['as' => 'admintestmymailroute', 'uses' => 'admin\AdminmytestController@testmymail']);
    
    
    //****************** For testmail Management********************
    
     //Route::get('/'.ADMINSEPARATOR.'/mailtest', ['as' => 'mailtestroute', 'uses' => 'admin\TestmailController@index']);
     
     Route::get('/'.ADMINSEPARATOR.'/sendemail', ['as' => 'mailtestroute', 'uses' => 'admin\TestmailController@index']) ;


    //****************** For skill Pannel********************

     Route::get('/'.ADMINSEPARATOR.'/skill', ['as' => 'adminskillroute', 'uses' => 'admin\AdminskillController@index']);
     Route::get('/'.ADMINSEPARATOR.'/skilladd/{id?}', ['as' => 'adminskilladdroute', 'uses' => 'admin\AdminskillController@addskill'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/skillsave', ['as' => 'adminskillsaveroute', 'uses' => 'admin\AdminskillController@saveskill']);
     Route::get('/'.ADMINSEPARATOR.'/skilldel/{id?}', ['as' => 'adminskilldelroute', 'uses' => 'admin\AdminskillController@delskill'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/skillstatus', ['as' => 'adminskillstatusroute', 'uses' => 'admin\AdminskillController@statuschangeskill']);
     
     Route::post('/'.ADMINSEPARATOR.'/skillnamechange', ['as' => 'adminskillcommonroute', 'uses' => 'admin\AdminskillController@commonchangeskill']);
     
     //****************** For Association Management Pannel********************

     Route::get('/'.ADMINSEPARATOR.'/association', ['as' => 'adminassociationroute', 'uses' => 'admin\AdminassociationController@index']);
     Route::get('/'.ADMINSEPARATOR.'/associationadd/{id?}', ['as' => 'adminassociationaddroute', 'uses' => 'admin\AdminassociationController@addassociation'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/associationsave', ['as' => 'adminassociationsaveroute', 'uses' => 'admin\AdminassociationController@saveassociation']);
     Route::get('/'.ADMINSEPARATOR.'/associationdel/{id?}', ['as' => 'adminassociationdelroute', 'uses' => 'admin\AdminassociationController@delassociation'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/associationstatus', ['as' => 'adminassociationstatusroute', 'uses' => 'admin\AdminassociationController@statuschangeassociation']);
     
     Route::post('/'.ADMINSEPARATOR.'/associationcategorynamechange', ['as' => 'adminassociationcommonroute', 'uses' => 'admin\AdminassociationController@commonchangecategory']);
     Route::post('/'.ADMINSEPARATOR.'/associationgenrenamechange', ['as' => 'adminassociationcommonroute', 'uses' => 'admin\AdminassociationController@commonchangegenre']);
     
    //****************** For Package Management Pannel********************

     Route::get('/'.ADMINSEPARATOR.'/package', ['as' => 'adminpackageroute', 'uses' => 'admin\AdminpackageController@index']);
     Route::get('/'.ADMINSEPARATOR.'/packageadd/{id?}', ['as' => 'adminpackageaddroute', 'uses' => 'admin\AdminpackageController@addpackage'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/packagesave', ['as' => 'adminpackagesaveroute', 'uses' => 'admin\AdminpackageController@savepackage']);
     Route::get('/'.ADMINSEPARATOR.'/packagedel/{id?}', ['as' => 'adminpackagedelroute', 'uses' => 'admin\AdminpackageController@delpackage'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/packagestatus', ['as' => 'adminpackagestatusroute', 'uses' => 'admin\AdminpackageController@statuschangepackage']);
     
     
     //****************** For forgot password Purpose ********************
    Route::get('/'.ADMINSEPARATOR.'/forgotpwd', ['as' => 'admintest4gtpwd', 'uses' => 'admin\AdminforgotpwdController@index']);
    Route::post('/'.ADMINSEPARATOR.'/sendfrgtpwd', ['as' => 'admintestsend4gtpwd', 'uses' => 'admin\AdminforgotpwdController@sendnewfrgtpwd']);
    

    //****************** For admin edit profile********************
    Route::get('/'.ADMINSEPARATOR.'/editprofileadmin', ['as' => 'admineditprofileroute', 'uses' => 'admin\AdminprofileController@index']);
    Route::post('/'.ADMINSEPARATOR.'/editprofilesuccess', ['as' => 'admineditprofileupdateroute', 'uses' => 'admin\AdminprofileController@updateprofile']);
    
    
    //****************** For Language Management********************
     Route::get('/'.ADMINSEPARATOR.'/language', ['as' => 'adminlanguageroute', 'uses' => 'admin\AdminlanguageController@index']);
     Route::get('/'.ADMINSEPARATOR.'/languageadd/{id?}', ['as' => 'adminlanguageaddroute', 'uses' => 'admin\AdminlanguageController@addlanguage'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/languagesave', ['as' => 'adminlanguagesaveroute', 'uses' => 'admin\AdminlanguageController@savelanguage']);
     Route::get('/'.ADMINSEPARATOR.'/languagedel/{id?}', ['as' => 'adminlanguagedelroute', 'uses' => 'admin\AdminlanguageController@dellanguage'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/languagestatus', ['as' => 'adminlanguagestatusroute', 'uses' => 'admin\AdminlanguageController@statuschangelanguage']);


     //******************* For FAQ Management ****************
     Route::get('/'.ADMINSEPARATOR.'/faq', ['as' => 'adminfaqroute', 'uses' => 'admin\AdminfaqController@index']);
     Route::get('/'.ADMINSEPARATOR.'/faqadd/{id?}', ['as' => 'adminfaqaddroute', 'uses' => 'admin\AdminfaqController@addfaq'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/faqsave', ['as' => 'adminfaqsaveroute', 'uses' => 'admin\AdminfaqController@savefaq']);
     Route::get('/'.ADMINSEPARATOR.'/faqdel/{id?}', ['as' => 'adminfaqdelroute', 'uses' => 'admin\AdminfaqController@delfaq'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/faqstatus', ['as' => 'adminfaqstatusroute', 'uses' => 'admin\AdminfaqController@statuschangefaq']);
     
     
     //****************** For Contact-us Management********************
     Route::get('/'.ADMINSEPARATOR.'/contactus', ['as' => 'admincontactusroute', 'uses' => 'admin\AdmincontactusController@index']);
     Route::get('/'.ADMINSEPARATOR.'/contactusdel/{id?}', ['as' => 'admincontactusdelroute', 'uses' => 'admin\AdmincontactusController@delcontact'])->where(['id' => '[0-9]+']);

     
     //****************** For Banner Management Pannel********************

     Route::get('/'.ADMINSEPARATOR.'/banner', ['as' => 'adminbannerroute', 'uses' => 'admin\AdminbannerController@index']);
     Route::get('/'.ADMINSEPARATOR.'/banneradd/{id?}', ['as' => 'adminbanneraddroute', 'uses' => 'admin\AdminbannerController@addbanner'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/bannersave', ['as' => 'adminbannersaveroute', 'uses' => 'admin\AdminbannerController@savebanner']);
     Route::get('/'.ADMINSEPARATOR.'/bannerdel/{id?}', ['as' => 'adminbannerdelroute', 'uses' => 'admin\AdminbannerController@delbanner'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/bannerstatus', ['as' => 'adminbannerstatusroute', 'uses' => 'admin\AdminbannerController@statuschangebanner']);
     
     //******************* For Howitsdone Management ****************
     Route::get('/'.ADMINSEPARATOR.'/howitsdone', ['as' => 'adminhowitsdoneroute', 'uses' => 'admin\AdminhowitsdoneController@index']);
     Route::get('/'.ADMINSEPARATOR.'/howitsdoneadd/{id?}', ['as' => 'adminhowitsdoneaddroute', 'uses' => 'admin\AdminhowitsdoneController@addhowitsdone'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/howitsdonesave', ['as' => 'adminhowitsdonesaveroute', 'uses' => 'admin\AdminhowitsdoneController@savehowitsdone']);
     Route::get('/'.ADMINSEPARATOR.'/howitsdonedel/{id?}', ['as' => 'adminhowitsdonedelroute', 'uses' => 'admin\AdminhowitsdoneController@delhowitsdone'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/howitsdonestatus', ['as' => 'adminhowitsdonestatusroute', 'uses' => 'admin\AdminhowitsdoneController@statuschangehowitsdone']);
     
     //******************** For help_supportbypage Management ****************
     Route::get('/'.ADMINSEPARATOR.'/supportbypage', ['as' => 'adminsupportbypageroute', 'uses' => 'admin\AdminsupportbypageController@index']);
     Route::get('/'.ADMINSEPARATOR.'/supportbypageadd/{id?}', ['as' => 'adminsupportbypageaddroute', 'uses' => 'admin\AdminsupportbypageController@addsupportbypage'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/supportbypagesave', ['as' => 'adminsupportbypagesaveroute', 'uses' => 'admin\AdminsupportbypageController@savesupportbypage']);
     Route::get('/'.ADMINSEPARATOR.'/supportbypagedel/{id?}', ['as' => 'adminsupportbypagedelroute', 'uses' => 'admin\AdminsupportbypageController@delsupportbypage'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/supportbypagestatus', ['as' => 'adminsupportbypagestatusroute', 'uses' => 'admin\AdminsupportbypageController@statuschangesupportbypage']);
});


Route::group(['middleware' => ['frontweb']], function () {
    
    //****************** For Frontend  starts ********************
    
    Route::get('/', ['as' => 'frontendhomeroute', 'uses' => 'frontend\FrontendhomeController@index']);
    Route::post('/registeruser', ['as' => 'frontendregisteruser', 'uses' => 'frontend\FrontendhomeController@registeruser']);
    Route::post('/loginuser', ['as' => 'frontendloginuser', 'uses' => 'frontend\FrontendhomeController@loginuser']);
    Route::get('/editprofile', ['as' => 'frontendeditprofile', 'uses' => 'frontend\FrontenduserController@index']);
    Route::get('/logout', ['as' => 'frontendlogout', 'uses' => 'frontend\FrontendhomeController@logout']);
    Route::post('/saveuserurls', ['as' => 'frontendsaveuserurls', 'uses' => 'frontend\FrontenduserController@saveuserurls']);
    Route::post('/saveuserskills', ['as' => 'frontendsaveuserskills', 'uses' => 'frontend\FrontenduserController@saveuserskills']);
    Route::post('/saveuserdesc', ['as' => 'frontendsaveuserdesc', 'uses' => 'frontend\FrontenduserController@saveuserdesc']);
    Route::post('/saveusername', ['as' => 'frontendsaveusername', 'uses' => 'frontend\FrontenduserController@saveusername']);
    Route::post('/populatesubskill', ['as' => 'frontendpopulatesubskill', 'uses' => 'frontend\FrontenduserController@populatesubskill']);
    Route::post('/saveskilldata', ['as' => 'frontendsaveskilldata', 'uses' => 'frontend\FrontenduserController@saveskilldata']);
     Route::post('/deletemyskill', ['as' => 'frontenddeletemyskill', 'uses' => 'frontend\FrontenduserController@deletemyskill']);
    
    //*********** forget password routes starts here
    Route::post('/forgotpass', ['as' => 'frontendforgotpass', 'uses' => 'frontend\FrontendhomeController@forgotpassword']);
    //********** forget password routes ends here
    //*********** Frontend Support routes starts here
    Route::get('/help', ['as' => 'frontendhelp', 'uses' => 'frontend\FrontendHelpController@index']);
    //********** Frontend Support routes ends here
    
     //*********** Frontend profile routes starts here
    Route::get('/profile', ['as' => 'frontendprofile', 'uses' => 'frontend\FrontendprofileController@index']);
    //********** Frontend profile routes ends here
    
     //*********** Frontend googlepluslogincheck routes starts here
    Route::post('/checkgooglepluslogin', ['as' => 'frontendcheckgooglepluslogin', 'uses' => 'frontend\FrontendhomeController@checkgooglepluslogin']);
    //***********  Frontend googlepluslogincheck routes ends   here
    
    //*********** Frontend activateuser routes starts here
    Route::get('/activateuser/{activationtime}/{id}/{verify_token}', ['as' => 'frontendactivateuser', 'uses' => 'frontend\FrontendhomeController@activateuser']);
    //***********  Frontend activateuser routes ends   here
    
     //*********** Frontend subscription routes starts here
    Route::post('/subscription', ['as' => 'frontendsubscription', 'uses' => 'frontend\FrontendSubscriptionController@index']);
    Route::post('/unsubscription', ['as' => 'frontendunsubscription', 'uses' => 'frontend\FrontendSubscriptionController@unsubscribe']);
    //***********  Frontend subscription routes ends here
    
   //****************** For Frontend  ends ********************
    
    

});






