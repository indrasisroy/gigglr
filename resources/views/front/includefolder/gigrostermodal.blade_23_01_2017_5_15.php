 
  <?php

   //***************** fetching data for tooltip mesages starts here

   
                $fetchtypetooltip='multiple'; 
                $tablenametooltip="tooltip_message";
                $fieldnamestooltip="tooltip_label,tooltip_message";
                $whereartooltip=array();
                $infieldname='tooltip_label';
                $inar=array('Security-deposit','Total-payment','Cancellation-fee','Duration','Request-expire-datetime','start-time','Is this a private event');
                $orderbyfieldtooltip="id"; $orderbytypetooltip="asc";
                $limitstarttooltip=0;$limitendtooltip=0; 
                $securitydeposit_heading=''; 
                $totalpaymenet_heading=''; 
                $cancellationfee_heading=''; 
                $duration_heading=''; 
                $starttime_heading ='';

                $reqespiredatetime_heading=''; 
                $privateorpubliccheck ='';
                

                $frontwelcomedata_tooltip=getdatafromtable($fetchtypetooltip,$tablenametooltip,$fieldnamestooltip,$whereartooltip,$orderbyfieldtooltip='',$orderbytypetooltip,$limitstarttooltip,$limitendtooltip,$forinnotin=1,$forinnotin_type='IN',$infieldname,$inar);

                if(!empty($frontwelcomedata_tooltip))
                {
                  $securitydeposit_heading=stripslashes($frontwelcomedata_tooltip[0]->tooltip_message);
                  $totalpaymenet_heading = stripslashes($frontwelcomedata_tooltip[1]->tooltip_message);

                  $cancellationfee_heading=stripslashes($frontwelcomedata_tooltip[2]->tooltip_message);
                  $duration_heading = stripslashes($frontwelcomedata_tooltip[3]->tooltip_message);

                  $reqespiredatetime_heading=stripslashes($frontwelcomedata_tooltip[4]->tooltip_message);

                  $starttime_heading=stripslashes($frontwelcomedata_tooltip[5]->tooltip_message);

                  $privateorpubliccheck=stripslashes($frontwelcomedata_tooltip[6]->tooltip_message);
                }

//***************** fetching data for tooltip mesages end

 
  $front_sess= session('front_id_sess');
  $event_address1 = "";
  $event_address2 = "";
  $city_gig = "";
  $zip_gig = "";
  $bid_type = 0;
  
  $event_type = "";
  $type_flag = "";
  $giguniqueid = "";
  $booker_id_1 = "";
  
  $booking_cancellation_fee_gig = "";
  $artist_security_deposit_gig = "";
  $total_amount_gig = "";
  
  $event_date = "";
  $event_start_time = "";
  $event_end_date = "";
  $event_end_time = "";
  
  $request_expire_date = "";
  $request_expire_time = "";
  $gig_description_gig = "";
  $gigmaster_id = "";
  $gigpostrequestflag = "";
  $gigmasterbooking_status = '';
  $first_accepted_by = '';
  
    //******************added in 25-08-16 for gig master table change start **************//
    $gig_m_bcf_lock_id = "";
    $gig_m_asd_lock_id = "";
    $gig_m_ta_lock_id = "";
    //******************added in 25-08-16 for gig master table change end **************//
    
    $gig_description = "";

  if(!empty($gig_master_details)){
  //print_r($gig_master_details);die;
  
    //******************added in 25-08-16 for gig master table change start **************//
    $gig_m_bcf_lock_id = $gig_master_details->bcf_lock_id;
    $gig_m_asd_lock_id = $gig_master_details->asd_lock_id;
    $gig_m_ta_lock_id = $gig_master_details->ta_lock_id;
    //******************added in 25-08-16 for gig master table change end **************//
    
  $gigmaster_id = $gig_master_details->id;
  $giguniqueid = $gig_master_details->giguniqueid;


  $booker_id_1 = $gig_master_details->booker_id; 
  $event_address1 = $gig_master_details->event_address1;
  $event_address2 = $gig_master_details->event_address2;
  $city_gig = $gig_master_details->event_city;
  $zip_gig = $gig_master_details->event_zip;
  
  $event_type = $gig_master_details->event_type;
  $type_flag = $gig_master_details->type_flag;
  $gigpostrequestflag = $gig_master_details->gigpostrequestflag;
  $gigmasterbooking_status = $gig_master_details->booking_status;
  if($event_type =="1"){
  $event_type_for = "Public";
  }else if($event_type =="2"){
  $event_type_for = "Private";
  }else{
  $event_type_for = "Public and Private";
  }
  
  if($type_flag =="1"){
  $type_flag_for = "Artist";
  }else if($type_flag =="2"){
  $type_flag_for = "Group";
  }else{
  $type_flag_for = "Vanue";
  }
  $artist_id = $gig_master_details->artist_id;
  
  $booking_cancellation_fee_gig = $gig_master_details->booking_cancellation_fee;
  $artist_security_deposit_gig = $gig_master_details->artist_security_deposit;
  $total_amount_gig = $gig_master_details->total_amount;
  
  $event_date = $gig_master_details->event_date;
  $event_start_time = $gig_master_details->event_start_time;
  $event_end_date = $gig_master_details->event_end_date;
  $event_end_time = $gig_master_details->event_end_time;
  
  $request_expire_date = $gig_master_details->request_expire_date;
  $request_expire_time = $gig_master_details->request_expire_time;
  $gig_description = html_entity_decode($gig_master_details->gig_description);

  //***************** Offer expires calculation starts here

$dayelapsed='';
$hourelapsed='';
$minselapsed='';
$booking_req_date = $gig_master_details->booking_req_date;
$req_expires = $gig_master_details->request_expire;


$secondsInAMinute = 60; 
$secondsInAnHour = 60 * $secondsInAMinute; 
$secondsInADay = 24 * $secondsInAnHour; 

 $days = floor($req_expires / $secondsInADay); 

$hourSeconds = $req_expires % $secondsInADay; 
$hours = floor($hourSeconds / $secondsInAnHour);

$minuteSeconds = $hourSeconds % $secondsInAnHour; 
 $minutes = floor($minuteSeconds / $secondsInAMinute); 
 $curdate=date('Y-m-d H:i:s');
 

$currtimestamp = strtotime($curdate);

$nowdate = date('Y-m-d H:i:s', strtotime($booking_req_date. ' + '.$days. 'days' .$hours. 'hours' .$minutes. 'minutes'));

 $nowtimestamp = strtotime($nowdate); 
 if($nowtimestamp>$currtimestamp)
 {
     $currentdatetime = new DateTime($curdate);
     $nowdatetime = new DateTime($nowdate);
     $dayinterval = $nowdatetime->diff($currentdatetime);

      $dayelapsed = $dayinterval->format('%a');
  
      $hourelapsed = $dayinterval->format('%h');
   
      $minselapsed = $dayinterval->format('%i');

 }



   //***************** Offer expires calculation ends here
  

  //***************** Duration calculation starts here

          $eventstartdatetimeval = $gig_master_details->event_start_date_time;
          $eventenddatetimeval   = $gig_master_details->event_end_date_time;

          $eventstartdatetimeval = new DateTime($eventstartdatetimeval);
          $eventenddatetimeval   = new DateTime($eventenddatetimeval);

          $interval = date_diff($eventenddatetimeval,$eventstartdatetimeval);

          $r1 = $interval->format('%H');
          $r2 = $interval->format('%I');



  //***************** Duration calculation ends here




  }
      $booking_cancellation_fee = "";
	  $bcf_lock_id = "";
	  $artist_security_deposit = "";
	  $asd_lock_id = "";
	  $total_amount = "";
	  $ta_lock_id = "";
	  
	  $gig_bidrequest_details_id = "";
      $gig_bid_status = "";
      $booker_id_bid = "";
      $last_updated_by = "";
      $last_updated_by_bid = "";
      $bid_request_artist_id = "";
      $first_accepted_by='';
  if(!empty($gig_bidrequest_details)){
  // echo "<pre>";
  // print_r($gig_bidrequest_details);die;

      $first_accepted_by = $gig_bidrequest_details->first_accepted_by;
      $last_updated_by_bid = $gig_bidrequest_details->last_updated_by;
      $bid_request_artist_id = $gig_bidrequest_details->artist_id;
	  $gig_bidrequest_details_id = $gig_bidrequest_details->id;
      $booker_id_bid = $gig_bidrequest_details->booker_id;
      $booking_cancellation_fee = $gig_bidrequest_details->booking_cancellation_fee;
	  $bcf_lock_id = $gig_bidrequest_details->bcf_lock_id;
	  $artist_security_deposit = $gig_bidrequest_details->artist_security_deposit;
	  $asd_lock_id = $gig_bidrequest_details->asd_lock_id;
	  $total_amount = $gig_bidrequest_details->total_amount;
	  $ta_lock_id = $gig_bidrequest_details->ta_lock_id;
	  $gig_description = html_entity_decode($gig_bidrequest_details->gig_description);
      $gig_bid_status = $gig_bidrequest_details->gig_bid_status;
  }
  $country_name = '';$state_name = '';
  $cat_name = ''; $gener = '';
  
	if($get_gig_country_details!=''){
	$country_name =$get_gig_country_details;
  }
	if($get_gig_state_details!=''){
	$state_name =$get_gig_state_details;
  }
    if($get_gig_Cat_details!=''){
	$cat_name =$get_gig_Cat_details;
  }
    if($get_gig_Gen_details!=''){
	$gener =$get_gig_Gen_details;
  }
  $booking_request_class = "";
  $booking_request_text = "";
  if($gigpostrequestflag == 1){
    $booking_request_class = "";
    if($front_sess == $booker_id_1){
        $booking_request_text = "your posted gig";
    }else{
    $booking_request_text = "your matched skill gig";
    }
    
    
  }else if($gigpostrequestflag == 2){
    if($gig_bid_status == '2'){
    $booking_request_text = "confirmed booking";
    }else{
    $booking_request_text = "booking request";
    }
    $booking_request_class = "booking_request";

  }

   $cancel_request_class = "";
     if($front_sess == $booker_id_1){
         $cancel_request_class ="Cancel";
          // $accecptidval ="accept_bid_reqst_booker";
          $accecptidval ="accept_bid_reqst_booker_artst";

     }
     else
      {
       $cancel_request_class ="Decline";
       // $accecptidval ="accept_bid_reqst";
       $accecptidval ="accept_bid_reqst_booker_artst";

     }
     

      $gigbidrequestsql = DB::select( DB::raw("SELECT * FROM gig_bidrequest WHERE giguniqueid = '$giguniqueid'") );

       $countgigbid = count($gigbidrequestsql);
    
  
  ?>

