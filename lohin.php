<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
  </style>
   <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Database configuration
        $server = "localhost";
        $dbUsername = "root";
        $dbName = "project";
        $dbPassword = "";

        // Create a connection
        $conn = new mysqli($server, $dbUsername, $dbPassword);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Create the database if it doesn't exist
        $createDbSql = "CREATE DATABASE IF NOT EXISTS $dbName";
        if ($conn->query($createDbSql) === TRUE) {
            // Select the database
            $conn->select_db($dbName);

            // Create the users table if it doesn't exist
            $createTableSql = "CREATE TABLE IF NOT EXISTS loginusers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                password VARCHAR(255) NOT NULL
            )";
            if ($conn->query($createTableSql) === FALSE) {
                die("Error creating table: " . $conn->error);
            }

            // Perform the login authentication
            // Replace this with your own secure authentication logic
            $sql = "SELECT * FROM loginusers WHERE username = ? AND password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Authentication successful
                // Redirect the user to the home page or any other page
                header('Location: gursha.html');
                exit();
            } else {
                // Authentication failed
                $error = 'Invalid username or password';
            }
        } else {
            die("Error creating database: " . $conn->error);
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    }
    ?>
    <form action="#" method="post">
      <?php if (isset($error)) { ?>
        <div class="error-message"><?php echo $error; ?></div>
      <?php } ?>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Login</button>
      <div class="terms-and-conditions">
        <label>
          <input type="checkbox" required>
          I agree to the <a href="terms.html" target="_blank">Terms and Conditions</a>
        </label>
      </div>
      <div class="additional-options">
        <a href="forget.php">Forget Password</a>
        <a href="create_acount.php">Create Account</a>
      </div>
    </form>
  </div>
</body>
</html>