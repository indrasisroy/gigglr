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
use Illuminate\Routing\Route;

class AdminsupportbypageController extends Controller
{
        /**
         * Show the profile for the given user.
         *
         * @param  int  $id
         * @return Response
        **/
        
        public function index(Request $request )
        {
            
                //echo "AdminsupportbypageController";die;
                $data=array();
                $useinPagiAr=array();
               
                $srch1=addslashes(trim($request->input('srch1','')));
                $sort1=addslashes(trim($request->input('sort1','')));
                $sorttype1=addslashes(trim($request->input('sorttype1','')));
                
                if(!empty($srch1))
                {
                    $useinPagiAr['srch1']=trim($srch1);  
                }
                
                if(!empty($sort1))
                {
                    $useinPagiAr['sort1']=trim($sort1);  
                }
                
                if(!empty($sorttype1))
                {
                    $useinPagiAr['sorttype1']=trim($sorttype1);  
                }
                
                
                $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
                $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
                
                
                if(!empty($successmsgdata)){
                  $data['successmsgdata']=$successmsgdata;
                }
                if(!empty($errormsgdata)){
                      $data['errormsgdata']=$errormsgdata;               
                }
                
                //**** fetch data starts
                
                $howitsdone_db = DB::table('help_supportbypage as supportbypage');
                $howitsdone_db=$howitsdone_db->select(DB::raw('supportbypage.id,supportbypage.title,supportbypage.description,supportbypage.create_date,supportbypage.modified_date,supportbypage.status'));
                if(!empty($srch1))
                {
                   $howitsdone_db=$howitsdone_db->where('supportbypage.title', 'like', "%".$srch1."%");   
                }
                
                if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
                {
                      
                      $howitsdone_db=$howitsdone_db->orderBy('supportbypage.'.$sort1, $sorttype1);
                }
                
                $pagi_howitsdone=$howitsdone_db;
                
                //**** fetch data ends
                
                //***** fetch data from settings table starts
                
                $pagelimit=1;
                
                $staterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();
                
                if(!empty($staterow))
                {
                    $pagelimit=$staterow->record_per_page_admin;
                }
                
                //***** fetch data from settings table ends
            
                //***** pagination code starts
                 
                $pagi_howitsdone = $pagi_howitsdone->paginate($pagelimit);
        
                $pagi_howitsdone->setPath(url(ADMINSEPARATOR.'/supportbypage'));
          
                $data['pagi_supportbypage']=$pagi_howitsdone;
                $data['useinPagiAr']=$useinPagiAr;
                
                //***** pagination code ends
                //print_r($data);die;
           
                return view('admin.supportbypage.supportbypagelist', $data);
        }
    
