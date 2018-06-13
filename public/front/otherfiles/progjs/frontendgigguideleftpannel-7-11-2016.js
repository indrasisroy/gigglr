
                    
function showhideprevnextimggigslider(totalItems,curritemnum)
{
                if (totalItems<=6)
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
    

function getallGroupUserCategory(){
        var categorydata = {_token:csrf_token_data};
        var urldata=base_url_data+"/getgigguidgetcategory";
        jQuery.ajax({
            type: "POST",
            data:categorydata,
            url: urldata,
            dataType:"json",
                success: function(res)
                {
                    var catHtml = '';
                    if (res.flag == '1') {
                        
                        $.each( res.data, function( key, value ) {
                        catHtml += "<option value ="+value.id+">"+value.name+"</option>";
                        
                        });
                        
                       
                    }else{
                        toastr.remove();
                        poptriggerfunc(msgtype='error',titledata='',msgdata=res.msg,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width'); 
                        
                    }
                    //$(".catGuide").html(catHtml);
                    $("#Category_guide").html(catHtml);
                    $("#Category_guide").selectpicker('refresh').fadeIn(100,function(){
                        
                            $( "#Category_guide" ).change(function() {
                                var guide_gen='';
                                var guide_cat_id ='';
                                var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                               // showmycustomloader(1,'','',"",imfpth);

                                guide_cat = $(this).val();
                                pro_genre = '';
                                pro_category = guide_cat;
                                $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar
                                var newdefdt=selecteddate;
                                renderCustCalendarRoster(newdefdt); // call  and reinitialize calendar
                                loadGigGuideLeftPannel();
                                
                                var categorydata = {_token:csrf_token_data,guide_cat:guide_cat};
                                var urldata=base_url_data+"/getgigguidgetgenre";
                                jQuery.ajax({
                                    type: "POST",
                                    data:categorydata,
                                    url: urldata,
                                    dataType:"json",
                                        success: function(res)
                                        {
                                            //showmycustomloader(0,'','',"",imfpth);
                                            $.each( res.data, function( key, value ) {
                                            guide_gen += "<option value ="+value.id+">"+value.name+"</option>";
                                            });
                                            $("#Genre_guide").html(guide_gen);
                                            $("#Genre_guide").selectpicker('refresh').fadeIn(100,function(){
                                                
                                                $( "#Genre_guide" ).change(function() {
                                                    var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                                    //showmycustomloader(1,'','',"",imfpth);
                                                    pro_category = guide_cat;
                                                    pro_genre = $(this).val();
                                                    
                                                    var newdefdt=selecteddate;            
                                                    $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar            
                                                    renderCustCalendarRoster(newdefdt); // call  and reinitialize calendar
                                                                                            
                                                    loadGigGuideLeftPannel();
                                                    
                                                });
                                                
                                            });
                                        }
                                        
                                });

                            });
                            
                        });
                }
        });
}

function functionclinkmodal(gigunicid,type_flag,event_type,booking_stat) {
    
    toastr.remove();
    if (event_type == '2' && booking_stat == '1') {
        
        poptriggerfunc(msgtype='error',titledata='',msgdata="Private event details are not displayed",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
        
    }else if (booking_stat == '2') {
        poptriggerfunc(msgtype='error',titledata='',msgdata="This is a tendered booking. Details withheld",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
    }
    else if (event_type == '1' && booking_stat == '1') {
        
        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
        //showmycustomloader(1,'','',"",imfpth);


        var callingurlfunc="getprofilemodalajax";
        var callingurl=base_url_data+"/"+callingurlfunc;
    
        var callurlwithdata={_token:csrf_token_data,'type_flag':type_flag,'gigunicid':gigunicid,'event_type':event_type};
        var cmsgdata='data updated successfully';
    
           $.ajax({
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d)
               {
                //showmycustomloader(0,'','',"",imfpth);
                  var ep_contents=d.ep_contents;
                  $('.Guidemodal').html(ep_contents);
                  $('#myModalGuide').modal('show');
               }
          });
               
    }
}



function loadGigGuideLeftPannel(){
        
        if (daymonth == 'month') {
            $(".clickMWD").filter('[data-mdw="month"]').addClass('activepanecolorforrosterleftclass');
        }
        
        //var categorydata = {_token:csrf_token_data,logID:logID,filterevtype:filterevtype,cal_select_date:cal_select_date,month:daymonth};
        
        var pro_searchdatastr='';
        var pro_searchdatastrAr=[];
        pro_searchdatastrAr.push('"_token":"'+csrf_token_data+'"');
        pro_searchdatastrAr.push('"logID":"'+logID+'"');

        if (daymonth!='') {
            pro_searchdatastrAr.push('"month":'+'"'+daymonth+'"');
        }
        //if (curr_lat_data!='') {
            pro_searchdatastrAr.push('"curr_lat_data":'+'"'+curr_lat_data+'"');
        //}
        //if (curr_long_data!='') {
            pro_searchdatastrAr.push('"curr_long_data":'+'"'+curr_long_data+'"');
        //}
        
        if (pro_category!='')
        {
           pro_searchdatastrAr.push('"category":'+'"'+pro_category+'"');
        }
        
        if (pro_genre!='')
        {
           pro_searchdatastrAr.push('"genre":'+'"'+pro_genre+'"');
        }
        
        
        if (cal_select_date!='')
        {
           pro_searchdatastrAr.push('"cal_select_date":'+'"'+cal_select_date+'"');
        }
        if (filterevtype!='')
        {
            pro_searchdatastrAr.push('"filterevtype":'+'"'+filterevtype+'"');
        }

        if (pro_searchdatastrAr.length>0)
        {
            pro_searchdatastr=pro_searchdatastrAr.toString();
        }

        var pro_searchdatastrObj=JSON.parse("{"+pro_searchdatastr+"}");

        var categorydata=pro_searchdatastrObj;
        
        var urldata=base_url_data+"/getgigguidleftpannel";
        jQuery.ajax({
            type: "POST",
            data:categorydata,
            url: urldata,
            dataType:"json",
                success: function(res)
                {
                    var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                    //showmycustomloader(0,'','',"",imfpth);
                    if (res.return_type == '1') {
                        $("#gigleftpanneldvid").html(res.ep_contents).fadeIn(100,function(){
                                
                                $('.clickGigView').click(function(){
                                        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                        //showmycustomloader(1,'','',"",imfpth);
                                        var gig_id = $(this).data("gig");
                                        var type_flag = $(this).data("type_flag");
                                        //alert(gig_id+" "+type_flag);
                                        functionclinkmodal(gig_id,type_flag,1,1);
                                        
                                });
                        });;
                        
                    }
                }
        });
    }
$(document).ready(function()
{
    loadGigGuideLeftPannel();
    getallGroupUserCategory();
    
    
    $( ".clickMWD" ).click(function() {
        
      var clickval = $(this).data('mdw');
      
      if (clickval == 'day') {
        $(".clickMWD").removeClass('activepanecolorforrosterleftclass');
        $(this).filter('[data-mdw="day"]').addClass('activepanecolorforrosterleftclass');
      }else if (clickval == 'week') {
        $(".clickMWD").removeClass('activepanecolorforrosterleftclass');
        $(this).filter('[data-mdw="week"]').addClass('activepanecolorforrosterleftclass');
      }else if (clickval == 'month') {
        $(".clickMWD").removeClass('activepanecolorforrosterleftclass');
        $(this).filter('[data-mdw="month"]').addClass('activepanecolorforrosterleftclass');
      }
      
      daymonth = clickval;
      loadGigGuideLeftPannel();
    });
    
     $(".mycustevntcls").click(function(){
        
            
            //***** remove all deactive starts 
            
            //$('.mycustevntcls').each(function(){
            //
            //$(this).parent().removeClass('deactive');            
            //
            //});
             //***** remove all deactive ends
             
            //$(this).parent().addClass('deactive');  //***** deactive the selected button choosen
            
            var showevntflag=$(this).data("showevntflag");
           
            var filterevtypedta=$(this).data("filterevtype");
            //alert("=filterevtypedta=>"+filterevtypedta);
            cal_select_date=selecteddate;
            //filterevtype=filterevtypedta;
            
            //****************************** show hide event  text starts
            if(filterevtypedta=="EVENTFAN")
            {
                if(showevntflag==0)
                {
                          $(this).data("showevntflag",1);
                          $(this).find(".evntxtdtacls").html("Show Events I am a fan");
                          
                                //*** check evnttypeshowflag to   delete  in  array starts
                
                                var check_evntchoosed_data= $.inArray( filterevtypedta, evnttypeshowflagAr );
                                if (check_evntchoosed_data!=-1)
                                {
                                 evnttypeshowflagAr.splice(check_evntchoosed_data,1);
                                }
                
                                //*** check evnttypeshowflag to   delete  in  array ends
                }
                else
                {
                           $(this).data("showevntflag",0);
                           $(this).find(".evntxtdtacls").html("Hide Events I am a fan");
                           
                           //*** check evnttypeshowflag to   add  in  array starts
                
                                var check_evntchoosed_data= $.inArray( filterevtypedta, evnttypeshowflagAr );
                    
                                  if (check_evntchoosed_data==-1)
                                 {
                                     evnttypeshowflagAr.push(filterevtypedta);
                                 }
                    
                             //*** check evnttypeshowflag to   add  in  array ends
                }
                
            }
            else if(filterevtypedta=="EVENTGENRE")
            {
                if(showevntflag==0)
                {
                          $(this).data("showevntflag",1);
                          $(this).find(".evntxtdtacls").html("Show my profile genres");
                          
                          //*** check evnttypeshowflag to   delete  in  array starts
                
                                var check_evntchoosed_data= $.inArray( filterevtypedta, evnttypeshowflagAr );
                                if (check_evntchoosed_data!=-1)
                                {
                                evnttypeshowflagAr.splice(check_evntchoosed_data,1);
                                }
                
                         //*** check evnttypeshowflag to   delete  in  array ends
                }
                else
                {
                           $(this).data("showevntflag",0);
                           $(this).find(".evntxtdtacls").html("Hide my profile genres");
                           
                           //*** check evnttypeshowflag to   add  in  array starts
                
                                var check_evntchoosed_data= $.inArray( filterevtypedta, evnttypeshowflagAr );
                    
                                  if (check_evntchoosed_data==-1)
                                 {
                                     evnttypeshowflagAr.push(filterevtypedta);
                                 }
                    
                             //*** check evnttypeshowflag to   add  in  array ends
                }
            }
            else if(filterevtypedta=="EVENTTOWN")
            {
                if(showevntflag==0)
                {
                          $(this).data("showevntflag",1);
                          $(this).find(".evntxtdtacls").html("Show events in my town");
                          
                          //*** check evnttypeshowflag to   delete  in  array starts
                
                                var check_evntchoosed_data= $.inArray( filterevtypedta, evnttypeshowflagAr );
                                if (check_evntchoosed_data!=-1)
                                {
                                evnttypeshowflagAr.splice(check_evntchoosed_data,1);
                                }
                
                         //*** check evnttypeshowflag to   delete  in  array ends
                }
                else
                {
                           $(this).data("showevntflag",0);
                           $(this).find(".evntxtdtacls").html("Hide events in my town");
                           
                           //*** check evnttypeshowflag to   add  in  array starts
                
                                var check_evntchoosed_data= $.inArray( filterevtypedta, evnttypeshowflagAr );
                    
                                  if (check_evntchoosed_data==-1)
                                 {
                                     evnttypeshowflagAr.push(filterevtypedta);
                                 }
                    
                             //*** check evnttypeshowflag to   add  in  array ends
                }
            }
            
            filterevtype=evnttypeshowflagAr.join("||");
            //****************************** show hide event  text starts
            
             var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
             //showmycustomloader(1,'','',"",imfpth); 
            
             loadGigGuideLeftPannel(); // call left panel data
             
            var newdefdt=selecteddate;            
            $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar            
            renderCustCalendarRoster(newdefdt); // call  and reinitialize calendar
            
        });
     
     
     //***** remove all deactive starts 
            
            $('.mycustevntcls').each(function(){
            
            if (logID =='') {
                $(this).parent().addClass('deactive');        
            }
                
            
            });
             //***** remove all deactive ends

           //****** for showing right icon in image slider on load  starts
                    
                   var totalItems = $('.item').length; var curritemnum=1;
                   showhideprevnextimggigslider(totalItems,curritemnum);
                   
            //****** for showing right icon in image slider on load ends  
             
    
});