<?php

$habboName = "Administrador.4"; //Valor pego da variável global da sessão
$habboServer = ".com.br";//O valor ser´pego da variável global da sessão.
$logado = true; //valor será pego da variável global da sessão

if($logado == true){//Só executa caso a sessão esteja logada.
	
	//Capturando UniqueID Habbo.
	$url = "https://www.habbo$habboServer/api/public/users?name=$habboName";
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL,$url);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);//Desliguei o SSL pq estou em localhost e nao tenho certificado SSL aqui.
	curl_setopt($curl_handle, CURLOPT_USERAGENT, 'spider');
	$query = curl_exec($curl_handle);
	$infos = json_decode($query,true);
	//var_dump($query);

	//echo($infos["uniqueId"]);
	curl_close($curl_handle);


	//Buscando a array de quartos do usuário

	$urlGruposAPI = "https://www.habbo.com/api/public/users/".$infos["uniqueId"]."/rooms";
	$curl_grupos_handle = curl_init();
	curl_setopt($curl_grupos_handle, CURLOPT_URL,$urlGruposAPI); 
	curl_setopt($curl_grupos_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_grupos_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_grupos_handle, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl_grupos_handle, CURLOPT_USERAGENT, 'spider');
	$dados_retornados = curl_exec($curl_grupos_handle);
	$rooms = json_decode($dados_retornados,true);

	echo("{\"dados\":$dados_retornados}");
	
}else{
	echo("Você precisa logar.");
	//header("location:login.php");
}

?>