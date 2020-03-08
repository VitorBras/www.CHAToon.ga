<?php

session_start();


?>


<html>
	<head>
	
	</head>
	<body>
		<div class="boxBase-One">
			<nav class="menu-bar">
				MENU
			</nav>
			<div class="boxBase-Two">
				<div class="boxContent-One">
				
				</div>
				<div class="boxContent-Two">
				
				</div>
			</div>
			<div class="boxBase-Three">
				
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
				</div>
				<div class="boxContent-resultados">
					<ul class="boxContent-lista-resultados">
						<li>
							<table id="molde-resultados-grupos-pesquisa">
								<tr>
									<td class="info-nome-group">Nome grupo</td>					
								</tr>
								<tr>
									<td class="info-adm-group" hasadm="yes"><span>Tenho ADM</span></td>
									<td class="info-qtd-members"><span>QTD Participantes</span></td>
									<td class="info-owner"><span>Dono/Publico/Privado</span></td>
									<td class="action-join-button"><button>Entrar</button></td>
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


