# lweb-homework-2022-2023
# VALERIO SPAGNOLI 1973484
# DANIELE SICILIANO 1938217 

-- XHTML/CSS HOMEWORK --

Il primo homework riguarda un sito di autonoleggio con principalmente 4 pagine documentative, nelle quali vengono utilizzate le principali regole css per posizionare al meglio gli elementi all'interno del documento xhtml.
La prima pagina si trova al di fuori della cartella web, con il nome index.html, per un accesso diretto digitando l'indirizzo http://localhost/projects/repository-linguaggi sulla barra di ricerca.

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
Si compila per intero il form indicato composto da nome, cognome ed e-mail, inviando tutto al server mediante il bottone "INVIA". Successivamente lo script "cgi-newsletter" prende questi dati e ne controlla la lunghezza, verificando se siano stati inseriti o meno. In caso di errore, lo script rimanda alla pagina dove si compila il form, mentre in caso di successo viene creata una pagina di conferma e i dati vengono salvati su un file di testo chiamato "newsletter.txt" all'interno della cartella "cgi-local-bin".
Il foglio di stile della pagina creata dallo script si trova in res/css/newsletter/ con il nome di "newsletter-style.css".

I siti di riferimento per la stesura del codice:
-http://www.diag.uniroma1.it/marte/homepage/didattica/lw-latina.html
-https://www.w3schools.com
-https://www.html.it
-https://stackoverflow.com
-https://css-tricks.com

NB: Non tutte le funzionalità sono state implementate. Inoltre è necessario avere una cartella di nome "projects" all'interno di htdocs. Il server web è stato configurato in modo che i cgi scripts possano essere inseriti all'interno di una cartella di nome "cgi-local-bin", situata all'interno del repository git con il seguente ScriptAlias:

ScriptAlias /cgi-local-bin/ "C:/xampp/htdocs/projects/lweb-homework-2022-2023/cgi-local-bin/"