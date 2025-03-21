<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Models\Theme;
use App\Models\Issues;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Admin dashboard view
    public function dashboard()
    {
        $totalSubscribers = User::count();

        $totalThemes = Theme::count();
        $publicThemes = Theme::where('status', 'Public')->count();
        $privatethemes = Theme::where('status', 'Private')->count();

        $totalNumbers = Issues::count();
        $publishedNumbers = Issues::where('status', 'public')->count();
        $privateNumbers = Issues::where('status', 'private')->count();

        $totalArticles = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $pendingArticles = Article::where('status', 'pending')->count();

        $articles = Article::with('theme')->get();
        $users = User::all();
        $themes = Theme::withCount('articles')->get();
        $issues = Issues::all();

        return view('admin.adminhome', compact(
            'articles',
            'users',
            'themes',
            'totalSubscribers',
            'totalThemes',
            'publicThemes',
            'privatethemes',
            'totalNumbers',
            'publishedNumbers',
            'privateNumbers',
            'totalArticles',
            'publishedArticles',
            'pendingArticles',
            'issues'
        ));
    }

    // Admin article management view

    public function article()
    {
        try {
            $articles = Article::with('theme')->get();
            $themes = Theme::all();
            $issues = Issues::all(); // Fetch all issues

            return view('admin.manage-articles', compact('articles', 'themes', 'issues'));
        } catch (\Exception $e) {
            Log::error('Error fetching articles and themes: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching articles and themes.');
        }
    }

    public function switchStatus($id)
    {
        $article = Article::find($id);
        if ($article) {
            $article->status = ($article->status === 'published') ? 'pending' : 'published';
            $article->save();
        }
        return redirect()->back()->with('success', 'Article status switched successfully.');
    }

    public function remove($id)
    {
        $article = Article::find($id);
        if ($article) {
            // Delete related records in the history table
            DB::table('history')->where('article_id', $id)->delete();

            // Now delete the article
            $article->delete();
        }
        return redirect()->back()->with('success', 'Article removed successfully.');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        $themeId = $article->theme_id; // Assuming that the article has a theme_id field
        return redirect()->route('article.show', ['themeId' => $themeId, 'articleId' => $id]);
    }

    public function assignIssue(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'issue_id' => 'required|exists:issues,id',
        ]);

        $article = Article::find($request->article_id);
        $issue = Issues::find($request->issue_id);

        // Assuming you have a relationship set up between Article and Issue
        $article->issue()->associate($issue);
        $article->save();

        return redirect()->back()->with('success', 'Article assigned to issue successfully.');
    }
    //create article controller 
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

    //user controler
    // Function to get all users
    public function indexuser()
    {
        $users = User::all();

        return view('admin.manage-users', compact('users'));
    }



    public function updateuser(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function switchRole($id)
    {
        $user = User::find($id);
        if ($user) {
            switch ($user->usertype) {
                case 'admin':
                    $user->usertype = 'moderator';
                    break;
                case 'moderator':
                    $user->usertype = 'user';
                    break;
                default:
                    $user->usertype = 'admin';
                    break;
            }
            $user->save();
        }
        return redirect()->route('admin.users.index')->with('success', 'User role switched successfully.');
    }

    // Function to delete a user
    public function destroyuser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    //theme controller

    public function indextheme()
    {
        $themes = Theme::withCount('articles')->with('user')->get();
        $moderators = User::whereIn('usertype', ['moderator', 'admin'])->get();
        return view('admin.manage-responsible-themes', compact('themes', 'moderators'));
    }

    public function storetheme(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'imagepath' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'user_id' => 'nullable|exists:users,id',
        'status' => 'required|string|in:Public,Private',
        'updated_at' => 'nullable|date',
        'created_at' => 'nullable|date',
    ]);

   // Gérer l'upload de l'image
if ($request->hasFile('imagepath')) {
    // Create directory if it doesn't exist
    if (!file_exists(public_path('admin_themes'))) {
        mkdir(public_path('admin_themes'), 0777, true);
    }

    // Check if old image exists and delete it
    if (!empty($validatedData['imagepath'])) {
        $oldImagePath = public_path('admin_themes/' . $validatedData['imagepath']);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    }

    $file = $request->file('imagepath');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('admin_themes'), $fileName);

    // Save the relative path in the database
    $validatedData['imagepath'] = $fileName;
}


    $theme = Theme::create($validatedData);

    return redirect()->back()->with('success', 'Theme created successfully');
}

    public function updateResponsible(Request $request, $id)
    {
        $theme = Theme::findOrFail($id);
        $theme->user_id = $request->new_responsible;
        $theme->save();

        return redirect()->back()->with('success', 'Responsible user updated successfully');
    }

    public function toggleStatustheme($id)
    {
        $theme = Theme::findOrFail($id);
        $theme->status = $theme->status === 'Public' ? 'Private' : 'Public';
        $theme->save();

        return redirect()->back()->with('success', 'Theme status toggled successfully');
    }

    public function destroytheme($id)
    {
        $theme = Theme::findOrFail($id);
        $theme->delete();

        return redirect()->back()->with('success', 'Theme deleted successfully');
    }

    // numbers controller

    public function indexnumber()
    {
        $issues = Issues::all();
        return view('admin.manage-numbers', compact('issues'));
    }

    public function storenumber(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
            'publication_date' => 'required|date',
            'imagepath' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('imagepath')) {
            // Create directory if it doesn't exist
            if (!file_exists(public_path('admin_numbers'))) {
                mkdir(public_path('admin_numbers'), 0777, true);
            }

            // Check if old image exists and delete it
            if (!empty($validatedData['imagepath'])) {
                $oldImagePath = public_path('admin_numbers/' . $validatedData['imagepath']);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('imagepath');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin_numbers'), $fileName);

            // Save the filename in the database
            $validatedData['imagepath'] = $fileName;
        }

        $issue = Issues::create($validatedData);

        return redirect()->route('admin.issues.index');
    }

    public function updateStatusnumber(Request $request, $id)
    {
        $issue = Issues::findOrFail($id);
        $issue->status = $request->status;
        $issue->save();

        return redirect()->route('admin.issues.index');
    }

    public function destroynumber($id)
    {
        $issue = Issues::findOrFail($id);
        $issue->delete();

        return redirect()->route('admin.issues.index');
    }
}
