<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

class LegalController extends Controller
{
    public function privacy(): View
    {
        return ViewFacade::make('public.legal.privacy');
    }

    public function terms(): View
    {
        return ViewFacade::make('public.legal.terms');
    }

    public function cookies(): View
    {
        return ViewFacade::make('public.legal.cookies');
    }
}
