  $(".myfavorite").on("click", (function () {
    
    var likeFlag = 1;
    if (logID!='') {
      var userid = $(this).data("userid");
      var usertype = $(this).data("usertype");
      if (userid==logID) {
        var msg = "Sorry!!! you can't like your own profile";
       poptriggerfunc(msgtype='error',titledata='',msgdata=msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width'); 
      }else{
            var callingurl=base_url_data+"/savemyfavorite";
            var callurlwithdata={_token:csrf_token_data,logID:logID,likeFlag:likeFlag,userid:userid,usertype:usertype};
           
            $.ajax({
            
              url:callingurl,
              type:'POST',
              dataType:'json',
              data:callurlwithdata,
              success:function(d){
              toastr.remove();
              if (d.flag == '1') {
                if (d.lastStatus == '1'){
                  $(".myfavorite").addClass( "proflhearbuttonactv" );
                }else{
                  $(".myfavorite").removeClass( "proflhearbuttonactv" );
                }
                 poptriggerfunc(msgtype='success',titledata='',msgdata=d.msg,sd=2000,hd=2500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                //alert(d.msg+d.lastStatus);
              }else{
                
                poptriggerfunc(msgtype='error',titledata='',msgdata=msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width'); 
              }
              
              
              }
            
            });
      }
    }else{
      toastr.remove();
       var msg = "Please login to continue";
       poptriggerfunc(msgtype='error',titledata='',msgdata=msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width'); 
    }
    
  }));
  CharacterCountartist = function(){
                                var myField = document.getElementById('gig_description');
                                var myLabel = document.getElementById('fieldtocountbookingartist');
                                var myErrLabel = document.getElementById('CharCountLabelartistbooking');
                                if(!myField || !myLabel){return false;} // catches errors
                                var MaxChars =  myField.maxLengh;
                                if(!MaxChars){MaxChars =  myField.getAttribute('maxlength'); }    if(!MaxChars){return false;}
                                var remainingChars =   MaxChars - myField.value.length;
                                myErrLabel.innerHTML = remainingChars+" Characters Remaining of Maximum "+MaxChars;
                };
 
                setInterval(function(){
                    CharacterCountartist('gig_description','CharCountLabelartistbooking')},0); 