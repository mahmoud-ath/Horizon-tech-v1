<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\History;
use App\Models\Article;

class LogArticleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $articleId = $request->route('articleId'); // Assuming the article ID is passed as a route parameter

            History::create([
                'user_id' => $user->id,
                'article_id' => $articleId,
                'accessed_at' => now(),
            ]);
        }

        return $next($request);
    }
}
