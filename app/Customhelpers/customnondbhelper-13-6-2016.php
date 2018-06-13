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
$chk = urlencode($address);
//$kk='Monirampur+Biswanath+Roy+Road+Barrackpur+West+bengal+India';
$lat ='';
$lng='';
$flag1 ='';
$flag2 = '';
$LatLongArray = array();
$areacodeArray = array();
$getLatlong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address="+'.$chk.'+"&key=AIzaSyDMtfReOBcDyXEUBByLlLgjOkwMKKJw86M');
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

   function getTimezone($lat='',$lng='')
   {
       if($lat!= '' && $lng!='')
       { 
           $gettimezone =file_get_contents('https://maps.googleapis.com/maps/api/timezone/json?location=+'.$lat.','.$lng.'+&timestamp=1331766000&key=AIzaSyDMtfReOBcDyXEUBByLlLgjOkwMKKJw86M');
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
?>