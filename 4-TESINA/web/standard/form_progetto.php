<?php
//1)
//Se il form non è completo, viene salvato nelle bozze e poi si viene reindirizzati nel form degli step. Da qui, dopo aver aggiunto gli step, si può decidere se
//aggiungere altri step o pubblicare il progetto. In questo caso si verrà reindirizzati nel form di creazione del progetto con i campi inseriti in precedenza gia compilati
//mandando l'id della bozza corrente tramite get (che sarà id_vecchia_bozza relativamente a quella nuova creata).
//Questo id servirà all'eliminazione della bozza corrente dal file delle bozze e alla sostituzione di quest'ultima con la nuova bozza, che potrà essere completa o incompleta.
//In questo caso, se l'operazione è stata eseguita per modificare o completare una bozza, bisognerà prendere tutti gli step della bozza precedente
//(ottenibile tramite id_vecchia_bozza) ed inserirli in quella nuova.
//Da qui si verrà reindirizzati al form per aggiungere gli step, dove si decidera se pubblicare il progetto, aggiungere nuovi step o uscire dal form. 

//2)
//se il form è completo, viene salvato nelle bozze per poi essere reindirizzati in form-step, dove verranno aggiunti step. Premendo pubblica verrà eseguito lo script
//per copiare la bozza nel progetto e il tutorial nei tutorial progetti, eliminando definitivamente la bozza da bozze.xml. 
session_start();
require_once('../../lib/functions.php');
$path = "index.php"; 
$std = "standard";     
addressing($_SESSION['Tipo_utente'], $std, $path); 

$tps_root = "../../";
require_once('../../lib/get_nodes.php');

$logout = $tps_root . "lib/logout.php?ban=true";
addressing($_SESSION['ban'], 0, $logout);

$xmlCategorie = $tps_root . "data/xml/categorie.xml";
$doc = getDOMdocument($xmlCategorie); 
$root = $doc->documentElement; 
$categorie_tot = $root->childNodes; 

if(isset($_SESSION['id_bozza']) && isset($_GET['modifica'])){

    $flag = 0;
    $id_bozza = $_SESSION['id_bozza'];
    unset($_SESSION['id_bozza']);  
    $xmlFile = $tps_root . "data/xml/bozze.xml"; 
    $doc = getDOMdocument($xmlFile); 
    $xpath = new DOMXPath($doc); 
    $thisBozza = $xpath->query("/bozze/bozza[@id = '$id_bozza']")->item(0);

    $titolo = $thisBozza->getAttribute('titolo'); 
    $descrizione_progetto = $thisBozza->getElementsByTagName('descrizione')->item(0); 
    if(empty($descrizione_progetto)){
    $descrizione_progetto = "";  
    } else {
      $descrizione_progetto = $descrizione_progetto->nodeValue; 
    }

    $categoriaProposta = $thisBozza->getElementsByTagName('categoriaProposta')->item(0); 
    if(empty($categoriaProposta)){
    $categoriaProposta = "";  
    } else {
      $categoriaProposta = $categoriaProposta->nodeValue; 
    }

    $categorie = $thisBozza->getElementsByTagName('categorie')->item(0);
    
    $categorieArray = [];

    if ($categorie) {
      foreach ($categorie->getElementsByTagName('categoria') as $cat) {
          $idCategoria = $cat->getAttribute('id_categoria');
          $categorieArray[] = $idCategoria;
      }
    }

    $tempo_medio = $thisBozza->getAttribute('tempo_medio'); 
    $difficolta = $thisBozza->getAttribute('difficolta'); 
    $clearance = $thisBozza->getAttribute('clearance'); 


    

}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/control/view-dashboard.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/form-aggiungi-progetto.css"></link>

      <script type="text/javascript">
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
          <a class="elem" href="bacheca.php">Bacheca</a>
          <a class="elem" href="view_bozze.php">Bozze</a>
          <a class="elem" href="view_storico.php">Storico</a>
          <div class="divisore"></div>
          <a class="elem" href="../../lib/logout.php">Logout</a>
        </div>
      </div>
      <div class="dashboard">
      <div class="bar"></div>
        <div class="toolbar"></div>

        <div class="title">AGGIUNGI PROGETTO</div>

        <?php
        echo "    <div id=\"error\">\n";
          
                if(isset($_SESSION['error_null_fields']) && $_SESSION['error_null_fields'] === "true" ){
                  echo "Compila tutti i campi per procedere alla pubblicazione";
                  unset($_SESSION['error_null_fields']);
                }

                echo " </div>";