        public function addsupportbypage(Request $request,$id=0)
        {
                $data=array();
                $data['data1']="hello";
      
                if(!empty($id))
                {
                        //**** fetch data starts
                        
                        $supportbypagerow = DB::table('help_supportbypage as supportbypage')->where('supportbypage.id', $id)->first();
                        
                        $data['supportbypage']=$supportbypagerow;
                        
                        //**** fetch data ends
                }
                //print_r($data);die;

                return view('admin.supportbypage.supportbypageadd', $data);
        }
    
    
        public function savesupportbypage(Request $request)
        {
                //echo "I am inside faq insert section ";exit();
                
                $title = addslashes(ucfirst(trim($request->input('title',''))));
            // echo "========== <br>";
                $description = htmlentities($request->input('description',''));
            //echo "========== <br>";
            //  $youtube_url = htmlentities($request->input('youtube_url',''));
            //echo "========== <br>";
                $youtube_embed = htmlentities($request->input('youtube_embed',''));
            //echo "========== <br>";
            
                $id = addslashes(trim($request->input('howitsdoneid',0)));//exit();
                $dataInsert=array();
                if($id == 0)
                {
                        $dataInsert['status']=1;
                }
   
  
                $dataInsert['title']=$title;
                $dataInsert['description']=$description;
                $dataInsert['modified_date']=date('Y-m-d H:i:s');
                 
                 
           
                $chkvalid=$this->checkfaqform($request,$id);
            
                if($chkvalid===true)
                {
                        //********Getting SEO name starts here
                        $seoname = $this->seoUrl($title);
                        $seoname = $seoname.'--';
                        //********** Checking SEO name exists or not strats here
            
                        $seoqry = DB::table('help_howitsdone');
                        $seoqry=$seoqry->where('seo_name', 'like', $seoname.'%');
                          if(!empty($id))
                         {
                                //***check for edit
                          $seoqry=$seoqry->where('id', '<>', $id);
                         }
                      
                        $seoqry=$seoqry->count();
                        $tot_seocount=$seoqry;
                        $tot_seocount = $tot_seocount+1;
                        $seoname = $seoname.$tot_seocount;
                        $dataInsert['seo_name']= $seoname;
                        //********** Checkign SEO name exists or not ends here
                        //********Getting SEO name ends here
                        
                        
                        
                        if(empty($id))
                        {
                                $dataInsert['create_date']=date('Y-m-d H:i:s');

                                
                                //*** insert  query
                                $isInserted = DB::table('help_supportbypage')->insert($dataInsert);
                                
                                /*Last Insert id*/
                                $isInserted=DB::getPdo()->lastInsertId();
                        }
                        else
                        {
                                //*** update query
                                
                                $isInserted=DB::table('help_supportbypage')
                                ->where('id', $id)
                                ->update($dataInsert);
                        }
                 
                        if($isInserted >= 0 )
                        {
                               $request->session()->flash('admin_successmsgdata_sess', 'help support by page Successfully saved');
                               return redirect(ADMINSEPARATOR.'/supportbypage');
                        }
                }
                else
                {
                        if(!empty($id))
                        {
                                return redirect(ADMINSEPARATOR.'/supportbypageadd/'.$id)
                                ->withErrors($chkvalid)
                                ->withInput();
                        }
                        else
                        {
                                return redirect(ADMINSEPARATOR.'/supportbypageadd')
                                ->withErrors($chkvalid)
                                ->withInput();
                        }
                }
           
                return redirect(ADMINSEPARATOR.'/supportbypage');
        }
     
        public function checkfaqform($request,$id=0)
        {
                $validator = Validator::make($request->all(),
                        [
                                'title' => "required|max:100|unique:help_supportbypage,title,".$id,
                                'description'=> "required|max:250",
                        ],
                        [
                                'title.required'=>'*Title field required',
                                'title.unique'=>'*Title already present',
                                'description.required'=>'*Description embed field required',
                                //'language_3_code.unique'=>'*Language 3 letter code should be unique',
                        ]
                );
                   
                if ($validator->fails())
                {
                    return $validator;
                }
                    
                return true;
        } 
           
        public function statuschangesupportbypage(Request $request)
        {       
                $statuschange = $request->input('statuschange',0);
                $faqid =    $request->input('faqid',0);
                //$rt=$statuschange.'======'.$languageid;
                //echo  json_encode($rt);
                //die;
                
                $respAr=array();
                $flagdata=0;
               
                if($faqid!='' && $faqid>0 && in_array($statuschange,array(0,1)))
                {
                        //*** update status starts
                        
                        $dataUpdate=array();
                        $dataUpdate['status']=$statuschange;
                        
                        $updstaus=DB::table('help_supportbypage')
                              ->where('id', $faqid)
                              ->update($dataUpdate);
                              
                         if(!empty($updstaus))
                         {
                                $flagdata=1;
                         }
                        
                        //*** update status ends
                }
               
                $respAr['flag']=$flagdata;
                $respAr['iddata']=$faqid;
                
                //echo  json_encode($dataUpdate);
                //die;
                
                echo  json_encode($respAr);
        }
       
        public function delsupportbypage(Request $request,$id=0)
        {
                if(empty($id))
                {
                        return redirect(ADMINSEPARATOR.'/supportbypage');
                }
           
                $ar=DB::table('help_supportbypage')->where('id', '=', $id)->delete();
           
                if($ar>0)
                {
                        $request->session()->flash('admin_successmsgdata_sess', 'Support by page has been deleted successfully');  
                }

                return redirect(ADMINSEPARATOR.'/supportbypage');
        }
        
        
         //*********Custom SEO Function starts here
       
      public function seoUrl($string_main) 
      {
            $string = substr($string_main,0,50);
            //Lower case everything
            $string = strtolower($string);
            //Make alphanumeric (removes all other characters)
            $string = str_slug($string,'-');
            return $string;
       }
      //*********Custom SEO Function ends here
           
}