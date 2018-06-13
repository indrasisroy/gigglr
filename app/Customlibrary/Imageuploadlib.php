<?php
namespace App\Customlibrary;

use Illuminate\Http\Request;

use Image;

 class Imageuploadlib  {
    
    //uploadfile/validatefile
    
        public  static function imageupload(Request $request,$filecontrolname="banner_image",$allowedFileExtAr=array(),$allowedFileExtSizeAr=array(),$allowedFileResolAr=array(),$ffnmdata="uploadfile",$id=0,$destinationsourcePath='',$errfilenmAr=array())
        {
            
           
            
            //**** image code starts
                
                /* echo "<pre>";
                    print_r($_FILES);
              echo "</pre>";
              
               echo "<pre>";
                   print_r( $request->file('img1'));
              echo "</pre>"; */
               
                
             
              $fileobjAr=$request->file($filecontrolname);
              
              $fileokobjAr=array();
              
             if(!empty($fileobjAr))
             {
               foreach($fileobjAr as $fileobj )
               {
                    if(!empty($fileobj))
                    {
                        $fileokobjAr[]= $fileobj;
                    }
               }
             }
             
             //echo "<pre>";
             //      print_r( $fileokobjAr);
             // echo "</pre>";
             // 
             //echo " ******** func=>".$ffnmdata;
             
             $errorMsg=array(); $filetouploadobjAr=array();$fileuploadednames=array();
             
             $errfileAr=array(); $totalfileposted=0;
             
          if(($ffnmdata=="validatefile"))
          {
              if ($request->hasFile($filecontrolname))
              {
               
                  //echo "ok present";
                  
                  if(!empty($fileokobjAr))
                  {
                       foreach($fileokobjAr as $kk=> $fileokobj)
                       {
                        
                                                        
                            $errorocflag=0;
                            
                         if ($fileokobj->isValid())
                         {
                                 ++$totalfileposted; 
                                                            
                             /*
                              echo "<br>**** real path =>".$fileokobj->getRealPath();
                              echo "<br>**** original =>".$fileokobj->getClientOriginalName();
                              echo "<br>**** getClientOriginalExtension =>".$fileokobj->getClientOriginalExtension();
                              echo  "<br>****getSize=>".$fileokobj->getSize();
                              echo "<br>*****getMimeType==>".$fileokobj->getMimeType();
                              */
                              
                              $original_uploaded_filename=$fileokobj->getClientOriginalName();
                              
                              $fileextn=$fileokobj->getClientOriginalExtension();
                              $filetmpdata=$fileokobj->getRealPath();
                              $mimedata=$fileokobj->getMimeType();
                              $filesizedata=$fileokobj->getSize(); // bytes
                              
                              //echo "<pre>"; print_r($filesizedata); exit();
                              
                              $width=0;$height=0;$type=0;$attr;$getClientOriginalExtension='';
                              
                             /* $imgextAr=array();
                              $imgextAr[]="jpg";
                              $imgextAr[]="jpeg";
                              $imgextAr[]="png";
                              
                              */
                              
                               $fileextn=strtolower($fileextn);
                              
                              //***** check  file extention
                              if(!empty($allowedFileExtAr))
                              {
                                   
                                    
                                    if(!in_array($fileextn,$allowedFileExtAr))
                                    {
                                        
                                          $errorMsg[]=" The  file \"".$original_uploaded_filename."\" doesn't meets allowed file extention. ";
                                          //list($width, $height, $type, $attr) = getimagesize($filetmpdata);
                                                                            
                                          //echo "<br>width=>>".$width;echo "<br>height=>>".$height;
                                          $errorocflag=1;
                                   
                                    }
                                    
                              }
                              
                               //***** check  file resolution 
                              if(!empty($allowedFileResolAr))
                              {
                                   list($width, $height, $type, $attr) = getimagesize($filetmpdata);
                                   
                                   $resolutionchkarray=array(); // file extention respective resolution array
                                   
                                    if( array_key_exists($fileextn,$allowedFileResolAr) )
                                    {
                                      $resolutionchkarray=$allowedFileResolAr[$fileextn];
                                    }
                                   
                                   if(!empty($resolutionchkarray))
                                   {
                                      if(array_key_exists('max_width',$resolutionchkarray) && ($width>$resolutionchkarray['max_width']))
                                      {
                                      $errorMsg[]=" The  file \"".$original_uploaded_filename."\"  width  exceeds maximum image width.";
                                      $errorocflag=1;
                                      }
                                      
                                      
                                      if(array_key_exists('max_height',$resolutionchkarray) && ($height>$resolutionchkarray['max_height']))
                                      {
                                      $errorMsg[]=" The  file \"".$original_uploaded_filename."\"  height  exceeds maximum image height.";
                                      $errorocflag=1;
                                      }
                                      
                                      
                                      
                                      if(array_key_exists('min_width',$resolutionchkarray) && ($width < $resolutionchkarray['min_width']))
                                      {
                                      $errorMsg[]=" Sorry, but \"".$original_uploaded_filename."\"  is below the allowable image width";
                                      $errorocflag=1;
                                      }
                                      
                                      if(array_key_exists('min_height',$resolutionchkarray) && ($height < $resolutionchkarray['min_height']))
                                      {
                                      $errorMsg[]="Sorry, but \"".$original_uploaded_filename."\"   is below the allowable image height";
                                      $errorocflag=1;
                                      }
                                      
                                      if(array_key_exists('equal_width',$resolutionchkarray) && ($width!=$resolutionchkarray['equal_width']))
                                      {
                                      $errorMsg[]=" The  file \"".$original_uploaded_filename."\"  width  does not meets required image width.";
                                      $errorocflag=1;
                                      }
                                      
                                      if(array_key_exists('equal_height',$resolutionchkarray) && ($height!=$resolutionchkarray['equal_height']))
                                      {
                                      $errorMsg[]=" The  file \"".$original_uploaded_filename."\"  height  does not meets required image height.";
                                      $errorocflag=1;
                                      }
                                    
                                   }
                                   
                                    
                              }
                              
                              
                              //*** check file size
                              if(!empty($allowedFileExtSizeAr))
                              {
                                    $allowedfilesz=0;
                                    if(array_key_exists($fileextn,$allowedFileExtSizeAr))
                                    {
                                      $allowedfilesz=$allowedFileExtSizeAr[$fileextn];
                                      
                                        if($filesizedata>$allowedfilesz)
                                        {
                                           $errorMsg[]=" The  file \"".$original_uploaded_filename."\" exceeds allowed file size. ";
                                           $errorocflag=1;
                                        }
                                      
                                    }
                              }
                             
                          
                          if($errorocflag==1)
                          {
                            $errfileAr[]=$original_uploaded_filename;
                          }
                          
                                        
                                        
                         }
                    } // for each loop ends
               
               }
    
                              }
                              else
                              {
                                      if(empty($id))
                                      {
                                          $errorMsg[]=" File not provided ";
                                      }
                              }
                              
                            
                              
        }
        elseif(($ffnmdata=="uploadfile"))
        {
            //echo  "==filecontrolname==>".$filecontrolname;
                if ($request->hasFile($filecontrolname))
              {
               
                 // echo "ok present inside  uploadfile";
                  
                  if(!empty($fileokobjAr))
                  {
                       foreach($fileokobjAr as $kk=> $fileokobj)
                       {
                         if ($fileokobj->isValid())
                         {
                          
                            ++$totalfileposted;
                              
                             /*
                              echo "<br>**** real path =>".$fileokobj->getRealPath();
                              echo "<br>**** original =>".$fileokobj->getClientOriginalName();
                              echo "<br>**** getClientOriginalExtension =>".$fileokobj->getClientOriginalExtension();
                              echo  "<br>****getSize=>".$fileokobj->getSize();
                              echo "<br>*****getMimeType==>".$fileokobj->getMimeType();
                              */
                              
                              $original_uploaded_filename=$fileokobj->getClientOriginalName();
                              
                              $fileextn=$fileokobj->getClientOriginalExtension();
                              $filetmpdata=$fileokobj->getRealPath();
                              $mimedata=$fileokobj->getMimeType();
                              $filesizedata=$fileokobj->getSize(); // bytes
                              
                               $fileextn=strtolower($fileextn); 
                              
                              //**** upload file code starts
                              
                                  if(!empty($errfilenmAr))
                                  {
                                      if(!in_array($original_uploaded_filename,$errfilenmAr))
                                    {
                                          $fileName=rand().".".$fileextn; 
                                       
                                        $chkmov=$fileokobj->move($destinationsourcePath, $fileName);
                                        
                                        if($chkmov)
                                        {
                                           
                                          $fileuploadednames[]=array('filenamedata'=>$fileName,'fileuploadedpath'=>$destinationsourcePath,'fileextention'=>$fileextn);
                                        }
                                    }
                                  }
                                  else
                                  {
                                      $fileName=rand().".".$fileextn; 
                                       
                                        $chkmov=$fileokobj->move($destinationsourcePath, $fileName);
                                        
                                        if($chkmov)
                                        {
                                           
                                          $fileuploadednames[]=array('filenamedata'=>$fileName,'fileuploadedpath'=>$destinationsourcePath,'fileextention'=>$fileextn);
                                        }
                                  }
                                    
                                        
                              
                                        
                                        
                                       
                                        //echo "<br>==sourcepathwithimage1==>".$sourcepathwithimage;
                                       // echo "<br>"; exit();
                                        
                                        
                                        //**** thumb nail code starts
                                        
                                        /*
                                        $destinationPath2=$destinationcommonPath."thumb-big/".$fileName;
                                        
                                        
                                        Image::make($sourcepathwithimage)
                                        ->resize($width=80,$height=80)
                                        ->save($destinationPath2);
                                        
                                        
                                        $destinationPath3=$destinationcommonPath."thumb-medium/".$fileName;
                                        
                                        
                                        Image::make($sourcepathwithimage)
                                        ->resize($width=80,$height=80)
                                        ->save($destinationPath3);
                                        
                                        
                                        $destinationPath4=$destinationcommonPath."thumb-small/".$fileName;
                                        
                                        
                                        Image::make($sourcepathwithimage)
                                        ->resize($width=80,$height=80)
                                        ->save($destinationPath4);
                                        
                                        
                                        */
                                       //**** thumb nail code ends 
                                        
                                        
                                        //echo "chkupld2==><pre>";
                                        //
                                        //print_r($chkupld2);
                                        //
                                        //echo "</pre>"; exit();
                              
                              
                              
                              
                               //**** upload file code ends
                              
                              
                             
                              
                              
                                        
                                        
                         }
                    }
               
               }
    
                              }
          
        }
                
        
               //**** image code ends
               
         $errorMsgStr='';
         if(!empty($errorMsg))
         {
            
            foreach($errorMsg as $errorMsgData)
            {
              $errorMsgStr.=" <br>".$errorMsgData;
            }
         }
         
         $responseAr=array();
         $responseAr['errormsgs']=$errorMsgStr;
         $responseAr['fileuploadednames']=$fileuploadednames;
         $responseAr['errfileAr']=$errfileAr;
         $responseAr['totalfileposted']=$totalfileposted;
         return  $responseAr;
             
        }
        
        
        public static  function  createthumb($sourcepathwithimage='',$destinationfilewithPath='',$width=0,$height=0)
        {
          
              
               //**** thumb nail code starts
                                        
                     if( (!empty($width) && ($width >0 )) && (!empty($height) && ($height >0 )) )
                     {
                        Image::make($sourcepathwithimage)
                        ->resize($width,$height)
                        ->save($destinationfilewithPath);
                     }
                     elseif( (!empty($width) && ($width >0 )) && (empty($height) ) )
                     {
                     
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        
                         Image::make($sourcepathwithimage)
                        ->resize($width, null, function ($constraint) {
                                              $constraint->aspectRatio();
                                              })
                        ->save($destinationfilewithPath);
                                            
                     }
                      elseif( (!empty($height) && ($height >0 )) && (empty($width) ) )
                     {
                      
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        
                         Image::make($sourcepathwithimage)
                        ->resize(null, $height, function ($constraint) {
                                              $constraint->aspectRatio();
                                              })
                        ->save($destinationfilewithPath);
                                            
                     } 
                  
              
                return true;        
             
          
        }
        
    }

?>