<?php

session_start();

require_once('../lib/functions.php');


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>richiedi accesso</title>
</head>
<body>

<h1>accesso alla discussione</h1>

<form action="../lib/richiedere_accesso_discussione.php" method="post">

    <label for="id_discussione">id_discussione</label>
    <input name="id_discussione" required></input><br>

    <input type="submit" value="prova ad accedere">
</form>

</body>
</html>