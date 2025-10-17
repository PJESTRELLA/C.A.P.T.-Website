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

        $eventId = $_POST['event-id'] ?? '';

        if ($eventId === '') {
            echo "⚠️ ERROR: Missing event ID.";
            exit;
        }

        try {
            $stmt = $mysqli->prepare("SELECT image FROM events WHERE id = ?");
            $stmt->bind_param("i", $eventId);
            $stmt->execute();
            $stmt->bind_result($imagePath);
            $stmt->fetch();
            $stmt->close();

            if (!$imagePath) {
                echo "⚠️ ERROR: Event not found.";
                exit;
            }

            $stmt = $mysqli->prepare("DELETE FROM events WHERE id = ?");
            $stmt->bind_param("i", $eventId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $fullPath = $_SERVER["DOCUMENT_ROOT"] . $imagePath;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }

                header("Location: /dashboard/admin/admin-bulletin.html");
                exit();
            } else {
                echo "⚠️ ERROR: No rows deleted.";
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            echo "[ERROR]: " . $e->getMessage();
        }

        $mysqli->close();
    } else {
        echo "<h1>Invalid request method.</h1>";
    }
?>