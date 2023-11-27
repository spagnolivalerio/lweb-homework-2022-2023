<?php

session_start();

require_once('../lib/functions.php');


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ammetti</title>
</head>
<body>

<h1>accesso alla discussione</h1>

<form action="../lib/gestisci_richiesta.php" method="post">

    <label for="id_richiesta">id_richiesta</label>
    <input name="id_richiesta" required></input><br>

    <input type="submit" name="esito" value="accettata">
    <input type="submit" name="esito" value="rifiutata">
</form>

</body>
</html>