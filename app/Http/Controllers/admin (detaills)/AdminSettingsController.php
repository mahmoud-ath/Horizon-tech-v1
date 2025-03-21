<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

    
    class AdminSettingsController extends Controller
    {
        public function settings()
        {
            // Your logic to retrieve and display user settings
            return view('admin.settings'); // Ensure you have a `settings.blade.php` view file
        }
        public function updateprofile(Request $request)
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

        // Gérer l'upload de l'image de profil avec 'move'
        if ($request->hasFile('user_image')) {
            // Vérifier si l'utilisateur a une ancienne image et la supprimer
            if (!empty($user->user_image) && Storage::disk('public')->exists('admin-image/' . $user->user_image)) {
                Storage::disk('public')->delete('admin-image/' . $user->user_image);
            }

            // Déplacer la nouvelle image dans le dossier public/admin-image
            $file = $request->file('user_image');
            $filename = time() . '_' . $file->getClientOriginalName(); // Nom unique pour l'image
            $file->move(public_path('admin-image'), $filename); // Déplacer l'image
            $user->user_image = $filename; // Enregistrer le nom de l'image
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

    }
    
    

