<?php

namespace App\Http\Controllers\Customer;

use App\Enums\InstallationStatus;
use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = $request->user()->reviews()
            ->with('installation.service')
            ->latest()
            ->get();
        $pendingInstallations = $request->user()->installations()
            ->with('service:id,name')
            ->where('status', InstallationStatus::COMPLETED)
            ->whereDoesntHave('reviews', fn ($query) => $query->where('user_id', $request->user()->id))
            ->latest('installation_date')
            ->get();

        return view('customer.reviews.index', compact('reviews', 'pendingInstallations'));
    }

    public function store(Request $request, Installation $installation)
    {
        abort_unless($installation->user_id === $request->user()->id, 403);
        abort_unless($installation->status === InstallationStatus::COMPLETED, 403);
        abort_if($installation->reviews()->where('user_id', $request->user()->id)->exists(), 403);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        Review::create([
            'user_id' => $request->user()->id,
            'installation_id' => $installation->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'],
            'is_approved' => false,
        ]);

        return back()->with('success', '¡Gracias por tu valoración! Será revisada pronto.');
    }
}
