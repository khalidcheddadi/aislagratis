<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemap = Sitemap::create()
            ->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency('weekly'))
            ->add(Url::create(route('services.index'))->setPriority(0.9))
            ->add(Url::create(route('about'))->setPriority(0.8))
            ->add(Url::create(route('faq'))->setPriority(0.7))
            ->add(Url::create(route('coverage'))->setPriority(0.6))
            ->add(Url::create(route('leads.create'))->setPriority(0.95))
            ->add(Url::create(route('legal.privacy'))->setPriority(0.3))
            ->add(Url::create(route('legal.terms'))->setPriority(0.3));

        Service::active()->get()->each(function ($service) use ($sitemap) {
            $sitemap->add(
                Url::create(route('services.show', $service))
                    ->setLastModificationDate($service->updated_at)
                    ->setPriority(0.85)
            );
        });

        return response($sitemap->render(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function robots(): Response
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /mi-cuenta/\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "Disallow: /gracias\n";
        $content .= "Disallow: /api/\n\n";
        $content .= 'Sitemap: '.url('/sitemap.xml')."\n";

        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
