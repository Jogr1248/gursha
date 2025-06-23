<!DOCTYPE html>
<html>
<head>
    <title>Food Menu</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        /* Food category list */
        .food-category ul {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            list-style: none;
            padding: 0;
            margin: 20px;
        }

        /* Food category list item */
        .food-category li {
            width: calc(33.33% - 20px);
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .food-category li:nth-child(3n + 1) {
            margin-right: 0;
        }

        .food-category li:hover {
            transform: translateY(-5px);
        }

        /* Food category image */
        .food-category img {
            width: 100%;
            height: auto;
            border-radius: 10px 10px 0 0;
        }

        .food-info {
            padding: 20px;
            text-align: center;
        }

        .food-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        .food-description {
            margin-bottom: 10px;
            display: block;
        }

        .food-price {
            font-size: 18px;
            font-weight: bold;
            color: #27ae60;
            display: block;
            margin-bottom: 10px;
        }

        .add-to-cart {
            background-color: #27ae60;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            width: 100%;
        }

        .add-to-cart:hover {
            background-color: #219653;
        }
    </style>
</head>
<body>

<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
        echo "<h2>{$hotelName}</h2>";

        // Retrieve food items for the current hotel
        $foodQuery = "SELECT * FROM food_items WHERE hotel_name = '{$hotelName}'";
        $foodResult = $conn->query($foodQuery);

        // Check if the food items query executed successfully
        if ($foodResult) {
            // Display the food items in the desired HTML format
            echo "<ul class='food-category'>";
            $count = 0;
            while ($foodRow = $foodResult->fetch_assoc()) {
                $foodName = $foodRow['food_name'];
                $foodPrice = $foodRow['food_price'];
                $foodDescription = $foodRow['food_description'];
                $foodImage = $foodRow['image_path'];

                echo "<li>";
                echo "<img src='{$foodImage}' alt='{$foodName}'>";
                echo "<div class='food-info'>";
                echo "<span class='food-name'>{$foodName}</span>";
                echo "<span class='food-description'>{$foodDescription}</span>";
                echo "<span class='food-price'>{$foodPrice} Birr</span>";
                echo "<button class='add-to-cart' onclick='addToCart(\"{$foodName}\")'>Add to Cart</button>";
                echo "</div>";
                echo "</li>";
                
                $count++;
                if ($count % 3 == 0) { // Start a new row after every 3 items
                    echo "<li style='width: calc(33.33% - 20px);'></li>"; // Empty space for alignment
                }
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
<script>
    function addToCart(foodName) {
        alert("Added to cart: " + foodName);
        // You can add your cart functionality here, such as updating a cart object or redirecting to a cart page
    }
</script>
</body>
</html>
