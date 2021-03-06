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


if ($dados) {

    // Função cálculo de comissão: base de 8.5%
    function comissao($valor_venda)
    {
        return (8.5 / 100) * $valor_venda;
    }

    $query = "INSERT INTO vendas (nome, email, id_vendedor, descricao_venda, comissao, valor_venda, data_venda) VALUES (:nome, :email, :id_vendedor, :descricao_venda, :comissao, :valor_venda, :data_venda)";
    $cad_venda = $conn->prepare($query);

    $cad_venda->bindParam(':nome', $dados['vendedor']['nome'], PDO::PARAM_STR);
    $cad_venda->bindParam(':email', $dados['vendedor']['email'], PDO::PARAM_STR);
    $cad_venda->bindParam(':id_vendedor', $dados['vendedor']['id_vendedor'], PDO::PARAM_STR);
    $cad_venda->bindParam(':descricao_venda', $dados['vendedor']['descricao_venda'], PDO::PARAM_STR);
    $cad_venda->bindParam(':comissao', comissao($dados['vendedor']['valor_venda']), PDO::PARAM_STR);
    $cad_venda->bindParam(':valor_venda', $dados['vendedor']['valor_venda'], PDO::PARAM_STR);
    $cad_venda->bindParam(':data_venda', $dados['vendedor']['data_venda'], PDO::PARAM_STR);

    $cad_venda->execute();

    if ($cad_venda->rowCount()) {
        $response = [
            "erro" => false,
            "mensagem" => "Venda Cadastrada no DB via API com Sucesso!"
        ];
    } else {
        $response = [
            "erro" => true,
            "mensagem" => "Venda não Cadastrada através da API!"
        ];
    }
} else {
    $response = [
        "erro" => true,
        "mensagem" => "Venda não Cadastrada!"
    ];
}

http_response_code(200);
echo json_encode($response);
