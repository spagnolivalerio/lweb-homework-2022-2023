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

<h1>Aggiungi Discussione</h1>

<form action="../lib/aprire_discussione.php" method="post">
    <label for="titolo">Titolo:</label>
    <input type="text" name="titolo" required><br>

    <label for="descrizione">Descrizione:</label>
    <textarea name="descrizione" required></textarea><br>

    <label for="id_progetto">10</label>
    <textarea name="id_progetto" required></textarea><br>

    <input type="submit" value="Aggiungi Discussione">
</form>

</body>
</html>
