<?php

session_start();
include('../conn.php');
require_once('get_nodes.php');
$radice = "../";

$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

if (!isset($_POST['id_utente']) || empty($_POST['id_utente'])) {
    exit;
} else {
    $id_utente = $_POST['id_utente'];
}


if (!isset($_POST['nome']) || empty($_POST['nome'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_profilo_utente.php?id_utente=' . $id_utente);
    exit;
} else {
    $nome = $_POST['nome'];
}

if (!isset($_POST['cognome']) || empty($_POST['cognome'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_profilo_utente.php?id_utente=' . $id_utente);
    exit;
} else {
    $cognome = $_POST['cognome'];
}

if (!isset($_POST['email']) || empty($_POST['email'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_profilo_utente.php?id_utente=' . $id_utente);
    exit;
} else {
    $email = $_POST['email'];
}

if (!isset($_POST['username']) || empty($_POST['username'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_profilo_utente.php?id_utente=' . $id_utente);
    exit;
} else {
    $username = $_POST['username'];
}

if (!isset($_POST['old_username']) || empty($_POST['old_username'])) {
    exit;
} else {
    $old_username = $_POST['old_username'];
}

if (!isset($_POST['old_email']) || empty($_POST['old_email'])) {
    exit;
} else {
    $old_email = $_POST['old_email'];
}



if (!isset($_POST['indirizzo']) || empty($_POST['indirizzo'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_profilo_utente.php?id_utente=' . $id_utente);
    exit;
} else {
    $indirizzo = $_POST['indirizzo'];
}


//CONTROLLO DUPLICATI

$_QUERY_username_uguale = "SELECT *
                               FROM utente
                               WHERE username = '$username'";

$_QUERY_email_uguale = "SELECT *
                            FROM utente
                            WHERE email = '$email'";

$rows = mysqli_query($conn, $_QUERY_username_uguale);

if (!$rows) {
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_profilo_utente.php?id_utente=' . $id_utente);
    exit;
}

if (mysqli_num_rows($rows) > 0 && ($username != $old_username)) {
    $_SESSION['username_esistente'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_profilo_utente.php?id_utente=' . $id_utente);
    exit;
}

$rows = mysqli_query($conn, $_QUERY_email_uguale);

if (!$rows) {
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_profilo_utente.php?id_utente=' . $id_utente);
    exit;
}

if (mysqli_num_rows($rows) > 0 && ($email != $old_email)) {
    $_SESSION['email_esistente'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_profilo_utente.php?id_utente=' . $id_utente);
    exit;
}



//AGGIORNAMENTO TABELLA UTENTE

$query = "UPDATE utente SET 
              nome = '$nome',
              cognome = '$cognome',
              email = '$email',
              username = '$username',
              indirizzo = '$indirizzo'
          WHERE id = $id_utente";

$result = $conn->query($query);

#QUI VA FATTA LA FUNZIONE PER RENDERE COERENTE LA MODIFICA

# AGGIORNAMENTO IN PROGETTI.XML

$xmlFile = "../data/xml/progetti.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$xpath = new DOMXPath($doc); 

$progetti = getProgetti($radice);

foreach($progetti as $progetto){

    if($progetto->getAttribute('id_creator') === $id_utente){

        $id_progetto = $progetto->getAttribute('id');

        $modProgetto = $xpath->query("/progetti/progetto[@id = '$id_progetto']")->item(0); 

        $modProgetto->setAttribute('username_creator', $username);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML();
        file_put_contents($xmlFile, $xmlString);
    }
}

# AGGIORNAMENTO IN COMMENTI.XML

$xmlFile = "../data/xml/commenti.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$xpath = new DOMXPath($doc); 

$commenti = getAllCommenti($radice);

foreach($commenti as $commento){

    if($commento->getAttribute('id_commentatore') === $id_utente){

        $id_commento = $commento->getAttribute('id');

        $modCommento = $xpath->query("/commenti/commento[@id = '$id_commento']")->item(0); 

        $modCommento->setAttribute('commentatore', $username);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML();
        file_put_contents($xmlFile, $xmlString);
    }
}

# AGGIORNAMENTO IN DISCUSSIONI.XML

$xmlFile = "../data/xml/discussioni.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$xpath = new DOMXPath($doc); 

$discussioni = getAllDiscussioni($radice);

foreach($discussioni as $discussione){

    if($discussione->getAttribute('id_poster') === $id_utente){

        $id_discussione = $discussione->getAttribute('id');

        $modDiscussione = $xpath->query("/discussioni/discussione[@id = '$id_discussione']")->item(0); 

        $modDiscussione->setAttribute('autore', $username);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML();
        file_put_contents($xmlFile, $xmlString);
    }
}


# AGGIORNAMENTO IN RICHIESTE_ACCESSO_DISCUSSIONI.XML  DA RIVEDERE



# AGGIORNAMENTO IN STORICI.XML  

$xmlFile = "../data/xml/storici.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$xpath = new DOMXPath($doc); 

$storici = getStorici($radice);

foreach($storici as $storico){

    $id_storico = $storico->getAttribute('id');

    $reports_progetti = getStoricoReportsProgetti($radice, $storico);
    $reports_commenti = getStoricoReportsCommenti($radice, $storico);

    foreach($reports_progetti as $report_progetto){

        if($report_progetto->getAttribute('publisher') === $old_username){

            echo $old_username;
            echo $username;

            $modStoricoP = $xpath->query("/storici/storico[@id = '$id_storico']/reports_progetti/report_progetto[@publisher = '$old_username']")->item(0); 

            if($modStoricoP != null){
                $modStoricoP->setAttribute('publisher', $username);
            }

        }
    }

    foreach($reports_commenti as $report_commento){

        if($report_commento->getAttribute('commentatore') === $old_username){

            echo $old_username;
            echo $username;

            $modStoricoC = $xpath->query("/storici/storico[@id = '$id_storico']/reports_commenti/report_commento[@commentatore = '$old_username']")->item(0);
            
            if($modStoricoC != null){
                $modStoricoC->setAttribute('commentatore', $username);
            }

        }
    }  

}

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);


$_SESSION['esito'] = "true";
header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_profilo_utente.php?id_utente=' . $id_utente);

exit;

?>