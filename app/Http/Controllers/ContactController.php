<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('accueil.contact_us');
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string',
        ]);

        Message::create($request->all());

        return redirect()->back()->with('success', 'Your message has been sent successfully.');
    }

    public function showMessages()
    {
        $messages = Message::all();
        return view('admin.messages', compact('messages'));
    }
}
