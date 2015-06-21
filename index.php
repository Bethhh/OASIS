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
    <script type="text/javascript" src="./js/leaflet-heatmap.js"></script>
  
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
    var testData={
      max: 46,
      data: [{lat: 33.5363, lon:-117.044, count: 1},{lat: 33.5608, lon:-117.24, count: 1},{lat: 38, lon:-97, count: 1},{lat: 38.9358, lon:-77.1621, count: 1},{lat: 38, lon:-97, count: 2},{lat: 54, lon:-2, count: 1},{lat: 51.5167, lon:-0.7, count: 2},{lat: 51.5167, lon:-0.7, count: 6},{lat: 60.3911, lon:5.3247, count: 1},{lat: 50.8333, lon:12.9167, count: 9},{lat: 50.8333, lon:12.9167, count: 1},{lat: 52.0833, lon:4.3, count: 3},{lat: 52.0833, lon:4.3, count: 1},{lat: 51.8, lon:4.4667, count: 16},{lat: 51.8, lon:4.4667, count: 9},{lat: 51.8, lon:4.4667, count: 2},{lat: 51.1, lon:6.95, count: 1},{lat: 13.75, lon:100.517, count: 1},{lat: 18.975, lon:72.8258, count: 1},{lat: 2.5, lon:112.5, count: 2},{lat: 25.0389, lon:102.718, count: 1},{lat: -27.6167, lon:152.733, count: 1},{lat: -33.7667, lon:150.833, count: 1},{lat: -33.8833, lon:151.217, count: 2},{lat: 9.4333, lon:99.9667, count: 1},{lat: 33.7, lon:73.1667, count: 1},{lat: 33.7, lon:73.1667, count: 2},{lat: 22.3333, lon:114.2, count: 1},{lat: 37.4382, lon:-84.051, count: 1},{lat: 34.6667, lon:135.5, count: 1},{lat: 37.9167, lon:139.05, count: 1},{lat: 36.3214, lon:127.42, count: 1},{lat: -33.8, lon:151.283, count: 2},{lat: -33.8667, lon:151.225, count: 1},{lat: -37.65, lon:144.933, count: 2},{lat: -37.7333, lon:145.267, count: 1},{lat: -34.95, lon:138.6, count: 1},{lat: -27.5, lon:153.017, count: 1},{lat: -27.5833, lon:152.867, count: 3},{lat: -35.2833, lon:138.55, count: 1},{lat: 13.4443, lon:144.786, count: 2},{lat: -37.8833, lon:145.167, count: 1},{lat: -37.86, lon:144.972, count: 1},{lat: -27.5, lon:153.05, count: 1},{lat: 35.685, lon:139.751, count: 2},{lat: -34.4333, lon:150.883, count: 2},{lat: 14.0167, lon:100.733, count: 2},{lat: 13.75, lon:100.517, count: 5},{lat: -31.9333, lon:115.833, count: 1},{lat: -33.8167, lon:151.167, count: 1},{lat: -37.9667, lon:145.117, count: 1},{lat: -37.8333, lon:145.033, count: 1},{lat: -37.6417, lon:176.186, count: 2},{lat: -37.6861, lon:176.167, count: 1},{lat: -41.2167, lon:174.917, count: 1},{lat: 39.0521, lon:-77.015, count: 3},{lat: 24.8667, lon:67.05, count: 1},{lat: 24.9869, lon:121.306, count: 1},{lat: 53.2, lon:-105.75, count: 4},{lat: 44.65, lon:-63.6, count: 1},{lat: 53.9667, lon:-1.0833, count: 1},{lat: 40.7, lon:14.9833, count: 1},{lat: 37.5331, lon:-122.247, count: 1},{lat: 39.6597, lon:-86.8663, count: 2},{lat: 33.0247, lon:-83.2296, count: 1},{lat: 34.2038, lon:-80.9955, count: 1},{lat: 28.0087, lon:-82.7454, count: 1},{lat: 44.6741, lon:-93.4103, count: 1},{lat: 31.4507, lon:-97.1909, count: 1},{lat: 45.61, lon:-73.84, count: 1},{lat: 49.25, lon:-122.95, count: 1},{lat: 49.9, lon:-119.483, count: 2},{lat: 32.7825, lon:-96.8207, count: 6},{lat: 32.7825, lon:-96.8207, count: 7},{lat: 32.7825, lon:-96.8207, count: 4},{lat: 32.7825, lon:-96.8207, count: 41},{lat: 32.7825, lon:-96.8207, count: 11},{lat: 32.7825, lon:-96.8207, count: 3},{lat: 32.7825, lon:-96.8207, count: 10},{lat: 32.7825, lon:-96.8207, count: 5},{lat: 32.7825, lon:-96.8207, count: 14},{lat: 41.4201, lon:-75.6485, count: 4},{lat: 31.1999, lon:-92.3508, count: 1},{lat: 41.9874, lon:-91.6838, count: 1},{lat: 30.1955, lon:-85.6377, count: 1},{lat: 42.4266, lon:-92.358, count: 1},{lat: 41.6559, lon:-91.5228, count: 1},{lat: 33.9269, lon:-117.861, count: 3},{lat: 41.8825, lon:-87.6441, count: 6},{lat: 42.3998, lon:-88.8271, count: 1},{lat: 33.1464, lon:-97.0902, count: 1},{lat: 47.2432, lon:-93.5119, count: 1},{lat: 41.6472, lon:-93.46, count: 1},{lat: 36.1213, lon:-76.6414, count: 1},{lat: 41.649, lon:-93.6275, count: 1},{lat: 44.8547, lon:-93.7854, count: 1},{lat: 43.6833, lon:-79.7667, count: 1},{lat: 40.6955, lon:-89.4293, count: 1},{lat: 37.6211, lon:-77.6515, count: 1},{lat: 37.6273, lon:-77.5437, count: 3},{lat: 33.9457, lon:-118.039, count: 1},{lat: 33.8408, lon:-118.079, count: 1},{lat: 40.3933, lon:-74.7855, count: 1},{lat: 40.9233, lon:-73.9984, count: 1},{lat: 39.0735, lon:-76.5654, count: 1},{lat: 40.5966, lon:-74.0775, count: 1},{lat: 40.2944, lon:-73.9932, count: 2},{lat: 38.9827, lon:-77.004, count: 1},{lat: 38.3633, lon:-81.8089, count: 1},{lat: 36.0755, lon:-79.0741, count: 1},{lat: 51.0833, lon:-114.083, count: 2},{lat: 49.1364, lon:-122.821, count: 1},{lat: 39.425, lon:-84.4982, count: 3},{lat: 38.7915, lon:-82.9217, count: 1},{lat: 39.0131, lon:-84.2049, count: 1},{lat: 29.7523, lon:-95.367, count: 7},{lat: 29.7523, lon:-95.367, count: 4},{lat: 41.5171, lon:-71.2789, count: 1},{lat: 29.7523, lon:-95.367, count: 2},{lat: 32.8148, lon:-96.8705, count: 1},{lat: 45.5, lon:-73.5833, count: 1},{lat: 40.7529, lon:-73.9761, count: 6},{lat: 33.6534, lon:-112.246, count: 1},{lat: 40.7421, lon:-74.0018, count: 1},{lat: 38.3928, lon:-121.368, count: 1},{lat: 32.7825, lon:-96.8207, count: 1},{lat: 39.7968, lon:-76.993, count: 2},{lat: 40.5607, lon:-111.724, count: 1},{lat: 41.2863, lon:-75.8953, count: 1},{lat: 26.3484, lon:-80.2187, count: 1},{lat: 32.711, lon:-117.053, count: 2},{lat: 32.5814, lon:-83.6286, count: 3},{lat: 35.0508, lon:-80.8186, count: 3},{lat: 35.0508, lon:-80.8186, count: 1},{lat: -22.2667, lon:166.45, count: 5},{lat: 50.1167, lon:8.6833, count: 1},{lat: 51.9167, lon:4.5, count: 2},{lat: 54, lon:-2, count: 6},{lat: 52.25, lon:21, count: 1},{lat: 49.1, lon:10.75, count: 3},{lat: 51.65, lon:6.1833, count: 1},{lat: 1.3667, lon:103.8, count: 1},{lat: 29.4889, lon:-98.3987, count: 11},{lat: 29.3884, lon:-98.5311, count: 1},{lat: 41.8825, lon:-87.6441, count: 2},{lat: 41.8825, lon:-87.6441, count: 1},{lat: 33.9203, lon:-84.618, count: 4},{lat: 40.1242, lon:-82.3828, count: 1},{lat: 40.1241, lon:-82.3828, count: 1},{lat: 43.0434, lon:-87.8945, count: 1},{lat: 43.7371, lon:-74.3419, count: 1},{lat: 42.3626, lon:-71.0843, count: 1},{lat: 4.6, lon:-74.0833, count: 1},{lat: 19.7, lon:-101.117, count: 1},{lat: 25.6667, lon:-100.317, count: 1},{lat: 53.8167, lon:10.3833, count: 1},{lat: 50.8667, lon:6.8667, count: 3},{lat: 55.7167, lon:12.45, count: 2},{lat: 44.4333, lon:26.1, count: 4},{lat: 50.1167, lon:8.6833, count: 2},{lat: 52.5, lon:5.75, count: 4},{lat: 48.8833, lon:8.7, count: 1},{lat: 17.05, lon:-96.7167, count: 3},{lat: 23, lon:-102, count: 1},{lat: 20.6167, lon:-105.25, count: 1},{lat: 23, lon:-102, count: 2},{lat: 20.6667, lon:-103.333, count: 1},{lat: 21.1167, lon:-101.667, count: 1},{lat: 17.9833, lon:-92.9167, count: 1},{lat: 20.9667, lon:-89.6167, count: 2},{lat: 21.1667, lon:-86.8333, count: 1},{lat: 17.9833, lon:-94.5167, count: 1},{lat: 18.6, lon:-98.85, count: 1},{lat: 16.75, lon:-93.1167, count: 1},{lat: 19.4342, lon:-99.1386, count: 1},{lat: -10, lon:-55, count: 1},{lat: -22.9, lon:-43.2333, count: 1},{lat: 15.7833, lon:-86.8, count: 1},{lat: 10.4667, lon:-64.1667, count: 1},{lat: 7.1297, lon:-73.1258, count: 1},{lat: 4, lon:-72, count: 2},{lat: 4, lon:-72, count: 1},{lat: 6.8, lon:-58.1667, count: 1},{lat: 0, lon:0, count: 1},{lat: 48.15, lon:11.5833, count: 2},{lat: 45.8, lon:16, count: 15},{lat: 59.9167, lon:10.75, count: 1},{lat: 51.5002, lon:-0.1262, count: 1},{lat: 55, lon:73.4, count: 1},{lat: 52.5, lon:5.75, count: 1},{lat: 52.2, lon:0.1167, count: 1},{lat: 48.8833, lon:8.3333, count: 1},{lat: -33.9167, lon:18.4167, count: 1},{lat: 40.9157, lon:-81.133, count: 2},{lat: 43.8667, lon:-79.4333, count: 1},{lat: 54, lon:-2, count: 2},{lat: 39, lon:22, count: 1},{lat: 54, lon:-2, count: 11},{lat: 54, lon:-2, count: 4},{lat: 54, lon:-2, count: 3},{lat: 9.0833, lon:-79.3833, count: 2},{lat: 21.5, lon:-104.9, count: 1},{lat: 19.5333, lon:-96.9167, count: 1},{lat: 32.5333, lon:-117.017, count: 1},{lat: 19.4342, lon:-99.1386, count: 3},{lat: 18.15, lon:-94.4167, count: 1},{lat: 20.7167, lon:-103.4, count: 1},{lat: 23.2167, lon:-106.417, count: 2},{lat: 10.9639, lon:-74.7964, count: 1},{lat: 24.8667, lon:67.05, count: 2},{lat: 1.2931, lon:103.856, count: 1},{lat: -41, lon:174, count: 1},{lat: 13.75, lon:100.517, count: 2},{lat: 13.75, lon:100.517, count: 46},{lat: 13.75, lon:100.517, count: 9},{lat: 13.75, lon:100.517, count: 8},{lat: 13.75, lon:100.517, count: 7},{lat: 13.75, lon:100.517, count: 16},{lat: 13.75, lon:100.517, count: 4},{lat: 13.75, lon:100.517, count: 6},{lat: 55.75, lon:-97.8667, count: 5},{lat: 34.0438, lon:-118.251, count: 2},{lat: 44.2997, lon:-70.3698, count: 1},{lat: 46.9402, lon:-113.85, count: 14},{lat: 45.6167, lon:-61.9667, count: 1},{lat: 45.3833, lon:-66, count: 2},{lat: 54.9167, lon:-98.6333, count: 1},{lat: 40.8393, lon:-73.2797, count: 1},{lat: 41.6929, lon:-111.815, count: 1},{lat: 49.8833, lon:-97.1667, count: 1},{lat: 32.5576, lon:-81.9395, count: 1},{lat: 49.9667, lon:-98.3, count: 2},{lat: 40.0842, lon:-82.9378, count: 2},{lat: 49.25, lon:-123.133, count: 5},{lat: 35.2268, lon:-78.9561, count: 1},{lat: 43.9817, lon:-121.272, count: 1},{lat: 43.9647, lon:-121.341, count: 1},{lat: 32.7825, lon:-96.8207, count: 13},{lat: 33.4357, lon:-111.917, count: 2},{lat: 36.0707, lon:-97.9077, count: 1},{lat: 32.7791, lon:-96.8028, count: 1},{lat: 34.053, lon:-118.264, count: 1},{lat: 30.726, lon:-95.55, count: 1},{lat: 45.4508, lon:-93.5855, count: 1},{lat: 32.7825, lon:-96.8207, count: 8},{lat: 36.8463, lon:-76.0979, count: 3},{lat: 36.8463, lon:-76.0979, count: 1},{lat: 34.0533, lon:-118.255, count: 1},{lat: 35.7217, lon:-81.3603, count: 1},{lat: 40.6888, lon:-74.0203, count: 4},{lat: 47.5036, lon:-94.685, count: 2},{lat: 32.3304, lon:-81.6011, count: 1},{lat: 39.0165, lon:-77.5062, count: 2},{lat: 38.6312, lon:-90.1922, count: 1},{lat: 32.445, lon:-81.7758, count: 1},{lat: -37.9667, lon:145.15, count: 1},{lat: -33.9833, lon:151.117, count: 1},{lat: 49.6769, lon:6.1239, count: 2},{lat: 53.8167, lon:-1.2167, count: 1},{lat: 52.4667, lon:-1.9167, count: 3},{lat: 52.5, lon:5.75, count: 2},{lat: 33.5717, lon:-117.729, count: 4},{lat: 31.5551, lon:-97.1604, count: 1},{lat: 42.2865, lon:-71.7147, count: 1},{lat: 48.4, lon:-89.2333, count: 1},{lat: 42.9864, lon:-78.7279, count: 1},{lat: 41.8471, lon:-87.6248, count: 1},{lat: 34.5139, lon:-114.293, count: 1},{lat: 51.9167, lon:4.4, count: 1},{lat: 51.9167, lon:4.4, count: 4},{lat: 51.55, lon:5.1167, count: 38},{lat: 51.8, lon:4.4667, count: 8},{lat: 54.5, lon:-3.6167, count: 1},{lat: -34.9333, lon:138.6, count: 1},{lat: -33.95, lon:151.133, count: 1},{lat: 15, lon:100, count: 4},{lat: 15, lon:100, count: 1},{lat: 15, lon:100, count: 3},{lat: 15, lon:100, count: 2},{lat: 41.5381, lon:-87.6842, count: 1},{lat: 40.9588, lon:-75.3006, count: 1},{lat: 46.7921, lon:-96.8827, count: 1},{lat: 41.9474, lon:-87.7037, count: 1},{lat: 41.6162, lon:-87.0489, count: 1},{lat: 37.5023, lon:-77.5693, count: 1},{lat: 38.4336, lon:-77.3887, count: 1},{lat: 41.759, lon:-88.2615, count: 1},{lat: 42.0158, lon:-87.8423, count: 1},{lat: 46.5833, lon:-81.2, count: 1},{lat: 45.3667, lon:-63.3, count: 1},{lat: 18.0239, lon:-66.6366, count: 2},{lat: 43.2667, lon:-79.9333, count: 1},{lat: 45.0667, lon:-64.5, count: 1},{lat: 39.6351, lon:-78.7665, count: 1},{lat: 33.4483, lon:-81.6921, count: 2},{lat: 41.5583, lon:-87.6612, count: 1},{lat: 30.5315, lon:-90.4628, count: 1},{lat: 34.7664, lon:-82.2202, count: 2},{lat: 47.6779, lon:-117.379, count: 2},{lat: 47.6201, lon:-122.141, count: 1},{lat: 45.0901, lon:-87.7101, count: 1},{lat: 38.3119, lon:-90.1535, count: 3},{lat: 34.7681, lon:-84.9569, count: 4},{lat: 47.4061, lon:-121.995, count: 1},{lat: 40.6009, lon:-73.9397, count: 1},{lat: 40.6278, lon:-73.365, count: 1},{lat: 40.61, lon:-73.9108, count: 1},{lat: 34.3776, lon:-83.7605, count: 2},{lat: 38.7031, lon:-94.4737, count: 1},{lat: 39.3031, lon:-82.0828, count: 1},{lat: 42.5746, lon:-88.3946, count: 1},{lat: 45.4804, lon:-122.836, count: 1},{lat: 44.5577, lon:-123.298, count: 1},{lat: 40.1574, lon:-76.7978, count: 1},{lat: 34.8983, lon:-120.382, count: 1},{lat: 40.018, lon:-89.8623, count: 1},{lat: 37.3637, lon:-79.9549, count: 1},{lat: 37.2141, lon:-80.0625, count: 1},{lat: 37.2655, lon:-79.923, count: 1},{lat: 39.0613, lon:-95.7293, count: 1},{lat: 41.2314, lon:-80.7567, count: 1},{lat: 40.3377, lon:-79.8428, count: 1},{lat: 42.0796, lon:-71.0382, count: 1},{lat: 43.25, lon:-79.8333, count: 1},{lat: 40.7948, lon:-72.8797, count: 2},{lat: 40.6766, lon:-73.7038, count: 4},{lat: 37.979, lon:-121.788, count: 1},{lat: 43.1669, lon:-76.0558, count: 1},{lat: 37.5353, lon:-121.979, count: 1},{lat: 43.2345, lon:-71.5227, count: 1},{lat: 42.6179, lon:-70.7154, count: 3},{lat: 42.0765, lon:-71.472, count: 2},{lat: 35.2298, lon:-81.2428, count: 1},{lat: 39.961, lon:-104.817, count: 1},{lat: 44.6667, lon:-63.5667, count: 1},{lat: 38.4473, lon:-104.632, count: 3},{lat: 40.7148, lon:-73.7939, count: 1},{lat: 40.6763, lon:-73.7752, count: 1},{lat: 41.3846, lon:-73.0943, count: 2},{lat: 43.1871, lon:-70.91, count: 1},{lat: 33.3758, lon:-84.4657, count: 1},{lat: 15, lon:100, count: 12},{lat: 36.8924, lon:-80.076, count: 2},{lat: 25, lon:17, count: 1},{lat: 27, lon:30, count: 1},{lat: 49.1, lon:10.75, count: 2},{lat: 49.1, lon:10.75, count: 4},{lat: 47.6727, lon:-122.187, count: 1},{lat: -27.6167, lon:152.767, count: 1},{lat: -33.8833, lon:151.217, count: 1},{lat: 31.5497, lon:74.3436, count: 4},{lat: 13.65, lon:100.267, count: 2},{lat: -37.8167, lon:144.967, count: 1},{lat: 47.85, lon:12.1333, count: 3},{lat: 47, lon:8, count: 3},{lat: 52.1667, lon:10.55, count: 1},{lat: 50.8667, lon:6.8667, count: 2},{lat: 40.8333, lon:14.25, count: 2},{lat: 47.5304, lon:-122.008, count: 1},{lat: 47.5304, lon:-122.008, count: 3},{lat: 34.0119, lon:-118.468, count: 1},{lat: 38.9734, lon:-119.908, count: 1},{lat: 52.1333, lon:-106.667, count: 1},{lat: 41.4201, lon:-75.6485, count: 3},{lat: 45.6393, lon:-94.2237, count: 1},{lat: 33.7516, lon:-84.3915, count: 1},{lat: 26.0098, lon:-80.2592, count: 1},{lat: 34.5714, lon:-78.7566, count: 1},{lat: 40.7235, lon:-73.8612, count: 1},{lat: 39.1637, lon:-94.5215, count: 5},{lat: 28.0573, lon:-81.5687, count: 2},{lat: 26.8498, lon:-80.14, count: 1},{lat: 47.6027, lon:-122.156, count: 11},{lat: 47.6027, lon:-122.156, count: 1},{lat: 25.7541, lon:-80.271, count: 1},{lat: 32.7597, lon:-97.147, count: 1},{lat: 40.9083, lon:-73.8346, count: 2},{lat: 47.6573, lon:-111.381, count: 1},{lat: 32.3729, lon:-81.8443, count: 1},{lat: 32.7825, lon:-96.8207, count: 2},{lat: 41.5074, lon:-81.6053, count: 1},{lat: 32.4954, lon:-86.5, count: 1},{lat: 30.3043, lon:-81.7306, count: 1},{lat: 45.9667, lon:-81.9333, count: 1},{lat: 42.2903, lon:-72.6404, count: 5},{lat: 40.7553, lon:-73.9924, count: 1},{lat: 55.1667, lon:-118.8, count: 1},{lat: 37.8113, lon:-122.301, count: 1},{lat: 40.2968, lon:-111.676, count: 1},{lat: 42.0643, lon:-87.9921, count: 1},{lat: 42.3908, lon:-71.0925, count: 1},{lat: 44.2935, lon:-94.7601, count: 1},{lat: 40.4619, lon:-74.3561, count: 2},{lat: 32.738, lon:-96.4463, count: 1},{lat: 35.7821, lon:-78.8177, count: 1},{lat: 40.7449, lon:-73.9782, count: 1},{lat: 40.7449, lon:-73.9782, count: 2},{lat: 28.5445, lon:-81.3706, count: 1},{lat: 41.4201, lon:-75.6485, count: 1},{lat: 38.6075, lon:-83.7928, count: 1},{lat: 42.2061, lon:-83.206, count: 1},{lat: 42.3222, lon:-88.4671, count: 1},{lat: 42.3222, lon:-88.4671, count: 3},{lat: 37.7035, lon:-122.148, count: 1},{lat: 37.5147, lon:-122.042, count: 1},{lat: 40.6053, lon:-111.988, count: 1},{lat: 38.5145, lon:-81.7814, count: 1},{lat: 42.1287, lon:-88.2654, count: 1},{lat: 36.9127, lon:-120.196, count: 1},{lat: 36.3769, lon:-119.184, count: 1},{lat: 36.84, lon:-119.828, count: 1},{lat: 48.0585, lon:-122.148, count: 1},{lat: 42.1197, lon:-87.8445, count: 1},{lat: 40.7002, lon:-111.943, count: 2},{lat: 37.5488, lon:-122.312, count: 1},{lat: 41.3807, lon:-73.3915, count: 1},{lat: 45.5, lon:-73.5833, count: 3},{lat: 34.0115, lon:-117.854, count: 3},{lat: 43.0738, lon:-83.8608, count: 11},{lat: 33.9944, lon:-118.464, count: 3},{lat: 42.7257, lon:-84.636, count: 1},{lat: 32.7825, lon:-96.8207, count: 22},{lat: 40.7805, lon:-73.9512, count: 1},{lat: 42.1794, lon:-75.9491, count: 1},{lat: 43.3453, lon:-75.1285, count: 1},{lat: 42.195, lon:-83.165, count: 1},{lat: 33.9289, lon:-116.488, count: 5},{lat: 29.4717, lon:-98.514, count: 1},{lat: 28.6653, lon:-81.4188, count: 1},{lat: 40.8217, lon:-74.1574, count: 1},{lat: 41.2094, lon:-73.2116, count: 2},{lat: 41.0917, lon:-73.4316, count: 1},{lat: 30.4564, lon:-97.6938, count: 1},{lat: 36.1352, lon:-95.9364, count: 1},{lat: 33.3202, lon:-111.761, count: 1},{lat: 38.9841, lon:-77.3827, count: 1},{lat: 29.1654, lon:-82.0967, count: 1},{lat: 37.691, lon:-97.3292, count: 1},{lat: 33.5222, lon:-112.084, count: 1},{lat: 41.9701, lon:-71.7217, count: 1},{lat: 35.6165, lon:-97.4789, count: 3},{lat: 35.4715, lon:-97.519, count: 1},{lat: 41.2307, lon:-96.1178, count: 1},{lat: 53.55, lon:-113.5, count: 2},{lat: 36.0844, lon:-79.8209, count: 1},{lat: 40.5865, lon:-74.1497, count: 1},{lat: 41.9389, lon:-73.9901, count: 1},{lat: 40.8596, lon:-73.9314, count: 1},{lat: 33.6119, lon:-111.891, count: 2},{lat: 38.8021, lon:-90.627, count: 1},{lat: 38.8289, lon:-91.9744, count: 1},{lat: 42.8526, lon:-86.1263, count: 2},{lat: 40.781, lon:-73.2522, count: 1},{lat: 41.1181, lon:-74.0833, count: 2},{lat: 40.8533, lon:-74.6522, count: 2},{lat: 41.3246, lon:-73.6976, count: 1},{lat: 40.9796, lon:-73.7231, count: 1},{lat: 28.4517, lon:-81.4653, count: 1},{lat: 36.0328, lon:-115.025, count: 2},{lat: 32.5814, lon:-83.6286, count: 1},{lat: 33.6117, lon:-117.549, count: 1},{lat: 40.4619, lon:-74.3561, count: 4},{lat: 40.4619, lon:-74.3561, count: 1},{lat: 44.1747, lon:-94.0492, count: 3},{lat: 43.0522, lon:-87.965, count: 1},{lat: 40.0688, lon:-74.5956, count: 2},{lat: 33.6053, lon:-117.717, count: 1},{lat: 39.95, lon:-74.9929, count: 1},{lat: 38.678, lon:-77.3197, count: 2},{lat: 34.9184, lon:-92.1362, count: 2},{lat: 35.9298, lon:-86.4605, count: 1},{lat: 35.8896, lon:-86.3166, count: 1},{lat: 39.1252, lon:-76.5116, count: 1},{lat: 26.976, lon:-82.1391, count: 1},{lat: 34.5022, lon:-120.129, count: 1},{lat: 39.9571, lon:-76.7055, count: 2},{lat: 34.7018, lon:-86.6108, count: 1},{lat: 54.1297, lon:-108.435, count: 1},{lat: 32.805, lon:-116.902, count: 1},{lat: 45.6, lon:-73.7333, count: 1},{lat: 32.8405, lon:-116.88, count: 1},{lat: 33.2007, lon:-117.226, count: 1},{lat: 40.1246, lon:-75.5385, count: 1},{lat: 40.2605, lon:-75.6155, count: 1},{lat: 40.7912, lon:-77.8746, count: 1},{lat: 40.168, lon:-76.6094, count: 1},{lat: 40.3039, lon:-74.0703, count: 2},{lat: 39.3914, lon:-74.5182, count: 1},{lat: 40.1442, lon:-74.8483, count: 1},{lat: 28.312, lon:-81.589, count: 1},{lat: 34.0416, lon:-118.299, count: 1},{lat: 50.45, lon:-104.617, count: 1},{lat: 41.2305, lon:-73.1257, count: 3},{lat: 40.6538, lon:-73.6082, count: 1},{lat: 40.9513, lon:-73.8773, count: 2},{lat: 41.078, lon:-74.1764, count: 1},{lat: 32.7492, lon:-97.2205, count: 1},{lat: 39.5407, lon:-84.2212, count: 1},{lat: 40.7136, lon:-82.8012, count: 3},{lat: 36.2652, lon:-82.834, count: 8},{lat: 40.2955, lon:-75.3254, count: 2},{lat: 29.7755, lon:-95.4152, count: 2},{lat: 32.7791, lon:-96.8028, count: 3},{lat: 32.7791, lon:-96.8028, count: 2},{lat: 36.4642, lon:-87.3797, count: 2},{lat: 41.6005, lon:-72.8764, count: 1},{lat: 35.708, lon:-97.5749, count: 1},{lat: 40.8399, lon:-73.9422, count: 1},{lat: 41.9223, lon:-87.7555, count: 1},{lat: 42.9156, lon:-85.8464, count: 1},{lat: 41.8824, lon:-87.6376, count: 1},{lat: 30.6586, lon:-88.3535, count: 1},{lat: 42.6619, lon:-82.9211, count: 1},{lat: 35.0481, lon:-85.2833, count: 1},{lat: 32.3938, lon:-92.2329, count: 1},{lat: 39.402, lon:-76.6329, count: 1},{lat: 39.9968, lon:-75.1485, count: 1},{lat: 38.8518, lon:-94.7786, count: 1},{lat: 33.4357, lon:-111.917, count: 1},{lat: 35.8278, lon:-78.6421, count: 2},{lat: 22.3167, lon:114.183, count: 12},{lat: 34.0438, lon:-118.251, count: 1},{lat: 41.724, lon:-88.1127, count: 1},{lat: 37.4429, lon:-122.151, count: 1},{lat: 51.25, lon:-80.6, count: 1},{lat: 39.209, lon:-94.7305, count: 1},{lat: 40.7214, lon:-74.0052, count: 1},{lat: 33.92, lon:-117.208, count: 1},{lat: 29.926, lon:-97.5644, count: 1},{lat: 30.4, lon:-97.7528, count: 1},{lat: 26.937, lon:-80.135, count: 1},{lat: 32.8345, lon:-111.731, count: 1},{lat: 29.6694, lon:-82.3572, count: 13},{lat: 36.2729, lon:-115.133, count: 1},{lat: 33.2819, lon:-111.88, count: 3},{lat: 32.5694, lon:-117.016, count: 1},{lat: 38.8381, lon:-77.2121, count: 1},{lat: 41.6856, lon:-72.7312, count: 1},{lat: 33.2581, lon:-116.982, count: 1},{lat: 38.6385, lon:-90.3026, count: 1},{lat: 43.15, lon:-79.5, count: 2},{lat: 43.85, lon:-79.0167, count: 1},{lat: 44.8833, lon:-76.2333, count: 1},{lat: 45.4833, lon:-75.65, count: 1},{lat: 53.2, lon:-105.75, count: 1},{lat: 51.0833, lon:-114.083, count: 1},{lat: 29.7523, lon:-95.367, count: 1},{lat: 38.692, lon:-92.2929, count: 1},{lat: 34.1362, lon:-117.298, count: 2},{lat: 28.2337, lon:-82.179, count: 1},{lat: 40.9521, lon:-73.7382, count: 1},{lat: 38.9186, lon:-76.7862, count: 2},{lat: 42.2647, lon:-71.8089, count: 1},{lat: 42.6706, lon:-73.7791, count: 1},{lat: 39.5925, lon:-78.5901, count: 1},{lat: 52.1333, lon:-106.667, count: 2},{lat: 40.2964, lon:-75.2053, count: 1},{lat: 34.1066, lon:-117.815, count: 1},{lat: 40.8294, lon:-73.5052, count: 1},{lat: 42.1298, lon:-72.5687, count: 1},{lat: 25.6615, lon:-80.412, count: 2},{lat: 37.8983, lon:-122.049, count: 1},{lat: 37.0101, lon:-122.032, count: 2},{lat: 40.2843, lon:-76.8446, count: 1},{lat: 39.4036, lon:-104.56, count: 1},{lat: 34.8397, lon:-106.688, count: 1},{lat: 40.1879, lon:-75.4254, count: 2},{lat: 35.0212, lon:-85.2729, count: 2},{lat: 40.214, lon:-75.073, count: 1},{lat: 39.9407, lon:-75.2281, count: 1},{lat: 47.2098, lon:-122.409, count: 1},{lat: 41.3433, lon:-73.0654, count: 2},{lat: 41.7814, lon:-72.7544, count: 1},{lat: 41.3094, lon:-72.924, count: 1},{lat: 45.3218, lon:-122.523, count: 1},{lat: 45.4104, lon:-122.702, count: 3},{lat: 45.6741, lon:-122.471, count: 2},{lat: 32.9342, lon:-97.2515, count: 1},{lat: 40.8775, lon:-74.1105, count: 1},{lat: 40.82, lon:-96.6806, count: 1},{lat: 45.5184, lon:-122.655, count: 1},{lat: 41.0544, lon:-74.6171, count: 1},{lat: 35.3874, lon:-78.8686, count: 1},{lat: 39.961, lon:-85.9837, count: 1},{lat: 34.0918, lon:-84.2209, count: 2},{lat: 39.1492, lon:-78.278, count: 1},{lat: 38.7257, lon:-77.7982, count: 1},{lat: 45.0059, lon:-93.4305, count: 1},{lat: 35.0748, lon:-80.6774, count: 1},{lat: 35.8059, lon:-78.7997, count: 1},{lat: 35.8572, lon:-84.0177, count: 1},{lat: 38.7665, lon:-89.6533, count: 1},{lat: 43.7098, lon:-87.7478, count: 2},{lat: 33.3961, lon:-84.7821, count: 1},{lat: 32.7881, lon:-96.9431, count: 1},{lat: 43.1946, lon:-89.2025, count: 1},{lat: 43.0745, lon:-87.9078, count: 1},{lat: 34.0817, lon:-84.2553, count: 1},{lat: 37.9689, lon:-103.749, count: 1},{lat: 31.7969, lon:-106.387, count: 1},{lat: 31.7435, lon:-106.297, count: 1},{lat: 29.6569, lon:-98.5107, count: 1},{lat: 28.4837, lon:-82.5496, count: 1},{lat: 29.1137, lon:-81.0285, count: 1},{lat: 29.6195, lon:-100.809, count: 1},{lat: 35.4568, lon:-97.2652, count: 1},{lat: 33.8682, lon:-117.929, count: 1},{lat: 32.7977, lon:-117.132, count: 1},{lat: 33.3776, lon:-112.387, count: 1},{lat: 43.1031, lon:-79.0092, count: 1},{lat: 40.7731, lon:-80.1137, count: 2},{lat: 40.7082, lon:-74.0132, count: 1},{lat: 39.7187, lon:-75.6216, count: 1},{lat: 29.8729, lon:-98.014, count: 1},{lat: 42.5324, lon:-70.9737, count: 1},{lat: 41.6623, lon:-71.0107, count: 1},{lat: 41.1158, lon:-78.9098, count: 1},{lat: 39.2694, lon:-76.7447, count: 1},{lat: 39.9, lon:-75.3075, count: 1},{lat: 41.2137, lon:-85.0996, count: 1},{lat: 32.8148, lon:-96.8705, count: 2},{lat: 39.8041, lon:-75.4559, count: 4},{lat: 40.0684, lon:-75.0065, count: 1},{lat: 44.8791, lon:-68.733, count: 1},{lat: 40.1879, lon:-75.4254, count: 1},{lat: 41.8195, lon:-71.4107, count: 1},{lat: 38.9879, lon:-76.5454, count: 3},{lat: 42.5908, lon:-71.8055, count: 6},{lat: 40.7842, lon:-73.8422, count: 2},{lat: 0, lon:0, count: 2},{lat: 33.336, lon:-96.7491, count: 5},{lat: 33.336, lon:-96.7491, count: 6},{lat: 37.4192, lon:-122.057, count: 1},{lat: 33.7694, lon:-83.3897, count: 1},{lat: 37.7609, lon:-87.1513, count: 1},{lat: 33.8651, lon:-84.8948, count: 1},{lat: 28.5153, lon:-82.2856, count: 1},{lat: 35.1575, lon:-89.7646, count: 1},{lat: 32.318, lon:-95.2921, count: 1},{lat: 35.4479, lon:-91.9977, count: 1},{lat: 36.6696, lon:-93.2615, count: 1},{lat: 34.0946, lon:-101.683, count: 1},{lat: 31.9776, lon:-102.08, count: 1},{lat: 39.0335, lon:-77.4838, count: 1},{lat: 40.0548, lon:-75.4083, count: 8},{lat: 38.9604, lon:-94.8049, count: 2},{lat: 33.8138, lon:-117.799, count: 3},{lat: 33.8138, lon:-117.799, count: 1},{lat: 33.8138, lon:-117.799, count: 2},{lat: 38.2085, lon:-85.6918, count: 3},{lat: 37.7904, lon:-85.4848, count: 1},{lat: 42.4488, lon:-94.2254, count: 1},{lat: 43.179, lon:-77.555, count: 1},{lat: 29.7523, lon:-95.367, count: 3},{lat: 40.665, lon:-73.7502, count: 1},{lat: 40.6983, lon:-73.888, count: 1},{lat: 43.1693, lon:-77.6189, count: 1},{lat: 43.7516, lon:-70.2793, count: 1},{lat: 37.3501, lon:-121.985, count: 1},{lat: 32.7825, lon:-96.8207, count: 19},{lat: 35.1145, lon:-101.771, count: 1},{lat: 31.7038, lon:-83.6753, count: 2},{lat: 34.6222, lon:-83.7901, count: 1},{lat: 35.7102, lon:-84.3743, count: 1},{lat: 42.0707, lon:-72.044, count: 1},{lat: 34.7776, lon:-82.3051, count: 2},{lat: 34.9965, lon:-82.3287, count: 1},{lat: 32.5329, lon:-85.5078, count: 1},{lat: 41.5468, lon:-93.6209, count: 1},{lat: 41.2587, lon:-80.8298, count: 1},{lat: 35.2062, lon:-81.1384, count: 1},{lat: 39.9741, lon:-86.1272, count: 1},{lat: 33.7976, lon:-118.162, count: 1},{lat: 41.8675, lon:-87.6744, count: 1},{lat: 42.8526, lon:-86.1263, count: 1},{lat: 39.9968, lon:-82.9882, count: 1},{lat: 35.1108, lon:-89.9483, count: 1},{lat: 35.1359, lon:-90.0027, count: 1},{lat: 32.3654, lon:-90.1118, count: 1},{lat: 42.1663, lon:-71.3611, count: 1},{lat: 39.5076, lon:-104.677, count: 2},{lat: 39.378, lon:-104.858, count: 1},{lat: 44.84, lon:-93.0365, count: 1},{lat: 31.2002, lon:-97.9921, count: 1},{lat: 26.1783, lon:-81.7145, count: 2},{lat: 47.9469, lon:-122.197, count: 1},{lat: 32.2366, lon:-90.1688, count: 1},{lat: 25.7341, lon:-80.3594, count: 13},{lat: 26.9467, lon:-80.217, count: 2},{lat: 44.9487, lon:-93.1002, count: 1},{lat: 38.6485, lon:-77.3108, count: 1},{lat: 45.6676, lon:-122.606, count: 1},{lat: 40.1435, lon:-75.3567, count: 1},{lat: 43.0139, lon:-71.4352, count: 1},{lat: 41.9395, lon:-71.2943, count: 2},{lat: 37.6134, lon:-77.2564, count: 1},{lat: 42.5626, lon:-83.6099, count: 1},{lat: 41.55, lon:-88.1248, count: 1},{lat: 34.0311, lon:-118.49, count: 1},{lat: 33.7352, lon:-118.315, count: 1},{lat: 34.0872, lon:-117.882, count: 1},{lat: 33.8161, lon:-117.979, count: 2},{lat: 47.6609, lon:-116.834, count: 15},{lat: 40.2594, lon:-81.9641, count: 2},{lat: 35.9925, lon:-78.9017, count: 1},{lat: 32.8098, lon:-96.7993, count: 5},{lat: 32.6988, lon:-97.1237, count: 1},{lat: 32.9722, lon:-96.7376, count: 3},{lat: 32.9513, lon:-96.7154, count: 1},{lat: 32.9716, lon:-96.7058, count: 2},{lat: 41.4796, lon:-81.511, count: 2},{lat: 36.7695, lon:-119.795, count: 1},{lat: 36.2082, lon:-86.879, count: 2},{lat: 41.3846, lon:-73.0943, count: 1},{lat: 37.795, lon:-122.219, count: 1},{lat: 41.4231, lon:-73.4771, count: 1},{lat: 38.0322, lon:-78.4873, count: 1},{lat: 43.6667, lon:-79.4167, count: 1},{lat: 42.3222, lon:-88.4671, count: 7},{lat: 40.7336, lon:-96.6394, count: 2},{lat: 33.7401, lon:-117.82, count: 2},{lat: 33.7621, lon:-84.3982, count: 1},{lat: 39.7796, lon:-75.0505, count: 1},{lat: 39.4553, lon:-74.9608, count: 1},{lat: 39.7351, lon:-75.6684, count: 1},{lat: 51.3833, lon:0.5167, count: 1},{lat: 45.9833, lon:6.05, count: 1},{lat: 51.1833, lon:14.4333, count: 1},{lat: 41.9167, lon:8.7333, count: 1},{lat: 45.4, lon:5.45, count: 2},{lat: 51.9, lon:6.1167, count: 1},{lat: 50.4333, lon:30.5167, count: 1},{lat: 24.6408, lon:46.7728, count: 1},{lat: 54.9878, lon:-1.4214, count: 5},{lat: 51.45, lon:-2.5833, count: 2},{lat: 46, lon:2, count: 2},{lat: 51.5167, lon:-0.7, count: 1},{lat: 35.94, lon:14.3533, count: 1},{lat: 53.55, lon:10, count: 1},{lat: 53.6, lon:7.2, count: 1},{lat: 53.8333, lon:-1.7667, count: 1},{lat: 53.7833, lon:-1.75, count: 2},{lat: 52.6333, lon:-1.1333, count: 1},{lat: 53.5333, lon:-1.1167, count: 2},{lat: 51.0167, lon:-0.45, count: 2},{lat: 50.7833, lon:-0.65, count: 1},{lat: 50.9, lon:-1.4, count: 1},{lat: 50.9, lon:-1.4, count: 5},{lat: 52.2, lon:-2.2, count: 8},{lat: 50.1167, lon:8.6833, count: 3},{lat: 49.0047, lon:8.3858, count: 1},{lat: 49.1, lon:10.75, count: 7},{lat: 37.9833, lon:23.7333, count: 1},{lat: 41.9, lon:12.4833, count: 19},{lat: 51.8833, lon:10.5667, count: 3},{lat: 50.0333, lon:12.0167, count: 1},{lat: 49.8667, lon:10.8333, count: 14},{lat: 51, lon:9, count: 1},{lat: 53.3667, lon:-1.5, count: 1},{lat: 52.9333, lon:-1.5, count: 1},{lat: 52.9667, lon:-1.1667, count: 1},{lat: 52.9667, lon:-1.3, count: 1},{lat: 51.9, lon:-2.0833, count: 2},{lat: 50.3, lon:3.9167, count: 1},{lat: 45.45, lon:-73.75, count: 4},{lat: 53.7, lon:-2.2833, count: 1},{lat: 53.9833, lon:-1.5333, count: 1},{lat: 50.8167, lon:7.1667, count: 1},{lat: 56.5, lon:-2.9667, count: 1},{lat: 51.4667, lon:-0.35, count: 1},{lat: 43.3667, lon:-5.8333, count: 1},{lat: 47, lon:8, count: 4},{lat: 47, lon:8, count: 1},{lat: 47, lon:8, count: 2},{lat: 50.7333, lon:-1.7667, count: 2},{lat: 52.35, lon:4.9167, count: 1},{lat: 48.8833, lon:8.3333, count: 2},{lat: 53.5333, lon:-0.05, count: 1},{lat: 55.95, lon:-3.2, count: 2},{lat: 55.8333, lon:-4.25, count: 4},{lat: 54.6861, lon:-1.2125, count: 2},{lat: 52.5833, lon:-0.25, count: 2},{lat: 53.55, lon:-2.5167, count: 2},{lat: 52.7667, lon:-1.2, count: 1},{lat: 52.6333, lon:-1.8333, count: 2},{lat: 55.0047, lon:-1.4728, count: 2},{lat: 50.9, lon:-1.4, count: 2},{lat: 52.6333, lon:1.3, count: 5},{lat: 52.25, lon:-1.1667, count: 1},{lat: 54.9167, lon:-1.7333, count: 1},{lat: 53.5667, lon:-2.9, count: 3},{lat: 55.8833, lon:-3.5333, count: 1},{lat: 53.0667, lon:6.4667, count: 1},{lat: 48.3333, lon:16.35, count: 37},{lat: 58.35, lon:15.2833, count: 1},{lat: 50.6167, lon:3.0167, count: 1},{lat: 53.3833, lon:-2.6, count: 1},{lat: 53.3833, lon:-2.6, count: 2},{lat: 54.5333, lon:-1.15, count: 5},{lat: 51.55, lon:0.05, count: 2},{lat: 51.55, lon:0.05, count: 1},{lat: 50.8, lon:-0.3667, count: 2},{lat: 49.0533, lon:11.7822, count: 1},{lat: 52.2333, lon:4.8333, count: 1},{lat: 54.5833, lon:-1.4167, count: 3},{lat: 54.5833, lon:-5.9333, count: 1},{lat: 43.1167, lon:5.9333, count: 2},{lat: 51.8333, lon:-2.25, count: 1},{lat: 50.3964, lon:-4.1386, count: 2},{lat: 51.45, lon:-2.5833, count: 4},{lat: 54.9881, lon:-1.6194, count: 1},{lat: 55.9833, lon:-4.6, count: 4},{lat: 53.4167, lon:-3, count: 1},{lat: 51.5002, lon:-0.1262, count: 2},{lat: 50.3964, lon:-4.1386, count: 8},{lat: 51.3742, lon:-2.1364, count: 1},{lat: 52.4833, lon:-2.1167, count: 1},{lat: 54.5728, lon:-1.1628, count: 1},{lat: 54.5333, lon:-1.15, count: 1},{lat: 47.7833, lon:7.3, count: 1},{lat: 46.95, lon:4.8333, count: 1},{lat: 60.1756, lon:24.9342, count: 2},{lat: 58.2, lon:16, count: 2},{lat: 57.7167, lon:11.9667, count: 1},{lat: 60.0667, lon:15.9333, count: 2},{lat: 41.2333, lon:1.8167, count: 2},{lat: 40.4833, lon:-3.3667, count: 1},{lat: 52.1333, lon:4.6667, count: 2},{lat: 51.4167, lon:5.4167, count: 1},{lat: 51.9667, lon:4.6167, count: 2},{lat: 51.8333, lon:4.6833, count: 1},{lat: 51.8333, lon:4.6833, count: 2},{lat: 48.2, lon:16.3667, count: 1},{lat: 54.6833, lon:25.3167, count: 2},{lat: 51.9333, lon:4.5833, count: 2},{lat: 50.9, lon:5.9833, count: 1},{lat: 51.4333, lon:-1, count: 1},{lat: 49.4478, lon:11.0683, count: 1},{lat: 61.1333, lon:21.5, count: 1},{lat: 62.4667, lon:6.15, count: 1},{lat: 59.2167, lon:10.95, count: 1},{lat: 48.8667, lon:2.3333, count: 1},{lat: 52.35, lon:4.9167, count: 4},{lat: 52.35, lon:4.9167, count: 5},{lat: 52.35, lon:4.9167, count: 32},{lat: 54.0833, lon:12.1333, count: 1},{lat: 50.8, lon:-0.5333, count: 1},{lat: 50.8333, lon:-0.15, count: 1},{lat: 52.5167, lon:13.4, count: 2},{lat: 58.3167, lon:15.1333, count: 2},{lat: 59.3667, lon:16.5, count: 1},{lat: 55.8667, lon:12.8333, count: 2},{lat: 50.8667, lon:6.8667, count: 1},{lat: 52.5833, lon:-0.25, count: 1},{lat: 53.5833, lon:-0.65, count: 2},{lat: 44.4333, lon:26.1, count: 6},{lat: 44.4333, lon:26.1, count: 3},{lat: 51.7833, lon:-3.0833, count: 1},{lat: 50.85, lon:-1.7833, count: 1},{lat: 52.2333, lon:-1.7333, count: 1},{lat: 53.1333, lon:-1.2, count: 2},{lat: 51.4069, lon:-2.5558, count: 1},{lat: 51.3833, lon:-0.1, count: 1},{lat: 52.4667, lon:-0.9167, count: 1},{lat: 55.1667, lon:-1.6833, count: 1},{lat: 50.9667, lon:-2.75, count: 5},{lat: 53.25, lon:-1.9167, count: 4},{lat: 55.8333, lon:-4.25, count: 5},{lat: 50.7167, lon:-2.4333, count: 1},{lat: 51.2, lon:-0.5667, count: 2},{lat: 51.0667, lon:-1.7833, count: 2},{lat: 51.8167, lon:-2.7167, count: 2},{lat: 53.3833, lon:-0.7667, count: 1},{lat: 51.3667, lon:1.45, count: 6},{lat: 55.4333, lon:-5.6333, count: 1},{lat: 52.4167, lon:-1.55, count: 4},{lat: 51.5333, lon:-0.3167, count: 2},{lat: 50.45, lon:-3.5, count: 2},{lat: 53.0167, lon:-1.6333, count: 1},{lat: 51.7833, lon:1.1667, count: 3},{lat: 53.8833, lon:-1.2667, count: 1},{lat: 56.6667, lon:-3, count: 2},{lat: 51.4, lon:-1.3167, count: 5},{lat: 52.1333, lon:-0.45, count: 1},{lat: 52.4667, lon:-1.9167, count: 1},{lat: 52.05, lon:-2.7167, count: 1},{lat: 54.7, lon:-5.8667, count: 2},{lat: 52.4167, lon:-1.55, count: 1},{lat: 43.6, lon:3.8833, count: 1},{lat: 49.1833, lon:-0.35, count: 1},{lat: 52.6333, lon:-1.1333, count: 2},{lat: 52.4733, lon:-8.1558, count: 1},{lat: 53.3331, lon:-6.2489, count: 3},{lat: 53.3331, lon:-6.2489, count: 1},{lat: 52.3342, lon:-6.4575, count: 1},{lat: 52.2583, lon:-7.1119, count: 1},{lat: 54.25, lon:-6.9667, count: 1},{lat: 52.9667, lon:-1.1667, count: 2},{lat: 51.3742, lon:-2.1364, count: 2},{lat: 52.5667, lon:-1.55, count: 3},{lat: 49.9481, lon:11.5783, count: 1},{lat: 52.3833, lon:9.9667, count: 1},{lat: 47.8167, lon:9.5, count: 1},{lat: 50.0833, lon:19.9167, count: 1},{lat: 52.2167, lon:5.2833, count: 1},{lat: 42.4333, lon:-8.6333, count: 1},{lat: 42.8333, lon:12.8333, count: 1},{lat: 55.7167, lon:12.45, count: 1},{lat: 50.7, lon:3.1667, count: 1},{lat: 51.5833, lon:-0.2833, count: 1},{lat: 53.4333, lon:-1.35, count: 1},{lat: 62.8, lon:30.15, count: 1},{lat: 51.3, lon:12.3333, count: 2},{lat: 53.6528, lon:-6.6814, count: 1},{lat: 40.2333, lon:-3.7667, count: 1},{lat: 42.3741, lon:-71.1072, count: 1},{lat: 51.5002, lon:-0.1262, count: 5},{lat: 52.4667, lon:-1.9167, count: 2},{lat: 53.5, lon:-2.2167, count: 3},{lat: 54.0667, lon:-2.8333, count: 1},{lat: 52.5, lon:-2, count: 1},{lat: 48.0833, lon:-1.6833, count: 2},{lat: 43.6, lon:1.4333, count: 4},{lat: 52.6, lon:-2, count: 1},{lat: 56, lon:-3.7667, count: 1},{lat: 55.8333, lon:-4.25, count: 3},{lat: 55.8333, lon:-4.25, count: 1},{lat: 55.8333, lon:-4.25, count: 2},{lat: 53.8, lon:-1.5833, count: 1},{lat: 54.65, lon:-2.7333, count: 1},{lat: 51.5, lon:-3.2, count: 1},{lat: 54.35, lon:-6.2833, count: 1},{lat: 51.2, lon:-0.8, count: 1},{lat: 54.6861, lon:-1.2125, count: 1},{lat: 51.75, lon:-0.3333, count: 2},{lat: 52.3667, lon:-1.25, count: 1},{lat: 53.8, lon:-1.5833, count: 2},{lat: 52.6333, lon:-2.5, count: 2},{lat: 52.5167, lon:-1.4667, count: 1},{lat: 57.4833, lon:12.0667, count: 1},{lat: 59.3667, lon:18.0167, count: 1},{lat: 46, lon:2, count: 1},{lat: 51.0211, lon:-3.1047, count: 1},{lat: 53.4167, lon:-3, count: 4},{lat: 51.25, lon:-0.7667, count: 1},{lat: 49, lon:2.3833, count: 1},{lat: 50.8333, lon:4, count: 1},{lat: 48.7833, lon:2.4667, count: 1},{lat: 52, lon:20, count: 2},{lat: 55.7522, lon:37.6156, count: 1},{lat: 51.55, lon:5.1167, count: 1},{lat: 52, lon:20, count: 1},{lat: 49.9667, lon:7.9, count: 1},{lat: 46.25, lon:20.1667, count: 1},{lat: 49.3, lon:-1.2333, count: 1},{lat: 48.4333, lon:8.6833, count: 1},{lat: 51.65, lon:-0.2667, count: 1},{lat: 53.7, lon:-1.4833, count: 2},{lat: 51.5002, lon:-0.1262, count: 3},{lat: 51.5, lon:-0.5833, count: 1},{lat: 52.5833, lon:-2.1333, count: 2},{lat: 49.2833, lon:1, count: 3},{lat: 43.65, lon:5.2667, count: 2},{lat: 54.9881, lon:-1.6194, count: 2},{lat: 51.3458, lon:-2.9678, count: 2},{lat: 51.0833, lon:-4.05, count: 1},{lat: 50.8667, lon:-2.9667, count: 1},{lat: 50.3964, lon:-4.1386, count: 5},{lat: 53.5333, lon:-1.1167, count: 1},{lat: 54.9878, lon:-1.4214, count: 3},{lat: 51.4167, lon:-0.2833, count: 1},{lat: 54.9881, lon:-1.6194, count: 3},{lat: 52.4167, lon:-1.55, count: 3},{lat: 51.5002, lon:-0.1262, count: 4},{lat: 51.55, lon:0.1667, count: 1},{lat: 51.8333, lon:-2.25, count: 3},{lat: 53.65, lon:-1.7833, count: 2},{lat: 53.5833, lon:-2.4333, count: 2},{lat: 51.45, lon:-2.5833, count: 1},{lat: 59.9667, lon:17.7, count: 1},{lat: 54, lon:-2, count: 8},{lat: 52.7167, lon:-2.7333, count: 2},{lat: 51.0833, lon:-0.7, count: 1},{lat: 51.8, lon:4.4667, count: 1},{lat: 48.9, lon:9.1167, count: 1},{lat: 48.3167, lon:2.5, count: 2},{lat: 51.6667, lon:-0.4, count: 1},{lat: 51.75, lon:-1.25, count: 1},{lat: 52.6333, lon:-2.5, count: 1},{lat: 52.35, lon:4.9167, count: 3},{lat: 51.3458, lon:-2.9678, count: 1},{lat: 53.7167, lon:-1.85, count: 1},{lat: 53.4333, lon:-1.35, count: 4},{lat: 42.2, lon:24.3333, count: 2},{lat: 51.5333, lon:0.7, count: 1},{lat: 50.3964, lon:-4.1386, count: 1},{lat: 50.3964, lon:-4.1386, count: 12},{lat: 50.3964, lon:-4.1386, count: 20},{lat: 52.5833, lon:-2.1333, count: 1},{lat: 55.7667, lon:-4.1667, count: 7},{lat: 53.3167, lon:-3.1, count: 1},{lat: 51.9, lon:-2.0833, count: 1},{lat: 50.7167, lon:-1.8833, count: 1},{lat: 51.6, lon:0.5167, count: 2},{lat: 53.5, lon:-2.2167, count: 1},{lat: 53.1333, lon:-1.2, count: 1},{lat: 52.0167, lon:4.3333, count: 4},{lat: 50.7, lon:3.1667, count: 2},{lat: 49.6769, lon:6.1239, count: 13},{lat: 53.1, lon:-2.4333, count: 1},{lat: 51.3794, lon:-2.3656, count: 1},{lat: 24.6408, lon:46.7728, count: 2},{lat: 24.6408, lon:46.7728, count: 3},{lat: 50.75, lon:-1.55, count: 1},{lat: 52.6333, lon:1.75, count: 1},{lat: 48.15, lon:9.4667, count: 1},{lat: 52.35, lon:4.9167, count: 2},{lat: 60.8, lon:11.1, count: 1},{lat: 43.561, lon:-116.214, count: 1},{lat: 47.5036, lon:-94.685, count: 1},{lat: 42.1818, lon:-71.1962, count: 1},{lat: 42.0477, lon:-74.1227, count: 1},{lat: 40.0326, lon:-75.719, count: 1},{lat: 40.7128, lon:-73.2962, count: 2},{lat: 27.9003, lon:-82.3024, count: 1},{lat: 38.2085, lon:-85.6918, count: 1},{lat: 46.8159, lon:-100.706, count: 1},{lat: 30.5449, lon:-90.8083, count: 1},{lat: 44.735, lon:-89.61, count: 1},{lat: 41.4201, lon:-75.6485, count: 2},{lat: 39.4209, lon:-74.4977, count: 1},{lat: 39.7437, lon:-104.979, count: 1},{lat: 39.5593, lon:-105.006, count: 1},{lat: 45.2673, lon:-93.0196, count: 1},{lat: 41.1215, lon:-89.4635, count: 1},{lat: 43.4314, lon:-83.9784, count: 1},{lat: 43.7279, lon:-86.284, count: 1},{lat: 40.7168, lon:-73.9861, count: 1},{lat: 47.7294, lon:-116.757, count: 1},{lat: 47.7294, lon:-116.757, count: 2},{lat: 35.5498, lon:-118.917, count: 1},{lat: 34.1568, lon:-118.523, count: 1},{lat: 39.501, lon:-87.3919, count: 3},{lat: 33.5586, lon:-112.095, count: 1},{lat: 38.757, lon:-77.1487, count: 1},{lat: 33.223, lon:-117.107, count: 1},{lat: 30.2316, lon:-85.502, count: 1},{lat: 39.1703, lon:-75.5456, count: 8},{lat: 30.0041, lon:-95.2984, count: 2},{lat: 29.7755, lon:-95.4152, count: 1},{lat: 41.8014, lon:-87.6005, count: 1},{lat: 37.8754, lon:-121.687, count: 7},{lat: 38.4493, lon:-122.709, count: 1},{lat: 40.5494, lon:-89.6252, count: 1},{lat: 42.6105, lon:-71.2306, count: 1},{lat: 40.0973, lon:-85.671, count: 1},{lat: 40.3987, lon:-86.8642, count: 1},{lat: 40.4224, lon:-86.8031, count: 4},{lat: 47.2166, lon:-122.451, count: 1},{lat: 32.2369, lon:-110.956, count: 1},{lat: 41.3969, lon:-87.3274, count: 2},{lat: 41.7364, lon:-89.7043, count: 2},{lat: 42.3425, lon:-71.0677, count: 1},{lat: 33.8042, lon:-83.8893, count: 1},{lat: 36.6859, lon:-121.629, count: 2},{lat: 41.0957, lon:-80.5052, count: 1},{lat: 46.8841, lon:-123.995, count: 1},{lat: 40.2851, lon:-75.9523, count: 2},{lat: 42.4235, lon:-85.3992, count: 1},{lat: 39.7437, lon:-104.979, count: 2},{lat: 25.6586, lon:-80.3568, count: 7},{lat: 33.0975, lon:-80.1753, count: 1},{lat: 25.7615, lon:-80.2939, count: 1},{lat: 26.3739, lon:-80.1468, count: 1},{lat: 37.6454, lon:-84.8171, count: 1},{lat: 34.2321, lon:-77.8835, count: 1},{lat: 34.6774, lon:-82.928, count: 1},{lat: 39.9744, lon:-86.0779, count: 1},{lat: 35.6784, lon:-97.4944, count: 2},{lat: 33.5547, lon:-84.1872, count: 1},{lat: 27.2498, lon:-80.3797, count: 1},{lat: 41.4789, lon:-81.6473, count: 1},{lat: 41.813, lon:-87.7134, count: 1},{lat: 41.8917, lon:-87.9359, count: 1},{lat: 35.0911, lon:-89.651, count: 1},{lat: 32.6102, lon:-117.03, count: 1},{lat: 41.758, lon:-72.7444, count: 1},{lat: 39.8062, lon:-86.1407, count: 1},{lat: 41.872, lon:-88.1662, count: 1},{lat: 34.1404, lon:-81.3369, count: 1},{lat: 46.15, lon:-60.1667, count: 1},{lat: 36.0679, lon:-86.7194, count: 1},{lat: 43.45, lon:-80.5, count: 1},{lat: 44.3833, lon:-79.7, count: 1},{lat: 45.4167, lon:-75.7, count: 2},{lat: 43.75, lon:-79.2, count: 2},{lat: 45.2667, lon:-66.0667, count: 3},{lat: 42.9833, lon:-81.25, count: 2},{lat: 44.25, lon:-79.4667, count: 3},{lat: 45.2667, lon:-66.0667, count: 2},{lat: 34.3667, lon:-118.478, count: 3},{lat: 42.734, lon:-87.8211, count: 1},{lat: 39.9738, lon:-86.1765, count: 1},{lat: 33.7438, lon:-117.866, count: 1},{lat: 37.5741, lon:-122.321, count: 1},{lat: 42.2843, lon:-85.2293, count: 1},{lat: 34.6574, lon:-92.5295, count: 1},{lat: 41.4881, lon:-87.4424, count: 1},{lat: 25.72, lon:-80.2707, count: 1},{lat: 34.5873, lon:-118.245, count: 1},{lat: 35.8278, lon:-78.6421, count: 1}]
    };

    var cfg = {
      // radius should be small ONLY if scaleRadius is true (or small radius is intended)
      // if scaleRadius is false it will be the constant radius used in pixels
      "radius": 2,
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
      lngField: 'lon',
      // which field name in your data represents the data value - default "value"
      valueField: 'count'
    };






    //var transformedTestData = { max: testData.max , data: [] },
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

      var heatmapLayer = new HeatmapOverlay(cfg);
 


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
            "Streets": streets2,
            "HeatMap":heatmapLayer
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
            layers: [bike2, streets2, heatmapLayer]
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
          layers: [bike, streets, heatmapLayer]
       });
       L.control.layers(baseMaps, overlayMaps).addTo(map);

       heatmapLayer.setData(testData);



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

    var lats = [];
    var lngs = [];
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
