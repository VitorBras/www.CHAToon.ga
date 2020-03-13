

function search(){//Enviará ao servidor requisição para a busca de grupos/pessoas
	
}

//Ativar o filtro de grupos

document.querySelector("#filtro").addEventListener("change",function(){filtroPG();});

function criarGrupo(){
	window.location.href = "criarGrupo.php";
}

function filtroPG(){//Filtro Pessoa Grupo. É o select de pessoas ou grupos na interface

	if(document.querySelector("#filtro").value == "grupos"){
		setInterface("group-filters-show");
	}else{
		setInterface("group-filters-close");
	}
}

function setInterface(oque){
	
	switch(oque){
		case "group-filters-show":
			document.querySelector(".box-filtros").setAttribute("style","display:block;");
			break;
		case "group-filters-close":
			document.querySelector(".box-filtros").setAttribute("style","display:none;");
			break;
	}
}

