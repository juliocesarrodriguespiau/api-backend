<?php

// cabecalhos obrigatórios
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");

//incluir conexao
include_once 'conexao.php';

$reponse_json = file_get_contents("php://input");
$dados = json_decode($reponse_json, true);

if($dados) {

    $query_vendedor = "INSERT INTO vendedores (nome, email) VALUES (:nome, :email)";
    $cad_vendedor = $conn->prepare($query_vendedor);

    $cad_vendedor->bindParam(':nome', $dados['vendedor']['nome'], PDO::PARAM_STR);
    $cad_vendedor->bindParam(':email', $dados['vendedor']['email'], PDO::PARAM_STR);

    $cad_vendedor->execute();

    if($cad_vendedor->rowCount()) {
        $response = [
            "erro" => false,
            "mensagem" => "Vendedor Cadastrado no DB via API com Sucesso!"
        ];
    }else{
        $response = [
            "erro" => true,
            "mensagem" => "Vendedor não Cadastrado através da API!"
        ];
    }
    
} else {
    $response = [
        "erro" => true,
        "mensagem" => "Vendedor não Cadastrado!"
    ];
}

http_response_code(200);
echo json_encode($response);


