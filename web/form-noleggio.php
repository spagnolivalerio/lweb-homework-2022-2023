<?php

	session_start();
	require('../res/var/db.php');

	$conn = new mysqli($servername, $db_username, $db_password, $db_name);

	if(!isset($_SESSION['tipo_utente'])){
		header('Location: login.php');
	}
	//serve per poter tornare indietro dal form di noleggio e poter cambiare macchina da noleggiare.
	//quando premo NOLEGGIA ORA, l'id auto viene mandato a check-noleggio.php via hidden-field.
	//successivamente lato "server", lo script setta un cookie con l'id dell'auto, in modo che tornando indietro si possa cambiare auto da noleggiare
	if(!isset($_POST['id_auto'])){
		$id_auto = $_COOKIE['id_auto'];
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
		<?php
		echo"" .$_COOKIE['id_auto'] . ""?>

			<div class="row">
				<div class="column">
					<div class="car-name"><?php echo" " . $row['marca'] . " " . $row['modello'] . " ";?></div> 
					<img class="car" src="http://localhost/projects/repository-linguaggi/img/<?php echo"".$row['nome_file_img'].""?>"></img>
				</div>
				<div class="column">

				 <form class="form" method="post" action="../lib/php/check-noleggio.php">
					 <div class="flexbox">
						<div class="flex-item">
							<label for="giorno_inizio">Giorno_inizio</label><br />
							<input type="date" name="giorno_inizio"></input>
						</div>
						<div class="flex-item">
							<label for="giorno_fine">Giorno_fine</label><br />
							<input type="date" name="giorno_fine"></input>
						</div>
						<!--stampa flexbox con prezzo nel caso di $_SESSION[] settata-->
					</div>
					<?php 
						if(!isset($_SESSION['disponibilita']) || $_SESSION['disponibilita'] === 'no'){
						echo "<div class=\"btn\"><button type=\"submit\">VERIFICA DISPONIBILIT&Agrave;</button></div>
							 <input type=\"hidden\" name=\"id_auto\" value=\"$id_auto\"></input";
						} elseif($_SESSION['disponibilita'] === 'yes'){
							echo "<div class=\"btn\"><button type=\"submit\">NOLEGGIA;</button></div>
								 <input type=\"hidden\" name=\"id_auto\" value=\"$id_auto\"></input";
						}

						if(isset($_SESSION['error_days'])){
							echo"<p id=\"errore\">Errore</p>";
						}
					?>
				 </form>

				</div>
			</div>
	<?php
		$conn->close();
	?>
</html>