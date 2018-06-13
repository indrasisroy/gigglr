
function bindeventswithcontrol()
{
       //*************************** binding code starts*********************
                              $('.rfn_srch').click(function(){
                              $('.category').slideToggle(300);
                              $(this).toggleClass('on');
                              });
                              
                              
                              //**** bind with search button 
                              $("#srchnowbutnmainid").click(function(){
                                 
                                  var  pagenumdata=1; var pgloadflag=0;
                                  domainsearch(pagenumdata,pgloadflag);
                                  
                                      
                                  
                                  
                                  });
    
                              //**** bind with whowhat control 
                               $("#whowhat").bind("change",function(){        
                              var  pagenumdata=1;var pgloadflag=0;
                              
                               var whowhatdta=$(this).val();
                              
                              var mainsearchdata=$("#mainsearch").val();
                              
                              if(whowhatdta==1)
                               {
                                   //*** change genre and category starts
                                   $("#genre").html("");
                                   $("#genre").selectpicker('refresh');
                                   
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
                                           // $("#category option[value="+selectcategnmid+"]").attr('selected',true);                                    
                                           //console.log("==>"+categ_opt);                                    
                                           $("#category").selectpicker('refresh');
                                   }
                                   //*** change genre and category ends
                                   
                                   
                               }
       
       
                                             if (mainsearchdata!='')
                                             {    
                                              
                                                  domainsearch(pagenumdata,pgloadflag);
                                             }
                                              
                                              });            
                                                    
                                          
                                          
                                          
                                                       //*** for category onload bind starts   
                                                     
                                                      $('#category').on('change',function(evnt){
                                                          
                                                         // alert($(this).val());
                                                         
                                                         var whowhatdta=  $("#whowhat").val();
                                                          
                                                         var  categorydata=$(this).val();
                                                         var  mainsearchdta= $("#mainsearch").val();
                                                         
                                                         var categorydata=$( "#category option:selected" ).text();
                                                         var categoryiddata=$(this ).val();
                                                                    
                                                          
                                                         if (categorydata!='' && categorydata!=null)
                                                         {
                                                                 if(whowhatdta==2  )
                                                                 {
                                                                    $("#mainsearch").val(categorydata);
                                                                 }
                                                                 
                                                                 
                                                                 $("#genre").html("");
                                                                 $("#genre").selectpicker('refresh');
                                                                                          
                                                                              
                                                                 populategenre(categoryiddata);
                                                                 
                                                                 var pgloadflag=0;
                                                                 domainsearch('1',pgloadflag);
                                                         }
                                                         else
                                                         {
                                                                              $("#genre").html("");
                                                                              $("#genre").selectpicker('refresh');
                                                         }
                                                          
                                                          
                                                          });
                                                     
                                                     //*** for category onload bind ends
                                                     
                                                     //*** for genre onload bind starts   
                                                     
                                                      $('#genre').on('change',function(evnt){
                                                          
                                                         // alert($(this).val());
                                                          var whowhatdta=  $("#whowhat").val(); 
                                                         var  genredata=$(this).val();
                                                         
                                                          var genredata=$( "#genre option:selected" ).text();
                                                          
                                                          
                                                          if(whowhatdta==2)
                                                          {
                                                           $("#mainsearch").val(genredata);
                                                          }
                                                         
                                                         var pgloadflag=0;
                                                                     domainsearch('1',pgloadflag);
                                                         
                                                        
                                                          
                                                          });
                                                     
                                                     //*** for genre onload bind ends
                                                     
                                                     //*** for on blur mainsearch starts
                                                     
                                                     $("#mainsearch").on("blur",function(){
                                                        
                                                     //$("#genre").html('');              
                                                     //$("#category option:selected").prop("selected", false);//deselect category
                                                     
                                                                    });
                                                     //*** for on blur mainsearch ends
                                                     
                                                      //*** for booktime bind starts   
                                                      //$('#booktime').data("DateTimePicker").destroy();
                                                      $("#booktime").datetimepicker({
                                                      format: 'LT'
                                                      });
                                                      
                                                       $('#booktime').bind("dp.hide",function(e){
                                                          
                                                         console.log(e.date);
                                                         
                                                         var curbooktime=e.date;
                                                         if (curbooktime!=null)
                                                         {
                                                             var getcurtime=curbooktime.format("HH:mm" );                    
                                                            available_time=getcurtime;
                                                            console.log("==getcurtime==>"+getcurtime+"==available_time==>"+available_time);
                                                            
                                                             var  pagenumdata=1;var pgloadflag=0;
                                                            domainsearch(pagenumdata,pgloadflag);
                                                         }
                                                        
                                                          
                                                      });
                                                       
                                                     $('#booktime').data("DateTimePicker").disable();  
                                                      
                                                      //*** for booktime bind ends
                                                     
                                                     
                                                     //*** for bookdate bind starts
                                                      var bookcur = new Date();
                                                      //bookcur.setDate(datecur.getDate() + 7);
                                                      
                                                      //$('#bookdate').data("DateTimePicker").destroy();
                                                      $('#bookdate').datetimepicker({
                                                      format: 'DD/MM/YYYY',
                                                      //minDate:"05/24/2016"              
                                                      
                                                      });
                                                       $('#bookdate').bind("dp.hide",function(e){
                                                          
                                                         console.log(e.date);
                                                         
                                                        var curbookdate=e.date;
                                                        
                                                        if (curbookdate!=null)
                                                        {
                                                           
                                                        
                                                            var getcurdt=curbookdate.format("YYYY-MM-DD" );               
                                                            available_date=getcurdt;
                                                         
                                                            console.log("=getcurdt=>"+getcurdt+"==available_date=>"+available_date);
                                                               
                                                             $('#booktime').data("DateTimePicker").enable();  // enable time
                                                             
                                                             //if (available_time!='')
                                                             //{
                                                             //          var  pagenumdata=1;var pgloadflag=0;
                                                             //          domainsearch(pagenumdata,pgloadflag);
                                                             //}
                                                             
                                                             var  pagenumdata=1;var pgloadflag=0;
                                                              domainsearch(pagenumdata,pgloadflag);
                                                         
                                                        }
                                                           
                                                          
                                                          });
                                                      //*** for bookdate bind ends
                                      
                                                     
                                                     
                                                     //**** assign lat long starts
                                                     if(logID=='')
                                                     {
                                                            getlatlongfromjsapi();
                                                            getlatlongfrombrowser();
                                                     }
                                                      //**** assign lat long starts
                                                      
                                                     //**** onload call starts        
                                                     setTimeout(function(){
                                                     
                                                     
                                                     //var  pagenumdata=1;var pgloadflag=1;
                                                     //domainsearch(pagenumdata,pgloadflag);
                                                     
                                                     
                                                     },1500);
                                                     //**** onload call ends
                                                     
                                                     //**** for radius  search bind srchradius starts
                                                     
                                                    // $("#srchradius").slider('destroy');
                                                     $('#srchradius').slider({
                                                     
                                                     tooltip_position:'bottom',
                                                     formatter: function(value) {
                                                                    
                                                                    //distance_data=value;
                                                                    ////console.log(" from distance slider event change ");
                                                                    //var  pagenumdata=1;var pgloadflag=0;
                                                                    //domainsearch(pagenumdata,pgloadflag);
                                                     
                                                                     return value + 'KM ';
                                                     }
                                                     });
                                                     
                                                     $("#srchradius").on("slideStop", function(slideEvt) {
                                                     
                                                     //console.log("slide ===>"+slideEvt.value);               
                                                     distance_data=slideEvt.value;
                                                     var  pagenumdata=1;var pgloadflag=0;
                                                     domainsearch(pagenumdata,pgloadflag);
                                                     
                                                     
                                                     
                                                     });
                                                     
                                                    
                                                     
                                                     //**** for radius  search bind srchradius ends
                              
                              
                                                            
                              //// ************ random home search section starts ************ ////
               
               $(".homesearchbyskillid").click(function(){
                              
                              console.log("inside homesearchbyskillid button");
                              
                              var hidsklid = $(this).data("skillid");
                              var hidsklnm = $(this).data("skillnm");
                              var whowhatval = '2';
                              
                              if (hidsklid!='' && hidsklid!='0') {
                                             
                                          //     console.log(" from home srch button section : hidsklid=>"+hidsklid+"=hidsklnm=>"+hidsklnm+"=whowhatval=>"+whowhatval);
                                          
                                          //*****for refreshing whowhat starts
                                                          
                                                            var whowhat_opt=''; var whowhat_optAr=[];
                                                            $("#whowhat option").each(function()
                                                            {
                                                            if ($(this).val()!='')
                                                            {
                                                             var opt_dta="<option value='"+$(this).val()+"'>"+$(this).text()+"</option>";
                                                             whowhat_optAr.push(opt_dta);
                                                            }
                                                            
                                                            });
                                                            
                                                            if (whowhat_optAr.length>0)
                                                            {
                                                            whowhat_opt=whowhat_optAr.join('');
                                                            }
                                                            
                                                            if (whowhat_opt!='')
                                                            {
                                                            
                                                                           $("#whowhat").html(whowhat_opt);
                                                                           $("#whowhat option[value="+whowhatval+"]").attr('selected',true);                                    
                                                                           //console.log("= before whowhat refre==>"+whowhatval);                                    
                                                                           $("#whowhat").selectpicker('refresh');                                                                           
                                                                          // console.log("= after whowhat refre==>"+whowhatval);  
                                                            }
                           
                                             //*****for refreshing whowhat ends
                                          
                                               
                                          
                                             
                                             $("#category option:selected").prop("selected", false);//deselect category
                                             $("#category").selectpicker('refresh');
                                             
                                             $("#genre").html("");
                                             $("#genre").selectpicker('refresh');
                                             
                                             
                                             $("#mainsearch").val(hidsklnm);
                                             
                                             
                                             //*** reinitialize slider starts
                                           
                                           
                                              
                                             var rein_sldr=$("#srchradius").slider({
                                                     
                                                     tooltip_position:'bottom',
                                                     formatter: function(value) {                                                  
                                                     
                                                                     return value + 'KM ';
                                                     
                                                     },
                                                      min:0,
                                                      max:parseInt(max_radius_limit),
                                                      value:parseInt(default_radius)
                                                     
                                                     });

                                              
                                             rein_sldr.data('slider').setValue(parseInt(default_radius));
                                             
                                             //*** reinitialize slider ends
                                             
                                                                                       
                                             $('#bookdate').data("DateTimePicker").clear();    // clear date
                                             $('#booktime').data("DateTimePicker").clear();    // clear time
                                             $('#booktime').data("DateTimePicker").disable();  // disable time
                                             
                                             distance_data=''; 	 available_date='';	 available_time='';
                                             
                                             $( "#srchnowbutnmainid" ).trigger( "click" );
                                                   
                                             
                                             
                                             
                                             
                              }
               });
               
               $(window).resize();              
                              
                              
                                                      //*** for bookdate bind ends
               
                              //// ************ random home search section ends ************ ////
                              
                              
                              
                             var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif";
                             showmycustomloader(0,'100','2000',"",imfpth);  
                              
                              //******************************** binding code ends********************         
}

