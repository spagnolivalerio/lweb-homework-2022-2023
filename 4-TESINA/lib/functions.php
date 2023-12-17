<?php
require_once('get_nodes.php');

function getDOMdocument($xmlFile)
{

    $xmlstring = "";
    foreach (file($xmlFile) as $node) { //riscrive il file come un'unica stringa
        $xmlstring .= trim($node);
    }

    $doc = new DOMDocument(); //creo un oggetto DOMdocument
    if (!$doc->loadXML($xmlstring)) { //carico il file xml privo di spazi bianchi dentro all'oggetto doc
        exit;
    }

    return $doc;

}

function uploadXML($xmlFile)
{

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement; //creo una variabile radice alla quale assegno il primo elemento del file xml
    $elementi = $root->childNodes; //childNodes restituisce una lista di nodi, i nodi figli di $root

    return $elementi; //array di childnodes della root del file xml

}

function generate_id($xmlFile)
{

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;

    $id = $root->getAttribute('ultimo_id');
    $newID = intval($id) + 1;
    $root->setAttribute('ultimo_id', $newID);

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    return $newID;
}

function remove_1_1($xmlFile, $query, $id)
{

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;
    $xpath = new DOMXPath($doc);

    $to_remove = $xpath->query($query . " = '$id']")->item(0);

    if ($to_remove !== null) {
        $root->removeChild($to_remove);
    }

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

}

function remove_1_n($xmlFile, $query, $id)
{

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;
    $xpath = new DOMXPath($doc);
    $array_id = array();

    $to_remove_s = $xpath->query($query . " = '$id']");

    foreach ($to_remove_s as $to_remove) {

        array_push($array_id, $to_remove->getAttribute('id'));
        $root->removeChild($to_remove);

    }

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    return $array_id;
}

function remove_1_2n($xmlFile, $query, $array_id)
{

    if (empty($array_id)) {
        return 0;
    }

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;
    $xpath = new DOMXPath($doc);
    $array_id_2 = array();

    foreach ($array_id as $id) {

        $res = $xpath->query($query . "= '$id']");

        foreach ($res as $node) {

            $root->removeChild($node);
            array_push($array_id_2, $node->getAttribute('id'));
        }
    }

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    return $array_id_2;
}

function add_img($img_location, $nome_file_img)
{

    $fd = fopen($nome_file_img, 'w');
    $img = file_get_contents($img_location);

    if ($fd) {

        fwrite($fd, $img);
        fclose($fd);

    } else {

        exit;

    }
}

function check_partecipante($partecipanti, $id_utente)
{
    if(empty($partecipanti)){
        return 0; 
    }

    foreach($partecipanti as $partecipante){
        if($id_utente === $partecipante->getAttribute('id_partecipante')){
            return true; 
        }
    }

    return false; 
}

function already_voted($valutazioni, $id_utente) {

    if(empty($valutazioni)){
        return false; 
    }
    foreach($valutazioni as $valutazione){
        if($id_utente == $valutazione->getAttribute('id_votante')){
            return true; 
        }
    }

    return false; 
}



function already_reported($reports_commento, $id_utente) {

    if(empty($reports_commento)){
        return false; 
    }

    foreach($reports_commento as $report_commento){
        if($id_utente == $report_commento->getAttribute('id_utente')){
            return true; 
        }
    }

    return false; 
}

function already_sended($richieste_accesso, $id_utente) {

    if(empty($richieste_accesso)){
        return false; 
    }
    foreach($richieste_accesso as $richiesta_accesso){
        if($id_utente == $richiesta_accesso->getAttribute('id_utente')){
            return true; 
        }
    }

    return false; 
}


function getState($richieste_accesso, $id_utente){
    foreach($richieste_accesso as $richiesta_accesso){
        if($id_utente == $richiesta_accesso->getAttribute('id_utente')){
            return $richiesta_accesso->getAttribute('stato'); 
        }
    }
}

function addressing($var, $perm, $path){ //controlla il valore di var se è uguale a perm: se non è uguale rimanda al path
    switch ($var) {
        case "$perm":
            return 0; 
        default:
            header("Location: " . $path);
            break;
    }
}

function checkFieldsNotNull($fields) {
    foreach ($fields as $field) {
        if (is_null($field)) {
            return false; // Se almeno un campo è nullo, restituisci false
        }
    }
    return true; // Se nessun campo è nullo, restituisci true
}
function ban()
{};

function sban()
{};

function mod_tipo_utente()
{};

function chiudi_discussione($root, $id_utente)
{};

?>