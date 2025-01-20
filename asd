    echo '<form method="post" action="admin.php?action=remind_password">
          <input type="submit" value="Przypomnij hasło">
        </form>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action']) && $_GET['action'] === 'remind_password') {
        PrzypomnijHaslo("s-a49@wp.pl"); // Wyślij przypomnienie hasła
        exit;
    }

    $login = $_POST['login'] ?? '';
    $pass = $_POST['pass'] ?? '';

    if ($login === $cfg_login && $pass === $cfg_pass) {
        $_SESSION['zalogowany'] = true;
    } else {
        FormularzLogowania('Nieprawidłowy login lub hasło.');
        exit;
    }
}

if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] !== true) {
    FormularzLogowania();
    exit;
}


if (isset($_GET['akcja']) && $_GET['akcja'] === 'wyloguj') {
    session_start();
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit;
}
