<?php
namespace App\Helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class Email
{
    public static function envoyerEmailTransaction($email, $nom, $type, $desc, $montant, $date)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'lovasoa.alexis@gmail.com';
            $mail->Password   = 'ponf xhzc gjud wger'; // mot de passe d'application Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('cashtrack@gmail.com', 'CashTrack');
            $mail->addAddress($email, $nom);

            $mail->isHTML(true);
            $mail->Subject = "Débit effectué sur votre compte CashTrack";
            $mail->Body = "
                <p>Bonjour <b>$nom</b>,</p>
                <p>Une transaction de type <b>$type</b> a été enregistrée sur votre compte :</p>
                <ul>
                    <li><b>Description :</b> $desc</li>
                    <li><b>Montant :</b> " . number_format($montant, 0, ',', ' ') . " Ar</li>
                    <li><b>Date :</b> $date</li>
                </ul>
                <p>Merci d’utiliser <b>CashTrack</b> 💰</p>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Erreur PHPMailer: " . $mail->ErrorInfo);
            return false;
        }
    }
}
