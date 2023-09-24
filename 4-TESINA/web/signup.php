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
		<div class="circle circle_3" id="circle3"></div>
		<div class="circle circle_2" id="circle2"></div>
		<div class="circle circle_1" id="circle1"></div>

        <script>
                const circle1 = document.getElementById('circle1');
                const circle2 = document.getElementById('circle2');
                const circle3 = document.getElementById('circle3');
                const amplitude = 50;
                const frequency = 0.005;
                const radius = 100; 
                let time = 0;
                let angle = 0;

                function animate() {
                    // Calcola la posizione verticale basata su una funzione sinusoidale
                    const yPos1 = amplitude * Math.sin(frequency * time);
                    const yPos2 = amplitude * Math.cos(frequency * time + Math.PI * 0.5);
                    const yPos3 = amplitude * Math.cos(frequency * time + Math.PI);

                    const xPos1 = radius * Math.cos(angle);
                    const xPos2 = radius * Math.cos(angle + Math.PI * 0.5);
                    const xPos3 = radius * Math.cos(angle + Math.PI);

                    // Imposta le posizioni dei div
                    circle1.style.transform = `translate(${-50 + xPos1}%, ${yPos1}%)`;
                    circle2.style.transform = `translate(${40 + xPos2}%, ${-40 + yPos2}%)`;
                    circle3.style.transform = `translate(${-120 + xPos3}%, ${-60 + yPos3}%)`;

                    // Aggiorna il tempo
                    time += 1;
                    angle += 0.01; 

                    // Richiedi un nuovo frame di animazione
                    requestAnimationFrame(animate);
                }

                // Avvia l'animazione
             animate();
        </script>

        <div class="box">
        	<form class="form" method="post" action="">
        	 <div class="signup_title">REGISTRATI</div>
                <div class="container">
                    <div class="form-item">
                        <p class="label">Nome</p></br>
                        <input name="nome" type="text"></input>
                    </div>
                    <div class="form-item">
                        <p class="label">Cognome</p></br>
                        <input name="cognome" type="text"></input>
                    </div>
        		    <div class="form-item">
        			    <p class="label">e-mail</p></br>
        			    <input name="e-mail" type="text"></input>
        		    </div>
        		    <div class="form-item">
        		        <p class="label">Indirizzo</p></br>
        			    <input type="text" name="indirizzo"></input>
        		    </div>
                    <div class="form-item">
                        <p class="label">Username</p></br>
                        <input type="text" name="username"></input>
                    </div>
                    <div class="form-item">
                        <p class="label">password</p></br>
                        <input type="password" name="password"></input>
                    </div>
                </div>
        		<div class="form-item submit">
        			<button type="subimt" name="submit">REGISTRATI</button></br>
        			<div><p class="signup"><a href="login.php">ho già un account</a></p></div>
        		</div>
        	</form>
		</div>
	</body>

</html>
