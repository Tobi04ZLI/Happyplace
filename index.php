<!doctype html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css" type="text/css">
  <style>
    /*{
        margin: 0;
        padding: 0;
      }*/
    .map {
      margin-left: 370px;
      margin-top: 40px;
      height: 850px;
      width: 80%;
      position: absolute;
      top: 0;
      left: 0;
      z-index: -9;
    }

    table {
      border-collapse: collapse;
      margin-top: 20px;
    }

    button {
      width: 200px;
      background-color: #BEBEBE;
    }

    .name {
      border: white;
      background-color: #BEBEBE;
    }

    .register {
      margin-top: 20px;
      background-color: green;
      width: 177px;
    }

    .registertwo {
      margin-top: 20px;
      background-color: blue;
      width: 177px;
    }

    .back {
      margin-top: 20px;
      background-color: red;
      width: 177px;
    }

    .login {
      margin-top: 20px;
      background-color: yellow;
      width: 177px;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
  <title>Project Happy Place</title>
</head>

<body>
  <?php

  if (!empty($_POST["personsearch"]) && !empty($_POST["personsearch-last"])) {
    $searchPrename = $_POST["personsearch"];
    $searchLastname = $_POST["personsearch-last"];
  } else {
    $searchPrename = '';
    $searchLastname = '';
  }

  ?>
  <form action="index.php" method="POST">
    <input type="text" name="personsearch" placeholder="prename" value="<?php echo ($searchPrename); ?>">
    <input type="text" name="personsearch-last" placeholder="lastname" value="<?php echo ($searchLastname); ?>">
    <button type="submit" name="submit-search">
      search
    </button>
  </form>

  <button class="register" onclick="location.href='registrierung.php'">register new member</button>
  <button class="back" onclick="location.href='index.php'">back to main page</button> <br>
  <button class="registertwo" onclick="location.href='login.php'">register new admin</button>
  <button class="login" onclick="location.href='anmeldung.php'">log in as admin</button>

  <h2>Members</h2>

  <div id="map" class="map"></div>
  <script type="text/javascript">
    var map = new ol.Map({
      target: 'map',
      layers: [
        new ol.layer.Tile({

          source: new ol.source.XYZ({
            urls: ["http://a.tile.openstreetmap.org/{z}/{x}/{y}.png", "http://b.tile.openstreetmap.org/{z}/{x}/{y}.png", "http://c.tile.openstreetmap.org/{z}/{x}/{y}.png"]
          })

          /*source: new ol.source.OSM()*/
        }),
        new ol.layer.Vector({
          source: new ol.source.Vector({
            format: new ol.format.GeoJSON(),
            url: './assets/data/countries.geojson' // GeoCountries file from github
          })
        })
      ],
      view: new ol.View({
        center: ol.proj.fromLonLat([8.5208324, 47.360127]),
        zoom: 10
      })
    });

    function add_map_point(lng, lat) {
      var vectorLayer = new ol.layer.Vector({
        source: new ol.source.Vector({
          features: [new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lng), parseFloat(lat)], 'EPSG:4326', 'EPSG:3857')),
          })]
        }),
        style: new ol.style.Style({
          image: new ol.style.Icon({
            anchor: [0.5, 0.5],
            anchorXUnits: "fraction",
            anchorYUnits: "fraction",
            src: "https://upload.wikimedia.org/wikipedia/commons/e/ec/RedDot.svg"
          })
        })
      });
      map.setView(new ol.View({
        center: ol.proj.transform([lng, lat], 'EPSG:4326', 'EPSG:3857'),
        zoom: 10
      }));
      map.addLayer(vectorLayer);
    }
  </script>

  <?php
  $servername = "localhost";
  $user = "root";
  $password = "";
  $dbname = "happyplace";

  $connection = new mysqli($servername, $user, $password, $dbname);
  if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
  }

  $herkunft = "SELECT * FROM apprentices JOIN places ON apprentices.place_id = places.id JOIN markers ON apprentices.markers_id = markers.id";

  if (!empty($_POST["personsearch"]) && !empty($_POST["personsearch-last"])) {
    $herkunft .= sprintf(" WHERE prename='%s' AND lastname='%s'", $searchPrename, $searchLastname);
  }

  $ausgabe = $connection->query($herkunft);

  if ($ausgabe->num_rows <= 0) {
    echo "<p id='result-id' class='result'>0 results</p>";
  } else {

    while ($row = $ausgabe->fetch_object()) {
  ?>

      <table>
        <form action="index.php" method="POST">
          <button type="submit" name="submit-search">
            <input class="name" type="text" name="personsearch" value="<?php echo $row->prename; ?>">
            <input class="name" type="text" name="personsearch-last" value="<?php echo $row->lastname; ?>">
          </button>
        </form>
      </table>

  <?php


      echo "
            <script type='text/javascript'>
                add_map_point(" . $row->longitude . ", " . $row->latitude . ");
            </script>";
    }
  }
  $connection->close();
  ?>

</body>

</html>