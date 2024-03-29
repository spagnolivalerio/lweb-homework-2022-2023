<?php

session_start();
require_once('functions.php');
include('../conn.php');

$tps_root = "../";
$id_bozza = $_SESSION['id_bozza'];
$username_creator = $_SESSION['username'];
$id_creator = $_SESSION['id_utente'];
$data_ora = new DateTime();
$data_ora = $data_ora->format('Y-m-d H:i:s');

$xmlFile = "../data/xml/bozze.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$xpath = new DOMXPath($doc); 

$thisBozza = $xpath->query("/bozze/bozza[@id = '$id_bozza']")->item(0); 

$titolo = $thisBozza->getAttribute('titolo'); 
$descrizione_progetto = $thisBozza->getElementsByTagName('descrizione')->item(0); 
if(empty($descrizione_progetto)){
   $descrizione_progetto = "";  
} else {
    $descrizione_progetto = $descrizione_progetto->nodeValue; 
}

$categoriaProposta = $thisBozza->getElementsByTagName('categoriaProposta')->item(0); 
if(empty($categoriaProposta)){
    $categoriaProposta = "";  
 } else {
     $categoriaProposta = $categoriaProposta->nodeValue; 
 }

 
$categorie = $thisBozza->getElementsByTagName('categorie')->item(0); 
$tempo_medio = $thisBozza->getAttribute('tempo_medio'); 
$difficolta = $thisBozza->getAttribute('difficolta'); 
$nome_file_img = $thisBozza->getAttribute('nome_file_img');
$clearance = $thisBozza->getAttribute('clearance');
$sospeso = $thisBozza->getAttribute('sospeso');

$categorieArray = [];

if ($categorie) {
    foreach ($categorie->getElementsByTagName('categoria') as $cat) {
        $idCategoria = $cat->getAttribute('id_categoria');
        $categorieArray[] = $idCategoria;
    }
    if(empty($categorieArray)){
        $null = 1;
    }else{
        $null = 0;
    }
}

if($null = 1 && !empty($categoriaProposta)){
    $null = 0;
}

if(empty($titolo) || empty($tempo_medio) || empty($difficolta) || empty($descrizione_progetto) || empty($nome_file_img) || empty($clearance)  || $null == 1 ){
    $noNullFields = false;
}else{
    $noNullFields = true;
}

if($noNullFields == false){
    $_SESSION['error_null_fields'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/form_progetto.php?modifica=true');
    exit;
}

$bozSteps = $xpath->query("/bozze/bozza[@id = '$id_bozza']/tutorial_bozza")->item(0)->childNodes; 


//AGGIUNTO IN PROGETTI.XML

$xmlFile = $tps_root . "data/xml/progetti.xml";
$id_progetto = generate_id($xmlFile);
$_SESSION['id_progetto'] = $id_progetto;
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;

$newProgetto = $doc->createElement('progetto');

$proTitolo = $doc->createElement('titolo', $titolo);
$proCategorie = $doc->createElement('categorie');
$proDescrizione = $doc->createElement('descrizione', $descrizione_progetto);
$proCategoriaProposta = $doc->createElement('categoriaProposta', $categoriaProposta);
$proReports = $doc->createElement('reports_progetti');
$proDiscussioni = $doc->createElement('discussioni');
$proTutorial = $doc->createElement('tutorial_progetto');
$proValutazioni = $doc->createElement('valutazioni');

$newProgetto->setAttribute('id', $id_progetto);
$newProgetto->setAttribute('username_creator', $username_creator);
$newProgetto->setAttribute('id_creator', $id_creator);
$newProgetto->setAttribute('tempo_medio', $tempo_medio);
$newProgetto->setAttribute('data_pubblicazione', $data_ora);
$newProgetto->setAttribute('visualizzazioni', 0);
$newProgetto->setAttribute('nome_file_img', $nome_file_img);
$newProgetto->setAttribute('difficolta', $difficolta);
$newProgetto->setAttribute('clearance', $clearance);
$newProgetto->setAttribute('sospeso', $sospeso);

foreach ($categorie->getElementsByTagName('categoria') as $cat) {
    $idCategoria = $cat->getAttribute('id_categoria');
    $proCategoria = $doc->createElement('categoria');
    $proCategoria->setAttribute('id_categoria', $idCategoria);
    $proCategorie->appendChild($proCategoria);
}

$proTutorial->setAttribute('id_tutorial', $id_progetto);

$newProgetto->appendChild($proTitolo);
$newProgetto->appendChild($proCategorie);
$newProgetto->appendChild($proDescrizione);
$newProgetto->appendChild($proCategoriaProposta);
$newProgetto->appendChild($proReports);
$newProgetto->appendChild($proDiscussioni);
$newProgetto->appendChild($proTutorial);
$newProgetto->appendChild($proValutazioni);

$root->appendChild($newProgetto);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

//AGGIUNTO IN TUTORIALS.XML

$xmlFile = $tps_root . "data/xml/tutorials.xml"; 
$id_tutorial = generate_id($xmlFile);
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

$newTutorial = $doc->createElement('tutorial_progetto');

$newTutorial->setAttribute('id', $id_tutorial);
$newTutorial->setAttribute('id_progetto', $id_progetto);

foreach($bozSteps as $bozStep){
    $newStep = $doc->createElement('step'); 
    $newStep->setAttribute('titolo_step', $bozStep->getAttribute('titolo_step'));
    $newStep->setAttribute('num_step', $bozStep->getAttribute('num_step')); 
    $newStep->setAttribute('nome_file_img', $bozStep->getAttribute('nome_file_img')); 
    $newStepDesc = $doc->createElement('descrizione', $bozStep->getElementsByTagName('descrizione')->item(0)->nodeValue); 
    $newStep->appendChild($newStepDesc); 
    $newTutorial->appendChild($newStep);
}

$root->appendChild($newTutorial);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
$xmlTutorial = "../data/xml/tutorials.xml";
file_put_contents($xmlTutorial, $xmlString);


//AGGIUNTA IN STORICI.XML

$xmlFile = "../data/xml/storici.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

foreach ($nodes as $node) {

    if ($_SESSION['id_utente'] === $node->getAttribute('id_utente')) {

        $stoProgetto = $doc->createElement('progetto');
        $stoProgetto->setAttribute('titolo', $titolo);
        $stoProgetto->setAttribute('data_ora', $data_ora);
        $stoProgetto->setAttribute('id_progetto', $id_progetto);
        $stoProgetti = $node->getElementsByTagName('progetti')->item(0);
        $stoProgetti->appendChild($stoProgetto);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML();
        file_put_contents($xmlFile, $xmlString);

        break;

    }
}

//RIMUOVI BOZZA

$query = "/bozze/bozza[@id"; 
$xmlFile = $tps_root . "data/xml/bozze.xml"; 
remove_1_1($xmlFile, $query, $id_bozza); 

$conn = connect_to_db($servername, $db_username, $db_password, $db_name);
updateAllUsers($tps_root, $conn);

if($_SESSION['Tipo_utente'] === "moderatore" && $sospeso === "true"){
    header('Location: modifica_sospensione_progetto.php?nomeCategoria=' . $categoriaProposta . '&id_progetto=' . $id_progetto);
    exit;
}

header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/homepage.php');
exit;

?>
