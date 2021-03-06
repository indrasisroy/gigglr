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
  
  //**** for ajax pagination starts
  
  	 
function paginatecustom($reload, $page, $tpages,$ajaxstatus) {
        $adjacents = 2;
        $prevlabel = "&lsaquo; Prev";
        $nextlabel = "Next &rsaquo;";        
        
        $out = "<ul class='pagination_outer_cust'>";
        
        // 1st  page when current page is <= totalpages and total pages is > 1
        if ( ($page > 1)  &&  ($page <=$tpages ) && ($tpages > 1) )
                    {
                        $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page="."1";
                        
                        $out.="<li><a href=\"".$customurl."\" data-page=\""."1"."\">"."First Page"."</a></li>";
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
        } elseif ($page == 2)
        {
            $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page=".($page - 1); 
               
            $out.="<li><a href=\"".$customurl."\" data-page=\"".($page - 1)."\" >".$prevlabel."</a></li>";
        }       
        else {
                                           
                    $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page=".($page - 1);            
                    $out.="<li><a href=\"".$customurl."\" data-page=\"".($page - 1)."\" >".$prevlabel."</a></li>";
        }
        
        $pmin=($page>$adjacents)?($page - $adjacents):1;
        $pmax=($page<($tpages - $adjacents))?($page + $adjacents):$tpages;
        
        for ($i = $pmin; $i <= $pmax; $i++)
        {
            if ($i == $page)
            {
                
				if($tpages>1)
				{
					  $out.= "<li class=\"active\"><a href='javascript:void(0);' data-page=\"nopage\" >".$i."</a></li>";
				}
				else
				{
						 $out.="";        
				}
                
            } elseif ($i == 1) {
                
                 $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload;
                 
                $out.= "<li><a href=\"".$customurl."\" data-page=\"".$i."\" >".$i."</a></li>";
            } else {
                
                $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload. "&amp;page=".$i;
                
                $out.= "<li><a href=\"".$customurl."\" data-page=\"".$i."\" >".$i. "</a></li>";
            }
        }
        
       // $cond222=$page<($tpages - $adjacents); echo "==page==>".$page."==pmin=>".$pmin."==pmax==>".$pmax."==cond222==>".$cond222;
        
        if ($page<($tpages - $adjacents))
        {
            $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page=".$tpages;
            $out.= "<li>...</li><li><a style='font-size:11px' href=\"" .$customurl."\" data-page=\"".$tpages."\" >" .$tpages."</a></li>";
        }
        
        // next
        if ($page < $tpages)
        {
              $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page=".($page + 1);
              
                $out.= "<li><a href=\"".$customurl."\" data-page=\"".($page+1)."\" >".$nextlabel."</a></li>";          
                
                
        }
        else
        {
           // $out.= "<li > <a href=\"javascript:void(0);\" data-page=\"nopage\"  >".$nextlabel."</a></li>";
		   $out.="";
            
        }
        
       // Last  page when current page is <= totalpages and total pages is > 1
         if (  ($page < $tpages ) && ($tpages > 1) )
            {
                $customurl=!empty($ajaxstatus)?"javascript:void(0);":$reload."&amp;page=".$tpages;
                
                $out.="<li><a href=\"".$customurl."\" data-page=\"".$tpages."\" >"."Last Page"."</a></li>";
            }
        
        
        $out.= "</ul>";
        return $out;
    }
  
  //**** for ajax pagination ends
  
  
?>