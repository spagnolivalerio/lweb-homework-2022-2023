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

<form action="../lib/aggiungere_progetto.php" method="post">
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

  <!-- Descrizione -->
  <label for="descrizione">Descrizione: </label>
  <textarea  name="descrizione" rows="4" cols="50" required></textarea>
  <br>

  <!-- Tempo Medio -->
  <label for="tempo_medio">Tempo Medio (in minuti): </label>
  <input type="number"  name="tempo_medio" min="1" required>
  <br>

  <!-- Immagine -->
  <label for="immagine">URL dell'immagine: </label>
  <input type="text" name="img" required>
  <br>

  <!-- Difficoltà -->
  <label for="difficolta">Difficoltà: </label>
  <select id="difficolta" name="difficolta" required>
    <option value="facile">Facile</option>
    <option value="medio">Medio</option>
    <option value="difficile">Difficile</option>
  </select>
  <br>

  <!-- Pulsante di invio -->
  <input type="submit" value="Pubblica Progetto">
</form>


</body>
</html>
