<?php
$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$banco = isset($filtro['nomebd']) ? $filtro['nomebd'] : null;
$idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;
$idPreferencia = isset($filtro['idPreferencia']) ? $filtro['idPreferencia'] : null;
$idServico = isset($filtro['idServico']) ? $filtro['idServico'] : null;
$identificacao = isset($filtro['identificacao']) ? $filtro['identificacao'] : null;
$sigla = isset($filtro['sigla']) ? $filtro['sigla'] : null;
$email = isset($filtro['email']) ? $filtro['email'] : null;
$dsn = "mysql:host=localhost;dbname=$banco;charset=utf8";
$usuario = "root";
$senha = "";
$dataS = new \DateTime("now", new \DateTimeZone("America/Sao_Paulo"));
$dataSolicitacao = $dataS->format('Y-m-d H:i:s');

try {
    $conexao = new PDO($dsn, $usuario, $senha);

    $sqlnumero = 'SELECT nsenha FROM t_filas WHERE id = :IDFILA';
    $stmt1 = $conexao->prepare($sqlnumero);
    $stmt1->bindParam(':IDFILA', $idFila);
    $stmt1->execute();
    $n = $stmt1->fetch();
    $numero = str_pad($n['nsenha'], 4, '0', STR_PAD_LEFT);
    
    $sql = 'INSERT INTO t_senhas (t_preferencia_id, t_servicos_id, dataSolicitacao, identificacao, sigla, numero, situacao, email, t_filas_id) VALUES (:IDPREFERENCIA, :IDSERVICO, :DATASOLICITACAO, :IDENTIFICACAO, :SIGLA, :NUMERO, 
    	"Aguardando", :EMAIL, :IDFILA)';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':IDPREFERENCIA', $idPreferencia);
    $stmt->bindParam(':IDSERVICO', $idServico);
    $stmt->bindParam(':DATASOLICITACAO', $dataSolicitacao);
    $stmt->bindParam(':IDENTIFICACAO', $identificacao);
    $stmt->bindParam(':SIGLA', $sigla);
    $stmt->bindParam(':NUMERO', $numero);
    $stmt->bindParam(':EMAIL', $email);
    $stmt->bindParam(':IDFILA', $idFila);
    $stmt->execute();

    $linhas = $stmt->rowCount();
    if($linhas > 0){
    	$resultado = array("insert" => "SUCESSO", "senha" => $sigla.$numero);
    	$nsenha = $n['nsenha'] + 1;
    	$sqlupdate = 'UPDATE t_filas SET nsenha = :NSENHA';
    	$stmtupdate = $conexao->prepare($sqlupdate);    
    	$stmtupdate->bindParam(':NSENHA', $nsenha);
    	$stmtupdate->execute();    
    	echo json_encode($resultado);
	}else{
		$resultado = array("insert" => "ERRO");
		echo json_encode($resultado);
	}
    
} catch (PDOException $e) {
    echo "conexao_erro";
    exit;
}