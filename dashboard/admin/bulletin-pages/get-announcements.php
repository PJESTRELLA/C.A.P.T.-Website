<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
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
            $sql = "SELECT * FROM announcements ORDER BY timeCreated DESC";
            $return = $mysqli->query($sql);

            $announcements = [];
            while ($row = $return->fetch_assoc()) {
                $announcements[] = [
                    'id' => $row['id'],
                    'title' => htmlspecialchars($row['title']),
                    'caption' => htmlspecialchars($row['caption']),
                    'image' => htmlspecialchars($row['image']),
                    'timeCreated' => htmlspecialchars($row['timeCreated'])
                ];
            }

            header("Content-Type: application/json");
            echo json_encode($announcements);
        } catch (mysqli_sql_exception $e) {
            echo "[ERROR]: " . $e->getMessage();
        }

        $mysqli->close();
    } else {
        echo "<h1>Invalid request method.</h1>";
    }
?>