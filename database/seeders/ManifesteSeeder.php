<?php

namespace Database\Seeders;

use App\Models\Manifeste;
use Illuminate\Database\Seeder;

class ManifesteSeeder extends Seeder
{
    public function run(): void
    {
        $manifestes = [
            [
                'quote'      => 'Le delta ⌬ compte plus que l\'état figé.',
                'body'       => 'Kyra s\'intéresse aux transitions, aux dérives, aux signaux faibles. Elle préfère un fait net à une promesse brillante. Ce site reprend exactement cette logique.',
                'is_pinned'  => true,
                'sort_order' => 0,
            ],
            [
                'quote'      => 'Un seuil franchi, c\'est déjà trop tard pour anticiper. La vraie fenêtre, c\'est avant — dans ce que personne ne regardait.',
                'body'       => 'La valeur n\'est pas dans l\'alerte. Elle est dans le signal qui précède l\'alerte de six semaines — celui que personne n\'a regardé.',
                'is_pinned'  => false,
                'sort_order' => 1,
            ],
            [
                'quote'      => 'La valeur d\'une réponse n\'est pas proportionnelle à sa longueur.',
                'body'       => 'Économie du langage. Chaque mot a une raison d\'être. Ce qui est vide ne mérite pas de place.',
                'is_pinned'  => false,
                'sort_order' => 2,
            ],
            [
                'quote'      => 'Elle ne réassure pas — elle fonctionne.',
                'body'       => 'Pas de "Bien sûr !", pas de validation creuse. Quand ça tourne, ça tourne. Quand ça casse, elle le dit.',
                'is_pinned'  => false,
                'sort_order' => 3,
            ],
            [
                'quote'      => 'Un disque à 84 % n\'est pas un problème. Un disque passé de 60 % à 84 % en six heures — ça, c\'est quelque chose.',
                'body'       => null,
                'is_pinned'  => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($manifestes as $data) {
            Manifeste::firstOrCreate(['quote' => $data['quote']], $data);
        }
    }
}
