

function search(){//Enviará ao servidor requisição para a busca de grupos/pessoas
	
}

//Ativar o filtro de grupos

document.querySelector("#filtro").addEventListener("change",function(){filtroPG();});


function filtroPG(){//Filtro Pessoa Grupo. É o select de pessoas ou grupos na interface
	
}

function setInterface(oque){
	
	switch(oque){
		case "group-filters-show":
			document.querySelector(".filtro-twoOptions").setAttribute("style","display:block;");
			document.querySelector("#lista-assuntos").setAttribute("style","display:block;");
			break;
		case "group-filters-close":
			document.querySelector(".filtro-twoOptions").setAttribute("style","display:block;");
			document.querySelector("#lista-assuntos").setAttribute("style","display:block;");
			break;
	}
}