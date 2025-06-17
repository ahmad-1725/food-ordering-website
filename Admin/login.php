<?php
  include_once '../actions/connect.php';
  
  if( $_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['login']) ){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = $conn->prepare("SELECT * from admin WHERE username=?");
    $query->bind_param('s',$username);
    $query->execute();

    $res =  $query->get_result();

    if($res && $res->num_rows === 1){
      $admin = $res->fetch_assoc();

      if(hash('sha256',$password) === $admin['password']){
        session_start();
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;

        echo "<script>alert('Login Successful');  window.location='dashboard.php';</script>";
        exit();
      }else{
        echo "<script> alert('Incorrect Password'); </script>";
      }
    }else{
      echo "<script> alert('User not found'); </script>";
    }
    $query->close();
  }else{
    echo "<script>alert('Error');</script>";
  }
?>