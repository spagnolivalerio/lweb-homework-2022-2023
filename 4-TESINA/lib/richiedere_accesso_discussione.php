<?php

    session_start();
    require_once('functions.php');
    $xmlFile = "../data/xml/richieste_accesso_discussioni.xml";

    if(!isset($_POST['id_discussione']) || empty($_POST['id_discussione'])){
        exit; 
    } else {
        $id_discussione = $_POST['id_discussione'];
    }

    $data_ora = new DateTime();
    $data_ora = $data_ora->format('Y-m-d H:i:s');

    //AGGIUNTA IN RICHIESTE_ACCESSO_DISCUSSIONI.XML

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;
    $default = "in lavorazione";

    $newRichiesta = $doc->createElement('richiesta');
    $newRichiesta->setAttribute('id', generate_id($xmlFile));
    $newRichiesta->setAttribute('id_discussione', $id_discussione);
    $newRichiesta->setAttribute('id_utente', $_SESSION['id_utente']);
    $newRichiesta->setAttribute('data_ora', $data_ora);
    $newRichiesta->setAttribute('stato', $default);

    $root->appendChild($newRichiesta);

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML(); 
    file_put_contents($xmlFile, $xmlString);

    header('Location: ../prove_funzioni/prova_richiedi_accesso.php');
    exit; 

?>