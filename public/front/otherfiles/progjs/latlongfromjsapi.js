 function getlatlongfromjsapi()
    {
      // this is needed to be included //https://www.google.com/jsapi?key
      
        if (google.loader.ClientLocation)
        {
          //console.log(google.loader);
          var latitude = google.loader.ClientLocation.latitude;
          
          var longitude = google.loader.ClientLocation.longitude;
          var city = google.loader.ClientLocation.address.city;
          var country = google.loader.ClientLocation.address.country;
          var country_code = google.loader.ClientLocation.address.country_code;
          var region = google.loader.ClientLocation.address.region;
          
          //var text = 'Your Location<br /><br />Latitude: ' + latitude + '<br />Longitude: ' + longitude + '<br />City: ' + city + '<br />Country: ' + country + '<br />Country Code: ' + country_code + '<br />Region: ' + region;
        
          curr_lat_data=latitude;
          curr_long_data=longitude;
          
          //console.log("=curr_lat_data=>"+curr_lat_data+"==curr_long_data==>"+curr_long_data);
        
        }
        else
        {
            //console.log("google loader ClientLocation not working might be");
        }
   
    }
    