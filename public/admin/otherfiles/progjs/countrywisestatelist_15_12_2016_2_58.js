$(document).ready(function() {
    // var usrststest = user_ststus_chk;
    // if(usrststest!=1)
    // {
    // 	$('#useraddfrmid').attr('readonly', 'readonly');
    // 	$('#uservenueaddfrmid').attr('readonly', 'readonly');
    // }
    // if(usertotalimagecount!='') {
    //     if(usertotalimagecount >= 3 ){
    //         console.log('I am here');
    //     }
    // }

    var currentStep = 1;
    // var user_status = ststus_chk;
    //	console.log("user_status"+user_status);
    $('#wizardTab li a').click(function() {
        return false;
    });
    $("#prevStep").attr('style', "display:none");



    $('#wizardTab li a').click(function() {
        return false;
    });
    $("#prevStepvenue").attr('style', "display:none");


    $("#addeditcomplete").attr('style', "display:none");
    $("#addeditcompletevenue").attr('style', "display:none");

    $('#footer2').attr('style', "display:none");

    if (typeflag == 0) {
        $('.panel-tab').attr('style', "display:none");
        $('.panel-footer').attr('style', "display:none");

        $('#footer2').removeAttr('style', "display:none");
    }


    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        //startDate:'01/08/2016'	
    })
    $('#tfndiv').hide();

    //*** check if gst is yes or no and tfn block showing respect of that starts

    var gstonload = $('#gst').val();

    if (gstonload == 0) {
        $('#tfndiv').hide();
    } else {
        $('#tfndiv').show();
    }

    jQuery('#gst').on('change', function(evnt) {

        var gstchangeval = this.value;

        if (gstchangeval == 1) {
            $('#tfndiv').show('slow');
        } else {
            $('#tfndiv').hide('slow');
        }

    });

    //*** check if gst is yes or no and tfn block showing respect of that ends

    //*** populate state on selecting country  starts

    jQuery('#country_id').on('change', function(evnt) {

        var country_id = this.value;
        callurl = admin_base_url_data + '/countrywisestate';
        var snddata = {
            _token: admin_csrf_token_data,
            country_id: country_id
        }
        jQuery.ajax({
            url: callurl,
            data: snddata,
            type: "POST",
            dataType: 'JSON',
            success: function(d) {
                state_opt_html = '';

                if (d != null) {
                    $.each(d, function(idx, obj) {
                        state_opt_html += "<option value='" + obj.state_id + "'>" + obj.state_name + "</option>";
                    });
                }

                $("#state_id").html(state_opt_html);
                //	$("#state_id").selectpicker('refresh');
            }
        });
    });

    //*** populate state on selecting country  ends

    //*** populate subskill on selecting skill  starts
    //****for venue
    jQuery('#skill_id').on('change', function(evnt) {

        var skill_id = this.value;
        callurl = admin_base_url_data + '/skillwisesubskillvenue';
        var snddata = {
            _token: admin_csrf_token_data,
            skill_id: skill_id
        }
        jQuery.ajax({
            url: callurl,
            data: snddata,
            type: "POST",
            dataType: 'JSON',
            success: function(d) {
                subskill_opt_html = '';

                if (d != null) {
                    subskill_opt_html += "<option value=''>Select genre</option>";
                    $.each(d, function(idx, obj) {
                        subskill_opt_html += "<option value='" + obj.subskill_id + "'>" + obj.subskill_name + "</option>";
                    });
                }

                $("#subskill_id").html(subskill_opt_html);
                //$("#subskill_id").selectpicker('refresh');
            }
        });
    });

    //********for group
    jQuery('#skill_id_group').on('change', function(evnt) {

        var skill_id = this.value;
        callurl = admin_base_url_data + '/skillwisesubskillgroup';
        var snddata = {
            _token: admin_csrf_token_data,
            skill_id: skill_id
        }
        jQuery.ajax({
            url: callurl,
            data: snddata,
            type: "POST",
            dataType: 'JSON',
            success: function(d) {
                subskill_opt_html = '';

                if (d != null) {
                    subskill_opt_html += "<option value=''>Select genre</option>";
                    $.each(d, function(idx, obj) {
                        subskill_opt_html += "<option value='" + obj.subskill_id + "'>" + obj.subskill_name + "</option>";
                    });
                }

                $("#subskill_id_group").html(subskill_opt_html);
                //$("#subskill_id").selectpicker('refresh');
            }
        });
    });

    //*** populate subskill on selecting skill  ends

    //**********added for venue skill add and delete starts 13-08-2016
    var vnuID = $("#vnuID").val();
    var vnucreatrID = $("#vnucreatrID").val();
    jQuery('#subskill_id').on('change', function(evnt) {
        var subskillid = this.value;


        //alert(vnuID + " venuecreatrID"+vnucreatrID);

        var skillid = $('#skill_id').val();
        callurl = admin_base_url_data + '/subskillsavevenue';
        var sndata = {
            _token: admin_csrf_token_data,
            skillid: skillid,
            subskillid: subskillid,
            vnuID: vnuID,
            vnucreatrID: vnucreatrID
        }
        jQuery.ajax({
            url: callurl,
            data: sndata,
            type: "POST",
            dataType: 'JSON',
            success: function(res) {
                $("#sports_venuelist").html(res.response_data);
            }
        });
    });

    //**********added for venue skill add and delete ends 13-08-2016

    //**********added for group skill add and delete starts 13-08-2016
    var groupID = $("#groupID").val();
    var grupcreatrID = $("#grupcreatrID").val();
    jQuery('#subskill_id_group').on('change', function(evnt) {
        var subskillid = this.value;


        //alert(vnuID + " venuecreatrID"+vnucreatrID);

        var skillid = $('#skill_id_group').val();
        callurl = admin_base_url_data + '/subskillsavegroup';
        var sndata = {
            _token: admin_csrf_token_data,
            skillid: skillid,
            subskillid: subskillid,
            groupID: groupID,
            grupcreatrID: grupcreatrID
        }
        jQuery.ajax({
            url: callurl,
            data: sndata,
            type: "POST",
            dataType: 'JSON',
            success: function(res) {
                $("#group_list").html(res.response_data);
            }
        });
    });

    //**********added for group skill add and delete ends 13-08-2016



    //**********added for user skill add and delete starts 13-08-2016
    var userID = $("#userID").val();
    jQuery('#skill_id_usr').on('change', function(evnt) {

        var skill_id = this.value;
        callurl = admin_base_url_data + '/skillwisesubskillshowuser';
        var snddata = {
            _token: admin_csrf_token_data,
            skill_id: skill_id
        }
        jQuery.ajax({
            url: callurl,
            data: snddata,
            type: "POST",
            dataType: 'JSON',
            success: function(d) {
                subskill_opt_html = '';

                if (d != null) {
                    subskill_opt_html += "<option value=''>Select genre</option>";
                    $.each(d, function(idx, obj) {
                        subskill_opt_html += "<option value='" + obj.subskill_id + "'>" + obj.subskill_name + "</option>";
                    });
                }

                $("#subskill_id_usr").html(subskill_opt_html);
                //$("#subskill_id").selectpicker('refresh');
            }
        });
    });

    jQuery('#subskill_id_usr').on('change', function(evnt) {
        var subskillid = this.value;
        var skillid = $('#skill_id_usr').val();
        //alert(skillid);
        callurl = admin_base_url_data + '/skillwisesubskillsaveuser';
        var sndata = {
            _token: admin_csrf_token_data,
            skillid: skillid,
            subskillid: subskillid,
            userID: userID
        }
        jQuery.ajax({
            url: callurl,
            data: sndata,
            type: "POST",
            dataType: 'JSON',
            success: function(res) {
                $("#user_categorygenrelist").html(res.response_data);
            }
        });
    });

    //**********added for user skill add and delete ends 13-08-2016



    // $("#dateofbirth").on("dp.change", function (e) {
    // 	$('#dateofbirth').data("DatePicker").maxDate(e.date);
    // });

    $('#nextStep').click(function() {
        var usrsts = user_ststus_chk;

        currentStep++;

        if (currentStep == 2) {
            $('#wizardTab li:eq(1) a').tab('show');
            $("#prevStep").removeAttr('style', "display:none");
            $("#nextStep").removeAttr('style', "display:none");

            $('#prevStep').attr('disabled', false);
            $('#prevStep').removeClass('disabled');
        } else if (currentStep == 3) {
            $('#wizardTab li:eq(2) a').tab('show');
            $("#prevStep").removeAttr('style', "display:none");
            $("#nextStep").removeAttr('style', "display:none");


            $('#nextStep').attr('disabled', false);
            $('#nextStep').removeClass('disabled');
        } else if (currentStep == 4) {
            $('#wizardTab li:eq(3) a').tab('show');
            $("#prevStep").removeAttr('style', "display:none");
            $("#nextStep").removeAttr('style', "display:none");


            $('#nextStep').attr('disabled', false);
            $('#nextStep').removeClass('disabled');
        } else if (currentStep == 5) {
            $('#wizardTab li:eq(4) a').tab('show');
            $("#prevStep").removeAttr('style', "display:none");
            $("#nextStep").attr('style', "display:none");

            if (usrsts != 0) {

                $("#addeditcomplete").removeAttr('style', "display:none");
            }
        }

        return false;
    });
    $('#prevStep').click(function() {
        $("#addeditcomplete").attr('style', "display:none");

        currentStep--;

        if (currentStep == 1) {

            $('#wizardTab li:eq(0) a').tab('show');
            //	$('#wizardProgress').css("width","66%");

            $("#prevStep").attr('style', "display:none");
            $("#nextStep").removeAttr('style', "display:none");

            //$('#wizardProgress').css("width","33%");
        } else if (currentStep == 2) {

            $('#wizardTab li:eq(1) a').tab('show');
            //$('#wizardProgress').css("width","66%");

            $("#prevStep").removeAttr('style', "display:none");
            $("#nextStep").removeAttr('style', "display:none");



            $('#nextStep').attr('disabled', false);
            $('#nextStep').removeClass('disabled');

            //	$('#wizardProgress').css("width","33%");
        } else if (currentStep == 3) {

            $('#wizardTab li:eq(2) a').tab('show');
            //$('#wizardProgress').css("width","66%");

            $("#prevStep").removeAttr('style', "display:none");
            $("#nextStep").removeAttr('style', "display:none");



            $('#nextStep').attr('disabled', false);
            $('#nextStep').removeClass('disabled');

            //	$('#wizardProgress').css("width","33%");
        } else if (currentStep == 4) {

            $('#wizardTab li:eq(3) a').tab('show');
            //	$('#wizardProgress').css("width","66%");

            $("#prevStep").removeAttr('style', "display:none");
            $("#nextStep").removeAttr('style', "display:none");

            $('#nextStep').attr('disabled', false);
            $('#nextStep').removeClass('disabled');

            //	$('#wizardProgress').css("width","66%");
        }

        return false;
    });


    //*********for venue section 

    $('#nextStepvenue').click(function() {
        var user_status = ststus_chk;
        currentStep++;
        if (currentStep == 2) {
            $('#wizardTab li:eq(1) a').tab('show');
            $("#prevStepvenue").removeAttr('style', "display:none");
            $("#nextStepvenue").removeAttr('style', "display:none");

            $('#prevStepvenue').attr('disabled', false);
            $('#prevStepvenue').removeClass('disabled');
        }
        if (currentStep == 3) {
            $('#wizardTab li:eq(2) a').tab('show');
            $("#prevStepvenue").removeAttr('style', "display:none");
            $("#nextStepvenue").removeAttr('style', "display:none");

            $('#prevStepvenue').attr('disabled', false);
            $('#prevStepvenue').removeClass('disabled');
        } else if (currentStep == 4) {
            $('#wizardTab li:eq(3) a').tab('show');
            $("#prevStepvenue").removeAttr('style', "display:none");
            $("#nextStepvenue").attr('style', "display:none");


            $('#nextStepvenue').attr('disabled', false);
            $('#nextStepvenue').removeClass('disabled');

            if (user_status != 0) {
                $("#addeditcompletevenue").removeAttr('style', "display:none");
            }
        }
        return false;
    });
    $('#prevStepvenue').click(function() {
        $("#addeditcompletevenue").attr('style', "display:none");
        currentStep--;
        if (currentStep == 1) {
//alert('its ok');
            $('#wizardTab li:eq(0) a').tab('show');
            $("#prevStepvenue").attr('style', "display:none");
            $("#nextStepvenue").removeAttr('style', "display:none");
        } else if (currentStep == 2) {

            $('#wizardTab li:eq(1) a').tab('show');
            $("#prevStepvenue").removeAttr('style', "display:none");
            $("#nextStepvenue").removeAttr('style', "display:none");
        } else if (currentStep == 3) {
            $('#wizardTab li:eq(2) a').tab('show');
            $("#prevStepvenue").removeAttr('style', "display:none");
            $("#nextStepvenue").removeAttr('style', "display:none");
            $('#nextStepvenue').attr('disabled', false);
            $('#nextStepvenue').removeClass('disabled');

        }
        return false;
    });


    //**********added for venue skill add and delete starts 13-08-2016

    callurl = admin_base_url_data + '/subskillsavevenueall';
    var sndata = {
        _token: admin_csrf_token_data,
        vnucreatrID: vnucreatrID,
        vnuID: vnuID
    }
    jQuery.ajax({
        url: callurl,
        data: sndata,
        type: "POST",
        dataType: 'JSON',
        success: function(res) {

            //alert(ststus_chk)
            //$('.subskilldeleteajax').css('display','none');
            $("#sports_venuelist").html(res.response_data);

            if (ststus_chk != 1) {
                $("#sports_venuelist").find('a.subskilldeleteajax').remove();
            }
        }
    });

    //**********added for venue skill add and delete ends 13-08-2016


    //**********added for venue skill add and delete starts 13-08-2016

    callurl = admin_base_url_data + '/skillsubskillshowgroupall';
    var sndata = {
        _token: admin_csrf_token_data,
        grupcreatrID: grupcreatrID,
        groupID: groupID
    }
    jQuery.ajax({
        url: callurl,
        data: sndata,
        type: "POST",
        dataType: 'JSON',
        success: function(res) {
            //console.log(ststus_chk);

            $("#group_list").html(res.response_data);
            if (ststus_chk != 1) {
                $("#group_list").find('a.subskilldeleteajax').remove();
            }
        }
    });

    //**********added for venue skill add and delete ends 13-08-2016

    callurl = admin_base_url_data + '/displayskillsubskilluser';
    var sndata = {
        _token: admin_csrf_token_data,
        userID: userID
    }
    jQuery.ajax({
        url: callurl,
        data: sndata,
        type: "POST",
        dataType: 'JSON',
        success: function(res) {


            $("#user_categorygenrelist").html(res.response_data);

            if (ststus_chk != 1) {
                $("#user_categorygenrelist").find('a.subskilldeleteajax').remove();
            }
        }
    });



    //**********image upload starts for user

    $(".userimgupldclsadmin").click(function() {

        $("#image_name").trigger('click');
    });
    $("#image_name").change(function() {


        //  console.log($(this).val());

        var filename = $('input[name="image_name"]').val();
        //console.log(filename);

        var inp = document.getElementById('image_name');

        var allowedfiletypeAr = [];
        allowedfiletypeAr.push("jpg");
        allowedfiletypeAr.push("jpeg");
        allowedfiletypeAr.push("png");


        var allowedfiletypeSizeAr = [];
        allowedfiletypeSizeAr.push((1024 * 1024 * 5)); // in bytes
        allowedfiletypeSizeAr.push((1024 * 1024 * 5)); // in bytes
        allowedfiletypeSizeAr.push((1024 * 1024 * 5)); // in bytes


        var errorar = [];
        var errorstr = '';
        var filepassedAr = [];

        for (var i = 0; i < inp.files.length; ++i) {

            var namedata = inp.files.item(i).name;
            var flsize = inp.files.item(i).size;

            var namedataAr = namedata.split(".");
            var fileext = '';
            if (namedataAr.length > 0) {
                var fileext = namedataAr.pop();

                if (fileext != '') {
                    var chkvalidfiletype = allowedfiletypeAr.indexOf(fileext.toLowerCase());

                    if (chkvalidfiletype == -1) {
                        // file type error

                        errorstr += ' <p> "' + namedata + '" has invalid file type </p>';

                    } else {
                        var allowedfilesize = allowedfiletypeSizeAr[chkvalidfiletype];

                        var chkfilesize = (flsize <= allowedfilesize) ? true : false;

                        if (chkfilesize == false) {
                            //file size error
                            errorstr += ' <p> "' + namedata + '" exceeds allowed file size </p>';
                        } else {
                            filepassedAr.push(namedata);
                        }

                    }



                } else {
                    //error without file extention

                    errorstr += ' <p> "' + namedata + '" has no file extention  </p>';
                }

            }


            //console.log("here is a file name: " + name + "==size=>"+ inp.files.item(i).size );
        }

        if (errorstr != '' && filepassedAr.length > 0) {
            toastr.remove(); // Immediately remove current toasts without using animation
            poptriggerfunc(msgtype = 'error', titledata = '', msgdata = errorstr, sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');
            console.log('error file');
            $("#submitbutnid").trigger("click");
        } else if (errorstr != '' && filepassedAr.length == 0) {
            //alert(errorstr);
            toastr.remove(); // Immediately remove current toasts without using animation
            poptriggerfunc(msgtype = 'error', titledata = '', msgdata = errorstr, sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');

        }
        if (errorstr == '' && filepassedAr.length > 0) {

          //  console.log('validated successfully');
            $("#submitbutnid").trigger("click");
        }


    });
    //********* For user image upload ends



}); //*******document ready ends


