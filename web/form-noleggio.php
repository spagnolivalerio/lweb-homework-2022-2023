<?php

	session_start();
	require('../res/var/db.php');

	$conn = new mysqli($servername, $db_username, $db_password, $db_name);

	if(!isset($_SESSION['tipo_utente'])){
		header('Location: login.php');
		exit(1);
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

	$_SESSION['prezzo_giornaliero'] = $row['prezzo_giornaliero'];
	$_SESSION['marca'] = $row['marca'];
	$_SESSION['modello'] = $row['modello'];

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
		<div class="firstbox">
		   	<p class="car-name"><?php echo"".$_SESSION['marca']." ".$_SESSION['modello'].""?></p>
				<div class="secondbox">
					<img class="car-image" src="../img/car-img/<?php echo"".$row['nome_file_img'].""?>" alt="car"></img>
				</div>
				<div class="thirdbox">
				<?php
				//CONTROLLO ERRORI DATE INSERITE
					if(isset($_SESSION['error_days'])){
						if($_SESSION['error_days'] === 'start > end'){
							echo"<div class=\"error-container\" id=\"error-container\"><p>Errore: Giorno di inizio maggiore del giorno di fine</div></p>";
							unset($_SESSION['error_days']);
						} elseif($_SESSION['error_days'] === '<today'){
							echo"<div class=\"error-container\" id=\"error-container\"><p>Errore: Gorno di inzio minore di oggi</div></p>";
							unset($_SESSION['error_days']);
						} elseif($_SESSION['error_days'] === 'nulldate'){
							echo"<div class=\"error-container\" id=\"error-container\"><p>Errore: inserisci le date</div></p>";
							unset($_SESSION['error_days']);
						}

							echo "<script>

									function go_away(id){
										var error = document.getElementById(id);
										error.style.display = \"none\";
									}

									setTimeout(function() { go_away(\"error-container\"); }, 5000);

							  </script>";
					}


					//disp = 'no': le date non sono disponibili perchè ci sono altri noleggi prenotati-> il bottone rimanda allo script che rieseguirà le query e verificherà la disponibilità.
					if(isset($_SESSION['disp']) && $_SESSION['disp'] === 'no'){
						unset($_SESSION['disp']);

						echo "<div class=\"error-container\" id=\"date-non-disp\"><p>date non disponibili</p></div>

							<script>
								function go_away(id){
									var error = document.getElementById(id);
									error.style.display = \"none\";
								}

								setTimeout(function() { go_away(\"date-non-disp\"); }, 5000);

							</script>";
							

					//CASO IN CUI TORNO INDIETRO DAL CHECKOUT CON LA VARIABILE SETTATA A 'yes'-> qualsiasi data risulterebbe prenotabile, perciò la setto a 'no' e inserisco le date, ripremo il bottone e rieseguo la query.
					} elseif(isset($_SESSION['disp']) && $_SESSION['disp'] === 'yes'){
						unset($_SESSION['disp']);
					}

				?>

				<form action="../lib/php/check-noleggio.php" method="post">
					<label for="giorno_inizio">Giorno inizio noleggio:</label>
					<input type="date" name="giorno_inizio"></input><br /><br />
					<label for="giorno_fine">Giorno fine noleggio:</label>
					<input type="date" name="giorno_fine"></input><br /><br />
				<?php
					
					echo"<div><button class=\"btn\" type=\"submit\">VERIFICA DISPONIBILIT&Agrave;</button></div>
						<input type=\"hidden\" name=\"id_auto\" value=\"$id_auto\"></input>";
				?>	

				</form>
			</div>
		</div>

					
	</body>

	<?php
		$conn->close();
	?>

</html>