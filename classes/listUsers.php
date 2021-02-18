<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
include_once './ConDB.php';
include_once './Usuario.php';
  
$database = new Database();
$db = $database->getConnection();
  
$usuarios = new Usuarios($db);
  
$stmt = $usuarios->read();
$num = $stmt->rowCount();
  
if($num>0){
  
    $usuarios_arr=array();
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        array_push($usuarios_arr, $nome);
    }
  
    http_response_code(200);
  
    echo json_encode($usuarios_arr);
}
  
else{
  
    http_response_code(404);
  
    echo json_encode(
        array("message" => "No products found.")
    );
}