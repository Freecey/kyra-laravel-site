<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Manifeste;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    private array $staticPages = [
        ['route' => 'home',       'priority' => '1.0', 'freq' => 'weekly'],
        ['route' => 'about',      'priority' => '0.8', 'freq' => 'monthly'],
        ['route' => 'signal',     'priority' => '0.7', 'freq' => 'monthly'],
        ['route' => 'protocole',  'priority' => '0.7', 'freq' => 'monthly'],
        ['route' => 'blog.index', 'priority' => '0.8', 'freq' => 'daily'],
        ['route' => 'manifestes', 'priority' => '0.6', 'freq' => 'weekly'],
        ['route' => 'contact',    'priority' => '0.5', 'freq' => 'yearly'],
    ];

    public function index(): Response
    {
        // lastmod du dernier manifeste actif pour la page /manifestes
        $lastManifeste = Manifeste::active()->orderByDesc('updated_at')->value('updated_at');

        // Pages statiques
        $pages = array_map(fn (array $p) => array_merge($p, [
            'url'     => route($p['route']),
            'lastmod' => ($p['route'] === 'manifestes' && $lastManifeste)
                ? \Carbon\Carbon::parse($lastManifeste)->toAtomString()
                : now()->toAtomString(),
        ]), $this->staticPages);

        // Articles publiés — get() intentionnel : on veut TOUS les posts dans le sitemap
        $posts = BlogPost::published()
            ->select('slug', 'published_at', 'updated_at')
            ->get()
            ->map(fn (BlogPost $post) => [
                'url'      => route('blog.show', $post->slug),
                'lastmod'  => $post->updated_at->toAtomString(),
                'freq'     => 'monthly',
                'priority' => '0.7',
            ])
            ->all();

        $content = view('sitemap', [
            'pages' => $pages,
            'posts' => $posts,
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=86400');
    }
}
