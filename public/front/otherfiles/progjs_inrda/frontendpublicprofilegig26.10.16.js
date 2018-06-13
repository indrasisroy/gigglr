//loadprofileleftmenu()


function loadprofileCatFen() {
    
    
        
    
    var callingurlfunc="getprofilecatgen";
    var callingurl=base_url_data+"/"+callingurlfunc;

          var callurlwithdata={_token:csrf_token_data,'type_flag':type_flag,'seo_name':seo_name};
          var cmsgdata='data updated successfully';

             $.ajax({
                 url:callingurl,
                 type:'POST',
                 dataType:'json',
                 data:callurlwithdata,
                 success:function(d){
                    //alert(d);
                    
                    var ep_contents=d.ep_contents;
                    
                    $(".profileCatFen").html(ep_contents).fadeIn(100,function(){
                        

                        //***** bind change starts
                        
                        $( "#category_sub_profile" ).change(function() {
                        //alert($(this).val());
                        
                        //**** call loader
                        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                      //  showmycustomloader(1,'','',"",imfpth);
                        
                        //***** call left panel populate  starts                        
                        pro_category = $(this).val();
                        loadprofileleftmenu();
                         //***** call left panel populate  ends
                         
                        //***** call calendar repopulate   starts
                        
                        var newdefdt=selecteddate;
                        
                        $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar                                                
                        renderCustCalendarRoster(newdefdt);                   
                        
                         //***** call calendar repopulate   ends  
                        
                        var callingurlfunc="getprofilegenajax";
                        var callingurl=base_url_data+"/"+callingurlfunc;
                        
                        var callurlwithdata={_token:csrf_token_data,'type_flag':type_flag,'seo_name':seo_name,'pro_category':pro_category};
                        var cmsgdata='data updated successfully';
                        
                        $.ajax({
                                    url:callingurl,
                                    type:'POST',
                                    dataType:'json',
                                    data:callurlwithdata,
                                    success:function(d){
                                    var subskillopt="";
                                    subskillopt+="";
                                    $.each(d, function(idx, obj){
                                    subskillopt+="<option value='"+obj.id+"'>"+obj.name+"</option>";
                        });
                                    
                        $("#genre_sub_profile").html(subskillopt);
                        $("#genre_sub_profile").selectpicker('refresh').fadeIn(100,function(){
                            
                            $( "#genre_sub_profile" ).change(function() {
                                
                                //alert($(this).val());
                                
                                //**** call loader
                                var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                               // showmycustomloader(1,'','',"",imfpth);
                                
                                pro_genre = $(this).val();
                                
                                loadprofileleftmenu();
                                //***** call calendar repopulate   starts
                                
                                
                                var newdefdt=selecteddate;
                                                                
                                $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar                                                
                                renderCustCalendarRoster(newdefdt);
                                
                               
                                
                                //$('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar                                                
                                //renderCustCalendarRoster();
                                
                                
                                
                                //***** call calendar repopulate   ends  
                                
                            });
                            
                            
                            
                            });

                        
                        }
                        });
                        
                        });
                        
                        //***** bind change ends
                        
                        
                        });
                    
                 }
             });
}


function loadprofileleftmenu()
{
//now start
//$('#monthlink').addClass("activepanecolorforrosterleftclass");
 var pro_searchdatastr='';
        var pro_searchdatastrAr=[];
        pro_searchdatastrAr.push('"_token":"'+csrf_token_data+'"');
         
         
         //*** for filtration purpose starts
        
        if (daymonth!='') {
            pro_searchdatastrAr.push('"month":'+'"'+daymonth+'"');
        }
        
        if (pro_category!='')
        {
           pro_searchdatastrAr.push('"category":'+'"'+pro_category+'"');
        }
        
        if (pro_genre!='')
        {
           pro_searchdatastrAr.push('"genre":'+'"'+pro_genre+'"');
        }
        
        if (type_flag!='')
        {
           pro_searchdatastrAr.push('"type_flag":'+'"'+type_flag+'"');
        }
        
        if (seo_name!='')
        {
           pro_searchdatastrAr.push('"seo_name":'+'"'+seo_name+'"');
        }
        
        if (cal_select_date!='')
        {
           pro_searchdatastrAr.push('"cal_select_date":'+'"'+cal_select_date+'"');
        }
        if (filterevtype!='')
        {
            pro_searchdatastrAr.push('"filterevtype":'+'"'+filterevtype+'"');
        }
        
        //*** for filtration purpose ends
         
        if (pro_searchdatastrAr.length>0)
        {
            pro_searchdatastr=pro_searchdatastrAr.toString();
        }
        
       // console.log(searchdatastr.length+"=searchdata=>"+searchdatastr);
        
        var pro_searchdatastrObj=JSON.parse("{"+pro_searchdatastr+"}");
       // console.log("=searchdata=>"+JSON.stringify(searchdatastrObj));
       
        var callurlwithdata=pro_searchdatastrObj;

//now end

    //alert(base_url_data+" "+seo_name+" "+type_flag+" "+cal_select_date+" "+someevntfired_flag);
    var callingurlfunc="getprofileleftmanu";
    var callingurl=base_url_data+"/"+callingurlfunc;

          //var callurlwithdata={_token:csrf_token_data,'type_flag':type_flag,'seo_name':seo_name};
          var cmsgdata='data updated successfully';

             $.ajax({
                 url:callingurl,
                 type:'POST',
                 dataType:'json',
                 data:callurlwithdata,
                 success:function(d)
                 {
                    if (d.return_type == '1') {
                        var ep_contents=d.ep_contents;
                        $(".loadLeftGigList").html(ep_contents).fadeIn(100,function(){
                            $('.clickMe').click(function(){
                            functionclinkmodal($(this).data('value'),$(this).data('type_flag'),$(this).data('event_type'),$(this).data('booking_stat'));
                            
                            });
                        });
                    }else{
                        $(".loadLeftGigList").html("<span class='nodatacustlftclass'>Record not found</span>");
                        //poptriggerfunc(msgtype='error',titledata='',msgdata="Record not found",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');         
                    }
                    
                    
                    

                    
//                                 toastr.remove();// Immediately remove current toasts without using animation

                 }
            });
             
}



