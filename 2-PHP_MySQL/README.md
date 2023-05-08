# lweb-homework-2022-2023
# VALERIO SPAGNOLI 1973484
# DANIELE SICILIANO 1938217 

-- PHP/MYSQL --

Repository di Valerio Spagnoli:
https://github.com/spagnolivalerio/lweb-homework-2022-2023.git

Repository di Daniele Siciliano:
https://github.com/danielesiciliano/repository-linguaggi.git

Per verificare la funzionalità del sito è necessario inserire la cartella nella root del server web o in una sua sottocartella.

# Descrizione
Il secondo homework è un'estensione del primo, dove è possibile registrare un account, eseguire il login, logout, prenotare e visualizzare noleggi di auto.
Questi aspetti sono stati implementati attraverso l'uso di script php, utilizzando variabili di sessione, cookie e hidden fields, in modo da mantenere uno stato all'interno dell'applicazione.
In particolare, cookie ed hidden fields sono stati utilizzati per l'implementazione del tema scuro (selezionabile all'interno del menu a scomparsa), attraverso la referenzazione di diversi fogli di stile a seconda del valore del cookie.
Le auto, gli utenti e i noleggi sono rappresentati da tabelle all'interno di una base di dati, che verrà creata e popolata (solo per le auto, per aggiungere un account c'è il form per la registrazione) una volta avviato install.php. Successivamente si verrà indirizzati nell'index.php, che gestirà i successivi indirizzamenti.
La newsletter è stata riadattata utilizzando il php e inserendo una tabella nel database, dove verranno inserite le mail registrate nel form. In caso di utente già registrato, verrà visualizzata una spunta verde accanto al link alla newsletter, contenuta all'interno del menù a a scomparsa.

# Nota bene
E' stato usato uno script in javascript esclusivamente per applicare la regola di stile 'display: none;' agli errori che si possono verificare nella compilazione dei form.
