<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
      $request->session()->regenerate();
      return redirect()->intended(route('account'));
    }

    return back()
      ->onlyInput('email')
      ->withErrors(['email' => 'Ces identifiants ne correspondent à aucun compte.']);
  }

  public function register(Request $request)
  {
    $validated = $request->validate([
      'email' => 'required|email|unique:users,email',
      'password' => 'required|confirmed|min:8',
    ]);

    $user = User::create([
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
    ]);

    Auth::login($user);

    return redirect()->route('account');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home')->with('success', 'Vous avez été déconnecté avec succès.');
  }
}