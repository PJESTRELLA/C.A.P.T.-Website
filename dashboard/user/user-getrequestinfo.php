<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

        // Part X: Request Option
        $requestoption = $_POST["request_option"] ?? '';
        
        // Part 1: Personal Information
        $lastname = $_POST["lastname"] ?? '';
        $firstname = $_POST["firstname"] ?? '';
        $middlename = $_POST["middlename"] ?? '';
        $suffix = $_POST["suffix"] ?? '';
        $birthday = $_POST["birthday"] ?? '';
        $age = $_POST["age"] ?? '';
        $gender = $_POST["gender"] ?? '';

        // Part 2: Contact Information
        $house = $_POST["house"] ?? '';
        $street = $_POST["street"] ?? '';
        $barangay = $_POST["barangay"] ?? '';
        $city = $_POST["city"] ?? '';
        $zip = $_POST["zip"] ?? '';
        $phone = $_POST["phone"] ?? '';
        $telephone = $_POST["telephone"] ?? '';
        $email = $_POST["email"] ?? '';

        if (!preg_match("/^[a-zA-Z ]+$/", $lastname) || !preg_match("/^[a-zA-Z ]+$/", $firstname) || (!empty($middlename) && !preg_match("/^[a-zA-Z ]+$/", $middlename))) {
            $raiseError[] = "⚠️ ERROR: Names can only contain letters and spaces.";
        } 

        if (!preg_match("/^[0-9A-Za-z ]+$/", $house)) {
            $raiseError[] = "⚠️ ERROR: House number can only contain letters, numbers, and spaces.";
        }


        if (!preg_match("/^[a-zA-Z0-9. ]+$/", $street)){  // lower, upper, space, numbers, period
            $raiseError[] = "⚠️ ERROR: Street name can only contain letters, numbers, and periods"; 
        }

        if (!preg_match("/^[a-zA-Z ]+$/", $city)){  // lower, upper, space
            $raiseError[] = "⚠️ ERROR: City names can only contain letters and spaces."; 
        }

        if (!preg_match("/^[0-9]{4}$/", $zip)) {
            $raiseError[] = "⚠️ ERROR: ZIP Code must contain exactly 4 digits.";
        }

        if (!preg_match("/^09[0-9]{9}$/", $phone)) {
            $raiseError[] = '⚠️ ERROR: Phone number must start with "09" and contain exactly 11 digits.';
        }

        if (!empty($telephone) && !preg_match("/^8[0-9]{7}$/", $telephone)) {
            $raiseError[] = '⚠️ ERROR: Telephone number must start with "8" and contain exactly 8 digits.';
        }

        if (empty($raiseError)){
            $sql = null;
            $id = null;
            
            if (isset($_SESSION['id'])){
                $id = $_SESSION['id'];
            }

            switch($requestoption){
                case 'clearance':
                    $sql = "INSERT INTO `requestedDocument_BarangayClearance` (`userId`, `lastName`, `givenName`, `middleName`, `suffix`, `birthday`, `age`, `gender`, `houseNumber`, `street`, `barangay`, `city`, `zip`, `phoneNumber`, `telephoneNumber`, `emailAddress`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    break;
                case 'residency':
                    $sql = "INSERT INTO `requestedDocument_BarangayCertificateResidency` (`userId`, `lastName`, `givenName`, `middleName`, `suffix`, `birthday`, `age`, `gender`, `houseNumber`, `street`, `barangay`, `city`, `zip`, `phoneNumber`, `telephoneNumber`, `emailAddress`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    break;
                case 'indigency':
                    $sql = "INSERT INTO `requestedDocument_BarangayCertificateIndigency` (`userId`, `lastName`, `givenName`, `middleName`, `suffix`, `birthday`, `age`, `gender`, `houseNumber`, `street`, `barangay`, `city`, `zip`, `phoneNumber`, `telephoneNumber`, `emailAddress`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    break;
                case 'business':
                    $sql = "INSERT INTO `requestedDocument_BarangayCertificateBusiness` (`userId`, `lastName`, `givenName`, `middleName`, `suffix`, `birthday`, `age`, `gender`, `houseNumber`, `street`, `barangay`, `city`, `zip`, `phoneNumber`, `telephoneNumber`, `emailAddress`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    break;
                default:
                    die("[ERROR]: Unknown request option.");
            }

            try {
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("isssssisssssssss", $id, $lastname, $firstname, $middlename, $suffix, $birthday, $age, $gender, $house, $street, $barangay, $city, $zip, $phone, $telephone, $email);
                $stmt->execute(); // insert actual values into the table 

                if ($stmt->affected_rows === 1) { // checks if one row has been added to the table
                    header("Location: /dashboard/user/user-request.html"); // redirect to request page
                    exit(); // stops code execution
                } else {
                    echo "[WARNING]: Insert ran but no row added.";
                }
                    $stmt->close(); // releases stmt (since dynamically allocated)
            } catch (mysqli_sql_exception $e) {
                echo "[ERROR]: " . $e->getMessage();
            }
        } else{
            foreach ($raiseError as $error) {
                echo htmlspecialchars($error) . "<br>";
            }
        }
        
    } else {
        echo "<h1>No data submitted!</h1>";
    }
?>