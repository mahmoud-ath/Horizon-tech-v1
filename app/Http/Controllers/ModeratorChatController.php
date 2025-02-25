<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Article;
use App\Models\Theme;
use App\Models\Issues;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;


class ModeratorChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
// Get the current logged-in user's ID
$currentUserId = Auth::id();

// Retrieve the conversations for articles related to the theme associated with the current user
$chats = Chat::join('articles', 'chats.article_id', '=', 'articles.id')
    ->join('themes', 'articles.theme_id', '=', 'themes.id')
    ->where('themes.user_id', $currentUserId)
    ->select('chats.*')
    ->get();

        return view('responsable.moderatorconversations', compact('chats'));
    }

    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->delete();
        return redirect()->route('moderator.conversations.index')->with('success', 'Conversation deleted successfully');
    }
}
