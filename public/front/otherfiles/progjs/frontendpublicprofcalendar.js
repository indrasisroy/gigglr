	var defaultDateData =moment().format('YYYY-MM-DD');
	
	
    
	function renderCustCalendarRoster()
		{
				//console.log("called me ");
                var smplDateDatastart_ym =moment().format('YYYY-MM');
				
				var smplDateDatastart=smplDateDatastart_ym+"-01 10:05:10"
				
				var smplDateDataend =moment(smplDateDatastart,'YYYY-MM-DD HH:mm:ss').add(1, 'hours').format('YYYY-MM-DD HH:mm:ss');
				
				
				//console.log("smplDateDatastart==>"+smplDateDatastart+"smplDateDataend===>"+smplDateDataend);
                
				$('#calendardivid').fullCalendar({
				header: {
					left: false,
					
					right: 'prev,month,next'
				},
				defaultDate: defaultDateData,
				editable: true,
				eventLimit: false, // allow "more" link when too many events
				events: [{"title":"redclock title","start":smplDateDatastart,"end":smplDateDataend,"rcsipsbb":"REDCLOCK","giguniqueid"
:"GIG-5774ca8a6dcac","gigmaster_id":"20"},{"title":"yellow star title","start":smplDateDatastart,"end":smplDateDataend,"rcsipsbb":"STARICON","giguniqueid"
:"GIG-5774ca8a6dcad","gigmaster_id":"21"},{"title":"black star star title","start":smplDateDatastart,"end":smplDateDataend,"rcsipsbb":"BLACKSTARICON","giguniqueid"
:"GIG-5774ca8a6dcad","gigmaster_id":"21"} ],
                
                eventAfterAllRender:function(view){
				
				//console.log("rendering all fnshd");
                samesize();	

                setTimeout(function(){
               //  alert("Hello");
                 sameHeight($(".calendarHeight"));//added for calendar height 
                  }, 1000);
                // sameHeight($(".calendarHeight"));//added for calendar height	


                },
				
				eventAfterRender: function(event, el)
			{
                
						
                        el.find('.fc-title').closest("a").addClass("mydisplaynone");
							
                        var rcsipsbb_data=event.rcsipsbb;
                        var startdatetime=event.start.format("YYYY-MM-DD");//"YYYY-MM-DD HH:mm:ss"
                          
                        var enddatetime=event.end.format("YYYY-MM-DD");
                                        
                         
                        var dificon_cls='';
                        //yellowclockdev, redclockdev, yellowstardev, purpleboxdev,bluebookdev
                        //YELLOWCLOCK,REDCLOCK,STARICON,PURPLE,BLUEBOOK
                        
                        if (rcsipsbb_data=='YELLOWCLOCK')
                        {
                               dificon_cls="yellowclockdev";
                        }
                        else if (rcsipsbb_data=='REDCLOCK')
                        {
                               dificon_cls="redclockdev";
                        }
                         else if (rcsipsbb_data=='STARICON')
                        {
                                 dificon_cls="yellowstardev";
                        }
                        else if (rcsipsbb_data=='BLACKSTARICON')
                        {
                                 dificon_cls="blackstardev";
                        }
                        else if (rcsipsbb_data=='PURPLE')
                        {
                                 dificon_cls="purpleboxdev";
                        }
                        else if (rcsipsbb_data=='BLUEBOOK')
                        {
                                 dificon_cls="bluebookdev";
                        }
                        
                        var daterespclass=startdatetime+dificon_cls+"cls"
                        
                        var startdatetimecls=startdatetime+"cls";
                        
                        var chkdaterespclassprsnt = $("#calendardivid").find('.'+daterespclass).length;
                        
                        //console.log("=daterespclass=>"+daterespclass+"==chkdaterespclassprsnt=>"+chkdaterespclassprsnt);

                           
                        if (chkdaterespclassprsnt==0)
                        {
                                
                                //****** now do starts
                                
                                var chkdaterespclassprsnt = $("#calendardivid").find('.'+startdatetimecls).length;
                                
                                if (chkdaterespclassprsnt>0)
                                {
                                      $("#calendardivid").find('.'+startdatetimecls).eq(0).append(
                                //$('<div class="okbabay "/>').text(event.hellotest)
                                
                                        $("<div class='"+dificon_cls+" "+daterespclass+" "+startdatetimecls+" "+"' data-startdatetime='"+startdatetime+"'  data-enddatetime='"+enddatetime+"' data-rcsipsbb='"+rcsipsbb_data+"'   > "+'&nbsp;'+"  </div>")
                                
                                         );
                                      
                                }
                                else
                                {
                                        el.find('.fc-title').closest("td").append(
                                        //$('<div class="okbabay "/>').text(event.hellotest)
                                        
                                        $("<div class=' commoncustrowclass "+startdatetimecls+"'><div class='"+dificon_cls+" "+daterespclass+"  "+"' data-startdatetime='"+startdatetime+"'  data-enddatetime='"+enddatetime+"' data-rcsipsbb='"+rcsipsbb_data+"'   > "+'&nbsp;'+"  </div></div>")
                                        
                                        );
                                        
                                                                          
                                        
                                }
                                
                                //****** now do ends
                                
                               
                                    
                                el.find('.fc-title').closest("td").find(".suitcaseclass").click(function()
                                {
                                
                                         fetchedDate=$(this).data("startdatetime");
                                         callleftlistbycurdt();
                                
                                });
                        
                        }
                        
                       $("#calendardivid").find(".fc-more").addClass("mydisplaynone");
							
                        //console.log("==viewshowflag==>"+viewshowflag);
					
						if (viewshowflag==1)
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
                                  
                                  if (privateeventshowflag_trk==0)
                                  {
                                   $(".blackstardev").hide();
                                  }
                                  else
                                  {
                                   $(".blackstardev").show();						
                                  
                                  }
                                  
                                  
                                  $(".calsettingsdvcls").show();
                            
                        }
                        else if (viewshowflag==0)
                        {
                                 $(".redclockdev").hide();
                                 $(".yellowstardev").hide();
                                 $(".blackstardev").hide();
                                 $(".calsettingsdvcls").hide();
                        }
                        
                        //****hide number  from boxes starts
                        $("#calendardivid").find(".fc-day-number").addClass("mydisplaynone");
                        //****hide number  from boxes ends
                        
                        
                        //**** remove current dat highlight class starts
                        $("#calendardivid").find(".fc-today").css("background","#fff");
                        //**** remove current dat highlight class ends
			},
			
                loading: function(isLoading,view)
				{
					//console.log("=bool=>"+isLoading);
					
					
					
					
					
					
				}
			
					
					
					
				
			});
				
				
			
            $(".fc-prev-button").unbind(); 
            $(".fc-next-button").unbind(); 	
				
				
				
		}
		