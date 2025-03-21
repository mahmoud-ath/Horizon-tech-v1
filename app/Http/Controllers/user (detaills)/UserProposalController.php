<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class UserProposalController extends Controller
{
    /**
     * Afficher le formulaire de proposition d'article.
     */
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

}
