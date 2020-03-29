//Abas onde estou TRABALHANDO: ABAS ABERTAS

var serverUrl = "localhost/TESTEDECODIGO/Chat/www.CHAToon.ga/"

var disponibilidade;
var status;
var email;
var senha = {alterando:false,nova:{inputUm:null,inputDois:null}};
var dadosCookies = {hbname:null,hbserver:null};

var allCookies = document.cookie;

//Pegar dados de cookies (nesses cookies guarda-se valores de variáveis de sessão)
function pegarDadosSessao(){//Utilizando RegEx para pegar dados de cookies
	let expression_hbname = /(?<=hbname\=).+?(?=;)/; //(hbname=.+?;)
	let expression_hbserver = /(?<=hbserver\=).+?(?=;)/;  //(hbserver=.+?;)
	if(expression_hbname.test(allCookies) == true && expression_hbserver.test(allCookies) == true){
		dadosCookies.hbname = expression_hbname.exec(allCookies)[0];
		dadosCookies.hbserver = expression_hbserver.exec(allCookies)[0];
	}else{
		console.log("Um dos cookies ou os dois não foram gerados. Provavelmente a sessão não está logada.");
	}
	//console.log(expression_hbserver.exec(allCookies));
}
pegarDadosSessao();

//-------------
function disponibilidadeChange(elemento){//Enviar ao servidor o pedido de novo estado de disponibilidade
	
}
function changeSenha(elemento){
	//Iniciar a mudança de senha
	if(senha.alterando == false){
		if(elemento.className == "password_typing newPassone"){
			senha.nova.inputUm = elemento.value;
		}else{
			senha.nova.inputDois = elemento.value;
		}
	}
	//Verificar se os dois campos do input de senha nova coincidem (confirmação de nova senha)
	if(senha.nova.inputUm == senha.nova.inputDois && senha.nova.inputDois != null ){
		console.log("As senhas coincidem");
		elemento.setAttribute("incorreta","false");
	}else if(senha.nova.inputDois != null){//As senhas digitadas nos dois inputs não coincidem
		console.log("As senhas não se coincidem");
		elemento.setAttribute("incorreta","true");
	}
	//Envia ao servidor o pedido para mudar senha
	
}

function goToAmigos(){
	console.log("Ir ao Amigos.(amigos.php)");
}

function goToBusiness(){
	console.log("Ir ao Negócios.(marketplace.php)");
}

function goToPerfil(){
	console.log("Ir ao perfil.(dashboard.php)");
}

function confirmar(processo){//Botão (confirmar) na caixa de confirmação de código chama esta função.
	let codigo = document.querySelector(".input_de_codigo").value;//Tratar entrada aqui.
	switch(processo){
		case "confirmar_codigo_email":
			$.ajax({
				url:"functions/confirmarEmail.php",
				type:"GET",
				//data:{hbname:dadosCookies.hbname,hbserver:dadosCookies.hbserver,confirmCode:codigo},
				data:{confirmCode:codigo},
				success:function(response){
					response = JSON.parse(response);
					
					if(response.response == "email_confirmed"){//O E-mail foi confirmado
						setInterface("email_confirmed");
						console.log("E-mail confirmado com sucesso!");
					}else if(response.response == "incorrect_code"){//Código incorreto/E-mail não confirmado
						console.log("Código de confirmação incorreto!");
						setInterface("email_code_incorrect_to_confirm");
					}else if(response.response == "user_no_logged"){//Usuário não logado
						
					}else if(response.response == "have_no_email_to_verify"){//Não há email para verificar
						console.log("Não há email para verificar.");
						setInterface("have_not_email_to_confirm");//_____________________________________________
					}
				}
			});
			break;
	}
}

