<?php



/*                  _________________Dados enviados da aplicação cliente__________________
{nomeGrupo:grupoNome,assuntos:[assuntos[0],assuntos[1],assuntos[2]],grupoAberto:grupoAberto,roomId:roomId}
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

require("generalFunctions.php");

session_start();//Ficar experto com a sessão. Vou logar o usuário lá no sistema de LOGIN. Não irei loga-lo aqui.....
$_SESSION['logado'] = true;//Ficar EXPERTO COM ESSA ATRIBUIÇÃO. Estou testando ainda.. depois LEMBRAR DE TIRAR.
$_SESSION['hbname'] = "Administrador.4";//O hbname será pego quando o usuário logar.
$_SESSION['hbserver'] = ".com.br";//Será pega 
$criador_id = "d"; //Será capiturada da sessão
$hbserver = ".com.br"; //será capiturada da sessão/  $_SESSION['hbserver'];

/*Dados enviados pela aplicação cliente*/
$nomeGrupo; 
$assuntos = array();
$grupoAberto;
$roomId;



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
set_timing($_SESSION['hbserver']); //Configuro o timestamp de acordo com a zona ou servidor que o usuário acessa
$datetime = date("Y-m-d H:i:s"); //Armazeno os dados para coloca-lo na base de dados
//------------------------------FIM DO SISTEMA DE TIMESTAMP---------------------------------------
	
//------------------------------Registrar o grupo na base de dados-------------------------------------

$nomeGrupo;
$assuntos = array();
$grupoAberto;
$roomId;


if(isset($_SESSION['logado'])){
	if($_SESSION['logado'] == true or $_SESSION['logado'] == "true" or $_SESSION['logado'] == 1){
		
		if(isset($_REQUEST["nomeGrupo"]) && isset($_REQUEST["assuntos"]) && isset($_REQUEST["grupoAberto"]) && isset($_REQUEST["roomId"])){
			//Caso todos os dados forem enviados pela aplicação cliente o procedimento começa realizar o FILTRO ANTI-SQL-INJECTION
			$nomeGrupo = $_REQUEST["nomeGrupo"];//Filtro Anti-SQLI-INJECTION e Verificar Padrão de nome
			$assuntos = $_REQUEST["assuntos"];//Verificar
			$grupoAberto = $_REQUEST["grupoAberto"];//Verificar e converter para boolean
			$roomId = $_REQUEST["roomId"];//Verificar se pertence ao Habbo Avatar cadastrado
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
				//print("Assuntos aceitos");
				//Só continua se grupoAberto tiver um valor válido.
				if($grupoAberto == "aberto" or $grupoAberto == "fechado"){//Valor válido
					//Verificar se o Id do Room pertence ao usuário logado
					if(isRoomOwner($_SESSION['hbname'],$_SESSION['hbserver'],$roomId) == true){//Id do room pertence ao a conta avatar Habbo logada
						
					}else{
						echo("{\"response\":\"roomId_is_not_owner\"}");
						goto end;
					}
				}
				
			}else{
				echo("{\"response\":\"hashtag_not_accepted_actually\"}");
				goto end;
			}
			
		
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