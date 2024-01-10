
<?php
    session_start();   
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    include('../../conn.php');

    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/visitatore/visitatore.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/progetti.css" />


  </head>

  <body>

     <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione">
          <div class="logo">TPS</div>
        </div>
        <div class="homepage-sidebar-list">
          <a class="elem blur">Homepage</a>
          <a class="elem blur">Bacheca</a>
          <a class="elem blur">Bozze</a>
          <a class="elem blur">Storico</a>
          <div class="divisore"></div>
        </div>
      </div>
      <div class="dashboard">
      <div class="bar"></div>
        <div class="toolbar">
          <div class="login"><a href="../login.php">Accedi</a></div>
          <div class="searchbar">
            <input type="text" id="searchInput" placeholder="Cerca per titolo...">
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
          $sospeso = $progetto->getAttribute('sospeso');
          $livello_richiesto = intval($clearance) * 2;

          $query = "SELECT * FROM utente WHERE id = '$id_creator'"; 
          $res = mysqli_query($conn, $query);
          $row = mysqli_fetch_array($res); 
          $avatar = $row['avatar'];  

          $query = "SELECT ban FROM utente WHERE id = $id_creator";
          $result = $conn->query($query);
          $row = $result->fetch_assoc();
          $ban_value = $row['ban'];
          $rating = valutazioneProgetto($root, $id_progetto, $conn);

          if($sospeso === 'false'){

              echo "<div class=\"card-container\">\n";
              echo "  <div class=\"card-header\" style=\"background-image: url('$img_path'); background-size: cover; background-position: center;\">\n";
              echo "   <div class=\"top-card\">\n";
              echo "    <img src=\"$root/img/avatar/$avatar\" alt=\"&#x1F464;\" style=\"width: 20px; height: 20px;\"></img>\n";
              echo "    <div class=\"card-user\">$username</div>\n";
              echo "    </div>\n";
              echo "   </div>\n";
              echo "<div class=\"card-footer\">\n";
              echo "<div class=\"flexbox1\">\n";
              echo "<div class=\"card-titolo\">$titolo</div>\n";
              echo "<div class=\"card-rating\">rating</div>\n";
              echo "</div>\n";
              echo "    <div class=\"flexbox2\">\n";
              echo "      <div class=\"card-descrizione\">$descrizione</div>\n";

              if($clearance == 1){
                echo "      <form class=\"card-commenta\" action=\"view.php\" method=\"post\">\n";
                  echo "        <div class=\"animation\"></div>\n";
                  echo "        <button class=\"submit\" type=\"submit\">Dettagli</button>\n";
                  echo "        <input class=\"hidden\" name=\"id_progetto\" type=\"hidden\" value=\"$id_progetto\">\n";
                echo "      </form>\n";
              }else{
                echo "    <div class=\"card-user\">Effettua l'accesso per i dettagli</div>\n";
              }

              echo "    </div>\n";
            echo "  </div>\n";
            echo "</div>\n";
          }
        } 

      ?>
      </div>

    <div class="footer"></div>

  </body>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
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



</html>