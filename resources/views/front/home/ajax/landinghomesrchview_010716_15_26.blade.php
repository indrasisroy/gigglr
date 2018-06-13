<div class="demoSec">
			<div class="container">
			
			<!--------     random home search dyanmic data implementation starts    --------->
			
		<?php
			if(!empty($homesearchAr))
			{
				foreach($homesearchAr as $homesearchObj)
				{
					$imgurldata = asset('upload/homesearch-image/source-file/'.$homesearchObj->image_name);
					$imgtit = stripslashes($homesearchObj->image_title);
					$tit = stripslashes($homesearchObj->title);
					$loc = stripslashes($homesearchObj->location);
					$desc = stripslashes($homesearchObj->description);
					$sklid = stripslashes($homesearchObj->skill_id);
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
                            <button class="btn btn-primary">Search NOW!</button>
                            <a href="javascript:void(0)"></a>
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