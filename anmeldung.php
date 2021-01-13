<!doctype html>
<html lang="en">

<head>
    <style>
        .input {
            margin-left: 830px;
            margin-top: 250px;
        }

        .back {
            margin-left: -10px;
            margin-top: 41px;
            background-color: red;
            width: 177px;
        }
    </style>
</head>

<body>

    <button class="back" onclick="location.href='index.php'">back to main page</button>

    <form action="anmeldung.php" method="POST">
        <div class="input">
            <input type="text" name="username" placeholder="username"> <br> <br>
            <input type="password" name="password" placeholder="password"> <br> <br>
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

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username != "" && $password != "") {

            $myusername = mysqli_real_escape_string($connection, $_POST['username']);
            $mypassword = mysqli_real_escape_string($connection, $_POST['password']);
            $verifacation = "SELECT username FROM users WHERE username = '$myusername' AND password = '$mypassword';";
            $result = mysqli_query($connection, $verifacation);
            if (mysqli_num_rows($result)) {
                echo "Acess granted";
                header("Location: crud.php");
            } else {
                echo ("this user does not exist");
            }
        }
    }
    ?>

</body>

</html>