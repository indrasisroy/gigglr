
function rosterleftlistitemmodal(gigid,gig_request_id){
    var callingurl=base_url_data+"/loadgigrostermodal";
    var callurlwithdata={_token:csrf_token_data,gig_request_id:gig_request_id,bidreqstId:gigid};
    
    var cmsgdata="...";         
      
    if (logID!='') {
     $.ajax({
       
       url:callingurl,
       type:'POST',
       dataType:'json',
       data:callurlwithdata,
       success:function(d){
            toastr.remove();
            if(d.flag == '1'){
                var ep_contents=d.ep_contents;
                $("#gigrosterDiv").html(ep_contents);
                
                setTimeout(function(){


                   $('#clickme').click(function(){
                  $( ".new-location" ).toggle();
                  $(this).parent().toggleClass('clickBorder');
                  $('.new-location').find('.form-control:eq(0)').focus();
                  });
                  $('.closeLoc').click(function(){
                  $(".new-location").toggle();
                  $(".reqField").removeClass('clickBorder');
                  });
    
                }, 500);
                
                
                $('#myRosterGigModal').modal('show');
    
                footerarea_css(); 
            }else{
                if (d.type == '1') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                }else if (d.type == '2') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                }else if (d.type == '3') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                }else if (d.type == '4') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                }else if (d.type == '5') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                }else if (d.type == '6') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                }
                
            }

                            
  
        
       }
       
      });
    }else{
      poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
    }
  }
//****script for modal open and close starts
                  // $('#clickme').click(function(){
                  // $( ".new-location" ).toggle();
                  // $(this).parent().toggleClass('clickBorder');
                  // $('.new-location').find('.form-control:eq(0)').focus();
                  // });
                  // $('.closeLoc').click(function(){
                  // $(".new-location").toggle();
                  // $(".reqField").removeClass('clickBorder');
                  // });
//****script for modal open and close ends