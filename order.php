<?php
// Retrieve the form values
$name = isset($_POST['userName']) ? $_POST['userName'] : '';
$phoneNumber = isset($_POST['userPhone']) ? $_POST['userPhone'] : '';
$address = isset($_POST['userAddress']) ? $_POST['userAddress'] : '';
$hotelName = isset($_POST['hotelName']) ? $_POST['hotelName'] : '';
$totalPrice = isset($_POST['totalPrice']) ? $_POST['totalPrice'] : 0;
$foodItems = isset($_POST['selectedItems']) ? json_decode($_POST['selectedItems'], true) : array();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user exists in the "users" table
$userSql = "SELECT id FROM users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($userSql);
$stmt->bind_param("ss", $name, $phoneNumber); // assuming phone is used as email or username as fallback
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $userId = $user['id'];
} else {
    // Insert new user into the users table
    $userSql = "INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($userSql);
    $password = password_hash("default_password", PASSWORD_DEFAULT); // Replace with a real password handling method
    $stmt->bind_param("ssss", $name, $name, $phoneNumber, $password);
    $stmt->execute();
    $userId = $stmt->insert_id; // Get the newly inserted user ID
}

// Get hotel ID by name (assuming one hotel is used for now)
$hotelSql = "SELECT hotel_id FROM hotels WHERE name = ?";
$stmt = $conn->prepare($hotelSql);
$stmt->bind_param("s", $hotelName);
$stmt->execute();
$hotelResult = $stmt->get_result();
$hotel = $hotelResult->fetch_assoc();
$hotelId = $hotel['hotel_id'];

// Insert order details into the "orders" table
$orderSql = "INSERT INTO orders (user_id, hotel_id, total_price) VALUES (?, ?, ?)";
$stmt = $conn->prepare($orderSql);
$stmt->bind_param("iid", $userId, $hotelId, $totalPrice);
$stmt->execute();
$orderId = $stmt->insert_id; // Get the newly inserted order ID

// Insert food items into the "order_items" table
$orderItemsSql = "INSERT INTO order_items (order_id, food_id, quantity, price) VALUES (?, ?, ?, ?)";
$orderItemsStmt = $conn->prepare($orderItemsSql);

foreach ($foodItems as $item) {
    // Get food_id based on the food_name
    $foodSql = "SELECT food_id FROM food_items WHERE food_name = ?";
    $stmt = $conn->prepare($foodSql);
    $stmt->bind_param("s", $item['name']);
    $stmt->execute();
    $foodResult = $stmt->get_result();
    $food = $foodResult->fetch_assoc();
    $foodId = $food['food_id'];

    // Insert the item into order_items
    $quantity = isset($item['quantity']) ? $item['quantity'] : 1; // Assuming quantity is passed or default to 1
    $price = $item['price']; // Use price passed from the form data
    $orderItemsStmt->bind_param("iiid", $orderId, $foodId, $quantity, $price);
    $orderItemsStmt->execute();
}

$orderItemsStmt->close();
$stmt->close();
$conn->close();

echo "Order placed successfully. Order ID: $orderId";
?>
