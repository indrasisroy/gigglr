$(document).ready(function(){
     
     $("#eventselect").hide();
     
     $("#arrivaltime").datetimepicker({ format:'LT' });
     $("#leavetime").datetimepicker({ format:'LT' });
     $("#grouparrivaltime").datetimepicker({ format:'LT' });
     $("#groupleavetime").datetimepicker({ format:'LT' });
     $("#venuearrivaltime").datetimepicker({ format:'LT' });
     $("#venueleavetime").datetimepicker({ format:'LT' });
     $("#bookerarrivaltime").datetimepicker({ format:'LT' });

     $(document).on('click','#artistsub',function(){
          
          var flagartformsubchk1='';
          
          var arriveradioforchk = $('input[name=arrive]:checked', '#againstartistfrmid').val();
          var specificationradioforchk = $('input[name=specification]:checked', '#againstartistfrmid').val();
          var performanceradioforchk = $('input[name=performance]:checked', '#againstartistfrmid').val();
          var technicalradioforchk = $('input[name=technical]:checked', '#againstartistfrmid').val();
          var riderradioforchk = $('input[name=rider]:checked', '#againstartistfrmid').val();
          var leaveradioforchk = $('input[name=leave]:checked', '#againstartistfrmid').val();
          
          $("#againstartistfrmid").validate({                                   
                                    
               /*****add parent class*****/
               highlight: function(element) {
                   $(element).parent().addClass("errorField");
               },
               /*****remove parent class*****/
               unhighlight: function(element) {
                   $(element).parent().removeClass("errorField");
               },   
               /*****remove error text*****/
               errorPlacement: function () {
                   return false;
               },   
                                    
               errorClass: "authError",
               errorElement: 'span',
                                             
               rules: {
                    arrivaltime: {
                         required: true,
                    },
                    leavetime:{
                         required: true,
                    },
                    againstartist:{
                         required: true,
                    },
                    summary:{
                         required: true,
                         maxlength: 500,
                    },                               
               },
               
               messages: {
                    arrivaltime: {
                         required: "Please enter arrival time",
                    },
                    leavetime: {
                         required: "Please enter leaving time",
                    },
                    againstartist: {
                         required: "Please select the artist",
                    },
                    summary:{
                         required: "Please provide a description",
                         maxlength: "Maximum 500 characters are allowed",
                    },
               },
                                       
          });
          
          var chkagainstartistvalidation =  $("#againstartistfrmid").valid();
          
          if( (arriveradioforchk != undefined && (arriveradioforchk=='1' || arriveradioforchk=='2')) && (specificationradioforchk != undefined && (specificationradioforchk=='1' || specificationradioforchk=='2')) && (performanceradioforchk != undefined && (performanceradioforchk=='1' || performanceradioforchk=='2')) && (technicalradioforchk != undefined && (technicalradioforchk=='1' || technicalradioforchk=='2')) && (riderradioforchk != undefined && (riderradioforchk=='1' || riderradioforchk=='2')) && (leaveradioforchk != undefined && (leaveradioforchk=='1' || leaveradioforchk=='2')) )
          {
               $("#arriveId").parent().removeClass('radioerrorcolor');
               $("#specificationId").parent().removeClass('radioerrorcolor');
               $("#performanceId").parent().removeClass('radioerrorcolor');
               $("#technicalId").parent().removeClass('radioerrorcolor');
               $("#riderId").parent().removeClass('radioerrorcolor');
               $("#leaveId").parent().removeClass('radioerrorcolor');
                    
               if(chkagainstartistvalidation === true)
               {    
                    var againstartistchking = $('#againstartist').val();
                    if(againstartistchking!=undefined && againstartistchking!='')
                    {
                         flagartformsubchk1 = 1;
                    }else{
                         flagartformsubchk1 = 0;
                    }
               }
               else
               {
                    flagartformsubchk1 = 0;
               }
          }
          else
          {
               if (arriveradioforchk != '1' && arriveradioforchk != '2') {
                    $("#arriveId").parent().addClass('radioerrorcolor');
                    flagartformsubchk1 = 0;
               }
               else if (arriveradioforchk == '1' || arriveradioforchk == '2') {
                    $("#arriveId").parent().removeClass('radioerrorcolor');
                    if(chkagainstartistvalidation === true)
                    {
                         flagartformsubchk1 = 1;
                    }
                    else
                    {
                         flagartformsubchk1 = 0;
                    }
               }
               
               if (specificationradioforchk != '1' && specificationradioforchk != '2') {
                    $("#specificationId").parent().addClass('radioerrorcolor');
                    flagartformsubchk1 = 0;
               }
               else if (specificationradioforchk == '1' || specificationradioforchk == '2') {
                    $("#specificationId").parent().removeClass('radioerrorcolor');
                    if(chkagainstartistvalidation === true)
                    {
                         flagartformsubchk1 = 1;
                    }
                    else
                    {
                         flagartformsubchk1 = 0;
                    }
               }
               
               if (performanceradioforchk != '1' && performanceradioforchk != '2') {
                    $("#performanceId").parent().addClass('radioerrorcolor');
                    flagartformsubchk1 = 0;
               }
               else if (performanceradioforchk == '1' || performanceradioforchk == '2') {
                    $("#performanceId").parent().removeClass('radioerrorcolor');
                    if(chkagainstartistvalidation === true)
                    {
                         flagartformsubchk1 = 1;
                    }
                    else
                    {
                         flagartformsubchk1 = 0;
                    }
               }
               
               if (technicalradioforchk != '1' && technicalradioforchk != '2') {
                    $("#technicalId").parent().addClass('radioerrorcolor');
                    flagartformsubchk1 = 0;
               }
               else if (technicalradioforchk == '1' || technicalradioforchk == '2') {
                    $("#technicalId").parent().removeClass('radioerrorcolor');
                    if(chkagainstartistvalidation === true)
                    {
                         flagartformsubchk1 = 1;
                    }
                    else
                    {
                         flagartformsubchk1 = 0;
                    }
               }
               
               if (riderradioforchk != '1' && riderradioforchk != '2') {
                    $("#riderId").parent().addClass('radioerrorcolor');
                    flagartformsubchk1 = 0;
               }
               else if (riderradioforchk == '1' || riderradioforchk == '2')  {
                    $("#riderId").parent().removeClass('radioerrorcolor');
                    if(chkagainstartistvalidation === true)
                    {
                         flagartformsubchk1 = 1;
                    }
                    else
                    {
                         flagartformsubchk1 = 0;
                    }
               }
               
               if (leaveradioforchk != '1' && leaveradioforchk != '2') {
                    $("#leaveId").parent().addClass('radioerrorcolor');
                    flagartformsubchk1 = 0;
               }
               else if (leaveradioforchk == '1' || leaveradioforchk == '2') {
                    $("#leaveId").parent().removeClass('radioerrorcolor');
                    if(chkagainstartistvalidation === true)
                    {
                         flagartformsubchk1 = 1;
                    }
                    else
                    {
                         flagartformsubchk1 = 0;
                    }
               }
          }
          
          if (flagartformsubchk1 == 1) {
          
               $("#artistsub").prop("disabled", true);
     
               var arriveradio = $('input[name=arrive]:checked', '#againstartistfrmid').val();
               var arrivaltime = $('#arrivaltime').val();
               var specificationradio = $('input[name=specification]:checked', '#againstartistfrmid').val();
               var performanceradio = $('input[name=performance]:checked', '#againstartistfrmid').val();
               var technicalradio = $('input[name=technical]:checked', '#againstartistfrmid').val();
               var riderradio = $('input[name=rider]:checked', '#againstartistfrmid').val();
               var leaveradio = $('input[name=leave]:checked', '#againstartistfrmid').val();
               var leavetime = $('#leavetime').val();
               var againstartist = $('#againstartist').val();
               var description = $('#summary').val();
               
               //alert('arriveradio:'+arriveradio+', arrivaltime:'+arrivaltime+', againstartist:'+againstartist);
               
               var againstartistfrm_url=base_url_data+"/againstartistfrmsub";
           
               var againstartistfrm_data={_token:csrf_token_data,'arriveradio':arriveradio,'arrivaltime':arrivaltime,'specificationradio':specificationradio,'performanceradio':performanceradio,'technicalradio':technicalradio,'riderradio':riderradio,'leaveradio':leaveradio,'leavetime':leavetime,'againstartist':againstartist,'description':description};
               
               $.ajax({
                  
                    url:againstartistfrm_url,
                    type:'POST',
                    dataType:'json',
                    data:againstartistfrm_data,
                    success:function(d){
                         
                         $( '#againstartistfrmid' ).each(function(){
                              this.reset();
                         });
                         
                         $("#againstartist").selectpicker('refresh');
                         
                         //$("#againstgroup").selectpicker('refresh');
                         //$("#againstvenue").selectpicker('refresh');
                         //$("#againstbooker").selectpicker('refresh');
                         
                         pickerrefreshing();
                         
                         $("#artistsub").prop("disabled", false);
                         
                         //$("#datetimepicker3").datetimepicker({
                         //     format:'LT',
                         //     Default:false
                         //});
                         
                         if (d.flag_id == 0)
                         {      
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=2000,etmo=2000,poscls='toast-top-full-width');
                              }
                         }
                         else if(d.flag_id == 1)
                         {
                              poptriggerfunc(msgtype='success',titledata='',msgdata="Dispute with the artist has been saved successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         }
                         else{
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                              }
                         }
                    }
                  
               });
          }
          else{
               toastr.remove();
               poptriggerfunc(msgtype='error',titledata='',msgdata="Please ensure required fields are complete before submitting your dispute against artist",sd=1000,hd=3000,tmo=2000,etmo=1000,poscls='toast-top-full-width');
          }
     });
     
     $(document).on('click','#groupsub',function(){
          
          var flaggrpformsubchk1='';
          
          var grouparriveradioforchk = $('input[name=grouparrive]:checked', '#againstgroupfrmid').val();
          var groupspecificationradioforchk = $('input[name=groupspecification]:checked', '#againstgroupfrmid').val();
          var groupperformanceradioforchk = $('input[name=groupperformance]:checked', '#againstgroupfrmid').val();
          var grouptechnicalradioforchk = $('input[name=grouptechnical]:checked', '#againstgroupfrmid').val();
          var groupriderradioforchk = $('input[name=grouprider]:checked', '#againstgroupfrmid').val();
          var groupleaveradioforchk = $('input[name=groupleave]:checked', '#againstgroupfrmid').val();
          
          $("#againstgroupfrmid").validate({                                   
                                    
               /*****add parent class*****/
               highlight: function(element) {
                   $(element).parent().addClass("errorField");
               },
               /*****remove parent class*****/
               unhighlight: function(element) {
                   $(element).parent().removeClass("errorField");
               },   
               /*****remove error text*****/
               errorPlacement: function () {
                   return false;
               },   
                                    
               errorClass: "authError",
               errorElement: 'span',
                                             
               rules: {
                    grouparrivaltime: {
                         required: true,
                    },
                    groupleavetime:{
                         required: true,
                    },
                    againstgroup:{
                         required: true,
                    },
                    groupsummary:{
                         required: true,
                         maxlength: 500,
                    },                               
               },
               
               messages: {
                    grouparrivaltime: {
                         required: "Please enter arrival time",
                    },
                    groupleavetime: {
                         required: "Please enter leaving time",
                    },
                    againstgroup: {
                         required: "Please select the group",
                    },
                    groupsummary:{
                         required: "Please provide a description",
                         maxlength: "Maximum 500 characters are allowed",
                    },
               },
                                       
          });
          
          var chkagainstgroupvalidation =  $("#againstgroupfrmid").valid();
          
          if( (grouparriveradioforchk != undefined && (grouparriveradioforchk=='1' || grouparriveradioforchk=='2')) && (groupspecificationradioforchk != undefined && (groupspecificationradioforchk=='1' || groupspecificationradioforchk=='2')) && (groupperformanceradioforchk != undefined && (groupperformanceradioforchk=='1' || groupperformanceradioforchk=='2')) && (grouptechnicalradioforchk != undefined && (grouptechnicalradioforchk=='1' || grouptechnicalradioforchk=='2')) && (groupriderradioforchk != undefined && (groupriderradioforchk=='1' || groupriderradioforchk=='2')) && (groupleaveradioforchk != undefined && (groupleaveradioforchk=='1' || groupleaveradioforchk=='2')) )
          {
               $("#grouparriveId").parent().removeClass('radioerrorcolor');
               $("#groupspecificationId").parent().removeClass('radioerrorcolor');
               $("#groupperformanceId").parent().removeClass('radioerrorcolor');
               $("#grouptechnicalId").parent().removeClass('radioerrorcolor');
               $("#groupriderId").parent().removeClass('radioerrorcolor');
               $("#groupleaveId").parent().removeClass('radioerrorcolor');
               
               if(chkagainstgroupvalidation === true)
               {
                    var againstgroupchking = $('#againstgroup').val();
                    if(againstgroupchking!=undefined && againstgroupchking!='')
                    {
                         flaggrpformsubchk1 = 1;
                    }else{
                         flaggrpformsubchk1 = 0;
                    }
               }
               else
               {
                    flaggrpformsubchk1 = 0;
               }
          }
          else
          {    
               if (grouparriveradioforchk != '1' && grouparriveradioforchk != '2') {
                    $("#grouparriveId").parent().addClass('radioerrorcolor');
                    flaggrpformsubchk1 = 0;
               }
               else if (grouparriveradioforchk == '1' || grouparriveradioforchk == '2') {
                    $("#grouparriveId").parent().removeClass('radioerrorcolor');
                    if(chkagainstgroupvalidation === true)
                    {
                         flaggrpformsubchk1 = 1;
                    }
                    else
                    {
                         flaggrpformsubchk1 = 0;
                    }
               }
               
               if (groupspecificationradioforchk != '1' && groupspecificationradioforchk != '2') {
                    $("#groupspecificationId").parent().addClass('radioerrorcolor');
                    flaggrpformsubchk1 = 0;
               }
               else if (groupspecificationradioforchk == '1' || groupspecificationradioforchk == '2') {
                    $("#groupspecificationId").parent().removeClass('radioerrorcolor');
                    if(chkagainstgroupvalidation === true)
                    {
                         flaggrpformsubchk1 = 1;
                    }
                    else
                    {
                         flaggrpformsubchk1 = 0;
                    }
               }
               
               if (groupperformanceradioforchk != '1' && groupperformanceradioforchk != '2') {
                    $("#groupperformanceId").parent().addClass('radioerrorcolor');
                    flaggrpformsubchk1 = 0;
               }
               else if (groupperformanceradioforchk == '1' || groupperformanceradioforchk == '2') {
                    $("#groupperformanceId").parent().removeClass('radioerrorcolor');
                    if(chkagainstgroupvalidation === true)
                    {
                         flaggrpformsubchk1 = 1;
                    }
                    else
                    {
                         flaggrpformsubchk1 = 0;
                    }
               }
               
               if (grouptechnicalradioforchk != '1' && grouptechnicalradioforchk != '2') {
                    $("#grouptechnicalId").parent().addClass('radioerrorcolor');
                    flaggrpformsubchk1 = 0;
               }
               else if (grouptechnicalradioforchk == '1' || grouptechnicalradioforchk == '2') {
                    $("#grouptechnicalId").parent().removeClass('radioerrorcolor');
                    if(chkagainstgroupvalidation === true)
                    {
                         flaggrpformsubchk1 = 1;
                    }
                    else
                    {
                         flaggrpformsubchk1 = 0;
                    }
               }
               
               if (groupriderradioforchk != '1' && groupriderradioforchk != '2') {
                    $("#groupriderId").parent().addClass('radioerrorcolor');
                    flaggrpformsubchk1 = 0;
               }
               else if (groupriderradioforchk == '1' || groupriderradioforchk == '2') {
                    $("#groupriderId").parent().removeClass('radioerrorcolor');
                    if(chkagainstgroupvalidation === true)
                    {
                         flaggrpformsubchk1 = 1;
                    }
                    else
                    {
                         flaggrpformsubchk1 = 0;
                    }
               }
               
               if (groupleaveradioforchk != '1' && groupleaveradioforchk != '2') {
                    $("#groupleaveId").parent().addClass('radioerrorcolor');
                    flaggrpformsubchk1 = 0;
               }
               else if (groupleaveradioforchk == '1' || groupleaveradioforchk == '2') {
                    $("#groupleaveId").parent().removeClass('radioerrorcolor');
                    if(chkagainstgroupvalidation === true)
                    {
                         flaggrpformsubchk1 = 1;
                    }
                    else
                    {
                         flaggrpformsubchk1 = 0;
                    }
               }
          }
          
          if (flaggrpformsubchk1 == 1) {
          
               $("#groupsub").prop("disabled", true);
     
               var grouparriveradio = $('input[name=grouparrive]:checked', '#againstgroupfrmid').val();
               var grouparrivaltime = $('#grouparrivaltime').val();
               var groupspecificationradio = $('input[name=groupspecification]:checked', '#againstgroupfrmid').val();
               var groupperformanceradio = $('input[name=groupperformance]:checked', '#againstgroupfrmid').val();
               var grouptechnicalradio = $('input[name=grouptechnical]:checked', '#againstgroupfrmid').val();
               var groupriderradio = $('input[name=grouprider]:checked', '#againstgroupfrmid').val();
               var groupleaveradio = $('input[name=groupleave]:checked', '#againstgroupfrmid').val();
               var groupleavetime = $('#groupleavetime').val();
               var againstgroup = $('#againstgroup').val();
               var groupdescription = $('#groupsummary').val();
               
               //alert('arriveradio:'+arriveradio+', arrivaltime:'+arrivaltime+', againstartist:'+againstartist);
               
               var againstgroupfrm_url=base_url_data+"/againstgroupfrmsub";
           
               var againstgroupfrm_data={_token:csrf_token_data,'grouparriveradio':grouparriveradio,'grouparrivaltime':grouparrivaltime,'groupspecificationradio':groupspecificationradio,'groupperformanceradio':groupperformanceradio,'grouptechnicalradio':grouptechnicalradio,'groupriderradio':groupriderradio,'groupleaveradio':groupleaveradio,'groupleavetime':groupleavetime,'againstgroup':againstgroup,'groupdescription':groupdescription};
               
               $.ajax({
                  
                    url:againstgroupfrm_url,
                    type:'POST',
                    dataType:'json',
                    data:againstgroupfrm_data,
                    success:function(d){
                         
                         $( '#againstgroupfrmid' ).each(function(){
                              this.reset();
                         });
                         
                         $("#againstgroup").selectpicker('refresh');
                         
                         //$("#againstvenue").selectpicker('refresh');
                         //$("#againstbooker").selectpicker('refresh');
                         //$("#againstartist").selectpicker('refresh');
                         
                         pickerrefreshing();
                         
                         $("#groupsub").prop("disabled", false);
                         
                         //$("#datetimepicker3").datetimepicker({
                         //     format:'LT',
                         //     Default:false
                         //});
                         
                         if (d.flag_id == 0)
                         {      
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=2000,etmo=2000,poscls='toast-top-full-width');
                              }
                         }
                         else if(d.flag_id == 1)
                         {
                              poptriggerfunc(msgtype='success',titledata='',msgdata="Dispute with the group has been saved successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         }
                         else{
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                              }
                         }
                    }
                  
               });
          }
          else{
               toastr.remove();
               poptriggerfunc(msgtype='error',titledata='',msgdata="Please ensure required fields are complete before submitting your dispute against group",sd=1000,hd=3000,tmo=2000,etmo=1000,poscls='toast-top-full-width');
          }
    
     });
     
     $(document).on('click','#venuesub',function(){
          
          var flagvenformsubchk1='';
          
          var venuearriveradioforchk = $('input[name=venuearrive]:checked', '#againstvenuefrmid').val();
          var venuepresentationradioforchk = $('input[name=venuepresentation]:checked', '#againstvenuefrmid').val();
          var venuespecificationradioforchk = $('input[name=venuespecification]:checked', '#againstvenuefrmid').val();
          var venuetechnicalradioforchk = $('input[name=venuetechnical]:checked', '#againstvenuefrmid').val();
          var venueleaveradioforchk = $('input[name=venueleave]:checked', '#againstvenuefrmid').val();
          
          $("#againstvenuefrmid").validate({                                   
                                    
               /*****add parent class*****/
               highlight: function(element) {
                   $(element).parent().addClass("errorField");
               },
               /*****remove parent class*****/
               unhighlight: function(element) {
                   $(element).parent().removeClass("errorField");
               },   
               /*****remove error text*****/
               errorPlacement: function () {
                   return false;
               },   
                                    
               errorClass: "authError",
               errorElement: 'span',
                                             
               rules: {
                    venuearrivaltime: {
                         required: true,
                    },
                    venueleavetime:{
                         required: true,
                    },
                    againstvenue:{
                         required: true,
                    },
                    venuesummary:{
                         required: true,
                         maxlength: 500,
                    },                               
               },
               
               messages: {
                    venuearrivaltime: {
                         required: "Please enter arrival time",
                    },
                    venueleavetime: {
                         required: "Please enter leaving time",
                    },
                    againstvenue: {
                         required: "Please select the venue",
                    },
                    venuesummary:{
                         required: "Please provide a description",
                         maxlength: "Maximum 500 characters are allowed",
                    },
               },
                                       
          });
          
          var chkagainstvenuevalidation =  $("#againstvenuefrmid").valid();
          
          if( (venuearriveradioforchk != undefined && (venuearriveradioforchk=='1' || venuearriveradioforchk=='2')) && (venuepresentationradioforchk != undefined && (venuepresentationradioforchk=='1' || venuepresentationradioforchk=='2')) && (venuespecificationradioforchk != undefined && (venuespecificationradioforchk=='1' || venuespecificationradioforchk=='2')) && (venuetechnicalradioforchk != undefined && (venuetechnicalradioforchk=='1' || venuetechnicalradioforchk=='2')) && (venueleaveradioforchk != undefined && (venueleaveradioforchk=='1' || venueleaveradioforchk=='2')) )
          {
               if(chkagainstvenuevalidation === true)
               {
                    $("#venuearriveId").parent().removeClass('radioerrorcolor');
                    $("#venuepresentationId").parent().removeClass('radioerrorcolor');
                    $("#venuespecificationId").parent().removeClass('radioerrorcolor');
                    $("#venuetechnicalId").parent().removeClass('radioerrorcolor');
                    $("#venueleaveId").parent().removeClass('radioerrorcolor');
                    
                    var againstvenuechking = $('#againstvenue').val();
                    if(againstvenuechking!=undefined && againstvenuechking!='')
                    {
                         flagvenformsubchk1 = 1;
                    }else{
                         flagvenformsubchk1 = 0;
                    }
               }
               else
               {
                    flagvenformsubchk1 = 0;
               }
          }
          else
          {
               if (venuearriveradioforchk != '1' && venuearriveradioforchk != '2') {
                    $("#venuearriveId").parent().addClass('radioerrorcolor');
                    flagvenformsubchk1 = 0;
               }
               else if(venuearriveradioforchk == '1' || venuearriveradioforchk == '2'){
                    $("#venuearriveId").parent().removeClass('radioerrorcolor');
                    if(chkagainstvenuevalidation === true)
                    {
                         flagvenformsubchk1 = 1;
                    }
                    else
                    {
                         flagvenformsubchk1 = 0;
                    }
               }
               
               if (venuepresentationradioforchk != '1' && venuepresentationradioforchk != '2') {
                    $("#venuepresentationId").parent().addClass('radioerrorcolor');
                    flagvenformsubchk1 = 0;
               }
               else if(venuepresentationradioforchk == '1' || venuepresentationradioforchk == '2'){
                    $("#venuepresentationId").parent().removeClass('radioerrorcolor');
                    if(chkagainstvenuevalidation === true)
                    {
                         flagvenformsubchk1 = 1;
                    }
                    else
                    {
                         flagvenformsubchk1 = 0;
                    }
               }
               
               if (venuespecificationradioforchk != '1' && venuespecificationradioforchk != '2') {
                    $("#venuespecificationId").parent().addClass('radioerrorcolor');
                    flagvenformsubchk1 = 0;
               }
               else if(venuespecificationradioforchk == '1' || venuespecificationradioforchk == '2'){
                    $("#venuespecificationId").parent().removeClass('radioerrorcolor');
                    if(chkagainstvenuevalidation === true)
                    {
                         flagvenformsubchk1 = 1;
                    }
                    else
                    {
                         flagvenformsubchk1 = 0;
                    }
               }
               
               if (venuetechnicalradioforchk != '1' && venuetechnicalradioforchk != '2') {
                    $("#venuetechnicalId").parent().addClass('radioerrorcolor');
                    flagvenformsubchk1 = 0;
               }
               else if(venuetechnicalradioforchk == '1' || venuetechnicalradioforchk == '2'){
                    $("#venuetechnicalId").parent().removeClass('radioerrorcolor');
                    if(chkagainstvenuevalidation === true)
                    {
                         flagvenformsubchk1 = 1;
                    }
                    else
                    {
                         flagvenformsubchk1 = 0;
                    }
               }
               
               if (venueleaveradioforchk != '1' && venueleaveradioforchk != '2') {
                    $("#venueleaveId").parent().addClass('radioerrorcolor');
                    flagvenformsubchk1 = 0;
               }
               else if(venueleaveradioforchk == '1' || venueleaveradioforchk == '2'){
                    $("#venueleaveId").parent().removeClass('radioerrorcolor');
                    if(chkagainstvenuevalidation === true)
                    {
                         flagvenformsubchk1 = 1;
                    }
                    else
                    {
                         flagvenformsubchk1 = 0;
                    }
               }
          }
          
          if (flagvenformsubchk1 == 1) {
          
               $("#venuesub").prop("disabled", true);
     
               var venuearriveradio = $('input[name=venuearrive]:checked', '#againstvenuefrmid').val();
               var venuearrivaltime = $('#venuearrivaltime').val();
               var venuepresentationradio = $('input[name=venuepresentation]:checked', '#againstvenuefrmid').val();
               var venuespecificationradio = $('input[name=venuespecification]:checked', '#againstvenuefrmid').val();
               var venuetechnicalradio = $('input[name=venuetechnical]:checked', '#againstvenuefrmid').val();
               var venueleaveradio = $('input[name=venueleave]:checked', '#againstvenuefrmid').val();
               var venueleavetime = $('#venueleavetime').val();
               var againstvenue = $('#againstvenue').val();
               var venuedescription = $('#venuesummary').val();
               
               //alert('arriveradio:'+arriveradio+', arrivaltime:'+arrivaltime+', againstartist:'+againstartist);
               
               var againstvenuefrm_url=base_url_data+"/againstvenuefrmsub";
           
               var againstvenuefrm_data={_token:csrf_token_data,'venuearriveradio':venuearriveradio,'venuearrivaltime':venuearrivaltime,'venuepresentationradio':venuepresentationradio,'venuespecificationradio':venuespecificationradio,'venuetechnicalradio':venuetechnicalradio,'venueleaveradio':venueleaveradio,'venueleavetime':venueleavetime,'againstvenue':againstvenue,'venuedescription':venuedescription};
               
               $.ajax({
                  
                    url:againstvenuefrm_url,
                    type:'POST',
                    dataType:'json',
                    data:againstvenuefrm_data,
                    success:function(d){
                         
                         $( '#againstvenuefrmid' ).each(function(){
                              this.reset();
                         });
                         
                         $("#againstvenue").selectpicker('refresh');
                         
                         //$("#againstgroup").selectpicker('refresh');
                         //$("#againstbooker").selectpicker('refresh');
                         //$("#againstartist").selectpicker('refresh');
                         
                         pickerrefreshing();
                         
                         $("#venuesub").prop("disabled", false);
                         
                         //$("#arrivaltime").datetimepicker({
                         //     format:'LT',
                         //     Default:false
                         //});
                         
                         if (d.flag_id == 0)
                         {      
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=2000,etmo=2000,poscls='toast-top-full-width');
                              }
                         }
                         else if(d.flag_id == 1)
                         {
                              poptriggerfunc(msgtype='success',titledata='',msgdata="Dispute with the venue has been saved successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         }
                         else{
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                              }
                         }
                    }
                  
               });
          }
          else{
               toastr.remove();
               poptriggerfunc(msgtype='error',titledata='',msgdata="Please ensure required fields are complete before submitting your dispute against venue",sd=1000,hd=3000,tmo=2000,etmo=1000,poscls='toast-top-full-width');
          }      
     });
     
     $(document).on('click','#bookersub',function(){
          
          var flagbkrformsubchk1='';
          
          var getgigforchk = $('input[name=getgig]:checked', '#againstbookerfrmid').val();
          var commencegigforchk= $('input[name=commencegig]:checked', '#againstbookerfrmid').val();
          var bookertechnicalradioforchk = $('input[name=bookertechnical]:checked', '#againstbookerfrmid').val();
          var bookerspecificationradioforchk = $('input[name=bookerspecification]:checked', '#againstbookerfrmid').val();
          var bookerriderradioforchk = $('input[name=bookerrider]:checked', '#againstbookerfrmid').val();
          var bookerleaveradioforchk = $('input[name=bookerleave]:checked', '#againstbookerfrmid').val();
          
          $("#againstbookerfrmid").validate({                                   
                                    
               /*****add parent class*****/
               highlight: function(element) {
                   $(element).parent().addClass("errorField");
               },
               /*****remove parent class*****/
               unhighlight: function(element) {
                   $(element).parent().removeClass("errorField");
               },   
               /*****remove error text*****/
               errorPlacement: function () {
                   return false;
               },   
                                    
               errorClass: "authError",
               errorElement: 'span',
                                             
               rules: {
                    bookerarrivaltime: {
                         required: true,
                    },
                    againstbooker:{
                         required: true,
                    },
                    bookersummary:{
                         required: true,
                         maxlength: 500,
                    },                               
               },
               
               messages: {
                    bookerarrivaltime: {
                         required: "Please enter arrival time",
                    },
                    againstbooker: {
                         required: "Please select the booker",
                    },
                    bookersummary:{
                         required: "Please provide a description",
                         maxlength: "Maximum 500 characters are allowed",
                    },
               },
                                       
          });
          
          var chkagainstbookervalidation =  $("#againstbookerfrmid").valid();
          
          if( (getgigforchk != undefined && (getgigforchk=='1' || getgigforchk=='2')) && (commencegigforchk != undefined && (commencegigforchk=='1' || commencegigforchk=='2')) && (bookertechnicalradioforchk != undefined && (bookertechnicalradioforchk=='1' || bookertechnicalradioforchk=='2')) && (bookerspecificationradioforchk != undefined && (bookerspecificationradioforchk=='1' || bookerspecificationradioforchk=='2')) && (bookerriderradioforchk != undefined && (bookerriderradioforchk=='1' || bookerriderradioforchk=='2')) && (bookerleaveradioforchk != undefined && (bookerleaveradioforchk=='1' || bookerleaveradioforchk=='2')) )
          {
               if(chkagainstbookervalidation === true)
               {
                    $("#getgigId").parent().removeClass('radioerrorcolor');
                    $("#commencegigId").parent().removeClass('radioerrorcolor');
                    $("#bookertechnicalId").parent().removeClass('radioerrorcolor');
                    $("#bookerspecificationId").parent().removeClass('radioerrorcolor');
                    $("#bookerriderId").parent().removeClass('radioerrorcolor');
                    $("#bookerleaveId").parent().removeClass('radioerrorcolor');
                         
                    var againstbookerchking = $('#againstbooker').val();
                    if(againstbookerchking!=undefined && againstbookerchking!='')
                    {
                         flagbkrformsubchk1 = 1;
                    }else{
                         flagbkrformsubchk1 = 0;
                    }
               }
               else
               {
                    flagbkrformsubchk1 = 0;
               }
          }
          else
          {
               if (getgigforchk != '1' && getgigforchk != '2') {
                    $("#getgigId").parent().addClass('radioerrorcolor');
                    flagbkrformsubchk1 = 0;
               }
               else if (getgigforchk == '1' || getgigforchk == '2') {
                    $("#getgigId").parent().removeClass('radioerrorcolor');
                    if(chkagainstbookervalidation === true)
                    {
                         flagbkrformsubchk1 = 1;
                    }
                    else
                    {
                         flagbkrformsubchk1 = 0;
                    }
               }
               
               if (commencegigforchk != '1' && commencegigforchk != '2') {
                    $("#commencegigId").parent().addClass('radioerrorcolor');
                    flagbkrformsubchk1 = 0;
               }
               else if (commencegigforchk == '1' || commencegigforchk == '2') {
                    $("#commencegigId").parent().removeClass('radioerrorcolor');
                    if(chkagainstbookervalidation === true)
                    {
                         flagbkrformsubchk1 = 1;
                    }
                    else
                    {
                         flagbkrformsubchk1 = 0;
                    }
               }
               
               if (bookertechnicalradioforchk != '1' && bookertechnicalradioforchk != '2') {
                    $("#bookertechnicalId").parent().addClass('radioerrorcolor');
                    flagbkrformsubchk1 = 0;
               }
               else if (bookertechnicalradioforchk == '1' || bookertechnicalradioforchk == '2') {
                    $("#bookertechnicalId").parent().removeClass('radioerrorcolor');
                    if(chkagainstbookervalidation === true)
                    {
                         flagbkrformsubchk1 = 1;
                    }
                    else
                    {
                         flagbkrformsubchk1 = 0;
                    }
               }
               
               if (bookerspecificationradioforchk != '1' && bookerspecificationradioforchk != '2') {
                    $("#bookerspecificationId").parent().addClass('radioerrorcolor');
                    flagbkrformsubchk1 = 0;
               }
               else if (bookerspecificationradioforchk == '1' || bookerspecificationradioforchk == '2') {
                    $("#bookerspecificationId").parent().removeClass('radioerrorcolor');
                    if(chkagainstbookervalidation === true)
                    {
                         flagbkrformsubchk1 = 1;
                    }
                    else
                    {
                         flagbkrformsubchk1 = 0;
                    }
               }
               
               if (bookerriderradioforchk != '1' && bookerriderradioforchk != '2') {
                    $("#bookerriderId").parent().addClass('radioerrorcolor');
                    flagbkrformsubchk1 = 0;
               }
               else if (bookerriderradioforchk == '1' || bookerriderradioforchk == '2') {
                    $("#bookerriderId").parent().removeClass('radioerrorcolor');
                    if(chkagainstbookervalidation === true)
                    {
                         flagbkrformsubchk1 = 1;
                    }
                    else
                    {
                         flagbkrformsubchk1 = 0;
                    }
               }
               
               if (bookerleaveradioforchk != '1' && bookerleaveradioforchk != '2') {
                    $("#bookerleaveId").parent().addClass('radioerrorcolor');
                    flagbkrformsubchk1 = 0;
               }
               else if (bookerleaveradioforchk == '1' || bookerleaveradioforchk == '2') {
                    $("#bookerleaveId").parent().removeClass('radioerrorcolor');
                    if(chkagainstbookervalidation === true)
                    {
                         flagbkrformsubchk1 = 1;
                    }
                    else
                    {
                         flagbkrformsubchk1 = 0;
                    }
               }
          }
          
          if (flagbkrformsubchk1 == 1) {
          
               $("#bookersub").prop("disabled", true);
     
               var getgig = $('input[name=getgig]:checked', '#againstbookerfrmid').val();
               var bookerarrivaltime = $('#bookerarrivaltime').val();
               var commencegig= $('input[name=commencegig]:checked', '#againstbookerfrmid').val();
               var bookertechnicalradio = $('input[name=bookertechnical]:checked', '#againstbookerfrmid').val();
               var bookerspecificationradio = $('input[name=bookerspecification]:checked', '#againstbookerfrmid').val();
               var bookerriderradio = $('input[name=bookerrider]:checked', '#againstbookerfrmid').val();
               var bookerleaveradio = $('input[name=bookerleave]:checked', '#againstbookerfrmid').val();
               var againstbooker = $('#againstbooker').val();
               var bookerdescription = $('#bookersummary').val();
               
               //alert('arriveradio:'+arriveradio+', arrivaltime:'+arrivaltime+', againstartist:'+againstartist);
               
               var againstbookerfrm_url=base_url_data+"/againstbookerfrmsub";
           
               var againstbookerfrm_data={_token:csrf_token_data,'getgig':getgig,'bookerarrivaltime':bookerarrivaltime,'commencegig':commencegig,'bookertechnicalradio':bookertechnicalradio,'bookerspecificationradio':bookerspecificationradio,'bookerriderradio':bookerriderradio,'bookerleaveradio':bookerleaveradio,'againstbooker':againstbooker,'bookerdescription':bookerdescription};
               
               $.ajax({
                  
                    url:againstbookerfrm_url,
                    type:'POST',
                    dataType:'json',
                    data:againstbookerfrm_data,
                    success:function(d){
                         
                         $( '#againstbookerfrmid' ).each(function(){
                              this.reset();
                         });
                         
                         $("#againstbooker").selectpicker('refresh');
                         
                         //$("#againstgroup").selectpicker('refresh');
                         //$("#againstvenue").selectpicker('refresh');
                         //$("#againstartist").selectpicker('refresh');
                         
                         pickerrefreshing();
                         
                         $("#bookersub").prop("disabled", false);
                         
                         //$("#datetimepicker3").datetimepicker({
                         //     format:'LT',
                         //     Default:false
                         //});
                         
                         if (d.flag_id == 0)
                         {      
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=2000,etmo=2000,poscls='toast-top-full-width');
                              }
                         }
                         else if(d.flag_id == 1)
                         {
                              poptriggerfunc(msgtype='success',titledata='',msgdata="Dispute with the booker has been saved successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         }
                         else{
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                              }
                         }
                    }
                  
               });
          }
          else{
               toastr.remove();
               poptriggerfunc(msgtype='error',titledata='',msgdata="Please ensure required fields are complete before submitting your dispute against booker",sd=1000,hd=3000,tmo=2000,etmo=1000,poscls='toast-top-full-width');
          }
     });
     
     
     //$(document).on('click','#consupsub',function(){
     //
     //     var reqres = $('input[name=reqres]:checked', '#contactsupportfrmid').val();
     //     var mecopy = $('input[name=mecopy]:checked', '#contactsupportfrmid').val();
     //     var condesc = $('#condesc').val();
     //     var conemail = $('#conemail').val();
     //     var conlname = $('#conlname').val();
     //     var confname = $('#confname').val();
     //     var contactreason = $('#contactreason').val();
     //     
     //     var contactsupportfrm_url=base_url_data+"/contactsupportfrmsub";
     // 
     //     var contactsupportfrm_data={_token:csrf_token_data,'reqres':reqres,'mecopy':mecopy,'condesc':condesc,'conemail':conemail,'conlname':conlname,'confname':confname,'contactreason':contactreason};
     //     
     //     $.ajax({
     //        
     //          url:contactsupportfrm_url,
     //          type:'POST',
     //          dataType:'json',
     //          data:contactsupportfrm_data,
     //          success:function(d){
     //               
     //               $( '#contactsupportfrmid' ).each(function(){
     //                    this.reset();
     //               });
     //               
     //               $("#contactreason").selectpicker('refresh');
     //               
     //               if (d.flag_id == 0)
     //               {      
     //                    var error_message=d.error_message;
     //                    var error_message_data='';
     //                                               
     //                    if (error_message!=null)
     //                    {
     //                         for (ermsgkey in error_message)
     //                         {
     //                              error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
     //                         }
     //                    }
     //                    
     //                    if (error_message_data!='') {              
     //                         poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=2000,etmo=2000,poscls='toast-top-full-width');
     //                    }
     //               }
     //               else if(d.flag_id == 1)
     //               {
     //                    poptriggerfunc(msgtype='success',titledata='',msgdata="Your contact details has been sent successfully to the site support team",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
     //               }
     //               else{
     //                    var error_message=d.error_message;
     //                    var error_message_data='';
     //                                               
     //                    if (error_message!=null)
     //                    {
     //                         for (ermsgkey in error_message)
     //                         {
     //                              error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
     //                         }
     //                    }
     //                    
     //                    if (error_message_data!='') {              
     //                         poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
     //                    }
     //               }
     //          }
     //        
     //     });
     //
     //});
     
     $(document).on('click','#consupsub',function(){
          
          var flagformsubchk='';
          var contrsn = $('#contactreason').val();
          
          $("#contactsupportfrmid").validate({                                   
                                    
               /*****add parent class*****/
               highlight: function(element) {
                   $(element).parent().addClass("errorField");
               },
               /*****remove parent class*****/
               unhighlight: function(element) {
                   $(element).parent().removeClass("errorField");
               },   
               /*****remove error text*****/
               errorPlacement: function () {
                   return false;
               },   
                                    
               errorClass: "authError",
               errorElement: 'span',
                                             
               rules: {
                    contactreason: {
                         required: true,
                    },
                    confname:{
                          required: true,
                    },
                    conemail:{
                          required: true,
                          email: true,
                    },
                    condesc:{
                          required: true,
                    },                               
               },
               
               messages: {
                    contactreason: {
                       required: "Please select a contact reason",
                    },
                    confname: {
                       required: "Please enter first name",
                    },
                    conemail: {
                       required: "Please enter email address",
                       email: "Please enter a valid email address",
                    },
                    condesc:{
                          required: "Please enter a message",
                    },
               },
                                       
          });
          
          var chkcontactsupportvalidation =  $("#contactsupportfrmid").valid();
          
          if (contrsn==6) {
               var evesel=$('#gigselect').val();
               if (evesel!='') {
                    $("#gigselect").parent().removeClass('errorField');
                    if(chkcontactsupportvalidation === true){
                         flagformsubchk = 1;
                    }else{
                         flagformsubchk = 0;
                    }
               }
               else{
                    $("#gigselect").parent().addClass('errorField');
                    flagformsubchk = 0;
               }
          }
          else{
               if(chkcontactsupportvalidation === true){
                    flagformsubchk = 1;
               }
               else{
                    flagformsubchk = 0;
               }
          }
          
          if (flagformsubchk == 1) {
          
               $("#consupsub").prop("disabled", true);
     
               var reqres = $('input[name=reqres]:checked', '#contactsupportfrmid').val();
               var mecopy = $('input[name=mecopy]:checked', '#contactsupportfrmid').val();
               var condesc = $('#condesc').val();
               var conemail = $('#conemail').val();
               var conlname = $('#conlname').val();
               var confname = $('#confname').val();
               var contactreason = $('#contactreason').val();
               
               if (contactreason==6) {
                 var gigselect=$('#gigselect').val();
               }
               else{
                  var gigselect='';  
               }
               
               var contactsupportfrm_url=base_url_data+"/contactsupportfrmsub";
           
               var contactsupportfrm_data={_token:csrf_token_data,'reqres':reqres,'mecopy':mecopy,'condesc':condesc,'conemail':conemail,'conlname':conlname,'confname':confname,'contactreason':contactreason,'gigselect':gigselect};
               
               $.ajax({
                  
                    url:contactsupportfrm_url,
                    type:'POST',
                    dataType:'json',
                    data:contactsupportfrm_data,
                    success:function(d){
                         
                         $( '#contactsupportfrmid' ).each(function(){
                              this.reset();
                         });
                         
                         $("#contactreason").selectpicker('refresh');
                         
                         if (contactreason==6) {
                              
                              pickerrefreshing();
                              
                              $("#eventselect").hide();
                              
                              //$("#gigselect").selectpicker('refresh');
                              //console.log('refreshing6');
                              //alert('refreshing6');
                              //$("#againstartist").selectpicker('refresh');
                              //$("#againstgroup").selectpicker('refresh');
                              //$("#againstvenue").selectpicker('refresh');
                              //$("#againstbooker").selectpicker('refresh');
                         }
                         
                         $("#consupsub").prop("disabled", false);
                         
                         if (d.flag_id == 0)
                         {      
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=2000,etmo=2000,poscls='toast-top-full-width');
                              }
                         }
                         else if(d.flag_id == 1)
                         {
                              poptriggerfunc(msgtype='success',titledata='',msgdata="Your message has been sent to the Support Team",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         }
                         else{
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                              }
                         }
                    }
                  
               });
          
          }
          else{
               toastr.remove();
               poptriggerfunc(msgtype='error',titledata='',msgdata="Please ensure required fields are complete before submitting your Contact Support informations",sd=1000,hd=3000,tmo=2000,etmo=1000,poscls='toast-top-full-width');
          }
    
     });
     
     
     $(document).on('click','#resolve',function(){
          
          window.location.href = base_url_data+"/showdisputerecords";
     });
     
     
     $(document).on('click','#detailsub',function(){
          
          var disputeid=$(this).data("disputeid");
          window.location.href = base_url_data+"/showdisputereplies/"+disputeid;
          //var xtra='main';
          //var disrplfrmdata={_token:csrf_token_data, 'disputeid':disputeid, 'xtra':xtra};
          //var disrplfrmurl=base_url_data+"/showdisputereplies";
          //$.ajax({
          //          url:disrplfrmurl,
          //          type:'POST',
          //          data:disrplfrmdata,
          //          success:function(d){
          //               jQuery('body').load(base_url_data+"/showdisputereplies");
          //          }
          //});
     });
     
     $(document).on('click','#disback1',function(){
          
          window.history.back();
     });
     
     $(document).on('click','#disback2',function(){
          
          window.history.back();
     });
     
     
     $(document).on('click','#subreply',function(){
          
          if ($('input.checkboxcheck_admin').is(':checked')) {
               var adminid = $('#admincheck').val();
               var adminmail = $('#adminemailid').val();
          }
          else{
               var adminid = 0;
               var adminmail = '';
          }
          
          if ($('input.checkboxcheck_opponent').is(':checked')) {
               var opponentid = $('#opponentcheck').val();
               var opponentmail = $('#opponentemailid').val();
          }
          else{
               var opponentid = 0;
               var opponentmail = '';
          }
          
          var replydesc = $('#opponent_description').val();
          var disputemainid = $('#hiddisputeid').val();
          var disputemaintype = $('#hiddisputetype').val();
          var disputegigmstrid = $('#hiddisputegigid').val();
          var disputegigmstruniqueid = $('#hiddisputegiguniqueid').val();
          var disputegigmstrtype = $('#hiddisputegigtype').val();
          var disputegigmstrbookerid = $('#hiddisputegigbookerid').val();
          var disputegigmstrartistid = $('#hiddisputegigartistid').val();
          var disputefrontperpagelimit = $('#hidmodlimit').val();
          
          var disputereplyfrm_url=base_url_data+"/frontdisputereplyfrmsub";
          //var disputereplyfrm_url=base_url_data+"/showdisputereplies/"+disputemainid+"/flagpass";
      
          var disputereplyfrm_data={_token:csrf_token_data, 'adminid':adminid, 'adminmail':adminmail, 'opponentid':opponentid, 'opponentmail':opponentmail, 'replydesc':replydesc, 'disputemainid':disputemainid, 'disputemaintype':disputemaintype, 'disputegigmstrid':disputegigmstrid, 'disputegigmstruniqueid':disputegigmstruniqueid, 'disputegigmstrtype':disputegigmstrtype, 'disputegigmstrbookerid':disputegigmstrbookerid, 'disputegigmstrartistid':disputegigmstrartistid};
          
          //var disputereplyfrm_data={_token:csrf_token_data, 'adminid':adminid, 'adminmail':adminmail, 'opponentid':opponentid, 'opponentmail':opponentmail, 'replydesc':replydesc, 'xtra':'submain'};
          
          if((adminid==0 || adminid=='') && (opponentid==0 || opponentid==''))
          {
               poptriggerfunc(msgtype='error',titledata='',msgdata="You didn\'t choose any of the checkboxes!",sd=1000,hd=1500,tmo=2000,etmo=2000,poscls='toast-top-full-width');
          }
          else{
               $.ajax({
                  
                    url:disputereplyfrm_url,
                    type:'POST',
                    dataType:'json',
                    data:disputereplyfrm_data,
                    success:function(d){
                         
                         if (d.flag_id == 0)
                         {      
                              var error_message=d.error_message;
                              var error_message_data='';
                                                         
                              if (error_message!=null)
                              {
                                   for (ermsgkey in error_message)
                                   {
                                        error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                   }
                              }
                              
                              if (error_message_data!='') {              
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=2000,etmo=2000,poscls='toast-top-full-width');
                              }
                         }
                         else if(d.flag_id == 1)
                         {
                              poptriggerfunc(msgtype='success',titledata='',msgdata="Dispute reply has been saved successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                              
                              var resp=d.replyrec;
                              $("#nextreply").html(resp);
                              
                              $( '#frontdisputereplyfrm' ).each(function(){
                                   this.reset();
                              });
                              
                              $('#disrpl').modal('hide');
                              
                              //$('#limit').val(next_limit);
                              $('#frontloadDiv').html(' ');
                              $('#limit').val(disputefrontperpagelimit);
                              
                              if($("#frontreplyload").is(":hidden")){
                                  $('#frontreplyload').show();	
                              }
                         }
                    }
               });
          }
     });
     
     $('#frontreplyload').click(function(){
          var respdata = '';
          
          var total_data = $('#total_data').val();
          var limit = $('#limit').val();
          var actual_limit=$('#actuallimit').val();
          var next_limit = parseInt(limit)+parseInt(actual_limit);
            
          var disputemainid = $('#hid_hiddisputeid').val();
          var disputemaintype = $('#hid_hiddisputetype').val();
          var disputegigmstrid = $('#hid_hiddisputegigid').val();
          var disputegigmstruniqueid = $('#hid_hiddisputegiguniqueid').val();
          var disputegigmstrtype = $('#hid_hiddisputegigtype').val();
          var disputegigmstrbookerid = $('#hid_hiddisputegigbookerid').val();
          var disputegigmstrartistid = $('#hid_hiddisputegigartistid').val();
            
          var moreurl= base_url_data+"/frontend-dispute-replies-loadmore";
          var moredata={_token:csrf_token_data, 'disputemainid':disputemainid, 'disputemaintype':disputemaintype, 'disputegigmstrid':disputegigmstrid, 'disputegigmstruniqueid':disputegigmstruniqueid, 'disputegigmstrtype':disputegigmstrtype, 'disputegigmstrbookerid':disputegigmstrbookerid, 'disputegigmstrartistid':disputegigmstrartistid, 'limit':limit};
            
          $.ajax({
               url:moreurl,
               type: "POST",
               dataType:'json',
               data:moredata,
               success:function(d){
                    respdata=d.replyrec;
                    $('#frontloadDiv').append(respdata);
                    
                    if (total_data > next_limit ){
                            $('#frontreplyload').show();	
                    }
                    else{
                            $('#frontreplyload').hide();
                    }
                    
                    $('#limit').val(next_limit);  
               }
          });
     });
     
     
     $('#frontrecordload').click(function(){
          var respdata = '';
          
          var total_data = $('#total_data').val();
          var limit = $('#limit').val();
          var actual_limit=$('#actuallimit').val();
          var next_limit = parseInt(limit)+parseInt(actual_limit);
            
          var disputemainid = $('#hid_hiddisputeid').val();
          var disputemaintype = $('#hid_hiddisputetype').val();
          var disputegigmstrid = $('#hid_hiddisputegigid').val();
          var disputegigmstruniqueid = $('#hid_hiddisputegiguniqueid').val();
          var disputegigmstrtype = $('#hid_hiddisputegigtype').val();
          var disputegigmstrbookerid = $('#hid_hiddisputegigbookerid').val();
          var disputegigmstrartistid = $('#hid_hiddisputegigartistid').val();
            
          var moreurl= base_url_data+"/frontend-dispute-records-loadmore";
          var moredata={_token:csrf_token_data, 'disputemainid':disputemainid, 'disputemaintype':disputemaintype, 'disputegigmstrid':disputegigmstrid, 'disputegigmstruniqueid':disputegigmstruniqueid, 'disputegigmstrtype':disputegigmstrtype, 'disputegigmstrbookerid':disputegigmstrbookerid, 'disputegigmstrartistid':disputegigmstrartistid, 'limit':limit};
            
          $.ajax({
               url:moreurl,
               type: "POST",
               dataType:'json',
               data:moredata,
               success:function(d){
                    respdata=d.replyrec;
                    $('#frontloadDiv').append(respdata);
                    
                    if (total_data > next_limit ){
                            $('#frontreplyload').show();	
                    }
                    else{
                            $('#frontreplyload').hide();
                    }
                    
                    $('#limit').val(next_limit);  
               }
          });
     });

});


