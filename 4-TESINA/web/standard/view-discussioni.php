<?php 
    session_start();
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    require_once($root . "lib/functions.php");
    $var = $_SESSION['Tipo_utente'];
    $std = "standard";
    $path = "index.php";

    if (!isset($_POST['id_progetto']) && (isset($_GET['id_progetto']) ) ) {
      $id_progetto = $_GET['id_progetto'];
    } elseif(!empty($_POST['id_progetto'])) {
      $id_progetto = $_POST['id_progetto'];
    }elseif(!isset($_POST['id_progetto']) && !isset($_GET['id_progetto'])){
      header("Location: ../index.php" );
    }

    $id_utente = $_SESSION['id_utente'];

    $discussioni = getDiscussioni($root, $id_progetto);
    $steps = getSteps($root, $id_progetto);

    if(empty($steps)){
      exit; 
    } 

    if(!empty($_GET['num_step'])){
      $num_step = $_GET['num_step'];
    } else {
      $num_step = 0; 
    }

    $step = $steps->item($num_step);
    $descrizione_step = $step->getElementsByTagName('descrizione')->item(0)->nodeValue; 
    $img_path = $step->getAttribute('nome_file_img');

    $reports_progetto = getSegnalazioniProgetto($root, $id_progetto);
    $reported_project = already_reported($reports_progetto, $id_utente);
    $valutazioni_progetto = getValutazioniProgetto($root, $id_progetto);
    $voted = already_voted($valutazioni_progetto, $id_utente);

    addressing($var, $std, $path); 

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/discussioni.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/progetti.css" />

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

              <?php

              echo "<div class=\"step\">\n";
              echo "    <div class=\"step-container\">\n";
              echo "        <div class=\"step-content\">\n";
              echo "            <div class=\"step-img\" style=\"background-image: url('../../$img_path'); background-size: cover; background-position: center;\"></div>\n";
              echo "            <div class=\"descrizione\">\n";
              echo "                <div class=\"fase\"><h4>STEP " . $num_step+1 . "</h4></div>\n";
              echo "                <div class=\"testo\">$descrizione_step</div>\n";
              echo "            </div>\n";
              echo "        </div>\n";
              echo "        <form action=\"" . $root . "lib/forward_numstep.php\" method=\"post\">\n";
              echo "        <input type=\"hidden\" value=\"$num_step\" name=\"num_step\"></input>\n";
              echo "        <input type=\"hidden\" value=\"$id_progetto\" name=\"id_progetto\"></input>\n";
              echo "        <div class=\"move-button\">\n";
              if($num_step === 0){
                  echo "            <div class=\"left\" type=\"submit\"></div>\n";
              } else{
                  echo "            <button class=\"left l\" name=\"action\" value=\"prev\" type=\"submit\">&#129184; Prev</button>\n";
              }

              if($step->nextSibling){
                  echo "            <button class=\"right r\" name=\"action\" value=\"next\" type=\"submit\">Next &#129185;</button>\n";
              } else{
                  echo "            <div class=\"right\" type=\"submit\"></div>\n";
              }
              echo "        </div>\n";
              echo "        </form>\n";
              echo "    </div>\n";
              echo "</div>";

              #DA POSIZIONARE
              if($voted){
                echo "  <div class=\"votato\">Contributo già valutato</div>\n";
              }else{
                echo "            <form class=\"form-box\" action=\"../../lib/valutare_progetto.php\" method=\"post\">\n";
                echo "                <div class=\"rating\">\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"5\" id=\"5_$id_progetto\">\n";
                echo "                    <label for=\"5_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"4\" id=\"4_$id_progetto\">\n";
                echo "                    <label for=\"4_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"3\" id=\"3_$id_progetto\">\n";
                echo "                    <label for=\"3_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"2\" id=\"2_$id_progetto\">\n";
                echo "                    <label for=\"2_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"1\" id=\"1_$id_progetto\">\n";
                echo "                    <label for=\"1_$id_progetto\">&#9734;</label>\n";
                echo "                    <span class=\"type-rating\">Rating</span>\n";
                echo "                </div>\n";
                echo "                <input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input>\n";
                echo "                <textarea type=\"text\" name=\"testo\"></textarea>\n";
                echo "                <button type=\"submit\" class=\"valuta\">VALUTA</button>\n";
                echo "            </form>\n";
              }

                  #DA POSIZIONARE BENE
              if($reported_project){
                echo "  <div class=\"reported\">Segnalazione effettuata --> Stato della segnalazione: In attesa di un riscontro</div>\n";
              }else{
                echo "            <form class=\"form-segnalazione\" action=\"../../lib/aggiungere_report_progetto.php\" method=\"post\">\n";
                echo "                <label for=\"segnala\"></label>\n";
                echo "                <input type=\"text\" name=\"testo\" placeholder=\"Fornisci maggiori dettagli\"></input>\n";
                echo "                <select name=\"tipo\">\n";
                echo "                    <option value=\"spam\">spam</option>\n";
                echo "                    <option value=\"Contenuti inesatti\">Contenuti inesatti</option>\n";
                echo "                    <option value=\"Contenuti inappropriati\">Contenuti inappropriati</option>\n";
                echo "                </select>\n";
                echo "                <input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input>\n";
                echo "                <button type=\"submit\" class=\"segnala\">segnala</button>\n";
                echo "            </form>\n"; 
              }
              ?>
            
            <div class = "aprire-discussione">
              <form class="form-creazione" action="../../lib/aprire_discussione.php" method="post">
                <input type="text" name="titolo"></input>
                <textarea type="text" name="descrizione"></textarea>
                <input type="hidden" name="id_progetto"<?php echo "value=\"$id_progetto\"";?>></input>
                <button type="submit">Apri Discussione</button>
              </form>
            </div>

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

                echo "        <form class=\"comment-form\" action =\"../../lib/commentare.php\" method=\"post\">\n";
                echo "            <input type=\"text\" name=\"testo\" placeholder=\"Aggiungi un commento alla discussione\"></input>\n";
                echo "            <input type=\"hidden\" name=\"id_discussione\" value=\"$id_discussione\"></input>\n";
                echo "            <input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input>\n";
                echo "            <button type=\"submit\">Commenta</button>\n";
                echo "        </form>\n";
                }

                echo "        <span class=\"commenti-span\"><h2>COMMENTI</h2></span>\n";

                foreach($commenti as $commento){
                  $commentatore = $commento->getAttribute('commentatore');
                  $testo = $commento->getElementsByTagName('testo')->item(0)->nodeValue; 
                  $data_ora = $commento->getAttribute('data_ora');
                  $id_commento = $commento->getAttribute('id'); 
                  $id_commentatore = $commento->getAttribute('id_commentatore'); 
                  $valutazioni_commento = getValutazioniCommenti($root, $id_commento);
                  $voted = already_voted($valutazioni_commento, $id_utente);
                  $reports_commento = getSegnalazioniCommento($root, $id_commento);
                  $reported_comment = already_reported($reports_commento, $id_utente);

                echo "        <div class=\"comment\">\n";
                echo "            <div class=\"comment-info\">\n";
                echo "                <span class=\"comment-author\">$commentatore</span>\n";

                if($id_commentatore === $id_utente){
                  echo "      <form class=\"card-commenta\" action=\"../../lib/rimuovere_commento.php\" method=\"post\">\n";
                  echo "        <input class=\"submit\" type=\"submit\" value=\"🗑️\">\n";
                  echo "        <input class=\"hidden\" name=\"id_commento\" type=\"hidden\" value=\"$id_commento\">\n";
                  echo "        <input class=\"hidden\" name=\"id_discussione\" type=\"hidden\" value=\"$id_discussione\">\n";
                  echo "        <input class=\"hidden\" name=\"id_progetto\" type=\"hidden\" value=\"$id_progetto\">\n";
                  echo "      </form>\n";
                }

                echo "                <span class=\"comment-datetime\">$data_ora</span>\n";
                echo "            </div>\n";
                echo "            <div class=\"comment-box\">\n";
                echo "                <p class=\"comment-text\">$testo</p>\n";
                echo "            </div>\n";
                

                
                if($voted){
                  echo "  <div class=\"votato\">Contributo già valutato</div>\n";
                }elseif(!$flag){
                  echo "  <div class=\"votato\">Richiedi accesso per valutare i contributi</div>\n";
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

                if($reported_comment){
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

              echo "    </div>\n"; 
              echo "    </div>\n"; 


            }

            ?>
          </div>
        </div>
    </div>
  </body>

</html>

</html>