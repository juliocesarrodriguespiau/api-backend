<?php
// cabecalhos obrigatórios
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1

header("Content-Type: application/json; charset=UTF-8");

//incluir conexao
include_once 'conexao.php';

$query_vendedores = "SELECT id, nome, email FROM vendedores ORDER BY id";
$result_vendedores = $conn->prepare($query_vendedores);
$result_vendedores->execute();

if(($result_vendedores) AND ($result_vendedores->rowCount() != 0)) {
    while($row_vendedor = $result_vendedores->fetch(PDO::FETCH_ASSOC)) {
        //var_dump($row_vendedor);
        extract($row_vendedor);

        $lista_vendedores["records"][$id] = [
            'id' => $id,
            'nome' => $nome,
            'email' => $email,
        ];
    }
    //reposta com status 200
    http_response_code(200);

    //retornar os vendedores em json
    echo json_encode($lista_vendedores);

}

