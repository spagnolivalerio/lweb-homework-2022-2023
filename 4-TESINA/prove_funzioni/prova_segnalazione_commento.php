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

<h1>SEGNALA</h1>

<form action="../lib/aggiungere_report_commento.php" method="post">
    <label for="tipo">Tipo:</label>
         <select id="tipo" name="tipo">
            <option value="spam">Spam</option>
            <option value="contenuti inappropriati">Contenuti inappropriati</option>
            <option value="contenuti inesatti">Contenuti inesatti</option>
         </select>
    <br>

    <label for="testo">testo</label>
    <input type="text" name="testo" required><br>

    <label for="id_commento">10</label>
    <input name="id_commento" required></input><br>

    <input type="submit" value="segnala">
</form>

</body>
</html>