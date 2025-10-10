<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

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


        echo "<h1>Form Data Received</h1>";

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
        echo "<strong>Email</strong>: {$email}<br>";

    } else {
        echo "<h1>No data submitted!</h1>";
    }
?>