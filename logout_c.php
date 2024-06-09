<?php
session_start();

// Destroy all session data
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Successfully Logged Out</title>
  <link rel="stylesheet" type="text/css" href="Admin.css">

  <style>
    /* CSS styles for the logout page */
    /* ... Add your CSS styles here ... */
  </style>
</head>
<body>
  <div class="container">
    <h2>Successfully Logged Out</h2>
    <p>You have been successfully logged out.</p>
    <p>Click <a href="index.php">here</a> to go to the login page.</p>
  </div>
</body>
</html>