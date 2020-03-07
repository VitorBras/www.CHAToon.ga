<?php

$server = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "db_sistemachat";

$connect = mysqli_connect($server,$dbUser,$dbPass,$dbName);

$hbname;
$hbserver;
$senha;

if(isset($_REQUEST['hbname']) and isset($_REQUEST['senha']) and isset($_REQUEST['hbserver'])){
	$hbname = $_REQUEST['hbname'];
	$hbserver = $_REQUEST['hbserver'];
	$senha = $_REQUEST['senha'];
	
	$hbname = strtolower($_REQUEST['hbname']);
	$hbserver = strtolower($_REQUEST['hbserver']);

	$query = mysqli_query($connect,"SELECT senha,ban FROM usuarios WHERE habbo_name = '$hbname' AND server = '$hbserver';"); 
	$dados = mysqli_fetch_assoc($query);
	if($dados != null){
		if($dados['ban'] == "0" | $dados['ban'] == 0 | $dados['ban'] == false | $dados['ban'] == "false"){
			if($dados['senha'] == $senha){
				session_start();
				$_SESSION['logado'] = true;
				
				echo("{\"response\":\"logado\"}");
			}else{
				echo("{\"response\":\"senha-incorreta\"}");
			}
		}else{
			echo("{\"response\":\"banned\"}");
		}
	}else{
		echo("{\"response\":\"nao-registrado\"}");
	}
	//O usuário está banido?
	
}else{
	echo("{\"response\":\"no-data-sended\"}");
	
}

?>