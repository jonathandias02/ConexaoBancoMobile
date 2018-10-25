<?php

include "conexao.php";
$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$senhaAtual = isset($filtro['senhaAtual']) ? md5($filtro['senhaAtual']) : null;
$senha = isset($filtro['senha']) ? md5($filtro['senha']) : null;
$email = isset($filtro['email']) ? $filtro['email'] : null;

$sql_update = 'UPDATE t_usuariosapp SET senha = :SENHA
WHERE email = :EMAIL AND senha = :SENHAATUAL';

$stmt = $conexao->prepare($sql_update);
$stmt->bindParam(':SENHA', $senha);
$stmt->bindParam(':EMAIL', $email);
$stmt->bindParam(':SENHAATUAL', $senhaAtual);
$stmt->execute();
$count = $stmt->rowCount();

if($count > 0){
	$retornoapp = array("update" => "SUCESSO");
}else{
	$retornoapp = array("update" => "ERRO");
}

echo json_encode($retornoapp);