<?php
// Database configuration
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $hotelName = $_POST['hotelName'];
    $category = $_POST['category'];
    $itemNames = $_POST['itemName'];
    $itemPrices = $_POST['itemPrice'];
    $itemImages = $_FILES['itemImage'];

    // Construct the hotel object
    $newHotel = [
        'name' => $hotelName,
        'foodItems' => []
    ];

    // Combine the food item details into the hotel object
    for ($i = 0; $i < count($itemNames); $i++) {
        $category = $conn->real_escape_string($category[$i]);
        $itemName = $conn->real_escape_string($itemNames[$i]);
        $itemPrice = $conn->real_escape_string($itemPrices[$i]);
        $itemImageName = $itemImages['name'][$i];
        $itemImageTmpName = $itemImages['tmp_name'][$i];
        $itemImageError = $itemImages['error'][$i];

        // Handle image upload
        if ($itemImageError === UPLOAD_ERR_OK) {
            $uploadDir = 'food_images/';
            $itemImageDestination = $uploadDir . $itemImageName;
            move_uploaded_file($itemImageTmpName, $itemImageDestination);
        }

        $newHotel['foodItems'][] = [
            'category' => $category,
            'name' => $itemName,
            'price' => $itemPrice,
            'image' => ($itemImageError === UPLOAD_ERR_OK) ? $itemImageDestination : ""
        ];
    }

    // Insert the hotel data into the database
    $hotelData = $conn->real_escape_string(json_encode($newHotel));
    $sql = "INSERT INTO hotels (name, data) VALUES ('$hotelName', '$hotelData')";

    if ($conn->query($sql) === TRUE) {
        echo "Hotel added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Hotel</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1>Add Hotel</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="hotelName">Hotel Name:</label>
        <input type="text" id="hotelName" name="hotelName" required>

        <fieldset>
            <legend>Food Items</legend>
            <div id="foodItems">
                <div class="foodItem">
                    <input type="text" name="category[]" placeholder="Category" required>
                    <input type="text" name="itemName[]" placeholder="Item Name" required>
                    <input type="number" name="itemPrice[]" placeholder="Item Price" step="0.01" required>
                    <input type="file" name="itemImage[]" required>
                    <button type="button" onclick="removeFoodItem(this)">Remove</button>
                </div>
            </div>
            <button type="button" onclick="addFoodItem()">Add Food Item</button>
        </fieldset>

        <button type="submit">Submit</button>
    </form>

    <script>
        function addFoodItem() {
            const foodItemsDiv = document.getElementById("foodItems");
            const foodItemDiv = document.createElement("div");
            foodItemDiv.className = "foodItem";
            foodItemDiv.innerHTML = `
                <input type="text" name="category[]" placeholder="Category" required>
                <input type="text" name="itemName[]" placeholder="Item Name" required>
                <input type="number" name="itemPrice[]" placeholder="Item Price" step="0.01" required>
                <input type="file" name="itemImage[]" required>
                <button type="button" onclick="removeFoodItem(this)">Remove</button>
            `;
            foodItemsDiv.appendChild(foodItemDiv);
        }

        function removeFoodItem(button) {
            const foodItemDivIt looks like you encountered some PHP warnings related to undefined array keys and trying to access array offsets on a null value. These warnings indicate that there are issues with your code where you are trying to access array elements that do not exist or have null values.

To resolve these warnings, you can make the following modifications to your code:

1. Add checks to ensure that the array keys exist before accessing them. You can use the `isset()` function to check if an array key is set before accessing it.

2. Make sure that the array keys you are trying to access exist and have valid values. Check if the arrays have been properly populated before accessing their elements.

Here's an updated version of your code with these modifications:

```php
<?php
// Database configuration
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $hotelName = $_POST['hotelName'];
    $category = $_POST['category'];
    $itemNames = $_POST['itemName'];
    $itemPrices = $_POST['itemPrice'];
    $itemImages = $_FILES['itemImage'];

    // Construct the hotel object
    $newHotel = [
        'name' => $hotelName,
        'foodItems' => []
    ];

    // Combine the food item details into the hotel object
    for ($i = 0; $i < count($itemNames); $i++) {
        $categoryValue = isset($category[$i]) ? $conn->real_escape_string($category[$i]) : "";
        $itemNameValue = isset($itemNames[$i]) ? $conn->real_escape_string($itemNames[$i]) : "";
        $itemPriceValue = isset($itemPrices[$i]) ? $conn->real_escape_string($itemPrices[$i]) : "";
        $itemImageName = isset($itemImages['name'][$i]) ? $itemImages['name'][$i] : "";
        $itemImageTmpName = isset($itemImages['tmp_name'][$i]) ? $itemImages['tmp_name'][$i] : "";
        $itemImageError = isset($itemImages['error'][$i]) ? $itemImages['error'][$i] : "";

        // Handle image upload
        if ($itemImageError === UPLOAD_ERR_OK) {
            $uploadDir = 'food_images/';
            $itemImageDestination = $uploadDir . $itemImageName;
            move_uploaded_file($itemImageTmpName, $itemImageDestination);
        }

        $newHotel['foodItems'][] = [
            'category' => $categoryValue,
            'name' => $itemNameValue,
            'price' => $itemPriceValue,
            'image' => ($itemImageError === UPLOAD_ERR_OK) ? $itemImageDestination : ""
        ];
    }

    // Insert the hotel data into the database
    $hotelData = $conn->real_escape_string(json_encode($newHotel));
    $sql = "INSERT INTO hotels (name, data) VALUES ('$hotelName', '$hotelData')";

    if ($conn->query($sql) === TRUE) {
        echo "Hotel added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>