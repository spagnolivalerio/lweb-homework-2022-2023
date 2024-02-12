<?php 
	session_start();

    if(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] == 'false'){

        $username = $_SESSION['username'];
        unset($_SESSION['username']);
        $nome = $_SESSION['nome'];
        unset($_SESSION['nome']);
        $cognome = $_SESSION['cognome'];
        unset($_SESSION['cognome']);
        $password = $_SESSION['password'];
        unset($_SESSION['password']);
        $email = $_SESSION['email'];
        unset($_SESSION['email']);
        $indirizzo = $_SESSION['indirizzo'];
        unset($_SESSION['indirizzo']);
        $avatar = $_SESSION['avatar'];
        unset($_SESSION['avatar']); 

    }

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
?>

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
                    const yPos1 = amplitude * Math.sin(frequency * time);
                    const yPos2 = amplitude * Math.cos(frequency * time + Math.PI * 0.5);
                    const yPos3 = amplitude * Math.cos(frequency * time + Math.PI);

                    const xPos1 = radius * Math.cos(angle);
                    const xPos2 = radius * Math.cos(angle + Math.PI * 0.5);
                    const xPos3 = radius * Math.cos(angle + Math.PI);

                    circle1.style.transform = `translate(${-50 + xPos1}%, ${yPos1}%)`;
                    circle2.style.transform = `translate(${40 + xPos2}%, ${-40 + yPos2}%)`;
                    circle3.style.transform = `translate(${-120 + xPos3}%, ${-60 + yPos3}%)`;

                    time += 1;
                    angle += 0.01; 

                    requestAnimationFrame(animate);
                }

             animate();
        </script>

        <div class="box">
        	<form class="form" method="post" action="../lib/signup.php">
        	 <div class="signup_title">REGISTRATI</div>
             <div id="error">
                <?php 
                    if(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] === "false" && !isset($_SESSION['username_esistente'])  && !isset($_SESSION['email_esistente']) && !isset($_SESSION['password_unmatch']) && !isset($_SESSION['email_invalid'])){
                        echo "Inserisci le credenziali";
                    } elseif (isset($_SESSION['username_esistente']) && $_SESSION['username_esistente'] === "true") {
                        echo "Username esistente";
                        unset($_SESSION['username_esistente']);
                    } elseif (isset($_SESSION['email_esistente']) && $_SESSION['email_esistente'] === "true") {
                        echo "E-mail esistente";
                        unset($_SESSION['email_esistente']);
                    } elseif (isset($_SESSION['password_unmatch']) && $_SESSION['password_unmatch'] === "true") {
                        echo "La password non rispetta i criteri di sicurezza";
                        unset($_SESSION['password_unmatch']);
                    } elseif (isset($_SESSION['email_invalid']) && $_SESSION['email_invalid'] === "true") {
                        echo "L'e-mail scelta non rispetta la struttura richiesta ";
                        unset($_SESSION['email_invalid']);
                    }
                ?>
            </div>
            <script>
                function scomparsa() {
                    var error = document.getElementById('error');
                    if (error) {
                        error.style.display = "none";
                    }
                }
                setTimeout(scomparsa, 4000);
            </script>

                <div class="container">
                    <div class="form-item">
                        <p class="label">Nome</p><br />
                        <input name="nome" type="text" <?php if(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] == 'false') {echo "value=\"$nome\""; }?>></input>
                    </div>
                    <div class="form-item">
                        <p class="label">Cognome</p><br />
                        <input name="cognome" type="text" <?php if(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] == 'false') {echo "value=\"$cognome\""; }?>></input>
                    </div>
        		    <div class="form-item">
        			    <p class="label">e-mail&ast;&ast;</p><br />
        			    <input name="e-mail" type="text" <?php if(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] == 'false') {echo "value=\"$email\""; }?>></input>
        		    </div>
        		    <div class="form-item">
        		        <p class="label">Indirizzo</p><br />
        			    <input type="text" name="indirizzo" <?php if(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] == 'false') {echo "value=\"$indirizzo\""; }?>></input>
        		    </div>
                    <div class="form-item">
                        <p class="label">Username</p><br />
                        <input type="text" name="username" <?php if(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] == 'false') {echo "value=\"$username\""; }?>></input>
                    </div>
                    <div class="form-item">
                        <p class="label">password&ast;</p><br />
                        <input type="password" name="password" <?php if(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] == 'false') {echo "value=\"$password\""; }?>></input>
                    </div>

                    <div class="avatar-box">
                        <label for="avatar">Seleziona un avatar:</label>

                        <div class="box">
                            <div class=avatar-container-radio-img>
                                <input type="radio" id="avatar1" name="avatar" value="avatar1.png" <?php if(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] == 'false'){ echo ($avatar == 'avatar1.png') ? 'checked' : '';} ?>>
                                <label for="avatar1">
                                    <div class="avatar-preview">
                                        <img src="../img/avatar/avatar1.png" alt="Avatar 1">
                                    </div>
                                </label>
                            </div>

                            <div class=avatar-container-radio-img>
                                <input type="radio" id="avatar2" name="avatar" value="avatar2.png" <?php if(isset($_SESSION['credenziali']) && $_SESSION['credenziali'] == 'false'){ echo ($avatar == 'avatar2.png') ? 'checked' : '';} ?>>
                                <label for="avatar2">
                                    <div class="avatar-preview">
                                        <img src="../img/avatar/avatar2.png" alt="Avatar 2">
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
        		<div class="form-item submit">
        			<button type="subimt" name="submit">REGISTRATI</button><br />
        		</div>
                <p class="signup"><a href="login.php">ho già un account</a></p>
                <div class="info">
                    <p>&ast;Nota bene: La password deve avere almeno 8 caratteri di cui una lettera maiuscola e un carattere speciale (&excl;&commat;&num;&dollar;&percnt;&Hat;&amp;&ast;)</p>
                    <p>&ast;&ast;La mail deve rispettare il formato xxxxxxxxxx@xxxx.xx</p>
                </div>
        	</form>
		</div>
	</body>
    
    <?php 
        unset($_SESSION['credenziali']);
    ?>

</html>
