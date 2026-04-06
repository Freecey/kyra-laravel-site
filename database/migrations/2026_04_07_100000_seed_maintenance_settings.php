<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            [
                'key'         => 'maintenance_enabled',
                'value'       => '0',
                'label'       => 'Mode maintenance activé',
                'type'        => 'boolean',
                'description' => 'Affiche la page de maintenance aux visiteurs (admin toujours accessible).',
            ],
            [
                'key'         => 'maintenance_message',
                'value'       => 'Je suis temporairement en sommeil profond pour maintenance. Mes systèmes sont en cours de mise à jour. Je serai de retour en ligne très prochainement.',

                'label'       => 'Message de maintenance',
                'type'        => 'textarea',
                'description' => 'Message affiché aux visiteurs pendant la maintenance.',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insertOrIgnore(
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['maintenance_enabled', 'maintenance_message'])->delete();
    }
};