<!--negotiation process modal      -->
<!-- reqmodal1 starts -->
<div class="modal fade" id="reqmodal1" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog popup-dialog" role="document">
      <div class="modal-content popup-content artist_popup">
         <div class="modal-body popup-body">
            <div class="artist_hedr request booking_request">
               <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h2 id="booking">Booking Request</h2>
            </div>
            <div class="artist_form_outr clearfix">
                <h2><span>When </span>is your event</h2>
               <!--<form>-->
               <div class="Constitution-inner-first artist_list">
               </div>
               <div class="row">
     
                  <div class="col-md-6">
                    <div class="inline artist_list">
                        <span>Date of Event</span>
                        <div class="form-group inpt input-customm">
                           <div class='input-group date'>
                                <?php    
                echo Form::text("event_date", $value=date('d M Y', strtotime($event_date)), $attributes = array( "readonly","id"=>"event_date","class"=>"form-control clck_outr disablecolorclass" )); 
                                 ?>                              <span class="input-group-addon dt">
                              <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                           </div>
                        </div>
                     </div>
                    <div class="timer_absolute">
                     <div class="inline artist_list">
                             <span>Start Time</span>
                             <?php 

                             if($starttime_heading!='')
                             {

                             ?>
                              <a href="javascript:void(0)" type="button" class="helpIcon" aria-label="Help" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo stripslashes($starttime_heading) ?>"><i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a> 
                               
                           <?php 

                              }
                                ?>
                         </div>
                        <div class="form-group inpt input-customm clearfix newTimeWrap">
                           <div class="timeField">
                               <?php
                echo Form::text("event_start_time", $value=date('h', strtotime($event_start_time)), $attributes = array( "readonly","id"=>"event_start_time","class"=>"form-control clck_outr disablecolorclass" ));

                                 ?>
                           </div>
                           <div class="timeField">
                           <?php
                echo Form::text("event_start_time", $value=date('i', strtotime($event_start_time)), $attributes = array( "readonly","id"=>"event_start_time","class"=>"form-control clck_outr disablecolorclass" ));

                                 ?>
                           </div>
                           <div class="ampm">
                            <?php
                echo Form::text("event_start_time", $value=date('A', strtotime($event_start_time)), $attributes = array( "readonly","id"=>"event_start_time","class"=>"form-control clck_outr disablecolorclass" ));

                                 ?>
                          </div>
                        </div>
                     </div>
                     
                     <div class="timer_absolute timer_absoluteA">
                     <div class="inline artist_list">
                        <span>Duration</span>
                          <div class="form-group inpt input-customm clearfix newTimeWrap ">
                           <div class="timeField"> 
                            <?php
                echo Form::text("end_time_hr", $value=$r1, $attributes = array( "readonly","id"=>"end_time_hr","class"=>"form-control date_outr disablecolorclass","maxlength"=>"2","placeholder"=>"hh"  ));
                                 ?>
                            </div>
                            <div class="timeField hasInfo">
                             <?php
                                  echo Form::text("end_time_mnt", $value=$r2, $attributes = array( "readonly","id"=>"end_time_mnt","class"=>"form-control date_outr disablecolorclass","maxlength"=>"2","placeholder"=>"mm"  ));
                                  ?>
                       
                          <?php

                              if($duration_heading!='')
                          {
                               ?>         
                          <a href="javasript:void(0)" type="button" class="helpIcon" aria-label="Help" data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="<?php echo stripslashes($duration_heading) ?> "><i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                                  <?php

                    }
                     ?>   
                            </div>


                          </div>
                     </div> <!-- end of inline artist list -->
                      </div>
                  </div>
                  <div class="col-md-12">
                      <input type="hidden" name="artistID" value="114" id="artistID" >
                      <div class="custom_btn-Grp">

                     <button class="btn btn-warning artist_btn rqst_trm_btn agretoterm buttonpercentg" style="float: right;" id="reqmodalnextbutn1" type="button" data-toggle="modal">Next Page > </button>
                    </div>
                  </div>
               </div>
               <!--</form>-->
               </form>            </div>
         </div>
      </div>
   </div>
