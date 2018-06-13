				
		<script type="text/javascript">
//		
//        function loadLeadDataAjax(posturl,pagenumdata,searchdata)
//        {
//            $("#leads_cont_id").nextAll().remove();
//            
//            /*$('.mycustlistrowclass').each(function(i, obj) {
//            
//            $(this).remove();
//            
//            });*/
//            
//            showLoader("#loaderimgdivid",".suloader_class",100,"#msgcontentouterdivid");
//            
//            $("#loaderimgdivid").fadeIn(5000,function(){
//                
//                
//                $.ajax({
//                                dataType:'html',
//                                data:{search:searchdata,pagenum:pagenumdata},
//                                url:posturl,
//                                type:'POST',
//                                success:function(d){
//                                    
//                                    //alert(d);
//                                                                            
//                                    var dataAr=d.split("@@@###$1$###@@@");
//                                    var cont_data=dataAr[0];// content
//                                    var pagi_data=dataAr[1];// pagination
//                                    
//                                    //alert("==cont_data=>"+cont_data);
//                                    
//                                    
//                                    $("#leads_cont_id").after(cont_data);
//                                    
//                                
//                                    
//                                    //**** here select box now starts
//                                    
//                                    $("select#changestatus").selectBoxIt().bind({
//                                    "option-click": function(ev, obj) {
//                                    
//                                    
//                                    var selnewstatus=$(this).val();
//                                    var dataselstatusAr=selnewstatus.split("---");
//                                    
//                                    var newstatusdata=dataselstatusAr[0];
//                                    var leadiddata=dataselstatusAr[1];
//                                    
//                                    var chkconfstat=confirm(" Are you sure you want to change ? ");
//                                    
//                                        if (chkconfstat==true)
//                                        {
//                                            
//                                                //*** change status using ajax starts
//                                                
//                                                //var statusposturl="<?php echo base_url()."leads/changetoleadnewstatus"; ?>";
//												var statusposturl=base_url_data+"/groupmemberlist"; 
//                                                
//                                                
//                                                $.ajax({
//                                                dataType:'html',
//                                                data:{newstatusdata:newstatusdata,leadiddata:leadiddata},
//                                                url:statusposturl,
//                                                type:'POST',
//                                                success:function(d){
//                                                
//                                                //alert("done");
//                                                $("#btnfiltersearchid").trigger('click');
//                                                
//                                                
//                                                }});
//                                                //*** change status using ajax ends
//                                        
//                                        }
//                                    
//                                    }
//                                    });
//                                    //**** here select box now ends
//                                    
//                                    $("#pagination_div_id").fadeIn('fast',function(){
//                                        
//                                        $("#pagination_div_id").html(pagi_data);
//                                        
//                                        
//                                        //**** now bind with each li starts
//                                                $('.pagination_outer_cust').find('li').each(function(){
//                                                    
//                                                    $(this).click(function(){
//                                                        
//                                                        var pagenumdata=$(this).find('a').data('page');
//                                                        if(pagenumdata!='nopage')
//                                                        {
//                                                            var searchdata="";
//                                                            loadLeadDataAjax(posturl,pagenumdata,searchdata);
//                                                        }
//                                                        
//                                                        });
//                                                    
//                                                    });
//                                        //**** now bind with each li ends                                        
//                                        
//                                        });
//                                    
//                                    hideLoader("#member_details_div",".suloader_class",300,"#msgcontentouterdivid");
//                                    
//                                    //*** scroll code starts
//                                    //leads_cont_id
//                                    
//                                    $('html, body').animate({
//                                    scrollTop: $(".search_type").offset().top + 5 }, 'slow');
//
//                                    //*** scroll code ends
//                                    
//                                    
//                                    
//                                }
//                                
//                                });
//                
//                
//                });
//            
//                            
//                            
//            
//        }
//        
//        
//        //**** on load call lead list ajax function starts
//        var searchdata="";
//        //var posturl="<?php echo base_url()."leads/loadleadsbyajax"; ?>";
//		var posturl="";
//        
//        
//         setTimeout(function(){
//            
//                //showLoader("#loaderimgdivid",".suloader_class",100,"#msgcontentouterdivid");
//            var pagenumdata=1;
//            loadLeadDataAjax(posturl,pagenumdata,searchdata);
//            
//            
//         },250);
		  //**** on load call lead list ajax function ends
		 </script>	
         <?php print_r($GroupUser);die;?>
				<div class="col-sm-08 col-md-9">
					<div class="rightContent">
						<h3>Member list</h3>
						
						<div class="table-responsive" id="member_details_div">
	            				<table class="table user-table">
	            					<thead>
	            						<tr>
	            							<th>Member Name</th>
	            							<th>Joining date</th>
	            							<th>Action</th>
	            						</tr>
	            					</thead>
	            					<tbody>
                                    <?php
                                    if(!empty($GroupUser)){
									//print_r($GroupUser);die;
                                    foreach($GroupUser as $userList){
                                    $p=$userList->create_date;
                                    $date=date('dS, F Y',strtotime($p));
                                    ?>
                                    <tr>
	            							<td>
	            								<a href="#" class="userName"><?php echo ucfirst($userList->first_name." ".$userList->last_name);?></a>
	            							</td>
	            							<td><?php echo $date;?></td>
                                         
	            							<td>
	            								<div class="actionBtn">
	            									<!--<a href="#" class="editUser"><img src="{{ URL::asset('public/front')}}/images/edit-icon.png" alt="" /></a>-->
	            									<a href="#" class="removeUser"><img src="{{ URL::asset('public/front')}}/images/delete-icon.png" alt="" /></a>
	            								</div>
	            							</td>
	            						</tr>
                                    <?php
                                    }
                                    }
                                    ?>
	            						
	            						
	            					</tbody>
	            				</table>
	            			</div>
						
					</div>
				</div>
 <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendgroupdashbord.js">