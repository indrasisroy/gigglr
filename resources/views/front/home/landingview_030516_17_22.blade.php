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
				<h1>welcome text</h1>
				<div class="text" style="max-width: 704px;">
					<p class="lead">
						Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt 
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

    
@endsection