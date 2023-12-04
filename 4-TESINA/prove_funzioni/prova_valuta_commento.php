<?php

session_start();

require_once '../lib/functions.php';

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>valutasCOMMENTO</title>
</head>
<body>

<h1>COMMENTA</h1>

<form action="../lib/valuta_commento.php" method="post">

    <label for="liv_accordo">accordo da 1 a 3</label>
    <input name="liv_accordo" required></input><br>

    <label for="utilita">voto a 1 a 5</label>
    <input name="utilita" required></input><br>

    <label for="id_commento">id_commento</label>
    <input name="id_commento" required></input><br>

    <input type="submit" value="commenta">
</form>

</body>
</html>
