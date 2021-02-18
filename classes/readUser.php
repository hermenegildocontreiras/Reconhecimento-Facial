<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
include_once './ConDB.php';
include_once './Usuario.php';
  
$database = new Database();
$db = $database->getConnection();
  
$usuarios = new Usuarios($db);

$data = json_decode(file_get_contents("php://input"));
$usuarios->nome = $data->nome;
$usuarios->senha = $data->senha;
  
$usuarios->readOne();
  
if($usuarios->nome!=null){
    $usuarios_arr = array(
        "nome" =>  $usuarios->nome,
    );
  
    http_response_code(200);
  
    echo json_encode($usuarios_arr);
}
  
else{
    http_response_code(404);
  
    echo json_encode(array("message" => "Incorrecto"));
}
?>