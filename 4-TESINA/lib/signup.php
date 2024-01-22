<?php

session_start();
require_once '../conn.php';

$_SESSION['username'] = $_POST['username'];
$_SESSION['nome'] = $_POST['nome'];
$_SESSION['cognome'] = $_POST['cognome'];
$_SESSION['password'] = $_POST['password'];
$_SESSION['email'] = $_POST['e-mail'];
$_SESSION['indirizzo'] = $_POST['indirizzo'];
$_SESSION['avatar'] = $_POST['avatar'];


$data = new DateTime();
$data = $data->format('Y-m-d');

$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

$campi = [$_POST['nome'], $_POST['cognome'], $_POST['e-mail'], $_POST['indirizzo'], $_POST['username'], $_POST['password'], $_POST['avatar'], $data];

$not_empty = array_reduce($campi, function ($carry, $campo) {return $carry && !empty($campo);}, true); //array_reduce riduce tutti i valori dell'array in un unico valore con l'ausilio di una variabile $carry con cui esegue ad ogni iterazione && con !empty($campo), $campo singolo campo dell'array $campi

if ($not_empty) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $email = mysqli_real_escape_string($conn, $_POST['e-mail']);
    $indirizzo = mysqli_real_escape_string($conn, $_POST['indirizzo']);
    $avatar = mysqli_real_escape_string($conn, $_POST['avatar']);
    $data = mysqli_real_escape_string($conn, $data);

    $password_match = mysqli_real_escape_string($conn, $_POST['password']);


} else {

    $_SESSION['credenziali'] = "false";

    header('Location: ../web/signup.php');
    exit;

}

$_QUERY_username_uguale = "SELECT *
                               FROM utente
                               WHERE username = '$username'";

$_QUERY_email_uguale = "SELECT *
                            FROM utente
                            WHERE email = '$email'";

$rows = mysqli_query($conn, $_QUERY_username_uguale);

if (!$rows) {
    header('Location: ../web/signup.php');
    exit;
}

if (mysqli_num_rows($rows) > 0) {
    $_SESSION['username_esistente'] = "true";
    $_SESSION['credenziali'] = "false";
    header('Location: ../web/signup.php');
    exit;
}

$rows = mysqli_query($conn, $_QUERY_email_uguale);

if (!$rows) {
    header('Location: ../web/signup.php');
    exit;
}

if (mysqli_num_rows($rows) > 0) {
    $_SESSION['email_esistente'] = "true";
    $_SESSION['credenziali'] = "false";
    header('Location: ../web/signup.php');
    exit;
}

if (!preg_match('~^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9]).{8,}$~', $password_match)){
    $_SESSION['password_unmatch'] = "true";
    $_SESSION['credenziali'] = "false";
    header('Location: ../web/signup.php');
    exit;
}

$_QUERY_inserimento_utente = "INSERT INTO utente (nome, cognome, username, password, email, indirizzo, avatar, data)
                                  VALUES ('$nome', '$cognome', '$username', '$password', '$email', '$indirizzo', '$avatar', '$data')";

$_QUERY_cerca_id = "SELECT id
                        FROM utente
                        WHERE username = '$username'";

if (!mysqli_query($conn, $_QUERY_inserimento_utente)) {

    $_SESSION['utente_creato'] = false;
    $conn->close();
    exit;

} else {

    $_SESSION['utente_creato'] = true;

    $result = mysqli_query($conn, $_QUERY_cerca_id);
    $row = mysqli_fetch_array($result);
    $_SESSION['id_utente'] = $row['id']; //per la creazione dello storico -> $_SESSION['id_utente'] viene sempre risettata ad ogni login, quindi posso riutilizzarla in questa fase che è subito dopo la creazione di storico, dopodiche unsetto;

    header('Location: crea_storico.php');
    $conn->close();
    exit;
}

?>