</div>  <!-- reqmodal1 ends -->
      <!-- reqmodal2 starts -->
<div class="modal fade" id="reqmodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog popup-dialog" role="document">
    <div class="modal-content popup-content artist_popup">
        <div class="modal-body popup-body">
      <div class="artist_hedr request booking_request">
               <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h2 id="booking">Booking Request</h2>
        </div>
        <div class="artist_form_outr clearfix">
            <h2><span>Where </span>is your event</h2>
           <!--  <form method="POST" action="http://52.10.11.14/betaprosessional" accept-charset="UTF-8" id="bookingform" class="" autocomplete="off"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="artist_divsn reqst_dvsn">
                          <div class="inline artist_list request_type">

                           <?php echo Form::text("address1_gig", $value=$event_address1, $attributes = array( "readonly","id"=>"address1_gig","class"=>"form-control form-control-B" ));

                echo Form::text("event_address2", $value=$event_address2, $attributes = array( "readonly","id"=>"address2_gig","placeholder"=>"Address2","class"=>"form-control form-control-B" ));
                
                ?>
                           <!--    <input type="text" class="form-control form-control-B" placeholder="Address1"/>-->
                 
              <!--   <input id="booking_location" class="form-control form-control-B" name="booking_location" type="text" value="">         
                <input id="booking_location_second" class="form-control form-control-B" placeholder="Address2" name="booking_location_second" type="text" value="">     -->                       
                 </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
                           <?php
                echo Form::text("country_name", $value=$country_name, $attributes = array( "readonly","id"=>"country_name","class"=>"form-control form-control-B" )); 
                ?>
                              <!--   <select class="selectpicker artist_txt">
                                    <option value="0">Australia</option>

                                    <option value="1">Spain</option>
                                    <option value="2">France</option>

                                </select> -->
                            </div>
                        </div>
                  </div>
                    <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
                          <?php               
               echo Form::text("state_name", $value=$state_name, $attributes = array( "readonly","id"=>"state_name","class"=>"form-control form-control-B" )); 
               ?>
                               <!--  <select class="selectpicker artist_txt">
                                    <option value="0">NSW</option>

                                    <option value="1">Tasmania</option>
                                    <option value="2">Norfolk Island</option>

                                </select> -->
                            </div>
                        </div>
                  </div>
                    <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
                                <!-- <input id="booking_location" class="form-control form-control-B" placeholder="Sydeny" name="booking_location" type="text" value=""> -->
                                   <?php echo Form::text("city_gig", $value=$city_gig, $attributes = array( "readonly","id"=>"city_gig","placeholder"=>"City","class"=>"form-control form-control-B")); ?>
                            </div>
                        </div>
                  </div>
                    <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
                          <?php echo Form::text("zip_gig", $value=$zip_gig, $attributes = array( "readonly","id"=>"zip_gig","placeholder"=>"ZIP","class"=>"form-control form-control-B")); ?>
                               <!-- <input id="booking_location" class="form-control form-control-B" placeholder="2000" name="booking_location" type="text" value=""> -->
                            </div>
                        </div>
                  </div>
                    <div class="col-sm-12">
                        <div class="radio_Check radio-check_B">
                            <span>Is this a private event? </span> &nbsp;
                            <?php 
                            if($event_type == 1)
                            {
                              echo "No";
                            }
                            else
                            {
                              echo "Yes";

                            }
                            if($privateorpubliccheck !='')
                              {
                               ?>

                          
                            <a href="javasript:void(0)" type="button" class="helpIcon" aria-label="Help" data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="<?php echo $privateorpubliccheck; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                             <?php 

                              }
                                ?>
                           <!--  <label class="radio-check"><input type="radio" name="gender" value="za">
                              <span></span>Yes</label>
                            <label class="radio-check"><input type="radio" name="gender" value="za" checked="checked">
                              <span></span>No</label> -->
                            <!-- <a href="javasript:void(0)" type="button" class="helpIcon" aria-label="Help" data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="Publish this event in Gig Guide? "><i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a> -->
                        </div>
                    </div>
                    <div class="col-sm-12">
                    <div class="btn_Adj">
                     <button class="btn btn-warning artist_btn rqst_trm_btn agretoterm buttonpercentg" style="float: left;"id="reqmodalpreviousbutn2" type="button" data-toggle="modal" data-target="#myModal5"> &#60; Previous Page </button>
                     <button class="btn btn-warning artist_btn rqst_trm_btn agretoterm buttonpercentg" style="float: right;" id="reqmodalnextbutn2" type="button" data-toggle="modal">Next Page ></button>
                    </div>
                   </div> 
                </div>
           <!--  </form> -->
        </div>
       </div> 
    </div>
  </div>
</div>
     
     <!-- reqmodal2 ends -->
     <!-- reqmodal3 starts -->

