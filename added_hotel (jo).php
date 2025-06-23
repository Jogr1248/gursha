<!DOCTYPE html>
<html>
<head>
    <title>Food Menu</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        /* Food category list */
        .food-category ul {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 10px;
            list-style: none;
            padding: 0;
        }

        /* Food category list item */
        .food-category li {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 10px;
            background-color: #f2f2f2;
        }

        /* Food category image */
        .food-category img {
            width: 100px;
            height: auto;
            border: 5px solid rgb(255, 255, 255);
        }
    </style>
</head>
<body>

<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Update 'your_password' with the actual password
$dbname = "project";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

// Fetch distinct hotel names from the hotels table
$query = "SELECT DISTINCT hotel_name FROM food_items";
$result = $conn->query($query);

// Check if the query executed successfully
if ($result) {
    // Process each hotel
    while ($row = $result->fetch_assoc()) {
        $hotelName = $row['hotel_name'];

        // Display the hotel name as a header
        echo "<h3>{$hotelName}</h3>";

        // Retrieve food items for the current hotel
        $foodQuery = "SELECT * FROM food_items WHERE hotel_name = '{$hotelName}'";
        $foodResult = $conn->query($foodQuery);

        // Check if the food items query executed successfully
        if ($foodResult) {
            // Display the food items in the desired HTML format
            echo "<ul class='food-category'>";
            while ($foodRow = $foodResult->fetch_assoc()) {
                $foodName = $foodRow['food_name'];
                $foodPrice = $foodRow['food_price'];
                $foodDescription = $foodRow['food_description'];
                $foodImage = $foodRow['image_path'];
                $foodID = $foodRow['id']; // Assuming there's an ID field in your food_items table

                echo "<li>";
                echo "<img src='{$foodImage}' alt='{$foodName}'>";
                echo "<div class='food-info'>";
                echo "<span class='food-name'>{$foodName}</span>";
                echo "<span class='food-description'>{$foodDescription}</span>";
                echo "<span class='food-price'>{$foodPrice} Birr</span>";
                echo "<form method='post' action='cart.php'>"; // Form for adding item to cart
                echo "<input type='hidden' name='food_id' value='{$foodID}'>";
                echo "<input type='submit' class='add-to-cart' value='Add to Cart'>";
                echo "</form>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "Error retrieving food items: " . $conn->error;
        }
    }
} else {
    echo "Error retrieving hotels: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
</body>
</html>
