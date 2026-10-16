<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CoverageArea;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View as ViewFacade;

class HomeController extends Controller
{
    public function index(): View
    {
        $areas = Cache::remember(
            'home.page.coverage-areas',
            now()->addHour(),
            fn () => CoverageArea::covered()->get()
        );

        return ViewFacade::make('public.home', compact('areas'));
    }

    public function coverage(): View
    {
        $areas = Cache::remember('coverage.areas.all', now()->addDay(), fn () => CoverageArea::covered()->get()->groupBy('province')
        );

        return ViewFacade::make('public.coverage', compact('areas'));
    }
}
