function upload_menu(myformid,outputdivid) 
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
              $("#profsldroutrdivid").html(slider_contents);
              
              bindimagedelclick();
              
            
             //*** slider now starts         
 
              ////get carousel instance data and store it in variable owl
              //  var owl = $(".profile_slider").data('owlCarousel');     
              //  
              //  owl.destroy();
              //  
              //  var newOptions={
              //  loop:false,
              //  margin:0,
              //  items:1,
              //  nav:true,
              //  dots:false
              //  
              //  };
              //  
              //  $('.profile_slider').owlCarousel(newOptions);              
                
             //*** slider now ends
             
             //****** for binding with  user image slider on change of slider starts 
                    var owl = $('.owl-carousel');
               
                     owl.owlCarousel({callbacks: true});
                
                     owl.on('changed.owl.carousel', function(event) {
                  
                    var totalItems = $('.item').length;
                     //console.log("len=>"+totalItems);
                
                    var currentitemnmbr=event.item.index;
                    var curritemnum=currentitemnmbr+1; // current item number without starting  from 0 ,  if current index is o then , curr photo is 0+1=1 , if 1 then 1+1=2
                  
                     showhideprevnextimgslider(totalItems,curritemnum) ;                  
               
                     });
               //****** for binding with  user image slider on change of slider ends
               
               var totalItems = $('.item').length; var curritemnum=1;
               showhideprevnextimgslider(totalItems,curritemnum);
             
             
              $(".userimgupldcls").click(function(){
                                         
                                         // console.log("file control");		
                                         $("#image_name").trigger("click");
                                         
                                         });
             
              $("#progress_div").fadeOut(2500);
             
             
              toastr.remove();// Immediately remove current toasts without using animation
			  poptriggerfunc(msgtype='success',titledata='',msgdata="Venue menu uploaded successfully",sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-bottom-right');
         
              
              //** change image on header starts
              
              // var default_image_name=d.default_image_name;
              //                      
              //var imagepthnew=base_url_data+"/front/otherfiles/progimages/"+"noimagefound52X52.jpg";
              //                           
              //if (default_image_name!='')
              //{
              //      imagepthnew=base_url_data+"/upload/userimage/thumb-small/"+default_image_name;                                             
              //}
              //                          
              //
              // var imagepthnew=base_url_data+"/upload/userimage/thumb-small/"+default_image_name;
              //$("#myprodileimgicon").find("img").attr("src",imagepthnew);
              //
              //** change image on header ends
         
         }
         else if (flagdta==0)
         {
            
             $("#progress_div").fadeOut(2500);
             toastr.remove();// Immediately remove current toasts without using animation
			 poptriggerfunc(msgtype='error',titledata='',msgdata=errorespmsg,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right'); 
			  
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