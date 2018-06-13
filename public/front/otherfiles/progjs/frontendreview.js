//************************** function to pulate review data starts ***********************************
 function populateprofilereviewreview(pagenumdata)
    {
       
       
        var inputstr='';
                
        var searchdatastr='';
        var searchdatastrAr=[];
        searchdatastrAr.push('"_token":"'+csrf_token_data+'"');
        searchdatastrAr.push('"pagenum":"'+pagenumdata+'"'); // for page number used in pagination
         
        var flag_filtr_clkd=0;
         
         //*** for filtration purpose starts
        
       var tz = jstz.determine();
       var local_tz_data=tz.name();
        if(typeof(local_tz_data)== 'undefined')
            {
                local_tz_data='';
            }
        
       searchdatastrAr.push('"local_tz":'+'"'+local_tz_data+'"');
        
        if (reviewof!='')
        {
           
           searchdatastrAr.push('"reviewof":'+'"'+reviewof+'"');
        }
        
        if(seo_name!='')
            {

                searchdatastrAr.push('"seo_name":'+'"'+seo_name+'"');
            }

        if(type_flag!='')
            {

                searchdatastrAr.push('"type_flag":'+'"'+type_flag+'"');
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
        
        var mainsearchposturl=base_url_data+"/getreviewdata";
       
        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
        showmycustomloader(1,'','',"",imfpth);
        
        
        //** ajax call starts here
        
        setTimeout(function(){
            
           
        
        $.ajax({
            
            data:searchdata,
            dataType:"json",
            type:"GET",
            url:mainsearchposturl,
            success:function(d){
                
                //console.log(JSON.stringify(d));
                var respdata=d.respdata;
                var pagination_link=d.pagination_link;
               // var main_srch_union_lim=d.main_srch_union_lim; //alert(main_srch_union_lim);
                
                  $("#review_div_id").html(respdata);
                $("#pagidivid").html(pagination_link);
                
                
                //**** now bind with each li starts
												jQuery('.pagination_outer_cust').find('li').each(function(){
													
													jQuery(this).click(function(){
														
														var pagenumdata=jQuery(this).find('a').data('page');
														if(pagenumdata!='nopage')
														{
															var searchdata="";var pgloadflag=0;
                                                             populateprofilereviewreview(pagenumdata);
														}
														
														});
													
													});
				//**** now bind with each li ends		
                
                 bindaddmoreshowmore();
                 
            }
            
            
            });
        
        
        
             },1000);
            //** ajax call ends here
     
    }

//************************** function to populate review data ends ***********************************

//************************** function to check to  populate review data starts ***********************************
 
 function checktopopulatereviewforArtist()
    {
        bindaddmoreshowmore();
                if(type_flag==1)
                {    
                       // $('#reviewofid').selectpicker('val', 'ASANARTIST');
                       // var pagenumber=1; reviewof='ASANARTIST';        
                       // populateprofilereviewreview(pagenumber);    
                    
                        var chk_reviewof='ASANARTIST';
                    
                        var inputstr='';

                        var searchdatastr='';
                        var searchdatastrAr=[];
                        searchdatastrAr.push('"_token":"'+csrf_token_data+'"');
                        //searchdatastrAr.push('"pagenum":"'+pagenumdata+'"'); // for page number used in pagination                       

                        //*** for filtration purpose starts

                        if (reviewof!='')
                        {

                            searchdatastrAr.push('"reviewof":'+'"'+chk_reviewof+'"'); //reviewof
                        }

                        if(seo_name!='')
                        {

                            searchdatastrAr.push('"seo_name":'+'"'+seo_name+'"');
                        }

                        if(type_flag!='')
                        {

                            searchdatastrAr.push('"type_flag":'+'"'+type_flag+'"');
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

                        var mainsearchposturl=base_url_data+"/checkreviewdatatopopulate";

                        var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                        showmycustomloader(1,'','',"",imfpth);


                        //** ajax call starts here

                        setTimeout(function(){



                        $.ajax({

                        data:searchdata,
                        dataType:"json",
                        type:"GET",
                        url:mainsearchposturl,
                        success:function(d){

                        //console.log(JSON.stringify(d));
                            var tot_rev_recv_as_booker=parseInt(d.tot_rev_recv_as_booker);
                            var tot_rev_recv_as_artgrpven=parseInt(d.tot_rev_recv_as_artgrpven);                        
                            var reviewof_respdata=d.reviewof;
                            
                            //****** call populateprofilereviewreview  to populate  review starts ********************
                            
                            
                            var pagenumber=1; 
                            
                            reviewof='ASANARTIST';  
                            
                            if( (tot_rev_recv_as_artgrpven==0) && (tot_rev_recv_as_booker>0))
                                {
                                     reviewof='ASABOOKER';  
                                    
                                    setTimeout(function(){
                                        
                                        $('#reviewofid').selectpicker('val', 'ASABOOKER');
                                        
                                    },2500);
                                     
                                }
                                  
                            populateprofilereviewreview(pagenumber); 
                            //****** call populateprofilereviewreview  to populate  review ends ********************
                            // bindaddmoreshowmore();

                        }


                        });



                        },1000);
                        //** ajax call ends here
                    
                    
                    
                    
                    
        
                }
        
        
     
    }
    
    
    function bindaddmoreshowmore()
    {        
        
                $('.nwMore').click(function(){
                $('.shortDescription').removeClass('onn');
                $(this).parent().addClass('onn');
                });
                $('.lsMore').click(function(){
                $(this).parent().removeClass('onn');
                });
        
    }
//************************** function to check to  populate review data ends ***********************************

