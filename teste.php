<?php

$url = "https://www.habbo.com.br/api/public/users?name=Administrador.4";
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
		//var_dump($infos);
		
?>