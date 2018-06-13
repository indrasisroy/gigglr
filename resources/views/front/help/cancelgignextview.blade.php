
							<label>Select event *</label>
							<div class="from-control-custom">
									
								<?php
								$control_attrAr=array();
								$control_attrAr['id']='gigselect';
								$control_attrAr['class']="selectpicker";
								$control_attrAr['title']="Choose the event";
								$gigevent='';
								
								$fetchgigeventArData=array();
								if(!empty($cancel_bookinglist)){
									foreach($cancel_bookinglist as $eventarr){
										$fetchgigeventArData[$eventarr['element']]=$eventarr['content'];
									}
								}
								else{
									$fetchgigeventArData[0]='No event is available';
								}
							  
								echo Form::select('gigselect',
								$fetchgigeventArData,
								$gigevent,
								$control_attrAr
								);							
								?>
									
                            </div>
														
                        