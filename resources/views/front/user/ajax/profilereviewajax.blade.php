<?php
	 if(!empty($user_testi))
     {
	//echo "<pre>";
	//  print_r($user_testi);
        //echo count($user_testi);
	 foreach($user_testi as $userreview)
     {
         
        // echo "====<pre>"; print_r($userreview); echo "</pre>======";
	    //exit();
         
        $ratingreview = $userreview->rev_param_one+$userreview->rev_param_two+$userreview->rev_param_three;
		  
		
		
        //  $ratinground = $ratingreview/5; 
         
         
         //$points_new=0;
         //$ratingreview_perc= ($ratingreview/15)*100;
        // if(!empty($ratingreview_perc))
        // {
        //     $points_new=($ratingreview_perc/100)*5;
        // }

         $gigmaster_id_data=$userreview->gigmaster_id;
	    
	    if($userreview->bookertrackerflag=="FROMBOOKER")
	    {
	      $review1=$userreview->rev_param_one;
		 $review2=$userreview->rev_param_two;
           $review3=$userreview->rev_param_three;
	    }
	    elseif($userreview->bookertrackerflag=="NOTFROMBOOKER")
	    {
	     $review1=$userreview->rev_param_one;
	     $review2=$userreview->rev_param_two;
          $review3=$userreview->rev_param_three;
	    }
	    
         
        
	  
          ?>

         <div class="col-sm-6 review_cols">
          <div class="review_cell clearfix">
   
          <div class="review_img_cell">
            <div class="prodile_img" data-gigmaster_id="<?php echo $gigmaster_id_data; ?>">
				<?php
         
                if($userreview->usertype==1)
                {
                     $userimgurl = BASEURLPUBLICCUSTOM.'upload/userimage/thumb-small/'.$userreview->image_name;
                }
                elseif($userreview->usertype==2)
                {
                     $userimgurl = BASEURLPUBLICCUSTOM.'upload/groupimage/thumb-small/'.$userreview->image_name;
                }
                elseif($userreview->usertype==3)
                {
                     $userimgurl = BASEURLPUBLICCUSTOM.'upload/venueimage/thumb-small/'.$userreview->image_name;
                }
         
				  
				   if($userreview->image_name!='noimage')
					{
					?>
					  <img alt="" src="{{$userimgurl}}">
				<?php	}
					else
					{
					?>
					  <img alt="" src="{{ FRONTCSSPATH}}/otherfiles/progimages/noimagefound52X52.png">
				<?php	}
				?>
				</div>
       {{stripslashes($userreview->showname)}}
             </div>
                    <div class="review_cont_cell">
                       
                       <div class="clearfix">
                           <div class="star_feedWrap">
                            <span class="star_feed">
                                <span>
						  <?php
						  if($userreview->bookertrackerflag=="FROMBOOKER"){
							echo "Punctuality";
							}
							else
							{
							  echo "Hospitality";
							}
						 ?>
						  </span>
							<?php
							for($i=1;$i<=$review1;$i++){
							?>
                                  <img src="{{ FRONTCSSPATH}}/images/yellow_star.png" alt=""> 
                                 <?php
						   }
						   ?>
                             </span>
                               <span class="star_feed">
                                <span>
						   <?php
						   if($userreview->bookertrackerflag=="FROMBOOKER"){
							echo "Performance";
							}
							else
							{
							  echo "Environment";
							}
						 ?>
						  </span>
                                 <?php
							for($i=1;$i<=$review2;$i++){
							?>
                                  <img src="{{ FRONTCSSPATH}}/images/yellow_star.png" alt=""> 
                                 <?php
						   }
						   ?>
      
                             </span>
                               <span class="star_feed">
                                <span>
						  <?php
						   if($userreview->bookertrackerflag=="FROMBOOKER"){
							echo "Presentation";
							}
							else
							{
							  echo "Readiness";
							}
						 ?>
						  </span>
                                 <?php
							for($i=1;$i<=$review3;$i++){
							?>
                                  <img src="{{ FRONTCSSPATH}}/images/yellow_star.png" alt=""> 
                                 <?php
						   }
						   ?>
                             </span>
                           </div>
                        <div class="shortDescription">
				    <?php
				    
				    $desc_data=stripslashes($userreview->review_description);
				    $desc_len=strlen($desc_data);
				    ?>
                        <p>
                             {{$desc_data}}
                        </p>
					<?php if($desc_len>120) { ?>
					<a href="javascript:void(0);" class="lsMore">[See Less]</a><a href="javascript:void(0);" class="nwMore">[See More]</a>
						<?php } ?>
                       </div>
                       </div>
                        
                    </div>
                         <div class="clearfix mrgnTopNw fullRow">
                         <ul class="review_date">
                           <li>
                               <img src="{{ FRONTCSSPATH}}/images/calender_icon.png" alt="">
						  <?php 
         
                             $review_date =$userreview->review_date;
                             $review_date_tz=$userreview->review_date_tz; //server tz
                            
                            if(!empty($local_tz))
                            {
    $revdtcnv= convertdatetothistz($dttm=$review_date,$ftmzn=$review_date_tz,$ttmzn=$local_tz,$cnvrtdtdrmt='Y-m-d H:i:s');
                                if(array_key_exists('converteddatetime',$revdtcnv))
                                {
                                    $review_date=$revdtcnv['converteddatetime'];
                                }
                                
                               
                                
                                
                            }
         
                             echo   date('j F, Y',strtotime($review_date));
                        ?>
                                                    </li>

                                   <!-- incluede category and genre start-->
                         <?php
						   	
									   echo "<li>".$userreview->category_name.": ".$userreview->genre_name."</li>";
									   
								
						   ?>			   <!-- incluede category and genre end-->
                           <li>
                            <?php 
         
                             $review_time =$review_date;
                             echo date('g:i A',strtotime($review_time))." | ";
                       ?>                    

                           </li>
                        </ul>
                        <div class="form_right">
                        <img src="{{ FRONTCSSPATH}}/images/location_icon.png" alt="">
                       <?php
				   if($userreview->city=='')
                      {
                      echo "Location not available";
                  }else{
                      echo ucfirst(trans($userreview->city));
                  }
                  ?>    
                        </div>
                   </div>
            </div>
         </div>
    <?php }
	 ?>
	 
	 
	 <?php
	 
	 
	 
	 }else
	 {
	   echo "There have been no reviews yet";
	 }
          
          
	  ?>