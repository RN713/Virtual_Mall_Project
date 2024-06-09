<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['admin'])) {
  header("Location: admin.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="Admin.css">
  
</head>
<body>
  <div class="container">
    <h2>Admin Dashboard</h2>
    <div class="dashboard-links">
      <a href="addStore.php">Add Store</a>
      <a href="updateStore.php">Update Store</a>
      <a href="viewOrders.php">View Orders</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>
</body>
</html>