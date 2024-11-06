<?php
$imie = "asd";
 $nr_indeksu = '169335';
 $nrGrupy = '4';
 echo 'Autor: Paweł Marszałek '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';

 echo' Metoda include';
 include('header.html');
 echo('metoda require_once');
 require_once('footer.html');

 echo 'Warunki if, else, elseif, switch <br />';
 $wartosc = date('d');
 echo $wartosc;
 if ($wartosc < 10) {
    echo 'Wartość jest mniejsza niż 10.<br />';
 } elseif ($wartosc < 20) {
    echo 'Wartość jest między 10 a 20.<br />';
 } else {
    echo 'Wartość jest większa niż 20.<br />';
 }

 $kolor = 'zielony';
 switch ($kolor) {
    case 'czerwony':
        echo 'Kolor to czerwony.<br />';
        break;
    case 'zielony':
        echo 'Kolor to zielony.<br />';
        break;
    default:
        echo 'Kolor jest inny.<br />';
        break;
 }

 echo '<br />Zadanie 2c: Pętla while() i for() <br />';
 $licznik = 0;
 while ($licznik < 5) {
    echo 'Licznik: ' . $licznik . '<br />';
    $licznik++;
 }

 for ($i = 0; $i < 5; $i++) {
    echo 'Iteracja for: ' . $i . '<br />';
 }


echo '<br />Zadanie 2d: Typy zmiennych $_GET, $_POST, $_SESSION <br />';
echo '<form method="GET">
    Wpisz swoje imię: <input type="text" name="imie" />
    <input type="submit" value="Wyślij" />
</form>';
if (isset($_GET['imie'])) {
    echo 'Wartość przekazana przez GET: ' . htmlspecialchars($_GET['imie']) . '<br />';
}

echo '<form method="POST">
    Wpisz swoje imię: <input type="text" name="imie" />
    <input type="submit" value="Wyślij" />
</form>';
if (isset($_POST['imie'])) {
    echo 'Wartość przekazana przez POST: ' . htmlspecialchars($_POST['imie']) . '<br />';
}

session_start();
if (!isset($_SESSION['odwiedziny'])) {
    $_SESSION['odwiedziny'] = 1;
} else {
    $_SESSION['odwiedziny']++;
}
echo 'Liczba odwiedzin: ' . $_SESSION['odwiedziny'] . '<br />';
?>
 