function upload_presskit(myformid,outputdivid) 
{
  var bar = $('#bar');
  var percent = $('#percent');
  $('#'+myformid).ajaxForm({
    beforeSubmit: function(arr, $form, options) {
      
     
      //document.getElementById("progress_div").style.display="block";
      //var percentVal = '0%';
      //bar.width(percentVal)
      //percent.html(percentVal);
      
    },

    uploadProgress: function(event, position, total, percentComplete) {
      
      //console.log("==total==>"+total+"==position=>"+position+"==percentComplete==>"+percentComplete);
      //var percentVal = percentComplete + '%';
      //bar.width(percentVal)
      //percent.html(percentVal);
    },
    dataType:'json',
    
	success: function(d) {
      
      
      var percentVal = '100%'; 
      
      bar.width(percentVal)
      percent.html(percentVal);
      
       
      
      if (d!=null)
      {
         var errorespmsg=d.errorespmsg;
         var flagdta=d.flag;
         var slider_contents=d.slider_contents;
         var default_image_name=d.default_image_name;
        //myprodileimgicon
         
        //console.log("======flagdta==>"+flagdta);
         
         if (flagdta==1)
         {
              toastr.remove();// Immediately remove current toasts without using animation
			  poptriggerfunc(msgtype='success',titledata='',msgdata="Press kit uploaded successfully",sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
         
              
         
         }
         else if (flagdta==0)
         {
            
             $("#progress_div").fadeOut(2500);
             toastr.remove();// Immediately remove current toasts without using animation
			 poptriggerfunc(msgtype='error',titledata='',msgdata=errorespmsg,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width'); 
			  
         }
         
         
         
      }
      
      
    },

    complete: function(xhr) {
      if(xhr.responseText)
      {
             // document.getElementById(outputdivid).innerHTML=xhr.responseText;
      }
    }
    
    
    
  }); 
}