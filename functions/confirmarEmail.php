<?php

require("generalFunctions.php");
$server = "localhost";
$db_name = "db_sistemachat";
$db_user = "root";
$db_pass = "";

//Iniciar sessão
if(isset($_REQUEST['PHPSESSID']) == false or isset($_REQUEST['PHPSESSID']) == true){
	session_id($_COOKIE['PHPSESSID']);
	session_start();
}else{//Sessão não foi indicada. O usuário precisa logar.
	echo('{"response":"user_no_logged"}');
}
//--
if(isset($_SESSION['logado'])){
	if($_SESSION['logado'] == true){
		if(isset($_REQUEST['confirmCode'])){
			$confirmCode = $_REQUEST['confirmCode'];//FlTro ANTI-SQL-INJECTION aqui
			$hbname = $_SESSION['hbname'];//FlTro ANTI-SQL-INJECTION aqui
			$hbserver = $_SESSION['hbserver'];//FlTro ANTI-SQL-INJECTION aqui
	
			//Confirmar email
				//Capitar dados da TUPLA de verificação (codigo_confirmacao)
			$infos = userDataConfirming_EmailAndCode($hbname,$hbserver);
			//Deu algum erro?
			if($infos != false){
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
				
			}else if($infos == null){//Não há registro na TUPLA de verificação para este respectivo usuário
				echo('{"response":"have_no_email_to_verify"}');
			}
		}else if(isset($_REQUEST['resendCodeToEmail'])){
			//Verificar se dados informações pela aplicação cliente condiz com dados da sessão
			if(isset($_SESSION['hbname']) AND isset($_SESSION['hbserver'])){//Dados condizem
				$hbname = $_SESSION['hbname'];
				$hbserver = $_SESSION['hbserver'];
				$infos = userDataConfirming_EmailAndCode($hbname,$hbserver);
				if($infos != false){
					//Reenviar email para o email
					$configSystem = simplexml_load_file('../config/sistemaConfig.xml');
					$link;
					for($i=0;$i<count($configSystem->serverLinks->codeEmailConfirm);$i++){
						if($configSystem->serverLinks->codeEmailConfirm[$i]['using'] == "yes"){
							$link = $configSystem->serverLinks->codeEmailConfirm[$i];
						}
					}
					$sending = sendEmail("email_confirm_code",$infos['email'],$hbname,$hbserver,$infos['codigo_email'],$link);
					if($sending == true){//Email reenviado com sucesso
						echo('{"response":"email_resended"}');
					}else{//Email não enviado
						echo('{"response":"email_not_resended"}');
					}
				}else{//Deu erro
					
				}
			}else{//O usuário não está logado porque as variáveis de sessão não existem. :(
				echo('{"response":"user_no_logged"}');
			}
			
		}
	}else{//Dizer a aplicação cliente para o usuário logar
		echo('{"response":"user_no_logged"}');
	}
}else{
	echo('{"response":"user_no_logged"}');
}


?>