<?php
$metodo = $_SERVER['REQUEST_METHOD'];

$servername = "172.17.0.1:3306";
    $user = "root";
    $pass = "ricca";
    $db="mydb";
  
    // Create connection
    $conn = mysqli_connect($servername, $user, $pass, $db) or die("Connessione non riuscita". mysqli_connect_error());

  
    if ($metodo == "GET"){
    
   echo "riccabello";

  }
    if ($metodo == "POST"){
    
    echo "Sì, mi è arrivata un POST!";
  }
    if ($metodo == "PUT"){
    
    echo "Sì, mi è arrivata un PUT!";
  }
    if ($metodo == "DELETE"){
    
    echo "Sì, mi è arrivata una DELETE!";
  }
        
?>