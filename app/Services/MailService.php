<?php

namespace App\Services;

use App\Models\ContactMessage;
use App\Models\MessageReply;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailService
{
    private function mailer(): PHPMailer
    {
        $mailerDriver = Setting::get('mail_mailer', 'smtp');
        $host         = Setting::get('mail_host', '127.0.0.1');
        $port         = (int) Setting::get('mail_port', 25);
        $username     = Setting::get('mail_username') ?: '';
        $password     = Setting::get('mail_password') ?: '';
        $encryption   = Setting::get('mail_encryption') ?: '';
        $fromAddr     = Setting::get('mail_from_address', 'hello@imkyra.be');
        $fromName     = Setting::get('mail_from_name', 'KYRA');
        $verifySsl    = Setting::get('mail_verify_ssl', true); // returns bool via Setting model

        $mail = new PHPMailer(true);

        if ($mailerDriver === 'log') {
            // In log mode we still build the mailer, caller should handle output separately
            $mail->isMail(); // won't actually send; caller catches exception and logs
        } else {
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->Port = $port;

            // Auth
            if ($username !== '') {
                $mail->SMTPAuth   = true;
                $mail->Username   = $username;
                $mail->Password   = $password;
            }

            // Encryption
            if ($encryption === 'ssl' || $port === 465) {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($encryption === 'tls' || $port === 587) {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->SMTPSecure = '';
                $mail->SMTPAutoTLS = false;
            }

            // SSL certificate verification
            if (! $verifySsl) {
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true,
                    ],
                ];
            }
        }

        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->setFrom($fromAddr, $fromName);

        return $mail;
    }

    /**
     * Send a plain-text test email.
     */
    public function sendRaw(string $to, string $subject, string $body): void
    {
        $mail = $this->mailer();
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->isHTML(false);
        $mail->send();
    }

    /**
     * Send the contact notification email.
     */
    public function sendContactNotification(ContactMessage $contact): void
    {
        $prefix  = Setting::get('notification_subject', '[KYRA] Nouveau message');
        $mailTo  = Setting::get('mail_to', 'hello@imkyra.be');
        $mailCc  = Setting::get('mail_cc') ?: null;

        $html = View::make('mail.contact-received', ['contactMessage' => $contact])->render();

        $mail = $this->mailer();
        $mail->addAddress($mailTo);
        if ($mailCc) {
            $mail->addCC($mailCc);
        }
        $mail->addReplyTo($contact->email, $contact->name);
        $mail->Subject = $prefix . ' : ' . $contact->subject;
        $mail->isHTML(true);
        $mail->Body    = $html;
        $mail->AltBody = strip_tags($html);
        $mail->send();
    }

    /**
     * Send an admin reply to the original contact sender.
     */
    public function sendReply(ContactMessage $contact, MessageReply $reply): void
    {
        $fromAddr = Setting::get('mail_from_address', 'hello@imkyra.be');
        $fromName = Setting::get('mail_from_name', 'KYRA');

        $html = View::make('mail.reply', [
            'contact' => $contact,
            'reply'   => $reply,
        ])->render();

        $mail = $this->mailer();
        $mail->addAddress($contact->email, $contact->name);
        $mail->setFrom($fromAddr, $fromName);
        $mail->Subject = $reply->subject;
        $mail->isHTML(true);
        $mail->Body    = $html;
        $mail->AltBody = strip_tags($reply->body);

        foreach ($reply->attachments as $attachment) {
            $fullPath = storage_path('app/' . $attachment->path);
            if (file_exists($fullPath)) {
                $mail->addAttachment($fullPath, $attachment->original_name);
            }
        }

        $mail->send();
    }
}

