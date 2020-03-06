

var habboName;
var habboServer;
var active_warnings = 0;

var not_confirmed_yet = 0;

function logar(caso){//Redireciona o usuário a página de login. Salva o nome de usuário no cookie.
	//Guardando o nome do usuário
	habboName = document.querySelector(".input-username").value;
	switch(caso){
		case "already-registered":
			console.log
			document.cookie = "username="+habboName;
			window.location.href = "login.php";
			break;
	}
	
}
function confirm_hb_avatar_owner(){//Pedir para o servidor confirmar a possa da conta do avatar habbo.
	
	$.ajax({
				url:"http://localhost/TESTEDECODIGO/Chat/www.CHAToon.ga/functions/confirmarHabboOwner.php",
				type:"GET",
				data:{processo:"confirmar-habbo-owner",habbo_name:habboName,habbo_server:habboServer},
				success:function(response){
					console.log("Server Response: "+response);
					console.log("habboName: "+habboName+" / habboServer: "+habboServer);
					let resposta = JSON.parse(response);

					switch(resposta.response){
						case "hb-name-confirmed" :
							console.log("Client App: UI Confirmed hbname");
							start_options("confirmed-hb-name",resposta.code);
							break;
						case "hb-name-not-confirmed" :
							console.log("Client App: UI Already Registered");
							start_options("hb-name-not-confirmed",null,resposta.hbname);
							break;
						case "" :
							
							break;
					}
					
				}
			});
}

function start_options(pagetype,code,hbname){//Acionar opções confirmação
	switch(pagetype){
		case "confirm-hb-name":
			console.log("Client App: UI CONFIRM HB NAME");
			document.querySelector("#servidor").setAttribute("style","display:none;");
			
			document.querySelector("#molde-tabela").setAttribute("style","top:4%;");
			document.querySelector(".input-username").setAttribute("disabled","");
			document.querySelector(".explain-confirm").setAttribute("style","display:block;");
			document.querySelector("#code-confirm").setAttribute("style","display:block;");
			document.querySelector("#code-confirm").innerHTML = code;
			document.querySelector(".explain-confirm-text").setAttribute("style","display:block;");
			document.querySelector(".button-register").innerHTML = "Confirmar";
			document.querySelector(".button-register").setAttribute("onclick","confirm_hb_avatar_owner();");
			document.querySelector(".explain-text-principal").innerHTML = "O avatar é mesmo seu?";
			document.querySelector(".explain-text-principal").setAttribute("style","display:block;");
			
			break;
		case "confirm-email":
			document.querySelector(".input-hbname-confirm-code").setAttribute("style","display:none;");
			break;
			
		case "confirm-phone-number":
		
			break;
		case "already-registered":
			document.querySelector(".input-hbname-confirm-code").setAttribute("style","display:none;");
			document.querySelector(".explain-confirm").setAttribute("style","display:block;");
			document.querySelector("#servidor").setAttribute("style","display:none;");
			document.querySelector("#molde-tabela").setAttribute("style","top:7%;");
			document.querySelector("#code-confirm").setAttribute("style","display:none;");
			document.querySelector(".input-username").setAttribute("disabled","");
			document.querySelector(".input-username").setAttribute("value",hbname);
			document.querySelector(".button-register").innerHTML = "Registrar outro";
			document.querySelector(".button-register").setAttribute("onclick","start_options('register-user')");
			document.querySelector(".button-ir-logar").setAttribute("style","display:block;");
			document.querySelector(".explain-text-principal").innerHTML = "Usuário já cadastrado!";
			document.querySelector(".explain-text-principal").setAttribute("style","display:block;");
			document.querySelector(".explain-text-secundario").innerHTML = "Logue nessa conta agora!";
			document.querySelector(".explain-text-secundario").setAttribute("style","display:block;");
			break;
		case "register-user" :
			document.querySelector(".input-username").disabled = false;
			document.querySelector(".input-username").setAttribute("value","");
			document.querySelector(".explain-text-principal").setAttribute("style","display:none;");
			document.querySelector(".explain-text-secundario").setAttribute("style","display:none;");
			document.querySelector("#molde-tabela").setAttribute("style","top:25%;");
			document.querySelector(".button-ir-logar").setAttribute("style","display:none;");
			document.querySelector("#servidor").setAttribute("style","display:block;");
			document.querySelector(".button-register").innerHTML = "Próximo";
			document.querySelector(".button-register").setAttribute("onclick","confirm_hb_name();");
			break;
		case "confirmed-hb-name" :
			//document.querySelector("#molde-tabela").setAttribute("style","top:4%;");
			//document.querySelector(".input-username").setAttribute("disabled","");
			//document.querySelector(".explain-confirm").setAttribute("style","display:block;");
			document.querySelector("#code-confirm").setAttribute("style","display:none;");
			//document.querySelector("#code-confirm").innerHTML = code;
			//document.querySelector(".explain-confirm-text").setAttribute("style","display:block;");
			//document.querySelector(".button-register").innerHTML = "Confirmar";
			document.querySelector(".button-register").setAttribute("style","display:none;");
			document.querySelector(".explain-confirm-text").setAttribute("style","display:none;");
			document.querySelector(".button-ir-logar").setAttribute("style","display:block;");
			//document.querySelector(".button-register").setAttribute("onclick","confirm_hb_avatar_owner();");
			document.querySelector(".explain-text-principal").innerHTML = "É seu mesmo! ^^";
			document.querySelector(".explain-text-principal").setAttribute("style","display:block;");
			document.querySelector(".explain-text-secundario").innerHTML = "Você está registrado(a) no CHAToon.";
			document.querySelector(".explain-text-secundario").setAttribute("style","display:block;");
			break;
		case "hb-name-not-confirmed" :
			if(not_confirmed_yet < 4){not_confirmed_yet++;//Pedir para confirmar novamente;
				setTimeout(function(){confirm_hb_avatar_owner(habboName,habboServer);},6000);
			}else{//Realmente o servidor não está conseguindo confirmar de que a conta é realmente do usuário. Talvez o usuário n~~ao esteja colando o código no lugar certo.
				
			}
			//Devo desenhar uma interface de recarregamento aqui.
			break;
	
	}
}
function adapt_ui_to_warnings(quantos){console.log(quantos);
	switch(quantos){
		case 0:
			document.querySelector("#molde-tabela").style = "top:25%;";
			break;
		case 1:
			document.querySelector("#molde-tabela").style = "top:8%;";
			break;
		case 2:
			document.querySelector("#molde-tabela").style = "top:8%;";		
			break;
		case 3:
			document.querySelector("#molde-tabela").style = "top:8%;";
			break;
		case 4:
			document.querySelector("#molde-tabela").style = "top:8%;";
			break;
		case 5:
			document.querySelector("#molde-tabela").style = "top:8%;";
			break;
		case 6:
			document.querySelector("#molde-tabela").style = "top:8%;";
			break;
		case 7:
			document.querySelector("#molde-tabela").style = "top:8%;";
			break;
		case 8:
			document.querySelector("#molde-tabela").style = "top:8%;";
			break;
		case 9:
			document.querySelector("#molde-tabela").style = "top:8%;";
			break;
	}
}

