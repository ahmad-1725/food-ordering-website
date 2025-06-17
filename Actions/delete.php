<?php

    include('./connection.php');

    $query = $conn->prepare('delete from dishes where id = ?');
    $id = $_GET['id'];
    $query->bind_param('i',$id);
    
   $res= $query->execute();
   if(!$res){
     die("DELTETION FAILED");
   }

?>