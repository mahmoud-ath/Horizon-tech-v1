<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminThemeController extends Controller
{
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
}
