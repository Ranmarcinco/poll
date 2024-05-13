<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-size: 20px;
            background-image: url('BACKGROUND.jpeg');
            background-size: cover; 
            background-repeat: no-repeat;
            background-attachment: fixed; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-size: 25px;
            color: rgb(16, 161, 72);
        }
        form {
            color: rgb(16, 161, 72);
        }
        button {
            font-size: 18px;
            color: rgb(16, 161, 72);
            background-color: rgb(232, 240, 241);
        }
        h1 {
            color: rgb(16, 161, 72);
            align-self: center;
        }
        p {
            color: rgb(16, 161, 72);
        }
        a {
            color: rgb(16, 161, 72);
        }
        input {
            background-color: rgb(242, 244, 248);
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Registration Form</h1>
    <form id="registrationForm" action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">Register</button>
    </form>
    <p>Already registered? <a href="login.php">Back to login</a></p>
</div>
</body>
</html>



<?php
$servername = "localhost"; // Change this if your MySQL server is on a different host
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "poll"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form is submitted, handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Insert data into the database
    $sql = "INSERT INTO users (username, password)
    VALUES ('$username', '$password')";

if ($conn->query($sql) === TRUE) {
echo "Sign up successful!";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}
}


$conn->close();