<?php


namespace App\Http\Controllers\admin;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//use App\User
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
//use Illuminate\Routing\Route;
use Mail;


class AdminmytestController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function testmymail(Request $request )
    {
           echo "test my mail";
           
        $chkmail=Mail::raw('Text to e-mail', function ($message) {
                $message->from($address="sambit@esolzmail.com", $name = "Sambit Kapat");
                $message->sender($address="sambit@esolzmail.com", $name = "Sambit Kapat");
                $message->to($address="soumik@esolzmail.com", $name = "Soumik");
               // $message->cc($address, $name = null);
                //$message->bcc($address, $name = null);
                //$message->replyTo($address, $name = null);
                $message->subject($subject="test subject");
               // $message->priority($level=1);
               
               

        });
        
        var_dump($chkmail);
    }
    
       
           
           
           
}