<div class="modal fade" id="reqmodal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog popup-dialog" role="document">
    <div class="modal-content popup-content artist_popup">
        <div class="modal-body popup-body">
      <div class="artist_hedr request booking_request">
               <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h2 id="booking">Booking Request</h2>
        </div>
        <div class="artist_form_outr clearfix">
            <h2><span>What </span>Do you require</h2>
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="inline artist_list">
                            <span>Skill Group</span>
                            <div class="artist_divsn">
                             <div class="inline artist_list request_list">
                             <?php           
              echo Form::text("cat_name", $value=$cat_name, $attributes = array( "readonly","id"=>"cat_name","class"=>"form-control form-control-B" ));                 
            ?>
                               <!-- <select id="bookingcat_sub" class="selectpicker artist_txt" title="DJ" name="bookingcat_sub"><option value="117">Comedian</option><option value="147">DJ</option><option value="127">Dancer</option></select> -->
                               </div>
                             </div>
                        </div>
                     </div>
                    
                    <div class="col-md-6">
                     <div class="inline artist_list">
                         <span>Genre</span>
                         <div class="artist_divsn">
                        <div class="inline artist_list request_list">
                        <?php           
              echo Form::text("gener", $value=$gener, $attributes = array( "readonly","id"=>"gener","class"=>"form-control form-control-B" ));            
            ?>
                           <!-- <select id="bookinggenre_sub" class="selectpicker artist_txt" title="Required" name="bookinggenre_sub"></select>   -->             
                             </div>
                     </div>
                     </div>
                  </div>
                     <div class="col-md-12">
                     <div class="inline artist_list" id="tech_speech_div">
                        <!--                      <span>Tech Specs</span>-->
                        <!--<div class="form-group inpt nb">-->
                        <!--</div>-->
                         <span>Enter details or specifics here</span>
						      <textarea id="gig_description" maxlength="1000" class="form-group inpt nb form-control" name="gig_description" cols="50" rows="10" placeholder="please assit artist(s) by describing any venue specifics such as: parking areas,access times or areas,set up times, back stage areas,stage size, on-site contact person details, lift access or any other technical requirements or concerns in this area here."><?php echo $gig_description ; ?></textarea>                                       <!-- <p> 5 lines, 50 characters maximum per line</p> ----> 
                    </div>
							<input type="hidden" id="fieldtocountnegotiation" value="1000">
							 <p  id="CharCountLabelnegotiation" ></p>
                  </div>
                    <div class="col-sm-12">
                    <div class="btn_Adj">
                     <button class="btn btn-warning artist_btn rqst_trm_btn agretoterm buttonpercentg" style="float: left;" id="reqmodalpreviousbutn3" type="button" data-toggle="modal" data-target="#myModal_6"> &#60; Previous Page </button>
                     <button class="btn btn-warning artist_btn rqst_trm_btn agretoterm buttonpercentg" style="float: right;" id="reqmodalnextbutn3" type="button" data-toggle="modal">Last Page ></button>
                    </div>
                   </div> 
                </div>
        </div>
       </div> 
    </div>
  </div>
</div> <!-- reqmodal3 ends -->

<!-- reqmodal4 starts -->

