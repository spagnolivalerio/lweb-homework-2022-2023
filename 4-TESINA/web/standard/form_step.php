
<?php

session_start();

require_once('../../lib/functions.php');


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Discussione</title>
</head>
<body>

<h1>Aggiungi step</h1>

<form action="../../lib/step.php" method="post" enctype="multipart/form-data">

    <label for="descrizione">Descrizione:</label>
    <textarea name="descrizione" required></textarea><br>

    <label for="num_step">step</label>
    <textarea name="num_step" required></textarea><br>

    <label for="img">10</label>
    <input type="file" name="img" accept="image/*" required></input><br>

    <input type="submit" value="Aggiungi step">

</form>
<form action="../../lib/progetto.php" method="post">
    <button type="submit">PUBBLICA</button>
</form>
</body>
</html>








