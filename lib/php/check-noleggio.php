<?php
	session_start();
	require('../../res/var/db.php');
	$conn = new mysqli($servername, $db_username, $db_password, $db_name);


	$start_day = $_POST['giorno_inizio'];
	$end_day = $_POST['giorno_fine'];
	$auto = $_POST['id_auto'];
	$_SESSION['id_auto'] = $auto;


	//SALVO giorno_inizio e giorno_fine in delle variabili di sessione pr utilizzarle in checkout_noleggio

	$_SESSION['giorno_inizio'] = $start_day;
	$_SESSION['giorno_fine'] = $end_day;



	// CONVERTO LE DATE IN UN FORMATO COMPATIBILE CON PHP
	$start_date = new DateTime($start_day);
	$end_date = new DateTime($end_day);

	//CONTROLLO ERRORI INSERIMENTO DATE
	if(empty($_POST['giorno_fine']) || empty($_POST['giorno_inizio'])){
		$_SESSION['error_days'] = 'nulldate';
		header('Location: ../../web/form-noleggio.php');
		exit(1);
	}

	if($start_day > $end_day){
		$_SESSION['error_days'] = 'start > end';
		header('Location: ../../web/form-noleggio.php');
		exit(1);
	}


	$today = new DateTime();
	if($start_day < $today){
		$_SESSION['error_days'] = '<today';
		header('Location: ../../web/form-noleggio.php');
		exit(1);
	}
	//FINE_CONTROLLO

	$check_disp =	"SELECT *
                	 FROM noleggio n
                	 WHERE n.id_auto = '$auto'
                	 AND((n.data_inizio < '$start_day' AND '$start_day' < n.data_fine)
                	 OR  ('$end_day' > n.data_inizio AND '$end_day' < n.data_fine)
                	 OR  (n.data_inizio = '$start_day' AND n.data_fine = '$end_day'));";

   //CONTROLLO SULLA VARIABILE $_SESSION['disp']: SE NON è SETTATA O è 'false' ALLORA FACCIO LA QUERY PER CERCARE DISPONIBILITà: NEL CASO LA TROVA, LA SETTA A 'true' E VA NEL CHECKOUT NOLEGGIO, SE NO TORNA IN FORM-NOLEGGIO CON LA VARIABILE SETTATA A 'false'. IL FORM FARà I RELATIVI CONTROLLI SULLA VARIABILE PER CAPIRE COSA STAMPARE E COME COMPORTARSI.
   if(!isset($_SESSION['disp']) || $_SESSION['disp'] === false){      

   	$res = mysqli_query($conn, $check_disp);

   	if(mysqli_num_rows($res) === 0){
   		$_SESSION['disp'] = true;
		//CALCOLO GIORNI NOLEGGIO
		$diff = date_diff($start_date, $end_date);
		$num_days = $diff->days;
		//SALVO IL NUMERO DI GIORNI IN UNA VARIABILE DI SESSIONE
		$_SESSION['num_days'] = $num_days;
   		header('Location: ../../web/checkout_noleggio.php');
   		exit(1);
  	 	} else {
  	 		$_SESSION['disp'] = false;
  	 		header('Location: ../../web/form-noleggio.php');
   		exit(1);
  	 	}
  	}

  	$conn->close();

?>