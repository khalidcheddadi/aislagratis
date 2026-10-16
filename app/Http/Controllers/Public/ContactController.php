<?php

namespace App\Http\Controllers\Public;

use App\Actions\Notifications\SaveCookieConsentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\SaveCookieConsentRequest;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function saveCookieConsent(
        SaveCookieConsentRequest $request,
        SaveCookieConsentAction $action,
    ): JsonResponse {
        $consent = $action->execute($request->validated());

        return response()->json([
            'success' => true,
            'country' => $consent->country,
            'city' => $consent->city,
        ]);
    }
}
