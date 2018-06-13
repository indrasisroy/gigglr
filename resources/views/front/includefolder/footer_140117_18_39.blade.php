<footer class="footer">


<?php

						$fetchtype='single'; $tablename="settings";
						$fieldnames=" facebook_url,twitter_url,google_url,instagram_url,youtube_url,footer_logo_image,site_name,copyright_year";
						$wherear=array();
						$wherear['id']=1;
						$orderbyfield="id"; $orderbytype="asc";
						$limitstart=0;$limitend=0;                
						
						$fetchfooterurldata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);


						$fetchtype='single'; $tablename="user_master";
						$UserID=Session::get('front_id_sess');

						$fieldnames="seo_name";
						$wherear=array();
						$wherear['id']=$UserID;
						$orderbyfield="id"; $orderbytype="asc";
						$limitstart=0;$limitend=0;                
						$userprofilelink ='';
						$fetchfooteruserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
						
						if(!empty($fetchfooteruserdata))
						{
							$userprofilelink = $fetchfooteruserdata->seo_name;
						}
						


?>


		<div class="container">
			<div class="row">
				<div class="copyWrap dpShow">
				<?php
                
						$footerfburl=''; $footertwiturl=''; $footergoogleurl=''; $footerinstaurl=''; $footeryoutubeurl=''; $site_name=''; $copyright_year='';
						$imgurldata = "{{ URL::asset('public/front')}}/images/footer-logo.png";
						if(!empty($fetchfooterurldata))
						{
							 $footerfburl=$fetchfooterurldata->facebook_url;
							 $footertwiturl=$fetchfooterurldata->twitter_url;
							 $footergoogleurl=$fetchfooterurldata->google_url;
							 $footerinstaurl=$fetchfooterurldata->instagram_url;
							 $footeryoutubeurl=$fetchfooterurldata->youtube_url;
							 $site_name=$fetchfooterurldata->site_name;
							 $copyright_year=$fetchfooterurldata->copyright_year;
							 $imgurldata = asset('public/upload/settings-image/source-file/'.$fetchfooterurldata->footer_logo_image);
						}
				
				?>
					<!--<a href="index.html"><img src="{{ URL::asset('public/front')}}/images/footer-logo.png" alt="" /></a>-->
					<a href="<?php echo url('/');?>"><img src="{{$imgurldata}}" alt="" /></a>
					<div class="copy">Copyright &copy; {{$copyright_year}} {{$site_name}}</div>
				</div>
				<div class="footerLinkWrap">
					<h4>JUMP TO</h4>
						
					<ul class="footerLink">
					
									<?php
									$value=Session::get('front_id_sess');
									$myaccount_act_cls_footr=''; $myprofile_act_cls_footr=''; $myroster_act_cls_footr='';
									$myaccount_dact_cls_footr='';  $myprofile__dact_cls_footer='';		$myroster_dact_cls_footer='';
									if(!empty($value))
									{
										// $myaccount_act_cls_footr=' active ';
										// $myprofile_act_cls_footr=' active ';
										// $myroster_act_cls_footr=' active ';
									
									}else if(empty($value))
									{
											$myaccount_dact_cls_footr=' disable ';
											$myprofile__dact_cls_footer=' disable ';
											$myroster_dact_cls_footer=' disable ';
									}
									?>
									<li class="<?php echo $myaccount_act_cls_footr.$myaccount_dact_cls_footr; ?>"><a href="<?php echo url('myaccount'); ?>" >My Account</a></li>
									<li class="<?php echo $myprofile_act_cls_footr.$myprofile__dact_cls_footer; ?>"><a href="<?php echo url('a/'.$userprofilelink); ?>" >My Profile</a></li>
									<li class="<?php echo $myprofile_act_cls_footr.$myprofile__dact_cls_footer; ?>"><a href="<?php echo url('myroster'); ?>"" >My Roster</a></li>	
									<li><a href="<?php echo url('/');?>">Search</a></li>
									<li><a href="<?php echo url('gigguide');?>">Gig Guide</a></li>
									<li><a href="<?php echo url('support');?>">Support</a></li>
									<li><a href="<?php echo url('help');?>">Help</a></li>
                     </ul>
				</div>
				<div class="footerLinkWrap">
					<h4>VIEW</h4>
					<ul class="footerLink">
						
						<li><a href="<?php echo url('terms-and-conditions');?>" target="_blank">Terms & Conditions</a></li>
						<li><a href="<?php echo url('privacy-policy');?>" target="_blank">Privacy Policy</a></li>
						<li><a href="<?php echo url('security-and-safety');?>" target="_blank">Security & Safety</a></li>
						<li><a href="<?php echo url('tips');?>" target="_blank">Tips</a></li>
					</ul>
				</div>
						
				
						
				<div class="footerSocialWrap">
					<h4 class="headingExtra-margin">CONNECT</h4>
					<ul class="footerSocial">
                        <li><a href="<?php echo $footerfburl;?>" target="_blank"><i class="fa fa-facebook"></i>Facebook</a></li>
                        <li><a href="<?php echo $footertwiturl;?>" target="_blank"><i class="fa fa-twitter"></i>Twitter</a></li>
                        <li><a href="<?php echo $footerinstaurl;?>" target="_blank"><i class="fa fa-instagram"></i>Instagram</a></li>
                        <li><a href="<?php echo $footergoogleurl;?>" target="_blank"><i class="fa g-plus"></i>Google+</a></li>
                        <li><a href="<?php echo $footeryoutubeurl;?>" target="_blank"><i class="fa fa-play"></i>YouTube</a></li>
                    </ul>
				</div>
						
                <div class="subscribe">
					<h4>subscribe</h4>
						<?php echo Form::open(array('url'=>'subscribe','files'=>true,'method'=>'post','id'=>'subscribeform','class'=>'')); ?>
						<div class="subscribeInput"><?php echo Form::text("subscriberemail", $value='', $attributes = array("id"=>"subscribe_email", "class"=>"form-control", "placeholder"=>"your email address")); ?></div>
						<div class="subscribeBtn"><button type="button" id="subscribebut" class="btn btn-primary">subscribe</button></div>
						<!--loader for subscription starts-->
						<div id="subscribeloader" class="row margintop5 mydisplaynone">
							<div class="col-sm-4">&nbsp;</div>
							<div class="col-sm-4">
							
								<div class="row mytextcenter">
								   <img width="35" src="{{ URL::asset('public/front')}}/otherfiles/progimages/loder.gif" alt="Loading...">
								</div>
								<div class="row mytextcenter">Please wait...</div>
							
							</div>
							<div class="col-sm-4">&nbsp;</div>
						</div>
						<!--loader for subscription ends--> 
						<?php echo Form::close(); ?>
				</div>
				
				<div class="copyWrap mobShow">
					<a href="index.html"><img src="{{$imgurldata}}" alt="" /></a>
				   <div class="copy">Copyright &copy; {{$copyright_year}} {{$site_name}}</div>
				</div>
			</div>
		</div><!-- /.container -->
	</footer>

<div class="modal fade" id="myModal6" tabindex="-1" role="dialog">
	<div id="ShowGigPost"></div>					
</div>
						
<!-- for subscribe js starts -->
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendsubscribe.js"></script>

<!-- for subscribe js ends -->	
<!-- for subscribe js starts -->
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendsessioncheck.js"></script>

<!-- for subscribe js ends -->						
<script>
//     jQuery(document).ready(function(){
				
//         $('#subscribebut').click(function(){
// 		    callforsubscription("subscribe",csrf_token_data);
// 		});
// //        $('#clickme1').click(function(){
// //        	$( ".new-location" ).toggle();
// //			$(this).parent().toggleClass('clickBorder');
// //			$('.new-location').find('.form-control:eq(0)').focus();
// //		});		
//     });
</script>