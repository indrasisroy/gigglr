//***** document.ready starts
            
$(document).ready(function(){
                
                callleftlistbycurdt();
                
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
	
});

//****** document.ready ends




//****** functions to call ajax starts

function callleftlistbycurdt() {
                //*** for current date in js starts
                
                var fullDate = new Date();
                //console.log(fullDate);
                var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
                var twoDigitDate = fullDate.getDate()+"";if(twoDigitDate.length==1)	twoDigitDate="0" +twoDigitDate;
                var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + twoDigitDate ;
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
                                                
                                                
                                                //**** calling function to show modal for roster left list item detail starts
                                                
                                                $('.gig_request').click(function(){
                                                                var giguniqueid=$(this).data("id");
                                                                var gigtype=$(this).data("gigtype");
                                                                var bookerorartist=$(this).data("bkrorart");
                                                                var gigid=$(this).data("gigid");
                                                                if (gigtype==1) {
                                                                                if (bookerorartist=='booker') {
                                                                                                rosterleftnesteddata(gigid);
                                                                                }
                                                                                else{
                                                                                                rosterleftlistitemmodal(giguniqueid);      
                                                                                }
                                                                }
                                                                else{
                                                                                rosterleftlistitemmodal(giguniqueid);
                                                                }
                                                });
                                                
                                                //**** calling function to show modal for roster left list item detail ends
                                }
                });           
}


function rosterleftnesteddata(gigid) {
                
                var callurlwithdataStr='';
                var callurlwithdataArr=[];
                
                callurlwithdataArr.push('"_token":"'+csrf_token_data+'"');
                
                if (gigid!='')
                {
                                callurlwithdataArr.push('"gigid":'+'"'+gigid+'"');
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
                                                
                                                //console.log(d);
                                                respdata=d.respdata;
                                                console.log(respdata);
                                                var nestdivid='rosterleftnestedlistresponseid_'+gigid;
                                                $("#"+nestdivid).html(respdata);
                                                
                                                //***************** Check response ends
                                                
                                                
                                                //**** calling function to show modal for roster left list nested item detail starts
                                                
                                                $('.gig_request').click(function(){
                                                                var gigbidid=$(this).data("id");
                                                                rosterleftlistitemmodal(gigid,gigbidid);
                                                });
                                                
                                                //**** calling function to show modal for roster left list nested item detail ends
                                }
                }); 
}

//****** functions to call ajax ends
             
