<?php
$metodo = $_SERVER['REQUEST_METHOD'];
$index="http://localhost:8081/frontend2/index.php";
$servername = "172.17.0.1:3307";
$user = "root";
$pass = "ricca";
$db="mydb";
  
// Create connection
$conn =  mysqli_connect($servername, $user, $pass, $db) or die("Connessione non riuscita". mysqli_connect_error());


if ($metodo == "POST"){

  $start=$_POST['start'];
  $lenght=$_POST['length'];
  $cerca=$_POST['search']['value'];
  $ord=$_POST['order']['0']['dir'];
  $num=$_POST['order']['0']['column'];
  
  $num=$num + 1;
  $a = array();
  $Selectall = "SELECT * FROM employees WHERE id like '%{$cerca}%' 
  OR birth_date like '%{$cerca}%' 
  OR first_name like '%{$cerca}%'
  OR last_name like '%{$cerca}%'
  OR gender like '%{$cerca}%'
  OR hire_date like '%{$cerca}%' order by {$num} {$ord} limit {$start},{$lenght}"; //select 
  $Selectallr = mysqli_query ($conn, $Selectall) or //risultato
  die ("Query fallita 0 " . mysqli_error($conn) . " " . mysqli_errno($conn));
 
  $count = "SELECT count(id) FROM employees  "; //select 
  $countr = mysqli_query ($conn, $count) or //risultato
  die ("Query fallita 0 " . mysqli_error($conn) . " " . mysqli_errno($conn));
 
  $countf = "SELECT count(id) FROM employees WHERE id like '%{$cerca}%' 
  OR birth_date like '%{$cerca}%' 
  OR first_name like '%{$cerca}%'
  OR last_name like '%{$cerca}%'
  OR gender like '%{$cerca}%'
  OR hire_date like '%{$cerca}%'
  "; //select 
  $countfr = mysqli_query ($conn, $countf) or //risultato
  die ("Query fallita 0 " . mysqli_error($conn) . " " . mysqli_errno($conn));




while ($row = mysqli_fetch_array ($countr, MYSQLI_NUM)) 
{
$a['recordsTotal']=$row['0'];
}

while ($rowi = mysqli_fetch_array ($countfr, MYSQLI_NUM)) 
{
$a['recordsFiltered']=$rowi['0'];
}



  $a["data"]=array();
  while ($row = mysqli_fetch_array ($Selectallr, MYSQLI_NUM)) 
  {
 $dipendente=array(
 
    "id"=>$row['0'],
  "birth_date"=>$row['1'],
  "first_name"=>$row['2'],
  "last_name"=>$row['3'],
  "gender"=>$row['4'],
  "hire_date"=>$row['5']
 );
 array_push($a["data"], $dipendente);
  }

  echo json_encode($a);




}

?>    