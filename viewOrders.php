<?php
include "connection.php";
?>



<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="Admin.css">
    
    </head>
    <h1>View Orders</h1>
<body>
<a href="logout.php">Logout</a>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>




<?php

$query = "SELECT * FROM view_orders";
$result = mysqli_query($con, $query);

// Create the table header
echo '<table>
        <tr>
            <th>Order Date</th>
            <th>Customer Email</th>
            <th>Order Number</th>
            <th>Total Price</th>
            <th>Name Store</th>
        </tr>';

// Iterate through the result and display each row in the table
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <td>' . $row['date'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['order_number'] . '</td>
            <td>' . $row['total_price'] . '</td>
            <td>' . $row['Name_store'] . '</td>
        </tr>';
}

// Close the table
echo '</table>';

// Close the database connection
mysqli_close($con);
?>

