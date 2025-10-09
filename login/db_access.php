<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $servername = "localhost"; 
    $username = "u362083597_captofficial"; 
    $password = "BarangaySystem2025"; 
    $dbname = "u362083597_test_userAuth"; 
    
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    $mysqli->set_charset("utf8mb4");

    $email = isset($_POST['email']) ? strtolower(trim($_POST['email'])) : '';
    $pwd   = $_POST['password'] ?? '';

    $stmt = $mysqli->prepare("SELECT id, `password` FROM `user` WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($uid, $hash);
        $stmt->fetch();
        $ok = password_verify($pwd, $hash);

        if ($ok) {
            if (ob_get_level()){ 
                ob_end_clean(); 
            }

            $url = 'https://' . $_SERVER['HTTP_HOST'] . '/dashboard/user/user-bulletin.html';
            header("Location: $url", true, 303); // POST → GET
            exit;
        }
    } else {
        error_log("No user for $email");
    }

    $stmt->close();
    $mysqli->close();
?>