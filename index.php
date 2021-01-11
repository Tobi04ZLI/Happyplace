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
        height: 800px;
        width: 80%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: -9;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
    <title>Project Happy Place</title>
  </head>
  <body>
  <form action = "index.php" method = "POST">
  <input type="text" name="personsearch" value="<?php echo($_POST["personsearch"]);?>">
  <input type="text" name="personsearch-last" value="<?php echo($_POST["personsearch-last"]);?>">
  <button type="submit" name="submit-search">
  suchen
  </button>
  </form>

    <div id="map" class="map"></div>
    <script type="text/javascript">
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({

            source: new ol.source.XYZ({
                urls : ["http://a.tile.openstreetmap.org/{z}/{x}/{y}.png","http://b.tile.openstreetmap.org/{z}/{x}/{y}.png","http://c.tile.openstreetmap.org/{z}/{x}/{y}.png"]
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
if (isset($_POST['submit-search'])) {
  $searchedperson = $_POST['personsearch'];
  $searchedperson_last = $_POST['personsearch-last'];
  $sql_full = "SELECT * FROM apprentices WHERE prename='" . $searchedperson . "' AND lastname='$searchedperson_last';";
  $result_full = $connection->query($sql_full);
  $sql_appr = "SELECT prename, lastname FROM apprentices WHERE prename='" . $searchedperson . "' AND lastname='$searchedperson_last';";
  $result_appr = $connection->query($sql_appr);
  if ($result_full->num_rows > 0) {
      $row_full = $result_full->fetch_array(MYSQLI_BOTH);
      $row_appr = $result_appr->fetch_array(MYSQLI_BOTH);
      $place_id = $row_full[3];
      $marker_id = $row_full[4];
      $sql_place = "SELECT latitude, longitude FROM places WHERE id=" . $place_id . ";";
      $sql_marker = "SELECT color FROM markers WHERE id=" . $marker_id . ";";
      $result_places = $connection->query($sql_place);
      $result_marker = $connection->query($sql_marker);
      $row_places = $result_places->fetch_array(MYSQLI_BOTH);
      $row_marker = $result_marker->fetch_array(MYSQLI_BOTH);

      $herkunft = "SELECT * FROM apprentices";
      $ausgabe = $connection->query($herkunft);
      while($row = $ausgabe->fetch_object()) {
        ?>
        <p>
        <?php echo $row->prename; ?> 
        <?php echo $row->lastname; ?> 
        </p>
        <?php
      }

      echo "
      <script type='text/javascript'>
          add_map_point(" . $row_places[1] . ", " . $row_places[0] . ");
      </script>";;
  } else {
      echo "<p id='result-id' class='result'>0 results</p>";
  }

}
$connection->close();
?>

  </body>
</html> 