$("#addeditcomplete_btn").click(function() {

    $('#useraddfrmid').submit();
});
//******** for  venue skill delete starts here
function showmemenue(a, b) {
    var skillmaster_ID = a;
    var skillmaster_parentID = b;

    var vnuID = $("#vnuID").val();
    var vnucreatrID = $("#vnucreatrID").val();


    $("#hdnursid").val(vnucreatrID);
    $("#hdnursvenueid").val(vnuID);
    $("#hdnskillmaster_ID").val(skillmaster_ID);
    $("#hdnskillmaster_parentID").val(skillmaster_parentID);


    $('#myModalvenue').modal('show');
}

function deletevenuekill() {
    // alert('test');
    var vnucreatrID = $("#hdnursid").val();
    var vnuID = $("#hdnursvenueid").val();
    var skillmaster_ID = $("#hdnskillmaster_ID").val();
    var skillmaster_parentID = $("#hdnskillmaster_parentID").val();



    //$("#delete").click(function(){
    var clurl = admin_base_url_data + '/deletesubskillvenueajax';
    var sndata = {
        _token: admin_csrf_token_data,
        skillmaster_id: skillmaster_ID,
        skillmaster_parentid: skillmaster_parentID,
        vnuID: vnuID,
        vnucreatrID: vnucreatrID
    }
    $.ajax({
        url: clurl,
        data: sndata,
        type: "POST",
        dataType: 'JSON',
        success: function(res) {

            if (res.typeflag == 'exists') {
                $("#skilldletststusvnu").html('You can not delete this genre');
                $("#myModalvnuskildltsts").modal('show');
                //alert('You can not delete this skill');

            } else {

                $("#skilldletststusvnu").html('Genre deleted successfully');
                $("#myModalvnuskildltsts").modal('show');
                //alert('Skill deleted successfully');

            }


            $("#sports_venuelist").html(res.response_data);
        }

    });
    //	});
}
//**********  for venue skill delete starts here

