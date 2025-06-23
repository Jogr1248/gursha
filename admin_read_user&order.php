<?php
// Check if the user is logged in as admin
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirect to the login page if not logged in as admin
    header("Location: login.php");
    exit;
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from users and orders tables based on referenced_id
$sql = "SELECT u.id, u.password, u.email, o.name, o.phoneNumber, o.address, o.foodItems, o.totalPrice, o.hotel, o.photo 
        FROM users u
        INNER JOIN orders o ON u.id = o.referenced_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
        }

        .row {
            flex-basis: 50%;
            padding: 10px;
        }

        .row h4 {
            margin-bottom: 5px;
        }

        .row p {
            margin: 0;
        }
    </style>
</head>
<body>
    <h2>Welcome, Admin!</h2>
    <h3>User and Orders Data:</h3>
    <?php if ($result->num_rows > 0) { ?>
        <div class="container">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="row">
                    <h4>User ID: <?php echo $row['id']; ?></h4>
                    <p>Password: <?php echo $row['password']; ?></p>
                    <p>Email: <?php echo $row['email']; ?></p>
                    <p>Name: <?php echo $row['name']; ?></p>
                    <p>Phone Number: <?php echo $row['phoneNumber']; ?></p>
                    <p>Address: <?php echo $row['address']; ?></p>
                    <p>Food Items: <?php echo $row['foodItems']; ?></p>
                    <p>Total Price: <?php echo $row['totalPrice']; ?></p>
                    <p>Hotel: <?php echo $row['hotel']; ?></p>
                    <p>Photo: <?php echo $row['photo']; ?></p>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>No data found.</p>
    <?php } ?>
</body>
</html>