<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
        $birthdate = $_POST["birthDate"];
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
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