$(document).on('change','#contactreason',function(){
     
     var valchoose=$(this).val();
     //alert(valchoose);
     if (valchoose==6) {
        $("#eventselect").show();
     }
     else{
        $("#eventselect").hide();  
     }
     
});


     function pickerrefreshing(){
          refreshing_url=base_url_data+"/refreshingpicker";
          $.ajax({
               url:refreshing_url,
               type:'POST',
               dataType:'json',
               data:{_token:csrf_token_data},
               success:function(d){
                    console.log(d);
                    
                    resdatacanelgig=d.contents_cancelgig;
                    $('#eventselect').html(resdatacanelgig);
                    console.log(resdatacanelgig);
                    
                    resdataagainstartist=d.contents_againstartist;
                    $('#againstartistlist').html(resdataagainstartist);
                    console.log(resdataagainstartist);
                    
                    resdataagainstgroup=d.contents_againstgroup;
                    $('#againstgrouplist').html(resdataagainstgroup);
                    console.log(resdataagainstgroup);
                     
                    resdataagainstvenue=d.contents_againstvenue;
                    $('#againstvenuelist').html(resdataagainstvenue);
                    console.log(resdataagainstvenue);
                     
                    resdataagainstbooker=d.contents_againstbooker;
                    $('#againstbookerlist').html(resdataagainstbooker);
                    console.log(resdataagainstbooker);
                     
                    $('#gigselect').selectpicker('refresh');
                    $("#againstartist").selectpicker('refresh');
                    $("#againstgroup").selectpicker('refresh');
                    $("#againstvenue").selectpicker('refresh');
                    $("#againstbooker").selectpicker('refresh');
               }
          });
     }