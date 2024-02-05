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



function already_reported($reports, $id_utente) {

    if(empty($reports)){
        return false; 
    }

    foreach($reports as $report){
        if($id_utente == $report->getAttribute('id_utente')){
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

function valutazioneProgetto($root, $id_progetto, $conn){

    $valutazioni_progetto = getValutazioniProgetto($root, $id_progetto);
    $pesi_totali = 0;
    $value = 0;

    foreach($valutazioni_progetto as  $valutazione_progetto){

        $id_votante = $valutazione_progetto->getAttribute('id_votante');
        $select_peso_query = "SELECT peso_valutazione FROM utente WHERE id = $id_votante";
        $result = $conn->query($select_peso_query);

        if($result){
        
            $row = $result->fetch_assoc();
            $peso_votante = $row['peso_valutazione'];     
            $value += $valutazione_progetto->getAttribute('value') * $peso_votante;
            $pesi_totali += $peso_votante;
        }
    }

    if($pesi_totali != 0){

        $value = $value / $pesi_totali;
    }

    return $value;
}


function calcolaReputazione($root, $id_utente, $conn){

    $livello = 1;
    $reputazione = 0;

    $progetti = getProgetti($root);
    
    foreach($progetti as $progetto) {

        $id_progetto = $progetto->getAttribute('id');
        $sospeso = $progetto->getAttribute('sospeso');

        if($id_utente == $progetto->getAttribute('id_creator') && $sospeso == 'false'){

            $reputazione += 5;

            if ($reputazione >= 10 * pow(2, $livello) ){

                $reputazione = $reputazione - 10 * pow(2, $livello);
                $livello += 1;
            }

            
            $value = valutazioneProgetto($root, $id_progetto, $conn);

            if($value != 0) {

                $reputazione += (10 * $value) - 20;

                if ($reputazione >= 10 * pow(2, $livello) ){

                    $reputazione = $reputazione - 10 * pow(2, $livello);
                    $livello += 1;
                }elseif($reputazione < 0){

                    $livello -= 1;
                    $reputazione = 10 * pow(2, $livello) + $reputazione;
                }
        
            }

        }

        $discussioni = getDiscussioni($root, $id_progetto);

        foreach($discussioni as $discussione){

            $id_discussione = $discussione->getAttribute('id');
            $commenti = getCommenti($root, $id_discussione);

            foreach($commenti as $commento){

                $id_commento = $commento->getAttribute('id');

                if($id_utente == $commento->getAttribute('id_commentatore')){

                    $valutazioni_commento = getValutazioniCommenti($root, $id_commento);

                    foreach($valutazioni_commento as $valutazione_commento){

                        $utilità = $valutazione_commento->getElementsByTagName('utilita')->item(0)->nodeValue;
                        $accordo = $valutazione_commento->getElementsByTagName('livello_di_accordo')->item(0)->nodeValue;

                        if($accordo == 1){
                            $reputazione -= 2;
                        }elseif($accordo == 3){
                            $reputazione += 2;
                        }

                        if($utilità == 1){
                            $reputazione -= 2;
                        }elseif($utilità == 3){
                            $reputazione += 2;
                        }elseif($utilità == 4){
                            $reputazione += 4;
                        }elseif($utilità == 5){
                            $reputazione += 6;
                        }

                        if ($reputazione >= 10 * pow(2, $livello) ){

                            $reputazione = $reputazione - 10 * pow(2, $livello);
                            $livello += 1;
                        }elseif($reputazione < 0){
                            
                            $livello -= 1;
                            $reputazione = 10 * pow(2, $livello) + $reputazione;
                        }
                    }
                }
            }
        }

        
    }

    if($livello > 10) {
        $livello = 10;
        $reputazione = 0;
    }

    $update_reputation_query = "UPDATE utente SET punti_reputazione = '$reputazione' WHERE id = '$id_utente'";
    $update_level_query = "UPDATE utente SET livello = '$livello' WHERE id = '$id_utente'";
    $conn->query($update_level_query);
    $conn->query($update_reputation_query);

}

function updateClearance($root, $id_utente, $conn){

    $query = "SELECT * FROM utente WHERE id = " . $id_utente;
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $livello_utente = $row['livello'];
    
    if($livello_utente <= 2){
        $clearance_utente = 1;
    }elseif($livello_utente > 2 && $livello_utente <= 4 ){
        $clearance_utente = 2;
    }elseif($livello_utente > 4 && $livello_utente <= 6 ){
        $clearance_utente = 3;
    }elseif($livello_utente > 6 && $livello_utente <= 8 ){
        $clearance_utente = 4;
    }elseif($livello_utente > 8){
        $clearance_utente = 5;
    }

    $update_clearance_query = "UPDATE utente SET clearance = '$clearance_utente' WHERE id = '$id_utente'";
   
    $conn->query($update_clearance_query);

    return $clearance_utente;
}

function updatePeso($root, $id_utente, $conn){

    $query = "SELECT * FROM utente WHERE id = " . $id_utente;
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $livello_utente = $row['livello'];
    
    if($livello_utente <= 3){
        $peso = 1;
    }elseif($livello_utente > 3 && $livello_utente <= 7){
        $peso = 2; 
    }elseif($livello_utente > 7 && $livello_utente <= 9){
        $peso = 2.5; 
    }elseif($livello_utente > 9 && $livello_utente <= 10){
        $peso = 3; 
    }

    $update_peso_query = "UPDATE utente SET peso_valutazione = '$peso' WHERE id = '$id_utente'";
   
    $conn->query($update_peso_query);

}


function updateAllUsers($root, $conn){

    $query = "SELECT * FROM utente";
    $result = $conn->query($query);

    while ($row = mysqli_fetch_assoc($result)){
        if($row['tipo'] == 'standard'){
            calcolaReputazione($root, $row['id'], $conn);
            updateClearance($root, $row['id'], $conn);
            updatePeso($root, $row['id'], $conn);
        }
    }

}

function updateViews($root, $id_progetto){
    
    $xmlFile = $root . "data/xml/progetti.xml";

    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    $progetto = $xpath->query("/progetti/progetto[@id = '$id_progetto']")->item(0);

    $visualizzazioni = $progetto->getAttribute('visualizzazioni');
    $visualizzazioni = intval($visualizzazioni) + 1;
    $progetto->setAttribute('visualizzazioni', $visualizzazioni);


    $doc->formatOutput = true;
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

}

function getAllViews($progetti){
    $visualizzazioni = 0;
    
    foreach($progetti as $progetto){

        $visualizzazioni = $visualizzazioni + $progetto->getAttribute('visualizzazioni');
    }
    return $visualizzazioni;
}




?>