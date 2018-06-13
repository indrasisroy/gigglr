<?php
$successmsg='';$errormsg='';
if(!empty($successmsgdata))
{
        $successmsg=$successmsgdata;
}

if(!empty($errormsgdata))
{
        $errormsg=$errormsgdata;
}

?>
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
  
  	<section class="content">
				
	
	
		<div class="welcomeSec">
			<div class="container">
				<h1>welcome</h1>
				<div class="text" style="max-width: 704px;">
					<p class="lead">
						<?php echo stripslashes($frontwelcometext);?> 
					</p>
					
				</div>										
				
<!--				<div class="row serviceThumbWrap">
					<div class="col-sm-4">
						<a href class="serviceThumb">
							<div class="serviceIcon">
								<img src="{{ URL::asset('public/front')}}/images/wine-glass-white.png" />
								<span><img src="{{ URL::asset('public/front')}}/images/wine-glass-hov.png" alt="" /></span>
							</div>
							<h4>DJ for a Party</h4>
						</a>
					</div>
					<div class="col-sm-4">
						<a href class="serviceThumb ad-arrow">
							<div class="serviceIcon">
								<img src="{{ URL::asset('public/front')}}/images/vanue.png" />
								<span><img src="{{ URL::asset('public/front')}}/images/vanue-hov.png" alt="" /></span>
							</div>
							<h4>Venue for a Wedding</h4>
						</a>
					</div>
					<div class="col-sm-4">
						<a href class="serviceThumb">
							<div class="serviceIcon">
								<img src="{{ URL::asset('public/front')}}/images/pointer.png" />
								<span><img src="{{ URL::asset('public/front')}}/images/pointer-hov.png" alt="" /></span>
							</div>
							<h4>Band for  a  Venue</h4>
						</a>
					</div>
					
				</div>
-->				
		    </div><!-- /.container -->			
		</div>
				
				<div class="welcomeSec">
			<div class="container">
				
				<div class="pf_inner_content">
					
		           <div class="row">
		           	<div class="col-md-12 clearfix reslt">
	                    <div class="sort">
	                     <p class="prf_slt_txt">sort by :</p>
	                    <div class="inputbox input_selectout prf_slt_bx clearfix" >
		                    <div class="select_outer singl_arow">
		                       <select class="selectpicker">
	                              <option>Most popular</option>
	                              <option>DJ</option>
	                              <option>Dancer</option>
		                       </select>
		                   </div>
		                 </div>
	                    </div>
	                </div>
	                
					<div id="searchlistresponseid">
					<!--responsedata starts-->
					<!--responsedata ends-->			
					</div>	
								
		         </div>
								
		             <div class="search_pg" id="pagidivid">
		              <!--<ul class="pagination search_pagintn">
		                  <li><a href="#">Previous</a> </li>
		                <li class="active"><a href="#">1</a></li>
		                <li><a href="#">2</a></li>
		                <li><a href="#">3</a></li>
		                <li><a href="#">4</a></li>
		                <li><a href="#">5</a></li>
		                <li><a href="#">6</a></li>
		                <li><a  href="#">next</a> </li>
		            </ul>-->
					
		             </div>
		       </div>
				
				<!-- <h1>welcome text</h1>
				<div class="text" style="max-width: 704px;">
					<p class="lead">
						Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt 
					</p>
				</div> -->
				
				
				<!-- <div class="row serviceThumbWrap">
					<div class="col-sm-4">
						<a href class="serviceThumb">
							<div class="serviceIcon">
								<img src="images/wine-glass-white.png" />
								<span><img src="images/wine-glass-hov.png" alt="" /></span>
							</div>
							<h4>DJ for a Party</h4>
						</a>
					</div>
					<div class="col-sm-4">
						<a href class="serviceThumb ad-arrow">
							<div class="serviceIcon">
								<img src="images/vanue.png" />
								<span><img src="images/vanue-hov.png" alt="" /></span>
							</div>
							<h4>Venue for a Wedding</h4>
						</a>
					</div>
					<div class="col-sm-4">
						<a href class="serviceThumb">
							<div class="serviceIcon">
								<img src="images/pointer.png" />
								<span><img src="images/pointer-hov.png" alt="" /></span>
							</div>
							<h4>Band for  a  Venue</h4>
						</a>
					</div>
					
				</div> -->
				
		    </div><!-- /.container -->			
		</div>
		
		
		<div class="demoSec">
			<div class="container">
				
				<div class="clearfix demoWrap">
					<div class="demoPic">
						<img src="{{ URL::asset('public/front')}}/images/pic1.jpg" alt="" />
						<div class="demoTitle">BAND FOR HIRE</div>
					</div>
					<div class="demoContent">
						<h2>dublin</h2>
						<div class="subTxt">31.Località di Mare - Salento Ionico</div>
						<div class="subTxt">Dubline 1</div>
						
						<p>
							Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt 
						</p>
