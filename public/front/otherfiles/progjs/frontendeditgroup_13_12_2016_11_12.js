//var facebook_url_deflt="https://www.facebook.com/";
//var soundcloud_url_deflt="https://www.soundcloud.com/";
//var residentadvisor_url_deflt="https://www.residentadvisor.net/";
//var twitter_url_deflt="https://www.twitter.com/";
//var youtube_url_deflt="https://www.youtube.com/";
//var instagram_url_deflt="https://www.instagram.com/";
// saveuserurls   savegroupurls
var parentskilladdedar=[];
function samesize() {
                $('.container').each(function(){  
                  var highestBox = 0;
                  $('.sam_height', this).each(function(){
                    if($(this).outerHeight() > highestBox) {
                      highestBox = $(this).outerHeight();
                    }                  
                  });  
                  $('.sam_height',this).outerHeight(highestBox);
                                
                });
            }
            
            
            
            
            
            function addMyGenre() {
                 // alert($(this).val());
                    
                    var skill_parent_data=parseInt($("#skill_parent").find(":selected").val());
                    var skill_parent_txtdata=$("#skill_parent").find(":selected").text();
                    // var  skill_sub_data=parseInt($(this).val());
                    var  skill_sub_data=parseInt($("#skill_sub").find(":selected").val());
                    //var  skill_sub_txtdata=$(this).find(":selected").text();
                     var  skill_sub_txtdata=$("#skill_sub").find(":selected").text();
                    
                    var totcnt=$("#skillidouterdiv").find('.skillparentclss').length;
                   //alert(skill_sub_txtdata+"==="+skill_parent_txtdata);
                   
                   if(skill_sub_txtdata=="Select Genre")
                   {
                        return false;        
                   }                   
                    if (totcnt>0)
                    {
                         
                        $("#skillidouterdiv").find('.skillparentclss').each(function(){
                         
                          var skillparclss_data=parseInt($(this).data("skillparent"));
                                                   
                          var check_skillparclss_data= $.inArray( skillparclss_data, parentskilladdedar );
                           
              
                              if (check_skillparclss_data==-1)
                              {
                                  parentskilladdedar.push(skillparclss_data);
                              }
                               
                         
                         }); 
                         
                   
                              var check_parispresent= $.inArray( skill_parent_data, parentskilladdedar );

                              if (check_parispresent!=-1)
                              {
                                   //***** create small  structure  starts
                                   
                                   //console.log(" 22 parent skill div exists add new sub skill");
                                   
                                   var prntsklobj=$("#skillidouterdiv").find(".skillparentclss[data-skillparent='" + skill_parent_data + "']"); // get the parent skill div obj
                                 
                                   
                                             //** check whether sub skill present in the structure or not starts
                                             
                                            var suskillobjchk=prntsklobj.find(".mysubcustcls[data-skillsub='" + skill_sub_data + "']");
                                          
                                             //alert("22 check =suskillobjchk=>"+suskillobjchk);
                                             //** check whether sub skill present in the structure or not ends 
                                             
                                                  if (suskillobjchk.data("skillsub")==null)
                                                  {
                                                       var prevklmstrdivstruc=prntsklobj.html();
                                                       
                                                       prevklmstrdivstruc=prevklmstrdivstruc.replace(/\./gi, ",");
                                                       
                                                       
                                                       var newsklmstrdivstruc="<div class='gener mysubcustcls' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"'  >"+skill_sub_txtdata+".<span class='delsubskillclass' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"' >&times;</span></div>";

                                                       
                                                       prntsklobj.html(prevklmstrdivstruc+newsklmstrdivstruc);
                                                       callsaveskilldata(2,skill_parent_data,skill_sub_data,"savegroupskilldata"); // saveskilldata
                                                  }
                                                  else
                                                  {
                                                       //alert("already sub struct present");
                                                       toastr.remove();// Immediately remove current toasts without using animation
                                                       poptriggerfunc(msgtype='error',titledata='',msgdata="This genre already exist",sd=1000,hd=1500,tmo=10000,etmo=2000,poscls='toast-top-full-width');
                         
                                                  }
                                   
                                  
                                  //***** create small  structure  ends
                                  
                                   //**** bind delete to skill starts
                              
                                   $(".delsubskillclass").click(function(){
                                                deleteskillstruct(this);
                                                 
                                                  
                                   });
                                   
                                   //**** bind delete to skill ends
                              }
                              else
                              {
                                    //console.log(" 333 create new whole structure parent skill div struct ");
                                   //***** create new whole structure  starts
                                   
                                              // alert("parent skill not present add new whole");
                                        var prevklmstrdivstruc=$("#skillidouterdiv").html();
                                        var newsklmstrdivstruc="<div class='name_holder skillparentclss'  data-skillparent='"+skill_parent_data+"' ><div class='mainCategory skillparentname'>"+skill_parent_txtdata+":</div><div class='gener mysubcustcls' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"' >"+skill_sub_txtdata+".<span class='delsubskillclass' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"'>&times;</span></div></div>";
                                        $("#skillidouterdiv").html(prevklmstrdivstruc+newsklmstrdivstruc);
                                  
                                         callsaveskilldata(2,skill_parent_data,skill_sub_data,"savegroupskilldata"); // saveskilldata
                                  
                                   //***** create new whole structure  ends
                                    //**** bind delete to skill starts
                              
                                   $(".delsubskillclass").click(function(){
                                   deleteskillstruct(this);     

                                   });
                                   
                                   //**** bind delete to skill ends
                              
                               }
                    
                    
                    
                    
                    }
                    else
                    {
                         parentskilladdedar.push(skill_parent_data);
                         //console.log("=parentskilladdedar array contnt => "+parentskilladdedar.toString()+"--length of array=>"+parentskilladdedar.length)
                               //***** create structure  starts
                              
                             //alert("add new whole skill struct");
                             //console.log("11 not a singl struct present create 1st new struct");
                             var newsklmstrdivstruc="<div class='name_holder skillparentclss'  data-skillparent='"+skill_parent_data+"' ><div class='mainCategory skillparentname'   >"+skill_parent_txtdata+":</div><div class='gener mysubcustcls' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"' >"+skill_sub_txtdata+".<span class='delsubskillclass' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"'>&times;</span></div></div>";
                             $("#skillidouterdiv").html(newsklmstrdivstruc);
                                                         
                             callsaveskilldata(2,skill_parent_data,skill_sub_data,"savegroupskilldata"); // saveskilldata
                             
                              //***** create structure  ends
                              
                              //**** bind delete to skill starts
                              
                              $(".delsubskillclass").click(function(){
                                   deleteskillstruct(this); 

                              });
                              
                              //**** bind delete to skill ends
                              
                    }
                   
                    
                    
                     // populatessubkill(skill_parent_data,1,'skilladd'); // refresh sub skill drop down 
                             
            }

function callcalviewshowflagsave(clkobj)
               {
                     var calviewshowflagdata=$(clkobj).data("calviewshowflag");               
               var typeflagdata=$(clkobj).data("typeflag");
               var artistgrpvenueid=$(clkobj).data("artistgrpvenueid");
               
               //calendarshowhidesave
              
               var callingurlfunc="calendarshowhidesave";
               var callingurl=base_url_data+"/"+callingurlfunc;
                         var callurlwithdata={_token:csrf_token_data,'type_flag':typeflagdata,'cal_viewshowflag':calviewshowflagdata,'artistgrpvenueid':artistgrpvenueid};
                         var cmsgdata='data updated successfully';
            
                            $.ajax({
                                url:callingurl,
                                type:'POST',
                                dataType:'json',
                                data:callurlwithdata,
                                success:function(d){
                                                toastr.remove();// Immediately remove current toasts without using animation
                                                
                                                //***************** Check response starts
                                                
                                                if (d.update_flag==0)
                                                {
                                                
                                                       poptriggerfunc(msgtype='error',titledata='',msgdata=d.error_message,sd=1000,hd=1500,tmo=1000,etmo=2000,poscls='toast-top-full-width');
                                                
                                                }
                                                else
                                                {
                                                  
                                                       viewshowflag=calviewshowflagdata;
                                                       
                                                       if (viewshowflag==0)
                                                       {
                                                            $(".yellowstardev").hide();
                                                            $(".redclockdev").hide();
                                                            $(".calsettingsdvcls").slideUp(); 
                                                             
                                                       }
                                                       else if (viewshowflag==1)
                                                       {
                                                            
                                                                  if (pendingbkshowflag_trk==0)
                                                                 {
                                                                      $(".redclockdev").hide();
                                                                 }
                                                                 else
                                                                 {
                                                                       $(".redclockdev").show();						
                                                                 
                                                                 }
                                                                 
                                                                 if (publiceventshowflag_trk==0)
                                                                 {
                                                                  $(".yellowstardev").hide();
                                                                 }
                                                                 else
                                                                 {
                                                                  $(".yellowstardev").show();						
                                                                 
                                                                 }
                                                                 
                                                                 $(".calsettingsdvcls").slideDown(); 
                                                                 
                                                                 
                                                           
                                                       }
                                                       
                                                       $(".calendarPopBtn").trigger("click"); // hide dropdown popup
                                                       
                                                       poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                                                }
                                                      
                                                //***************** Check response ends      
                                             }
                                  }); 
               }
               
