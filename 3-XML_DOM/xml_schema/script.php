<?php
$xmlString = <<<XML
<!-- Contenuto XML esistente -->
<automobili>
  <auto id="1">
    <Modello>Panda</Modello>
  </auto>
</automobili>
XML;

// Percorso del file XSD
$xsdFile = 'automobili.xsd';

// Creazione del documento XML
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->loadXML($xmlString);

// Validazione XML
if (!$doc->schemaValidate($xsdFile)) {
    echo "Errore di validazione XML.";
    exit;
}

// Creazione dell'elemento "auto" da inserire
$newAuto = $doc->createElement("auto");
$newAuto->setAttribute("id", "2");
$newAuto->setAttribute("Marca", "Fiat");
$newAuto->setAttribute("Modello", "500");
$newAuto->setAttribute("Colore", "Rosso");
$newAuto->setAttribute("Cambio", "Manuale");

// Inserimento del nuovo elemento "auto" nella radice "automobili"
$automobili = $doc->getElementsByTagName("automobili")->item(0);
$automobili->appendChild($newAuto);

// Validazione XML dopo l'aggiunta dell'auto
if (!$doc->schemaValidate($xsdFile)) {
    echo "Errore di validazione XML dopo l'aggiunta dell'auto.";
    exit;
}

// Salvataggio del documento XML aggiornato
$doc->save("auto.xml");

echo "File XML aggiornato con successo!";
?>
