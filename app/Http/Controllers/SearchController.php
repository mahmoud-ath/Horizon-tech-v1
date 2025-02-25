<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $query = $request->input('query');

        // Perform the search using your model
        $suggestions = Article::where('title', 'LIKE', "%{$query}%")
                              ->orWhere('content', 'LIKE', "%{$query}%")
                              ->limit(5)
                              ->get(['id', 'title', 'theme_id']);

        return response()->json($suggestions);
    }
}
