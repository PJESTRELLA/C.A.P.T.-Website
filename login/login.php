<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        echo "<h1>Form Data Received</h1>";

        echo "<strong>Email</strong>: {$email}<br>";
        echo "<strong>Password</strong>: {$password}";
    } else {
        echo "<h1>No data submitted!</h1>";
    }
?>
