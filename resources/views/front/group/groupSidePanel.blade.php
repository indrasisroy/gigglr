				<div class="col-sm-04 col-md-3">
					<div class="rightSidebar">
						<button class="sidebar-close-btn"><span aria-hidden="true">&times;</span></button>
						<ul class="leftMenu">
							<li><a href="javascript:void(0)">Dashboard</a></li>
                                <?php
                                $seg = Request::segment(1);
                                $classgroupdashboard = '';
                                $classgroupmemberlist = '';
                                if($seg=="groupdashboard"){
                                $classgroupdashboard ='selected';
                                }else if($seg=="groupmemberlist"){
                                 $classgroupmemberlist ='selected';
                                }
								//*********edit checking start*********
								$edit_seg = Request::segment(2);
								if($edit_seg!=''){
								$str_text = "Edit Group";
								}else{
								$str_text = "Creat Group";
								}
                                //*********edit checking end*********
                                ?>
							<!--<li class="<?php echo $classgroupdashboard;?>"><a href="<?php echo url('groupdashboard'); ?>">Form</a></li>-->
							<li class="preeSelected" id="formPage"><a href="javascript:void(0)"><?php echo $str_text;?></a></li>
							<!--<li class="hasAc"><a href="javascript:void(0);">Profile</a>
								<ul class="leftMentSub">
									<li><a href="#">My account</a></li>
									<li><a href="#">Change Password</a></li>
								</ul>
							</li>-->
							<!--<li class="<?php echo $classgroupmemberlist;?>"><a href="<?php echo url('groupmemberlist'); ?>">User List</a></li>-->
							<li class="preeSelected" id="userList"><a href="javascript:void(0)">Member List</a></li>
								
							<li class="preeSelected" id=""><a href="javascript:void(0)">Request sent to users</a></li>
							<li class="preeSelected" id=""><a href="javascript:void(0)">Declined by the users</a></li>
							<li class="preeSelected" id=""><a href="javascript:void(0)">Chating</a></li>
							<li class="preeSelected" id=""><a href="javascript:void(0)">Booking Request</a></li>
							<li class="preeSelected" id=""><a href="javascript:void(0)">Earnings</a></li>
							<li class="preeSelected" id=""><a href="javascript:void(0)">subadmin of the group</a></li>
							<li class="preeSelected" id=""><a href="javascript:void(0)">Group Calendar</a></li>
							<!--<li class="hasAc"><a href="javascript:void(0);">Lorem</a>
								<ul class="leftMentSub">
									<li><a href="#">Lorem ipsum</a></li>
									<li><a href="#">Change Password</a></li>
								</ul>
							</li>-->
						</ul>
					</div>
				</div>