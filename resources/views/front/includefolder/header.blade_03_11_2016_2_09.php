	<?php
	$bkurldata="";
	$currurldata=url()->current();
	$currurldataAr=explode("/",$currurldata);
	$bkurldata=$currurldata;
	
	$routename=Route::currentRouteName(); // get route name
	 
	 $headerclassnm1=' indexHeader ';
	 
	 if($routename!="frontendhomeroute")
	 {
		$headerclassnm1=' inrpgHeader ';
	 }
	 
	
	?>
	<script>
        var logID = "<?php echo session('front_id_sess')?>";
		var currentbkurl="<?php echo $bkurldata;  ?>";
    </script>
    
    <?php
	$front_id_sess= session('front_id_sess');
	
	$beforelogincls='';
	$headBtnCls = '';
	if(!empty($front_id_sess))
	{
		$headBtnCls = 'pdng0';
	}

	
		$rqst_segmn1=Request::segment(1);
		
		//****  for showing menu item active starts
		
		$myaccount_act_cls=''; $myprofile_act_cls=''; $profile_act_cls='';
		$editprofile_act_cls=''; $myroster_act_cls=''; $search_act_cls='';
		$gig_act_cls=''; $help_act_cls='';
		 
		if( $rqst_segmn1 == 'myaccount' )
		{
			$myaccount_act_cls=' active ';
		}
		elseif( $rqst_segmn1 == 'profile' || $rqst_segmn1 == 'editprofile' )
		{
			$profile_act_cls=' active ';
			
		}
		elseif( $rqst_segmn1 == 'editprofile' )
		{
			
			$editprofile_act_cls=' active ';
		}
		elseif( $rqst_segmn1 == 'myroster' )
		{
			$myroster_act_cls=' active ';
		}
		elseif( $rqst_segmn1 == 'search' )
		{
			$search_act_cls=' active ';
		}
		elseif( $rqst_segmn1 == 'gig' )
		{
			$gig_act_cls=' active ';
		}
		elseif( $rqst_segmn1 == 'help' )
		{
			$help_act_cls=' active ';
		}
		
		//****  for showing menu item active ends
		
		//****  for showing menu item disable starts
		
		$myaccount_dact_cls='';  $profile_dact_cls='';		$myroster_dact_cls='';
		$search_dact_cls=''; $gig_dact_cls=''; $help_dact_cls='';

		if(empty($front_id_sess))
		{
			$myaccount_dact_cls=' disable ';
			$profile_dact_cls=' disable ';
			$myroster_dact_cls=' disable ';
			
		}
		
		
		//****  for showing menu item disable ends
		
		
		
    
		$fetchtype='single'; $tablename="settings";
		$fieldnames="afterlogin_logo_image";
		$wherear=array();
		$wherear['id']=1;
		$orderbyfield="id"; $orderbytype="asc";
		$limitstart=0;$limitend=0;                
		
		$fetchheaderurldata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
		
		//$imgurldata = "{{ URL::asset('public/front')}}/images/fav-icon-logo.png";
		$imgurldata = BASEURLPUBLICCUSTOM."front/images/fav-icon-logo.png";
		if(!empty($fetchheaderurldata))
		{
			 
			// $imgurldata = asset('upload/settings-image/source-file/'.$fetchheaderurldata->afterlogin_logo_image);
			  $imgurldata = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$fetchheaderurldata->afterlogin_logo_image;
		}
		
		
		 //**** fetch  user deafult image starts
		 
                $user_id=$front_id_sess; $image_name='';
				//$image_with_pth=asset("front/otherfiles/progimages/"."noimagefound52X52.jpg");
				$image_with_pth=BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound52X52.jpg";
				
				
                $fetchtype='single'; $tablename="user_master_img";
                $fieldnames=" * ";
                $wherear=array();
                $wherear['user_id']=$user_id;
				$wherear['default_status']=1;
				
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=1;                
                
                $fetchuserimgdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
               
				if(!empty($fetchuserimgdata))
				{
					$image_name=$fetchuserimgdata->image_name;
					
					//$image_with_pth=asset('upload/userimage/thumb-small/'.$image_name);
					$image_with_pth=BASEURLPUBLICCUSTOM.'upload/userimage/thumb-small/'.$image_name;
					
				}
                                
       //**** fetch  user deafult image ends
       
       //**** fetch  user_master starts
		 
                $user_id=$front_id_sess;
                
				$nickname = "";
                
                $fetchtype='single'; $tablename="user_master";
                $fieldnames="nickname,wallet_amount,first_name";
                $wherear=array();
                $wherear['id']=$user_id;
				//$wherear['default_status']=1;
				
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=1;                
                
                $fetchusernickname=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
				 $wallet_amount=0;
				if(!empty($fetchusernickname))
				{
                    $nickname=$fetchusernickname->first_name;
					$wallet_amount=$fetchusernickname->wallet_amount;
				}
                                
       //**** fetch  user_master ends

		
	?>
	
	
	
	
	<div class="navbar navbar-inverse <?php echo $beforelogincls; ?> <?php echo $headerclassnm1; ?>" role="navigation">
		<div class="container">
		
		
			<a href="<?php echo url('');?>" class="navbar-brand"><img src="{{$imgurldata}}" alt="" /></a>
			
		
	        <div class="navbar-header pull-right">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <!-- <a class="navbar-brand" href="#">Project name</a> -->
	          
	          <div class="headerBtn <?php echo $headBtnCls;?>">
			  
				<?php if(empty($front_id_sess)) { ?>
	          	<button class="btn" data-toggle="modal" data-target="#myModal1"><img src="{{ URL::asset('public/front')}}/images/login.png" alt="" /> Log In</button>
	          	<button class="btn btnSign" data-toggle="modal" data-target="#myModal">Sign Up</button>
				<button class="btnfrgt" data-toggle="modal" data-target="#myModalFrgt" style="display:none;">Forgot password?</button>
				<?php } ?>
				
				<?php if(!empty($front_id_sess)) { ?>
				<!--profile menu after login starts-->
				<div class="prodile_img" id="myprodileimgicon"><img src="<?php echo $image_with_pth; ?>" alt="" /></div>
	          	<div class="profile_name dropdown">	          		
	          		 <a data-toggle="dropdown" class="dropdown-toggle" href="#">
					 <span class="myaccountname">Hi ,
                     
                                    <?php
									//if(strlen($nickname)>12){
									//echo substr($nickname,0,12)."...,";
									//}else{
									echo $nickname;
									//}
									?>  
                     </span>
					 <br /> <span id="wallet_amount_id"> You have $<?php echo $wallet_amount; ?></span> <span class="drop_icon"><img src="{{ URL::asset('public/front')}}/images/arrow_select.png" alt="" /></span></a>
	          		<ul role="menu" class="dropdown-menu">
	          			<!--<li><a href="edit-profile.html">MY Profile</a></li>-->
	          			<!--<li><a href="<?php echo url('myaccount'); ?>">My Account</a></li>-->
	          			<li><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal3paymentview">Wallet</a></li>
	          			<li><a href="<?php echo url('logout'); ?>">Log out</a></li>
	          		</ul>
	          	</div>
				<!--profile menu after login ends-->
				<?php } ?>	
					
	          </div>
	        </div>
				
			
			
	        <div class="collapse navbar-collapse">
	          <ul class="nav navbar-nav menu_cstm">
			 
	            <li class="<?php echo $myaccount_act_cls.$myaccount_dact_cls; ?>" ><a href="<?php echo url('myaccount'); ?>">My Account</a></li>
	            <!--<li class="<?php echo  $profile_act_cls.$profile_dact_cls; ?>" ><a href="#" class="disable">My Profile</a>
                    <ul class="dropdown-menu">
                        <li><a href="edit-profile.html">Edit Profile</a></li>
                        <li><a href="#">My Group</a></li>
                        <li><a href="#">Create Venue</a></li>
                    </ul>
                </li>-->
				<?php
					                            
                            $sqlProfileName="SELECT `seo_name` FROM `user_master` WHERE `id`='".$front_id_sess."'";
                            $ProfileName= DB::select( DB::raw($sqlProfileName));
                            if(!empty($ProfileName))
                            {
							
                                $seonamedata=$ProfileName[0]->seo_name;
                                $plink = "javascript:void(0)";
                                if(!empty($seonamedata))
                                {
                                    $plink = url('profile')."/".$ProfileName[0]->seo_name;
                                }
							
                            }else{
							$plink = "javascript:void(0)";
							
							}
							$plinkClass = "";
							if($rqst_segmn1 == "profile" )
							{
								$plinkClass = "active";
							}else if($rqst_segmn1 == "editprofile")
							{
								//alert("Hello");
								$plinkClass = "active";
							}else if($rqst_segmn1 == "group")
							{
								$plinkClass = "active";
							}else if($rqst_segmn1 == "venue-edit")
							{
								$plinkClass = "active";
							}
				?>
                <li class="dropdown <?php echo $myaccount_dact_cls.$plinkClass;?>"><a class="dropdown-toggle" href="<?php echo $plink;?>">My Profile</a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo url('editprofile'); ?>">Edit Profile</a></li>

                           <!-- Checking user have group start-->
                            <?php
                            
                            $sqlGroupName="SELECT `seo_name`,`nickname` FROM `group_master` WHERE `creater_id`='".$front_id_sess."'";
                            $GroupName= DB::select( DB::raw($sqlGroupName));
                            if(!empty($GroupName)){
                            ?>
                            <li><a href="<?php echo url('group')."/".$GroupName[0]->seo_name; ?>">Edit Group</a></li>
                            <?php
                            }else{
                           ?>
                           <li><a href="<?php echo url('group'); ?>">Create Group</a></li>
                           <?php
                            }
                            ?>
                            <!-- Checking user have group end-->
                        <?php
                     
                        $sqlVenueName="SELECT * FROM `venue_master` WHERE `creater_id`='".$front_id_sess."'";
                        $VenueName= DB::select( DB::raw($sqlVenueName));

                        if(empty($VenueName)){ ?>
                        <li><a href="<?php echo url('venue-edit'); ?>">Create Venue</a></li>
                        <?php
                        }
                        else
                        {
                            
                        ?>
                           <li><a href="<?php echo url('venue-edit')."/".$VenueName[0]->seo_name; ?>">Edit Venue</a></li>
                            <?php
                          
                        }
                            ?>
                    </ul>
                 </li>
                    
                <li class="<?php echo $myroster_act_cls.$myroster_dact_cls; ?>" ><a href="<?php echo url('myroster'); ?>">My Roster</a></li>
					
	            <li class="<?php echo $search_act_cls.$search_dact_cls; ?>" ><a href="<?php echo url('/'); ?>">Search</a></li>
                <!--<li class="<?php echo $gig_act_cls.$gig_dact_cls; ?>" ><a href="#">Gig Guide</a></li>-->
				<?php
				$gigguideClass = '';
					if($rqst_segmn1 == "gigguide" ){
						$gigguideClass = 'active';
					}
				?>
                 
				 <li class="dropdown <?php echo $myaccount_dact_cls.$gigguideClass;?>">
				 <?php
					if($front_id_sess!=''){
					?>
					<li class="dropdown <?php echo $myaccount_dact_cls.$gigguideClass;?>">
					<?php					
					}else{
					?>
					<li class="<?php echo $gigguideClass;?>">
					<?php
					}
				 ?>
				 <a class="dropdown-toggle" href="<?php echo url("gigguide"); ?>">Gig Guide</a>
					<?php
					if($front_id_sess!='') {
					?>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0);" id="myModalPostAGig">Post a Gig</a></li>
                    </ul>
					<?php
					}
					?>
                </li>
                    
                <!--<li class="<?php echo $help_act_cls.$help_dact_cls; ?>" ><a href="<?php echo url("help"); ?>">Help & Support</a></li>-->
				<?php
				$helpsupportClass = '';
					if($rqst_segmn1 == "support" ||$rqst_segmn1 == "help" ){
						$helpsupportClass = 'active';
					}
				?>
                <li class="dropdown <?php echo $helpsupportClass;?>"><a class="dropdown-toggle" href="<?php echo url("help"); ?>">Help & Support</a>
                    <ul class="dropdown-menu">
						<li><a href="<?php echo url("support"); ?>">Support</a></li>
						<li><a href="<?php echo url("help"); ?>">Help</a></li>
                    </ul>
 
						
                </li> 
                    
	          </ul>
	        </div><!--/.nav-collapse -->
			
			
			
		</div><!-- /.container -->
	</div> <!-- /.navbar -->
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendGid.js"></script>
	
	<!--<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendmyaccount.js"></script>-->