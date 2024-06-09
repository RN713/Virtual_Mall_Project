
<?php
include "connection.php";
?>


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
  <title>Update Store</title>
  <link rel="stylesheet" type="text/css" href="Admin.css">
  <style>
    
    #delete {
      background-color: red;
      color: white;
    }
    #add2 {
      background-color: green;
      color: white;
    }

    tr {
    text-align: center;
    
  }

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
</head<body>
  <div class="container">
    <h2>Update Store</h2>
    <br>
   

      <?php


// Retrieve the distinct Name_store values from the addstore table
$query = "SELECT DISTINCT Name_store FROM addstore";
$result = mysqli_query($con, $query);

// Loop through the distinct Name_store values
while ($row = mysqli_fetch_assoc($result)) {
    $nameStore = $row['Name_store'];
    echo "<h3>Name_store: " . $nameStore . "</h3>";
    echo "<button id='add2' onclick=\"add8('" . $nameStore . "')\">add Item</button>"; // Add the order Name_store button
    
    // Retrieve all rows with the same Name_store value from the addstore table
    $query2 = "SELECT * FROM additem WHERE Name_store = '$nameStore'";
    $result2 = mysqli_query($con, $query2);

   // Check if there are items for the current Name_store
   if (mysqli_num_rows($result2) > 0) {
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>
            <th>Item Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Actions</th>
          </tr>";
    echo "</thead>";
    echo "<tbody>";

    // Loop through the rows with the same Name_store value
    while ($row2 = mysqli_fetch_assoc($result2)) {
      // Access the specific columns you need from the row
      $itemName = $row2['Item_Name'];
      $itemPrice = $row2['Item_Price'];
      // ...

      // Do something with the retrieved data
      echo "<tr>
             <td>".$itemName."</td>
             <td>Description of ".$itemName."</td>
             <td>".$itemPrice."</td>
             <td> <button id='delete' onclick=\"deleteItem('".$itemName."')\">Delete</button> </td>
           </tr>";
    }

    echo "</tbody>";
    echo "</table>";
  } else {
    echo "<p>No items found for this store.</p>";
  }

  echo "<br>";
}

// Close the database connection
mysqli_close($con);
?>
</tbody>
</table>


<script>
function add8(nameStore) {
        if (confirm("Are you sure you want to add ?")) {
          // Make an AJAX request to delete the nameStore from the database
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "add.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              console.log("name Store deleted: " + nameStore);
              // Redirect to addItem.php
              location.href = "addItem.php";
              
            }
          };
          xhr.send("nameStore=" + encodeURIComponent(nameStore));
        }
      }


      function deleteItem(itemName) {
        if (confirm("Are you sure you want to delete this item?")) {
          // Make an AJAX request to delete the item from the database
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "delete_item.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              console.log("Item deleted: " + itemName);
              // Refresh the page
              location.reload();
            }
          };
          xhr.send("itemName=" + encodeURIComponent(itemName));
        }
      }
      </script>


    <a  href="logout.php">Logout</a>
    <a  href="dashboard.php">Back to Dashboard</a>
  </div>
</body>
</html>