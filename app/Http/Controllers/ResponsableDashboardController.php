<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Theme;
use App\Models\Issues;
use App\Models\Subscription;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResponsableDashboardController extends Controller
{
    public function showDashboard()
    {
        $articlesCount = Article::count();
        $subscriberCount = Subscription::count();
        $conversationsCount = Chat::count();

        $articles = Article::all();
        $subscribers = User::all();
        $proposals = Article::with('user')
            ->where('status', 'pending')
            ->get();
        $conversations = Chat::all();
        $user = Auth::user();

        return view('responsable.responsable', compact(
            'articlesCount',
            'subscriberCount',
            'conversationsCount',
            'articles',
            'subscribers',
            'proposals',
            'conversations',
            'user'
        ));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_img' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_img')) {
            $path = $request->file('profile_img')->store('profile_images', 'public');
            $user->profile_img = $path;
        }

        $user->save();

        return redirect()->route('responsable.profile')->with('success', 'Profile updated successfully');
    }
}
