$('.rider_btn').click(function(){

                var callingurl=base_url_data+"/"+"ridershow";
                var callurlwithdata={_token:csrf_token_data,ridervalue:ridervalue,rider_type:rider_type};
                
                $.ajax({
                     url:callingurl,
                     data:callurlwithdata,
                     type:'POST',
                     dataType:'JSON',
                     success:function(d){
                          
                
                          if (d.return_type=='1') {
                                $(".myRiderShow").html(d.ep_contents);
                                $('#myRider').modal('show');
                          }
                          
                          
                          
                     }
                     
                });
});