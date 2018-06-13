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
use Image;
use App\Customlibrary\Imageuploadlib;

class AdminhomesearchController extends Controller
{
        /**
         * Show the profile for the given user.
         *
         * @param  int  $id
         * @return Response
        */
        
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
                
                $homesearch_db = DB::table('home_search as hs');
                $homesearch_db=$homesearch_db->select(DB::raw('hs.id,hs.title,hs.image_name,hs.image_title,hs.status'));
                //$homesearch_db=$homesearch_db->where('hs.status',1);
                
                if(!empty($srch1))
                {
                        $homesearch_db=$homesearch_db->where('hs.title', 'like', "%".$srch1."%");
                }
                
                if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
                { 
                        $homesearch_db=$homesearch_db->orderBy('hs.'.$sort1, $sorttype1);
                }
                
                $pagi_homesearch=$homesearch_db;
                
                //**** fetch data ends
               
                //***** fetch data from settings table starts
                
                $pagelimit=1;
                $settingrow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();            
                
                if(!empty($settingrow))
                {
                    $pagelimit=$settingrow->record_per_page_admin;
                }
                //***** fetch data from settings table ends
                
                //***** pagination code starts
                
                $pagi_homesearch = $pagi_homesearch->paginate($pagelimit);
    
                $pagi_homesearch->setPath(url(ADMINSEPARATOR.'/homesearch'));
               
                // echo $pagi_banner->count();
                //echo  $pagi_banner->perPage();
                //echo  $pagi_banner->total();           
                //echo "pagi=><pre>";
                //print_r($pagi_banner);
                //echo "</pre>"; exit(); 
              
                $data['pagi_homesearch']=$pagi_homesearch;
                $data['useinPagiAr']=$useinPagiAr;
                
                //***** pagination code ends
                
                // echo "******<pre>"; echo "******"; echo "</pre>******"; exit();
              
