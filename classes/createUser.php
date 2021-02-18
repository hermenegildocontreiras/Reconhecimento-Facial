<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
include_once './ConDB.php';
  
include_once './Usuario.php';
  
$database = new Database();
$db = $database->getConnection();
  
$usuarios = new Usuarios($db);
  
$data = json_decode(file_get_contents("php://input"));
  
if(
    !empty($data->nome) &&
    !empty($data->senha)
){
    $usuarios->nome = $data->nome;
    $usuarios->senha = $data->senha;
  
    if($usuarios->create()){
        $usuarios_arr = array(
            "nome" =>  $usuarios->nome,
        );
        http_response_code(201);
        echo json_encode(array($usuarios_arr));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Impossível criar usuário."));
    }
}
  
else{
    http_response_code(400);
    echo json_encode(array("message" => "Dados Incompletos para criar usuário."));
}
?>