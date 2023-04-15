# Progetto_lweb_2023-2024
# VALERIO SPAGNOLI 1973484
# DANIELE SICILIANO 1938217 

-- XHTML-CSS HOMEWORK --

Il primo homework riguarda un sito di autonoleggio con principalmente 4 pagine documentative, nelle quali vengono utilizzate le principali regole css per posizionare al meglio gli elementi all'interno del documento xhtml.
La prima pagina si trova al di fuori della cartella web, con il nome index.html, per un accesso diretto digitando l'indirizzo http://localhost/projects/repository-linguaggi sulla barra di ricerca. 

I documenti xhtml sono tutti stati validati mediante il validatore ufficiale W3C secondo le regole XHTML 1.0 STRICT. La pagina "dove_siamo", per motivi prettamente estetici utilizza dei tag non supportati dal linguaggio xhtml; di fatto per inserire la mappa dinamica di google maps è stato copiato il codice html dato dal sito e incollato sul documento xhtml (La parte di codice corretta è stata commentata a scopo dimostrativo).

-CGI-
Gli script cgi sono stati utilizzati per l'implementazione di una newsletter dal seguente funzionamento:
Si compila per intero il form indicato composto da nome, cognome e e-mail, inviando tutto al server mediante il bottone "INVIA". Successivamente lo script "cgi-newsletter" prende questi dati e ne controlla la lunghezza, verificando se siano stati inseriti o meno. In caso di errore, lo script rimanda alla pagina dove si compila il form, mentre in caso di successo viene creata una pagina di conferma e i dati vengono salvati su un file di testo "newsletter.txt" all'interno della cartella "cgi-local-bin".

I siti di riferimento per la stesura del codice:
-http://www.diag.uniroma1.it/marte/homepage/didattica/lw-latina.html
-https://www.w3schools.com
-https://www.html.it
-https://stackoverflow.com
-https://css-tricks.com

NB: è necessario avere una cartella di nome "projects" all'interno di htdocs. Inoltre abbiamo configurato il server web in modo che i cgi scripts possano essere inseriti all'interno di una cartella di nome "cgi-local-bin", situata all'interno del repository git.
