<?php
	session_start();
	require('../../res/var/db.php');
	$conn = new mysqli($servername, $db_username, $db_password, $db_name);


	$start_day = $_POST['giorno_inizio'];
	$end_day = $_POST['giorno_fine'];
	$auto = $_POST['id_auto'];
	$_SESSION['id_auto'] = $auto;

	//CONTROLLO ERRORI INSERIMENTO DATE
	if($start_day > $end_day){
		$_SESSION['error_days'] = 'start > end';
		header('Location: ../../web/form-noleggio.php');
		exit(1);
	}

	if(empty($_POST['giorno_fine']) || empty($_POST['giorno_inizio'])){
		$_SESSION['error_days'] = 'nulldate';
		header('Location: ../../web/form-noleggio.php');
		exit(1);
	}

	$today = date('Y-m-d');
	if($start_day < $today){
		$_SESSION['error_days'] = '<today';
		header('Location: ../../web/form-noleggio.php');
		exit(1);
	}
	//FINE_CONTROLLO

	//QUERY PER CERCARE NOLEGGI CON L'AUTO SELEZIONATA CHE SI SOVRAPPONGONO
	$check_disp =	"SELECT *
                 	FROM noleggio n
                 	WHERE n.id_auto = '$auto'
                 	AND((n.data_inizio < '$start_day' AND '$start_day' < n.data_fine)
                 	OR  ('$end_day' > n.data_inizio AND '$end_day' < n.data_fine)
                 	OR  (n.data_inizio = '$start_day' AND n.data_fine = '$end_day'));";


   //CONTROLLO SULLA VARIABILE $_SESSION['disp']: SE NON è SETTATA O è 'no' ALLORA FACCIO LA QUERY PER CERCARE DISPONIBILITà: NEL CASO LA TROVA LA SETTA A 'yes' E VA NEL CHECKOUT NOLEGGIO, SE NO TORNA IN FORM-NOLEGGIO CON LA VARIABILE SETTATA A 'no'. IL FORM FARà I RELATIVI CONTROLLI SULLA VARIABILE PER CAPIRE COSA STAMPARE E COME COMPORTARSI.
   if(!isset($_SESSION['disp']) || $_SESSION['disp'] !== 'yes'){      

   	$res = mysqli_query($conn, $check_disp);

   	if(mysqli_num_rows($res) === 0){
   		$_SESSION['disp'] = 'yes';
   		header('Location: ../../web/checkout_noleggio.php');
   		exit(1);
  	 	} else {
  	 		$_SESSION['disp'] = 'no';
  	 		header('Location: ../../web/form-noleggio.php');
   		exit(1);
  	 	}
  	}

?>