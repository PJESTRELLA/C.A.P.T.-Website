<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $birthdate = $_POST["birthDate"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $consent = $_POST["consent"];

        echo "<h1>Form Data Received</h1>";

        echo "<strong>Email</strong>: {$email}<br>";
        echo "<strong>Birth Date</strong>: {$birthdate}<br>";
        echo "<strong>Username</strong>: {$username}<br>";
        echo "<strong>Email</strong>: {$email}<br>";
        echo "<strong>Password</strong>: {$password}<br>";
        echo "<strong>Consent</strong>: {$consent}<br>";
    } else {
        echo "<h1>No data submitted!</h1>";
    }
?>
