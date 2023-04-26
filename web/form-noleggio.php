<?php

	session_start();
	require('../res/var/db.php');

	$conn = new mysqli($servername, $db_username, $db_password, $db_name);

	if(!isset($_SESSION['tipo_utente'])){
		header('Location: login.php');
	}

	//serve per poter tornare indietro una volta premuto il tasto invia dal form-noleggio, perchè rieseguendo la pagina form-noleggio.php non ha ricevuto $_POST['id_auto'], quindi uso variabile di sessione;

	if(!isset($_POST['id_auto'])){
		$id_auto = $_SESSION['id_auto'];
	} else {
		$id_auto = $_POST['id_auto'];
	}

	$auto_da_noleggiare = "SELECT *
					   FROM auto
					   WHERE id = $id_auto;";

	$res = mysqli_query($conn, $auto_da_noleggiare);

	if(mysqli_num_rows($res) < 0){
		echo "Errore: " . $res->error;
	}

	$row = mysqli_fetch_array($res);

?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Noleggio form</title>
		<link rel="stylesheet" href="../res/css/noleggio/form-noleggio.css" type="text/css" />
	</head>


	<body>
		<div class="row">
			<div class="column left-column">		
				<div class="car-name"><?php echo" " . $row['marca'] . " " . $row['modello'] . " ";?></div> 
					<img class="car" src="http://localhost/projects/repository-linguaggi/img/<?php echo"".$row['nome_file_img'].""?>"></img>
			</div>
			<div class="column">
				<div class="bar"></div>
			     <form class="form" method="post" action="../lib/php/check-noleggio.php">
					<div class="flexbox">
						<div class="flex-item">
							<label for="giorno_inizio">Giorno_inizio</label><br /><br />
							<input type="date" name="giorno_inizio"></input>
						</div>
						<div class="flex-item">
							<label for="giorno_fine">Giorno_fine</label><br /><br />
							<input type="date" name="giorno_fine"></input>
						</div>
					</div>

					<?php 

						//CONTROLLO ERRORI DATE
						if(isset($_SESSION['error_days'])){
							if($_SESSION['error_days'] === 'start > end'){
								echo"<div class=\"error-container\"><p class=\"errore\">Errore: Giorno di inizio maggiore del giorno di fine</div></p>";
								unset($_SESSION['error_days']);
							} elseif($_SESSION['error_days'] === '<today'){
								echo"<div class=\"error-container\"><p class=\"errore\">Errore: Gorno di inzio minore di oggi</div></p>";
								unset($_SESSION['error_days']);
							} elseif($_SESSION['error_days'] === 'nulldate'){
								echo"<div class=\"error-container\"><p class=\"errore\">Errore: inserisci le date</div></p>";
								unset($_SESSION['error_days']);
							}	
						}

						//3 CASI POSSIBILI: disp non è settata (caso inziale)->inserisco le date e verifico, successivamente disp verrà settata necessariamente o a yes o a no.
						if(!isset($_SESSION['disp'])){
							echo "<div class=\"btn\"><button type=\"submit\">VERIFICA DISPONIBILIT&Agrave;</button></div>
							 	<input type=\"hidden\" name=\"id_auto\" value=\"$id_auto\"></input";
					     //disp = 'no': le date non sono disponibili perchè ci sono altri noleggi prenotati-> il bottone rimanda allo script che rieseguirà le query e verificherà la disponibilità.
						} elseif($_SESSION['disp'] === 'no'){
							echo "<div class=\"error-container\"><p class=\"error\">date non disponibili</p></div>
								<div class=\"btn\"><button type=\"submit\">VERIFICA DISPONIBILIT&Agrave;</button></div>
								<input type=\"hidden\" name=\"id_auto\" value=\"$id_auto\"></input";
						//CASO IN CUI TORNO INDIETRO DAL CHECKOUT CON LA VARIABILE SETTATA A 'yes' -> qualsiasi data risulterebbe prenotabile, perciò la setto a 'no' e inserisco le date, ripremo il bottone e rieseguo la query.
						} elseif($_SESSION['disp'] === 'yes'){
							unset($_SESSION['disp']);
							echo "<div class=\"btn\"><button type=\"submit\">VERIFICA DISPONIBILIT&Agrave;</button></div>
								<input type=\"hidden\" name=\"id_auto\" value=\"$id_auto\"></input";
						}

					?>

				</form>
			</div>
		</div>
	</body>

	<?php
		$conn->close();
	?>

</html>