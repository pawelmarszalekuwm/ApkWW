<?php

include '../cfg.php';
// Funkcja do wyświetlania formularza kontaktowego
function PokazKontakt() {
    // Formularz kontaktowy HTML
    $formularz = '
    <form action="admin.php?action=wyslij_kontakt" method="POST">
        <label for="email">Twój e-mail:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="temat">Temat wiadomości:</label><br>
        <input type="text" id="temat" name="temat" required><br><br>
        
        <label for="tresc">Treść wiadomości:</label><br>
        <textarea id="tresc" name="tresc" rows="5" required></textarea><br><br>
        
        <input type="submit" value="Wyślij">
    </form>';

    return $formularz;
}

// Funkcja do wysyłania e-maila
function WyslijMailKontakt() {
    // Sprawdzamy, czy formularz został wysłany
    if (isset($_POST['wyslij'])) {
        $odbiorca = $_POST['adresat'];   // Pobranie adresata
        $temat = $_POST['temat'];        // Pobranie tematu
        $tresc = $_POST['tresc'];        // Pobranie treści wiadomości

        // Nagłówki wiadomości (od kogo)
        $naglowek = "From: ziomowow@gmail.com";

        // Wysłanie wiadomości
        $chek = mail($odbiorca, $temat, $tresc, $naglowek);

        if ($chek) {
            echo "Wiadomość została wysłana.";
        } else {
            echo "Błąd w wysyłaniu wiadomości.";
        }
    }
    // Formularz do wysyłania wiadomości
    echo '
    <form method="post" action="">
        <label for="adresat">Adresat:</label>
        <input type="email" name="adresat" id="adresat" required><br><br>

        <label for="temat">Temat:</label>
        <input type="text" name="temat" id="temat" required><br><br>

        <label for="tresc">Treść wiadomości:</label><br>
        <textarea name="tresc" id="tresc" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" name="wyslij" value="Wyślij wiadomość">
    </form>';
}



function PrzypomnijHaslo($odbiorca) {
    global $cfg_pass;

    // Treść wiadomości
    $temat = "Przypomnienie hasła do panelu admina";
    $tresc = "Oto twoje hasło: " . $cfg_pass;  // Poprawione łączenie ciągów

    // Nagłówki wiadomości (od kogo)
    $naglowek = "From: ziomowow@gmail.com";

    // Wysłanie wiadomości
    $chek = mail($odbiorca, $temat, $tresc, $naglowek);
if($chek)
{
    echo "wysłano";
}
else
{
    echo "Błąd w wysłaniu wiadmości  ";
}
}


?>