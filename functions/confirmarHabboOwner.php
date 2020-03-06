<?php
$habboName;

$server = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "db_sistemachat";

$connect = mysqli_connect($server,$dbUser,$dbPass,$dbName);


if(isset($_REQUEST['processo'])){
	if($_REQUEST['processo'] == "confirmar-habbo-owner"){
		if(isset($_REQUEST['habbo_name']) and isset($_REQUEST['habbo_server'])){
			$habboName = $_REQUEST['habbo_name'];//Colocar um filtro ANTI SQL INJECTION aqui
			$habboServer = $_REQUEST['habbo_server'];//Colocar um filtro ANTI SQL INJECTION aqui
			$resultado = mysqli_query($connect,"SELECT codigo_hb_name,status FROM codigo_confirmacao WHERE habbo_name = '$habboName' AND server = '$habboServer';");
			//print(mysqli_error($connect));
			//var_dump($resultado);
			$dados = mysqli_fetch_assoc($resultado);
			//Verificar se precisa mesmo verificar se a conta Habbo pertence ao indivíduo
			if($dados['status'] == "0" or $dados['status'] == 0){//Sim
				//Verificar se o código de confirmação foi colocado na missão do avatar a ser REGISTRADO DEFINITIVAMENTE
				//print($dados['codigo_hb_name']);
			
				$missao;
				$url = "https://www.habbo.com.br/api/public/users?name=Te_Importa?";
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
					
					echo("{\"response\":\"hb-name-confirmed\",\"habbo_name\":\"$habboName\",\"habbo_server\":\"$habboServer\"}");
				}else{
					//print("NÃO");
					echo("{\"response\":\"hb-name-not-confirmed\",\"habbo_name\":\"$habboName\",\"habbo_server\":\"$habboServer\"}");
					//App Client precisa pedir confirmação até 4 vezes pois pode ser um problema de conexão do servidor. 
					}

				
				
				/*
				switch(){
					
				}
				*/
			}
		}
	}
}

mysqli_close($connect);