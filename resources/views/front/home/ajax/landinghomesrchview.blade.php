<div class="demoSec">
			<div class="container">
			
			<!--------     random home search dyanmic data implementation starts    --------->
			
		<?php
		
			$imgurldata=''; $imgtit=''; $tit=''; $loc=''; $desc=''; $sklid=''; $sklnm='';$ssklid='';
                
               // echo "homesearchAr=><pre>"; print_r($homesearchAr); echo "</pre>";
			
			if(!empty($homesearchAr))
			{
				foreach($homesearchAr as $homesearchObj)
				{
					//$imgurldata = asset('upload/homesearch-image/source-file/'.$homesearchObj->image_name);
					$imgurldata = BASEURLPUBLICCUSTOM."upload/homesearch-image/source-file/".$homesearchObj->image_name;
					$imgtit = stripslashes($homesearchObj->image_title);
					$tit = stripslashes($homesearchObj->title);
					$loc = stripslashes($homesearchObj->location);
					$desc = stripslashes($homesearchObj->description);
					$sklid = stripslashes($homesearchObj->skill_id);
                    $ssklid = stripslashes($homesearchObj->skill_sub_id);
					$sklnm = stripslashes($homesearchObj->name);
                    $ssklnm = stripslashes($homesearchObj->genre_name);
		?>
				
				<div class="clearfix demoWrap">
					<div class="demoPic">
						<img src="{{ $imgurldata }}" alt="" />
						<div class="demoTitle"><?php echo $imgtit;?></div>
					</div>
					<div class="demoContent">
						<h2><?php echo $tit;?></h2>
						<div class="subTxt"><?php echo $loc;?></div>
						<!--<div class="subTxt">Dubline 1</div>-->
						
						<p><?php echo $desc;?></p>
<!--
						<div class="basicContact">
							<a href="tel:+39 335 7237621" class="phn"> +39 335 7237621</a>
							<a href="mailto:contact@dublin.com" class="mail">contact@dublin.com</a>
						</div>
-->

						

                        <div class="search-now">
                            <button class="btn btn-primary homesearchbyskillid" data-skillid="<?php echo $sklid;?>" data-skillsubid="<?php echo $ssklid;?>"  data-skillnm="<?php echo $sklnm;?>"  data-skillsubnm="<?php echo $ssklnm;?>" type="button">Search NOW!</button>
                            <!--<a href="javascript:void(0)"></a>-->
						  
						   <!--<div class="datepickerWrap">
									<a class="calendarOpen" href="javascript:void(0)"></a>
									<input class="hmsrchbookdate form-control" type="text">									
						   </div>-->
									
						
									
						
						   
                        </div>
					</div>
				</div>
					
		<?php
				}
			}
		?>
			
			<!--------     random home search dyanmic data implementation ends    --------->
				
				
				</div>
				
			</div><!-- /.container -->