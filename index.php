<?php
// cabecalhos obrigatórios
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1

header("Content-Type: application/json; charset=UTF-8");

//incluir conexao
include_once 'conexao.php';

$query = "SELECT id, nome, email, id_vendedor, descricao_venda, comissao, valor_venda, data_venda FROM vendas ORDER BY id";
$result = $conn->prepare($query);
$result->execute();

if(($result) AND ($result->rowCount() != 0)) {
    while($row_venda = $result->fetch(PDO::FETCH_ASSOC)) {
        //var_dump($row_vendedor);
        extract($row_venda);

        $lista_vendas["records"][$id] = [
            'id' => $id,
            'nome' => $nome,
            'email' => $email,
            'id_vendedor' => $id_vendedor,
            'descricao_venda' => $descricao_venda,
            'comissao' => $comissao,
            'valor_venda' => $valor_venda,
            'data_venda' => $data_venda
        ];
    }
    //reposta com status 200
    http_response_code(200);

    //retornar os vendedores em json
    echo json_encode($lista_vendas);

}

