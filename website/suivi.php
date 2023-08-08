<!--
************************************ Projet suivi végétal 2021 **********************************
Classe: 2BTS SNIR
Date de création: 21/01/2021

Description: Interface web pour la gestion des
plantes à distances.

Logiciel utilisé: vim
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
	$requete01 = "SELECT * FROM `CO2` WHERE `ID`!=0 ORDER BY `ID_date` ASC";

	$requete2 = "SELECT * FROM `Date` ORDER BY `date` DESC";

	$requete3 = "SELECT * FROM `HumiditeAir` ORDER BY `ID_date` DESC";
	$requete03 = "SELECT * FROM `HumiditeAir` WHERE `ID`!=0 ORDER BY `ID_date` ASC";

	$requete4 = "SELECT * FROM `HumiditeSol` ORDER BY `ID_date` DESC";
	$requete04 = "SELECT * FROM `HumiditeSol` WHERE `ID`!=0 ORDER BY `ID_date` ASC";
	
	$requete5 = "SELECT * FROM `Luminosite` ORDER BY `ID_date` DESC";
	$requete05 = "SELECT * FROM `Luminosite` WHERE `ID`!=0 ORDER BY `ID_date` ASC";
	# Exclusion des plantes retirées du système
	$requete6 = "SELECT `nom` FROM `Plantes` WHERE `date_retrait` IS NULL";

	$requete7 = "SELECT * FROM `Temperature` ORDER BY `ID_date` DESC";
	$requete07 = "SELECT * FROM `Temperature` WHERE `ID`!=0 ORDER BY `ID_date` ASC";

	# envois des requetes sql :
	$resultat_co2 = mysqli_query($bdd, $requete1);
	$resultat_co2_graph = mysqli_query($bdd, $requete01);

	$resultat_date = mysqli_query($bdd, $requete2);

	$resultat_humidite_air = mysqli_query($bdd, $requete3);
	$resultat_humidite_air_graph = mysqli_query($bdd, $requete03);

	$resultat_humidite_sol = mysqli_query($bdd, $requete4);
	$resultat_humidite_sol_graph = mysqli_query($bdd, $requete04);

	$resultat_luminosite = mysqli_query($bdd, $requete5);
	$resultat_luminosite_graph = mysqli_query($bdd, $requete05);

	$resultat_plantes = mysqli_query($bdd, $requete6);
	$resultat_temperature = mysqli_query($bdd, $requete7);
	$resultat_temperature_graph = mysqli_query($bdd, $requete07);

	# stockage des resultats sous forme de tableau :
	# verification que les variables ont des valeurs :
	$co2 = mysqli_fetch_assoc($resultat_co2);
	if(!isset($co2))
		echo "CO<sub>2</sub> non défini !";
	$date = mysqli_fetch_assoc($resultat_date);
	if(!isset($date))
		echo "Date non défini !";
	$humidite_air = mysqli_fetch_assoc($resultat_humidite_air);
	if(!isset($humidite_air))
		echo "HumiditeAir non défini !";
	$humidite_sol = mysqli_fetch_assoc($resultat_humidite_sol);
	if(!isset($humidite_sol))
		echo "HumiditeSol non défini !";
	$luminosite = mysqli_fetch_assoc($resultat_luminosite);
	if(!isset($luminosite))
		echo "Luminosite non défini !";
	#$plantes = mysqli_fetch_assoc($plantes);
	if(!isset($resultat_plantes))
		echo "Plantes non défini !";
	$temperature = mysqli_fetch_assoc($resultat_temperature);
	if(!isset($temperature))
		echo "Temperature non défini !";

	# verification des differentes valeurs
	# pour envoyer un email d'alerte
	# preparation des emails
	# idées : 
	# 	- envoyer un email qui alerte du nombre d'erreurs
	# 	- ajouter une table email pour me simplifier la vie
	# 	- 
	/*
	$destinataire = "raphael.kliyanage@gmail.com";
	
	$objet_co2 = "Alerte suivi végétal : seuil du CO2 franchi !";
	$objet_humidite_air = "Alerte suivi végétal : seuil de l'humidité de l'air franchi !";
	$objet_humidite_sol = "Alerte suivi végétal : seuil de l'humidité au sol franchi !";
	$objet_luminosite = "Alerte suivi végétal : seuil de luminosité franchi !";
	$objet_temperature = "Alerte suivi végétal : seuil de température franchi !";
	
	$msg_co2 = "Consultez le taux de CO2 sur votre interface de suivi végétal !";
	# 10% - 60%
	$msg_humidite_air = "Consultez l'humidité à l'air sur votre interface de suivi végétal !";
	# 10%
	$msg_humidite_sol = "Consultez l'humidité au sol sur votre interface de suivi végétal !";
	# 500lux
	$msg_luminosite = "Consultez la luminosité sur votre interface de suivi végétal !";
	# 17-21°C
	$msg_temperature = "Consultez la température sur votre interface de suivi végétal !";

	if($_SESSION['sent_mail'] == 0) {
		if($humidite_air >= 60 || $humidite_air <= 10) {
			mail($destinataire, $objet_humidite_air, $msg_humidite_air);
			#$_SESSION['sent_mail']++;
		}
		if($humidite_sol <= 10) {
			mail($destinataire, $objet_humidite_sol, $msg_humidite_sol);
			#$_SESSION['sent_mail']++;
		}
		if($luminosite < 500) {
			mail($destinataire, $objet_luminosite, $msg_luminosite);
			#$_SESSION['sent_mail']++;
		}
		if($temperature < 17 || $temperature > 21) {
			mail($destinataire, $objet_temperature, $msg_temperature);
			#$_SESSION['sent_mail']++;
		}
	#}
	#echo $_SESSION['sent_mail'];
	# trouver un moyen de reset à 0:00 le nombre de email envoyé
	#$heure_actuelle = date("i");
	#while($heure_actuelle == 25 && $_SESSION['sent_mail'] >= 1 && $_SESSION['sent_mail'] <= 4)
	#	$_SESSION['sent_mail'] = 0;
	#echo " après ". $_SESSION['sent_mail'];
	*/
