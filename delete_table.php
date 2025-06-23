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

// Delete table function
function delete_table($table_name, $conn) {
    $sql = "DROP TABLE IF EXISTS $table_name";

    if ($conn->query($sql) === TRUE) {
        echo "Table $table_name deleted successfully";
    } else {
        echo "Error deleting table $table_name: " . $conn->error;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the table name from the user input
    $table = $_POST["table"];

    // Delete the specified table
    delete_table($table, $conn);
}

// Close the connection
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Table</title>
</head>
<body>

<h2>Delete Table</h2>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Table Name: <input type="text" name="table">
    <input type="submit" value="Delete">
</form>

</body>
</html>