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

class AdminlanguageController extends Controller
{
        /**
         * Show the profile for the given user.
         *
         * @param  int  $id
         * @return Response
        **/
        
        public function index(Request $request )
        {
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
                
                $language_db = DB::table('language as lc');
                $language_db=$language_db->select(DB::raw('lc.id,lc.language_name,lc.language_3_code,lc.status,lc.create_date,lc.modified_date'));
                if(!empty($srch1))
                {
                   $language_db=$language_db->where('lc.language_name', 'like', "%".$srch1."%");   
                }
                
                if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
                {
                      
                      $language_db=$language_db->orderBy('lc.'.$sort1, $sorttype1);
                }
                
                $pagi_country=$language_db;
                
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
                 
                $pagi_country = $pagi_country->paginate($pagelimit);
        
                $pagi_country->setPath(url(ADMINSEPARATOR.'/language'));
          
                $data['pagi_country']=$pagi_country;
                $data['useinPagiAr']=$useinPagiAr;
                
                //***** pagination code ends
           
                return view('admin.language.languagelist', $data);
        }
    
        public function addlanguage(Request $request,$id=0)
        {
                $data=array();
                $data['data1']="hello";
      
                if(!empty($id))
                {
                        //**** fetch data starts
                        
                        $languagerow = DB::table('language as lc')->where('lc.id', $id)->first();
                        
                        $data['languagerow']=$languagerow;
                        
                        //**** fetch data ends
                }

                return view('admin.language.languageadd', $data);
        }
    
    
        public function savelanguage(Request $request)
        {
                $language_name = addslashes(ucfirst(trim($request->input('language_name',''))));
                $language_3_code = addslashes(strtoupper(trim($request->input('language_3_code',''))));
                $id = addslashes(trim($request->input('languageid',0)));
                
                $dataInsert=array();
                $dataInsert['language_name']=$language_name;
                $dataInsert['language_3_code']=$language_3_code;
                $dataInsert['modified_date']=date('Y-m-d H:i:s');
           
                $chkvalid=$this->checklanguageform($request,$id);
            
                if($chkvalid===true)
                {
                        if(empty($id))
                        {
                                $dataInsert['create_date']=date('Y-m-d H:i:s');
                                
                                //*** insert  query
                                $isInserted = DB::table('language')->insert($dataInsert);
                                
                                /*Last Insert id*/
                                $isInserted=DB::getPdo()->lastInsertId();
                        }
                        else
                        {
                                //*** update query
                                
                                $isInserted=DB::table('language')
                                ->where('id', $id)
                                ->update($dataInsert);
                        }
                 
                        if($isInserted >= 0 )
                        {
                               $request->session()->flash('admin_successmsgdata_sess', 'Language Successfully saved');
                               return redirect(ADMINSEPARATOR.'/language');
                        }
                }
                else
                {
                        if(!empty($id))
                        {
                                return redirect(ADMINSEPARATOR.'/languageadd/'.$id)
                                ->withErrors($chkvalid)
                                ->withInput();
                        }
                        else
                        {
                                return redirect(ADMINSEPARATOR.'/languageadd')
                                ->withErrors($chkvalid)
                                ->withInput();
                        }
                }
           
                return redirect(ADMINSEPARATOR.'/language');
        }
     
        public function checklanguageform($request,$id=0)
        {
                $validator = Validator::make($request->all(),
                        [
                                'language_name' => "required|unique:language,language_name,".$id,
                                'language_3_code' => "required|unique:language,language_3_code,".$id,
                        ],
                        [
                                'language_name.required'=>'*Language name field required',
                                'language_name.countrynameunique'=>'*Language name should be unique',
                                'language_3_code.required'=>'*Language 3 letter code field required',
                                'language_3_code.unique'=>'*Language 3 letter code should be unique',
                        ]
                );
                   
                if ($validator->fails())
                {
                    return $validator;
                }
                    
                return true;
        } 
           
        public function statuschangelanguage(Request $request)
        {       
                $statuschange = $request->input('statuschange',0);
                $languageid =    $request->input('languageid',0);
                //$rt=$statuschange.'======'.$languageid;
                //echo  json_encode($rt);
                //die;
                
                $respAr=array();
                $flagdata=0;
               
                if($languageid!='' && $languageid>0 && in_array($statuschange,array(0,1)))
                {
                        //*** update status starts
                        
                        $dataUpdate=array();
                        $dataUpdate['status']=$statuschange;
                        
                        $updstaus=DB::table('language')
                              ->where('id', $languageid)
                              ->update($dataUpdate);
                              
                         if(!empty($updstaus))
                         {
                                $flagdata=1;
                         }
                        
                        //*** update status ends
                }
               
                $respAr['flag']=$flagdata;
                $respAr['iddata']=$languageid;
                
                //echo  json_encode($dataUpdate);
                //die;
                
                echo  json_encode($respAr);
        }
       
        public function dellanguage(Request $request,$id=0)
        {
                if(empty($id))
                {
                        return redirect(ADMINSEPARATOR.'/language');
                }
           
                $ar=DB::table('language')->where('id', '=', $id)->delete();
           
                if($ar>0)
                {
                        $request->session()->flash('admin_successmsgdata_sess', 'Language has been deleted successfully');  
                }

                return redirect(ADMINSEPARATOR.'/language');
        }
           
}