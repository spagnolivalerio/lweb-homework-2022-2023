<?php 
	session_start();
?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<link rel="stylesheet" href="../res/css/login.css" type="text/css" />
	</head>

	<body>
		<div class="circle circle_1"></div>
		<div class="circle circle_2"></div>
		<div class="circle circle_3"></div>
        <div class="box">
        	<form class="form" method="post" action="">
        		<div class="login">LOGIN</div>
        		<div class="form-item">
        			<label for="username">Nome utente</label></br></br>
        			<input name="username" type="text"></input></br>
        		</div>
        		<div class="form-item">
        			<label for="password">Password</label></br></br>
        			<input type="password" name="password"></input></br>
        		</div></br>
        		<div class="form-item submit">
        			<button type="subimt" name="submit">ACCEDI</button></br>
        			<div><p class="signup">oppure <a href="signup.php">registrati</a></p></div>
        		</div>
        	</form>
		</div>
	</body>

</html>

