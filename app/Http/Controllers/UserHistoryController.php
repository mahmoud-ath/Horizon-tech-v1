<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class UserHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $themeId = $request->query('theme');
        $dateFilter = $request->query('date');

        // Fetch all themes for the filter dropdown
        $themes = Theme::all();

        // Fetch the browsing history for the logged-in user with filters
        $historyQuery = History::where('user_id', $user->id)->with(['article.theme']);

        if (!empty($themeId)) {
            $historyQuery->whereHas('article', function($query) use ($themeId) {
                $query->where('theme_id', $themeId);
            });
        }

        if (!empty($dateFilter)) {
            switch ($dateFilter) {
                case 'today':
                    $historyQuery->whereDate('accessed_at', now()->toDateString());
                    break;
                case 'yesterday':
                    $historyQuery->whereDate('accessed_at', now()->subDay()->toDateString());
                    break;
                case 'last-week':
                    $historyQuery->whereBetween('accessed_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                    break;
                case 'last-month':
                    $historyQuery->whereBetween('accessed_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
                    break;
            }
        }

        $history = $historyQuery->orderBy('accessed_at', 'desc')->get();

        return view('user.browsing-history', compact('history', 'themes'));
    }
}
