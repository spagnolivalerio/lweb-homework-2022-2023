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

<form action="../lib/valutare_progetto.php" method="post">
    <label for="testo">testo</label>
    <input type="text" name="testo" required><br>

    <label for="id_progetto">id_progetto</label>
    <input name="id_progetto" required></input><br>

    <label for="value">voto a 1 a 5</label>
    <input name="value" required></input><br>

    <input type="submit" value="commenta">
</form>

</body>
</html>