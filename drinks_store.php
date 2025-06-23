<?php

// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data from orders and order_items tables
$sql = "SELECT o.name, o.phoneNumber, o.totalPrice, o.order_id, oi.product
        FROM orders o
        JOIN order_items oi ON o.order_id = oi.order_id";

// Execute the query
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data for each row
    echo "<div class='order-list'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='order'>";
        echo "<p><strong>Name:</strong> " . $row["name"] . "</p>";
        echo "<p><strong>Phone Number:</strong> " . $row["phoneNumber"] . "</p>";
        echo "<p><strong>Total Price:</strong> " . $row["totalPrice"] . "</p>";
        echo "<p><strong>Order ID:</strong> " . $row["order_id"] . "</p>";
        echo "<p><strong>Product:</strong> " . $row["product"] . "</p>";
        echo "</div>";
        echo "<hr>";
    }
    echo "</div>";
} else {
    echo "No results found.";
}

// Close the connection
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Order List</title>
    <style>
        .order-list {
            padding: 20px;
        }
        .order {
            background-color: #f7f7f7;
            padding: 10px;
            margin-bottom: 10px;
        }
        .order p {
            margin: 0;
        }
    </style>
</head>
<body>

<h2>Order List</h2>

<!-- Output from PHP code will be displayed here -->

</body>
</html>