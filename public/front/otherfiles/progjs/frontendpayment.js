function callpaymenttowallet()
{
    var price=$("#price").val();
    
    
        
        var inputstr='';
                
        var searchdatastr='';
        var searchdatastrAr=[];
        searchdatastrAr.push('"_token":"'+csrf_token_data+'"');
        searchdatastrAr.push('"price":"'+price+'"'); 
      
        
        //if (price=='')
        //{
        //    alert(" Provide amount ");
        //    return false;
        //}
        
        console.log(price);
         
        if (searchdatastrAr.length>0)
        {
            searchdatastr=searchdatastrAr.toString();
        }
        
       // console.log(searchdatastr.length+"=searchdata=>"+searchdatastr);
        
        var searchdatastrObj=JSON.parse("{"+searchdatastr+"}");        
       // console.log("=searchdata=>"+JSON.stringify(searchdatastrObj));
       
        var searchdata=searchdatastrObj;        
        
        var mainsearchposturl=base_url_data+"/paytowallet";
       
        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
        showmycustomloader(1,'','',"",imfpth);
        
        
        //** ajax call starts here
        
          
        
        $.ajax({
            
            data:searchdata,
            dataType:"json",
            type:"POST",
            url:mainsearchposturl,
            success:function(d){
                
                var flagdata=d.flagdata;
                var error_message=d.error_message;
                var tot_wallet_amount=d.tot_wallet_amount;
                
                toastr.remove();// Immediately remove current toasts without using animation
      		
               // alert("=flagdata=>"+flagdata+"--errordata=>"+error_message);
                if(flagdata==0)
                {
                    var error_message_data='';
                    if (error_message!=null)
                    {
                        for (ermsgkey in error_message)
                        {
                              error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                        }
                    }
                    poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');          

                }
                else if(flagdata==1)
                {
                    $("#wallet_amount_id").html("You have $"+tot_wallet_amount);
                    $("#price").val('');
                    poptriggerfunc(msgtype='success',titledata='',msgdata=" Payment done successfully",sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-top-full-width');
                                                                             
                }
                 var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                 showmycustomloader(0,'','',"",imfpth);
               
                 
            }
            
            
            });
            //** ajax call ends here
        
    
    
}

$(document).ready(function(){
    
    $("#paybuttonid").click(function(){
      
      //*** call confirm box starts
        
        $.confirm({
                                title: 'Confirm!',
                                content: 'Are you sure , you want to proceed !',
                                confirmButton: 'Yes',
                                cancelButton: 'No',
                                confirmButtonClass: 'btn-success',
                                cancelButtonClass: 'btn-danger',
                                closeIcon: false,
                                backgroundDismiss: false,
                                theme:'material',
                                confirm: function(){
                                         //$.alert('Confirmed!');
                                         
                                         callpaymenttowallet();
                                         
                                         
                                },
                                cancel: function(){
                                         //$.alert('Canceled!')
                                }
                });
        
        //*** call confirm box ends
      
       
       
        
        });
    
    });