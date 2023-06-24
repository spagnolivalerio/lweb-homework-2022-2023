<?php

function print_auto(){

$xmlstring = "";
foreach (file("../../xml/automobili.xml") as $node){
  $xmlstring .= trim($node);
}

$doc = new DOMDocument();
$doc->loadXML($xmlstring);
$root = $doc->documentElement;
$elementi = $root->childNodes;

for ($i=0; $i<$elementi->length; $i++) {
    $auto = $elementi->item($i);
    $marca = $auto->firstChild;
    $nomeMarca = $marca->textContent;
    $modello = $marca->nextSibling;
    $nomeModello = $modello->textContent;
    $prezzo_giorn = $modello->nextSibling;
    $value_string_pg = $prezzo_giorn->textContent;
    $img = $prezzo_giorn->nextSibling;
    $nome_file_img = $img->textContent;
    $targa = $auto->getAttribute('targa');
    $posti = $auto->getAttribute('num_posti');
    $cambio = $auto->getAttribute('cambio');
    $porte = $auto->getAttribute('num_porte');
    $carburante = $auto->getAttribute('carburante');
    $cavalli = $auto->getAttribute('cavalli');




  //usata in web/noleggio.php

            echo "<div class=\"row\">

                    <div class=\"column left-column\">
                      <div class=\"car-name\"><span> $nomeMarca $nomeModello </span></div>
                      <img class=\"car\" src=\"../img/car-img/$nome_file_img\" alt=\"img\"></img>
                    </div>
                    <div class=\"column center-column\">
                      <div class=\"container\">
                      	<div class=\"flexbox\">
             		 		      <ul class=\"features\">
               			 		   <li><img src=\"../img/posti.png\"></img> $posti </li>
               			 		   <li><img src=\"../img/cambio.png\"></img> $cambio </li>
              				    </ul>
            	 			      <ul class=\"features flex-item\">
              		  			 <li>&#9981; $carburante </li>
               		  	 		 <li><img src=\"../img/porte.png\"></img> $porte </li>
              				    </ul>
             	    		    <ul class=\"features\">
              	  				 <li>&#x1F40E; $cavalli </li>
              				    </ul>
                        </div>

                        <ul class=\"dettagli\">
                          <li><img class =\"check\" src=\"../img/check.png\" alt=\"check\"></img> Climatizzazione</li>
                          <li><img class =\"check\" src=\"../img/check.png\" alt=\"check\"></img> Polizza assicurativa</li>
                          <li><img class =\"check\" src=\"../img/check.png\" alt=\"check\"></img> Cancellazione gratuita fino a 72h prima</li>
                          <li><img class =\"check\" src=\"../img/check.png\" alt=\"check\"></img> Servizio GPS</li>
                          <li><img class =\"check\" src=\"../img/check.png\" alt=\"check\"></img> Chilometraggio illimitato</li>
                        </ul>

                        <p class=\"recensioni\">Guarda le recensioni</p>

                      </div>

              			</div>

                    <div class=\"column right-column\">
                      <p class=\"prezzo\"> $value_string_pg &euro; <span id=\"g-text\">giornalieri</span></p>
                      <form action=\"form-noleggio.php\" method=\"post\"> 
                          <input type=\"hidden\" name=\"id_auto\" value=\"$targa\"></input>
                          <button class=\"noleggio-button\" type=\"submit\">NOLEGGIA ORA</button>
                      </form>
                    </div>
                  </div>";
        }
    }

?>