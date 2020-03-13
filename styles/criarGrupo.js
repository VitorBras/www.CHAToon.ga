

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

