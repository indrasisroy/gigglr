	<?php
	if(!empty($banner_image))
	{
	?>
	<!--<section class="banner" style="background-image: url({{ URL::asset('public/front')}}/images/banner.jpg);">-->
	<section class="banner" style="background-image: url({{ $banner_image }});">
		<!-- <img src="images/banner.jpg" alt="" /> -->
		<div class="bannerCaption">
			<div class="container">
				<div class="bannerForm">
				
				
				<?php

						$fetchtype='single'; $tablename="settings";
						$fieldnames="site_logo_image";
						$wherear=array();
						$wherear['id']=1;
						$orderbyfield="id"; $orderbytype="asc";
						$limitstart=0;$limitend=0;                
						
						$fetchbannerurldata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
						
						$imgurldata = "{{ URL::asset('public/front')}}/images/index-logo.png";
						if(!empty($fetchbannerurldata))
						{
							 
							 $imgurldata = asset('upload/settings-image/source-file/'.$fetchbannerurldata->site_logo_image);
						}


				?>

				
				
				
					<a href="#" class="logo"><img src="{{$imgurldata}}" alt="" /></a>
					<div class="inlineWrap">
						<div class="textField inline"><input type="text" class="form-control" placeholder="What are you looking for?" /></div>
						<div class="seltbox inline">
							<select class="selectpicker">
								<option value="0">Show all</option>
								<option value="1">Option 01</option>
								<option value="2">Option 02</option>
								<option value="3">Option 03</option>
							</select>
						</div>
						<div class="btnOut inline"><button class="btn btn-warning">Search Now</button></div>
					</div>
				</div>
		    </div><!-- /.container -->
		</div>
	    <div class="downArrow">
	    	<a class="downArrowBtn" href="javascript:void(0);"></a>
	    </div>
	</section> <!-- /.content -->
<?php
	}
	?>