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



if (!isset($_POST['nome']) || empty($_POST['nome'])) {
    exit;
} else {
    $nome = $_POST['nome'];
}

if (!isset($_POST['cognome']) || empty($_POST['cognome'])) {
    exit;
} else {
    $cognome = $_POST['cognome'];
}

if (!isset($_POST['email']) || empty($_POST['email'])) {
    exit;
} else {
    $email = $_POST['email'];
}

if (!isset($_POST['username']) || empty($_POST['username'])) {
    exit;
} else {
    $username = $_POST['username'];
}

if (!isset($_POST['old_username']) || empty($_POST['old_username'])) {
    exit;
} else {
    $old_username = $_POST['old_username'];
}



if (!isset($_POST['indirizzo']) || empty($_POST['indirizzo'])) {
    exit;
} else {
    $indirizzo = $_POST['indirizzo'];
}


if (!isset($_POST['id_utente']) || empty($_POST['id_utente'])) {
    exit;
} else {
    $id_utente = $_POST['id_utente'];
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

$xmlFile = "../data/xml/richieste_accesso_discussioni.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$xpath = new DOMXPath($doc); 

$richieste = getAllRichiesteAccesso($radice);

foreach($richieste as $richiesta){

    $moderatore = $richiesta->getElementsByTagName('moderatore')->item(0);
    $id_mod = $moderatore->getAttribute('id_mod');

    if($id_mod === $id_utente){

        $id_richiesta = $richiesta->getAttribute('id');

        $modRichiesta = $xpath->query("/richieste/richiesta[@id = '$id_richiesta']/moderatore[@id_mod = '$id_utente']")->item(0); 

        $modRichiesta->setAttribute('username', $username);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML();
        file_put_contents($xmlFile, $xmlString);
    }
}

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



header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/bacheca.php');

exit;

?>