<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminCreateArticleController extends Controller
{
    public function create()
    {
        $themes = Theme::all();
        return view('admin.publication', compact('themes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'theme' => 'required|exists:themes,id',
            'status' => 'required|in:Published,Pending',
            'cover_image' => 'required|image|max:2048',
            'content' => 'required|string'
        ]);

        try {
            $article = new Article();
            $article->title = $request->title;
            $article->theme_id = $request->theme;
            $article->user_id = Auth::id();
            $article->status = $request->status;
            $article->content = $request->content;

            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $filePath = public_path('storage/covers');
                if (!File::exists($filePath)) {
                    File::makeDirectory($filePath, 0755, true);
                }
                $file->move($filePath, $fileName);
                $article->imagepath = 'storage/covers/' . $fileName;
            }

            $article->published_date = now();
            $article->save();

            return response()->json(['success' => true, 'message' => 'Article created successfully!']);
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while creating the article.']);
        }
    }
}