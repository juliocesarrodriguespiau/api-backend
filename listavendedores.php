<?php
// cabecalhos obrigatórios
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1

header("Content-Type: application/json; charset=UTF-8");

//incluir conexao
include_once 'conexao.php';

$query = "SELECT id_vendedor, nome, email FROM tbl_vendedor ORDER BY id_vendedor";
$result = $conn->prepare($query);
$result->execute();

if(($result) AND ($result->rowCount() != 0)) {
    while($row_venda = $result->fetch(PDO::FETCH_ASSOC)) {
        //var_dump($row_vendedor);
        extract($row_venda);

        $lista_vendedores["records"][$id_vendedor] = [
            'id_vendedor' => $id_vendedor,
            'nome' => $nome,
            'email' => $email
        ];
    }
    //reposta com status 200
    http_response_code(200);

    //retornar os vendedores em json
    echo json_encode($lista_vendedores);

}

