<?php
  include_once '../actions/connect.php';

  session_start();
  session_unset();
  session_destroy();
  Header("Location: adminLogin.php");
  exit();
?>