<div class="modal fade" id="reqmodal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog popup-dialog" role="document">
    <div class="modal-content popup-content artist_popup">
        <div class="modal-body popup-body">
      <div class="artist_hedr request booking_request">
               <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h2 id="booking">Booking Request</h2>
        </div>
        <div class="artist_form_outr clearfix">
            <h2><span>Your </span>budget / offer</h2>
           <!--  <form method="POST" action="http://52.10.11.14/betaprosessional" accept-charset="UTF-8" id="bookingform" class="" autocomplete="off"> -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="timer_absolute timer_absoluteZ">
                        <div class="inline artist_list">
                        <span>Total Payment</span>
                        <div class="form-group inpt input-customm">
                             <div class='input-group date hasInfo'>
                           <span class="dollar">$</span>
                                  <?php
                 if($gig_bidrequest_details_id!=""){
                                 echo Form::text("total_payment_gig",
                                 $value=$total_amount,
                                 $attributes = array( "id"=>"total_payment_gig",
                                 "class"=>"form-control clck_outr lck_outr totalpayimg",
                                 "placeholder"=>"0.00",
                                 "maxlength"=>"16"
                                 ));
                 }
                                 
                                  else if(($gigpostrequestflag == 1) && ($front_sess == $booker_id_1)){
                           
                                  
                                   echo Form::text("total_payment_gig",
                                    $value=$total_amount_gig,
                                    $attributes = array( "readonly","id"=>"total_payment_gig",
                                    "class"=>"form-control clck_outr lck_outr totalpayimg",
                                    "placeholder"=>"0.00",
                                    "maxlength"=>"16"
                                 ));

                                  }

                                 else{
                 echo Form::text("total_payment_gig",
                                 $value=$total_amount_gig,
                                 $attributes = array( "id"=>"total_payment_gig",
                                 "class"=>"form-control clck_outr lck_outr totalpayimg",
                                 "placeholder"=>"0.00",
                                 "maxlength"=>"16"
                                 ));
                 }
                                 ?>





                              <!-- <input id="total_payment" class="form-control clck_outr lck_outr" maxlength="16" name="total_payment" type="text" value="600.00">   -->
                    <span class="input-group-addon clck clickable" id="total_payment_gigspanclick">
                              <span class="glyphicon lck">
                              <div id="totalpayimg_div" data-totalpayimgflag=''>
                							  <!-- <div id="totalpayimg_div" data-totalpayimgflag='0'>
                                   <img src="http://52.10.11.14/betaprosessional/public/front/images/lock.png" alt="">-->
                                </div> 
							               </span>
                       </span>

                           <?php

                              if($totalpaymenet_heading!='')
                          {
                               ?>    
                               <a href="javascript:void(0)" type="button" class="helpIcon bookingfrommarginleft" aria-label="Help" data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="<?php echo $totalpaymenet_heading;?>"><i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                             <?php 

                          }
                                ?>
                                
                           </div>
                        </div>
                     </div>
                      </div>
                    <div class="timer_absolute timer_absoluteZ">
                    <div class="inline artist_list">
                        <span>Security Deposit</span>
                        <div class="form-group inpt input-customm">
                           <div class="input-group date hasInfo">
                           <span class="dollar">$</span>
                              <?php
                if($gig_bidrequest_details_id!=""){
                
                                 echo Form::text("security_payment_gig",
                                 $value=$artist_security_deposit,
                                 $attributes = array( "id"=>"security_payment_gig",
                                 "class"=>"form-control clck_outr lck_outr securityimg",
                                 "placeholder"=>"0.00",
                                 "maxlength"=>"16",
                 
                                 ));
                }
                           else if(($gigpostrequestflag == 1) && ($front_sess == $booker_id_1)){
                           
                             echo Form::text("security_payment_gig",
                                 $value=$artist_security_deposit_gig,
                                 $attributes = array( "readonly","id"=>"security_payment_gig",
                                 "class"=>"form-control clck_outr lck_outr securityimg",
                                 "placeholder"=>"0.00",
                                 "maxlength"=>"16",
                 
                                 ));
                            
                            }
                              else{
                                 echo Form::text("security_payment_gig",
                                 $value=$artist_security_deposit_gig,
                                 $attributes = array( "id"=>"security_payment_gig",
                                 "class"=>"form-control clck_outr lck_outr securityimg",
                                 "placeholder"=>"0.00",
                                 "maxlength"=>"16",
                 
                                 ));
                }

                                 ?>
                            <!--   <input id="security_payment" class="form-control clck_outr lck_outr" maxlength="16" name="security_payment" type="text">  -->
                              <span class="input-group-addon clck clickable" id="security_payment_gigspanclick">
                              <span class="glyphicon lck">
                                <div id="securityimg_div">
                             <!--  <div id="securityimg_div" data-securityimgflag="0"><img src="http://52.10.11.14/betaprosessional/public/front/images/lock.png" alt="">-->
                              </div> 
                              </span>
                              </span>
                              <?php

                              if($securitydeposit_heading!='')
                            {
                               ?>

                                <a href="javascript:void(0)" type="button" class="helpIcon bookingfrommarginleft" aria-label="Help" data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="<?php echo $securitydeposit_heading?>"><i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                               <?php 

                              }
                                ?>
                                

                           </div>
                        </div>
                     </div>
                    </div>
                    <?php
            
            if($artist_id!='0'){
            ?>
                    <div class="timer_absolute timer_absoluteZ">
                    <div class="inline artist_list">
                        <span>Cancellation Fee</span>
                        <div class="form-group inpt input-customm input-customm-2">
                           <div class="input-group date hasInfo">
                           <span class="dollar">$</span>

                           <?php
                if($gig_bidrequest_details_id!=""){
                   echo Form::text("cancellation_fee",
                   $value=$booking_cancellation_fee,
                   $attributes = array( "id"=>"cancellation_fee",
                   "class"=>"form-control clck_outr lck_outr bookingcanimg hello",
                   "placeholder"=>"0.00",
                   "maxlength"=>"16"
                   ));
                   }else{
                   echo Form::text("cancellation_fee",
                   $value=$booking_cancellation_fee_gig,
                   $attributes = array( "id"=>"cancellation_fee",
                   "class"=>"form-control clck_outr lck_outr bookingcanimg",
                   "placeholder"=>"0.00",
                   "maxlength"=>"16"
                   ));
                   }
                   ?>

                             <!--  <input id="cancellation_payment" class="form-control date_outr lck_outr" maxlength="16" name="cancellation_payment" value="" type="text">  -->   
                           <span class="input-group-addon dt clck clickable" id="cancellation_payment_gigspanclick">
                              <span class="glyphicon lck">
                              <div id="bookingcanimg_div" data-bookingcanimgflag="">
							  <!-- <div id="bookingcanimg_div" data-bookingcanimgflag="0"><img src="http://52.10.11.14/betaprosessional/public/front/images/lock.png" alt=""> -->
                </div>
							  </span>
                              </span>
                             <?php

                              if($cancellationfee_heading!='')
                          {
                               ?>
                                
                               <a href="javascript:void(0)" type="button" class="helpIcon bookingfrommarginleft" aria-label="Help" data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="<?php echo $cancellationfee_heading;?> "><i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                      
                                <?php 

                    }
                      ?>


                           </div>
                        </div>
                     </div>
                    </div>
                </div>
                <?php
            }
            ?>
                <div class="col-sm-6">
                    <div class="timer_absolute timer_absoluteB timer_absoluteBA">
                      <div class="inline artist_list ">
                        <span>Offer Expires</span>
                        <div class="form-group inpt input-customm input-customm-color hasInfo artist_listB">
                            <div class="timeField">
                            <?php
                echo Form::text("reqexpire_time_day", $value=$dayelapsed, $attributes = array( "id"=>"reqexpire_time_day","class"=>"form-control date_outr clck_outr fadeY","maxlength"=>"2","placeholder"=>"DD"  ));
                                 ?>
                              <!-- <input type='text' maxlength="2" class="form-control date_outr clck_outr fadeY" placeholder="DD" id="requexpire_time_hr" name="requexpire_time_hr" /> -->
                              </div>
                              <div class="timeField">
                              <?php
                echo Form::text("reqexpire_time_hrs", $value=$hourelapsed, $attributes = array( "id"=>"reqexpire_time_hrs","class"=>"form-control date_outr clck_outr fadeY","maxlength"=>"2","placeholder"=>"HH"  ));
                                 ?> 
                              <!-- <input type='text' maxlength="2" class="form-control date_outr clck_outr fadeY" placeholder="HH" id="reqexpire_time_mnt" name="reqexpire_time_mnt" /> -->
                              </div>
                            <div class="timeField">
                            <?php
                echo Form::text("reqexpire_time_mnt", $value=$minselapsed, $attributes = array( "id"=>"reqexpire_time_mnt","class"=>"form-control date_outr clck_outr fadeY","maxlength"=>"2","placeholder"=>"MM"  ));
                                 ?>
                              <!-- <input type='text' maxlength="2" class="form-control date_outr clck_outr fadeY" placeholder="MM" id="reqexpire_time_mnt" name="reqexpire_time_mnt" /> -->
                              </div>
                           
                          <?php 
                           if($reqespiredatetime_heading !='')
                           {
                           ?>
                            <a href="javasript:void(0)" type="button" class="helpIcon" aria-label="Help" data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="<?php echo stripslashes($reqespiredatetime_heading); ?> "><i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                           <?php 

                            }
                                ?>

                        </div>
                     </div>
                      </div>
                    <div class="timer_absolute timer_absoluteB" style="opacity:0;">
                      <div class="inline artist_list">
                        <span>Request Expires</span>
                        <div class="form-group inpt input-customm input-customm-color hasInfo">
                           <div class='input-group date'>
                              <input id="requestexpireddate" class="form-control clck_outr datetimepicker" name="requestexpireddate" type="text" value="">                              <span class="input-group-addon dt">
                              <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                           </div>

                           
                            <a href="javasript:void(0)" type="button" class="helpIcon" aria-label="Help" data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="Request expire date time text message "><i class="fa fa-question-circle" aria-hidden="true"  style="display: none;">></i>
                                </a>

                        </div>
                     </div>
                      </div>

                 
                       <div class="radio_Check radio_CheckC">
                        <span>Do you agree with the<br><a href="<?php echo url('terms-and-conditions');?>" target="_blank">Terms &amp; Conditions </a></span>
                       <div class="adj-baje">
                        <label class="radio-check"><input type="radio" name="i_agree" id="i_agree_id" value="zb">
                          <span></span>Yes</label>
                        <label class="radio-check"><input type="radio" name="i_agree" value="za" checked="checked">
                          <span></span>No</label>
                        </div>
                    </div>
                    

                </div>
                    <div class="col-sm-12">
                   
                     <div class="customBtn-group customBtn-groupCU clearfix">
                            <div class="col-sm-Cu">
                            <button class="btn btn-warning artist_btn rqst_trm_btn agretoterm buttonpercentg" id="reqmodalpreviousbutn4" type="button" data-toggle="modal" > < page </button>
                            </div>
                            <div class="col-sm-Cu">
                            <button class="btn btn-warning artist_btn rqst_trm_btn decline_A" type="button" id="cancel_bid_reqst"><?php echo $cancel_request_class; ?></button>
                            </div>
                            <div class="col-sm-Cu" id="renegdiv">
                            <button class="btn btn-warning artist_btn rqst_trm_btn reneg"  type="button" id="negotiated_bid_reqst">reneg</button>
                            </div>
                           <div class="col-sm-Cu" id="acceptdiv">
                           
                            <button class="btn btn-warning artist_btn rqst_trm_btn green_A" type="button" id="<?php echo $accecptidval; ?>">accept</button> 
                           </div>

                           <input type="hidden" value="" id="whoamiidval">
                           <input type="hidden" value="" id="whoamitextval"> 
                           <input type="hidden" value="" id="whoamiagv">
                           <input type="hidden" id="submittrueorflase">
                      </div>
                         

                   
                   </div> 
                </div>
            <!-- </form> -->
        </div>
       </div> 
    </div>
  </div>
