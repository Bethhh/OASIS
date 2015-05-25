<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title>OASIS Map</title>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="http://d3js.org/d3.geo.tile.v0.min.js"></script>
    <script src="http://d3js.org/topojson.v1.min.js"></script>
    <script src="http://libs.cartocdn.com/cartodb.js/v2/cartodb.js"></script>
    <script type="text/javascript" src="http://maplib.khtml.org/khtml.maplib/khtml_all.js"></script>
    <style type="text/css">
 
    body{
        background:black;
    }
    #map {
      position: absolute;
      z-index: 0;
    }
    .popup {
      position: absolute;
      z-index: 1;
      background-color: white;
    }
    svg:active {
      cursor: move;
      cursor: -moz-grabbing;
      cursor: -webkit-grabbing;
    }
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
    .countries :hover {
      fill: orange;
      stroke-width: 2.5px;
    }
</style>
 
</head>

<body>
  <div id="map"></div>
<script>

    var first_layer = 'd3_world_borders';
     
    var sql = new cartodb.SQL({ user: 'viz2', format: 'geojson', dp: 5});

    var width = 1100,                  //svg/map width and height
        height = 600;

    var projection = d3.geo.mercator()       
        .center([0, 40])              //The center of the map (more land is possible)
        .scale(160);                  //Initial zoom of the map
    var country;
    var defs;

    var mr=new Object(khtml.maplib);
    var map=null; //global map object
     
    function getOSM(lat, lng, level){
       console.log("lat="+ lat + " lng=" + lng);
       //var a = document.getElementsByClassName("popup");
       //console.log(a);
       map = new mr.Map(document.getElementsByClassName("popup")[0]);
       var center = new mr.LatLng(lat,lng);
       map.centerAndZoom(center,level); //12 = zoomlevel
       //now the map is working, if you don't need overlays you are finished
    }

 
    

    var path = d3.geo.path()
        .projection(projection);

    var tile = d3.geo.tile()
        .scale(projection.scale() * 2 * Math.PI)
        .translate(projection([0, 0]))
        .zoomDelta((window.devicePixelRatio || 1) - .5);

    function redraw() {
      svg.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
    }
    

    var svg = d3.select("#map").append("svg")
        .call(d3.behavior.zoom()
                .on("zoom", redraw))
        .attr("width", width)
        .attr("height", height);

    // Background rect
    svg.append("rect")
        .attr("width", "100%")
        .attr("height", "100%")
        .attr("fill", "#3A81B7");

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
            .attr("x", function(d) { return Math.round((d[0] + tiles.translate[0]) * tiles.scale); })
            .attr("y", function(d) { return Math.round((d[1] + tiles.translate[1]) * tiles.scale); });

        svg.append("use")
            .attr("xlink:href", "#countries")
            .attr("class", "stroke");

    });

    var earthquakes;
    sql.execute("SELECT the_geom, quakedate, magnitude FROM {{table_name}} WHERE the_geom IS NOT NULL ORDER BY quakedate ASC", {table_name: 'earthquaked3'})
      .done(function(collection) {
        earthquakes = collection.features;
        quake();
      });
 
    var i = 0;
    function quake() {
      var c = earthquakes[i];
      var h=svg.append("circle")
          .attr("class", "dataPoint")
          .attr("cx", projection(c.geometry.coordinates)[0])
          .attr("cy", projection(c.geometry.coordinates)[1])
          .attr("lat", c.geometry.coordinates[0])
          .attr("lng", c.geometry.coordinates[1])
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


      $(".dataPoint").on('click', function(evt){
          //console.log("PP");
          evt.stopPropagation();
          circle_clicked(evt);
      });

      i++;
      if (earthquakes.length==i) i = 0;
    }

    function circle_clicked(evt){
        $('.popup').remove();

        var pw = 300;
        var ph = 200;
        //console.log("hey");
        //console.log(evt);
        currX = evt.clientX - pw/2;
        currY = evt.clientY - ph/2;

        /*svg.append("rect")
            .attr("x", currX)
            .attr("y", currY)
            .attr("class", "popup")
            .attr("width", pw)
            .attr("height", ph)
            .attr("fill", "#ffffff");*/

        var div = document.createElement("div");
        div.setAttribute("class", "popup");

        div.style.width = pw + "px";
        div.style.height = ph + "px";
        div.style.top = currY + "px";
        div.style.left = currX + "px";
        document.body.appendChild(div);
        //console.log(div);

        getOSM(evt.target.attributes.cx.value, evt.target.attributes.cy.value, 12);//level);
    }

</script>


<?php
echo "My first PHP script!";
?>
</body>
</html>
