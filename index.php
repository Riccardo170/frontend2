<?php
$metodo = $_SERVER['REQUEST_METHOD'];

$servername = "172.17.0.1:3306";
$user = "root";
$pass = "ricca";
$db="mydb";
  
// Create connection
$conn = mysqli_connect($servername, $user, $pass, $db) or die("Connessione non riuscita". mysqli_connect_error());


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = ['id' => 10001, 'birthDate' => "1953-09-01", 'firstName' => 'Georgi', 'lastName' => 'Facello', 'gender' => 'M', 'hireDate' => '1986-06-25'];

if ($metodo === 'GET') {
    echo json_encode($data);
    $sql = "SELECT * from employees";
    $result = $conn->query($sql);
   
} else 
    if ($metodo === 'POST') {
    echo json_encode($data);
} else 
    if ($metodo === 'DELETE') {
    echo json_encode($data);
} else 
    if ($metodo === 'PUT') {
    echo json_encode($data);
}