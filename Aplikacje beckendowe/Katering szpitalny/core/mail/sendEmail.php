<?php
// obsługije wysyłanie emaili na adres email zapisanym w bazie danych do usera, trzeba najpierw w pliku php pobrać go dla odczytu
// i jak na razie obsługuje tylko 2fa wysyłke emaili lecz jest tu parametr type dzięki temu można swobodnie rozszerzać moduł o inne interakcjie wysyłania dancyh


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../lib/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../../lib/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../lib/PHPMailer-master/src/SMTP.php';

function sendEmail($to, $name, $type, $code)
{
    $mailConfig = require __DIR__ . '/../config/mail.php';

    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $mailConfig['username'];
        $mail->Password   = $mailConfig['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
        $mail->addAddress($to, $name);

        $mail->isHTML(true);

        if ($type === '2fa') {
            $mail->Subject = 'Kod weryfikacyjny logowania';
            $mail->Body = '
                <div style="font-family: Arial, sans-serif; font-size: 16px; color: #222;">
                    <p>Witaj ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . ',</p>
                    <p>Twój kod weryfikacyjny to:</p>
                    <p style="font-size: 28px; font-weight: bold; letter-spacing: 3px;">' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '</p>
                    <p>Kod jest ważny przez 5 minut.</p>
                </div>
            ';
            $mail->AltBody = "Witaj {$name}, Twój kod weryfikacyjny to: {$code}. Kod jest ważny przez 5 minut.";
        } else {
            $mail->Subject = 'Wiadomość systemowa';
            $mail->Body    = '<p>Brak szablonu wiadomości.</p>';
            $mail->AltBody = 'Brak szablonu wiadomości.';
        }

        return $mail->send();
    } catch (\Throwable $e) {
        return false;
    }
}