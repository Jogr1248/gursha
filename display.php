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

// Specify the hotel name for filtering
$hotelName = "vectory"; // Replace with the desired hotel name

// Construct the SQL query to retrieve the data
$query = "SELECT o.order_id, o.name, o.phoneNumber, o.address, o.hotelName, o.foodName, o.totalPrice
          FROM orders o
          WHERE o.hotelName = '$hotelName'";

// Execute the query
$result = $conn->query($query);

// Check if any results were found
if ($result && $result->num_rows > 0) {
    // Output the data for each row
    echo "<table>";
    echo "<tr>";
    echo "<th>Order ID</th>";
    echo "<th>Name</th>";
    echo "<th>Phone Number</th>";
    echo "<th>Address</th>";
    echo "<th>Hotel Name</th>";
    echo "<th>Food Name</th>";
    echo "<th>Total Price</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["order_id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["phoneNumber"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td>" . $row["hotelName"] . "</td>";
        echo "<td>" . $row["foodName"] . "</td>";
        echo "<td>" . $row["totalPrice"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No orders found for the specified hotel.";
}

// Close the database connection
$conn->close();
?>