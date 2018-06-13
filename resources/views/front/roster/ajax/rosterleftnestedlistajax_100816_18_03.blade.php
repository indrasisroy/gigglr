<div class="event_left_row">
					<ul class="event_list">
<?php
$artistname=""; $reqondt=""; $requestondt=""; $bidartistlabel="";

if(!empty($nested_qry_data)){

					foreach($nested_qry_data as $nested_data){
										
                                        $artistname=ucfirst(trim(stripslashes($nested_data->book_req_artist_name)));
										$gigbidid=trim(stripslashes($nested_data->giguniqueid));
                                        
                                        $reqondt=trim(stripslashes($nested_data->create_date));
										if(!empty($reqondt))
										{
															$requestondt=date("d/m/Y",strtotime($reqondt));	
										}
										
                                        $bidartistlabel="->   ".$artistname." has requested a bid for this gig on ".$requestondt;
?>
										<li class="marginleft25">
															<a href="javascript:void(0)" class="gig_request" data-id="<?php echo $gigbidid;?>" >
																				<?php echo $bidartistlabel;?>
															</a> 
										</li>					
<?php
					}
}
else{
?>
					<li class="marginleft25">-
					<a href="javascript:void(0)">
					No bid record is present.
					</a>
					</li>
<?php
}
?>						
					</ul>
</div>