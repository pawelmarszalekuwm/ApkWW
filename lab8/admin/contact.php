<?php

function FormularzKontaktowy() {
    // Formularz HTML
    echo '<form method="post">
        <label>Adresat: <input type="email" name="adresat" required></label><br>
        <label>Temat: <input type="text" name="temat" required></label><br>
        <label>Treść: <textarea name="tresc" required></textarea></label><br>
        <button type="submit" name="wyslij_kontakt">Wyślij wiadomość</button>
    </form>';
}

function WyslijMailKontakt() {
    // Sprawdzamy, czy formularz został wysłany
    if (isset($_POST['wyslij_kontakt'])) {
        $odbiorca = $_POST['adresat'];   // Pobranie adresata
        $temat = $_POST['temat'];        // Pobranie tematu
        $tresc = $_POST['tresc'];        // Pobranie treści wiadomości

        // Walidacja danych
        if (empty($odbiorca) || empty($temat) || empty($tresc)) {
            echo "Wszystkie pola muszą być wypełnione.<br>";
        } else {
            // Nagłówki wiadomości (od kogo)
            $naglowek = "From: ziomowow@gmail.com";

            // Wysłanie wiadomości
            $chek = mail($odbiorca, $temat, $tresc, $naglowek);

            if ($chek) {
                echo "Wiadomość została wysłana.<br>";
                return; // Nie wyświetlamy formularza po wysłaniu wiadomości
            } else {
                echo "Błąd w wysyłaniu wiadomości. Spróbuj ponownie.<br>";
            }
        }
    }

    // Wyświetlenie formularza, jeśli wiadomość nie została wysłana
    FormularzKontaktowy();
}





function PrzypomnijHaslo($odbiorca) {
    global $pass;
    // Treść wiadomości
    $temat = "Przypomnienie hasła do panelu admina";
    $tresc = "Oto twoje hasło: " . $pass;  // Poprawione łączenie ciągów

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