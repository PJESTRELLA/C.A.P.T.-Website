<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    $servername = "localhost"; 
    $username = "u362083597_captofficial"; 
    $password = "BarangaySystem2025"; 
    $dbname = "u362083597_test_userAuth"; 
    
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    $mysqli->set_charset("utf8mb4");

    if (headers_sent($f,$l)) { error_log("HEADERS SENT at $f:$l"); }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST['email'] ?? '';
        $pwd   = $_POST['password'] ?? '';

        $stmt = $mysqli->prepare("SELECT id, `password` FROM `user` WHERE email=? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($uid, $hash);
            $stmt->fetch();

            if (password_verify($pwd, $hash)) {
                if (ob_get_level()) { ob_end_clean(); }
                header("Location: /dashboard/user/user-bulletin.html");
                exit;
            }
        }
    }
?>