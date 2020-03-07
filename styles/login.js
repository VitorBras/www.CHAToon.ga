
var cookies = [];

function cookie(name,value){
	this.name = name;
	this.value = value;
}

function separate_cookies(string){
	let cookies = [];
	for(i=0,x=0;i<string.length;i++){
		
		if(string[i] == ";"){
			x++;
		}else{
			if(cookies[x] == null | cookies[x] == undefined){
				if(string[i] != " "){
					cookies[x] = string[i];
				}
			}else{
				if(string[i] != " "){
					cookies[x] += string[i];
				}
				
			}
		}
	}
	//console.log(cookies);
	return cookies;
}

function cookieBuild(string){
	let name = null;
	let value = null;
		for(i=0;i<string.length;i++){
			for(ii=0,x=0;ii<string[i].length;ii++){
			if(x == 0){
				if(string[i][ii] != "="){
					if(name == null){
						name = string[i][ii];
					}else{
						name += string[i][ii];
					}
				}else{
					x = 1;
				}
			}else{
				if(value == null){
					value = string[i][ii];
				}else{
					value += string[i][ii];
				}
			}
			if(ii == string[i].length-1){
				cookies[i] = new cookie(name,value);
				name = null; value = null;
			}
		}
	}
	
	return cookies;
}

function getCookies(){
	return cookieBuild(separate_cookies(document.cookie));
}
//---------------------------------------Aqui começo a codificar


getCookies();
for(i=0;i<cookies.length;i++){
	if(cookies[i].name == "username"){
		username = cookies.value;
		document.querySelector(".input-username").value = cookies[i].value;
	}
}

//________________________________Programando Sistema de Login


function ir_dashboard(){
	window.location = "dashboard.php";
	document.cookie = "username="+document.querySelector('.input-username').value;
}

function registrar(){
	window.location = "registrar.php";
}

function start_warnings(cause){
	switch(cause){
		case "senha-incorreta":
			document.querySelector(".explain-text-secundario").innerHTML = "Senha incorreta";
			document.querySelector(".explain-text-secundario").setAttribute("style","display:block;");
			document.querySelector(".explain-text-secundario").setAttribute("style","color:red;");
			break;
		case "conta-banida":
			document.querySelector(".explain-text-secundario").innerHTML = "Conta banida";
			document.querySelector(".explain-text-secundario").setAttribute("style","display:block;");
			document.querySelector(".explain-text-secundario").setAttribute("style","color:red;");
			break;
		case "nao-registrado":
			document.querySelector(".explain-text-secundario").innerHTML = "Usuário(a) não registrado(a)";
			document.querySelector(".explain-text-secundario").setAttribute("style","display:block;");
			document.querySelector(".explain-text-secundario").setAttribute("style","color:black;");
			break;
	}
}

function logar(){
	let hbname = document.querySelector(".input-username").value;
	let senha = document.querySelector(".input-userpass").value;
	let server = document.querySelector("#servidor").value;
	$.ajax({
		url:"functions/logarUsuario.php",
		type:"GET",
		data:{hbname:hbname,senha:senha,hbserver:server},
		success:function(response){
			console.log("Resposta do servidor: "+response);
			let resposta = JSON.parse(response);
			switch(resposta.response){
				case "logado" :
					ir_dashboard();
					break;
				case "senha-incorreta" :
					start_warnings("senha-incorreta");
					console.log("Senha incorreta.");
					break;
				case "banned" :
					console.log("A conta foi banida.");
					start_warnings('conta-banida');
					break;
				case "nao-registrado" :
					console.log("Usuário não cadastrado.");
					start_warnings('nao-registrado');
					break;
				case "no-data-sended" :
					console.log("Não foi enviados os dados necessários ao servidor.");
					break;
			}
		}
	});
}

