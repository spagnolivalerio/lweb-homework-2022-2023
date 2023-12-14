<?php 
    session_start();
    $root = "../../";
    require_once($root . "lib/get_nodes.php");

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

    
    if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
      $id_progetto = $_GET['id_progetto'];
    } else {
      $id_progetto = $_POST['id_progetto'];
    }

    $id_utente = $_SESSION['id_utente'];

  

    $discussioni = getDiscussioni($root, $id_progetto);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/standard/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/discussioni.css" />

  </head>

  <body>

        <div class="homepage">
          <div class="homepage-sidebar">
            <div class="intestazione">
              <div class="logo">TPS</div>
            </div>
            <div class="homepage-sidebar-list">
              <a class="elem">Homepage</a>
              <a class="elem">Bacheca</a>
              <a class="elem">Progetti</a>
              <a class="elem">Bozze</a>
              <a class="elem">Storico</a>
              <div class="divisore"></div>
              <a class="elem">Logout</a>
            </div>
          </div>
          <div class="dashboard">
            <div class="toolbar"></div>
            <div class="content">

            <?php

              foreach($discussioni as $discussione){

                $id_discussione = $discussione->getAttribute('id');
                $titolo = $discussione->getAttribute('titolo');
                $descrizione = $discussione->getElementsByTagName('descrizione')->item(0)->nodeValue;
                $autore = $discussione->getAttribute('autore');
                $data_ora = $discussione->getAttribute('data_ora');
                $risolta = $discussione->getAttribute('risolta');
                $commenti = getCommenti($root, $id_discussione);

                $partecipanti = getPartecipanti($root, $id_discussione);
                $flag = check_partecipante($partecipanti, $id_utente);
                $richieste_accesso = getRichiesteAccesso($root, $id_discussione);
                $sended = already_sended($richieste_accesso, $id_utente);


                echo "<div class=\"discussion-container\">\n";
                echo "    <div class=\"discussion-header\">\n";
                echo "        <h1 class=\"discussion-title\">$titolo</h1>\n";
                echo "        <p class=\"discussion-info\">\n";
                echo "            <span>$autore</span>\n";
                echo "            <span class=\"datetime\">$data_ora</span>\n";
                echo "        </p>\n";
                echo "        <p class=\"discussion-text\">$descrizione</p>\n";
                echo "    </div>\n";
                echo "    <div class=\"comment-container\">\n";

                if($risolta == "true"){

                  echo "  <div class=\"risolta\">Discussione risolta</div>\n";

                } elseif(!$flag) {

                  if(!$sended){
                    echo "  <div class=\"accesso\">\n";
                    echo "  <form class=\"form-accesso\" action=\"../../lib/richiedere_accesso_discussione.php\" method=\"post\">\n";
                    echo "            <input type=\"hidden\" name=\"id_discussione\" value=\"$id_discussione\"></input>\n";
                    echo "            <input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input>\n";
                    echo "            <button type=\"submit\">Richiedi Accesso</button>\n";
                    echo "     </form>\n";
                    echo "  </div>\n";
                  }else{
                    $stato = getState($richieste_accesso, $id_utente); 
                    echo "  <div class=\"accesso\">Richiesta inviata --> Stato della richiesta: " . $stato . "</div>\n";
                  }

                } else {

                echo "        <form class=\"comment-form\">\n";
                echo "            <input type=\"text\" name=\"comment-text\" placeholder=\"Aggiungi un commento alla discussione\"></input>\n";
                echo "            <input type=\"hidden\" name=\"id_discussione\" value=\"$id_discussione\"></input>\n";
                echo "            <button type=\"submit\">Commenta</button>\n";
                echo "        </form>\n";
                }

                echo "        <span class=\"commenti-span\"><h2>COMMENTI</h2></span>\n";

                foreach($commenti as $commento){
                  $commentatore = $commento->getAttribute('commentatore');
                  $testo = $commento->getElementsByTagName('testo')->item(0)->nodeValue; 
                  $data_ora = $commento->getAttribute('data_ora');
                  $id_commento = $commento->getAttribute('id'); 
                  $valutazioni_commento = getValutazioni($root, $id_commento);
                  $voted = already_voted($valutazioni_commento, $id_utente);
                  $reports_commento = getSegnalazioni($root, $id_commento);
                  $reported = already_reported($reports_commento, $id_utente);

                echo "        <div class=\"comment\">\n";
                echo "            <div class=\"comment-info\">\n";
                echo "                <span class=\"comment-author\">$commentatore</span>\n";
                echo "                <span class=\"comment-datetime\">$data_ora</span>\n";
                echo "            </div>\n";
                echo "            <div class=\"comment-box\">\n";
                echo "                <p class=\"comment-text\">$testo</p>\n";
                echo "            </div>\n";

                if($voted){
                  echo "  <div class=\"votato\">Contributo già valutato</div>\n";
                }else{
                  echo "            <form class=\"form-box\" action=\"../../lib/valuta_commento.php\" method=\"post\">\n";
                  echo "                <div class=\"rating\">\n";
                  echo "                    <input type=\"radio\" name=\"rating\" value=\"5\" id=\"5_$id_commento\">\n";
                  echo "                    <label for=\"5_$id_commento\">&#9734;</label>\n";
                  echo "                    <input type=\"radio\" name=\"rating\" value=\"4\" id=\"4_$id_commento\">\n";
                  echo "                    <label for=\"4_$id_commento\">&#9734;</label>\n";
                  echo "                    <input type=\"radio\" name=\"rating\" value=\"3\" id=\"3_$id_commento\">\n";
                  echo "                    <label for=\"3_$id_commento\">&#9734;</label>\n";
                  echo "                    <input type=\"radio\" name=\"rating\" value=\"2\" id=\"2_$id_commento\">\n";
                  echo "                    <label for=\"2_$id_commento\">&#9734;</label>\n";
                  echo "                    <input type=\"radio\" name=\"rating\" value=\"1\" id=\"1_$id_commento\">\n";
                  echo "                    <label for=\"1_$id_commento\">&#9734;</label>\n";
                  echo "                    <span class=\"type-rating\">Rating</span>\n";
                  echo "                </div>\n";
                  echo "                <div class=\"rr\">\n";
                  echo "                    <label for=\"utility\"></label>\n";
                  echo "                    <select name=\"utility\" id=\"utility\">\n";
                  echo "                        <option value=\"1\">Per niente utile</option>\n";
                  echo "                        <option value=\"2\">Indifferente</option>\n";
                  echo "                        <option value=\"3\">Utile</option>\n";
                  echo "                    </select>\n";
                  echo "                    <span class=\"type-rating\">Utilit&agrave;</span>\n";
                  echo "                </div>\n";
                  echo "                <input type=\"hidden\" name=\"id_commento\" value=\"$id_commento\"></input>\n";
                  echo "                <input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input>\n";
                  echo "                <button type=\"submit\" class=\"valuta\">VALUTA</button>\n";
                  echo "            </form>\n";
                }

                if($reported){
                  echo "  <div class=\"reported\">Segnalazione effettuata --> Stato della segnalazione: In attesa di un riscontro</div>\n";
                }else{
                  echo "            <form class=\"form-segnalazione\" action=\"../../lib/aggiungere_report_commento.php\" method=\"post\">\n";
                  echo "                <label for=\"segnala\"></label>\n";
                  echo "                <input type=\"text\" name=\"testo\" placeholder=\"Fornisci maggiori dettagli\"></input>\n";
                  echo "                <select name=\"tipo\">\n";
                  echo "                    <option value=\"spam\">spam</option>\n";
                  echo "                    <option value=\"Contenuti inesatti\">Contenuti inesatti</option>\n";
                  echo "                    <option value=\"Contenuti inappropriati\">Contenuti inappropriati</option>\n";
                  echo "                </select>\n";
                  echo "                <input type=\"hidden\" name=\"id_commento\" value=\"$id_commento\"></input>\n";
                  echo "                <input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input>\n";
                  echo "                <button type=\"submit\" class=\"segnala\">segnala</button>\n";
                  echo "            </form>\n"; 
                }
                echo "    </div>\n";
              }

              echo "    </div>\n"; // Chiusura di discussioni
              echo "    </div>\n"; // Chiusura di comment


            }

            ?>
          </div>
        </div>
    </div>
  </body>

</html>

</html>