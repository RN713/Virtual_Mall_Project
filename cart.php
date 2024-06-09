<?php
include "connection.php";
?>

<?php

$today = date("Y-m-d");


// Fetch data from the store table
$query = "SELECT store.Item_Name, store.Item_Price, store.quantity, additem.Item_Price AS additem_price
          FROM store
          LEFT JOIN additem ON store.Item_Name = additem.Item_Name
          INNER JOIN name_customer ON store.name_cust = name_customer.name_cust";
$result = mysqli_query($con, $query);

// Check if the form is submitted
if (isset($_POST['delete'])) {
    $itemToDelete = $_POST['delete'];

    // Delete the item from the store table
    $deleteQuery = "DELETE FROM store WHERE Item_Name = '$itemToDelete'";
    mysqli_query($con, $deleteQuery);

    // Refresh the page
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Check if the form is submitted to update the quantity
if (isset($_POST['update'])) {
    $itemName = $_POST['item_name'];
    $newQuantity = $_POST['quantity'];

    // Update the quantity in the store table
    $updateQuery = "UPDATE store SET quantity = '$newQuantity' WHERE Item_Name = '$itemName'";
    mysqli_query($con, $updateQuery);

    // Refresh the page
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Check if the cancel_all form is submitted
if (isset($_POST['cancel_all'])) {
    // Delete the rows from the store table that match the name_cust column from the name_customer table
    $deleteQuery = "DELETE store FROM store INNER JOIN name_customer ON store.name_cust = name_customer.name_cust";
    mysqli_query($con, $deleteQuery);

    // Refresh the page
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}


// Check if the checkout button is clicked
// Check if the checkout button is clicked
if (isset($_POST['checkout'])) {
    // Insert into view_orders table
    $insertQuery = "INSERT INTO view_orders (date, email, order_number, total_price, Name_store)
                   SELECT '$today', register.email,
                   (SELECT COUNT(*) FROM view_orders) + 1,
                   SUM(store.Item_Price * store.quantity),
                   store.Name_store
                   FROM store
                   INNER JOIN name_customer ON store.name_cust = name_customer.name_cust
                   INNER JOIN register ON name_customer.name_cust = register.name_cust";
    mysqli_query($con, $insertQuery);

    // Redirect to the checkout page or perform any other necessary action
    header("Location: checkout.php");
    exit();
}



?>

<!DOCTYPE html>
<html>
<head>
    <title>cart</title>
    <link rel="stylesheet" type="text/css" href="Admin.css">

    <style>
        .top-links {
            margin-bottom: 10px;
        }


        #green {
      background-color: green;
      color: white;
    }

    #remove {
      background-color: red;
      color: white;
    }

    </style>
</head>
<body>
    <div class="top-links">
        <a href="home.php">Home</a>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to handle quantity increase
        function increaseQuantity(itemName) {
            var quantityElement = $("#quantity_" + itemName);
            var quantity = parseInt(quantityElement.text());
            quantity++;
            quantityElement.text(quantity);
            updateQuantity(itemName, quantity);
        }

        // Function to handle quantity decrease
        function decreaseQuantity(itemName) {
            var quantityElement = $("#quantity_" + itemName);
            var quantity = parseInt(quantityElement.text());
            if (quantity > 1) {
                quantity--;
                quantityElement.text(quantity);
                updateQuantity(itemName, quantity);
            }
        }

        // Function to update the quantity in the store table
        function updateQuantity(itemName, newQuantity) {
            $.ajax({
                type: "POST",
                url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                data: {
                    update: true,
                    item_name: itemName,
                    quantity: newQuantity
                },
                success: function () {
                    // Refresh the page
                    location.reload();
                }
            });
        }
    </script>
</head>
<body>
    <h1>Shopping Cart</h1>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="cancel_all" value="true">
        <button type="submit" id='green' >Cancel All</button>
    </form>

    <table>
        <tr>
            <th>Item Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['Item_Name']; ?></td>
                <td>Description <?php echo $row['Item_Name']; ?></td>
                <td>
                    <?php 
                    // Check if 'additem_price' is available
                    if (isset($row['additem_price'])) {
                        echo $row['additem_price'] * $row['quantity'];
                    } else {
                        echo $row['Item_Price'] * $row['quantity'];
                    }
                    ?>
                </td>
                <td>
                    <button onclick="decreaseQuantity('<?php echo $row['Item_Name']; ?>')">-</button>
                    <span id="quantity_<?php echo $row['Item_Name']; ?>"><?php echo $row['quantity']; ?></span>
                    <button onclick="increaseQuantity('<?php echo $row['Item_Name']; ?>')">+</button>
                </td>
                <td>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="delete" value="<?php echo $row['Item_Name']; ?>">
                        <button type="submit" id='remove' >Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>

    </table>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <button type="submit" name="checkout" id='green'>Proceed to Checkout</button>
</form>

</body>
</html>