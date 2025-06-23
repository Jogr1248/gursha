<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // Database configuration
    $server = "localhost";
    $dbUsername = "root";
    $dbName = "project";
    $dbPassword = "";

    // Create a connection
    $conn = new mysqli($server, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the password for the given username
    $sql = "SELECT password, email FROM loginusers WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $row['password'];
        $email = $row['email'];

        // Send an email with the password
        $to = $email;
        $subject = "Password Recovery";
        $message = "Your password is: $password";
        $headers = "From: your-email@example.com";

        // Send email
        mail($to, $subject, $message, $headers);

        echo "Password recovery email sent successfully";
    } else {
        echo "Invalid username";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Forgot Password</h1>
  <form action="#" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <button type="submit">Reset Password</button>
  </form>
</body>
</html>