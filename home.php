<?php
 include_once "actions/connect.php";

 // display menu
 $stmt = $conn->prepare("SELECT * FROM menu_items");
  if($stmt){
    $stmt->execute();
    $res = $stmt->get_result();
    
    if($res && $res->num_rows === 0){
      $res = NULL;
    }
  }
  else{
    echo "Query Failed";
  }
  $stmt->close();

  // add to cart
  if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addCart']) && isset($_POST['item_id'])){
    $id = intval($_POST['item_id']);

    $stmt = $conn->prepare("SELECT id FROM menu_items WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();

    $query = $stmt->get_result();
    if($query && $query->num_rows > 0){

      $check = $conn->prepare("SELECT quantity FROM cart WHERE menu_item_id =?");
      $check->bind_param('i', $id);
      $check->execute();
      $var = $check->get_result();

      // if iteam already exists in cart
      if($var->num_rows > 0){

        $stmt = $conn->prepare("UPDATE cart SET quantity= quantity+1 WHERE menu_item_id=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
      }else{
      // if item is added for the first time
        $stmt = $conn->prepare("INSERT INTO cart (menu_item_id, quantity) VALUES (?,1)");
        $stmt->bind_param('i',$id);
        $stmt->execute();
      }
      echo "<script> alert('Item added to card'); </script>";
      header('location: home.php');
      $stmt->close();
    }else{
      echo "<script>alert('Invalid item ID.');</script>";
    }
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- <link rel="stylesheet" href="nav.css"> -->
  <style>
  :root {
      --primary-color: #FF6B35;
      --secondary-color: #FFF3E0;
      --accent-color: #4ECDC4;
      --dark-color: #1A535C;
      --light-color: #F7FFF7;
    }
   *{
      /* font-family: 'calibri'; */
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body{
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100%;
      width: 100%;
      background-color: var(--light-color);
      color: #333;
      overflow-x: hidden;
    }
    .main{
      width:90%;
      margin: 0 auto;

    }
    .nav-box {
      width: 100%;
      background-color: var(--dark-color);
      display: flex;
      height: 70px;
      align-items: center;
      padding: 0 20px;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    #web-name {
      cursor: default;
      width: 30%;
      display: flex;
      align-items: center;
    }
    
    #h1-name {
      color: var(--light-color);
      font-weight: bold;
      font-size: 28px;
      letter-spacing: 1px;
    }
    
    #h1-name span {
      color: var(--primary-color);
    }

    #nav-content {
      display: flex;
      align-items: center;
      width: 70%;
      height: auto;
    }
    #nav-list {
      list-style: none;
      display: flex;
      width: 100%;
      justify-content: space-around;
      margin-right: 10px;
    }

    #nav-list li {
      position: relative;
      cursor: pointer;
      padding: 8px 12px;
      font-weight: 500;
      color: var(--light-color);
      transition: all 0.1s ease;
    }
    #nav-list li a{
      color:#F7FFF7;
      text-decoration: none;
      transition: all 0.1s ease;
    }
    #nav-list a:hover {
      color: var(--primary-color);
    }
    #nav-list li:hover {
      color: var(--primary-color);
    }
    .sec-2 {
  padding: 60px 20px;
  text-align: center;
  background-color: white;
  margin-top: 30px;
  border-radius: 15px;
  position: relative;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

/* Section 2 background elements */
.sec-2::before {
  content: '';
  position: absolute;
  top: -50px;
  left: -50px;
  width: 200px;
  height: 200px;
  background: linear-gradient(135deg, var(--accent-color) 0%, transparent 70%);
  border-radius: 50%;
  opacity: 0.1;
  z-index: 0;
}

.sec-2::after {
  content: '';
  position: absolute;
  bottom: -50px;
  right: -50px;
  width: 200px;
  height: 200px;
  background: linear-gradient(315deg, var(--primary-color) 0%, transparent 70%);
  border-radius: 50%;
  opacity: 0.1;
  z-index: 0;
}

.sec-2 h2 {
  font-size: 2.5rem;
  margin-bottom: 40px;
  color: var(--dark-color);
  position: relative;
  display: inline-block;
  z-index: 1;
}

.sec-2 h2:after {
  content: '';
  position: absolute;
  width: 60px;
  height: 4px;
  background-color: var(--primary-color);
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
}

.steps {
  display: flex;
  justify-content: space-evenly;
  align-items: stretch;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 30px;
  position: relative;
  z-index: 1;
}

.box {
  width: 280px;
  background-color: white;
  border-radius: 12px;
  padding: 30px 20px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  position: relative;
  border: 1px solid #eee;
}

.box:hover {
  transform: translateY(-10px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.box .icon {
  width: 70px;
  height: 70px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--secondary-color);
  border-radius: 50%;
  margin-bottom: 20px;
  color: var(--primary-color);
  font-size: 28px;
}

.box h3 {
  font-size: 20px;
  margin-bottom: 15px;
  color: var(--dark-color);
}

.box p {
  color: #666;
  line-height: 1.5;
}

.number-badge {
  position: absolute;
  top: -15px;
  left: -15px;
  width: 36px;
  height: 36px;
  background-color: var(--primary-color);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 18px;
}
    .container {
      justify-content:center;
      background-color: var(--secondary-color);
      width: 100%;
      margin-top: 15px;
      height: 100vh;
      border-radius: 1rem;
      position: relative;
      gap: 5vmin;
      display:flex;
      flex-wrap:wrap;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    .container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: 
        linear-gradient(45deg, var(--primary-color) 25%, transparent 25%),
        linear-gradient(-45deg, var(--primary-color) 25%, transparent 25%),
        linear-gradient(45deg, transparent 75%, var(--primary-color) 75%),
        linear-gradient(-45deg, transparent 75%, var(--primary-color) 75%);
      background-size: 20px 20px;
      opacity: 0.03;
      z-index: 0;
    }
    #container-title {
      width: 100%;
      text-align: center;
      font-size: 2.5rem;
      margin-top: 10vmin;
      margin-bottom: -10vmin;
      color: var(--dark-color);
      position: relative;
    }
    #container-title:after {
      content: '';
      position: absolute;
      width: 60px;
      height: 4px;
      background-color: var(--primary-color);
      top: 10vmin;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
    }
    .card{
      background-color: white;
      margin-top:;
      border-radius: 1rem;
      height: fit-content;
      width: 40vmin;
      color: rgb(60, 60, 60);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      position: relative;
      }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    #img-div{
      width: 100%;
      height: 20vmin;
    }
    #img-div img{
      border-radius: 1rem;
      width: 100%;
      height:100%;
      object-fit: cover;
    }
    .card-content{
      padding: 20px;
      text-align: left;
    }
    #title{
      font-size: 20px;
      color: var(--dark-color);
    }
    #description{
      color: #666;
      font-weight: 400;
      font-size: 14px;
      padding: 10px 0;
    }
    #price{
      font-weight: bold;
      color: var(--primary-color);
    }
    .action-buttons{
      display: flex;
      align-items: start;
      justify-content:space-evenly;
      gap: 3px;
      height: fit-content;
      position: relative;
      top:-4vmin;
    }
    #cart-btn{
      background-color: var(--primary-color); 
      box-shadow: 0 0 1vmin rgba(0, 0, 0, 0.2);
      color: white;
      border:none;
      width: 80px;
      padding: 8px 16px;
      border-radius: 20px;
      cursor: pointer;
      font-weight: 500;
      text-align: right;
      transition: all 0.3s ease;
      display: flex;
      gap: 5px;
    }
    #cart-btn:hover {
      background-color: #ff5722;
    }
    #icon{
      position: relative;
      color: white;
      top: 25px;
      font-weight: lighter;
      left: 14px;
      cursor: pointer;
    }
    footer {
      background-color: var(--dark-color);
      color: var(--light-color);
      padding: 40px 20px;
      text-align: center;
      margin-top: 40px !important;
      margin: 0 auto;
      width: 90%;
      position: relative;
      overflow: hidden;
    }

    /* Footer background pattern */
    footer::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: repeating-linear-gradient(
        45deg,
        rgba(255, 255, 255, 0.05),
        rgba(255, 255, 255, 0.05) 10px,
        transparent 10px,
        transparent 20px
      );
      z-index: 0;
    }

    footer h2 {
      position: relative;
      z-index: 1;
    }

    footer p {
      margin-top: 20px;
      font-size: 14px;
      opacity: 0.8;
      position: relative;
      z-index: 1;
    }


  </style>
