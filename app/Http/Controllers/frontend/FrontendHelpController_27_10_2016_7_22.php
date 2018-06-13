<?php


namespace App\Http\Controllers\frontend;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//use App\User
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;



class FrontendHelpController extends Controller
{
    
    public function index(Request $request)
    {
      //echo "FrontendSupportController";
        $datahelp=array();
        
        //***** for article help  description starts ************
        $articlePage = DB::table('article as ar');
        $articlePage=$articlePage->select(DB::raw('ar.description,ar.title'));
        $articlePage=$articlePage->where('ar.status', 1);
        $articlePage=$articlePage->where('ar.id', 13);        
        $articlePagedata=$articlePage->first();
        //***** for article help  description ends ************
        
        //***** for help_supportbypage starts ************
        $help_supportbypage = DB::table('help_supportbypage as supportbypage');
        $help_supportbypage=$help_supportbypage->select(DB::raw('supportbypage.id,supportbypage.title,supportbypage.description,supportbypage.seo_name,supportbypage.create_date,supportbypage.modified_date'));
        $help_supportbypage=$help_supportbypage->where('supportbypage.status', 1);
        $help_supportbypage=$help_supportbypage->orderby('supportbypage.modified_date','DESC')->skip(0)->take(6);
        $help_supportbypagedata=$help_supportbypage->get();
        //***** for help_supportbypage ends ************
       
        //***** for howitsdone starts ************
        $help_howitsdone = DB::table('help_howitsdone as howitsdone');
        $help_howitsdone=$help_howitsdone->select(DB::raw('howitsdone.id,howitsdone.title,howitsdone.youtube_embed,howitsdone.seo_name,howitsdone.create_date,howitsdone.modified_date'));
        $help_howitsdone=$help_howitsdone->where('howitsdone.status', 1);
        $help_howitsdonedata=$help_howitsdone->get();
        //***** for howitsdone ends ************
        
        //***** for faq starts ************        
        $help_faqpagedata=array();
        $help_faqpage = DB::table('faq as fq');
        $help_faqpage=$help_faqpage->select(DB::raw('fq.id,fq.title,fq.description,fq.seo_name,fq.create_date,fq.modified_date'));
        $help_faqpage=$help_faqpage->where('fq.publish', 1);
        $help_faqpage=$help_faqpage->orderby('fq.modified_date','DESC')->skip(0)->take(6);
        $help_faqpagedata=$help_faqpage->get();        
        //***** for faq ends   ************
        
        
        $datahelp['supportbypage']=$help_supportbypagedata;
        $datahelp['howitsdone']=$help_howitsdonedata;
        $datahelp['artile']=$articlePagedata;
        $datahelp['faqpage']=$help_faqpagedata;        
        //
        //echo "<pre>";
        //print_r($datahelp);
        //echo "</pre>";
        //die;
        //
      return view('front.help.helpview',$datahelp);
    }
        public function support(Request $request)
    {
        return view('front.help.supportview');
    }
    
    
}