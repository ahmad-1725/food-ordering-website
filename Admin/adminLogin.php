<?php
  include_once '../actions/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <style>
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'calibri';
      }
    body{
      height: 100vmin;
      width: 100%;
    }
    .nav-box {
      width: 100%;
      background-color:#1A535C;
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
      color:#F7FFF7;
      font-weight: bold;
      font-size: 28px;
      letter-spacing: 1px;
    }
    
    #h1-name span {
      color: #FF6B35;
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
      color:#F7FFF7;
      transition: all 0.3s ease;
    }
    #nav-list li a{
      color:#F7FFF7;
      text-decoration: none;
      transition: all 0.3s ease;

    }
    #nav-list a:hover {
      color: #FF6B35;
    }
    #nav-list li:hover {
      color: #FF6B35;
    }
    .container{
      background-color:beige;
      width:100%;
      height: 88vmin;
      justify-items: center;
      align-content:center;
    }
    .container form{
      background-color: #4ECDC4;
      color: rgb(60, 60, 60);
      font-weight: bold;
      width: 50vmin;
      height: 50vmin;
      text-align:center;
      align-content:center;
      box-shadow: 0 0 1vmin rgba(0,0,0,0.5);
      border-radius: .7rem;
    }
    .container form input{
      padding: 3px 10px;
      border-radius: .5rem;
      border: none;
      margin: 2vmin;
      outline:none;
      box-shadow: 0 0 1vmin rgba(0,0,0,0.3);
    }
    .container form input:focus{
      outline: 1px solid black;
    }
    .container form h1{
      position: relative;
      top: -2vmin;
      padding: 7px 0px;
    }
    #btn{
      cursor:pointer;
      background-color:#FF6B35;
      color: #FFF3E0;
      position: relative;
      bottom:-3vmin;
      padding: 1vmin 5vmin;
      font-weight: bold;
      transition: all ease 0.3s;
    }
    #btn:hover{
      background-color:#FF5E00;
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
          <li><a href="../home.php">Home</a></li>
          <li><a href="adminLogin.php">Admin</a></li>
          <li>About Us</li>
        </ul>
      </div>
    </div>
    <div class="container">
      <form action="login.php" method="POST">
        <h1 class="form-title">Admin Login</h1>
        Username: 
        <input type="text" name="username" id="username" required><br>
        Password: 
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Login" name="login" id="btn">
      </form>
    </div>
</body>
</html>