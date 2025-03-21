<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Theme;
use App\Models\Issues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ModeratorArticlesController extends Controller
{
    /**
     * Display a listing of the articles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $articles = Article::whereIn('theme_id', $user->themes->pluck('id'))->get();
        return view('responsable.moderatorarticles', compact('articles'));
    }

    /**
     * Show the article details.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $themeId = $article->theme_id; // Assuming that the article has a theme_id field
        return redirect()->route('article.show', ['themeId' => $themeId, 'articleId' => $id]);
    }

    /**
     * Remove the specified article from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('moderator.articles.index')
            ->with('success', 'Article deleted successfully');
    }

    /**
     * Publish the specified article.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish($id)
    {
        $article = Article::findOrFail($id);
        $article->status = 'Published';
        $article->save();

        return redirect()->route('moderator.articles.index')
            ->with('success', 'Article published successfully');
    }
}
