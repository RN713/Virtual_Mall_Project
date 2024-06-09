<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['admin'])) {
  header("Location: dashboard.php");
  exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if the username and password match the predefined values
  if ($username === 'admin' && $password === 'admin123') {
    $_SESSION['admin'] = true;
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Invalid credentials. Please try again.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" type="text/css" href="Admin.css">
  
</head>
<body>
  <div class="container">
    <h2>Admin Login</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required><br><br>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required><br><br>
      <input type="submit" value="Login">
      <?php if (isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
      <?php } ?>
    </form>
  </div>
</body>
</html>