//********** for group delete starts here
function showmedelgroup(a, b) {
    var skillmaster_ID = a;
    var skillmaster_parentID = b;

    var groupID = $("#groupID").val();
    var grupcreatrID = $("#grupcreatrID").val();
    //var grpidcpy = groupID;

    $("#hdnursid").val(grupcreatrID);
    $("#hdnursgrupid").val(groupID);
    //alert(groupID);
    $("#hdnskillmaster_ID").val(skillmaster_ID);
    $("#hdnskillmaster_parentID").val(skillmaster_parentID);
    $('#myModalgrup').modal('show');
}

function deletegroupskill() {
    var grupcreatrID = $("#hdnursid").val();
    var groupID = $("#hdnursgrupid").val();
    var skillmaster_ID = $("#hdnskillmaster_ID").val();
    var skillmaster_parentID = $("#hdnskillmaster_parentID").val();

    //alert('groupID'+groupID);


    // $("#delete").click(function(){
    var clurl = admin_base_url_data + '/deletesubskillgroupajax';
    var sndata = {
        _token: admin_csrf_token_data,
        skillmaster_id: skillmaster_ID,
        skillmaster_parentid: skillmaster_parentID,
        groupID: groupID,
        grupcreatrID: grupcreatrID
    }
    $.ajax({
        url: clurl,
        data: sndata,
        type: "POST",
        dataType: 'JSON',
        success: function(res) {

            if (res.typeflag == 'exists') {
                $("#skilldletststusgrp").html('You can not delete this genre');
                $("#myModalgrpskildltsts").modal('show');
                //alert('You can not delete this skill');

            } else {

                $("#skilldletststusgrp").html('Genre deleted successfully');
                $("#myModalgrpskildltsts").modal('show');
                //alert('Skill deleted successfully');

            }



            $("#group_list").html(res.response_data);
        }

    });
    // });
}
//********** for group delete ends here


