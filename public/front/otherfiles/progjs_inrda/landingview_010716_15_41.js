
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
                                                                 if(whowhatdta==2 && mainsearchdta=='' )
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
                                                          
                                                         var  genredata=$(this).val();
                                                         
                                                          var genredata=$( "#genre option:selected" ).text();
                                                           $("#mainsearch").val(genredata);
                                                         
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
                                                      
                                                       $('#booktime').bind("dp.change",function(e){
                                                          
                                                         console.log(e.date);
                                                         
                                                         var curbooktime=e.date;
                                                         var getcurtime=curbooktime.format("HH:mm" );                    
                                                         available_time=getcurtime;
                                                         console.log("==getcurtime==>"+getcurtime+"==available_time==>"+available_time);
                                                         
                                                          var  pagenumdata=1;var pgloadflag=0;
                                                         domainsearch(pagenumdata,pgloadflag);
                                                          
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
                                                       $('#bookdate').bind("dp.change",function(e){
                                                          
                                                         console.log(e.date);
                                                         
                                                        var curbookdate=e.date;
                                                        var getcurdt=curbookdate.format("YYYY-MM-DD" );               
                                                        available_date=getcurdt;
                                                     
                                                        console.log("=getcurdt=>"+getcurdt+"==available_date=>"+available_date);
                                                           
                                                         $('#booktime').data("DateTimePicker").enable();  // enable time
                                                         
                                                         if (available_time!='')
                                                         {
                                                                   var  pagenumdata=1;var pgloadflag=0;
                                                                   domainsearch(pagenumdata,pgloadflag);
                                                         }
                                                         
                                                           
                                                          
                                                          });
                                                      //*** for bookdate bind ends
                                      
                                                     
                                                     
                                                     //**** assign lat long starts
                                                      getlatlongfromjsapi();
                                                      getlatlongfrombrowser();
                                                      //**** assign lat long starts
                                                      
                                                     //**** onload call starts        
                                                     setTimeout(function(){
                                                     
                                                     
                                                     var  pagenumdata=1;var pgloadflag=1;
                                                     domainsearch(pagenumdata,pgloadflag);
                                                     
                                                     
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
                              
                              
                              
                              
                              var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                             showmycustomloader(0,'100','2000',"Please wait . Its loading ...",imfpth);  
                              
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
                              
                              $("#demoserchomesrchid").html(landinghmsrchcontent); // populate home srch category  content data
                              
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
     showmycustomloader(1,'','',"Please wait . Its loading ...",imfpth);
     
     $("#bannercntntdvsrchid").fadeIn("600","linear",function(){
                              
                          populatebanner();
                          
                            
                            
                            });
    
               
               
               
                  
   
    
              
    
    });