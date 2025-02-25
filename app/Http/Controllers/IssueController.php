<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issues;
use App\Models\Article;
use App\Models\Chat;

class IssueController extends Controller
{
    public function index()
    {
        $issues = Issues::all();
        return view('accueil.firstpage', compact('issues'));
    }

    public function showArticlesByIssue($issue_id)
    {
        $issue = Issues::findOrFail($issue_id);
        $articles = Article::where('issue_id', $issue_id)->get();
        return view('gestion des articles.numbers', compact('issue', 'articles'));
    }

    public function showArticle($issue_id, $article_id)
    {
        $issue = Issues::findOrFail($issue_id);
        $article = Article::where('id', $article_id)->where('issue_id', $issue_id)->firstOrFail();
        $comments = Chat::where('article_id', $article_id)->get();
        return view('gestion des articles.article', compact('issue', 'article', 'comments'));
    }
}
