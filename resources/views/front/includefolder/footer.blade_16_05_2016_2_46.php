<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="copyWrap dpShow">
					<a href="index.html"><img src="{{ URL::asset('public/front')}}/images/footer-logo.png" alt="" /></a>
					<div class="copy">Copyright &copy; 2016 prosessional</div>
				</div>
				<div class="footerLinkWrap">
					<h4>JUMP TO</h4>
						
					<ul class="footerLink">
					
						<?php
								$value=Session::get('front_id_sess');
								if(!empty($value))
								{
						?>
					
                        <li><a href="#" class="disable">My Account</a></li>
	                    <li><a href="#" class="disable">My Profile</a></li>
                        <li><a href="#" class="disable">My Roster</a></li>
								
						<?php
								}
						?>
								
                        <li><a href="#">Search</a></li>
                         <li><a href="#">Gig Guide</a></li>
                         <li><a href="#">Help & Support</a></li>
                     </ul>
				</div>
				<div class="footerLinkWrap">
					<h4>VIEW</h4>
					<ul class="footerLink">
						<li><a href="#">Contact</a></li>
						<li><a href="#">FAQ</a></li>
						<li><a href="#">Terms and Conditions</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Report a Bug</a></li>
					</ul>
				</div>
						
				<?php
                
						$fetchtype='single'; $tablename="settings";
						$fieldnames=" facebook_url,twitter_url,google_url,instagram_url,youtube_url ";
						$wherear=array();
						$wherear['id']=1;
						$orderbyfield="id"; $orderbytype="asc";
						$limitstart=0;$limitend=0;                
						
						$fetchfooterurldata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
						
						$footerfburl=''; $footertwiturl=''; $footergoogleurl=''; $footerinstaurl=''; $footeryoutubeurl='';
						if(!empty($fetchfooterurldata))
						{
							 $footerfburl=$fetchfooterurldata->facebook_url;
							 $footertwiturl=$fetchfooterurldata->twitter_url;
							 $footergoogleurl=$fetchfooterurldata->google_url;
							 $footerinstaurl=$fetchfooterurldata->instagram_url;
							 $footeryoutubeurl=$fetchfooterurldata->youtube_url;
						}
						
				?>
						
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
					<div class="subscribeInput"><input type="text" class="form-control" placeholder="your email address" /></div>
					<div class="subscribeBtn"><button class="btn btn-primary">subscribe</button></div>
				</div>
				
				<div class="copyWrap mobShow">
					<a href="index.html"><img src="{{ URL::asset('public/front')}}/images/footer-logo.png" alt="" /></a>
					<div class="copy">Copyright &copy; 2016 prosessional</div>
				</div>
			</div>
		</div><!-- /.container -->
	</footer>