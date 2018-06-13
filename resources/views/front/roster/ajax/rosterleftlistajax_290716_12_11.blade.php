<div class="event_left_row">
    <!--<h2>March 2015</h2>-->
    <ul class="event_list">

<?php

$sess_id='';       
if($con_sess_id!='')
{
    $sess_id= $con_sess_id;
}

$gigid=''; $gigunique=''; $gigtype=''; $bookerorartist=''; $bookerid=''; $bookername=''; $artistid=''; $artistname=''; $categoryid=''; $categoryname=''; $genreid=''; $genrename=''; $cancelfee=''; $securityfee=''; $totalfee=''; $reqexpdt=''; $bkaccdt=''; $bookstat=''; $typo=''; $typoname=''; $evntstdt=''; $evntstdt_frmt=''; $bookreqdt=''; $bookreqdt_frmt=''; $licls=''; $bookerorartistlabel=''; $nestdivid='';

if(!empty($daily_cal_qry_data))
{
    if(!empty($current_date_data))
    {
        $checkmonth=date("m-Y",strtotime($current_date_data));
        $presentmonth=date("F Y",strtotime($current_date_data));
        
        $nxtdate = strtotime($current_date_data);
        $nxtmnth = strtotime("+1 month", $nxtdate);
        $nextmonth=date('F Y', $nxtmnth);
    }

?>
					
		<h2 class="rrostr"><?php echo $presentmonth;?></h2>
					
<?php

    foreach($daily_cal_qry_data as $daily_data)
    {        
        $gigid=trim(stripslashes($daily_data->id));
        $gigunique=trim(stripslashes($daily_data->giguniqueid));
        $gigtype=trim(stripslashes($daily_data->gigpostrequestflag));
        $bookerorartist=trim(stripslashes($daily_data->bookerorartist));
        $bookerid=trim(stripslashes($daily_data->booker_id));
        $bookername=ucfirst(trim(stripslashes($daily_data->booker_name)));
        $artistid=trim(stripslashes($daily_data->artist_id));
        $artistname=ucfirst(trim(stripslashes($daily_data->assumed_artistname)));
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
        if($gigtype==1 || $gigtype==2)
        {
            if($typo==1)
            {
                $typoname='Artist';			
            }
            elseif($typo==2)
            {
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
            if($bookerid==$sess_id)
            {
                if($bookstat=='1')
                {
					$iconpic = BASEURLPUBLICCUSTOM."/front/images/book_blue.png";
					$bookerorartistlabel="You have booked ".$artistname." ".$typoname." for an event based on ".$genrename." genre of ".$categoryname." category - event is on ".$evntstdt_frmt;
                }
                elseif($bookstat=='2')
                {
                    $bookerorartistlabel="You have posted a gig on ".$bookreqdt_frmt." for ".$typoname." on ".$genrename." genre of ".$categoryname." category - the event is on ".$evntstdt_frmt;
                }
            }
			else{
				if($bookstat=='1')
                {
					$iconpic = BASEURLPUBLICCUSTOM."/front/images/yellow_star.png";
                    if($bookerorartist=='artist' && $artistid==$sess_id)
                    {
                        $bookerorartistlabel="You have a confirmed booking on ".$evntstdt_frmt." and the event is based on ".$genrename." genre of ".$categoryname." category - event booker is ".$bookername;  
                    }
                    elseif($bookerorartist=='artist' && $artistid!=$sess_id)
                    {
                        if($typo=='2')
                        {
                            $bookerorartistlabel="Your ".$artistname." Group has a confirmed booking on ".$evntstdt_frmt." and the event is based on ".$genrename." genre of ".$categoryname." category - event booker is ".$bookername;
                        }
                    }
                }
				elseif($bookstat=='2')
                {
					$iconpic = BASEURLPUBLICCUSTOM."/front/images/box_icon.png";
					if($typo=='1')
					{
						$bookerorartistlabel=$bookername." has posted a gig for Artist under ".$genrename." genre of ".$categoryname." category which is similar to your genre and category - event is on ".$evntstdt_frmt;
					}
					elseif($typo=='2')
					{
						$bookerorartistlabel=$bookername." has posted a gig for Group under ".$genrename." genre of ".$categoryname." category which is similar to your ".$artistname." Group - event is on ".$evntstdt_frmt;
					}
                }
			}
        }
        
        elseif($gigtype==2)
        {
            if($bookerid==$sess_id)
            {
                if($bookstat=='1')
                {
					$iconpic = BASEURLPUBLICCUSTOM."/front/images/book_blue.png";
					$bookerorartistlabel="You have booked ".$artistname." ".$typoname." for an event based on ".$genrename." genre of ".$categoryname." category - event is on ".$evntstdt_frmt;
                }
                elseif($bookstat=='2')
                {
					$iconpic = BASEURLPUBLICCUSTOM."/front/images/clock-red.png";
                    $bookerorartistlabel="Your request to book ".$artistname." ".$typoname." on ".$bookreqdt_frmt." for ".$genrename." genre of ".$categoryname." category, has been going through the negotiation process - the event is on ".$evntstdt_frmt;
                }
            }
            else
            {
                if($bookstat=='1')
                {
					$iconpic = BASEURLPUBLICCUSTOM."/front/images/yellow_star.png";
                    if($bookerorartist=='artist' && $artistid==$sess_id)
                    {
						$bookerorartistlabel="You have a confirmed booking on ".$evntstdt_frmt." and the event is based on ".$genrename." genre of ".$categoryname." category - event booker is ".$bookername;
                    }
                    elseif($bookerorartist=='artist' && $artistid!=$sess_id)
                    {
                        if($typo=='2')
                        {
							$bookerorartistlabel="Your ".$artistname." Group has a confirmed booking on ".$evntstdt_frmt." and the event is based on ".$genrename." genre of ".$categoryname." category - event booker is ".$bookername;
                        }
                        elseif($typo=='3')
                        {
							$bookerorartistlabel="Your ".$artistname." Venue has a confirmed booking on ".$evntstdt_frmt." and the event is based on ".$genrename." genre of ".$categoryname." category - event booker is ".$bookername;
                        }
                    }
                }
                elseif($bookstat=='2')
                {
					$iconpic = BASEURLPUBLICCUSTOM."/front/images/clock-red.png";
                    if($bookerorartist=='artist' && $artistid==$sess_id)
                    {
                        $bookerorartistlabel="You are going through the negotiation process in respect of the booking request of ".$bookername." for ".$genrename." genre of ".$categoryname." category - event is on ".$evntstdt_frmt;
                    }
                    elseif($bookerorartist=='artist' && $artistid!=$sess_id)
                    {
                        if($typo=='2')
                        {
                            $bookerorartistlabel="Your ".$artistname." Group has been going through the negotiation process in respect of the booking request of ".$bookername." for ".$genrename." genre of ".$categoryname." category - event is on ".$evntstdt_frmt;   
                        }
                        elseif($typo=='3')
                        {
                            $bookerorartistlabel="Your ".$artistname." Venue has been going through the negotiation process in respect of the booking request of ".$bookername." for ".$genrename." genre of ".$categoryname." category - event is on ".$evntstdt_frmt;
                        }
                    }
                }
            }
        }
        
?>
										
		<li>
		
<?php

		if($gigtype==1)
		{
			if($bookerid==$sess_id && $bookstat=='2')
			{
			
?>

			<div class="rosterlefticonclass rosterleftextraiconclass">PG</div>

<?php
				
			}
			else
			{

?>			
			<img class="rosterlefticonclass" src="<?php echo $iconpic;?>">


<?php

			}
		}

		else
		{
		
?>

            <img class="rosterlefticonclass" src="<?php echo $iconpic;?>">
			
<?php

		}

?>			
			
			<a href="javascript:void(0)" class="gig_request" data-id="<?php echo $gigunique;?>" data-gigtype="<?php echo $gigtype;?>" data-bkrorart="<?php echo $bookerorartist;?>" data-gigid="<?php echo $gigid;?>" >
				<?php echo $bookerorartistlabel;?>
			</a>
                
<?php

        if($gigtype==1 && $bookerorartist=='booker')
        {
            $nestdivid='rosterleftnestedlistresponseid_'.$gigid;
            
?>
                                                            
            <div id="<?php echo $nestdivid;?>">
            </div>
                
<?php

        }
        
?>

        </li>
										
<?php

	}
}

else
{

?>

        <li>
            <a href="javascript:void(0)">
				No record is available.
            </a>
        </li>
        
<?php

}

?>
										
	</ul>
</div>
    
    
    