#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main(){

    char *query_string;
    char nome[50], cognome[50], email[50];
    int length;
    FILE *file;

    //pulisco i buffer per registrazioni precedenti
    memset(nome, 0, sizeof(nome));
    memset(cognome, 0, sizeof(cognome));
    memset(email, 0, sizeof(email));

    length = atoi(getenv("CONTENT_LENGTH"));

    //alloco spazio per contenere la query_string
    query_string = malloc(length + 1);
    
    //usiamo lo standard input per leggere i dati inviati dal form 
    fgets(query_string, length + 1, stdin);

    //divido nome cognome e mail
    sscanf(query_string, "nome=%[^&]&cognome=%[^&]&e-mail=%s", nome, cognome, email);

    //controllo eventuali missed fields
    if (strlen(nome) == 0 || strlen(cognome) == 0 || strlen(email) == 0){
        printf("Location: ../web/newsletter-form.html\n\n");
        return 1;
    }

    //pulisco la query_string
    memset(query_string, 0, sizeof(query_string));

    file = fopen("newsletter.txt", "a");
    fprintf(file, "nome: %s\ncognome: %s\ne-mail: %s\n\n", nome, cognome, email);
    fclose(file);

    printf("Content-Type:text/html\n\n");
    printf("<html>\n");
    printf("<head>\n");
    printf("<title>Conferma registrazione</title>\n");
    printf("<link rel=\"stylesheet\" href=\"../res/css/newsletter/newsletter-style.css\" type=\"text/css\" />\n");
    printf("</head>\n");
    printf("<div id=\"title\">\n\t<img src=\"../img/logoS_S.png\" alt=" "></img>\n</div>");
    printf("<body>\n");
    printf("<div class=\"blocco\">\n");
    printf("<h1>Registrazione completata</h1>\n");
    printf("<ul>\n");
    printf("\t<li>Grazie per esserti iscritto alla nostra newsletter.</li>\n");
    printf("\t<li>Resta sintonizzato per non perderti le nostre migliori offerte!</li>\n");
    printf("\t<li class=\"bottone\"><a href=\"../index.html\"><span class=\"icon-home\">&#x2302;</span></a></li>");
    printf("</ul>\n");
    printf("</div>\n");
    printf("</body>\n");
    printf("</html>\n");

    return 0;
}
