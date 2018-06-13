//***** document.ready starts
            
$(document).ready(function(){
                
                callleftlistbycurdt();
                getallrosterCategory();
                //*** if month / week / day button is clicked fromroster calender - starts
                
                $('.mwdclicked').click(function(){
                                var numItems = $('.activepanecolorforrosterleftclass').length;
                                $('.activepanecolorforrosterleftclass').removeClass('activepanecolorforrosterleftclass');
                                mwdclik=$(this).data("id");
                                $(this).addClass("activepanecolorforrosterleftclass");
                                $("#hidmwd").val(mwdclik);
                                callleftlistbycurdt();
                });
                
                //*** if month / week / day button is clicked fromroster calender - ends
                
                
                //*** functionality of setting button on roster calndar starts
                
                $('.calendarPopBtn').click(function(){
                                $(this).parent().toggleClass('showcalendarPopup');
                });
                
                $('.showHideCalendarPopup a').click(function(){
                                $('.showHideCalendarPopup a').removeClass('active');
                                $(this).addClass('active');
                });
                
                //*** functionality of setting button on roster calndar ends

            $('.rateStar').rating({
	              min: 0,
	              max: 5,
	              step: 1,
	              size: 'sm',
	              showClear: false
	        });

	
});

//****** document.ready ends




//****** functions to call ajax starts

function callleftlistbycurdt()
{
                
                //*** for current date in js starts
                
                var fullDate = new Date();
                //console.log(fullDate);
                var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
                var twoDigitDate = fullDate.getDate()+"";if(twoDigitDate.length==1)	twoDigitDate="0" +twoDigitDate;
                
                var month = fullDate.getMonth()+1;
                var day = fullDate.getDate();
                
                var currentDate = fullDate.getFullYear() + '-' +
                    ((''+month).length<2 ? '0' : '') + month + '-' +
                    ((''+day).length<2 ? '0' : '') + day;
                //var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + twoDigitDate ;
                //console.log(currentDate);
                
                //*** for current date in js ends
                
                //*** fetching value from view starts
                
                var mwd=$("#hidmwd").val();
                var daily="";
                if (mwd!='') {
                                daily=mwd;     
                }else{
                                daily="daily";
                }
                
                //*** fetching value from view ends
                
                var callurlwithdataStr='';
                var callurlwithdataArr=[];
        
                callurlwithdataArr.push('"_token":"'+csrf_token_data+'"');
                //searchdatastrAr.push('"pagenum":"'+pagenumdata+'"'); // for page number used in pagination
         
                //*** for filtration purpose starts
        
                if (fetchedDate=='')
                {
                                callurlwithdataArr.push('"currentDate":'+'"'+currentDate+'"');
                }
                else{
                                callurlwithdataArr.push('"currentDate":'+'"'+fetchedDate+'"');
                }
                
                if (daily!='')
                {
                                callurlwithdataArr.push('"mwd":'+'"'+daily+'"');
                }
                
                
                if (evnttypeshowflag!='')
                {
                                callurlwithdataArr.push('"evnttypeshowflag":'+'"'+evnttypeshowflag+'"');
                }
        
                 if (pro_category!='')
                {
                                callurlwithdataArr.push('"category":'+'"'+pro_category+'"');
                }
                
                if (pro_genre!='')
                {
                                 callurlwithdataArr.push('"genre":'+'"'+pro_genre+'"');
                }
        
        
        
                //*** for filtration purpose ends
         
                if (callurlwithdataArr.length>0)
                {
                                callurlwithdataStr=callurlwithdataArr.toString();
                }
                // console.log(searchdatastr.length+"=searchdata=>"+searchdatastr);
        
                var callurlwithdataObj=JSON.parse("{"+callurlwithdataStr+"}");        
                // console.log("=searchdata=>"+JSON.stringify(searchdatastrObj));
       
                var callurlwithdata=callurlwithdataObj;

                var callingurl=base_url_data+"/callrosterleftpanel";
                
                $.ajax({
                                url:callingurl,
                                type:'POST',
                                dataType:'json',
                                data:callurlwithdata,
                                success:function(d){
                                                //***************** Check response starts
                                                
                                                //console.log(d);
                                                respdata=d.respdata;
                                                //console.log(respdata);
                                                $("#rosterleftlistresponseid").html(respdata);
                                                
                                                //***************** Check response ends

                                                $('.gig_request').click(function(){
                                                                var chkreviewcustpop = $(this).hasClass('reviewcustpop');
                                                                if (chkreviewcustpop == true) {
                                                                reviewfunc($(this).data("id"),$(this).data("typo"),$(this).data("gigid"));
                                                                    //$('#reviewPopup').modal('show');
                                                                }else{
                                                                                var giguniqueid=$(this).data("id");
                                                                                var gigtype=$(this).data("gigtype");
                                                                                var bookerorartist=$(this).data("bkrorart");
                                                                                var gigid=$(this).data("gigid");
                                                                                var gigprotypo=$(this).data("typo");
                                                                                if (gigtype==1) {
                                                                                                if (bookerorartist =='booker') {
                                                                                                                //console.log("I am here booker");
                                                                                                                rosterleftnesteddata(gigid,gigprotypo);
                                                                                                                //alert('nestdata');
                                                                                                }
                                                                                                else{
                                                                                                                rosterleftlistitemmodal('',giguniqueid);
 //rosterleftnesteddata(gigid,gigprotypo);                                                                                                               //console.log("I am here artist");
                                                                                                }
                                                                                }
                                                                                else{
                                                                                                rosterleftlistitemmodal('',giguniqueid);
                                                                                }             
                                                                }
                                                });
                                                
                                                //**** calling function to show modal for roster left list item detail ends
                                                
                                                
                                                $('.marginleft25').click(function(){
                                                                
                                                                var bidId=$(this).data("bidid");
                                                                var gigunid=$(this).data("id");
                                                                
                                                                rosterleftlistitemmodal(bidId,gigunid);
                                                                //alert(bidId+" Dhiman "+gigunid);
                                                });
                                }
                });           
}

