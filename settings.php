<?php

require("functions/generalFunctions.php");



//-----------------------INICILIALIZAÇÃO DE SESSÂO ARTIFICIAL   (APENAS PARA DESENVOLVIMENTO)
session_id("o1ogb822rt2l8guii1jdk5fsoq");
session_start();

$_SESSION['adm'] = "Vitor Gomes";
$_SESSION['hbserver'] = ".com.br";
$_SESSION['hbname'] = "VitorGp";
$_SESSION['logado'] = true;

echo("<script>

console.log('Administrador = ".$_SESSION['adm']." ');
console.log('Servidor = ".$_SESSION['hbserver']." ');
console.log('Nome = ".$_SESSION['hbname']." ');
console.log('Logado Var = ".$_SESSION['logado']." ');
</script>
");
//Passando dados da sessão para lado cliente para que ele possa enviar requisições com base em sua sessão
setcookie("hbname",$_SESSION['hbname']);
setcookie("hbserver",$_SESSION['hbserver']);
//---------------------------------INICIALIZAÇAO DE SESSAO ARTIFICIAL REALIZADA


?>


<html>
	<head>
		<title>Configurações</title>
		<meta charset="utf-8">
		<h4></h4>
	</head>
	<body>
		<div class="boxBase-One">
			<nav class="menu-bar">
				<div class="box-menu-bar">
					<button class="button-negocios botoes-menu" onclick="goToBusiness();">Negócios</button>
					<button class="button-friendsbotoes-menu botoes-menu" onclick="goToAmigos();">Amigos</button>
					<button class="button-configuracoes botoes-menu" onclick="goToPerfil();">Perfil</button>
					<button class="button-configuracoes botoes-menu" onclick="salvar();">Salvar</button>
				</div>
			</nav>
			<div class="boxBase-Two">
				<table class="molde-lista-quartos">
					<tr>
						<td><span>Nome</span></td>
						<td>
							<span class="hbName"><?php echo($_SESSION['hbname']);?></span>
						</td>
						<td>
							<select id="opt_status" adaptacao="oneFalse">
								<option>Disponível</option>
								<option>Meio Ocupado</option>
								<option>Ocupado</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><span class="nomenclatura">Status:</span></td>
						<td>
							<button class="btn_mudar_senha btn_mudar_status" clicked='false' onclick="setInterface('status_changing');"><div></div></button>
							<table class="modelo_insercao_status">
								<tr>
									<td>
										<textarea class="area_text_status"></textarea>
									</td>
									<td>
										<div class="icone_close_status_change" onclick="setInterface('close_status_changing');"><div></div></div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="3"><?php //  nÃ£o ?>
							<span class="status_atual"><?php echo(utf8_encode(friendlyDataUser(userData($_SESSION['hbname'],$_SESSION['hbserver'])['status'],"status")));?></span>
						</td>
					</tr>
					<tr>
						<td style="min-width:60px;"><span>E-mail:</span></td>
						<td id="buttonsTD-area" class="space-in-table">
							<span id="email_usuario"><?php echo(friendlyDataUser(userData($_SESSION['hbname'],$_SESSION['hbserver'])['email'],"email"));?></span>
							<button class="btn_mudar_senha btn_mudar_email" visible="yes" clicked='false' onclick="setInterface('email_changing');"><div></div></button>
							<table class="modelo_de_input_de_email">
								<tr>
									<td>
										<input class="area_text_email" type="email">
									</td>
									<td>
										<div class="icone_close_area_text_email" onclick="setInterface('close_email_change');"><div></div></div>
									</td>
								</tr>	
							</table>
						</td>
					</tr>
					<tr>
						<td><span>Senha:</span></td>
						<td>
							<button class="btn_mudar_senha btn_apenas_mudar_senha" visible="yes" clicked="false" onclick="setInterface('senha_changing');"><div></div></button>
						</td>
					</tr>
					<tr>
						<td colspan="3" id="zona-btn-criar-grupo">
							<div>
								<button class="button-salvar-settings botao_salvar" visible="not" positioned="false" onclick="salvar();">Salvar</button>
							</div>
						</td>
					</tr>
				</table>
				<div class="box_change_password" visible='false'>
					<div class="botao_fechar_box_senha" onclick="setInterface('close_box_password_change');"></div>
					<span>Insira uma nova senha</span>
					<table>
						<tr>
							<td>
								<input class="password_typing newPassone" incorreta="false" onchange="changeSenha(this);" type="text">
							</td>
						</tr>
						<tr>
							<td>
								<input class="password_typing newPasstwo" incorreta="false" onchange="changeSenha(this);" type="text">
							</td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="boxBase-Three" >
				<div class="box-search">
					<div id="texto1" visible="yes">
						<span>Confirmar Mudança</span>
					</div>
				</div>
				<div class="box-confirmacao" confirmando="">
					<div>
						<div>
							<table class="modelo_confirmacao" >
								<tr>
									<td><span class="span_text_code">Código</span></td>
								</tr>
								<tr>
									<td>
										<span id="codigo_confirmacao" visible="yes">085947</span>
										<input type="text" class="input_de_codigo" maxlength="6" visible="no">
									</td>
								</tr>
								<tr>
									<td><button class="button-salvar-settings btn-confirmar" onclick="confirmar('confirmar_codigo_email');" visible="no">Confirmar</button></td>
								</tr>
								<tr>
									<td><button class="button-salvar-settings btn-resend-code" onclick="resendCode();" visible="no";>Reenviar código</button></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="boxBase-Four">
				<div class="boxContent-resultados">
					
				</div>
			</div>
		</div>
	</body>
	<link href="styles/settings.css" rel="stylesheet" />
	<script src="styles/settings.js"></script>
	<script src="frameworks/jquery-3.4.1.min.js"></script>
	
	<!-- Importando a biblioteca de CSS Bootstrap ao projeto -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	-->
</html>


