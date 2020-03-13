

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
		}
	}
}


window.addEventListener("load",function(){roomSearch();});

// opcoesTwo.children[0].rows[0].cells[0]
/*
opcoesTwo = document.querySelector("#assuntos_escolhidos");
opcoesTwo.childElementCount;



*/