function callpendbkpblshowflclssave(clkobj)
               {
                
                    if (viewshowflag==0)
                    {
                         toastr.remove();// Immediately remove current toasts without using animation
                         var emsgdata=" 'Show Calendar' option is not set .  ";
                          poptriggerfunc(msgtype='error',titledata='',msgdata=emsgdata,sd=1000,hd=2500,tmo=2000,etmo=1000,poscls='toast-top-full-width');
                          return false;
                    }
                
                
                    var pendbkpblshowfldata=$(clkobj).data("pendbkpblshowfl");
                    var pendingbkshowflagdata=$(clkobj).data("pendingbkshowflag");
                    
                    
                    var typeflagdata=$(clkobj).data("typeflag");
                    var artistgrpvenueid=$(clkobj).data("artistgrpvenueid");
                
                //alert(pendbkpblshowfldata+" "+pendingbkshowflagdata+" "+typeflagdata+" "+artistgrpvenueid);
                
                
                var callingurlfunc="calpendbkpublicevesave";
                var callingurl=base_url_data+"/"+callingurlfunc;
                         var callurlwithdata={_token:csrf_token_data,'type_flag':typeflagdata,'pendbkpblshowfl':pendbkpblshowfldata,'pendingbkshowflag':pendingbkshowflagdata,'artistgrpvenueid':artistgrpvenueid};
                         var cmsgdata='data updated successfully';
                
                            $.ajax({
                                url:callingurl,
                                type:'POST',
                                dataType:'json',
                                data:callurlwithdata,
                                success:function(d){
                                                toastr.remove();// Immediately remove current toasts without using animation
                                                
                                                
                                                
                                                
                                                //***************** Check response starts
                                                
                                                if (d.update_flag==0)
                                                {
                                                
                                                       poptriggerfunc(msgtype='error',titledata='',msgdata=d.error_message,sd=1000,hd=1500,tmo=1000,etmo=2000,poscls='toast-top-full-width');
                                                
                                                }
                                                else
                                                {
                                                  
                                                       //pendbkpblshowflmsgcls
                                                       
                                                       
                                                       if (pendbkpblshowfldata=="cal_pendingbkshowflag")
                                                       {
                                                           if (pendingbkshowflagdata=='0')
                                                           {
                                                                 var msgdata="Show Pending Booking";
                                                                 $(clkobj).data("pendingbkshowflag","1");
                                                                 $(clkobj).find(".pendbkpblshowflmsgcls").html(msgdata);
                                                                 
                                                                 pendingbkshowflag_trk=pendingbkshowflagdata;
                                                                 
                                                                 if (pendingbkshowflag_trk==0)
                                                                 {
                                                                                $(".redclockdev").hide();
                                                                                $(".pendingmsg").removeClass( "remove_icon" );
                                                                                $(".pendingmsg").addClass( "add_icon" );
                                                                 }
                                                                 else
                                                                 {
                                                                                $(".redclockdev").show();						
                                                                                $(".pendingmsg").removeClass( "add_icon" );
                                                                                $(".pendingmsg").addClass( "remove_icon" );
                                                                 }
                                                                 
                                                           }
                                                           else if(pendingbkshowflagdata=='1')
                                                           {
                                                                 var msgdata="Hide Pending Booking";
                                                                 $(clkobj).data("pendingbkshowflag","0");
                                                                 $(clkobj).find(".pendbkpblshowflmsgcls").html(msgdata);
                                                                 
                                                                 pendingbkshowflag_trk=pendingbkshowflagdata;
                                                                 
                                                                  if (pendingbkshowflag_trk==0)
                                                                 {
                                                                                $(".redclockdev").hide();
                                                                                $(".pendingmsg").removeClass( "remove_icon" );
                                                                                $(".pendingmsg").addClass( "add_icon" );
                                                                 }
                                                                 else
                                                                 {
                                                                                $(".redclockdev").show();
                                                                                $(".pendingmsg").removeClass( "add_icon" );
                                                                                $(".pendingmsg").addClass( "remove_icon" );
                                                                 
                                                                 }
                                                           }
                                                      
                                                       }
                                                       else if (pendbkpblshowfldata=="cal_publiceventshowflag")
                                                       {
                                                            if (pendingbkshowflagdata==0)
                                                           {
                                                                  var msgdata="Show my public events";                                                                  
                                                                  $(clkobj).data("pendingbkshowflag","1");
                                                                  $(clkobj).find(".pendbkpblshowflmsgcls").html(msgdata);
                                                                  
                                                                  publiceventshowflag_trk=pendingbkshowflagdata;
                                                                  
                                                                  
                                                                 
                                                                  if (publiceventshowflag_trk==0)
                                                                 {
                                                                            $(".yellowstardev").hide();
                                                                            $(".publicevent").removeClass( "remove_icon" );
                                                                            $(".publicevent").addClass( "add_icon" );
                                                                 }
                                                                 else
                                                                 {
                                                                            $(".yellowstardev").show();
                                                                            $(".publicevent").removeClass( "add_icon" );
                                                                            $(".publicevent").addClass( "remove_icon" );					
                                                                 
                                                                 }
                                                                  
                                                                  
                                                                  
                                                           }
                                                           else if(pendingbkshowflagdata==1)
                                                           {
                                                                  var msgdata="Hide my public events";                                                                  
                                                                  $(clkobj).data("pendingbkshowflag","0");
                                                                  $(clkobj).find(".pendbkpblshowflmsgcls").html(msgdata);
                                                                  
                                                                  publiceventshowflag_trk=pendingbkshowflagdata;
                                                                  
                                                                  if (publiceventshowflag_trk==0)
                                                                 {
                                                                            $(".yellowstardev").hide();
                                                                            $(".publicevent").removeClass( "remove_icon" );
                                                                            $(".publicevent").addClass( "add_icon" );
                                                                 }
                                                                 else
                                                                 {
                                                                            $(".yellowstardev").show();
                                                                            $(".publicevent").removeClass( "add_icon" );
                                                                            $(".publicevent").addClass( "remove_icon" );					
                                                                 
                                                                 }
                                                           } 
                                                       }
                                                       // added by dhiman start start
                                                          else if (pendbkpblshowfldata=="cal_privateeventshowflag")
                                                       {
                                                            if (pendingbkshowflagdata==0)
                                                           {
                                                                  var msgdata="Show my private events";                                                                  
                                                                  $(clkobj).data("pendingbkshowflag","1");
                                                                  $(clkobj).find(".pendbkpblshowflmsgcls").html(msgdata);
                                                                  
                                                                  publiceventshowflag_trk=pendingbkshowflagdata;
                                                                  
                                                                  
                                                                 
                                                                  if (publiceventshowflag_trk==0)
                                                                 {
                                                                                $(".blackstardev").hide();
                                                                                $(".privateevent").removeClass( "remove_icon" );
                                                                                $(".privateevent").addClass( "add_icon" );
                                                                 }
                                                                 else
                                                                 {
                                                                                $(".blackstardev").show();						
                                                                                $(".privateevent").removeClass( "add_icon" );
                                                                                $(".privateevent").addClass( "remove_icon" );
                                                                 }
                                                                  
                                                                  
                                                                  
                                                           }
                                                           else if(pendingbkshowflagdata==1)
                                                           {
                                                                  var msgdata="Hide my private events";                                                                  
                                                                  $(clkobj).data("pendingbkshowflag","0");
                                                                  $(clkobj).find(".pendbkpblshowflmsgcls").html(msgdata);
                                                                  
                                                                  publiceventshowflag_trk=pendingbkshowflagdata;
                                                                  
                                                                  if (publiceventshowflag_trk==0)
                                                                 {
                                                                                $(".blackstardev").hide();
                                                                                $(".privateevent").removeClass( "remove_icon" );
                                                                                $(".privateevent").addClass( "add_icon" );
                                                                 }
                                                                 else
                                                                 {
                                                                                $(".blackstardev").show();						
                                                                                $(".privateevent").removeClass( "add_icon" );
                                                                                $(".privateevent").addClass( "remove_icon" );	 
                                                                 }
                                                           } 
                                                       }
                                                       
                                                       // added by dhiman start end
                                                  
                                                       poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                                                }
                                                      
                                                //***************** Check response ends      
                                             }
                                  }); 
               }        
