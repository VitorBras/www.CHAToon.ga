<?php

require("generalFunctions.php");


$hbname;
$hbserver;
$sessionId; //É o Hash da sessão. Armazeno ela no banco de dados quando o usuário loga.

//Variáveis com dados enviados
$newStatus;


if(isset($_REQUEST['processo']) and isset($_REQUEST['PHPSESSID'])){
	//Iniciando sessão
	session_id($_REQUEST['PHPSESSID']);
	session_start();
	//A sessão está logada?
	if(@$_SESSION['logado'] == true){//Está logada sim.
		//Atribuindo as variáveis globais os valores passado a este sistema para início de sua operação
		$GLOBALS['hbname'] = $_SESSION['hbname']; //FILTRO ANTI-SQL-INJECTION aqui
		$GLOBALS['hbserver'] = $_SESSION['hbserver'];//FILTRO ANTI-SQL-INJECTION aqui
		
		//Qual é o processo?
		switch($_REQUEST['processo']){
			case "change_status":
				if(isset($_REQUEST['newStatus'])){
					//Mudar status
					$newStatus = $_REQUEST['newStatus'];//FILTRO ANTI-SQL aqui
					
					//Atualizar dados no banco de dados
					
					userDataUpdate($GLOBALS['hbname'],$GLOBALS['hbserver'],"status",$newStatus);
					if(userDataUpdate($GLOBALS['hbname'],$GLOBALS['hbserver'],"status",$newStatus)){
						echo("{\"response\":\"status_changed\"}");
					}
				}else{
					echo("{\"response\":\"falta_dados_a_enviar\"}");
				}
				
				break;
			case "change_email":
				if(isset($_REQUEST['newEmail'])){
					$email = $_REQUEST['newEmail'];//Filtro ANTI-SQL-INJECTION aqui
					if(changeEmail($GLOBALS['hbname'],$GLOBALS['hbserver'],$email) == "confirm_email_step"){
						echo("{\"response\":\"confirm_email_step\"}");
					}
				}else{
					echo("{\"response\":\"falta_dados_a_enviar\"}");
				}
				break;
			case "change_pass":
				if(isset($_REQUEST['newPass'])){
					
				}else{
					echo("{\"response\":\"falta_dados_a_enviar\"}");
				}
				break;
		}
	}else{//Usuário não logado
		echo("{\"response\":\"user_no_loged\"}");
	}
	
	
}else{
	echo("{\"response\":\"falta_dados_a_enviar\"}");
}

/*
o1ogb822rt2l8guii1jdk5fsoq      adm=vitor
o1ogb822rt2l8guii1jdk5fsoq   settings.php

*/
?>