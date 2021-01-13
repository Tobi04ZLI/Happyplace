<!doctype html>
<html lang="en">

<head>¨
    <style>
        .input {
            margin-left: 830px;
            margin-top: 250px;
        }

        .back {
            margin-left: 830px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <form action="login.php" method="POST">
        <div class="input">
            <input type="text" name="prename" placeholder="prename"> <br> <br>
            <input type="text" name="lastname" placeholder="lastname"> <br> <br>
            <input type="text" name="username" placeholder="username"> <br> <br>
            <input type="password" name="password" placeholder="password"> <br> <br>
            <button type="submit" name="submit">
                register
            </button>
        </div>
    </form>
    <button class="back" onclick="location.href='index.php'">I already have an account</button>

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
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $idcount = "SELECT COUNT(id) as countid FROM users";
    $results = $connection->query($idcount);
    $row = $results->fetch_assoc();
    $id = $row["countid"]+1;

/*ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(-1);*/

    if ($prename != "" && $lastname != "" && $username != ""  &&  $password != ""){
    $userSQL = "INSERT INTO users (id, prename, lastname, username, password) VALUES ($id, '$prename', '$lastname', '$username', '$password');";
    mysqli_query($connection, $userSQL);

    }
}

    ?>

</body>

</html>