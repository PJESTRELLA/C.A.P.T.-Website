<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $servername = "localhost";
        $username = "u362083597_captofficial";
        $password = "BarangaySystem2025";
        $dbname = "u362083597_test_userAuth";

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset("utf8mb4");

        if ($mysqli->connect_error) {
            die("⚠️ ERROR: Connection failed - " . $mysqli->connect_error);
        }

        try {
            $sql = "SELECT image FROM announcements";
            $result = $mysqli->query($sql);
            while ($row = $result->fetch_assoc()) {
                $fullPath = $_SERVER['DOCUMENT_ROOT'] . $row['image'];
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }

            $mysqli->query("DELETE FROM announcements");

            header("Location: /dashboard/admin/admin-bulletin.html");
            exit();
        } catch (mysqli_sql_exception $e) {
            echo "[ERROR]: " . $e->getMessage();
        }

        $mysqli->close();
    } else {
        echo "<h1>Invalid request method.</h1>";
    }
?>