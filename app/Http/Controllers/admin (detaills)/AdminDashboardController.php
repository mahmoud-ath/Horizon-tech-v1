<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Models\Theme;
use App\Models\Issues;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $totalSubscribers = User::count();
        
        $totalThemes = Theme::count();
        $publicThemes = Theme::where('status', 'Public')->count();
        $privatethemes = Theme::where('status', 'Private')->count();
        
        $totalNumbers = Issues::count();
        $publishedNumbers = Issues::where('status', 'public')->count();
        $privateNumbers = Issues::where('status', 'private')->count();
        
        $totalArticles = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $pendingArticles = Article::where('status', 'pending')->count();
        
        $articles = Article::with('theme')->get();
        $users = User::all();
        $themes = Theme::withCount('articles')->get();
        $issues = Issues::all();

        return view('admin.adminhome', compact(
            'articles',
            'users',
            'themes',
            'totalSubscribers',
            'totalThemes',
            'publicThemes',
            'privatethemes',
            'totalNumbers',
            'publishedNumbers',
            'privateNumbers',
            'totalArticles',
            'publishedArticles',
            'pendingArticles',
            'issues'
        ));
    }
}