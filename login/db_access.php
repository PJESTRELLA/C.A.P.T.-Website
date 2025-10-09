<?php
    header("Location: dashboard/user/user-bulletin.html");

    $servername = "localhost";
    $username = "u362083597_captofficial";
    $password = "BarangaySystem2025";
    $dbname = "u362083597_test_userAuth";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error){
        die("Failed connection :(.");
    }

    $raiseError = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $statement = $conn->prepare("SELECT * FROM user where email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();

        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();

            if(password_verify($password, $row['password'])){
                header("Location: user/user-bulletin.html");
                exit();
            }
            else{
                $raiseError = "❎ Password does not match with the registered email.";
            }
        } else{
            $raiseError = "❎ The login credentials you provided are not officially registered.";
        }

        $statement->close();
    }

    $conn->close();
?>