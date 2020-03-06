



<html>
<head>
	<title>Registrar</title>
</head>
<body>

	<div class="box-capsula">
		<h1>CHAToon</h1>
		<h3>Entre, convide amigos e falem a vontade!</h3>
	</div>
	<div class="login-box login-box-positioned " >
		<div class="login-box-transparente">
			<ul class="warnings">
				<li id="hb_name_existence" >Este avatar não existe</li>
				<li id="hb_name_patter" >Este nome não é aceitável</li>
				<li id="banned_account" >Esta conta foi banida permanentemente</li>
				<li id="banned_account_date" >Esta conta está banida até []</li>
				<li id="account_pass_patter" >Esta senha não é aceitável</li>
				<li id="hb_name_nowrited_warn" >Você precisa digitar o nome do seu avatar no Habbo</li>
				<li id="hb_name_sobig_warn" >Você digitou um nome muito grande</li>
				<li id="hb_server_noselected_warn" >Você precisa selecionar o servidor em que joga</li>
			</ul>
			<div class="explain-confirm">
				<span class="explain-text-principal">Usuário já cadastrado!</span>
				<span class="explain-text-secundario">Logue na conta agora!</span>
				<span class="explain-confirm-text">Cole o código na missão do seu avatar</span>
				<span id="code-confirm">Código</span>
			</div>
			
			<table id="molde-tabela">
				<tr><td> <input type="text"  class="input-username input" name="hbName" id="hbName" placeholder="Nome do Avatar Habbo"> </td></tr>
				<tr><td>
					<input type="text" class="input-userpass input pos-confirm" placeholder="Sua senha" disabled><!-- Pós confirmação -->
					<input type="text" class="input-hbname-confirm-code input pos-confirm" placeholder="Digite o código" ><!-- Pós confirmação -->
					<button class="button-ir-logar" onclick="logar('already-registered');">Ir logar</button>
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
				</td></tr>
			</table>
		</div>
		<div class="login-box-transparente2">
			<button onclick="start_options('already-registered');">Teste</button>
			<button class="button-box button-login" style="display:none;">Logar</button>
			<button class="button-box button-register" onclick="confirm_hb_name();">Próximo</button>
		</div>
	</div>
<link href="styles/register.css" rel="stylesheet" />
<script src="styles/register.js"></script>
<script src="frameworks/jquery-3.4.1.min.js"></script>

</body>
<html>