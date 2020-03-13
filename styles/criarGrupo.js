

var botoes = document.querySelector(".boxOptions-group");

function btnSelect(elemento){//Seleciona o elemento e atribui uma propriedade nele.
	
	let botoes = document.querySelector(".boxOptions-group");
	for(i=0;i<botoes.childElementCount;i++){//Desselecionando os botões
		if(botoes.children[i].getAttribute("selecionado") == "true"){
			botoes.children[i].setAttribute("selecionado","false");
		}
	}
	elemento.setAttribute("selecionado",true);
}

function roomSearch(){//Pede para o servidor enviar a lista de quartos (do avatar logado no sistema) em JSON.
	
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


// opcoesTwo.children[0].rows[0].cells[0]
/*
opcoesTwo = document.querySelector("#assuntos_escolhidos");
opcoesTwo.childElementCount;



*/



