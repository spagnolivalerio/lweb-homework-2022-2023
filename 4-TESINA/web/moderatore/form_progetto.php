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
$mod = "moderatore";     
addressing($_SESSION['Tipo_utente'], $mod, $path); 

$tps_root = "../../";
require_once('../../lib/functions.php');

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

    echo"$titolo";
    echo"$tempo_medio";
    echo"$difficolta";
    echo"$descrizione_progetto";
    print_r($categorieArray);
    

}


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Discussione </title>
</head>
<body>

<h1>Aggiungi progetto</h1>

<form action="../../lib/bozze.php" method="post" enctype="multipart/form-data">

<label>Categorie:</label>
  <br>
  <input type="checkbox" id="categoria_1" name="categorie[]" value="1">
  <label for="categoria_1">Categoria 1</label>
  <br>
  <input type="checkbox" id="categoria_2" name="categorie[]" value="2">
  <label for="categoria_2">Categoria 2</label>
  <br>
  <input type="checkbox" id="categoria_3" name="categorie[]" value="3">
  <label for="categoria_3">Categoria 3</label>
  <br>
  <input type="checkbox" id="categoria_4" name="categorie[]" value="4">
  <label for="categoria_4">Categoria 4</label>
  <!-- Aggiungi altre categorie secondo necessità -->
  <br>

  <label for="titolo">titolo: </label>
  <input type="text"  name="titolo" <?php if(isset($flag)) {echo "value=\"$titolo\""; }?>></input>
  <br>

  <!-- Descrizione -->

  <label for="descrizione">Descrizione: </label>
  <textarea name="descrizione" rows="4" cols="50"><?php if(isset($flag)) {echo $descrizione_progetto; }?></textarea>
  <br>


  <!-- Tempo Medio -->
  <label for="tempo_medio">Tempo Medio (in minuti): </label>
  <input type="number"  name="tempo_medio" min="1" <?php if(isset($flag)) {echo "value=\"$tempo_medio\""; }?>></input>
  <br>

  <?php 
      if(isset($_GET['modifica']) && isset($id_bozza)){
          echo "<input type=\"hidden\" value=\"$id_bozza\" name=\"id_vecchia_bozza\"></input>\n";
        }
  ?>

  <!-- Difficoltà -->
  <?php
  if(isset($difficolta)){
    if($difficolta == 'facile') {
        echo '<label for="difficolta">Difficoltà: </label>';
        echo '<select id="difficolta" name="difficolta" required>';
        echo '<option value="facile">Facile</option>';
        echo '<option value="medio">Medio</option>';
        echo '<option value="difficile">Difficile</option>';
        echo '</select>';
        echo '<br>';
    } elseif($difficolta == 'medio') {
        echo '<label for="difficolta">Difficoltà: </label>';
        echo '<select id="difficolta" name="difficolta" required>';
        echo '<option value="facile">Medio</option>';
        echo '<option value="medio">Facile</option>';
        echo '<option value="difficile">Difficile</option>';
        echo '</select>';
        echo '<br>';
    } elseif($difficolta == 'difficile') {
        echo '<label for="difficolta">Difficoltà: </label>';
        echo '<select id="difficolta" name="difficolta" required>';
        echo '<option value="facile">Difficile</option>';
        echo '<option value="medio">Facile</option>';
        echo '<option value="difficile">Medio</option>';
        echo '</select>';
        echo '<br>';
    }
  }else{
        echo '<label for="difficolta">Difficoltà: </label>';
        echo '<select id="difficolta" name="difficolta" required>';
        echo '<option value="facile">Facile</option>';
        echo '<option value="medio">Medio</option>';
        echo '<option value="difficile">Difficile</option>';
        echo '</select>';
        echo '<br>';
  }
?>

  


  <label for="img">10</label>
  <input type="file" name="img" accept="image/*"></input><br>


  <!-- Pulsante di invio -->
  <input type="submit" name="bottone">CONTINUA</input>
</form>


</body>
</html>