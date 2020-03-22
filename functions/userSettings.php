<?php

require("generalFunctions.php");
session_id($_REQUEST['PHPSESSID']);
session_start();

$hbname;
$hbserver;
$sessionId; //É o Hash da sessão. Armazeno ela no banco de dados quando o usuário loga.

//Variáveis com dados enviados
$newStatus;


if(isset($_REQUEST['processo']) and isset($_REQUEST['newStatus']) and isset($_REQUEST['PHPSESSID'])){
	
	//Qual é o processo?
	switch($_REQUEST['processo']){
		case "change_status":
			//Mudar status
			$newStatus = $_REQUEST['newStatus'];//FILTRO ANTI-SQL aqui
			//A sessão está logada?
			if($_SESSION['hbname'] != null && $_SESSION['hbserver'] != null && $_SESSION['logado'] == true){//Atualizar dados no banco de dados
				//Atribuindo as variáveis globais os valores passado a este sistema para início de sua operação
				$GLOBALS['hbname'] = $_SESSION['hbname'];
				$GLOBALS['hbserver'] = $_SESSION['hbserver'];
				userDataUpdate($GLOBALS['hbname'],$GLOBALS['hbserver'],"status",$newStatus);
			}
			break;
		case "a":
		
			break;
		case "b":
		
			break;
	}
	
}else{
	echo("{\"response\":\"nenhum_dado_enviado\"}");
}

echo("<script>alert('Administrador = ".$_SESSION['adm']." ')</script>");
/*
o1ogb822rt2l8guii1jdk5fsoq      adm=vitor
o1ogb822rt2l8guii1jdk5fsoq   settings.php

*/
?>