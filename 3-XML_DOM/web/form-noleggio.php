<?php

	session_start();
	require_once('../lib/DOM/cerca_auto.php');

	//Verifichiamo che siamo loggati.
	if(!isset($_SESSION['tipo_utente'])){
		header('Location: login.php');
		exit(1);
	}

	//Serve per poter tornare indietro una volta premuto il tasto invia dal form-noleggio, perchè rieseguendo la pagina form-noleggio.php non ha ricevuto $_POST['id_auto'], quindi uso variabile di sessione.
	if(!isset($_POST['id_auto'])){
		$id_auto = $_SESSION['id_auto'];
	} else {
		$id_auto = $_POST['id_auto'];
	}

	//definita in DOM/cerca_auto.php
	cerca_auto($id_auto);

?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Noleggio form</title>
		<?php
		if(!isset($_COOKIE['dark-mode']) || $_COOKIE['dark-mode'] === 'false'){
          echo"
              <link rel=\"stylesheet\" href=\"../res/css/noleggio/form-noleggio.css\" type=\"text/css\" />";
        	} elseif(isset($_COOKIE['dark-mode']) && $_COOKIE['dark-mode'] === 'true'){
          echo"
              <link rel=\"stylesheet\" href=\"../res/css/noleggio/dark-theme/dark-form-noleggio.css\" type=\"text/css\" />";
        	}
    ?>
	</head>


	<body>
		<div class="larr"><a href="noleggio.php">&larr;</a></div>
		<div class="firstbox">
		   	<p class="car-name"><?php echo"".$_SESSION['marca']." ".$_SESSION['modello'].""?></p>
				<div class="secondbox">
					<img class="car-image" src="../img/car-img/<?php echo"".$_SESSION['nome_file_img'].""?>" alt="car"></img>
				</div>
				<div class="thirdbox">
				<?php

					//Controllo sugli errori negli inserimenti delle date.
					if(isset($_SESSION['error_days'])){
						if($_SESSION['error_days'] === 'start < today'){
							echo"<div class=\"error-container\" id=\"error-container\"><p>Errore: Giorno di inizio minore di oggi</div></p>";
						} elseif($_SESSION['error_days'] === 'end > today'){
							echo"<div class=\"error-container\" id=\"error-container\"><p>Errore: Giorno finale minore di oggi</div></p>";
						} elseif($_SESSION['error_days'] === 'start_nulldate'){
							echo"<div class=\"error-container\" id=\"error-container\"><p>Errore: inserisci la data iniziale</div></p>";
						}	elseif($_SESSION['error_days'] === 'end_nulldate'){
							echo"<div class=\"error-container\" id=\"error-container\"><p>Errore: inserisci la data finale</div></p>";
						} elseif($_SESSION['error_days'] === 'start > end'){
							echo"<div class=\"error-container\" id=\"error-container\"><p>Errore: inconsistenza nelle date inserite</div></p>";
						}

							//Script per la scomparsa degli errori.
							echo "<script>

									function go_away(id){
										var error = document.getElementById(id);
										error.style.display = \"none\";
									}

									setTimeout(function() { go_away(\"error-container\"); }, 5000);

							  </script>";
					}


					//La variabile di sessione 'disp' serve per verificare la disponibilià delle date inserite: se disp = false, le date non sono disponibili e stampo un errore. Si unsetta la variabile per ripetere il procedimento da zero.
					if(isset($_SESSION['disp']) && $_SESSION['disp'] === false){
						unset($_SESSION['disp']);

						echo "<div class=\"error-container\" id=\"date-non-disp\"><p>date non disponibili</p></div>

							<script>
								function go_away(id){
									var error = document.getElementById(id);
									error.style.display = \"none\";
								}

								setTimeout(function() { go_away(\"date-non-disp\"); }, 5000);

							</script>";
							
					//Se disp = true, teoricamente mi trovo all'interno di checkout-noleggio.php. Nel caso in cui torno indietro per scegliere altre date, devo unsettare la variabile in modo da evitare la scelta di date non disponibili.
					} elseif(isset($_SESSION['disp']) && $_SESSION['disp'] === true){
						unset($_SESSION['disp']);
					}

				?>

				<form action="../lib/DOM/check-noleggio.php" method="post">
					<label for="giorno_inizio">Giorno inizio noleggio:</label>
					<input type="date" name="giorno_inizio"
					<?php
					if(isset($_SESSION['error_days'])){
						if(($_SESSION['error_days'] === 'end < today') || ($_SESSION['error_days'] === 'end_nulldate')){
							echo" value=\"".$_SESSION['giorno_inizio']."\"";
						}
					}
					?>></input><br /><br />
					<label for="giorno_fine">Giorno fine noleggio:</label>
					<input type="date" name="giorno_fine"
					<?php
					if(isset($_SESSION['error_days'])){
						if($_SESSION['error_days'] === 'start < today' || $_SESSION['error_days'] === 'start_nulldate'){
							echo" value=\"".$_SESSION['giorno_fine']."\"";
						}
					}
					?>></input><br /><br />
					<div><button class="btn" type="submit">VERIFICA DISPONIBILIT&Agrave;</button></div>
					<input type="hidden" name="id_auto" value="<?php echo"$id_auto"?>"></input>	
				</form>
			</div>
		</div>

					
	</body>

	<?php
	
		if(isset($_SESSION['error_days'])){
			unset($_SESSION['error_days']);
		}
	?>

</html>