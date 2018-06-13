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

class AdminbannerController extends Controller
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
            
            $banner_db = DB::table('banner as b');
            $banner_db=$banner_db->select(DB::raw(' b.id,b.title,b.banner_image,b.status '));
           
            if(!empty($srch1))
            {
               $banner_db=$banner_db->where('b.title', 'like', "%".$srch1."%");   
            }
            
            
            if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
            {
                  
                  $banner_db=$banner_db->orderBy('b.'.$sort1, $sorttype1);
            }
            
            
            $pagi_banner=$banner_db;
            
            
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
            
           $pagi_banner = $pagi_banner->paginate($pagelimit);

           $pagi_banner->setPath(url(ADMINSEPARATOR.'/banner'));
           
            // echo $pagi_banner->count();
            //echo  $pagi_banner->perPage();
            //echo  $pagi_banner->total();           
            //echo "pagi=><pre>";
            //print_r($pagi_banner);
            //echo "</pre>"; exit(); 
          
            $data['pagi_banner']=$pagi_banner;
            $data['useinPagiAr']=$useinPagiAr;
            //***** pagination code ends
            
           // echo "******<pre>"; echo "******"; echo "</pre>******"; exit();
          
          return view('admin.banner.bannerlist', $data);
    }
    
    public function addbanner(Request $request,$id=0)
    {
                $data=array();
                $data['data1']="hello";
          
                $banner_categAr=array(); $banner_typeAr=array();
                 
                 if(!empty($id))
                 {
                   //**** fetch data starts
                   
                   $bannerrow = DB::table('banner as b')->where('b.id', $id)->first();
                   
                  /* echo "<pre>";           
                   print_r($bannerrow);
                   echo "</pre>"; exit();
                   */
                   $data['bannerrow']=$bannerrow;
                   //**** fetch data ends
                   
                 }
          
          
          return view('admin.banner.banneradd', $data);
    }
    
    
    public function savebanner(Request $request)
    {
            
            
            $title = addslashes(trim($request->input('title','')));
           
            //$status = 0;
            $date_data=date("Y-m-d H:i:s");
            
            $id = addslashes(trim($request->input('bannerid',0)));
            $prev_banner_image = addslashes(trim($request->input('prev_banner_image','')));
             
           
            $dataInsert=array();
            
            $dataInsert['title']=$title;
            //$dataInsert['status']=$status;
           
            $dataInsert['modified_date']=$date_data;
            
            
            //var_dump($chkvalid); exit();
           // echo "i=>>".$id; exit();
            $chkvalid=$this->checkbannerform($request,$id);
            
           if($chkvalid===true)
           {
                 
                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="jpg";
                $allowedFileExtAr[]="jpeg";
                $allowedFileExtAr[]="png";
                
                $filecontrolname="banner_image";
                
               
				$allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['jpg']=(50*1024*1024);
				$allowedFileExtSizeAr['jpeg']=(50*1024*1024);
                
				
				
				
				//max_width & max_height ,min_width &  min_height,equal_width & equal_height  
				$allowedFileResolAr=array();
				
				$allowedFileResolAr['jpeg']=array('min_width'=>1503,'min_height'=>710);
				$allowedFileResolAr['jpg']=array('min_width'=>1503,'min_height'=>710);
                $func="uploadfile";//validatefile/uploadfile
                
                $Imcommonpath=public_path()."/upload/banner-image/";
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="banner_image",$Imcommonpath,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid=0) ;
                
                
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
                                $destinationcommonPath=public_path()."/upload/banner-image/";
                                
                                foreach($fileuploadednames as $fileuploadednameAr)
                                {
                                       
                                       $thumbfileName=$fileuploadednameAr['filenamedata'];
                                        $sourcepathwithimage=$fileuploadednameAr['fileuploadedpath'].$thumbfileName;
                                        
                                       
                                        $destinationfilewithPath1=$destinationcommonPath."thumb-big/".$thumbfileName;
                                       //  echo "==destinationfilewithPath1==>". $destinationfilewithPath1; exit();
                                        $width=1503;$height=0;
                                      
                                        Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath1,$width,$height);
                                        
                                        $destinationfilewithPath2=$destinationcommonPath."thumb-medium/".$thumbfileName;
                                        $width=150;$height=75;
                                      
                                        Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath2,$width,$height);
                                        
                                        $destinationfilewithPath3=$destinationcommonPath."thumb-small/".$thumbfileName;
                                        $width=50;$height=0;
                                      
                                        Imageuploadlib::createthumb($sourcepathwithimage,$destinationfilewithPath3,$width,$height);
                       
                               
                               
                                }
                                
                               $singleimagename=$thumbfileName;
                                
                        }
                        
               
                
                }
                
                //**** image code ends
                
                
                
                
                
                  if(empty($id))
                  {
                        $dataInsert['title']=$title;
                            
            $dataInsert['status']=0;
                        $dataInsert['create_date']=$date_data;
                        
                        if(!empty($singleimagename))
                        {
                                  $dataInsert['banner_image']=$singleimagename;
                        }
                        
                        
                        //*** insert  query
                        $isInserted = DB::table('banner')->insert($dataInsert);
                        
                        /*Last Insert id*/
                        $isInserted=DB::getPdo()->lastInsertId();
                        // echo "====>".$last_insert_id;
                  
                  }
                  else
                  {
                       
                        //*** update query
                        
                        //echo "<pre>"; print_r($dataInsert); echo $id; exit();
                        
                        
                                if(!empty($singleimagename))
                               {
                                         $dataInsert['banner_image']=$singleimagename;
                               }
                               
                               $isInserted=DB::table('banner')
                               ->where('id', $id)
                               ->update($dataInsert);
                               
                               
                               if(!empty($singleimagename) && !empty($prev_banner_image))
                               {
                                 
                                         $destinationcommonPath=public_path()."/upload/banner-image/source-file/".$prev_banner_image;
                                         $destinationcommonPath2=public_path()."/upload/banner-image/thumb-small/".$prev_banner_image;
                                         $destinationcommonPath3=public_path()."/upload/banner-image/thumb-medium/".$prev_banner_image;
                                         $destinationcommonPath4=public_path()."/upload/banner-image/thumb-big/".$prev_banner_image;
                                         
                                         @unlink($destinationcommonPath);
                                         @unlink($destinationcommonPath2);
                                         @unlink($destinationcommonPath3);
                                         @unlink($destinationcommonPath4);
                                         
                                         
                               }
      
                  }
                  
                 
                  if($isInserted >= 0 )
                  {
                  
                         $request->session()->flash('admin_successmsgdata_sess', 'Banner Successfully saved.');
                         return redirect(ADMINSEPARATOR.'/banner');
                  
                  }
           }
           else
           {
                  if(!empty($id))
                        {
                              
                              return redirect(ADMINSEPARATOR.'/banneradd/'.$id)
                              ->withErrors($chkvalid)
                              ->withInput();
                        }
                        else
                        {
                              return redirect(ADMINSEPARATOR.'/banneradd')
                              ->withErrors($chkvalid)
                              ->withInput();
                        }
           }
           
           return redirect(ADMINSEPARATOR.'/banner');
                  
      
    }
     
    public function checkbannerform($request,$id=0)
           {

                
                            
               
                    $validator = Validator::make($request->all(), [
                   
                    'title' => "required|unique:banner,title,".$id,
                                    
                    
                    ],[
                       
                       'title.unique'=>'* Title should be unique',
                       
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                   
                   // echo "----id==>".$id."here"; exit();
                   
                   
                $userData=array();
                $userData['request']=$request;
                $userData['addeditid']=$id;
                
                $validator->after(function($validator)  use ($userData)  {
                        
                       $request=$userData['request'];
                       $addeditid=$userData['addeditid'];
                      
                        $validatefilechk=$this->fileisinvalid($request,$addeditid);
                        
                        /*echo "==validatefilechk==><pre>";
                        print_r($validatefilechk);
                        echo "</pre>===="; exit();*/
                        
                        if (!empty($validatefilechk))
                        {
                                 $validator->errors()->add('banner_image', $validatefilechk);
                                 
                                 
                                 
                                // echo "<pre>"; print_r($tt); echo "</pre>"; exit();
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
               
                // echo "<pre>";    print_r($request); exit();
                
                
                //**** image code starts
                
                
                $allowedFileExtAr=array();
                $allowedFileExtAr[]="jpg";
                $allowedFileExtAr[]="jpeg";
                
                
                $filecontrolname="banner_image";
                
               
				$allowedFileExtSizeAr=array();
                $allowedFileExtSizeAr['jpg']=(50*1024*1024);
				$allowedFileExtSizeAr['jpeg']=(50*1024*1024);
               
				
				
				
				//max_width & max_height ,min_width &  min_height,equal_width & equal_height  
				$allowedFileResolAr=array();
				
				$allowedFileResolAr['jpeg']=array('min_width'=>1503,'min_height'=>710);
				$allowedFileResolAr['jpg']=array('min_width'=>1503,'min_height'=>710);
                $func="validatefile";//validatefile/uploadfile
                
                $Imcommonpath=public_path()."/upload/banner-image/";
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="banner_image",$Imcommonpath,$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid) ;
                
                
               /*
                echo "==chkimg1==><pre>";
                print_r($chkimgresp);
                echo "</pre>"; exit();
                */
               
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
           
        public function statuschangebanner(Request $request)
       {
          
           
          $statuschange = $request->input('statuschange',0);
          $bannerid =    $request->input('bannerid',0);
          
          $respAr=array();
          $flagdata=0;
          
          
          if(!empty($bannerid) && ($bannerid>0) && in_array($statuschange,array(0,1)))
          {
            
            
                  //*** update status starts
                  $dataUpdate=array();
                  $dataUpdate3=array();
                  $dataUpdate['status']=$statuschange;
                  
                  $updstaus=DB::table('banner')
                        ->where('id', $bannerid)
                        ->update($dataUpdate);
                        
                        if(!empty($updstaus))
                        {
                                $flagdata=1;
                                $dataUpdate3['status']=0;
                                $updstaus3 =    DB::table('banner')
                                                ->where('id','!=', $bannerid)
                                                ->update($dataUpdate3);
                                if(!empty($updstaus3))
                                {
                                      $flagdata10=1;  
                                }
                        }
                  
                  //*** update status ends
          }
          
          $respAr['flag']=$flagdata;
          $respAr['iddata']=$bannerid;
          //$respAr['flag10']=$flagdata10;
          
          echo  json_encode($respAr);
       }
       
        public function delbanner(Request $request,$id=0)
       {
           if(empty($id))
           {
             return redirect(ADMINSEPARATOR.'/banner');
           }
           
                //**** fetch data starts
                   
                        $bannerrow = DB::table('banner as b')->where('b.id', $id)->first();
                        $prev_banner_image='';
                        if(!empty($bannerrow))
                        {
                                $prev_banner_image=stripslashes($bannerrow->banner_image);
                        }
                        
                //**** fetch data ends
           
           $ar=DB::table('banner')->where('id', '=', $id)->delete();
         
           
           if($ar>0)
           {
                        
                
                        //***** unlink image starts
                        $destinationcommonPath=public_path()."/upload/banner-image/source-file/".$prev_banner_image;
                        $destinationcommonPath2=public_path()."/upload/banner-image/thumb-small/".$prev_banner_image;
                        $destinationcommonPath3=public_path()."/upload/banner-image/thumb-medium/".$prev_banner_image;
                        $destinationcommonPath4=public_path()."/upload/banner-image/thumb-big/".$prev_banner_image;
                        
                        @unlink($destinationcommonPath);
                        @unlink($destinationcommonPath2);
                        @unlink($destinationcommonPath3);
                        @unlink($destinationcommonPath4);
                        
                        //***** unlink image ends
                
                 $request->session()->flash('admin_successmsgdata_sess', 'Banner data delete successfully.');  
           }

           return redirect(ADMINSEPARATOR.'/banner');
       }
       
       
       
       
           
           
           
}