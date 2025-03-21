<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class ModeratorProposalController extends Controller
{
    public function indexpropose()
    {
        $user = Auth::user();

        // Fetch pending articles associated with the themes of the current user
        $proposals = Article::where('status', 'pending')
            ->whereHas('theme', function($query) use ($user) {
                $query->whereIn('themes.id', $user->themes->pluck('id'));
            })
            ->with('theme')
            ->get();

        return view('responsable.moderatorsubpro', compact('proposals'));
    }

    public function destroypropose($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('moderator.proposals.index')->with('success', 'Proposal deleted successfully.');
    }

    public function proposeEdit($id)
    {
        $article = Article::findOrFail($id);
        $article->status = 'published'; // Correctly quoted status value
        $article->save();

        return redirect()->route('moderator.proposals.index')->with('success', 'Proposal published successfully.');
    }
}
