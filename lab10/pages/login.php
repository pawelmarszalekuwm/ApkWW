<?php
include('../includes/auth.php');

// Sprawdzenie, czy formularz logowania został przesłany
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Próba zalogowania
    if (login($username, $password)) {
        header("Location: index.php"); // Przekierowanie na stronę główną
        exit(); // Zakończ dalsze wykonywanie kodu
    } else {
        $error = "Nieprawidłowe dane logowania!";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Logowanie</h1>

        <!-- Wyświetlenie błędu, jeśli wystąpił -->
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Formularz logowania -->
        <form method="POST">
            <input type="text" name="username" placeholder="Nazwa użytkownika" required>
            <input type="password" name="password" placeholder="Hasło" required>
            <button type="submit" name="login">Zaloguj</button>
        </form>
    </div>
</body>
</html>
