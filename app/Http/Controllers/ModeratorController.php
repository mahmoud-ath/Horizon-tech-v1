<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Subscription;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ModeratorController extends Controller
{
    public function dashboard()
    {


        // Get the current logged-in user's ID
        $currentUserId = Auth::id();

        // Count the number of articles for themes associated with the current user
        $articlesCount = Article::join('themes', 'articles.theme_id', '=', 'themes.id')
            ->where('themes.user_id', $currentUserId)
            ->count();




        // Count the number of subscriptions for themes associated with the current user
        $subscriberCount = Subscription::join('themes', 'subscriptions.theme_id', '=', 'themes.id')
            ->where('themes.user_id', $currentUserId)
            ->count();


        // Count the number of conversations for articles related to the theme associated with the current user
        $conversationsCount = Chat::join('articles', 'chats.article_id', '=', 'articles.id')
            ->join('themes', 'articles.theme_id', '=', 'themes.id')
            ->where('themes.user_id', $currentUserId)
            ->count();

        return view('responsable.moderatordashboard', compact('articlesCount', 'subscriberCount', 'conversationsCount'));
    }

    //article 
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


    //subscription controller

    /**
     * Display a listing of the subscribers.
     *
     * @return \Illuminate\View\View
     */
    public function indexsub()
    {
        $subscribers = Subscription::whereHas('theme', function ($query) {
            $query->where('user_id', Auth::id()); // Themes created by the logged-in user
        })->with('user')->get();

        return view('responsable.moderatorsubscribers', compact('subscribers'));
    }

    /**
     * Remove the specified subscription.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroysub($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('moderator.subscribers.index')
            ->with('success', 'Subscription deleted successfully');
    }

    /**
     * Show the subscription details.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showsub($id)
    {
        $subscription = Subscription::findOrFail($id);
        return view('responsable.moderatorsubscription', compact('subscription'));
    }
    //managing conversations controller 
    public function indexchat()
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

    public function destroychat($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->delete();
        return redirect()->route('moderator.conversations.index')->with('success', 'Conversation deleted successfully');
    }

    //managing proposing article controller
    public function indexpropose()
    {
        $user = Auth::user();

        // Fetch pending articles associated with the themes of the current user
        $proposals = Article::where('status', 'pending')
            ->whereHas('theme', function ($query) use ($user) {
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

    //settings controller
    public function update(Request $request)
    {
        try {
            // Vérifier si l'utilisateur est authentifié
            $user = Auth::user();

            if (!$user) {
                return back()->with('error', 'Utilisateur non trouvé. Veuillez vous reconnecter.');
            }

            // Validation des données
            $request->validate([
                'username' => 'required|string|max:255',
                'password' => 'nullable|min:6',
                'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Mettre à jour le nom d'utilisateur
            $user->name = $request->username;

            // Mettre à jour le mot de passe (si fourni)
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Gérer l'upload de l'image de profil
            if ($request->hasFile('user_image')) {
                // Vérifier si l'utilisateur a une ancienne image et la supprimer
                if (!empty($user->user_image) && Storage::disk('public')->exists('respo-image/' . $user->user_image)) {
                    Storage::disk('public')->delete('respo-image/' . $user->user_image);
                }

                // Sauvegarder la nouvelle image
                $imagePath = $request->file('user_image')->store('respo-image', 'public');
                $user->user_image = basename($imagePath);
            }


            // Enregistrer les modifications
            $user->save();

            return back()->with('success', 'Paramètres mis à jour avec succès !');
        } catch (\Exception $e) {
            // Enregistrer l'erreur dans les logs
            Log::error('Erreur lors de la mise à jour des paramètres utilisateur : ' . $e->getMessage());

            // Retourner un message d'erreur à l'utilisateur
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour. Veuillez réessayer plus tard.');
        }
    }

    public function settings()
    {
        // Your logic to retrieve and display user settings
        return view('responsable.moderatorsettings'); // Ensure you have a settings.blade.php view file
    }
}
