<?php
    session_start();
    require('../res/var/db.php');
    $conn = new mysqli($servername, $db_username, $db_password, $db_name);

    $id_utente = $_SESSION['id_utente'];

    $view = "SELECT *
    		   FROM noleggio n, auto a
    		   WHERE n.id_utente = '$id_utente'
    		   AND n.id_auto = a.id";

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
              <link rel=\"stylesheet\" href=\"../res/css/global/header.css\" type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/noleggio/i-miei-noleggi.css\"   type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/global/footer.css\" type=\"text/css\" />";
        } elseif(isset($_COOKIE['dark-mode']) && $_COOKIE['dark-mode'] === 'true'){
          echo"
              <link rel=\"stylesheet\" href=\"../res/css/global/dark-theme/dark-header.css\" type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/noleggio/dark-theme/dark-i-miei-noleggi.css\"   type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/global/footer.css\" type=\"text/css\" />";
        }

      ?>
	</head>

	<body>

		<div id="header">
      		<div id="title"><img src="http://localhost/projects/repository-linguaggi/img/logoS_S.png" alt=" "></img></div>
    			</div>
    			<div class ="mainmenu">
        		<ul>
         		 	<li><a href ="dove_siamo.php">DOVE SIAMO</a></li>
          			<li><a href ="noleggio.php">NOLEGGIO</a></li>
          			<li><a href ="homepage.php">HOMEPAGE</a></li>
         			<li><a href ="#contatti">CONTATTI</a></li>
        		</ul>
  		</div>
      
      	<div id="select-menu"><a href="#hidden-menu">&#x2630;</a></div>
      	<div><span id="back-target"></span></div>
      	<div id="hidden-menu">
        	<ul>
          	<li>SERVIZI FINANZIARI</li>
          	<li>USATO GARANTITO</li>
          	<li>PRENOTA UN NOLEGGIO</li>

          	<?php
            	if(isset($_SESSION['tipo_utente'])){
              	$nome_utente = $_SESSION['nome_utente'];
              	echo "<li style=\"color: #FF6600;\">$nome_utente</li>
                     <li><a href=\"../lib/php/logout.php\" style=\"color: #FF6600;\">LOGOUT</a></li>";
            	} else {
              	echo "<a href=\"login.php\" style=\"color: #FF6600;\"><li>ACCEDI</li></a>";
            	}
          	?>
          
          	<li>IMPOSTAZIONI</li>
          	<li>NEWSLETTER</li>
          	<li>FAQ</li>
          	<form method="post" action="../lib/php/dark-mode.php">
             <li>
              <input type="hidden" name="page" value="i-miei-noleggi">
              <input type="submit" name="dark-mode" 
              <?php

                if(!isset($_COOKIE['dark-mode']) || $_COOKIE['dark-mode'] === 'false'){
                  echo "value=\"dark\"";
                } elseif (isset($_COOKIE['dark-mode']) && $_COOKIE['dark-mode'] === 'true'){
                  echo "value=\"light\"";
                } 

              ?> >
            
             </input></li>
          	</form>
        	</ul>
        	<div id="back"><a href="#back-target">&#x2715;</a></div>
      	</div>
      
		<h2>I MIEI NOLEGGI</h2>
		<div class="table">
			<table>
				<tr>
					<th>Marca</th>
					<th>Modello</th>
					<th>Data inizio</th>
					<th>Data fine</th>
					<th>Prezzo totale</th>
				</tr>
				<?php

					$res = mysqli_query($conn, $view);

					if(mysqli_num_rows($res) > 0){

			 			foreach ($res as $row){
			 				echo "<tr>
			 						<td>" . $row['marca'] . "</td>
			 						<td>" . $row['modello'] . "</td>
			 						<td>" . $row['data_inizio'] . "</td>
			 						<td>" . $row['data_fine'] . "</td>
			 						<td>" . $row['prezzo_tot'] . " &euro;</td>
			 					 </tr>";
			 			}
					} else {
						echo "<p class=\"none-nol\">NON CI SONO NOLEGGI</p>";
					}

				?>
			</table>
		</div>

		<div class="footer" id="contatti">
      		<div class="grid-item" id="grid-item-1">
        			<h3>SIAMO QUI PER TE</h3>
        			<p>S&amp;S Motors nasce per offrirti le migliori autovetture sul mercato a prezzi imbattibili. <br />
        			Proproniamo anche diversi servizi come noleggio auto o finaziamenti a tasso 0.<br />
        			Non perderti le nostre prossime offerte e iscriviti alla newsletter.</p>
        			<img src="http://localhost/projects/repository-linguaggi/img/payment.jpg" alt="payment-methods" class="payment"></img>
      		</div>
      		<div class="grid-item" id="grid-item-2">
        			<h3>CONTATTI</h3>
        			<ul>
          			<li><span class="social">k</span>  sands@motors.it</li>
          			<li><span class="social">L</span>  333.3333333</li>
          			<li><span class="social">m</span>  06.0000000</li>
          			<li><a href="https://goo.gl/maps/fxjQaQMvub5emHyo9"><span class="social social-transition">9</span></a></li>
        			</ul>
      		</div>
      		<div class="grid-item" id="grid-item-3">
        			<h3>SOCIAL</h3>
        			<ul>
          			<li><span class="social social-transition">E</span></li>
          			<li><span class="social social-transition">Q</span></li>
          			<li><a href="https://github.com/danielesiciliano/repository-linguaggi.git"><span class="social social-transition">)</span></a></li>
        			</ul>
      		</div>
    		</div>
	</body>

</html>