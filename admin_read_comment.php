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

// Construct the SQL query to retrieve the comments from the table
$query = "SELECT * FROM comments,hotel_comments";

// Execute the query
$result = $conn->query($query);

// Check if any results were found
if ($result && $result->num_rows > 0) {
    // Display the comments
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>User Name:</strong> " . $row["user_name"] . "</p>";
        echo "<p><strong>Hotel Name:</strong> " . $row["hotel_name"] . "</p>";
        echo "<p><strong>Comment:</strong> " . $row["comment"] . "</p>";
        echo "<hr>";
    }
} else {
    echo "<p>No comments found.</p>";
}

// Close the database connection
$conn->close();
?>