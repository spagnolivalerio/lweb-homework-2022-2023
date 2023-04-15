#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main(void) {
    char *data;
    char nome[50], cognome[50], email[50];
    int length;

    length = atoi(getenv("CONTENT_LENGTH"));

    // Allocazione della memoria per i dati inviati dal client
    data = malloc(length + 1);

    if (data == NULL) {
        printf("Content-Type:text/html\n\n");
        printf("<html><head><title>Error</title></head><body>");
        printf("<h1>Errore nella registrazione</h1>");
        printf("<p>Impossibile allocare la memoria per i dati inviati.</p>");
        printf("</body></html>");
        return 1;
    }

    

    // Leggi i dati inviati dal client
    fgets(data, length + 1, stdin);

    // Azzeramento dei campi nome, cognome ed email
    memset(nome, 0, sizeof(nome));
    memset(cognome, 0, sizeof(cognome));
    memset(email, 0, sizeof(email));

    // Analizza i dati inviati e recupera nome, cognome ed email
    sscanf(data, "nome=%[^&]&cognome=%[^&]&e-mail=%s", nome, cognome, email);

    if (strlen(nome) == 0 || strlen(cognome) == 0 || strlen(email) == 0){
        printf("Location: http://localhost/projects/repository-linguaggi/web/newsletter-form.html\n\n");
        return 1;
    }

 

    // Libera la memoria allocata per i dati inviati dal client
    free(data);

    // Salva i dati in un file di testo
    FILE *file;
    file = fopen("newsletter.txt", "a");

    if (file == NULL) {
        printf("Content-Type:text/html\n\n");
        printf("<html>\n");
        printf("<head>");
        printf("<title>Error</title>\n");
        printf("<link rel=\"stylesheet\" href=\"http://localhost/projects/repository-linguaggi/res/css/style.css\" type=\"text/css\" />\n");
        printf("</head>\n");
        printf("<body>");
        printf("<h1>Errore nella registrazione</h1>\n");
        printf("<p>Impossibile aprire il file di testo per la registrazione.</p>\n");
        printf("</body>\n");
        printf("</html>\n");
        return 1;
    }

    fprintf(file, "%s %s %s\n", nome, cognome, email);
    fclose(file);

    // Mostra una pagina di conferma
    printf("Content-Type:text/html\n\n");
    printf("<html>");
    printf("<head>");
    printf("<title>Conferma registrazione</title>");
    printf("<link rel=\"stylesheet\" href=\"http://localhost/projects/repository-linguaggi/res/css/newsletter/newsletter-style.css\" type=\"text/css\" />");
    printf("</head>");
    printf("<div id=\"title\"><img src=\"http://localhost/projects/repository-linguaggi/img/logoS_S.png\" alt=" "></img></div>");
    printf("<body>");
    printf("<div class=\"blocco\">");
    printf("<h1>Registrazione completata</h1>");
    printf("<ul>");
    printf("<li>Grazie per esserti iscritto alla nostra newsletter.</li>");
    printf("<li>Resta sintonizzato per non perderti le nostre migliori offerte!</li>");
    printf("<li class=\"bottone\"><a href=\"http://localhost/projects/repository-linguaggi\"><span class=\"icon-home\">&#x2302;</span></a></li>");
    printf("</ul>");
    printf("</div>");
    printf("</body>");
    printf("</html>");

    return 0;
}