<!--
						<div class="basicContact">
							<a href="tel:+39 335 7237621" class="phn"> +39 335 7237621</a>
							<a href="mailto:contact@dublin.com" class="mail">contact@dublin.com</a>
						</div>
-->
                        <div class="search-now">
                            <button class="btn btn-primary">Search NOW!</button>
                            <a href="javascript:void(0)"></a>
                        </div>
					</div>
				</div>
				<div class="clearfix demoWrap">
					<div class="demoPic">
						<img src="{{ URL::asset('public/front')}}/images/pic1.jpg" alt="" />
						<div class="demoTitle">WEDDING VENUE</div>
					</div>
					<div class="demoContent">
						<h2>Berlin</h2>
						<div class="subTxt">31.Località di Mare - Salento Ionico</div>
						<div class="subTxt">Berlin 1</div>
						
						<p>
							Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt 
						</p>
<!--
						<div class="basicContact">
							<a href="tel:+39 335 7237621" class="phn"> +39 335 7237621</a>
							<a href="mailto:contact@dublin.com" class="mail">contact@dublin.com</a>
						</div>
-->
						<div class="search-now">
                            <button class="btn btn-primary">Search NOW!</button>
                            <a href="javascript:void(0)"></a>
                        </div>
						
					</div>
				</div>
				<div class="clearfix demoWrap">
					<div class="demoPic">
						<img src="{{ URL::asset('public/front')}}/images/pic1.jpg" alt="" />
						<div class="demoTitle">live <span>PERFORMER</span></div>
					</div>
					<div class="demoContent">
						<h2>dublin</h2>
						<div class="subTxt">31.Località di Mare - Salento Ionico</div>
						<div class="subTxt">Dubline 1</div>
						
						<p>
							Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt 
						</p>
<!--
						<div class="basicContact">
							<a href="tel:+39 335 7237621" class="phn"> +39 335 7237621</a>
							<a href="mailto:contact@dublin.com" class="mail">contact@dublin.com</a>
						</div>
-->
						<div class="search-now">
                            <button class="btn btn-primary">Search NOW!</button>
                            <a href="javascript:void(0)"></a>
                        </div>
						
					</div>
				</div>
				
			</div><!-- /.container -->
		</div>
	    
	</section> <!-- /.content -->
    
	<script>
			var curr_lat_data='';
			var curr_long_data='';
			var distance_data='';
			
			var available_date='';
			var available_time='';
			
			var selectcategnmid='';
			var selectgenrenmid='';
			
			var selectcategnm='';
			var selectgenrenm='';
			
	</script>
    <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/mainsearchfunc.js"></script>
    <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/landingview.js"></script>
	
				<!--for latitude longitude starts-->
				<script type="text/javascript" src="https://www.google.com/jsapi"></script>
				<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/latlongfromjsapi.js"></script>			
				<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/latlongbrowser.js"></script>
				<!--for latitude longitude starts-->
	
				
@endsection