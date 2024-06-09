<?php
include "connection.php";
?>

<?php 
if (isset($_POST["submit1"])) {
  if (isset($_FILES["storeLogo"])) {
    $name_file = $_FILES["storeLogo"]["name"];
    $tmp_file = $_FILES["storeLogo"]["tmp_name"];
    $ext = explode(".", $name_file);
    $extension = end($ext);
    $array_extensions = array("png", "jpg");
    $target = "Logo/";
    $error = "";

    if (!in_array($extension, $array_extensions)) {
      $error = "Error: Invalid file type. Please upload a PNG or JPG file. <br>";
    }

    if (empty($error)) {
      move_uploaded_file($tmp_file, $target . $name_file);

      // Escape the values before inserting them into the query
      $storeName = mysqli_real_escape_string($link, $_POST["storeName"]);
      $logoPath = mysqli_real_escape_string($link, $target . $name_file);

      $sql = mysqli_query($link, "DELETE FROM update_store");
      if ($sql) {
        $sql = mysqli_query($link, "INSERT INTO `addstore` (`Name_store`, `Logo`) VALUES ('$storeName', '$logoPath')");
        $sql = mysqli_query($link, "INSERT INTO `update_store` (`Name_store`) VALUES ('$storeName')");

        if ($sql) {
          echo "Store added successfully.";
          ?>
          <script type="text/javascript">
            alert("Store inserted");
            window.location = "addStore.php";
          </script>
          <?php
        } else {
          echo "Error: " . mysqli_error($link);
        }
      } else {
        echo "Error: " . mysqli_error($link);
      }
    } else {
      echo $error;
    }
  }
}
?>


<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['admin'])) {
  header("Location: admin.php");
  exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  header("Location: addItem.php");
  exit;
}
?>



<!DOCTYPE html>
<html>
<head>
  <title>Add Store</title>
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
    <h2>Add Store</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      <label for="storeName">Store Name:</label>
      <input type="text" id="storeName" name="storeName" required><br><br>
      <label for="storeLogo">Store Logo:</label>
      <input type="file" id="storeLogo" name="storeLogo" required><br><br>
      <input type="submit" name="submit1" value="Add Store">
    </form>
    <a href="logout.php">Logout</a>
    <a href="dashboard.php">Back to Dashboard</a>
  </div>
</body>
</html>