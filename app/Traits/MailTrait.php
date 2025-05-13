<?php

namespace App\Traits;

use PHPMailer\PHPMailer\PHPMailer;

trait MailTrait
{

    /**
     * Envia e-mails. Para verificá-los, acesse http://localhost:8025
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param string|null $from
     * @return bool
     */
    public function sendMail(string $to, string $subject, string $body, string $from = null): bool
    {
        $mail = new PHPMailer(true);

        try {

            // Envio via SMTP para MailHog
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->Port = $_ENV['SMTP_PORT'];
            $mail->SMTPAuth = false;

            $mail->CharSet = 'UTF-8';
            $mail->setFrom($from ?? 'no-reply@test.com', 'Sistema');
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->isHTML();

            return $mail->send();

        } catch (\Exception $e) {
            // Não queremos disparar nada caso tenha falha
            return false;
        }
    }
}