function populatebanner()
    {
               //**** call ajax to populate banner starts
               var searchdatastrAr=[];
               searchdatastrAr.push('"_token":"'+csrf_token_data+'"');
               
               
              var searchdatastr='';
               
               if (searchdatastrAr.length>0)
               {
                 searchdatastr=searchdatastrAr.toString();
               }
               
               // console.log(searchdatastr.length+"=searchdata=>"+searchdatastr);
               
               var searchdatastrObj=JSON.parse("{"+searchdatastr+"}");        
               // console.log("=searchdata=>"+JSON.stringify(searchdatastrObj));
               
               var callurlwithdata=searchdatastrObj;
               
               //console.log("inside populatessubkill 1 ...");
               //**** call ajax to populate date to skill_sub starts
               
               var callingurl=base_url_data+"/"+"frontendlandingajx";
              // var callurlwithdata={_token:csrf_token_data,parent_id:skill_parent_data};
               
               $.ajax({
                    url:callingurl,
                    data:callurlwithdata,
                    type:'POST',
                    dataType:'JSON',
                    success:function(d){
                         
                         //console.log(JSON.stringify(d));
                         
                         var respdatastr=d.respdatastr;
                         var landinghmsrchcontent=d.landinghmsrchcontent;
                         
                         if (d!=null)
                         {
                                                    
                                                           
                            $("#bannercntntdvsrchid").html(respdatastr); // populate banner data
                              
                             
                            $("#bannermddleid").fadeIn(600,"swing",function(){
                              
                              $("#bannermddleid").removeClass("mydisplaynone");
                              $("#welcomesecid").removeClass("mydisplaynone");
                              
                              
                              //******* banner search  related  control initialization for looks  starts
                              
                              //*****for refreshing whowhat starts
                                                          
                                                            var whowhat_opt=''; var whowhat_optAr=[];
                                                            $("#whowhat option").each(function()
                                                            {
                                                            if ($(this).val()!='')
                                                            {
                                                             var opt_dta="<option value='"+$(this).val()+"'>"+$(this).text()+"</option>";
                                                             whowhat_optAr.push(opt_dta);
                                                            }
                                                            
                                                            });
                                                            
                                                            if (whowhat_optAr.length>0)
                                                            {
                                                            whowhat_opt=whowhat_optAr.join('');
                                                            }
                                                            
                                                            if (whowhat_opt!='')
                                                            {
                                                                           var loadwhowhatval='2';
                                                            
                                                                           $("#whowhat").html(whowhat_opt);
                                                                           $("#whowhat option[value="+loadwhowhatval+"]").attr('selected',true);                                    
                                                                           //console.log("= before whowhat refre==>"+whowhatval);                                    
                                                                           $("#whowhat").selectpicker('refresh');                                                                           
                                                                          // console.log("= after whowhat refre==>"+whowhatval);  
                                                            }
                           
                                             //*****for refreshing whowhat ends
                                          
                                               
                                          
                                             
                                             $("#category option:selected").prop("selected", false);//deselect category
                                             $("#category").selectpicker('refresh');
                                             
                                             $("#genre").html("");
                                             $("#genre").selectpicker('refresh');
                              
                              //******* banner search  related  control initialization for looks  ends
                              
                              
                              
                              
                              $("#demoserchomesrchid").html(landinghmsrchcontent); // populate home srch category  content data
                              
                              //*** bind for hmsrch callendar starts
                              setTimeout(function(){
                              
                            
                              $(".hmsrchbookdate").datetimepicker({
                              format: 'DD/MM/YYYY',
                              keepOpen: true,
                              
                              });
                              
                              
                              //$(".hmsrchbookdate").datetimepicker({
                              //format: 'DD/MM/YYYY',
                              //inline: true,                              
                              //keepOpen: true,                              
                              //debug:true
                              //});
                              
                              
                              $('.hmsrchbookdate').bind("dp.hide",function(e){
                              
                              console.log("date has been selected from home srch section");
                              
                              var curbookdate=e.date;
                              
                              if (curbookdate!=null)
                              {
                               //******** logic of clearing date time sliding   data and assigning and trigerring search starts        
                                             var getcurdt=curbookdate.format("YYYY-MM-DD" );               
                                             available_date=getcurdt;
                                             
                                             
                                            // $(this).parent().parent().find(".homesearchbyskillid").trigger('click');
                                                                                    
                                            
                                            var hidsklid = $(this).parent().parent().find(".homesearchbyskillid").data("skillid");
                                            var hidsklnm = $(this).parent().parent().find(".homesearchbyskillid").data("skillnm");
                                            var whowhatval = '2';
                              
                                             if (hidsklid!='' && hidsklid!='0')
                                             {
                                                       //console.log("date from home srch section : hidsklid=>"+hidsklid+"=hidsklnm=>"+hidsklnm+"=whowhatval=>"+whowhatval);     
                                                          
                                                          //*****for refreshing whowhat starts
                                                          
                                                            var whowhat_opt=''; var whowhat_optAr=[];
                                                            $("#whowhat option").each(function()
                                                            {
                                                            if ($(this).val()!='')
                                                            {
                                                             var opt_dta="<option value='"+$(this).val()+"'>"+$(this).text()+"</option>";
                                                             whowhat_optAr.push(opt_dta);
                                                            }
                                                            
                                                            });
                                                            
                                                            if (whowhat_optAr.length>0)
                                                            {
                                                            whowhat_opt=whowhat_optAr.join('');
                                                            }
                                                            
                                                            if (whowhat_opt!='')
                                                            {
                                                            
                                                                           $("#whowhat").html(whowhat_opt);
                                                                           $("#whowhat option[value="+whowhatval+"]").attr('selected',true);                                    
                                                                           //console.log("= before whowhat refre==>"+whowhatval);                                    
                                                                           $("#whowhat").selectpicker('refresh');                                                                           
                                                                          // console.log("= after whowhat refre==>"+whowhatval);  
                                                            }
                           
                                                           //*****for refreshing whowhat ends
                                                          
                                                            
                                                            //$("#whowhat option:selected").prop("selected", false);//deselect category
                                                            //$("#whowhat option[value="+whowhatval+"]").attr("selected", true);//deselect category
                                                            //$("#whowhat").selectpicker('refresh');
                                                            
                                                            $("#category option:selected").prop("selected", false);//deselect category
                                                            $("#category option[value="+hidsklid+"]").attr("selected", true);//deselect category
                                                            
                                                            $("#category").selectpicker('refresh');
                                                            
                                                            $("#genre").html("");
                                                            $("#genre").selectpicker('refresh');
                                                            
                                                            
                                                            $("#mainsearch").val(hidsklnm);
                                                            
                                                            
                                                            //*** reinitialize slider starts
                                                          
                                                          
                                                             
                                                            var rein_sldr=$("#srchradius").slider({
                                                                    
                                                                    tooltip_position:'bottom',
                                                                    formatter: function(value) {                                                  
                                                                    
                                                                                    return value + 'KM ';
                                                                    
                                                                    },
                                                                     min:0,
                                                                     max:parseInt(max_radius_limit),
                                                                     value:parseInt(default_radius)
                                                                    
                                                                    });
               
                                                             
                                                            rein_sldr.data('slider').setValue(parseInt(default_radius));
                                                            
                                                            //*** reinitialize slider ends
                                                            
                                                                                                      
                                                            $('#bookdate').data("DateTimePicker").clear();    // clear date
                                                            $('#booktime').data("DateTimePicker").clear();    // clear time
                                                            $('#booktime').data("DateTimePicker").disable();  // disable time
                                                            
                                                            distance_data='';
                                                            //available_date='';
                                                           // available_time='';
                                                           
                                                           var makedtpickerdtfrmt=curbookdate.format("DD/MM/YYYY" );
                                                           console.log("=makedtpickerdtfrmt=>"+makedtpickerdtfrmt);
                                                           $("#bookdate").val(makedtpickerdtfrmt  );
                                                           $("#bookdate").data("DateTimePicker").defaultDate(makedtpickerdtfrmt);
                                                           //$("#bookdate").data("DateTimePicker").options({defaultDate:makedtpickerdtfrmt});
                                                            
                                                            $( "#srchnowbutnmainid" ).trigger( "click" );
                                                          //  defaultDate  //'DD/MM/YYYY',
                                                         
                                                 }
                                            
                                            
                              //******** logic of clearing date time sliding   data and assigning and trigerring search ends  
                                       
                              
                              }
                              
                              
                              });
                              
                              },1000);      
                              //*** bind for hmsrch callendar ends
                              
                               
                              
                              });  
                            
                              setTimeout(function(){
                               
                              bindeventswithcontrol();
                               
                                             
                              },1000);                             
                              
                             
                         }                                        
                         
                         
                     
                        
                         
                    }
                    
                    });
               
               
              
                                             
                    //**** call ajax to populate banner ends
    }

