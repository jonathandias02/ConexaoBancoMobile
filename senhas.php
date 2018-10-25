<?php

$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$banco = isset($filtro['nomebd']) ? $filtro['nomebd'] : null;
$idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;
$email = isset($filtro['email']) ? $filtro['email'] : null;
$dsn = "mysql:host=localhost;dbname=$banco;charset=utf8";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO($dsn, $usuario, $senha);
    
    $sql = 'SELECT id, sigla, numero, guiche, t_preferencia_id FROM t_senhas WHERE situacao != "Aguardando" AND t_filas_id = :IDFILA ORDER BY dataChamada DESC LIMIT 4';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':IDFILA', $idFila);
    $stmt->execute();
    $senhas = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($senhas);
    
} catch (PDOException $e) {
    echo "conexao_erro";
    exit;
}