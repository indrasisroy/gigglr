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

class AdmintooltipController extends Controller
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
                
                $tooltipmsg_db = DB::table('tooltip_message as tm');
                $tooltipmsg_db=$tooltipmsg_db->select(DB::raw('tm.id,tm.tooltip_label,tm.tooltip_message'));
                $tooltipmsg_db=$tooltipmsg_db->where('tm.status',1);
                
                if(!empty($srch1))
                {
                        $tooltipmsg_db=$tooltipmsg_db->where('tm.tooltip_label', 'like', "%".$srch1."%");   
                }
                
                if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
                { 
                        $tooltipmsg_db=$tooltipmsg_db->orderBy('tm.'.$sort1, $sorttype1);
                }
                
                $pagi_amenities=$tooltipmsg_db;
                
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
                
                $pagi_amenities = $pagi_amenities->paginate($pagelimit);
    
                $pagi_amenities->setPath(url(ADMINSEPARATOR.'/tooltipmessages'));
               
                // echo $pagi_banner->count();
                //echo  $pagi_banner->perPage();
                //echo  $pagi_banner->total();           
                //echo "pagi=><pre>";
                //print_r($pagi_banner);
                //echo "</pre>"; exit(); 
              
                $data['pagi_amenities']=$pagi_amenities;
                $data['useinPagiAr']=$useinPagiAr;
                
                //***** pagination code ends
                
                // echo "******<pre>"; echo "******"; echo "</pre>******"; exit();
              
                return view('admin.tooltipmessage.tooltipmessagelist', $data);
        }
    
        public function addtooltipmessages(Request $request,$id=0)
        {
                $data=array();
                $data['data1']="hello";
                $amenities_categAr=array(); $amenities_typeAr=array(); 
                if(!empty($id))
                {
                        //**** fetch data starts
                        
                        $amenitiesrow = DB::table('tooltip_message as tm')->where('tm.id', $id)->first();
                        if(!$amenitiesrow)
                        {
                            return redirect(ADMINSEPARATOR.'/tooltipmessages');
                        }
                        /* echo "<pre>";           
                        print_r($bannerrow);
                        echo "</pre>"; exit();
                        */ 
                        $data['amenitiesrow']=$amenitiesrow;
                        
                        //**** fetch data ends
                }
                return view('admin.tooltipmessage.tooltipmessageadd', $data);
        }
    
    
        public function savetooltip(Request $request)
        {
                $tooltipmessage = addslashes(ucfirst(trim($request->input('tooltipmessage',''))));
                //$status = 0;
                $date_data=date("Y-m-d H:i:s");
                $id = addslashes(trim($request->input('amenitiesid',0)));
                
                $dataInsert=array();
              //  $dataInsert['tooltip_message']=$tooltipmessage;

                $dataInsert['modified_date']=$date_data;
            
                //var_dump($chkvalid); exit();
                // echo "i=>>".$id; exit();
                //$chkvalid=$this->checkamenitiesform($request,$id);
            
                // if($chkvalid===true)
                // {
                      
                
                        // if(empty($id))
                        // {
                        //         $dataInsert['tooltip_message']=$tooltipmessage;                
                        //         $dataInsert['status']=1;
                        //         $dataInsert['create_date']=$date_data;
                        
                              
                        
                        //         //*** insert  query
                        //         $isInserted = DB::table('tooltip_message')->insert($dataInsert);
                                
                        //         /*Last Insert id*/
                        //         $isInserted=DB::getPdo()->lastInsertId();
                        //         // echo "====>".$last_insert_id;
                        // }
                        // else
                        // {
                                //*** update query
                                $dataInsert['tooltip_message']=$tooltipmessage;         
                               
                                $isInserted=DB::table('tooltip_message')
                               ->where('id', $id)
                               ->update($dataInsert);
                               
                             
                        //}
                 
                        if($isInserted >= 0 )
                        {
                                $request->session()->flash('admin_successmsgdata_sess', 'Tooltip message is saved successfully');
                                return redirect(ADMINSEPARATOR.'/tooltipmessages');
                        }
               // }
                // else
                // {
                //         if(!empty($id))
                //         {
                              
                //                 return redirect(ADMINSEPARATOR.'/amenitiesadd/'.$id)
                //                 ->withErrors($chkvalid)
                //                 ->withInput();
                //         }
                //         else
                //         {
                //                 return redirect(ADMINSEPARATOR.'/amenitiesadd')
                //                 ->withErrors($chkvalid)
                //                 ->withInput();
                //         }
                // }
           
                return redirect(ADMINSEPARATOR.'/tooltipmessages');
        }
     
        public function checkamenitiesform($request,$id=0)
        {
                $validator = Validator::make($request->all(), [
                        'amenity_name' => "required|unique:amenity_master,amenity_name,".$id,
                ],[
                        'amenity_name.unique'=>'* Amenity name should be unique',
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
                                $validator->errors()->add('amenity_img', $validatefilechk);
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
                //echo $addeditid."<br><pre>";    print_r($request); exit();
                //echo  "<pre>"; print_r($_FILES); echo  "</pre>"; exit();
                //**** image code starts
                
                $allowedFileExtAr=array();
                //$allowedFileExtAr[]="jpg";
                //$allowedFileExtAr[]="jpeg";
                $allowedFileExtAr[]="png";
                
                $filecontrolname="amenity_img";
               
				$allowedFileExtSizeAr=array();
                //$allowedFileExtSizeAr['jpg']=(50*1024*1024);
                //$allowedFileExtSizeAr['jpeg']=(50*1024*1024);
                $allowedFileExtSizeAr['png']=(50*1024*1024);
				
				//max_width & max_height ,min_width &  min_height,equal_width & equal_height  
				$allowedFileResolAr=array();
				//$allowedFileResolAr['jpeg']=array('min_width'=>1503,'min_height'=>710);
				//$allowedFileResolAr['jpg']=array('min_width'=>1503,'min_height'=>710);
                $allowedFileResolAr['png']=array('equal_width'=>27,'equal_height'=>27);
                
                $func="validatefile";//validatefile/uploadfile
                
                $Imcommonpath=public_path()."/upload/amenities-image/";
                //echo "check=========".$Imcommonpath;die;
                $chkimgresp=Imageuploadlib::imageupload($request,$filecontrolname="amenity_img",$allowedFileExtAr,$allowedFileExtSizeAr,$allowedFileResolAr,$func,$addeditid,$Imcommonpath) ;
                
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
           
        public function statuschangeamenities(Request $request)
        {
                $statuschange = $request->input('statuschange',0);
                $amenitiesid =    $request->input('amenitiesid',0); 
                $respAr=array();
                $flagdata=0;
                
                if(!empty($amenitiesid) && ($amenitiesid>0) && in_array($statuschange,array(0,1)))
                {
                        //*** update status starts
                        
                        $dataUpdate=array();
                        $dataUpdate3=array();
                        $dataUpdate['status']=$statuschange;
                        $updstaus=DB::table('amenity_master')
                              ->where('id', $amenitiesid)
                              ->update($dataUpdate);
                              
                        if(!empty($updstaus))
                        {
                                 $flagdata=1;
                                // $dataUpdate3['status']=0;
                                // $updstaus3 =    DB::table('amenity_master')
                                //                 ->where('id','!=', $amenitiesid)
                                //                 ->update($dataUpdate3);
                                
                                // if(!empty($updstaus3))
                                // {
                                     // $flagdata10=1;  
                               // }
                        }
                        
                        //*** update status ends
                }
                
                $respAr['flag']=$flagdata;
                $respAr['iddata']=$amenitiesid;
                //$respAr['flag10']=$flagdata10;
                
                echo  json_encode($respAr);
        }
       
        public function delamenities(Request $request,$id=0)
        {
                if(empty($id))
                {
                        return redirect(ADMINSEPARATOR.'/amenities');
                }
           
                //**** fetch data starts
                   
                $amenitiesrow = DB::table('amenity_master as am')->where('am.id', $id)->first();
                $prev_amenities_image='';
                if(!empty($amenitiesrow))
                {
                        $prev_amenities_image=stripslashes($amenitiesrow->amenity_img);
                }
                        
                //**** fetch data ends
           
                $ar=DB::table('amenity_master')->where('id', '=', $id)->delete();
         
           
                if($ar>0)
                {
                        //***** unlink image starts
                        $destinationcommonPath=public_path()."/upload/amenities-image/source-file/".$prev_amenities_image;
                        $destinationcommonPath2=public_path()."/upload/amenities-image/thumb-small/".$prev_amenities_image;
                        $destinationcommonPath3=public_path()."/upload/amenities-image/thumb-medium/".$prev_amenities_image;
                        $destinationcommonPath4=public_path()."/upload/amenities-image/thumb-big/".$prev_amenities_image;
                        
                        @unlink($destinationcommonPath);
                        @unlink($destinationcommonPath2);
                        @unlink($destinationcommonPath3);
                        @unlink($destinationcommonPath4);
                        
                        //***** unlink image ends
                     
                        $request->session()->flash('admin_successmsgdata_sess', 'Amenity data is deleted successfully.');  
                }

                return redirect(ADMINSEPARATOR.'/amenities');
        }
  
}