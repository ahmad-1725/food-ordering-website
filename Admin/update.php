<?php
// Include the DB connection
include '../actions/connect.php';

// Fetch the dish ID from URL
   if($_SERVER['REQUEST_METHOD'] === "GET"){
      $id = trim($_GET['id']);
      
      // Query to fetch the details of the dish to edit
      $query = $conn->prepare('SELECT * FROM menu_items WHERE id = ?');
      $query->bind_param("i", $id);
      $query->execute();
      $res = $query->get_result();
      if($res->num_rows ===1 ){        
         // Fetch the dish details into an associative array
         $dish = $res->fetch_assoc();
      }else{
         echo "Error";
      }
      // Get the result of the query
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish Dish</title>
   <link rel="stylesheet" href="../nav.css">
    <style>
    * {
      box-sizing: border-box; /* ✅ fixed */
      padding: 0;
      margin: 0;
      font-family: 'calibri';
    }
    body {
      height: 100vh;
      width: 100%;
      background: #f9f9f9;
      overflow-y: hidden;
    }
    .container{
      justify-items: center;
      align-content: center;
      height: 80%;
    }
    #nav-list{
      justify-content: space-around ;
    }
    .nav-box{
      box-shadow: 0 0 1.5vmin rgba(0,0,0,0.5);
    }
    #web-name{
      margin-top: 10px;
    }
    .container{
      justify-items: center;
      align-content: center;
      height: 80%;
    }
    form {
      max-width: 700px;
      width: 100%;
      padding: 20px;
      background: white;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    input {
      padding: 10px 13px;
      font-size: 16px;
    }
    button {
      color: white;
      padding: 10px;
      font-size: 18px;
      background: #FF6B35;
      border-radius: 4px;
      border: none;
      cursor: pointer;
    }
    h2 {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
    <div class="nav-box">
      <div id="web-name">
        <h2 id="h1-name">Food<span>hot</span></h2>
      </div>
      <div id="nav-content">
        <ul id="nav-list">
          <li><a href="dashboard.php">Admin</a></li>
          <li><a href="logout.php">LogOut</a></li>      
        </ul>
      </div>
    </div>
    <!-- Update form -->
     <div class="container">
         <form action="../actions/update.php" method="POST">
            <h2 style="width: fit-content; padding: 8px 13px;">Food <span style="color: #FF6B35">Hot</span></h2>
            <input type="text" placeholder="Enter the title for dish" value="<?= htmlspecialchars($dish['title']) ?>" name="title" required>
            <input type="text" placeholder="Enter the description for dish" value="<?= htmlspecialchars($dish['description']) ?>" name="description" required>
            <input type="number" placeholder="Enter price for dish" value="<?= htmlspecialchars($dish['price']) ?>" name="price" required>
            <input type="file" name="image" id="img" value="../assets/images/<?= htmlspecialchars($row['img']); ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>" >
            <button type="submit" name="update_dish">Update Dish</button>
         </form>
     </div>
</body>
</html>
