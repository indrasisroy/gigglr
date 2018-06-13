//loadprofileleftmenu()


function loadprofileCatFen() {
    
    
        
    
    var callingurlfunc="getprofilecatgen";
    var callingurl=base_url_data+"/"+callingurlfunc;

          var callurlwithdata={_token:csrf_token_data,'type_flag':type_flag,'seo_name':seo_name};
          var cmsgdata='data updated successfully';

             $.ajax({
                 url:callingurl,
                 type:'GET',
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
                        showmycustomloader(1,'','',"Please wait. Its loading...",imfpth);
                        
                        //***** call left panel populate  starts                        
                        pro_category = $(this).val();
                        loadprofileleftmenu();
                         //***** call left panel populate  ends
                         
                        //***** call calendar repopulate   starts
                        
                        $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar                                                
                        renderCustCalendarRoster();                        
                        
                         //***** call calendar repopulate   ends  
                        
                        var callingurlfunc="getprofilegenajax";
                        var callingurl=base_url_data+"/"+callingurlfunc;
                        
                        var callurlwithdata={_token:csrf_token_data,'type_flag':type_flag,'seo_name':seo_name,'pro_category':pro_category};
                        var cmsgdata='data updated successfully';
                        
                        $.ajax({
                                    url:callingurl,
                                    type:'GET',
                                    dataType:'json',
                                    data:callurlwithdata,
                                    success:function(d){
                                    var subskillopt="";
                                    subskillopt+="<option value=''>Select Genre</option>";
                                    $.each(d, function(idx, obj){
                                    subskillopt+="<option value='"+obj.id+"'>"+obj.name+"</option>";
                        });
                                    
                        //$("#genre_sub_profile").html(subskillopt).fadeIn(100,function(){
                        //    alert("fbsd");
                        //    });
                        $("#genre_sub_profile").html(subskillopt);
                        $("#genre_sub_profile").selectpicker('refresh');
                        
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
                 type:'GET',
                 dataType:'json',
                 data:callurlwithdata,
                 success:function(d){
                    //alert(d);
                    
                    var ep_contents=d.ep_contents;
                    
                    $(".loadLeftGigList").html(ep_contents);
                    daymonth = '';
//                                 toastr.remove();// Immediately remove current toasts without using animation
//                                 
//                                 //***************** Check response starts
//                                 
//                                 if (d.update_flag==0)
//                                 {
//                                 
//                                        poptriggerfunc(msgtype='error',titledata='',msgdata=d.error_message,sd=1000,hd=1500,tmo=1000,etmo=2000,poscls='toast-top-full-width');
//                                 
//                                 }
//                                 else
//                                 {
//                                   
//                                        viewshowflag=calviewshowflagdata;
//                                        
//                                        if (viewshowflag==0)
//                                        {
//                                             $(".yellowstardev").hide();
//                                             $(".redclockdev").hide();
//                                             $(".calsettingsdvcls").slideUp(); 
//                                              
//                                        }
//                                        else if (viewshowflag==1)
//                                        {
//                                             
//                                                   if (pendingbkshowflag_trk==0)
//                                                  {
//                                                       $(".redclockdev").hide();
//                                                  }
//                                                  else
//                                                  {
//                                                        $(".redclockdev").show();						
//                                                  
//                                                  }
//                                                  
//                                                  if (publiceventshowflag_trk==0)
//                                                  {
//                                                   $(".yellowstardev").hide();
//                                                  }
//                                                  else
//                                                  {
//                                                   $(".yellowstardev").show();						
//                                                  
//                                                  }
//                                                  
//                                                  $(".calsettingsdvcls").slideDown(); 
//                                                  
//                                                  
//                                            
//                                        }
//                                        
//                                        $(".calendarPopBtn").trigger("click"); // hide dropdown popup
//                                        
//                                        poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
//                                 }
//                                       
//                                 //***************** Check response ends      
//                              }
                 }
                   });
             
}

$(document).ready(function(){
    
   loadprofileCatFen();
   loadprofileleftmenu();
    
    
    
    
    
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

    
   
    
    });


       