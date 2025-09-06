<?php
    $servername = 'localhost';
    $username = 'root';
    $password = 'password';
    $dbname = 'sme_db';
    
    //Create Database Connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
    }
      
    $conn->query($conn, "SET NAMES 'utf8' ");
?>