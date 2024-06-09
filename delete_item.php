<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['itemName'])) {
  $itemName = $_POST['itemName'];

  
  $query = "DELETE FROM additem WHERE Item_Name = '$itemName'";
  $result = mysqli_query($con, $query);

  if ($result) {
    // Deletion successful
    echo "Item deleted successfully";
  } else {
    // Deletion failed
    echo "Error deleting item: " . mysqli_error($con);
  }

  // Close the database connection
  mysqli_close($con);
}
?>