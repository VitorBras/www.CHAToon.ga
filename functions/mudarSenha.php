<?php

include("generalFunctions.php");
header("Content-Type:application/json");
//Verificar o processo
if(isset($_REQUEST['processo'])){
	if($_REQUEST['processo'] == "changepass"){//Processo de mudança de senha
		if(isset($_REQUEST['substitutePass']) && isset($_REQUEST['PHPSESSID'])){
			session_id($_REQUEST['PHPSESSID']);
			session_start();
			//var_dump($_SESSION);
			if($_SESSION['logado'] == true){//logado
				$substitutePass = $_REQUEST['substitutePass'];//ANTI SQL INJECTION aqui.
				//Processo de verificação se HB Owner
				isHabboAvatarOwner($_SESSION['hbname'],$_SESSION['hbserver'],null,$substitutePass);
				//echo('Debugg');
			}else{//Não logado
				print('{"response":"USER_NO_LOGGED"}');
			}
		}
	}elseif($_REQUEST['processo'] == "confirmAvatarOwner"){
		if(isset($_REQUEST['PHPSESSID'])){
			session_id($_REQUEST['PHPSESSID']);
			session_start();
			$hbName = $_SESSION['hbname'];
			$hbServer = $_SESSION['hbserver'];
			if($_SESSION['logado'] == true){//echo("Debbug Problem");
				$avatar = new HabboAvatar($_SESSION['hbname'],$_SESSION['hbserver']);
				$user = new User;
				$user->dataInVerification($_SESSION['hbname'],$_SESSION['hbserver']);
				if($avatar->motto == $user->substitutePassCode){//O código foi digitado na missão do avatar no Habbo Hotel
					//echo($user->substitutePassCode." / ".$avatar->motto);
					//Apagar a TUPLA de verificação relacionada ao usuário
					$user = new User;
					$user->dataInVerification($hbName,$hbServer);
					$newPass = $user->substitutePass;

					$connect = new conectarBancoDeDados();
					$query = mysqli_query($connect->conexao,"DELETE FROM codigo_confirmacao WHERE habbo_name = '$hbName' AND server = '$hbServer';");
					//Atualizar senha
					userDataUpdate($hbName,$hbServer,"senha",$newPass);
					//echo(mysqli_error($connect->conexao));
					mysqli_close($connect->conexao);
					echo('{"response":"PASS_CHANGED"}');
				}else{
					echo('{"response":"AVATAR_OWNER_NOT_CONFIRMED"}');
				}
			}
		}
	}
}

?>