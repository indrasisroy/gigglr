<div class="event_left_row">
					<ul class="event_list">
<?php
$artistname=""; $reqondt=""; $requestondt=""; $bidartistlabel=""; $bidbid=''; $gigunid=''; $nestid='';

if(!empty($nested_qry_data)){

					foreach($nested_qry_data as $nested_data){
										
                                        $artistname=ucfirst(trim(stripslashes($nested_data->book_req_artist_name)));
										$gigunid=trim(stripslashes($nested_data->giguniqueid));
										
										$bidbid=trim(stripslashes($nested_data->id));
										$nestid="bidbid_".$bidbid;
                                        
                                        $reqondt=trim(stripslashes($nested_data->create_date));
										if(!empty($reqondt))
										{
															$requestondt=date("d/m/Y",strtotime($reqondt));	
										}
										
                                        $bidartistlabel="->   ".$artistname." has requested a bid for this gig on ".$requestondt;
?>
										<li class="marginleft25" data-bidId = "<?php echo $bidbid;?>" data-id="<?php echo $gigunid;?>">
															<a id="<?php echo $nestid; ?>" href="javascript:void(0)" class="" data-id="<?php echo $gigunid;?>" data-bidid="<?php echo $bidbid;?>" >
																				<?php echo $bidartistlabel;?>
															</a>
															<input type="hidden" id="hidbidid" value="<?php echo $bidbid;?>">
										</li>
															
<?php
					}
}
else{
?>
					<li>
					<a href="javascript:void(0)" gigid>
					No bid record is present.
					</a>
					</li>
<?php
}
?>						
					</ul>
</div>