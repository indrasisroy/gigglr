
var showmodalflag=0;
var submitvalueflag = 0;
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
       // alert(d.flag);
            toastr.remove();
            if(d.flag == '1'){
                var ep_contents=d.ep_contents;
                $("#gigrosterDiv").html(ep_contents);


              // console.log(d.ep_contents);

               // console.log(d);
                // setTimeout(function(){
                  
                //    $('[data-toggle="tooltip"]').tooltip();

                //   $('#clickme').click(function(){
                //   $( ".new-location" ).toggle();
                //   $(this).parent().toggleClass('clickBorder');
                //   $('.new-location').find('.form-control:eq(0)').focus();
                //   });
                //   $('.closeLoc').click(function(){
                //   $(".new-location").toggle();
                //   $(".reqField").removeClass('clickBorder');
                //   });

                //   $("#revertbacktofive").click(function(){
                    

                //       setTimeout(function(){
                //       $('#myRosterGigModal').modal('show');
                //        },1000) 
                //        $('#myModal_6').modal("hide");
                   

                //   });

                //       $("#revertbacktosix").click(function(){
                        
                         
                //          $('#myModal_7').modal("hide");
                //         setTimeout(function(){
                //           $('#myModal_6').modal('show');
                //            },1000) 

                //       });

                //           $("#revertbacktoseven").click(function(){

                             
                //               $('#myModal_8').modal('hide');
                //               setTimeout(function(){
                //               $('#myModal_7').modal('show');
                //                },1000) 

                //           });



    
                // }, 500);
                
                setTimeout(function(){

                $('[data-toggle="tooltip"]').tooltip();
                
                $('#reqmodal1').modal('show');


                $('#reqmodal1').on('hidden.bs.modal', function () { 

                    if(showmodalflag==2)
                    {
                     $('#reqmodal2').modal('show');
                    }

                 });

                $('#reqmodal2').on('hidden.bs.modal', function () { 

                  if(showmodalflag==3)
                    {
                   $('#reqmodal3').modal('show');
                      }
                    else  if(showmodalflag==1)
                    {
                   $('#reqmodal1').modal('show');
                      }

                 });
               $('#reqmodal3').on('hidden.bs.modal', function () { 

                  if(showmodalflag==4)
                    {
                 $('#reqmodal4').modal('show');
                      }
                       else  if(showmodalflag==2)
                    {
                   $('#reqmodal2').modal('show');
                      }

                 });

               $('#reqmodal4').on('hidden.bs.modal', function () { 

                if(showmodalflag==3)
                    {
                 $('#reqmodal3').modal('show');
                      }

                 });


               $("#reqmodalnextbutn1").bind('click',function(){

                   showmodalflag=2;
                   $('#reqmodal1').modal('hide');

               });

               $("#reqmodalnextbutn2").bind('click',function(){

                  showmodalflag=3;
                   $('#reqmodal2').modal('hide');
                
               });


               $("#reqmodalnextbutn3").bind('click',function(){

                showmodalflag=4;
                 $('#reqmodal3').modal('hide');
               //  console.log("here");


               //********************* validation starts here

               var textspec_val = $("#gig_description").val();
              // console.log("textspec_val is "+textspec_val);

              if(textspec_val == '')
              {
                 submitvalueflag=0;
                 $("#submittrueorflase").val(submitvalueflag);
                $("#gig_description").parent().addClass('errorField');
              }else
              {
                 submitvalueflag=1;
                 $("#submittrueorflase").val(submitvalueflag);
                 $("#gig_description").parent().removeClass('errorField');
              }
               //********************* validation ends here 
                
               });
                $("#reqmodalpreviousbutn4").bind('click',function(){

                showmodalflag=3;
                 $('#reqmodal4').modal('hide');

                
               });

               $("#reqmodalpreviousbutn3").bind('click',function(){

                showmodalflag=2;
                 $('#reqmodal3').modal('hide');

                
               });
                $("#reqmodalpreviousbutn2").bind('click',function(){

                showmodalflag=1;
                 $('#reqmodal2').modal('hide');

                
               });



               
              }, 500); 



    
                footerarea_css(); 
            }else{
                if (d.type == '1') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                }else if (d.type == '2') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                }else if (d.type == '3') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                }else if (d.type == '4') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                }else if (d.type == '5') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                }else if (d.type == '6') {
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                }
                
            }

                // $('#clickme').click(function(){
                //   $( ".new-location" ).toggle();
                //   $(this).parent().toggleClass('clickBorder');
                //   $('.new-location').find('.form-control:eq(0)').focus();
                //   });
                //   $('.closeLoc').click(function(){
                //   $(".new-location").toggle();
                //   $(".reqField").removeClass('clickBorder');
                //   });            
  
        
       }
       
      });
    }else{
      poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
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