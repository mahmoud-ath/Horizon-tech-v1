<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issues;
use Illuminate\Support\Facades\Storage;

class AdminIssueController extends Controller
{
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
