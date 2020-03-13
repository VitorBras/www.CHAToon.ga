<?php

session_start();


?>


<html>
	<head>
	
	</head>
	<body>
		<div class="boxBase-One">
			<nav class="menu-bar">
				<div class="box-menu-bar">
					<button class="button-negocios botoes-menu">Negócios</button>
					<button class="button-friendsbotoes-menu botoes-menu">Amigos</button>
					<button class="button-criar-grupo botoes-menu" onclick="criarGrupo();">Criar Grupo</button>
					<button class="button-configuracoes botoes-menu">Configurações</button>
				</div>
			</nav>
			<div class="boxBase-Two">
				<table>
					<tr>
						<td><span>Nome</span></td>
						<td>
							<input type="search" class="inputs-search" placeholder="Pesquise...">
						</td>
					</tr>
					<tr>
						<td><span>Assunto</span></td>
						<td>
							<select id="assunto">
								<option value="#Namoro">Namoro</option>
								<option value="#Amizade">Amizade</option>
								<option value="#Politica">Política</option>
								<option value="#Jogos">Jogos</option>
								<option value="#Negociacao">Negociação</option>
								<option value="#Policias">Polícias</option>
								<option value="#Insonia">Insônia</option>
								<option value="#Medo">Medo</option>
								<option value="#Adultos">Adultos</option>
								<option value="#Criancas">Crianças</option>
								<option value="#FilmesDesenhosSeries">Filmes, Desenhos e Séries</option>
								<option value="#Estudos">Estudos</option>
								<option value="#LGBT">LGBT</option>
							</select>
						</td>
						<td>
							<table id="assuntos_escolhidos">
								<tr><td><span>Assunto 1</span></td></tr>
								<tr><td><span>Assunto 2</span></td></tr>
								<tr><td><span>Assunto 3</span></td></tr>
							</table>
						</td>
					</tr>
					<tr>
						<td><span>Acesso</span></td>
						<td id="buttonsTD-area">
							<div class="boxOptions-group">
								<button class="button-option-group button-aberto" onclick="btnSelect(this);" selecionado="false">Aberto</button>
								<button class="button-option-group button-fechado" onclick="btnSelect(this);" selecionado="false">Fechado</button>
							</div>
						</td>
					</tr>
					<tr>
						<td><span>Quarto</span></td>
						<td>
							<input type="search" class="inputs-search" id="quarto-id" placeholder="Id do seu quarto...">
						</td>
					</tr>
				</table>
			</div>
			<div class="boxBase-Three">
				<div class="box-search">
					<table class="molde-box-search">
						<tr>
							<td>
								<select id="filtro">
									<option value="grupos">Grupos</option>
									<option value="pessoas">Pessoas</option>
								</select>
							</td>
							<td>
								<input type="search" class="inputs-search" placeholder="Pesquise...">
							</td>
							<td>
								<button onclick="search();">Pesquisar</button>
							</td>
						</tr>
					</table>
				</div>
				<div class="box-filtros">
					<div class="filtro-twoOptions">
						<select id="selectTwoOptions">
							<option value="public">Público</option>
							<option value="private">Privado</option>
						</select>
					</div>
					<ul id="lista-assuntos">
						<li>
							<div>
								<input type="checkbox">
								<span>#Namoro</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Amizade</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Politica</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Jogos</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Negociacao</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Policias</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Insonia</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Medo</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Adultos</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Criancas</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Filmes</span>
								<span>Desenhos</span>
								<span>Series</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#Estudos</span>
							</div>
						</li>
						<li>
							<div>
								<input type="checkbox">
								<span>#LGBT</span>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="boxBase-Four">
				<div class="boxContent-Infos">
					<table class="molde-infos">
						<tr><td class="infos-categories">Grupos</td></tr>
						<tr>
							<td>Grupos Públicos:</td>
							<td>40</td>
						</tr>
						<tr>
							<td>Grupos Privados</td>
							<td>60</td>
						</tr>
					</table>
					<table class="molde-infos-pessoas">
						<tr>
							<td><pan>255 pessoas encontradas</span></td>
						</tr>
					</table>
				</div>
				<div class="boxContent-resultados">
					<ul class="boxContent-lista-resultados-grupos">
						<li>
							<table id="molde-resultados-grupos-pesquisa">
								<tr>
									<td class="info-nome-group">Nome grupo</td>					
								</tr>
								<tr>
									<td class="info-adm-group" hasadm="yes"><span>Tenho ADM</span></td>
									<td class="info-qtd-members"><span>QTD Participantes</span></td>
									<td class="info-owner"><span>Dono/Publico/Privado</span></td>
									<td class="action-join-button"><button class="action-join-button-btn">Entrar</button></td>
								</tr>
							</table>
							<table id="molde-resultados-grupos-pesquisaTwo">
								<tr>
									<td class="info-nome-group">Nome grupo</td>					
								</tr>
								<tr>
									<td class="info-adm-group" hasadm="yes"><span>Tenho ADM</span></td>
								</tr>
								<tr>
									<td class="info-qtd-members"><span>QTD Participantes</span></td>
								</tr>
								<tr>							
									<td class="info-owner"><span>Dono/Publico/Privado</span></td>
								</tr>
								<tr>
									<td class="action-join-button"><button class="action-join-button-btn">Entrar</button></td>
								</tr>
							</table>
						</li>
					</ul>
					<ul class="boxContent-lista-resultados-pessoas">
						<li>
							<table id="molde-resultados-pessoas-pesquisa">
								<tr>
									<td class="info-nome-group">Nome pessoa</td>					
								</tr>
								<tr>
									<td class="info-adm-group" isme="yes"><span>Sou eu</span></td>
									<td class="info-qtd-members"><span>QTD amigos</span></td>
									<td class="info-owner"><span>Adicionado</span></td>
									<td class="action-join-button"><button>Adicionar</button></td>
								</tr>
							</table>
							<table id="molde-resultados-pessoas-pesquisaTwo">
								<tr>
									<td class="info-nome-group">Nome pessoa</td>					
								</tr>
								<tr>
									<td class="info-adm-group" isme="yes"><span>Sou eu</span></td>
								</tr>
								<tr>
									<td class="info-qtd-members"><span>QTD amigos</span></td>
								</tr>
								<tr>
									<td class="info-owner"><span>Adicionado</span></td>
								</tr>
								<tr>
									<td class="action-join-button"><button>Adicionar</button></td>
								</tr>
							</table>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
	<link href="styles/criarGrupo.css" rel="stylesheet" />
	<script src="styles/criarGrupo.js"></script>
</html>


