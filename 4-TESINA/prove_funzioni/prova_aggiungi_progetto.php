<?php

session_start();

require_once('../lib/functions.php');


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Discussione</title>
</head>
<body>

<h1>Aggiungi progetto</h1>

<form action="../lib/aggiungere_progetto.php" method="post" enctype="multipart/form-data">
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
  <input type="text"  name="titolo"></input>
  <br>

  <!-- Descrizione -->
  <label for="descrizione">Descrizione: </label>
  <textarea  name="descrizione" rows="4" cols="50"></textarea>
  <br>

  <!-- Tempo Medio -->
  <label for="tempo_medio">Tempo Medio (in minuti): </label>
  <input type="number"  name="tempo_medio" min="1">
  <br>

  <label for="id_vecchia_bozza">id_bozza</label>
  <input type="text" name="id_vecchia_bozza">
  <br>

  <!-- Difficoltà -->
  <label for="difficolta">Difficoltà: </label>
  <select id="difficolta" name="difficolta" required>
    <option value="facile">Facile</option>
    <option value="medio">Medio</option>
    <option value="difficile">Difficile</option>
  </select>
  <br>

  <label for="img">10</label>
  <input type="file" name="img" accept="image/*"></input><br>


  <!-- Pulsante di invio -->
  <input type="submit" name="bozza" value="bozza">bozza</input>
  <input type="submit" name="bozza" value="false">progetto</input>
</form>


</body>
</html>
