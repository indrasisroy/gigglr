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

 
 define("FRONTCSSPATH", config('myprojectcontants.mycustompath.publicfolder')."front" );
 define("ADMINCSSPATH", config('myprojectcontants.mycustompath.publicfolder')."admin" );
 define("PROJECTABSOLUTEPATH", config('myprojectcontants.mycustompath.projectabsolute') );
 define("PUBLICABSOLUTEPATH", config('myprojectcontants.mycustompath.projectabsolute')."public" );
 define("BASEURLCUSTOM", config('myprojectcontants.mycustompath.baseurl') );
 define("BASEURLPUBLICCUSTOM", config('myprojectcontants.mycustompath.baseurl')."public/" );
 
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
     Route::get('/'.ADMINSEPARATOR.'/countrydel/{id?}', ['as' => 'admincountrydelroute', 'uses' => 'admin\AdmincountryController@delcountry'])->where(['id' => '[A-Za-z0-9,=]+']);
     Route::post('/'.ADMINSEPARATOR.'/countrystatus', ['as' => 'admincountrystatusroute', 'uses' => 'admin\AdmincountryController@statuschangecountry']);
     
     //****************** For State Management********************
    
     Route::get('/'.ADMINSEPARATOR.'/state', ['as' => 'adminstateroute', 'uses' => 'admin\AdminstateController@index']);
     Route::get('/'.ADMINSEPARATOR.'/stateadd/{id?}', ['as' => 'adminstateaddroute', 'uses' => 'admin\AdminstateController@addstate'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/statesave', ['as' => 'adminstatesaveroute', 'uses' => 'admin\AdminstateController@savestate']);
     Route::get('/'.ADMINSEPARATOR.'/statedel/{id?}', ['as' => 'adminstatedelroute', 'uses' => 'admin\AdminstateController@delstate'])->where(['id' => '[A-Za-z0-9,=]+']);
     Route::post('/'.ADMINSEPARATOR.'/statestatus', ['as' => 'adminstatestatusroute', 'uses' => 'admin\AdminstateController@statuschangestate']);
     
     //****************** For country wise state list ********************
    Route::post('/'.ADMINSEPARATOR.'/countrywisestate', ['as' => 'adminusercountrywisestateroute', 'uses' => 'admin\AdminuserController@countrywisestatefunc']);
     
    //****************** For skill wise subskill list ********************
    // Route::post('/'.ADMINSEPARATOR.'/skillwisesubskill', ['as' => 'adminuserskillwisesubskillroute', 'uses' => 'admin\AdminuserController@skillwisesubskillfunc']);
     

    //****************** For Settings Pannel********************
    Route::get('/'.ADMINSEPARATOR.'/settings', ['as' => 'adminsettingsroute', 'uses' => 'admin\AdminsettingsController@settings']);
    Route::post('/'.ADMINSEPARATOR.'/upadte_settings', ['as' => 'adminsettingscheckroute', 'uses' => 'admin\AdminsettingsController@updatesettings']);
    
    
    //****************** For User Management********************
    
     Route::get('/'.ADMINSEPARATOR.'/user', ['as' => 'adminuserroute', 'uses' => 'admin\AdminuserController@index']);
     Route::get('/'.ADMINSEPARATOR.'/useradd/{id?}', ['as' => 'adminuseraddroute', 'uses' => 'admin\AdminuserController@adduser'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/usersave', ['as' => 'adminusersaveroute', 'uses' => 'admin\AdminuserController@saveuser']);
     Route::get('/'.ADMINSEPARATOR.'/userdel/{id?}', ['as' => 'adminuserdelroute', 'uses' => 'admin\AdminuserController@deluser'])->where(['id' => '[0-9]+']);

      //*****
     Route::post('/'.ADMINSEPARATOR.'/statusdeactivate', ['as' => 'adminuserstatusdeactiveroute', 'uses' => 'admin\AdminuserController@statusdeactivatefunc']); 

      Route::post('/'.ADMINSEPARATOR.'/deactivationreason', ['as' => 'adminuserstatusdeactivereasonroute', 'uses' => 'admin\AdminuserController@deactivationreasonfunc']); 
     //*****


     Route::post('/'.ADMINSEPARATOR.'/userstatus', ['as' => 'adminuserstatusroute', 'uses' => 'admin\AdminuserController@statuschangeuser']);

     //******download press kit
     Route::get('/'.ADMINSEPARATOR.'/userpresskitadmin/{file}', ['as' => 'adminuserpressroute', 'uses' => 'admin\AdminuserController@userpresskitadmindownload']);

      //********** for venue user and group user starts here 09-08-2016

     Route::get('/'.ADMINSEPARATOR.'/useradd/groupadd/{idf?}/{ids?}', ['as' => 'adminusegroupaddeditroute', 'uses' => 'admin\AdminuserController@addusergroup'])->where(['idf' => '[0-9]+'])->where(['ids' => '[0-9]+']);


     Route::post('/'.ADMINSEPARATOR.'/usergroupsave',['as' => 'adminusergroupaddeditsave', 'uses' => 'admin\AdminuserController@saveusergroup']);

    Route::get('/'.ADMINSEPARATOR.'/usergrouppresskitadmin/{file}', ['as' => 'adminuserpressroutegroup', 'uses' => 'admin\AdminuserController@usergrouppresskitadmindownload']);


      //******create venue by user
      Route::get('/'.ADMINSEPARATOR.'/useradd/venueadd/{id?}/{ids?}', ['as' => 'adminusevenueaddeditroute', 'uses' => 'admin\AdminuserController@adduservenue'])->where(['id' => '[0-9]+'])->where(['ids' => '[0-9]+']);
      Route::post('/'.ADMINSEPARATOR.'/uservenuesave',['as' => 'adminuservenueaddeditsave', 'uses' => 'admin\AdminuserController@saveuservenue']);

      Route::get('/'.ADMINSEPARATOR.'/uservenuepresskitadmin/{file}', ['as' => 'adminuserpressroutevenue', 'uses' => 'admin\AdminuserController@uservenuepresskitadmindownload']);
       Route::get('/'.ADMINSEPARATOR.'/uservenuemenuadmin/{file}', ['as' => 'adminusermenuroutevenue', 'uses' => 'admin\AdminuserController@uservenuemenuadmindownload']);



    //*********** user profile mltiple delete starts here

     Route::get('/'.ADMINSEPARATOR.'/multipleuserldelete/{id?}', ['as' => 'adminusermultipledeleteroute', 'uses' => 'admin\AdminuserController@userdeletemultiple'])->where(['id' => '[A-Za-z0-9,=]+']); 

    //********** usr profile multiple delete ends here





        //**********added for venue skill add and delete starts 13-08-2016

       //***** routes for venue 
       Route::post('/'.ADMINSEPARATOR.'/skillwisesubskillvenue', ['as' => 'adminuserskillwisesubskillroute', 'uses' => 'admin\AdminuserController@skillwisesubskillfunc']);
        Route::post('/'.ADMINSEPARATOR.'/subskillsavevenue', ['as' => 'adminuserskillwisesubskillsaveroute', 'uses' => 'admin\AdminuserController@skillwisesubskillsavefunc']);
        Route::post('/'.ADMINSEPARATOR.'/deletesubskillvenueajax', ['as' => 'adminuserskillwisesubskilldeleteroute', 'uses' => 'admin\AdminuserController@skillwisesubskilldeletevenue']);
        Route::post('/'.ADMINSEPARATOR.'/subskillsavevenueall', ['as' => 'adminuserskillwisesubskillsaverouteall', 'uses' => 'admin\AdminuserController@skillwisesubskilldisplayvenue']);

                //****** routes for group

        Route::post('/'.ADMINSEPARATOR.'/skillwisesubskillgroup', ['as' => 'adminuserskillwisesubskillroutegroup', 'uses' => 'admin\AdminuserController@skillwisesubskillfuncgroup']);
        Route::post('/'.ADMINSEPARATOR.'/subskillsavegroup', ['as' => 'adminuserskillwisesubskillsaveroutegroup', 'uses' => 'admin\AdminuserController@skillwisesubskillsavefuncgroup']);

        Route::post('/'.ADMINSEPARATOR.'/deletesubskillgroupajax', ['as' => 'adminuserskillwisesubskilldeleteroutegroup', 'uses' => 'admin\AdminuserController@skillwisesubskilldeletegroup']);

        Route::post('/'.ADMINSEPARATOR.'/skillsubskillshowgroupall', ['as' => 'adminuserskillwisesubskillrouteallgroup', 'uses' => 'admin\AdminuserController@skillwisesubskilldisplaygroup']);

                //****  routes for user

        Route::post('/'.ADMINSEPARATOR.'/skillwisesubskillshowuser', ['as' => 'adminskillwisesubskillshowrouteuser', 'uses' => 'admin\AdminuserController@userskillwisesubskillshowfunc']);

         Route::post('/'.ADMINSEPARATOR.'/skillwisesubskillsaveuser', ['as' => 'adminskillwisesubskillsaverouteuser', 'uses' => 'admin\AdminuserController@userskillwisesubskillsavefunc']);

        Route::post('/'.ADMINSEPARATOR.'/deletesubskilluserajax', ['as' => 'adminskillwisesubskilldeleterouteuser', 'uses' => 'admin\AdminuserController@skillwisesubskilldeleteuser']);

        Route::post('/'.ADMINSEPARATOR.'/displayskillsubskilluser', ['as' => 'adminskillwisesubskilldisplayrouteuser', 'uses' => 'admin\AdminuserController@skillwisesubskilldisplayeuser']);
              

       //**********added for venue skill add and delete ends 13-08-2016


 //************* For image upload and delete starts 25-08-2016
        //**********user Image
    Route::post('/'.ADMINSEPARATOR.'/userimagesaveadmin',['as' => 'adminimageuploadrouteuser','uses' => 'admin\AdminuserController@adminuserimagesave']);
Route::post('/'.ADMINSEPARATOR.'/deleteuserimageadmin',['as' => 'adminimagedeleterouteuser','uses' => 'admin\AdminuserController@adminuserimagedelete']);

 Route::post('/'.ADMINSEPARATOR.'/uservenueimagesaveadmin',['as' => 'adminimageuploadrouteuservenue','uses' => 'admin\AdminuserController@adminuservenueimagesave']);
 Route::post('/'.ADMINSEPARATOR.'/deleteuservenueimageadmin',['as' => 'adminimagedeleteroutevenue','uses' => 'admin\AdminuserController@adminuservenueimagedelete']);


 Route::post('/'.ADMINSEPARATOR.'/usergroupimagesaveadmin',['as' => 'adminimageuploadrouteusergroup','uses' => 'admin\AdminuserController@adminusergroupimagesave']);
Route::post('/'.ADMINSEPARATOR.'/deleteusergroupimageadmin',['as' => 'adminimagedeleteroutegroup','uses' => 'admin\AdminuserController@adminusergroupimagedelete']);

        //************* For image upload and delete ends 25-08-2016
        

        //***********************user review manage start here*******************************
     Route::get('/'.ADMINSEPARATOR.'/userreview/{id?}/{ids?}', ['as' => 'adminuserreviewroute', 'uses' => 'admin\AdminreviewController@index'])->where(['id' => '[0-9]+'])->where(['ids' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/reviewchangestatus', ['as' => 'adminreviewstatusroute', 'uses' => 'admin\AdminreviewController@statuschangereview']);
     Route::get('/'.ADMINSEPARATOR.'/createreview/{id?}', ['as' => 'adminreviewaddroute', 'uses' => 'admin\AdminreviewController@addreview'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/reviewsave', ['as' => 'adminreviewsaveroute', 'uses' => 'admin\AdminreviewController@reviewsave']);
    
    //***********************user review manage end  here*******************************

        
     //********** for venue user end group user ends here 09-08-2016
    

    //****************** For Subscription Management********************
    
     Route::get('/'.ADMINSEPARATOR.'/subscription', ['as' => 'adminsubscriptionroute', 'uses' => 'admin\AdminsubscriptionController@index']);
     Route::get('/'.ADMINSEPARATOR.'/subscriptiondel/{id?}', ['as' => 'adminsubscriptiondelroute', 'uses' => 'admin\AdminsubscriptionController@delsubscription'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/subscriptionstatus', ['as' => 'adminsubscriptionstatusroute', 'uses' => 'admin\AdminsubscriptionController@statuschangesubscription']);
     Route::post('/'.ADMINSEPARATOR.'/subscriptionstatusmail', ['as' => 'adminsubscriptionstatusmailroute', 'uses' => 'admin\AdminsubscriptionController@statuschangesubscriptionmail']);


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
     Route::post('/'.ADMINSEPARATOR.'/skillusertypechange', ['as' => 'adminskillusertypechangeroute', 'uses' => 'admin\AdminskillController@usertypechangebyskill']);
     Route::post('/'.ADMINSEPARATOR.'/subskillusertypechange', ['as' => 'adminsubskillusertypechangeroute', 'uses' => 'admin\AdminskillController@usertypechangebysubskill']);

     //*****for multiple skill delete
    Route::get('/'.ADMINSEPARATOR.'/multipleskilldelete/{id?}', ['as' => 'adminsubskillmultipleskilldeleteroute', 'uses' => 'admin\AdminskillController@skilldeletemultiple'])->where(['id' => '[A-Za-z0-9,=]+']);     
     //*****for multiple skill delete

     
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
     
     
     //****************** For Amenities Management Pannel********************

     Route::get('/'.ADMINSEPARATOR.'/amenities', ['as' => 'adminamenitiesroute', 'uses' => 'admin\AdminamenitiesController@index']);
     Route::get('/'.ADMINSEPARATOR.'/amenitiesadd/{id?}', ['as' => 'adminamenitiesaddroute', 'uses' => 'admin\AdminamenitiesController@addamenities'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/amenitiessave', ['as' => 'adminamenitiessaveroute', 'uses' => 'admin\AdminamenitiesController@saveamenities']);
     Route::get('/'.ADMINSEPARATOR.'/amenitiesdel/{id?}', ['as' => 'adminamenitiesdelroute', 'uses' => 'admin\AdminamenitiesController@delamenities'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/amenitiesstatus', ['as' => 'adminamenitiesstatusroute', 'uses' => 'admin\AdminamenitiesController@statuschangeamenities']);
     
     
     //****************** For Home-Search Management Pannel********************

     Route::get('/'.ADMINSEPARATOR.'/homesearch', ['as' => 'adminhomesearchroute', 'uses' => 'admin\AdminhomesearchController@index']);
     Route::get('/'.ADMINSEPARATOR.'/homesearchadd/{id?}', ['as' => 'adminhomesearchaddroute', 'uses' => 'admin\AdminhomesearchController@addhomesearch'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/homesearchsave', ['as' => 'adminhomesearchsaveroute', 'uses' => 'admin\AdminhomesearchController@savehomesearch']);
     Route::get('/'.ADMINSEPARATOR.'/homesearchdel/{id?}', ['as' => 'adminhomesearchdelroute', 'uses' => 'admin\AdminhomesearchController@delhomesearch'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/homesearchstatus', ['as' => 'adminhomesearchstatusroute', 'uses' => 'admin\AdminhomesearchController@statuschangehomesearch']);
     
     
     //****************** For Dispute-Reason Management Pannel********************

     Route::get('/'.ADMINSEPARATOR.'/disputereason', ['as' => 'admindisputereasonroute', 'uses' => 'admin\AdmindisputereasonController@index']);
     Route::get('/'.ADMINSEPARATOR.'/disputereasonadd/{id?}', ['as' => 'admindisputereasonaddroute', 'uses' => 'admin\AdmindisputereasonController@adddisputereason'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/disputereasonsave', ['as' => 'admindisputereasonsaveroute', 'uses' => 'admin\AdmindisputereasonController@savedisputereason']);
     Route::get('/'.ADMINSEPARATOR.'/disputereasondel/{id?}', ['as' => 'admindisputereasondelroute', 'uses' => 'admin\AdmindisputereasonController@deldisputereason'])->where(['id' => '[0-9]+']);
     Route::post('/'.ADMINSEPARATOR.'/disputereasonstatus', ['as' => 'admindisputereasonstatusroute', 'uses' => 'admin\AdmindisputereasonController@statuschangedisputereason']);
     
     
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
     
     //******************** For admin_issue_with_artist Management ****************
    Route::get('/'.ADMINSEPARATOR.'/admin_issue_with_artist', ['as' => 'admin_issue_with_artist', 'uses' => 'admin\Admin_issue_with_artist_Controller@index']);
    Route::get('/'.ADMINSEPARATOR.'/view_artist/{id}', ['as' => 'admin_issue_with_artist_view', 'uses' => 'admin\Admin_issue_with_artist_Controller@view']);
    Route::post('/'.ADMINSEPARATOR.'/reply', ['as' => 'admin_issue_with_artist_send_mail', 'uses' => 'admin\Admin_issue_with_artist_Controller@reply']);
    Route::get('/'.ADMINSEPARATOR.'/reply_from_admin_artist/{id}', ['as' => 'reply_from_admin_artist', 'uses' => 'admin\Admin_issue_with_artist_Controller@reply_view']);
    
    Route::post('/'.ADMINSEPARATOR.'/load-more', ['as' => 'admin_issue_with_artist_load_more', 'uses' => 'admin\Admin_issue_with_artist_Controller@load_more']);

      //******************** For admin_issue_with_group Management ****************
    Route::get('/'.ADMINSEPARATOR.'/admin_issue_with_group', ['as' => 'admin_issue_with_group', 'uses' => 'admin\Admin_issue_with_group_Controller@index']);
    Route::get('/'.ADMINSEPARATOR.'/view_group/{id}', ['as' => 'admin_issue_with_group_view', 'uses' => 'admin\Admin_issue_with_group_Controller@view']);
    Route::post('/'.ADMINSEPARATOR.'/reply_to_group_booker', ['as' => 'admin_issue_with_group_send_mail', 'uses' => 'admin\Admin_issue_with_group_Controller@reply']);
    Route::get('/'.ADMINSEPARATOR.'/reply_from_admin_group/{id}', ['as' => 'reply_from_admin_group', 'uses' => 'admin\Admin_issue_with_group_Controller@reply_view']);
      //******************** For admin_issue_with_venue Management ****************
    Route::get('/'.ADMINSEPARATOR.'/admin_issue_with_venue', ['as' => 'admin_issue_with_venue', 'uses' => 'admin\Admin_issue_with_venue_Controller@index']);
    Route::get('/'.ADMINSEPARATOR.'/view_venue/{id}', ['as' => 'admin_issue_with_venue_view', 'uses' => 'admin\Admin_issue_with_venue_Controller@view']);
      //******************** For admin_issue_with_booker Management ****************
    Route::get('/'.ADMINSEPARATOR.'/admin_issue_with_booker', ['as' => 'admin_issue_with_booker', 'uses' => 'admin\Admin_issue_with_booker_Controller@index']);
    Route::get('/'.ADMINSEPARATOR.'/view_booker/{id}', ['as' => 'admin_issue_with_booker_view', 'uses' => 'admin\Admin_issue_with_booker_Controller@view']);



    //***************************** For admin display users transaction details ************
    Route::get('/'.ADMINSEPARATOR.'/transctiondeatils/{id}', ['as' => 'admintransactiondetails', 'uses' => 'admin\AdmintransactionController@index']);

     
});


Route::group(['middleware' => ['frontweb']], function () {
    
    //****************** For Frontend  starts ********************
    
    Route::get('/', ['as' => 'frontendhomeroute', 'uses' => 'frontend\FrontendhomeController@index']);
    Route::post('/frontendlandingajx', ['as' => 'frontendlandingajx', 'uses' => 'frontend\FrontendhomeController@landingajx']);
    Route::post('/registeruser', ['as' => 'frontendregisteruser', 'uses' => 'frontend\FrontendhomeController@registeruser']);
    Route::post('/loginuser', ['as' => 'frontendloginuser', 'uses' => 'frontend\FrontendhomeController@loginuser']);
    
    Route::get('/logout', ['as' => 'frontendlogout', 'uses' => 'frontend\FrontendhomeController@logout']);
    Route::post('/saveuserurls', ['as' => 'frontendsaveuserurls', 'uses' => 'frontend\FrontenduserController@saveuserurls']);
    Route::post('/saveuserskills', ['as' => 'frontendsaveuserskills', 'uses' => 'frontend\FrontenduserController@saveuserskills']);
    Route::post('/saveuserdesc', ['as' => 'frontendsaveuserdesc', 'uses' => 'frontend\FrontenduserController@saveuserdesc']);
    Route::post('/saveusername', ['as' => 'frontendsaveusername', 'uses' => 'frontend\FrontenduserController@saveusername']);
    Route::post('/populatesubskill', ['as' => 'frontendpopulatesubskill', 'uses' => 'frontend\FrontenduserController@populatesubskill']);
    Route::post('/saveskilldata', ['as' => 'frontendsaveskilldata', 'uses' => 'frontend\FrontenduserController@saveskilldata']);
    Route::post('/deletemyskill', ['as' => 'frontenddeletemyskill', 'uses' => 'frontend\FrontenduserController@deletemyskill']);
    
    //*********** editprofile routes starts here
    Route::get('/editprofile', ['as' => 'frontendeditprofile', 'uses' => 'frontend\FrontenduserController@index']);
    Route::post('/editprofileajax', ['as' => 'frontendeditprofileajax', 'uses' => 'frontend\FrontenduserController@editprofileajax']);
    //*********** editprofile routes ends here
    
    //*********** booking options in editprofile routes starts here
    Route::post('/bookingoptionssaveajx', ['as' => 'frontendeditprofilebookingoptions', 'uses' => 'frontend\FrontenduserController@bookingoptionssaveconfunc']);
    //*********** booking options in editprofile routes ends here
    
    //*********** Rider in person editprofile routes starts here
    Route::post('/saveridercust', ['as' => 'frontendsaveridercustajax', 'uses' => 'frontend\FrontenduserController@saveridercustfunc']);
    //*********** Rider in person editprofile routes ends here
    
    //*********** ABN in person editprofile routes starts here
    Route::post('/saveabncust', ['as' => 'frontendsaveabncustajax', 'uses' => 'frontend\FrontenduserController@saveabncustfunc']);
    //*********** ABN in person editprofile routes ends here
    
    //*********** GST in person editprofile routes starts here
    Route::post('/savegstcust', ['as' => 'frontendsavegstcustajax', 'uses' => 'frontend\FrontenduserController@savegstcustfunc']);
    //*********** GST in person editprofile routes ends here
    
    //*********** pagemetatag in person editprofile routes starts here
    Route::post('/savepagemetatagcust', ['as' => 'frontendsavepagemetatagcustajax', 'uses' => 'frontend\FrontenduserController@savepagemetatagcustfunc']);

    Route::post('/savepageseotagcust', ['as' => 'frontendsavepageseotagcustajax', 'uses' => 'frontend\FrontenduserController@savepageseotagcustfunc']);
    //*********** pagemetatag in person editprofile routes ends here
    
    //*********** forget password routes starts here
    Route::post('/forgotpass', ['as' => 'frontendforgotpass', 'uses' => 'frontend\FrontendhomeController@forgotpassword']);
    //********** forget password routes ends here
    
    //*********** Frontend Support routes starts here
    Route::get('/help', ['as' => 'frontendhelp', 'uses' => 'frontend\FrontendHelpController@index']);
    Route::get('/support', ['as' => 'frontendsupport', 'uses' => 'frontend\FrontendHelpController@support']);
    
    Route::post('/againstartistfrmsub', ['as' => 'frontendsupportagainstartistdispute', 'uses' => 'frontend\FrontendHelpController@againstartistfrmsubfunc']);
    Route::post('/againstgroupfrmsub', ['as' => 'frontendsupportagainstgroupdispute', 'uses' => 'frontend\FrontendHelpController@againstgroupfrmsubfunc']);
    Route::post('/againstvenuefrmsub', ['as' => 'frontendsupportagainstvenuedispute', 'uses' => 'frontend\FrontendHelpController@againstvenuefrmsubfunc']);
    Route::post('/againstbookerfrmsub', ['as' => 'frontendsupportagainstbookerdispute', 'uses' => 'frontend\FrontendHelpController@againstbookerfrmsubfunc']);
    
    //********** Frontend Support routes ends here

     //*********** Frontend profile routes starts here
   // Route::get('/profile', ['as' => 'frontendprofile', 'uses' => 'frontend\FrontendprofileController@index']);
     // Route::get('/profile/{seoname?}/{bkflag?}', ['as' => 'frontendprofile', 'uses' => 'frontend\FrontendprofileController@index']);
      Route::get('/artist/{seoname?}/{bkflag?}', ['as' => 'frontendprofile', 'uses' => 'frontend\FrontendprofileController@index']);
    Route::post('/countrystate',['as' => 'profilecountrystate', 'uses' =>'frontend\FrontendprofileController@getstate']);
    Route::post('/getGenere',['as' => 'profilecategorygenere', 'uses' =>'frontend\FrontendprofileController@getgenere']);
     Route::get('/presskitdownload/{file}', ['as' => 'frontendpresskit', 'uses' => 'frontend\FrontendprofileController@downloadpresskit']);

      Route::post('/getartistgenere',['as' => 'frontendartistgenere', 'uses' =>'frontend\FrontendprofileController@getartistgenere']);//****
     Route::post('/bookingconfirmartist',['as' => 'frontendartistbookingconfirmartist', 'uses' =>'frontend\FrontendprofileController@completebooking']);//
     
       Route::post('/artistreview', ['as' => 'frontendartistreview', 'uses' => 'frontend\FrontendprofileController@getReviewData']);
     
     
    //********** Frontend profile routes ends here
    
     //*********** Frontend googlepluslogincheck routes starts here
    Route::post('/checkgooglepluslogin', ['as' => 'frontendcheckgooglepluslogin', 'uses' => 'frontend\FrontendhomeController@checkgooglepluslogin']);
    //***********  Frontend googlepluslogincheck routes ends   here
    
    //*********** Frontend activateuser routes starts here
    Route::get('/activateuser/{activationtime}/{id}/{verify_token}', ['as' => 'frontendactivateuser', 'uses' => 'frontend\FrontendhomeController@activateuser']);
    //***********  Frontend activateuser routes ends   here
    
     //*********** Frontend subscription routes starts here
    Route::post('/subscribe', ['as' => 'frontendsubscription', 'uses' => 'frontend\FrontendSubscriptionController@index']);
    Route::post('/unsubscribe', ['as' => 'frontendunsubscription', 'uses' => 'frontend\FrontendSubscriptionController@unsubscribe']);
    //***********  Frontend subscription routes ends here
    
    //*********** Frontend Roster routes starts here
    Route::get('/myroster', ['as' => 'frontendroster', 'uses' => 'frontend\FrontendRosterController@index']);
    Route::post('/giguserfeeds', ['as' => 'frontendgiguserfeeds', 'uses' => 'frontend\FrontendRosterController@giguserfeeds']);
    Route::post('/callrosterleftpanel', ['as' => 'frontendrosterleftpanel', 'uses' => 'frontend\FrontendRosterController@callrosterleftpanelfunc']);
    Route::post('/viewrosterleftnestpanel', ['as' => 'frontendrosterleftnestpanelview', 'uses' => 'frontend\FrontendRosterController@viewrosterleftnestpanelfunc']);
    Route::post('/callrosterleftnestedpanel', ['as' => 'frontendrosterleftnestedpanel', 'uses' => 'frontend\FrontendRosterController@callrosterleftnestedpanelfunc']);
    Route::post('/reviewmodal', ['as' => 'frontendreviewmodal', 'uses' => 'frontend\FrontendRosterController@reviewmodal']);
    Route::post('/reviesubmit', ['as' => 'frontendreviesubmit', 'uses' => 'frontend\FrontendRosterController@reviesubmit']);
    Route::get('/exportingics/{fromdt}/{todt}', ['as' => 'frontendrostercalexp', 'uses' => 'frontend\FrontendRosterController@frontendrostercalexp']);
    Route::get('/totalexporteddata', ['as' => 'frontendrostertotalexporteddata', 'uses' => 'frontend\FrontendRosterController@totalexporteddata']);
    //********** Frontend Roster routes ends here 
    
     //*********** Frontend user image  routes starts here 
     Route::post('/userimagesave', ['as' => 'frontenduserimagesave', 'uses' => 'frontend\FrontenduserController@userimagesave']);
     Route::post('/userimagedelete', ['as' => 'frontenduserimagedelete', 'uses' => 'frontend\FrontenduserController@userimagedelete']);
     //*********** Frontend user image  routes ends here
     
     //*********** press kit upload  routes starts here 
     Route::post('/presskituploadsave', ['as' => 'frontendpresskituploadsave', 'uses' => 'frontend\FrontenduserController@presskituploadsave']);
     
     //*********** press kit upload  routes ends here 

    //*********** Frontend myaccount routes starts here
    Route::get('/myaccount', ['as' => 'frontendmyaccount', 'uses' => 'frontend\FrontendmyaccountController@index']);
    Route::post('/myaccountcity', ['as' => 'frontendmyaccountcity', 'uses' => 'frontend\FrontendmyaccountController@checkcity']);
    Route::post('/myaccountreferemail', ['as' => 'frontendmyaccountreferemail', 'uses' => 'frontend\FrontendmyaccountController@referemail']);
    Route::post('/myaccountfrmsubmit', ['as' => 'frontendmyaccountfrmsubmit', 'uses' => 'frontend\FrontendmyaccountController@myaccountfrmsubmit']);
    Route::post('/myaccountchkpass', ['as' => 'frontendmyaccountchkpass', 'uses' => 'frontend\FrontendmyaccountController@checkpass']);
    Route::post('/myaccountdeactivefrmsubmit', ['as' => 'frontendmyaccountdeactive', 'uses' => 'frontend\FrontendmyaccountController@myaccountdeactivefrmsubmitfunc']);
    //********** Frontend myaccount routes ends here
    
    //*********** Frontend group routes starts here old
    //Route::post('/groupmemberlist', ['as' => 'frontendgroupmemberlist', 'uses' => 'frontend\FrontendgroupController@index']);
    //Route::get('/group/{grpid?}', ['as' => 'frontendgroupdashboard', 'uses' => 'frontend\FrontendgroupController@dashboard']);
    //Route::post('/groupdashboardfrmpage', ['as' => 'frontendgroupdashboardfrmpageload', 'uses' => 'frontend\FrontendgroupController@groupdashboardfrmload']);
    //Route::post('/groupdashboardfrmsubmit', ['as' => 'frontendgroupdashboardfrmsubmit', 'uses' => 'frontend\FrontendgroupController@groupdashboardfrmsubmit']);
    //Route::post('/groupChekEmail', ['as' => 'frontendgroupChekEmail', 'uses' => 'frontend\FrontendgroupController@groupChekEmail']);
    //Route::post('/groupChekGrpName', ['as' => 'frontendgroupChekGrpName', 'uses' => 'frontend\FrontendgroupController@groupChekGrpName']);
    //*********** Frontend group create or edit routes end here old
    
    //*********** Frontend group routes starts here new
    //Route::get('/groupprofile/{seoname?}', ['as' => 'frontendgroup', 'uses' => 'frontend\FrontendGroupController@index']);
    Route::get('/group/{seoname?}/{bkflag?}', ['as' => 'frontendgroup', 'uses' => 'frontend\FrontendGroupController@index']);
    Route::post('/groupcountrystate',['as' => 'groupcountrystate', 'uses' =>'frontend\FrontendGroupController@getstate']);
    Route::post('/groupgetGenere',['as' => 'groupcategorygenere', 'uses' =>'frontend\FrontendGroupController@getgenere']);
    Route::get('/grouppresskitdownload/{file}', ['as' => 'frontendgrouppresskit', 'uses' => 'frontend\FrontendGroupController@downloadpresskit']);
    //*********** Frontend group routes starts here new
    
    //*********** Frontend editpgroup routes starts here
    Route::get('/editgroup/{seoname?}', ['as' => 'frontendeditgroup', 'uses' => 'frontend\FrontendGroupController@editgroup']);
    Route::post('/editgroupprofileajax', ['as' => 'frontendeditgroupajax', 'uses' => 'frontend\FrontendGroupController@editgroupajax']);
    Route::post('/savegroupurls', ['as' => 'frontendsavegroupurls', 'uses' => 'frontend\FrontendGroupController@savegroupurls']);
    Route::post('/savegroupskills', ['as' => 'frontendsavegroupkills', 'uses' => 'frontend\FrontendGroupController@savegroupskills']);
    Route::post('/savegroupdesc', ['as' => 'frontendsavegroupdesc', 'uses' => 'frontend\FrontendGroupController@savegroupdesc']);
    Route::post('/savegroupname', ['as' => 'frontendsavegroupname', 'uses' => 'frontend\FrontendGroupController@savegroupname']);
    Route::post('/populategroupsubskill', ['as' => 'frontendpopulategroupsubskill', 'uses' => 'frontend\FrontendGroupController@populategroupsubskill']);
    Route::post('/savegroupskilldata', ['as' => 'frontendgroupsaveskilldata', 'uses' => 'frontend\FrontendGroupController@savegroupskilldata']);
    Route::post('/deletegroupskill', ['as' => 'frontenddeletegroupskill', 'uses' => 'frontend\FrontendGroupController@deletegroupskill']);
    Route::post('/savegroupridercust', ['as' => 'frontendsaveridercustgroup', 'uses' => 'frontend\FrontendGroupController@savegroupridercust']);
    Route::post('/saveabncustgroup', ['as' => 'frontendsaveabncustgroup', 'uses' => 'frontend\FrontendGroupController@saveabncustgroup']);
    Route::post('/savegstcustgroup', ['as' => 'frontendsavegstcustgroup', 'uses' => 'frontend\FrontendGroupController@savegstcustgroup']);
    Route::post('/savepagemetatagcustgroup', ['as' => 'frontendsavepagemetatagcustgroup', 'uses' => 'frontend\FrontendGroupController@savepagemetatagcustgroup']);
   //*********** for group seo starts
    Route::post('/saveseourlcustgroup', ['as' => 'frontendsaveseourlcustgroup', 'uses' => 'frontend\FrontendGroupController@saveseourlcustgroup']);
  //*********** for group seo ends

    Route::post('/presskituploadsavegroup', ['as' => 'frontendpresskituploadsavegroup', 'uses' => 'frontend\FrontendGroupController@presskituploadsavegroup']);
    Route::post('/groupimagesave', ['as' => 'frontendgroupimagesave', 'uses' => 'frontend\FrontendGroupController@groupimagesave']);
    Route::post('/groupimagedelete', ['as' => 'frontendgroupimagedelete', 'uses' => 'frontend\FrontendGroupController@groupimagedelete']);
    Route::post('/groupprofilesubmit', ['as' => 'frontendgroupprofilesubmit', 'uses' => 'frontend\FrontendGroupController@groupprofilesubmit']);
    Route::post('/groupbookingoptionssaveajx', ['as' => 'frontendeditprofilegroupbookingoptions', 'uses' => 'frontend\FrontendGroupController@groupbookingoptionssaveajx']);
    //*********** Frontend editpgroup routes ends here
    
    //*********** Frontend Venue routes starts here
    //Route::get('/venuelist', ['as' => 'frontendVenuelist', 'uses' => 'frontend\FrontendVenueController@index']);
    //Route::get('/venuedashboard', ['as' => 'frontendVenuedashboard', 'uses' => 'frontend\FrontendVenueController@dashboard']);
    
   //  Route::get('/venue/{seoname?}', ['as' => 'frontendpublicVenue', 'uses' => 'frontend\FrontendVenueLocationController@index']);
   // Route::get('/venue-edit/{seoname?}', ['as' => 'frontendpublicVenueEdit', 'uses' => 'frontend\FrontendVenueLocationController@edit_venue']);
   //   Route::post('/populatesubskillvenue', ['as' => 'frontendpopulateVenuesubskill', 'uses' => 'frontend\FrontendVenueLocationController@venuesubskill']);
   //Route::post('/saveuserurlsVenue', ['as' => 'frontendsaveuserurlsVenue', 'uses' => 'frontend\FrontendVenueLocationController@saveuserurls']);
   //
   //Route::post('/saveusernameVenue', ['as' => 'frontendsaveusernameVenue', 'uses' => 'frontend\FrontendVenueLocationController@saveusernamevenue']);
   //Route::post('/saveuserdescVenue', ['as' => 'frontendsaveuserdescVenue', 'uses' => 'frontend\FrontendVenueLocationController@saveuserdescvenue']);
   //
    Route::get('/venue/{seoname?}/{bkflag?}', ['as' => 'frontendpublicVenue', 'uses' => 'frontend\FrontendVenueLocationController@index']);
        Route::get('/venue-edit/{seoname?}', ['as' => 'frontendpublicVenueEdit', 'uses' => 'frontend\FrontendVenueLocationController@edit_venue']);
        Route::post('/populatesubskillvenue', ['as' => 'frontendpopulateVenuesubskill', 'uses' => 'frontend\FrontendVenueLocationController@venuesubskill']);
        Route::post('/saveuserurlsVenue', ['as' => 'frontendsaveuserurlsVenue', 'uses' => 'frontend\FrontendVenueLocationController@saveuserurls']);
        
        Route::post('/saveusernameVenue', ['as' => 'frontendsaveusernameVenue', 'uses' => 'frontend\FrontendVenueLocationController@saveusernamevenue']);
        Route::post('/saveuserdescVenue', ['as' => 'frontendsaveuserdescVenue', 'uses' => 'frontend\FrontendVenueLocationController@saveuserdescvenue']);
        Route::post('/saveskilldataVenue', ['as' => 'frontendsaveskilldataVenue', 'uses' => 'frontend\FrontendVenueLocationController@saveskilldatavenue']);
        Route::post('/deletemyskillVenue', ['as' => 'frontenddeletemyskillVenue', 'uses' => 'frontend\FrontendVenueLocationController@deletemyskillvenue']);
        Route::post('/presskituploadsaveVenue', ['as' => 'frontendpresskituploadsaveVenue', 'uses' => 'frontend\FrontendVenueLocationController@presskituploadsavevenue']);
        //*********** ABN GST in person editprofile routes starts here
        Route::post('/saveabncustVenue', ['as' => 'frontendsaveabncustVenue', 'uses' => 'frontend\FrontendVenueLocationController@saveabncustfuncvenue']);
        Route::post('/savegstcustVenue', ['as' => 'frontendsavegstcustVenue', 'uses' => 'frontend\FrontendVenueLocationController@savegstcustfuncvenue']);
         //*********** pagemetatag in person editprofile routes starts here
        Route::post('/savepagemetatagcustVenue', ['as' => 'frontendsavepagemetatagcustVenue', 'uses' => 'frontend\FrontendVenueLocationController@savepagemetatagcustfuncvenue']);

        //*********** venue seo url starts here
        Route::post('/saveseourlcustvenue', ['as' => 'frontendsaveseourlcustvenue', 'uses' => 'frontend\FrontendVenueLocationController@saveseourlcustvenue']);
          //*********** venue seo url ends here
        
        
         //*********Image For Venue starts here
       Route::post('/userimagesaveVenue', ['as' => 'frontenduserimagesaveVenue', 'uses' => 'frontend\FrontendVenueLocationController@userimagesavevenue']);
       Route::post('/userimagedeleteVenue', ['as' => 'frontenduserimagedeleteVenue', 'uses' => 'frontend\FrontendVenueLocationController@userimagedeletevenue']);
       Route::post('/menuuploadsaveVenue', ['as' => 'frontendmenuuploadsaveVenue', 'uses' => 'frontend\FrontendVenueLocationController@menuuploadsavevenue']);
        Route::post('/venueaddress', ['as' => 'frontendaddresssaveVenue', 'uses' => 'frontend\FrontendVenueLocationController@addresssavevenue']);
        Route::post('/countrystatevenue',['as' => 'frontendvenueeditprofilecountrystate', 'uses' =>'frontend\FrontendVenueLocationController@getstatevenue']);
     //**********Image For Venue ends here
      Route::get('/presskitdownloadvenue/{file}', ['as' => 'frontendvenuepresskitdownloadVenue', 'uses' => 'frontend\FrontendVenueLocationController@downloadpresskitveue']);
       Route::post('/getgenerevenue',['as' => 'frontendvenuegenere', 'uses' =>'frontend\FrontendVenueLocationController@getvenueetgenere']);

        Route::post('/venuebookingsubmission',['as' => 'frontendvenuevenuebookingsubmissione', 'uses' =>'frontend\FrontendVenueLocationController@venuebookingsubmission']);


         Route::get('/menudownloadvenue/{file}',['as' => 'frontendvenuevenuebookingmenudownload', 'uses' =>'frontend\FrontendVenueLocationController@menudownloadvenue']);

//******
          Route::post('/bookingoptionssaveajxvenue',['as' => 'frontendvenuevenuebookingoptionssaveajxvenue', 'uses' =>'frontend\FrontendVenueLocationController@bookingoptionssaveajxvenue']);

    //*********** Frontend Venue routes end here
    
    
    //*********** Frontend main search routes starts here*******
     Route::post('/mainsearch', ['as' => 'frontendmainsearch', 'uses' => 'frontend\FrontendMainsearchController@mainsearch']);
     Route::post('/mainsearchcateg', ['as' => 'frontendmainsearchcateg', 'uses' => 'frontend\FrontendMainsearchController@mainsearchcateg']);
      Route::post('/mainsearchgenre', ['as' => 'frontendmainsearchgenre', 'uses' => 'frontend\FrontendMainsearchController@mainsearchgenre']);
      Route::post('/mainsearchloclatlong', ['as' => 'frontendmainsearchloclatlong', 'uses' => 'frontend\FrontendMainsearchController@mainsearchloclatlong']);
    //*********** Frontend main search routes ends here********
    
    //*********** Frontend fetch city/town  routes starts here********
    
      Route::post('/mainsearchcitytowndata', ['as' => 'frontendmainsearchcitytowndata', 'uses' => 'frontend\FrontendMainsearchController@mainsearchcitytowndata']);
    
    //*********** Frontend fetch city/town  routes ends here********
    
    //*********** Frontend main search routes ends here********
    
    //************* Frontend gig start (08-07-16)***************//
    Route::post('/loadgigpostmodal', ['as' => 'frontendloadgigpostmodal', 'uses' => 'frontend\FrontendGigController@index']);
    Route::post('/getparentskill', ['as' => 'frontendloadskill', 'uses' => 'frontend\FrontendGigController@getAllSkillParent']);
    Route::post('/gigsubskill', ['as' => 'frontendloadgigsubskill', 'uses' => 'frontend\FrontendGigController@gigsubskill']);
    Route::post('/getcountrydatagig', ['as' => 'frontendloadgigcountrydata', 'uses' => 'frontend\FrontendGigController@getCountryDataGig']);
    Route::post('/getgigstate', ['as' => 'frontendloadgetgigstate', 'uses' => 'frontend\FrontendGigController@getgigstate']);
    Route::post('/gigmasterpost', ['as' => 'frontendgigmasterpost', 'uses' => 'frontend\FrontendGigController@gig_master_post_submit']);
    
    //************* Frontend gig end ***************//
    //************* Frontend gig rouster start ***************//
    Route::post('/loadgigrostermodal', ['as' => 'frontendloadgigrostermodal', 'uses' => 'frontend\FrontendGigRosterController@index']);
    Route::get('/savegigbidrequest', ['as' => 'frontendsavegigbidrequest', 'uses' => 'frontend\FrontendGigRosterController@savegigbidrequest']);
    Route::get('/accptbidrequestbyartist', ['as' => 'frontendaccptbidrequestbyartist', 'uses' => 'frontend\FrontendGigRosterController@accptbidrequestbyartist']);
    Route::get('/accptbidrequestbybooker', ['as' => 'frontendaccptbidrequestbybooker', 'uses' => 'frontend\FrontendGigRosterController@accptbidrequestbybooker']);
    Route::get('/gigcancelbybooker', ['as' => 'frontendgigcancelbybooker', 'uses' => 'frontend\FrontendGigRosterController@gigcancelbybooker']);
    Route::get('/gigcancelbyartist', ['as' => 'frontendgigcancelbyartist', 'uses' => 'frontend\FrontendGigRosterController@gigcancelbyartist']);
    //************* Frontend gig rouster end ***************//
    
    //*********** Frontend public profile  routes starts here
    Route::post('/publicprofilegigs', ['as' => 'frontendpublicprofilegigs', 'uses' => 'frontend\FrontendPublicprofilegigController@publicprofilegigs']);
    Route::post('/getprofileleftmanu', ['as' => 'frontendgetprofileleftmanu', 'uses' => 'frontend\FrontendPublicprofilegigController@profileleftmanu']);
    Route::post('/getprofilecatgen', ['as' => 'frontendgetprofilecatgen', 'uses' => 'frontend\FrontendPublicprofilegigController@getcatgen']);
    Route::post('/getprofilegenajax', ['as' => 'frontendgetprofilegenajax', 'uses' => 'frontend\FrontendPublicprofilegigController@profilegenajax']);
    Route::post('/getprofilemodalajax', ['as' => 'frontendgetprofilemodalajax', 'uses' => 'frontend\FrontendPublicprofilegigController@profilemodalajax']);
    Route::post('/savemyfavorite', ['as' => 'frontendmyfavorite', 'uses' => 'frontend\FrontendPublicprofilegigController@myfavorite']);
    
    //*********** Frontend public profile  routes ends here
    
    //*********** Frontend editprofile calendarshowhidesave  routes starts here
    Route::post('/calendarshowhidesave', ['as' => 'frontendcalendarshowhidesave', 'uses' => 'frontend\FrontendPublicprofilegigController@calendarshowhidesave']);
    Route::post('/calpendbkpublicevesave', ['as' => 'frontendcalpendbkpublicevesave', 'uses' => 'frontend\FrontendPublicprofilegigController@calpendbkpublicevesave']);
    
    //*********** Frontend editprofile calendarshowhidesave  routes ends here
    
    //************frontendeditprofile review section starts here
    Route::post('/showreviewinprofile', ['as' => 'frontendreviewshowpublic', 'uses' => 'frontend\FrontendPublicprofilegigController@showreviewinprofilepg']);
    //************frontend editprofile review ends here
    
    
    //*********** Frontend gig_guide  routes starts here
    
    Route::get('/gigguide', ['as' => 'frontendgigguide', 'uses' => 'frontend\FrontendgigguideController@index']);
    Route::post('/getgigguidecallendardata', ['as' => 'frontendgetgigguidecallendardata', 'uses' => 'frontend\FrontendgigguideController@getgigguidecallendardata']);
    Route::post('/getgigguidleftpannel', ['as' => 'frontendgetgigguidleftpanneld', 'uses' => 'frontend\FrontendgigguideController@gigleftpannel']);
    Route::post('/getgigguidgetcategory', ['as' => 'frontendgetgigguidgetcategory', 'uses' => 'frontend\FrontendgigguideController@getcategory']);
    Route::post('/getgigguidgetgenre', ['as' => 'frontendgetgigguidgetgenre', 'uses' => 'frontend\FrontendgigguideController@getgenre']);
    
    Route::post('/getrostergetcategory', ['as' => 'frontendgetrostergetcategory', 'uses' => 'frontend\FrontendgigguideController@getrostergetcategory']);
    //*********** Frontend gig_guide  routes ends here
    
   
     //************for session exists or not starts here
    Route::post('/showsessionexiststrue', ['as' => 'frontendreviewshowsessionexists', 'uses' => 'frontend\FrontendhomeController@showsessionexiststrue']);
    //************for session exists or not ends here
    
    
    //*********** Frontend rider view start
    Route::post('/ridershow', ['as' => 'frontendridershow', 'uses' => 'frontend\FrontendPublicprofilegigController@ridershow']);
     Route::post('/ridersave', ['as' => 'frontendridersave', 'uses' => 'frontend\FrontendPublicprofilegigController@ridersave']);
    //*********** Frontend rider view end



     //******For Fornt end static page routes strts here

    Route::get('/terms-and-conditions', ['as' => 'frontendtermsconditions', 'uses' => 'frontend\FrontendHelpController@termsandconditions']);
    
    Route::get('/security-and-safety', ['as' => 'frontendsecurityandsafety', 'uses' => 'frontend\FrontendHelpController@securityandsafety']);

    Route::get('/privacy-policy', ['as' => 'frontendprivacypolicy', 'uses' => 'frontend\FrontendHelpController@privacypolicy']);
    
     Route::get('/tips', ['as' => 'frontendtips', 'uses' => 'frontend\FrontendHelpController@tips']);

     //******For front end static page routes ends here

    //******* for payment related starts *************
     Route::post('/paytowallet', ['as' => 'frontendpaytowallet', 'uses' => 'frontend\FrontendpaymentController@paytowallet']);
    Route::post('/paymentwalletprocess', ['as' => 'frontendpaymentprocess', 'uses' => 'frontend\FrontendpaymentController@paymentwalletprocess']);
    Route::get('/paymentsuccess', ['as' => 'frontendpaymentprocess', 'uses' => 'frontend\FrontendpaymentController@paymentsuccess']);
     Route::post('/showtransactionlist', ['as' => 'frontendshowtransactionlist', 'uses' => 'frontend\FrontendpaymentController@showtransactionlist']);
    
    
     Route::post('/paytobank', ['as' => 'frontendpaytobank', 'uses' => 'frontend\FrontendpaymentController@paytobank']);
    
    //******* for payment related ends *************



   //****************** For Frontend  ends ********************
   
   
    
    

});






