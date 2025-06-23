<!DOCTYPE html>
<html>
<head>
    <title>Delivery Partners</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Delivery Partners</h1>

    <?php
    // Database connection details
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'project';

    // Establish a connection to the MySQL database
    $connection = mysqli_connect($host, $username, $password, $database);

    // Check if the connection was successful
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SELECT query
    $query = "SELECT * FROM delivery_partners";

    // Execute the SELECT query
    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        // Display the table
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Vehicle</th><th>License</th><th>Address</th></tr>";

        // Loop through the rows of the result
        while ($row = mysqli_fetch_assoc($result)) {
            // Retrieve the values from the row
            $id = $row['id'];
            $name = $row['name'];
            $email = $row['email'];
            $phone = $row['phone'];
            $vehicle = $row['vehicle'];
            $license = $row['license'];
            $address = $row['address'];


            // Display the row data in the table
            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$name</td>";
            echo "<td>$email</td>";
            echo "<td>$phone</td>";
            echo "<td>$vehicle</td>";
            echo "<td>$license</td>";
            echo "<td>$address</td>";

            echo "</tr>";
        }

        // Close the table
        echo "</table>";

        // Free the result set
        mysqli_free_result($result);
    } else {
        // Handle the case when there are no rows in the table
        echo "No data found.";
    }

    // Close the database connection
    mysqli_close($connection);
    ?>
</body>
</html>