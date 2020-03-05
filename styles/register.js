

var habboName;
var habboServer;
var active_warnings = 0;



function start_options(pagetype){//Acionar opções confirmação
	switch(pagetype){
		case "confirm-hb-name":
			console.log("Client App: UI CONFIRM HB NAME");
			document.querySelector("#servidor").setAttribute("style","display:none;");
			document.querySelector(".input-hbname-confirm-code").setAttribute("style","display:block;");
			document.querySelector("#molde-tabela").setAttribute("style","top:4%;");
			document.querySelector(".input-username").setAttribute("disabled","");
			document.querySelector(".explain-confirm").setAttribute("style","display:block;");
			document.querySelector("#code-confirm").setAttribute("style","display:block;");
			document.querySelector(".explain-confirm-text").setAttribute("style","display:block;");
			document.querySelector(".button-register").innerHTML = "Confirmar";
			break;
		case "confirm-email":
		
			break;
			
		case "confirm-phone-number":
		
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
					if(resposta.response == "need-confirm-hbname"){//Se o servidor salva os dados e pede para confirmar a App Client muda a interface.
						console.log("Client App: UI Confirm hbname");
						start_options("confirm-hb-name");
					}else{//O servidor não salvou os dados por algum motivo...
						
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