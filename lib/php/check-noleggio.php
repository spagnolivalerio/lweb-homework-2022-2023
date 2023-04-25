<?php
	session_start();
	require('../../res/var/db.php');
	$conn = new mysqli($servername, $db_username, $db_password, $db_name);
	setcookie('id_auto', $_POST['id_auto'], time() + 3600, '/');

	$start_day = $_POST['giorno_inizio'];
	$end_day = $_POST['giorno_fine'];
	$auto = $_POST['id_auto'];


	$check_disp ="SELECT *
               FROM noleggio n, auto a
               WHERE n.id_auto = a.id
               AND   a.id = '$auto'
               AND(
				    (n.data_inizio >= '$start_day' 
                          AND n.data_inizio < '$end_day')
               OR      (n.data_fine > '$start_day '
                           AND n.data_fine <= '$end_day')
               OR      (n.data_inizio < '$start_day'
                           AND n.data_fine > '$end_day')
				);";

	$insert_noleggio = "INSERT INTO noleggio 
						(id_auto, id_utente, data_inizio, data_fine, stato)
	                    VALUES ('$auto', 'devomemorizzarmi id_utente', '$start_day', '$end_day', 'in corso')";"

	$res = mysqli_query($conn, $check_disp);

	if(mysqli_num_rows($res) > 0){
		echo "errore";
		$_SESSION['disponibilità']= 'no';
		header('Location: ../../web/form-noleggio.php');
		exit(1);
	}

	if($_SESSION['disponiblità']){

	}

	$_SESSION['disponibilità'] = 'yes';
	header('Location: ../../web/form-noleggio.php');

	if($start_day > $end_day){
		$_SESSION['error_days'] = 'start > end';
		header('Location: ../../web/form-noleggio.php');
		exit(1);
	}
?>