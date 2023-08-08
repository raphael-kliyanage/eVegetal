<!--
************************************ Projet suivi végétal 2021 **********************************
Classe: 2BTS SNIR
Date de création: 21/01/2021

Description: ajouter ou supprimer des plantes dans la base de données

Logiciel utilisé: vim
-->
<?php
	if(empty($_POST['code']))
		header("Location:id_plantes.php");
?>

<!doctype html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>eVégétal - Plantes</title>
	</head>

	<body>
		<header>
			<a href="accueil.php">Accueil</a> |
			<a href="suivi.php">Suivi végétal</a> |
			<a href="id_plantes.php">Plantes</a> |
			<a href="supprimer.php">Supprimer</a>
			<hr>
		</header>
	<body>
</html>

<?php
	#session_start();
	# connexion à la base de données :
	# remember to enable remote access - otherwise: localhost
	$bdd = mysqli_connect('127.0.0.1', 'root', 'raspberry', 'e-vegetal')
		or die("Erreur : Impossible de se connecter à la base de données !");

	if(!isset($_POST['modifier']) && !isset($_POST['supprimer'])) {
		$code = mysqli_real_escape_string($bdd, $_POST['code']);
		$requete = "SELECT * FROM `Plantes` WHERE ID='$code'";
		$resultat = mysqli_query($bdd, $requete);
		$donne = mysqli_fetch_row($resultat);
		#var_dump($donne);

		echo "<form action=\"". $_SERVER['PHP_SELF']. "\" method=\"post\" enctype=\"application/x-www-form-urlencoded\">";
		echo "<input type=\"text\" name=\"ID\" value=\"".$donne[0] ."\"><br><br>";
		echo "<input type=\"text\" name=\"nom\" value=\"".$donne[1] ."\"><br><br>";
		echo "<input type=\"date\" name=\"date_ajout\" value=\"".$donne[2] ."\"><br><br>";
		echo "<input type=\"date\" name=\"date_retrait\"> valeur actuelle : '$donne[3]' <br><br>";
		echo "<input type=\"submit\" name=\"modifier\" value=\"Modifier\">";
		echo "<input type=\"submit\" name=\"supprimer\" value=\"Supprimer de la base de donnée\">";
		echo "<input type=\"hidden\" name=\"code\" value=\"$code\">";
		echo "</form>";
	} elseif(isset($_POST['modifier']) && isset($_POST['nom']) && isset($bdd, $_POST['date_ajout'])) {		
		$id = mysqli_real_escape_string($bdd, $_POST['ID']);
		$nom = mysqli_real_escape_string($bdd, $_POST['nom']);
		$date_ajout = mysqli_real_escape_string($bdd, $_POST['date_ajout']);
		$date_retrait = mysqli_real_escape_string($bdd, $_POST['date_retrait']);
		$code = mysqli_real_escape_string($bdd, $_POST['code']);
		if($date_retrait == "")
			$requete_modifier = "UPDATE `Plantes` SET ID='$id', nom='$nom', date_ajout='$date_ajout', date_retrait=null WHERE ID='$code';";
		else
			$requete_modifier = "UPDATE `Plantes` SET ID='$id', nom='$nom', date_ajout='$date_ajout', date_retrait='$date_retrait' WHERE ID='$code';";
		$resultat = mysqli_query($bdd, $requete_modifier);
		if(!$resultat)
			printf(mysqli_error($bdd));
		else			
			header("Location:suivi.php");
	} elseif(isset($_POST['supprimer']) && isset($_POST['nom']) && isset($bdd, $_POST['date_ajout'])) {
		$code = mysqli_real_escape_string($bdd, $_POST['code']);
		$nom = mysqli_real_escape_string($bdd, $_POST['nom']);
		$date_ajout = mysqli_real_escape_string($bdd, $_POST['date_ajout']);
		$requete_supprimer = "DELETE FROM `Plantes` WHERE `ID`='$code';";
		$resultat = mysqli_query($bdd, $requete_supprimer);
		header("Location:id_plantes.php");
	}
?>
		
