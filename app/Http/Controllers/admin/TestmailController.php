<?php

namespace App\Http\Controllers\admin;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//use App\User
use Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;

class TestmailController extends Controller
{
    
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    
    public function index()
    {
        $data = array(
            
            'name' => "Learning Laravel",
        );
    
    //echo 'TEST MAIL';die;
    
        Mail::send('emails.welcomeback', $data, function ($message) {
    
            //$message->from('indrasis.roy@esolzmail.com', 'Learning Laravel');
    
            $message->to('smita.roy@esolzmail.com')->subject('Learning Laravel test email');
    
        });
    
        //$dataret['mailsucctext']= "Your email has been sent successfully";
        //return view('admin.testmail.testmailsucc', $dataret);
        
        return "Your email has been sent successfully";
    }
    
}