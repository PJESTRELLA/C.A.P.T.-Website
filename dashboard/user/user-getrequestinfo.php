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

        /*echo "<h1>Form Data Received</h1>";

        echo "<h2>Document Request</h2>";
        echo "<strong>Request Option</strong>: {$requestoption}<br><br>";

        echo "<h2>Part 1: Personal Information</h2>";
        
        echo "<strong>Last Name</strong>: {$lastname}<br>";
        echo "<strong>First Name</strong>: {$firstname}<br>";
        echo "<strong>Middle Name</strong>: {$middlename}<br>";
        echo "<strong>Suffix</strong>: {$suffix}<br>";
        echo "<strong>Birthday</strong>: {$birthday}<br>";
        echo "<strong>Age</strong>: {$age}<br>";
        echo "<strong>Gender</strong>: {$gender}<br><br>";

        echo "<h2>Part 2: Contact Information</h2>";
        echo "<strong>House</strong>: {$house}<br>";
        echo "<strong>Street</strong>: {$street}<br>";
        echo "<strong>Barangay</strong>: {$barangay}<br>";
        echo "<strong>City</strong>: {$city}<br>";
        echo "<strong>ZIP Code</strong>: {$zip}<br>";
        echo "<strong>Phone No.</strong>: {$phone}<br>";
        echo "<strong>Telephone No.</strong>: {$telephone}<br>";
        echo "<strong>Email</strong>: {$email}<br>";*/

    } else {
        echo "<h1>No data submitted!</h1>";
    }
?>