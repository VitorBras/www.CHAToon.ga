<?php

$hbname = null;
$hbserver = null;

$host = "127.0.0.1";
$db_pass = ""; 
$db_name = "db_sistemachat";
$db_user = "root";

$connect = mysqli_connect($host, $db_user, $db_pass, $db_name);

/*
function hbname_verify_patter(){
	
}
function hbserver_verify_patter(){
	
}
*/

function gen_code_confirm(){
	$code = "";
	for($i=0;$i<6;$i++){
		if($i == 0){
			$code = rand(0,9);
		}else{
			$code .= rand(0,9);
		}
	}
	return($code);
}
function set_timing($servidor){
	
	switch($servidor){
		case ".com.br":
			date_default_timezone_set('America/Sao_Paulo');//Brasil
			break;
		case ".com":
			date_default_timezone_set('America/New_York');//internacional
			break; 
		case ".de":
			date_default_timezone_set('Europe/Berlin');//Alemanha
			break;
		case ".es":
			date_default_timezone_set('Europe/Madrid');//Espanha
			break;
		case ".fi":
			date_default_timezone_set('Europe/Moscow');//Finlandia
			break;
		case ".fr":
			date_default_timezone_set('Europe/Paris');//França
			break;
		case ".it":
			date_default_timezone_set('Europe/Monaco');//Italia
			break;
		case ".nl":
			date_default_timezone_set('Europe/Amsterdam');//Holanda
			break;
		case ".com.tr":
		date_default_timezone_set('Europe/Istanbul');//Turkuia
			break;
	}
	
}
//print(gen_code_confirm());
if(isset($_GET['processo'])){
	if($_GET['processo'] == "registrar"){
		if(isset($_GET['processo']) && isset($_GET['hbname']) && isset($_GET['hbserver'])){
			$hbname = $_GET['hbname'];
			$hbserver = $_GET['hbserver'];
			
			//Registrando nome do usuário mais o código de confirmação no banco de dados
			
			//Verificar se o avatar está registrado PARA CONFIRMAÇÃO de posse de conta do avatar Habbo
			$verify_is_user = mysqli_query($connect,"SELECT habbo_name,ban FROM usuarios WHERE habbo_name = '$hbname';");
			$resultado = mysqli_fetch_assoc($verify_is_user);
			//Está registrado em usuários?
			if($resultado['habbo_name'] == $hbname){//print("Cadastrado em: USUÁRIOS");
				
				//A conta está banida?
				if($resultado['ban'] == true or $resultado['ban'] == 1){//print("Conta: BANIDA");
					print("{\"response\":\"banned\",\"hbname\":\"$hbname\",\"hbserver\":\"$hbserver\"}");
				}else{//Está cadastrado definitivamente e não está banido.
					print("{\"response\":\"already_registered\",\"hbname\":\"$hbname\",\"hbserver\":\"$hbserver\"}");
					//print("Cadastrado em: USUÁRIOS e não banido");
				}
			}else{//Avatar não está cadastrado como usuário. Será que está na base de dados para confirmação de HABBO NAME?
				$verify_is_confirming = mysqli_query($connect,"SELECT habbo_name,codigo_hb_name,status FROM codigo_confirmacao WHERE habbo_name = '$hbname';");
				$result = mysqli_fetch_assoc($verify_is_confirming);
				//O sistema está esperando o usuário confirmar a posse da conta Avatar Habbo?
				//print("status: ".$result['status']);
				//print("habbo_name: ".$result['habbo_name']);
				if($result['status'] == "0" and strtolower($result['habbo_name']) == strtolower("$hbname")){//Sim
					//print("Cadastrado em: BASE DE CONFIRMAÇÃO e aguardando confirmação de HBNAME");
					$codigo_confirmacao = $result['codigo_hb_name'];
					print("{\"response\":\"need-confirm-hbname\",\"hbname\":\"$hbname\",\"hbserver\":\"$hbserver\",\"code\":\"$codigo_confirmacao\"}");
				}elseif($result['status'] == 2){//Usuário cadastrado.. mas com o email confirmado?
					print("{\"response\":\"already_registered-with-email-confirmed\",\"hbname\":\"$hbname\",\"hbserver\":\"$hbserver\"}");
				}else{//print("EXECUTANDO.</br>");
					//O status não é 0 e nem 2: Não está para confirmar, nem foi confirmado com email. Então não foi cadastrado em lugar algum.
					//Então vamos cadastrar o usuário na base de confirmação...
					set_timing($hbserver);
					$codigo = gen_code_confirm();
					$datetime = date("Y-m-d H:i:s");
					mysqli_query($connect,"INSERT INTO codigo_confirmacao (habbo_name,codigo_hb_name,server,criado_timestamp) VALUES ('$hbname','$codigo','$hbserver','$datetime')");
					print("{\"response\":\"need-confirm-hbname\",\"hbname\":\"$hbname\",\"hbserver\":\"$hbserver\",\"code\":\"$codigo\"}");
					//print("Aki".mysqli_error($connect)."Aki");
				}
			}
			
			//mysqli_query($connect,"INSERT INTO codigo_confirmacao (habbo_name,codigo_hb_name,status) VALUES ($hbname,$codigo,0)");
			
		
		}
		
		
	}

}else{
	print("{\"response\":\"nothing-received\"}");
}




mysqli_close($connect);


?>