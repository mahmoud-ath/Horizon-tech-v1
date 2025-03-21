<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class UserArticleController extends Controller
{
    public function myArticles()
    {
        $articles = Article::where('user_id', Auth::id())->get(); // Get only the logged-in user's articles
        return view('user.myarticle', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        $themeId = $article->theme_id; // Assuming that the article has a theme_id field
        return redirect()->route('article.show', ['themeId' => $themeId, 'articleId' => $id]);
    }

    public function update(Request $request, $id)
{
    $article = Article::findOrFail($id);
    $article->title = $request->input('title');
    $article->content = $request->input('content');

    $article->save();

    return redirect()->route('user.myarticles')->with('success', 'Article updated successfully');
}
}
