				<div class="col-sm-08 col-md-9">
					<div class="rightContent">
					<?php echo Form::open(array('files' => true, 'method' => 'post','id'=>'groupdashbordfrmid','class'=>"" )); ?>
						<?php
						if(!empty($groupDetail)){
						//print_r($groupDetail);
						?>
						<h3>Edit group</h3>
						<?php
						$rqst_segmn1=$groupDetail->seo_name;
						echo Form::hidden('edit_group', $rqst_segmn1, $attributes = array( "id"=>"edit_group"));
						}else{
						?>
						<h3>Dashboard group</h3>
						<?php
						}
						?>
						
						
                                 <div class="inputForum clearfix">
                                    <label>Group name *</label>
                                     <div class="from-control-custom">
									 
                                         <?php 
										 $edtgroup_name='';
										 if(!empty($groupDetail)){
										 if($groupDetail->group_name!=''){
											$edtgroup_name=$groupDetail->group_name;								 
										 }
										 }
										 echo Form::text("group_name", $value=$edtgroup_name, $attributes = array( "id"=>"group_name","class"=>" form-control input-sm parsley-validated "));
										 
										  ?>
                                     </div>
                                </div>
                                 
                                <div class="inputForum clearfix">
                                    <label>Group E-Mail Address *</label>
                                    <div class="from-control-custom">
                                         <?php
										 $edtgroup_email='';
										 if(!empty($groupDetail)){
										 if($groupDetail->group_email!=''){
											$edtgroup_email=$groupDetail->group_email;								 
										 }
										 }
										 echo Form::text("group_email", $value=$edtgroup_email, $attributes = array( "id"=>"group_email","class"=>" form-control input-sm parsley-validated "));
										 
										 ?>
                                     </div>
                                </div>
                                 <div class="inputForum clearfix">
                                    <label>Contact Number *</label>
                                    <div class="from-control-custom">
                                         <?php
										  $editgroup_contact='';
										 if(!empty($groupDetail)){
										 
										 if($groupDetail->group_contact!=''){
											$editgroup_contact=$groupDetail->group_contact;								 
										 }
										 }
										 echo Form::text("group_contact", $value=$editgroup_contact, $attributes = array( "id"=>"group_contact","class"=>" form-control input-sm parsley-validated "));
										 ?>
                                     </div>
                                </div>
                                 <div class="inputForum clearfix">
                                    <label>Group web url *</label>
                                    <div class="from-control-custom">
                                         <?php
										  $editgroup_web_url='';
										 if(!empty($groupDetail)){
										
										 if($groupDetail->group_web_url!=''){
											$editgroup_web_url=$groupDetail->group_web_url;								 
										 }
										 }
										 echo Form::text("group_web_url", $value=$editgroup_web_url, $attributes = array( "id"=>"group_web_url","class"=>" form-control input-sm parsley-validated "));
										 ?>
                                     </div>
                                </div>
                                 <div class="inputForum clearfix">
                                    <label>Address 1 *</label>
                                    <div class="from-control-custom">
                                         <?php
										 $editaddress_1='';
										 if(!empty($groupDetail)){
										 
										 if($groupDetail->address_1!=''){
											$editaddress_1=$groupDetail->address_1;								 
										 }
										 }
										 echo Form::text("address_1", $value=$editaddress_1, $attributes = array( "id"=>"address_1","class"=>" form-control input-sm parsley-validated "));
										 ?>
                                     </div>
                                </div>
                                 <div class="inputForum clearfix">
                                    <label>Address 2</label>
                                   <div class="from-control-custom">
                                         <?php
										 $editaddress_2='';
										 if(!empty($groupDetail)){
										 
										 if($groupDetail->address_2!=''){
											$editaddress_2=$groupDetail->address_2;								 
										 }
										 }
										 echo Form::text("address_2", $value=$editaddress_2, $attributes = array( "id"=>"address_2","class"=>" form-control input-sm parsley-validated "));
										 ?>
                                     </div>
                                </div>
								                                      <div class="clearfix">
                                    <div class="col-custom-xs-6">
									<div class="inputForum clearfix">
                                          <label>Country</label>
										<div class="from-control-custom">
                                        
									<?php
									
									$control_attrAr=array();
									$control_attrAr['id']='select_country';
									$control_attrAr['class']=" selectpicker ";
									$control_attrAr['title']="Select Country";
									
									$fetchskillmasterArData=array();
									
									if(!empty($country)){
									foreach($country as $countryAll){
										$fetchskillmasterArData[$countryAll->id]=$countryAll->country_name;
									}
									
									}
									
									$country='';
									if(!empty($groupDetail)){
										$country=$groupDetail->country;	
									}
									
									
														
									echo Form::select('skill_parent', $fetchskillmasterArData, $country,$control_attrAr);							
									?>
									
                                    </div>
                                    </div>
                                     
                                    </div>
                                     <div class="col-custom-xs-4">
                                        <div class="inputForum clearfix right">
                                              <label>State</label>
												<div class="from-control-custom">
                                                <?php
								
													$control_attrAr=array();
													$control_attrAr['id']='select_state';
													$control_attrAr['class']=" selectpicker ";
													$control_attrAr['title']="Select state";
													
													
													$select_state='';
													$fetchstateData=array();
													
													if(!empty($groupDetail)){
													
														if(!empty($state)){
															foreach($state as $stateAll){
																$fetchstateData[$stateAll->id]=$stateAll->state_name;
															}
														}
														
														if($groupDetail->state!=''){
															$select_state=$groupDetail->state;
														}else{
															$select_state='';
														}
													}
													
													echo Form::select('select_state', $fetchstateData, $select_state,$control_attrAr);							
												?>
                                                </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="clearfix">
                                    <div class="col-custom-xs-6">
                                     <div class="inputForum clearfix">
                                              <label>City</label>
                                               <div class="from-control-custom">
													 <?php
													 $editcity='';
										 if(!empty($groupDetail)){
													
												   if($groupDetail->city!=''){
													  $editcity=$groupDetail->city;								 
												   }
												   }
													 echo Form::text("city", $value=$editcity, $attributes = array( "id"=>"city","class"=>" form-control input-sm parsley-validated "));
													 ?>
                                                 </div>
                                        </div>
                                    </div>
                                    <div class="col-custom-xs-4 col-custom-xs-4-short">
                                    <div class="inputForum clearfix right">
                                        <label>Post Code</label>
                                       <div class="from-control-custom">
                                             <?php
											 $editzip='';
										 if(!empty($groupDetail)){
											 
											if($groupDetail->zip!=''){
											   $editzip=$groupDetail->zip;								 
											}
											}
											 echo Form::text("zip", $value=$editzip, $attributes = array( "id"=>"zip","class"=>" form-control input-sm parsley-validated "));
											
											?>
                                         </div>
                                    </div>
                                    </div> 
                                
                                </div>
                                

                                    
                              <div class="orange-btn-group">
                              	
                              	<div class="clearfix nwBtn">
                              		<!--<a href="#" data-toggle="modal" data-target="#password-apply" class="btn orange-btn">save</a>
									-->
									<button type="button" id="group_submit" class="btn btn-primary">Save</button>
	                                <!-- <a href="javascript:void(0)" data-toggle="modal"  data-target=".password-apply-2" class="btn orange-btn deactive">DEACTIVATE ACCOUNT</a> -->
                              	</div>
                                
                         </div>
                            
					 <?php 	echo Form::close();	?>
					</div>
				</div>
 <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendgroupdashbord.js">