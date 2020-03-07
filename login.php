



<html>
<head>
	<title>CHAToon - Login</title>
</head>
<body>

	<div class="box-capsula">
		<h1>CHAToon</h1>
		<h3>Entre, convide amigos e falem a vontade!</h3>
	</div>
	<div class="login-box login-box-positioned " >
		<div class="login-box-transparente">
			<ul class="warnings">
				<li id="hb_name_existence" >Usuário não cadastrado</li>
				<li id="hb_name_patter" >Este nome não é aceitável</li>
				<li id="banned_account" >Esta conta foi banida permanentemente</li>
				<li id="banned_account_date" >Esta conta está banida até []</li>
				<li id="account_pass_patter" >Senha incorreta</li>
			</ul>
			<div class="explain-confirm">
				<span class="explain-text-principal">Vem bater um papo!</span>
				<span class="explain-text-secundario">Logue em sua conta agora!</span>
				
			</div>
			<table id="mode-tabela">
				<tr><td> <input type="text" class="input-username input" placeholder="Seu nome"> </td></tr>
				<tr><td> <input type="password" class="input-userpass input" placeholder="Sua senha"> </td></tr>
				<tr><td>
					<select id="servidor" name="servidor" required> 
							<option value="nothing-selected" selected>Em qual servidor Habbo?</option>
							<option value=".com.br">.com.br</option>
							<option value=".com">.com</option>
							<option value=".de">.de</option>
							<option value=".es">.es</option>
							<option value=".fi">.fi</option>
							<option value=".fr">.fr</option>
							<option value=".it">.it</option>
							<option value=".nl">.nl</option>
							<option value=".com.tr">.com.tr</option>
					</select>
				</tr></td>
			</table>
		</div>
		<div class="login-box-transparente2">
			<button class="button-box button-login" onclick="logar();">Logar</button>
			<button class="button-box button-register" onclick="registrar();">Registrar</button>
		</div>
	</div>
<link href="styles/login.css" rel="stylesheet" />
<script src="styles/login.js"></script>
<script src="frameworks/jquery-3.4.1.min.js"></script>

</body>
<html>