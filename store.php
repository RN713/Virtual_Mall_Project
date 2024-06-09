<?php
include "connection.php";

// Retrieve the value of name_cust from name_customer table
$name_cust_query = "SELECT name_cust FROM name_customer";
$name_cust_result = $con->query($name_cust_query);

if ($name_cust_result->num_rows > 0) {
    $name_cust_row = $name_cust_result->fetch_assoc();
    $name_cust = $name_cust_row['name_cust'];
} else {
    $name_cust = ""; // Set a default value if no value found
}

// Add item to cart
if (isset($_POST['add_to_cart'])) {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];



    // Retrieve the item price from the additem table
    $item_price_query = "SELECT Item_Price FROM additem WHERE Item_Name = '$item_name'";
    $item_price_result = $con->query($item_price_query);

    if ($item_price_result->num_rows > 0) {
        $item_price_row = $item_price_result->fetch_assoc();
        $item_price = $item_price_row['Item_Price'];
        $name_store_query = "SELECT Name_store FROM additem WHERE Item_Name = '$item_name'";
        $name_store_result = $con->query($name_store_query);

        if ($name_store_result->num_rows > 0) {
            $name_store_row = $name_store_result->fetch_assoc();
            $name_store = $name_store_row['Name_store'];

            // Insert the item into the store table
            $sql = "INSERT INTO store (Item_Name, Quantity, Item_Price, name_cust, Name_store) VALUES ('$item_name', '$quantity', '$item_price', '$name_cust', '$name_store')";

            if ($con->query($sql) === TRUE) {
                // Refresh the page
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error adding item to cart: " . $con->error;
            }
        } else {
            echo "Name store not found.";
        }
    } else {
        echo "Item price not found.";
    }
}


         
// Retrieve items from the additem table
$sql = "SELECT a.Item_Name, a.Item_Price FROM additem a JOIN home h ON a.Name_store = h.Name_store";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Item List</title>
    <link rel="stylesheet" type="text/css" href="Admin.css">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            text-align: left;
        }

        input[type="number"] {
            width: 60px;
        }
        .top-links {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="top-links">
        <a href="cart.php">cart</a>
        <span style="margin: 0 10px;">|</span>
        <a href="home.php">Home</a>
        <span style="margin: 0 10px;">|</span>
        <a href="logout_c.php">Logout</a>
    </div>
</head>
<body>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item_name = $row['Item_Name'];
                $item_description = "Description: " . $row['Item_Name'];
                $item_price = $row['Item_Price'];
        ?>
                <tr>
                    <td><?php echo $item_name; ?></td>
                    <td><?php echo $item_description; ?></td>
                    <td><?php echo $item_price; ?></td>
                    <td>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="item_name" value="<?php echo $item_name; ?>">
                            <input type="hidden" name="name_cust" value="<?php echo $name_cust; ?>">
                            <input type="number" name="quantity" value="1" min="1">
                    </td>
                    <td>
                            <input type="submit" name="add_to_cart" value="Add to Cart">
                        </form>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "No items found.";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close the database connection
$con->close();
?>