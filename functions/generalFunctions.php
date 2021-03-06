<?php

//Variáveis de sistema
$connect;
$db_name = "db_sistemachat";
$db_server = "localhost";
$db_user = "root";
$db_pass = "";

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

function wordFiltro($dados){//Filtro de palavras ofensivas. Normalmente acessa a base de dados. São muitas palavras.
	return($dados);//Por enquanto
}

function wordNameFiltro($dados){//Filtra a string tirando as palavras proibidas pelo padrão de nome de grupo que é padronizado no arquivo (config/sistemaConfig.xml) e retorna o valor filtrado.
	return($dados);//Por enquanto
}

function nameGroupAccepted($dados){//Verificar se a string nome de grupo não contêm palavras proibidas.
	$configSystem = simplexml_load_file('../config/sistemaConfig.xml');
	
	
}

function isUser($hbname,$hbserver){
	
}

function isRoomOwner($habboName,$habboServer,$roomId){//Verificar se o quarto pertence ao Habbo Avatar Cadastrado
	//Pegar habbo Id única
	$url = "https://www.habbo".$habboServer."/api/public/users?name=".$habboName;
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL,$url);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);//Desliguei o SSL pq estou em localhost e nao tenho certificado SSL aqui.
	curl_setopt($curl_handle, CURLOPT_USERAGENT, 'spider');
	$query = curl_exec($curl_handle);
	$infos = json_decode($query,true);
	//var_dump($query);
	
	curl_close($curl_handle);
	//$infos["uniqueId"];
	//Pegar a lista de quartos
	$url_grupos = "https://www.habbo".$habboServer."/api/public/users/".$infos['uniqueId']."/rooms";
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL,$url_grupos);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);//Desliguei o SSL pq estou em localhost e nao tenho certificado SSL aqui.
	curl_setopt($curl_handle, CURLOPT_USERAGENT, 'spider');
	$query = curl_exec($curl_handle);
	$datas = json_decode($query,true);
	//var_dump($query);
	
	curl_close($curl_handle);
	//Verificar se o RoomId é igual a um dos Room IDs da lista de quartos
	$isOwner = false;
	for($i=0;$i<count($datas);$i++){
		if($roomId == $datas[$i]['id']){
			$isOwner = true;
			break;
		}
	}
	return($isOwner);
	
}
//print(isRoomOwner("Administrador.4",".com.br","546985030"));

function userStatusChange($status){//Mudar status do usuário

}

