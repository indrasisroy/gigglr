$(document).ready(function(){

     $(document).on('click','#artistsub',function(){

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
                         poptriggerfunc(msgtype='success',titledata='',msgdata="Dispute with the artist has beensaved successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
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
                    
                    $( '#againstartistfrmid' ).each(function(){
                         this.reset();
                    });
                    
                    $("#againstartist").selectpicker('refresh');
                    
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
                         poptriggerfunc(msgtype='success',titledata='',msgdata="Dispute with the artist has beensaved successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
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

});