<?php

   function get_client_ip_server()
    {
               $ipAddress = '';

               $chk1=getenv('HTTP_X_FORWARDED_FOR');
               $chk2=('' !== trim(getenv('HTTP_X_FORWARDED_FOR')));
               $chk3=getenv('REMOTE_ADDR');
               $chk4=('' !== trim(getenv('REMOTE_ADDR')));
              
               // Check for X-Forwarded-For headers and use those if found
               if ( ($chk1!=false) && ($chk2!=false)) {
                    
               $ipAddress = trim(getenv('HTTP_X_FORWARDED_FOR'));
               } else {
               if ( ($chk3!=false) && ($chk4!=false)) {
               $ipAddress = trim(getenv('REMOTE_ADDR'));
               }
               }
       
                return $ipAddress;
   }
    //************for address and lat-long starts here
  
  
function getLatLong($address='')
{
  $settingsdatares = getsettingdata();
  $settingsgoogleapi = $settingsdatares->google_api_key ? $settingsdatares->google_api_key : '';

$chk = urlencode($address);
//$kk='Monirampur+Biswanath+Roy+Road+Barrackpur+West+bengal+India';
$lat ='';
$lng='';
$flag1 ='';
$flag2 = '';
$LatLongArray = array();
$areacodeArray = array();
$getLatlong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address="+'.$chk.'+"&key='.$settingsgoogleapi.'');
//echo $getLatlong;
$getOutput= json_decode($getLatlong);

   if($getOutput->status == 'OK')
   {
       $AllLatLongArray = array();
       $singleLatLongArray = array();
       $LatLongArray['flag'] = '1';
        //array_push($LatLongArray,'','','1');
       foreach ($getOutput->results as $result)
       {
           $lat = $result->geometry->location->lat;
           $lng = $result->geometry->location->lng;
           $Lat_long_elements = array("latitude" => $lat, "longitude" => $lng);
           array_push($AllLatLongArray, $Lat_long_elements);
       }
       $LatLongArray['latlong'] = $AllLatLongArray;
       
   }
   else
   {
       $LatLongArray['flag'] = '0';
       $LatLongArray['latlong'] = 'Not Found';
        
   }
   //echo "<pre>";
   //print_r($LatLongArray);
   //echo "</pre>";
   return $LatLongArray;
}

 //**** for reverse geo coding  finding city  rom lat long starts
 
   function getCityNameAr($lati='',$longi='')
  {
    $settingsdatares = getsettingdata();
    $settingsgoogleapi = $settingsdatares->google_api_key ? $settingsdatares->google_api_key : '';
  
  
  //$kk='Monirampur+Biswanath+Roy+Road+Barrackpur+West+bengal+India';
  $lat ='';
  $lng='';
  $flag1 ='';
  $flag2 = '';
  
  $citynameAr=array();
  
  $getLatlong = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lati.",".$longi."&key=".$settingsgoogleapi);
  //echo $getLatlong;
  $getOutput= json_decode($getLatlong);

     if($getOutput->status == 'OK')
     {
      
       $resultsobjAr=$getOutput->results;
      
         if(!empty($resultsobjAr))
         {
            foreach($resultsobjAr as $resultsobj)
            {
                  $address_components=$resultsobj->address_components;
                  
                  
                  
                  if(!empty($address_components))
                  {
                     foreach($address_components as $acobj)
                     {
                        $short_name_data=$acobj->short_name;
                        $citynameAr[]=strtolower($short_name_data);
                     
                     }
                  
                  }
       
            }
         }
       
     }
     else
     {
         $LatLongArray['flag'] = '0';
         $LatLongArray['latlong'] = 'Not Found';
          
     }
     
     if(!empty($citynameAr))
     {
         $citynameAr=array_unique($citynameAr);
     }
     
     
     //echo "--citynameAr--><pre>";
     //             print_r($citynameAr);
     //             echo "</pre>";
                  
     return $citynameAr;
  }
  
 //**** for reverse geo coding  finding city  rom lat long ends



   function getTimezone($lat='',$lng='')
   {

        $settingsdatares = getsettingdata();
        $settingsgoogleapi = $settingsdatares->google_api_key ? $settingsdatares->google_api_key : '';

       if($lat!= '' && $lng!='')
       { 
           $gettimezone =file_get_contents('https://maps.googleapis.com/maps/api/timezone/json?location=+'.$lat.','.$lng.'+&timestamp=1331766000&key='.$settingsgoogleapi.'');
           $gettimezone= json_decode($gettimezone);
            if($gettimezone->status = 'OK')
              {
               $Timezonearray = array("flag" => 1,"timeZoneId" => $gettimezone->timeZoneId, "timeZoneName" => $gettimezone->timeZoneName);
              }
              else
              {
                   $Timezonearray = array("flag" => 0,"timeZoneId" => '', "timeZoneName" => '');
                  
              }
              //echo "<pre>";
              //print_r($Timezonearray);
              //echo "</pre>";
       }
       else
       {
            //echo "Timezone not found";
            $Timezonearray = array("flag" => 0,"timeZoneId" => 'Not Found', "timeZoneName" => 'Not Found');
           
       }
       return $Timezonearray;
   }
   
  //************for address and lat-long ends here
  
  //**** for ajax pagination starts
  
  	 
