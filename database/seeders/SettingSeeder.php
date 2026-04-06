<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // ─── Serveur mail ─────────────────────────────────────────────
            [
                'key'         => 'mail_mailer',
                'value'       => 'smtp',
                'label'       => 'Protocole mail',
                'type'        => 'text',
                'description' => 'smtp, sendmail ou log (test)',
            ],
            [
                'key'         => 'mail_host',
                'value'       => '127.0.0.1',
                'label'       => 'Hôte SMTP',
                'type'        => 'text',
                'description' => 'Serveur SMTP — 127.0.0.1 pour ISPConfig local',
            ],
            [
                'key'         => 'mail_port',
                'value'       => '25',
                'label'       => 'Port SMTP',
                'type'        => 'text',
                'description' => '25 (local sans auth), 587 (TLS), 465 (SSL)',
            ],
            [
                'key'         => 'mail_username',
                'value'       => '',
                'label'       => 'Utilisateur SMTP',
                'type'        => 'text',
                'description' => 'Laisser vide pour serveur local sans authentification',
            ],
            [
                'key'         => 'mail_password',
                'value'       => '',
                'label'       => 'Mot de passe SMTP',
                'type'        => 'password',
                'description' => 'Laisser vide pour serveur local sans authentification',
            ],
            [
                'key'         => 'mail_encryption',
                'value'       => '',
                'label'       => 'Chiffrement',
                'type'        => 'text',
                'description' => 'tls, ssl ou vide (aucun — pour localhost port 25)',
            ],
            [
                'key'         => 'mail_verify_ssl',
                'value'       => '1',
                'label'       => 'Vérifier le certificat SSL',
                'type'        => 'boolean',
                'description' => 'Désactiver pour les certificats auto-signés',
            ],
            [
                'key'         => 'mail_from_address',
                'value'       => 'hello@imkyra.be',
                'label'       => 'Adresse expéditeur',
                'type'        => 'email',
                'description' => 'Adresse email affichée comme expéditeur',
            ],
            [
                'key'         => 'mail_from_name',
                'value'       => 'KYRA',
                'label'       => 'Nom expéditeur',
                'type'        => 'text',
                'description' => 'Nom affiché dans le champ "De" des emails',
            ],
            // ─── Notifications ────────────────────────────────────────────
            [
                'key'         => 'mail_to',
                'value'       => 'hello@imkyra.be',
                'label'       => 'Adresse de réception',
                'type'        => 'email',
                'description' => 'Email destinataire des notifications de contact',
            ],
            [
                'key'         => 'mail_cc',
                'value'       => null,
                'label'       => 'CC',
                'type'        => 'email',
                'description' => 'Email en copie (optionnel)',
            ],
            [
                'key'         => 'notification_subject',
                'value'       => '[KYRA] Nouveau message',
                'label'       => 'Préfixe objet email',
                'type'        => 'text',
                'description' => 'Préfixe ajouté à l\'objet de chaque email de notification',
            ],
            [
                'key'         => 'form_enabled',
                'value'       => '1',
                'label'       => 'Formulaire de contact actif',
                'type'        => 'boolean',
                'description' => 'Active ou désactive le formulaire de contact',
            ],
            [
                'key'         => 'form_success_message',
                'value'       => 'Message envoyé ! Je vous répondrai dès que possible.',
                'label'       => 'Message de succès',
                'type'        => 'text',
                'description' => 'Message affiché au visiteur après envoi du formulaire',
            ],
        ];

        foreach ($defaults as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
