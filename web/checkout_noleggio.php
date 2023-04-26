<?php
session_start();

$tot_costo = ($_SESSION['num_days'] + 1) * $_SESSION['prezzo_giornaliero'];


?>


<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title> Checkout noleggio</title>
    <link rel="stylesheet" href="../res/css/noleggio/checkout-style.css" type="text/css" />
</head>


<body>
    <div class="blocco">
        <h1>Resoconto Noleggio</h1>
        <ul>
        <?php echo 
                "<li>&#128664; Noleggio " . $_SESSION['marca'] . " " . $_SESSION['modello'] . "</li>
                <li>&#128197; Dal: " . $_SESSION['giorno_inizio'] . " Al: " . $_SESSION['giorno_fine'] . "</li>
                <li>&#128181; Costo Totale: " . $tot_costo . "&euro;</li>
                <button class=\"noleggio-button\" type=\"submit\">CONFERMA NOLEGGIO</button>

                "; 
                ?>
        </ul>
    </div>
</body>

</html>

