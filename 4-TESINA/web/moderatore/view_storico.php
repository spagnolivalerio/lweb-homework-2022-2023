<?php 
    session_start();
    require_once("../../lib/get_nodes.php");
    require_once("../../lib/functions.php");
    include('../../conn.php');
    $root="../../";
    $mod = "moderatore";
    $path = "index.php"; 
    addressing($_SESSION['Tipo_utente'], $mod, $path); 

    $logout = $root . "lib/logout.php?ban=true";
    addressing($_SESSION['ban'], 0, $logout);

    $id_utente = $_SESSION['id_utente'];

    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);
    $query = "SELECT * FROM utente";
    $result = $conn->query($query);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/control/storico.css"></link>

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
                <a class="elem" href="view_bozze.php">Bozze</a>
                <a class="elem" href="view_storico.php">Storico</a>
                <div class="divisore"></div>
                <a class="elem" href="../../lib/logout.php">Logout</a>
            </div>
          </div>
          <div class="dashboard">
          <div class="bar"></div>
            <div class="toolbar"></div>


            
        <div class="container">
            <!-- Parte Sinistra - Informazioni Utente -->
            <div class="users-section">
                <div class="filtro">
                    <input type="text" id="searchInput" placeholder="&#x1F50D; Cerca per nome"></input>
                </div>

                <?php

                while ($row = mysqli_fetch_assoc($result)){
                    
                echo "          <div class=\"user-info\" onclick=\"redirectToUserPage('view_storico.php?id_utente=" . $row['id'] . "')\">\n";
                echo "              <div class=\"details-storico\">\n";
                echo "                  <img src=\"../../img/avatar/" . $row['avatar'] . "\" alt=\"\"></img>\n";
                echo "                  <p class=\"card-titolo\">" . $row['username'] . "</p>\n";
                echo "              </div>\n";
                echo "              <p class=\"user-type\">" . $row['tipo'] . "</p>\n";
                echo "          </div>\n";                   
                }  
                ?>
            </div>  

            <!-- Parte Destra - Lista Attività Utente -->
            <div class="activities">

            <?php

            $utente_id = $id_utente;

            if(isset($_GET['id_utente'])){
                
                $utente_id = $_GET['id_utente'];
            }

            $tabella = 1;

            if(isset($_GET['tipo_tabella'])){
                
                $tabella = $_GET['tipo_tabella'];
            }

            $query = "SELECT * FROM utente WHERE id = " . $utente_id;
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            $storico = getStoricoUtente($root, $utente_id);
            

            echo "                <div class=\"profile\">\n";
            echo "                    <div class=\"profile-info\">\n";
            echo "                        <img src=\"../../img/avatar/" . $row['avatar'] . "\" alt=\"\"></img>\n";
            echo "                        <p>" . $row['username'] . "</p>\n";
            echo "                    </div>\n";
            echo "                    <div class=\"table-ref\">\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&amp;tipo_tabella=1\">PROGETTI PUBBLICATI</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&amp;tipo_tabella=2\">COMMENTI PUBBLICATI</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&amp;tipo_tabella=3\">DISCUSSIONI APERTE</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&amp;tipo_tabella=4\">VALUTAZIONI PROGETTI</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&amp;tipo_tabella=5\">VALUTAZIONI COMMENTI</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&amp;tipo_tabella=6\">REPORT COMMENTI</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&amp;tipo_tabella=7\">REPORT PROGETTI</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&amp;tipo_tabella=8\">RICHIESTE ACCESSO</a>\n";
            
            echo "                    </div>\n";
            echo "                </div>\n";

            echo "                <div class=\"activity-type\">\n";
            echo "                    <table class=\"activity-list\">\n";

            if($tabella == 1){

                echo "                        <tr>\n";
                echo "                            <th>ID progetto</th>\n";
                echo "                            <th>Titolo del Progetto</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

                $progetti = getStoricoProgetti($root, $storico);
            
                foreach($progetti as $progetto){

                    $id_progetto = $progetto->getAttribute('id_progetto');
                    $titolo = $progetto->getAttribute('titolo');
                    $data = $progetto->getAttribute('data_ora');

                    $project = getProgetto($root, $id_progetto); #mi serve per fare il controllo sull'eliminazione
                    
                    if($project !== null){

                        echo "                        <tr>\n";
                        echo "                            <td><a href='view.php?id_progetto=" . $id_progetto . "'>" . $id_progetto . "</a></td>\n";
                        echo "                            <td>" . $titolo . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }else{
                        echo "                        <tr>\n";
                        echo "                            <td>Contributo eliminato</td>\n";
                        echo "                            <td>" . $titolo . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n"; 
                    }
                }
            }elseif($tabella == 2){

                echo "                        <tr>\n";
                echo "                            <th>ID commento</th>\n";
                echo "                            <th>Testo del commento</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

                $commenti = getStoricoCommenti($root, $storico);
                
                foreach($commenti as $commento){

                    $id_commento = $commento->getAttribute('id_commento');
                    $id_discussione = $commento->getAttribute('id_discussione');
                    $testo = $commento->getElementsByTagName('testo')->item(0)->nodeValue;
                    $data = $commento->getAttribute('data_ora');                   
                    $discussione = getDiscussione($root, $id_discussione);

                    $commento = getCommento($root, $id_commento);

                    
                    if($commento !== null){
                        $id_progetto = $discussione->getAttribute('id_progetto');

                        echo "                        <tr>\n";
                        echo "                            <td><a href='view.php?id_progetto=" . $id_progetto . "#com_" . $id_commento . "'>" . $id_commento . "</a></td>\n";
                        echo "                            <td>" . $testo . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }else{
                        echo "                        <tr>\n";
                        echo "                            <td>Contributo eliminato</td>\n";
                        echo "                            <td>" . $testo . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }
                }
            }elseif($tabella == 3){

                echo "                        <tr>\n";
                echo "                            <th>ID discussione</th>\n";
                echo "                            <th>Titolo</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

                
                $discussioni_aperte = getStoricoDiscussioni($root, $storico);

                foreach($discussioni_aperte as $discussione_aperta){
                    $data = $discussione_aperta->getAttribute('data_ora');
                    $id_discussione = $discussione_aperta->getAttribute('id_discussione');
                    $titolo = $discussione_aperta->getAttribute('titolo');
                    $discussione = getDiscussione($root, $id_discussione);

                    if($discussione !== null){
                        $id_progetto = $discussione->getAttribute('id_progetto');                  
                    
                        echo "                        <tr>\n";
                        echo "                            <td><a href='view.php?id_progetto=" . $id_progetto . "#disc_" . $id_discussione . "'>" . $id_discussione . "</a></td>\n";
                        echo "                            <td>" . $titolo . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }else{
                        echo "                        <tr>\n";
                        echo "                            <td>Contributo eliminato</td>\n";
                        echo "                            <td>" . $titolo . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }
                }
            }elseif($tabella == 4){

                echo "                        <tr>\n";
                echo "                            <th>ID progetto</th>\n";
                echo "                            <th>Valutazione in stelle</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

                $valutazioniProgetti = getStoricoValutazioniProgetti($root, $storico);
            
                foreach($valutazioniProgetti as $valutazioneProgetto){

                    $data = $valutazioneProgetto->getAttribute('data_ora');
                    $id_progetto = $valutazioneProgetto->getAttribute('id_progetto');
                    $value = $valutazioneProgetto->getAttribute('value');

                    $project = getProgetto($root, $id_progetto); #mi serve per fare il controllo sull'eliminazione
                    
                    if($project !== null){

                        echo "                        <tr>\n";
                        echo "                            <td><a href='view.php?id_progetto=" . $id_progetto . "'>" . $id_progetto . "</a></td>\n";
                        echo "                            <td>" . $value . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }else{
                        echo "                        <tr>\n";
                        echo "                            <td>Contributo Eliminato</td>\n";
                        echo "                            <td>" . $value . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }
                }
            }elseif($tabella == 5){

                echo "                        <tr>\n";
                echo "                            <th>ID commento</th>\n";
                echo "                            <th>Giudizio sull'utilità</th>\n";
                echo "                            <th>Giudizio sul livello di accordo</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

            
                $valutazioniCommenti = getStoricoValutazioniCommenti($root, $storico);

                foreach($valutazioniCommenti as $valutazioneCommento){
                    $data = $valutazioneCommento->getAttribute('data_ora');
                    $id_progetto = $valutazioneCommento->getAttribute('id_progetto');
                    $id_commento = $valutazioneCommento->getAttribute('id_commento');
                    $utilità = $valutazioneCommento->getElementsByTagName('utilita')->item(0)->nodeValue;
                    $accordo = $valutazioneCommento->getElementsByTagName('livello_di_accordo')->item(0)->nodeValue;

                    
                    $commento = getCommento($root, $id_commento);#mi serve per fare il controllo sull'eliminazione

                    if($commento !== null){
                        echo "                        <tr>\n";
                        echo "                            <td><a href='view.php?id_progetto=" . $id_progetto . "#com_" . $id_commento . "'>" . $id_commento . "</a></td>\n";
                        echo "                            <td>" . $utilità . "</td>\n";
                        echo "                            <td>" . $accordo . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }else{
                        echo "                        <tr>\n";
                        echo "                            <td>Contributo eliminato</td>\n";
                        echo "                            <td>" . $utilità . "</td>\n";
                        echo "                            <td>" . $accordo . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }
                }
            }elseif($tabella == 6){

                echo "                        <tr>\n";
                echo "                            <th>ID commento</th>\n";
                echo "                            <th>Categoria del report</th>\n";
                echo "                            <th>Creator del commento</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

            
                $reports_commenti = getStoricoReportsCommenti($root, $storico);

                foreach ($reports_commenti as $report_commento) {

                    $data = $report_commento->getAttribute('data_ora');
                    $id_commento = $report_commento->getAttribute('id_commento');
                    $tipo = $report_commento->getAttribute('tipo');
                    $commentatore = $report_commento->getAttribute('commentatore');
                    $commento = getCommento($root, $id_commento);

                    if($commento !== null){
                    
                        $id_discussione = $commento->getAttribute('id_discussione');
                        $discussione = getDiscussione($root, $id_discussione);

                        
                        $id_progetto = $discussione->getAttribute('id_progetto');

                        echo "                        <tr>\n";
                        echo "                            <td><a href='view.php?id_progetto=" . $id_progetto . "#com_" . $id_commento . "'>" . $id_commento . "</a></td>\n";
                        echo "                            <td>" . $tipo . "</td>\n";
                        echo "                            <td>" . $commentatore . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }else{
                        echo "                        <tr>\n";
                        echo "                            <td>Contributo eliminato</td>\n";
                        echo "                            <td>" . $tipo . "</td>\n";
                        echo "                            <td>" . $commentatore . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }
                }
            }elseif($tabella == 7){

                echo "                        <tr>\n";
                echo "                            <th>ID progetto</th>\n";
                echo "                            <th>Categoria del report</th>\n";
                echo "                            <th>Creator del progetto</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

            
                $reports_progetti = getStoricoReportsProgetti($root, $storico);
            
                foreach ($reports_progetti as $report_progetto) {
                    $data = $report_progetto->getAttribute('data_ora');
                    $id_progetto = $report_progetto->getAttribute('id_progetto');
                    $tipo = $report_progetto->getAttribute('tipo');
                    $publisher = $report_progetto->getAttribute('publisher');
                    $progetto = getProgetto($root, $id_progetto);

                    
                    if($progetto !== null){
                    

                        echo "                        <tr>\n";
                        echo "                            <td><a href='view.php?id_progetto=" . $id_progetto . "'>" . $id_progetto . "</a></td>\n";
                        echo "                            <td>" . $tipo . "</td>\n";
                        echo "                            <td>" . $publisher . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }else{
                        echo "                        <tr>\n";
                        echo "                            <td>Contributo eliminato</td>\n";
                        echo "                            <td>" . $tipo . "</td>\n";
                        echo "                            <td>" . $publisher . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }
                }
            }elseif($tabella == 8){

                echo "                        <tr>\n";
                echo "                            <th>ID discussione</th>\n";
                echo "                            <th>Titolo Discussione</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

            
                $richieste = getStoricoRichieste($root, $storico);
             
                foreach($richieste as $richiesta){
                    $data = $richiesta->getAttribute('data_ora');
                    $id_discussione = $richiesta->getAttribute('id_discussione');
                    $titolo = $richiesta->getAttribute('titolo');

                    $discussione = getDiscussione($root, $id_discussione);

                    if($discussione !== null){
                        $id_progetto = $discussione->getAttribute('id_progetto');

                        echo "                        <tr>\n";
                        echo "                            <td><a href='view.php?id_progetto=" . $id_progetto . "#disc_" . $id_discussione . "'>" . $id_discussione . "</a></td>\n";
                        echo "                            <td>" . $titolo . "</td>\n";
                        echo "                            <td>" . $data . "</td>\n";
                        echo "                        </tr>\n";
                    }
                }
            }


            echo "                    </table>\n";
            echo "                </div>\n";
        
?>


                </div>
            </div>
        </div>



        <script type="text/javascript">
            function redirectToUserPage(url) {
                window.location.href = url;
            }
        </script>

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script type="text/javascript">
            // Quando il documento è pronto
                $(document).ready(function() {
                    // Associa un'azione all'evento di input sulla barra di ricerca
                    $('#searchInput').on('input', function() {
                        // Ottieni il testo inserito nella barra di ricerca
                        var searchText = $(this).val().toLowerCase();

                        // Per ogni elemento con classe "user-info"
                        $('.user-info').each(function() {
                            // Ottieni il titolo del progetto
                            var titolo = $(this).find('.card-titolo').text().toLowerCase();

                            // Controlla se il titolo contiene il testo di ricerca
                            if (titolo.includes(searchText)) {
                                $(this).show();  // Mostra l'elemento
                            } else {
                                $(this).hide();  // Nascondi l'elemento
                            }
                        });
                    });
                });
            </script>

        
          </div>
  </body>
  

</html>