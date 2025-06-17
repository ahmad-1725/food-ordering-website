<?php

    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'FD';

    $conn = new mysqli($server,$user,$pass,$db);

    if($conn->connect_error){
        die("Database connection failed");
    }

?>