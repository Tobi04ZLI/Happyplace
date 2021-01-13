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

            <table>
                <form action="index.php" method="POST">
                        <?php echo $row->prename; ?>
                        <?php echo $row->lastname; ?>
                </form>
            </table>

    <?php
        }
    
    $connection->close();
    ?>

</body>

</html>