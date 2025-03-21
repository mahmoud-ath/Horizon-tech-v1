<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class UserSubscriptionController extends Controller
{
    public function indexsub()
    {
        // Fetch all themes and the user's subscription status
        $themes = Theme::all()->map(function ($theme) {
            $theme->status = $theme->subscriptions()->where('user_id', Auth::id())->exists();
            return $theme;
        });

        return view('user.subscriptions', compact('themes'));
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
