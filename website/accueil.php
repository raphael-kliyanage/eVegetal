<!--
************************************ Projet suivi végétal 2021 **********************************
Classe: 2BTS SNIR
Date de création: 20/01/2021

Description: Page d'accueil du site, qui présente le projet, et 
offre la possibilité de naviguer sur les différentes pages web.

Logiciel utilisé: vim
-->

<!DOCTYPE html >
<html lang="fr">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>eVégétal - Page d'accueil</title>
	</head>

	<body>
		<header>
			<a href="accueil.php">Accueil</a> |
			<a href="suivi.php">Suivi végétal</a> |
			<a href="id_plantes.php">Plantes</a> |
			<a href="supprimer.php">Supprimer</a>
			<hr>
		</header>
		
		<article>
			<h1>Bienvenue sur eVégétal !</h1>
			<h3>Présentation du projet</h3>
			<p>
				La végétation offre des bienfaits sur l'environnement et sur le bien-être
				des personnes. En effet, ces touches de verdure confèrent une atmosphère
				apaisante, décorent à merveille le lieu et apportent des puits d'oxygène
				naturels.
			</p>
			<p>
				Des particuliers en appartement, qui souhaitent faire entrer la
				végétation chez eux, installent de la verdure souvent dans un espace
				restreint, qui ne sont pas les conditions idéales pour le bien-être
				des plantes...
			</p>
			<p>
				C'est là qu'intervient eVégétal : une application de suivi végétal,
				contrôlée par à un nano-ordinateur. L'application est accessible
				par plusieurs moyens :
				<ul>
					<li>Sur votre navigateur web</li>
					<li>Sur votre smartphone Android</li>
					<li>Sur votre nano-ordinateur Raspberry Pi</li>
				</ul>
				Grâce à eVégétal, vous pouvez entretenir vos plantes sans craindre
				qu'elles meurent, permettant ainsi de profiter de votre végétation
				le plus longtemps, sans craindre le pire.
			</p>
		</article>
		<article>
			<!--
			If I have some spare time, make a search engine to display a small description
			about the plants.
			<h3>Présentation des plantes</h3>
			<p>
			-->
		</article>
		<footer>
			<hr>
			Contact : <a href="mailto:ce.0941918Z@ac-creteil.fr">ce.0941918Z@ac-creteil.fr</a>
			<br>
			Rédacteur : Étudiant en 2BTS SNIR (le rédacteur souhaite rester anonyme)
			<br>
			<!-- à centrer -->
			<?php echo "eVégétal 2021 - ". date("Y");?>
			<br>
			<a href="#">Haut de page</a>
		</footer>
	</body>
</html>
