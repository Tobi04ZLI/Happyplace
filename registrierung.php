<!doctype html>
<html lang="en">

<head>¨
    <style>
        .back {
            margin-left: -10px;
            margin-top: 41px;
            background-color: red;
            width: 177px;
        }

        .input {
            margin-left: 830px;
            margin-top: 250px;
        }
    </style>
</head>

<body>

    <button class="back" onclick="location.href='index.php'">back to main page</button>

    <form action="registrierung.php" method="POST">
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

    <?php
    $servername = "localhost";
    $user = "root";
    $password = "";
    $dbname = "happyplace";

    $connection = new mysqli($servername, $user, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    if(isset($_POST['submit'])){
    $prename = $_POST['prename'];    
    $lastname = $_POST['lastname'];
    $location = $_POST['location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    
    $idcount = "SELECT COUNT(id) as countid FROM apprentices";
    $results = $connection->query($idcount);
    $row = $results->fetch_assoc();
    $id = $row["countid"]+1;

/*ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(-1);*/

    if ($prename != "" && $lastname != "" && $location != ""  &&  $latitude != "" && $longitude != ""){
    $placeSQL = "INSERT INTO places (id, name, latitude, longitude) VALUES ($id, '$location', '$latitude', '$longitude');";
    $markersSQL = "INSERT INTO markers (id) VALUES ($id);";
    $apprenticesSQL = "INSERT INTO apprentices (prename, lastname, place_id, markers_id) VALUES ('$prename', '$lastname', $id, $id);";
    mysqli_query($connection, $placeSQL);
    mysqli_query($connection, $markersSQL);
    mysqli_query($connection, $apprenticesSQL);
    }
}

    ?>
</body>  

</html>