<?php
	$successmsg='';$errormsg='';
	if(!empty($successmsgdata))
	{
		$successmsg=$successmsgdata;
	}
	if(!empty($errormsgdata))
	{
		$errormsg=$errormsgdata;
	}
?>


  	
<!-- profile-section-start -->
	
<section id="faqsecid" class="profile_outer text-center">
	<div class="container">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">	
			</div>
		</div>	
		<div class="row">	

		asasdasd


		</div>	
		<div id="map" class="prf_venue_map mapclass" style="height:500px;
  width:100%;"></div>
		<div class="row">
		</div>
		<div id="accordion" class="panel-group row">
		
		</div>
	</div>
</section>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>

$(document).ready(function(){
	google.maps.event.addDomListener(window, 'load', initialize(22.572646,88.363895));
})
	
</script>
<!-- AIzaSyDWE3PmXCnLTLvI8526Lo1U_GiYcVLuzBA
AIzaSyCGwmW20c0PQy4bqgPTj8HIZac_rPrCs78 -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWE3PmXCnLTLvI8526Lo1U_GiYcVLuzBA"></script>

<script type="text/javascript">

 var map;
  function initialize(ltude,lngtude) {

   if(ltude == '' && lngtude== '')
   {
    ltude = -33.868820;
    lngtude = 151.209296;

   }



        var mapOptions = {
          zoom: 16,
          center: {lat: ltude, lng: lngtude}
        };
        map = new google.maps.Map(document.getElementById('map'),
            mapOptions);

        var marker = new google.maps.Marker({
          // The below line is equivalent to writing:
          // position: new google.maps.LatLng(-34.397, 150.644)
          position: {lat: ltude, lng: lngtude},
          map: map
        });

        // You can use a LatLng literal in place of a google.maps.LatLng object when
        // creating the Marker object. Once the Marker object is instantiated, its
        // position will be available as a google.maps.LatLng object. In this case,
        // we retrieve the marker's position using the
        // google.maps.LatLng.getPosition() method.
        var infowindow = new google.maps.InfoWindow({
          content: '<p>Marker Location:' + marker.getPosition() + '</p>'
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map, marker);
        });
      }


</script>




		

