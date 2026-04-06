<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Override mail configuration from DB settings at runtime
        // Note: actual sending is handled by App\Services\MailService (PHPMailer)
        // This block keeps Laravel's Mail facade in sync for any other usage.
        try {
            $mailer     = \App\Models\Setting::get('mail_mailer', 'smtp');
            $host       = \App\Models\Setting::get('mail_host', '127.0.0.1');
            $port       = (int) \App\Models\Setting::get('mail_port', 25);
            $username   = \App\Models\Setting::get('mail_username') ?: null;
            $password   = \App\Models\Setting::get('mail_password') ?: null;
            $encryption = \App\Models\Setting::get('mail_encryption') ?: null;
            $fromAddr   = \App\Models\Setting::get('mail_from_address', 'hello@imkyra.be');
            $fromName   = \App\Models\Setting::get('mail_from_name', 'KYRA');

            Config::set([
                'mail.default'                       => $mailer,
                'mail.mailers.smtp.host'             => $host,
                'mail.mailers.smtp.port'             => $port,
                'mail.mailers.smtp.username'         => $username,
                'mail.mailers.smtp.password'         => $password,
                'mail.mailers.smtp.encryption'       => $encryption,
                'mail.mailers.smtp.timeout'          => 10,
                'mail.from.address'                  => $fromAddr,
                'mail.from.name'                     => $fromName,
            ]);
        } catch (\Throwable) {
            // Settings table may not exist yet (before first migration)
        }
    }
}
