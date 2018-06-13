	<!--	post a gig  start -->

  <!--<div class="modal fade" id="myModal6" tabindex="-1" role="dialog">-->
  <div class="modal-dialog popup-dialog" role="document">
    <div class="modal-content popup-content artist_popup">
      <div class="modal-body popup-body">
          <div class="artist_hedr gig">
            <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <h2>post a gig</h2>
          </div>
          <div class="artist_form_outr clearfix">
          <!--<form>-->
				<?php
                  echo Form::open(array('url' => '',
                  'method' => 'get',
                  'id'=>'gig_master_post',
                  'class'=>"",
				  'autocomplete'=>'off'
                  ));
                ?>
              <div class="alert error" style="display: none;">Your booking failed</div>
              <div class="alert success" style="display: none;">Your booking successfully</div>
              <div class="Constitution-inner-first artist_list">
						<span>Public Event:</span>
					  <div class="radio_in">
                     <?php 
                        echo Form::radio('radio_eventType', '1', false,$attributes = array("id"=>"radio_eventtype_pb", "class"=>"eventType"));
                        ?>
                     <label for="radio_eventtype_pb"><span><span></span></span>Yes</label>
                  </div>
                  <div class="radio_in">
                     <?php 
                        echo Form::radio('radio_eventType', '2', true,$attributes = array("id"=>"radio_eventtype_pr", "class"=>"eventType"));
                        ?>
                     <label for="radio_eventtype_pr"><span><span></span></span>No</label>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                    <div class="artist_divsn reqst_dvsn">
                        <div class="inline artist_list request_type lacTxt">
                          <span>Location:</span>
                        </div>
                        <div class="reqField"><a href="javascript:void(0);" id="clickme1" class="tBtn form-control">Required Field.</a></div>
                    </div>
                  </div>
                  <div class="new-location clearfix clickmeShow" style="display:none;" id="opnaddresssection_gig">
                      <div class="col-md-12">
                        <div class="artist_divsn reqst_dvsn">
                          <div class="inline artist_list request_type">
                               <!--<input type="text" class="form-control form-control-B" placeholder="Address1"/>-->
							   <?php echo Form::text("address1_gig", $value="", $attributes = array( "id"=>"address1_gig","placeholder"=>"Address1","class"=>"form-control form-control-B" )); ?>
                              <!--<input type="text" class="form-control form-control-B" placeholder="Address2"/>-->
							  <?php echo Form::text("address2", $value="", $attributes = array( "id"=>"address2_gig","placeholder"=>"Address2","class"=>"form-control form-control-B" )); ?>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
						   <?php								
						   
						  $control_attrAr=array();
						  $control_attrAr['id']='country_gigp';
						  $control_attrAr['class']=" selectpicker ";
						  $control_attrAr['title']="Select Country";
						  
						  $country='';
						  $fetchcountryArData=array();
						  echo Form::select('country_gigp', $fetchcountryArData, $country,$control_attrAr);		
						   ?>
                            </div>
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
 
								 <?php
								$control_attrAr=array();
								$control_attrAr['id']='select_state_gigp';
								$control_attrAr['class']=" selectpicker ";
								$control_attrAr['title']="Select state";
								
								$select_state='';
								$fetchstateData=array();
								echo Form::select('select_state_gigp', $fetchstateData, $select_state,$control_attrAr);
							 ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
                                <!--<input type="text" class="form-control" placeholder="City" />-->
								<?php echo Form::text("city_gig", $value="", $attributes = array( "id"=>"city_gig","placeholder"=>"City","class"=>"form-control form-control-B")); ?>
								
                            </div>
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
								<?php echo Form::text("zip_gig", $value="", $attributes = array( "id"=>"zip_gig","placeholder"=>"Post Code","class"=>"form-control form-control-B")); ?>
                            </div>
                        </div>
                    </div>
                    
                    <a class="closeLoc" href="javascript:void(0);"></a>
                    
                </div>

                  <div class="col-md-12">
                     <div class="Constitution-inner-first artist_list gig_list">
						  <div class="radio_in">
						    <!--<input id="radio6" type="radio" name="radio5" value="2" class="gig_type"><label for="radio6"><span><span></span></span><span class="gig_txt">Individual:</span></label>-->
						<?php 
                        echo Form::radio('radio_gig_type', '1', true,$attributes = array("id"=>"radio_gig_type_in", "class"=>"gig_type"));
                        ?>
						<label for="radio_gig_type_in"><span><span></span></span><span class="gig_txt">Individual:</span></label>
						  </div>
						<div class="radio_in">
						    <!--<input id="radio5" type="radio" name="radio5" value="1" class="gig_type" checked="checked"><label for="radio5"><span><span></span></span><span class="gig_txt">Group:</span></label>-->
						<?php 
                        echo Form::radio('radio_gig_type', '2', false,$attributes = array("id"=>"radio_gig_type_gr", "class"=>"gig_type"));
                        ?>
						<label for="radio_gig_type_gr"><span><span></span></span><span class="gig_txt">Group:</span></label>
						  </div>

						</div>
                  </div>
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list request_list">
                        <!--<select class="selectpicker artist_txt" id="skillcategory">
                        </select>-->
						<?php						
						$control_attrAr=array();
						$control_attrAr['id']='skillcategory';
						$control_attrAr['class']=" selectpicker ";
						$control_attrAr['title']="Select Category";
						
						$skill_sub='';
						$fetchskillsubData=array();
						echo Form::select('skillcategory', $fetchskillsubData, $skill_sub,$control_attrAr);							
						?>

                    </div>
                </div>
                  </div>
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list request_list">

						<?php						
						$control_attrAr=array();
						$control_attrAr['id']='skillgenre';
						$control_attrAr['class']=" selectpicker ";
						$control_attrAr['title']="Select Genre";
						
						$skill_sub='';
						$fetchskillsubData=array();
						echo Form::select('skillgenre', $fetchskillsubData, $skill_sub,$control_attrAr);							
						?>
                    </div>
                </div>
                  </div>
                  <div class="col-md-6">
