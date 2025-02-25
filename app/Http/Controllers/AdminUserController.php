<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
   // Function to get all users
   public function index()
   {
       $users = User::all();
       
       return view('admin.manage-users', compact('users'));
   }

    

    public function update(Request $request, $id)
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
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}