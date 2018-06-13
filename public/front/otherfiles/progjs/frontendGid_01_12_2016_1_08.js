jQuery(document).ready(function(){
  $('#myModalPostAGig').click(function(){
    var callingurl=base_url_data+"/loadgigpostmodal";
    var callurlwithdata={_token:csrf_token_data};
    
    var cmsgdata="...";         
      
    if (logID!='') {
     $.ajax({
       
       url:callingurl,
       type:'POST',
       dataType:'json',
       data:callurlwithdata,
       success:function(d){
            

                           var ep_contents=d.ep_contents;
                           $("#ShowGigPost").html(ep_contents);
                           
                           setTimeout(function(){
                            //$('#clickme1').trigger('click', function() {
                            //
                            //});
                            //$('#clickme1').trigger('click');
                           }, 500);
                           
                           
                           $('#myModal6').modal('show');

                           footerarea_css();
                            

        
       }
       
      });
    }else{
      poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
    }
  });

});


//$("#clickme1").on("click", (function () {
//  alert("ghj");
//    //$( ".new-location" ).toggle();
//    //$(this).parent().toggleClass('clickBorder');
//    //$('.new-location').find('.form-control:eq(0)').focus();
//  }));