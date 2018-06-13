	<?php
	$front_id_sess= session('front_id_sess');
	
	$beforelogincls='';
	if(empty($front_id_sess))
	{
		
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
		
		$imgurldata = "{{ URL::asset('public/front')}}/images/fav-icon-logo.png";
		if(!empty($fetchheaderurldata))
		{
			 
			 $imgurldata = asset('upload/settings-image/source-file/'.$fetchheaderurldata->afterlogin_logo_image);
		}

		
	?>
	
	
	
	
	<div class="navbar navbar-inverse <?php echo $beforelogincls; ?> inrpgHeader" role="navigation">
		<div class="container">
		
		
			<a href="index.html" class="navbar-brand"><img src="{{$imgurldata}}" alt="" /></a>
			
		
	        <div class="navbar-header pull-right">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <!-- <a class="navbar-brand" href="#">Project name</a> -->
	          
	          <div class="headerBtn">
			  
				<?php if(empty($front_id_sess)) { ?>
	          	<button class="btn" data-toggle="modal" data-target="#myModal1"><img src="{{ URL::asset('public/front')}}/images/login.png" alt="" /> Log In</button>
	          	<button class="btn btnSign" data-toggle="modal" data-target="#myModal">Sign Up</button>
				<button class="btnfrgt" data-toggle="modal" data-target="#myModalFrgt" style="display:none;">Forgot password?</button>
				<?php } ?>
				
				<?php if(!empty($front_id_sess)) { ?>
				<!--profile menu after login starts-->
				<div class="prodile_img"><img src="{{ URL::asset('public/front')}}/images/profile_img.jpg" alt="" /></div>
	          	<div class="profile_name dropdown">	          		
	          		 <a data-toggle="dropdown" class="dropdown-toggle" href="#"><span>Hi , Alex Brown <br /> You have $ 130</span> <span class="drop_icon"><img src="{{ URL::asset('public/front')}}/images/arrow_select.png" alt="" /></span></a>
	          		<ul role="menu" class="dropdown-menu">
	          			<li><a href="edit-profile.html">MY Profile</a></li>
	          			<li><a href="#">My Account</a></li>
	          			<li><a href="#" data-toggle="modal" data-target="#myModal3">Wallet</a></li>
	          			<li><a href="<?php echo url('logout'); ?>">Logout</a></li>
	          		</ul>
	          	</div>
				<!--profile menu after login ends-->
				<?php } ?>	
					
	          </div>
	        </div>
				
			
			
	        <div class="collapse navbar-collapse">
	          <ul class="nav navbar-nav">
			 
	            <li class="<?php echo $myaccount_act_cls.$myaccount_dact_cls; ?>" ><a href="#" class="disable">My Account</a></li>
	            <li class="<?php echo  $profile_act_cls.$profile_dact_cls; ?>" ><a href="#" class="disable">My Profile</a></li>
                <li class="<?php echo $myroster_act_cls.$myroster_dact_cls; ?>" ><a href="#" class="disable">My Roster</a></li>
					
	            <li class="<?php echo $search_act_cls.$search_dact_cls; ?>" ><a href="#">Search</a></li>
                <li class="<?php echo $gig_act_cls.$gig_dact_cls; ?>" ><a href="#">Gig Guide</a></li>
                <li class="<?php echo $help_act_cls.$help_dact_cls; ?>" ><a href="<?php echo url("help"); ?>">Help & Support</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
			
			
			
		</div><!-- /.container -->
	</div> <!-- /.navbar -->
   
