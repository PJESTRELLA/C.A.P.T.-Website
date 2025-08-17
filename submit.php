<?php
// Check if form data was sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // For testing, just display them back
    echo "<h1>Form Data Received</h1>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    echo "<p><strong>Password:</strong> " . htmlspecialchars($password) . "</p>";
} else {
    // If someone opens submit.php directly
    echo "<h1>No data submitted!</h1>";
}
?>
