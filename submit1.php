<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'project';

$mysqli = mysqli_connect($hostname, $username, $password, $database);
if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted data
    $formData = $_POST['food_data'];
    $foodImage = $_FILES['food_image'];

    foreach ($formData as $index => $item) {
        // Validate input
        $foodName = validateInput($item['food_name'], 50);
        if ($foodName === false) {
            echo "Food name is too long!";
            exit;
        }
        $foodName = sanitizeInput($foodName);

        // Rest of the validation and sanitization...

        // Check if there is a corresponding image for the current food item
        if (!empty($foodImage['name'][$index])) {
            $fileName = basename($foodImage['name'][$index]);
            $tempFilePath = $foodImage['tmp_name'][$index];
            $filePath = "food_images/" . $fileName;

            move_uploaded_file($tempFilePath, $filePath);
        } else {
            $filePath = null;
        }

        // Prepare the query
        $query = "INSERT INTO food_items (food_name, food_price, food_description, food_category, hotel_name, image_path) ";
        $query .= "VALUES (?, ?, ?, ?, ?, ?)";

        // Prepare the statement and check for errors
        $stmt = mysqli_prepare($mysqli, $query);
        if (!$stmt) {
            echo "Failed to prepare SQL statement: " . mysqli_error($mysqli);
            exit;
        }

        // Bind parameters to the query
        mysqli_stmt_bind_param($stmt, "sdssss", $foodName, $foodPrice, $foodDescription, $foodCategory, $hotelName, $filePath);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Close the statement
        mysqli_stmt_close($stmt);
    }

    // Redirect to a success page or display a success message
    echo "Form data has been successfully processed and written to the database.";
}

// Close the connection
mysqli_close($mysqli);

// Validate input
function validateInput($input, $maxLength) {
    $input = trim($input);
    if (strlen($input) > $maxLength) {
        return false;
    }
    return $input;
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