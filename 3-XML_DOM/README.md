# lweb-homework-2022-2023
# VALERIO SPAGNOLI 1973484
# DANIELE SICILIANO 1938217 

-- XML-DOM --

Repository di Valerio Spagnoli:
https://github.com/spagnolivalerio/lweb-homework-2022-2023.git

Repository di Daniele Siciliano:
https://github.com/danielesiciliano/repository-linguaggi.git

Per verificare la funzionalità del sito è necessario inserire la cartella nella root del server web o in una sua sottocartella.

# Descrizione
Nel terzo homework la gestione dei dati avviene tramite XML e XMLSchema. La libreria DOM in php è stata utilizzata per manipolare in maniera efficace il file automobili.xml. Il file auto.xsd contiene la grammatica necessaria alla rappresentazione delle auto e dei noleggi relativi; di fatto, gli elementi "noleggi" sono sottelementi dell'elemento "auto". Per l'identificazione delle auto è stato usato il tipo xsd:ID, che nel nostro caso ne rappresenta la targa, mentre per identificare i noleggi è stata effettuata la concatenzazione della targa dell'auto in questione e di un intero progressivo, in modo da rendere univoco il record.
In aggiunta al precedente homework è stata inserita la possibilità di eliminare i noleggi direttamente dalla pagina "i-miei-noleggi".
Sono stati utilizzati principalmenti metodi come:
-appenChild();
-removeChild();
-item();
ed altre funzionalità messe a disposizione dalla libreria.

Il file install.php crea e popola una piccola base di dati con una tabella "utenti", inserendone due con le seguenti credenziali:

- utente1
- password

- utente2
- password

I seguenti account possiedono già alcuni noleggi.

Per la validazione è stato utilizzato lo script in lib/DOM/validator.php, che restituisce un messaggio di errore nel caso non il file non fosse conforme con il suo xsd, e un messaggio di successo nel caso opposto.
