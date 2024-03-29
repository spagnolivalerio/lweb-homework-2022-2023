# lweb-homework-2022-2023
# VALERIO SPAGNOLI 1973484
# DANIELE SICILIANO 1938217 

-- XHTML/CSS HOMEWORK --

Repository di Valerio Spagnoli:
https://github.com/spagnolivalerio/lweb-homework-2022-2023.git

Repository di Daniele Siciliano:
https://github.com/danielesiciliano/repository-linguaggi.git

Il primo homework riguarda un sito di autonoleggio con principalmente 4 pagine documentative, nelle quali vengono utilizzate le principali regole css per posizionare al meglio gli elementi all'interno del documento xhtml.
La prima pagina si trova al di fuori della cartella web, con il nome index.html, per un accesso diretto digitando l'indirizzo http://localhost/projects/repository-linguaggi sulla barra di ricerca.
In questo esercizio si sono voluti mettere alla prova diversi aspetti del css e dell'xhtml, ma in particolare il posizionamento degli elementi nel documento e come manipolarli adeguatamente.
Sono state usate regole di stile come display: flex; e display: grid; per tastarne le principali differenze e similitudini, e tutti i valori che si possono dare alla proprietà position: static, absolute, relative, sticky e fixed.

Il file system è organizzato in modo gerarchico:

    lweb-homework-2022-2023--/cgi-local-bin
						     |	
						     /img
						     |
						     /res--/css--/dove_siamo
						     |    	|	  |
						     |    	|	  /global
						     |		|	  |
						     |		|	  /homepage
						     |		|	  |
						     |		|	  /newsletter
						     |		|	  |
						     |		|     /noleggio
						     |		|
						     |		/font
						     |			  
						     /web

I documenti xhtml sono tutti stati validati mediante il validatore ufficiale W3C secondo le regole XHTML 1.0 STRICT. La pagina "dove_siamo", per motivi prettamente estetici utilizza dei tag non supportati dal linguaggio xhtml (<iframe>); di fatto per inserire la mappa dinamica di google maps è stato copiato il codice html dato dal sito e incollato sul documento (La parte di codice corretta è stata commentata a scopo dimostrativo).

-- CGI --

Gli script cgi sono stati utilizzati per l'implementazione di una newsletter dal seguente funzionamento:
Si compila per intero il form indicato composto da nome, cognome ed e-mail, inviando tutto al server mediante il bottone "INVIA". Successivamente lo script "cgi-newsletter" riceve una richiesta POST e riceve i dati, controllandone la lunghezza, verificando se siano stati inseriti o meno. In caso di errore, lo script rimanda alla pagina dove si compila il form, mentre in caso di successo viene creata una pagina di conferma e i dati vengono salvati su un file di testo chiamato "newsletter.txt" all'interno della cartella "cgi-local-bin".
Il foglio di stile della pagina creata dallo script si trova in res/css/newsletter/ con il nome di "newsletter-style.css".

I siti di riferimento per la stesura del codice:
-http://www.diag.uniroma1.it/marte/homepage/didattica/lw-latina.html
-https://www.w3schools.com
-https://www.html.it
-https://stackoverflow.com
-https://css-tricks.com

