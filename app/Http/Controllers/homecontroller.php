<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $usertype = $user->usertype;

            if ($usertype == 'user') {
                return redirect()->route('user.dashboarduser'); // Ensure this view exists
            } elseif ($usertype == 'moderator') {
                return redirect()->route('moderatorhome'); // Ensure this view exists
            } elseif ($usertype == 'admin') {
                return redirect()->route('admin.adminhome'); // Redirect to the adminhome route
            }
        }

        return redirect('/'); // Redirect to the home page if not authenticated
    }
}
