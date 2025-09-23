<?php
    $servername = "localhost";
    $username = "u362083597_captofficial";
    $password = "BarangaySystem2025";
    $dbname = "u362083597_test_userAuth";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error){
        die("Failed connection :(.");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $birthDate = $_POST['birthDate'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "INSERT INTO user (name, birthDate, username, email, password) VALUES ('$name', '$birthDate', '$username', '$email', '$password')";

        if($conn->query($sql) === TRUE){
        echo "<h1>Form Data Received</h1>";

        echo "<strong>Name</strong>: {$name}<br>";
        echo "<strong>Birth Date</strong>: {$birthDate}<br>";
        echo "<strong>Username</strong>: {$username}<br>";
        echo "<strong>Email</strong>: {$email}<br>";
        echo "<strong>Password</strong>: {$password}<br>";
        } else{
            echo "Error!";
        }
    }

    $conn->close();
?>