</div>  <!-- reqmodal4 ends -->



<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendGigRosterAjax.js"></script>
<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendroster.js"></script>
<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/jquery.maskMoney.js"></script>
<script>
 var lockImg = "<img src='{{ URL::asset('public/front')}}/images/lock2.png' alt=''>";
	  var unlockImg = "<img src='{{ URL::asset('public/front')}}/images/lock.png' alt=''>";
	  var gig_type = "<?php echo $bid_type;?>";
	  var gigmaster_id = "<?php echo $gigmaster_id;?>";
      var gig_bid_status = "<?php echo $gig_bid_status;?>";
      var gigpostrequestflagjs = "<?php echo $gigpostrequestflag;?>";
      
	  var ta_lock_id_p = "<?php echo $ta_lock_id;?>";
    // alert(ta_lock_id_p);
      var bcf_lock_id_p = "<?php echo $bcf_lock_id;?>";
      var asd_lock_id_p = "<?php echo $asd_lock_id;?>";
      
	  var gig_bidrequest_id = "<?php echo $gig_bidrequest_details_id;?>";

if(gig_bidrequest_id == '')
{
  console.log("Gig bid table value is empty");
  console.log("Total amount lock id is "+gig_m_bcf_lock_id);
  console.log("cancellation amount lock id is "+gig_m_asd_lock_id);
  console.log("security amount lock id is "+gig_m_ta_lock_id);
}else
{
 console.log("Gig bid table value "+gig_bidrequest_id);  
}


	  var gigunique_id = "<?php echo $giguniqueid;?>";
	  var booker_id = "<?php echo $booker_id_1;?>";
	  var artist_id = "<?php echo $artist_id;?>";
	  var type_flag = "<?php echo $type_flag;?>";
      var bid_request_artist_id = "<?php echo $bid_request_artist_id;?>";
      var last_updated_by_bid = "<?php echo $last_updated_by_bid;?>";
      var negotiation_id = "<?php echo '0' ;?>";   
      var first_accepted_by = "<?php echo $first_accepted_by;?>";


     


	  
    //******************added in 25-08-16 for gig master table change start **************//
    var gig_m_bcf_lock_id = "<?php echo $gig_m_bcf_lock_id;?>";
    console.log(" gig_m_bcf_lock_id "+gig_m_bcf_lock_id);
    var gig_m_asd_lock_id = "<?php echo $gig_m_asd_lock_id;?>";
    var gig_m_ta_lock_id = "<?php echo $gig_m_ta_lock_id;?>";
    
    var  totalamoutnlockflag = '';
    var  securityamoutnlockflag = '';
    var  cancellationamoutnlockflag = '';


