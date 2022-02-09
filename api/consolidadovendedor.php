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
$id_vendedor = filter_input(INPUT_GET, 'id_vendedor', FILTER_SANITIZE_NUMBER_INT);
$response = "";

$query_vendedor = "SELECT 
                        vendas.id, 
                        tbl_vendedor.nome, 
                        tbl_vendedor.email, 
                        tbl_vendedor.id_vendedor, 
                        vendas.descricao_venda, 
                        vendas.comissao, 
                        vendas.valor_venda, 
                        vendas.data_venda 
                    FROM 
                        vendas 
                        INNER JOIN tbl_vendedor ON vendas.id_vendedor = tbl_vendedor.id_vendedor
                    WHERE 
                        tbl_vendedor.id_vendedor = :id_vendedor
                    LIMIT 1000
                    ";

$result_vendedor = $conn->prepare($query_vendedor);
$result_vendedor->bindParam(':id_vendedor', $id_vendedor, PDO::PARAM_INT);
$result_vendedor->execute();

if (($result_vendedor) and ($result_vendedor->rowCount() != 0)) {
    $row_vendedor = $result_vendedor->fetch(PDO::FETCH_ASSOC);
    extract($row_vendedor);

    $vendedor = [
        'id' => $id,
        'nome' => $nome,
        'email' => $email,
        'id_vendedor' => $id_vendedor,
        'descricao_venda' => $descricao_venda,
        'comissao' => $comissao,
        'valor_venda' => $valor_venda,
        'data_venda' => $data_venda
    ];

    $response = [
        "erro" => false,
        "vendedor" => $vendedor
    ];
} else {
    $response = [
        "erro" => true,
        "mensagem" => "Vendedor não foi encontrado através da API!"
    ];
}
http_response_code(200);
echo json_encode($response);
