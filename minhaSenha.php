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
    
    $minhaSenha = 'SELECT id, sigla, numero, t_preferencia_id FROM t_senhas WHERE situacao = "Aguardando" AND t_filas_id = :IDFILA AND email = :EMAIL ORDER BY id DESC LIMIT 1';
    $stmt1 = $conexao->prepare($minhaSenha);
    $stmt1->bindParam(':IDFILA', $idFila);
    $stmt1->bindParam(':EMAIL', $email);
    $stmt1->execute();
    $msenha = $stmt1->fetch();

    if ($stmt1->rowCount() > 0) {
        $retornoApp = array('MSENHA' => 'SUCESSO', 'id' => $msenha['id'], 'sigla' => $msenha['sigla'], 'numero' => $msenha['numero'], 'preferencia' => $msenha['t_preferencia_id']);
    } else {
        $retornoApp = array('MSENHA' => 'ERRO');
    }

    echo json_encode($retornoApp);
    
} catch (PDOException $e) {
    echo "conexao_erro";
    exit;
}