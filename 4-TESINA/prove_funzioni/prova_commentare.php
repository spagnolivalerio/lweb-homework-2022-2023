<?php

session_start();

require_once('../lib/functions.php');


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMMENTO</title>
</head>
<body>

<h1>COMMENTA</h1>

<form action="../lib/commentare.php" method="post">
    <label for="testo">testo</label>
    <input type="text" name="testo" required><br>

    <label for="id_discussione">2</label>
    <input name="id_discussione" required></input><br>

    <input type="submit" value="Aggiungi Discussione">
</form>

</body>
</html>