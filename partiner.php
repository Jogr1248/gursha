<?php
// Establish a database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "project";

$connection = mysqli_connect($host, $user, $password, $database);

// Check if there is a database connection error
if (mysqli_connect_errno()) {
    echo "Failed to connect to database: " . mysqli_connect_error();
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted data
$name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $vehicle = sanitizeInput($_POST['vehicle']);
    $license = sanitizeInput($_POST['license']);
    $address = sanitizeInput($_POST['address']);

    // Create an INSERT query
$query = "INSERT INTO delivery_partners (name, email, phone, vehicle, license, address) ";
    $query .= "VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare the statement and check for errors
$stmt = mysqli_prepare($connection, $query);
    if (!$stmt) {
        echo "Failed to prepare SQL statement: " . mysqli_error($connection);
        exit;
    }

    // Bind parameters to the query
$null = null;
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $phone, $vehicle, $license, $address);

    // Execute the query and check for errors
mysqli_stmt_execute($stmt);
    if (!$stmt) {
        echo "Failed to execute SQL statement: " . mysqli_error($connection);
        exit;
    }

    // Close the statement
mysqli_stmt_close($stmt);

    // Close the connection
mysqli_close($connection);

    // Redirect to a success page or display a success message
echo "Form data has been successfully processed and written to the database.";
}

// Sanitize input
function sanitizeInput($input) {
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    $input = trim($input);
    $input = strip_tags($input);
    $input = addslashes($input);
    return $input;
}
?>
