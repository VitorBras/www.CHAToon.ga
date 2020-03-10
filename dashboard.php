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
					<button class="button-configuracoes botoes-menu">Configurações</button>
				</div>
			</nav>
			<div class="boxBase-Two">
				<div class="boxContent-One">
					<table class="molde-profile-data">
						<tr>
							<td id="nome">Nome:</td>
						</tr>
						<tr>
							<td>Like:</td>
						</tr>
						<tr>
							<td>Friend QTD:</td>
						</tr>
						<tr>
							<td>Status:</td>
						</tr>
					</table>
				</div>
				<div class="boxContent-Two">
					<div class="money-box-info">
						<div class="prefixoMoneyBox">
							<div class="simbolo-money">
							</div>
							<span id="prefixoMoney">Toon$</span>
							<span id="unidade-toon-money">200</span>
						</div>
						<div class="boxAvatar">
							<div id="avatar">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="boxBase-Three">
				<div class="box-search">
					<table class="molde-box-search">
						<tr>
							<td>
								<select id="filtro">
									<option>Grupos</option>
									<option>Pessoas</option>
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
	<link href="styles/dashboard.css" rel="stylesheet" />
	<script src="styles/dashboard.js"></script>
</html>


