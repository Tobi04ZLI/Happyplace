<!doctype html>
<html lang="en">

<head>
    <style>
        .back {
            margin-left: -10px;
            margin-top: 41px;
            background-color: red;
            width: 177px;
        }

        .input {
            margin-left: 280px;
            margin-top: -250px;
        }

        .backtwo {
            background-color: green;
        }

        .output {
        margin-top: 0px;
    }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
    <title>Project Happy Place</title>
</head>

<body>


    <button class="back" onclick="location.href='index.php'">back to main page</button>

    <h2>Members</h2>

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

    $ausgabe = $connection->query($herkunft);

    while ($row = $ausgabe->fetch_object()) {
    ?>
        <div class="output">
            <table>
                <form action="index.php" method="POST">
                    <?php echo $row->prename; ?> 
                    <?php echo $row->lastname; ?> <br> <br>
                </form>
            </table>
        </div>
    <?php
    }

    if (isset($_POST['submit'])) {
        $prename = $_POST['prename'];
        $lastname = $_POST['lastname'];
        $location = $_POST['location'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        $idcount = "SELECT COUNT(id) as countid FROM apprentices";
        $results = $connection->query($idcount);
        $row = $results->fetch_assoc();
        $id = $row["countid"] + 1;

        /*ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(-1);*/

        if ($prename != "" && $lastname != "" && $location != ""  &&  $latitude != "" && $longitude != "") {
            $placeSQL = "INSERT INTO places (id, name, latitude, longitude) VALUES ($id, '$location', '$latitude', '$longitude');";
            $markersSQL = "INSERT INTO markers (id) VALUES ($id);";
            $apprenticesSQL = "INSERT INTO apprentices (prename, lastname, place_id, markers_id) VALUES ('$prename', '$lastname', $id, $id);";
            mysqli_query($connection, $placeSQL);
            mysqli_query($connection, $markersSQL);
            mysqli_query($connection, $apprenticesSQL);
        }
    }



    $connection->close();
    ?>

<form action="crud.php" method="POST">
        <div class="input">
            <input type="text" name="prename" placeholder="prename"> <br> <br>
            <input type="text" name="lastname" placeholder="lastname"> <br> <br>
            <input type="text" name="location" placeholder="location"> <br> <br>
            <input type="text" name="latitude" placeholder="latitude"> <br> <br>
            <input type="text" name="longitude" placeholder="longitude">
            <button type="submit" name="submit">
                register
            </button>
        </div>
    </form>

</body>

</html>