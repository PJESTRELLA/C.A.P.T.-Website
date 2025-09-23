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
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM user
                WHERE email='$email'
                AND password='$password'";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            header("Location: login.php");
            exit();
        } else{
            echo "Invalid credentials.";
        }
    }
?>