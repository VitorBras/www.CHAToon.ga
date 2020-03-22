//Abas onde estou TRABALHANDO: ABAS ABERTAS

var disponibilidade;
var status;
var email;
var senha = {alterando:false,nova:{inputUm:null,inputDois:null}};

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
	console.log("Ir ao Negócios.(marketplace.php)")
}

function goToPerfil(){
	console.log("Ir ao perfil.(dashboard.php)")
}

function salvar(){
	console.log("Salvar");
	
	//Todos os botões precisam estar com o atributo CLICKED=FALSE
	document.querySelector(".btn_mudar_status").setAttribute("clicked","false");
	
	//Ajustando a posição do select
	document.querySelector("#opt_status").setAttribute("adaptacao","oneFalse");
	
	//Identifica qual campo/dado está sendo alterado. Colhe os dados dos inputs e manda para variáveis.
	if(document.querySelector(".btn_mudar_status").getAttribute("clicked") == "true"){//Editando status
		//Pegar valor criado
		status = document.querySelector(".area_text_status").value;
		//Enviar dados ao servidor para registrar um novo status
		$.ajax({
			url:"function/userSettings.php",
			type:"GET",
			data:{processo:"change_status",newStatus:status},
			success:function(response){
				
			}
		});
	}
	if(document.querySelector(".btn_mudar_email").getAttribute("clicked") == "true"){//Editando E-mail
		
	}
	if(document.querySelector(".btn_apenas_mudar_senha").getAttribute("clicked") == "true"){//Editando senha
		
	}
	//Das variáveis vão para o servidor
	
	//De acordo com a resposta do servidor a aplicação altera sua interface setInterface(estado);
	
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
	}
}