function salvar(){
	console.log("Salvar");
	
	//Ajustando a posição do select
	document.querySelector("#opt_status").setAttribute("adaptacao","oneFalse");
	
	//Identifica qual campo/dado está sendo alterado. Colhe os dados dos inputs e manda para variáveis.
	if(document.querySelector(".btn_mudar_status").getAttribute("clicked") == "true"){//Editando status
		console.log("Requisição enviada");
		//Pegar valor criado
		status = document.querySelector(".area_text_status").value;
		//Enviar dados ao servidor para registrar um novo status
		$.ajax({
			url:"functions/userSettings.php",
			type:"GET",
			data:{processo:"change_status",newStatus:status,PHPSESSID:"o1ogb822rt2l8guii1jdk5fsoq"},
			success:function(response){//Informar ao usuário que deu certo
				console.log(response);
			}
		});
		//Reabilitando os botões de configuração
		setInterface("reabilitar_botoes_configuracao");
		
		document.querySelector(".btn_apenas_mudar_senha").setAttribute("clicked","false");
		document.querySelector(".btn_apenas_mudar_senha").setAttribute("visible","yes");
	} else if(document.querySelector(".btn_mudar_email").getAttribute("clicked") == "true"){//Editando Email
		
		email = document.querySelector(".area_text_email").value;
		//Enviar dados ao servidor para registrar um novo status
		$.ajax({
			url:"functions/userSettings.php",
			type:"GET",
			data:{processo:"change_email",newEmail:email,PHPSESSID:"o1ogb822rt2l8guii1jdk5fsoq"},
			success:function(response){//Informar ao usuário que deu certo
				console.log(response);
				response = JSON.parse(response);
				//CAso a mudança seja iniciada, adaptar a interface para a confirmação do código
				if(response.response == "confirm_email_step"){//Email em processo de confirmação
					setInterface("email_confirm");
				}
			}
		});
		
		//Reabilitando os botões de configuração
		setInterface("reabilitar_botoes_configuracao");
		
	} else if(document.querySelector(".btn_apenas_mudar_senha").getAttribute("clicked") == "true"){//Editando Senha
		
		
		//Reabilitando os botões de configuração
		setInterface("reabilitar_botoes_configuracao");
	}
	
	//Das variáveis vão para o servidor
	
	//De acordo com a resposta do servidor a aplicação altera sua interface setInterface(estado);
	
	//Todos os botões precisam estar com o atributo CLICKED=FALSE
	document.querySelector(".btn_mudar_status").setAttribute("clicked","false");
}
function resendCode(){//Pedir ao servidor para reenviar o código de confirmação.
	console.log("resendCode()");
	//Verificar o que está sendo confirmado
	if(document.querySelector(".box-confirmacao").getAttribute("confirmando") == "email"){//Confirmando código email
		//Enviar ao servidor uma requisição para ele reenviar o código para o email novamente
		console.log("Enviar requisição :resendCode()");
		$.ajax({
			url:"functions/confirmarEmail.php",
			type:"GET",
			data:{resendCodeToEmail:true},
			success:function(response){
				response = JSON.parse(response);
				console.log(response);
				if(response.response == "email_resended"){//O código foi reenviado ao email que está em verificação com sucesso.
					console.log("O código foi reenviado ao email.");
				}else if(response.response == "email_not_resended"){//O código não foi enviado ao email que está em verifi...
					console.log("O código não foi reenviado ao email..");
				}
			},
			error:function(erro){
				console.log(erro);
			}
		});
	}else if(document.querySelector(".box-confirmacao").getAttribute("confirmando") == "phone_number"){
		//Não existe uma confirmação para Número de telefone ainda. Não fiz o CHAToon com esta funcionalidade. Em versoes posteriores irei adicionaar
	}
}
function setInterface(estado){
	switch(estado){
		case "status_changing":
			if(document.querySelector(".btn_mudar_status").getAttribute("clicked") == 'false'){
				document.querySelector(".btn_mudar_status").setAttribute("clicked","true");
				document.querySelector(".btn_mudar_status").setAttribute("visible","not");
				document.querySelector("#opt_status").setAttribute("adaptacao","threeTrue");
				
				//Botão salvar
				document.querySelector(".botao_salvar").setAttribute("visible","yes");
				//Demais configurações inabilitadas
				document.querySelector(".btn_mudar_email").setAttribute("visible","not");
				document.querySelector(".btn_apenas_mudar_senha").setAttribute("visible","not");
			}else{
				document.querySelector(".btn_mudar_status").setAttribute("clicked","false");
			}
			break;
		case "email_changing":
			if(document.querySelector(".btn_mudar_email").getAttribute("clicked") == 'false'){
				document.querySelector(".btn_mudar_email").setAttribute("clicked","true");
				document.querySelector(".btn_mudar_email").setAttribute("visible","not");
				document.querySelector("#opt_status").setAttribute("adaptacao","twoTrue");
				
				//Botão salvar
				document.querySelector(".botao_salvar").setAttribute("visible","yes");//RESOLVER
				//Demais configurações inabilitadas
				document.querySelector(".btn_mudar_status").setAttribute("visible","not");
				document.querySelector(".btn_apenas_mudar_senha").setAttribute("visible","not");
			}else{
				document.querySelector(".btn_mudar_email").setAttribute("clicked","false");
			}
			break;
		case "senha_changing":
			if(document.querySelector(".btn_apenas_mudar_senha").getAttribute("clicked") == 'false'){
				document.querySelector(".btn_apenas_mudar_senha").setAttribute("clicked","true");
				document.querySelector(".btn_apenas_mudar_senha").setAttribute("visible","not");
				document.querySelector(".box_change_password").setAttribute("visible","true");
				
				//Alocando o botão salvar através do Javascript porque CSS tá sendo COMPLICADO D+
				document.querySelector(".botao_salvar").setAttribute("positioned","true");
				
				//Botão salvar
				document.querySelector(".botao_salvar").setAttribute("visible","yes");
				//Demais configurações inabilitadas
				document.querySelector(".btn_mudar_status").setAttribute("visible","not");
				document.querySelector(".btn_mudar_email").setAttribute("visible","not");
			}else{
				document.querySelector(".btn_apenas_mudar_senha").setAttribute("clicked","false");
			}
			break;
		case "close_box_password_change":
			document.querySelector(".box_change_password").setAttribute("visible","false");
			document.querySelector(".btn_apenas_mudar_senha").setAttribute("clicked","false");
			document.querySelector(".btn_apenas_mudar_senha").setAttribute("visible","yes");
			//Alocando o botão salvar através do Javascript porque CSS tá sendo COMPLICADO D+
			document.querySelector(".botao_salvar").setAttribute("positioned","false");
			
			//Desabilitando botão salvar
			document.querySelector(".botao_salvar").setAttribute("visible","not");
			//Demais configurações reabilitadas
			document.querySelector(".btn_mudar_status").setAttribute("visible","yes");
			document.querySelector(".btn_mudar_email").setAttribute("visible","yes");
			break;
		case "close_email_change":
			document.querySelector(".btn_mudar_email").setAttribute("clicked","false");
			document.querySelector(".btn_mudar_email").setAttribute("visible","yes");
			//Alocando o botão salvar através do Javascript porque CSS tá sendo COMPLICADO D+
			document.querySelector(".botao_salvar").setAttribute("positioned","false");
			
			//Desabilitando botão salvar
			document.querySelector(".botao_salvar").setAttribute("visible","not");
			//Demais configurações inabilitadas
			document.querySelector(".btn_mudar_status").setAttribute("visible","yes");
			document.querySelector(".btn_apenas_mudar_senha").setAttribute("visible","yes");
			break;
		case "close_status_changing":
			document.querySelector(".btn_mudar_status").setAttribute("clicked","false");
			document.querySelector(".btn_mudar_status").setAttribute("visible","yes");
			document.querySelector("#opt_status").setAttribute("adaptacao","oneFalse");
			//Alocando o botão salvar através do Javascript porque CSS tá sendo COMPLICADO D+
			document.querySelector(".botao_salvar").setAttribute("positioned","false");
			//Desabilitando botão salvar
			document.querySelector(".botao_salvar").setAttribute("visible","not");
			//Demais configurações inabilitadas
			document.querySelector(".btn_mudar_email").setAttribute("visible","yes");
			document.querySelector(".btn_apenas_mudar_senha").setAttribute("visible","yes");
			break;
		case "reabilitar_botoes_configuracao":
			//Reabilitando os botões de configuração
			document.querySelector(".btn_mudar_status").setAttribute("clicked","false");
			document.querySelector(".btn_mudar_status").setAttribute("visible","yes");
			document.querySelector(".btn_mudar_email").setAttribute("clicked","false");
			document.querySelector(".btn_mudar_email").setAttribute("visible","yes");
			document.querySelector(".botao_salvar").setAttribute("visible","not");
			break;
		case "email_confirm":
			document.querySelector("#texto1").children[0].innerText = "Confirmar Email";
			document.querySelector(".box-confirmacao").setAttribute("confirmando","email");
			document.querySelector("#texto1").setAttribute("visible","yes");
			document.querySelector(".box-search").setAttribute("visible","yes");
			document.querySelector(".input_de_codigo").setAttribute("visible","yes");
			document.querySelector("#codigo_confirmacao").innerHTML = "Digite o código aqui";
			document.querySelector(".btn-confirmar").setAttribute("visible","yes");
			document.querySelector(".btn-resend-code").setAttribute("visible","yes");
			break;
		case "email_confirmed":
			document.querySelector(".box-confirmacao").setAttribute("confirmando","");
			document.querySelector(".input_de_codigo").setAttribute("visible","no");
			document.querySelector("#codigo_confirmacao").innerHTML = "Email confirmado!";
			document.querySelector(".btn-resend-code").setAttribute("visible","no");
			document.querySelector(".btn-confirmar").setAttribute("visible","no");
			setTimeout(function(){
				document.querySelector("#codigo_confirmacao").innerHTML = "";
				document.querySelector("#texto1").setAttribute("visible","no");
			},3000);
			break;
		case "email_code_incorrect_to_confirm":
			document.querySelector(".input_de_codigo").setAttribute("visible","yes");
			document.querySelector("#codigo_confirmacao").innerHTML = "Código incorreto!";
			setTimeout(function(){
				document.querySelector("#codigo_confirmacao").innerHTML = "";
				document.querySelector("#texto1").children[0].innerText = "Confirmar Mudanças";
			},3000);
			break;
		case "have_not_email_to_confirm":
			document.querySelector(".box-confirmacao").setAttribute("confirmando","");
			document.querySelector(".input_de_codigo").setAttribute("visible","no");
			document.querySelector("#codigo_confirmacao").innerHTML = "Não há email para confirmar!";
			document.querySelector(".btn-resend-code").setAttribute("visible","no");
			document.querySelector(".btn-confirmar").setAttribute("visible","no");
			
			setTimeout(function(){
				document.querySelector("#codigo_confirmacao").innerHTML = "";
				document.querySelector("#texto1").setAttribute("visible","no");
			},3000);
			break;
	}
}