function reviewfunc(gig_uniqueid,typo,gigid) {
                var callingurlre = base_url_data+"/reviewmodal";
                var callurlwithdatare ={_token:csrf_token_data,'gig_uniqueid':gig_uniqueid,'loginid':logID,'typo':typo,'gigid':gigid};

                $.ajax({
                                url:callingurlre,
                                type:'POST',
                                dataType:'json',
                                data:callurlwithdatare,
                                success:function(d)
                                {
                                                
                                                
                                                console.log(d);
                                                
                                                if (d.returnflag == '1') {
                                                $('#review_div_open').html(d.respdata);
                                                $('.rateStar').rating({
                                                min: 0,
                                                max: 5,
                                                step: 1,
                                                size: 'sm',
                                                showClear: false
                                                });
                                                $('#reviewPopup').modal('show').fadeIn(100,function(){
                                                
                                                $("#submitreview").click(function(){

                                                                var performance = $(".performance").val();
                                                                var presentation = $(".presentation").val();
                                                                var punctuality = $(".punctuality").val();
                                                                
                                                                var review_description = $("#review_description").val();
                                                                
                                                                if (usr_typ == 'booker') {
                                                                                //var callurlwithdatare ={_token:csrf_token_data,'performance':performance,'presentation':presentation,'punctuality':punctuality,'review_description':review_description,'review_flag_type':review_flag_type,'gig_uniqueid':gig_uniqueid,'loginid':logID,'usr_typ':usr_typ};
                                                                                var callurlwithdatare ={_token:csrf_token_data,'bkr_hospitality':performance,'bkr_environment':presentation,'bkr_readiness':punctuality,'review_description':review_description,'review_flag_type':review_flag_type,'gig_uniqueid':gig_uniqueid,'loginid':logID,'usr_typ':usr_typ,'review_flag_type':review_flag_type};
                                                                }else if (usr_typ == 'artist') {
                                                                                var callurlwithdatare ={_token:csrf_token_data,'performance':performance,'presentation':presentation,'punctuality':punctuality,'review_description':review_description,'review_flag_type':review_flag_type,'gig_uniqueid':gig_uniqueid,'loginid':logID,'usr_typ':usr_typ};
                                                                                //var callurlwithdatare ={_token:csrf_token_data,'bkr_hospitality':performance,'bkr_environment':presentation,'bkr_readiness':punctuality,'review_description':review_description,'review_flag_type':review_flag_type,'gig_uniqueid':gig_uniqueid,'loginid':logID,'usr_typ':usr_typ,'review_flag_type':review_flag_type};
                                                                }
                                                                
                                                                $("#reviesubmit_form").validate({
                                                                                
                                                                                
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
                                                                                
                                                                                
                                                                            rules: {
                                                                                            review_description:{
                                                                                            required: true,
                                                                                            maxlength: 250,
                                                                                            }     
                                                                            },
                                                                            messages: {
                                                                                            review_description:{
                                                                                            required: "Review description should not me empty",
                                                                                            maxlength: "Review description should not me above 250",
                                                                                            }   
                                                                            }
                                                                });
                                                                
                                                                var reviesubmit_form_validation =  $("#reviesubmit_form").valid();
                                                                if(reviesubmit_form_validation === true)
                                                                {
                                                                //console.log(callurlwithdatare);
                                                                
                                                                var callingurlre = base_url_data+"/reviesubmit";
                                                                $.ajax({
                                                                                url:callingurlre,
                                                                                type:'POST',
                                                                                dataType:'json',
                                                                                data:callurlwithdatare,
                                                                                success:function(d){
                                                                                                console.log(d.return_flag);
                                                                                                if (d.return_flag == '1') {
                                                                                                                poptriggerfunc(msgtype='success',titledata='',msgdata=d.message,sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                                                                                                $('#reviewPopup').modal('hide');
                                                                                                    
                                                                                                    
                                                                                                                //********** refresh calender and left panel start *****//
                                                                                                                var newdefdt=selecteddate;            
                                                                                                                $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar            
                                                                                                                renderCustCalendarRoster(newdefdt); // call  and reinitialize calendar
                                                                                                                callleftlistbycurdt();
                                                                                                                //********** refresh calender and left panel end *****//
                                                                                                                    
                                                                                                                    
                                                                                                }else if (d.return_flag == '0') {
                                                                                                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.message,sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                                                                                }
                                                                                }
                                                                });
                                                                
                                                                }

                                                                
                                                });

                                                $("#cancelreview").on("click", (function () {
                                                                $('#reviewPopup').modal('hide');
                                                }));
                                                                
                                                }); 

                                                }else if (d.returnflag == '0') {
                                                                
                                                         poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');       
                                                    
                                                }
                                                

                                }
                });
}


function rosterleftnesteddata(gigid,gigprotypo)
{
                //nestedflag = 1;
                
                var callurlwithdataStr='';
                var callurlwithdataArr=[];
                
                callurlwithdataArr.push('"_token":"'+csrf_token_data+'"');
                
                if (gigid!='')
                {
                                callurlwithdataArr.push('"gigid":'+'"'+gigid+'"');
                }
                
                if (gigprotypo!='')
                {
                                callurlwithdataArr.push('"gigprotypo":'+'"'+gigprotypo+'"');
                }
                
                if (callurlwithdataArr.length>0)
                {
                                callurlwithdataStr=callurlwithdataArr.toString();
                }
                
                var callurlwithdataObj=JSON.parse("{"+callurlwithdataStr+"}");
                
                var callurlwithdata=callurlwithdataObj;

                var callingurl=base_url_data+"/callrosterleftnestedpanel";
                
                $.ajax({
                                url:callingurl,
                                type:'POST',
                                dataType:'json',
                                data:callurlwithdata,
                                success:function(d){
                                                //***************** Check response starts
                                            
                                var ep_contents=d.ep_contents;
                                
                                var respdata=d.respdata;
                               // console.log(respdata);
                                var nestdivid='rosterleftnestedlistresponseid_'+gigid;
                                
                               // console.log("=nestdivid=> "+nestdivid);

                                $("#gigrosterDiv").html(ep_contents);
                                $('#myRosterGigModal').modal('show');

                                //******** for open and closing of location field starts here
                                    $('#clickme').click(function(){
                                    $( ".new-location" ).toggle();
                                    $(this).parent().toggleClass('clickBorder');
                                    $('.new-location').find('.form-control:eq(0)').focus();
                                    });
                                    $('.closeLoc').click(function(){
                                    $(".new-location").toggle();
                                    $(".reqField").removeClass('clickBorder');
                                    }); 

                                //******** for open and closing of location field ends here
                                
                                
                                //setTimeout(function(){
                                //  
                                //$("#"+nestdivid).html(respdata);
                                //                //***************** Check response ends
                                //                
                                //                
                                //                //**** calling function to show modal for roster left list nested item detail starts
                                //                
                                //                var hidbidid=$('#hidbidid').val();
                                //                var idi="bidbid_"+hidbidid;
                                //                
                                //                //****************previous code 13/08/16 start***************//
                                //                //$('.gig_request').click(function(){
                                //                //$('#'+idi).click(function(){
                                //                //                
                                //                //                var gigunid=$(this).data("id");
                                //                //                //rosterleftlistitemmodal(hidbidid,gigunid);
                                //                //                alert("Dhiman"+hidbidid);
                                //                //});
                                //                //****************previous code 13/08/16 end***************//
                                //                
                                //                //****************code 13/08/16 by dhiman start***************//
                                //                $('.marginleft25').click(function(){
                                //                                
                                //                                var bidId=$(this).data("bidid");
                                //                                var gigunid=$(this).data("id");
                                //                                
                                //                                rosterleftlistitemmodal(bidId,gigunid);
                                //                                //alert(bidId+" Dhiman "+gigunid);
                                //                });
                                //                //****************code 13/08/16 by dhiman end***************//
                                //
                                //                //**** calling function to show modal for roster left list nested item detail ends
                                //
                                //}, 100);



            
                                                
                                                





                                }
                });
                //$('.viewgig').click(function(){alert(gigid);});
}


       function getallrosterCategory(){
        var categorydata = {_token:csrf_token_data};
        var urldata=base_url_data+"/getrostergetcategory";
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
                    $("#Category_roster").html(catHtml);
                    $("#Category_roster").selectpicker('refresh').fadeIn(100,function(){
                        
                            $( "#Category_roster" ).change(function() {
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
                                //loadGigGuideLeftPannel();
                                callleftlistbycurdt();
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
                                                       callleftlistbycurdt();                                     
                                                    
                                                    
                                                });
                                                
                                            });
                                        }
                                        
                                });

                            });
                            
                        });
                }
        });
}







//****** functions to call ajax ends
             
