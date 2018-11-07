<?php

$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$banco = isset($filtro['nomebd']) ? $filtro['nomebd'] : null;
$idSenha = isset($filtro['idSenha']) ? $filtro['idSenha'] : null;
$dsn = "mysql:host=localhost;dbname=$banco;charset=utf8";
$usuario = "root";
$senha = "";

$conexao = new PDO($dsn, $usuario, $senha);

try {
    $conexao = new PDO($dsn, $usuario, $senha);

    $sql2 = 'UPDATE t_senhas SET situacao = "Não Avaliada" WHERE id = :ID';
    $stmt1 = $conexao->prepare($sql2);
    $stmt1->bindParam(':ID', $idSenha);
    $stmt1->execute();
    $retorno = array();

    if($stmt1->rowCount() > 0){
        $retorno = array("avaliacao" => "sucesso");
    }else{
        $retorno = array("avaliacao" => "erro");
    }

    echo json_encode($retorno);

} catch (PDOException $e) {
    echo "conexao_erro";
    exit;
}