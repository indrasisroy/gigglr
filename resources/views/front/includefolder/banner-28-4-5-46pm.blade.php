	<section class="banner" style="background-image: url({{ URL::asset('public/front')}}/images/banner.jpg);">
		<!-- <img src="images/banner.jpg" alt="" /> -->
		<div class="bannerCaption">
			<div class="container">
				<div class="bannerForm">
					<a href="#" class="logo"><img src="{{ URL::asset('public/front')}}/images/index-logo.png" alt="" /></a>
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
