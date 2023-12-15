<?php
//1)
//Se il form non è completo, viene salvato nelle bozze e poi si viene reindirizzati nel form degli step. Da qui, dopo aver aggiunto gli step, si può decidere se
//aggiungere altri step o pubblicare il progetto. In questo caso si verrà reindirizzati nel form di creazione del progetto con i campi inseriti in precedenza gia compilati
//mandando l'id della bozza corrente tramite get (che sarà id_vecchia_bozza relativamente a quella nuova creata).
//Questo id servirà all'eliminazione della bozza corrente dal file delle bozze e alla sostituzione di quest'ultima con la nuova bozza, che potrà essere completa o incompleta.
//In questo caso, se l'operazione è stata eseguita per modificare o completare una bozza, bisognerà prendere tutti gli step della bozza precedente
//(ottenibile tramite id_vecchia_bozza) ed inserirli in quella nuova.
//Da qui si verrà reindirizzati al form per aggiungere gli step, dove si decidera se pubblicare il progetto, aggiungere nuovi step o uscire dal form. 

//2)
//se il form è completo, viene salvato nelle bozze per poi essere reindirizzati in form-step, dove verranno aggiunti step. Premendo pubblica verrà eseguito lo script
//per copiare la bozza nel progetto e il tutorial nei tutorial progetti, eliminando definitivamente la bozza da bozze.xml. 
?>