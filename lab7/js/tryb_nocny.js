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
        body.style.background = "url('https://images.gram.pl/news/fckj20230426083458926owba.jpg') no-repeat center center fixed";
        body.style.backgroundSize = "cover";
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
        body.style.background = "url('https://st.depositphotos.com/3141391/4085/v/450/depositphotos_40851617-stock-illustration-oscar-statue-on-black.jpg') no-repeat center center fixed";
        body.style.backgroundSize = "cover"; // Dostosowanie obrazu do ekranu
        body.style.color = "#ffffff";  // Biały tekst

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
