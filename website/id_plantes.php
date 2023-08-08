<!--
************************************ Projet suivi végétal 2021 **********************************
Classe: 2BTS SNIR
Date de création: 21/01/2021

Description: ajouter/modifier les informations sur les plantes

Logiciel utilisé: gedit
-->

<?php
	#session_start();
	# connexion à la base de données :
	# remember to enable remote access - otherwise: localhost
	$bdd = mysqli_connect('127.0.0.1:3306', 'root', 'raspberry', 'e-vegetal')
		or die("Erreur : Impossible de se connecter à la base de données !");

	if(isset($_POST['ajouter'])) {
		if(!isset($_POST['nom']) || !isset($_POST['date_ajout']))
			echo "<script language=\"javascript\"> alert(\"Veuillez remplir les deux champs !\"); </script>";
			# on récupère la date du formulaire
			$nom = mysqli_real_escape_string($bdd, $_POST['nom']);
			$date_ajout = mysqli_real_escape_string($bdd, $_POST['date_ajout']);
			$requete_ajout = "INSERT INTO `Plantes` (`nom`, `date_ajout`, `date_retrait`) VALUES ('$nom', '$date_ajout', NULL);";
			$resultat = mysqli_query($bdd, $requete_ajout);
			if(!$resultat)
				printf("Erreur : %s\n", mysqli_error($bdd));
			else {
				$requete_id = "SELECT `ID` FROM `Plantes` WHERE `nom`='$nom' AND `date_ajout`='$date_ajout';";
				$resultat_id = mysqli_query($bdd, $requete_id);
				$id = mysqli_fetch_assoc($resultat_id);
				echo "ID de la nouvelle plante : {$id['ID']}";
			}

	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
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
		<form action="test_tableau.php" method="post" enctype="application/x-www-form-urlencoded">
			<fieldset>
				<legend><b>Saississez l'id de plante à modifier</b></legend>
				<table><tbody>
					<tr>
						<td>ID plante :</td>
						<td><input type="text" name="code" size"20" maxlength="65535"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" value="Afficher"></td>
					</tr>
				</tbody></table>
			</fieldset>
		</form>
		<br>
		<br>
		<form action="".<?php $_SERVER['PHP_SELF'] ?>."" method="post" enctype="application/x-www-form-urlencoded">
			<fieldset>
				<legend><b>Ajouter une plante</b></legend>
				<table><tbody>
					<tr>
						<td>Nom :</td>
						<td><input type="text" name="nom" size"20" maxlength="255"></td>
					</tr>
					<tr>
						<td>Date d'ajout :</td>
						<td><input type="date" name="date_ajout"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="ajouter" value="Ajouter"></td>
					</tr>
				</tbody></table>
			</fieldset>
		</form>
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

