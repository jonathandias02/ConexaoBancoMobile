<?php

include "conexao.php";
$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = isset($filtro['nome']) ? $filtro['nome'] : null;
$sobrenome = isset($filtro['sobrenome']) ? $filtro['sobrenome'] : null;
$telefone = isset($filtro['telefone']) ? $filtro['telefone'] : null;
$email = isset($filtro['email']) ? $filtro['email'] : null;

$sql_update = 'UPDATE t_usuariosapp SET nome = :NOME, sobrenome = :SOBRENOME, telefone = :TELEFONE
WHERE email = :EMAIL';

$stmt = $conexao->prepare($sql_update);
$stmt->bindParam(':NOME', $nome);
$stmt->bindParam(':SOBRENOME', $sobrenome);
$stmt->bindParam(':TELEFONE', $telefone);
$stmt->bindParam(':EMAIL', $email);
$stmt->execute();
$count = $stmt->rowCount();

if($count > 0){
	$retornoapp = array("update" => "SUCESSO");
}else{
	$retornoapp = array("update" => "ERRO");
}

echo json_encode($retornoapp);