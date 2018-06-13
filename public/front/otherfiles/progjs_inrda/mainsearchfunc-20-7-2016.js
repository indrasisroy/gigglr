 function domainsearch(pagenumdata,pgloadflag)
    {
        var whowhat=$("#whowhat").val();
        var mainsearch=$("#mainsearch").val();
        
        var categorydata=$( "#category option:selected" ).text();
        var genredata=$( "#genre option:selected" ).text();
        var locationtxt=$( "#locationtxt" ).val();
        
        var inputstr='';
                
        var searchdatastr='';
        var searchdatastrAr=[];
        searchdatastrAr.push('"_token":"'+csrf_token_data+'"');
         searchdatastrAr.push('"pagenum":"'+pagenumdata+'"'); // for page number used in pagination
         
         //*** for filtration purpose starts
        
        
        if (categorydata!='')
        {
           searchdatastrAr.push('"category":'+'"'+categorydata+'"');
        }
        
        if (genredata!='')
        {
           searchdatastrAr.push('"genre":'+'"'+genredata+'"');
        }
        
        if (whowhat!='')
        {           
            searchdatastrAr.push('"whowhat":'+'"'+whowhat+'"');
           
        }
        
        if (mainsearch!='')
        {
            searchdatastrAr.push('"mainsearch":'+'"'+mainsearch+'"');
        }
        
        
        if (curr_lat_data!='')
        {
            searchdatastrAr.push('"curr_lat":'+'"'+curr_lat_data+'"');
        }
        
        
        if (curr_long_data!='')
        {
            searchdatastrAr.push('"curr_long":'+'"'+curr_long_data+'"');
        }
        
        if (distance_data!='')
        {
            searchdatastrAr.push('"distance_data":'+'"'+distance_data+'"');
        }
        
        if (locationtxt!='')
        {
            searchdatastrAr.push('"locationtxt":'+'"'+locationtxt+'"');
        }
        
        
        
        if (available_time!='' && available_date!='')
        {
            
            searchdatastrAr.push('"available_time":'+'"'+available_time+'"');
            searchdatastrAr.push('"available_date":'+'"'+available_date+'"');
            
            var available_datetime=available_date+' '+available_time;
            searchdatastrAr.push('"available_datetime":'+'"'+available_datetime+'"');
        }
        else if (available_date!='')
        {
           searchdatastrAr.push('"available_date":'+'"'+available_date+'"');
           var available_datetime=available_date
           searchdatastrAr.push('"available_datetime":'+'"'+available_datetime+'"');
        }
        
        
       
        
        
        if (orderbycust!='')
        {
             searchdatastrAr.push('"orderbycust":'+'"'+orderbycust+'"');
        }
        
        
        //*** for filtration purpose ends
         
        if (searchdatastrAr.length>0)
        {
            searchdatastr=searchdatastrAr.toString();
        }
        
       // console.log(searchdatastr.length+"=searchdata=>"+searchdatastr);
        
        var searchdatastrObj=JSON.parse("{"+searchdatastr+"}");        
       // console.log("=searchdata=>"+JSON.stringify(searchdatastrObj));
       
        var searchdata=searchdatastrObj;        
        
        var mainsearchposturl=base_url_data+"/mainsearch";
       
        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
        showmycustomloader(1,'','',"Please wait . Its loading ...",imfpth);
        
        
        //** ajax call starts here
        
        setTimeout(function(){
            
           
        
        $.ajax({
            
            data:searchdata,
            dataType:"json",
            type:"POST",
            url:mainsearchposturl,
            success:function(d){
                
                var respdata=d.respdata;
                var pagination_link=d.pagination_link;
                var main_srch_union_lim=d.main_srch_union_lim; //alert(main_srch_union_lim);
                
                //****  if what has been seleted and category or genre has been searched starts
                if ( (whowhat!='' && whowhat==2) && mainsearch!='')
                {           
                   
                         selectcategnmid=d.selectcategnmid;
                         selectgenrenmid=d.selectgenrenmid;
                         
                         selectcategnm=d.selectcategnm;
                         selectgenrenm=d.selectgenrenm;
                         
                         var categ_opt=''; var categ_optAr=[];
                            $("#category option").each(function()
                            {
                                    if ($(this).val()!='')
                                    {
                                       var opt_dta="<option value='"+$(this).val()+"'>"+$(this).text()+"</option>";
                                       categ_optAr.push(opt_dta);
                                    }
                                    
                            });
                            
                            if (categ_optAr.length>0)
                            {
                                categ_opt=categ_optAr.join('');
                            }
                            
                            if (categ_opt!='')
                            {
                                
                                    $("#category").html(categ_opt);
                                    $("#category option[value="+selectcategnmid+"]").attr('selected',true);                                    
                                    //console.log("==>"+categ_opt);                                    
                                    $("#category").selectpicker('refresh');
                            }
                           
                            
                            populategenre(selectcategnmid);
                        
                         
                         
                }                
                //****  if what has been seleted and category or genre has been searched ends
                 
                if(respdata=='')
                {
                    respdata="<div id=\"searchlistresponseid\" class=\"col-md-12 col-sm-12 fullbx\">No  data  found</div>";
                    $(".sortcustclass").addClass("mydisplaynone");
                }
                else
                {
                    //**** bind  ordering drop down  starts

                    $("#orderbycust").one("change",function(){
                        
                        orderbycust=$(this).val();
                        
                        var  pagenumdata=1; var pgloadflag=1;
                        domainsearch(pagenumdata,pgloadflag);
                        
                        });
                    
                    //**** bind  ordering drop down  ends
                    
                    
                    //show ordering drop down 
                    $(".sortcustclass").removeClass("mydisplaynone"); 
                }
                
                $("#searchlistresponseid").html(respdata);
                $("#pagidivid").html(pagination_link);
                
                
                //**** now bind with each li starts
												jQuery('.pagination_outer_cust').find('li').each(function(){
													
													jQuery(this).click(function(){
														
														var pagenumdata=jQuery(this).find('a').data('page');
														if(pagenumdata!='nopage')
														{
															var searchdata="";var pgloadflag=0;
                                                             domainsearch(pagenumdata,pgloadflag);
														}
														
														});
													
													});
				//**** now bind with each li ends			
                
                
                footerarea_css();
                 showmycustomloader(0,'1000','1000',"Please wait . Its loading ...",imfpth)
                 
                if (pgloadflag==0)
                {
                //**** called during page load time  scroll to code starts
                
                //*** scroll code starts                              
                
                jQuery('html, body').animate({
                scrollTop: jQuery("#searchlistresponseid").offset().top + 5 }, '2000','swing');
                
                //*** scroll code ends
                
                //**** called during page load time scroll to code ends
                }
                 
            }
            
            
            });
        
        
        
             },1000);
            //** ajax call ends here
        
        
        
    }
$(document).ready(function(){
    
    
      
        
        
    
    
    
    
    });