<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Prosessional Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Jquery -->
	<script src="{{ADMINCSSPATH}}/js/jquery-1.10.2.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="{{ ADMINCSSPATH}}/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Font Awesome -->
	<link href="{{ ADMINCSSPATH}}/css/font-awesome.min.css" rel="stylesheet">

	<!-- Pace -->
	<link href="{{ ADMINCSSPATH}}/css/pace.css" rel="stylesheet">	
	
	<!-- Endless -->
	<link href="{{ ADMINCSSPATH}}/css/endless.min.css" rel="stylesheet">
	<link href="{{ ADMINCSSPATH}}/css/endless-skin.css" rel="stylesheet">
	<!-- Website Developer -->
	<!-- <link href="{{ URL::asset('public/commonassets/admindev')}}/css/admindeveloper.css" rel="stylesheet"> -->
	<link href="{{ BASEURLPUBLICCUSTOM.'commonassets/admindev'}}/css/admindeveloper.css" rel="stylesheet">
  </head>

  <body class="overflow-hidden">
	<!-- Overlay Div -->
	<div id="overlay" class="transparent"></div>

	<a href="" id="theme-setting-icon"><i class="fa fa-cog fa-lg"></i></a>
	<div id="theme-setting">
		<div class="title">
			<strong class="no-margin">Skin Color</strong>
		</div>
		<div class="theme-box">
			<a class="theme-color" style="background:#323447" id="default"></a>
			<a class="theme-color" style="background:#efefef" id="skin-1"></a>
			<a class="theme-color" style="background:#a93922" id="skin-2"></a>
			<a class="theme-color" style="background:#3e6b96" id="skin-3"></a>
			<a class="theme-color" style="background:#635247" id="skin-4"></a>
			<a class="theme-color" style="background:#3a3a3a" id="skin-5"></a>
			<a class="theme-color" style="background:#495B6C" id="skin-6"></a>
		</div>
		<div class="title">
			<strong class="no-margin">Sidebar Menu</strong>
		</div>
		<div class="theme-box">
			<label class="label-checkbox">
				<input type="checkbox" checked id="fixedSidebar">
				<span class="custom-checkbox"></span>
				Fixed Sidebar
			</label>
		</div>
	</div><!-- /theme-setting -->
	
	<div id="wrapper" class="preload">
		<div id="top-nav" class="skin-6 fixed">
			<div class="brand">
				<span>Prosessional</span>
				<span class="text-toggle"> Admin</span>
			</div><!-- /brand -->
			<button type="button" class="navbar-toggle pull-left" id="sidebarToggle">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<button type="button" class="navbar-toggle pull-left hide-menu" id="menuToggle">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<ul class="nav-notification clearfix">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-envelope fa-lg"></i>
						<span class="notification-label bounceIn animation-delay4">7</span>
					</a>
					<ul class="dropdown-menu message dropdown-1">
						<li><a>You have 4 new unread messages</a></li>					  
						<li>
							<a class="clearfix" href="#">
								<img src="{{ ADMINCSSPATH}}/img/user.jpg" alt="User Avatar">
								<div class="detail">
									<strong>Admin</strong>
									<p class="no-margin">
										Lorem ipsum dolor sit amet...
									</p>
									<small class="text-muted"><i class="fa fa-check text-success"></i> 27m ago</small>
								</div>
							</a>	
						</li>
						<li>
							<a class="clearfix" href="#">
								<img src="{{ ADMINCSSPATH}}/img/user2.jpg" alt="User Avatar">
								<div class="detail">
									<strong>Admin</strong>
									<p class="no-margin">
										Lorem ipsum dolor sit amet...
									</p>
									<small class="text-muted"><i class="fa fa-check text-success"></i> 5hr ago</small>
								</div>
							</a>	
						</li>
						<li>
							<a class="clearfix" href="#">
								<img src="{{ ADMINCSSPATH}}/img/user.jpg" alt="User Avatar">
								<div class="detail">
									<strong>Bill Doe</strong>
									<p class="no-margin">
										Lorem ipsum dolor sit amet...
									</p>
									<small class="text-muted"><i class="fa fa-reply"></i> Yesterday</small>
								</div>
							</a>	
						</li>
						<li>
							<a class="clearfix" href="#">
								<img src="{{ ADMINCSSPATH}}/img/user2.jpg" alt="User Avatar">
								<div class="detail">
									<strong>Baby Doe</strong>
									<p class="no-margin">
										Lorem ipsum dolor sit amet...
									</p>
									<small class="text-muted"><i class="fa fa-reply"></i> 9 Feb 2013</small>
								</div>
							</a>	
						</li>
						<li><a href="#">View all messages</a></li>					  
					</ul>
				</li>
				<li class="dropdown hidden-xs">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-tasks fa-lg"></i>
						<span class="notification-label bounceIn animation-delay5">4</span>
					</a>
					<ul class="dropdown-menu task dropdown-2">
						<li><a href="#">You have 4 tasks to complete</a></li>					  
						<li>
							<a href="#">
								<div class="clearfix">
									<span class="pull-left">Bug Fixes</span>
									<small class="pull-right text-muted">78%</small>
								</div>
								<div class="progress">
									<div class="progress-bar" style="width:78%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="#">
								<div class="clearfix">
									<span class="pull-left">Software Updating</span>
									<small class="pull-right text-muted">54%</small>
								</div>
								<div class="progress progress-striped">
									<div class="progress-bar progress-bar-success" style="width:54%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="#">
								<div class="clearfix">
									<span class="pull-left">Database Migration</span>
									<small class="pull-right text-muted">23%</small>
								</div>
								<div class="progress">
									<div class="progress-bar progress-bar-warning" style="width:23%"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="#">
								<div class="clearfix">
									<span class="pull-left">Unit Testing</span>
									<small class="pull-right text-muted">92%</small>
								</div>
								<div class="progress progress-striped active">
									<div class="progress-bar progress-bar-danger " style="width:92%"></div>
								</div>
							</a>
						</li>
						<li><a href="#">View all tasks</a></li>					  
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-bell fa-lg"></i>
						<span class="notification-label bounceIn animation-delay6">5</span>
					</a>
					<ul class="dropdown-menu notification dropdown-3">
						<li><a href="#">You have 5 new notifications</a></li>					  
						<li>
							<a href="#">
								<span class="notification-icon bg-warning">
									<i class="fa fa-warning"></i>
								</span>
								<span class="m-left-xs">Server #2 not responding.</span>
								<span class="time text-muted">Just now</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="notification-icon bg-success">
									<i class="fa fa-plus"></i>
								</span>
								<span class="m-left-xs">New user registration.</span>
								<span class="time text-muted">2m ago</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="notification-icon bg-danger">
									<i class="fa fa-bolt"></i>
								</span>
								<span class="m-left-xs">Application error.</span>
								<span class="time text-muted">5m ago</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="notification-icon bg-success">
									<i class="fa fa-usd"></i>
								</span>
								<span class="m-left-xs">2 items sold.</span>
								<span class="time text-muted">1hr ago</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="notification-icon bg-success">
									<i class="fa fa-plus"></i>
								</span>
								<span class="m-left-xs">New user registration.</span>
								<span class="time text-muted">1hr ago</span>
							</a>
						</li>
						<li><a href="#">View all notifications</a></li>					  
					</ul>
				</li>
				<li class="profile dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<strong>Admin</strong>
						<span><i class="fa fa-chevron-down"></i></span>
					</a>
					<ul class="dropdown-menu">
						<!--<li>
							<a class="clearfix" href="#">
								<img src="{{ ADMINCSSPATH}}/img/user.jpg" alt="User Avatar">
								<div class="detail">
									<strong>John Doe</strong>
									<p class="grey">John_Doe@email.com</p> 
								</div>
							</a>
						</li>-->
						<!--<li><a tabindex="-1" href="profile.html" class="main-link"><i class="fa fa-edit fa-lg"></i> Edit profile</a></li>
						<li><a tabindex="-1" href="gallery.html" class="main-link"><i class="fa fa-picture-o fa-lg"></i> Photo Gallery</a></li>-->
						<!--<li><a tabindex="-1" href="#" class="theme-setting"><i class="fa fa-cog fa-lg"></i> Setting</a></li>-->
						<li class="divider"></li>
						<li><a tabindex="-1" class="main-link" href="<?php echo url(ADMINSEPARATOR.'/editprofileadmin')?>"><i class="fa fa-pencil fa-fw"></i> Edit profile</a></li>
						<li><a tabindex="-1" class="main-link logoutConfirm_open" href="#"><i class="fa fa-lock fa-lg"></i> Log out</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /top-nav-->
		
		<aside class="fixed skin-6">	
			<div class="sidebar-inner scrollable-sidebar">
				<div class="size-toggle">
					<a class="btn btn-sm" id="sizeToggle">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="btn btn-sm pull-right logoutConfirm_open"  href="#logoutConfirm">
						<i class="fa fa-power-off"></i>
					</a>
				</div><!-- /size-toggle -->	
				{{-- <div class="user-block clearfix">
					<img src="{{ ADMINCSSPATH}}/img/user.jpg" alt="User Avatar">
					<div class="detail">
						<strong>John Doe</strong><span class="badge badge-danger bounceIn animation-delay4 m-left-xs">4</span>
						<ul class="list-inline">
							<li><a href="profile.html">Profile</a></li>
							<li><a href="inbox.html" class="no-margin">Inbox</a></li>
						</ul>
					</div>
				</div><!-- /user-block --> 
				<div class="search-block">
					<!--<div class="input-group">
						<input type="text" class="form-control input-sm" placeholder="search here...">
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
						</span>
					</div>--><!-- /input-group -->
				</div> <!-- /search-block --> --}}
				<div class="main-menu">
				<?php
				$adminroutename = \Route::currentRouteName();
				?>
					<ul>
					<?php
					
					$dash_actv='';
					$adrouteAr=array();
					$adrouteAr[]="admindashboardroute";
					if(in_array($adminroutename,$adrouteAr))
					{$dash_actv="active"; }
					?>
						<li class="<?php echo $dash_actv; ?>">
							<a href="<?php echo url(ADMINSEPARATOR);?>">
								<span class="menu-icon">
									<i class="fa fa-desktop fa-lg"></i> 
								</span>
								<span class="text">
									Dashboard
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>	 
						<?php					
					$dash_actv='';
					$adrouteAr=array();
					$adrouteAr[]="adminsettingsroute";
					if(in_array($adminroutename,$adrouteAr))
					{$dash_actv="active"; }
					?>  
						  <li class="openable <?php echo $dash_actv; ?>">
							<a href="#">
								<span class="menu-icon">
									<i class="fa fa-cog fa-lg"></i> 
								</span>
								<span class="text">
									Settings
								</span>
								<span class="badge badge-success bounceIn animation-delay5"></span>
								<span class="menu-hover"></span>
							</a>
							<ul class="submenu">
								<li>
									<a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/settings')?>">
									<span class="submenu-label">Settings </span>
									  </a>
								</li>
							</ul>							  
						</li>
					<?php					
					$dash_actv='';
					$adrouteAr=array();
					$adrouteAr[]="adminarticleroute";
					$adrouteAr[]="adminarticleaddroute";
					if(in_array($adminroutename,$adrouteAr))
					{$dash_actv="active"; }
					?>	  
						<li class="<?php echo $dash_actv; ?>">
							<a href="<?php echo url(ADMINSEPARATOR.'/article');?>">
								<span class="menu-icon">
									<i class="fa fa-file-text fa-lg"></i> 
								</span>
								<span class="text">
									Article
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						<?php					
					$dash_actv='';
					$adrouteAr=array();
					$adrouteAr[]="adminemailroute";
					$adrouteAr[]="adminemailaddroute";
					if(in_array($adminroutename,$adrouteAr))
					{$dash_actv="active"; }
					?>  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/email-template');?>">
								<span class="menu-icon">
									<i class="fa fa-file-text fa-lg"></i> 
								</span>
								<span class="text">
									Email Template
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
					<?php					
					$dash_actv='';
					$adrouteAr=array();
					$adrouteAr[]="admincountryroute";
					$adrouteAr[]="admincountryaddroute";
					if(in_array($adminroutename,$adrouteAr))
					{$dash_actv="active"; }
					?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/country');?>">
								<span class="menu-icon">
									<i class="fa fa-flag fa-lg"></i> 
								</span>
								<span class="text">
									Country
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						  
						<?php					
					$dash_actv='';
					$adrouteAr=array();
					$adrouteAr[]="adminstateroute";
					$adrouteAr[]="adminstateaddroute";
					if(in_array($adminroutename,$adrouteAr))
					{$dash_actv="active"; }
					?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/state');?>">
								<span class="menu-icon">
									<i class="fa fa-flag fa-lg"></i> 
								</span>
								<span class="text">
									State
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						  
						<?php					
					$dash_actv='';
					$adrouteAr=array();
					$adrouteAr[]="adminuserroute";
					$adrouteAr[]="adminuseraddroute";
					if(in_array($adminroutename,$adrouteAr))
					{$dash_actv="active"; }
					?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/user');?>">
								<span class="menu-icon">
									<i class="fa fa-user fa-lg"></i> 
								</span>
								<span class="text">
									User
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						  
						<?php					
					$dash_actv='';
					$adrouteAr=array();
					$adrouteAr[]="adminskillroute";
					$adrouteAr[]="adminskilladdroute";
					if(in_array($adminroutename,$adrouteAr))
					{$dash_actv="active"; }
					?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/skill');?>">
								<span class="menu-icon">
									<i class="fa fa-user fa-lg"></i> 
								</span>
								<span class="text">
									Skill
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						  
						<?php					
						  $dash_actv='';
						  $adrouteAr=array();
						  $adrouteAr[]="adminpackageroute";
						  $adrouteAr[]="adminpackageaddroute";
						  if(in_array($adminroutename,$adrouteAr))
						  {$dash_actv="active"; }
						?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/package');?>">
								<span class="menu-icon">
									<i class="fa fa-briefcase"></i> 
								</span>
								<span class="text">
									Package
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						  
						 
						<?php					
						  $dash_actv='';
						  $adrouteAr=array();
						  $adrouteAr[]="adminbanneroute";
						  $adrouteAr[]="adminbanneraddroute";
						  if(in_array($adminroutename,$adrouteAr))
						  {$dash_actv="active"; }
						?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/banner');?>">
								<span class="menu-icon">
									<i class="fa fa-picture-o"></i> 
								</span>
								<span class="text">
									Banner
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>  
						  
						  
						  
						  
						<?php					
						  $dash_actv='';
						  $adrouteAr=array();
						  $adrouteAr[]="adminlanguageroute";
						  $adrouteAr[]="adminlanguageaddroute";
						  if(in_array($adminroutename,$adrouteAr))
						  {$dash_actv="active"; }
						?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/language');?>">
								<span class="menu-icon">
									<i class="fa fa-exclamation"></i> 
								</span>
								<span class="text">
									Language
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						  
						  <?php					
						  $dash_actv='';
						  $adrouteAr=array();
						  $adrouteAr[]="adminassociationroute";
						  $adrouteAr[]="adminassociationaddroute";
						  if(in_array($adminroutename,$adrouteAr))
						  {$dash_actv="active"; }
						?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/association');?>">
								<span class="menu-icon">
									<i class="fa fa-arrows"></i> 
								</span>
								<span class="text">
									Association
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						  
						  <!--Help-->

						  
						<?php					
						$dash_actv='';
						$adrouteAr=array();
						$adrouteAr[]="adminsupportbypageroute";
						$adrouteAr[]="adminhowitsdoneroute";
						if(in_array($adminroutename,$adrouteAr))
						{$dash_actv="active"; }
						?>  
							  <li class="openable <?php echo $dash_actv; ?>">
								<a href="#">
									<span class="menu-icon">
										<i class="fa fa-cog fa-lg"></i> 
									</span>
									<span class="text">
										Help
									</span>
									<span class="badge badge-success bounceIn animation-delay5"></span>
									<span class="menu-hover"></span>
								</a>
								<ul class="submenu">
								<?php					
								$dash_actv='';
								$adrouteAr=array();
								$adrouteAr[]="adminsupportbypageroute";
								if(in_array($adminroutename,$adrouteAr))
								{$dash_actv="active"; }
								?> 
									<li class="<?php echo $dash_actv; ?>">
										<a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/supportbypage')?>">
										<span class="submenu-label">Support By Page </span>
										  </a>
									</li>
									  <?php					
									  $dash_actv='';
									  $adrouteAr=array();
									  $adrouteAr[]="adminhowitsdoneroute";
									  if(in_array($adminroutename,$adrouteAr))
									  {$dash_actv="active"; }
									  ?> 
									<li class="<?php echo $dash_actv; ?>">
										<a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/howitsdone')?>">
										<span class="submenu-label">How Its done </span>
										  </a>
									</li>
								</ul>							  
							</li>
							  
							  
							  <?php					
						  $dash_actv='';
						  $adrouteAr=array();
						  $adrouteAr[]="adminsubscriptionroute";
						  if(in_array($adminroutename,$adrouteAr))
						  {$dash_actv="active"; }
						?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/subscription');?>">
								<span class="menu-icon">
									<i class="fa fa-bookmark"></i> 
								</span>
								<span class="text">
									Subscription
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						 
						 <?php					
						  $dash_actv='';
						  $adrouteAr=array();
						  $adrouteAr[]="adminamenitiesroute";
						  $adrouteAr[]="adminamenitiesaddroute";
						  if(in_array($adminroutename,$adrouteAr))
						  {$dash_actv="active"; }
						?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/amenities');?>">
								<span class="menu-icon">
									<i class="fa fa-cubes"></i> 
								</span>
								<span class="text">
									Amenities
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						  
						<?php					
						  $dash_actv='';
						  $adrouteAr=array();
						  $adrouteAr[]="adminhomesearchroute";
						  $adrouteAr[]="adminhomesearchaddroute";
						  if(in_array($adminroutename,$adrouteAr))
						  {$dash_actv="active"; }
						?>	  
						<li class="<?php echo $dash_actv; ?>" >
							<a href="<?php echo url(ADMINSEPARATOR.'/homesearch');?>">
								<span class="menu-icon">
									<i class="fa fa-home"></i> 
								</span>
								<span class="text">
									Home-search
								</span> 
								<span class="menu-hover"></span>
							</a>
						</li>
						
					</ul>
					
					<!--<div class="alert alert-info">
						Welcome to Prosessional Admin. Do not forget to check all my pages. 
					</div>-->
				</div><!-- /main-menu -->
			</div><!-- /sidebar-inner -->
		</aside>

		<div id="main-container">
		
		<?php
		$msgclass=''; $flagshowmsg=0; $msgdata="";
		if(!empty($successmsg))
		{
			$msgclass=" alert-success ";
			$flagshowmsg=1;
			$msgdata=$successmsg;
		}
		elseif(!empty($errormsg))
		{
			$msgclass=" alert-danger ";
			$flagshowmsg=1;
			$msgdata=$errormsg;
		}
		?>
		<?php
		if($flagshowmsg==1)
		{
		?>
			<div class="alert <?php echo $msgclass;  ?>" id="custommsgdivid1" >
			  <?php echo $msgdata; ?>
			  <a  href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
			</div>
		<?php
		}
		?>
			<!--<div id="breadcrumb">
				<ul class="breadcrumb">
					 <li><i class="fa fa-home"></i><a href="index.html"> Home</a></li>
					 <li class="active">Blank page</li>	 
				</ul>
			</div>-->
			
			@yield('content')
			
			<!-- breadcrumb -->
		</div><!-- /main-container -->
	</div><!-- /wrapper -->

	<a href="" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>
	
	<!-- Logout confirmation -->
	<div class="custom-popup width-100" id="logoutConfirm">
		<div class="padding-md">
			<h4 class="m-top-none"> Do you want to logout?</h4>
		</div>

		<div class="text-center">
			<a class="btn btn-success m-right-sm" href="<?php echo url(ADMINSEPARATOR.'/logout'); ?>">Logout</a>
			<a class="btn btn-danger logoutConfirm_close">Cancel</a>
		</div>
	</div>
	
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
	<!-- Jquery -->
	<!--<script src="{{ ADMINCSSPATH}}/js/jquery-1.10.2.min.js"></script>-->
	
	<!-- Bootstrap -->
    <script src="{{ ADMINCSSPATH}}/bootstrap/js/bootstrap.min.js"></script>
   
	<!-- Modernizr -->
	<script src="{{ ADMINCSSPATH}}/js/modernizr.min.js"></script>
   
    <!-- Pace -->
	<script src="{{ ADMINCSSPATH}}/js/pace.min.js"></script>
	
	<!-- Popup Overlay -->
	<script src="{{ ADMINCSSPATH}}/js/jquery.popupoverlay.min.js"></script>
   
    <!-- Slimscroll -->
	<script src="{{ ADMINCSSPATH}}/js/jquery.slimscroll.min.js"></script>
    
	<!-- Cookie -->
	<script src="{{ ADMINCSSPATH}}/js/jquery.cookie.min.js"></script>

	<!-- Endless -->
	<script src="{{ ADMINCSSPATH}}/js/endless/endless.js"></script>
	<script>
	
	var admin_base_url_data="<?php  echo url('adminpannel'); ?>";
    var admin_csrf_token_data="<?php echo csrf_token(); ?>";
	
	  jQuery(document).ready(function(){
	  
	   setTimeout(function(){
	   
	   jQuery("#custommsgdivid1").slideUp();
	   
	   }, 5000);
	  
	  });
	</script>
  </body>
</html>
