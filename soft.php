<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have retrieved the order details from the user input
    $name = $_POST['name'];
    $phoneNumber = $_POST['phone'];
    $address = $_POST['address'];
    $hotelName = $_POST['hotel'];
    $totalPrice = 100;

    // Example order items
    $orderItems = array(
        array("product" => "merinda ", "price" => 25),
        array("product" => "coccola", "price" => 25),
        array("product" => "pepse", "price" => 25),
        array("product" => "sprite", "price" => 25),
		array("product" => "juice", "price" => 25)
    );

    // Database connection parameters
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "project";

    // Create a new MySQLi instance
    $conn = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the order details into the "orders" table
    $sql = "INSERT INTO orders (name, phoneNumber, address, hotelName, totalPrice) VALUES ('$name', '$phoneNumber', '$address', '$hotelName', $totalPrice)";

    if ($conn->query($sql) === TRUE) {
        $orderId = $conn->insert_id;
        echo "Order placed successfully. Order ID: " . $orderId;

        // Insert the order items into the "order_items" table
        foreach ($orderItems as $item) {
            $product = $item['product'];
            $price = $item['price'];

            $sql = "INSERT INTO order_items (order_id, product, price) VALUES ($orderId, '$product', $price)";

            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
/* CSS styles for the product containers */
.product {
    display: inline-block;
    text-align: center;
    margin-right: 20px;
    width: calc(25% - 20px);
    box-sizing: border-box;
    vertical-align: top;
    border: 1px solid #ccc; /* Add a 1px solid border */
    padding: 10px; /* Add some padding to create space between the border and content */
}

.product img {
    width: 100%;
    height: auto;
}

.product__title {
    margin-top: 10px;
    margin-bottom: 5px;
    font-size: 18px;
}

.product__price {
    margin-bottom: 5px;
    font-size: 14px;
}

/* Rest of your CSS styles */
    </style>
    <link rel="stylesheet" href="drink.css">
</head>
<body>

    <div class="product">
        <img src="st gorgis beer.jpg" alt="st gorgis beer" />
        <h3 class="product__title">ST.Gorgise BEER</h3>
        <div class="flex-group space-between v-center">
            <p class="product__price">Price <span>25 Birr</span></p>
            <button class="button" data-type="outline" onclick="calculateTotalPrice(25, 'ST.Gorgise BEER')">ORDER</button>
        </div>
    </div>

    <div class="product">
        <img src="st gorgis beer.jpg" alt="merinda" />
        <h3 class="product__title"> mirinda</h3>
        <div class="flex-group space-between v-center">
            <p class="product__price">Price <span>25 Birr</span></p>
            <button class="button" data-type="outline" onclick="calculateTotalPrice(25, 'ST.Gorgise BEER')">ORDER</button>
        </div>
    </div>

    <div class="product">
        <img src="meta beer.jpg" alt="cocacola" />
        <h3 class="product__title">COCA cola</h3>
        <div class="flex-group space-between v-center">
            <p class="product__price">Price <span>25 Birr</span></p>
            <button class="button" data-type="outline" onclick="calculateTotalPrice(25, 'META BEER')">ORDER</button>
        </div>
    </div>

    <div class="product">
        <img src="harer beer.jpg" alt="Harer Beer" />
        <h3 class="product__title">sprite</h3>
        <div class="flex-group space-between v-center">
            <p class="product__price">Price <span>25 Birr</span></p>
            <button class="button" data-type="outline" onclick="calculateTotalPrice(25, 'Harar')">ORDER</button>
        </div>
    </div>

    <div class="product" data-featured="true">
        <img src="walia beer.jpg" alt="pepose" />
        <h3 class="product__title">Walia</h3>
        <p class="product__description">
           
        </p>

        <div class="flex-group space-between v-center">
            <p class="product__price">Price<span>25 Birr</span></p>
            <button class="button" data-type="outline" onclick="calculateTotalPrice(25, 'Walia')">ORDER</button>
        </div>
    </div>

    <div class="product">
        <img src="dashen beer.jpg" alt="dashen" />
        <h3 class="product__title">fanta</h3>
        <div class="flex-group space-between v-center">
            <p class="product__price">Price <span>25 Birr</span></p>
            <button class="button" data-type="outline" onclick="calculateTotalPrice(25, 'Dashen')">Order</button>
        </div>
    </div>

    <div class="product">
        <img src="dashen beer.jpg" alt="dashen" />
        <h3 class="product__title">jouci</h3>
        <div class="flex-group space-between v-center">
            <p class="product__price">Price <span>25 Birr</span></p>
            <button class="button" data-type="outline" onclick="calculateTotalPrice(25, 'Dashen')">Order</button>
        </div>
    </div>

    <div id="total-price">Total Price: 0 Birr</div>

    <!-- Order form -->
    <form id="order-form" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="hotel">Hotel:</label>
        <select id="hotel" name="hotel" required>
            <option value="hotel1">Hotel 1</option>
            <option value="hotel2">Hotel 2</option>
            <option value="hotel3">Hotel 3</option>
            <!-- Add more options for other hotels if needed -->
        </select><br><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="food_items">Food Items:</label>
        <input type="text" id="food_items" name="food_items" value="drinks" required><br><br>

        <button type="submit">Place Order</button>
    </form>

    <!-- JavaScript for calculating the total price -->
    <script>
        var totalPriceElement = document.getElementById('total-price');
        var totalPrice = 0;

        function calculateTotalPrice(price, product) {
            totalPrice += price;
            totalPriceElement.textContent = 'Total Price: ' + totalPrice + ' Birr';
            var foodItemsElement = document.getElementById('food_items');
            foodItemsElement.value += ', ' + product;
        }
    </script>
</body>
</html>