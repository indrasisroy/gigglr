	<?php
	if(!empty($banner_image))
	{
		$other_dataAr=array();
		if(!empty($other_data))
		{
			$other_dataAr=$other_data;
		}
		
		$categoryAr=array();
		if(!empty($other_dataAr) && array_key_exists("categoryAr",$other_dataAr))
		{
			$categoryAr=$other_dataAr['categoryAr'];
		}
		
	
		//**** fetch  settings - starts
                
                $fetchtype='single'; $tablename="settings";
                $fieldnames=" welcome_text,default_radius,max_radius_limit ";
                $wherear=array();
                $wherear['id']=1;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchfrontwelcomedata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                
                $frontwelcomedata=''; $default_radius=0; $max_radius_limit=100;
                if(!empty($fetchfrontwelcomedata))
                {
                     $frontwelcomedata=$fetchfrontwelcomedata->welcome_text;
                     $default_radius=$fetchfrontwelcomedata->default_radius;
                     $max_radius_limit=$fetchfrontwelcomedata->max_radius_limit;
                }
               
                
        //**** fetch  from settings - ends
                
                    
	
		
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
						
						//$imgurldata = "{{ URL::asset('public/front')}}/images/index-logo.png";
						$imgurldata = BASEURLPUBLICCUSTOM."front/images/index-logo.png";
						if(!empty($fetchbannerurldata))
						{
							 $imgurldata = BASEURLPUBLICCUSTOM."upload/settings-image/source-file/".$fetchbannerurldata->site_logo_image;
							// $imgurldata = asset('upload/settings-image/source-file/'.$fetchbannerurldata->site_logo_image);
						}


				?>

				
				
				
					<a href="<?php echo url('');?>" class="logo"><img src="{{$imgurldata}}" alt="" /></a>
					<div class="midle mydisplaynone" id="bannermddleid">
						<form action="search-result.html" method="post">
		                    <div class="mdl_outer">
		                    <div class="row clearfix">
		                     <div class="col-md-12 srch_mdlpg clearfix">
		                        
		                    <div class="srchbx">
		                      <div class="seltbox inline srch_optn">
							  
							  <?php
								
								$whowhat_attrAr = array();
								$whowhat_attrAr['1']="Who"; 
								$whowhat_attrAr['2']="What";
								
								$control_attrAr=array();
								$control_attrAr['id']='whowhat';
								$control_attrAr['class']=" selectpicker ";
																
								$whowhat='2';							
								echo Form::select('whowhat', $whowhat_attrAr, $whowhat,$control_attrAr);							
								?>
							  
		                       <!-- <select class="selectpicker">
		                            <option value="0">Who</option>
		                            <option value="1">What</option>
		                        </select>-->
									
		                    </div>
		                    </div>
		                      <div class="look_fild">
		                      <div class="srchpg clearfix">
		                        <!--<input type="text" class="form-control inpt" placeholder="Are you looking for?" />-->
								<?php    
								echo Form::text("mainsearch", $mainsearch='', $attributes = array( "id"=>"mainsearch","class"=>" form-control inpt  ","placeholder"=>"are you looking for?"));
								?>
								
		                    </div>
		                    </div>
		                     
		                      <div class="srch_btn srchpg">
		                    <div class="btnOut inline srchnw_btn"><button id="srchnowbutnmainid" type="button" class="btn btn-warning inpt">Search Now</button></div>
		                    </div>
		                </div>
		                     </div>
		                     
		                    </div>
	
			                <div class="category clearfix">
				
				                  <div class=" srchpg srcbx_bg">
				                    <div class="seltbox inline srch_slct seldrpdwn">
									 <?php
								
								$control_attrAr=array();
								$control_attrAr['id']='category';
								$control_attrAr['class']=" selectpicker ";
								$control_attrAr['title']="Category";
								
								$category_id_data='';							
								echo Form::select('category', $categoryAr, $category_id_data,$control_attrAr);							
								?>									
				                       <!-- <select class="selectpicker">
				                            <option value="0">Category</option>
				                            <option value="1">DJ</option>
				                            <option value="2">Dancer</option>
				                        </select>-->
				                    </div>
				                    </div>
				                  <div class="seltbox inline categry_list">
								  
				                        <!--<select class="selectpicker">
				                            <option value="0">Genre</option>
				                            <option value="1">Drum & Bass</option>
				                            <option value="2">Belly Dancer</option>
				                            <option value="3">HipHop/Rap</option>
				                        </select>-->										
								<?php
								
								$control_attrAr=array();
								$control_attrAr['id']='genre';
								$control_attrAr['class']=" selectpicker ";
								$control_attrAr['title']="Genre";
								
								$genre_id_data='';	$genreAr=array();						
								echo Form::select('genre', $genreAr, $genre_id_data,$control_attrAr);							
								?>	
											
				                    </div>
				                    <div class="srchpg clearfix">
				                      <div class="price">
				                          <!-- <div class="max-box clearfix">
				                            <div class="srchtext"><p>Min</p></div>
				                              <div class="selectrbx">
						                        <select class="selectpicker">
						                            <option value="0">Price</option>
						                            <option value="1">$200</option>
						                            <option value="2">$300</option>
						                            <option value="3">$400</option>
						                        </select>
				                              </div>
				                          </div>
				                          <div class="max-box clearfix">
				                            <div class="srchtext"><p>Max</p></div>
				                              <div class="selectrbx">
						                        <select class="selectpicker">
						                            <option value="0">Price</option>
						                            <option value="1">$500</option>
						                            <option value="2">$600</option>
						                            <option value="3">$700</option>
						                        </select>
				                              </div>
				                          </div> -->
				                          
				                          <div class="max-box clearfix">
				                          	  <div class="input-group date">
					                             <!--<input id="bookdate" name="bookdate" type="text" class="form-control date_outr datetimepicker" placeholder="">-->
					        <?php    
							echo Form::text("bookdate", $value='', $attributes = array( "id"=>"bookdate","class"=>" form-control clck_outr datetimepicker  ","placeholder"=>"Event Date"));
							?> 
												   <span class="input-group-addon dt">
					                               <span class="glyphicon glyphicon-calendar clndr"></span>
					                              </span>
					                          </div>
				                          </div>
				                          <div class="max-box clearfix">
				                          	  <div class="input-group date" id="datetimepicker4">
					                             <!--<input id="booktime" name="booktime" type="text" class="form-control clck_outr timepicker" placeholder="">-->
							<?php    
							echo Form::text("booktime", $value='', $attributes = array( "id"=>"booktime","class"=>" form-control clck_outr timepicker  ","placeholder"=>"Event Time"));
							?>
					                               <span class="input-group-addon clck">
					                               <span class="glyphicon glyphicon-time"></span>
					                              </span>
					                          </div>
				                          </div>
				
				                      </div>
				                </div>
				                    <div class="dstn_bx">
				                    <div class="textField inline srchtxtfield">
									<!--<input type="text" class="form-control inpt" placeholder="Location" />-->
									<?php
							$attributes=array();
							$attributes['id']="locationtxt";
							$attributes['class']=" form-control inpt ";
							$attributes['placeholder']="Location";
							
							echo Form::text("locationtxt", $value='', $attributes );
							?> 	
				                    </div>
				
				                <div class="catgr_ratng_divsn srchpg clearfix">
				                    <div class="dstn">Distance</div>
				                    <div class="progress_outer">
				        			
				      				<!--<input id="srchradius" data-slider-id='srchradius' type="text" data-slider-min="0" data-slider-max="50000" data-slider-step="50" data-slider-value="10000"/>-->
								 <?php
							$attributes=array();
							$attributes['id']="srchradius";
							$attributes['class']=" form-control clck_outr datetimepicker ";
							 $attributes['placeholder']="";
							$attributes['data-slider-id']="srchradius";
							$attributes['data-slider-min']="0";
							$attributes['data-slider-max']=$max_radius_limit;
							$attributes['data-slider-step']="50";
							$attributes['data-slider-value']=$default_radius;
							echo Form::text("srchradius", $value='', $attributes );
							?> 	
									</div>
				                </div>
				                 </div>       
				              </div>
				                
			                <div class="refine-search">
			                	<a class="rfn_srch on" href="javascript:void(0)">Refine your search</a>
			                </div>
			            	
		            	</form>
		            	
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