</head>
<body>
  <div class="main">
    <div class="nav-box">
      <div id="web-name">
        <h2 id="h1-name">Food<span>hot</span></h2>
      </div>
      <div id="nav-content">
        <ul id="nav-list">
          <li><a href="home.php">Home</a></li>
          <li><a href="admin/adminLogin.php">Admin</a></li>
          <li>About Us</li>
        </ul>
      </div>
    </div>
    <div class="sec-2">
      <h2 class="reveal reveal-bottom">Order in 3 Simple Steps</h2>
      <div class="steps">
        <div class="box reveal reveal-left">
          <div class="number-badge">1</div>
          <div class="icon">
            <i class="fas fa-utensils"></i>
          </div>
          <h3>Choose a Menu</h3>
          <p>Browse through our extensive collection of homemade specialties from local family chefs.</p>
        </div>
        <div class="box reveal reveal-bottom">
          <div class="number-badge">2</div>
          <div class="icon">
            <i class="fas fa-clipboard-check"></i>
          </div>
          <h3>Place your Order</h3>
          <p>Select your favorite dishes, customize as needed, and complete your order in just a few clicks.</p>
        </div>
        <div class="box reveal reveal-right">
          <div class="number-badge">3</div>
          <div class="icon">
            <i class="fas fa-smile"></i>
          </div>
          <h3>Enjoy Food</h3>
          <p>Sit back and relax while we deliver fresh, homemade goodness right to your doorstep.</p>
        </div>
      </div>
    </div>
    
    <div class="container"> <!-- offer container/div -->
      <?php if(!$res): ?>
        <p>No items available</p>
      </body>
      </html>
      <?php endif; ?>
      
      <h2 id="container-title">Menu</h2>
      <?php
      if($res):
        while($row = $res->fetch_assoc()){
      ?>
          <div class="card"> <!-- offer content -->
              <div style="display: flex; gap: 5px; flex-direction: column;">
                <div id="img-div">
                  <img id="img" src="assets/images/<?= htmlspecialchars($row['img']); ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                </div>
                <div class="card-content">
                  <h2 id="title" ><?= htmlspecialchars($row['title']) ?></h2>
                  <p id="description"><?= htmlspecialchars($row['description']); ?> </p>
                  <p id="price" >Rs.<?= htmlspecialchars($row['price']) ?></p>
                </div>
              </div>
            <div class="action-buttons"> <!-- offer footer -->
              <form action="home.php" method="post">
                <input type="hidden" name="item_id" value="<?= htmlspecialchars($row['id']) ?>" hidden>
                <i class="fas fa-plus" id="icon"></i>
                <input type="submit" id="cart-btn" value="Add" name="addCart">
              </form>
            </div>
          </div>
      <?php
        }
      endif;
      ?>
    </div>
    </div>
    <footer class="">
    <h2 id="h1-name">Food<span>hot</span></h2>
    <p>&copy; 2025 Foodhot. All rights reserved. Connecting hungry people with amazing home chefs.</p>
  </footer>

</body>
</html>