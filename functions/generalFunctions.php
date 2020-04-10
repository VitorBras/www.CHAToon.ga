<?php

//Variáveis de sistema
$connect;
$db_name = "db_sistemachat";
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$sessid = session_id();

class habboAvatar{

	public $uniqueId = null;
	public $name = null;
	public $figureString = null;
	public $memberSince = null;
	public $profileVisible = null;
	public $selectedBadges = null;
	public $motto = null;

	public $infos;
	public function capiturar_dados($hbName,$hbServer){
		$url = "https://www.habbo$hbServer/api/public/users?name=$hbName";
		$curl_handle = curl_init();

		curl_setopt($curl_handle, CURLOPT_URL,$url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);//Desliguei o SSL pq estou em localhost e nao tenho certificado SSL aqui.
		curl_setopt($curl_handle, CURLOPT_USERAGENT, 'spider');
		$loop = true;$loopCount = 0;
		while($loop == true){//Parar só quando a requisição trouxer informações
			$query = curl_exec($curl_handle);
			$loopCount++;
			if(curl_error($curl_handle) == ''){//Deu certo
				curl_close($curl_handle);
				$this->infos = json_decode($query,true);
				if($this->infos != '' AND $this->infos != null AND $this->infos != '{"error":"not-found"}'){//Requizição mal feita
					$loop = false;
					return(true);//O usuário foi encontrado.
				}elseif($this->infos == '{"error":"not-found"}'){//Requisição bem feita porém esse usuário não foi encontrado
					$loop = false;
					return(true);//Retorna true pq a requisição foi bem feita apesar do usuário não ser encontrado.
				}
				if($loopCount == 10){
					$loop = false;
					return(false);
				}
			}else{
				curl_close($curl_handle);
				if($loopCount == 10){
					return(false);
				}
			}		
		}
		print($query);
		https://www.habbo.com.br/api/public/users?name=ababsab
	}

	function __construct($hbName,$hbServer){
		if($this->capiturar_dados($hbName,$hbServer) == true){//Requisição feita com sucesso
			//Verificar se o usuário foi encontrado
			if(isset($this->infos['error'])){//Usuário não encontrado
				$this->uniqueId = $this->infos['uniqueId'];
				$this->name = $this->infos['name'];
				$this->figureString = $this->infos['figureString'];
				$this->memberSince = $this->infos['memberSince'];
				$this->profileVisible = $this->infos['profileVisible'];
				$this->selectedBadges = $this->infos['selectedBadges'];
				$this->motto = $this->infos['motto'];
			}		
		}else{//Não feita com sucesso
			/*não fazer nada. Os atributos do objeto ficam como nulos*/
		}
		
		

	}
}

