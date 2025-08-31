<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        echo "<h1>Form Data Received</h1>";
        echo "<strong>Email</strong>: {$email}<br>";
        echo "<strong>Password</strong>: {$password}";
    } else {
        echo "<h1>No data submitted!</h1>";
    }
?>
