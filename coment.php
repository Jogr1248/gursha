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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $userName = $_POST["userName"];
    $hotelName = $_POST["hotelName"];
    $comment = $_POST["comment"];

    // Prepare and execute the SQL statement to insert the comment into the table
    $stmt = $conn->prepare("INSERT INTO comments (user_name, hotel_name, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $userName, $hotelName, $comment);
    $stmt->execute();
    $stmt->close();
}

// Construct the SQL query to retrieve the comments from the table
$query = "SELECT * FROM comments";

// Execute the query
$result = $conn->query($query);

// Check if any results were found


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comment Page</title>
</head>
<body>
    <h2>Leave a Comment</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="userName">User Name:</label>
        <input type="text" id="userName" name="userName" required><br><br>

        <label for="hotelName">Hotel Name:</label>
        <input type="text" id="hotelName" name="hotelName" required><br><br>

        <label for="comment">Comment:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>