function upload_image(myformid, outputdivid) {
    $("#groupprogressbar").removeClass('mydiplaymoneadmin');
    var bar = $('#bar');
    var percent = $('#percent');
    $('#' + myformid).ajaxForm({
        beforeSubmit: function(arr, $form, options) {

            //alert("bokaa");

            document.getElementById("progress_div").style.display = "block";
            var percentVal = '0%';
            bar.width(percentVal)
            percent.html(percentVal);

        },

        uploadProgress: function(event, position, total, percentComplete) {

            //console.log("==total==>"+total+"==position=>"+position+"==percentComplete==>"+percentComplete);
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        dataType: 'json',

        success: function(d) {


            var percentVal = '100%';

            bar.width(percentVal)
            percent.html(percentVal);



            if (d != null) {
                var errorespmsg = d.errorespmsg;
                var flagdta = d.flag;
                var slider_contents = d.slider_contents;
                var default_image_name = d.default_image_name;
                var totalimagepresentnow = d.totlalfilepresent;
              
               // console.log("======flagdta==>" + d.getuservenueimgallAr);
               //  console.log("======flagdta==>" + d.totlalfilepresent);
               //  console.log("======flagdta==>" + d.default_image_name);
               // $("#showuserimageanchr").html(d.getuserimgallAr);
               //  if(totalimagepresentnow == 3 || totalimagepresentnow > 3){

               //      $("#usrtotalimage").addClass('mydiplaymoneadmin');

               //  }else if(totalimagepresentnow > 0 && totalimagepresentnow < 3 ) {

               //       $("#usrtotalimage").removeClass('mydiplaymoneadmin');
               //  }

                if (flagdta == 1) {
                    
                     $("#showusergroupimageanchr").html(d.getuservenueimgallAr);
                if(totalimagepresentnow == 3 || totalimagepresentnow > 3){

                    $("#grouptotalimage").addClass('mydiplaymoneadmin');

                }else if(totalimagepresentnow > 0 && totalimagepresentnow < 3 ) {

                     $("#grouptotalimage").removeClass('mydiplaymoneadmin');
                }





                    $(".userimgupldcls").click(function() {

                        // console.log("file control");   
                        $("#image_name").trigger("click");

                    });

                    $("#progress_div").fadeOut(2500);
                    $("#groupprogressbar").addClass('mydiplaymoneadmin');

                    toastr.remove(); // Immediately remove current toasts without using animation
                    poptriggerfunc(msgtype = 'success', titledata = '', msgdata = "Image added successfully", sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');


                    //** change image on header starts

                    var default_image_name = d.default_image_name;

                    var imagepthnew = admin_base_url_data + "/public/front/otherfiles/progimages/" + "noimagefound52X52.jpg";

                    if (default_image_name != '') {
                        imagepthnew = admin_base_url_data + "/public/upload/userimage/thumb-small/" + default_image_name;
                    }


                    // var imagepthnew=admin_base_url_data+"/public/upload/userimage/thumb-small/"+default_image_name;
                    $("#myprodileimgicon").find("img").attr("src", imagepthnew);

                    //** change image on header ends

                } else if (flagdta == 0) {
                  //  alert('hello');

                    $("#progress_div").fadeOut(2500);
                    $("#groupprogressbar").addClass('mydiplaymoneadmin');
                    $("#showusergroupimageanchr").removeClass('mydiplaymoneadmin');
                    toastr.remove(); // Immediately remove current toasts without using animation
                    poptriggerfunc(msgtype = 'error', titledata = '', msgdata = errorespmsg, sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');

                }



            }


        },

        complete: function(xhr) {
            if (xhr.responseText) {
                // document.getElementById(outputdivid).innerHTML=xhr.responseText;
            }
        }



    });
}