?>

<!doctype html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>eVégétal - Suivi</title>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
		      google.charts.load('current', {'packages':['bar']});
		      google.charts.setOnLoadCallback(drawChart);
		      <?php
			# faire un tableau avec un tri à bulle
			#array graph_co2;
		      ?>
		      function drawChart() {
			var data = google.visualization.arrayToDataTable([
			  ['Jour', 'CO2 (ppm)'],
			  
			  <?php
				if(mysqli_num_rows($resultat_co2_graph) > 0) {
					#while($ligne = mysqli_fetch_array($resultat_co2))
					for($c=0; $c<7; $c++) {
						$ligne = mysqli_fetch_array($resultat_co2_graph);
						echo "['".$ligne['ID']."', '".$ligne['valeur_CO2']."'],";
					}
				}
			  ?>
			]);

			var options = {
			  chart: {
			    title: 'Concentration de CO2',
			    subtitle: 'sur les 7 derniers jours',
			  }
			};

			var chart = new google.charts.Bar(document.getElementById('columnchart_co2'));

			chart.draw(data, google.charts.Bar.convertOptions(options));
		      }
		 </script>
	         <script type="text/javascript">
			google.charts.load('current', {'packages':['bar']});
					      google.charts.setOnLoadCallback(drawChart);

					      function drawChart() {
						var data = google.visualization.arrayToDataTable([
						  ['Jour', 'Humidité air (%)'],
						  
						  <?php
							if(mysqli_num_rows($resultat_humidite_air_graph) > 0) {
								#while($ligne = mysqli_fetch_array($resultat_co2))
								for($c=0; $c<7; $c++) {
									$ligne = mysqli_fetch_array($resultat_humidite_air_graph);
									echo "['".$ligne['ID']."', '".$ligne['valeur_humAir']."'],";
								}
							}
						  ?>

						]);

						var options = {
						  chart: {
						    title: 'Taux d\'humidité à l\'air',
						    subtitle: 'sur les 7 derniers jours',
						  }
						};

						var chart = new google.charts.Bar(document.getElementById('columnchart_humAir'));

						chart.draw(data, google.charts.Bar.convertOptions(options));
					      }
			</script>
	         	<script type="text/javascript">
			google.charts.load('current', {'packages':['bar']});
					      google.charts.setOnLoadCallback(drawChart);

					      function drawChart() {
						var data = google.visualization.arrayToDataTable([
						  ['Jour', 'Humidité sol (%)'],
						  
						  <?php
							if(mysqli_num_rows($resultat_humidite_sol_graph) > 0) {
								#while($ligne = mysqli_fetch_array($resultat_co2))
								for($c=1; $c<8; $c++) {
									$ligne = mysqli_fetch_array($resultat_humidite_sol_graph);
									echo "['-".$c."', '".$ligne['valeur_humSol']."'],";
								}
							}
						  ?>

						]);

						var options = {
						  chart: {
						    title: 'Taux d\'humidité au sol',
						    subtitle: 'sur les 7 derniers jours',
						  }
						};

						var chart = new google.charts.Bar(document.getElementById('columnchart_humSol'));

						chart.draw(data, google.charts.Bar.convertOptions(options));
					      }
		</script>
	        <script type="text/javascript">
		google.charts.load('current', {'packages':['bar']});
					      google.charts.setOnLoadCallback(drawChart);

					      function drawChart() {
						var data = google.visualization.arrayToDataTable([
						  ['Jour', 'Éclairement (lux)'],
						  
						  <?php
							if(mysqli_num_rows($resultat_luminosite_graph) > 0) {
								#while($ligne = mysqli_fetch_array($resultat_co2))
								for($c=0; $c<7; $c++) {
									$ligne = mysqli_fetch_array($resultat_luminosite_graph);
									echo "['".$ligne['ID']."', '".$ligne['valeur_lum']."'],";
								}
							}
						  ?>

						]);

						var options = {
						  chart: {
						    title: 'Éclairement lumineux',
						    subtitle: 'sur les 7 derniers jours',
						  }
						};

						var chart = new google.charts.Bar(document.getElementById('columnchart_luminosite'));

						chart.draw(data, google.charts.Bar.convertOptions(options));
					      }
		</script>
		<script type="text/javascript">
		google.charts.load('current', {'packages':['bar']});
					      google.charts.setOnLoadCallback(drawChart);

					      function drawChart() {
						var data = google.visualization.arrayToDataTable([
						  ['Jour', 'Température (°C)'],
						  
						  <?php
							if(mysqli_num_rows($resultat_temperature_graph) > 0) {
								#while($ligne = mysqli_fetch_array($resultat_co2))
								for($c=0; $c<7; $c++) {
									$ligne = mysqli_fetch_array($resultat_temperature_graph);
									echo "['".$ligne['ID']."', '".$ligne['valeur_temp']."'],";
								}
							}
						  ?>

						]);

						var options = {
						  chart: {
						    title: 'Température ambiant',
						    subtitle: 'sur les 7 derniers jours',
						  }
						};

						var chart = new google.charts.Bar(document.getElementById('columnchart_temperature'));

						chart.draw(data, google.charts.Bar.convertOptions(options));
					      }
		</script>
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
			<h3>Informations sur la pièce :</h3>
			<?php
				# Affichage des informations générales à propos de la pièce
				echo "<h5>Mesure du {$date['date']} :</h5>"; 
				if($co2['valeur_CO2'] >= 2000)
					echo "Taux de CO<sub>2</sub> : {$co2['valeur_CO2']} ppm	<b>Attention !</b><br>";
				else
					echo "Taux de CO<sub>2</sub> : {$co2['valeur_CO2']} ppm<br>";
				
				echo "<div id=\"columnchart_co2\" style=\"width: 1920; height: 500px\"></div>";

				if($humidite_air['valeur_humAir'] >= 60 || $humidite_air['valeur_humAir'] <= 10)
					echo "Taux d'humidité dans l'air : {$humidite_air['valeur_humAir']} %	<b>Attention !</b><br>";
				#elseif($humidite_air <= 10)
				#	echo "Taux d'humidité dans l'air : {$humidite_air['valeur_humAir']} % 	Attention : air trop sec (devrait être supérieur à 10%) ! <br>";
				else
					echo "Taux d'humidité dans l'air : {$humidite_air['valeur_humAir']} %<br>";

				echo "<div id=\"columnchart_humAir\" style=\"width: 1920; height: 500px\"></div>";					

				if($luminosite['valeur_lum'] <= 50 || $luminosite['valeur_lum'] >= 650)		
					echo "Luminosité : {$luminosite['valeur_lum']} lux <b>Attention !</b><br>";
				else
					echo "Luminosité : {$luminosite['valeur_lum']} lux<br>";

				echo "<div id=\"columnchart_luminosite\" style=\"width: 1920; height: 500px\"></div>";

				if($temperature['valeur_temp'] < 17 || $temperature['valeur_temp'] > 21)
					echo "Température ambiant : {$temperature['valeur_temp']} °C <b>Attention !</b><br>";
				else
					echo "Température ambiant : {$temperature['valeur_temp']} °C<br>";

				echo "<div id=\"columnchart_temperature\" style=\"width: 1920; height: 500px\"></div>";
			?>
		</section>
		<section>
			<h3>Informations sur les plantes :</h3>
			<?php
				# Affichage des informations concernant les plantes
				echo "<h5>Mesure du {$date['date']} :</h5>";
				if($humidite_sol['valeur_humSol'] <= 20 || $humidite_sol['valeur_humSol'] > 100)
					echo "Taux d'humidité au sol : {$humidite_sol['valeur_humSol']} % <b>Attention !</b><br>";
				else
					echo "Taux d'humidité au sol : {$humidite_sol['valeur_humSol']} %<br>";
				
				echo "<div id=\"columnchart_humSol\" style=\"width: 1920; height: 500px\"></div>";

				# Stockage sous forme de tableau pour afficher touts les plantes
				# présentes dans la base de données
				$nb_plantes =  mysqli_num_rows($resultat_plantes);
				if($nb_plantes <= 0)
					echo "Vous n'avez aucune plante !<br>";
				elseif($nb_plantes == 1)
					echo "Vous avez 1 plante :<br>";
				else
					echo "Vous avez $nb_plantes plantes :<br>";
				echo "<ul>";
				foreach($resultat_plantes as $ligne) {
					foreach($ligne as $nom=>$value) {
						echo "<li>$value<br>";
					}
				}
				echo "</ul>";
				# envoi email d'alerte
				#$msg = "This message is in fact a fucking spam\n"
				#	."sent from school\n"
				#	."enjoy";
				#$msg = wordwrap($msg, 70);
				#mail('raphael.kliyanage@gmail.com', 'Alerte suivi végétal', $msg);

				# graph de malade
				#$pc = new C_PhpChartX(array(array(11, 9, 5, 12, 14)), 'basic_chart');
				#$pc->set_animate(true);
				#$pc->set_title(array('text'=>'Wow'));
				#$pc-draw();
			?>
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
