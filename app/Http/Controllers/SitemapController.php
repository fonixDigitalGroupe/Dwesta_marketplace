<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        // Pages statiques principales
        $urls[] = ['loc' => url('/'), 'priority' => '1.0', 'freq' => 'daily'];
        foreach (['about', 'terms', 'privacy', 'help', 'contact'] as $named) {
            if (\Route::has($named)) {
                $urls[] = ['loc' => route($named), 'priority' => '0.4', 'freq' => 'monthly'];
            }
        }

        // Catégories actives
        Category::where('actif', true)->get()->each(function ($c) use (&$urls) {
            $urls[] = ['loc' => route('categories.show', $c->slug), 'priority' => '0.7', 'freq' => 'weekly'];
        });

        // Annonces publiées
        Annonce::where('statut', Annonce::STATUT_PUBLIEE)
            ->select('slug', 'updated_at')
            ->orderByDesc('updated_at')
            ->limit(5000)
            ->get()
            ->each(function ($a) use (&$urls) {
                $urls[] = [
                    'loc'     => route('annonces.show', $a->slug),
                    'lastmod' => optional($a->updated_at)->toAtomString(),
                    'priority' => '0.6',
                    'freq'    => 'weekly',
                ];
            });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            if (!empty($u['lastmod'])) {
                $xml .= "    <lastmod>" . $u['lastmod'] . "</lastmod>\n";
            }
            $xml .= "    <changefreq>" . $u['freq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $u['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
