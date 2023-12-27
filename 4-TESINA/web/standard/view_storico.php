<?php 
    session_start();
    require_once("../../lib/get_nodes.php");
    require_once("../../lib/functions.php");
    include('../../conn.php');
    $root="../../";
    $std = "standard";
    $path = "index.php"; 
    addressing($_SESSION['Tipo_utente'], $std, $path); 
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

    $id_utente = $_SESSION['id_utente'];

    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);
    


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/discussioni.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/storico.css" />

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
                <a class="elem" href="view_bozze.php">Bozze</a>
                <a class="elem" href="view_storico.php">Storico</a>
                <div class="divisore"></div>
                <a class="elem" href="../../lib/logout.php">Logout</a>
            </div>
          </div>
          <div class="dashboard">
        <div class="bar"></div>
        <div class="toolbar">
         
        </div>

            <?php

            $storico = getStoricoUtente($root, $id_utente);
                                                                                

            $eventi = []; // Array per memorizzare tutti gli eventi

            $reports_commenti = getStoricoReportsCommenti($root, $storico);

            foreach ($reports_commenti as $report_commento) {

                $data = $report_commento->getAttribute('data_ora');
                $id_commento = $report_commento->getAttribute('id_commento');
                $tipo = $report_commento->getAttribute('tipo');
                $commento = getCommento($root, $id_commento);
                $commentatore = $commento->getAttribute('commentatore');
                $id_discussione = $commento->getAttribute('id_discussione');
                $discussione = getDiscussione($root, $id_discussione);
                $id_progetto = $discussione->getAttribute('id_progetto');
                
                $eventi[] = [
                    'tipo_evento' => 'report_commento',
                    'data' => $data,
                    'commentatore' => $commentatore,
                    'id_progetto' => $id_progetto,
                    'id_commento' => $id_commento,
                    'tipo' => $tipo
                ];
            }

            $reports_progetti = getStoricoReportsProgetti($root, $storico);
            
            foreach ($reports_progetti as $report_progetto) {
                $data = $report_progetto->getAttribute('data_ora');
                $id_progetto = $report_progetto->getAttribute('id_progetto');
                $tipo = $report_progetto->getAttribute('tipo');
                $progetto = getProgetto($root, $id_progetto);
                $publisher = $progetto->getAttribute('id_creator');
                $titolo = $progetto->getElementsByTagName('titolo')->item(0)->nodeValue;

                $eventi[] = [
                    'tipo_evento' => 'report_progetto',
                    'data' => $data,
                    'publisher' => $publisher,
                    'titolo' => $titolo,
                    'id_progetto' => $id_progetto
                ];
            }

            $discussioni_aperte = getStoricoDiscussioni($root, $storico);

            foreach ($discussioni_aperte as $discussione_aperta) {
                $data = $discussione_aperta->getAttribute('data_ora');
                $id_discussione = $discussione_aperta->getAttribute('id_discussione');
                $discussione = getDiscussione($root, $id_discussione);
                $id_progetto = $discussione->getAttribute('id_progetto');
                $titolo = $discussione->getAttribute('titolo');

                $eventi[] = [
                    'tipo_evento' => 'discussioni_aperte',
                    'data' => $data,
                    'id_discussione' => $id_discussione,
                    'titolo' => $titolo,
                    'id_progetto' => $id_progetto
                ];
            }

            $richieste = getStoricoRichieste($root, $storico);
             
            foreach($richieste as $richiesta){
              $data = $richiesta->getAttribute('data_ora');
              $id_discussione = $richiesta->getAttribute('id_discussione');
              $discussione = getDiscussione($root, $id_discussione);
              $titolo = $discussione->getAttribute('titolo');
              $id_progetto = $discussione->getAttribute('id_progetto');

                $eventi[] = [
                    'tipo_evento' => 'richieste',
                    'data' => $data,
                    'id_discussione' => $id_discussione,
                    'titolo' => $titolo,
                    'id_progetto' => $id_progetto
                ];
            }

            $progetti = getStoricoProgetti($root, $storico);

              foreach($progetti as $progetto){
                $data = $progetto->getAttribute('data_ora');
                $id_progetto = $progetto->getAttribute('id_progetto');
                $titolo = $progetto->getAttribute('titolo');

                $eventi[] = [
                    'tipo_evento' => 'progetti',
                    'data' => $data,
                    'titolo' => $titolo,
                    'id_progetto' => $id_progetto
                ];
            }
            
            $commenti = getStoricoCommenti($root, $storico);

              foreach($commenti as $commento){
                $data = $commento->getAttribute('data_ora');
                $id_commento = $commento->getAttribute('id_commento');
                $id_discussione =  $commento->getAttribute('id_discussione');
                $discussione = getDiscussione($root, $id_discussione);
                $id_progetto = $discussione->getAttribute('id_progetto');

                $eventi[] = [
                    'tipo_evento' => 'commenti',
                    'data' => $data,
                    'id_commento' => $id_commento,
                    'id_progetto' => $id_progetto
                ];
            }

            $valutazioniProgetti = getStoricoValutazioniProgetti($root, $storico);

              foreach($valutazioniProgetti as $valutazioneProgetto){
                $data = $valutazioneProgetto->getAttribute('data_ora');
                $id_progetto = $valutazioneProgetto->getAttribute('id_progetto');
                $value = $valutazioneProgetto->getAttribute('value');
                

              $eventi[] = [
                  'tipo_evento' => 'valprogetti',
                  'data' => $data,
                  'value' => $value,
                  'id_progetto' => $id_progetto
              ];
          }

          $valutazioniCommenti = getStoricoValutazioniCommenti($root, $storico);

              foreach($valutazioniCommenti as $valutazioneCommento){
                $data = $valutazioneCommento->getAttribute('data_ora');
                $id_progetto = $valutazioneCommento->getAttribute('id_progetto');
                $id_commento = $valutazioneCommento->getAttribute('id_commento');
                $utilità = $valutazioneCommento->getElementsByTagName('utilita')->item(0)->nodeValue;
                

              $eventi[] = [
                  'tipo_evento' => 'valcommenti',
                  'data' => $data,
                  'id_progetto' => $id_progetto
              ];
          }

          

            // Ordina tutti gli eventi in base alla data
            usort($eventi, function ($a, $b) {
                return strtotime($b['data']) - strtotime($a['data']);
            });

            // Stampa gli eventi ordinati
            echo "<div class=\"lista\">\n";
            echo "  <ul>\n";
            foreach ($eventi as $evento) {
                if ($evento['tipo_evento'] === 'report_commento') {
                    echo "    <li class='evento report'> Hai effettuato un report per " . $evento['tipo'] . " nei confronti dell'utente: " . $evento['commentatore'] . " in merito al contenuto del seguente <a href='view.php?id_progetto=" . $evento['id_progetto'] . "#" . $evento['id_commento'] . "'>commento</a> \n";
                    echo "      <span class=\"data\">" . $evento['data'] . "</span>\n";
                    echo "    </li>\n";
                } elseif ($evento['tipo_evento'] === 'report_progetto') {
                    echo "    <li class='evento report'> Hai effettuato un report per ". $evento['tipo'] ." nei confronti dell'utente: ". $evento['publisher'] ." in merito al contenuto del <a href='homepage.php?#" . $evento['id_progetto'] . "'>progetto</a> intitolato: " . $evento['titolo'] . " \n";
                    echo "      <span class=\"data\">". $evento['data'] ."</span>\n";
                    echo "    </li>\n";
                }elseif ($evento['tipo_evento'] === 'discussioni_aperte') {
                    echo "    <li class='evento report'> Hai aggiunto una <a href='view.php?id_progetto=" . $evento['id_progetto'] . "#" . $evento['id_discussione'] . "'>discussione</a> intitolata: " . $evento['titolo'] . " \n";
                    echo "      <span class=\"data\">". $evento['data'] ."</span>\n";
                    echo "    </li>\n";
                }elseif ($evento['tipo_evento'] === 'richieste') {
                    echo "    <li class='evento report'> Hai richiesto accesso alla <a href='view.php?id_progetto=" . $evento['id_progetto'] . "#" . $evento['id_discussione'] . "'>discussione</a> intitolata: " . $evento['titolo'] . " \n";
                    echo "      <span class=\"data\">". $evento['data'] ."</span>\n";
                    echo "    </li>\n";
                }elseif ($evento['tipo_evento'] === 'progetti') {
                    echo "    <li class='evento report'> Hai pubblicato un <a href='homepage.php?id_progetto=#" . $evento['id_progetto'] . "'>progetto</a> intitolato: " . $evento['titolo'] . " \n";
                    echo "      <span class=\"data\">". $evento['data'] ."</span>\n";
                    echo "    </li>\n";
                }elseif ($evento['tipo_evento'] === 'commenti') {
                    echo "    <li class='evento report'> Hai pubblicato il seguente <a href='view.php?id_progetto=" . $evento['id_progetto'] . "#" . $evento['id_commento'] . "'>commento</a>\n";
                    echo "      <span class=\"data\">". $evento['data'] ."</span>\n";
                    echo "    </li>\n";
                }elseif ($evento['tipo_evento'] === 'valprogetti') {
                    echo "    <li class='evento report'>Hai assegnato al seguente <a href='view.php?id_progetto=" . $evento['id_progetto'] . "'>progetto</a> una valutazione di ". $evento['value'] ." stelle\n";
                    echo "      <span class=\"data\">". $evento['data'] ."</span>\n";
                    echo "    </li>\n";
                }elseif ($evento['tipo_evento'] === 'valcommenti') {
                    echo "    <li class='evento report'>Hai giudicato il seguente <a href='view.php?id_progetto=" . $evento['id_progetto'] . "'>commento</a> come: " . $evento['id_progetto'] . "\n";
                    echo "      <span class=\"data\">". $evento['data'] ."</span>\n";
                    echo "    </li>\n";
                }
            }
            echo "  </ul>\n";
            echo "</div>\n";
            ?>

                    

  </body>



</html>