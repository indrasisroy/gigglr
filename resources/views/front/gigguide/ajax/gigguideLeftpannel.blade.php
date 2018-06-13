				<div class="event_left_row scrollforrosterleftclass">

				<ul class="event_list">
				<br>
				
				<?php
				//echo "<pre>";print_r($result);die;
				
				if(!empty($result)){
						$dateLast = '';
						
						$textMsg = '';
						$eventtxtData = '';
						
						foreach($result as $guide){
						$iconImage = '';
						$iconImage1 = '';
						$iconImage2 = '';
						$class_return_type = explode(",",$guide['return_type']);
						//print_r($class_return_type);die;
						
						
						//if($guide['return_type'] =='genre_only'){
						
						if(in_array("genre_only", $class_return_type)){
							$iconImage = 'user.png';
							$textMsg = 'has an genre';
							$eventtxtData = ucfirst(trim(stripslashes($guide['artist_name'])))." has an event in ".$guide['event_city']." on ".date('d/m/Y',strtotime($guide['event_start_date_time']));
							
							if(in_array("city_only", $class_return_type)){
								$iconImage1 = 'home.png';
							}
							if(in_array("favorite_only", $class_return_type)){
								$iconImage2 = 'heart_icon2.png';
							}
							
							
							
						}else if(in_array("city_only", $class_return_type)){
							$iconImage = 'home.png';
							$textMsg = 'has an event';
							$eventtxtData = ucfirst(trim(stripslashes($guide['artist_name'])))." has an event in ".$guide['event_city']." on ".date('d/m/Y',strtotime($guide['event_start_date_time']));
							
							if(in_array("genre_only", $class_return_type)){
								$iconImage1 = 'user.png';
							}
							if(in_array("favorite_only", $class_return_type)){
								$iconImage2 = 'heart_icon2.png';
							}
							
						}else if(in_array("favorite_only", $class_return_type)){
						
							$iconImage = 'heart_icon2.png';
							$textMsg = 'has an favorite';
							
							$type_flag = '';
							if($guide['type_flag'] == '1'){
							$type_flag = 'artist';
							}else if($guide['type_flag'] == '2'){
							$type_flag = 'group';
							}
							
							
							$eventtxtData = "Your favorite ".$type_flag." '".ucfirst(trim(stripslashes($guide['artist_name'])))."' has an event in ".$guide['event_city']." on ".date('d/m/Y',strtotime($guide['event_start_date_time']));
							
							if(in_array("city_only", $class_return_type)){
								$iconImage1 = 'home.png';
							}
							//if(in_array("favorite_only", $class_return_type)){
							//	$iconImage2 = 'heart_icon2.png';
							//}
							if(in_array("genre_only", $class_return_type)){
								$iconImage1 = 'user.png';
							}
						}
						
						
						?>
						<h2>
							<?php
							
							if($dateLast != date('F Y',strtotime($guide['event_start_date_time']))){
								$dateLast = date('F Y',strtotime($guide['event_start_date_time']));
								echo $dateLast;
							}
							
							
							?>
						</h2>
						<li>
						<img class="rosterlefticonclass" src="{{ FRONTCSSPATH}}/images/<?php echo $iconImage;?>">
						<?php
						if($iconImage1!=''){
							?>
							<img class="rosterlefticonclass" src="{{ FRONTCSSPATH}}/images/<?php echo $iconImage1;?>">
							<?php
						
						}
						if($iconImage2!=''){
							?>
							<img class="rosterlefticonclass" src="{{ FRONTCSSPATH}}/images/<?php echo $iconImage2;?>">
							<?php
						}
						?>
						<a class="clickGigView" href="javascript:void(0)" data-type_flag='<?php echo $guide['type_flag'];?>' data-gig='<?php echo $guide['giguniqueid'];?>'>
						<?php
						echo $eventtxtData;
						?>
						</a>
						</li>
						<?php
						}
					}
					else{
					echo "<span class='nodatacustlftclass'>Event details display here.</span>";
					}
				?>
				</ul>
				</div>
   <div class="modal fade" id="myModalGuide" tabindex="-1" role="dialog">
      <div class="Guidemodal"></div>		
   </div>