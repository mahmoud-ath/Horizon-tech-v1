<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class ModeratorSubscribersController extends Controller
{
    /**
     * Display a listing of the subscribers.
     *
     * @return \Illuminate\View\View
     */
    public function indexsub()
    {
        $subscribers = Subscription::whereHas('theme', function ($query) {
            $query->where('user_id', Auth::id()); // Themes created by the logged-in user
        })->with('user')->get();

        return view('responsable.moderatorsubscribers', compact('subscribers'));
    }

    /**
     * Remove the specified subscription.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroysub($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('moderator.subscribers.index')
            ->with('success', 'Subscription deleted successfully');
    }

    /**
     * Show the subscription details.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showsub($id)
    {
        $subscription = Subscription::findOrFail($id);
        return view('responsable.moderatorsubscription', compact('subscription'));
    }
}