if(gig_bidrequest_id == '')
{

    //alert(" gig_m_ta_lock_id "+gig_m_ta_lock_id);
    if (gig_m_ta_lock_id == '' || gig_m_ta_lock_id == '0') {

     // totalamoutnlockflag='';
     // alert(" gig_m_ta_lock_id here "+gig_m_ta_lock_id);
        totalamoutnlockflag ='';
        $("#totalpayimg_div").html(unlockImg);
        $('#totalpayimg_div').data('totalpayimgflag',0);
        $('#totalpayimg_div').data('totalpay_lock_by',0);
    }else{

    // console.log("Here first");
 // alert(" gig_m_ta_lock_id here "+gig_m_ta_lock_id);
        totalamoutnlockflag ='BKR';
       // $('#total_payment_gig').attr('readonly', true);
        $('#total_payment_gig').attr('readonly', true);
        $("#totalpayimg_div").html(lockImg);
        $('#totalpayimg_div').data('totalpayimgflag',1);
        $('#totalpayimg_div').data('totalpay_lock_by',gig_m_ta_lock_id);
        //$('#total_payment_gig').attr('disabled', 'disabled');
        // $('#totalpayimg_div').removeClass("clickable");
        $('#total_payment_gigspanclick').removeClass("clickable");
        
        ta_lock_id_p = gig_m_ta_lock_id;
        
    }
    
    if (gig_m_asd_lock_id == '' || gig_m_asd_lock_id == '0') {
        securityamoutnlockflag = '';
        $("#securityimg_div").html(unlockImg);
        $('#securityimg_div').data('securityimgflag',0);
        $('#securityimg_div').data('security_lock_by',0);
    }else{
          securityamoutnlockflag = 'BKR';
     // console.log("Here second");
        $("#securityimg_div").html(lockImg);
        $('#securityimg_div').data('securityimgflag',1);
        $('#securityimg_div').data('security_lock_by',gig_m_asd_lock_id);
        $('#security_payment_gig').attr('disabled', 'disabled');
        // $('.securityclck').parent().removeClass("clickable");
        $('#security_payment_gigspanclick').removeClass("clickable");
        
        asd_lock_id_p = gig_m_asd_lock_id;
    }
    
    
    if (gig_m_bcf_lock_id=='' || gig_m_bcf_lock_id =='0') {
      cancellationamoutnlockflag='';
        $("#bookingcanimg_div").html(unlockImg); 
        $("#bookingcanimg_div").data('bookingcanimgflag',0);
        $('#bookingcanimg_div').data('booking_lock_by',0);
    }else{
          cancellationamoutnlockflag='BKR';
      //console.log("Here third");
        $("#bookingcanimg_div").html(lockImg); 
        $('#bookingcanimg_div').data('bookingcanimgflag',1);
        $('#bookingcanimg_div').data('booking_lock_by',gig_m_bcf_lock_id);
        $('#cancellation_fee').attr('disabled', 'disabled');
        // $('.bookingcanclck').parent().removeClass("clickable");
        $('#cancellation_payment_gigspanclick').removeClass("clickable");
        
        bcf_lock_id_p = gig_m_bcf_lock_id;
        
    }
  }
  // else
  // {
  //   console.log(" ta_lock_id_p here === >"+ta_lock_id_p);
  // }

     //******************added in 25-08-16 for gig master table change end **************//

    var negotiate_flg = 0;
   	//$('#total_payment_gig').maskMoney({prefix:'$'}); //******masking for total payment
   	//$('#cancellation_fee').maskMoney({prefix:'$'});//******masking for cancellation payment
   	//$('#security_payment_gig').maskMoney({prefix:'$'});//*******masking for security payemnt

    if(gig_bidrequest_id != '')
{
	
    if (ta_lock_id_p == '' || ta_lock_id_p == '0') {

        totalamoutnlockflag = '';
        $("#totalpayimg_div").html(unlockImg);
        $('#totalpayimg_div').data('totalpayimgflag',0);
        $('#totalpayimg_div').data('totalpay_lock_by',0);
    }else{
         totalamoutnlockflag = '<?php echo $gig_bidtotallockflag ;?>';

         // console.log(" totalamoutnlockflag abc"+totalamoutnlockflag);

        $("#totalpayimg_div").html(lockImg);
        $('#totalpayimg_div').data('totalpayimgflag',1);
        $('#totalpayimg_div').data('totalpay_lock_by',ta_lock_id_p);
        $('#total_payment_gig').attr('disabled', 'disabled');
        // $('.totalclck').removeClass("clickable");
         $('#total_payment_gigspanclick').removeClass("clickable");
        negotiate_flg = 1;
        
    }
    
    if (asd_lock_id_p == '' || asd_lock_id_p == '0') {
      securityamoutnlockflag ='';
        $("#securityimg_div").html(unlockImg);
        $('#securityimg_div').data('securityimgflag',0);
        $('#securityimg_div').data('security_lock_by',0);
    }else{

        securityamoutnlockflag = '<?php echo $gig_bid_securitylockflag ;?>';
        $("#securityimg_div").html(lockImg);
        $('#securityimg_div').data('securityimgflag',1);
        $('#securityimg_div').data('security_lock_by',asd_lock_id_p);
        $('#security_payment_gig').attr('disabled', 'disabled');
        // $('.securityclck').removeClass("clickable");
         $('#security_payment_gigspanclick').removeClass("clickable");
        negotiate_flg = 1;
    }
    
    
    if (bcf_lock_id_p=='' || bcf_lock_id_p =='0') {

        cancellationamoutnlockflag='';
        $("#bookingcanimg_div").html(unlockImg); 
        $("#bookingcanimg_div").data('bookingcanimgflag',0);
        $('#bookingcanimg_div').data('booking_lock_by',0);
    }else{

        cancellationamoutnlockflag='<?php echo $gig_bid_cancellationflag ;?>';

        $("#bookingcanimg_div").html(lockImg); 
        $('#bookingcanimg_div').data('bookingcanimgflag',1);
        $('#bookingcanimg_div').data('booking_lock_by',bcf_lock_id_p);
        $('#cancellation_fee').attr('disabled', 'disabled');
        // $('.bookingcanclck').removeClass("clickable");
        $('#cancellation_payment_gigspanclick').removeClass("clickable");
        negotiate_flg = 1;
        
    }

}

    
    if (gigpostrequestflagjs == 1) {
        if ((parseInt(asd_lock_id_p )> 0) && (parseInt(ta_lock_id_p)> 0)) {
            $('.reqst_btn_dvlr_negotiated').hide();
        }
    }else{
        if ( (parseInt(bcf_lock_id_p )> 0) && (parseInt(asd_lock_id_p )> 0) && (parseInt(ta_lock_id_p)> 0)) {
            $('.reqst_btn_dvlr_negotiated').hide();
        }
    }




