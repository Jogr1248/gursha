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

// Delete tuples function
function delete_tuples($order_id, $conn) {
    // Delete from order_items table
    $sql_order_items = "DELETE FROM order_items WHERE order_id = $order_id";
    if ($conn->query($sql_order_items) === TRUE) {
        echo "Order items tuples deleted successfully";
    } else {
        echo "Error deleting order items tuples: " . $conn->error;
    }

    // Delete from orders table
    $sql_orders = "DELETE FROM orders WHERE order_id = $order_id";
    if ($conn->query($sql_orders) === TRUE) {
        echo "Order tuples deleted successfully";
    } else {
        echo "Error deleting order tuples: " . $conn->error;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["order_id"])) {
        $order_id = $_POST["order_id"];
        delete_tuples($order_id, $conn);
    } else {
        echo "Order ID not provided";
    }
}

// Close the connection
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Tuples</title>
</head>
<body>

<h2>Delete Tuples</h2>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Order ID: <input type="number" name="order_id">
    <input type="submit" value="Delete">
</form>

</body>
</html>