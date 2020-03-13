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
					<button class="button-configuracoes botoes-menu">Painel</button>
					<button class="button-configuracoes botoes-menu">Configurações</button>
				</div>
			</nav>
			<div class="boxBase-Two">
				<table class="molde-lista-quartos">
					<tr>
						<td><span>Nome</span></td>
						<td>
							<input type="search" class="inputs-search" placeholder="Pesquise...">
						</td>
					</tr>
					<tr>
						<td><span>Assunto</span></td>
						<td>
							<select id="assunto" onchange="assuntoSelecionado(this);"><!-- Lista de quartos -->
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
								<tr><td selecionado="false" onclick="assuntoSelecionar(this);"><span escolhido="false">Assunto 1</span></td></tr>
								<tr><td selecionado="false" onclick="assuntoSelecionar(this);"><span escolhido="false">Assunto 2</span></td></tr>
								<tr><td selecionado="false" onclick="assuntoSelecionar(this);"><span escolhido="false">Assunto 3</span></td></tr>
							</table>
						</td>
					</tr>
					<tr>
						<td><span>Acesso</span></td>
						<td id="buttonsTD-area" class="space-in-table">
							<div class="boxOptions-group">
								<button class="button-option-group button-aberto" onclick="btnSelect(this);" selecionado="false">Aberto</button>
								<button class="button-option-group button-fechado" onclick="btnSelect(this);" selecionado="false">Fechado</button>
							</div>
						</td>
					</tr>
					<tr>
						<td><span>Quarto</span></td>
						<td>
							<input type="search" class="inputs-search space-in-table" id="quarto-id" placeholder="Id do seu quarto...">
						</td>
					</tr>
					<tr>
						<td colspan="3" id="zona-btn-criar-grupo">
							<div>
								<button class="button-criar-grupo" onclick="criarGrupo();">Criar Grupo</button>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="boxBase-Three">
				<div class="box-search">
					<table class="molde-box-search">
						<tr>
							<td id="texto1">
								<span>Meus Quartos</span>
							</td>
							<td>
								<button onclick="roomSearch();">Atualizar</button>
							</td>
							<td>
								<!-- Célula VAZIA -->
							</td>
						</tr>
					</table>
				</div>
				<div class="box-lista-quarto">
					<div class="filtro-twoOptions">
						<span>*Selecione um quarto seu do Habbo Hotel</span>
					</div>
					<ul id="lista-quartos">
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
				<div class="boxContent-resultados">
				
				</div>
			</div>
		</div>
	</body>
	<link href="styles/criarGrupo.css" rel="stylesheet" />
	<script src="styles/criarGrupo.js"></script>
</html>


