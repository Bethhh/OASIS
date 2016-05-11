<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title>OASIS Map</title>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="http://d3js.org/d3.geo.tile.v0.min.js"></script>
    <script src="http://d3js.org/topojson.v1.min.js"></script>
    <script src="http://libs.cartocdn.com/cartodb.js/v2/cartodb.js"></script>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
    <script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>

    <script type="text/javascript" src="./js/leaflet-heatmap.js"></script>
    <script type="text/javascript" src="./js/heatmap.min.js"></script>

        <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/scrolling-nav.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <style type="text/css">
 
    body {
      padding: 0;
      margin: 0;
    }
    html, body, #map {
      height: 100%;
    }  background:black;
    }
    #map {
      position: absolute;
      z-index: 0;
    }
    #popup {
      position: absolute;
      z-index: 2;
      background-color: white;
    }
    svg:active {
      cursor: move;
      cursor: -moz-grabbing;
      cursor: -webkit-grabbing;
    }
    circle {
      fill: none;
      z-index: 1;
      stroke-width: 1.5px;
    }
    /*#first_layer path {
      fill-opacity:0.8;
      fill: none;
      stroke: black;
      stroke-width:0.5px;
      stroke-linecap: round;
      stroke-linejoin: round;
    }*/
    .stroke {
      fill: none;
      stroke: white;
      stroke-width: 0.5px;
    }
    .countries :hover {
      fill: orange;
      stroke-width: 2.5px;
    }
    .leaflet-marker-icon.profileMarker{
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
    }
</style>
 
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

       <div id="map"></div>
    
