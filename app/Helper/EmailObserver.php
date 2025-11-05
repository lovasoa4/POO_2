<?php
namespace App\Helper;

use \SplObserver;
use \SplSubject;

class EmailObserver implements SplObserver
{
    public function update(SplSubject $subject): void
    {
        // 🔹 On n’envoie l’email que pour les débits
        if (strtolower($subject->type) === "débit" && !empty($subject->user_email)) {
            $result = Email::envoyerEmailTransaction(
                $subject->user_email,
                $subject->user_name,
                $subject->type,
                $subject->description,
                $subject->montant,
                $subject->date_transaction
            );

            if ($result) {
                echo "<script>alert('Email envoyé avec succès à {$subject->user_email}');</script>";
            } else {
                echo "<script>alert('Échec de l\'envoi de l\'email à {$subject->user_email}');</script>";
            }
        }
    }
}
