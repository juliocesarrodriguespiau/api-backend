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

    $query = "INSERT INTO tbl_vendedor (nome, email, id_vendedor) VALUES (:nome, :email, :id_vendedor)";
    $cad_venda = $conn->prepare($query);

    $cad_venda->bindParam(':nome', $dados['vendedor']['nome'], PDO::PARAM_STR);
    $cad_venda->bindParam(':email', $dados['vendedor']['email'], PDO::PARAM_STR);
    $cad_venda->bindParam(':id_vendedor', $dados['vendedor']['id_vendedor'], PDO::PARAM_STR);
    // $cad_venda->bindParam(':descricao_venda', $dados['vendedor']['descricao_venda'], PDO::PARAM_STR);
    // $cad_venda->bindParam(':comissao', $dados['vendedor']['comissao'], PDO::PARAM_STR);
    // $cad_venda->bindParam(':valor_venda', $dados['vendedor']['valor_venda'], PDO::PARAM_STR);
    // $cad_venda->bindParam(':data_venda', $dados['vendedor']['data_venda'], PDO::PARAM_STR);

    $cad_venda->execute();

    if($cad_venda->rowCount()) {
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


