<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserSettingsController extends Controller
{
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
}
