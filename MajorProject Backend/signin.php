<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

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
            // Set $_SESSION['loggedin'] to true
            $_SESSION['loggedin'] = true;
            // Optionally, you can also store other user information in session
            $_SESSION['user_mobile'] = $row['mobile'];
            // Redirect the user to the dashboard or another authorized page
            header("Location: dashb.php");
            exit();
        } else {
            // Invalid credentials
           echo "<script>alert('Invalid credentials');</script>";
        }
    } else {
        // Invalid credentials
       echo "<script>alert('Invalid credentials');</script>";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>LearNexus | Login</title>
  <link rel="stylesheet" href="login.css">
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <style>
    .error {
      color: red;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <h1>Hello!</h1>
    <p>Welcome to LearNexus</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
      <input type="tel" placeholder="Enter your Mobile (10 digits)" name="uname" id="uname" >
      <span class="error" id="unameError"></span>
      <input type="password" placeholder="Password" name="pass" id="pass">
      <span class="error" id="passError"></span>
      <p class="recover">
        <a href="forgot.html">Forgot Password?</a>
      </p>
      <!-- Move the button inside the form -->
      <button type="submit">Sign in</button>
    </form>
    <p class="or">
      ----- or continue with -----
    </p>
    <div class="icons">
      <i class="fab fa-google"></i>
      <i class="fab fa-github"></i>
      <i class="fab fa-facebook"></i>
    </div>
    <div class="not-member">
      Not a member? <a href="signup.html"><b>Register Now</b></a>
    </div>
  </div>

  <script>
    function validateForm() {
      // Get form input values
      var uname = document.getElementById('uname').value.trim();
      var pass = document.getElementById('pass').value.trim();

      // Reset error messages
      document.getElementById('unameError').innerHTML = "";
      document.getElementById('passError').innerHTML = "";

      var isValid = true;

      // Validate username
      if (uname === "") {
        document.getElementById('unameError').innerHTML = "Phone number is required";
        isValid = false;
      } else if (!(/^\d{10}$/.test(uname))) {
        document.getElementById('unameError').innerHTML = "Phone number should be of 10 digits";
        isValid = false;
      }

      // Validate password
      if (pass === "") {
        document.getElementById('passError').innerHTML = "Password is required";
        isValid = false;
      }

      return isValid;
    }

   if (window.performance) {
            if (performance.navigation.type === 1) {
                // Redirect to logoutphp.php to clear the session
                window.location.href = 'signin.php';
            }
        }

  </script>
</body>
</html>
