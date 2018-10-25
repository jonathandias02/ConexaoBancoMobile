<?php

$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$banco = isset($filtro['nomebd']) ? $filtro['nomebd'] : null;
$idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;
$dsn = "mysql:host=localhost;dbname=$banco;charset=utf8";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO($dsn, $usuario, $senha);
    
    $sql = 'SELECT id, nomeServico, sigla FROM t_servicos WHERE t_filas_id = :IDFILA AND deletar = 0';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':IDFILA', $idFila);
    $stmt->execute();
    $servicos = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    echo json_encode($servicos);
    
} catch (PDOException $e) {
    echo "conexao_erro";
    exit;
}