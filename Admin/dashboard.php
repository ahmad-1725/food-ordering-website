<?php
    session_start();
    include_once '../actions/connect.php';

    if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
        header("Location: adminLogin.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../nav.css">
    <style>
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #FFF3E0;
            --accent-color: #4ECDC4;
            --dark-color: #1A535C;
            --light-color: #F7FFF7;
            }
        *{
            font-family: 'calibri';
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            height: 100%;
            width: 100%;
        }
        button{
            width: 100%;
            padding: 3px 8px;
            border-radius: 3px;
            outline: none;
            border: none;
            cursor: pointer;
        }
        #nav-list{
            justify-content:flex-end ;
        }
        .nav-box{
            box-shadow: 0 0 1.5vmin rgba(0,0,0,0.5);
        }
        .sidebar{
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding:8px 13px;
            border-right:1px solid black;
            width: 20%;
            height: 100vh;
            background-color:beige;
        }
        .container{
            justify-content:center;
            width: 80%;
            height: 100vh;
            gap: 1vmin;
            display:flex;
            flex-wrap:wrap;
        }
        .sidebar a{
            color: rgb(60, 60, 60);
            text-decoration: none;
            margin-left:3vmin;
            margin-top: 4vmin;
            text-transform: capitalize;
            font-size: larger;
            transition: all ease 0.1s;
        }
        .sidebar a:hover{
            color: var(--primary-color);
        }
        section{
            display: flex;
            align-items: start;
        }
        .card{
            margin-top:3vmin;
            box-shadow: 0 0 1vmin rgba(0, 0, 0, 0.2);
            color: rgb(60, 60, 60);
            border-radius: 5px;
            height: fit-content;
            width: 40vmin;
            padding: 8px;
            background-color: var(--secondary-color);
        }
        #title{
            padding:10px 0;
            text-align: center;
        }
        #description{
            padding: 10px 5px;
            text-align: center;
        }
        #price{
            padding: 10px 5px;
            text-align: center;
        }
        #img-div{
            width: 100%;
            height: 20vmin;
            background-color:red;
        }
        #img-div img{
            width: 100%;
            height:100%;
            object-fit: cover;
        }
        .action-buttons{
            display: flex;
            align-items: start;
            justify-content:space-evenly;
            gap: 3px;
            padding: 10px 0;
        }
        #edit-btn{
            background-color: rgba(0, 128, 0, 0.705); 
        }
        #delete-btn{
            background-color: rgba(255, 0, 0, 0.712); 
        }        
        #edit-btn, #delete-btn{
            box-shadow: 0 0 1vmin rgba(0, 0, 0, 0.2);
            color: white;
            padding: 1vmin 3vmin;
            border-radius: 0.25rem;
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
          <li><a href="logout.php">LogOut</a></li>
        </ul>
      </div>
    </div>
    <section>
        <div class="sidebar" >
            <a href="logout.php">Home</a>
            <a href="publish.php">create dish</a>
            <a href="/dashboard/cart">cart</a>
        </div>
        <div class="container">
        <?php
            $query = $conn->prepare('SELECT * FROM menu_items');
            $query->execute();
            $res = $query->get_result();
        if($res->num_rows > 0 ){
            while ($row = $res->fetch_assoc()) {
        ?>
            <div class="card">
                <div style="display: flex; gap: 5px; flex-direction: column;">
                    <div id="img-div">
                        <img id="img" src="../assets/images/<?= htmlspecialchars($row['img']); ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                    </div>
                    <h2 id="title" ><?= htmlspecialchars($row['title']) ?></h2>
                    <p id="description"><?= htmlspecialchars($row['description']); ?> </p>
                    <p id="price" >Price= Rs.<?= htmlspecialchars($row['price']) ?></p>
                    <div class="action-buttons">
                        <form action="update.php" method="GET" >
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type='submit' id="edit-btn">Edit</button>
                        </form>
                        <form action="delete.php" method="post">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type='submit' id="delete-btn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
            }
        }else{
        ?>
            <div>No items in menu to show</div>
        <?php
        }
        ?>

        </div>
    </section>

    
</body>
</html>