<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nameStore'])) {
  $namestore = $_POST['nameStore'];

 
  $query = "DELETE FROM update_store";
  $result = mysqli_query($con, $query);

 $query2 = "SELECT * FROM addstore WHERE Name_store = '$namestore'";
    $result2 = mysqli_query($con, $query2);
    $row = mysqli_fetch_assoc($result2);
    $name = $row['Name_store'];
    $sql = mysqli_query($link, "INSERT INTO `update_store` (`Name_store`) VALUES ('$name')");

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
