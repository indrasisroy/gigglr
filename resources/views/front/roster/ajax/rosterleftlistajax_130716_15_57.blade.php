<div class="event_left_row">
					<!--<h2>March 2015</h2>-->
					<ul class="event_list">

<?php
$gigid=''; $gigunique=''; $gigtype=''; $bookerorartist=''; $bookerid=''; $bookername=''; $artistid=''; $artistname=''; $categoryid=''; $categoryname=''; $genreid=''; $genrename=''; $cancelfee=''; $securityfee=''; $totalfee=''; $reqexpdt=''; $bkaccdt=''; $bookstat=''; $typo=''; $typoname=''; $evntstdt=''; $evntstdt_frmt=''; $bookreqdt=''; $bookreqdt_frmt=''; $licls=''; $bookerorartistlabel='';

if(!empty($daily_cal_qry_data)){
					//echo "<pre>"; print_r($daily_cal_qry_data);
					foreach($daily_cal_qry_data as $daily_data){
										
										$gigid=trim(stripslashes($daily_data->id));
										$gigunique=trim(stripslashes($daily_data->giguniqueid));
										$gigtype=trim(stripslashes($daily_data->gigpostrequestflag));
										$bookerorartist=trim(stripslashes($daily_data->bookerorartist));
										$bookerid=trim(stripslashes($daily_data->booker_id));
										$bookername=ucfirst(trim(stripslashes($daily_data->booker_name)));
										$artistid=trim(stripslashes($daily_data->artist_id));
										$artistname=ucfirst(trim(stripslashes($daily_data->book_req_artist_name)));
										$categoryid=trim(stripslashes($daily_data->category));
										$categoryname=trim(stripslashes($daily_data->category_name));
										$genreid=trim(stripslashes($daily_data->genre));
										$genrename=trim(stripslashes($daily_data->genre_name));
										$cancelfee=trim(stripslashes($daily_data->booking_cancellation_fee));
										$securityfee=trim(stripslashes($daily_data->artist_security_deposit));
										$totalfee=trim(stripslashes($daily_data->total_amount));
										$reqexpdt=trim(stripslashes($daily_data->request_expire_datetime));
										$bkaccdt=trim(stripslashes($daily_data->booking_accept_date));
										$bookstat=trim(stripslashes($daily_data->booking_status));
										
										$typo=trim(stripslashes($daily_data->type_flag));
										if($gigtype==1)
										{
															if($typo==1)
															{
																				$typoname='Artists';			
															}
															elseif($typo==2){
																				$typoname='Groups';			
															}
															else{
																				$typoname='Venues';					
															}
										}
										elseif($gigtype==2)
										{
															if($typo==1)
															{
																				$typoname='Artist';			
															}
															elseif($typo==2){
																				$typoname='Group';			
															}
															else{
																				$typoname='Venue';					
															}					
										}
										
										$evntstdt=trim(stripslashes($daily_data->event_start_date_time));
										if(!empty($evntstdt))
										{
															$evntstdt_frmt=date("d/m/Y",strtotime($evntstdt));	
										}
										
										$bookreqdt=trim(stripslashes($daily_data->booking_req_date));
										if(!empty($bookreqdt))
										{
															$bookreqdt_frmt=date("d/m/Y",strtotime($bookreqdt));	
										}
										
										if($gigtype==1)
										{
															$licls="zoom_nav";
															
															if($bookerorartist=='artist')
															{
																				$bookerorartistlabel=$bookername." has posted a gig on ".$bookreqdt_frmt." for ".$genrename." genre of ".$categoryname." category for ".$typoname." - event is on ".$evntstdt_frmt;
															}
															elseif($bookerorartist=='booker')
															{
																				$bookerorartistlabel="You have posted a gig on ".$bookreqdt_frmt." for ".$genrename." genre of ".$categoryname." category for ".$typoname." - event is on ".$evntstdt_frmt;		
															}
										}
										elseif($gigtype==2)
										{
															$licls="home_nav";
															
															if($bookerorartist=='artist')
															{
																				$bookerorartistlabel=$bookername." has requested for a booking to you on ".$bookreqdt_frmt." for ".$genrename." genre of ".$categoryname." category for - event is on ".$evntstdt_frmt;
															}
															elseif($bookerorartist=='booker')
															{
																				$bookerorartistlabel="You have requested for a booking to ".$artistname." ".$typoname." on ".$bookreqdt_frmt." for ".$genrename." genre of ".$categoryname." category - event is on ".$evntstdt_frmt;		
															}
										}
?>
										
										<li class="<?php echo $licls;?>">
															<a href="javascript:void(0)" class="gig_request" data-id="<?php echo $gigunique;?>">
																				<?php echo $bookerorartistlabel;?>
															</a>
										</li>
										
<?php
					}
}
else{
?>
					<li class="home_nav">
					<a href="javascript:void(0)">
					No record is available.
					</a>
					</li>
<?php
}
?>
										
					</ul>
</div>