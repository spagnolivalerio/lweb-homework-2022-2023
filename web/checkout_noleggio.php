<?php
	session_start();
	$tot_costo = ($_SESSION['num_days'] + 1) * $_SESSION['prezzo_giornaliero'];
    $_SESSION['prezzo_tot'] = $tot_costo;

    //Controllo di varie inconsistenze
    if(!isset($_SESSION['tipo_utente'])){
        header('Location: login.php');
        exit(1);
    }

    if(!isset($_SESSION['disp']) || $_SESSION['disp'] === false){
        header('Location: noleggio.php');
        exit(1);
    }


    //La variabile di sessione not_back serve per poter tornare indietro una volta completato l'ordine, senza la visualizzazione di errori dovuti all'inconsistenza di alcune variabili.
    if(isset($_SESSION['not_back']) && $_SESSION['not_back'] === true){
        unset($_SESSION['not_back']);
        header('Location: noleggio.php');
        exit(1);
    }

?>


<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Checkout noleggio</title>
    <?php
        if(!isset($_COOKIE['dark-mode']) || $_COOKIE['dark-mode'] === 'false'){
            echo"
              <link rel=\"stylesheet\" href=\"http://localhost/projects/repository-linguaggi/res/css/noleggio/checkout-style.css\" type=\"text/css\" />";
            } elseif(isset($_COOKIE['dark-mode']) && $_COOKIE['dark-mode'] === 'true'){
            echo"
              <link rel=\"stylesheet\" href=\"http://localhost/projects/repository-linguaggi/res/css/noleggio/dark-theme/dark-checkout-style.css\" type=\"text/css\" />";
            }
    ?>
</head>


<body>
    <?php
        if (!isset($_SESSION['conferma_noleggio'])) {
            echo "<div class=\"larr\"><a href=\"form-noleggio.php\">&larr;</a></div>";
        }
    ?>
    <div class="block">
        <h1>Resoconto Noleggio</h1>
        <ul>

        <?php 
                //La pagina di visualizzazione del checkout è la stessa del resoconto finale. Il controllo per la stampa viene eseguito sulla variabile di sessione 'conferma_noleggio': Nel caso in cui il noleggio va a buon fine, nella pagine insert_in_noleggio.php viene posta $_SESSION['conferma_noleggio'] = 'true' -> verrà stampato il resoconto di noleggio completato.
                //Se $_SESSION['conferma_noleggio'] = 'false' verrà stampato il resoconto di noleggio fallito.
                //Se $_SESSION['conferma_noleggio'] is not set -> viene stampata la pagina per completare il noleggio.
                if(!isset($_SESSION['conferma_noleggio'])){
                    unset($_SESSION['not_back']);
                    echo 
                	       "<li>&#128664; Noleggio <span class=\"bold-text\"> " . $_SESSION['marca'] . " " . $_SESSION['modello'] . "</span></li>
                	       <li>&#128197; Dal: " . $_SESSION['giorno_inizio'] . " al: " . $_SESSION['giorno_fine'] . "</li>
                	       <li>&#128181; Costo Totale: <span class=\"bold-text\">" . $tot_costo . "&euro;</span></li>
                           <form action=\"../lib/php/insert_in_noleggio.php\" method=\"post\">
                	           <button class=\"noleggio-button\" type=\"submit\">CONFERMA</button>
                           </form>";
                } elseif($_SESSION['conferma_noleggio'] === true){
                    unset($_SESSION['conferma_noleggio']);
                    $_SESSION['not_back'] = true;
                    echo "<p class=\"conferma\">NOLEGGIO <span class=\"successo\">COMPLETATO</span>, PREMI HOME TORNARE INDIETRO</p>
                          <div class=\"indietro\"><a href=\"homepage.php\">&#x2302;</a></div>";
                } elseif($_SESSION['conferma_noleggio'] === false){
                    unset($_SESSION['conferma_noleggio']);
                    $_SESSION['not_back'] = true;
                    echo "<p class=\"conferma\">NOLEGGIO <span class=\"fallito\">NON</span> ANDATO A BUON FINE, PREMI HOME PER TORNARE INDIETRO</p>
                          <div class=\"indietro\"><a href=\"homepage.php\">&#x2302;</a></div>";
                }
        ?>

        </ul>
    </div>
</body>

</html>

