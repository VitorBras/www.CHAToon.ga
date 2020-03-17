<?php


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

function userStatusChnge($status){//Mudar status do usuário

}

function userData($hbName,$hbServer){//Retorna dados do usuário
	$connect = mysqli_connect("localhost","root","","db_sistemachat");
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
		mysqli_close($connect);
	}else{
		return("already_registered");
	}
}

registerGroup("nada",["Medo","Polícias","Insônia"],"146985034",".com.br","Administrador.4");


?>