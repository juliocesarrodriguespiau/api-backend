<?php

// cabecalhos obrigatórios
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");

//incluir conexao
include_once 'conexao.php';

//$comissao = 71;
$id = filter_input(INPUT_GET, 'id_vendedor', FILTER_SANITIZE_NUMBER_INT);
$response = "";

$query_vendedor = "SELECT id_vendedor, nome, email FROM tbl_vendedor WHERE id_vendedor=:id_vendedor ORDER BY id_vendedor";
$result_vendedor = $conn->prepare($query_vendedor); 
$result_vendedor->bindParam(':id', $id, PDO::PARAM_INT);
$result_vendedor->execute();

if(($result_vendedor) AND ($result_vendedor->rowCount() != 0)) {
    $row_vendedor = $result_vendedor->fetch(PDO::FETCH_ASSOC);
    extract($row_vendedor);

    $vendedor = [
        'id_vendedor' => $id,
        'nome' => $nome,
        'email' => $email,
        'descricao_venda' => $descricao_venda,
        'comissao' => $comissao,
        'valor_venda' => $valor_venda,
        'data_venda' => $data_venda
    ];

    $response = [
        "erro" => false,
        "vendedor" => $vendedor
    ];
}else{
    $response = [
        "erro" => true,
        "mensagem" => "Vendedor não foi encontrado através da API!"
    ];
}
http_response_code(200);
echo json_encode($response);

