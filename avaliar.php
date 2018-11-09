<?php

$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$banco = isset($filtro['nomebd']) ? $filtro['nomebd'] : null;
$idUsuario = isset($filtro['idUsuario']) ? $filtro['idUsuario'] : null;
$cnpj = isset($filtro['cnpj']) ? $filtro['cnpj'] : null;
$nota = isset($filtro['nota']) ? $filtro['nota'] : null;
$idSenha = isset($filtro['idSenha']) ? $filtro['idSenha'] : null;
$avaliacao = isset($filtro['avaliacao']) ? $filtro['avaliacao'] : null;
$dsn = "mysql:host=localhost;dbname=$banco;charset=utf8";
$dsn1 = "mysql:host=localhost;dbname=atendimentos_solutions;charset=utf8";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO($dsn, $usuario, $senha);
    $conexao1 = new PDO($dsn1, $usuario, $senha);
    
    $sql = 'INSERT INTO t_avaliacao (nota, t_cliente_cnpj, t_usuariosapp_id) VALUES (:NOTA, :CNPJ, :IDUSUARIO)';
    $stmt = $conexao1->prepare($sql);
    $stmt->bindParam(':NOTA', $nota);
    $stmt->bindParam(':CNPJ', $cnpj);
    $stmt->bindParam(':IDUSUARIO', $idUsuario);
    $stmt->execute();

    $sql2 = 'UPDATE t_senhas SET situacao = "Avaliada", avaliacao = :AVALIACAO WHERE id = :ID';
    $stmt1 = $conexao->prepare($sql2);
    $stmt1->bindParam(':ID', $idSenha);
    $stmt1->bindParam(':AVALIACAO', $avaliacao);
    $stmt1->execute();
    $retorno = array();

    if($stmt->rowCount() > 0){
        $retorno = array("avaliacao" => "sucesso");
    }else{
        $retorno = array("avaliacao" => "erro");
    }
 
    echo json_encode($retorno);

} catch (PDOException $e) {
    echo "conexao_erro";
    exit;
}