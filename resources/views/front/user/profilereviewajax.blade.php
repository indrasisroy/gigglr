   <div class="container">
   <div class="clearfix revEdit" >
      <h3 class="review_head">Review</h3>
      
<?php  if(!empty($user_testi))
     { ?>

      <div class="radioCheckWrap" style="margin-top: -5px;">
         <!--<select class="selectpicker">-->
         <!--  <option value="">Booker</option>-->
         <!--  <option value="" selected>Artist</option>-->
         <!---->
         <!--</select>-->
       <?php
		        $control_attrAr=array();
	           $control_attrAr['id']='orderbycat';
	           $control_attrAr['class']=" selectpicker ";
	           
	           
	           $orderbycustdataAr=array();
	           $orderbycustdataAr["Artist"]="Artist";
	           $orderbycustdataAr["Booker"]="Booker";

	           

	           $orderbycustdata='Artist';
	           
	           echo Form::select('orderbycat', $orderbycustdataAr, $orderbycustdata,$control_attrAr);
          ?>
        </div>
<?php } ?>
</div>

      <div class="row review_row">
	  <?php
	 if(!empty($user_testi))
     {
       // echo count($user_testi);
	 foreach($user_testi as $userreview)
     {
          $ratingreview = $userreview->rev_param_one+$userreview->rev_param_two+$userreview->rev_param_three;
          $ratinground = $ratingreview/5; 
         if($ratinground>0 && $ratinground<=0.6)
         {
             $points = 1;
        }else if($ratinground>0.6 && $ratinground<=1.2)
         {
              $points = 2;
         }
         else if($ratinground>1.2 && $ratinground<=1.8)
         {
              $points = 3;
         }
         else if($ratinground>1.9 && $ratinground<=2.4)
         {
              $points = 4;
         }
         else if($ratinground>2.4 && $ratinground<=3.0)
         {
              $points = 5;
         }
           
          ?>
         <div class="col-sm-6 review_cols">
          <div class="review_cell clearfix">
   
          <div class="review_img_cell">
            <div class="prodile_img">
				<?php
				   $userimgurl = BASEURLPUBLICCUSTOM.'upload/userimage/thumb-small/'.$userreview->image_name;
				   if($userreview->image_name!='noimage')
					{
					?>
					  <img alt="" src="{{$userimgurl}}">
				<?php	}
					else
					{
					?>
					  <img alt="" src="{{ FRONTCSSPATH}}/otherfiles/progimages/noimagefound52X52.jpg">
				<?php	}
				?>
				</div>
       {{$userreview->showname}}
             </div>
               <div class="review_cont_cell">
             <p>
             {{$userreview->review_description}}
         </p>
                  <div class="clearfix">
         <ul class="review_date">
                   <li>
                       <img src="{{ FRONTCSSPATH}}/images/calender_icon.png" alt="" /> 
                       <?php 
         
                             $review_date =$userreview->review_date;
                             echo   date('j F, Y',strtotime($review_date));
                       ?>
                        </li>
						   
						   <!-- incluede category and genre start-->
						   <?php
						   	
									   echo "<li>".$userreview->category_name.": ".$userreview->genre_name."</li>";
									   
								
						   ?>
						   <!-- incluede category and genre end-->
                 <li>
                     <?php 
         
                             $review_time =$userreview->review_date;
                             echo date('g:i A',strtotime($review_time))." | ";
                       ?>
                      
                          <span class="star_feed">
                             <?php 
                      
                              for($i=0;$i<$points;$i++)
                              {
                              ?> 
                              <img src="{{ FRONTCSSPATH}}/images/yellow_star.png" alt="" /> 

                     <?php
                              }
                              ?>
                        </span>
                </li>
        </ul>
              <div class="form_right">
         <img src="{{ FRONTCSSPATH}}/images/location_icon.png" alt="" />
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
         </div>
    <?php }
	 ?>
	 
	 
	 <?php
	 
	 
	 
	 }else
	 {
	   echo "No Reviews Found";
	 }
          
          
	  ?>
        
      </div>
   </div>
