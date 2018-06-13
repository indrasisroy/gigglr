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
  
<!--include banner code  here starts-->
<div id="bannercntntdvsrchid" class="mydisplaynone"></div>
<!--include banner code  here ends-->

  	<section class="content">
				
	
	
		
				
				<div class="welcomeSec">
			<div class="container">
				
				<div class="pf_inner_content">
					
		           <div class="row">
		           	<div class="col-md-12 clearfix reslt">
	                    <div class="sort sortcustclass mydisplaynone">
	                     <p class="prf_slt_txt">sort by :</p>
	                    <div class="inputbox input_selectout prf_slt_bx clearfix" >
		                    <div class="select_outer singl_arow">
								 <?php
								
								$control_attrAr=array();
								$control_attrAr['id']='orderbycust';
								$control_attrAr['class']=" selectpicker ";
								
								
								$orderbycustdataAr=array();
								$orderbycustdataAr["Name"]="Name";
								$orderbycustdataAr["Popularity"]="Popularity";
								$orderbycustdataAr["Distance"]="Distance";
								
						
								$orderbycustdata='Name';
								
								echo Form::select('orderbycust', $orderbycustdataAr, $orderbycustdata,$control_attrAr);							
								?>
		                      <!-- <select class="selectpicker">
	                              <option>Most popular</option>
	                              <option>DJ</option>
	                              <option>Dancer</option>
		                       </select>-->
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
				
				
				
		    </div><!-- /.container -->			
		</div>
		
		
		
		<div id="welcomesecid" class="welcomeSec mydisplaynone entertain_text">
			<div class="container">
				<h1><?php echo $welcometxt_heading;?></h1>
				<div class="text " style="max-width: 704px;">
					<p class="lead">
						<?php echo stripslashes($frontwelcometext);?> 
					</p>
					
				</div>										
				

		    </div><!-- /.container -->			
		</div>
		
		
		
		
		<div id="demoserchomesrchid">		
		</div>
		
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
			
			var srchradius_sliderobj='';
			
			var orderbycust="Name";
			
			var default_radius="<?php echo $default_radius; ?>";
			var max_radius_limit="<?php echo $max_radius_limit; ?>";
			
	</script>
    <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/mainsearchfunc.js"></script>
    <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/landingview.js"></script>
	
				<!--for latitude longitude starts-->
				<script type="text/javascript" src="https://www.google.com/jsapi"></script>
				<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/latlongfromjsapi.js"></script>			
				<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/latlongbrowser.js"></script>
				<!--for latitude longitude starts-->
	
				
@endsection