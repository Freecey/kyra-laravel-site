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
        try {
            $mailer     = \App\Models\Setting::get('mail_mailer', 'smtp');
            $host       = \App\Models\Setting::get('mail_host', '127.0.0.1');
            $port       = (int) \App\Models\Setting::get('mail_port', 25);
            $username   = \App\Models\Setting::get('mail_username') ?: null;
            $password   = \App\Models\Setting::get('mail_password') ?: null;
            $encryption = \App\Models\Setting::get('mail_encryption') ?: null;
            $fromAddr   = \App\Models\Setting::get('mail_from_address', 'hello@imkyra.be');
            $fromName   = \App\Models\Setting::get('mail_from_name', 'KYRA');
            $verifySsl  = \App\Models\Setting::get('mail_verify_ssl', '1');

            $streamOptions = $verifySsl === '1' ? [] : [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

            Config::set([
                'mail.default'                        => $mailer,
                'mail.mailers.smtp.host'              => $host,
                'mail.mailers.smtp.port'              => $port,
                'mail.mailers.smtp.username'          => $username,
                'mail.mailers.smtp.password'          => $password,
                'mail.mailers.smtp.encryption'        => $encryption,
                'mail.mailers.smtp.timeout'           => 10,
                'mail.mailers.smtp.stream'            => $streamOptions,
                'mail.from.address'                   => $fromAddr,
                'mail.from.name'                      => $fromName,
            ]);
        } catch (\Throwable) {
            // Settings table may not exist yet (before first migration)
        }
    }
}
