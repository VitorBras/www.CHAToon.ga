//Abas onde estou TRABALHANDO: ABAS ABERTAS

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
	
	//Identifica qual campo/dado está sendo alterado. Colhe os dados dos inputs e manda para variáveis.
	//Das variáveis vão para o servidor
	
	//De acordo com a resposta do servidor a aplicação altera sua interface setInterface(estado);
	
}

function setInterface(estado){
	switch(estado){
		case "status_changing":
			if(document.querySelector(".btn_mudar_status").getAttribute("clicked") == 'false'){
				document.querySelector(".btn_mudar_status").setAttribute("clicked","true");
					document.querySelector("#opt_status").setAttribute("adaptacao","true");
			}else{
				document.querySelector(".btn_mudar_status").setAttribute("clicked","false");
			}
			break;
		case "email_changing":
			if(document.querySelector(".btn_mudar_email").getAttribute("clicked") == 'false'){
				document.querySelector(".btn_mudar_email").setAttribute("clicked","true");
			}else{
				document.querySelector(".btn_mudar_email").setAttribute("clicked","false");
			}
			break;
		case "senha_changing":
			if(document.querySelector(".btn_apenas_mudar_senha").getAttribute("clicked") == 'false'){
				document.querySelector(".btn_apenas_mudar_senha").setAttribute("clicked","true");
				document.querySelector(".box_change_password").setAttribute("visible","true");
			}else{
				document.querySelector(".btn_apenas_mudar_senha").setAttribute("clicked","false");
				document.querySelector(".btn_apenas_mudar_senha").setAttribute("clicked","false");
			}
			break;
		case "close_box_password_change":
			document.querySelector(".box_change_password").setAttribute("visible","false");
			document.querySelector(".btn_apenas_mudar_senha").setAttribute("clicked","false");
			break;
		case "close_email_change":
			document.querySelector(".btn_mudar_email").setAttribute("clicked","false");
			break;
		case "close_status_changing":
			document.querySelector(".btn_mudar_status").setAttribute("clicked","false");
			document.querySelector("#opt_status").setAttribute("adaptacao","false");
			break;
	}
}

