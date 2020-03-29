<?php

require("generalFunctions.php");
$server = "localhost";
$db_name = "db_sistemachat";
$db_user = "root";
$db_pass = "";
if(isset($_REQUEST['hbname']) and isset($_REQUEST['hbserver']) and isset($_REQUEST['confirmCode'])){
	$confirmCode = $_REQUEST['confirmCode'];//FlTro ANTI-SQL-INJECTION aqui
	$hbname = $_REQUEST['hbname'];//FlTro ANTI-SQL-INJECTION aqui
	$hbserver = $_REQUEST['hbserver'];//FlTro ANTI-SQL-INJECTION aqui
	
	//Confirmar email
	$connect = mysqli_connect($server,$db_user,$db_pass,$db_name);
	$query = "SELECT email,codigo_email FROM codigo_confirmacao WHERE habbo_name = '$hbname' AND server = '$hbserver';";
	$dados = mysqli_query($connect,$query);
	//Há algum erro?
	if(mysqli_error($connect) == "" or mysqli_error($connect) == null){
		$infos = mysqli_fetch_array($dados);
		//Verificar dados
		if($confirmCode == $infos['codigo_email']){
			echo('{"response":"email_confirmed"}');
			
			//Mudar o email do usuário na base de dados de registro definitivo (usuarios)
			userDataUpdate($hbname,$hbserver,"email",$infos['email']);
			//Apagar o registro desse usuário na base de dados de confirmação (codigo_confirmacao)
				//DEPOIS IREI APAGAR      estou trabalhando no sistema. irei fazer uns testes ainda
			deleteVerificationRecordInDB($hbname,$hbserver);			
			//Mostrar ao usuário uma interface gráfica apresentando o sucesso do feito. Puxar outros arquivos de estilos.
			
		}else{
			echo('{"response":"incorrect_code"}');
			//Por segurança, é necessário registrar o erro na confirmação. Concatenar +1 no campo confirm_error em 
			//... codigo_confirmacao       (IREI FAZER ESTE SISTEMA DE CONTAGEM PARA SEGURANÇA ANTI BRUTAL FORCE)
			
			//Mostrar ao usuário uma interface gráfica apresentando o INSUCESSO do feito. Puxar outros arquivos de estilos.
			
		}
	}else{
		echo("mysql_error");
	}
}

?>