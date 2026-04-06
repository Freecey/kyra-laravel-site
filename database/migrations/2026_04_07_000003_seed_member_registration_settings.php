<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = [
            [
                'key'         => 'member_registration_enabled',
                'value'       => '1',
                'label'       => 'Activer les inscriptions membres',
                'type'        => 'boolean',
                'description' => 'Si désactivé, le formulaire d\'inscription est remplacé par un message',
            ],
            [
                'key'         => 'member_registration_disabled_message',
                'value'       => 'Les inscriptions sont temporairement fermées. Revenez bientôt.',
                'label'       => 'Message affiché si inscriptions désactivées',
                'type'        => 'text',
                'description' => '',
            ],
            [
                'key'         => 'member_registration_approval',
                'value'       => 'auto',
                'label'       => 'Mode d\'activation des nouveaux comptes',
                'type'        => 'text',
                'description' => 'auto = immédiat, email = vérification email, admin = approbation admin',
            ],
        ];

        foreach ($rows as $row) {
            if (! DB::table('settings')->where('key', $row['key'])->exists()) {
                DB::table('settings')->insert(array_merge($row, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'member_registration_enabled',
            'member_registration_disabled_message',
            'member_registration_approval',
        ])->delete();
    }
};
