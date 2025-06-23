<?php
// Modify the database connection parameters accordingly
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Construct the SQL query to retrieve the data
$query = "SELECT o.*, GROUP_CONCAT(oi.product) AS products
          FROM orders o
          LEFT JOIN order_items oi ON o.order_id = oi.order_id
          GROUP BY o.order_id
          ORDER BY o.order_id";

// Execute the query
$result = $conn->query($query);

// Check if any results were found
if ($result && $result->num_rows > 0) {
    // Output the data in a table with borders
    echo "<style>";
    echo "table {";
    echo "    border-collapse: collapse;";
    echo "    width: 100%;";
    echo "}";
    echo "th, td {";
    echo "    border: 1px solid black;";
    echo "    padding: 8px;";
    echo "    text-align: left;";
    echo "}";
    echo "th {";
    echo "    background-color: #f2f2f2;";
    echo "}";
    echo "</style>";

    echo "<table>";
    echo "<tr>";
    echo "<th>Order ID</th>";
    echo "<th>Name</th>";
    echo "<th>Phone Number</th>";
    echo "<th>Address</th>";
    echo "<th>Hotel Name</th>";
    echo "<th>Products</th>";
    echo "<th>Total Price</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        $orderID = $row["order_id"];
        $name = $row["name"];
        $phoneNumber = $row["phoneNumber"];
        $address = $row["address"];
        $hotelName = $row["hotelName"];
        $products = $row["products"];
        $totalPrice = $row["totalPrice"];

        echo "<tr>";
        echo "<td>" . $orderID . "</td>";
        echo "<td>" . $name . "</td>";
        echo "<td>" . $phoneNumber . "</td>";
        echo "<td>" . $address . "</td>";
        echo "<td>" . $hotelName . "</td>";
        echo "<td>" . $products . "</td>";
        echo "<td>" . $totalPrice . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No orders found.";
}

// Close the database connection
$conn->close();
?>