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
					   
					 if(strlen($profile_name)>10)
					 {
								$profile_name=substr( $profile_name,0,10);	  
					 }
					 
					 //***** for profile image starts
					 
					// $image_with_pth = asset("front/otherfiles/progimages/"."noimagefound208X201.jpg");
                     $image_with_pth = BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound208X201.jpg";
					 $image_name=$mainserch_data->image_name;
					 if(!empty($image_name) &&  $image_name!="noimage")
					 {
										  if($type_flag==1)
										  {
										  //$image_with_pth=asset('upload/userimage/thumb-medium/'.$image_name);
                                          $image_with_pth=BASEURLPUBLICCUSTOM.'upload/userimage/thumb-medium/'.$image_name;
                                          
										  }
										  elseif($type_flag==2)
										  {
										 // $image_with_pth=asset('upload/groupimage/thumb-medium/'.$image_name);
                                          $image_with_pth=BASEURLPUBLICCUSTOM.'upload/groupimage/thumb-medium/'.$image_name;
										  }
										  elseif($type_flag==3)
										  {
										  //$image_with_pth=asset('upload/venueimage/thumb-medium/'.$image_name);
                                          $image_with_pth=BASEURLPUBLICCUSTOM.'upload/venueimage/thumb-medium/'.$image_name;
										  }
					 }
					 //***** for profile image ends
					 
					 //***** for profile link starts
					
					$profilelinkurl=url('/');
					 if($type_flag==1)
					 {
						  $profilelinkurl.="/profile/".$mainserch_data->seo_name;
				     }
					 elseif($type_flag==2)
					 {
					      $profilelinkurl.="/groupprofile/".$mainserch_data->seo_name;
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
			
			
			
			$bkprofilelinkurl=" javascript:void(0);";
			if($allowedtobook=='YES')
			{
					 $bkprofilelinkurl=url('/');
					 if($type_flag==1)
					 {
						  $bkprofilelinkurl.="/profile/".$mainserch_data->seo_name;
						  $bkprofilelinkurl.="/bk";
				     }
					 elseif($type_flag==2)
					 {
					      $bkprofilelinkurl.="/groupprofile/".$mainserch_data->seo_name;
						  $bkprofilelinkurl.="/bk";
					 }
					  elseif($type_flag==3)
					 {
						 $bkprofilelinkurl.="/venue/".$mainserch_data->seo_name;
						 $bkprofilelinkurl.="/bk";
					 }
        	 }
			
			//***** for book button  ends
			
			
			
					  
					
?>
<div  class="col-md-4 col-sm-6 fullbx" data-typeflag="<?php echo $mainserch_data->type_flag; ?>" data-artistgroupnenuecommid="<?php echo  $artistgroupnenuecommid; ?>" >
		             <div class="box clearfix">
		               <a href="<?php echo $profilelinkurl; ?>" <?php if($allowedtobook=='YES'){ ?> target="_blank" <?php } ?> class="pic_side"  style="background-image: url({{ $image_with_pth }});">               
			               <div class="hvr_innr">
			                <span> <img src="{{ URL::asset('front')}}/images/fav-icon-logo.png" alt=""/></span>
			                <span>view profile</span>
			               </div> 
		               </a>
		               <div class="text_side">
		                 <p><?php echo $profile_name; ?></p>
		                  <!-- <div class="like_box srch_lkebx">
							<a href="#" class="add_link srch_link"><img src="{{ URL::asset('front')}}/images/plus_icon.png" alt="" /></a>
		                        
							<a href="#" class="like_link srch_link"><img src="{{ URL::asset('front')}}/images/heart_icon.png" alt="" /></a>
		                        
							<a href="#" class="calndr_link "><img src="{{ URL::asset('front')}}/images/calender_icon.png" alt="" /></a>
						</div>-->
		                <div class="name_holder srch_nmhldr">
						<?php
						if(!empty($category_idAr))
						{
										  for($ii=0;$ii<count($category_idAr);$ii++)
										  {
										  
										  $categid=$category_idAr[$ii];						
											
						?>
						
						<div class="mainCategory"><?php  echo $category_nameAr[$ii];  ?>:</div>
					 <?php
										   $dispgenrAr=array();
										  for($ss=0; $ss < count($categgenAr); $ss++)
										  {
															  
										  
															   if($categgenAr[$ss]['categid']==$categid)
															   {
											
															   $genreiddata=$categgenAr[$ss]['genreid'];
															   $genreiddata_pos=array_search($genreiddata,$genre_idAr);
											
															   $genrenamedata=$genre_nameAr[$genreiddata_pos];
															   $dispgenrAr[]=$genrenamedata;
															   }
											}
											?>
							<?php if(!empty($dispgenrAr)) { ?>				
							<div class="gener"><?php echo implode(",",$dispgenrAr); ?></div>
					       <?php  } ?>					  
										  <?php
												
					 }
					 ?>
							
						<?php
										  
						}
						
						
						?>				  
						</div>
		                 <div class="buttn_box">
		                   <a href="<?php echo $bkprofilelinkurl; ?>" <?php if($allowedtobook=='YES'){ ?> target="_blank" <?php } ?> class="btn btn-primary artist" type="button">book artist</a>
		                   <a href="<?php echo $prsskitdwnloadurl; ?>" target="_blank" class="btn btn-primary artist press" type="button">Press Kit</a>  
		                 </div>
		                  <div class="rtng_box">
		                   <p class="ratin_box">
		                   rating
		                  </p>
		                   <p class="ratin_cnt_box">
		                   <?php echo $point_perc = ($point_perc=="0.00") ? "N/A" : $point_perc."%"; ?>
		                   </p>
		                  </div>
		               </div>
								
		             </div>
		           </div>
                    <?php
                    }
}
?>