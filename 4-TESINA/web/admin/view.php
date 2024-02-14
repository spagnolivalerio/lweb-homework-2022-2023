<?php 
    session_start();
    $root = "../../";
    require_once($root . 'conn.php');
    require_once($root . "lib/get_nodes.php");
    require_once($root . "lib/functions.php");
    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);
    $adm = "admin";
    $path = "index.php";

    if (!isset($_POST['id_progetto']) && (isset($_GET['id_progetto']) ) ) {
      $id_progetto = $_GET['id_progetto'];
    } elseif(!empty($_POST['id_progetto'])) {
      $id_progetto = $_POST['id_progetto'];
    }elseif(!isset($_POST['id_progetto']) && !isset($_GET['id_progetto'])){
      header("Location: ../index.php" );
    }

    $id_utente = $_SESSION['id_utente'];

    updateViews($root, $id_progetto);
    
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
    $titolo_step = $step->getAttribute('titolo_step');
    $descrizione_step = $step->getElementsByTagName('descrizione')->item(0)->nodeValue; 
    $img_path = $step->getAttribute('nome_file_img');

    $progetto = getProgetto($root, $id_progetto);
    $descrizione_progetto = $progetto->getElementsByTagName('descrizione')->item(0)->nodeValue;
    $id_creator = $progetto->getAttribute('id_creator');
    $reports_progetto = getSegnalazioniProgetto($root, $id_progetto);
    $reported_project = already_reported($reports_progetto, $id_utente);
    $valutazioni_progetto = getValutazioniProgetto($root, $id_progetto);
    $p_voted = already_voted($valutazioni_progetto, $id_utente);

    addressing($_SESSION['Tipo_utente'], $adm, $path); //redirect

    $logout = $root . "lib/logout.php?ban=true";
    addressing($_SESSION['ban'], 0, $logout);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/discussioni.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/progetti.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/valutazione_progetto.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/recensioni_progetto.css"></link>

      <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js">
        function scomparsa() {
            var error = document.getElementById('error');
            if (error) {
                error.style.display = "none";
            }
        }
        setTimeout(scomparsa, 4000);
      </script>

  </head>

  <body>

        <div class="homepage">
          <div class="homepage-sidebar">
            <div class="intestazione">
              
            </div>
            <div class="homepage-sidebar-list">
            <a class="elem" href="homepage.php">Homepage</a>
            <a class="elem" href="bacheca.php">Profilo</a>
            <a class="elem" href="moderator_dashboard.php">Dashboard</a>
            <a class="elem" href="view_storico.php">Storico</a>
            <div class="divisore"></div>
            <a class="elem" href="../../lib/logout.php">Logout</a>
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
              echo "                <div class=\"fase\"><h4>".$titolo_step." - STEP " . $num_step+1 . "</h4></div>\n";
              echo "                <div class=\"testo\">$descrizione_step</div>\n";
              echo "            </div>\n";
              echo "        </div>\n";
              echo "        <form action=\"" . $root . "lib/forward_numstep.php\" method=\"post\">\n";
              echo "        <div class=\"nascondi\"><input type=\"hidden\" value=\"$num_step\" name=\"num_step\"></input></div>\n";
              echo "        <div class=\"nascondi\"><input type=\"hidden\" value=\"$id_progetto\" name=\"id_progetto\"></input></div>\n";
              echo "        <div class=\"move-button\">\n";
              if($num_step == 0){
                  echo "            <div class=\"left\"></div>\n";
              } else{
                  echo "            <button class=\"left l\" name=\"action\" value=\"prev\" type=\"submit\">&#129184; Prev</button>\n";
              }

              if($step->nextSibling){
                  echo "            <button class=\"right r\" name=\"action\" value=\"next\" type=\"submit\">Next &#129185;</button>\n";
              } else{
                  echo "            <div class=\"right\"></div>\n";
              }
              echo "        </div>\n";
              echo "        </form>\n";
 
              echo "    </div>\n";
              ?>

             <div class="descrizione_progetto">
                <h2>DESCRIZIONE</h2>
                <p><?php echo "$descrizione_progetto";?></p>
                <?php
                if($id_creator !== $id_utente){
                  echo "<span><a href=\"#recensioni\">Valuta o segnala</a></span>\n";
                }             
                ?>
              </div>
            </div> 

              
            <div class = "aprire-discussione">
              <div class="label-form">Apri discussione</div>
                <form class="form-aprire-discussione" action="../../lib/aprire_discussione.php" method="post">
                  <p>Titolo<br />
                  <input type="text" name="titolo" id="titolo"></input></p>
                  <p>Descrizione<br />
                  <textarea name="descrizione" id="descrizione" cols="50" rows="2"></textarea></p>
                  <div class="nascondi"><input type="hidden" name="id_progetto" <?php echo "value=\"$id_progetto\"";?>></input></div>
                  <div><button type="submit">Apri Discussione</button></div>
                </form>
            </div>
              
            <!-- STAMPA DISCUSSIONI -->
      
            <div class="content">

            <?php

              foreach($discussioni as $discussione){

                $id_discussione = $discussione->getAttribute('id');
                $titolo = $discussione->getAttribute('titolo');
                $descrizione = $discussione->getElementsByTagName('descrizione')->item(0)->nodeValue;
                $autore = $discussione->getAttribute('autore');
                $id_autore = $discussione->getAttribute('id_poster');
                $data_ora = $discussione->getAttribute('data_ora');
                $risolta = $discussione->getAttribute('risolta');
                $commenti = getCommenti($root, $id_discussione);

                $partecipanti = getPartecipanti($root, $id_discussione);
                $richieste_accesso = getRichiesteAccesso($root, $id_discussione);
                $sended = already_sended($richieste_accesso, $id_utente);

                $query = "SELECT * FROM utente WHERE id = '$id_autore'"; 
                $res = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($res); 
                $avatar = $row['avatar']; 


                echo "<div class=\"discussion-container\">\n";
                echo "    <div class=\"discussion-header\" id=\"disc_" . $id_discussione . "\">\n";
                echo "        <h1 class=\"discussion-title\">$titolo</h1>\n";

                //DA POSIZIONARE
                if($risolta == "false"){
                  if($id_autore === $id_utente){
                    echo "      <form class=\"\" action=\"../../lib/chiudi_discussione.php\" method=\"post\">\n";
                    echo "        <div class=\"nascondi\"><input class=\"\" name=\"id_progetto\" type=\"hidden\" value=\"$id_progetto\"></input></div>\n";
                    echo "        <div class=\"nascondi\"><input class=\"\" name=\"id_discussione\" type=\"hidden\" value=\"$id_discussione\"></input></div>\n";
                    echo "        <button type=\"submit\" name=\"risolta\" value=\"true\">Contrassegna come risolta</button>\n";
                    echo "      </form>\n";
                  }
                }

                echo "        <div class=\"discussion-info\">\n";
                echo "            <div class=\"top-info\">\n";
                echo "              <img src=\"$root/img/avatar/$avatar\" alt=\"&#x1F464;\" style=\"width: 20px; height: 20px;\"></img>\n";
                echo "              <span>$autore</span>\n";
                echo "            </div>\n";
                echo "            <span class=\"datetime\">$data_ora</span>\n";
                echo "        </div>\n";
                echo "        <p class=\"discussion-text\">$descrizione</p>\n";
                echo "    </div>\n";
                echo "    <div class=\"comment-container\">\n";

                if($risolta == "true"){

                  //stampa di controllo

                }else {

                echo "        <form class=\"comment-form\" action =\"../../lib/commentare.php\" method=\"post\">\n";
                echo "            <div class=\"nascondi\"><input type=\"hidden\" name=\"id_discussione\" value=\"$id_discussione\"></input></div>\n";
                echo "            <div class=\"nascondi\"><input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input></div>\n";
                echo "            <div><input type=\"text\" name=\"testo\"></input>\n";
                echo "            <button type=\"submit\">Commenta</button></div>\n";
                echo "        </form>\n";
                }

                echo "        <div class=\"commenti-span\"><h2>COMMENTI</h2></div>\n";

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

                  $query = "SELECT * FROM utente WHERE id = '$id_commentatore'"; 
                  $res = mysqli_query($conn, $query);
                  $row = mysqli_fetch_array($res); 
                  $avatar = $row['avatar']; 

                  echo "        <div class=\"comment\" id=\"com_" . $id_commento . "\">\n";
                  echo "            <div class=\"comment-info\">\n";
                  echo "              <div class=\"top-info\">\n";
                  echo "                <img src=\"$root/img/avatar/$avatar\" alt=\"&#x1F464;\" style=\"width: 20px; height: 20px;\"></img>\n";
                  echo "                <span class=\"comment-author\">$commentatore</span>\n";
                  echo "              </div>\n";

                
                echo "      <form action=\"../../lib/rimuovere_commento.php\" method=\"post\">\n";
                echo "        <p><input class=\"submit-delete\" type=\"submit\" value=\"&#10005;\"></input></p>\n";
                echo "        <div class=\"nascondi\"><input class=\"hidden\" name=\"id_commento\" type=\"hidden\" value=\"$id_commento\"></input></div>\n";
                echo "        <div class=\"nascondi\"><input class=\"hidden\" name=\"id_discussione\" type=\"hidden\" value=\"$id_discussione\"></input></div>\n";
                echo "        <div class=\"nascondi\"><input class=\"hidden\" name=\"id_progetto\" type=\"hidden\" value=\"$id_progetto\"></input></div>\n";
                echo "      </form>\n";
                

                echo "                <span class=\"comment-datetime\">$data_ora</span>\n";
                echo "            </div>\n";
                echo "            <div class=\"comment-box\">\n";
                echo "                <p class=\"comment-text\">$testo</p>\n";
                echo "            </div>\n";
                
                
                if($voted){
                      //stampa di controllo
                }elseif($id_commentatore !== $id_utente){
                  echo "            <form class=\"form-box\" action=\"../../lib/valuta_commento.php\" method=\"post\">\n";
                  echo "                <div class=\"rating\">\n";
                  echo "                    <input type=\"radio\" name=\"utility\" value=\"5\" id=\"val_5_$id_commento\"></input>\n";
                  echo "                    <label for=\"val_5_$id_commento\">&#9734;</label>\n";
                  echo "                    <input type=\"radio\" name=\"utility\" value=\"4\" id=\"val_4_$id_commento\"></input>\n";
                  echo "                    <label for=\"val_4_$id_commento\">&#9734;</label>\n";
                  echo "                    <input type=\"radio\" name=\"utility\" value=\"3\" id=\"val_3_$id_commento\"></input>\n";
                  echo "                    <label for=\"val_3_$id_commento\">&#9734;</label>\n";
                  echo "                    <input type=\"radio\" name=\"utility\" value=\"2\" id=\"val_2_$id_commento\"></input>\n";
                  echo "                    <label for=\"val_2_$id_commento\">&#9734;</label>\n";
                  echo "                    <input type=\"radio\" name=\"utility\" value=\"1\" id=\"val_1_$id_commento\"></input>\n";
                  echo "                    <label for=\"val_1_$id_commento\">&#9734;</label>\n";
                  echo "                    <span class=\"type-rating\">Utilit&agrave;</span>\n";
                  echo "                </div>\n";
                  echo "                <div class=\"rr\">\n";
                  echo "                    <select name=\"rating\">\n";
                  echo "                        <option value=\"1\">Per niente d'accordo</option>\n";
                  echo "                        <option value=\"2\">Indifferente</option>\n";
                  echo "                        <option value=\"3\">Completamente d'accordo</option>\n";
                  echo "                    </select>\n";
                  echo "                    <span class=\"type-rating\">Accordo</span>\n";
                  echo "                </div>\n";
                  echo "                <div class=\"nascondi\"><input type=\"hidden\" name=\"id_commento\" value=\"$id_commento\"></input></div>\n";
                  echo "                <div class=\"nascondi\"><input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input></div>\n";
                  echo "                <div><button type=\"submit\" class=\"valuta\">VALUTA</button></div>\n";
                  echo "            </form>\n";
                }

                if($reported_comment){
                      //stampa di controllo
                }elseif($id_commentatore !== $id_utente){
                  echo "            <form class=\"form-segnalazione\" action=\"../../lib/aggiungere_report_commento.php\" method=\"post\">\n";
                  echo "              <div class=\"segnalazione-div\">\n";
                  echo "                <label for=\"testo\">Dettagli</label>\n";
                  echo "                <input type=\"text\" name=\"testo\"></input>\n";
                  echo "                <div class=\"select-box\"><select name=\"tipo\">\n";
                  echo "                    <option value=\"spam\">spam</option>\n";
                  echo "                    <option value=\"Contenuti inesatti\">Contenuti inesatti</option>\n";
                  echo "                    <option value=\"Contenuti inappropriati\">Contenuti inappropriati</option>\n";
                  echo "                </select></div>\n";
                  echo "                <div class=\"nascondi\"><input type=\"hidden\" name=\"id_commento\" value=\"$id_commento\"></input></div>\n";
                  echo "                <div class=\"nascondi\"><input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input></div>\n";
                  echo "                <div><button type=\"submit\" class=\"segnala\">segnala</button></div>\n";
                  echo "              </div>\n";
                  echo "            </form>\n"; 
                }
                echo "    </div>\n";
              }

              echo "    </div>\n"; 
              echo "    </div>\n"; 

            }

            ?>
          </div>

          <?php
   
              if($id_creator !== $id_utente){
                echo "    <div class=\"options\" id=\"recensioni\">";
                echo "    <div id=\"error\">\n";
              
          
                if(isset($_SESSION['empty_form']) && $_SESSION['empty_form'] === "true" ){
                  echo "Compila tutti i campi";
                  unset($_SESSION['empty_form']);
                }

                echo " </div>";
                if($p_voted){
                  echo "  <div class=\"votato\">Contributo già valutato</div>\n";
                }else{
                echo "          <div class=\"p-rating-content\">\n";
                echo "            <div class=\"label-form\">Valuta progetto</div>\n";
                echo "            <form class=\"p-rating\" action=\"../../lib/valutare_progetto.php\" method=\"post\">\n";
                echo "                <p>Descrivi la tua esperienza!<br />\n";
                echo "                <textarea name=\"testo\" rows=\"2\" cols=\"50\"></textarea></p>\n";
                echo "                <div class=\"rating stars\">\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"5\" id=\"valpro_5_$id_progetto\"></input>\n";
                echo "                    <label for=\"valpro_5_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"4\" id=\"valpro_4_$id_progetto\"></input>\n";
                echo "                    <label for=\"valpro_4_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"3\" id=\"valpro_3_$id_progetto\"></input>\n";
                echo "                    <label for=\"valpro_3_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"2\" id=\"valpro_2_$id_progetto\"></input>\n";
                echo "                    <label for=\"valpro_2_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"1\" id=\"valpro_1_$id_progetto\"></input>\n";
                echo "                    <label for=\"valpro_1_$id_progetto\">&#9734;</label>\n";
                echo "                </div>\n";
                echo "                <div class=\"nascondi\"><input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input></div>\n";
                echo "                <div><button type=\"submit\">VALUTA</button></div>\n";
                echo "            </form>\n";
                echo "          </div>\n";
                }
              

              if($reported_project){
                echo "  <div class=\"votato\">Contributo segnalato</div>\n";
              }elseif($id_creator !== $id_utente){
                echo "          <div class=\"form-seganalazione-content\">\n";
                echo "            <div class=\"label-form\">Segnala</div>\n";
                echo "            <form class=\"form-segnalazione-progetto\" action=\"../../lib/aggiungere_report_progetto.php\" method=\"post\">\n";
                echo "                <div><select name=\"tipo\">\n";
                echo "                    <option value=\"spam\">spam</option>\n";
                echo "                    <option value=\"Contenuti inesatti\">Contenuti inesatti</option>\n";
                echo "                    <option value=\"Contenuti inappropriati\">Contenuti inappropriati</option>\n";
                echo "                </select></div>\n";
                echo "                <div><textarea name=\"testo\" cols=\"50\" rows=\"2\">Esprimi la tua motivazione</textarea>\n";
                echo "                <div class=\"nascondi\"><input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input></div>\n";
                echo "                <button type=\"submit\">SEGNALA</button></div>\n";
                echo "            </form>\n"; 
                echo "          </div>\n";
              }
              echo "          </div>\n";
            }
