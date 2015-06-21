<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title>OASIS Map</title>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="http://d3js.org/d3.geo.tile.v0.min.js"></script>
    <script src="http://d3js.org/topojson.v1.min.js"></script>
    <script src="http://libs.cartocdn.com/cartodb.js/v2/cartodb.js"></script>
    <script>L_DISABLE_3D = true;</script>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
    <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
        <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/scrolling-nav.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <style type="text/css">
 
    body{
    }
    #container {
      width:1400px;
      height: 700px;
      margin:0px;
      padding:0px;
    }
    #map {
      position: relative;
      z-index: 0;
      margin: 0px;
      padding:0px;
      float:left;
    }
    #description {
      width:400px;
      height:700px;
      margin:0px;
      padding:0px;
      float:left;
    }
    #dMap, #chart, #sampleImage {
      width:400px;
      margin:0px;
    }
    #dMap {
      position: relative;
      z-index: 0;
      margin: 0px;
      padding:0px;
      width: 400px;
      height:400px;
    }
    .popup {
      position: absolute;
      z-index: 1;
      background-color: white;
    }
    /*svg:active {
      cursor: move;
      cursor: -moz-grabbing;
      cursor: -webkit-grabbing;
    }*/
    circle {
      fill: none;
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
    /*.countries :hover {
      fill: orange;
      stroke-width: 2.5px;
    }*/

    .tiles { 
      margin: 0px;
      pointer-events: none;
      position: absolute;
      width: 256px;
      height: 256px;
    }
</style>
 
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

  <div id="container">
       <div id="map"></div>
       <div id="description">
          <div id="dMap">
          </div>
          <div id="chart">
          </div>
          <div id="sampleImage">
            <img src="ph.gif" >
          </div>
       </div>
  </div>
    
<script>

    var data = "submissions.json";
    var database_url= "http://warm-ridge-5036.herokuapp.com"
    //$.getJSON(database_url, data, function(){console.log("yay")});//Cross Domain need to be handle properly later

    /*$.ajax({
      type: "POST",
      dataType: "jsonp",
      url: database_url,
      data: data,
      success: success
    });

    function success(data){
      console.log("Yay");
      console.log(data);
      //console.log(JSON.parse(data));
    }*/

    var first_layer = 'd3_world_borders';
     
    var sql = new cartodb.SQL({ user: 'viz2', format: 'geojson', dp: 5});
    var width = 1000,                  //svg/map width and height
        height = 700;

    var projection = d3.geo.mercator()       
        .center([-15, 60])              //The center of the map (more land is possible)
        .scale(160);                  //Initial zoom of the map
    var country;
    var defs;
    var dmap;
    var layerGroup;

    
     
    function getOSM(lat, lng, level){
       //console.log("lat="+ lat + " lng=" + lng);

       var mapboxURL = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}';
       var ac = 'pk.eyJ1IjoiYmV0aHNoaSIsImEiOiJjOTg3MmVmMThjNDA3ZWNlZGFiMzQxYzVmMWE5MTA0YSJ9.m1VNax_7vNjkZVXuUY69Gw';
       var mapattr = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> , Imagery © <a href="http://mapbox.com">Mapbox</a>';

       var mapid_bike = 'bethshi.c9cd002c';
       var mapid_streets = 'bethshi.m99m2dgg';

       //large
       var bike2 = L.tileLayer(mapboxURL, {
          attribution: mapattr,
          maxZoom: 18,
          id: mapid_bike,
          accessToken: ac
       });

       var streets2 = L.tileLayer(mapboxURL, {
          attribution: mapattr,
          maxZoom: 18,
          id: mapid_streets,
          accessToken: ac
       });

       //var data_point2 = L.marker([lat, lng]).bindPopup("Here");
       //var points = L.layerGroup([data_point2]);


       var baseMaps2 = {
            "Bike": bike2,
            "Streets": streets2
       };

       

       if(!dmap){
         var k = 0;
         //var points2;

         var overlayMaps2 = {
             //"Points": points2
         };
         //for(k=0; k<lats.length; k++){
           // var p = L.marker([lats[k], lngs[k]]).bindPopup("Here");
            //points2.push(p);
         //}
         //console.log(points);
         dmap = L.map('dMap',{
            center: [lat, lng],
            zoom:level-2,
            layers: [bike2, streets2]
         });
         layerGroup = L.control.layers(baseMaps2, overlayMaps2)
         layerGroup.addTo(dmap);
       }else{
         dmap.setView(new L.LatLng(lat, lng), level-2);
         //dmap.layers.clearLayers(); 
         //layerGroup.clearLayers();      
       }



      //small
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

       var baseMaps = {
            "Bike": bike,
            "Streets": streets
       };

       var overlayMaps = {
            "Points": points
       };

       //var map = L.map('popup').setView([lat, lng], 13);
       var map = L.map('popup',{
          center: [lat, lng],
          zoom:level,
          layers: [bike, streets]
       });
       L.control.layers(baseMaps, overlayMaps).addTo(map);



    }

 
    

    var path = d3.geo.path()
        .projection(projection);

    var tile = d3.geo.tile()
        .scale(projection.scale() * 2 * Math.PI)
        .translate(projection([0, 0]))
        .zoomDelta((window.devicePixelRatio || 1) - .5);

    var svg = d3.select("#map").append("svg")
       // .call(d3.behavior.zoom()
         //       .on("zoom", redraw))
        .attr("width", width)
        .attr("height", height);

    // Background rect
    svg.append("rect")
        .attr("width", "100%")
        .attr("height", "100%")
        .attr("fill", "#000000");//"#3A81B7");

    d3.json("./d3/world-50m.json", function(error, topology) {
        var tiles = tile();

        svg.append("defs");

        svg.append("path")
            .attr("id", "countries")
            .datum(topojson.feature(topology, topology.objects.countries))
            .attr("d", path);

        svg.append("clipPath")
            .attr("id", "clip")
          .append("use")
            .attr("xlink:href", "#countries");


        svg.append("g")
            .attr("id", "first_layer")
            .attr("clip-path", "url(#clip)")
          .selectAll("image")
            .data(tiles)
          .enter().append("image")
            .attr("xlink:href", function(d) { return "http://" + ["a", "b", "c", "d"][Math.random() * 4 | 0] + ".tiles.mapbox.com/v3/mapbox.natural-earth-2/" + d[2] + "/" + d[0] + "/" + d[1] + ".png"; })
            .attr("width", Math.round(tiles.scale))
            .attr("height", Math.round(tiles.scale))
            .attr("class", "tiles")
            .attr("x", function(d) { return Math.round((d[0] + tiles.translate[0]) * tiles.scale); })
            .attr("y", function(d) { return Math.round((d[1] + tiles.translate[1]) * tiles.scale); });

        svg.append("use")
            .attr("xlink:href", "#countries")
            .attr("class", "stroke");

    });

    var lats;
    var lngs;
    var earthquakes;
    sql.execute("SELECT the_geom, quakedate, magnitude FROM {{table_name}} WHERE the_geom IS NOT NULL ORDER BY quakedate ASC", {table_name: 'earthquaked3'})
      .done(function(collection) {
        earthquakes = collection.features;
        quake();
        count();
      }); 
  
    var i = 0;    
    function quake() {
      var c = earthquakes[i];
      var h=svg.append("circle")
          .attr("class", "dataPoint")
          .attr("cx", projection(c.geometry.coordinates)[0])
          .attr("cy", projection(c.geometry.coordinates)[1])
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
          .attr("r", c.properties.magnitude * 10)
          .style("fill-opacity", 1e-6)
          .style("stroke-opacity", 1e-6)
          .remove()

        setTimeout(quake, 200);


      //console.log("c=", c.geometry.coordinates);
      //console.log("x=", projection(c.geometry.coordinates)[0]);
      //console.log("y=", projection(c.geometry.coordinates)[1]);


      $(".dataPoint").on('hover', function(evt){
          evt.stopPropagation();
          circle_clicked(evt);
      });

      $(".dataPoint").on('click', function(evt){
          viewing = false;
          evt.stopPropagation();
          circle_clicked(evt);
      });

      i++;
      if (earthquakes.length==i) {
        i = 0;
      }
    }

    var j = 0;
    function count(){
        var c = earthquakes[j];
        lats.push(c.geometry.coordinates[1]);
        lngs.push(c.geometry.coordinates[0]);
    }

    var viewing = false;

    function circle_clicked(evt){
        console.log(viewing);
        if(!viewing){
          viewing = true;
          $('#popup').remove();

          var pw = 300;
          var ph = 200;
          var gap = 50;

          //currX = evt.clientX - pw/2;
          //currY = evt.clientY - ph/2;
          currX = evt.clientX - gap;
          currY = evt.clientY - gap;

          var div = document.createElement("div");
          div.setAttribute("id", "popup");

          div.style.width = pw + "px";
          div.style.height = ph + "px";
          div.style.top = currY + "px";
          div.style.left = currX + "px";
          div.style.position = "absolute";
      
          document.getElementById("map").appendChild(div);

          getOSM(evt.target.attributes.lat.value, evt.target.attributes.lng.value, 15);//level);
          //getOSM(31.2, 121.5, 12);//SH is right
          //getOSM(73,127,15);//Lena river
          //getOSM(40.7127, -74.0059,15);//NY  north, east

          $('#popup').on("mouseleave", function() {
            viewing = false;
          });

        }//viewing  

    }//circle clicked



</script>


<?php
//echo "Test map!";
?>
    

</body>
</html>
