		<!-- modal for review start -->
	<div class="modal fade" id="reviewPopup" tabindex="-1" role="dialog" >
	  <div class="modal-dialog popup-dialog" role="document">
	    <div class="modal-content popup-content artist_popup">
	      <div class="modal-body popup-body">
	          <div class="artist_hedr" style="background: #ff6364;">
	            <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	             <h2>Leave a Review</h2>
	          </div>
	          <div class="artist_form_outr">
			  				<?php
                  echo Form::open(array('id'=>'reviesubmit_form','class'=>"",'autocomplete'=>'off'));
                ?>
	          	<div class="row">
	          		<div class="profileImgSec">
	          			<div class="person">
                        	<?php
							$image_path = '';
							if($usr_typ == 'booker'){
							  $type_flag = '1';
							  if($booker_data[0]->image_name!=''){
								$image = BASEURLPUBLICCUSTOM."upload/userimage/thumb-medium/".$booker_data[0]->image_name;
							  }else{
								$image = BASEURLPUBLICCUSTOM.'/front/otherfiles/progimages/noimagefound208X201.png';
							  }
							  
							}else if($usr_typ == 'artist'){
							
							  if($type_flag == '1'){
							  
							  if($artist_data[0]->image_name!=''){
								$image = BASEURLPUBLICCUSTOM."upload/userimage/thumb-medium/".$artist_data[0]->image_name;
							  }else{
								$image = BASEURLPUBLICCUSTOM.'/front/otherfiles/progimages/noimagefound208X201.png';
							  }
							  
							  }else if($type_flag == '2'){
							  
								if($artist_data[0]->image_name!=''){
								  $image = BASEURLPUBLICCUSTOM."upload/groupimage/thumb-medium/".$artist_data[0]->image_name;
								}else{
								  $image = BASEURLPUBLICCUSTOM.'/front/otherfiles/progimages/noimagefound208X201.png';
								}
							  
							  }else if($type_flag == '3'){
							  
							  if($artist_data[0]->image_name!=''){
								$image = BASEURLPUBLICCUSTOM."upload/venueimage/thumb-medium/".$artist_data[0]->image_name;
							  }else{
								$image = BASEURLPUBLICCUSTOM.'/front/otherfiles/progimages/noimagefound208X201.png';
							  }
							  
							  }
							}
							?>
                        <img src="<?php echo $image;?>" alt="" />
                        </div>
	          			<div class="prifile_heading">
						
						<?php
                            
                            
                            
						  if($usr_typ == 'booker'){
						  
                              $bkr_fnm=stripslashes($booker_data[0]->first_name);
                              $bkr_mnm=stripslashes($booker_data[0]->middle_name);
                              $bkr_lnm=stripslashes($booker_data[0]->last_name);
                              
                              echo $bkr_fnm.' '.$bkr_mnm.' '.$bkr_lnm;
                              
						      //echo $booker_data[0]->first_name." ".$booker_data[0]->middle_name." ".$booker_data[0]->last_name;
						  
						  }else if($usr_typ == 'artist'){
						  
							//echo "<pre>";print_r($artist_data);die;
							if($type_flag == '1'){
                                $art_fnm=stripslashes($artist_data[0]->first_name);
                                $art_mnm=stripslashes($artist_data[0]->middle_name);
                                $art_lnm=stripslashes($artist_data[0]->last_name);
                                
                                echo $art_fnm.' '.$art_mnm.' '.$art_lnm;
							 // echo $artist_data[0]->first_name." ".$artist_data[0]->middle_name." ".$artist_data[0]->last_name;
                             
                                
							}else if($type_flag == '2'){
                                
                                 $grpn_nknm=stripslashes($artist_data[0]->nickname);
                                  echo $grpn_nknm;
							     //echo $artist_data[0]->nickname;
                                
							  
							}else if($type_flag == '3'){
							
                                 $vnpn_nknm=stripslashes($artist_data[0]->nickname);
                                  echo $vnpn_nknm;
                                //echo $artist_data[0]->nickname;
                                
                                
							}
						  }
						?>
						</div>
	          		</div>
	          		<div class="ratingSec visitor_cols">
						<div class="btn_row">
							<div class="rank_cell">
								
						<?php
						  if($usr_typ == 'booker'){
						  ?>
						  Hospitality
						  <?php
						  }else if($usr_typ == 'artist'){
						  ?>
						  Performance
						  <?php
						  }
						?>
								<div class="star_cell">
									<input class="rateStar performance" type="number" />
								</div>
							</div>
						</div>	
						<div class="btn_row">
							<div class="rank_cell">
								
						<?php
						  if($usr_typ == 'booker'){
						  ?>
						  Environment
						  <?php
						  }else if($usr_typ == 'artist'){
						  ?>
						  Presentation
						  <?php
						  }
						?>
								<div class="star_cell">
									<input class="rateStar presentation" type="number" />
                                    
								</div>
							</div>
						</div>	
						<div class="btn_row">
							<div class="rank_cell">
								
								
						<?php
						  if($usr_typ == 'booker'){
						  ?>
						  Readiness
						  <?php
						  }else if($usr_typ == 'artist'){
						  ?>
						  Punctuality
						  <?php
						  }
						?>
								<div class="star_cell">
									<input class="rateStar punctuality" type="number" />
								</div>
							</div>
						</div>	
					</div>
	          	</div>
	          	
	          	<div class="clearfix leavRvwTime">
					<ul class="review_date">
						<li>
							<img src="<?php echo BASEURLPUBLICCUSTOM.'/front/images/calender_icon.png';?>" alt="">
							
							
							<?php
							echo date('d F, Y', strtotime($gig_date_time))
							?>
						</li>
						<li>
							<?php
							echo date('h.i A', strtotime($gig_date_time))
							?>
						</li>
						<li>
							<span><?php echo $gig_cat;?>:</span> <?php echo $gig_gen;?>
						</li>
					</ul>
					
					<div class="form_right">
						<img src="<?php echo BASEURLPUBLICCUSTOM.'/front/images/location_icon.png';?>" alt=""> <?php echo $gig_city;?>
					</div>
				</div>
				
                <h5>Write your review here:</h5>


				<div class="editorWrap">
				<?php
				$placeholder = "Bare in mind a good review is an objective review.