?>
<?php
          echo "    <div class=\"review-box\">\n";
          echo "    <div class=\"review-title\"><h2>RECENSIONI</h2></div>";
          foreach($valutazioni_progetto as $valutazione_progetto){
            $testo = $valutazione_progetto->getElementsByTagName('testo')->item(0)->nodeValue; 
            $value = $valutazione_progetto->getAttribute('value');
            $id_votante = $valutazione_progetto->getAttribute('id_votante');
            $data_ora = $valutazione_progetto->getAttribute('data_ora');

            $query = "SELECT * FROM utente WHERE id = '$id_votante'"; 
            $res = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($res); 
            $username = $row['username'];

            echo "<div class=\"review-container\">\n";
            echo "    <div class=\"review-header\">\n";
            echo "        <span class=\"review-username\">@" . $username . "</span>\n";
            echo "        <span class=\"review-date\">" . $data_ora . "</span>\n";
            echo "    </div>\n";
            echo "    <div class=\"review-rating\">\n";
            for ($i = 0; $i < 5; $i++) {
                echo "        " . ($i < $value ? "&#9733;" : "&#9734;"); // Stampa stelle piene o vuote
            }
            echo "\n    </div>\n";
            echo "    <div class=\"review-text\">\n";
            echo "        " . $testo . "\n";
            echo "    </div>\n";
            echo "</div>\n";
          }

            foreach($discussioni as $discussione){

              $id_discussione = $discussione->getAttribute('id');
              $commenti = getCommenti($root, $id_discussione);

              foreach($commenti as $commento){
                $testo = $commento->getElementsByTagName('testo')->item(0)->nodeValue; 
                $id_commento = $commento->getAttribute('id'); 
                $valutazioni_commento = getValutazioniCommenti($root, $id_commento);

                foreach($valutazioni_commento as $valutazione_commento){
                  $utilità = $valutazione_commento->getElementsByTagName('utilita')->item(0)->nodeValue;
                  $accordo = $valutazione_commento->getElementsByTagName('livello_di_accordo')->item(0)->nodeValue;
                  $data_ora = $valutazione_commento->getAttribute('data_ora');
                  $id_votante = $valutazione_commento->getAttribute('id_votante');

                  $query = "SELECT * FROM utente WHERE id = '$id_votante'"; 
                  $res = mysqli_query($conn, $query);
                  $row = mysqli_fetch_array($res); 
                  $username = $row['username'];

                  echo "<div class=\"comment-review-container\">\n";
                  echo "    <div class=\"review-header\">\n";
                  echo "        <span class=\"review-username\">@" . $username . "</span>\n";
                  echo "        <span class=\"review-date\">" . $data_ora . "</span>\n";
                  echo "    </div>\n";
                  echo "    <div class=\"comment-text\">\n";
                  echo "        <span class=\"comment-text-label\">Testo del commento recensito:</span> <span class=\"comment-text-content\">" . $testo . "</span>\n";
                  echo "    </div>\n";
                  echo "    <div class=\"review-rating\">\n";
                  echo "        <span class=\"utilita-label\">Valutazione dell'utilità:</span> <span class=\"rating-stars\">";
                  for ($i = 0; $i < 5; $i++) {
                      echo "<span class=\"star\">" . ($i < $utilità ? "&#9733;" : "&#9734;") . "</span>\n"; // Stampa stelle piene o vuote per l'utilità
                  }
                  echo "<br /></span>\n";
                  echo "<span class=\"accordo-label\">Livello di accordo:</span> ";
                  switch ($accordo) {
                      case 1:
                          echo "<span class=\"accordo-value\">Per nulla d'accordo</span>";
                          break;
                      case 2:
                          echo "<span class=\"accordo-value\">Indifferente</span>";
                          break;
                      case 3:
                          echo "<span class=\"accordo-value\">Completamente d'accordo</span>";
                          break;
                  }
                  echo "\n    </div>\n";
                  echo "</div>\n";
                }
          }
          echo "          </div>\n";
        }
?>
        </div>
  </body>
</html>