<!--					<div class="inline artist_list">
                      <span>Date of Event:</span>
                      <div class="form-group inpt input-customm">
                          <div class='input-group date'>
                             <input type='text' class="form-control date_outr datetimepicker" placeholder="03.05.16"/>
                               <span class="input-group-addon dt">
                               <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                          </div>
                       </div>
                    </div>-->
					  <div class="inline artist_list">
						<span>Date of Event:</span>
						  <div class="form-group inpt input-customm">
                           <div class='input-group date'>
                              <?php    
                                 echo Form::text("booking_date_gig",
                                 $value='',
                                 $attributes = array( "id"=>"booking_date_gig",
                                 "class"=>"form-control date_outr datetimepicker",
                                
                                 ));
                                 ?>
                              <span class="input-group-addon dt">
                              <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                           </div>
                        </div>
					  </div>

					 <div class="inline artist_list">
                        <span>Start Time:</span>
                        <div class="form-group inpt input-customm">
                           <div class='input-group date' id='datetimepicker3'>
                              <!--<input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm"/>-->
                              

                            <?php    
                                 echo Form::text("start_time_gig", 
                                 $value='',
                                 $attributes = array( "id"=>"start_time_gig",
                                 "class"=>"form-control clck_outr timepicker",
                                
                                 ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon glyphicon-time"></span>
                              </span>


                           </div>


                        </div>
                     </div>

                     <div class="inline artist_list">
                        <span>End Time:</span>
                        <div class="form-group inpt input-customm input-customm-2">
                           <div class='input-group date' id='datetimepicker4'>
                              <!--<input type='text' class="form-control clck_outr timepicker" placeholder="4.20 pm"/>-->
                             
                             <?php
                                 echo Form::text("end_time_gig",
                                 $value='',
                                 $attributes = array( "id"=>"end_time_gig",
                                 "class"=>"form-control clck_outr timepicker",
                                
                                 ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon glyphicon-time"></span>
                              </span>

                             
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-md-6">

                     <div class="inline artist_list">
                        <span>Security Deposit:</span>
                        <div class="form-group inpt input-customm">
                           <div class='input-group date'>
                           <span class="dollar">$</span>
                              <!--<input type='text' class="form-control clck_outr lck_outr" placeholder="$0.00" />-->
                              <?php
                                 echo Form::text("security_payment_gig",
                                 $value='',
                                 $attributes = array( "id"=>"security_payment_gig",
                                 "class"=>"form-control clck_outr lck_outr",
                                 //"placeholder"=>"$0.00",
                                 "maxlength"=>"16"
                                 
                                 ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock2.png" alt=""/></span>
                              </span>
                           </div>
                        </div>
                     </div>
<!--					 <div class="inline artist_list ">
                        <span>Total Payment:</span>
						<div class="form-group inpt input-customm">
                          <div class='input-group date'>
                             <input type='text' class="form-control clck_outr lck_outr" placeholder="$0.00" />
                               <span class="input-group-addon clck">
                               <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock.png" alt=""/></span>
                              </span>
                          </div>
                       </div>
                     </div>-->
                     <div class="inline artist_list">
                        <span>Total Payment:</span>
                        <div class="form-group inpt input-customm">
                           <div class='input-group date'>
                           <span class="dollar">$</span>
                              <?php    
                                 echo Form::text("total_payment_gig",
                                 $value='',
                                 $attributes = array( "id"=>"total_payment_gig",
                                 "class"=>"form-control clck_outr lck_outr",
                                 //"placeholder"=>"$0.00",
                                 "maxlength"=>"16"
                                 ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock.png" alt=""/></span>
                              </span>
                           </div>
                        </div>
                     </div>
                       <div class="inline artist_list">
                      <span>This Post Expires Date:</span>
<!--                      <div class="form-group inpt input-customm">
                          <div class='input-group date'>
                             <input type='text' class="form-control date_outr datetimepicker gig_inr" placeholder="10.05.16"/>
                               <span class="input-group-addon dt">
                               <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                          </div>
                       </div>-->
                        <div class="form-group inpt input-customm input-customm-color">
                           <div class='input-group date'>
                              <?php    
                                 echo Form::text("requestexpireddate_gig",
                                 $value='',
                                 $attributes = array( "id"=>"requestexpireddate_gig",
                                 "class"=>"form-control date_outr datetimepicker"
                                 
                                 ));
                                 ?>
                              <span class="input-group-addon dt">
                              <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                           </div>
                        </div>
                    </div>
                      <div class="inline artist_list">
                          <span>This Post Expires Time:</span>
<!--							<div class="form-group inpt input-customm">
								 <div class='input-group date' id='datetimepicker4'>
									<input type='text' class="form-control clck_outr timepicker gig_inr" placeholder="4.20 pm"/>
									  <span class="input-group-addon clck">
									  <span class="glyphicon glyphicon-time"></span>
									 </span>
								 </div>
							  </div>-->
                        <div class="form-group inpt input-customm input-customm-color">
                           <div class='input-group date' id='datetimepicker5'>

                              <?php    
                                 echo Form::text("requestexpiredtime_gig",
                                 $value='',
                                 $attributes =array( "id"=>"requestexpiredtime_gig",
                                 "class"=>"form-control clck_outr timepicker"
                                
                                 ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon glyphicon-time"></span>
                              </span>
                             


                           </div>
                        </div>
                        </div>
                     </div>
                    <div class="col-md-offset-6 col-md-6">
                        
                      </div>
                  <div class="col-md-12 posRltv">
<!--                      <span>Tech Specs</span>-->
                      <?php
					  
					  echo Form::textarea("gig_description", $value="", [ "id"=>"gig_description", "placeholder"=>"Gig Description","class"=>"form-group inpt nb form-control" ]);
					  
					  ?>
                        
<!--                       <p> 5 lines, 50 characters maximum per line</p>-->
                      </div>
                  <div class="col-md-12">
                    <div class="customBtn-group">
                      <button class="btn btn-warning artist_btn reqst_btn" type="button" id="cancel_post_a_gig">cancel</button>
                       <button class="btn btn-warning artist_btn rqst_trm_btn" type="button" id="agree_post_a_gig">agree to terms </button>
                     </div>
                  </div>
                  </div>
          <!--</form>-->
		                 <?php
                  echo Form::close();
                  ?>
            </div>
      </div>
    </div>
  </div>
<!--</div>-->
<!--	post a gig  end -->
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendedgidmodal.js"></script>
	     <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/jquery.maskMoney.js"></script>
       <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/postgigbookingdatetimevalidate.js"></script>


	  <script type="text/javascript">
	     	$(document).ready(function()
   	{
   //	$('#total_payment_gig').maskMoney({prefix:'$'}); //******masking for total payment
   	//$('#cancellation_payment').maskMoney({prefix:'$'});//******masking for cancellation payment
   //	$('#security_payment_gig').maskMoney({prefix:'$'});//*******masking for security payemnt
	
	   $("#divLoading").css("display","none");
	  //*********
	var csrf = "<?php echo csrf_token(); ?>";
	//*********

          var booking_date_gig ='';
          var requestexpireddate_gig ='';
          var datemax ='';
          var datecur = new Date();
          datecur.setDate(datecur.getDate());
          var datecur2 = new Date();

          
          $('#booking_date_gig').datetimepicker({
          format: 'DD/MM/YYYY',
          minDate:datecur
          });
          $('#requestexpireddate_gig').datetimepicker({
          format: 'DD/MM/YYYY',
          minDate:datecur2
          
          });

            $("#start_time_gig").datetimepicker({
          minDate: 1,
                  format: 'LT'
               });
        $("#end_time_gig").datetimepicker({
          minDate: 1,
                   format: 'LT'
               });

        $('#requestexpiredtime_gig').prop("disabled", true);  
        $('#requestexpireddate_gig').prop("disabled", true);  

   				// var booking_date_gig ='';
   				// var requestexpireddate_gig ='';
   				// var datemax ='';
   				// var datecur = new Date();
   				// datecur.setDate(datecur.getDate());
   				// var datecur2 = new Date();
   				// $('#booking_date_gig').datetimepicker({
   				// format: 'DD/MM/YYYY',
   				// minDate:datecur
   				// });
   				// $('#requestexpireddate_gig').datetimepicker({
   				// format: 'DD/MM/YYYY',
   				// minDate:datecur2
   				
   				// });

   			// 	  $("#start_time_gig").datetimepicker({
				  // minDate: 1,
      //             format: 'LT'
      //          });
			  // $("#end_time_gig").datetimepicker({
					// minDate: 1,
     //               format: 'LT'
     //           });
   		// 		$("#start_time_gig").on("dp.change", function(e)
   		// 		{

   		// 			 var mmdata1=e.date;
   		// 			 console.log(e.date);
					 
   		// 			 var startmmnttime= mmdata1.format("HH:mm");
   					
   					
   		// 			//**** get start date starts
   					
   		// 			var startdatedata=$("#booking_date_gig").val();
   		// 			console.log("=startdatedata=>"+startdatedata );
   										
   					
   		// 			var mmmntstartdate=moment(startdatedata,"DD-MM-YYYY").format("YYYY-MM-DD");

   		// 			var totaldatetime=mmmntstartdate+' '+startmmnttime;
   		// 			var prevsdate5hrsback=moment(totaldatetime,"YYYY-MM-DD HH:mm").subtract(5,"hours").format("MM-DD-YYYY" );
   		// 			var prevstime5hrsback=moment(totaldatetime,"YYYY-MM-DD HH:mm").subtract(5,"hours").format("hh:mm A" );
					
   		// 			//**** get start date ends
					
					// //********added by Indrasis after soumik da
					
					// var setdate=moment(prevsdate5hrsback,"MM-DD-YYYY").format("DD/MM/YYYY");
					// //var tttt = new Date(prevsdate5hrsback);
					// $("#requestexpireddate_gig").datetimepicker({
					// 	//minDate: 1;
					// 	//format:'DD-MM-YYYY',
					// 	//maxDate:prevsdate5hrsback
					// });
					
					// $('#requestexpireddate_gig').data("DateTimePicker").maxDate(setdate);
					// var requestTime = $("#requestexpireddate_gig").val();
					// var bookingTime = $("#booking_date_gig").val();
					
					// $('#requestexpiredtime_gig').data("DateTimePicker").maxDate(prevstime5hrsback);
					// //********added by Indrasis after soumik da
   					 
   		// 		});
   				
   				//*****soumik da****************************************************************************************************
				
				
				
				
				// $("#requestexpireddate_gig").on("dp.change", function(e)
   	// 			{
   				
   	// 				// alert('hello');
   	// 				 var mmdata1=e.date;
   	// 				 console.log(e.date);
   					 
   	// 				var startmmnttime= mmdata1.format("HH:mm");
   	// 				console.log( "=startmmnttime=>"+startmmnttime);
   					
   					
   					
   	// 				//**** get start date starts
   					
   					
   	// 				var startdatedata=$("#booking_date_gig").val();
   	// 				console.log("=startdatedata=>"+startdatedata );
   										
   					
   	// 				var mmmntstartdate=moment(startdatedata,"DD-MM-YYYY").format("YYYY-MM-DD");

   	// 				var totaldatetime=mmmntstartdate+' '+startmmnttime;
   	// 				var prevsdate5hrsback=moment(totaldatetime,"YYYY-MM-DD HH:mm").subtract(5,"hours").format("MM-DD-YYYY" );
   	// 				var prevstime5hrsback=moment(totaldatetime,"YYYY-MM-DD HH:mm").subtract(5,"hours").format("hh:mm A" );
   	// 				//**** get start date ends
					
				// 	//********added by Indrasis after soumik da
				// 	var requestTime = $("#requestexpireddate_gig").val();
				// 	var bookingTime = $("#booking_date_gig").val();
				// 	if (requestTime == bookingTime)
				// 	{
    //                    // console.log('match found');
				// 	   $("#requestexpiredtime_gig").show();
				// 		$('#requestexpiredtime_gig').data("DateTimePicker").maxDate(prevstime5hrsback);
						
    //                 }
				// 	else
				// 	{
				// 		$("#requestexpiredtime_gig").datetimepicker({
				// 		   maxDate:false,
				// 		   format: 'LT'
				// 		});
				// 	}
					
				// 	//********added by Indrasis after soumik da
   					 
   	// 			});
   				 
   	});
   //********masaking length for total payment attribute
   // var maxLength = $("#total_payment_gig").attr('maxlength');
   // if($("#total_payment_gig").val().length == maxLength)
   // {
   // 	$("#total_payment_gig").next().focus();
   // }

   // var maxLength3 = $("#security_payment_gig").attr('maxlength');
   // if($("#security_payment_gig").val().length == maxLength3)
   // {
   // 	$("#security_payment_gig").next().focus();
   // }
   	//**** bind profile page ends
</script>