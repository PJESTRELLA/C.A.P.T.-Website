<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $servername = "localhost"; 
    $username = "u362083597_captofficial"; 
    $password = "BarangaySystem2025"; 
    $dbname = "u362083597_test_userAuth"; 
    
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    $mysqli->set_charset("utf8mb4");

    $raiseError = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name      = $_POST['name']      ?? '';
        $birthDate = $_POST['birthDate'] ?? '';
        $uname     = $_POST['username']  ?? '';
        $email     = $_POST['email']     ?? '';
        $pwd       = $_POST['password']  ?? '';
        $consent   = isset($_POST['consent']) ? 1 : 0; // checkbox → int

        if (!preg_match("/^[a-zA-Z ]+$/", $name)){ 
            $raiseError[] = "[ERROR]: Name must only contain letters and spaces."; 
        }

        if (!preg_match("/^[a-zA-Z0-9_]+$/", $uname)){ 
            $raiseError[] = "[ERROR]: Username must only contain letters, numbers, and underscores (_)."; 
        }

        if (strlen($pwd) < 8)
            { $raiseError[] = "[ERROR]: Password must contain at least eight characters."; 
        }

        if (!preg_match("/[a-z]/", $pwd)){ 
            $raiseError[] = "[ERROR]: Password must contain at least one lowercase letter."; 
        }

        if (!preg_match("/[A-Z]/", $pwd)){ 
            $raiseError[] = "[ERROR]: Password must contain at least one uppercase letter."; 
        }
        if (!preg_match("/[0-9]/", $pwd)){ 
            $raiseError[] = "[ERROR]: Password must contain at least one numerical character."; 
        }
        if (!preg_match("/[\W_]/", $pwd)){ 
            $raiseError[] = "[ERROR]: Password must contain at least one special symbol."; 
        }

        if (empty($raiseError)) {
            $hash = password_hash($pwd, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `user` (`name`, `birthDate`, `username`, `email`, `password`, `consent`)
                    VALUES (?, ?, ?, ?, ?, ?)";

            try {
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ssssis", $name, $birthDate, $uname, $email, $hash, $consent);
                $stmt->execute();

                if ($stmt->affected_rows === 1) {
                    header("Location: /login/login.html");
                    exit();
                } else {
                    echo "[WARNING]: Insert ran but no row added.";
                }
                $stmt->close();
            } catch (mysqli_sql_exception $e) {
                echo "[ERROR]: " . $e->getMessage();
            }
        } else {
            foreach ($raiseError as $e) { echo "❎ " . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . "<br>"; }
        }
    }
    $mysqli->close();
?>