function deleteskillstruct(delobjctdta)
         {
          if (!confirm('Are you sure?')) return false;
                         var sk_parent_data=$(delobjctdta).data("skillparent");
                         var sk_sub_data=$(delobjctdta).data("skillsub");
                         
                         
                         var skill_sub_id=sk_sub_data;
                         var callingurlfunc="deletemyskill";
                                 
                         var callingurl=base_url_data+"/deletegroupskill";
                         var callurlwithdata={_token:csrf_token_data,'skill_sub_id':skill_sub_id};
                         var cmsgdata='Genre deleted successfully';
            
                            $.ajax({
                                url:callingurl,
                                type:'POST',
                                dataType:'json',
                                data:callurlwithdata,
                                success:function(d){
                                                toastr.remove();// Immediately remove current toasts without using animation
                                                
                                                //***************** Check response starts
                                                
                                                if (d.flag_id==0 && d.error_message!='')
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
                                                                
                                                                poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');               
                                                }else if (d.flag_id == 3 && d.error_message!='') {
                                                
                                                                poptriggerfunc(msgtype='error',titledata='',msgdata=d.error_message,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');
                                                
                                                }
                                                else
                                                {
                                                  
                                                                
                                                       var currentskillcount=$(delobjctdta).parent(".mysubcustcls").parent(".skillparentclss").find('.mysubcustcls').length;
                                                       
                                                       //**** count skill , if 0 then delete parent shill structure starts
                                                       
                                                       
                                                       //console.log("currentskillcount=>"+currentskillcount);
                                                       if ((currentskillcount-1)==0)
                                                       {
                                                             $(delobjctdta).parent(".mysubcustcls").parent(".skillparentclss").remove();
                                                       
                                                       //*****remove that element from the parentskilladdedar array so that they can be added later on starts 
                                                       
                                                       if (parentskilladdedar.length>0)
                                                       {
                                                       
                                                            var check_skillpar_preent= $.inArray( sk_parent_data, parentskilladdedar );
                                                            if (check_skillpar_preent!=-1)
                                                            {
                                                                  parentskilladdedar.splice(check_skillpar_preent,1);
                                                            }
                                                       }
                                                       //*****remove that element from the parentskilladdedar array so that they can be added later on ends 
                                                       }
                                                       else
                                                       {
                                                                
                                                                
                                                                 //*** now here in del starts
                                                             var prevdataobj=$(delobjctdta).parent(".mysubcustcls").prev();// find previous struct
                                                             
                                                             var nextdataobj=$(delobjctdta).parent(".mysubcustcls").next().html();// find previous struct
                                                            
                                                            if (nextdataobj==null)
                                                            {
                                                               var modifiedprevstruct=$(prevdataobj).html().replace(/\,/gi, ".");
                                                             
                                                                $(prevdataobj).html(modifiedprevstruct);
                                                             
                                                                 $(prevdataobj).find(".delsubskillclass").click(function(){                                  
                                                  
                                                                                 deleteskillstruct(this);                                                 
                                   
                                                                 });
                                                            }
                                                             
                                                             
                                                             //*** now here in del ends   
                                                             $(delobjctdta).parent(".mysubcustcls").remove();
                                                       }
                                                       //**** count skill , if 0 then delete parent shill structure ends   
                                                                
                                                  
                                                  
                                                  
                                                       poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                                                }
                                                      
                                                //***************** Check response ends      
                                }
                }); 
                                 
                                
          }
            
    function callsaveuserurls(controlname,controlnamedata,callingurlfunc,myurldefdata)
    {
                   
                    
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,controlname:controlname,controlnamedata:controlnamedata};
                      
            var defurl_prsnt_cnt = (controlnamedata.match(new RegExp(myurldefdata, "g")) || []).length;
            
            //console.log(" inside ajax func controlnamedata="+controlnamedata);
            //console.log(" inside ajax func myurldefdata="+myurldefdata);            
            //console.log("inside ajax func defurl_prsnt_cnt==>"+defurl_prsnt_cnt);
            
            
            if (defurl_prsnt_cnt==0 || defurl_prsnt_cnt > 1 || controlnamedata=='' )
            {
                    var error_message_data="This URL can not be accepted";//"Invalid url";
                    poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width'); 
                    return false;
            }
            
            
            
            
            var cmsgdata='';
               if (controlname=="facebook_url")
               {
                    cmsgdata="Facebook url saved sucessfully";
               
               }
               else if (controlname=="soundcloud_url")
               {
                    cmsgdata="Soundcloud url saved sucessfully";
               
               }
               else if (controlname=="residentadvisor_url")
               {
               
                     cmsgdata="Mixcloud url saved sucessfully";
               }
               else if (controlname=="twitter_url")
               {
               
                    cmsgdata="Twitter_url  saved sucessfully";
               }
               else if (controlname=="youtube_url")
               {
                    cmsgdata="Youtube  saved sucessfully";
               
               }
               else if (controlname=="instagram_url")
               {
               
                    cmsgdata="Instagram  saved sucessfully";
               }
            
                           
             $.ajax({
               
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                    
                         toastr.remove();// Immediately remove current toasts without using animation
                         
                         //***************** Check response starts
                         if (d.flag_id==0 && d.error_message!='')
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
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');         
                                
                               }
                               else
                               {
                                      poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                               }
                               
                         //***************** Check response ends      
                
               }
               
               });
          
       
          
    }
    
    function callsaveuserdesc(controlname,controlnamedata,callingurlfunc)
    {
                   
                    
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,'user_description':controlnamedata};
            
            var cmsgdata='';
            if (controlname=="user_description")
               {
                    cmsgdata="Description saved sucessfully";
               
               }
              
            
                           
             $.ajax({
               
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                    
                         toastr.remove();// Immediately remove current toasts without using animation
                         
                         //***************** Check response starts
                         if (d.flag_id==0 && d.error_message!='')
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
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');         
                                
                               }
                               else
                               {
                                      poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                               }
                               
                         //***************** Check response ends      
                
               }
               
               });
          
       
          
    }
    
			
		 function callsaveusername(controlname,controlnamedata,callingurlfunc)
    {
                   
                    
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,'seo_name':controlnamedata};
            
            var cmsgdata='';
               if (controlname=="nickname")
               {
                    cmsgdata="Name saved sucessfully";
               
               }
              
            
                           
             $.ajax({
               
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                //alert("savegroupname");
                    
                         toastr.remove();// Immediately remove current toasts without using animation
                         
                         //***************** Check response starts
                         if (d.flag_id==0 && d.error_message!='')
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
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');         
                                
                               }
                               // else if (d.redirectflag == 1) {
                               //  //alert(d.nicknmdata);
                               //  window.location.href = base_url_data+'/'+'group/'+d.nicknmdata;
                               // }
                               else
                               {
                                     var successmsg = d.successmsgdata;
                                      // if (d.groucretaeOredit == 1) {
                                      //    window.location.href = base_url_data+'/'+'group/'+d.nicknmdata;
                                      //   //window.location.href = "profile.php";  // replace
                                      // }
                                      poptriggerfunc(msgtype='success',titledata='',msgdata="Name saved successfully",sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                               }
                               
                         //***************** Check response ends      
                
               }
               
               });
          
       
          
    }
   
    function callsaveskilldata(catag_type_id,skill_id,skill_sub_id,callingurlfunc)
    {
                   
                    
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,'catag_type_id':catag_type_id,'skill_id':skill_id,'skill_sub_id':skill_sub_id};
            
            var cmsgdata='Genre saved successfully';
               
                      
                           
             $.ajax({
               
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                    
                         toastr.remove();// Immediately remove current toasts without using animation
                         
                         
                         //***************** Check response starts
                         if (d.flag_id==0 && d.error_message!='')
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
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');         
                                
                               }
                               else
                               {
                                      poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                               }
                               
                         //***************** Check response ends      
                
               }
               
               });
          
       
          
    }
    
    function  calldeletemyskill(skill_sub_id,callingurlfunc)
    {
                   
                    
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,'skill_sub_id':skill_sub_id};
            
            var cmsgdata='Genre deleted successfully';
               
                      
                           
             $.ajax({
               
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                    
                         toastr.remove();// Immediately remove current toasts without using animation
                         
                         
                         //***************** Check response starts
                         if (d.flag_id==0 && d.error_message!='')
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
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');         
                                
                               }else if (d.flag_id == 3 && d.error_message!='') {
                                 
                                 poptriggerfunc(msgtype='error',titledata='',msgdata=d.error_message,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');
                                 
                                 }
                               else
                               {
                                      poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                               }
                               
                         //***************** Check response ends      
                
               }
               
               });
          
       
          
    }
    function populatessubkill(skill_parent_data,catag_type,typeofcall)
    {
          
                   if (skill_parent_data!='' && skill_parent_data!=null)
                   {
                              //console.log("inside populatessubkill 1 ...");
                              //**** call ajax to populate date to skill_sub starts
                              
                              var callingurl=base_url_data+"/"+"populategroupsubskill"; // populatesubskill
                              var callurlwithdata={_token:csrf_token_data,parent_id:skill_parent_data,catag_type:catag_type};
                              
                              $.ajax({
                                   url:callingurl,
                                   data:callurlwithdata,
                                   type:'POST',
                                   dataType:'JSON',
                                   success:function(d){
                                        
                                        //console.log(JSON.stringify(d));
                                        
                                        var subskillopt="";
                                        
                                        if (d!=null)
                                        {
                                            $.each(d, function(idx, obj)
                                                   {
                                                 
                                                  subskillopt+="<option value='"+obj.id+"'>"+obj.name+"</option>";
                                                  
                                                  });
                                            
                                            
                                        }                                        
                                        
                                        $("#skill_sub").html(subskillopt);
                                        $("#skill_sub").selectpicker('refresh');
                                          
                                        
                                       // console.log(skill_parent_data+"refreshed sub ");
                                        if (typeofcall=='skilldelete')
                                        {
                                             //code
                                        }
                                        else if(typeofcall=='skilladd')
                                        {
                                             
                                        }
                                        
                                        
                                        
                                        
                                   }
                                   
                                   });
                              
                              //**** call ajax to populate date to skill_sub ends
                              
                   }
                   else
                   {
                                        //console.log("inside populatessubkill 2 ...");
                                  
                                        $("#skill_sub").html("");
                                        $("#skill_sub").selectpicker('refresh');
                                          //console.log(skill_parent_data+"===refreshed sub ");
                   }
    }
    
	function calluserimagedelete(imagenamedata,firstimageflagdata,imageiddata,callingurlfunc)
    {
             
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,'imagename':imagenamedata,'firstimageflag':firstimageflagdata,'imageid':imageiddata};
            
            var cmsgdata="Image deleted successfully";         
              
                    
             $.ajax({
               
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                    
                         toastr.remove();// Immediately remove current toasts without using animation
                         
                         //***************** Check response starts
                         if (d.flag_status==0 && d.error_message!='')
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
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');         
                                
                               }
                               else
                               {
                                   var slider_contents=d.slider_contents;
                                      //poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                               
                                    $("#profsldroutrdivid").html(slider_contents);
                                    
                                    bindimagedelclick();
              
            
                                        //*** slider now starts         
                            
                                         //get carousel instance data and store it in variable owl
                                           var owl = $(".profile_slider").data('owlCarousel');     
                                           
                                           owl.destroy();
                                           
                                           var newOptions={
                                           loop:false,
                                           margin:0,
                                           items:1,
                                           nav:true,
                                           dots:false,
                                           };
                                           
                                           $('.profile_slider').owlCarousel(newOptions);  
                                           
                                           
                                        //*** slider now ends
                                        
                                        //****** for binding with  user image slider on change of slider starts 
                                        var owl = $('.owl-carousel');
                                        
                                        owl.owlCarousel({callbacks: true});
                                        
                                        owl.on('changed.owl.carousel', function(event) {
                                        
                                        var totalItems = $('.item').length;
                                        //console.log("len=>"+totalItems);
                                        
                                        var currentitemnmbr=event.item.index;
                                        var curritemnum=currentitemnmbr+1; // current item number without starting  from 0 ,  if current index is o then , curr photo is 0+1=1 , if 1 then 1+1=2
                                        
                                        showhideprevnextimgslider(totalItems,curritemnum) ;                  
                                        
                                        });
                                        //****** for binding with  user image slider on change of slider ends
                                        
                                        var totalItems = $('.item').length; var curritemnum=1;
                                        showhideprevnextimgslider(totalItems,curritemnum);
                                        
                                        
                                         $(".userimgupldcls").click(function(){
                                         
                                         // console.log("file control");		
                                         $("#image_name").trigger("click");
                                         
                                         });
                                        
                                         $("#progress_div").fadeOut(2500);
                                        
                                        
                                         toastr.remove();// Immediately remove current toasts without using animation
                                        poptriggerfunc(msgtype='success',titledata='',msgdata="Image deleted successfully",sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                                    
                                        //var default_image_name=d.default_image_name;
                                        //
                                        // var imagepthnew=base_url_data+"/front/otherfiles/progimages/"+"noimagefound52X52.jpg";
                                        // 
                                        //if (default_image_name!='')
                                        //{
                                        //      imagepthnew=base_url_data+"/upload/groupimage/thumb-small/"+default_image_name;                                             
                                        //}
                                        //
                                        //
                                        ////** change image on header starts
                                        //
                                        //$("#myprodileimgicon").find("img").attr("src",imagepthnew);
                                        
                                        //** change image on header ends
                                        
                             
                               }
                               
                         //***************** Check response ends      
                
               }
               
               });
          
       
          
    }
    
           function bindimagedelclick()
                    {
                         //*** for image delete bind function starts
                    
                    $(".mycustdelimgcls").click(function(){
                         
                         var imagenamedata=$(this).data("imagename");
                         var firstimageflagdata=$(this).data("firstimageflag");
                         var imageiddata=$(this).data("imageid");
                         
                         var confmsg="";
                         if (firstimageflagdata==1)
                         {
                             confmsg=" This is default image .";
                         }
                         
                         confmsg+="Are you sure you want to delete ?";
                         
                         
                         var confrmdel=confirm(confmsg);
                         
                         
                         if (confrmdel)
                         {
                             calluserimagedelete(imagenamedata,firstimageflagdata,imageiddata,"groupimagedelete"); // userimagedelete
                         }
                         
                         
                         });
                    
                         //*** for image delete bind function starts
                    }
               
                    
             function showhideprevnextimgslider(totalItems,curritemnum)
             {
                     if (totalItems==1)
                  {
                         //*** hide both prev and next
                               jQuery('.owl-prev, .owl-next').hide();
                  }
                  else if (totalItems>1)
                  {
                         if(curritemnum ==1 )
                        {
                               //*** hide prev  and show next
                                   jQuery('.owl-prev').hide();
                                   jQuery('.owl-next').show();
                        }
                       else if(curritemnum < totalItems )
                        {
                               //*** show both prev and next
                               jQuery('.owl-prev, .owl-next').show();
                        }
                        else if (curritemnum == totalItems)
                        {
                           //*** hide  next and show prev
                           jQuery('.owl-next').hide();
                            jQuery('.owl-prev').show();
                        }
                  }
               
             }
             