function paginatecustom($reload, $page, $tpages,$ajaxstatus) {
    
    
        if($tpages<=1)
        {
            return ''; 
        }
    
        $adjacents = ($tpages>6)?6:$tpages;
        $prevlabel = "Prev";
        $nextlabel = "Next";        
        
        $out = "<ul class='pagination_outer_cust'>";
        
        // 1st  page when current page is <= totalpages and total pages is > 1
        if ( ($page > 1)  &&  ($page <=$tpages ) && ($tpages > 1) )
                    {
                        $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page="."1";
                        
                        $out.="<li><a href=\"".$customurl."\" data-page=\""."1"."\">"."First"."</a></li>";
                    }
        
        
        // previous
        if ($page == 1)
        {
             $customurl="javascript:void(0);";
                     
				if($tpages>1)
				{
					  //$out.="<li><a href=\"javascript:void(0);\" data-page=\"nopage\" >".$prevlabel."</a></li>";
					   $out.="";   
				}
				else
				{
						 $out.="";        
				}
            
            $out.="<li><a href=\"".$customurl."\" data-page=\"nopage\">"."First"."</a></li>";
            $out.="<li><a href=\"".$customurl."\" data-page=\"nopage\" >".$prevlabel."</a></li>"; 
            
            
        } elseif ($page == 2)
        {
            $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page=".($page - 1); 
               
            $out.="<li><a href=\"".$customurl."\" data-page=\"".($page - 1)."\" >".$prevlabel."</a></li>";
        }       
        else {
                                           
                    $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page=".($page - 1);            
                    $out.="<li><a href=\"".$customurl."\" data-page=\"".($page - 1)."\" >".$prevlabel."</a></li>";
        }
        
       // $pmin=($page>$adjacents)?($page - $adjacents):1; //($page - $adjacents):1;
       // $pmax=($page<($tpages - $adjacents))?($page + $adjacents):$tpages; //($page + $adjacents):$tpages;
    
        $pmin=1;
        $pmax=1;
    
        if($page  < $tpages)
        {
            
            if($page < $adjacents)
            {
                $pmin=1;
                $pmax=$adjacents;
            }
            else
            {
               $curpageplusadjc=$page+$adjacents;
                
                if($curpageplusadjc > $tpages)
                {
                    $pmin=$tpages-($adjacents-1);
                    $pmax=$tpages;
                }
                else
                {
                    $pmin=$page;
                    $pmax=$curpageplusadjc-1;
                }
                
            }
                     
            
        }
        elseif($page ==$tpages)
        {
            $pmin=$tpages-($adjacents-1);
            $pmax=$tpages;
            
            
        }
        elseif($page > $tpages)
        {
            
        }
      
        // $out.="<li>tpages=>".$tpages."-----pmin=>".$pmin."==pmax=>".$pmax."</li>";
         
        for ($i = $pmin; $i <= $pmax; $i++)
        {
            if ($i == $page)
            {
                
				if($tpages>1)
				{
					  $out.= "<li class=\"active \"><a href='javascript:void(0);' class=\"adjgrt1\" data-page=\"nopage\" >".$i."</a></li>";
				}
				else
				{
						 $out.="";        
				}
                
            } elseif ($i == 1) {
                
                 $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload;
                 
                $out.= "<li><a href=\"".$customurl."\"  class=\"adjeq1\" data-page=\"".$i."\" >".$i."</a></li>";
            } else {
                
                $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload. "&amp;page=".$i;
                
                $out.= "<li><a href=\"".$customurl."\" class=\"adjnoteq1\" data-page=\"".$i."\" >".$i. "</a></li>";
            }
        }
        
       // $cond222=$page<($tpages - $adjacents); echo "==page==>".$page."==pmin=>".$pmin."==pmax==>".$pmax."==cond222==>".$cond222;
        
        // *** ... with last page  structure 
        /* 
        if ($page<($tpages - $adjacents))
        {
            $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page=".$tpages;
            $out.= "<li>...</li><li><a style='font-size:11px' href=\"" .$customurl."\" data-page=\"".$tpages."\" >" .$tpages."</a></li>";
        }
        */
        
        // next
        if ($page < $tpages)
        {
              $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page=".($page + 1);
              
                $out.= "<li><a href=\"".$customurl."\" data-page=\"".($page+1)."\" >".$nextlabel."</a></li>";          
                
                
        }
        else
        {
            $out.= "<li > <a href=\"javascript:void(0);\" data-page=\"nopage\"  >".$nextlabel."</a></li>";
            $out.= "<li > <a href=\"javascript:void(0);\" data-page=\"nopage\"  >Last</a></li>";
            
		   //$out.="";
            
        }
        
       // Last  page when current page is <= totalpages and total pages is > 1
         if (  ($page < $tpages ) && ($tpages > 1) )
            {
                $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page=".$tpages;
                
                $out.="<li><a href=\"".$customurl."\" data-page=\"".$tpages."\" >"."Last"."</a></li>";
            }
        
        
        $out.= "</ul>";
        return $out;
    }
  
  //**** for ajax pagination ends



      function getsettingdata()
            {
              $settingsqry = DB::table('settings')->where('id',1)->first();
              return $settingsqry;

            }
    function cheking_distance($lat1='',$lat2='',$long1='',$long2=''){
     $fAddress = $lat1.",".$long1;
     $sAddress = $lat2.",".$long2;
     
     $goople_distance_api = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$fAddress."&destinations=".$sAddress."&mode=driving&language=en-EN&key=AIzaSyDMtfReOBcDyXEUBByLlLgjOkwMKKJw86M";
     //$goople_distance_api = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=22.5726,88.3639&destinations=28.7041,77.1025&mode=driving&language=en-EN&key=AIzaSyDMtfReOBcDyXEUBByLlLgjOkwMKKJw86M";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $goople_distance_api);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     $response = curl_exec($ch);
     curl_close($ch);
     $response_a = json_decode($response);


     $status = $response_a->rows[0]->elements[0]->status;

     //echo json_encode($response_a);die;

     if ( $status == 'ZERO_RESULTS' )
     {
       
         return FALSE;
     }
     else
     {
         $duration = $response_a->rows[0]->elements[0]->duration->value;
         $distance = $response_a->rows[0]->elements[0]->distance->text;
         //$return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
         $return = array(
          "duration"=>gmdate("H:i:s", $duration),
          "distance"=> rtrim($distance," km")
         );
         return $return;
     }
    }
  
  
?>