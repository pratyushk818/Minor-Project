<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['fname']) && isset($_POST['password'])) {
        $conn = new mysqli('your_hostname', 'your_username', 'your_password', 'your_database');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $username = $_POST['fname'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo "Signup successful!";
    } else {
        echo "All fields are required!";
    }
}
?>
