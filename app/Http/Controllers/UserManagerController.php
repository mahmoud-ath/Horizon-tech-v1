<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Issues;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;
use App\Models\History;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserManagerController extends Controller
{
    // User Dashboard controller
    public function index()
    {
        $user = Auth::user();

        // Fetch recommended articles based on user subscriptions (assuming user's subscriptions are related to themes)
        $recommendedArticles = Article::whereHas('theme', function($query) use ($user) {
            $query->whereIn('themes.id', $user->subscriptions->pluck('theme_id'));
        })
        ->where('status', 'published')
        ->orderBy('updated_at', 'desc')
        ->with('theme')
        ->get();

        // Fetch all magazine issues
        $magazineIssues = Issues::all();

        return view('user.dashboarduser', compact('recommendedArticles', 'magazineIssues'));
    }

    // User Subscription controller

    public function indexsub()
    {
        // Fetch all themes and the user's subscription status
        $themes = Theme::all()->map(function ($theme) {
            $theme->status = $theme->subscriptions()->where('user_id', Auth::id())->exists();
            return $theme;
        });

        return view('user.subscriptions', compact('themes'));
    }

    public function toggleSubscription(Request $request)
    {
        $themeId = $request->input('theme');
        $userId = Auth::id();

        $theme = Theme::findOrFail($themeId);

        if ($theme->subscriptions()->where('user_id', $userId)->exists()) {
            // If already subscribed, unsubscribe
            $theme->subscriptions()->where('user_id', $userId)->delete();
        } else {
            // If not subscribed, subscribe
            $theme->subscriptions()->create(['user_id' => $userId]);
        }

        return response()->json(['success' => true]);
    }

    // User Browsing History controller

    public function indexhistory(Request $request)
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


    // User Profile controller
    public function updatedata(Request $request)
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
                if (!empty($user->user_image) && Storage::disk('public')->exists('user-image/' . $user->user_image)) {
                    Storage::disk('public')->delete('user-image/' . $user->user_image);
                }

                // Sauvegarder la nouvelle image
                $imagePath = $request->file('user_image')->store('user-image', 'public');
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
        return view('user.settings'); // Ensure you have a `settings.blade.php` view file
    }

 // user propose article controller 
 
     // Afficher le formulaire de proposition d'article.
     
    public function create()
    {
        $themes = Theme::all();
        return view('user.propose-article', compact('themes'));
    }
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'title' => 'required|string|max:255',
            'theme' => 'required|exists:themes,id',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
            'content' => 'required|string',
            'status' => 'pending', 
        ]);

        try {
            // Déplacer l'image dans public/images
            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName(); // Générer un nom unique
            $file->move(public_path('images'), $filename); // Déplacer l'image
            $coverPath = 'images/' . $filename; // Chemin pour la base de données

            // Création de l'article
            Article::create([
                'title' => $request->title,
                'theme_id' => $request->theme,
                'imagepath' => $coverPath,
                'content' => $request->content,
                'user_id' => Auth::id(),
            ]);

            // Redirection avec message de succès
            return redirect()->back()->with('success', 'Votre article a été soumis avec succès !');

        } catch (\Exception $e) {
            // En cas d'erreur, rediriger avec message d'erreur
            return redirect()->back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    // User Article controller

    public function myArticles()
    {
        $articles = Article::where('user_id', Auth::id())->get(); // Get only the logged-in user's articles
        return view('user.myarticle', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        $themeId = $article->theme_id; // Assuming that the article has a theme_id field
        return redirect()->route('article.show', ['themeId' => $themeId, 'articleId' => $id]);
    }

    public function update(Request $request, $id)
{
    $article = Article::findOrFail($id);
    $article->title = $request->input('title');
    $article->content = $request->input('content');

    $article->save();

    return redirect()->route('user.myarticles')->with('success', 'Article updated successfully');
}
}