function functionclinkmodal(gigunicid,type_flag,event_type,booking_stat) {
    
    toastr.remove();
    if (event_type == '2' && booking_stat == '1') {
        
        poptriggerfunc(msgtype='error',titledata='',msgdata="Private event details are not displayed",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
        
    }else if (booking_stat == '2') {
        poptriggerfunc(msgtype='error',titledata='',msgdata="This is a tendered booking. Details withheld",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
    }
    else if (event_type == '1' && booking_stat == '1') {
        
        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
       // showmycustomloader(1,'','',"",imfpth);


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
               // showmycustomloader(0,'','',"",imfpth);
                  var ep_contents=d.ep_contents;
                  $('.profilemodal').html(ep_contents);
                  $('#myModalPro').modal('show');
               }
          });
               
    }
}





$(document).ready(function(){
    if (cal_viewshowflag=='1')
    {
        loadprofileCatFen();
        loadprofileleftmenu();
    }
   
    
    
    
    
    
$('#monthlink').click(function(){daymonth = 'month';
                      $('#weeklink').removeClass("activepanecolorforrosterleftclass");
                      $('#daylink').removeClass("activepanecolorforrosterleftclass");
                      $(this).addClass("activepanecolorforrosterleftclass");
                      daymonth = 'month';
                      loadprofileleftmenu();
                      });
$('#weeklink').click(function(){daymonth = 'week';
                    $('#monthlink').removeClass("activepanecolorforrosterleftclass");
                    $('#daylink').removeClass("activepanecolorforrosterleftclass");
                    daymonth = 'week';
                     loadprofileleftmenu();
                     $(this).addClass("activepanecolorforrosterleftclass");
                     });
$('#daylink').click(function(){daymonth = 'day';
                    $('#monthlink').removeClass("activepanecolorforrosterleftclass");
                    $('#weeklink').removeClass("activepanecolorforrosterleftclass");
                    daymonth = 'day';
                    loadprofileleftmenu();
                    $(this).addClass("activepanecolorforrosterleftclass");
                    });

    $('.allprofileeventcls').each(function(){
    
     var evtypedata=$(this).data('evtype');
      var evtypeflagdata=$(this).data('evtypeflag');
     
         console.log($(this).data('evtype')+"---"+$(this).data('evtypeflag'));
         
         if (evtypeflagdata==0)
         {
             // add class to show as inactive
             
             $(this).parent().addClass('deactive');
         }
        
         
    });

                    
$('.allprofileeventcls').click(function(evnt){
    
    var evtypeflagdata=$(this).data('evtypeflag');
    if (evtypeflagdata==1)
         {
                filterevtype = $(this).data('evtype');
                
                var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
              //  showmycustomloader(1,'','',"",imfpth);
                
                loadprofileleftmenu();
                console.log("Active  feature");
                
                var newdefdt=selecteddate;
                
                $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar                                                
                renderCustCalendarRoster(newdefdt);
                 
                                
                                
                
                
         }
         else
         {
            filterevtype='';
            console.log("InActive  feature");
            toastr.remove();
            poptriggerfunc(msgtype='error',titledata='',msgdata="InActive  feature",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right'); 
            evnt.preventDefault();
            
            
         }
    //alert(filterevtype);
    
    
});

    
   
    
    });


       