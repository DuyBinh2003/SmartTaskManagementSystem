<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // show list of users
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        // show a single user
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function create()
    {
        // show form to create a new user
        return view('users.create');
    }

    public function store(Request $request)
    {
        // validate and store a new user
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        return redirect()->route('users.show', $user);
    }
}
