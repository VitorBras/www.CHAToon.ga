<?php



/*                  _________________Dados enviados da aplicação cliente__________________
{nomeGrupo:grupoNome,assuntos:[assuntos[0],assuntos[1],assuntos[2]],grupoAberto:grupoAberto,grupoId:grupoId}
*/

/*  ---------------------------Dados necessários para a gravação do grupo na base de dados---------------------------------

criador id = varchar(24)    (a capiturar da sessão)
id do room = varcar(256)    (enviado pela client app)
nome_grupo = varchar(30)    (enviado pela client app)
assuntos = varchar(256)     (enviado pela client app)
criado_timestamp = copiar o sistema anterior    (a reutilizar o sistema anterior)
participantes_id = deixar null                  (deixar como nulo)
theme = int (botar 0 = thema default)           (deixar 0)
estado = int( deixar 1 = ativo)                 (deixar 1)
admins_do_grupo = varchar(1271)                 (deixar como nulo)
 
*/

session_start();
$_SESSION['logado'] = true;

$criador_id = "d"; //Será capiturada da sessão
$hbserver = ".com.br"; //será capiturada da sessão

/*Dados enviados pela aplicação cliente*/
$nomeGrupo; 
$assuntos = array();
$grupoAberto;
$grupoId;



/*________________Sistema de timestamp reutilizado__________________*/

function set_timing($servidor){
	
	switch($servidor){
		case ".com.br":
			date_default_timezone_set('America/Sao_Paulo');//Brasil
			break;
		case ".com":
			date_default_timezone_set('America/New_York');//internacional
			break; 
		case ".de":
			date_default_timezone_set('Europe/Berlin');//Alemanha
			break;
		case ".es":
			date_default_timezone_set('Europe/Madrid');//Espanha
			break;
		case ".fi":
			date_default_timezone_set('Europe/Moscow');//Finlandia
			break;
		case ".fr":
			date_default_timezone_set('Europe/Paris');//França
			break;
		case ".it":
			date_default_timezone_set('Europe/Monaco');//Italia
			break;
		case ".nl":
			date_default_timezone_set('Europe/Amsterdam');//Holanda
			break;
		case ".com.tr":
		date_default_timezone_set('Europe/Istanbul');//Turkuia
			break;
	}
	
}	
set_timing($hbserver); //Configuro o timestamp de acordo com a zona ou servidor que o usuário acessa
$datetime = date("Y-m-d H:i:s"); //Armazeno os dados para coloca-lo na base de dados
//------------------------------FIM DO SISTEMA DE TIMESTAMP---------------------------------------
	
//------------------------------Registrar o grupo na base de dados-------------------------------------

$nomeGrupo;
$assuntos = array();
$grupoAberto;
$grupoId;

function wordFiltro($dados){//Filtro de palavras ofensivas. Normalmente acessa a base de dados. São muitas palavras.
	return($dados);//Por enquanto
}
function wordNameFiltro($dados){//Filtra a string tirando as palavras proibidas pelo padrão de nome de grupo que é padronizado no arquivo (config/sistemaConfig.xml) e retorna o valor filtrado.
	return($dados);//Por enquanto
}
if(isset($_SESSION['logado'])){
	if($_SESSION['logado'] == true or $_SESSION['logado'] == "true" or $_SESSION['logado'] == 1){
		
		if(isset($_REQUEST["nomeGrupo"]) && isset($_REQUEST["assuntos"]) && isset($_REQUEST["grupoAberto"]) && isset($_REQUEST["grupoId"])){
			//Caso todos os dados forem enviados pela aplicação cliente o procedimento começa realizar o FILTRO ANTI-SQL-INJECTION
			$nomeGrupo = $_REQUEST["nomeGrupo"];//Filtro
			$assuntos = $_REQUEST["assuntos"];//Verificar e converter para array
			$grupoAberto = $_REQUEST["grupoAberto"];//Verificar e converter para boolean
			$grupoId = $_REQUEST["grupoId"];//Verificar e manter como string
			//-------------FIM DA ATRIBUIÇÃO DE VALORES E FILTRAGEM ANTI-SQL-INJECTION-----------------(Grava valor filtrado na variavel)
			//--------------Filtrar Palavras PROIBIDAS no nome do grupo e substitui-las bor BOBBA----------------(Altera variável)
			
			$nomeGrupo = wordNameFiltro($nomeGrupo);//Filtro de palavras proibidas para nome de grupo
			$nomeGrupo = wordFiltro($nomeGrupo);//Filtro de palavras ofensivas proibidas no geral.(base de dados)
			
			
			//--------------FIM DA FILTRAGEM DE PALAVRAS PROIBIDAS-------------------------------------
			//--------------VERIFICAÇÃO SE OS ASSUNTOS SÃO ACEITOS PELO SISTEMA CHAToon (Assuntos estão no arquivo config/sistemaConfig.xml)
			$assuntosAceitos = true;
			$configSystem; 
			
			if(file_exists("../config/sistemaConfig.xml")){
				$configSystem = simplexml_load_file('../config/sistemaConfig.xml');
				
				
				for($i=0,$x=0,$z=0;$i<count($configSystem->grupo->assuntos->assunto) and $x != 3;){
					
					if($x<3){
						if($assuntos[$x] == $configSystem->grupo->assuntos->assunto[$i]){//O assunto está no sistema?
							if($configSystem->grupo->assuntos->assunto[$i]['available'] == "yes"){//Está sendo aceito no momento para registro de grupos?
								$x++;$i=0;
							}else{print("Teste um");
								$x=3;
								$assuntosAceitos = false;
							}
						}else{//print("Teste dois");
							if($i+1 == count($configSystem->grupo->assuntos->assunto)){//Encerrando as verificações
								$x=3;
								$assuntosAceitos = false;
							}
							$i++;
						}
					}
					
					
				}
			}else{
				echo("Arquivo não encontrado");
			}
			//-----------------------------Fim da verificação dos assuntos----------------------------
			//var_dump($configSystem->grupo->assuntos->assunto);
			//var_dump($configSystem);
			if($assuntosAceitos == true){//Os assuntos de grupo enviado pelo cliente são aceitos. 
				
				
			}else{
				echo("{\"response\":\"hashtag_not_accepted_actually\"}");
				goto end;
			}
			//Verificar se o nome de grupo está no padrão: (irei utilizar o sistema de anti SQL injectio)
		
		
		}else{
			echo("{\"response\":\"nenhum_dado\"}");
		}
		
	}else{//-----------------------------------------------------------
		echo("{\"response\":\"user_no_logged\";}");
	}
	
}else{
	echo("{\"response\":\"user_no_logged\";}");
}


end:



?>