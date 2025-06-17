<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
    <div class="container">
      <form action="../actions/create.php" method="post" >
        <h2>Create <span style="color: #FF6B35">Dish</span></h2>
    
        <input type="text" name="title" placeholder="Enter the title for dish" required />
        <input type="text" name="description" placeholder="Enter the description for dish" required />
        <input type="number" name="price" placeholder="Enter price for dish" step="0.01" required />
        <input type="file" name="image" id="img" required>
        <button type="submit" name="create_dish">Publish</button>
      </form>
    </div>
</body>
</html>