function currentTime($server){
	set_timing($server);
	return(date("Y-m-d H:i:s"));
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

function wordFiltro($dados){//Filtro de palavras ofensivas. Normalmente acessa a base de dados. São muitas palavras.
	return($dados);//Por enquanto
}

function wordNameFiltro($dados){//Filtra a string tirando as palavras proibidas pelo padrão de nome de grupo que é padronizado no arquivo (config/sistemaConfig.xml) e retorna o valor filtrado.
	return($dados);//Por enquanto
}

function nameGroupAccepted($dados){//Verificar se a string nome de grupo não contêm palavras proibidas.
	$configSystem = simplexml_load_file('../config/sistemaConfig.xml');
	
	
}
function AcceptedServer($domain){//Preciso abrir o arquivo de configurações do sistema e buscar a lista de servidores Habbo
	//Verificar se o dominio passado no parâmetro está na lista de configurações do sistema e ver se está ativo no sistema.
	//Afim de permitir o sistema de verificar e por consequencia a realização do cadastro da conta do usuário para aquele respectivo servidor
	$configSystem = simplexml_load_file("../config/sistemaConfig.xml");
	
	for($i=0,$habS=false;$i<count($configSystem->habboServer->server);$i++){
		if(((string) $configSystem->habboServer->server[$i]) == $domain){//É um servidor Oficial do Habbo
			$i=count($configSystem->habboServer->server);
			$habS=true;
			return true;
		}else{
			if($i+1 == count($configSystem->habboServer->server) and $habS == false){
				return false;
			}
		}
	}
}

function isHabboAvatarOwner($hbName = null,$hbServer = null,$code = null,$substitutePass){
	if($hbName != null && $hbServer != null){
				
		//Verificar se o servidor é do Habbo e está aceitando cadastro no sistema do CHAToon
		if(AcceptedServer($hbServer) == true){//Servidor pode estar fora do ar
			//Verificar se há registro em codigo_confirmacao
			$resultado = mysqli_query($connect,"SELECT codigo_hb_name,status,substitutePass,substitutePassCode FROM codigo_confirmacao WHERE habbo_name = '$hbName' AND server = '$hbServer';");
			//print(mysqli_error($connect));
			//var_dump($resultado);
			if(mysqli_error() == false or mysqli_error() == ''){
				if($resultado != null or $resultado != ""){//Há tupla de veri..
					$dados = mysqli_fetch_assoc($resultado);
					mysqli_close($connect);
					if($dados['substitutePassCode'] == null){//Gravar um novo código
						$code = gen_code_confirm(6);
						$resultado = mysqli_query($connect,"UPDATE codigo_confirmacao SET status = 1,criado_timestamp = ".currentTime(".com.br").",substitutePass = '$substitutePass',substitutePassCode = '$code',server = '$hbServer' WHERE habbo_name = '$hbName' AND server = '$hbServer';");
						if(mysqli_error() == null or mysqli_error() == ""){//Sem erro
							mysqli_close($connect);
							echo('{"response":"PASS_IN_CONFIRMING_STEP","passCode":"$code"}');
							//return(true);
						}else{
							echo('{"response":"INTERNAL_ERROR"}');
							//return(false);
						}
					}
				}else{//Não há resultado. Cadastrar uma tupla de verificação
					$code = gen_code_confirm(6);
					$resultado = mysqli_query($connect,"INSERT INTO codigo_confirmacao (habbo_name,status,criado_timestamp,substitutePass,substitutePassCode,server) VALUES ('$hbName',1,'".currentTime(".com.br")."','$substitutePass','$code');");
					if(mysqli_error() == null or mysqli_error() == ""){//Sem erro
						echo('{"response":"PASS_IN_CONFIRMING_STEP","passCode":"$code"}');
						//return(true);
					}else{
						echo('{"response":"INTERNAL_ERROR"}');
						//return(false);
					}
				}
			}else{//Deu erro
				echo('{"response":"INTERNAL_ERROR"}');
			}
		}
							
	}else{//Não foram enviados dados suficientes sob parâmetro
		return('insufficient_params');
	}
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

//Função para mostrar dados amigáveis na interface_exists
function friendlyDataUser($dados,$dataType){
	
	switch($dataType){
		case "status":
			if($dados == null or $dados == "" or $dados == "null"){
				return("<i>status vazio</i>");
			}else{
				return($dados);
			}
			break;
		case "email":
			if($dados == null or $dados == "" or $dados == "null"){
				return("<i>sem e-mail</i>");
			}else{
				return($dados);
			}		
			break;
	}
	
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

function userDataConfirming_EmailAndCode($hbname,$hbserver){
	//Capiturar Email e Código de verificação do email
	$connect = mysqli_connect($GLOBALS['db_server'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
	$query = "SELECT email,codigo_email FROM codigo_confirmacao WHERE habbo_name = '$hbname' AND server = '$hbserver';";
	$dados = mysqli_query($connect,$query);
	if(mysqli_error($connect) == "" or mysqli_error($connect) == null){
		$infos = mysqli_fetch_array($dados);
		mysqli_close($connect);
		return($infos);
	}else{
		mysqli_close($connect);
		return(false);
	}
}

function registerGroup($gpName,$gpAssuntos,$roomId,$hbServer,$hbName){
	
	//Verificar se o grupo já está cadastrado na base de dados
	$connect = mysqli_connect("localhost","root","","db_sistemachat");
	$query = "SELECT criador_id FROM grupo WHERE HabboRoomId = '$roomId' AND server = '$hbServer'";
	$dados = mysqli_query($connect,$query);
	$dados = mysqli_fetch_array($dados);
	mysqli_close($connect);
	if($dados == null){print("registrar o grupo");
		$criadorId = userData($hbName,$hbServer)['user_id'];
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

function sendEmail($what,$email,$name = null,$hbserver,$code = null,$link,$sessid = "semSessao"){
	
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
						<h4>Ou clique no link para confirmar seu email: <a href='$link?hbname=$name&hbserver=$hbserver&confirmCode=$code&throwEmail=true&PHPSESSID=$sessid'>confirmar</a></h4></br></br></br>
						
						<span>*Por favor não responda este e-mail</span>
					</head>
				</html>
			
			";
			$sending = mail($email,"CHAToon - Confirme seu e-mail",$mensagem,$header);
			if($sending == true){//Email enviado com sucesso
				return(true);
			}else{//Email não enviado
				return(false);
			}
			break;
	}
}

function deleteVerificationRecordInDB($hbname,$hbserver){
	$connect = mysqli_connect($GLOBALS['db_server'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
	$query = "DELETE FROM codigo_confirmacao WHERE habbo_name = '$hbname' AND server = '$hbserver';";
	$query = mysqli_query($connect,$query);
	if(mysqli_error($connect) == "" or mysqli_error($connect) == null or mysqli_error($connect) == false){
		mysqli_close($connect);
		return(true);
	}else{
		mysqli_close($connect);
		return(false);
	}
}
function replaceEmailInConfirmingStep($hbname,$hbserver,$email){//Substitui o email que está em verificação na base de dados na tabela (codigo_confirmacao)
	$code = gen_code_confirm(6);
	$connect = mysqli_connect($GLOBALS['db_server'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
	$query = "UPDATE codigo_confirmacao SET email = '$email',codigo_email = '$code' WHERE habbo_name = '$hbname' AND server = '$hbserver';";
	$query = mysqli_query($connect,$query);
	if(mysqli_error($connect) == "" or mysqli_error($connect) == null or mysqli_error($connect) == false){
		mysqli_close($connect);
		//Escolhendo qual o link a usar.. de produção ou o usado no desenvolvimento localhost.
		$configSystem = simplexml_load_file('../config/sistemaConfig.xml');
		$link;
		for($i=0;$i<count($configSystem->serverLinks->codeEmailConfirm);$i++){
			if($configSystem->serverLinks->codeEmailConfirm[$i]['using'] == "yes"){
				$link = $configSystem->serverLinks->codeEmailConfirm[$i];
			}
		}
		$sending = sendEmail("email_confirm_code",$email,$hbname,$hbserver,$code,$link,$GLOBALS['sessid']);
		if($sending == true){
			//Avisar a aplicação cliente que o usuário deve ir ao seu email pegar o código
			return("confirm_email_step");
		}else{
			return(true);
		}
	}else{
		mysqli_close($connect);
		return(false);
	}
	
}
function changeEmail($hbname,$hbserver,$email){//Grava na base de dados na tabela de codigo de confirmação um novo email
	//Verificacr se o usuário está definitivamente cadastrado no sistema (Não é necessário pq esTÁ LOGADO)
	
	//Na base de dados da tabela CODIGO DE CONFIRMAÇÃO há um registro deste usuário que está em confirmação?
	$connect = mysqli_connect($GLOBALS['db_server'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
	$query = "SELECT status,codigo_email,email FROM codigo_confirmacao WHERE habbo_name = '$hbname' AND server = '$hbserver';";
	$dados = mysqli_query($connect,$query);
	if(mysqli_error($connect) == "" or mysqli_error($connect) == null or mysqli_error($connect) == false){
		$infos = mysqli_fetch_array($dados);
		//return(var_dump($infos));		
		if($infos == null){//Não há registro.
			//Registrar uma TUPlA de verificação: Usada para armazenar o EMAIL sob verificação e o Código para confirma-lo
			$code = gen_code_confirm(6);
			mysqli_close($connect);//Fechando conexão anterior
			$connect = mysqli_connect($GLOBALS['db_server'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
			$query = "INSERT INTO codigo_confirmacao (habbo_name,email,codigo_email,status,criado_timestamp,server) VALUES ('$hbname','$email','$code',1,'".currentTime($hbserver)."','$hbserver');";
			$dados = mysqli_query($connect,$query);
			//Verificar se deu certo
			if(mysqli_error($connect) == "" or mysqli_error($connect) == null or mysqli_error($connect) == false){
				mysqli_close($connect);
				//Escolhendo qual o link a usar.. de produção ou o usado no desenvolvimento localhost.
				$configSystem = simplexml_load_file('../config/sistemaConfig.xml');
				$link;
				for($i=0;$i<count($configSystem->serverLinks->codeEmailConfirm);$i++){
					if($configSystem->serverLinks->codeEmailConfirm[$i]['using'] == "yes"){
						$link = $configSystem->serverLinks->codeEmailConfirm[$i];
					}
				}
				$sending = sendEmail("email_confirm_code",$email,$hbname,$hbserver,$code,$link,$GLOBALS['sessid']);
				if($sending == true){
					//Avisar a aplicação cliente que o usuário deve ir ao seu email pegar o código
					return("confirm_email_step");
				}
				return("confirm_email_step");
			}else{//Caso dê errao
				mysqli_close($connect);
				return(false);
			}
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
						$sending = sendEmail("email_confirm_code",$email,$hbname,$hbserver,$code,$link,$GLOBALS['sessid']);
						if($sending == true){
							//Avisar a aplicação cliente que o usuário deve ir ao seu email pegar o código
							mysqli_close($connect);
							return("confirm_email_step");
						}
					}else{
						mysqli_close($connect);
						return("mysqli_error");
					}
				}else{//Já há um email para confirmar. Enviar ao cliente usuário uma opção para registrar outro e-mail.
					//Verificar se o email que foi enviado pela aplicação cliente é o mesmo que está sendo verificado. Caso não substituir pelo novo email enviado pela aplicação cliente
					if($infos['email'] == $email){
						return("confirm_email_step");
					}else{
						replaceEmailInConfirmingStep($hbname,$hbserver,$email);
					}
					
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

function changePass($hbName,$hbServer){//Processo de mudança de senha

}

?>