<?php

include "conexao.php";
$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = isset($filtro['nome']) ? $filtro['nome'] : null;
$sobrenome = isset($filtro['sobrenome']) ? $filtro['sobrenome'] : null;
$email = isset($filtro['email']) ? $filtro['email'] : null;
$telefone = isset($filtro['telefone']) ? $filtro['telefone'] : null;
$senha = isset($filtro['senha']) ? md5($filtro['senha']) : null;

$sql_verificar = "SELECT * FROM t_usuariosapp WHERE email = :EMAIL";
$stmt = $conexao->prepare($sql_verificar);
$stmt->bindParam(':EMAIL', $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $retornoApp = array('CADASTRO' => 'EMAIL_ERRO');
} else {
    $sql_insert = "INSERT INTO t_usuariosapp(nome, sobrenome, telefone, email, senha) VALUES (:NOME, :SOBRENOME, :TELEFONE, :EMAIL, :SENHA)";
    $stmt = $conexao->prepare($sql_insert);
    $stmt->bindParam(":NOME", $nome);
    $stmt->bindParam(":SOBRENOME", $sobrenome);
    $stmt->bindParam(":TELEFONE", $telefone);
    $stmt->bindParam(":EMAIL", $email);
    $stmt->bindParam(":SENHA", $senha);
    if ($stmt->execute()) {
        $retornoApp = array('CADASTRO' => 'SUCESSO');
    } else {
        $retornoApp = array('CADASTRO' => 'ERRO');
    }
}

echo json_encode($retornoApp);
