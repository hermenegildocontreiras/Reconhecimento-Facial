<?php
class Usuarios{
    private $conn;
    public $id;
    public $nome;
    public $senha;
  
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
        $query = "INSERT INTO usuarios values (null,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nome);
        $stmt->bindParam(2, $this->senha);
        if($stmt->execute()){
            return true;
        }
        return false;      
    }
    function readOne(){
        $query = "SELECT nome, senha FROM usuarios u WHERE nome = ? and senha = ? LIMIT 0,1";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->nome);
        $stmt->bindParam(2, $this->senha);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->nome = $row['nome'];
        $this->senha = $row['senha'];
    }
	function read(){
        $query = "SELECT idUsuario, nome FROM usuarios";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
		return $stmt;
    }
}
?>