

var botoes = document.querySelector(".boxOptions-group");
var quartos;
function btnSelect(elemento){//Seleciona o elemento e atribui uma propriedade nele.
	
	let botoes = document.querySelector(".boxOptions-group");
	for(i=0;i<botoes.childElementCount;i++){//Desselecionando os botões
		if(botoes.children[i].getAttribute("selecionado") == "true"){
			botoes.children[i].setAttribute("selecionado","false");
		}
	}
	elemento.setAttribute("selecionado",true);
}

function listRoom(infos){//Coloca os quartos na lista / Função é acionada automaticamente no primeiro LOAD mas é usada para atualizar a lista de grupos.
	let lista = document.querySelector("#lista-quartos");
	//console.log(infos);
	
	
	for(i=0;i<infos.dados.length;i++){//Criando lista
		let line = document.createElement("li");
		let box = document.createElement("div");
		let input = document.createElement("input");
		let span = document.createElement("span");
		
		input.setAttribute("type","radio");
		input.setAttribute("name","qualQuarto");

		box.appendChild(input);
		box.appendChild(span);
		line.appendChild(box);
		lista.appendChild(line);
		
	}
	
	for(i=0;i<lista.childElementCount;i++){//Atribuindo os dados da lista de quarto a lista criada
		lista.children[i].children[0].children[0].setAttribute("quartoId",infos.dados[i].id);
		lista.children[i].children[0].children[0].checked = false;
		lista.children[i].children[0].children[1].innerHTML = infos.dados[i].name;
	}
	
	for(i=0;i<document.getElementsByName("qualQuarto").length;i++){//Adicionando evento a lista.
		document.getElementsByName("qualQuarto")[i].onchange = function(){roomSelected(this);};
	}
	
}

function roomSelected(selecionado){
	document.querySelector("#quarto-id").setAttribute("value",selecionado.getAttribute("quartoid"));
}
function roomSearch(){//Pede para o servidor enviar a lista de quartos (do avatar logado no sistema) em JSON.
	
	
	$.ajax({
		url:"http://localhost/TESTEDECODIGO/Chat/www.CHAToon.ga/functions/buscaRooms.php",
		type:"GET",
		success:function(response){
			//console.log(response);
			quartos = JSON.parse(response);
			listRoom(quartos);
		}
	});
}

function criarGrupo(){//Envia ao servidor os dados para a criação do grupo.
	
	//assuntosSelecionados.children[0].childElementCount
	//assuntosSelecionados.children[0].children[0]
	
	let grupoNome = document.querySelector(".nome-grupo").getAttribute("value");
	let assuntos = [];
	let grupoAberto;  //Boolean
	let grupoId;
	
	let dadosCompletos = 0; //Precisa ser 4. São 4 campos de informações.
	let assuntosSelecionados = document.querySelector("#assuntos_escolhidos");
	
	
	
	for(i=0;i<assuntosSelecionados.children[0].children.length;i++){
		if(assuntosSelecionados.children[0].children[i].children[0].children[0].getAttribute("value") != "nenhum"){
			assuntos[i] = assuntosSelecionados.children[0].children[i].children[0].children[0].getAttribute("value");
		}else{
			console.log("Escolha mais um assunto");
		}
	}
	
	if(document.querySelector(".nome-grupo").value.length > 0){
		dadosCompletos++;
	}else{
		console.log("Dê algum nome ao grupo.");
	}
	
	if(assuntos.length == 3){//caso os assuntos sejam selecionados todos os 3.
		dadosCompletos++;
	}
	
	if(document.querySelector("#quarto-id").value.length > 8){//Alguma ID de quarto informada?
		dadosCompletos++;
	}else{
		console.log("Informe alguma ID de um quarto seu.");
	}
	
	let lista = document.querySelector("#lista-quartos");
	
	for(i=0;i<lista.children.length;i++){//Qual quarto foi selecionado na lista?
		if(lista.children[i].children[0].children.qualQuarto.checked == true){
			grupoId = lista.children[i].children[0].children.qualQuarto.getAttribute("quartoid");
			document.querySelector("#quarto-id").setAttribute("value",grupoId);
		}
	}
	
	//Grupo aberto?
	if(document.querySelector(".button-aberto").getAttribute("selecionado") == "false"){
		if(document.querySelector(".button-fechado").getAttribute("selecionado") == "true"){//Grupo fechado
			grupoAberto = false;
			dadosCompletos++;
		}else{
			console.log("Selecione uma das opçoes. Grupo aberto ou fechado?");
		}
	}else{//Grupo aberto
		grupoAberto = true;
		dadosCompletos++;
	}
	
	console.log(dadosCompletos);

	if(dadosCompletos == 4){//Caso todos os dados estejam completos...pode-se envia-los ao servidor para grava-lo na base de dados.
		$.ajax({
			url:"functions/criarGrupos.php",
			type:"GET",
			data:{nomeGrupo:grupoNome,assuntos:[assuntos[0],assuntos[1],assuntos[2]],grupoAberto:grupoAberto,grupoId:grupoId},
			success:function(response){
				console.log(response);
			}
		});
	}
}

function assuntoSelecionar(elemento){
	let opcoesTwo = document.querySelector("#assuntos_escolhidos");
	
	for(i=0;i<opcoesTwo.children[0].rows.length;i++){
		if(opcoesTwo.children[0].rows[i].cells[0] == elemento){
			if(elemento.getAttribute("selecionado") == "false"){
				opcoesTwo.children[0].rows[i].cells[0].setAttribute("selecionado","true");
				console.log("Selecionado");
			}else{
				opcoesTwo.children[0].rows[i].cells[0].setAttribute("selecionado","false");
				console.log("Desselecionar elemento");
			}		
		}else{
			opcoesTwo.children[0].rows[i].cells[0].setAttribute("selecionado","false");
		}
	}
}

function assuntoSelecionado(elemento){
	
	let opcoesTwo = document.querySelector("#assuntos_escolhidos");
	for(i=0;i<opcoesTwo.children[0].rows.length;i++){
		if(opcoesTwo.children[0].rows[i].cells[0].getAttribute("selecionado") == "true"){
			opcoesTwo.children[0].rows[i].cells[0].children[0].innerHTML = elemento.value;
			opcoesTwo.children[0].rows[i].cells[0].children[0].setAttribute("value",elemento.value);
		}
	}
}




window.addEventListener("load",function(){roomSearch();});

// opcoesTwo.children[0].rows[0].cells[0]
/*
opcoesTwo = document.querySelector("#assuntos_escolhidos");
opcoesTwo.childElementCount;



*/



