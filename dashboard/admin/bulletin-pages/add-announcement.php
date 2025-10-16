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
            die("Connection failed: " . $mysqli->connect_error);
        }

        $raiseError = [];


        $title = ($_POST['title'] ?? '');
        $caption = ($_POST['caption'] ?? '');
        $image = $_FILES['image'] ?? null;

        // INPUT VALIDATION AND SANITATION

        // Trims and sanitize HTML
        $title = trim($title);
        $caption = trim($caption);
        $title = htmlspecialchars($title, ENT_QUOTES, "UTF-8");
        $caption = htmlspecialchars($caption, ENT_QUOTES, "UTF-8");

        // Required Fields: ALL
        if ($title === '') {
            $raiseError[] = "⚠️ ERROR: Title is required.";
        }
        if ($caption === '') {
            $raiseError[] = "⚠️ ERROR: Caption is required.";
        }
        if (!$image || $image['error'] === UPLOAD_ERR_NO_FILE) {
            $raiseError[] = "⚠️ ERROR: Image is required.";
        }

        // Length validation: based on data type
        if (strlen($title) > 200) {
            $raiseError[] = "⚠️ ERROR: Title exceeds max size allowed. Title must not exceed 200 characters.";
        }
        if (strlen($caption) > 65535) {
            $raiseError[] = "⚠️ ERROR: Caption exceeds max size limit.";
        }

        // Character validation
        if (!preg_match("/^[a-zA-Z0-9\s\p{P}]+$/u", $title)) {
            $raiseError[] = "⚠️ ERROR: Title contains invalid characters.";
        }
        if (!preg_match("/^[a-zA-Z0-9\s\p{P}]+$/u", $caption)) {
            $raiseError[] = "⚠️ ERROR: Caption contains invalid characters.";
        }

        // Image Validation: File size and extension
        if ($image['size'] > 2 * 1024 * 1024) { // 2MB max
            $raiseError[] = "⚠️ ERROR: Image file size exceeds 2MB.";
        }
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($image['type'], $allowedTypes)) {
                $raiseError[] = "⚠️ ERROR: Only JPEG, PNG, and JPG file types are allowed.";
            }
        }

        if (!empty($raiseError)) {
            foreach ($raiseError as $error) {
                echo htmlspecialchars($error) . "<br>";
            }
            exit;
        }


        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $newFileName = time() . '_' . uniqid() . "." . $extension;
        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . "/Resources/announcements/";
        $uploadPath = $uploadDirectory . $newFileName;


        if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
            echo "⚠️ ERROR: Failed to move uploaded image.";
            exit;
        }


        $photoPathDB = "/Resources/announcements/" . $newFileName;

        
        try {
            $stmt = $mysqli->prepare("INSERT INTO announcements (title, caption, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $caption, $photoPathDB);
            $stmt->execute();

            if ($stmt->affected_rows === 1) {
                header("Location: /dashboard/admin/admin-bulletin.html");
                exit();
            } else {
                echo "[WARNING]: Insert ran but no row added.";
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            echo "[ERROR]: " . $e->getMessage();
        }
    } else {
        echo "<h1>No data submitted!</h1>";
    }

    $mysqli->close();
?>