<?php
    declare(strict_types=1);
    ini_set('display_errors','1');
    error_reporting(E_ALL);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method Not Allowed');
    }

    $mysqli = new mysqli('localhost','u362083597_captofficial','BarangaySystem2025','u362083597_test_userAuth');
    if ($mysqli->connect_errno) {
        http_response_code(500);
        exit('DB connection failed');
    }

    $email = $_POST['email'] ?? '';
    $pass  = $_POST['password'] ?? '';

    $stmt = $mysqli->prepare('SELECT password FROM `user` WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($dbpass);
        $stmt->fetch();
        if ($pass === $dbpass) {
            header('Location: /dashboard/user/user-bulletin.html', true, 303);
            exit;
        }
    }
    header('Location: /login.php?err=invalid', true, 303);
    exit;
