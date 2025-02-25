<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Theme;
use App\Models\Issues;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminArticleController extends Controller
{
    public function index()
    {
        try {
            $articles = Article::with('theme')->get();
            $themes = Theme::all();
            $issues = Issues::all(); // Fetch all issues

            return view('admin.manage-articles', compact('articles', 'themes','issues'));
        } catch (\Exception $e) {
            Log::error('Error fetching articles and themes: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching articles and themes.');
        }
    }

    public function switchStatus($id)
    {
        $article = Article::find($id);
        if ($article) {
            $article->status = ($article->status === 'published') ? 'pending' : 'published';
            $article->save();
        }
        return redirect()->back()->with('success', 'Article status switched successfully.');
    }

    public function remove($id)
    {
        $article = Article::find($id);
        if ($article) {
            // Delete related records in the history table
            DB::table('history')->where('article_id', $id)->delete();
            
            // Now delete the article
            $article->delete();
        }
        return redirect()->back()->with('success', 'Article removed successfully.');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        $themeId = $article->theme_id; // Assuming that the article has a theme_id field
        return redirect()->route('article.show', ['themeId' => $themeId, 'articleId' => $id]);
    }

    public function assignIssue(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'issue_id' => 'required|exists:issues,id',
        ]);

        $article = Article::find($request->article_id);
        $issue = Issues::find($request->issue_id);

        // Assuming you have a relationship set up between Article and Issue
        $article->issue()->associate($issue);
        $article->save();

        return redirect()->back()->with('success', 'Article assigned to issue successfully.');
    }
}
