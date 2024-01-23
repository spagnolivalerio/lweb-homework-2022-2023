<?php
//1)
//Se il form non è completo, viene salvato nelle bozze e poi si viene reindirizzati nel form degli step. Da qui, dopo aver aggiunto gli step, si può decidere se
//aggiungere altri step o pubblicare il progetto. In questo caso si verrà reindirizzati nel form di creazione del progetto con i campi inseriti in precedenza gia compilati
//mandando l'id della bozza corrente tramite get (che sarà id_vecchia_bozza relativamente a quella nuova creata).
//Questo id servirà all'eliminazione della bozza corrente dal file delle bozze e alla sostituzione di quest'ultima con la nuova bozza, che potrà essere completa o incompleta.
//In questo caso, se l'operazione è stata eseguita per modificare o completare una bozza, bisognerà prendere tutti gli step della bozza precedente
//(ottenibile tramite id_vecchia_bozza) ed inserirli in quella nuova.
//Da qui si verrà reindirizzati al form per aggiungere gli step, dove si decidera se pubblicare il progetto, aggiungere nuovi step o uscire dal form. 

//2)
//se il form è completo, viene salvato nelle bozze per poi essere reindirizzati in form-step, dove verranno aggiunti step. Premendo pubblica verrà eseguito lo script
//per copiare la bozza nel progetto e il tutorial nei tutorial progetti, eliminando definitivamente la bozza da bozze.xml. 

session_start(); 
require_once('functions.php');
$tps_root = "../";
$img_dir_path = "img/proj/"; 
$xmlFile = "../data/xml/bozze.xml";
$data_ora = new DateTime();
$data_ora = $data_ora->format('Y-m-d H:i:s');
$id_creator = $_SESSION['id_utente'];
$id_bozza = generate_id($xmlFile);
$_SESSION['id_bozza'] = $id_bozza; 

$categorie = $_POST['categorie'];
$categoriaProposta = $_POST['categoriaProposta'];
$descrizione = $_POST['descrizione'];
$titolo = $_POST['titolo'];
$tempo_medio = $_POST['tempo_medio'];
$difficolta = $_POST['difficolta'];
$clearance = $_POST['clearance'];

$doc = getDOMdocument($xmlFile); 
$root = $doc->documentElement;
$xpath = new DOMXPath($doc); 

$newBozza = $doc->createElement('bozza');
$bozTutorial = $doc->createElement('tutorial_bozza'); 

if (!empty($_FILES['img']['tmp_name'])) {
    $img_location = $_FILES['img']['tmp_name'];
    $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
    $nome_file_img = $img_dir_path . uniqid('img_proj_') . "." . $ext;
    add_img($img_location, $tps_root . $nome_file_img);
} else {
    $nome_file_img = "";
}

$bozCategorie = $doc->createElement('categorie');
$bozDescrizione = $doc->createElement('descrizione', $descrizione);
$bozCategoriaProposta = $doc->createElement('categoriaProposta', $categoriaProposta);

if(!empty($categoriaProposta)){
    $newBozza->setAttribute('sospeso', 'true');
}else{
    $newBozza->setAttribute('sospeso', 'false');
}

$newBozza->setAttribute('id', $id_bozza);
$newBozza->setAttribute('titolo', $titolo);
$newBozza->setAttribute('id_creator', $id_creator);
$newBozza->setAttribute('tempo_medio', $tempo_medio);
$newBozza->setAttribute('data_pubblicazione', $data_ora);
$newBozza->setAttribute('difficolta', $difficolta);
$newBozza->setAttribute('clearance', $clearance);

$newBozza->setAttribute('nome_file_img', $nome_file_img);

foreach ($categorie as $categoria) {

    $bozCategoria = $doc->createElement('categoria');
    $bozCategoria->setAttribute('id_categoria', $categoria);
    $bozCategorie->appendChild($bozCategoria);

}

$newBozza->appendChild($bozCategorie);
$newBozza->appendChild($bozCategoriaProposta);
$newBozza->appendChild($bozDescrizione);
$newBozza->appendChild($bozTutorial); 

$root->appendChild($newBozza);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

if(isset($_POST['id_vecchia_bozza'])){ //lo passa il form_progetto.php nel caso in cui modifico una bozza
    $id_vecchia_bozza = $_POST['id_vecchia_bozza'];

    $steps_vecchia_bozza = $xpath->query("/bozze/bozza[@id = '$id_vecchia_bozza']/tutorial_bozza")->item(0)->childNodes;
    
    foreach($steps_vecchia_bozza as $step_vecchia_bozza){
        $bozNewStep = $doc->createElement('step'); 
        $bozNewStep->setAttribute('num_step', $step_vecchia_bozza->getAttribute('num_step')); 
        $bozNewStep->setAttribute('nome_file_img', $step_vecchia_bozza->getAttribute('nome_file_img')); 
        $bozStepDescrizione = $doc->createElement('descrizione', $step_vecchia_bozza->getElementsByTagName('descrizione')->item(0)->nodeValue);
        $bozNewStep->appendChild($bozStepDescrizione); 

        $bozTutorial->appendChild($bozNewStep);

    }

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);
    
    if (!empty($id_vecchia_bozza)) {
        $query = "/bozze/bozza[@id";
        remove_1_1($xmlFile, $query, $id_vecchia_bozza);
        echo "$id_vecchia_bozza";
    } 
    
}

header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/form_step.php');
exit;

?>