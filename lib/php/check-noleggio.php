<?php
	session_start();
	require('../../res/var/db.php');
	$conn = new mysqli($servername, $db_username, $db_password, $db_name);

	$start_day = $_POST['giorno_inizio'];
	$end_day = $_POST['giorno_fine'];
	$auto = $_POST['id_auto'];


	//Salvo le date scelte nel form all'interno di variabili di sessione per trasportarle nelle varie pagine i dati necessari per completare il noleggio.
	$_SESSION['id_auto'] = $auto;
	$_SESSION['giorno_inizio'] = $start_day;
	$_SESSION['giorno_fine'] = $end_day;



	//Converto le date in un formato accettabile da mysql.
	$start_date = new DateTime($start_day);
	$end_date = new DateTime($end_day);

	//Controllo gli errori degli inserimenti date.
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


	$today = date('Y-m-d');
	if($start_day < $today){
		$_SESSION['error_days'] = '<today';
		header('Location: ../../web/form-noleggio.php');
		exit(1);
	}
	//Fine controllo.

	//Query che verifica se le date scelte vadano in conflitto con altri noleggi esistenti.
	$check_disp =	"SELECT *
                	 FROM noleggio n
                	 WHERE n.id_auto = '$auto'
                	 AND((n.data_inizio >= '$start_day' AND '$end_day' >= n.data_inizio)
                	 OR  ('$start_day' <= n.data_fine AND '$end_day' >= n.data_fine)
                	 OR  (n.data_inizio <= '$start_day' AND n.data_fine >= '$end_day')
                	 OR  ('$start_day' <= n.data_inizio AND '$end_day' >= n.data_fine));";

   //Si fa un controllo sulla variabile di sessione 'disp': se non è settata allora devo eseguire la query perchè siamo nel caso in cui dobbiamo verificare se c'è disponibilità.
   if(!isset($_SESSION['disp'])){      

   	$res = mysqli_query($conn, $check_disp);

   	//Se la query da 0 righe, significa che le date sono disponibili, di conseguenza setto 'disp' = true e vado in checkout_noleggio.php per proseguire con l'insert.
   	if(mysqli_num_rows($res) === 0){

   		$_SESSION['disp'] = true;
		$diff = date_diff($start_date, $end_date);
		$num_days = $diff->days;
		$_SESSION['num_days'] = $num_days;
   		header('Location: ../../web/checkout_noleggio.php');
   		exit(1);
   		
   	//Se ci sono delle righe nel risultato della query, allora le date non sono disponibili, quindi setto 'disp' = false e torno nel form-noleggio, dove verrà stampato il relativo errore. 
  	} else {

  	 	$_SESSION['disp'] = false;
  	 	header('Location: ../../web/form-noleggio.php');
   		exit(1);

  	}
   }

  	$conn->close();

?>