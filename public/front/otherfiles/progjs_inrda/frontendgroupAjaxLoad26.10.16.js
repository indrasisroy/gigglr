$(document).ready(function(){
    showFromPage();
    $(document).on('click','#formPage',function(){
                         
    showFromPage();
    });
    function showFromPage(){
        //alert(seo_url);
    //var url = $('#hiddenUrl').val();
    $(".preeSelected").removeClass("selected");
    $("#formPage").addClass("selected");
    var showFromPage_url=base_url_data+"/groupdashboardfrmpage";
    //var showFromPage_url=base_url_data+"/"+groupUrl;
    var mode = "form";
    var showFromPage_data={_token:csrf_token_data,'url':seo_url};
    $.ajax({
     url:showFromPage_url,
     type:'POST',
     dataType:'json',
     data:showFromPage_data,
     success:function(d){
       var ep_contents=d.ep_contents;
       loadPage(ep_contents,mode)
     }
     
     });
    }
    
    function loadPage(args,mode) {
                         
    var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
    showmycustomloader(1,'','',"Please wait . Its loading ...",imfpth);
    setTimeout(function(){
             showmycustomloader(0,'1000','1000',"Please wait . Its loading ...",imfpth)
             
             if (mode == "list") {
                $("#fromDiv").hide();
                var $objArray = jQuery.parseJSON(args);
                var Arraylength = $objArray.GroupUser.length;
                
                //************HTML start
                
                $htmlMemberList  = '<div class="col-sm-08 col-md-9">';
				$htmlMemberList += '<div class="rightContent">';
				$htmlMemberList += '<h3>Member list</h3>';
						
				$htmlMemberList += '<div class="table-responsive" id="member_details_div">';
	            $htmlMemberList += '<table class="table user-table">';
	            $htmlMemberList += '<thead>';
	            $htmlMemberList += '<tr>';
	            $htmlMemberList += '<th>Member Name</th>';
	            $htmlMemberList += '<th>Joining date</th>';
	            $htmlMemberList += '<th>Action</th>';
	            $htmlMemberList += '</tr>';
	            $htmlMemberList += '</thead>';
	            $htmlMemberList += '<tbody>';

                
                if (Arraylength > 0) {
                  $.each($objArray.GroupUser, function( index, valueFile ) {
                    console.log(valueFile.id);
                        $htmlMemberList += '<tr>';
                        $htmlMemberList += '<td>';
                        $htmlMemberList += '<a href="#" class="userName">'+valueFile.first_name+' '+valueFile.last_name+'</a>';
                        $htmlMemberList += '</td>';
                        $htmlMemberList += '<td>'+valueFile.created_date+'</td>';
                        
                        $htmlMemberList += '<td>';
                        $htmlMemberList += '<div class="actionBtn">';
                        $htmlMemberList += '<a href="#" class="removeUser"><img src="'+base_url_data+'/front/images/delete-icon.png" alt="" /></a>';
                        $htmlMemberList += '</div>';
                        $htmlMemberList += '</td>';
                        $htmlMemberList += '</tr>';
                        
                        });
                }else{
                    $htmlMemberList += '<tr><td> No data found </td><td>  </td><td> </td></tr>';
                }
                


	            						
	            						
	            $htmlMemberList += '</tbody>';
	            $htmlMemberList += '</table>';
	            $htmlMemberList += '</div>';
						
				$htmlMemberList += '</div>';
				$htmlMemberList += '</div>';
                
                $htmlMemberList += '<br>'+$objArray.link;
                
                //*************HTML end
                
                $("#listDiv").html($htmlMemberList).show();
             }else{
                $("#listDiv").hide();
                $("#fromDiv").html(args);
                $("#fromDiv").show();
                
             }
       },3000);
    }
    
    var user_list_current = 1;
    
    function getUserData(){
        
        var showFromPage_url=base_url_data+"/groupmemberlist";
        var showFromPage_data={_token:csrf_token_data,'user_list_current':user_list_current};
        var mode = "list";
        $.ajax({
         url:showFromPage_url,
         type:'POST',
         data:showFromPage_data,
         success:function(d){
            loadPage(d,mode)
         }
         
         });
    }
    
    $(document).on('click','#userList',function(){
        $(".preeSelected").removeClass("selected");
        $("#userList").addClass("selected");
        getUserData();
    });
    
    $(document).on('click','.pagination_outer_cust li a',function(){
        $page = $(this).data('page');
        user_list_current = $page;
        getUserData()
    });
     
});