Use of offensive language will not be tolerated. Offensive remarks
could result in the removal of your review.
Your review could effect peoples livelihoods. Try be to be constructive where possible.
Need help with a dispute?! please report this to us via the Support page.";

				echo Form::textarea("review_description", $value="", [ "id"=>"review_description", "placeholder"=>$placeholder,"class"=>"form-group inpt nb form-control", "maxlength"=>"250" ]);
				
				?>
				</div>
				 <!-- word count for review added 11-03-2017 -->
				  <input type="hidden" id="fieldtocountrosterreviewmodal" value="250">
               	  <p  id="CharCountLabelrosterreviewmodal" ></p>
				 <!-- word count for review added 11-03-2017 -->

				<div class="customBtn-group clearfix">
                	<div class="btnHlfWrap"><button class="btn btn-warning artist_btn reqst_btn" type="button" id="cancelreview">cancel</button></div>
                	<div class="btnHlfWrap"><button class="btn btn-warning artist_btn rqst_trm_btn btn-pink" type="button" id="submitreview">Post Review</button></div>
                </div>
		          <?php
                  echo Form::close();
                  ?>
	          </div>
	      </div>
	    </div>
	  </div>
    </div>
	  <script>
		var usr_typ = "<?php echo $usr_typ;?>";
		var review_flag_type = "<?php echo $type_flag;?>";



		//**************

                    CharacterCountreviewmodalgig = function(){
                        var myField = document.getElementById('review_description');
                        var myLabel = document.getElementById('fieldtocountrosterreviewmodal');
                        var myErrLabel = document.getElementById('CharCountLabelrosterreviewmodal');
                        if(!myField || !myLabel){return false;} // catches errors
                        var MaxChars =  myField.maxLengh;
                        if(!MaxChars){MaxChars =  myField.getAttribute('maxlength'); }    if(!MaxChars){return false;}
                        var remainingChars =   MaxChars - myField.value.length;
                        myErrLabel.innerHTML = remainingChars+" Characters Remaining of Maximum "+MaxChars;
                    };

                    setInterval(function(){
                    CharacterCountreviewmodalgig('review_description','CharCountLabelrosterreviewmodal')},0); 

                           //**************





	  </script>
		<!-- modal for review end -->