function bookingoptionstosave()
{
                $.validator.addMethod("numericfield", function(value, element) 
               {
                                        var characterReg = /^([0-9]*){0,}(\.\d{1,2})?$/; ///^[1-9][0-9]+(\.\d{1,2})?$/ ;
                                        return characterReg.test(value);
               },"Please enter proper numeric value");
                $("#goup_bookingoption_frmid").validate({
                                
              /********* added date 22th november 2016 start ***********/ 
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
              /********* added date 22th november 2016 end ***********/
                                
                errorClass: "authError",
                errorElement: 'span',//'div',
                                //***********************VALIDATION RULES*****************STARTS****************
                                rules: {
                                                typeEvent: {
                                                                required: true,
                                                },
                                                bookingfrom: {
                                                                required: true,
                                                },
                                                hourly_rate: {
                                                                required: true,
                                                                numericfield: true,
                                                },
                                                security_deposit: {
                                                                required: true,
                                                                numericfield: true,
                                                },
                                                setuptime: {
                                                                required: true, 
                                                },
                                                packuptime: {
                                                                required: true,
                                                },
                                                //tech_spec: {
                                                //                required: true,
                                                //},
                                },
                                //*****************VALIDATION RULES*****************************ENDS***********
                                                  
                                //*****************VALIDATION ERROR MESSAGES *******************STARTS*********
                                messages: {    
                                                typeEvent: {
                                                                required: "Please select Available for",
                                                },
                                                bookingfrom: {
                                                                required: "Please select Bookings from",
                                                },
                                                hourly_rate: {
                                                                required: "Total payment can not be empty",
                                                },
                                                security_deposit: {
                                                                required: "Security deposit can not be empty",
                                                },
                                                setuptime: {
                                                                required: "Please select Set-up time",        
                                                },
                                                packuptime: {
                                                                required: "Please select Pack-up time",
                                                },
                                                //tech_spec: {
                                                //                required: "Tech-spec field can not be empty",
                                                //},
                                },
                                //*****************VALIDATION ERROR MESSAGES *******************ENDS*********
                });
                var chkbookingoptionvalidation =  $("#goup_bookingoption_frmid").valid();
                if(chkbookingoptionvalidation === true)
                {
                                var typeEvent=$('#typeEvent').val();
                                var bookingfrom=$('#bookingfrom').val();
                                var hourly_rate=$('#hourly_rate').val();
                                var security_deposit=$('#security_deposit').val();
                                var setuptime=$('#setuptime').val();
                                var packuptime=$('#packuptime').val();
                                var tech_spec=$('#tech_spec').val();
                                var callingurl=base_url_data+"/groupbookingoptionssaveajx";
                                var callurlwithdata={_token:csrf_token_data,'typeEvent':typeEvent,'bookingfrom':bookingfrom,'hourly_rate':hourly_rate,'security_deposit':security_deposit,'setuptime':setuptime,'packuptime':packuptime,'tech_spec':tech_spec};
                                var cmsgdata="Booking options are saved successfully";
                                //alert(typeEvent+" "+bookingfrom+" "+hourly_rate+" "+security_deposit+" "+setuptime+" "+bookingfrom+" "+packuptime+" "+tech_spec+" "+callingurl);
                                $.ajax({
                                                url:callingurl,
                                                type:'POST',
                                                dataType:'json',
                                                data:callurlwithdata,
                                                success:function(d){
                                                                //alert(d.message+" dzvdfv ");
                                                                toastr.remove();// Immediately remove current toasts without using animation
                                                                //***************** Check response starts
                                                                if (d.flag_id==0 && d.error_message!='')
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
                                                                                poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');          
                                                                }
                                                                else
                                                                {
                                                                             $('#myModal4').modal('toggle');
                                                                                poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-top-full-width');
                                                                }     
                                                                //***************** Check response ends         
                                                }                
                                });
                                                
                }
                else
                {
                                var error_message_data="Please complete your booking request! ";
                               // poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                }

}

//**** character limit checking for tech-spec field in booking options of edit-profile page starts
                
                CharacterCount = function(){
                                var myField = document.getElementById('tech_spec');
                                var myLabel = document.getElementById('fieldtocount');
                                var myErrLabel = document.getElementById('CharCountLabel1');
                                if(!myField || !myLabel){return false}; // catches errors
                                var MaxChars =  myField.maxLengh;
                                if(!MaxChars){MaxChars =  myField.getAttribute('maxlength') ; };    if(!MaxChars){return false};
                                var remainingChars =   MaxChars - myField.value.length
                                myErrLabel.innerHTML = remainingChars+" Characters Remaining of Maximum "+MaxChars
                }
 
                setInterval(function(){CharacterCount('tech_spec','CharCountLabel1')},0);
                
//**** character limit checking for tech-spec field in booking options of edit-profile page ends
               