<script>

    var cfg = {
      // radius should be small ONLY if scaleRadius is true (or small radius is intended)
      // if scaleRadius is false it will be the constant radius used in pixels
      "radius": 5,
      "maxOpacity": .8, 
      // scales the radius based on map zoom
      "scaleRadius": true, 
      // if set to false the heatmap uses the global maximum for colorization
      // if activated: uses the data maximum within the current map boundaries 
      //   (there will always be a red spot with useLocalExtremas true)
      "useLocalExtrema": true,
      // which field name in your data represents the latitude - default "lat"
      latField: 'lat',
      // which field name in your data represents the longitude - default "lng"
      lngField: 'longitude',
      // which field name in your data represents the data value - default "value"
      valueField: 'ph'
    };



    function success(data){
      console.log("Yay");
      console.log(data);
      //console.log(JSON.parse(data));
    }
     
    //var sql = new cartodb.SQL({ user: 'viz2', format: 'geojson', dp: 5});
    //console.log("sql");
    //console.log(sql);

    var width = 1100,                  //svg/map width and height
        height = 600;


    var mapboxURL = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}';
    var ac = 'pk.eyJ1IjoiYmV0aHNoaSIsImEiOiJjOTg3MmVmMThjNDA3ZWNlZGFiMzQxYzVmMWE5MTA0YSJ9.m1VNax_7vNjkZVXuUY69Gw';
    var mapattr = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> , Imagery © <a href="http://mapbox.com">Mapbox</a>';

    var mapid_bike = 'bethshi.c9cd002c';
    var mapid_streets = 'bethshi.m99m2dgg';


    var init_zoom = 13;

    var map_base = L.map('map').setView([-41.2858, 174.7868], init_zoom); //svg need setView to work

    var heatmapLayer = new HeatmapOverlay(cfg);

    L.tileLayer(mapboxURL, {
      attribution: mapattr,
      maxZoom: 18,
      id: mapid_streets,
      accessToken: ac
    }).addTo(map_base);

    
    map_base.locate({setView: true, maxZoom: 5});
    
    function onLocationFound(e) {
      var radius = e.accuracy / 2;
      console.log(e);


      // var userIcon = L.icon({
      //     iconUrl: 'user.png',
      //     iconSize:     [60, 70], // size of the icon
      //     shadowSize:   [70, 70], // size of the shadow
      //     iconAnchor:   [30, 69], // point of the icon which will correspond to marker's location
      //     shadowAnchor: [5, 65],  // the same for the shadow
      //     popupAnchor:  [-1, -69] // point from which the popup should open relative to the iconAnchor
      // });

      // Current user profile pic (TODO handle profile pic selection)
      var UserIcon = L.Icon.Default.extend({
        options: {
          iconSize:     [32, 32], // size of the icon   20/25
          iconAnchor:   [15, 60], // point of the icon which will correspond to marker's location  10/40
          popupAnchor:  [0, -65]
        }
      });
      var user_pic = new UserIcon({iconUrl: 'test.png'});


      // Extend the default icon to make it bigger
      L.Icon.Big = L.Icon.Default.extend({
          options: {
          iconSize:     [40, 60],
          iconAnchor:   [20, 65], // point of the icon which will correspond to marker's location
          //popupAnchor:  [0, -65] // point from which the popup should open relative to the iconAnchor
      }});
      var bigIcon = new L.Icon.Big();

      // default marker (pinpoint loc)
      L.marker(e.latlng, {icon: bigIcon}).addTo(map_base);
      // User profile marker (binds the popup)
      var u = L.marker(e.latlng, {icon: user_pic}).addTo(map_base).bindPopup("You are within " + radius + " meters from this point").openPopup();
      
      // Make user profile pic circular
      $(u._icon).addClass('profileMarker');

      L.circle(e.latlng, radius).addTo(map_base);
    }

    function onLocationError(e) {
      alert(e.message);
    }

    map_base.on('locationfound', onLocationFound);
    map_base.on('locationerror', onLocationError);

    
  
    function getOSM(lat, lng, level){
       //console.log("lat="+ lat + " lng=" + lng);

       var bike = L.tileLayer(mapboxURL, {
          attribution: mapattr,
          maxZoom: 18,
          id: mapid_bike,
          accessToken: ac
       });

       var streets = L.tileLayer(mapboxURL, {
          attribution: mapattr,
          maxZoom: 18,
          id: mapid_streets,
          accessToken: ac
       });

       var data_point = L.marker([lat, lng]).bindPopup("Here");
       var points = L.layerGroup([data_point]);

       //var map = L.map('popup').setView([lat, lng], 13);
       var map = L.map('popup',{
          center: [lat, lng],
          zoom:level,
          layers: [bike, streets, heatmapLayer]
       });

       var baseMaps = {
            "Bike": bike,
            "Streets": streets
       };

       var overlayMaps = {
            "Points": points
       };
       L.control.layers(baseMaps, overlayMaps).addTo(map);
       heatmapLayer.setData(testData);

    }

    // TODO check if location of data points are correct (initial + zoom)
    // function redraw() {
    //   svg.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
    // }
    

    /* Initialize the SVG layer */
    map_base._initPathRoot();  

    /* We simply pick up the SVG from the map object */
    //var svg = d3.select("#map").select("svg"),

    var svg = d3.select("#map").select("svg"); 
                //.call(d3.behavior.zoom());
                //.on("zoom", redraw));
    var g = svg.append("g");

    //var earthquakes;
    // sql.execute("SELECT the_geom, quakedate, magnitude FROM {{table_name}} WHERE the_geom IS NOT NULL ORDER BY quakedate ASC", {table_name: 'earthquaked3'})
    //   .done(function(collection) {
    //     earthquakes = collection.features;
    //     console.log(collection);
    //     quake();
    //   });


    var earthquakes;
    var recent_upload= {};
    $(document).ready(function(){
      var url="http://52.53.177.54/getgeonumjson.php?num=20&callback=?";
      $.getJSON(url,function(data){
        recent_upload["features"] = [];
        $.each(data, function(i,geo){
          var item = {};
          item["geometry"] = {};
          item["geometry"]["type"] = "Point";
          item["geometry"]["coordinates"] = [Number(geo.longitude), Number(geo.lat)];
          item["properties"] = {};
          item["properties"]["uploadtime"] = geo.time;
          recent_upload["features"][i] = item;
        });
        console.log(recent_upload);
        earthquakes = recent_upload.features;
        quake();
      });
    });

    //52.53.177.54/getgeophjson.php
    var testData = {};
    $(document).ready(function(){
      var url="http://52.53.177.54/getgeophjson.php?callback=?";
      $.getJSON(url,function(data){
        testData["data"] = data
        // geojson["features"] = [];
        // $.each(data, function(i,geo){
        //   var item = {};
        //   item["geometry"] = {};
        //   item["geometry"]["type"] = "Point";
        //   item["geometry"]["coordinates"] = [Number(geo.longitude), Number(geo.lat)];
        //   item["properties"] = {};
        //   item["properties"]["uploadtime"] = geo.time;
        //   geojson["features"][i] = item;
        // });
        // console.log(geojson);
        // earthquakes = geojson.features;
        // quake();
        console.log(data);
      });
    });

 
    var i = 0;
    function quake() {
      var c = earthquakes[i];
      var p = map_base.latLngToLayerPoint(new L.LatLng((c.geometry.coordinates)[1], (c.geometry.coordinates)[0]));
      var h=svg.append("circle")
          .attr("class", "dataPoint")
          .attr("cx", p.x)
          .attr("cy", p.y)
          .attr("lat", c.geometry.coordinates[1])
          .attr("lng", c.geometry.coordinates[0])
          .attr("r", 1)
          .style("fill", "red")
          .style("fill-opacity", 0.5)
          .style("stroke", "red")
          .style("stroke-opacity", 0.5)
        .transition()
          .duration(4000)
          .ease(Math.sqrt)
          .attr("r", 2 * 10) //c.properties.magnitude
          .style("fill-opacity", 1e-6)
          .style("stroke-opacity", 1e-6)
          .remove()
        setTimeout(quake, 200);
      //console.log("c=", c.geometry.coordinates[0]);
      //console.log("c=", c.geometry.coordinates[1]);

      ///console.log("c=", c.geometry.coordinates);
      //console.log("x=", projection(c.geometry.coordinates)[0]);
      //console.log("y=", projection(c.geometry.coordinates)[1]);


      $(".dataPoint").on('click', function(evt){
          evt.stopPropagation();
          circle_clicked(evt);
      });

      i++;
      if (earthquakes.length==i) i = 0;
    }
    // TODO click other place => remove pop up
    // $("body").on('click', function(evt){
    //       evt.stopPropagation();
    //       $('#popup').remove();
    //       $('#invisibleDiv').remove();
    // });

    // Remove popup when clicking outside
    $(document).mouseup(function (e) {
       var popup = $("#popup");
       if (!$('#open').is(e.target) && !popup.is(e.target) && popup.has(e.target).length == 0) {
           popup.remove();
       }
    });
    
    // document.getElementById('invisibleDiv').onclick = function()
    // {
    //     document.getElementById('popup').style.display = 'none'; 
    // }

    function circle_clicked(evt){
        $('#popup').remove();
        $('#invisibleDiv').remove();

        var pw = 400;
        var ph = 300;
        console.log(evt);
        currX = evt.clientX - pw/2;
        currY = evt.clientY - ph/2;
        //console.log(currX);
        //console.log(currY);
        // var invisibleDiv = document.createElement("div");
        // invisibleDiv.setAttribute("id", "invisibleDiv");
        // invisibleDiv.style.height = "100vh";
        // invisibleDiv.style.width = "100vw";
        // document.body.appendChild(invisibleDiv);



        var div = document.createElement("div");
        div.setAttribute("id", "popup");

        div.style.width = pw + "px";
        div.style.height = ph + "px";
        div.style.top = currY + "px";
        div.style.left = currX + "px";
        document.body.appendChild(div);

        getOSM(evt.target.attributes.lat.value, evt.target.attributes.lng.value, 15);//level);
        //getOSM(31.2, 121.5, 12);//SH is right
        //getOSM(73,127,15);//Lena river
        //getOSM(40.7127, -74.0059,15);//NY  north, east
  
    }

</script>


<?php
echo "My first PHP script!";
?>

<!-- About Section -->
    

</body>
</html>
