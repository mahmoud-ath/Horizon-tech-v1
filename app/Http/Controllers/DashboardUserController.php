<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Issues;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch recommended articles based on user subscriptions (assuming user's subscriptions are related to themes)
        $recommendedArticles = Article::whereHas('theme', function($query) use ($user) {
            $query->whereIn('themes.id', $user->subscriptions->pluck('theme_id'));
        })
        ->where('status', 'published')
        ->orderBy('updated_at', 'desc')
        ->with('theme')
        ->get();

        // Fetch all magazine issues
        $magazineIssues = Issues::all();

        return view('user.dashboarduser', compact('recommendedArticles', 'magazineIssues'));
    }
}
