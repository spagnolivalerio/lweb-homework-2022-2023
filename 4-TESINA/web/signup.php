<?php 
	session_start();
?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<link rel="stylesheet" href="../res/css/signup.css" type="text/css" />
	</head>

	<body>
		<div class="circle circle_1"></div>
		<div class="circle circle_2"></div>
		<div class="circle circle_3"></div>
        <div class="box">
        	<form class="form" method="post" action="">
        	 <div class="signup_title">REGISTRATI</div>
                <div class="container">
        		<div class="form-item">
        			<label for="username">Nome utente</label></br></br>
        			<input name="username" type="text"></input></br>
        		</div></br>
        		<div class="form-item">
        			<label for="password">Password</label></br></br>
        			<input type="password" name="password"></input></br>
        		</div></br>
                <div class="form-item">
                    <label for="nome">Nome</label></br></br>
                    <input type="text" name="nome"></input></br>
                </div></br>
                <div class="form-item">
                    <label for="cognome">Cognome</label></br></br>
                    <input type="text" name="cognome"></input></br>
                </div></br>
             </div>
        		<div class="form-item submit">
        			<button type="subimt" name="submit">REGISTRATI</button></br>
        			<div><p class="signup"><a href="login.php">ho già un account</a></p></div>
        		</div>
        	</form>
		</div>
	</body>

</html>
