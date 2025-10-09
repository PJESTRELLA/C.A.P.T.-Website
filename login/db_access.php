<?php
    declare(strict_types=1);
    ini_set('display_errors', '1');
    error_reporting(E_ALL);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method Not Allowed');
    }

    $mysqli = new mysqli('localhost', 'u362083597_captofficial', 'BarangaySystem2025', 'u362083597_test_userAuth');
    if ($mysqli->connect_errno) {
        http_response_code(500);
        exit('DB connection failed');
    }

    $email = $_POST['email'] ?? '';
    $pass  = $_POST['password'] ?? '';

    $stmt = $mysqli->prepare('SELECT password FROM user WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($hash);
    $found = $stmt->fetch();
    $stmt->close();
    $mysqli->close();

    if ($found && password_verify($pass, $hash)) {
        header('Location: /dashboard/user/user-bulletin.html', true, 303);
        exit;
    }

    header('Location: /login.php?err=invalid', true, 303);
    exit;
