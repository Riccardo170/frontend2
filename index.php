<?php
$metodo = $_SERVER['REQUEST_METHOD'];
$index="http://localhost:8081/backrest/index.php";
$servername = "172.17.0.1:3307";
$user = "root";
$pass = "ricca";
$db="mydb";
  
// Create connection
$conn =  mysqli_connect($servername, $user, $pass, $db) or die("Connessione non riuscita". mysqli_connect_error());



if ($metodo === 'GET') {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $page=$_GET['page'];
    $size=$_GET['size'];
    $sql = "SELECT id,birth_date,first_name,last_name, gender,hire_date from employees limit ".$page*$size.",".$size;
    $result = mysqli_query ($conn, $sql) or //risultato
    die ("Query fallita " . mysqli_error($conn) . " " . mysqli_errno($conn));
    $employees=array();
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM)){
      array_push($employees, array("id"=>$row[0], "birthDate"=>$row[1], "firstName"=>$row[2], "lastName"=>$row[3], "gender"=>$row[4], "hireDate"=>$row[5], 
                  'links_' =>array( 'self'=>array('href'=>$index."?id=".$row[0]), 
                              'employee'=>array('href'=>$index."?id=".$row[0]))
                )); 
    }
    $imp=array();
    $imp['_embedded']['employees']=$employees;
    $sql = "SELECT count(id) as count from employees";
    $result = mysqli_query ($conn, $sql) or //risultato
    die ("Query fallita " . mysqli_error($conn) . " " . mysqli_errno($conn));
    $employees=array();
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM)){
        $tot=$row[0];
    }
    $links ['first']['href']='http://localhost:8081/backrest/index.php?page=0&size='.$size; 
    $links ['self']['href']=$index.'?page='.$page.'&size='.$size;
    $links ['next']['href']=$index.'?page='.($page+1).'&size='.$size;
    $links ['prev']['href']=$index.'?page='.($page-1).'&size='.$size;
    $links ['last']['href']=$index.'?page='.intval($tot/20).'&size='.$size;

    $pages = array('size'=>$size, 'totalElements'=>$tot, 'totalPages'=>intval($tot/20), 'number'=>intval($page));

    $imp['_links']=$links;
    $imp['page']=$pages;
    echo json_encode($imp,JSON_UNESCAPED_SLASHES);
    $sql = "SELECT * from employees";
    $result = $conn->query($sql);

   
} else 
if ($metodo == "POST"){
    $nome= $_GET['nome'];  
    $cognome= $_GET['cognome'];  
    $sql = "INSERT INTO employees (first_name, last_name) VALUES ('$nome','$cognome')";
    $result = mysqli_query ($conn, $sql) or die ("Query fallita " . mysqli_error($conn) . " " . mysqli_errno($conn));  
}
  if ($metodo == "PUT"){
    $id= $_GET['id'];  
    $nome= $_GET['nome'];  
    $cognome= $_GET['cognome'];  
    $sql = "UPDATE employees SET first_name = '$nome' , last_name= '$cognome' WHERE id = '$id'";
    $result = mysqli_query ($conn, $sql) or die ("Query fallita " . mysqli_error($conn) . " " . mysqli_errno($conn));  
}
  if ($metodo == "DELETE"){
  $id= $_GET['id'];         
$sql = " DELETE from employees where  id = ".$id;
$result = mysqli_query ($conn, $sql) or die ("Query fallita " . mysqli_error($conn) . " " . mysqli_errno($conn));  
}