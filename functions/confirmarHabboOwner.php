<?php
$habboName;
$habboServer;//Preciso determinar os valores possíveis
$cadastrarSenha;

$server = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "db_sistemachat";

$connect = mysqli_connect($server,$dbUser,$dbPass,$dbName);
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

//var_dump($configSystem->habboServer->server[0]['available']);print("</br></br>");

if(isset($_REQUEST['processo'])){
	if($_REQUEST['processo'] == "confirmar-habbo-owner"){
		if(isset($_REQUEST['habbo_name']) and isset($_REQUEST['habbo_server']) and isset($_REQUEST['senha'])){
			
			//Verificar se o servidor é do Habbo e está aceitando cadastro no sistema do CHAToon
			if(AcceptedServer($_REQUEST['habbo_server']) == true){
				$habboName = $_REQUEST['habbo_name'];//Colocar um filtro ANTI SQL INJECTION aqui
				$habboServer = $_REQUEST['habbo_server'];//Colocar um filtro ANTI SQL INJECTION aqui
				$cadastrarSenha = $_REQUEST['senha'];//Senha a ser utilizada para o cadastro caso seja confirmado o Habbo Avatar Owner
				$resultado = mysqli_query($connect,"SELECT codigo_hb_name,status FROM codigo_confirmacao WHERE habbo_name = '$habboName' AND server = '$habboServer';");
				//print(mysqli_error($connect));
				//var_dump($resultado);
				$dados = mysqli_fetch_assoc($resultado);
				//Verificar se precisa mesmo verificar se a conta Habbo pertence ao indivíduo
				if($dados['status'] == "0" or $dados['status'] == 0){//Sim
					//Verificar se o código de confirmação foi colocado na missão do avatar a ser REGISTRADO DEFINITIVAMENTE
					//print($dados['codigo_hb_name']);
				
					$missao;
					$url = "https://www.habbo$habboServer/api/public/users?name=$habboName";
					$curl_handle=curl_init();
					curl_setopt($curl_handle, CURLOPT_URL,$url);
					curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
					curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);//Desliguei o SSL pq estou em localhost e nao tenho certificado SSL aqui.
					curl_setopt($curl_handle, CURLOPT_USERAGENT, 'spider');
					$query = curl_exec($curl_handle);
					$infos = json_decode($query,true);
					//var_dump($query);
					curl_close($curl_handle);
					//print("Dados: ".$dados['codigo_hb_name']."</br>");
					//print( $infos['motto']);
					
					if((string) $dados['codigo_hb_name'] == ((string) $infos['motto'])){//Habbo Avatar Owner CONFIRMADO.  Registro...:
						//print("SIM");
						//print("");
						set_timing($habboServer);
						$datetime = date("Y-m-d H:i:s");
						$query = mysqli_query($connect,"INSERT INTO usuarios (habbo_name,senha,server,criado_timestamp) VALUES ('$habboName','$cadastrarSenha','$habboServer','$datetime');");
						//Mudando o status da base de dados de confirmação. O usuário já tem o Habbo Avatar Owner verificado
						//A próxima verificação será do E-mail. É importante cadastrar com o email para que o usuário possa desbloquear recursos que o sistema disponibiliza
						$query = mysqli_query($connect,"UPDATE codigo_confirmacao SET status = 1,codigo_hb_name = null WHERE habbo_name = '$habboName' AND server = '$habboServer';");
						
						echo("{\"response\":\"hb-name-confirmed\",\"habbo_name\":\"$habboName\",\"habbo_server\":\"$habboServer\"}");
						
					}else{
						//print("NÃO");
						echo("{\"response\":\"hb-name-not-confirmed\",\"habbo_name\":\"$habboName\",\"habbo_server\":\"$habboServer\"}");
						//App Client precisa pedir confirmação até 4 vezes pois pode ser um problema de conexão do servidor. 
					}
				}				
			}else{//O servidor não é habbo, ou não está aceitando cadastro no sistema do CHAToon
				echo("{\"response\":\"hb-server-not-accepted\",\"habbo_name\":\"$habboName\",\"habbo_server\":\"$habboServer\"}");
			}

		}
	}
}

mysqli_close($connect);