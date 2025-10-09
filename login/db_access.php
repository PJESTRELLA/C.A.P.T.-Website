<?php
    declare(strict_types=1);

    session_start();

    ini_set('display_errors','1');
    error_reporting(E_ALL);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { // ensures only POST requests are catered.
        http_response_code(405);
        exit('Method Not Allowed'); // exits the code early
    }

    $mysqli = new mysqli('localhost','u362083597_captofficial','BarangaySystem2025','u362083597_test_userAuth'); // creates mysql connection

    if ($mysqli->connect_errno) { // checks if connection failed.
        http_response_code(500);
        exit('DB connection failed'); // exits the code early.
    }

    $email = $_POST['email'] ?? ''; // empty string if email is empty
    $pass  = $_POST['password'] ?? ''; // empty string if password is empty

    $stmt = $mysqli->prepare('SELECT name, password FROM `user` WHERE email = ? LIMIT 1'); // finds email, limited to one record only
    $stmt->bind_param('s', $email); // declares email to find
    $stmt->execute(); // searches the table
    $stmt->store_result(); // generates result (password column)

    if ($stmt->num_rows === 1) { // checks if a match has been found
        $stmt->bind_result($dbname, $dbpass); // dbpass holds password column
        $stmt->fetch(); // returns actual password value
        
        if ($pass === $dbpass) { // checks if registered password and input password are the same. NOTE: SWAP TO password_verify IF MAGH-HASH
            $_SESSION['name'] = $dbname;
            header('Location: /dashboard/user/user-bulletin.html', true, 303); // true -> replace current header, idk what 303 is T_T
            exit;
        }
    }
    $stmt->close();
    $mysqli->close();
    header('Location: /login.php?err=invalid', true, 303);
    exit;
