<?php

$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$banco = isset($filtro['nomebd']) ? $filtro['nomebd'] : null;
$email = isset($filtro['email']) ? $filtro['email'] : null;
$dsn = "mysql:host=localhost;dbname=$banco;charset=utf8";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO($dsn, $usuario, $senha);
    
    $sql = 'SELECT s.sigla, s.numero, s.dataAtendimento, se.nomeServico, u.nome, u.sobrenome FROM t_senhas s, t_servicos se, t_usuario u WHERE s.t_servicos_id = se.id AND s.t_usuario_id = u.id AND situacao = "Atendida" AND email = :EMAIL ORDER BY s.id DESC LIMIT 10';
    $stmt1 = $conexao->prepare($sql);
    $stmt1->bindParam(':EMAIL', $email);
    $stmt1->execute();
    $resultado = array();

    while ($atendimentos = $stmt1->fetch(PDO::FETCH_OBJ)){
        
        $resultado[] = array("sigla" => $atendimentos->sigla, "numero" => $atendimentos->numero, "dataAtendimento" => $atendimentos->dataAtendimento, "servico" => $atendimentos->nomeServico, "atendente" => $atendimentos->nome." ".$atendimentos->sobrenome);        
        
    }

    echo json_encode($resultado);
    
} catch (PDOException $e) {
    echo "conexao_erro";
    exit;
}