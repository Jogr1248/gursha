<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

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

    $createTableSql = "CREATE TABLE IF NOT EXISTS loginusers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";

    // Create the users table if it doesn't exist
    if ($conn->query($createTableSql) === FALSE) {
        die("Error creating table: " . $conn->error);
    }

    // Insert values into the users table
    $sql = "INSERT INTO loginusers (username, email, phone, password) VALUES ('$username', '$email', '$phone', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Account created successfully, redirect to gursha.html
        header('Location: gursha.html');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Create Account</h1>
  <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($error)) { ?>
    <div class="error-message"><?php echo $error; ?></div>
  <?php } ?>
  <form action="#" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="phone">Phone:</label>
    <input type="tel" id="phone" name="phone" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Create Account</button>
  </form>
</body>
</html>