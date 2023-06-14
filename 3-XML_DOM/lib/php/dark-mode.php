<?php

	if(isset($_POST['dark-mode']) && $_POST['dark-mode'] === 'light' ){
		setcookie('dark-mode', 'false', time()+3600*24*30, '/');
	} elseif(isset($_POST['dark-mode']) && $_POST['dark-mode'] === 'dark'){
		setcookie('dark-mode', 'true', time()+3600*24*30, '/');
	}

	if(isset($_POST['page'])){

		switch($_POST['page']){

			case 'homepage':
			header('Location: ../../web/homepage.php#hidden-menu');
			break;

			case 'dove_siamo':
			header('Location: ../../web/dove_siamo.php#hidden-menu');
			break;

			case 'noleggio':
			header('Location: ../../web/noleggio.php#hidden-menu');
			break;

			case 'i-miei-noleggi':
			header('Location: ../../web/i-miei-noleggi.php#hidden-menu');
			break;

			case 'newsletter-form':
			header('Location: ../../web/newsletter-form.php#hidden-menu');
			break;
		}	

	} else {
		header('Location: ../../index.php');
		exit();
	}



?>