function populategenre(skill_parent_data)
    {
          
                   if (skill_parent_data!='' && skill_parent_data!=null)
                   {
                              var searchdatastrAr=[];
                              searchdatastrAr.push('"_token":"'+csrf_token_data+'"');
                              searchdatastrAr.push('"parent_id":"'+skill_parent_data+'"');
                              
                             
                             
                             var searchdatastr='';
                              
                              if (searchdatastrAr.length>0)
                              {
                                searchdatastr=searchdatastrAr.toString();
                              }
                              
                              // console.log(searchdatastr.length+"=searchdata=>"+searchdatastr);
                              
                              var searchdatastrObj=JSON.parse("{"+searchdatastr+"}");        
                              // console.log("=searchdata=>"+JSON.stringify(searchdatastrObj));
                              
                              var callurlwithdata=searchdatastrObj;       
                              
                              
                              //console.log("inside populatessubkill 1 ...");
                              //**** call ajax to populate date to skill_sub starts
                              
                              var callingurl=base_url_data+"/"+"mainsearchgenre";
                             // var callurlwithdata={_token:csrf_token_data,parent_id:skill_parent_data};
                              
                              $.ajax({
                                   url:callingurl,
                                   data:callurlwithdata,
                                   type:'POST',
                                   dataType:'JSON',
                                   success:function(d){
                                        
                                        //console.log(JSON.stringify(d));
                                        
                                        var subskillopt="";
                                        
                                        if (d!=null)
                                        {
                                            $.each(d, function(idx, obj)
                                                   {
                                                           
                                                 
                                                  subskillopt+="<option value='"+obj.id+"'>"+obj.name+"</option>";
                                                  
                                                  });
                                            
                                            
                                        }                                        
                                        
                                        $("#genre").html(subskillopt);
                                        
                                        if (selectcategnmid!='' &&  selectgenrenmid!='')
                                        {
                                              $("#genre option[value="+selectgenrenmid+"]").attr('selected','selected');
                                        
                                        }
                                        
                                        
                                        $("#genre").selectpicker('refresh');
                                       
                                        
                                   }
                                   
                                   });
                              
                              //**** call ajax to populate date to skill_sub ends
                              
                   }
                   else
                   {
                                        console.log("inside populatessubkill 2 ...");
                                  
                                        $("#genre").html("");
                                        $("#genre").selectpicker('refresh');
                                          //console.log(skill_parent_data+"===refreshed sub ");
                   }
    }
$(document).ready(function(){
      
      footerarea_css(); 
     var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
     showmycustomloader(1,'','',"",imfpth);
     
     $("#bannercntntdvsrchid").fadeIn("600","linear",function(){
                              
                          populatebanner();
                          
                            
                            
                            });
    
               
               
               
                  
   
    
              
    
    });