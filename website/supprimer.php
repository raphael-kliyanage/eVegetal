<!--
************************************ Projet suivi végétal 2021 **********************************
Classe: 2BTS SNIR
Date de création: 21/01/2021

Description: supprimer des données dans la base de données

Logiciel utilisé: gedit
-->

<?php
	#session_start();
	# connexion à la base de données :
	# remember to enable remote access - otherwise: localhost
	$bdd = mysqli_connect('127.0.0.1:3306', 'root', 'raspberry', 'e-vegetal')
		or die("Erreur : Impossible de se connecter à la base de données !");

	# stockage des requetes pour les différentes tables de la base de données
	# CO2 - Date - HumiditeAir - HumiditeSol - Luminosite - Plantes - Temperature
	# ID décroissants pour afficher les valeurs les plus réçentes
	$requete1 = "SELECT * FROM `CO2` ORDER BY `ID_date` DESC";
	$requete2 = "SELECT * FROM `Date` ORDER BY `date` DESC";
	$requete3 = "SELECT * FROM `HumiditeAir` ORDER BY `ID_date` DESC";
	$requete4 = "SELECT * FROM `HumiditeSol` ORDER BY `ID_date` DESC";
	$requete5 = "SELECT * FROM `Luminosite` ORDER BY `ID_date` DESC";
	# Exclusion des plantes retirées du système
	$requete6 = "SELECT `nom` FROM `Plantes` WHERE `date_retrait` IS NULL";
	$requete7 = "SELECT * FROM `Temperature` ORDER BY `ID_date` DESC";

	# envois des requetes sql :
	$co2 = mysqli_query($bdd, $requete1);
	$date = mysqli_query($bdd, $requete2);
	$humidite_air = mysqli_query($bdd, $requete3);
	$humidite_sol = mysqli_query($bdd, $requete4);
	$luminosite = mysqli_query($bdd, $requete5);
	$plantes = mysqli_query($bdd, $requete6);
	$temperature = mysqli_query($bdd, $requete7);

	# stockage des resultats sous forme de tableau :
	# verification que les variables ont des valeurs :
	$co2 = mysqli_fetch_assoc($co2);
	if(!isset($co2))
		echo "CO<sub>2</sub> non défini !";
	$date = mysqli_fetch_assoc($date);
	if(!isset($date))
		echo "Date non défini !";
	$humidite_air = mysqli_fetch_assoc($humidite_air);
	if(!isset($humidite_air))
		echo "HumiditeAir non défini !";
	$humidite_sol = mysqli_fetch_assoc($humidite_sol);
	if(!isset($humidite_sol))
		echo "HumiditeSol non défini !";
	$luminosite = mysqli_fetch_assoc($luminosite);
	if(!isset($luminosite))
		echo "Luminosite non défini !";
	#$plantes = mysqli_fetch_assoc($plantes);
	if(!isset($plantes))
		echo "Plantes non défini !";
	$temperature = mysqli_fetch_assoc($temperature);
	if(!isset($temperature))
		echo "Temperature non défini !";

	# suppression des données par rapport à une date
	# cascade
	if(isset($_POST['envoyer'])) {
		# on récupère la date du formulaire
		$date = mysqli_real_escape_string($bdd, $_POST['date']);
		$requete_suppression = "DELETE FROM Date WHERE date='$date'";
		$resultat = mysqli_query($bdd, $requete_suppression);
		if(!$resultat)
			printf("Erreur : %s\n", mysqli_error($bdd));

	}
?>

<!doctype html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>eVégétal - Supprimer</title>
	</head>

	<body>
		<header>
			<a href="accueil.php">Accueil</a> |
			<a href="suivi.php">Suivi végétal</a> |
			<a href="id_plantes.php">Plantes</a> |
			<a href="supprimer.php">Supprimer</a>
			<hr>
		</header>

		<section>
			<h3>Choisir la donnée à supprimer :</h3>
			<?php
				echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" enctype=\"application/x-www-form-urlencoded\">";
			?>
				<input type="date" name="date">
				<input type="submit" name="envoyer" value="Sélectionner">
		</section>
		<footer>
			<hr>
			Contact : <a href="mailto:ce.0941918ZZ@ac-creteil.fr">ce.0941918Z@ac-creteil.fr</a>
			<br>
			Rédacteur : Étudiant en 2BTS SNIR (le rédacteur souhaite rester anonyme)
			</br>
			<!-- à centrer -->
			<?php echo 'eVégétal 2021 - '. date("Y"); ?>
			<br>
			<a href="#">Haut de page</a>
		</footer>
	</body>
</html>

