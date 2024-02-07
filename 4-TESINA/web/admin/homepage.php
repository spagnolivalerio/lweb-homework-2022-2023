<?php
    session_start();   
    $root = "../../";
    include('../../conn.php');
    require_once($root . "lib/get_nodes.php");
    $id_utente = $_SESSION['id_utente'];
    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);

    $path = "index.php"; 
    $adm = "admin";     
    addressing($_SESSION['Tipo_utente'], $adm, $path);


    if (isset($_GET['id_progetto'])) {
      $id_progetto = $_GET['id_progetto'];
    } 

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" ></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css" ></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/discussioni.css" ></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/progetti.css" ></link>

      <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

      <script type="text/javascript">
        // Quando il documento è pronto
          $(document).ready(function() {
              // Associa un'azione all'evento di input sulla barra di ricerca
              $('#searchInput').on('input', function() {
                  // Ottieni il testo inserito nella barra di ricerca
                  var searchText = $(this).val().toLowerCase();

                  // Per ogni elemento con classe "card-container"
                  $('.card-container').each(function() {
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


  </head>

  <body>

    <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione"></div>
        <div class="homepage-sidebar-list">
          <a class="elem" href="homepage.php">Homepage</a>
          <a class="elem" href="bacheca.php">Bacheca</a>
          <a class="elem" href="moderator_dashboard.php">Dashboard</a>
          <a class="elem" href="view_storico.php">Storico</a>
          <div class="divisore"></div>
          <a class="elem" href="../../lib/logout.php">Logout</a>
        </div>
      </div>
      <div class="dashboard">
        <div class="bar"></div>
        <div class="toolbar">
          <div class="searchbar">
            <input type="text" id="searchInput" placeholder="Cerca per titolo..."></input>
            <select id="categoriaSelect">
              <option value="tutte">Tutte le categorie</option>
        <?php
        
          $categorie = getCategorie($root);

          foreach($categorie as $categoria){
            $id_cat = $categoria->getAttribute('id');
            $label = getNomeCategoria($root, $id_cat);
            echo "<option value=\"$id_cat\">$label</option>\n";

          }
        ?>
          </select>
        </div>
        </div>
        <div class="cards">

            <?php
 
              $progetti = getProgetti($root);

              foreach($progetti as $progetto){

                $titolo = $progetto->getElementsByTagName('titolo')->item(0)->nodeValue;
                $categorie = $progetto->getElementsByTagName('categorie')->item(0); 
                $descrizione = $progetto->getElementsByTagName('descrizione')->item(0)->nodeValue;
                $username = $progetto->getAttribute('username_creator');
                $img_path = $root . $progetto->getAttribute('nome_file_img');
                $id_progetto = $progetto->getAttribute('id'); 
                $id_creator = $progetto->getAttribute('id_creator'); 
                $clearance = $progetto->getAttribute('clearance'); 
                $difficoltà = $progetto->getAttribute('difficolta');
                $sospeso = $progetto->getAttribute('sospeso'); 
                $durata = $progetto->getAttribute('tempo_medio'); 

                $query = "SELECT * FROM utente WHERE id = '$id_creator'"; 
                $res = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($res); 
                $avatar = $row['avatar'];  

                $conn = connect_to_db($servername, $db_username, $db_password, $db_name);
                $query = "SELECT ban FROM utente WHERE id = $id_creator";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();
                $ban_value = $row['ban'];
                $rating = valutazioneProgetto($root, $id_progetto, $conn);
                $rating = round($rating, 1);

                if($sospeso === 'false'){

                  echo "<div class=\"card-container\">\n";
                  echo "  <div class=\"card-header\" style=\"background-image: url('$img_path'); background-size: cover; background-position: center;\">\n";
                  echo "    <div class=\"top-card\">\n";
                  echo "      <div class=\"intestazione-card\">\n";
                  echo "      <img src=\"$root/img/avatar/$avatar\" alt=\"&#x1F464;\" style=\"width: 20px; height: 20px;\"/>\n";
                  if($ban_value == 1){
                    echo "    <div class=\"card-user\">Utente Sospeso</div>\n";
                  } else {
                  echo "      <div class=\"card-user\">$username</div>\n";
                  }
                  echo "    </div>\n";
                  echo "    <form class=\"modify\" action=\"form_modifica_progetto.php\" method=\"post\">\n";
                  echo "      <div><button class=\"modify-button\" type=\"submit\">&#x270F;</button></div>\n";
                  echo "      <div class=\"nascondi\"><input name=\"id_progetto\" type=\"hidden\" value=\"$id_progetto\"></input></div>\n";
                  echo "      <div class=\"nascondi\"><input name=\"clearance\" type=\"hidden\" value=\"$clearance\"></input></div>\n";
                  echo "      <div class=\"nascondi\"><input name=\"difficoltà\" type=\"hidden\" value=\"$difficoltà\"></input></div>\n";
                  echo "      <div class=\"nascondi\"><input name=\"durata\" type=\"hidden\" value=\"$durata\"></input></div>\n";
                  echo "    </form>\n";
                  echo "   </div>\n";
                  echo "    <div class=\"details\">\n";
                  echo "      <div class=\"time\">&#128337;: $durata min</div>\n";
                  echo "      <div class=\"difficulty\">Difficolt&agrave;: $difficoltà</div>\n";
                  echo "    </div>\n";
                  echo "  </div>\n"; 
                  echo "  <div class=\"card-footer\">\n";
                  echo "    <div class=\"flexbox1\">\n";
                  echo "      <div class=\"card-titolo\">$titolo</div>\n";
                  echo "      <div class=\"card-rating\">$rating</div>\n";
                  foreach($categorie->getElementsByTagName('categoria') as $categoria){
                    $id_categoria = $categoria->getAttribute('id_categoria');
                    echo "      <div class=\"card-categorie\">$id_categoria</div>\n";
                  }
                  echo "    </div>\n";
                  echo "    <div class=\"flexbox2\">\n";
                  echo "      <div class=\"card-descrizione\">$descrizione</div>\n";
                  echo "      <form class=\"card-commenta\" action=\"view.php\" method=\"post\">\n";
                  echo "        <div class=\"animation\"></div>\n";
                  echo "        <div class=\"dettagli-button\"><button class=\"submit\" type=\"submit\">Dettagli</button></div>\n";
                  echo "        <div class=\"nascondi\"><input class=\"hidden\" name=\"id_progetto\" type=\"hidden\" value=\"$id_progetto\"></input></div>\n";
                  echo "      </form>\n";
                  echo "    </div>\n";
                  echo "  </div>\n";
                  echo "</div>\n";

                  }
            }

           ?>
        </div>
      </div>
    </div>
    <script type="text/javascript">
                  $('#categoriaSelect').on('change', function() {
                      var selectedCategoria = $(this).val();

                      // Per ogni elemento con classe "card-container"
                      $('.card-container').each(function() {
                          // Ottieni le categorie del progetto
                          var categorie = $(this).find('.card-categorie').map(function() {
                              return $(this).text().toLowerCase();
                          }).get();

                          // Controlla se la categoria selezionata è tra le categorie del progetto
                          if (selectedCategoria === 'tutte' || categorie.includes(selectedCategoria)) {
                              $(this).show();  // Mostra l'elemento
                          } else {
                              $(this).hide();  // Nascondi l'elemento
                          }
                      });
                  });

              </script>
  </body>

  


</html>



