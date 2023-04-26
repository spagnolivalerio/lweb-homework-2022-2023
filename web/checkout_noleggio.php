<?php
	session_start();
	$tot_costo = ($_SESSION['num_days'] + 1) * $_SESSION['prezzo_giornaliero'];
    if($_SESSION['disp'] !== 'yes'){
        header('Location: noleggio.php');
    }
?>


<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Checkout noleggio</title>
    <link rel="stylesheet" href="../res/css/noleggio/checkout-style.css" type="text/css" />
</head>


<body>
    <div class="block">
        <h1>Resoconto Noleggio</h1>
        <ul>

        <?php echo 
                	"<li>&#128664; Noleggio <span class=\"bold-text\"> " . $_SESSION['marca'] . " " . $_SESSION['modello'] . "</span></li>
                	<li>&#128197; Dal: " . $_SESSION['giorno_inizio'] . " al: " . $_SESSION['giorno_fine'] . "</li>
                	<li>&#128181; Costo Totale: <span class=\"bold-text\">" . $tot_costo . "&euro;</span></li>
                	<button class=\"noleggio-button\" type=\"submit\">CONFERMA</button>"; 
        ?>

        </ul>
    </div>
</body>

</html>

