<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    public function index()
    {
        // Fetch themes with a count of only the published articles
        $themes = Theme::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])->get()->map(function ($theme) {
            // Add subscription status
            $theme->isSubscribed = $theme->subscriptions()->where('user_id', Auth::id())->exists();
            return $theme;
        });

        // Return the view with themes data
        return view('gestion des articles.themes', compact('themes'));
    }

    public function toggleSubscription(Request $request)
    {
        $themeId = $request->input('theme');
        $userId = Auth::id();

        $theme = Theme::findOrFail($themeId);

        if ($theme->subscriptions()->where('user_id', $userId)->exists()) {
            // If already subscribed, unsubscribe
            $theme->subscriptions()->where('user_id', $userId)->delete();
        } else {
            // If not subscribed, subscribe
            $theme->subscriptions()->create(['user_id' => $userId]);
        }

        return response()->json(['success' => true]);
    }
}
