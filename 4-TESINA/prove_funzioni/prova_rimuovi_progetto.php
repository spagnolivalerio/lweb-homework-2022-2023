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

<h1>ELIMINA COMMENTO</h1>

<form action="../lib/copy.php" method="post">

    <label for="id_progetto">id_commento</label>
    <input name="id_progetto" required></input><br>

    <input type="submit" value="elimina">
</form>

</body>
</html>