?>

<form action="../../lib/bozze.php" method="post" enctype="multipart/form-data" class="container">
  <div class="p-cat">Categorie:</div>
  <div class="form-group cat-group">
    <?php 
      if (isset($categorie)) {
        $checkboxValues = [];
        $categorieEsistenti = getCategorie($tps_root);
        
        foreach ($categorieEsistenti as $categoria) {
          $id_categoria = $categoria->getAttribute('id');
          $checkboxValues[] = $id_categoria; 
        }

        foreach ($checkboxValues as $value) {
            $checked = in_array($value, $categorieArray) ? 'checked' : '';
            $label = getNomeCategoria($tps_root, $value);
            
            echo '<div class="checkbox-group">';
            echo '<input type="checkbox" id="categoria_' . $value . '" name="categorie[]" value="' . $value . '" ' . $checked . '></input>';
            echo '<label for="categoria_' . $value . '">' . $label . '</label>';
            echo '</div>';
        }
      } else {
        $categorieEsistenti = getCategorie($tps_root);

        foreach ($categorieEsistenti as $categoria) {
          $id_categoria = $categoria->getAttribute('id');
          $label = getNomeCategoria($tps_root, $id_categoria);
          
          echo '<div class="checkbox-group">';
          echo '<input type="checkbox" id="categoria_' . $id_categoria . '" name="categorie[]" value="' . $id_categoria . '"></input>';
          echo '<label for="categoria_' . $id_categoria . '">' . $label . '</label>';
          echo '</div>';
        }
      }
    ?>
  </div>

  <div class="form-group">
    <label>Proponi una categoria:</label>
    <input type="text" name="categoriaProposta" <?php if (isset($flag)) { echo "value=\"$categoriaProposta\""; } ?>></input>
  </div>

  <div class="form-group">
    <label>Titolo:</label>
    <input type="text" name="titolo" <?php if (isset($flag)) { echo "value=\"$titolo\""; } ?>></input>
  </div>

  <div class="form-group">
    <label>Descrizione:</label>
    <textarea name="descrizione" rows="4" cols="50"><?php if (isset($flag)) { echo $descrizione_progetto; } ?></textarea>
  </div>

  <div class="form-group">
    <label>Tempo Medio (in minuti):</label>
    <input type="number" name="tempo_medio" min="1" <?php if (isset($flag)) { echo "value=\"$tempo_medio\""; } ?>></input>
  </div>

  <div class="form-group">
    <label>Livello di clearance (da 1 a 5):</label>
    <input type="number" name="clearance" min="1" max="5" <?php if (isset($flag)) { echo "value=\"$clearance\""; } ?>></input>
  </div>

  <?php 
    if (isset($_GET['modifica']) && isset($id_bozza)) {
      echo "<div class=\"nascondi\"><input type=\"hidden\" value=\"$id_bozza\" name=\"id_vecchia_bozza\"></input></div>";
    }
  ?>

  <div class="form-group">
    <?php
      if (isset($difficolta)) {
        echo '<label for="difficolta">Difficoltà:</label>';
        echo '<select id="difficolta" name="difficolta">';
        echo '<option value="facile">' . ($difficolta == 'facile' ? 'Facile' : '') . '</option>';
        echo '<option value="medio">' . ($difficolta == 'medio' ? 'Medio' : '') . '</option>';
        echo '<option value="difficile">' . ($difficolta == 'difficile' ? 'Difficile' : '') . '</option>';
        echo '</select>';
      } else {
        echo '<label for="difficolta">Difficoltà:</label>';
        echo '<select id="difficolta" name="difficolta">';
        echo '<option value="facile">Facile</option>';
        echo '<option value="medio">Medio</option>';
        echo '<option value="difficile">Difficile</option>';
        echo '</select>';
      }
    ?>
  </div>

  <div class="form-group">
    <label>Immagine:</label>
    <input type="file" name="img" accept="image/*"></input>
  </div>

  <div class="form-group">
    <input type="submit" name="bottone" value="CONTINUA"></input>
  </div>
</form>

</div>
</div>

</body>


</html>