                return view('admin.homesearch.homesearchlist', $data);
        }
    
        public function addhomesearch(Request $request,$id=0)
        {
                $data=array();
                $data['data1']="hello";
                $homesearch_categAr=array(); $homesearch_typeAr=array(); 
                if(!empty($id))
                {
                        //**** fetch data starts
                        
                        $homesearchrow = DB::table('home_search as hs')->where('hs.id', $id)->first();

                        if(!$homesearchrow)
                        {
                            return redirect(ADMINSEPARATOR.'/homesearch');
                        }
                        /* echo "<pre>";           
                        print_r($bannerrow);
                        echo "</pre>"; exit();
                        */ 
                        $data['homesearchrow']=$homesearchrow;
                        
                        //**** fetch data ends
                }
                
                //******** fetch country data for drop down starts
        
                $skl_db = DB::table('skill_master as sm');
                $skl_db=$skl_db->select(DB::raw('sm.id,sm.name'));
                $skl_db=$skl_db->where('sm.status', '=', 1);
                $skl_db=$skl_db->where('sm.parent_id', '=', 0);
                $skl_db=$skl_db->orderBy('sm.name', 'asc');
                $skl_db= $skl_db->get();
                $sklIDAr=array();
                $sklIDAr['']="Select a skill";
                if(!empty($skl_db))
                {
                        foreach($skl_db as $skl_obj)
                        {
                                $sklIDAr[$skl_obj->id]=stripslashes($skl_obj->name);
                        }       
                }
                
                $data['homeskillidarr']=$sklIDAr;
        
                //******** fetch skill data for drop down ends
                
                return view('admin.homesearch.homesearchadd', $data);
        }
    
    
        public function savehomesearch(Request $request)
        {
                $home_search_title = addslashes(trim($request->input('homesearch_title','')));
                $home_search_location = addslashes(trim($request->input('homesearch_location','')));
                $home_search_description = addslashes(trim($request->input('homesearch_description','')));
                
                $home_search_skill_id = addslashes(trim($request->input('homesearch_skillid','')));
                $home_search_skill_id = ($home_search_skill_id=="Select a skill")?"":$home_search_skill_id;
                
                $home_search_image_title = addslashes(trim($request->input('homesearch_imagetitle','')));
                
                $id = addslashes(trim($request->input('homesearchid',0)));
                $prev_homesearch_image = addslashes(trim($request->input('prev_homesearch_image','')));
                
                $dataInsert=array();
                
                $dataInsert['title']=$home_search_title;
                $dataInsert['location']=$home_search_location;
                $dataInsert['description']=$home_search_description;
                $dataInsert['skill_id']=$home_search_skill_id;
                $dataInsert['image_title']=$home_search_image_title;
                
                $date_data=date("Y-m-d H:i:s");
                $dataInsert['modified_date']=$date_data;
                
                $chkvalid=$this->checkhomesearchform($request,$id);
                
                if($chkvalid===true)
                {
                        //**** image code starts
                        
                        $allowedFileExtAr=array();
                        $allowedFileExtAr[]="jpg";
                        //$allowedFileExtAr[]="jpeg";
                        //$allowedFileExtAr[]="png";
                        
                        $filecontrolname="homesearch_image";
                       
                        $allowedFileExtSizeAr=array();
                        $allowedFileExtSizeAr['jpg']=(70*1024*1024);
                        //$allowedFileExtSizeAr['jpeg']=(50*1024*1024);
                        //$allowedFileExtSizeAr['png']=(50*1024*1024);
				
                        //max_width & max_height ,min_width &  min_height,equal_width & equal_height  
                        $allowedFileResolAr=array();
                        //$allowedFileResolAr['jpeg']=array('min_width'=>1503,'min_height'=>710);
                        $allowedFileResolAr['jpg']=array('min_width'=>560,'min_height'=>624);
                        //$allowedFileResolAr['png']=array('equal_width'=>27,'equal_height'=>27);
                        
                        $func="uploadfile";//validatefile/uploadfile
                        
                        $Imcommonpath=public_path()."/upload/homesearch-image/source-file/";
                        //echo $Imcommonpath;die;
                        $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="homesearch_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0,$Imcommonpath) ;
                
                        /*
                        echo "==chkimg1==><pre>";
                        print_r($chkimgresp);
                        echo "</pre>"; exit();
                        */
                        if(!empty($chkimgresp))
                        {
                                $errormsgs='';  $fileuploadednames=array();
                        
                                if(array_key_exists('errormsgs',$chkimgresp))
                                {
                                        $errormsgs=$chkimgresp['errormsgs'];
                                }
                        
                                if(array_key_exists('fileuploadednames',$chkimgresp))
                                {
                                        $fileuploadednames=$chkimgresp['fileuploadednames'];
                                }
                        
                                $singleimagename='';$thumbfileName='';
                                
                                if(!empty($fileuploadednames))
                                {
                                        $destinationcommonPath=public_path()."/upload/homesearch-image/";
                                
                                        foreach($fileuploadednames as $fileuploadednameAr)
                                        {
                                       
                                                $thumbfileName=$fileuploadednameAr['filenamedata'];
                                                $sourcepathwithimage=$fileuploadednameAr['fileuploadedpath'].$thumbfileName;
                                               
                                                $destinationfilewithPath1=$destinationcommonPath."thumb-big/".$thumbfileName;
                                               //  echo "==destinationfilewithPath1==>". $destinationfilewithPath1; exit();
                                                $width=560;$height='';
                                              
                                                Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath1,$width,$height);
                                                
                                                $destinationfilewithPath2=$destinationcommonPath."thumb-medium/".$thumbfileName;
                                                $width=560;$height='';
                                              
                                                Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath2,$width,$height);
                                                
                                                $destinationfilewithPath3=$destinationcommonPath."thumb-small/".$thumbfileName;
                                                $width=52;$height=52;
                                              
                                                Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath3,$width,$height);
                                        }
                                
                                        $singleimagename=$thumbfileName;
                                }
                        }
                
                        //**** image code ends
                
                        if(empty($id))
                        {
                                $dataInsert['create_date']=$date_data;
                        
                                if(!empty($singleimagename))
                                {
                                        $dataInsert['image_name']=$singleimagename;
                                }
                        
                                //*** insert  query
                                $isInserted = DB::table('home_search')->insert($dataInsert);
                                
                                /*Last Insert id*/
                                $isInserted=DB::getPdo()->lastInsertId();
                                // echo "====>".$last_insert_id;
                        }
                        else
                        {
                                //*** update query
                        
                                if(!empty($singleimagename))
                                {
                                        $dataInsert['image_name']=$singleimagename;
                                }
                               
                               $isInserted=DB::table('home_search')
                               ->where('id', $id)
                               ->update($dataInsert);
                               
                               if(!empty($singleimagename) && !empty($prev_homesearch_image))
                               {
                                        $destinationcommonPath=public_path()."/upload/homesearch-image/source-file/".$prev_homesearch_image;
                                        $destinationcommonPath2=public_path()."/upload/homesearch-image/thumb-small/".$prev_homesearch_image;
                                        $destinationcommonPath3=public_path()."/upload/homesearch-image/thumb-medium/".$prev_homesearch_image;
                                        $destinationcommonPath4=public_path()."/upload/homesearch-image/thumb-big/".$prev_homesearch_image;
                                        
                                        @unlink($destinationcommonPath);
                                        @unlink($destinationcommonPath2);
                                        @unlink($destinationcommonPath3);
                                        @unlink($destinationcommonPath4);  
                               }
                        }
                 
                        if($isInserted >= 0 )
                        {
                                $request->session()->flash('admin_successmsgdata_sess', 'Home-search data is saved successfully');
                                return redirect(ADMINSEPARATOR.'/homesearch');
                        }
                }
                else
                {
                        if(!empty($id))
                        {
                              
                                return redirect(ADMINSEPARATOR.'/homesearchadd/'.$id)
                                ->withErrors($chkvalid)
                                ->withInput();
                        }
                        else
                        {
                                return redirect(ADMINSEPARATOR.'/homesearchadd')
                                ->withErrors($chkvalid)
                                ->withInput();
                        }
                }
           
                return redirect(ADMINSEPARATOR.'/homesearch');
        }
     
        public function checkhomesearchform($request,$id=0)
        {
                
                $validator = Validator::make($request->all(), [
                        'homesearch_title' => "required|unique:home_search,title,".$id,
                        'homesearch_location' => "required|max:60",
                        'homesearch_description' => "required|max:250",
                        'homesearch_skillid' => "required",
                        'homesearch_imagetitle' => "required|unique:home_search,image_title,".$id,
                ],[
                        'homesearch_title.required' => "* Title field is required",
                        'homesearch_title.unique' => "* This title is already in use. Title should be unique.",
                        'homesearch_location.required' => "* Location field is required",
                        'homesearch_location.max' => "* Location can take maximum 60 characters",
                        'homesearch_description.required' => "* Description field is required",
                        'homesearch_description.max' => "* Description field can take maximum 250 characters",
                        'homesearch_skillid.required' => "* Skill field is required",
                        'homesearch_imagetitle.required' => "* Image title field is required",
                        'homesearch_imagetitle.unique' => "* This image title is already in use. Image title should be unique.",
                ]);
                    
                $userData=array();
                $userData['request']=$request;
                $userData['addeditid']=$id;
                
                $validator->after(function($validator)  use ($userData)  {
                        
                        $request=$userData['request'];
                        $addeditid=$userData['addeditid'];
                      
                        $validatefilechk=$this->fileisinvalid($request,$addeditid);
                        
                        if (!empty($validatefilechk))
                        {
                                $validator->errors()->add('homesearch_image', $validatefilechk);
                        }
                });
                   
                if ($validator->fails())
                {
                        return $validator;   
                }  
                    
                return true;
        } 
        
        public function fileisinvalid($request,$addeditid=0)
        {   
                //echo $addeditid."<br><pre>";    print_r($request); exit();
                //echo  "<pre>"; print_r($_FILES); echo  "</pre>"; exit();
                //**** image code starts
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="jpg";
                //$allowedFileExtAr[]="jpeg";
                //$allowedFileExtAr[]="png";
                
                $filecontrolname="homesearch_image";
               
				$allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['jpg']=(70*1024*1024);
                //$allowedFileExtSizeAr['jpeg']=(50*1024*1024);
                //$allowedFileExtSizeAr['png']=(50*1024*1024);
				
				//max_width & max_height ,min_width &  min_height,equal_width & equal_height  
				$allowedFileResolAr=array();
				//$allowedFileResolAr['jpeg']=array('min_width'=>1503,'min_height'=>710);
				$allowedFileResolAr['jpg']=array('min_width'=>560,'min_height'=>624);
                //$allowedFileResolAr['png']=array('equal_width'=>27,'equal_height'=>27);
                
                $func="validatefile";//validatefile/uploadfile
                
                $Imcommonpath=public_path()."/upload/homesearch-image/";
                //echo "check=========".$Imcommonpath;die;
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="homesearch_image",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$Imcommonpath) ;
                
                //echo "==chkimg1==><pre>";
                //print_r($chkimgresp);
                //echo "</pre>"; exit();
               
                $invalidresp=false;
               
                $errormsgs='';  $fileuploadednames=array();
               
                if(!empty($chkimgresp))
                {
                        if(array_key_exists('errormsgs',$chkimgresp))
                        {
                                $errormsgs=$chkimgresp['errormsgs'];
                        } 
                }
                
                return $errormsgs;
        }
           
        public function statuschangehomesearch(Request $request)
        {
                $statuschange = $request->input('statuschange',0);
                $homesearchid = $request->input('homesearchid',0); 
                $respAr=array();
                $flagdata=0;
                
                if(!empty($homesearchid) && ($homesearchid>0) && in_array($statuschange,array(0,1)))
                {
                        //*** update status starts
                        
                        $dataUpdate=array();
                        $dataUpdate3=array();
                        $dataUpdate['status']=$statuschange;
                        $updstaus=DB::table('home_search')
                              ->where('id', $homesearchid)
                              ->update($dataUpdate);
                              
                        // if(!empty($updstaus))
                        // {
                                $flagdata=1;
                        //         $dataUpdate3['status']=0;
                        //         $updstaus3 =    DB::table('home_search')
                        //                         ->where('id','!=', $homesearchid)
                        //                         ->update($dataUpdate3);
                                
                        //         if(!empty($updstaus3))
                        //         {
                        //               $flagdata10=1;  
                        //         }
                        // }
                        
                        //*** update status ends
                }
                
                $respAr['flag']=$flagdata;
                $respAr['iddata']=$homesearchid;
                //$respAr['flag10']=$flagdata10;
                
                echo  json_encode($respAr);
        }
       
        public function delhomesearch(Request $request,$id=0)
        {
                if(empty($id))
                {
                        return redirect(ADMINSEPARATOR.'/homesearch');
                }
           
                //**** fetch data starts
                   
                $homesearchrow = DB::table('home_search as hs')->where('hs.id', $id)->first();
                $prev_homesearch_image='';
                if(!empty($homesearchrow))
                {
                        $prev_homesearch_image=stripslashes($homesearchrow->image_name);
                }
                        
                //**** fetch data ends
           
                $ar=DB::table('home_search')->where('id', '=', $id)->delete();
         
           
                if($ar>0)
                {
                        //***** unlink image starts
                        $destinationcommonPath=public_path()."/upload/homesearch-image/source-file/".$prev_homesearch_image;
                        $destinationcommonPath2=public_path()."/upload/homesearch-image/thumb-small/".$prev_homesearch_image;
                        $destinationcommonPath3=public_path()."/upload/homesearch-image/thumb-medium/".$prev_homesearch_image;
                        $destinationcommonPath4=public_path()."/upload/homesearch-image/thumb-big/".$prev_homesearch_image;
                        
                        @unlink($destinationcommonPath);
                        @unlink($destinationcommonPath2);
                        @unlink($destinationcommonPath3);
                        @unlink($destinationcommonPath4);
                        
                        //***** unlink image ends
                     
                        $request->session()->flash('admin_successmsgdata_sess', 'Home-search data is deleted successfully.');  
                }

                return redirect(ADMINSEPARATOR.'/homesearch');
        }
  
}