<?php
    session_start();   
    include('../../conn.php');
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    require_once($root . "lib/functions.php");
    $id_utente = $_SESSION['id_utente'];
    $path = "index.php"; 
    $adm = "admin";   
    addressing($_SESSION['Tipo_utente'], $adm, $path);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/control/dashboard.css" />

  </head>

  <body>

    <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione">
          <div class="logo">TPS</div>
        </div>
        <div class="homepage-sidebar-list">
          <a class="elem" href="homepage.php">Homepage</a>
          <a class="elem" href="bacheca.php">Bacheca</a>
          <a class="elem" href="moderator_dashboard.php">Dashboard</a>
          <a class="elem" href="view_bozze.php">Bozze</a>
          <a class="elem" href="view_storico.php">Storico</a>
          <div class="divisore"></div>
          <a class="elem" href="../../lib/logout.php">Logout</a>
        </div>
      </div>
      <div class="dashboard">
      <div class="bar"></div>
        <div class="toolbar"></div>

      <?php
        $richieste = getAllRichiesteAccesso($root);
        $numRichieste = getWaitingRequestNumber($root, $richieste);

        $progetti = getProgetti($root);
        $numProgetti = $progetti->length;

        $numSegnalazioni = 0;
        $segnalazioni_progetti = getAllSegnalazioniProgetto($root);
        foreach($segnalazioni_progetti as $segnalazione_progetto){
          $id_progetto = $segnalazione_progetto->getAttribute('id_progetto');
          $project = getProgetto($root, $id_progetto); #mi serve per fare il controllo sull'eliminazione
          $numSegnalazioni++;          
        }

        $segnalazioni_commenti = getAllSegnalazioniCommento($root);
        foreach($segnalazioni_commenti as $segnalazione_commento){
          $id_commento = $segnalazione_commento->getAttribute('$id_commento');
          $commento = getCommento($root, $id_commento); #mi serve per fare il controllo sull'eliminazione
          $numSegnalazioni++;
          
        }

        $visualizzazioni = getAllViews($progetti);
      ?>  
      
        <div class="flex-container">

          
          <a href="#" class="views-info">
            <span class="icona">&#128200;</span>
            <span class="testo">Numero di visualizzazioni dall'apertura del sito: <?php echo $visualizzazioni; ?></span>
          </a>
               
          <a href="view_richieste.php" class="richieste-info">
            <span class="icona">&#128236;</span>
            <span class="testo">Ci sono <?php echo $numRichieste; ?> richieste di accesso in attesa di un riscontro</span>
          </a>

          <a href="homepage.php" class="project-info">
            <span class="icona">🕹️</span>
            <span class="testo">Sono presenti <?php echo $numProgetti; ?> progetti all'interno del sito</span>
          </a>

          <a href="view_segnalazioni.php" class="report-info">
            <span class="icona">🚨</span>
            <span class="testo">Sono presenti <?php echo $numSegnalazioni; ?> segnalazioni da gestire</span>
          </a>
          
          <a href="listautenti.php" class="lista-utenti">
            <span class="icona">📋</span>
            <span class="testo">Accedi alla lista Utenti</span>
          </a>

        </div>
      
              
      









        
      </div>
    </div>
    
  </body>

</html>