function show_warnings(warning){//Apresentar os erros na interface
	switch(warning){ 
		case "hbName-SoBig":
			document.querySelector("#hb_name_sobig_warn").style = "display:block;"; 
			document.querySelector(".input-username").style = "border: 2px solid #f43a3a;";
			break;
		case "hbName-nowrited":
	
			break;
		case "password-SoBig":
			
			break;
		case "password-SoLittle":
	
			break;
		case "server-noselected":
	
			break;
	}
	//Remodelando a interface gráfica devido a quantidade de erros disparados na tela:
	//... mas primeiro é necessário contar a quantidade de AVISOS disparados na tela. 
	var warnings = document.querySelector(".warnings");
	for(i=0,warnings_displayed=0;i<warnings.childElementCount;i++){
		if(warnings.children[i].style.display == "block"){
			warnings_displayed++;
		}
		if(i+1 == warnings.childElementCount){//Caso o loop esteja no final...
			active_warnings = warnings_displayed;//console.log('Final');
		}
	}
	adapt_ui_to_warnings(active_warnings);
}

function verifyHabboNamePatter(nome){//Verifica o padrão do nome habbo e retorna boleano. Caso permitido = true
	if(nome.length <= 16){
		if(nome != "" && nome != " "){
			document.querySelector(".input-username").style = "border: 2px solid #7fe86f;";//Tirando o aspecto de erro do input
			document.querySelector("#hb_name_sobig_warn").style = "display:none;";
			return(true);
		}else{
			show_warnings("hbName-nowrited");
		}
	}else{
		return("muito-grande");
	}
}
function confirm_hb_name(){
	//Envia para o servidor o nome para confirmar (registra no banco de dados) [functions/registrarUsuario.php]
	habboName = document.querySelector("#hbName").value;
	habboServer = document.querySelector("#servidor").value;
	if(verifyHabboNamePatter(habboName) == true){//Verifica se o nome tá no padrão. Se estiver envia para o servidor. Se não os dados são apagados e aciona a interface.
		//Nome ok > Verificar se selecionou algum servidor
		if(habboServer != "nothing-selected"){//Tudo ok: Basta enviar para o servidor. [functions/registrarUsuario.php]
			$.ajax({
				url:"http://localhost/TESTEDECODIGO/Chat/www.CHAToon.ga/functions/registrarUsuario.php",
				type:"GET",
				data:{processo:"registrar",hbname:habboName,hbserver:habboServer},
				success:function(response){
					console.log("Server Response: "+response);
					var resposta = JSON.parse(response);

					switch(resposta.response){
						case "need-confirm-hbname" :
							console.log("Client App: UI Confirm hbname");
							start_options("confirm-hb-name",resposta.code);
							break;
						case "already_registered" :
							console.log("Client App: UI Already Registered");
							start_options("already-registered",null,resposta.hbname);
							break;
						case "" :
							
							break;
					}
					
				}
			});
		}else{
			show_warnings("server-noselected");
		}
	}else{
		switch(verifyHabboNamePatter(habboName)){//Verifica qual é o problema com o nome e dispara o erro na tela.
			case "muito-grande":
				show_warnings("hbName-SoBig");
				break;
		}
	}
	//Dependendo da resposta do servidor a interface se adapta
	//start_options("confirm-hb-name");
}