<?php include('config.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <title>Loading Markers from MySQL Database and Display Them on Google Maps</title>
  <style>
  #map{
    background: #ccc;
    height: 600px;
    width: 800px;
    margin: auto;
  }

  .marker-desc{
    width: 300px;
    min-height: 40px;
    text-align: justify;
    color: #333;
    font-size: 14px;
  }

  .button-map{
    background: #333;
    color: #fff;
    border: 1px solid #333;
    border-radius: 20px;
    padding: 10px 30px;
    margin-bottom: 20px;
  }

  .button-map:hover{
    cursor: pointer;
    background: #fff;
    color: #333;
    transition: all 0.5s;
  }
  </style>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAvipLM2vFAwgLRnaw55gvaqAwkzg5VYg&callback=initMap" async defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <script>
  var map_data;
  var map;
  var infoWindow;

  function fetch_data(){
    var response = '';
    $.ajax({
      type: "GET",
      url: "map_data.php",
      async: false,
      success : function(text){
        response = text;
      }
    });
    return response;
  }

  map_data = jQuery.parseJSON(fetch_data());

  function initMap(){
    map = new google.maps.Map(document.getElementById("map"), {
      center: new google.maps.LatLng(45.812897, 15.97706),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
  }

  function map_function(){
    infoWindow = new google.maps.InfoWindow();
    //Adding Markers
    for(var i=0;  i<map_data.length; i++){
      var data = map_data[i];
      latLng = new google.maps.LatLng(data.lat, data.lon);

      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: data.name
      });

      (function (marker, data) {
        google.maps.event.addListener(marker, "click", function (e) {
          //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
          infoWindow.setContent("<div class = 'marker-desc'>" + data.description + "</div>");
          infoWindow.open(map, marker);
        });
      })(marker, data);

    }

  }
  </script>

</head>

<body>

<center><button class="button-map" onclick="map_function()">Load Data</button></center>

<div id="map"></div>

</body>
</html>
