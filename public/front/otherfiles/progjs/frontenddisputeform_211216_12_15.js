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
                    
                    $("#againstgroup").selectpicker('refresh');
                    $("#againstvenue").selectpicker('refresh');
                    $("#againstbooker").selectpicker('refresh');
                    
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
    
     });
     
     $(document).on('click','#groupsub',function(){
          
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
                    
                    $("#againstvenue").selectpicker('refresh');
                    $("#againstbooker").selectpicker('refresh');
                    $("#againstartist").selectpicker('refresh');
                    
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
    
     });
     
     $(document).on('click','#venuesub',function(){
          
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
                    
                    $("#againstgroup").selectpicker('refresh');
                    $("#againstbooker").selectpicker('refresh');
                    $("#againstartist").selectpicker('refresh');
                    
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
    
     });
     
     $(document).on('click','#bookersub',function(){
          
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
                    
                    $("#againstgroup").selectpicker('refresh');
                    $("#againstvenue").selectpicker('refresh');
                    $("#againstartist").selectpicker('refresh');
                    
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
                         $("#gigselect").selectpicker('refresh');
                         console.log('refreshing6');
                         alert('refreshing6');
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