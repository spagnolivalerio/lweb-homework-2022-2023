<?php
	session_start();

	if(!isset($_SESSION['tipo_utente'])){
        header('Location: login.php');
        exit();
    }

	$start_day = $_POST['giorno_inizio'];
	$end_day = $_POST['giorno_fine'];
	$id_auto = $_POST['id_auto'];

	//Salvo le date scelte nel form all'interno di variabili di sessione per trasportarle nelle varie pagine i dati necessari per completare il noleggio.
	$_SESSION['id_auto'] = $id_auto;
	$_SESSION['giorno_inizio'] = $start_day;
	$_SESSION['giorno_fine'] = $end_day;


	//Converto le date in un formato accettabile da mysql.
	$start_date = new DateTime($start_day);
	$end_date = new DateTime($end_day);

	//Controllo gli errori degli inserimenti date.
	if(empty($_POST['giorno_inizio'])){
		$_SESSION['error_days'] = 'start_nulldate';
		header('Location: ../../web/form-noleggio.php');
		exit();
	}

	if(empty($_POST['giorno_fine'])){
		$_SESSION['error_days'] = 'end_nulldate';
		header('Location: ../../web/form-noleggio.php');
		exit();
	}

	if($start_day > $end_day){
		$_SESSION['error_days'] = 'start > end';
		header('Location: ../../web/form-noleggio.php');
		exit();
	}

	$today = date('Y-m-d');
	if($start_day < $today){
		$_SESSION['error_days'] = 'start < today';
		header('Location: ../../web/form-noleggio.php');
		exit();
	}

	if($end_day < $today){
		$_SESSION['error_days'] = 'end < today';
		header('Location: ../../web/form-noleggio.php');
		exit();
	}
	//Fine controllo.


	$xmlstring = "";
	foreach(file('../../xml/automobili.xml') as $node){
		$xmlstring .= trim($node);
	}

	$doc = new DOMDocument();
	$doc->loadXML($xmlstring);
	$root = $doc->documentElement;
	$nodi = $root->childNodes;

	for($i = 0; $i < $nodi->length; $i++){

		$auto = $nodi->item($i);
		$targa = $auto->getAttribute('targa');

		if($targa === $id_auto){

			$auto_elements = $auto->childNodes;
			$k = 0;
			$counter = 0;
			
			while(!is_null($auto_elements->item(4+$k))){

				$noleggio_auto = $auto_elements->item(4+$k);
				$noleggio_elements = $noleggio_auto->childNodes;
				$data_noleggio = $noleggio_elements->item(0);
				$data_inizio = $data_noleggio->firstChild;
				$value_di = $data_inizio->nodeValue;
				$data_fine = $data_inizio->nextSibling;
				$value_df = $data_fine->nodeValue;

				if(($value_di >= $start_day && $end_day >= $value_di) ||
				   ($start_day <= $value_df && $end_day >= $value_df) ||
				   ($value_di <= $start_day && $value_df >= $end_day) ||
				   ($start_day <= $value_di && $end_day >= $value_df)   ){

					$counter++;
				}

				$k++;
			}
		}
	}

   //Si fa un controllo sulla variabile di sessione 'disp': se non è settata allora devo eseguire la query perchè siamo nel caso in cui dobbiamo verificare se c'è disponibilità.
   if(!isset($_SESSION['disp'])){      


   		//Se la query da 0 righe, significa che le date sono disponibili, di conseguenza setto 'disp' = true e vado in checkout_noleggio.php per proseguire con l'insert.
   		if($counter === 0){

   			$_SESSION['disp'] = true;
			$diff = date_diff($start_date, $end_date);
			$num_days = $diff->days;
			$_SESSION['num_days'] = $num_days;
   			header('Location: ../../web/checkout_noleggio.php');
   			exit();
   		
   	//Se ci sono delle righe nel risultato della query, allora le date non sono disponibili, quindi setto 'disp' = false e torno nel form-noleggio, dove verrà stampato il relativo errore. 
  		} else {

  	 		$_SESSION['disp'] = false;
  	 		header('Location: ../../web/form-noleggio.php');
   			exit();

  		}
   }

?>