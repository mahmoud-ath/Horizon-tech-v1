<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Add this line to import the Hash facade
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Exception;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Process the login request
    public function login(Request $request)
    {
        try {
            // Validate the incoming request data
            $credentials = $request->only('email', 'password');

            // Debugging line to print the credentials
            Log::info('Credentials received:', $credentials);

            // Retrieve the user by email for debugging
            $user = User::where('email', $credentials['email'])->first();
            if ($user) {
                Log::info('User found in database:', ['email' => $user->email, 'hashed_password' => $user->password]);

                // Compare hashed passwords for debugging
                if (Hash::check($credentials['password'], $user->password)) {
                    Log::info('Password matches for user:', ['email' => $user->email]);
                } else {
                    Log::warning('Password does not match for user:', ['email' => $user->email]);
                }
            } else {
                Log::warning('User not found in database:', ['email' => $credentials['email']]);
                return redirect('login')->withErrors(['email' => 'User not found.']);
            }

            // Attempt to authenticate the user
            if (Auth::attempt($credentials)) {
                // Authentication successful, redirect to intended page or dashboard
                Log::info('Authentication successful for user:', ['email' => $credentials['email']]);
                return redirect()->intended('dashboard');
            }

            // Authentication failed, redirect back to login form with error message
            Log::warning('Authentication failed for user:', ['email' => $credentials['email']]);
            return redirect('login')->withErrors(['email' => 'These credentials do not match our records.']);
        } catch (Exception $e) {
            // Log the error and redirect back with a generic error message
            Log::error('Login error:', ['message' => $e->getMessage()]);
            return redirect('login')->withErrors(['error' => 'An error occurred during login. Please try again later.']);
        }
    }

    // Log out the user
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            return redirect('/');
        } catch (Exception $e) {
            // Log the error and redirect back with a generic error message
            Log::error('Logout error:', ['message' => $e->getMessage()]);
            return redirect('/')->withErrors(['error' => 'An error occurred during logout. Please try again later.']);
        }
    }
}
