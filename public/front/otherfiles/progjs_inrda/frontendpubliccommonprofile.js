$('.rider_btn').click(function(){

                var callingurl=base_url_data+"/"+"ridershow";
                var callurlwithdata={_token:csrf_token_data,ridervalue:ridervalue,rider_type:rider_type};
                
                $.ajax({
                     url:callingurl,
                     data:callurlwithdata,
                     type:'POST',
                     dataType:'JSON',
                     success:function(d){

                        if(rider_type=='view'){
                          if (d.return_type=='1') {
                                $(".myRiderShow").html(d.ep_contents);
                                $('#myRider').modal('show');

                                //console.log("111");
                          }
                        }else{

                             //console.log("222");
                          if (d.return_type=='1') {
                                $(".myRiderShow").html(d.ep_contents);

                                $('#myRider').modal('show').fadeIn(100,function(){

                                        $('#booking_opt_but_rider').click(function(){

                                                  var ridertxt = $('#rider_txt').val();
                                                  //alert(ridertxt);

                                                  $("#riderfrm_frmid").validate({
                                        errorClass: "authError",
                                        errorElement: 'span',
                                     
                                                        rules: {
                                                                rider_txt: {
                                                                required: true,
                                                                maxlength:250,
                                                                },
                                                            },
                                               
                                                            messages: {

                                                                rider_txt: {
                                                                required: "Rider can not be empty",
                                                                maxlength: "Maximum 250 characters are allowed"
                                                                },
                                                            },
                                                 });

                                                        var chkridervalidation =  $("#riderfrm_frmid").valid();
                                                        if(chkridervalidation === true)
                                                        {
                                                            //****
                                                        var callingurlrider=base_url_data+"/"+"ridersave";
                                                        var callurlwithriderdata={_token:csrf_token_data,ridervalue:ridertxt,usertype:usertype,profilehiddenid:profilehiddenid};
                                                      //  tostar.remove();
                                                        $.ajax({
                                                        url:callingurlrider,
                                                        data:callurlwithriderdata,
                                                        type:'POST',
                                                        dataType:'JSON',
                                                        success:function(d){
                                                              // console.log(d.error_message.ridervalue);
                                                              // alert(d.error_message);

                                                               // console.log(d.error_message);

                                                                if(d.return_flag == '1')
                                                                {
                                                                     poptriggerfunc(msgtype='success',titledata='',msgdata='Rider updated successfully',sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                                                                      $('#myRider').modal('hide');
                                                                      ridervalue = ridertxt;
                                                                }else if(d.return_flag == '0')
                                                                {
                                                                   // console.log(d.error_message.ridervalue);
                                                                 //   alert(d.error_message);
                                                                     poptriggerfunc(msgtype='error',titledata='',msgdata=d.error_message.ridervalue,sd=1000,hd=10000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                                                                     // $('#myRider').modal('hide');
                                                                }
                                                               

                                                        }

                                                            });
                                                            //****
                                                        }

                                             });

                                     });
                              
                                
                                //console.log(usertype+"          ==============================                 "+profilehiddenid);
                          }

                        }

                          
                          
                          
                     }
                     
                });
});