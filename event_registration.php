<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "project";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $eventType = $_POST['event_type'];
    $attendees = $_POST['attendees'];
    $duration = $_POST['duration'];
    $serviceType = $_POST['service_type'];

    // Insert the form data into the database table
    $sql = "INSERT INTO event_registrations (name, phone, address, event_type, attendees, duration, service_type)
            VALUES ('$name', '$phone', '$address', '$eventType', '$attendees', '$duration', '$serviceType')";

    if (mysqli_query($conn, $sql)) {
        $response = [
            'status' => 'success',
            'message' => 'Form submitted successfully!'
        ];
        echo json_encode($response);
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Error: ' . mysqli_error($conn)
        ];
        echo json_encode($response);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Handle the case when the form is not submitted via POST method
    echo "Invalid request.";
}
?>