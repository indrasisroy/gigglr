<div class="col-sm-9">
                                                <h4>Select the group</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
								$control_attrAr=array();
								$control_attrAr['id']='againstgroup';
								$control_attrAr['class']="selectpicker artist_txt";
								$control_attrAr['title']="Choose the event";
								$againstgroup_def='';
							  
								$fetchagainstgroupArData=array();
								if(!empty($against_group)){
									foreach($against_group as $againstgroup){
										$fetchagainstgroupArData[$againstgroup['element']]=$againstgroup['content'];
									}
								}
								else{
									$fetchagainstgroupArData[0]='No event is available';
								}
							  
								echo Form::select('againstgroup',
								$fetchagainstgroupArData,
								$againstgroup_def,
								$control_attrAr
								);							
								?>
                                            </div>