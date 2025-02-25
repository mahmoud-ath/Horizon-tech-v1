<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Chat;
use App\Models\Rating;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index($themeId)
    {
        $articles = Article::with('user') ->where('status', 'Published')->where('theme_id', $themeId)->get();
        return view('gestion des articles.annonces', compact('articles', 'themeId'));
    }

    public function show($themeId, $articleId)
    {
        $article = Article::with('user')->where('id', $articleId)->where('theme_id', $themeId)->firstOrFail();
        $comments = Chat::where('article_id', $articleId)->whereNull('parent_id')->with(['replies', 'replies.user', 'replies.parent', 'user'])->get();
        $userRating = Rating::where('article_id', $articleId)->where('user_id', auth()->id())->first();

        return view('gestion des articles.article', compact('article', 'themeId', 'comments', 'userRating'));
    }

    public function showArticlesByIssue($issue_id)
    {
        $articles = Article::with('user')->where('issue_id', $issue_id)->get();
        return view('gestion des articles.numbers', compact('articles', 'issue_id'));
    }

    public function storeComment(Request $request, $themeId, $articleId)
    {
        try {
            $request->validate([
                'content' => 'required',
                'parent_id' => 'nullable|exists:chats,id',
            ]);

            Chat::create([
                'article_id' => $articleId,
                'user_id' => auth()->id(),
                'content' => $request->input('content'),
                'parent_id' => $request->input('parent_id'), // Store parent_id if provided
            ]);

            return response()->json(['success' => 'Comment added successfully.']);
        } catch (\Exception $e) {
            Log::error('Error storing comment: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while adding the comment. Please try again later.'], 500);
        }
    }
    
    public function storeRating(Request $request, $articleId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rating::updateOrCreate(
            ['article_id' => $articleId, 'user_id' => auth()->id()],
            ['rating' => $request->input('rating')]
        );

        return response()->json(['success' => 'Rating submitted successfully.', 'rating' => $rating]);
    }
}
