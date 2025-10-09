<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $servername = "localhost"; 
    $username = "u362083597_captofficial"; 
    $password = "BarangaySystem2025"; 
    $dbname = "u362083597_test_userAuth"; 
    
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    $mysqli->set_charset("utf8mb4");

    $raiseError = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $mysqli->prepare("SELECT id, `password` FROM `user` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($uid, $hash);
            $stmt->fetch();

            if (password_verify($password, $hash)) {
                header("Location: /dashboard/user/user-bulletin.html");
                exit();
            } else {
                $raiseError = "❎ [ERROR]: Password does not match with the registered email.";
            }
        } else {
            $raiseError = "❎ [ERROR]: The login credentials you provided are not officially registered.";
        }
        $stmt->close();
    }

    $mysqli->close();
?>