//****** calling ajax to save Booking Options data into db ends
    		
			 $(document).ready(function(){
                
                
                //***************added in 15 sep 16 start ****************//
                //*** code to block removing static urls starts
                 $(".urlcommncustcls").keydown(function(e) {
                                
                                var urlatrrid=$(this).attr("id");
                                
                                //alert(urlatrrid);
                                
                                var facebook_url_deflt="https://www.facebook.com/";
                                var soundcloud_url_deflt="https://www.soundcloud.com/";
                                //var residentadvisor_url_deflt="https://www.residentadvisor.net/";
                                var residentadvisor_url_deflt="https://www.mixcloud.com/";
                                var twitter_url_deflt="https://www.twitter.com/";
                                var youtube_url_deflt="https://www.youtube.com/";
                                var instagram_url_deflt="https://www.instagram.com/";
                                
                                var checkdata='';
                                
                                 if (urlatrrid=="facebook_url")
                                  {
                                     
                                       checkdata=facebook_url_deflt;
                                  }
                                  else if (urlatrrid=="soundcloud_url")
                                  {
                                      checkdata=soundcloud_url_deflt;
                                       
                                  }
                                  else if (urlatrrid=="residentadvisor_url")
                                  {
                                     checkdata=residentadvisor_url_deflt;
                                       
                                  }
                                   else if (urlatrrid=="twitter_url")
                                  {
                                     
                                       checkdata=twitter_url_deflt;
                                  }
                                  else if (urlatrrid=="youtube_url")
                                  {
                                      checkdata=youtube_url_deflt;
                                       
                                  }
                                  else if (urlatrrid=="instagram_url")
                                  {
                                      
                                       checkdata=instagram_url_deflt;
                                  }
                                
                                var oldvalue=$(this).val();
                                var field=this;
                                setTimeout(function () {
                                if(field.value.indexOf(checkdata) !== 0) {
                                $(field).val(oldvalue);
                                }
                                }, 1);
                                
                                
                });
                 
                 //*** code to block removing static urls ends ****************//
                 //***************added in 15 sep 16 end****************//
                
                
			 
			  $( window ).resize(function() {
						 samesize()
							 });
							 
				$( window ).load(function() {
					  samesize()
			   });
             $('#group_booking_opt_but').click(function(){
               bookingoptionstosave();
             });
			   			 
			 
            	$('.descchngancclass').click(function(){
            		var initVal = $(this).parent('.esEditor').find('.outPut').text();
            		$(this).parent('.esEditor').find('.editInput').val(initVal).show().focus();
            		$(this).parent('.esEditor').addClass('editable');
                    
                    //console.log("opened description");
                    
            	});
                
               $('.namechnganchcls').click(function(){
            		var initVal = $(this).parent('.esEditor').find('.outPut').text();
                    var orignamedata=$('.editInputfirstname').val();
            		$(this).parent('.esEditor').find('.editInput').val(initVal).show().focus();
            		$(this).parent('.esEditor').addClass('editable');
                    
                   // console.log("name change");
                   

                   $('.editInputfirstname').keyup(function( event ) {
                    
                    
                         if ( (event.which) == 13  )
                         {
                               //console.log(nmchngflg);
                               
                               
                               var controlname=$(this).attr('name');
                               var controlnamedata=$(this).val();
                               var callingurlfunc="saveusername";
                               
                               $(this).trigger('blur');
                               
                               //callsaveusername(controlname,controlnamedata,callingurlfunc)
                         }
                   }
                         );
                   
               //****** bind first_name with blur starts
               
              
                    $(".editInputfirstname").one('blur', function () {
                    var currentVal = $(this).val();
                    $(this).parents('.esEditor').find('.outPut').text(currentVal);
                    $(this).parents('.esEditor').removeClass('editable');
                    $(this).parents('.esEditor').find('.editInput').hide();
                    
                     //**** find the first_name control id on blur starts
                                var control_id_data=$(this).attr('id');					
                                //console.log("==control_id_data==>"+control_id_data);					
                                if (typeof control_id_data != 'undefined')
                                {
                                    
                                    //if (control_id_data=="nickname")
                                    if (control_id_data=="seo_name")
                                    {
                                        var controlnamedata=$(this).val();
                                        //console.log("=facebook_url_data=>"+facebook_url_data);
                                           
                                           var controlname=$("#"+control_id_data).attr('name');
                                           //alert(controlnamedata+" -> "+callingurlfunc);
                                           
                                           callsaveusername(controlname,controlnamedata,'savegroupname');
                                       }
                                   }
              //**** find the first_name control id on blur ends  
                                        
                                        
                    
                    				});
                  
               //****** bind first_name with blur ends             
                    
            	});
                
                
            	$(".desccommncustcls").on('blur', function () {
            		var currentVal = $(this).val();
				    $(this).parents('.esEditor').find('.outPut').text(currentVal);
				    $(this).parents('.esEditor').removeClass('editable');
				    $(this).parents('.esEditor').find('.editInput').hide();
                    
                    
                    //console.log(currentVal+"===="+$(this).attr('id'));
                    
                    
                    //**** find the control id on blur starts
               					var control_id_data=$(this).attr('id');					
               					//console.log("==control_id_data==>"+control_id_data);					
               					if (typeof control_id_data != 'undefined')
               					{
               						
               						if (control_id_data=="user_description")
               						{
               							var controlnamedata=$(this).val();
               							//console.log("=facebook_url_data=>"+facebook_url_data);
                                           
                                           var controlname=$("#"+control_id_data).attr('name');               							
                                           callsaveuserdesc(controlname,controlnamedata,'savegroupdesc');
                                       }
                                   }
                    //**** find the control id on blur ends               
                    
                    
				});
				
				
                 //*****  url click code starts
               
               $('.outPut').click(function(){
            		var initVal = $(this).parent('.link_edit').find('.outPut').text();
                    
                    var myurldata=$(this).parent('.link_edit').find('.outPut').data("myurldata");
                    var myurldefdata=$(this).parent('.link_edit').find('.outPut').data(myurldata); // get myurldefdata 
                    //console.log("==myurldefdata==>"+myurldefdata);
            		
                    $(this).parent('.link_edit').find('.editInput').val(initVal).show().focus();
            		$(this).parent('.link_edit').addClass('editable');
                    //
                    //console.log(initVal);
                    //
                    //console.log("no way ...");
                    
                    //**** here enter key code starts
                    var control_id_data=$(this).parent('.link_edit').find('input').attr('id');
                    
                    //console.log("==control_id_data==>"+control_id_data);
                    $( "#"+control_id_data ).bind('keyup',function( event ) {
                         
                         //console.log("=control_id_data==>"+control_id_data+"--event.which-->"+event.which);
                         
                         if ( event.which == 13 )
                         {
                             
                              //**** find the control id on blur starts
                              				
                              //console.log("==control_id_data==>"+control_id_data);					
                              if (typeof control_id_data != 'undefined')
                              {
                                  
                                  if (control_id_data=="facebook_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      //console.log("=facebook_url_data=>"+facebook_url_data);
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                      //callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                      
                                       $( "#"+control_id_data ).trigger('blur');
                                      
                                       
                                  }
                                  else if (control_id_data=="soundcloud_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                     // callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                      $( "#"+control_id_data ).trigger('blur');
                                       
                                  }
                                  else if (control_id_data=="residentadvisor_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                     // callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                      $( "#"+control_id_data ).trigger('blur');
                                       
                                  }
                                   else if (control_id_data=="twitter_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                    //  callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                     $( "#"+control_id_data ).trigger('blur');
                                       
                                  }
                                  else if (control_id_data=="youtube_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                     // callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                      $( "#"+control_id_data ).trigger('blur');
                                       
                                  }
                                  else if (control_id_data=="instagram_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                     //  callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                     
                                      $( "#"+control_id_data ).trigger('blur');
                                       
                                  }
                                  
                              
                                  
                              }					
                              //**** find the control id on blur ends
                              
                              
                               $(this).parent('.link_edit').removeClass('editable');
                               $(this).parent('.link_edit').find('.editInput').hide();
                              
                              
                         }
                         
                         
                         });
                    
                   
               
              
               
                    
               //*****  url blur code starts     
                    
            	$( "#"+control_id_data ).one('blur', function () {
            		var currentVal = $(this).val(); //console.log("==currentVal==>"+currentVal);
				    $(this).parents('.link_edit').find('.outPut').text(currentVal);
				    $(this).parents('.link_edit').removeClass('editable');
				    $(this).parents('.link_edit').find('.editInput').hide();
					
					//**** find the control id on blur starts
					var control_id_data=$(this).parent('.link_edit').find('input').attr('id');				
					if (typeof control_id_data != 'undefined')
					{
                         
						
						if (control_id_data=="facebook_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							//console.log("=facebook_url_data=>"+facebook_url_data);
                            
                              var controlname=$("#"+control_id_data).attr('name');
                            
                              var myurldata=$(this).parent('.link_edit').find('.outPut').data("myurldata");
                              var myurldefdata=$(this).parent('.link_edit').find('.outPut').data(myurldata); // get myurldefdata 
                              
							
                              callsaveuserurls(controlname,controlnamedata,'savegroupurls',myurldefdata);                            
							 
						}
                        else if (control_id_data=="soundcloud_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							
                            
                            var controlname=$("#"+control_id_data).attr('name');
                            
                            var myurldata=$(this).parent('.link_edit').find('.outPut').data("myurldata");
                            var myurldefdata=$(this).parent('.link_edit').find('.outPut').data(myurldata); // get myurldefdata
							
                            callsaveuserurls(controlname,controlnamedata,'savegroupurls',myurldefdata);                            
							 
						}
                        else if (control_id_data=="residentadvisor_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							
                            
                            var controlname=$("#"+control_id_data).attr('name');
                            
                            var myurldata=$(this).parent('.link_edit').find('.outPut').data("myurldata");
                            var myurldefdata=$(this).parent('.link_edit').find('.outPut').data(myurldata); // get myurldefdata
							
                            callsaveuserurls(controlname,controlnamedata,'savegroupurls',myurldefdata);                            
							 
						}
                         else if (control_id_data=="twitter_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							
                            
                            var controlname=$("#"+control_id_data).attr('name');
                            
                            var myurldata=$(this).parent('.link_edit').find('.outPut').data("myurldata");
                            var myurldefdata=$(this).parent('.link_edit').find('.outPut').data(myurldata); // get myurldefdata
							
                            callsaveuserurls(controlname,controlnamedata,'savegroupurls',myurldefdata);                            
							 
						}
                        else if (control_id_data=="youtube_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							
                            
                            var controlname=$("#"+control_id_data).attr('name');
                            
                            var myurldata=$(this).parent('.link_edit').find('.outPut').data("myurldata");
                            var myurldefdata=$(this).parent('.link_edit').find('.outPut').data(myurldata); // get myurldefdata
							
                            callsaveuserurls(controlname,controlnamedata,'savegroupurls',myurldefdata);                            
							 
						}
                        else if (control_id_data=="instagram_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							
                            
                            var controlname=$("#"+control_id_data).attr('name');
                            
                            var myurldata=$(this).parent('.link_edit').find('.outPut').data("myurldata");
                            var myurldefdata=$(this).parent('.link_edit').find('.outPut').data(myurldata); // get myurldefdata
							
                            callsaveuserurls(controlname,controlnamedata,'savegroupurls',myurldefdata);                            
							 
						}
                        
                        
                        
                        
					}					
					//**** find the control id on blur ends

				});
                    
                //*****  url blur code starts   
                    
                    
                    
                    
            	});
               
               //*****  url click code ends
               
               
               
               	//***** rider data respective code block starts
				$('.ridercustcls').click(function(){
                                var initVal = $(this).find('.outPut').text();
                                $(this).find('.editInput').val(initVal).show().focus();
                                $(this).addClass('editable');
                                
                                $( "#ridercust" ).one('blur', function () {
                                                callsaveridercustfunc();             
                                });
                                
                                $( "#ridercust" ).bind('keyup',function( event ) {
                                                if ( event.which == 13 )
                                                {
                                                               $( "#ridercust" ).trigger('blur');            
                                                }
                                });
            	});
                //***** rider data respective code block ends
                
                //****** calling ajax to save rider data into db starts
                function callsaveridercustfunc() {
                                var riderdata=$('#ridercust').val();
                                                               
                                var callingurl=base_url_data+"/savegroupridercust"; //saveridercust
                                var callurlwithdata={_token:csrf_token_data,'riderdata':riderdata};
                                var cmsgdata="Rider is saved successfully";         
                                $.ajax({
                                                url:callingurl,
                                                type:'POST',
                                                dataType:'json',
                                                data:callurlwithdata,
                                                success:function(d){
                                                                toastr.remove();// Immediately remove current toasts without using animation
                                                                //***************** Check response starts
                                                                if (d.flag_id==0 && d.error_message!='')
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
                                                                                poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');          
                                                                }
                                                                else
                                                                {
                                                                                poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-top-full-width');
                                                                }     
                                                                //***************** Check response ends         
                                                }
                                });
                               
                }
                //****** calling ajax to save rider data into db ends
                
     
                //***** ABN data respective code block starts
	$('.abncustcls').click(function(){
                                var initVal = $(this).find('.outPut').text();
                                $(this).find('.editInput').val(initVal).show().focus();
                                $(this).addClass('editable');
                                
                                $( "#abncust" ).on('blur', function () {
                                              var currentVal = $(this).val();
		              $(this).parents('.btn_row').find('.outPut').text(currentVal);
		              $(this).parents('.btn_row').removeClass('editable');
                                              $(this).parents('.btn_row').find('.editInput').hide();
                                                callsaveabncustfunc();             
                                });
                                
                                $( "#abncust" ).bind('keyup',function( event ) {
                                                if ( event.which == 13 )
                                                {
                                                               $( "#abncust" ).trigger('blur');            
                                                }
                                });
            	});
                //***** ABN data respective code block ends
				
                //****** calling ajax to save ABN data into db starts
                
                function callsaveabncustfunc() {
                                var abndata=$('#abncust').val();
                                var callingurl=base_url_data+"/saveabncustgroup"; // saveabncust
                                var callurlwithdata={_token:csrf_token_data,'abndata':abndata};
                                var cmsgdata="ABN is saved successfully";         
                                $.ajax({
                                                url:callingurl,
                                                type:'POST',
                                                dataType:'json',
                                                data:callurlwithdata,
                                                success:function(d){
                                                                toastr.remove();// Immediately remove current toasts without using animation
                                                                //***************** Check response starts
                                                                if (d.flag_id==0 && d.error_message!='')
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
                                                                                poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');          
                                                                }
                                                                else
                                                                {
                                                                                poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1500,poscls='toast-top-full-width');
                                                                }     
                                                                //***************** Check response ends         
                                                }
                                });
                }
                
                //****** calling ajax to save ABN data into db ends
                
     //****** calling ajax to save GST data into db starts
                
                function callsavegstcustfunc() {
                                var gstdata=$('#gstcust').val();
                                var callingurl=base_url_data+"/savegstcustgroup"; //savegstcust
                                var callurlwithdata={_token:csrf_token_data,'gstdata':gstdata};
                                var cmsgdata="GST status and TFN are saved successfully";         
                                $.ajax({
                                                url:callingurl,
                                                type:'POST',
                                                dataType:'json',
                                                data:callurlwithdata,
                                                success:function(d){
                                                                toastr.remove();// Immediately remove current toasts without using animation
                                                                //***************** Check response starts
                                                                if (d.flag_id==0 && d.error_message!='')
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
                                                                                poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');          
                                                                }
                                                                else
                                                                {
                                                                                poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1500,poscls='toast-top-full-width');
                                                                }     
                                                                //***************** Check response ends         
                                                }
                                });
                }
                //****** calling ajax to save GST data into db ends             
            
 
                //***** GST data respective code block starts
                
	$('.gstcustcls').click(function(){
                                $(this).parent().toggleClass('showPop');
                                var radioValue = $('input[name=gst]:checked').val();
                           if(radioValue==1){
                               // alert(radioValue);
                                var initVal = $(this).find('.outPut').text();
                                $(this).find('.editInput').val(initVal).show().focus();
                                $(this).addClass('editable');
                                
                                $( "#gstcust" ).on('blur', function () {
                                              var currentVal = $(this).val();
		              $(this).parents('.btn_row').find('.outPut').text(currentVal);
		              $(this).parents('.btn_row').removeClass('editable');
                                              $(this).parents('.btn_row').find('.editInput').hide();
                                              callsavegstcustfunc();             
                                });
                                
                                $( "#gstcust" ).bind('keyup',function( event ) {
                                                if ( event.which == 13 )
                                                {
                                                  $( "#gstcust" ).trigger('blur');            
                                                }
                                });
                            }
                           
            	});
                                                                                                       
                                                                
                //***** GST data respective code block ends

                      //****** calling ajax to save Page-meta-tag data into db starts
                // function callsavepagemetatagcustfunc() {
                //                 var pagemetatagdata=$('#pagemetatagcust').val();
                //                 var callingurl=base_url_data+"/savepagemetatagcustgroup"; //savepagemetatagcust
                //                 var callurlwithdata={_token:csrf_token_data,'pagemetatagdata':pagemetatagdata};
                //                 var cmsgdata="Page meta tag is saved successfully";         
                //                 $.ajax({
                //                                 url:callingurl,
                //                                 type:'POST',
                //                                 dataType:'json',
                //                                 data:callurlwithdata,
                //                                 success:function(d){
                                                                
                                                                
                //                                                 toastr.remove();// Immediately remove current toasts without using animation
                //                                                 //***************** Check response starts
                //                                                 if (d.flag_id==0 && d.error_message!='')
                //                                                 {
                //                                                                 var error_message=d.error_message;
                //                                                                 var error_message_data='';
                //                                                                 if (error_message!=null)
                //                                                                 {
                //                                                                                 for (ermsgkey in error_message)
                //                                                                                 {
                //                                                                                                 error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                //                                                                                 }
                //                                                                 }
                //                                                                 poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');          
                //                                                 }
                //                                                 else
                //                                                 {
                //                                                                 poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-top-full-width');
                //                                                 }     
                //                                                 //***************** Check response ends         
                //                                 }
                //                 });
                // }
                //****** calling ajax to save Page-meta-tag data into db ends 
               
               
               
               
               
               
                //***** Page-meta-tag data respective code block starts
	// $('.pagemetatagcustcls').click(function(){
 //                                var initVal = $(this).find('.outPut').text();
 //                                $(this).find('.editInput').val(initVal).show().focus();
 //                                $(this).addClass('editable');
                                
 //                                $( "#pagemetatagcust" ).one('blur', function () {
 //                                              var currentVal = $(this).val();
	// 	              $(this).parents('.btn_row').find('.outPut').text(currentVal);
	// 	              $(this).parents('.btn_row').removeClass('editable');
 //                                              $(this).parents('.btn_row').find('.editInput').hide();
 //                                              callsavepagemetatagcustfunc();             
 //                                });
                                
 //                                $( "#pagemetatagcust" ).bind('keyup',function( event ) {
 //                                                if ( event.which == 13 )
 //                                                {
 //                                                               $( "#pagemetatagcust" ).trigger('blur');            
 //                                                }
 //                                });
 //            	});
                //***** Page-meta-tag data respective code block ends
                
         
				
				//$('.btn_row').click(function(){
            		//var initVal = $(this).find('.outPut').text();
            		//$(this).find('.editInput').val(initVal).show().focus();
            		//$(this).addClass('editable');
            	//});
				
   
				
				$('[data-toggle="tooltip"]').tooltip();
                
               
               //*** for skill add starts 
              
               
                $('#skill_parent').on('change',function(evnt){
                    
                   // alert($(this).val());
                    
                    var  skill_parent_data=$(this).val();
                    
                    var typeofcall="skilladd"; var catag_type=2;              
                   
                    
                   if (skill_parent_data!='' && skill_parent_data!=null)
                   {
                              //**** call ajax to populate date to skill_sub starts
                              
                              var callingurl=base_url_data+"/"+"populategroupsubskill"; // populatesubskill
                              var callurlwithdata={_token:csrf_token_data,parent_id:skill_parent_data,catag_type:catag_type};
                              
                              $.ajax({
                                   url:callingurl,
                                   data:callurlwithdata,
                                   type:'POST',
                                   dataType:'JSON',
                                   success:function(d){
                                        
                                        //console.log(JSON.stringify(d));
                                        
                                        var subskillopt="";
                                        
                                        if (d!=null)
                                        {
                                            $.each(d, function(idx, obj)
                                                   {
                                                 
                                                  subskillopt+="<option value='"+obj.id+"'>"+obj.name+"</option>";
                                                  
                                                  });
                                            
                                            
                                        }                                        
                                        
                                        $("#skill_sub").html(subskillopt);
                                        $("#skill_sub").selectpicker('refresh');                                        
                                        
                                   }
                                   
                                   });
                              
                              //**** call ajax to populate date to skill_sub ends
                              
                   }
                   else
                   {
                                        $("#skill_sub").html("");
                                        $("#skill_sub").selectpicker('refresh');
                   }
                    
                    
                    });
               
               //*** for skill add ends
               
               
               
               //*** for skill sub add starts 
              
               //var parentskilladdedar=[];
                $('#skill_sub').on('change',function(evnt){
                    
                   //// alert($(this).val());
                   // 
                   // var skill_parent_data=parseInt($("#skill_parent").find(":selected").val());
                   // var skill_parent_txtdata=$("#skill_parent").find(":selected").text();
                   // var  skill_sub_data=parseInt($(this).val());
                   // var  skill_sub_txtdata=$(this).find(":selected").text();
                   //
                   // 
                   // var totcnt=$("#skillidouterdiv").find('.skillparentclss').length;
                   //
                   //
                   // if (totcnt>0)
                   // {
                   //      
                   //     $("#skillidouterdiv").find('.skillparentclss').each(function(){
                   //      
                   //       var skillparclss_data=parseInt($(this).data("skillparent"));
                   //                                
                   //       var check_skillparclss_data= $.inArray( skillparclss_data, parentskilladdedar );
                   //        
                   //
                   //           if (check_skillparclss_data==-1)
                   //           {
                   //               parentskilladdedar.push(skillparclss_data);
                   //           }
                   //            
                   //      
                   //      }); 
                   //      
                   //
                   //           var check_parispresent= $.inArray( skill_parent_data, parentskilladdedar );
                   //
                   //           if (check_parispresent!=-1)
                   //           {
                   //                //***** create small  structure  starts
                   //                
                   //                console.log(" 22 parent skill div exists add new sub skill");
                   //                
                   //                var prntsklobj=$("#skillidouterdiv").find(".skillparentclss[data-skillparent='" + skill_parent_data + "']"); // get the parent skill div obj
                   //              
                   //                
                   //                          //** check whether sub skill present in the structure or not starts
                   //                          
                   //                         var suskillobjchk=prntsklobj.find(".mysubcustcls[data-skillsub='" + skill_sub_data + "']");
                   //                       
                   //                          //alert("22 check =suskillobjchk=>"+suskillobjchk);
                   //                          //** check whether sub skill present in the structure or not ends 
                   //                          
                   //                               if (suskillobjchk.data("skillsub")==null)
                   //                               {
                   //                                    var prevklmstrdivstruc=prntsklobj.html();
                   //                                    
                   //                                    prevklmstrdivstruc=prevklmstrdivstruc.replace(/\./gi, ",");
                   //                                    
                   //                                    
                   //                                    var newsklmstrdivstruc="<div class='gener mysubcustcls' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"'  >"+skill_sub_txtdata+".<span class='delsubskillclass' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"' >&times;</span></div>";
                   //
                   //                                    
                   //                                    prntsklobj.html(prevklmstrdivstruc+newsklmstrdivstruc);
                   //                                    callsaveskilldata(2,skill_parent_data,skill_sub_data,"savegroupskilldata"); // saveskilldata
                   //                               }
                   //                               else
                   //                               {
                   //                                    //alert("already sub struct present");
                   //                                    toastr.remove();// Immediately remove current toasts without using animation
                   //                                    poptriggerfunc(msgtype='error',titledata='',msgdata="This genre already exist",sd=1000,hd=1500,tmo=10000,etmo=2000,poscls='toast-top-full-width');
                   //      
                   //                               }
                   //                
                   //               
                   //               //***** create small  structure  ends
                   //               
                   //                //**** bind delete to skill starts
                   //           
                   //                $(".delsubskillclass").click(function(){
                   //                             deleteskillstruct(this);
                   //                              
                   //                               
                   //                });
                   //                
                   //                //**** bind delete to skill ends
                   //           }
                   //           else
                   //           {
                   //                 console.log(" 333 create new whole structure parent skill div struct ");
                   //                //***** create new whole structure  starts
                   //                
                   //                           // alert("parent skill not present add new whole");
                   //                     var prevklmstrdivstruc=$("#skillidouterdiv").html();
                   //                     var newsklmstrdivstruc="<div class='name_holder skillparentclss'  data-skillparent='"+skill_parent_data+"' ><div class='mainCategory skillparentname'>"+skill_parent_txtdata+":</div><div class='gener mysubcustcls' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"' >"+skill_sub_txtdata+".<span class='delsubskillclass' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"'>&times;</span></div></div>";
                   //                     $("#skillidouterdiv").html(prevklmstrdivstruc+newsklmstrdivstruc);
                   //               
                   //                      callsaveskilldata(2,skill_parent_data,skill_sub_data,"savegroupskilldata"); // saveskilldata
                   //               
                   //                //***** create new whole structure  ends
                   //                 //**** bind delete to skill starts
                   //           
                   //                $(".delsubskillclass").click(function(){
                   //                deleteskillstruct(this);     
                   //
                   //                });
                   //                
                   //                //**** bind delete to skill ends
                   //           
                   //            }
                   // 
                   // 
                   // 
                   // 
                   // }
                   // else
                   // {
                   //      parentskilladdedar.push(skill_parent_data);
                   //      //console.log("=parentskilladdedar array contnt => "+parentskilladdedar.toString()+"--length of array=>"+parentskilladdedar.length)
                   //            //***** create structure  starts
                   //           
                   //          //alert("add new whole skill struct");
                   //          //console.log("11 not a singl struct present create 1st new struct");
                   //          var newsklmstrdivstruc="<div class='name_holder skillparentclss'  data-skillparent='"+skill_parent_data+"' ><div class='mainCategory skillparentname'   >"+skill_parent_txtdata+":</div><div class='gener mysubcustcls' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"' >"+skill_sub_txtdata+".<span class='delsubskillclass' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"'>&times;</span></div></div>";
                   //          $("#skillidouterdiv").html(newsklmstrdivstruc);
                   //                                      
                   //          callsaveskilldata(2,skill_parent_data,skill_sub_data,"savegroupskilldata"); // saveskilldata
                   //          
                   //           //***** create structure  ends
                   //           
                   //           //**** bind delete to skill starts
                   //           
                   //           $(".delsubskillclass").click(function(){
                   //                deleteskillstruct(this); 
                   //
                   //           });
                   //           
                   //           //**** bind delete to skill ends
                   //           
                   // }
                   //
                   // 
                   // 
                   //  // populatessubkill(skill_parent_data,1,'skilladd'); // refresh sub skill drop down 
                   //          
                    
                    });
               
               //*** for skill sub add ends
               
               
               //***** add data starts
               
                     var totcnt=$("#skillidouterdiv").find('.skillparentclss').length;
                   
                   
                    if (totcnt>0)
                    {
                         
                        $("#skillidouterdiv").find('.skillparentclss').each(function(){
                         
                          var skillparclss_data=parseInt($(this).data("skillparent"));
                                                   
                          var check_skillparclss_data= $.inArray( skillparclss_data, parentskilladdedar );
                           
                         // console.log("=check parent id "+skillparclss_data+" present or not =>"+check_skillparclss_data);
                           
                              if (check_skillparclss_data==-1)
                              {
                                  parentskilladdedar.push(skillparclss_data);

                              }
                               
                         
                         });
                    }
               
               
               //***** add data ends
               
                //**** bind delete to skill starts
                              
                              $(".delsubskillclass").click(function(){
                                   deleteskillstruct(this); 
                                  //  var sk_parent_data=$(this).data("skillparent");
                                  // var sk_sub_data=$(this).data("skillsub");
                                  //calldeletemyskill(sk_sub_data,"deletegroupskill"); //deletemyskill
                                  //
                                  //var currentskillcount=$(this).parent(".mysubcustcls").parent(".skillparentclss").find('.mysubcustcls').length;
                                  //
                                  ////**** count skill , if 0 then delete parent shill structure starts
                                  //
                                  // 
                                  // //console.log("currentskillcount=>"+currentskillcount);
                                  // if ((currentskillcount-1)==0)
                                  //                {
                                  //                     $(this).parent(".mysubcustcls").parent(".skillparentclss").remove();
                                  //                     
                                  //                     //*****remove that element from the parentskilladdedar array so that they can be added later on starts 
                                  //                     
                                  //                     if (parentskilladdedar.length>0)
                                  //                     {
                                  //                        
                                  //                          var check_skillpar_preent= $.inArray( sk_parent_data, parentskilladdedar );
                                  //                          if (check_skillpar_preent!=-1)
                                  //                          {
                                  //                               parentskilladdedar.splice(check_skillpar_preent,1);
                                  //                          }
                                  //                     }
                                  //                     //*****remove that element from the parentskilladdedar array so that they can be added later on ends 
                                  //                }
                                  //                else
                                  //                {
                                  //                     $(this).parent(".mysubcustcls").remove();
                                  //                }
                                  
                              });
                              
                    //**** bind delete to skill ends
                     //**** bind custplus starts
                     
                     $(".custplus").click(function(){
                         
                         //var slp= $("#skill_parent").selectpicker();
                          //slp.selectpicker('refresh');
                          addMyGenre();
                          $('#skill_parent').selectpicker('deselectAll');
                          
                          $("#skill_sub").html('');
                          $("#skill_sub").selectpicker('refresh');
                         
                         });
                     //**** bind custplus ends
               
               
                    //**** regarding image upload  starts*****           
		
                    $("#image_name").change(function(){
            
            
                             //  console.log($(this).val());
            
                               var filename = $('input[name="image_name"]').val();
                               //console.log(filename);
           
                              var inp = document.getElementById('image_name');
                              
                              var allowedfiletypeAr=[];
                              allowedfiletypeAr.push("jpg");
                              allowedfiletypeAr.push("jpeg");
                              allowedfiletypeAr.push("png");
                              
                              
                              var allowedfiletypeSizeAr=[];
                              allowedfiletypeSizeAr.push((1024*1024*5)); // in bytes
                              allowedfiletypeSizeAr.push((1024*1024*5)); // in bytes
                              allowedfiletypeSizeAr.push((1024*1024*5)); // in bytes
			
			
                         var errorar=[]; var errorstr=''; var filepassedAr=[];
            
                         for (var i = 0; i < inp.files.length; ++i)
                         {
                          
                             var namedata = inp.files.item(i).name;
                             var flsize=inp.files.item(i).size;
                             
                             var namedataAr=namedata.split(".");
                             var fileext='';
                             if (namedataAr.length>0)
                             {
                                 var fileext=namedataAr.pop();
                                 
                                 if (fileext!='')
                                 {
                                     var chkvalidfiletype= allowedfiletypeAr.indexOf(fileext.toLowerCase());
                                     
                                     if (chkvalidfiletype==-1)
                                     {
                                             // file type error
                                             
                                              errorstr+=' <p> "'+namedata+'" - invalid file type </p>';
                                         
                                     }
                                     else
                                     {
                                       var allowedfilesize=allowedfiletypeSizeAr[chkvalidfiletype];
                                         
                                         var chkfilesize= (flsize<=allowedfilesize)?true:false;
                                         
                                             if (chkfilesize==false)
                                             {
                                                 //file size error
                                                 errorstr+=' <p> "'+namedata+'" exceeds allowed file size </p>';
                                             }
                                             else
                                             {
                                               filepassedAr.push(namedata);
                                             }
                                         
                                     }
                                   
                                   
                                   
                                 }
                                 else
                                 {
                                    //error without file extention
                                    
                                      errorstr+=' <p> "'+namedata+'" has no file extention  </p>';
                                 }
                                 
                             }
                             
                      
                             //console.log("here is a file name: " + name + "==size=>"+ inp.files.item(i).size );
                         }
			
                         if (errorstr!='' && filepassedAr.length > 0)
                         {
                             toastr.remove();// Immediately remove current toasts without using animation
                             poptriggerfunc(msgtype='error',titledata='',msgdata=errorstr,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width'); 
                           
                            $("#submitbutnid").trigger("click");
                         }
                         else if (errorstr!='' && filepassedAr.length==0)
                         {
                             //alert(errorstr);
                              toastr.remove();// Immediately remove current toasts without using animation
                             poptriggerfunc(msgtype='error',titledata='',msgdata=errorstr,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width'); 
                           
                         }
                         if (errorstr=='' && filepassedAr.length > 0)
                         {
                              
                           
                            $("#submitbutnid").trigger("click");
                         }
            
            
                     });
                    
                    //**** regarding image upload  ends******
                    
                    //*** bind click for image delete bind function starts
                    
                    bindimagedelclick();
                    
                    
                    
                   //*** bind click for image delete bind function starts
               
               $(".userimgupldcls").click(function(){
                                         
                                         // console.log("file control");		
                                         $("#image_name").trigger("click");
                                         
                                         });
                     
           //*********for checking if the review will be shown or not starts here


                var chkreviewIS_trueORnot = 1;
                $('input:radio[name="revShow"]').change(function(){
                    if ($(this).is(':checked') && $(this).val() == '1') 
                    {
                       chkreviewIS_trueORnot = 1;
                    }
                    else if (($(this).is(':checked') && $(this).val() == '0'))
                    {

                      chkreviewIS_trueORnot = 0;
                    }

                //***************** review change ajax start***************//
                var venueownid = $("#venuehiddenid").val();
                var review_url = "showreviewinprofile";
                var callingurl_review=base_url_data+"/"+review_url;
                var callurlwithdata={_token:csrf_token_data,'type_flag':2,'reviewyesorno':chkreviewIS_trueORnot,'venueID':groupID};
                
                $.ajax({
                url:callingurl_review,
                type:'POST',
                dataType:'json',
                data:callurlwithdata,
                success:function(d)
                {
                toastr.remove();// Immediately remove current toasts without using animation
                
                //***************** Check response starts
                
                if (d.update_flag==0)
                {
                               poptriggerfunc(msgtype='error',titledata='',msgdata="Something went wrong",sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');               
                }
                else
                {
                 if(d.flag_type == 1)
                 {
                      poptriggerfunc(msgtype='success',titledata='',msgdata="Review will be displayed in your profile",sd=2000,hd=2500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                       $("#showreviewnt").slideDown(); 
                  }else if(d.flag_type == 0)
                  {
                      poptriggerfunc(msgtype='success',titledata='',msgdata="Review will not be displayed in your profile",sd=2000,hd=2500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                       $("#showreviewnt").slideUp(); 
                  }  
                }
                     
                //***************** Check response ends      
                }
                }); 
                
                });
                //***************** review change ajax end ***************//
               //****** for binding with  user image slider on change of slider starts 
                    var owl = $('.owl-carousel');
               
                     owl.owlCarousel({callbacks: true});
                
                     owl.on('changed.owl.carousel', function(event) {
                  
                    var totalItems = $('.item').length;
                     //console.log("len=>"+totalItems);
                
                    var currentitemnmbr=event.item.index;
                    var curritemnum=currentitemnmbr+1; // current item number without starting  from 0 ,  if current index is o then , curr photo is 0+1=1 , if 1 then 1+1=2
                  
                     showhideprevnextimgslider(totalItems,curritemnum) ;                  
               
                     });
               //****** for binding with  user image slider on change of slider ends
               
               
                //****** for showing right icon in image slider on load  starts 
               var totalItems = $('.item').length; var curritemnum=1;
               showhideprevnextimgslider(totalItems,curritemnum);
               //****** for showing right icon in image slider on load ends
               
               $(".presskitupld").click(function(){
                   
                    $("#presskit_name").trigger("click");

               });
               
               //************* show demo review start ***********//
               
               
                //************* show demo review start ***********//
               
               //**** regarding presskit upload  starts*****
               
                    $("#presskit_name").change(function(){
            
            
                             //  console.log($(this).val());
            
                               var filename = $('input[name="presskit_name"]').val();
                               //console.log(filename);
           
                              var inp = document.getElementById('presskit_name');
                              
                              var allowedfiletypeAr=[];
                              allowedfiletypeAr.push("pdf");
                              
                              
                              
                              var allowedfiletypeSizeAr=[];
                              allowedfiletypeSizeAr.push((1024*1024*5)); // in bytes
                            
			
			
                         var errorar=[]; var errorstr=''; var filepassedAr=[];
            
                         for (var i = 0; i < inp.files.length; ++i)
                         {
                          
                             var namedata = inp.files.item(i).name;
                             var flsize=inp.files.item(i).size;
                             
                             var namedataAr=namedata.split(".");
                             var fileext='';
                             if (namedataAr.length>0)
                             {
                                 var fileext=namedataAr.pop();
                                 
                                 if (fileext!='')
                                 {
                                     var chkvalidfiletype= allowedfiletypeAr.indexOf(fileext.toLowerCase());
                                     
                                     if (chkvalidfiletype==-1)
                                     {
                                             // file type error
                                             
                                              errorstr+=' <p> "'+namedata+'" has invalid file type </p>';
                                         
                                     }
                                     else
                                     {
                                       var allowedfilesize=allowedfiletypeSizeAr[chkvalidfiletype];
                                         
                                         var chkfilesize= (flsize<=allowedfilesize)?true:false;
                                         
                                             if (chkfilesize==false)
                                             {
                                                 //file size error
                                                 errorstr+=' <p> "'+namedata+'" exceeds allowed file size </p>';
                                             }
                                             else
                                             {
                                               filepassedAr.push(namedata);
                                             }
                                         
                                     }
                                   
                                   
                                   
                                 }
                                 else
                                 {
                                    //error without file extention
                                    
                                      errorstr+=' <p> "'+namedata+'" has no file extention  </p>';
                                 }
                                 
                             }
                             
                      
                             //console.log("here is a file name: " + name + "==size=>"+ inp.files.item(i).size );
                         }
			
                         if (errorstr!='' && filepassedAr.length > 0)
                         {
                             toastr.remove();// Immediately remove current toasts without using animation
                             poptriggerfunc(msgtype='error',titledata='',msgdata=errorstr,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width'); 
                           
                            $("#submitbutnid").trigger("click");
                         }
                         else if (errorstr!='' && filepassedAr.length==0)
                         {
                             //alert(errorstr);
                              toastr.remove();// Immediately remove current toasts without using animation
                             poptriggerfunc(msgtype='error',titledata='',msgdata=errorstr,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width'); 
                           
                         }
                         if (errorstr=='' && filepassedAr.length > 0)
                         {
                              
                           
                            $("#presskitsubmitbutnid").trigger("click");
                         }
            
            
                     });
                    
                    //**** regarding presskit upload  ends******
               
               
                    $('.profile_slider').owlCarousel({
                    loop:false,
                    margin:0,
                    items:1,
                    nav:true,
                    dots:false,
                    });
                    
                    
                    //*** initialize slider ends
                    
                         //****** for binding with  user image slider on change of slider starts 
                         var owl = $('.owl-carousel');
                    
                          owl.owlCarousel({callbacks: true});
                     
                          owl.on('changed.owl.carousel', function(event) {
                       
                         var totalItems = $('.item').length;
                          //console.log("len=>"+totalItems);
                     
                         var currentitemnmbr=event.item.index;
                         var curritemnum=currentitemnmbr+1; // current item number without starting  from 0 ,  if current index is o then , curr photo is 0+1=1 , if 1 then 1+1=2
                       
                          showhideprevnextimgslider(totalItems,curritemnum) ;                  
                    
                          });
                    //****** for binding with  user image slider on change of slider ends
               
               
                    //****** for showing right icon in image slider on load  starts
                    
                   var totalItems = $('.item').length; var curritemnum=1;
                   showhideprevnextimgslider(totalItems,curritemnum);
                   
                   //****** for showing right icon in image slider on load ends
                    
                    
                    
                    $('#skill_parent').selectpicker('deselectAll');
                    
                    $("#skill_sub").html('');
                    $("#skill_sub").selectpicker('refresh');
                    
                     //*** functionality of setting button on roster calndar starts
                
                $('.calendarPopBtn').click(function(){
                                $(this).parent().toggleClass('showcalendarPopup');
                });
                
                $('.showHideCalendarPopup a').click(function(){
                                $('.showHideCalendarPopup a').removeClass('active');
                                $(this).addClass('active');
                });
                
                //*** functionality of setting button on roster calndar ends
                
                //***** call renderCustCalendarRoster starts
                renderCustCalendarRoster();
                
                //***** call renderCustCalendarRoster ends
                
                    
               footerarea_css();
		
               //************************* bind calviewshowflagcls starts*************************
               
              
               $(".calviewshowflagcls").click(function(){
                                
               callcalviewshowflagsave(this);   
              
                    
               });
                //************************** bind calviewshowflagcls ends  **************************
                //************************* bind pendbkpblshowflcls starts*************************
               
              
               $(".pendbkpblshowflcls").click(function(){
                                
               callpendbkpblshowflclssave(this);   
              
                    
               });
                //************************** bind pendbkpblshowflcls ends  **************************
         
         
          //console.log("=pendingbkshowflag_trk=>"+pendingbkshowflag_trk+"==publiceventshowflag_trk=>"+publiceventshowflag_trk);
                    
                    

                // //************************** bind pendbkpblshowflcls ends  **************************
                         
				
            });
             
             