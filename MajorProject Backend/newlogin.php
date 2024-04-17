<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "learnexus";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['uname'];
    $pass = $_POST['pass'];

    // Query the database
    $query = "SELECT * FROM registration WHERE mobile='$user'";
    $result = $conn->query($query);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the hashed password
        if (password_verify($pass, $row['pass'])) {
            echo "LOGIN SUCCESSFUL";
        } else {
            echo "OOPS....LOGIN FAILED - Incorrect Password";
        }
    } else {
        echo "OOPS....LOGIN FAILED - User not found";
    }
}

// Close the database connection
$conn->close();
?>

