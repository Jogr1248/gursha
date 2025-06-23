<!DOCTYPE html>
<html>
<head>
<style>
/* PHP code styling */
.php-code {
  background-color: #f6f8fa;
  border-radius: 5px;
  padding: 10px;
  font-family: Consolas, monospace;
  font-size: 14px;
  line-height: 1.4;
  color: #333;
}
.php-output {
  background-color: #f6f8fa;
  border-radius: 5px;
  padding: 10px;
  font-family: Arial, sans-serif;
  font-size: 14px;
  line-height: 1.4;
  color: #333;
}
</style>
</head>
<body>
  <h1>Welcome to Gursha</h1>
  <p>This is your last orders</p>
  

  <?php
  // Assuming you have already established a database connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "project";

  // Create a new connection
  $connection = new mysqli($servername, $username, $password, $dbname);

  // Check the connection
  if ($connection->connect_error) {
      die("Connection failed: " . $connection->connect_error);
  }

  // Retrieve the last order ID from the "orders" table
  $selectOrderQuery = "
  SELECT MAX(order_id) AS last_order_id
  FROM orders
  ";
  $selectOrderStatement = $connection->prepare($selectOrderQuery);
  $selectOrderStatement->execute();

  // Fetch the result
  $orderResult = $selectOrderStatement->get_result();
  $orderRow = $orderResult->fetch_assoc();
  $order_id = $orderRow['last_order_id'];

  // Retrieve the latest order values from the "order_items" table
  $selectQuery = "
  SELECT product
  FROM order_items
  WHERE order_id = ?
  ORDER BY order_id DESC
  LIMIT 1
  ";
  $selectStatement = $connection->prepare($selectQuery);
  $selectStatement->bind_param("i", $order_id);
  $selectStatement->execute();

  // Fetch the result
  $result = $selectStatement->get_result();
  if ($row = $result->fetch_assoc()) {
      $product = $row['product'];

      // Update the "orders" table with the latest order values
      $updateQuery = "
      UPDATE orders
      SET foodName = ?
      WHERE order_id = ?
      ";
      $updateStatement = $connection->prepare($updateQuery);
      $updateStatement->bind_param("si", $product, $order_id);

      // Execute the update statement
      $updateStatement->execute();

      // Close the update statement
      $updateStatement->close();
  }

  // Retrieve the updated data from the "orders" table
  $selectUpdatedQuery = "
  SELECT name, hotelName, foodName, totalPrice, order_id
  FROM orders
  WHERE order_id = ?
  ";
  $selectUpdatedStatement = $connection->prepare($selectUpdatedQuery);
  $selectUpdatedStatement->bind_param("i", $order_id);
  $selectUpdatedStatement->execute();

  // Fetch the updated results
  $updatedResult = $selectUpdatedStatement->get_result();
  if ($updatedRow = $updatedResult->fetch_assoc()) {
      $name = $updatedRow['name'];
      $hotelName = $updatedRow['hotelName'];
      $foodName = $updatedRow['foodName'];
      $totalPrice = $updatedRow['totalPrice'];
      $order_id = $updatedRow['order_id'];

      // Display the updated data
      echo '<div class="php-output">';
      echo "Name: " . $name . "<br>";
      echo "Hotel Name: " . $hotelName . "<br>";
      echo "Food Name: " . $foodName . "<br>";
      echo "Total Price: " . $totalPrice . "<br>";
      echo "Order ID: " . $order_id . "<br>";
      echo '</div>';
  } else {
      echo "No data found for order ID: " . $order_id;
  }

  // Close the select statement and database connection
  $selectUpdatedStatement->close();
  $connection->close();
  ?>
</body>
</html>