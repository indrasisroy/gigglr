<div class="col-sm-9">
                                                <h4>Select the artist</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
								$control_attrAr=array();
								$control_attrAr['id']='againstartist';
								$control_attrAr['class']="selectpicker artist_txt";
								$control_attrAr['title']="Choose the event";
								$againstartist_def='';
								
								$fetchagainstartistArData=array();
								if(!empty($against_artist)){
									foreach($against_artist as $againstartist){
										$fetchagainstartistArData[$againstartist['element']]=$againstartist['content'];
									}
								}
								else{
									$fetchagainstartistArData[0]='No event is available';
								}
							  
								echo Form::select('againstartist',
								$fetchagainstartistArData,
								$againstartist_def,
								$control_attrAr
								);							
								?>
                                            </div>