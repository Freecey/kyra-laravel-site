<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Pages statiques du site avec leur priorité et fréquence de mise à jour.
     */
    private array $pages = [
        [
            'route'    => 'home',
            'priority' => '1.0',
            'freq'     => 'weekly',
        ],
        [
            'route'    => 'about',
            'priority' => '0.8',
            'freq'     => 'monthly',
        ],
        [
            'route'    => 'signal',
            'priority' => '0.7',
            'freq'     => 'monthly',
        ],
        [
            'route'    => 'protocole',
            'priority' => '0.7',
            'freq'     => 'monthly',
        ],
        [
            'route'    => 'contact',
            'priority' => '0.6',
            'freq'     => 'yearly',
        ],
    ];

    public function index(): Response
    {
        $pages = array_map(function (array $page) {
            return array_merge($page, [
                'url'     => route($page['route']),
                'lastmod' => now()->toAtomString(),
            ]);
        }, $this->pages);

        $content = view('sitemap', compact('pages'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=86400');
    }
}
