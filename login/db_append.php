<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // reports sql errors

    session_start();

    $servername = "localhost"; 
    $username = "u362083597_captofficial"; 
    $password = "BarangaySystem2025"; 
    $dbname = "u362083597_test_userAuth"; 
    
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    $mysqli->set_charset("utf8mb4");

    $raiseError = []; // an array of error messages to be raised later on

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = ucwords($_POST['name'] ?? ''); // Returns empty string if input is empty.
        $birthDate = $_POST['birthDate'] ?? '';
        $uname = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $pwd = $_POST['password'] ?? '';
        $consent = isset($_POST['consent']) ? 1 : 0;

        if (!preg_match("/^[a-zA-Z ]+$/", $name)){  // lower, upper, space
            $raiseError[] = "[ERROR]: Name must only contain letters and spaces."; 
        }

        if (!preg_match("/^[a-zA-Z0-9]+$/", $uname)){ // lower, upper, numbers
            $raiseError[] = "[ERROR]: Username must only contain letters and numbers."; 
        }

        if (strlen($pwd) < 8){ // more than 8 chars 
            $raiseError[] = "[ERROR]: Password must contain at least eight characters."; 
        }

        if (!preg_match("/[a-z]/", $pwd)){ // at least one lowercase
            $raiseError[] = "[ERROR]: Password must contain at least one lowercase letter."; 
        }

        if (!preg_match("/[A-Z]/", $pwd)){ // at least one uppercase
            $raiseError[] = "[ERROR]: Password must contain at least one uppercase letter."; 
        }
        if (!preg_match("/[0-9]/", $pwd)){ // at least one number
            $raiseError[] = "[ERROR]: Password must contain at least one numerical character."; 
        }
        if (!preg_match("/[\W_]/", $pwd)){ // at least one special symbol
            $raiseError[] = "[ERROR]: Password must contain at least one special symbol."; 
        }

        if (empty($raiseError)){ // checks if no errors
            $sql = "INSERT INTO `user` (`name`, `birthDate`, `username`, `email`, `password`, `consent`)
                    VALUES (?, ?, ?, ?, ?, ?)"; // placeholders, will be supplied with bind_param

            try {
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ssssss", $name, $birthDate, $uname, $email, $pwd, $consent); // 6 strings
                $stmt->execute(); // insert actual values into the table 

                if ($stmt->affected_rows === 1) { // checks if one row has been added to the table
                    header("Location: /login/login.html"); // redirect to log in page
                    exit(); // stops code execution
                } else {
                    echo "[WARNING]: Insert ran but no row added.";
                }
                $stmt->close(); // releases stmt (since dynamically allocated)
            } catch (mysqli_sql_exception $e) {
                echo "[ERROR]: " . $e->getMessage();
            }
        } else {
            $_SESSION['raiseerror'] = $raiseError;
            exit;
            foreach ($raiseError as $e) { echo "❎ " . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . "<br>"; }
        }
    }
    $mysqli->close(); // closes db connection
?>