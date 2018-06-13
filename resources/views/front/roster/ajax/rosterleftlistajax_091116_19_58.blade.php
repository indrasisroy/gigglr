<div class="event_left_row">
    <!--<h2>March 2015</h2>-->
    <ul class="event_list">

	<?php
	if(!empty($maingig_qry_data_result)){
			$iconpic = "";
			$textmsg = "";
			$ggbid = '';
			$typo = '';
			$gigtype = '';
			$bookerorartist = '';
			$review = '';
			
			
		foreach($maingig_qry_data_result as $data_result){
			$iconpic2 = '';
            //$iconpic2 = '';
			
			if(session('front_id_sess') ==  $data_result['booker_id']){
				$bookerorartist = 'booker';
                //echo $bookerorartist;
			}else{
                $bookerorartist = '';
                //echo "other";
            }
			$gigid = $data_result['gigmaster_id'];
			$gigunique = $data_result['giguniqueid'];
			$typo = $data_result['type_flag'];
			$categoryname = $data_result['category_name_join'];
			$genrename = $data_result['genre_name_join'];
			$bookername = $data_result['bk_nickname'];
			$evntstdt_frmt = date('d/m/Y',strtotime($data_result['start_date']));
            $evnteddt_frmt = date('d/m/Y',strtotime($data_result['end_date']));
			$gigtype = $data_result['gigpostrequestflag'];
			$gig_rev = $data_result['review'];
			//echo $data_result['rcsipsbb'];
			$picArray = explode(",",$data_result['rcsipsbb']);
			//print_r($picArray);
            $eventtown = $data_result['event_city'];
			$evntsttm_frmt = date('h:i A',strtotime($data_result['start_date']));
            if($typo=='1'){
                $typeflag='an Artist';
            }elseif($typo=='2'){
                $typeflag='a Group';
            }
            else{
                $typeflag='a Venue';
            }
            
            
			//if($data_result['rcsipsbb'] == "REDCLOCK")
			if (in_array("REDCLOCK", $picArray))
			{
				if (in_array("PURPLE", $picArray))
				{
						//$iconpic2 = BASEURLPUBLICCUSTOM."front/images/box_icon.png";
                        $iconpic2 = BASEURLPUBLICCUSTOM."front/images/box_icon.gif";
				}
				$iconpic = BASEURLPUBLICCUSTOM."/front/images/clock-red.gif";
                //$iconpic = BASEURLPUBLICCUSTOM."/front/images/clock-red.png";
            
            $textmsg = "Negotiation process is going on <br>".$evntstdt_frmt." - ".$evntsttm_frmt."<br>".$genrename." genre - ".$categoryname." skill in ".$eventtown;
			
			}
			else if(in_array("STARICON", $picArray))
			{
			
				$currntDate = strtotime(date("Y-m-d"));
				$evnteddt_frmt_Date = strtotime($data_result['end_date']);
                
				
				if($currntDate > $evnteddt_frmt_Date)
				{
					
					if($gig_rev == '1'){
						//$iconpic = BASEURLPUBLICCUSTOM."/front/images/Star.png";
                        $iconpic = BASEURLPUBLICCUSTOM."/front/images/Star.gif";
					}else if($gig_rev == '0'){
						$iconpic = BASEURLPUBLICCUSTOM."/front/images/Gif-star-2.gif";
						$review = 'reviewcustpop';
					}
					
				}else{
					//$iconpic = BASEURLPUBLICCUSTOM."/front/images/yellow_star.png";
                    $iconpic = BASEURLPUBLICCUSTOM."/front/images/yellow_star.gif";
				}
				
			
			$textmsg = $evntstdt_frmt." - ".$evntsttm_frmt."<br> You hae a confirmed bookiing as ".$typeflag."<br>".$genrename." genre - ".$categoryname." skill in ".$eventtown;
			
			}
			else if(in_array("PURPLE", $picArray))
			{
			//$iconpic = BASEURLPUBLICCUSTOM."/front/images/box_icon.png";
            $iconpic = BASEURLPUBLICCUSTOM."/front/images/box_icon.gif";
            
            $textmsg = "Negotiation process is going on <br>".$evntstdt_frmt." - ".$evntsttm_frmt."<br>".$genrename." genre - ".$categoryname." skill in ".$eventtown;
            
            $textmsg = "You have posted a Gig Offer on <br>".$evntstdt_frmt." - ".$evntsttm_frmt."<br>".$genrename." genre - ".$categoryname." skill in ".$eventtown;
			}
			else if(in_array("BLUEBOOK", $picArray))
			{
			//$iconpic = BASEURLPUBLICCUSTOM."/front/images/book_blue.png";
            $iconpic = BASEURLPUBLICCUSTOM."/front/images/book_blue.gif";
			
			$textmsg = "You have booked process is going on <br>".$evntstdt_frmt." - ".$evntsttm_frmt."<br>".$genrename." genre - ".$categoryname." skill in ".$eventtown;
			}
			else if(in_array("GREENGIG", $picArray))
			{
				$iconpic = BASEURLPUBLICCUSTOM."/front/images/box_icon-green.gif";
                //$iconpic = BASEURLPUBLICCUSTOM."/front/images/box_icon-green.png";
					if($typo=='1')
					{
						
                        $textmsg = $bookername." has posted a Gig Offer for Artist on <br>".$evntstdt_frmt." - ".$evntsttm_frmt."<br>".$genrename." genre - ".$categoryname." skill in ".$eventtown;
					}
					else if($typo=='2')
					{
                        
                        $textmsg = $bookername." has posted a Gig Offer for Group on <br>".$evntstdt_frmt." - ".$evntsttm_frmt."<br>".$genrename." genre - ".$categoryname." skill in ".$eventtown;
					}
			}
			?>
			<li>
			<img class="rosterlefticonclass" src="<?php echo $iconpic;?>">
			<?php
				if($iconpic2!=''){
				
						?>
						<img class="rosterlefticonclass" src="<?php echo $iconpic2;?>">
						<?php
				
				}
			?>
			
			<a href="javascript:void(0)" class="gig_request viewgig <?php echo $review;?>" data-id="<?php echo $gigunique;?>" data-bkrorart="<?php echo $bookerorartist;?>" data-gigtype="<?php echo $gigtype;?>"  data-gigid="<?php echo $gigid;?>" data-typo="<?php echo $typo;?>"  data-offbid="<?php echo $ggbid;?>" >
			
			<?php echo $textmsg;?>
				
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
		

	
	}else{
	?>
        <li>
            <a href="javascript:void(0)">
				Event details display here.
            </a>
        </li>
	<?php
	}
	?>
								
		<li>
		


        </li>
										



        

										
	</ul>
</div>
    
    
    