$(document).ready(function(){
 
 //***************** Who am I starts here *************
  var whoami_text = "<?php echo $w_am_i;?>";
  var whoami_id = "<?php echo $w_am_i_id;?>";
  var w_am_id_agv = "<?php echo $w_am_id_agv;?>";

  console.log(" whoami_text =>"+whoami_text);
  console.log(" whoami_id "+whoami_id);
   console.log(" w_am_id_agv "+w_am_id_agv);
   var readyta  ='<?php echo $gig_bidtotallockflag; ?>';
   console.log(" ta_lock_id_p in ready"+readyta);
  

  $("#whoamiidval").val(whoami_id);
  $("#whoamitextval").val(whoami_text);
  $("#whoamiagv").val(w_am_id_agv);

  // console.log("My status is updated by id "+whoami_id);
  // console.log("My status is updated by text "+whoami_text);

  var lastupdatebywhomid = "<?php echo $gig_bid_lastupdateby; ?>";
  var lastupdatebywhomtype = "<?php echo $gig_bid_lastupdateby_type; ?>";

  // console.log(" lastupdatebywhomid "+lastupdatebywhomid);
  // console.log(" lastupdatebywhomtype "+lastupdatebywhomtype);


  //***************** who am I emds here ***************

  //*********

      var gig_bid_cancellationfeelock = "<?php echo $gig_bid_cancellationfeelock; ?>";
      var gig_bid_securitymoneylock = "<?php echo $gig_bid_securitymoneylock;   ?>";
      var gig_bid_totalmoneylock = "<?php echo $gig_bid_totalmoneylock;  ?>";

      if(gig_bid_totalmoneylock!='' && gig_bid_totalmoneylock > 0)
      {
         $('.totalclck').removeClass("clickable");
      }
       if(gig_bid_securitymoneylock!='' && gig_bid_securitymoneylock > 0)
      {
         $('.securityclck').removeClass("clickable");
      }
       if(gig_bid_cancellationfeelock!='' && gig_bid_cancellationfeelock > 0)
      {
         $('.bookingcanclck').removeClass("clickable");
      }


      // console.log(" gig_bid_cancellationfeelock "+gig_bid_cancellationfeelock);
      // console.log(" gig_bid_securitymoneylock "+gig_bid_securitymoneylock);
      // console.log(" gig_bid_totalmoneylock "+gig_bid_totalmoneylock);

  //*********

  var countgigbid = 0;
  var booker_id='';
  var session_id='';


   var last_updated_byID = '<?php echo $last_updated_by_bid?>';

   countgigbid = '<?php echo $countgigbid; ?>';
   // console.log(" countgigbid "+countgigbid+" last_updated_byID "+last_updated_byID);
   booker_id = '<?php echo $booker_id_1; ?>';
   session_id = '<?php echo $front_sess; ?>';


 if(countgigbid > 0)
 {


    if( (lastupdatebywhomid == whoami_id) && (lastupdatebywhomtype == whoami_text))
    {
       	$("#renegdiv").addClass('mydisplaynone');
       	$("#acceptdiv").addClass('mydisplaynone');	
        $("#cancel_bid_reqst").addClass('mydisplaynone');
 	  }else
    {
      $("#renegdiv").removeClass('mydisplaynone');
      $("#acceptdiv").removeClass('mydisplaynone');
      $("#cancel_bid_reqst").removeClass('mydisplaynone'); 
    }
 }
 else if(session_id==booker_id)
 {
 	$("#renegdiv").addClass('mydisplaynone');
 	$("#acceptdiv").addClass('mydisplaynone');
  $("#cancel_bid_reqst").addClass('mydisplaynone');
 	
 }
 else
 {
 	$("#renegdiv").removeClass('mydisplaynone');
 	$("#acceptdiv").removeClass('mydisplaynone');	
  $("#cancel_bid_reqst").removeClass('mydisplaynone');
 }
 



var bookingstatuscheck = "<?php echo $bookingstatuschecktext;?>";
var first_accepted_by = "<?php echo $first_accepted_by;?>";

console.log("bookingstatuscheck "+bookingstatuscheck);
  
  if(bookingstatuscheck == 'notprossibletoopen' || bookingstatuscheck == 'accecptedfrombothend')
  {
        $("#renegdiv").addClass('mydisplaynone');
        $("#acceptdiv").addClass('mydisplaynone');  
        $("#cancel_bid_reqst").addClass('mydisplaynone');
  }else if(first_accepted_by > 0)
  {
    $("#renegdiv").addClass('mydisplaynone');

    //***********  if cancelled then prevent user from entering any data
    $('#cancellation_fee').attr('disabled', 'disabled');
    $('#cancellation_payment_gigspanclick').removeClass("clickable");

    $('#security_payment_gig').attr('disabled', 'disabled');
    $('#security_payment_gigspanclick').removeClass("clickable");

    $('#total_payment_gig').attr('disabled', 'disabled');
    $('#total_payment_gigspanclick').removeClass("clickable");

  }







});






//**************  booking open value show starts here
var bookingstatusopenuntil='';
 bookingstatusopenuntil="<?php echo $bookingstatusopenuntil;?>";
console.log(" bookingstatusopenuntil "+bookingstatusopenuntil);

var array;
var daytobese='';
var hrtobeset='';
var minttobeset='';
if(bookingstatusopenuntil !="" &&  bookingstatusopenuntil !="notdefifound")
{
 array = bookingstatusopenuntil.split(':');
 console.log("asdsad here ==> "+array[0]);
  daytobeset = array[0];
  hrtobeset = array[1];
  minttobeset = array[2];

$("#reqexpire_time_day").val(daytobeset);
$("#reqexpire_time_hrs").val(hrtobeset);
$("#reqexpire_time_mnt").val(minttobeset);


  
}else 
{
  daytobeset = "";
  hrtobeset = "";
  minttobeset = "";
}

// console.log(" daytobeset "+daytobeset);
// console.log(" hrtobeset "+hrtobeset);
// console.log(" minttobeset "+minttobeset);




///************* booking open value show ends here 


  $('#reqexpire_time_day').keyup(function(e) {
     
           if(this.value.length == $(this).attr('maxlength')) {
           $(this).parent().next().find('input').focus();
           $(this).parent().next().find('button').focus();
           } 

     });
  $('#reqexpire_time_hrs').keyup(function(e) {
     
           if(this.value.length == $(this).attr('maxlength')) {
           $(this).parent().next().find('input').focus();
           $(this).parent().next().find('button').focus();
           } reqexpire_time_hrs

     });


  $('#reqexpire_time_day').keypress(function(key){

  if(key.charCode < 48 )
  {
    return false;
    
  }else
  {
    if(key.charCode > 57)
    return false;
  }
});
  $('#reqexpire_time_hrs').keypress(function(key){

  if(key.charCode < 48 )
  {
    return false;
    
  }else
  {
    if(key.charCode > 57)
    return false;
  }
});
  $('#reqexpire_time_mnt').keypress(function(key){

  if(key.charCode < 48 )
  {
    return false;
    
  }else
  {
    if(key.charCode > 57)
    return false;
  }
});


  CharacterCountartist = function(){
                                var myField = document.getElementById('gig_description');
                                var myLabel = document.getElementById('fieldtocountnegotiation');
                                var myErrLabel = document.getElementById('CharCountLabelnegotiation');
                                if(!myField || !myLabel){return false;} // catches errors
                                var MaxChars =  myField.maxLengh;
                                if(!MaxChars){MaxChars =  myField.getAttribute('maxlength'); }    if(!MaxChars){return false;}
                                var remainingChars =   MaxChars - myField.value.length;
                                myErrLabel.innerHTML = remainingChars+" Characters Remaining of Maximum "+MaxChars;
                };
 
                setInterval(function(){
                    CharacterCountartist('gig_description','CharCountLabelnegotiation')},0); 

</script>