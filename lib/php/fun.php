<?php

	function print_auto($res){

		foreach($res as $row){

            echo "<div class=\"row\">

                    <div class=\"column left-column\">
                      <div class=\"car-name\"><span>" . $row['marca'] . " " . $row['modello'] . "</span></div>
                      <img class=\"car\" src=\"http://localhost/projects/repository-linguaggi/img/car-img/" . $row['nome_file_img'] . "\" alt=\"img\"></img>
                    </div>
                    <div class=\"column center-column\">
                      <div class=\"container\">
                      	<div class=\"flexbox\">
             		 		      <ul class=\"features\">
               			 		   <li><img src=\"http://localhost/projects/repository-linguaggi/img/posti.png\"></img> " . $row['num_posti'] . " </li>
               			 		   <li><img src=\"http://localhost/projects/repository-linguaggi/img/cambio.png\"></img> " . $row['cambio'] . "</li>
              				    </ul>
            	 			      <ul class=\"features flex-item\">
              		  			 <li>&#9981; " . $row['carburante'] . "</li>
               		  	 		 <li><img src=\"http://localhost/projects/repository-linguaggi/img/porte.png\"></img> " . $row['num_porte'] . "</li>
              				    </ul>
             	    		    <ul class=\"features\">
              	  				 <li>&#x1F40E; " . $row['cavalli'] . "</li>
              				    </ul>
                        </div>

                        <ul class=\"dettagli\">
                          <li><img class =\"check\" src=\"http://localhost/projects/repository-linguaggi/img/check.png\" alt=\"check\"></img> Climatizzazione</li>
                          <li><img class =\"check\" src=\"http://localhost/projects/repository-linguaggi/img/check.png\" alt=\"check\"></img> Polizza assicurativa</li>
                          <li><img class =\"check\" src=\"http://localhost/projects/repository-linguaggi/img/check.png\" alt=\"check\"></img> Cancellazione gratuita fino a 72h prima</li>
                          <li><img class =\"check\" src=\"http://localhost/projects/repository-linguaggi/img/check.png\" alt=\"check\"></img> Servizio GPS</li>
                          <li><img class =\"check\" src=\"http://localhost/projects/repository-linguaggi/img/check.png\" alt=\"check\"></img> Chilometraggio illimitato</li>
                        </ul>

                        <p class=\"recensioni\">Guarda le recensioni</p>

                      </div>

              			</div>

                    <div class=\"column right-column\">
                      <p class=\"prezzo\">" . $row['prezzo_giornaliero'] . "&euro; <span id=\"g-text\">giornalieri</span></p>
                      <form action=\"form-noleggio.php\" method=\"post\"> 
                          <input type=\"hidden\" name=\"id_auto\" value=\" " . $row['id'] . " \"></input>
                          <button class=\"noleggio-button\" type=\"submit\">NOLEGGIA ORA</button>
                      </form>
                    </div>
                  </div>";
        }
    }

?>