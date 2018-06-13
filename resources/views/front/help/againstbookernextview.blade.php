<div class="col-sm-9">
                                                <h4>Select the booker</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
								$control_attrAr=array();
								$control_attrAr['id']='againstbooker';
								$control_attrAr['class']="selectpicker artist_txt";
								$control_attrAr['title']="Choose the event";
								$againstbooker_def='';
								
								$fetchagainstbookerArData=array();
								if(!empty($against_booker)){
									foreach($against_booker as $againstbooker){
										$fetchagainstbookerArData[$againstbooker['element']]=$againstbooker['content'];
									}
								}
								else{
									$fetchagainstbookerArData[0]='No event is available';
								}
							  
								echo Form::select('againstbooker',
								$fetchagainstbookerArData,
								$againstbooker_def,
								$control_attrAr
								);							
								?>
                                            </div>