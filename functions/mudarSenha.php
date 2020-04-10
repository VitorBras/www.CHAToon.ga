<?php

include("generalFunctions.php");

//Verificar o processo
if(isset($_REQUEST['processo'])){
	if($_REQUEST['processo'] == "changepass"){//Processo de mudança de senha
		if(isset($_REQUEST['substitutePass']) && isset($_REQUEST['PHPSESSID'])){
			session_id($_REQUEST['PHPSESSID']);
			session_start();
			if($_SESSION['logado'] == true){//logado
				$substitutePass = $_REQUEST['substitutePass'];//ANTI SQL INJECTION aqui.
				//Processo de verificação se HB Owner
				isHabboAvatarOwner($_SESSION['hbname'],$_SESSION['hbserver'],null,$substitutePass);
				$avatar = new HabboAvatar($_SESSION['hbname'],$_SESSION['hbserver']);
				if($avatar['motto'] == $code){

				}

			}else{//Não logado
				print('{"response":"USER_NO_LOGGED"}');
			}
		}
	}
}

?>