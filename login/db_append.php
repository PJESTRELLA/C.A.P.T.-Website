<?php
    $servername = "localhost";
    $username = "u362083597_captofficial";
    $password = "BarangaySystem2025";
    $dbname = "u362083597_test_userAuth";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error){
        die("Failed connection :(.");
    }

    $raiseError = [];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $birthDate = $_POST['birthDate'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $consent = $_POST['consent'];

        if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
            $raiseError[] = "❎ Name must only contain letters and spaces.";
        }
        if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            $raiseError[] = "❎ Username must only contain letters, numbers, and underscores (_).";
        }
        if (strlen($password) < 8){
            $raiseError[] = "❎ Password must contain at least eight characters.";
        }
        if (!preg_match("/[a-z]/", $password)) {
            $raiseError[] = "❎ Password must contain at least one lowercase letter.";
        }
        if (!preg_match("/[A-Z]/", $password)) {
            $raiseError[] = "❎ Password must contain at least one uppercase letter.";
        }
        if (!preg_match("/[0-9]/", $password)) {
            $raiseError[] = "❎ Password must contain at least one numerical character.";
        }
        if (!preg_match("/[\W_]/", $password)) {
            $raiseError[] = "❎ Password must contain at least one special symbol.";
        }
        
        if(empty($raiseError)){
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $statement = $conn->prepare("INSERT INTO user (name, birthDate, username, email, password, consent) VALUES (?, ?, ?, ?, ?, ?)");
            $statement->bind_param("ssssss", $name, $birthDate, $username, $email, $hashed_password, $consent);

            if($statement->execute()){
            echo "<h1>Form Data Received</h1>";

            echo "<strong>Name</strong>: {$name}<br>";
            echo "<strong>Birth Date</strong>: {$birthDate}<br>";
            echo "<strong>Username</strong>: {$username}<br>";
            echo "<strong>Email</strong>: {$email}<br>";
            echo "<strong>Password</strong>: {$password}<br>";
            } else{
                echo "[WARNING]: An error has been observed: " . $statement->error;
            }

            $statement->close();
        } 
    }
    $conn->close();
?>