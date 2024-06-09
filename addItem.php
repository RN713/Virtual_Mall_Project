<?php
include "connection.php";
?>

<?php
if (isset($_POST["submit1"])) {
  if (isset($_FILES["itemImage"])) {
    $name_file = $_FILES["itemImage"]["name"];
    $tmp_file = $_FILES["itemImage"]["tmp_name"];
    $ext = explode(".", $name_file);
    $extension = end($ext);
    $array_extensions = array("png", "jpg");
    $target = "item_img/";
    $error = "";

    if (!in_array($extension, $array_extensions)) {
      $error = "Error: Invalid file type. Please upload a PNG or JPG file. <br>";
    }

    if (empty($error)) {
      move_uploaded_file($tmp_file, $target . $name_file);

      // Escape the values before inserting them into the query
      $itemName = mysqli_real_escape_string($link, $_POST["itemName"]);
      $price = intval($_POST["itemPrice"]);
      $logoPath = mysqli_real_escape_string($link, $target . $name_file);

// Retrieve the name_store from the update_store table
$retrieveStoreQuery = "SELECT name_store FROM update_store";
$resultStore = mysqli_query($link, $retrieveStoreQuery);

if ($resultStore && mysqli_num_rows($resultStore) > 0) {
  $rowStore = mysqli_fetch_assoc($resultStore);
  $nameStore = $rowStore['name_store'];
} else {
  $nameStore = '';
}
      // Check if the Name_store value exists in the addstore table
      $checkStoreQuery = "SELECT Name_store FROM addstore WHERE Name_store = '$nameStore'";
      $result = mysqli_query($link, $checkStoreQuery);

      if ($result && mysqli_num_rows($result) > 0) {
        // Insert the item into the additem table
        $sql = mysqli_query($link, "INSERT INTO `additem` (`Item_Name`, `Item_Price`,`Item_Image`,`Name_store`) VALUES ('$itemName', '$price','$logoPath','$nameStore')");

        if ($sql) {
          echo "Item added successfully.";
          echo "Name store: " . $nameStore;
          ?>
          <script type="text/javascript">
            alert("Item inserted");
            window.location = "updateStore.php";
          </script>
          <?php
        } else {
          echo "Error: " . mysqli_error($link);
        }
      } else {
        echo "Error: The specified Name_store does not exist.";
      }
    } else {
      echo $error;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Item</title>
  <link rel="stylesheet" type="text/css" href="Admin.css">

  <style>
   a {
  display: inline-block;
  text-decoration: none;
  padding: 5px 10px;
  background-color: #f0f0f0;
  color: black;
  border: 1px solid #000;
  border-radius: 4px;
}
  </style>
</head>
<body>
  <div class="container">
    <h2>Add Item</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      <label for="itemName">Item Name:</label>
      <input type="text" id="itemName" name="itemName" required><br><br>
      <label for="itemPrice">Item Price:</label>
      <input type="number" id="itemPrice" name="itemPrice" required><br><br>
      <label for="itemImage">Item Image:</label>
      <input type="file" id="itemImage" name="itemImage" required><br><br>
      <input type="hidden" name="from" value="updateStore"> <!-- Add a hidden input field to indicate that the item is coming from the updateStore page -->
      <input type="submit" name="submit1" value="Add Item">
    </form>
    <a href="updateStore.php">Back to Update Store</a>
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>