<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title>Easy earthquakes</title>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="http://d3js.org/d3.geo.tile.v0.min.js"></script>
    <script src="http://d3js.org/topojson.v1.min.js"></script>
    <script src="http://libs.cartocdn.com/cartodb.js/v2/cartodb.js"></script>
    <style type="text/css">
 
    body{
        background:black;
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

<script>
    var first_layer = 'd3_world_borders';
     
    var sql = new cartodb.SQL({ user: 'viz2', format: 'geojson', dp: 5});

    var width = 1100,                  //svg/map width and height
        height = 600;

    var projection = d3.geo.mercator()       
        .center([0, 40])              //The center of the map (more land is possible)
        .scale(160);                  //Initial zoom of the map
    var country;
    var g;
    var defs;

    var path = d3.geo.path()
        .projection(projection);

    var tile = d3.geo.tile()
        .scale(projection.scale() * 2 * Math.PI)
        .translate(projection([0, 0]))
        .zoomDelta((window.devicePixelRatio || 1) - .5);

    function redraw() {
      svg.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
    }


    var svg = d3.select("body").append("svg")
        .call(d3.behavior.zoom()
                .on("zoom", redraw))
        .attr("width", width)
        .attr("height", height);

    svg.append("rect")
        .attr("width", "100%")
        .attr("height", "100%")
        .attr("fill", "#3A81B7");

    d3.json("./d3/world-50m.json", function(error, topology) {
      var tiles = tile();

      svg.append("defs");


      g=svg.append("path")
          .attr("id", "countries")
          .datum(topojson.feature(topology, topology.objects.countries))
          .attr("d", path);

      svg.append("clipPath")
          .attr("id", "clip")
        .append("use")
          .attr("xlink:href", "#countries");


      svg.append("g")
          .on("click", country_clicked)
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

      
      /*sql.execute("SELECT ST_Simplify(the_geom,0.01) as the_geom FROM {{table_name}} WHERE the_geom IS NOT NULL", {table_name: first_layer})
      .done(function(collection) {
          svg.select("#first_layer")
            .selectAll("path")
              .data(collection.features)
            .enter().append("path")
            .attr("d", path.projection(xy));
      })
      .error(function(errors) {
        // console.log('Errors! Oh no!')
      });*/
 


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
      svg.append("circle")
          .attr("cx", projection(c.geometry.coordinates)[0])
          .attr("cy", projection(c.geometry.coordinates)[1])
          .attr("r", 1)
          .style("fill", "red")
          .style("fill-opacity", 0.5)
          .style("stroke", "red")
          .style("stroke-opacity", 0.5)
        .transition()
          .duration(2000)
          .ease(Math.sqrt)
          .attr("r", c.properties.magnitude * 20)
          .style("fill-opacity", 1e-6)
          .style("stroke-opacity", 1e-6)
          .remove()
        setTimeout(quake, 200);
      i++;
      if (earthquakes.length==i) i = 0;
    }

function country_clicked(d) {
  g.selectAll(["#states", "#cities"]).remove();
  //defs.selectAll(["#states", "#cities"]).remove();
  state = null;

  if (country) {
    g.selectAll("#" + country.id).style('display', null);
    //defs.selectAll("#" + country.id).style('display', null);
  }

  if (d && country !== d) {
    var xyz = get_xyz(d);
    country = d;

    /*if (d.id  == 'USA' || d.id == 'JPN') {
      d3.json("/json/states_" + d.id.toLowerCase() + ".topo.json", function(error, us) {
        g.append("g")
          .attr("id", "states")
          .selectAll("path")
          .data(topojson.feature(us, us.objects.states).features)
          .enter()
          .append("path")
          .attr("id", function(d) { return d.id; })
          .attr("class", "active")
          .attr("d", path)
          .on("click", state_clicked);

        zoom(xyz);
        g.selectAll("#" + d.id).style('display', 'none');
      });      
    } else {*/
      zoom(xyz);
    //}
  } else {
    var xyz = [width / 2, height / 1.5, 1];
    country = null;
    zoom(xyz);
  }
}

function zoom(xyz) {
  g.transition()
    .duration(750)
    .attr("transform", "translate(" + projection.translate() + ")scale(" + xyz[2] + ")translate(-" + xyz[0] + ",-" + xyz[1] + ")")
    .selectAll(["#countries", "#states", "#cities"])
    .style("stroke-width", 1.0 / xyz[2] + "px")
    .selectAll(".city")
    .attr("d", path.pointRadius(20.0 / xyz[2]));
  /*defs.transition()
    .duration(750)
    .attr("transform", "translate(" + projection.translate() + ")scale(" + xyz[2] + ")translate(-" + xyz[0] + ",-" + xyz[1] + ")")
    .selectAll(["#countries", "#states", "#cities"])
    .style("stroke-width", 1.0 / xyz[2] + "px")
    .selectAll(".city")
    .attr("d", path.pointRadius(20.0 / xyz[2]));*/
}

function get_xyz(d) {
  var bounds = path.bounds(d);
  var w_scale = (bounds[1][0] - bounds[0][0]) / width;
  var h_scale = (bounds[1][1] - bounds[0][1]) / height;
  var z = .96 / Math.max(w_scale, h_scale);
  var x = (bounds[1][0] + bounds[0][0]) / 2;
  var y = (bounds[1][1] + bounds[0][1]) / 2 + (height / z / 6);
  return [x, y, z];
}


</script>
</body>
</html>
