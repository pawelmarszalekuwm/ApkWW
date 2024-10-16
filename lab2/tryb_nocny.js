var isNightMode = false; // Zmienna śledzi aktualny tryb

function toggleNightMode() {
    var body = document.body;
    var header = document.querySelector('header');
    var footer = document.querySelector('footer');
    var main = document.querySelector('main');
    var nav = document.querySelector('nav');
    var links = document.querySelectorAll('nav ul li a');
    var button = document.querySelector('button');

    if (isNightMode) {
        // Powrót do oryginalnych stylów (tryb dzienny)
        body.style.backgroundColor = "";  // Przywracamy domyślne tło
        body.style.color = "";  // Przywracamy domyślny kolor tekstu

        if (header) {
            header.style.backgroundColor = "";
            header.style.color = "";
        }

        if (footer) {
            footer.style.backgroundColor = "";
            footer.style.color = "";
        }

        if (main) {
            main.style.backgroundColor = "";
            main.style.color = "";
        }

        if (nav) {
            nav.style.backgroundColor = "";
            nav.style.color = "";
        }

        links.forEach(function(link) {
            link.style.color = "";
        });

        // Zmiana etykiety przycisku na "Tryb Nocny"
        button.textContent = "Tryb Nocny";

        isNightMode = false;
    } else {
        // Aktywacja trybu nocnego
        body.style.backgroundColor = "#121212"; // Ciemne tło
        body.style.color = "#f1f1f1";  // Jasny tekst

        if (header) {
            header.style.backgroundColor = "#1f1f1f";
            header.style.color = "#f1f1f1";
        }

        if (footer) {
            footer.style.backgroundColor = "#1f1f1f";
            footer.style.color = "#f1f1f1";
        }

        if (main) {
            main.style.backgroundColor = "#1f1f1f";
            main.style.color = "#f1f1f1";
        }

        if (nav) {
            nav.style.backgroundColor = "#333";
            nav.style.color = "#f1f1f1";
        }

        links.forEach(function(link) {
            link.style.color = "#ffffff";
        });

        // Zmiana etykiety przycisku na "Tryb Dzienny"
        button.textContent = "Tryb Dzienny";

        isNightMode = true;
    }
}
