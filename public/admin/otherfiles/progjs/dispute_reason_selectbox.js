$(document).ready(function() {

    $("#complaint_by").change();
    // $('.errorcustclass').html('');
    // var tt =1;
    // var jj=1;

});

$("#complaint_by").change(function() {



var addedittypeflag = $("#addedittypeflagckeck").val();
// console.log(addedittypeflag);
if(disputeresaonedit_flag == 0){
//alert(disputeresaonedit_flag);
    var firstselectbox_val = this.value;

    // var tt =1;
    fconplaintbytypeselect = "";
    fconplainagainstselect = "";

  var  fconplainagainstselect_artist = "";
  var  fconplainagainstselect_group = "";
  var  fconplainagainstselect_venue = "";

  var  sconplaintbytypeselect_artist = "";
  var  sconplaintbytypeselect_group = "";
  var  sconplaintbytypeselect_venue = "";

 var   sconplainagainstselect = "";
 var  sconplainbyselect = "";


 var fconplainagainstselect_artist_edit ="";
 var  fconplainagainstselect_group_edit = "";
  var  fconplainagainstselect_venue_edit = "";



  var  sconplaintbytypeselect_artist_edit = "";
  var  sconplaintbytypeselect_group_edit = "";
  var  sconplaintbytypeselect_venue_edit = "";



    if (firstselectbox_val == 1) {
        //  alert('hello'+firstselectbox_val);
        $("#complaintbytypehndval").addClass('mydisplaynoneadmin');



        $("#complaintagainsttypehndval").removeClass('mydisplaynoneadmin');


        var fconplaintbytype = $("#hidden_complaint_by_type").val();
        var fconplainagainst = $("#hidden_complaint_against").val();
        var fconplainagainst_type = $("#hidden_complaint_against_type").val();
        // console.log(fconplainagainst);
        if (fconplaintbytype == '1') {

            fconplaintbytypeselect = "selected";

        } else {
            fconplaintbytypeselect = "";
        }



        if (fconplainagainst == '2') {

            fconplainagainstselect = "selected";

        } else {
            fconplainagainstselect = "";
        }



        if (fconplainagainst_type == '1') {
            //alert('adasd');
            fconplainagainstselect_artist = "selected";

        } else if (fconplainagainst_type == '2') {
            fconplainagainstselect_group = "selected";
        } else if (fconplainagainst_type == '3') {
            fconplainagainstselect_venue = "selected";
        }

        // var fconplainagainsttype = $("#complaint_against_type").val();
    } else if (firstselectbox_val == 2) {
        // alert('hello'+firstselectbox_val);
        $("#complaintbytypehndval").removeClass('mydisplaynoneadmin');
        //  $("#complaint_against_type").val('1');
        // $('#complaint_against_type').find('option').remove().end().append("<option value=''>Select option</option><option value='1' selected>Artist</option>");
        $("#complaintagainsttypehndval").addClass('mydisplaynoneadmin');


        var sconplaintbytype = $("#hidden_complaint_by_type").val();
        var sconplainagainst = $("#hidden_complaint_against").val()
        var sconplainagainsttype = $("#hidden_complaint_against_type").val()




        if (sconplaintbytype == '1') {

            sconplaintbytypeselect_artist = "selected";

        } else if (sconplaintbytype == '2') {
            sconplaintbytypeselect_group = "selected";
        } else if (sconplaintbytype == '3') {
            sconplaintbytypeselect_venue = "selected";
        }


        if (sconplainagainst == '1') {

            sconplainagainstselect = "selected";

        } else {
            sconplainagainstselect = "";
        }

        if (sconplainagainsttype == '1') {

            sconplainbyselect = "selected";

        } else {
            sconplainbyselect = "";
        }


    }




    if (firstselectbox_val == 1) {
        $('#complaint_by_type').find('option').remove().end().append("<option value=''>Select option</option><option value='1' selected>Artist</option>");
        $('#complaint_against').find('option').remove().end().append("<option value=''>Select option</option><option value='2' " + fconplainagainstselect + ">Booked-artist/group/venue</option>");
        $('#complaint_against_type').find('option').remove().end().append("<option value=''>Select option</option><option value='1' " + fconplainagainstselect_artist + ">Artist</option><option value='2' " + fconplainagainstselect_group + ">Group</option><option value='3' " + fconplainagainstselect_venue + ">Venue</option>");
    }
    if (firstselectbox_val == 2) {
        $('#complaint_by_type').find('option').remove().end().append("<option value=''>Select option</option><option value='1' " + sconplaintbytypeselect_artist + ">Artist</option><option value='2' " + sconplaintbytypeselect_group + ">Group</option><option value='3' " + sconplaintbytypeselect_venue + ">Venue</option>");
        $('#complaint_against').find('option').remove().end().append("<option value=''>Select option</option><option value='1' " + sconplainagainstselect + ">Booker</option>");
        $('#complaint_against_type').find('option').remove().end().append("<option value=''>Select option</option><option value='1' selected>Artist</option>");
    }
    if (firstselectbox_val == 0) {
        $('#complaint_by_type').find('option').remove().end().append("<option value=''>Select option</option>");
        $('#complaint_against').find('option').remove().end().append("<option value=''>Select option</option>");
        $('#complaint_against_type').find('option').remove().end().append("<option value=''>Select option</option>");
    }


} //if condition ensds
else if(disputeresaonedit_flag > 0)
{
   //alert("hello 2");

   console.log("diputreson_complaintby"+diputreson_complaintby);
   console.log("diputreson_complaintby_type"+diputreson_complaintby_type);
   console.log("diputreson_complaintagainst"+diputreson_complaintagainst);
   console.log("diputreson_complaintagainst_type"+diputreson_complaintagainst_type);

   if(diputreson_complaintagainst_type == 1)
   {

   }

   if(diputreson_complaintby == 1)
   {

            if(diputreson_complaintagainst_type == 1)
            {
                fconplainagainstselect_artist_edit = "selected";
            }
            else if(diputreson_complaintagainst_type == 2)
            {
                fconplainagainstselect_group_edit = "selected";
            }
            else if(diputreson_complaintagainst_type == 3)
            {
                fconplainagainstselect_venue_edit = "selected";
            }


            $('#complaint_by').find('option').remove().end().append("<option value='1' selected>Booker</option>"); 
            $('#complaintbytypehndval').addClass('mydisplaynoneadmin');
            $('#complaint_against').find('option').remove().end().append("<option value='2' selected>Booked-artist/group/venue</option>");
             $('#complaint_against_type').find('option').remove().end().append("<option value=''>Select option</option><option value='1' " + fconplainagainstselect_artist_edit + ">Artist</option><option value='2' " + fconplainagainstselect_group_edit + ">Group</option><option value='3' " + fconplainagainstselect_venue_edit + ">Venue</option>");
   }
   else if(diputreson_complaintby == 2)
   {

    if(diputreson_complaintby_type == 1)
    {
        sconplaintbytypeselect_artist_edit = "selected";
    }
   else if(diputreson_complaintby_type == 2)
    {
        sconplaintbytypeselect_group_edit = "selected";
    }
    else if(diputreson_complaintby_type == 3)
    {
        sconplaintbytypeselect_venue_edit = "selected";
    }


    $('#complaint_by').find('option').remove().end().append("<option value=''>Select option</option><option value='2' selected>Booked-artist/group/venue</option>"); 
    $('#complaint_by_type').find('option').remove().end().append("<option value=''>Select option</option><option value='1' " + sconplaintbytypeselect_artist_edit + ">Artist</option><option value='2' " + sconplaintbytypeselect_group_edit + ">Group</option><option value='3' " + sconplaintbytypeselect_venue_edit + ">Venue</option>");
     $('#complaint_against').find('option').remove().end().append("<option value=''>Select option</option><option value='1' selected>Booker</option>");
     $('#complaintagainsttypehndval').addClass('mydisplaynoneadmin');
   }
    $('#complaint_by').prop('disabled', 'disabled');
    $('#complaint_by_type').prop('disabled','disabled');
    $('#complaint_against').prop('disabled', 'disabled');
    $('#complaint_against_type').prop('disabled','disabled');
   



}

});