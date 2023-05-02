<?php


	if(isset($_POST['dark-mode']) && $_POST['dark-mode'] === 'light' ){
		setcookie('dark-mode', 'false', time()+3600*24*30, '/');
	} elseif(isset($_POST['dark-mode']) && $_POST['dark-mode'] === 'dark'){
		setcookie('dark-mode', 'true', time()+3600*24*30, '/');
	}

	if(isset($_POST['page'])){

		switch($_POST['page']){

			case 'homepage':
			header('Location: ../../web/homepage.php');
			break;

			case 'dove_siamo':
			header('Location: ../../web/dove_siamo.php');
			break;

			case 'noleggio':
			header('Location: ../../web/noleggio.php');
			break;

			case 'i-miei-noleggi':
			header('Location: ../../web/i-miei-noleggi.php');
			break;
		}	

	} else {
		header('Location: ../../index.php');
		exit(1);
	}



?>