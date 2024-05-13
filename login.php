<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
       body{
            font-size: 20px;
            background-image: url('BACKGROUND.jpeg');
            background-size: cover; /* Cover the entire background */
            background-repeat: no-repeat; /* Do not repeat the background image */
            background-attachment: fixed; /* Fix the background image so it doesn't scroll with the page */
            display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         font-size: 25px;
        }
        form{
            color:rgb(16, 161, 72);
        }
        button{
            font-size: 25px;
            color: rgb(16, 161, 72);
            background-color: rgb(232, 240, 241);
        }
        h1{
            color: rgb(16, 161, 72);
        }
        p{
            color: rgb(16, 161, 72);
        }
        a{
            color: rgb(16, 161, 72);
        }
        input{
            background-color: rgb(242, 244, 248);
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Login Page</h1>
    <form id="loginForm" action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">Login</button>
    </form>
    <p>Not registered yet? <a href="register.php">Register here</a></p>
</div>
</body>
</html>

<?php
// Start session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are set and not empty
    if (isset($_POST["username"]) && !empty($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["password"])) {
        // Retrieve username and password from the form
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Database configuration
        $servername = "localhost"; // Replace with your server name
        $db_username = "root"; // Replace with your database username
        $db_password = ""; // Replace with your database password
        $database = "poll"; // Replace with your database name

        // Create connection
        $conn = new mysqli($servername, $db_username, $db_password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to check if username and password match
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Username and password match
            // Redirect user to main page
            $_SESSION["username"] = $username;
            header("Location: index.html");
            exit;
        } else {
            // Username and password do not match
            echo "Invalid username or password";
        }

        // Close connection
        $conn->close();
    } else {
        // Username or password not provided
        echo "Please provide username and password";
    }
} else {
    // Form not submitted
    echo "Form not submitted";
}
?>
