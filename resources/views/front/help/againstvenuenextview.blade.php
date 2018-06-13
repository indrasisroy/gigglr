<div class="col-sm-9">
                                                <h4>Select the venue</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
								$control_attrAr=array();
								$control_attrAr['id']='againstvenue';
								$control_attrAr['class']="selectpicker artist_txt";
								$control_attrAr['title']="Choose the event";
								$againstvenue_def='';
								
								$fetchagainstvenueArData=array();
								if(!empty($against_venue)){
									foreach($against_venue as $againstvenue){
										$fetchagainstvenueArData[$againstvenue['element']]=$againstvenue['content'];
									}
								}
								else{
									$fetchagainstvenueArData[0]='No event is available';
								}
							  
								echo Form::select('againstvenue',
								$fetchagainstvenueArData,
								$againstvenue_def,
								$control_attrAr
								);							
								?>
                                            </div>