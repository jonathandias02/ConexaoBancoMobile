<?php

include 'conexao.php';

$sql_buscar = "SELECT cnpj, empresa, nomebd, endereco FROM t_clientes";
$query = $conexao->query($sql_buscar);

$resultado = array();

while ($empresa = $query->fetch(PDO::FETCH_OBJ)){
    
    $resultado[] = array("CNPJ" => $empresa->cnpj, "EMPRESA" => $empresa->empresa, "BANCODEDADOS" => $empresa->nomebd, 
        "ENDERECO" => $empresa->endereco);
    
}
for ($i = 0; $i < count($resultado); $i++){
	$sql = "SELECT nota FROM t_avaliacao WHERE t_cliente_cnpj = :CNPJ";
	$stmt = $conexao->prepare($sql);
	$stmt->bindParam(':CNPJ', $resultado[$i]['CNPJ']);
	$stmt->execute();
	$notas = $stmt->fetchAll(PDO::FETCH_OBJ);
	$total = 0;
	for($j = 0; $j < count($notas); $j++){
		$total += $notas[$j]->nota;
	}	
	if(count($notas) > 0){
		$media = number_format($total / count($notas), 1);
		$resultado[$i]['AVALIACAO'] = "$media";
	}else{
		$resultado[$i]['AVALIACAO'] = "S/A";
	}
}

echo json_encode($resultado);