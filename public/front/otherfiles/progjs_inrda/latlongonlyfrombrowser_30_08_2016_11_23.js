 // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.

      function getlatlongfrombrowser()
      {
       

        // Try HTML5 geolocation.
        if (navigator.geolocation)
        {
          
          navigator.geolocation.getCurrentPosition(function(position) {
           
              console.log("==latitude==>"+position.coords.latitude+"==longitude=>"+position.coords.longitude);
              curr_lat_data= position.coords.latitude;
              curr_long_data= position.coords.longitude;
           
              //**** call callnedar  and populate left pannel starts
              $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar
              
              var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
              showmycustomloader(1,'','',"Please wait . Its loading ...",imfpth);
              
              clickedformagnify=true; 
              renderCustCalendarRoster(selecteddate);
              
               cal_select_date=selecteddate;
                loadGigGuideLeftPannel();
              
              //**** call callnedar  and populate left pannel ends
                  
           
          }, function() {
            //handleLocationError(true, infoWindow, map.getCenter());
            alert("Your browser doesn\'t support geolocation.");
          });
        }
        else
        {
          
          
          // Browser doesn't support Geolocation
          //handleLocationError(false, infoWindow, map.getCenter());
          alert("Your browser doesn\'t support geolocation.");
        }
      }

      
      
   
   
      