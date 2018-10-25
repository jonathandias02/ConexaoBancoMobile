<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form action="solicitarSenha.php" method="post">
            <label>Banco:</label>
            <input type="text" name="nomebd" /><br/>
            <label>Fila:</label>
            <input type="text" name="idFila" /><br/>
            <label>Preferencia:</label>
            <input type="text" name="idPreferencia" /><br/>
            <label>Servico:</label>
            <input type="text" name="idServico" /><br/>
            <label>Data:</label>
            <input type="datetime-local" name="dataSolicitacao" /><br/>
            <label>Identificação:</label>
            <input type="text" name="identificacao" /><br/>
            <label>Sigla:</label>
            <input type="text" name="sigla" /><br/>
            <label>Email:</label>
            <input type="text" name="email" /><br/>
            <input type="submit" value="Enviar"/>
        </form>
    </body>
</html>