///************ for user skill delete starts here
function showmedeluser(a, b) {

    var skillmaster_ID = a;
    var skillmaster_parentID = b;
    var t = 0;
    var userID = $("#userID").val();
    $("#hdnursid").val(userID);
    $("#hdnskillmaster_ID").val(skillmaster_ID);
    $("#hdnskillmaster_parentID").val(skillmaster_parentID);
    $('#myModal').modal('show');

}

function delteusrskill() {
    var userID = $("#hdnursid").val();
    var skillmaster_ID = $("#hdnskillmaster_ID").val();
    var skillmaster_parentID = $("#hdnskillmaster_parentID").val();

    var clurl = admin_base_url_data + '/deletesubskilluserajax';
    var sndata = {
        _token: admin_csrf_token_data,
        skillmaster_id: skillmaster_ID,
        skillmaster_parentid: skillmaster_parentID,
        userID: userID
    }
    $.ajax({
        url: clurl,
        data: sndata,
        type: "POST",
        dataType: 'JSON',
        success: function(res) {


            if (res.typeflag == 'exists') {
                $("#skilldletststususr").html('You can not delete this genre');
                $("#myModalusrskildltsts").modal('show');
                //alert('You can not delete this skill');

            } else {

                $("#skilldletststususr").html(' Genre deleted successfully');
                $("#myModalusrskildltsts").modal('show');
                //alert('Skill deleted successfully');

            }

            $("#user_categorygenrelist").html(res.response_data);
        }

    });



}
///************ for user skill delete ends here

