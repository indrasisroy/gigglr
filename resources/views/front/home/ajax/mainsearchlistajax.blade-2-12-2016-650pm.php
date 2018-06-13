<?php

// echo "<pre>"; print_r($mainserch_qry_data);  echo "</pre>";
 if(!empty($mainserch_qry_data))
 {
      foreach($mainserch_qry_data as $mainserch_data)
	  {
					 $artistgroupnenuecommid=$mainserch_data->id;
					 $profile_name=$mainserch_data->profile_name;
					 $type_flag=$mainserch_data->type_flag;
					 $presskit_name=$mainserch_data->presskit_name;
					 $allowedtobook=$mainserch_data->allowedtobook;
					 //$distance=$mainserch_data->distance;
					 $point_perc=$mainserch_data->point_perc;
					   
					 /* if(strlen($profile_name)>10)
					 {
								$profile_name=substr( $profile_name,0,10);	  
					 } */
					 
					 //***** for profile image starts
					 
					// $image_with_pth = asset("front/otherfiles/progimages/"."noimagefound208X201.jpg");
                     $image_with_pth = BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound537X507.png";
          
					 $image_name=$mainserch_data->image_name;
					 if(!empty($image_name) &&  $image_name!="noimage")
					 {
										  if($type_flag==1)
										  {
										  //$image_with_pth=asset('upload/userimage/thumb-medium/'.$image_name);
                                          $image_with_pth=BASEURLPUBLICCUSTOM.'upload/userimage/thumb-big/'.$image_name;
                                          
										  }
										  elseif($type_flag==2)
										  {
										 // $image_with_pth=asset('upload/groupimage/thumb-medium/'.$image_name);
                                          $image_with_pth=BASEURLPUBLICCUSTOM.'upload/groupimage/thumb-big/'.$image_name;
										  }
										  elseif($type_flag==3)
										  {
										  //$image_with_pth=asset('upload/venueimage/thumb-medium/'.$image_name);
                                          $image_with_pth=BASEURLPUBLICCUSTOM.'upload/venueimage/thumb-big/'.$image_name;
										  }
					 }
					 //***** for profile image ends
					 
					 //***** for profile link starts
					
					$profilelinkurl=url('/');
					 if($type_flag==1)
					 {
						  $profilelinkurl.="/artist/".$mainserch_data->seo_name;
				     }
					 elseif($type_flag==2)
					 {
					      $profilelinkurl.="/group/".$mainserch_data->seo_name;
					 }
					  elseif($type_flag==3)
					 {
						 $profilelinkurl.="/venue/".$mainserch_data->seo_name;
					 }
					  //***** for profile link ends
					  
					 
			//***** for category and genre  starts
			
			$category_id='';$category_name='';$genre_id='';$genre_name='';$skillsubskillrel='';
			$category_idAr=array(); $category_nameAr=array(); $genre_idAr=array(); $genre_nameAr=array(); $skillsubskillrelAr=array();
			
			if(!empty($mainserch_data->category_id))
			{
					 $category_id=$mainserch_data->category_id;
					 $category_idAr=explode(",",$category_id);
			}
			if(!empty($mainserch_data->category_name))
			{
					 $category_name=$mainserch_data->category_name;
					 $category_nameAr=explode(",",$category_name);
					 
			}
			if(!empty($mainserch_data->genre_id))
			{
					 $genre_id=$mainserch_data->genre_id;
					 $genre_idAr=explode(",",$genre_id);
			}
			if(!empty($mainserch_data->genre_name))
			{
					 $genre_name=$mainserch_data->genre_name;
					 $genre_nameAr=explode(",",$genre_name);
			}
			if(!empty($mainserch_data->skillsubskillrel))
			{
					 $skillsubskillrel=$mainserch_data->skillsubskillrel;
					 $skillsubskillrelAr=explode(",",$skillsubskillrel);
			}
			
			$categgenAr=array();
			if(!empty($skillsubskillrelAr))
			{
					 foreach($skillsubskillrelAr as $ssardata )
					 {
										  $ssrAr=explode("---",$ssardata);
										  $categdata=$ssrAr[0];
										  $genredata=$ssrAr[1];
										  $categgenAr[]=array("categid"=>$categdata,"genreid"=>$genredata);
										  
					 }
			
			}
			
			
			
			//***** for category and genre  ends
			
			
			//***** for press kit download starts
			
					  $prsskitdwnloadurl=" javascript:void(0); ";
					
					
					 if($presskit_name!="nopresskit")
					 {
										  $prsskitdwnloadurl=url('/');
										  
										  if($type_flag==1)
										  {
											   $prsskitdwnloadurl.="/presskitdownload/".base64_encode($presskit_name);
										  }
										  elseif($type_flag==2)
										  {
											   $prsskitdwnloadurl.="/grouppresskitdownload/".base64_encode($presskit_name);
										  }
										   elseif($type_flag==3)
										  {
											  $prsskitdwnloadurl.="/presskitdownloadvenue/".base64_encode($presskit_name);
										  }
					 }
			
			//***** for press kit download ends
			//***** for book button  starts
			
			
			
			/* $bkprofilelinkurl=" javascript:void(0);";
			if($allowedtobook=='YES')
			{
					 
        	 } */
             
                     $bkprofilelinkurl=url('/');
					 if($type_flag==1)
					 {
						  $bkprofilelinkurl.="/artist/".$mainserch_data->seo_name;
						  $bkprofilelinkurl.="/bk";
				     }
					 elseif($type_flag==2)
					 {
					      $bkprofilelinkurl.="/group/".$mainserch_data->seo_name;
						  $bkprofilelinkurl.="/bk";
					 }
					  elseif($type_flag==3)
					 {
						 $bkprofilelinkurl.="/venue/".$mainserch_data->seo_name;
						 $bkprofilelinkurl.="/bk";
					 }
			
			//***** for book button  ends
			
			
            
            if($point_perc=="0.00")
            {
                 $point_perc ="N/R";
            }
            elseif($point_perc=="100.00")
            {
                 $point_perc ="100%";
            }
            else
            {
                 $point_perc_in_val=intval($point_perc);
                 
                
                 $point_perc = ( $point_perc > $point_perc_in_val ) ? $point_perc."%" :$point_perc_in_val."%"  ;
            }
			
					  
					
?>


                     <div class="col-md-4 col-sm-6 fullbx">
		             <div class="box clearfix newSearch">
		               <a href="<?php echo $profilelinkurl; ?>"  target="_blank" class="pic_side" style="background-image: url({{ $image_with_pth }});" >               
			               <div class="hvr_innr">
			                <span><img src="{{ FRONTCSSPATH}}/images/fav-icon-logo.png" alt=""/></span>
			                <span>view profile</span>
			               </div> 
                           <div class="userNameNw"><?php echo $profile_name; ?></div>
                           <div class="pressKit"><?php echo $point_perc ; ?></div>
		               </a>
                    </div>
                   </div>


                


                    <?php
                    }
}
?>