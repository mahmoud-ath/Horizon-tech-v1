<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Theme;
use App\Models\Issues;
use App\Models\Subscription;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ModeratorDashboardController extends Controller
{
    public function dashboard()
    {


// Get the current logged-in user's ID
$currentUserId = Auth::id();

// Count the number of articles for themes associated with the current user
$articlesCount = Article::join('themes', 'articles.theme_id', '=', 'themes.id')
    ->where('themes.user_id', $currentUserId)
    ->count();




        // Count the number of subscriptions for themes associated with the current user
        $subscriberCount = Subscription::join('themes', 'subscriptions.theme_id', '=', 'themes.id')
            ->where('themes.user_id', $currentUserId)
            ->count();


// Count the number of conversations for articles related to the theme associated with the current user
$conversationsCount = Chat::join('articles', 'chats.article_id', '=', 'articles.id')
    ->join('themes', 'articles.theme_id', '=', 'themes.id')
    ->where('themes.user_id', $currentUserId)
    ->count();

        return view('responsable.moderatordashboard', compact('articlesCount', 'subscriberCount', 'conversationsCount'));
    }
}