//********user image delete starts here


function deleteuserimage(a, b,c) {

    var userimgID = a;
    var userimgsts = b;
 //   var usID = c;
    var userID = $("#userID").val();
    $("#hdnuserID").val(userID);
    $("#hdnuserimgID").val(userimgID);
    $("#hdnuserimgsts").val(userimgsts);
    // $("#hdnskillmaster_parentID").val(skillmaster_parentID);
    if(userimgsts == 1)
    {
        $('#userimagedeletetext').html('This is Your profile picture');
    }else if(userimgsts == 0) {
         $('#userimagedeletetext').html('');
    }
    $('#myModalusrsimagedelete').modal('show');

}
function deleteusrimg()
{
    var userID = $("#hdnuserID").val();
    var userimgID = $("#hdnuserimgID").val();
    var userimgsts = $("#hdnuserimgsts").val();
    // alert("userID"+userID+"="+"userimgID"+userimgID+"="+"userimgsts"+userimgsts);


    
    var imgurldata =  admin_base_url_data+"/otherfiles/progimages/noimagefound52X52.jpg";
    var clurl = admin_base_url_data + '/deleteuserimageadmin';
    var sndata = {
        _token: admin_csrf_token_data,
        userID: userID,
        userimgID: userimgID,
        userimgsts: userimgsts
    }
    $.ajax({
        url: clurl,
        data: sndata,
        type: "POST",
        dataType: 'JSON',
        success: function(res) {
           console.log(res.getuserimgallArcount);
           if(res.getuserimgallArcount>=0 && res.getuserimgallArcount<=3)
           {
            $("#usrtotalimage").removeClass('mydiplaymoneadmin');
           
           }

          
             toastr.remove(); // Immediately remove current toasts without using animation
            poptriggerfunc(msgtype = 'success', titledata = '', msgdata = "Image deleted successfully", sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');



           $("#showuserimageanchr").html(res.getuserimgallAr);
        }

    });

}


//***********delete image for user venue

function deletevenueimage(a, b,c) {

    var userimgID = a;
    var userimgsts = b;
 //   var usID = c;
    var userID = $("#vnucreatrID").val();
    var usrvnuid = $("#vnuID").val();

   // alert("userID"+userID);
    $("#hdnuservenueID").val(usrvnuid);
    $("#hdnuserID").val(userID);
    $("#hdnuserimgID").val(userimgID);
    $("#hdnuserimgsts").val(userimgsts);
    // $("#hdnskillmaster_parentID").val(skillmaster_parentID);
    if(userimgsts == 1)
    {
        $('#uservnuimagedeletetext').html('This is Your profile picture');
    }else if(userimgsts == 0) {
         $('#uservnuimagedeletetext').html('');
    }
    $('#myModalusrsimagedelete').modal('show');

}
function deleteusrvnueimg()
{
    var userID = $("#hdnuserID").val();
    var userimgID = $("#hdnuserimgID").val();
    var userimgsts = $("#hdnuserimgsts").val();
     var hdnuservenueID = $("#hdnuservenueID").val();
    // alert("userID"+userID+"="+"userimgID"+userimgID+"="+"userimgsts"+userimgsts);


    
    var imgurldata =  admin_base_url_data+"/otherfiles/progimages/noimagefound52X52.jpg";
    var clurl = admin_base_url_data + '/deleteuservenueimageadmin';
    var sndata = {
        _token: admin_csrf_token_data,
        userID: userID,
        userimgID: userimgID,
        userimgsts: userimgsts,
        hdnuservenueID: hdnuservenueID
    }
    $.ajax({
        url: clurl,
        data: sndata,
        type: "POST",
        dataType: 'JSON',
        success: function(res) {
           console.log(res.getuserimgallArcount);
           if(res.getuserimgallArcount>=0 && res.getuserimgallArcount<=3)
           {
            $("#venuetotalimage").removeClass('mydiplaymoneadmin');
           
           }

          
             toastr.remove(); // Immediately remove current toasts without using animation
            poptriggerfunc(msgtype = 'success', titledata = '', msgdata = "Image deleted successfully", sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');



           $("#showuservenueimageanchr").html(res.getuserimgallAr);
        }

    });

}


//**********group image delete



function deletegroupimage(a, b,c) {

    var userimgID = a;
    var userimgsts = b;
 //   var usID = c;
    var userID = $("#grupcreatrID").val();
    var usrgrupid = $("#groupID").val();

   // alert("userID"+userID);
    $("#hdngruopusrID").val(usrgrupid);
    $("#hdnuserID").val(userID);
    $("#hdnuserimgID").val(userimgID);
    $("#hdnuserimgsts").val(userimgsts);
    // $("#hdnskillmaster_parentID").val(skillmaster_parentID);
    if(userimgsts == 1)
    {
        $('#uservnuimagedeletetext').html('This is Your profile picture');
    }else if(userimgsts == 0) {
         $('#uservnuimagedeletetext').html('');
    }
    $('#myModalusrsimagedelete').modal('show');

}
function deleteusrgroupimg()
{
    var userID = $("#hdnuserID").val();
    var userimgID = $("#hdnuserimgID").val();
    var userimgsts = $("#hdnuserimgsts").val();
     var hdnusergroupID = $("#hdngruopusrID").val();
    // alert("userID"+userID+"="+"userimgID"+userimgID+"="+"userimgsts"+userimgsts);


    
    var imgurldata =  admin_base_url_data+"/otherfiles/progimages/noimagefound52X52.jpg";
    var clurl = admin_base_url_data + '/deleteusergroupimageadmin';
    var sndata = {
        _token: admin_csrf_token_data,
        userID: userID,
        userimgID: userimgID,
        userimgsts: userimgsts,
        hdnusergroupID: hdnusergroupID
    }
    $.ajax({
        url: clurl,
        data: sndata,
        type: "POST",
        dataType: 'JSON',
        success: function(res) {
           console.log(res.getuserimgallArcount);
           if(res.getuserimgallArcount>=0 && res.getuserimgallArcount<=3)
           {
            $("#grouptotalimage").removeClass('mydiplaymoneadmin');
           
           }

          
             toastr.remove(); // Immediately remove current toasts without using animation
            poptriggerfunc(msgtype = 'success', titledata = '', msgdata = "Image deleted successfully", sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');



           $("#showusergroupimageanchr").html(res.getuserimgallAr);
        }

    });

}


