
<?php
// contact.php - PHP script for a simple contact and password reminder system

// 1. ShowContact - Display a contact form
function PokazKontakt() {
    echo '<form method="post" action="contact.php">
            <label for="name">Imię:</label>
            <input type="text" id="name" name="name" required><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            
            <label for="message">Wiadomość:</label><br>
            <textarea id="message" name="message" required></textarea><br>
            
            <input type="submit" name="submit_contact" value="Wyślij">
          </form>';
}

// 2. SendMailContact - Send an email based on form input
function WyslijMailKontakt() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
        $to = 'admin@example.com'; // Replace with your email
        $subject = 'Nowa wiadomość z formularza kontaktowego';
        $message = "Imię: {$_POST['name']}
Email: {$_POST['email']}
Wiadomość:
{$_POST['message']}";
        $headers = 'From: ' . $_POST['email'];
        
        if (mail($to, $subject, $message, $headers)) {
            echo 'Wiadomość została wysłana.';
        } else {
            echo 'Błąd podczas wysyłania wiadomości.';
        }
    }
}

// 3. RemindPassword - Simplified password reminder functionality
function PrzypomnijHaslo() {
    $to = 'admin@example.com'; // Replace with your email
    $subject = 'Przypomnienie hasła';
    $message = 'Twoje hasło to: [przykładowe_hasło]'; // Replace with actual password retrieval logic
    $headers = 'From: noreply@example.com';
    
    if (mail($to, $subject, $message, $headers)) {
        echo 'Przypomnienie hasła zostało wysłane.';
    } else {
        echo 'Błąd podczas wysyłania przypomnienia hasła.';
    }
}

// Handle form submissions
if (isset($_POST['submit_contact'])) {
    WyslijMailKontakt();
}
?>
