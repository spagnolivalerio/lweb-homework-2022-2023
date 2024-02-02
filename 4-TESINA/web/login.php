<?php 
	session_start();

	echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<link rel="stylesheet" href="../res/css/login.css" type="text/css" />
	</head>

	<body>
		<div class="circle circle_1" id="circle1"></div>
		<div class="circle circle_2" id="circle2"></div>
		<div class="circle circle_3" id="circle3"></div>
        <div class="box">
        	<form class="form" method="post" action="../lib/login.php">
        		<div class="login">LOGIN</div>
        		<div id="error">
        		<?php 

					if(isset($_SESSION['error_ban']) && $_SESSION['error_ban'] == "true"){
						echo "Account sospeso";
        				echo "<script>

        						function scomparsa(){
        							var error = document.getElementById('error');
        							error.style.display = \"none\";
        						}

        						setTimeout(scomparsa, 4000);

        					 </script>";
							 unset($_SESSION['error_ban']);
					}
        			elseif(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] === "false"){
        				echo "Inserisci le credenziali";
        				echo "<script>

        						function scomparsa(){
        							var error = document.getElementById('error');
        							error.style.display = \"none\";
        						}

        						setTimeout(scomparsa, 4000);

        					 </script>";

        				unset($_SESSION['credenziali']);
        			}
        		?>
         		</div>
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

