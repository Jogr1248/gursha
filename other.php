<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phoneNumber = $_POST['phone'];
    $address = $_POST['address'];
    $hotelName = $_POST['hotel'];
    $foodName = $_POST['food_items'];
    $totalPrice = 100;

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "project";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert order details into orders table
    $sql = "INSERT INTO orders (name, phoneNumber, address, hotelName, totalPrice) 
            VALUES ('$name', '$phoneNumber', '$address', '$hotelName', $totalPrice)";
    
    if ($conn->query($sql) === FALSE) {
        die("Error inserting order details: " . $conn->error);
    }

    // Get the inserted order ID
    $orderId = $conn->insert_id;

    // Insert order items into orders_item table
    $sqlItems = "INSERT INTO orders_item (order_id, foodName) 
                 VALUES ($orderId, '$foodName')";
    
    if ($conn->query($sqlItems) === FALSE) {
        die("Error inserting order items: " . $conn->error);
    }

    echo "Order placed successfully. Order ID: " . $orderId;

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
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px;
    }

    /* Add your CSS styles here */

    </style>
</head>
<body>

     <div class="product-container">
       
        
        <div class="product-card">
            
            <img src="Jamesson-Black-Barrel.jpeg" alt="Product 1">
            <h3>Product 3</h3>
                <p class="price">$29.99</p>
                <p class="description">Product 3 description goes here.</p>
                <button class="button" data-product="Product 3" data-price="29.99">Add to Cart</button>
        </div>
        <div class="product-card">
            <img src="johnnie-walker-gold-label-reserve.jpeg" alt="Product 2">
            <h3>Product 3</h3>
            <p class="price">$29.99</p>
            <p class="description">Product 3 description goes here.</p>
            <button class="button" data-product="Product 3" data-price="29.99">Add to Cart</button>
        </div>
        <div class="product-card">
            <img src="Hendrick's-Gin.jpeg" alt="Product 3">
            <h3>Product 3</h3>
            <p class="price">$29.99</p>
            <p class="description">Product 3 description goes here.</p>
            <button class="button" data-product="Product 3" data-price="29.99">Add to Cart</button>
        </div>
   
          <div class="product-card">
              <img src="monkey-shoulder.jpeg" alt="Product 1">
              <h3>Product 3</h3>
              <p class="price">$29.99</p>
              <p class="description">Product 3 description goes here.</p>
              <button class="button" data-product="Product 3" data-price="29.99">Add to Cart</button>
          </div>
          <div class="product-card">
              <img src="Glenfiddich-15-years.jpeg" alt="Product 2">
              <h3>Product 3</h3>
              <p class="price">$29.99</p>
              <p class="description">Product 3 description goes here.</p>
              <button class="button" data-product="Product 3" data-price="29.99">Add to Cart</button>
          </div>
          <div class="product-card">
              <img src="Grant’s-Triple-Wood.jpeg" alt="Product 3">
              <h3>Product 3</h3>
              <p class="price">$29.99</p>
              <p class="description">Product 3 description goes here.</p>
              <button class="button" data-product="Product 3" data-price="29.99">Add to Cart</button>
          </div>
          
            <div class="product-card">
                <img src="Tanqueray-London-Dry-Gin.jpeg" alt="Product 1">
                <h3>Product 3</h3>
                <p class="price">$29.99</p>
                <p class="description">Product 3 description goes here.</p>
                <button class="button" data-product="Product 3" data-price="29.99">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="Winter-Palace-.jpeg" alt="Product 2">
                <h3>Product 3</h3>
                <p class="price">$29.99</p>
                <p class="description">Product 3 description goes here.</p>
                <button class="button" data-product="Product 3" data-price="29.99">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="Castello-Del-Pogglo-Prosecco.jpeg" alt="Product 3">
                <h3>Product 3</h3>
               <p class="price">$29.99</p>
                <p class="description">Product 3 description goes here.</p>
                <button class="button" data-product="Product 3" data-price="29.99">Add to Cart</button>
            </div>
        </div>
        

    <div id="total-price">Total Price: 0 Birr</div>

    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br> 
        <label for="hotel">Hotel:</label>
        <select id="hotel" name="hotel" required>
            <option value="hotel1">Hotel 1</option>
            <option value="hotel2">Hotel 2</option>
            <option value="hotel3">Hotel 3</option>
        </select><br><br>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required><br><br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>
        <label for="food_items">Food Items:</label>
        <input type="text" id="food_items" name="food_items" value="drinks" required><br><br>
        <button type="submit">Place Order</button>
    </form> 

    <script>
        // Add your JavaScript code here
    </script>

</body>
</html>