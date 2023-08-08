<!--
************************************ Projet suivi végétal 2021 **********************************
Classe: 2BTS SNIR
Date de création: 21/01/2021

Description: tache planifie pour envoyer 1 mail/jour à 12h

Logiciel utilisé: vim
-->

<?php
	#session_start();
	# connexion à la base de données :
	# remember to enable remote access - otherwise: localhost
	$bdd = mysqli_connect('127.0.0.1', 'root', 'raspberry', 'e-vegetal')
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

	# verification des differentes valeurs
	# pour envoyer un email d'alerte
	# preparation des emails
	# idées : 
	# 	- envoyer un email qui alerte du nombre d'erreurs
	# 	- ajouter une table email pour me simplifier la vie
	#
	$destinataire = "suivi.vegetal2021@gmail.com";
	#$destinataire = "raphael.kliyanage@gmail.com";
	#$destinataire = "alexandre.goncalves164@gmail.com";
	
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

	#if($_SESSION['sent_mail'] == 0) {
		if($co2['valeur_CO2'] >= 2000) {
			mail($destinataire, $objet_co2, $msg_co2);
		}
		if($humidite_air['valeur_humAir'] >= 60 || $humidite_air['valeur_humAir'] <= 10) {
			mail($destinataire, $objet_humidite_air, $msg_humidite_air);
			#$_SESSION['sent_mail']++;
		}
		if($humidite_sol['valeur_humSol'] <= 20 || $humidite_sol['valeur_humSol'] > 100) {
			mail($destinataire, $objet_humidite_sol, $msg_humidite_sol);
			#$_SESSION['sent_mail']++;
		}
		if($luminosite['valeur_lum'] >= 50 || $luminosite['valeur_lum'] <= 650) {
			mail($destinataire, $objet_luminosite, $msg_luminosite);
			#$_SESSION['sent_mail']++;
		}
		if($temperature['valeur_temp'] < 17 || $temperature['valeur_temp'] > 21) {
			mail($destinataire, $objet_temperature, $msg_temperature);
			#$_SESSION['sent_mail']++;
		}
	#}
	#echo $_SESSION['sent_mail'];
	# trouver un moyen de reset à 0:00 le nombre de email envoyé
	#$heure_actuelle = date("i");
	#while($heure_actuelle == 55 && $_SESSION['sent_mail'] >= 1 && $_SESSION['sent_mail'] <= 4)
	#	$_SESSION['sent_mail'] = 0;
	#echo " après ". $_SESSION['sent_mail'];
?>
