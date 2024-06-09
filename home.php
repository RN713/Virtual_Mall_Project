<?php
include "connection.php";

// Assuming you have already established a database connection

// Fetch customer name from the name_customer table
$query = "SELECT name_cust FROM name_customer LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$customerName = $row['name_cust'];

// Fetch available stores from the addstore table
$query = "SELECT Name_store, Logo FROM addstore";
$result = mysqli_query($con, $query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['storeName'])) {
        $selectedStore = $_POST['storeName'];

        // Delete existing records from the home table
        $deleteQuery = "DELETE FROM home";
        mysqli_query($con, $deleteQuery);





        // Insert the selected store into the home table
        $insertQuery = "INSERT INTO `home` (`Name_store`) VALUES ('$selectedStore')";
        mysqli_query($con, $insertQuery);

        // Redirect to store.php
        header("Location: store.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="Admin.css">
    <style>
        .top-links {
            margin-bottom: 10px;
        }

        #sub {
      background-color: green;
      color: white;
    }
        
    </style>
</head>
<body>
    <div class="top-links">
        <a href="cart.php">cart</a>
        <span style="margin: 0 10px;">|</span>
        <a href="logout_c.php">Logout</a>
    </div>

    <h1>Welcome, <?php echo $customerName; ?>!</h1>
    
    <h2>Available Stores:</h2>
    <table>
        <tr>
            <th>Store Name</th>
            <th>Store Logo</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['Name_store']; ?></td>
            <td><img src="<?php echo $row['Logo']; ?>" width="100" height="100"></td>
            <td>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="storeName" value="<?php echo $row['Name_store']; ?>">
                    <button type="submit" id='sub' >Select</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>