function userData($hbName,$hbServer){//Retorna dados do usuário
	$connect = mysqli_connect($GLOBALS['db_server'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
	$query = "SELECT user_id,senha,creditos,email,celular,criado_timestamp,status FROM usuarios WHERE habbo_name = '$hbName' AND server = '$hbServer'";
	$dados = mysqli_query($connect,$query);
	if(gettype($dados) == 'object'){
		$dados = mysqli_fetch_array($dados);
	}else{
		return("user_dont_found");
	}
	mysqli_close($connect);
	return($dados);
}

function registerGroup($gpName,$gpAssuntos,$roomId,$hbServer,$hbName){
	
	//Verificar se o grupo já está cadastrado na base de dados
	$connect = mysqli_connect("localhost","root","","db_sistemachat");
	$query = "SELECT criador_id FROM grupo WHERE HabboRoomId = '$roomId' AND server = '$hbServer'";
	$dados = mysqli_query($connect,$query);
	$dados = mysqli_fetch_array($dados);
	mysqli_close($connect);
	if($dados == null){print("registrar o grupo");
		$criadorId = userData("Administrador.4",".com.br")['user_id'];
		set_timing($hbServer);
		$timestamp = date("Y-m-d H:i:s");
		$connect = mysqli_connect("localhost","root","","db_sistemachat");
		$query = "INSERT INTO grupo (criador_id,HabboRoomId,nome_grupo,assuntos,criado_timestamp,theme,server) VALUES ('$criadorId','$roomId','".utf8_decode($gpName)."','{\"assuntos\":[\"".utf8_decode($gpAssuntos[0])."\",\"".utf8_decode($gpAssuntos[1])."\",\"".utf8_decode($gpAssuntos[2])."\"]}','$timestamp',0,'$hbServer');";
		$dados = mysqli_query($connect,$query);
		print(mysqli_error($connect));
		//O registro foi realizado com sucesso?
		if(mysqli_error($connect) == null or mysqli_error($connect) == ""){//Registrado com sucesso na base de dados.
			mysqli_close($connect);
			return true;
		}else{
			mysqli_close($connect);
			return false;
		}
		mysqli_close($connect);
	}else{
		return("already_registered");
	}
}
//registerGroup("nada",["Medo","Polícias","Insônia"],"146985034",".com.br","Administrador.4");

function userDataUpdate($hb_name,$hb_server,$mudar,$dado){
	
	$connect = mysqli_connect($GLOBALS['db_server'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
	
	switch($mudar){
		case "status":
			if($hb_name != null && $hb_server != null && $mudar != null && $dado != null){
				$query = "UPDATE usuarios SET status='".utf8_decode($dado)."' WHERE habbo_name='$hb_name' AND server='$hb_server';";
				$resposta = mysqli_query($connect,$query);
				//Tudo deu certo?
				if(mysqli_error($connect) == "" or mysqli_error($connect) == null){
					return(true);
					goto fim;
				}
			}
			break;
		case "senha":
			if($hb_name != null && $hb_server != null && $mudar != null && $dado != null){
				
			}
			break;
		case "email":
			if($hb_name != null && $hb_server != null && $mudar != null && $dado != null){
				$query = "UPDATE usuarios SET email='".utf8_decode($dado)."' WHERE habbo_name='$hb_name' AND server='$hb_server';";
				$resposta = mysqli_query($connect,$query);
				//Tudo deu certo?
				if(mysqli_error($connect) == "" or mysqli_error($connect) == null){
					return(true);
					goto fim;
				}
			}
			break;
		case "celular":
			if($hb_name != null && $hb_server != null && $mudar != null && $dado != null){
				
			}
			break;
		case "creditos":
			if($hb_name != null && $hb_server != null && $mudar != null && $dado != null){
				
			}
			break;
		case "banimento":
			if($hb_name != null && $hb_server != null && $mudar != null && $dado != null){
				
			}
			break;
		case "redeSocial":
			if($hb_name != null && $hb_server != null && $mudar != null && $dado != null){
				
			}
			break;
	}
	fim:
	mysqli_close($connect);
	
}

function gen_code_confirm($x){
	$code = "";
	for($i=0;$i<$x;$i++){
		if($i == 0){
			$code = rand(0,9);
		}else{
			$code .= rand(0,9);
		}
	}
	return($code);
}
function sendEmail($what,$email,$name = null,$hbserver,$code = null,$link){
	
	switch($what){
		case "email_confirm_code":
			//$mensagem = "Olá $name. \n Seu código de confirmação é: <h4>$code</h4> \n \n <strong>Por favor não responda este email.</strong>";
			$header = "Content-type: text/html; charset=UTF-8; \r\n";
			$header .= "MIME-Version: 1.0; \r\n";
			$header .= "From: jeguestudiodev@gmail.com; \r\n";
			$mensagem = "
				<html>
					<head>
						<h2>CHAToon - Olá $name</h2>
						<h4>Seu código de confirmação é: <strong>$code</strong></h4></br></br>
						<h4>Ou clique no link para confirmar seu email: <a href='$link?hbname=$name&hbserver=$hbserver&confirmCode=$code'>confirmar</a></h4></br></br></br>
						
						<span>*Por favor não responda este e-mail</span>
					</head>
				</html>
			
			";
			$sending = mail($email,"CHAToon - Confirme seu e-mail",$mensagem,$header);
			if($sending){
				return(true);
			}
			break;
	}
}
function changeEmail($hbname,$hbserver,$email){//Grava na base de dados na tabela de codigo de confirmação um novo email
	//Verificacr se o usuário está definitivamente cadastrado no sistema (Não é necessário pq esTÁ LOGADO)
	
	//Na base de dados da tabela CODIGO DE CONFIRMAÇÃO há um registro deste usuário que está em confirmação?
	$connect = mysqli_connect($GLOBALS['db_server'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
	$query = "SELECT status,codigo_email FROM codigo_confirmacao WHERE habbo_name = '$hbname' AND server = '$hbserver';";
	$dados = mysqli_query($connect,$query);
	if(mysqli_error($connect) == "" or mysqli_error($connect) == null){
		$infos = mysqli_fetch_array($dados);
		//return(var_dump($infos));
		
		if($infos == null){//Não há registro.
			
		}else{//Há algum registro.
			//return(var_dump($infos));
			//Verificar se apenas falta a verificação do email
			if($infos['status'] == "1"){
				if($infos['codigo_email'] == null){//Indicar um código para confirmação
					$code = gen_code_confirm(6);
					
					$query = "UPDATE codigo_confirmacao SET codigo_email = '$code',email = '$email' WHERE habbo_name = '$hbname' AND server = '$hbserver';";
					$dados = mysqli_query($connect,$query);
					print(mysqli_error($connect));
					if(mysqli_error($connect) == null or mysqli_error($connect) == ""){//Caso não dê erro
						//Enviar o código para o email
							//Escolhendo qual o link a usar.. de produção ou o usado no desenvolvimento localhost.
						$configSystem = simplexml_load_file('../config/sistemaConfig.xml');
						$link;
						for($i=0;$i<count($configSystem->serverLinks->codeEmailConfirm);$i++){
							if($configSystem->serverLinks->codeEmailConfirm[$i]['using'] == "yes"){
								$link = $configSystem->serverLinks->codeEmailConfirm[$i];
							}
						}
						$sending = sendEmail("email_confirm_code",$email,$hbname,$hbserver,$code,$link);
						if($sending == true){
							//Avisar a aplicação cliente que o usuário deve ir ao seu email pegar o código
							mysqli_close($connect);
							return("confirm_email_step");
						}
					}else{
						mysqli_close($connect);
						return("mysqli_error"); 
					}
					
					
					
				}else{
					return("confirm_email_step");
				}
			}else{
				mysqli_close($connect);
				return("user_no_registered_yet");
			}
		}
		
	}else{
		return("mysqli_error");
	}
	mysqli_close($connect);	
}




?>