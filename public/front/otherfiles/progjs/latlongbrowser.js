 // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.

    function getcitytowndatafromlatlong()
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
      
        
        
        if (curr_lat_data!='')
        {
            searchdatastrAr.push('"latidata":'+'"'+curr_lat_data+'"');
        }
        
        
        if (curr_long_data!='')
        {
            searchdatastrAr.push('"longidata":'+'"'+curr_long_data+'"');
        }
      
        
        
        
         
        if (searchdatastrAr.length>0)
        {
            searchdatastr=searchdatastrAr.toString();
        }
        
       // console.log(searchdatastr.length+"=searchdata=>"+searchdatastr);
        
        var searchdatastrObj=JSON.parse("{"+searchdatastr+"}");        
       // console.log("=searchdata=>"+JSON.stringify(searchdatastrObj));
       
        var searchdata=searchdatastrObj;        
        
        var mainsearchposturl=base_url_data+"/mainsearchcitytowndata";
       
       // var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
       // showmycustomloader(1,'','',"",imfpth);
        
        
        //** ajax call starts here
        
        setTimeout(function(){
            
           
        
        $.ajax({
            
            data:searchdata,
            dataType:"json",
            type:"POST",
            url:mainsearchposturl,
            success:function(d){
                
                var user_city=d.user_city;
                
               // console.log("==user_city==>"+user_city);
                
                if(user_city!='')
                {
                  $("#locationtxt").val(user_city);
                }
              
                 
            }
            
            
            });
        
        
        
             },500);
            //** ajax call ends here
       
    
    }


      function getlatlongfrombrowser()
      {
       

        // Try HTML5 geolocation.
        if (navigator.geolocation)
        {
         // console.log('Here');
          navigator.geolocation.getCurrentPosition(function(position) {
           
              //console.log("==latitude==>"+position.coords.latitude+"==longitude=>"+position.coords.longitude);
              curr_lat_data= position.coords.latitude;
              curr_long_data= position.coords.longitude;
           
               getcitytowndatafromlatlong();
              //var  pagenumdata=1;var pgloadflag=0;
              //domainsearch(pagenumdata,pgloadflag);
                  
           
          }, function() {
            //handleLocationError(true, infoWindow, map.getCenter());
            //alert("Your browser doesn\'t support geolocation");
          });
        }
        else
        {
          
          
          // Browser doesn't support Geolocation
          //handleLocationError(false, infoWindow, map.getCenter());
          //alert("Your browser doesn\'t support geolocation.");
        }
      }

      
      
   
   
      