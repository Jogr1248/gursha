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

// Construct the SQL query to retrieve comments where hotel_name is 'vectory'
$query = "SELECT hotel_name,comment,created_at FROM hotel_comments WHERE hotel_name = 'vectory'";

// Execute the query
$result = $conn->query($query);

// Check if any results were found
if ($result && $result->num_rows > 0) {
    // Display the comments
    while ($row = $result->fetch_assoc()) {
       
        echo "<p><strong>Hotel Name:</strong> " . $row["hotel_name"] . "</p>";
        echo "<p><strong>Comment:</strong> " . $row["comment"] . "</p>";
         echo "<p><strong>commented at:</strong> " . $row["created_at"] . "</p>";
		echo "<hr>";
    }
} else {
    echo "<p>No comments found for 'vectory' hotel.</p>";
}

// Close the database connection
$conn->close();
?>