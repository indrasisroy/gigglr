	var defaultDateData =moment().format('YYYY-MM-DD');
    
	var selecteddate='';
	var seldt='';
		
	var prevflag=false;
	var nextflag=false;
    
    
    
    var clickedformagnify=false;
    
    
    
    function getDynmDefaultDateData(dfdatedata)
    {
        var defaultDateData='';
        
        if (dfdatedata=='')
        {
                defaultDateData=moment().format('YYYY-MM-DD');
        }
        else
        {
                 defaultDateData=dfdatedata;
        }
       
        
        return defaultDateData;
    }
	
	function getmydynamicdata()
	{
		
			var newselecteddate=(selecteddate=='')?defaultDateData:selecteddate;
			//console.log("=newselecteddate=>"+newselecteddate);
			return newselecteddate;
	}
    
    function getlatidata()
    {
        var latidta=curr_lat_data;
        
        return latidta;
    }
    
    function getlongidata()
    {
        var longidta=curr_long_data;
        
        
        return longidta;
    }
    
    function getmyfilterevtypedata()
    {
        var filterevtypedta=filterevtype;
        
        return filterevtypedta;
    }
    
    function getmyprocategorydata()
    {
        var pro_category_dta=pro_category;
        
        return pro_category_dta;
    }
    
    function getmyprogenredata()
    {
        var pro_genre_dta=pro_genre;
        
        return pro_genre_dta;
    }
    
    
    function getmydynamicfldatedata(fdldflag)
    {
               
        var selecteddatedata=getmydynamicdata();
        
        var selmomobj=moment(selecteddatedata,'YYYY-MM-DD');
        var curmnthdays=selmomobj.daysInMonth();
        
       // console.log("curmnthdays=>"+curmnthdays);
        
        var selfrstdate=selmomobj.format('YYYY-MM')+"-01";
        var sellstdate=selmomobj.format('YYYY-MM')+"-"+curmnthdays;
       //  console.log("selfrstdate=>"+selfrstdate+"==sellstdate=>"+sellstdate);
       
       if (fdldflag=="fd")
       {
                return selfrstdate;
       }
       else  if (fdldflag=="ld")
       {
                return sellstdate;
       }
        
        
    }
	function getnextflag()
	{
			return nextflag;
	}
	
	function renderCustCalendarRoster(newdefdt)
		{

                
                
				$('#calendardivid').fullCalendar({
				header: {
					left: 'title',
					
					right: 'prev,month,next'
				},
				defaultDate: newdefdt,
				editable: true,
				eventLimit: true, // allow "more" link when too many events
				
				events: {
							url: base_url_data+'/getgigguidecallendardata',
							type: 'POST',
							//data:  {_token:csrf_token_data,	selecteddate1:selecteddate },
							
							data: function() { // a function that returns an object
								
								
								
							return {
										dynamic_value: Math.random(),
										selecteddate:getmydynamicdata(),
										_token:csrf_token_data,
										prevflag:prevflag,
										nextflag:getnextflag(),
                                        selectedfirstdate:getmydynamicfldatedata('fd'),
                                        selectedlastdate:getmydynamicfldatedata('ld'),
                                        filterevtype:getmyfilterevtypedata(),
                                        category:getmyprocategorydata(),
                                        genre:getmyprogenredata(),
                                        latidata:getlatidata(),
                                        longidata:getlongidata()
                                        
										};
							},
							
							error: function() {
								alert('there was an error while fetching events!');
							},
							color: 'yellow',   // a non-ajax option
							textColor: 'black' // a non-ajax option
						 },
						 
				
				eventClick: function(calEvent, jsEvent, view)
				{
				
						console.log('Event: ' + calEvent.title);
						//console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
						//console.log('View: ' + view.name);
						//console.log('Event start date time: ' + calEvent.start.format("YYYY-MM-DD HH:mm" ));
						
						
						// change the border color just for fun
						//$(this).css('border-color', 'red');
						
						if ($(this).hasClass('highlightme')==false)
						{
							$(this).addClass('highlightme')
						}
						
						if (calEvent.url)
						{
							window.open(calEvent.url);
							return false;
						}
				
				
				},
				
				eventMouseover :function ( event, jsEvent, view )
				{
					
						//console.log('Mouse over Event start date time: ' + event.start.format("YYYY-MM-DD HH:mm" ));
						//
						//if ($(this).hasClass('magnifycustclass')==false)
						//{
						//	$(this).addClass('magnifycustclass')
						//}
				
				},
				
				eventMouseout :function ( event, jsEvent, view )
				{
					
					//console.log('Mouse out Event start date time: ' + event.start.format("YYYY-MM-DD HH:mm" ));
					//
					//if ($(this).hasClass('magnifycustclass')==true)
					//{
					//	$(this).removeClass('magnifycustclass');
					//}
				
				},
			
			dayClick: function(date, jsEvent, view)
			{
	
				//console.log('Clicked on: ' + date.format());
				//
				//console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
				//
				//console.log('Current view: ' + view.name);
				
				
				selecteddate=date.format();
				
				var selecteddatemm = moment(selecteddate, 'YYYY-MM-DD');
				var seldtdata = selecteddatemm.format('DD');
                var selmnthdata = selecteddatemm.format('MM');
                
				seldt=seldtdata;
				
                var curmomentdata = $('#calendardivid').fullCalendar('getDate');
                var calendarcurmnth = curmomentdata.format('MM');
                
				//console.log("New seldt on selecting day click=>"+seldt);				 
				
                
		
				// change the day's background color just for fun
				//$(this).css('background-color', 'red');
				
				var chk=$(this).find(".zoomicondev");
				
				//console.log(chk.length);
                
				
				if (chk.length==0 && (selmnthdata==calendarcurmnth) )
				{
						$("#calendardivid").find(".zoomicondev").each(function(){
						
						$(this).remove();
						
						});
						
						var cntnt=$(this).html(); 
						cntnt+='<div class="zoomicondev">&nbsp;</div>';
						$(this).html(cntnt);
                        
                        clickedformagnify=true;
                         
                        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                         showmycustomloader(1,'','',"Please wait . Its loading ...",imfpth);  
                        
                         
                         
                        //***** show data in left pannel starts
                        cal_select_date=selecteddate;
                        loadGigGuideLeftPannel();
                        //***** show data in left pannel ends
                         
                         setTimeout(function(){
                                
                                var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                showmycustomloader(0,'','',"Please wait . Its loading ...",imfpth);  
                                
                                },1500);
                        
                        
				}
				else
				{
						
						//$(this).html('<div class="magnifyclass"> add magni </div>');
				 
				}
                
                
                
			
			}	,
			eventAfterRender: function(event, el)
			{
                
					// render the timezone offset below the event title
                        //						if (event.start.hasZone())
                        //                        {
                        //							
                        //						}
                        
                        el.find('.fc-title').closest("a").addClass("mydisplaynone");
							
                        var rcsipsbb_data=event.rcsipsbb;
                        var startdatetime=event.start.format("YYYY-MM-DD");//"YYYY-MM-DD HH:mm:ss"
                         //console.log("'111====> data-startdatetime='"+event.start.format("YYYY-MM-DD HH:mm:ss")+"  data-enddatetime='"+event.end.format("YYYY-MM-DD HH:mm:ss")); 
                       // var enddatetime=event.end.format("YYYY-MM-DD");
                       var enddatetime=event.evcustomend;
                       // console.log("'222====> data-startdatetime='"+event.start.format("YYYY-MM-DD HH:mm:ss")+"  data-enddatetime='"+event.end.format("YYYY-MM-DD HH:mm:ss")); 
                            
                        var giguniqueid=event.giguniqueid;  
                        var dificon_cls='';
                        //yellowclockdev, redclockdev, yellowstardev, purpleboxdev,bluebookdev,greengigdev
                        //YELLOWCLOCK,REDCLOCK,STARICON,PURPLE,BLUEBOOK,GREENGIG
                        
                        if (rcsipsbb_data=='EVENTFAN')
                        {
                                 dificon_cls="eventfankdev";
                        }
                        else if (rcsipsbb_data=='EVENTTOWN')
                        {
                                 dificon_cls="eventtowndev";
                        }
                        else if (rcsipsbb_data=='EVENTGENRE')
                        {
                                 dificon_cls="eventgenredev";
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
                                
                                        $("<div class='"+dificon_cls+" "+daterespclass+" "+startdatetimecls+" "+"' data-startdatetime='"+startdatetime+"'  data-enddatetime='"+enddatetime+"' data-rcsipsbb='"+rcsipsbb_data+"' data-giguniq='"+giguniqueid+"'   > "+'&nbsp;'+"  </div>")
                                
                                         );
                                      
                                }
                                else
                                {
                                        el.find('.fc-title').closest("td").append(
                                        //$('<div class="okbabay "/>').text(event.hellotest)
                                        
                                        $("<div class=' commoncustrowclass "+startdatetimecls+"'><div class='"+dificon_cls+" "+daterespclass+"  "+"' data-startdatetime='"+startdatetime+"'  data-enddatetime='"+enddatetime+"' data-rcsipsbb='"+rcsipsbb_data+"' data-giguniq='"+giguniqueid+"'   > "+'&nbsp;'+"  </div> </div>")
                                        
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
							
                        	
                        
                        
			},
			eventAfterAllRender:function(view){
				
				console.log("rendering all fnshd");
				
				if (selecteddate=='')
				{
				
					selecteddate=defaultDateData;		
					
					//var mnthdays=mmobj.daysInMonth();
					//console.log("nxt==mnthdays==>"+mnthdays);
				
				}
				
					var selecteddatemm = moment(selecteddate, 'YYYY-MM-DD');
					var seldtdata = selecteddatemm.format('DD');
					seldt=seldtdata;
				
					//console.log("==after all render when seldt is blank seldt=>>"+seldt+"==selecteddate=>"+selecteddate);
					
					//*** selected code starts
					var mmobj=$.fullCalendar.moment(selecteddate);
					//console.log(mmobj);
					$("#calendardivid").fullCalendar( 'select', mmobj );
					
					//*** selected code ends
				
			},
			
				loading: function(isLoading,view) {
					//console.log("=bool=>"+isLoading);
					
                    
					if (isLoading==false)
					{
						$(".fc-prev-button").unbind(); 
						$(".fc-next-button").unbind(); 
						bindprevnextfunc();
                        
                         //**** for adding  magnify icon on prev or next button starts
                        
                         $("#calendardivid").find(".zoomicondev").each(function(){
						
						$(this).remove();
						
						});
            
                        
                        
                        $('#calendardivid').find(".fc-widget-content").each(function(){
                            
                            var datadatedta=$(this).data("date");
                            
                            
                            if ( (datadatedta==selecteddate) && (clickedformagnify==true) )
                            {
                                    var cntnt=$(this).html(); 
                                    cntnt+='<div class="zoomicondev">&nbsp;</div>';
                                    $(this).html(cntnt);
                            }
                            
                            
                            });
                        //**** for adding  magnify icon on prev or next button ends
                        
                        
                        setTimeout(function(){
                                
                        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                         showmycustomloader(0,'','',"Please wait . Its loading ...",imfpth);        
                                },1500);
                        
                        
					}
					
				},
                eventLimit:false
			
					
					
					
				
			});
				
				
				
				
				
				
		}
		
		
		function bindprevnextfunc()
		{
				//**** bind prev and next button starts
			
			$('.fc-prev-button').click(function(){
				
			
			nextflag=false;
			prevflag=true;
				 
			var curmomentdata = $('#calendardivid').fullCalendar('getDate');
			
			var nexmonthdatedatammObj=curmomentdata.subtract(1, 'months'); //substract
			
			var nexmonthdatedata=nexmonthdatedatammObj.format('YYYY-MM-DD');
			
			var curmnthdays=nexmonthdatedatammObj.daysInMonth();
			
			//console.log('Prev is clicked, do something'+" ===The current date of the calendar is => " + curmomentdata.format("YYYY-MM-DD"));
			//console.log(" ===seldt : " + seldt+"> curmnthdays: "+curmnthdays);
			
			if (parseInt(seldt) > parseInt(curmnthdays))
			{
				//**** find last date of the the current month starts
				
				var newcurrmnthymdata=curmomentdata.format("YYYY-MM" );			
				newcurrmnthymdata=newcurrmnthymdata+"-"+curmnthdays;
				
				newcurrmnthymdata=moment(newcurrmnthymdata, 'YYYY-MM-DD');
				newcurrmnthymdata=newcurrmnthymdata.format('YYYY-MM-DD');
				
				selecteddate=newcurrmnthymdata;
				
					
				//**** find last date of the the current month ends
				
			}
			else if (parseInt(seldt) <= parseInt(curmnthdays))
			{
				//**** find the new date of the the current month starts
				
				var newcurrmnthymdata=curmomentdata.format("YYYY-MM" );			
				newcurrmnthymdata=newcurrmnthymdata+"-"+seldt;
				
				newcurrmnthymdata=moment(newcurrmnthymdata, 'YYYY-MM-DD');
				newcurrmnthymdata=newcurrmnthymdata.format('YYYY-MM-DD');
				
				selecteddate=newcurrmnthymdata;
				
					
				//**** find new  date of the the current month ends
			}
			
			
            
            var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
            showmycustomloader(1,'','',"Please wait . Its loading ...",imfpth);  
			
			$('#calendardivid').fullCalendar('prev');
            
            //**** for adding  magnify icon on prev or next button starts
            
            $("#calendardivid").find(".zoomicondev").each(function(){
						
						$(this).remove();
						
						});
            
            $('#calendardivid').find(".fc-widget-content").each(function(){
                
                var datadatedta=$(this).data("date");
                
                
                 if ( (datadatedta==selecteddate) && (clickedformagnify==true) )
                {
                        var cntnt=$(this).html(); 
						cntnt+='<div class="zoomicondev">&nbsp;</div>';
						$(this).html(cntnt);
                }
                
                
                });
            //**** for adding  magnify icon on prev or next button ends
			
			
					
			}); 
			
			$('.fc-next-button').click(function(event){
			
			nextflag=true;
			prevflag=false;
			
			
			
			var curmomentdata = $('#calendardivid').fullCalendar('getDate');
			
			var nexmonthdatedatammObj=curmomentdata.add(1, 'months'); //add
			
			var nexmonthdatedata=nexmonthdatedatammObj.format('YYYY-MM-DD');
			
			var curmnthdays=nexmonthdatedatammObj.daysInMonth();
			
			
			
			//console.log('Next is clicked, do something'+" ===The current date of the calendar is => " + curmomentdata.format("YYYY-MM-DD"));
			//console.log(" ===seldt : " + seldt+"> curmnthdays: "+curmnthdays);
			
			if (parseInt(seldt) > parseInt(curmnthdays))
			{
				//**** find last date of the the current month starts
				
				var newcurrmnthymdata=curmomentdata.format("YYYY-MM" );			
				newcurrmnthymdata=newcurrmnthymdata+"-"+curmnthdays;
				
				newcurrmnthymdata=moment(newcurrmnthymdata, 'YYYY-MM-DD');
				newcurrmnthymdata=newcurrmnthymdata.format('YYYY-MM-DD');
				
				selecteddate=newcurrmnthymdata;
				
					
				//**** find last date of the the current month ends
				
			}
			else if (parseInt(seldt) <= parseInt(curmnthdays))
			{
				//**** find the new date of the the current month starts
				
				var newcurrmnthymdata=curmomentdata.format("YYYY-MM" );			
				newcurrmnthymdata=newcurrmnthymdata+"-"+seldt;
				
				newcurrmnthymdata=moment(newcurrmnthymdata, 'YYYY-MM-DD');
				newcurrmnthymdata=newcurrmnthymdata.format('YYYY-MM-DD');
				
				selecteddate=newcurrmnthymdata;
				
				
				//**** find new  date of the the current month ends
			}
			
			
			console.log("here 111111 selecteddate when next butn is clicked =>"+selecteddate);
			var gotodatemomobj=moment(selecteddate, 'YYYY-MM-DD');
			
			
			
			// $('#calendardivid').fullCalendar( 'gotoDate', selecteddate );
			
			
			
            var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
            showmycustomloader(1,'','',"Please wait . Its loading ...",imfpth);  
            
			$('#calendardivid').fullCalendar('next');
            
            //**** for adding  magnify icon on prev or next button starts
            
            $("#calendardivid").find(".zoomicondev").each(function(){
						
						$(this).remove();
						
						});
            
            
            $('#calendardivid').find(".fc-widget-content").each(function(){
                
                var datadatedta=$(this).data("date");
                
                
                if ( (datadatedta==selecteddate) && (clickedformagnify==true) )
                {
                        var cntnt=$(this).html(); 
						cntnt+='<div class="zoomicondev">&nbsp;</div>';
						$(this).html(cntnt);
                }
                
                
                });
            //**** for adding  magnify icon on prev or next button ends
			
              
			
			});
			
			//**** bind prev and next button ends	
		}
	
	
	$(document).ready(function() {
        
        
        getlatlongfromjsapi();
        getlatlongfrombrowser();
		
        //*** on load call calenadr starts
		selecteddate=(selecteddate=='')?defaultDateData:selecteddate;
        //console.log("ddddd=>"+selecteddate);

        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
        showmycustomloader(1,'','',"Please wait . Its loading ...",imfpth);   
		//renderCustCalendarRoster(moment().format('YYYY-MM-DD')); // calendar
        clickedformagnify=true; 
		renderCustCalendarRoster(selecteddate); // calendar
        
        //*** on load call calenadr ends
        
       
        
        $(".commnevttypecls").click(function(event){
              
          //event.preventDefault();
          
          var evnttypeshowflagdata=$(this).data("evnttypeshowflag");          
          //console.log("=evnttypeshowflagdata=>"+evnttypeshowflagdata);
          
          evnttypeshowflag=evnttypeshowflagdata;          
         // defaultDateData=selecteddate;
          
          var newdefdt=selecteddate;
          
          $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar
          
           var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
           showmycustomloader(1,'','',"Please wait . Its loading ...",imfpth);
          
           clickedformagnify=true; 
          renderCustCalendarRoster(newdefdt);
                
                });
	
		
		
	});